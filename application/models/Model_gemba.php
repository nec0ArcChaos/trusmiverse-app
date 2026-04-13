<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_gemba extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_tipe()
    {
        $department_id = $_SESSION['department_id'];

        if ($_SESSION['user_id'] == 6396) {
            $department_id = 142;
        }

        if (in_array($this->session->userdata('user_id'), [1, 476])) {
            return $this->db->query("SELECT id, tipe_gemba,department_id FROM gemba_tipe")->result();
        } else {
            if ($_SESSION['user_id'] == 7731) {
                return $this->db->query("SELECT id, tipe_gemba,department_id FROM gemba_tipe WHERE department_id IN (106,142,183,72)")->result();
            } else {
                return $this->db->query("SELECT id, tipe_gemba,department_id FROM gemba_tipe WHERE FIND_IN_SET($department_id,department_id)")->result();
            }
        }
    }
    function get_employee($tipe)
    {
        $query = "SELECT
            emp.user_id,
            CONCAT(emp.first_name,' ', emp.last_name) AS nama,
            emp.department_id,
            dep.department_name,
            des.designation_name
            FROM
            xin_employees emp 
            JOIN gemba_tipe gm ON FIND_IN_SET(emp.department_id,gm.department_id)
            LEFT JOIN xin_departments dep ON dep.department_id = emp.department_id
            LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
            WHERE emp.is_active = 1
            AND gm.id = $tipe
            GROUP BY emp.user_id
            ORDER BY emp.first_name";
        return $this->db->query($query)->result();
    }

    function get_dokumen($dep_id)
    {
        $ids_array = explode(',', $dep_id);

        // 2. Pastikan setiap elemen adalah angka (integer)
        $clean_ids_array = array_map('intval', $ids_array);

        // 3. Ubah kembali menjadi string aman: '106,142,183'
        $safe_dep_id_string = implode(',', $clean_ids_array);
        $query = "SELECT
            sop.id_sop,
            sop.department,
            dep.department_name,
            sop.no_doc,
            sop.jenis_doc,
            sop.nama_dokumen,
            sop.file
            FROM
            `trusmi_sop` sop
            LEFT JOIN xin_departments dep ON dep.department_id = sop.department
            WHERE sop.department IN($safe_dep_id_string)
            AND sop.no_doc IS NOT NULL
            UNION ALL
            SELECT
            jp.id,
            jp.departement_id,
            dep.department_name,
            jp.no_dok,
            'Job Profile' AS jenis_doc,
            CONCAT('JP ', dep.department_name) AS nama_dokumen,
            '' AS file
            FROM
            trusmi_job_profile jp
            LEFT JOIN xin_departments dep ON dep.department_id = jp.departement_id
            WHERE jp.departement_id IN($safe_dep_id_string)
            AND jp.no_dok IS NOT NULL
            ";
        return $this->db->query($query)->result();
    }

    function generate_id_gemba()
    {
        $q = $this->db->query("SELECT 
                                MAX( RIGHT ( gemba.id_gemba, 3 ) ) AS kd_max 
                              FROM
                                gemba 
                              WHERE
                                DATE( gemba.created_at ) = CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }

        return 'GB' . date('ymd') . $kd;
    }

    function get_ceklis($tipe_gemba)
    {
        return $this->db->query("SELECT id FROM gemba_ceklis WHERE tipe_gemba = $tipe_gemba");
    }

    function list_proses()
    {
        $user_id = $_SESSION['user_id'];
        $role_id = $_SESSION['user_role_id'];
        $department_id = $_SESSION['department_id'];

        $list_super = [1139, 8892, 8970, 70, 3651, 2903, 4498]; // Viky, Lintang, Nining27
        // Super Admin & Tambahan
        if ($role_id == 1 || in_array($user_id, $list_super)) {
            $kondisi = "";
        } else {
            $kondisi = "AND gemba.created_by = $user_id";
        }

        return $this->db->query("SELECT
                              gemba.id_gemba,
                              gemba.tgl_plan,
                              gemba.tipe_gemba AS id_gemba_tipe,
                              tp.tipe_gemba,
                              gemba.lokasi,
                              gemba.evaluasi,
                              gemba.peserta,
                              gemba.created_at,
                              CONCAT( em.first_name, ' ', em.last_name ) AS created_by,
                              gemba.updated_at,
                              CONCAT( up.first_name, ' ', up.last_name ) AS updated_by 
                            FROM
                              gemba
                              JOIN ( SELECT id_gemba, COUNT( IF ( `status` IS NULL, 1, NULL )) AS total_progres FROM gemba_item GROUP BY id_gemba ) AS item ON item.id_gemba = gemba.id_gemba
                              JOIN gemba_tipe AS tp ON tp.id = gemba.tipe_gemba
                              LEFT JOIN xin_employees AS em ON em.user_id = gemba.created_by
                              LEFT JOIN xin_employees AS up ON up.user_id = gemba.updated_by 
                            WHERE
                              (item.total_progres > 0 OR gemba.evaluasi IS NULL) $kondisi")->result();
    }

    function list_perbaikan()
    {
        $user_id = $_SESSION['user_id'];
        $role_id = $_SESSION['user_role_id'];
        $department_id = $_SESSION['department_id'];

        // $list_super = [1139, 8892, 8970, 70, 3651, 2903, 4498]; // Viky, Lintang, Nining27
        // if ($role_id == 1 || in_array($user_id, $list_super)) {
        //     $kondisi = "";
        // } else {
        //     $kondisi = "AND item.pic = $user_id";
        // }

        $kondisi = "";

        // kalau bukan user id 1, pakai filter berdasarkan pic item
        if ($user_id != 1) {
            $kondisi = "AND item.pic = $user_id";
        }


        return $this->db->query("SELECT
    item.id_gemba_ceklis,
    item.status_verifikasi,
    gemba.id_gemba,
    gemba.tgl_plan,
    gemba.tipe_gemba AS id_gemba_tipe,
    tp.tipe_gemba,
    gemba.lokasi,
    gemba.evaluasi,
    gemba.peserta,
    gemba.created_at,
    CONCAT(em.first_name, ' ', em.last_name) AS created_by,
    gemba.updated_at,
    CONCAT(up.first_name, ' ', up.last_name) AS updated_by,
    ceklis.concern AS ceklis

FROM gemba
JOIN gemba_item AS item 
    ON item.id_gemba = gemba.id_gemba
JOIN gemba_tipe AS tp 
    ON tp.id = gemba.tipe_gemba
JOIN gemba_ceklis AS ceklis 
    ON ceklis.id = item.id_gemba_ceklis
LEFT JOIN xin_employees AS em 
    ON em.user_id = gemba.created_by
LEFT JOIN xin_employees AS up 
    ON up.user_id = gemba.updated_by

WHERE
(
    -- 🔹 KONDISI 1: Deadline awal
    (
        item.deadline IS NOT NULL
        AND item.perbaikan_at IS NULL
        AND (
            item.status_verifikasi IS NULL
            OR item.status_verifikasi != 'tidak oke'
        )
    )

    OR

    -- 🔹 KONDISI 2: Tidak oke + deadline baru
    (
        item.status_verifikasi = 'tidak oke'
        AND item.deadline_baru IS NOT NULL
        AND (
            item.perbaikan_at IS NULL
            OR item.updated_at > item.perbaikan_at
        )
    )
)

AND (
    (
        item.`status` = 'tidak'
        AND (
            item.file_perbaikan IS NULL
            OR item.link_perbaikan IS NULL
        )
    )
    OR item.status_verifikasi = 'tidak oke'
)

AND DATE(gemba.created_at) > '2026-02-01'

                                $kondisi
                                GROUP BY gemba.id_gemba
                                ")->result();
    }

    function list_deadline()
    {
        $user_id = $_SESSION['user_id'];
        $role_id = $_SESSION['user_role_id'];
        $department_id = $_SESSION['department_id'];

        // $list_super = [1139, 8892, 8970, 70, 3651, 2903, 4498]; // Viky, Lintang, Nining27
        // if ($role_id == 1 || in_array($user_id, $list_super)) {
        //     $kondisi = "";
        // } else {
        //     $kondisi = "AND item.pic = $user_id";
        // }

        $kondisi = "";

        // kalau bukan user id 1, pakai filter berdasarkan pic item
        if ($user_id != 1) {
            $kondisi = "AND item.pic = $user_id";
        }


        return $this->db->query("SELECT
  item.id_gemba_ceklis,
  item.status_verifikasi,
  gemba.id_gemba,
  gemba.tgl_plan,
  gemba.tipe_gemba AS id_gemba_tipe,
  tp.tipe_gemba,
  gemba.lokasi,
  gemba.evaluasi,
  gemba.peserta,
  gemba.created_at,
  CONCAT(em.first_name, ' ', em.last_name) AS created_by,
  gemba.updated_at,
  CONCAT(up.first_name, ' ', up.last_name) AS updated_by,
  ceklis.concern AS ceklis
FROM
  gemba
  JOIN gemba_item AS item ON item.id_gemba = gemba.id_gemba
  JOIN gemba_tipe AS tp ON tp.id = gemba.tipe_gemba
  JOIN gemba_ceklis AS ceklis ON ceklis.id = item.id_gemba_ceklis
  LEFT JOIN xin_employees AS em ON em.user_id = gemba.created_by
  LEFT JOIN xin_employees AS up ON up.user_id = gemba.updated_by
WHERE
  (
    -- 🔹 Kondisi A: belum ada deadline awal
    (item.`status` = 'tidak' AND (item.file_perbaikan IS NULL OR item.link_perbaikan IS NULL) AND item.deadline IS NULL)
    OR -- 🔹 Kondisi B: verifikasi tidak oke + sudah ada deadline baru
    (item.status_verifikasi = 'tidak oke' AND (item.deadline_baru IS NULL OR item.verifikasi_at > item.updated_at))
  )

  AND DATE(gemba.created_at) > '2026-02-01'
                            $kondisi
                            GROUP BY gemba.id_gemba
                                ")->result();
    }

    function list_verifikasi()
    {
        $user_id = $_SESSION['user_id'];
        $role_id = $_SESSION['user_role_id'];
        $department_id = $_SESSION['department_id'];

        $list_super = [1139, 8892, 8970, 70, 3651, 2903, 4498]; // Viky, Lintang, Nining27
        // Super Admin & Tambahan
        if ($role_id == 1 || in_array($user_id, $list_super)) {
            $kondisi = "";
        } else {
            $kondisi = "AND gemba.created_by = $user_id";
        }

        return $this->db->query("SELECT
                                item.id_gemba_ceklis,
                                item.id,
                                gemba.id_gemba,
                                gemba.tgl_plan,
                                gemba.tipe_gemba AS id_gemba_tipe,
                                tp.tipe_gemba,
                                gemba.lokasi,
                                gemba.evaluasi,
                                gemba.peserta,
                                gemba.created_at,
                                CONCAT(em.first_name, ' ', em.last_name) AS created_by,
                                gemba.updated_at,
                                CONCAT(up.first_name, ' ', up.last_name) AS updated_by,
                                ceklis.concern AS ceklis
                                FROM
                                gemba
                                JOIN gemba_item AS item ON item.id_gemba = gemba.id_gemba
                                JOIN gemba_tipe AS tp ON tp.id = gemba.tipe_gemba
                                JOIN gemba_ceklis AS ceklis ON ceklis.id = item.id_gemba_ceklis
                                LEFT JOIN xin_employees AS em ON em.user_id = gemba.created_by
                                LEFT JOIN xin_employees AS up ON up.user_id = gemba.updated_by
                                WHERE
                                item.`status` = 'tidak'
                                AND (
                                    item.file_perbaikan IS NOT NULL
                                    OR item.link_perbaikan IS NOT NULL
                                )
                                AND item.note_perbaikan IS NOT NULL
                                AND (
                                    item.verifikasi_at IS NULL
                                    OR item.perbaikan_at > item.verifikasi_at
                                )
                                AND DATE(gemba.created_at) > '2026-02-01' $kondisi
                                GROUP BY item.id_gemba")->result();
    }

    public function detail_perbaikan($id_gemba)
    {

        $user_id = $_SESSION['user_id'];

        $kondisi = '';
        if ($user_id != 1) {
            $kondisi = " AND item.pic = $user_id ";
        }

        return $this->db->query("SELECT 
    item.id_gemba,
    item.id_gemba_ceklis,
    item.lokasi_temuan,
    item.ekspetasi,
    item.deadline,
    ceklis.concern AS ceklis,
    item.status_verifikasi,
    item.alasan_verifikasi
FROM gemba
JOIN gemba_item AS item 
    ON item.id_gemba = gemba.id_gemba
JOIN gemba_ceklis AS ceklis 
    ON ceklis.id = item.id_gemba_ceklis
WHERE
    gemba.id_gemba = ?
    AND item.deadline IS NOT NULL
    AND (
        (
            item.`status` = 'tidak'
            AND (
                item.file_perbaikan IS NULL
                OR item.link_perbaikan IS NULL
            )
        )
        OR item.status_verifikasi = 'tidak oke'
    )
    AND DATE(gemba.created_at) > '2026-02-01'

                $kondisi


        ", [$id_gemba])->result(); // ⬅️ ARRAY
    }

    public function detail_deadline($id_gemba)
    {

        $user_id = $_SESSION['user_id'];

        $kondisi = '';
        if ($user_id != 1) {
            $kondisi = " AND item.pic = $user_id ";
        }

        return $this->db->query("
            SELECT
    item.id_gemba,
    item.id_gemba_ceklis,
    item.lokasi_temuan,
    item.ekspetasi,
    item.deadline,
    ceklis.concern AS ceklis,
    item.status_verifikasi,
    item.alasan_verifikasi,
    CASE
        WHEN item.deadline_baru IS NOT NULL 
            THEN item.deadline_baru
        ELSE item.deadline
    END AS deadline_lama

FROM gemba
JOIN gemba_item AS item 
    ON item.id_gemba = gemba.id_gemba
JOIN gemba_ceklis AS ceklis 
    ON ceklis.id = item.id_gemba_ceklis

WHERE
    gemba.id_gemba = ?
    AND item.status = 'tidak'
    AND (

        -- BELUM DIVERIFIKASI
        (
            item.status_verifikasi IS NULL
            AND item.deadline IS NULL
        )

        OR

        -- STATUS TIDAK OKE
        (
            item.status_verifikasi = 'tidak oke'
            AND (
                
                -- Deadline baru BELUM ADA
                (
                    item.deadline_baru IS NULL
                )

                OR

                -- Deadline baru SUDAH ADA
                (
                    item.deadline_baru IS NOT NULL
                    AND item.verifikasi_at > item.updated_at
                )

            )
        )
    )


    $kondisi



        ", [$id_gemba])->result(); // ⬅️ ARRAY
    }

    public function detail_verifikasi($id_gemba)
    {

        return $this->db->query("
        SELECT
            item.id_gemba,
            item.id_gemba_ceklis,
            item.lokasi_temuan,
            item.ekspetasi,
            item.deadline,
            ceklis.concern AS ceklis,
            item.file_perbaikan AS file,
            item.link_perbaikan AS link,
            item.note_perbaikan AS note,
            item.perbaikan_at,
            item.verifikasi_at,
            item.status_verifikasi
        FROM gemba
        JOIN gemba_item AS item 
            ON item.id_gemba = gemba.id_gemba
        JOIN gemba_ceklis AS ceklis 
            ON ceklis.id = item.id_gemba_ceklis
        WHERE
            gemba.id_gemba = ?
            AND item.status = 'tidak'

            -- SUDAH ADA PERBAIKAN
            AND (
                item.file_perbaikan IS NOT NULL
                OR item.link_perbaikan IS NOT NULL
            )

            -- LOGIC UTAMA
            AND (
                item.verifikasi_at IS NULL
                OR item.updated_at > item.verifikasi_at
            )

            $kondisi
    ", [$id_gemba])->result();
    }


    function get_detail_gemba($id_gemba)
    {
        return $this->db->query("SELECT
                              item.id_gemba,
                              cek.tipe_gemba,
                              item.id_gemba_ceklis,
                              cek.concern,
                              cek.monitoring,
                              IF(item.id_gemba_ceklis %2 = 0,'primary','info') AS warna
                            FROM
                              gemba_item AS item
                              JOIN gemba_ceklis AS cek ON cek.id = item.id_gemba_ceklis
                            WHERE
                              item.id_gemba = '$id_gemba' 
                              AND item.`status` IS NULL")->result();
    }

    function get_detail_evaluasi($id_gemba)
    {
        return $this->db->query("SELECT
                              gemba.id_gemba,
                              DATE_FORMAT( gemba.tgl_plan, '%d %M %Y' ) AS tgl_plan,
                              tp.tipe_gemba,
                              gemba.lokasi,
                              COALESCE ( gemba.evaluasi, '' ) AS evaluasi,
                              COALESCE ( gemba.peserta, '' ) AS peserta,
                              gemba.`status`
                            FROM
                              gemba
                              JOIN gemba_tipe AS tp ON tp.id = gemba.tipe_gemba
                            WHERE
                              gemba.id_gemba = '$id_gemba'")->row_array();
    }

    function list_gemba($start, $end)
    {
        $user_id = $_SESSION['user_id'];
        $role_id = $_SESSION['user_role_id'];
        $department_id = $_SESSION['department_id'];
        $designation_id = $_SESSION['designation_id'];

        $list_super = [1139, 8892, 8970, 70, 2, 5197, 2951, 5086, 5385, 2729, 68, 5286, 3651, 476, 9645, 4498, 7731, 10404]; // Viky, Lintang, Nining27, Ali95, hience3160, alfin3333, saeroh, Farhan63,farid3241, moch5508, pujaannicha8053
        $list_designation = [1217, 1218]; // HRBP Manager, Officer

        // Super Admin & Tambahan
        if ($role_id == 1 || in_array($user_id, $list_super) || in_array($designation_id, $list_designation)) {
            $kondisi = "";
        } else if ($role_id == 2) { // Head
            $kondisi = "AND em.department_id = $department_id";
        } else if ($role_id == 3) { // Manager
            $kondisi = "AND em.department_id = $department_id AND (em.user_role_id IN (4,5) OR gemba.created_by = $user_id)";
        } else if ($role_id == 4) { // Ass Manager
            $kondisi = "AND em.department_id = $department_id AND (em.user_role_id IN (5) OR gemba.created_by = $user_id)";
        } else if ($user_id == 70) { // Nining27
            $kondisi = "AND (gemba.created_by = $user_id OR em.company_id IN (4,5))";
        } else if ($user_id == 3325 || $user_id == 5336) { // budiman1835, farouq3286
            $kondisi = "AND (gemba.created_by = $user_id OR em.company_id IN (2))";
        } else {
            $kondisi = "AND gemba.created_by = $user_id";
        }

        if ($user_id == 7731) { // Dimas Nurullah
            $kondisi = "AND (em.department_id IN (106,142,183,72) OR gemba.created_by = $user_id)";
        }

        if ($user_id == 2735 || $user_id == 6396) { // Siti Cahyati & galuh4208
            $kondisi = "AND (em.department_id IN (142,204,205,206,207,210,211) OR gemba.created_by IN ($user_id,6736))";
        }
        if ($user_id == 5121 || $user_id == 4954) { // Siti Cahyati
            $kondisi = "AND (em.department_id IN (120) OR gemba.created_by IN ($user_id))";
        }

        return $this->db->query("SELECT
                              gemba.id_gemba,
                              gemba.tgl_plan,
                              gemba.tipe_gemba AS id_gemba_tipe,
                              tp.tipe_gemba,
                              gemba.lokasi,
                              gemba.evaluasi,
                              gemba.peserta,
                              gemba.created_at,
                              CONCAT(em.first_name,' ',em.last_name) AS created_by,
                              gemba.updated_at,
                              CONCAT(up.first_name,' ',up.last_name) AS updated_by,
                              IF(item.total_progres > 0 OR gemba.evaluasi IS NULL,'Waiting Completed','Completed') AS `status`,
                              IF(item.total_progres > 0 OR gemba.evaluasi IS NULL,'warning','success') AS color,
                              sts.`status` AS status_akhir,
                              sts.`color` AS color_akhir
                            FROM
                              gemba
                              JOIN ( SELECT id_gemba, COUNT( IF ( `status` IS NULL, 1, NULL )) AS total_progres FROM gemba_item GROUP BY id_gemba ) AS item ON item.id_gemba = gemba.id_gemba
                              JOIN gemba_tipe AS tp ON tp.id = gemba.tipe_gemba
                              LEFT JOIN xin_employees AS em ON em.user_id = gemba.created_by
                              LEFT JOIN xin_employees AS up ON up.user_id = gemba.updated_by
                              JOIN td_status_strategy AS sts ON sts.id = gemba.`status`
                            WHERE gemba.tgl_plan BETWEEN '$start' AND '$end' $kondisi")->result();
    }

    function get_result_gemba($id_gemba)
    {
        return $this->db->query("SELECT
                            cek.concern,
                            cek.monitoring,
                            item.status,
                            COALESCE(item.file,'') AS file,
                            COALESCE(item.link,'') AS link,
                            item.updated_at,
                            CONCAT(up.first_name,' ',up.last_name) AS updated_by,
                            IF(item.status IS NULL,'Waiting','Done') AS status_item,
                            IF(item.status IS NULL,'warning','success') AS warna_item,
                            u.employee_name AS pic
                            FROM gemba_item item
                            JOIN gemba_ceklis cek 
                            ON cek.id = item.id_gemba_ceklis
                            LEFT JOIN xin_employees up 
                            ON up.user_id = item.updated_by
                            LEFT JOIN user u 
                            ON u.id_user = item.pic
                            WHERE
                              item.id_gemba = '$id_gemba'")->result();
    }

    function get_status_strategy()
    {
        return $this->db->query("SELECT id, `status` FROM td_status_strategy")->result();
    }

    //   addnew
    function get_project()
    {
        return $this->db->query("SELECT id_project, project FROM rsp_project_live.m_project WHERE `status` IS NULL ORDER BY project")->result();
    }

    function get_pekerjaan()
    {
        $department_id = $this->session->userdata('department_id');
        return $this->db->query("SELECT id, pekerjaan FROM m_pekerjaan WHERE department_id = $department_id")->result();
    }

    function data_header($id)
    {
        $query = "SELECT
                    gemba.id_gemba,
                    gemba.tgl_plan,
                    gemba.tipe_gemba AS id_gemba_tipe,
                    tp.tipe_gemba,
                    gemba.lokasi,
                    gemba.evaluasi,
                    gemba.peserta,
                    gemba.created_at,
                    CONCAT(em.first_name,' ',em.last_name) AS created_by,
                    gemba.updated_at,
                    CONCAT(up.first_name,' ',up.last_name) AS updated_by,
                    IF(item.total_progres > 0 OR gemba.evaluasi IS NULL,'Waiting Completed','Completed') AS `status`,
                    IF(item.total_progres > 0 OR gemba.evaluasi IS NULL,'warning','success') AS color,
                    sts.`status` AS status_akhir,
                    sts.`color` AS color_akhir
                FROM
                    gemba
                    JOIN ( SELECT id_gemba, COUNT( IF ( `status` IS NULL, 1, NULL )) AS total_progres FROM gemba_item GROUP BY id_gemba ) AS item ON item.id_gemba = gemba.id_gemba
                    JOIN gemba_tipe AS tp ON tp.id = gemba.tipe_gemba
                    LEFT JOIN xin_employees AS em ON em.user_id = gemba.created_by
                    LEFT JOIN xin_employees AS up ON up.user_id = gemba.updated_by
                    JOIN td_status_strategy AS sts ON sts.id = gemba.`status`
                WHERE gemba.id_gemba = '$id'";
        return $this->db->query($query)->row_object();
    }
    function data_ceklis($id)
    {
        $query = "SELECT
                    item.id_gemba,
                    cek.tipe_gemba,
                    item.id_gemba_ceklis,
                    cek.concern,
                    cek.monitoring,
                    IF(item.id_gemba_ceklis %2 = 0,'primary','info') AS warna
                FROM
                    gemba_item AS item
                    JOIN gemba_ceklis AS cek ON cek.id = item.id_gemba_ceklis
                WHERE
                    item.id_gemba = '$id' 
                    AND item.`status` IS NULL";
        return $this->db->query($query)->result();
    }
}
