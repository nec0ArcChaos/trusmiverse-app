<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_trusmi_wb extends CI_Model
{
    protected $userId;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->userId = $this->session->userdata('user_id');
    }

    public function getAllDepartment()
    {
        $query = "SELECT
        department_id,
        department_name AS nama_dep,
        company_id 
    FROM
        xin_departments";

        return $this->db->query($query)->result();
    }

    public function getDepartmentActive()
    {
        $query = "SELECT
        dep.department_id,
        CONCAT( dep.department_name, ' | ', comp.`name` ) AS nama_dep 
    FROM
        xin_departments dep
        JOIN ( SELECT user_id, department_id FROM xin_employees WHERE is_active = 1 ) emp ON emp.department_id = dep.department_id
        LEFT JOIN xin_companies comp ON comp.company_id = dep.company_id 
    GROUP BY
        dep.department_id 
    ORDER BY
        department_name";
        return $this->db->query($query)->result();
    }

    public function getEmployee($id = null)
    {
        if ($id != null) {
            $kondisi = "WHERE xin_employees.department_id = $id and is_active = 1";
        } else {
            $kondisi = "WHERE is_active = 1";
        }

        $query = "SELECT
        user_id AS 
    `value`
        ,
        CONCAT( first_name, ' ', last_name,' | ',ds.designation_name ) AS `text`
    FROM
        `xin_employees`
        LEFT JOIN xin_designations ds ON xin_employees.designation_id = ds.designation_id
        $kondisi
        ORDER BY ds.designation_name";
        return $this->db->query($query)->result();
    }

    public function getCompany()
    {
        $query = "SELECT company_id, `name` AS nama_com FROM xin_companies";
        return $this->db->query($query)->result();
    }

    public function getDepartmentByCompany($id)
    {
        $query = "SELECT
        department_id,
        department_name AS nama_dep,
        company_id 
    FROM
        xin_departments
        WHERE 
        company_id = $id";

        return $this->db->query($query)->result();
    }

    public function getWbAktivitas()
    {
        $this->db->select('*')->from('trusmi_m_wb_aktivitas')->order_by('id_aktivitas', 'asc');
        return $this->db->get()->result();
    }

    public function getWbPertanyaan()
    {
        $this->db->select('*')->from('trusmi_m_wb_pertanyaan')->order_by('id_pertanyaan', 'asc');
        return $this->db->get()->result_array();
    }

    public function getListWb($start, $end)
    {
        $user = $this->session->userdata('user_id');
        $userList = [1, 61, 64, 68, 803, 118];
        if (!in_array($user, $userList)) {
            $kondisi = "AND twb.created_by = '$user' OR twb.pic_eskalasi = '$user'";
        } else {
            $kondisi = "";
        }

        $query = "SELECT
        twb.`status` AS id_status,
        twb.id_wb,
        twb.laporan,
        xd.department_name AS nama_department,
        CONCAT(xe.first_name,' ',xe.last_name) AS nama_employee,
        xe.username,
        xe.profile_picture,
        twb.tgl_temuan,
        twb.id_aktivitas,
        mwa.aktivitas,
        twb.note_other,
        twb.kronologi,
        twb.lokasi,
        twb.kota,
        twb.hubungan,
        xct.`name` AS nama_company_terkait,
        xdt.department_name AS nama_department_terkait,
        twb.informasi,
        twb.bukti,
        twb.ekspektasi_akhir,
        twb.keterkaitan_dampak,
        twb.dokumen_penyelesaian,
        COALESCE(twb.persetujuan,1) AS persetujuan,
        created_by.profile_picture AS created_profile_picture,
	    created_by.username AS created_username,
        CONCAT(created_by.first_name,' ',created_by.last_name) AS created_by,
        twb.created_at,
        GROUP_CONCAT( CONCAT( twbp.pertanyaan, ' ', '<b>',twbp.jawaban,'</b>' ) SEPARATOR '<br>' ) AS jawaban,
        twb.created_by AS id_created_by,
        twb.department_ext,  
        twb.employee_ext,
        wb_status.status, -- wbdev
        trusmi_m_wb_status_fu.status_fu,
        trusmi_m_wb_kategori.kategori AS kategori_aduan,
        CONCAT(wb_pic.first_name, ' ', wb_pic.last_name) AS pic_eskalasi_wb,
        twb.keterangan,
        trusmi_m_wb_alasan_reject.alasan AS alasan_reject, -- revnew   
        trusmi_m_wb_alasan_reject.deskripsi AS deskripsi_reject   
    FROM
        `trusmi_t_wb` twb
        LEFT JOIN trusmi_m_wb_aktivitas mwa ON mwa.id_aktivitas = twb.id_aktivitas
        LEFT JOIN xin_employees xe ON xe.user_id = twb.employee_id
        LEFT JOIN xin_departments xd ON xd.department_id = twb.department_id
        LEFT JOIN xin_departments xdt ON xdt.department_id = twb.department_terkait
        LEFT JOIN xin_companies xct ON xct.company_id = twb.company_terkait
        LEFT JOIN xin_employees created_by ON created_by.user_id = twb.created_by
        JOIN trusmi_t_wb_pertanyaan twbp ON twbp.id_wb = twb.id_wb 
        JOIN trusmi_m_wb_status wb_status ON wb_status.id = twb.status 
        -- wbdev
        LEFT JOIN trusmi_m_wb_status_fu ON twb.status_fu = trusmi_m_wb_status_fu.id
        LEFT JOIN trusmi_m_wb_kategori ON twb.kategori_aduan = trusmi_m_wb_kategori.id
        LEFT JOIN xin_employees wb_pic ON twb.pic_eskalasi = wb_pic.user_id 
        LEFT JOIN trusmi_m_wb_alasan_reject ON twb.alasan_reject = trusmi_m_wb_alasan_reject.id -- revnew
        
        WHERE
        DATE(twb.created_at) BETWEEN '$start' AND '$end'
        $kondisi
    GROUP BY
        twb.id_wb 
    ORDER BY
        twb.status";
        return $this->db->query($query)->result();
    }

    // addnew
    public function getPassIT($user_id)
    {
        return $this->db->query("SELECT `password` FROM `view_user` WHERE user_id = $user_id")->row();
    }

    // WBDEV
    public function resume_monitoring_progres_wb($id_user)
    {
        $userList = [61, 64, 68, 803];
        if (!in_array($id_user, $userList)) {
            $kondisi = "WHERE trusmi_t_wb.created_by = '$id_user'";
        } else {
            $kondisi = "";
        }

        $query = "SELECT
                    COUNT(wb_all.id_wb) AS total_aduan,
                    COUNT( IF(wb_all.`status` = 1, 1, NULL) ) AS total_waiting,
                    COUNT( IF(wb_all.`status` = 2, 1, NULL) ) AS total_progres,
                    COUNT( IF(wb_all.`status` = 3, 1, NULL) ) AS total_done,
                    COUNT( IF(wb_all.`status` = 4, 1, NULL) ) AS total_reject, -- revnew
                    ROUND( AVG(wb_lt_done.lt_done), 1 ) AS avg_lt_done
                FROM
                    `trusmi_t_wb`
                    LEFT JOIN (
                        SELECT
                            twb.id_wb,
                            twb.`status`,
                            twb.created_at,
                            twb.proses_at
                        FROM
                            trusmi_t_wb twb
                            JOIN trusmi_t_wb_pertanyaan twbp ON twb.id_wb = twbp.id_wb
                        GROUP BY twb.id_wb
                    ) wb_all ON trusmi_t_wb.id_wb = wb_all.id_wb
                    LEFT JOIN (
                        SELECT
                            twb.id_wb,
                            twb.created_at,
                            twb.proses_at,
                            DATEDIFF(twb.proses_at, twb.created_at) AS lt_done
                        FROM
                            trusmi_t_wb twb
                            JOIN trusmi_t_wb_pertanyaan twbp ON twb.id_wb = twbp.id_wb 
                        WHERE
                            twb.`status` = 3
                            AND twb.proses_at IS NOT NULL
                        GROUP BY twb.id_wb
                    ) wb_lt_done ON trusmi_t_wb.id_wb = wb_lt_done.id_wb
                    $kondisi";

        return $this->db->query($query)->result();
    }

    public function getWbStatus()
    {
        $this->db->select('*')->from('trusmi_m_wb_status')->order_by('id', 'asc');
        return $this->db->get()->result();
    }

    public function getWbKategoriAduan()
    {
        $this->db->select('*')->from('trusmi_m_wb_kategori')->order_by('id', 'asc');
        return $this->db->get()->result();
    }

    public function getWbStatusFu()
    {
        $this->db->select('*')->from('trusmi_m_wb_status_fu')->order_by('id', 'asc');
        return $this->db->get()->result();
    }

    public function getPicEscalation()
    {
        $query = "SELECT
                    user_id AS `value`,
                    CONCAT( first_name, ' ', last_name,' | ',ds.designation_name ) AS `text` 
                FROM
                    `xin_employees` 
                    LEFT JOIN xin_designations ds ON xin_employees.designation_id = ds.designation_id
                WHERE
                    xin_employees.ctm_posisi IN ('Head','Manager','Direktur') AND xin_employees.is_active = 1 AND xin_employees.user_id != 1";

        return $this->db->query($query)->result();
    }

    public function dt_list_wb_by_status($status)
    {
        $id_user = $this->session->userdata('user_id');

        $usr_akses_all_progres = [1, 68, 118];

        $kondisi = "";
        if ($status == 2 && !in_array($id_user, $usr_akses_all_progres)) { // jika status Working On dan user bukan pak Farhan/IT
            $kondisi = "AND twb.pic_eskalasi = '$id_user'";
        }

        $query = "SELECT
                    twb.id_wb,
                    twb.laporan,
                    xd.department_name AS nama_department,
                    CONCAT(xe.first_name,' ',xe.last_name) AS nama_employee,
                    xe.username,
                    xe.profile_picture,
                    twb.tgl_temuan,
                    twb.id_aktivitas,
                    mwa.aktivitas,
                    twb.note_other,
                    twb.kronologi,
                    twb.lokasi,
                    twb.kota,
                    twb.hubungan,
                    xct.`name` AS nama_company_terkait,
                    xdt.department_name AS nama_department_terkait,
                    twb.informasi,
                    twb.bukti,
                    COALESCE(twb.persetujuan,1) AS persetujuan,
                    created_by.username AS created_username,
                    CONCAT(created_by.first_name,' ',created_by.last_name) AS created_by,
                    twb.created_at,
                    twb.created_by AS id_created_by,
                    twb.department_ext,  
                    twb.employee_ext,
                    -- wbdev 
                    twb.status AS id_status,
                    trusmi_m_wb_status.`status`,
                    twb.keterangan, 
                    twb.proses_at,
                    twb.kategori_aduan AS id_kategori_aduan,
                    trusmi_m_wb_kategori.kategori AS kategori_aduan,
                    twb.status_fu AS id_status_fu,
                    trusmi_m_wb_status_fu.status_fu,
                    twb.pic_eskalasi,
                    CONCAT(wb_pic.first_name, ' ', wb_pic.last_name) AS pic_eskalasi_wb,
            -- 		twb.proses_by
                    'Anonim' AS proses_by,
                    twbhis.dokumen_penyelesaian 
                FROM
                    `trusmi_t_wb` twb
                    LEFT JOIN trusmi_m_wb_aktivitas mwa ON mwa.id_aktivitas = twb.id_aktivitas
                    LEFT JOIN xin_employees xe ON xe.user_id = twb.employee_id
                    LEFT JOIN xin_departments xd ON xd.department_id = twb.department_id
                    LEFT JOIN xin_departments xdt ON xdt.department_id = twb.department_terkait
                    LEFT JOIN xin_companies xct ON xct.company_id = twb.company_terkait
                    LEFT JOIN xin_employees created_by ON created_by.user_id = twb.created_by
                    JOIN trusmi_t_wb_pertanyaan twbp ON twbp.id_wb = twb.id_wb
                    LEFT JOIN trusmi_t_wb_history twbhis ON twb.id_wb = twbhis.id_wb AND twbhis.status = $status -- updev
                    
                    JOIN trusmi_m_wb_status ON twb.`status` = trusmi_m_wb_status.id
                    LEFT JOIN trusmi_m_wb_status_fu ON twb.status_fu = trusmi_m_wb_status_fu.id
                    LEFT JOIN trusmi_m_wb_kategori ON twb.kategori_aduan = trusmi_m_wb_kategori.id
                    LEFT JOIN xin_employees wb_pic ON twb.pic_eskalasi = wb_pic.user_id 
                WHERE
                    twb.`status` = $status
                    $kondisi
                GROUP BY
                    twb.id_wb 
                ORDER BY
                    tgl_temuan";

        return $this->db->query($query)->result();
    }

    public function dt_history_wb($id_wb)
    {
        $query = "SELECT
                    history.id_wb,
                    stat.`status`,
                    kat.kategori AS kategori_aduan,
                    stat_fu.status_fu,
                    CONCAT(pic.first_name, ' ', pic.last_name) AS pic_eskalasi,
                    history.keterangan,
                    history.proses_at,
                    CONCAT(usr_proses.first_name, ' ', usr_proses.last_name) AS proses_by
                FROM
                    `trusmi_t_wb_history` history
                    JOIN trusmi_m_wb_status stat ON history.`status` = stat.id
                    LEFT JOIN trusmi_m_wb_kategori kat ON history.kategori_aduan = kat.id
                    LEFT JOIN trusmi_m_wb_status_fu stat_fu ON history.status_fu = stat_fu.id
                    LEFT JOIN xin_employees pic ON history.pic_eskalasi = pic.user_id
                    LEFT JOIN xin_employees usr_proses ON history.proses_by = usr_proses.user_id 
                WHERE 
                    id_wb = '$id_wb'
                ORDER BY history.proses_at DESC";

        return $this->db->query($query)->result();
    }

    // revnew
    public function getWbAlasanReject()
    {
        $this->db->select('*')->from('trusmi_m_wb_alasan_reject')->order_by('id', 'asc');
        return $this->db->get()->result();
    }
}
