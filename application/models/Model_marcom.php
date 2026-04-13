<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_marcom extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function generate_id_campaign()
    {
        // Cari ID yang formatnya CMP + Tanggal Hari Ini
        $prefix = 'CMP' . date('ymd');

        $this->db->select("MAX(RIGHT(id, 3)) AS kd_max");
        $this->db->from('t_campaign_marcom');
        $this->db->where("id LIKE '$prefix%'");

        $q = $this->db->get();

        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                // Konversi ke int agar bisa ditambah 1
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }

        return $prefix . $kd; // Contoh: CMP251209001
    }

    public function get_akun()
    {

        $query = $this->db->select('*')
            ->from('m_akun_marcom')
            ->get();
        return $query->result();
    }

    public function get_all_campaigns($filters = [])
    {

        // 1. Filter Tanggal (Created At)
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $this->db->where('DATE(created_at) >=', $filters['start_date']);
            $this->db->where('DATE(created_at) <=', $filters['end_date']);
        }

        // 2. Filter Keyword (Search)
        if (!empty($filters['keyword'])) {
            $this->db->group_start();
            $this->db->like('campaign_name', $filters['keyword']);
            $this->db->or_like('goals', $filters['keyword']);
            $this->db->or_like('id', $filters['keyword']);
            $this->db->group_end();
        }

        // Default Order
        $this->db->order_by('created_at', 'DESC');

        $campaigns = $this->db->get('t_campaign_marcom')->result();

        // ... (Logic foreach PIC di bawahnya TETAP SAMA seperti sebelumnya) ...
        foreach ($campaigns as &$c) {
            $pic_ids = array_filter(explode(',', (string)$c->pic));
            $pic_list = [];
            if (!empty($pic_ids)) {
                $this->db->select("
                e.user_id,
                CONCAT(e.first_name, ' ', e.last_name) AS full_name,
                CASE
                    WHEN e.profile_picture IS NULL OR e.profile_picture = '' THEN
                        CASE WHEN e.gender = 'Female' 
                            THEN 'https://trusmiverse.com/hr/uploads/profile/default_female.jpg'
                            ELSE 'https://trusmiverse.com/hr/uploads/profile/default_male.jpg'
                        END
                    ELSE CONCAT('https://trusmiverse.com/hr/uploads/profile/', e.profile_picture)
                END AS profile_picture
            ");
                $this->db->from('xin_employees e');
                $this->db->where_in('e.user_id', $pic_ids);
                $pic_list = $this->db->get()->result();
            }
            $c->pics = $pic_list;
        }

        return $campaigns;
    }


    public function update_progress($id, $status, $status_progres)
    {
        // 1. Update Table Utama (t_campaign_marcom)
        // Ini update status visual (tab mana yang aktif dan kolom mana yang aktif)
        $data = [
            "status" => $status,                // Menandakan Tab Aktif (1, 2, 3...)
            "status_progres" => $status_progres, // Menandakan Kolom Kanban (1=Pending, 2=In Progress, dst)
            "updated_at" => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $id);
        $update_main = $this->db->update('t_campaign_marcom', $data);

        $this->db->insert('marcom_h_status', [
            'id_campaign' => $id,
            'tab'         => $status,
            'status_lama' => $status_progres,
            'status_baru' => $status_progres + 1,
            'created_by'  => $this->session->userdata('user_id'),
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        // 2. Tentukan Table Satelit berdasarkan Tab ($status)
        $table_satelit = '';

        switch ($status) {
            case 1: // Tab Riset SPV
                $table_satelit = 't_riset_spv_marcom';
                break;
            case 2: // Tab Content Script
                $table_satelit = 't_script_marcom';
                break;
            case 3: // Tab Riset KOL (Opsional: sesuaikan jika tabelnya ada)
                $table_satelit = 't_riset_kol_marcom'; // atau t_riset_kol_marcom
                break;
            case 4: // Tab Budgeting (Opsional)
                $table_satelit = 't_budgeting_marcom';
                break;
            case 5:
                $table_satelit = 't_shooting_marcom';
                break;
            case 6:
                $table_satelit = 't_editing_marcom';
                break;
        }

        // 3. Update Status di Table Satelit (jika table didefinisikan)
        if (!empty($table_satelit)) {
            $data_sub = [
                'status'     => $status_progres,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Opsional: Jika ingin mencatat siapa yang update (jika library session dimuat)
            if (isset($this->session) && $this->session->userdata('user_id')) {
                $data_sub['updated_by'] = $this->session->userdata('user_id');
            }

            // Update berdasarkan campaign_id
            $this->db->where('campaign_id', $id);
            $this->db->update($table_satelit, $data_sub);
        }

        return $update_main;
    }

    public function get_campaigns_by_user($user_id, $filters = [], $status = null)
    {
        // 1. SELECT DATA & JOIN
        $this->db->select('
        c.*,
        c.pic as pic_riset,
        s.pic as pic_script,
        k.pic as pic_kol,
        b.pic as pic_budget,
        st.pic as pic_shooting,
        ed.pic as pic_editing,
        com.name as company_name
    ');
        $this->db->from('t_campaign_marcom c');
        $this->db->join('t_riset_spv_marcom r', 'r.campaign_id = c.id', 'left');
        $this->db->join('t_script_marcom s', 's.campaign_id = c.id', 'left');
        $this->db->join('t_riset_kol_marcom k', 'k.campaign_id = c.id', 'left');
        $this->db->join('t_budgeting_marcom b', 'b.campaign_id = c.id', 'left');
        $this->db->join('t_shooting_marcom st', 'st.campaign_id = c.id', 'left');
        $this->db->join('t_editing_marcom ed', 'ed.campaign_id = c.id', 'left');
        $this->db->join('xin_companies com', 'c.company_id = com.company_id', 'left');

        // --- 2. FILTER PERMISSIONS (LOGIC BARU - STRICT PER PHASE) ---
        $superusers = [1, 638, 541, 118, 323, 7804, 9633, 803, 5286];
        $superusersAllCompany = [1, 118, 323, 803, 5286];
        $company_id = $this->session->userdata('company_id');

        if (!in_array((int)$user_id, $superusers)) {
            $this->db->group_start();

            if (!empty($status)) {
                // LOGIC BARU: Hanya cek PIC di fase yang sedang aktif
                switch ($status) {
                    case 1: // Tab Riset
                        // Status 1-4: Fase Riset
                        $this->db->where("FIND_IN_SET(" . (int)$user_id . ", c.pic) >", 0, FALSE);
                        $this->db->where('c.status_progres <=', 4);
                        break;

                    case 2: // Tab Script
                        // Status 5-8: Fase Script
                        $this->db->where("FIND_IN_SET(" . (int)$user_id . ", s.pic) >", 0, FALSE);
                        $this->db->where('c.status_progres >=', 5);
                        $this->db->where('c.status_progres <=', 8);
                        break;

                    case 3: // Tab KOL
                        // Status 9-12: Fase KOL
                        $this->db->where("FIND_IN_SET(" . (int)$user_id . ", k.pic) >", 0, FALSE);
                        $this->db->where('c.status_progres >=', 9);
                        $this->db->where('c.status_progres <=', 12);
                        break;

                    case 4: // Tab Budgeting
                        // Status 13-16: Fase Budgeting
                        $this->db->where("FIND_IN_SET(" . (int)$user_id . ", b.pic) >", 0, FALSE);
                        $this->db->where('c.status_progres >=', 13);
                        $this->db->where('c.status_progres <=', 16);
                        break;

                    case 5: // Tab Shooting
                        // Status 17-20: Fase Shooting
                        $this->db->where("FIND_IN_SET(" . (int)$user_id . ", st.pic) >", 0, FALSE);
                        $this->db->where('c.status_progres >=', 17);
                        $this->db->where('c.status_progres <=', 20);
                        break;

                    case 6: // Tab Editing
                        // Status 21-24: Fase Editing
                        $this->db->where("FIND_IN_SET(" . (int)$user_id . ", ed.pic) >", 0, FALSE);
                        $this->db->where('c.status_progres >=', 21);
                        break;
                }
            } else {
                // Dashboard/View All: Tampilkan hanya task di fase aktif user saat ini
                $this->db->group_start();

                // Riset (1-4)
                $this->db->group_start();
                $this->db->where("FIND_IN_SET(" . (int)$user_id . ", c.pic) >", 0, FALSE);
                $this->db->where('c.status_progres <=', 4);
                $this->db->group_end();

                // Script (5-8)
                $this->db->or_group_start();
                $this->db->where("FIND_IN_SET(" . (int)$user_id . ", s.pic) >", 0, FALSE);
                $this->db->where('c.status_progres >=', 5);
                $this->db->where('c.status_progres <=', 8);
                $this->db->group_end();

                // KOL (9-12)
                $this->db->or_group_start();
                $this->db->where("FIND_IN_SET(" . (int)$user_id . ", k.pic) >", 0, FALSE);
                $this->db->where('c.status_progres >=', 9);
                $this->db->where('c.status_progres <=', 12);
                $this->db->group_end();

                // Budgeting (13-16)
                $this->db->or_group_start();
                $this->db->where("FIND_IN_SET(" . (int)$user_id . ", b.pic) >", 0, FALSE);
                $this->db->where('c.status_progres >=', 13);
                $this->db->where('c.status_progres <=', 16);
                $this->db->group_end();

                // Shooting (17-20)
                $this->db->or_group_start();
                $this->db->where("FIND_IN_SET(" . (int)$user_id . ", st.pic) >", 0, FALSE);
                $this->db->where('c.status_progres >=', 17);
                $this->db->where('c.status_progres <=', 20);
                $this->db->group_end();

                // Editing (21-24)
                $this->db->or_group_start();
                $this->db->where("FIND_IN_SET(" . (int)$user_id . ", ed.pic) >", 0, FALSE);
                $this->db->where('c.status_progres >=', 21);
                $this->db->group_end();

                $this->db->group_end();
            }

            $this->db->group_end();
        }

        // Filter Status Campaign (Tab Aktif)
        if (!empty($status)) {
            $this->db->where('c.status >=', $status);
        }

        // --- 3. FILTER DARI UI (Search, Date, dll) ---
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            // $this->db->group_start();
            // $this->db->where_not_in('c.status_progres', [4, 8, 12, 16, 20, 24]);
            // $this->db->or_group_start();
            // $this->db->where('DATE(c.created_at) >=', $filters['start_date']);
            // $this->db->where('DATE(c.created_at) <=', $filters['end_date']);
            // $this->db->group_end();
            // $this->db->group_end();
            $this->db->where("DATE(c.created_at) BETWEEN '{$filters['start_date']}' AND '{$filters['end_date']}'");
        }

        if (!empty($filters['company_id'])) {
            $this->db->where('c.company_id', $filters['company_id']);
        }

        if (!in_array((int)$user_id, $superusersAllCompany)) {
            $this->db->where('c.company_id', $company_id);
        }

        if (!empty($filters['pic_id'])) {
            $this->db->group_start();
            $this->db->where("FIND_IN_SET(" . (int)$filters['pic_id'] . ", c.pic) >", 0, FALSE);
            $this->db->or_where("FIND_IN_SET(" . (int)$filters['pic_id'] . ", s.pic) >", 0, FALSE);
            $this->db->or_where("FIND_IN_SET(" . (int)$filters['pic_id'] . ", k.pic) >", 0, FALSE);
            $this->db->or_where("FIND_IN_SET(" . (int)$filters['pic_id'] . ", b.pic) >", 0, FALSE);
            $this->db->or_where("FIND_IN_SET(" . (int)$filters['pic_id'] . ", st.pic) >", 0, FALSE);
            $this->db->or_where("FIND_IN_SET(" . (int)$filters['pic_id'] . ", ed.pic) >", 0, FALSE);
            $this->db->group_end();
        }

        if (!empty($filters['keyword'])) {
            $this->db->group_start();
            $this->db->like('c.campaign_name', $filters['keyword']);
            $this->db->or_like('c.goals', $filters['keyword']);
            $this->db->or_like('c.id', $filters['keyword']);
            $this->db->group_end();
        }

        $this->db->order_by('c.created_at', 'DESC');
        $campaigns = $this->db->get()->result();

        // --- 4. FORMAT DATA PIC ---
        foreach ($campaigns as &$c) {
            $c->pics_main   = $this->_get_employee_details($c->pic);
            $c->pics_riset  = $this->_get_employee_details($c->pic_riset);
            $c->pics_script = $this->_get_employee_details($c->pic_script);
            $c->pics_kol    = $this->_get_employee_details($c->pic_kol);
            $c->pics_budget = $this->_get_employee_details($c->pic_budget);
            $c->pics_shooting = $this->_get_employee_details($c->pic_shooting);
            $c->pics_editing = $this->_get_employee_details($c->pic_editing);

            $docs = 0;
            if (!empty($c->reference_file)) $docs++;
            if (!empty($c->reference_file_2)) $docs++;
            if (!empty($c->reference_file_3)) $docs++;
            $c->docs_count = $docs;

            $links = 0;
            if (!empty($c->reference_link)) $links++;
            if (!empty($c->reference_link_2)) $links++;
            if (!empty($c->reference_link_3)) $links++;
            $c->links_count = $links;

            $max_steps = 24;
            $current_step = (int)$c->status_progres;

            if ($current_step > 0) {
                $progress = round(($current_step / $max_steps) * 100);
            } else {
                $progress = 0;
            }

            if ($progress > 100) $progress = 100;

            $c->progress_percent = $progress;
        }

        return $campaigns;
    }

    // --- HELPER PRIVATE UNTUK MENGAMBIL DETAIL KARYAWAN ---
    private function _get_employee_details($pic_ids_str)
    {
        if (empty($pic_ids_str)) return [];

        $pic_ids = array_filter(explode(',', (string)$pic_ids_str));
        if (empty($pic_ids)) return [];

        $this->db->select("
            e.user_id,
            CONCAT(e.first_name, ' ', e.last_name) AS full_name,
            CASE
                WHEN e.profile_picture IS NULL OR e.profile_picture = '' THEN
                    CASE WHEN e.gender = 'Female' 
                        THEN 'https://trusmiverse.com/hr/uploads/profile/default_female.jpg'
                        ELSE 'https://trusmiverse.com/hr/uploads/profile/default_male.jpg'
                    END
                ELSE CONCAT('https://trusmiverse.com/hr/uploads/profile/', e.profile_picture)
            END AS profile_picture
        ");
        $this->db->from('xin_employees e');
        $this->db->where_in('e.user_id', $pic_ids);
        return $this->db->get()->result();
    }

    public function get_campaign_by_id($id)
    {
        $query = "SELECT c.*, 
        riset_report,
        riset_link,
        riset_file,
        trend_analysis
        FROM t_campaign_marcom c
        LEFT JOIN t_riset_spv_marcom r ON c.id = r.campaign_id
        where c.id = '$id'
        ";
        return $this->db->query($query)->row();
    }

    public function get_eaf_jenis_biaya($company_id)
    {
        $query = "SELECT
                    e_jenis.id_jenis,
                    e_jenis.id_tipe_biaya,
                    e_jenis.id_budget,
                    e_jenis.jenis,
                    e_jenis.id_user_approval as id_user_approval,
                    e_jenis.id_user_verified,
                    IF(e_jenis.id_tipe_biaya = 4, e_biaya.budget_awal, COALESCE(e_biaya.budget, 'Unlimited')) AS budget_sisa,
                    ds.designation_name
                FROM
                    e_eaf.e_jenis_biaya e_jenis
                    JOIN e_eaf.e_biaya ON e_jenis.id_budget = e_biaya.id_budget
                    LEFT JOIN hris.xin_employees AS emp ON e_jenis.id_user_approval = emp.user_id
                    LEFT JOIN xin_designations ds ON ds.designation_id = emp.designation_id
                WHERE
                    e_jenis.jenis NOT LIKE 'XXX%' 
                    AND e_jenis.company_id = '$company_id'
                    AND (
                        (e_biaya.tahun_budget = DATE_FORMAT(CURDATE(), '%Y') AND e_biaya.bulan = DATE_FORMAT(CURDATE(), '%m') AND e_biaya.minggu IS NULL) 
                        OR 
                        (e_biaya.tahun_budget = DATE_FORMAT(CURDATE(), '%Y') AND e_biaya.bulan = DATE_FORMAT(CURDATE(), '%m') AND e_biaya.minggu = WEEK(CURDATE(), 1) - WEEK(DATE_FORMAT(CURDATE(), '%Y-%m-01'), 1) + 1)
                    )";
        return $this->db->query($query)->result();
    }

    public function generate_id_eaf($company_id)
    {
        // Tentukan Prefix Database
        if ($company_id == 2) {
            $db_prefix = 'rsp_project_live.';
        } else {
            $db_prefix = 'e_eaf.';
        }

        // Query ID Terakhir (Perbaiki query string agar tidak double titik)
        // Menggunakan {$db_prefix}e_pengajuan
        $query = "SELECT MAX(RIGHT(id_pengajuan, 4)) AS kd_max FROM {$db_prefix}e_pengajuan WHERE DATE(created_at) = CURDATE()";

        $q = $this->db->query($query);

        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }

        date_default_timezone_set('Asia/Jakarta');
        return 'EAF' . date('ymd') . $kd;
    }

    // --- INTEGRASI DATA MASTER EAF ---

    public function get_eaf_company()
    {
        return $this->db->query("SELECT company_id, company_name FROM e_eaf.e_company WHERE company_id IN (1, 3, 5)")->result();
    }

    public function get_eaf_pengaju()
    {
        // Query adaptasi dari Model_pengajuan->get_pengaju()
        $query = "SELECT
                    em.user_id,
                    CONCAT(em.first_name, ' ', em.last_name, '| ', ds.designation_name, '|', c.alias) AS employee_name
                FROM xin_employees AS em
                LEFT JOIN xin_departments as dp ON dp.department_id = em.department_id
                LEFT JOIN xin_designations as ds ON ds.designation_id = em.designation_id
                LEFT JOIN xin_companies as c ON c.company_id = em.company_id
                WHERE (em.company_id IN (1, 2, 3, 4, 5, 6)) AND em.is_active = 1 AND em.user_id <> 1 AND em.department_id IN (137, 169)
                ORDER BY em.first_name ASC";
        return $this->db->query($query)->result();
    }

    public function get_eaf_kategori()
    {
        // Query adaptasi dari Model_pengajuan->get_kategori()
        // Mengambil kategori umum (17, 18, 20)
        return $this->db->query("SELECT * FROM e_eaf.e_kategori WHERE id_kategori IN (17, 18, 20)")->result();
    }

    public function get_jenis_biaya_by_company($company_id, $nominal)
    {
        if ($company_id == 2) {
            $query = "SELECT
                        e_jenis_biaya.id_jenis,
                        e_jenis_biaya.id_tipe_biaya,
                        e_biaya.id_budget AS id_biaya,
                        e_jenis_biaya.jenis,
                        IF(e_jenis_biaya.id_tipe_biaya = 4, e_biaya.budget_awal, COALESCE(e_biaya.budget, 'Unlimited')) AS budget,
                        e_jenis_biaya.id_user_approval,
                        e_jenis_biaya.id_user_verified,
                        e_jenis_biaya.ba
                        FROM
                        rsp_project_live.e_jenis_biaya
                        JOIN rsp_project_live.e_biaya ON e_jenis_biaya.id_budget = e_biaya.id_budget
                        JOIN rsp_project_live.`user` ON e_jenis_biaya.id_user_approval = `user`.id_user
                        WHERE
                        e_jenis_biaya.jenis NOT LIKE 'XXX%'
                        AND (
                            (
                            e_biaya.tahun_budget = DATE_FORMAT(CURDATE(), '%Y')
                            AND e_biaya.bulan = DATE_FORMAT(CURDATE(), '%m')
                            AND e_biaya.minggu IS NULL
                            )
                            OR (
                            e_biaya.tahun_budget = DATE_FORMAT(CURDATE(), '%Y')
                            AND e_biaya.bulan = DATE_FORMAT(CURDATE(), '%m')
                            AND e_biaya.minggu = WEEK(CURDATE(), 1) - WEEK(DATE_FORMAT(CURDATE(), '%Y-%m-01'), 1) + 1
                            )
                        )
                        AND e_jenis_biaya.id_jenis != 711
                        AND e_jenis_biaya.list_dlk_department_id IS NULL";
        } else {
            $query = "SELECT
                    e_jenis.id_jenis,
                    e_jenis.id_tipe_biaya,
                    e_jenis.id_biaya,
                    e_jenis.jenis,
                    e_jenis.budget,
                    IF(
                        e_jenis.id_user_approval2 IS NULL
                        OR e_jenis.max_approve IS NULL,
                        e_jenis.id_user_approval,
                        IF(($nominal > e_jenis.nominal_app_2), e_jenis.id_user_approval2, e_jenis.id_user_approval)
                    ) AS id_user_approval,
                    e_jenis.id_user_verified,
                    e_jenis.ba
                    FROM
                    (
                        SELECT
                        e_jenis_biaya.id_jenis,
                        e_jenis_biaya.id_tipe_biaya,
                        e_biaya.id_budget AS id_biaya,
                        e_jenis_biaya.jenis,
                        e_jenis_biaya.max_approve,
                        e_jenis_biaya.nominal_app_2,
                        e_jenis_biaya.id_user_approval,
                        e_jenis_biaya.id_user_approval2,
                        IF(e_jenis_biaya.id_tipe_biaya = 4, e_biaya.budget_awal, COALESCE(e_biaya.budget, 'Unlimited')) AS budget,
                        e_jenis_biaya.id_user_verified,
                        e_jenis_biaya.ba
                        FROM
                        e_eaf.e_jenis_biaya
                        JOIN e_eaf.e_biaya ON e_jenis_biaya.id_budget = e_biaya.id_budget
                        WHERE
                        e_jenis_biaya.jenis NOT LIKE 'XXX%'
                        AND (
                            (
                            e_biaya.tahun_budget = DATE_FORMAT(CURDATE(), '%Y')
                            AND e_biaya.bulan = DATE_FORMAT(CURDATE(), '%m')
                            AND e_biaya.minggu IS NULL
                            )
                            OR (
                            e_biaya.tahun_budget = DATE_FORMAT(CURDATE(), '%Y')
                            AND e_biaya.bulan = DATE_FORMAT(CURDATE(), '%m')
                            AND e_biaya.minggu = WEEK(CURDATE(), 1) - WEEK(DATE_FORMAT(CURDATE(), '%Y-%m-01'), 1) + 1
                            )
                        )
                        AND e_jenis_biaya.company_id = '$company_id'
                    ) e_jenis";
        }

        return $this->db->query($query)->result();
    }

    function get_project()
    {
        // Hidden Project TL Kayangan (not used) dan RN Kondangsari (NA)
        return $this->db->query("SELECT id_project, project FROM rsp_project_live.m_project WHERE active = 1")->result();
    }
}
