<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_actual_audit extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function get_audit_employees()
    {
        $query = "SELECT
                    xin_employees.first_name,
                    xin_employees.last_name,
                    xin_employees.user_id
                FROM
                    xin_employees
                    JOIN ( SELECT * FROM `xin_departments` WHERE department_name LIKE '%audit%' ) AS department ON department.department_id = xin_employees.department_id 
                WHERE
                    xin_employees.is_active = 1 
                GROUP BY
                    xin_employees.user_id;";
        return $this->db->query($query)->result();
    }
    public function get_pic($posisi)
    {
        $query = "SELECT first_name, last_name,user_id FROM xin_employees WHERE is_active = 1 AND designation_id = $posisi";
        return $this->db->query($query)->result();
    }
    public function get_latest_plan()
    {
        $query = "SELECT * FROM t_audit_plan_monthly WHERE SUBSTR(created_at,1,7) = SUBSTR(CURDATE(),1,7) ORDER BY id_plan DESC LIMIT 1";
        return $this->db->query($query);
    }
    public function get_dokumen_audit()
    {
        $query = "SELECT
                    jp.id,
                    jp.no_dok,
                    jabatan.designation_name AS jabatan,
                    1 as tipe 
                FROM
                    trusmi_job_profile AS jp
                    LEFT JOIN xin_designations AS jabatan ON jabatan.designation_id = jp.designation_id 
                    WHERE jp.no_dok IS NOT NULL
                GROUP BY
                    jp.no_jp 
                    UNION
                SELECT
                    id_sop,
                    no_doc,
                    nama_dokumen,
                    2 as tipe 
                FROM
                    trusmi_sop AS sop 
                WHERE no_doc IS NOT NULL
                ORDER BY
                    id DESC";
        return $this->db->query($query)->result();
    }
    public function get_actual_audit($start, $end)
    {
        $query = "SELECT
                    tapm.id_plan,
                    tapm.`subject`,
                    tapm.object,
                    tapm.tool,
                    tapm.pemeriksaan,
                    tapm.output,
                    tapm.target,
                    tapm.bobot,
                    tapm.hasil,
                    tapm.analisa,
                    tapm.konfirmasi,
                    tapm.pemeriksaan_rekomendasi,
                    tapm.improvement,
                    tapm.note,
                    CONCAT( xe.first_name, ' ', xe.last_name ) AS auditor,
                    pic.all_pic as pics,
                    CONCAT('<ul>',dok.no_dokumen,'</ul>') as no_dok,
                    xin_companies.name as company,
                    xin_departments.department_name as department,
                    xin_designations.designation_name as designation,
                    pic.pp_pic
                FROM
                    t_audit_plan_monthly AS tapm
                    LEFT JOIN xin_employees AS xe ON xe.user_id = tapm.auditor
                    LEFT JOIN  xin_companies ON xin_companies.company_id = tapm.company_id
                    LEFT JOIN  xin_departments ON xin_departments.department_id = tapm.department_id
                    LEFT JOIN  xin_designations ON xin_designations.designation_id = tapm.designation_id
                    LEFT JOIN (
                    SELECT
                        id_plan,
                        GROUP_CONCAT( CONCAT(xe.first_name, ' ', xe.last_name ) SEPARATOR ' | ' ) AS all_pic,
                        GROUP_CONCAT(
                              CASE
                                  WHEN xe.profile_picture = '' 
                                  AND xe.gender = 'Male' THEN
                                    'default_male.jpg' 
                                    WHEN xe.profile_picture = '' 
                                    AND xe.gender = 'Female' THEN
                                      'default_female.jpg' ELSE COALESCE(xe.profile_picture,'default_male.jpg') 
                                    END 
                                    ) AS pp_pic
                    FROM
                        t_audit_plan_monthly
                        LEFT JOIN xin_employees AS xe ON FIND_IN_SET( xe.user_id, pic ) 
                    GROUP BY
                        id_plan 
                    ) AS pic ON pic.id_plan = tapm.id_plan
                    LEFT JOIN(
                    SELECT
                        tapmd.id_plan,
                        GROUP_CONCAT(CONCAT('<li>',tapmd.id_dokumen) SEPARATOR '</li>') as no_dokumen
                    FROM
                        t_audit_plan_monthly_detail as tapmd
                        LEFT JOIN t_audit_plan_monthly AS tapm ON tapm.id_plan = tapmd.id_plan
                    GROUP BY id_plan
                    ) as dok ON dok.id_plan = tapm.id_plan
                    WHERE tapm.created_at BETWEEN '$start' AND '$end' AND tapm.output IS NOT NULL;";
        return $this->db->query($query)->result();
    }
    public function get_plan_audit()
    {
        $user_id = $this->session->userdata('user_id');
        $condition = " AND head.user_id = $user_id OR tapm.auditor = $user_id";
        if ($user_id == 1) {
            $condition = '';
        }

        $query = "SELECT
                    tapm.id_plan,
                    tapm.`subject`,
                    tapm.object,
                    tapm.tool,
                    tapm.pemeriksaan,
                    tapm.output,
                    tapm.target,
                    tapm.bobot,
                    tapm.hasil,
                    tapm.analisa,
                    tapm.konfirmasi,
                    tapm.pemeriksaan_rekomendasi,
                    tapm.improvement,
                    tapm.note,
                    CONCAT( xe.first_name, ' ', xe.last_name ) AS auditor,
                    pic.all_pic as pics, 
                    dok.no_dokumen as no_dok
                FROM
                    t_audit_plan_monthly AS tapm
                    LEFT JOIN xin_employees AS xe ON xe.user_id = tapm.auditor
                    LEFT JOIN xin_departments dep ON dep.department_id = xe.department_id
					LEFT JOIN xin_employees head ON head.user_id = dep.head_id
                    LEFT JOIN (
                    SELECT
                        id_plan,
                        GROUP_CONCAT( CONCAT( xe.first_name, ' ', xe.last_name ) SEPARATOR ', ' ) AS all_pic 
                    FROM
                        t_audit_plan_monthly
                        LEFT JOIN xin_employees AS xe ON FIND_IN_SET( xe.user_id, pic ) 
                    GROUP BY
                        id_plan 
                    ) AS pic ON pic.id_plan = tapm.id_plan
                    LEFT JOIN(
                    SELECT
                        tapmd.id_plan,
                        GROUP_CONCAT(CONCAT('-',tapmd.id_dokumen) SEPARATOR '<br>') as no_dokumen
                    FROM
                        t_audit_plan_monthly_detail as tapmd
                        LEFT JOIN t_audit_plan_monthly AS tapm ON tapm.id_plan = tapmd.id_plan
                    GROUP BY id_plan
                    ) as dok ON dok.id_plan = tapm.id_plan
                    WHERE tapm.output IS NULL $condition";
        return $this->db->query($query)->result();
    }
    public function get_company()
    {
        $query = "SELECT `name`,company_id FROM xin_companies";
        return $this->db->query($query)->result();
    }
    public function get_department($id)
    {
        $query = "SELECT department_name,department_id FROM xin_departments where company_id = $id AND hide = 0";
        return $this->db->query($query)->result();
    }
    public function get_designations($company, $department)
    {
        $query = "SELECT designation_id,designation_name FROM xin_designations WHERE department_id = $department AND company_id = $company AND hide = 0";
        return $this->db->query($query)->result();
    }
}
