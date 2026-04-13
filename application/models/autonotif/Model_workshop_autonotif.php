<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_workshop_autonotif extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function check_workshop_reminder()
    {
        $sql = "SELECT workshop_id FROM `workshop_task` WHERE DATE(workshop_at) = CURRENT_DATE AND is_reminder IS NULL";
        return $this->db->query($sql)->result();
    }

    function get_workshop_title($workshop_id)
    {
        $query = "SELECT
                        w.workshop_id,
                        w.title_name,
                        IF(w.trainer_id IS NULL, w.trainer_name, CONCAT(u.first_name,' ',u.last_name)) AS trainer_name,
                        t.`name` AS type_name,
                        CONCAT(CASE DAYOFWEEK(w.workshop_at)
                                WHEN 1 THEN 'Minggu'
                                    WHEN 2 THEN 'Senin'
                                        WHEN 3 THEN 'Selasa'
                                            WHEN 4 THEN 'Rabu'
                                                WHEN 5 THEN 'Kamis'
                                                    WHEN 6 THEN 'Jumat'
                                                        WHEN 7 THEN 'Sabtu'
                                END,', ', DATE_FORMAT(w.workshop_at,'%d %b %Y')) AS tanggal,
                        CONCAT(DATE_FORMAT(w.workshop_at,'%H:%i'), ' WIB - Selesai') AS jam,
                        w.workshop_place AS tempat                    
                    FROM
                    `workshop_task` w
                    LEFT JOIN workshop_type t ON t.type_id = w.type_id
                    LEFT JOIN xin_departments d ON FIND_IN_SET(d.department_id,w.department_id)
                    LEFT JOIN xin_companies c ON c.company_id = d.company_id
                    LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,w.participant_plan)
                    LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id 
                    LEFT JOIN xin_employees ea ON FIND_IN_SET(ea.user_id,w.participant_actual)
                    LEFT JOIN xin_employees u ON u.user_id = w.trainer_id
                    LEFT JOIN xin_employees ee ON ee.user_id = w.created_by
                    WHERE w.workshop_id = '$workshop_id'
                    GROUP BY w.workshop_id";

        return $this->db->query($query)->row();
    }


    function get_workshop_list_participant($workshop_id)
    {
        $query = "SELECT
                    CONCAT(e.first_name, ' ', e.last_name, ' (',c.`name`,' - ',d.department_name,')') AS participan_name,
                    e.contact_no
                FROM
                `workshop_task` w
                LEFT JOIN workshop_type t ON t.type_id = w.type_id
                LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,w.participant_plan)
                LEFT JOIN xin_departments d ON d.department_id = e.department_id
                LEFT JOIN xin_companies c ON c.company_id = d.company_id
                LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id 
                WHERE w.workshop_id = '$workshop_id'
                ORDER BY CONCAT(e.first_name, ' ', e.last_name)";

        return $this->db->query($query)->result();
    }

    function update_reminder($workshop_id)
    {
        $data = [
            'is_reminder' => 1
        ];
        return $this->db->where('workshop_id', $workshop_id)->update('workshop_task', $data);
    }
}
