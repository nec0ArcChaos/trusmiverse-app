<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_marketing extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function data_kpi($user_id, $periode){
        $query = "SELECT 
                    e.user_id,
                    CONCAT(e.first_name, ' ', e.last_name) AS name,
                    COALESCE(kpi.company, cmp.`name`) AS company,
                    COALESCE(kpi.department, dep.department_name) AS department,
                    COALESCE(kpi.designation, dsg.designation_name) AS designation,
                    CASE 
                        WHEN e.profile_picture IS NULL OR e.profile_picture = '' OR e.profile_picture = 'no file'
                            THEN CASE WHEN e.gender = 'Male' THEN 'default_male.jpg' ELSE 'default_female.jpg' END
                        ELSE e.profile_picture
                    END AS profile_picture,
                    COALESCE(kpi.nilai_kpi,0) AS nilai_kpi,
                    -- master_kpi.id AS id_poin_kpi,
                    kpi.poin_kpi AS poin_kpi,
                    COALESCE(kpi.target,'') AS target,
                    COALESCE(kpi.aktual,'') AS aktual,
                    COALESCE(kpi.achieve,'') AS achieve,
                    COALESCE(kpi.bobot,'') AS bobot,
                    COALESCE(kpi.nilai,'') AS nilai
                
                
                FROM xin_employees e
                LEFT JOIN xin_companies cmp ON cmp.company_id = e.company_id
                LEFT JOIN xin_departments dep ON dep.department_id = e.department_id
                LEFT JOIN xin_designations dsg ON dsg.designation_id = e.designation_id
                LEFT JOIN (
                    SELECT
                        kpi.id_user,
                        COALESCE(kpi.periode,'') AS periode,
                        d.department_name AS department,
                        ds.designation_name AS designation,
                        c.`name` AS company,
                        kpi.nilai_kpi,
                        COALESCE(kpi.evaluasi,'') AS evaluasi,
                        item.poin_kpi AS poin_kpi,
                        item.target,
                        item.aktual,
                        item.achieve,
                        item.bobot,
                        item.nilai
                    FROM trusmi_kpi kpi 
                    LEFT JOIN xin_departments d ON d.department_id = kpi.department
                    LEFT JOIN xin_designations ds ON ds.designation_id = kpi.designation
                    LEFT JOIN xin_companies c ON c.company_id = kpi.company
                    LEFT JOIN trusmi_kpi_item item ON item.id_kpi = kpi.id_kpi
                    WHERE kpi.id_user = $user_id
                    AND kpi.periode = '$periode'
                ) kpi ON kpi.id_user = e.user_id
                WHERE e.user_id = $user_id";
        return $this->db->query($query);
    }


}
