<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_trusmi_memo extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function access_admin()
    {
        $username = $this->session->userdata('username');
        $query = "SELECT * FROM trusmi_memo_admin WHERE admin = '$username'";
        return $this->db->query($query)->result();
    }
    // function get_employee()
    // {
    //     $query = "SELECT
    //             emp.user_id,
    //             emp.company_id,
    //             emp.department_id,
    //             emp.designation_id,
    //             CONCAT(emp.first_name,' ',emp.last_name) AS nama,
    //             comp.`name` AS company_name,
    //             dep.department_name,
    //             emp.user_role_id
    //             FROM
    //             xin_employees emp
    //             LEFT JOIN xin_companies comp ON comp.company_id = emp.company_id
    //             LEFT JOIN xin_departments dep ON dep.department_id = emp.department_id
    //             WHERE emp.is_active = 1 AND emp.user_role_id NOT IN(1,7,8,11,12,13,14)
    //             ORDER BY emp.first_name ASC";
    //     return $this->db->query($query)->result();
    // }

    function get_all_pic()
    {
        $query = "SELECT
            emp.user_id,
            CONCAT(emp.first_name,' ',emp.last_name, ' | ',des.designation_name) AS nama,
            des.designation_name
            
            FROM
            xin_employees emp
            LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
            WHERE emp.is_active = 1
            AND emp.user_role_id NOT IN (8,9,11,12,13,14) AND emp.user_id <> 1
            ORDER BY first_name";
        return $this->db->query($query)->result();
    }

    function get_companies()
    {
        $query = "SELECT
                comp.company_id,
                comp.name,
                comp.kode,
                comp.header_memo
                FROM
                xin_companies comp 
                -- UNION ALL
                -- SELECT
                -- dep.company_id,
                -- CONCAT(comp.kode,' (',dep.department_name,')') AS name,
                -- comp.kode,
                -- dep.header_memo
                -- FROM
                -- xin_departments dep
                -- LEFT JOIN xin_companies comp ON comp.company_id = dep.company_id
                -- WHERE dep.department_id IN (39,40)
                ";
        return $this->db->query($query)->result();
    }

    function get_department($company_id = null)
    {
        if ($company_id != null) {
            $cond = "WHERE company_id = '$company_id'";
        } else {
            $cond = "";
        }
        $query = "SELECT * FROM xin_departments $cond";
        return $this->db->query($query)->result();
    }
    function get_to_person($id)
    {
        $query = "SELECT user_id, CONCAT(first_name,' ',last_name) AS nama FROM xin_employees WHERE department_id IN ($id) AND is_active = 1";
        return $this->db->query($query)->result();
    }

    function get_role()
    {
        $query = "SELECT * FROM xin_user_roles WHERE role_id NOT IN (1,11,12,13,14)";
        return $this->db->query($query)->result();
    }

    function get_approval()
    {
        $user_id = $this->session->userdata('user_id');
        $query = "SELECT
            apv.id,
            apv.nama,
            apv.dibuat,
            apv.diverifikasi,
            apv.disetujui,
            apv.mengetahui,
            GROUP_CONCAT(DISTINCT CONCAT(emp_dibuat.first_name,' ',emp_dibuat.last_name) SEPARATOR ', ') AS nama_dibuat,
            GROUP_CONCAT(DISTINCT CONCAT(emp_diverifikasi.first_name,' ',emp_diverifikasi.last_name) SEPARATOR ', ') AS nama_diverifikasi,
            GROUP_CONCAT(DISTINCT CONCAT(emp_disetujui.first_name,' ',emp_disetujui.last_name) SEPARATOR ', ') AS nama_disetujui,
            GROUP_CONCAT(DISTINCT CONCAT(emp_mengetahui.first_name,' ',emp_mengetahui.last_name) SEPARATOR ', ') AS nama_mengetahui
            FROM
            `trusmi_m_memo_approval` apv
            LEFT JOIN xin_employees emp_dibuat ON FIND_IN_SET(emp_dibuat.user_id,apv.dibuat)
            LEFT JOIN xin_employees emp_disetujui ON FIND_IN_SET(emp_disetujui.user_id,apv.disetujui)
            LEFT JOIN xin_employees emp_diverifikasi ON FIND_IN_SET(emp_diverifikasi.user_id,apv.diverifikasi)
            LEFT JOIN xin_employees emp_mengetahui ON FIND_IN_SET(emp_mengetahui.user_id,apv.mengetahui)
            WHERE apv.created_by = $user_id
            GROUP BY apv.id";
        return $this->db->query($query)->result();
    }
    function approval($id_memo)
    {
        $query = "SELECT 
            mem.id_memo AS id,
            '' AS id_approval,
            mem.id_memo,
            1 AS id_tipe,
            mas.tipe_approval,
            IF(crt.ttd_digital IS NOT NULL,1,NULL) AS status_approval,
            CONCAT(crt.first_name,' ',crt.last_name) AS pic_approval,
            des.designation_name,
            crt.ttd_digital,
            rol.level_sto AS urutan_level, -- Tambahkan ini juga harus sama,
            '' AS note_revisi
            FROM trusmi_t_memo mem
            LEFT JOIN xin_employees crt ON crt.user_id = mem.created_by
            LEFT JOIN trusmi_m_memo mas ON mas.id = 1
            LEFT JOIN xin_designations des ON des.designation_id = crt.designation_id
            LEFT JOIN xin_user_roles rol ON rol.role_id = crt.user_role_id
            WHERE id_memo = '$id_memo'
            UNION ALL
            SELECT
            apv.id,
            apv.id_approval,
            apv.id_memo,
            apv.tipe AS id_tipe,
            mas.tipe_approval,
            apv.status_approval,
            CONCAT(pic_apv.first_name,' ',pic_apv.last_name) AS pic_approval,
            des.designation_name,
            pic_apv.ttd_digital,
            rol.level_sto AS urutan_level, -- Tambahkan ini juga harus sama,
            apv.note_revisi
            FROM
            trusmi_t_memo_approval apv
            LEFT JOIN trusmi_m_memo mas ON mas.id = apv.tipe
            LEFT JOIN xin_employees pic_apv ON pic_apv.user_id = apv.pic
            LEFT JOIN xin_designations des ON des.designation_id = pic_apv.designation_id
            LEFT JOIN xin_user_roles rol ON rol.role_id = pic_apv.user_role_id
            WHERE apv.id_memo = '$id_memo'
            GROUP BY apv.id
            ORDER BY id_tipe,urutan_level ASC
            ";
        return $this->db->query($query)->result();
    }
    function list_approval($id_approval)
    {
        $query = "SELECT
            1 AS tipe,
            apv.id,
            emp.user_id
            FROM
            `trusmi_m_memo_approval` apv
            LEFT JOIN xin_employees emp ON FIND_IN_SET(emp.user_id,apv.dibuat)
            WHERE apv.id = $id_approval AND apv.dibuat IS NOT NULL
            GROUP BY emp.user_id
            UNION ALL
            SELECT
            2 AS tipe,
            apv.id,
            emp.user_id
            FROM
            `trusmi_m_memo_approval` apv
            LEFT JOIN xin_employees emp ON FIND_IN_SET(emp.user_id,apv.diverifikasi)
            WHERE apv.id = $id_approval AND apv.diverifikasi IS NOT NULL
            GROUP BY emp.user_id
            UNION ALL
            SELECT
            3 AS tipe,
            apv.id,
            emp.user_id
            FROM
            `trusmi_m_memo_approval` apv
            LEFT JOIN xin_employees emp ON FIND_IN_SET(emp.user_id,apv.disetujui)
            WHERE apv.id = $id_approval AND apv.disetujui IS NOT NULL
            GROUP BY emp.user_id
            UNION ALL
            SELECT
            4 AS tipe,
            apv.id,
            emp.user_id
            FROM
            `trusmi_m_memo_approval` apv
            LEFT JOIN xin_employees emp ON FIND_IN_SET(emp.user_id,apv.mengetahui)
            WHERE apv.id = $id_approval AND apv.mengetahui IS NOT NULL
            GROUP BY emp.user_id";
        return $this->db->query($query)->result();
    }

    function get_id_memo()
    {
        // Bagian yang diperbaiki ada di kueri SQL di bawah ini.
        $prefix = "MEMO" . substr(date("Ymd"), 2);
        $memo = $this->db->query("SELECT id_memo FROM trusmi_t_memo WHERE id_memo LIKE '{$prefix}%' ORDER BY id_memo DESC LIMIT 1")->row_array();

        if ($memo == null) {
            // Logika Anda di sini sudah benar.
            $id = $prefix . "001";
        } else {
            // Logika Anda di sini juga sudah benar.
            $latest = substr($memo['id_memo'], 10);
            $current = sprintf("%03d", (int) $latest + 1);
            $id = $prefix . $current;
        }
        return $id;
    }

    function read($url)
    {
        $query = "SELECT
            mem.id_memo,
            mem.nomer,
            mem.judul,
            jen.jenis,
            msc.category,
            msc.icon_category,
            msp.priority,
            msp.color_priority,
            mem.content,
            mem.department_id,
            mem.company_id,
            mem.lampiran,
            mem.publish,
            -- mem.draf,
            mem.status_memo,
            mem.approve_at,
            CONCAT(sk.first_name,' ',sk.last_name) AS approve_by,
            sk.ttd_digital AS ttd_sekdir,
            comp.`name`,
            CASE WHEN dep.department_id IN (39,40)
            THEN dep.header_memo
            ELSE comp.header_memo
            END AS header_memo
            FROM
            `trusmi_t_memo` mem
            LEFT JOIN trusmi_m_memo jen ON jen.id = mem.jenis
            LEFT JOIN xin_employees sk ON sk.user_id = mem.approve_by
            LEFT JOIN xin_companies comp ON comp.company_id = mem.company_id
            LEFT JOIN xin_departments dep ON FIND_IN_SET(dep.department_id, mem.department_id)
            LEFT JOIN trusmi_m_memo msc ON msc.id = mem.category
            LEFT JOIN trusmi_m_memo msp ON msp.id = mem.priority
            
            WHERE mem.url = '$url'";
        return $this->db->query($query)->row_object();
    }

    function data_memo($start, $end, $tipe)
    {
        $user_id = $this->session->userdata('user_id');
        $department_id = $this->session->userdata('department_id');
        $role_id = $this->session->userdata('user_role_id');
        $kondisi1 = "";
        if ($tipe == 0) {//index atau halaman awal
            $user_allow = [1, 1139, 5203, 7731, 321,3961,77,1436,10784,10034]; //  super admin
            if (in_array($user_id, $user_allow)) {
                $kondisi1 = "";
            } else {
                $kondisi1 = "AND (
            /* KONDISI A: Pengguna adalah pembuat memo dan memo masih dalam proses (draft, dll) */
            (mem.status_memo IN (1, 2, 3,4,5) AND mem.created_by = $user_id)
            
            OR

            /* KONDISI B: Memo sudah dipublikasi dan pengguna adalah penerima */
            (
                mem.status_memo NOT IN (1, 2, 3,5) -- Status memo sudah final/published
                AND (
                    -- Skenario 1: Memo ditujukan ke orang SPESIFIK di departemen tertentu
                    (
                        (mem.to_person IS NOT NULL AND mem.to_person != '')
                        AND FIND_IN_SET($user_id, mem.to_person)
                        AND FIND_IN_SET($department_id, mem.department_id)
                    )
                    OR
                    -- Skenario 2: Memo ditujukan ke departemen/role UMUM (to_person kosong)
                    (
                        (mem.to_person IS NULL OR mem.to_person = '')
                        AND FIND_IN_SET($department_id, mem.department_id)
                        AND (
                            FIND_IN_SET($role_id, mem.role_id) -- Cocokkan role pengguna
                            OR mem.role_id IS NULL -- Atau memo untuk semua role di departemen itu
                            OR mem.role_id = ''
                        )
                    )
                )
            )

            OR

            /* KONDISI C: User adalah PIC approval di memo tersebut */
            mem.id_memo IN (
                SELECT id_memo 
                FROM trusmi_t_memo_approval 
                WHERE pic = $user_id
            )

            OR

            /* KONDISI D: User ada di list CC */
            FIND_IN_SET($user_id, mem.cc)
        )";
            }
        } else if ($tipe == 1) {//draf
            $user_allow = [1]; // misal super admin
            if (in_array($user_id, $user_allow)) {
                $kondisi1 = "";
            } else {
                $kondisi1 = "AND mem.status_memo = 1 AND mem.created_by = $user_id";
            }
        } else if ($tipe == 4) {//kondisi di approval sekdir
            $kondisi1 = "AND mem.status_memo = 3 AND mem.approve_by IS NULL";

        }


        $query = "SELECT
                mem.id_memo,
                mem.judul,
                mem.nomer,
                mem.priority AS id_priority,
                mem.jenis AS id_jenis,
                jn.jenis,
                pr.priority,
                pr.color_priority,
                ct.category,
                ct.icon_category,
                mem.company_id,
                comp.`name` AS company_name,
                mem.department_id,
                mem.lampiran,
                GROUP_CONCAT(DISTINCT dep.department_name SEPARATOR ', ') AS department_name,
                mem.role_id,
                GROUP_CONCAT(DISTINCT rol.role_name SEPARATOR ', ') AS role_name,
                mem.note,
                mem.content,
                mem.status_memo,
                st.status,
                st.color_status,
                GROUP_CONCAT(DISTINCT CONCAT(per.first_name, ' ', per.last_name) SEPARATOR ', ') AS personal,
                GROUP_CONCAT(DISTINCT CONCAT(empcc.first_name, ' ', empcc.last_name) SEPARATOR ', ') AS list_cc,
                GROUP_CONCAT(DISTINCT apv.pic) AS pic_approval,
                GROUP_CONCAT(DISTINCT CASE WHEN apv.tipe = 1 THEN CONCAT(pic_apv.first_name, ' ', pic_apv.last_name, IF(apv.status_approval = 1, ' ✅', '')) END) AS dibuat,
                GROUP_CONCAT(DISTINCT CASE WHEN apv.tipe = 2 THEN CONCAT(pic_apv.first_name, ' ', pic_apv.last_name, IF(apv.status_approval = 1, ' ✅', '')) END) AS diverifikasi,
                GROUP_CONCAT(DISTINCT CASE WHEN apv.tipe = 3 THEN CONCAT(pic_apv.first_name, ' ', pic_apv.last_name, IF(apv.status_approval = 1, ' ✅', '')) END) AS disetujui,
                GROUP_CONCAT(DISTINCT CASE WHEN apv.tipe = 4 THEN CONCAT(pic_apv.first_name, ' ', pic_apv.last_name, IF(apv.status_approval = 1, ' ✅', '')) END) AS mengetahui,
                mem.created_at,
                mem.created_by,
                CONCAT(crt.first_name, ' ', crt.last_name) AS created_by_name,
                mem.url,
                mem.to_person,
                mem.cc,
                mem.tujuan,
                rev.id AS id_approval,
                GROUP_CONCAT(DISTINCT CONCAT(rev_by.first_name, ' ', rev_by.last_name,' | ',rev.note_revisi)) AS revisi_by_name,
                rev.revisi_by,
                IF($user_id = 1 OR mem.created_by = $user_id, 1, 0) as is_admin
                
                FROM
                    `trusmi_t_memo` mem
                    LEFT JOIN xin_companies comp ON comp.company_id = mem.company_id
                    LEFT JOIN xin_departments dep ON FIND_IN_SET(dep.department_id, mem.department_id)
                    LEFT JOIN xin_user_roles rol ON FIND_IN_SET(rol.role_id, mem.role_id)
                    LEFT JOIN xin_employees per ON FIND_IN_SET(per.user_id, mem.to_person)
                    LEFT JOIN xin_employees empcc ON FIND_IN_SET(empcc.user_id, mem.cc)
                    LEFT JOIN xin_employees crt ON crt.user_id = mem.created_by
                    LEFT JOIN trusmi_m_memo jn ON jn.id = mem.jenis
                    LEFT JOIN trusmi_m_memo pr ON pr.id = mem.priority
                    LEFT JOIN trusmi_m_memo ct ON ct.id = mem.category
                    LEFT JOIN trusmi_m_memo st ON st.id = mem.status_memo
                    LEFT JOIN trusmi_t_memo_approval apv ON mem.id_memo = apv.id_memo
                    LEFT JOIN trusmi_t_memo_approval rev ON rev.id_memo = mem.id_memo AND rev.status_approval = 2
                    LEFT JOIN xin_employees rev_by ON rev_by.user_id = rev.revisi_by
                    LEFT JOIN xin_employees pic_apv ON pic_apv.user_id = apv.pic
                    LEFT JOIN trusmi_m_memo tapv ON tapv.id = apv.tipe
                WHERE
                    SUBSTR(mem.created_at, 1, 10) BETWEEN '$start'
                    AND '$end'
                    $kondisi1
                GROUP BY
                mem.id_memo
        
                ";
        return $this->db->query($query)->result();
    }
    function data_approval($start, $end, $tipe)
    {
        $user_allow = [1, 5203];

        $user_id = $this->session->userdata('user_id');
        $kondisi = "";
        if ($tipe == 3) { // waiting approval 
            $kondisi = "AND mem.status_memo = 2";
        } else { //waiting sekdir
            $kondisi = "AND mem.status_memo = 3";

        }
        if (in_array($user_id, $user_allow)) {
            $kondisi .= " ";
        } else {
            $kondisi .= " AND apv.pic = $user_id";
        }


        $query = "SELECT
                apv.id AS id_approval,
                mem.id_memo,
                mem.nomer,
                mem.judul,
                jn.jenis,
                mem.jenis AS id_jenis,
                mem.priority AS id_priority,
                pr.priority,
                pr.color_priority,
                ct.category,
                ct.icon_category,
                mem.company_id,
                comp.`name` AS company_name,
                mem.department_id,
                GROUP_CONCAT(DISTINCT dep.department_name) AS department_name,
                mem.role_id,
                GROUP_CONCAT(DISTINCT rol.role_name) AS role_name,
                mem.note,
                GROUP_CONCAT(DISTINCT CONCAT(per.first_name, ' ', per.last_name) SEPARATOR ', ') AS personal,
                GROUP_CONCAT(DISTINCT CONCAT(empcc.first_name, ' ', empcc.last_name) SEPARATOR ', ') AS list_cc,
                mem.lampiran,
                mem.content,
                mem.status_memo AS status_memo,
                st.status AS status,
                st.color_status AS color_status,
                his.status_revisi,
                GROUP_CONCAT(DISTINCT apv.pic) AS pic_approval,
                GROUP_CONCAT(DISTINCT CASE WHEN apv.tipe = 1 THEN CONCAT(pic_apv.first_name, ' ', pic_apv.last_name) END) AS dibuat,
                GROUP_CONCAT(DISTINCT CASE WHEN apv.tipe = 2 THEN CONCAT(pic_apv.first_name, ' ', pic_apv.last_name) END) AS diverifikasi,
                GROUP_CONCAT(DISTINCT CASE WHEN apv.tipe = 3 THEN CONCAT(pic_apv.first_name, ' ', pic_apv.last_name) END) AS disetujui,
                GROUP_CONCAT(DISTINCT CASE WHEN apv.tipe = 4 THEN CONCAT(pic_apv.first_name, ' ', pic_apv.last_name) END) AS mengetahui,
                mem.created_at,
                mem.created_by,
                mem.cc,
                CONCAT(crt.first_name, ' ', crt.last_name) AS created_by_name,
                mem.url,
                pic_apv.ttd_digital,
                his.status_revisi,
                GROUP_CONCAT(DISTINCT CONCAT(rev_by.first_name, ' ', rev_by.last_name,' | ',apv.note_revisi)) AS revisi_by_name,
                mem.tujuan,
                IF($user_id = 1 OR mem.created_by = $user_id, 1, 0) as is_admin
                FROM
                    `trusmi_t_memo` mem
                    LEFT JOIN xin_companies comp ON comp.company_id = mem.company_id
                    LEFT JOIN xin_departments dep ON FIND_IN_SET(dep.department_id, mem.department_id)
                    LEFT JOIN xin_user_roles rol ON FIND_IN_SET(rol.role_id, mem.role_id)
                    LEFT JOIN xin_employees per ON FIND_IN_SET(per.user_id, mem.to_person)
                    LEFT JOIN xin_employees crt ON crt.user_id = mem.created_by
                    LEFT JOIN xin_employees empcc ON FIND_IN_SET(empcc.user_id, mem.cc)
                    LEFT JOIN trusmi_m_memo jn ON jn.id = mem.jenis
                    LEFT JOIN trusmi_m_memo pr ON pr.id = mem.priority
                    LEFT JOIN trusmi_m_memo ct ON ct.id = mem.category
                    LEFT JOIN trusmi_m_memo st ON st.id = mem.status_memo
                    LEFT JOIN trusmi_t_memo_approval apv ON mem.id_memo = apv.id_memo
                    LEFT JOIN xin_employees rev_by ON rev_by.user_id = apv.revisi_by
                    LEFT JOIN xin_employees pic_apv ON pic_apv.user_id = apv.pic
                    LEFT JOIN trusmi_m_memo tapv ON tapv.id = apv.tipe
                    LEFT JOIN trusmi_t_memo_history his ON his.id_memo = mem.id_memo AND his.feedback_by = apv.pic
                    LEFT JOIN trusmi_m_memo rev ON rev.id = his.status_revisi
                    
                WHERE
                    SUBSTR(mem.created_at, 1, 10) BETWEEN '$start'
                    AND '$end'
                    AND apv.status_approval IS NULL
                    AND mem.id_memo NOT IN (
                        SELECT id_memo
                        FROM trusmi_t_memo_approval
                        WHERE status_approval = 2
                    )
                    -- AND apv.status_approval <> 2
                    $kondisi
                GROUP BY
                apv.id
        
                ";
        return $this->db->query($query)->result();
    }

    


    function get_draf($id_memo)
    {
        $user_id = $this->session->userdata('user_id');
        $query = "SELECT
                mem.id_memo,
                mem.judul,
                mem.priority,
                mem.jenis,
                jn.jenis AS jenis_memo,
                mem.category,
                mem.company_id,
                mem.department_id,
                mem.role_id,
                mem.content,
                mem.lampiran,
                mem.tujuan,
                mem.to_person,
                apv.id_approval,
                mem.cc,
                GROUP_CONCAT(CONCAT(dep.department_id,',',dep.department_name) SEPARATOR '|') AS list_department,
                rev.note_revisi,
                GROUP_CONCAT(DISTINCT CONCAT(rev_by.first_name, ' ', rev_by.last_name,' | ',rev.note_revisi) SEPARATOR ', ') AS revisi_by_name,
                GROUP_CONCAT(DISTINCT rev.id) AS id_revisi,
                rev.revisi_by,
                IF($user_id = 1 OR mem.created_by = $user_id, 1, 0) as is_admin
                FROM
                trusmi_t_memo mem
                LEFT JOIN trusmi_t_memo_approval apv ON apv.id_memo = mem.id_memo
                LEFT JOIN trusmi_m_memo jn ON jn.id = mem.jenis
                LEFT JOIN trusmi_t_memo_approval rev ON rev.id_memo = mem.id_memo AND rev.status_approval = 2
                LEFT JOIN xin_employees rev_by ON rev_by.user_id = rev.revisi_by
                LEFT JOIN xin_departments dep ON dep.company_id = mem.company_id
                WHERE mem.id_memo = '$id_memo'";
        return $this->db->query($query)->row_object();
    }
    function cek_status_approval($id_memo)
    {
        $query = "SELECT * FROM trusmi_t_memo_approval WHERE id_memo = '$id_memo'";
        return $this->db->query($query)->result();
    }

    public function generate_approval_id()
    {
        // Correct date format for 'YYMMDD' is 'ymd'
        $prefix = 'AP' . date('ymd'); // e.g., AP250908 for today, September 8, 2025

        // Query to find the last ID for today
        $this->db->select('id_approval');
        $this->db->from('trusmi_m_memo_approval');
        $this->db->like('id_approval', $prefix, 'after'); // 'after' means prefix%
        $this->db->order_by('id_approval', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $row = $query->row();

        if ($row) {
            $last_id = $row->id_approval;
            $last_sequence = (int) substr($last_id, -3);
            $new_sequence = $last_sequence + 1;
        } else {
            $new_sequence = 1;
        }
        $formatted_sequence = str_pad($new_sequence, 3, '0', STR_PAD_LEFT);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    function dt_memo($start, $end, $department, $role_id, $status_memo, $id)
    {
        if ($department == 0 || $id == 1 || $id == 2516 || $id == 2729 || $id == 803 || $id == 6466) {
            $sub_query1 = "";
        } else {
            $sub_query1 = "FIND_IN_SET('$department',memo.department_id)";
        }

        if ($role_id == 1 || $id == 1 || $id == 2516 || $id == 2729 || $id == 803) {
            $sub_query2 = "";
        } else {
            $sub_query2 = "AND FIND_IN_SET('$role_id',memo.role_id)";
        }

        if ($start == null) {
            if ($status_memo != 'feedback') {
                if ($id == 1 || $id == 2516 || $id == 2729 || $id == 803 || $id == 6466) {
                    $sub = 'WHERE memo.status_memo = ' . $status_memo;
                } else {
                    $sub = 'WHERE memo.created_by = ' . $id . ' AND memo.status_memo = ' . $status_memo;
                }
            } else {
                $sub = 'WHERE SUBSTR(memo.start_feedback_at,1,10) <= CURDATE() AND memo.status_memo = 1';
            }
        } else {
            if ($id == 1 || $id == 2516 || $id == 2729 || $id == 803 || $id == 6466) {
                $sub = "WHERE SUBSTR(memo.created_at,1,10) BETWEEN SUBSTR('" . $start . "',1,10) AND SUBSTR('" . $end . "',1,10) AND memo.status_memo = " . $status_memo;
            } else {
                $sub = "WHERE SUBSTR(memo.created_at,1,10) BETWEEN SUBSTR('" . $start . "',1,10) AND SUBSTR('" . $end . "',1,10) AND ((" . $sub_query1 . " " . $sub_query2 . ") OR memo.created_by = " . $id . ") AND memo.status_memo = " . $status_memo;
            }
        }

        $query = "SELECT
                    memo.id_memo,
                    IF(memo.id_approval IS NOT NULL, 1, NULL) AS id_approval,
                    memo.tipe_memo,
                    memo.note,
                    memo.created_at,
                    memo.files_memo,
                    memo.status_memo,
                    CONCAT(emp.first_name,' ',emp.last_name) as created_by,
                    GROUP_CONCAT(DISTINCT com.name) as company,
                    GROUP_CONCAT(DISTINCT depa.department_name) as department,
	                GROUP_CONCAT(DISTINCT `role`.role_name) AS role,
                    CONCAT(upd.first_name,' ',upd.last_name) as updated_by,
                    memo.note_update  
                FROM
                    trusmi_t_memo memo
                    JOIN `xin_employees` emp ON emp.user_id = memo.created_by
                    LEFT JOIN `xin_employees` upd ON upd.user_id = memo.updated_by
                    JOIN xin_companies com ON FIND_IN_SET(com.company_id, memo.company_id)
                    JOIN xin_departments depa ON FIND_IN_SET(depa.department_id, memo.department_id)
	                JOIN xin_user_roles `role` ON FIND_IN_SET(`role`.role_id, memo.role_id)
                    $sub
                GROUP BY memo.id_memo;";
        return $this->db->query($query)->result();
    }

    public function generate_memo_number($company_code)
    {
        $year = date('Y'); // Mengambil tahun sekarang, misal: 2025
        $month_numeric = date('n'); // Mengambil bulan sekarang (numerik), misal: 8
        $division_code = $this->session->userdata('user_division');
        $roman_months = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];
        $month_roman = $roman_months[$month_numeric];

        $this->db->where('department_code', $division_code);
        $this->db->where('MONTH(created_at)', $month_numeric);
        $this->db->where('YEAR(created_at)', $year);
        $count = $this->db->count_all_results('memos');

        $next_number = $count + 1;

        // 4. Menyusun format akhir menggunakan sprintf
        // %02d akan membuat nomor urut menjadi 2 digit dengan awalan nol (01, 02, ..., 19)
        $memo_number = sprintf(
            "No. %02d/MI/%s/%s/%s/%d",
            $next_number,
            strtoupper($company_code), // Pastikan kode perusahaan huruf besar
            strtoupper($division_code), // Pastikan kode divisi huruf besar
            $month_roman,
            $year
        );

        return $memo_number;
    }

    function get_memo_history($id)
    {
        $query = "SELECT
                his.id,
                his.id_memo,
                mem.judul,
                his.note_revisi,
                his.status_revisi,
                mrv.revisi_status,
                his.revisi_at,
                his.revisi_by AS id_revisi_by,
                CONCAT(rv.first_name,' ',rv.last_name) AS revisi_by,
                his.feedback,
                his.feedback_at,
                his.feedback_by AS id_feedback_by,
                CONCAT(fb.first_name,' ',fb.last_name) AS feeback_by
                FROM
                trusmi_t_memo_history his
                LEFT JOIN trusmi_t_memo mem ON mem.id_memo = his.id_memo
                LEFT JOIN trusmi_m_memo mrv ON mrv.id = his.status_revisi
                LEFT JOIN xin_employees fb ON fb.user_id = his.feedback_by
                LEFT JOIN xin_employees rv ON rv.user_id = his.revisi_by
                WHERE his.id_memo = '$id'";
        return $this->db->query($query)->result();
    }
    function get_kode_department($id)
    {
        $query = "SELECT
            dep.department_id,
            dep.kode_memo  AS kode_dep,
            comp.kode AS kode_comp
            FROM
            xin_departments dep
            LEFT JOIN xin_companies comp ON comp.company_id  = dep.company_id
            WHERE dep.department_id = $id";
        return $this->db->query($query)->row_object();
    }
    function get_detail_notif($id_memo)
    {
        $user_cc = '1139,10034,3961';
        $query = "SELECT
                    mem.id_memo,
                    mem.nomer,
                    mem.judul,
                    mem.priority AS id_priority,
                    mem.jenis AS id_jenis,
                    jn.jenis,
                    pr.priority,
                    pr.color_priority,
                    pr.category,
                    pr.icon_category,
                    mem.company_id,
                    comp.`name` AS company_name,
                    mem.department_id,
                    mem.lampiran,
                    mem.content,
                    mem.url,
                    mem.to_person,
                    mem.role_id,
                    mem.tujuan,
                    GROUP_CONCAT(DISTINCT dep.department_name) AS department_name,
                    CONCAT(all_dep.first_name, ' ', all_dep.last_name) AS nama_karyawan,
                    all_dep.contact_no,
                    all_dep.email_corporate,
                    CONCAT(crt.first_name, ' ', crt.last_name) AS created_by_name
                FROM
                    `trusmi_t_memo` mem
                LEFT JOIN xin_companies comp ON comp.company_id = mem.company_id
                LEFT JOIN xin_departments dep ON FIND_IN_SET(dep.department_id, mem.department_id)
                LEFT JOIN xin_user_roles rol ON FIND_IN_SET(rol.role_id, mem.role_id)
                LEFT JOIN xin_employees per ON FIND_IN_SET(per.user_id, mem.to_person)
                LEFT JOIN xin_employees crt ON crt.user_id = mem.created_by
                LEFT JOIN trusmi_m_memo jn ON jn.id = mem.jenis
                LEFT JOIN trusmi_m_memo pr ON pr.id = mem.priority
                LEFT JOIN trusmi_m_memo ct ON ct.id = mem.category
                LEFT JOIN trusmi_m_memo st ON st.id = mem.status_memo
                LEFT JOIN xin_employees all_dep
                    ON FIND_IN_SET(all_dep.department_id, mem.department_id)
                    AND (
                            -- 1️⃣ Jika role_id ada isinya
                            (
                                mem.role_id IS NOT NULL
                                AND mem.role_id <> ''
                                AND (
                                    -- 1a. Jika to_person juga diisi, maka harus cocok role_id DAN user_id
                                    (mem.to_person IS NOT NULL AND mem.to_person <> '' 
                                        AND FIND_IN_SET(all_dep.user_role_id, mem.role_id)
                                        AND FIND_IN_SET(all_dep.user_id, mem.to_person)
                                    )
                                    -- 1b. Jika to_person kosong, cukup cocok role_id saja
                                    OR ( (mem.to_person IS NULL OR mem.to_person = '')
                                        AND FIND_IN_SET(all_dep.user_role_id, mem.role_id)
                                    )
                                )
                            )
                            -- 2️⃣ Jika role_id kosong/null (fallback lama)
                            OR (
                                (mem.role_id IS NULL OR mem.role_id = '')
                                AND (
                                    -- jika role kosong, pakai filter to_person bila diisi
                                    (mem.to_person IS NOT NULL AND mem.to_person <> ''
                                        AND FIND_IN_SET(all_dep.user_id, mem.to_person)
                                    )
                                    -- atau kalau dua-duanya kosong tetap tampil semua department
                                    OR (mem.to_person IS NULL OR mem.to_person = '')
                                )
                            )
                        )
                WHERE
                    mem.id_memo = '$id_memo'
                    AND all_dep.is_active = 1
                    AND all_dep.email_corporate IS NOT NULL
                GROUP BY
                    all_dep.user_id
                    UNION ALL
                    SELECT
                    mem.id_memo,
                    mem.nomer,
                    mem.judul,
                    mem.priority AS id_priority,
                    mem.jenis AS id_jenis,
                    jn.jenis,
                    pr.priority,
                    pr.color_priority,
                    pr.category,
                    pr.icon_category,
                    mem.company_id,
                    comp.`name` AS company_name,
                    mem.department_id,
                    mem.lampiran,
                    mem.content,
                    mem.url,
                    mem.to_person,
                    mem.role_id,
                    mem.tujuan,
                    GROUP_CONCAT(DISTINCT dep.department_name) AS department_name,
                    CONCAT(all_dep.first_name, ' ', all_dep.last_name) AS nama_karyawan,
                    all_dep.contact_no,
                    all_dep.email_corporate,
                    CONCAT(crt.first_name, ' ', crt.last_name) AS created_by_name
                FROM
                    `trusmi_t_memo` mem
                LEFT JOIN xin_companies comp ON comp.company_id = mem.company_id
                LEFT JOIN xin_departments dep ON FIND_IN_SET(dep.department_id, mem.department_id)
                LEFT JOIN xin_user_roles rol ON FIND_IN_SET(rol.role_id, mem.role_id)
                LEFT JOIN xin_employees per ON FIND_IN_SET(per.user_id, mem.to_person)
                LEFT JOIN xin_employees crt ON crt.user_id = mem.created_by
                LEFT JOIN trusmi_m_memo jn ON jn.id = mem.jenis
                LEFT JOIN trusmi_m_memo pr ON pr.id = mem.priority
                LEFT JOIN trusmi_m_memo ct ON ct.id = mem.category
                LEFT JOIN trusmi_m_memo st ON st.id = mem.status_memo
                LEFT JOIN xin_employees all_dep ON FIND_IN_SET(all_dep.user_id, CONCAT_WS(',', mem.cc, '$user_cc'))
                WHERE
                    mem.id_memo = '$id_memo'
                    AND all_dep.is_active = 1
                GROUP BY
                    all_dep.user_id;
                ";

        return $this->db->query($query)->result();
    }
    function get_detail_notif_wa($id_memo)
    {

        $query = "SELECT
            mem.id_memo,
            mem.judul,
            jn.jenis,
            ct.category,
            pr.priority,
            apv.pic AS id_pic,
            CONCAT(crt.first_name, ' ', crt.last_name) AS created_by_name,
            des.designation_name AS created_by_position,
            CONCAT(pc.first_name, ' ', pc.last_name) AS pic,
            pc.contact_no,
            CASE apv.tipe
                WHEN 1 THEN 'Dibuat'
                WHEN 2 THEN 'Diverifikasi'
                WHEN 3 THEN 'Disetujui'
                WHEN 4 THEN 'Mengetahui'
                ELSE '-'
            END AS jenis_approval,
            mem.created_at,
            DATE_ADD(mem.created_at, INTERVAL 2 DAY) AS deadline
        FROM
            trusmi_t_memo_approval apv
            LEFT JOIN trusmi_t_memo mem ON mem.id_memo = apv.id_memo
            LEFT JOIN xin_employees crt ON crt.user_id = mem.created_by
            LEFT JOIN xin_designations des ON des.designation_id = crt.designation_id
            LEFT JOIN trusmi_m_memo jn ON jn.id = mem.jenis
            LEFT JOIN trusmi_m_memo ct ON ct.id = mem.category
            LEFT JOIN trusmi_m_memo pr ON pr.id = mem.priority
            LEFT JOIN xin_employees pc ON pc.user_id = apv.pic
            LEFT JOIN trusmi_m_memo dd ON dd.status = mem.status_memo
        WHERE
            apv.id_memo = '$id_memo' 
            AND mem.status_memo = 2;
                ";

        return $this->db->query($query)->result();
    }

    function get_admin_pic()
    {
        $query = "SELECT
            adm.id,
            adm.admin,
            CONCAT(emp.first_name,' ',emp.last_name) AS nama,
            des.designation_name,
            dep.department_name,
            adm.updated_at,
            CONCAT(upt.first_name, ' ', upt.last_name) AS updated_by_name
            FROM trusmi_memo_admin adm
            LEFT JOIN xin_employees emp ON emp.username = adm.admin
            LEFT JOIN xin_employees upt ON upt.user_id = adm.updated_by
            LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
            LEFT JOIN xin_departments dep ON dep.department_id = emp.department_id
            ORDER BY adm.id";
        return $this->db->query($query)->result();
    }

    function get_employees_for_admin()
    {
        $query = "SELECT
            emp.user_id,
            emp.username,
            CONCAT(emp.first_name,' ',emp.last_name) AS nama,
            des.designation_name
            FROM xin_employees emp
            LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
            WHERE emp.is_active = 1 AND emp.user_id <> 1 AND emp.user_role_id <> 8 AND emp.user_id NOT IN (1,5203)
            ORDER BY emp.first_name";
        return $this->db->query($query)->result();
    }

    function update_admin_pic($id, $username)
    {
        $this->db->where('id', (int) $id);
        return $this->db->update('trusmi_memo_admin', 
        ['admin' => $username,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => $this->session->userdata('user_id')
        ]
        );
    }

    function insert_admin_pic($username)
    {
        return $this->db->insert('trusmi_memo_admin', [
            'admin'      => $username,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('user_id')
        ]);
    }

    function delete_admin_pic($id)
    {
        $this->db->where('id', (int) $id);
        return $this->db->delete('trusmi_memo_admin');
    }
}
