<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_workshop extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_workshop_type()
    {
        return $this->db->query("SELECT type_id, `name` AS type_name FROM `workshop_type`")->result();
    }

    function get_department()
    {
        return $this->db->query("SELECT
                                    d.department_id,
                                    CONCAT( d.department_name, ' | ', c.`name` ) AS department_name,
                                    COUNT(e.department_id) AS jml_karyawan
                                FROM
                                    `xin_departments` d
                                    LEFT JOIN xin_companies c ON c.company_id = d.company_id
                                    LEFT JOIN xin_employees e ON e.department_id = d.department_id AND e.is_active = 1
                                GROUP BY d.department_id
                                HAVING COUNT(e.department_id) > 0
                                ORDER BY
                                    d.department_name")->result();
    }

    function get_materi()
    {
        return $this->db->query("SELECT
                                    id AS title_id,
                                    training AS title_name
                                FROM
                                    `trusmi_materi_training` 
                                WHERE
                                    (jenis = 10 OR `type` = 'Assignment')")->result();
    }

    function get_participant()
    {
        $department_id = $this->input->post('department_id');
        if (strpos($department_id, 'all') !== false) {
            // do something
            $cond = "";
        } else {
            $cond = "AND e.department_id IN ($department_id)";
        }
        // if ($department_id == "all") {
        //     $cond = "";
        // }
        return $this->db->query("SELECT
            e.user_id AS participant_plan,
            CONCAT(e.first_name,' ',e.last_name, ' - ',d.department_name, ' - ',ds.designation_name) AS participant_name 
        FROM `xin_employees` e 
        LEFT JOIN xin_departments d ON d.department_id = e.department_id
        LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
        WHERE e.user_id != 1 AND e.is_active = 1 $cond ORDER BY CONCAT(e.first_name,' ',e.last_name)")->result();
    }

    function get_trainer()
    {
        return $this->db->query("SELECT
            e.user_id AS trainer_id,
            CONCAT(e.first_name,' ',e.last_name) AS trainer_name,
            CONCAT(e.first_name,' ',e.last_name, ' - ',d.department_name, ' - ',ds.designation_name) AS trainer
        FROM `xin_employees` e
        LEFT JOIN xin_departments d ON d.department_id = e.department_id
        LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
        WHERE e.user_id != 1 AND e.is_active = 1 ORDER BY CONCAT(e.first_name,' ',e.last_name)")->result();
    }

    function dt_workshop($start, $end)
    {
        $query = "SELECT
                    w.workshop_id,
                    w.`status`,
                    w.type_id,
                    COALESCE(w.commitment,'') AS commitment,
                    COALESCE(w.documentation,'') AS documentation,
                    t.`name` AS type_name,
                    w.department_id,
                    COALESCE(GROUP_CONCAT(DISTINCT c.`name`, ' - ', d.department_name ORDER BY c.`name`, d.department_name),'') AS department_name,
                    COALESCE(w.participant_plan,'') AS participant_plan,
                    COALESCE(GROUP_CONCAT(DISTINCT e.first_name, ' ', e.last_name ORDER BY CONCAT(e.first_name, ' ', e.last_name)),'') AS participant_plan_name,
                    COALESCE(GROUP_CONCAT(ds.designation_name),'') AS participant_designation_name,
                    COALESCE(GROUP_CONCAT(e.profile_picture),'') AS profile_picture_participant_plan,
                    COALESCE(w.participant_actual,'') AS participant_actual,
                    COALESCE(GROUP_CONCAT(DISTINCT ea.first_name, ' ', ea.last_name ORDER BY CONCAT(ea.first_name, ' ', ea.last_name)),'') AS participant_actual_name,
                    COALESCE(GROUP_CONCAT(ea.profile_picture),'') AS profile_picture_participant_actual,
                    w.source,
                    w.trainer_id,
                    IF(w.trainer_id IS NULL, w.trainer_name, CONCAT(u.first_name,' ',u.last_name)) AS trainer_name,
                    w.title_name,
                    DATE(w.workshop_at) AS workshop_at,
                    DATE_FORMAT(w.workshop_at, '%H:%i') AS workshop_time,
                    w.created_at,
                    w.created_by,
                    CONCAT(ee.first_name,' ', ee.last_name) AS created_by_name
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
                WHERE SUBSTR(w.workshop_at,1,10) BETWEEN '$start' AND '$end'
                GROUP BY w.workshop_id
        ";

        return $this->db->query($query)->result();
    }

    function dt_workshop_optimasi($start, $end)
    {
        $query = "SELECT
                    w.workshop_id,
                    w.`status`,
                    w.type_id,
                    COALESCE(w.commitment,'') AS commitment,
                    COALESCE(w.documentation,'') AS documentation,
                    t.`name` AS type_name,
                    w.department_id,
                    COALESCE(GROUP_CONCAT(DISTINCT c.`name`, ' - ', d.department_name ORDER BY c.`name`, d.department_name),'') AS department_name,
                    COALESCE(w.participant_plan,'') AS participant_plan,
                    e.participant_plan_name,
                    e.participant_designation_name,
                    COALESCE(w.participant_actual,'') AS participant_actual,
                    COALESCE(ea.participant_actual_name,'') AS participant_actual_name,
                    w.source,
                    w.trainer_id,
                    IF(w.trainer_id IS NULL, w.trainer_name, CONCAT(u.first_name,' ',u.last_name)) AS trainer_name,
                    w.title_name,
                    DATE(w.workshop_at) AS workshop_at,
                    DATE_FORMAT(w.workshop_at, '%H:%i') AS workshop_time,
                    w.created_at,
                    w.created_by,
                    CONCAT(ee.first_name,' ', ee.last_name) AS created_by_name
                FROM
                `workshop_task` w
                LEFT JOIN workshop_type t ON t.type_id = w.type_id
                LEFT JOIN xin_departments d ON FIND_IN_SET(d.department_id,w.department_id)
                LEFT JOIN xin_companies c ON c.company_id = d.company_id
                LEFT JOIN (
										SELECT
											w.workshop_id,
											w.participant_plan,
											GROUP_CONCAT( e.first_name, ' ', e.last_name ORDER BY e.first_name) AS participant_plan_name,
											GROUP_CONCAT(DISTINCT ds.designation_name ORDER BY ds.designation_name) AS participant_designation_name
										FROM
											workshop_task w
											LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, w.participant_plan ) 
											LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
											WHERE SUBSTR(w.workshop_at,1,10) BETWEEN '$start' AND '$end'
										GROUP BY
											w.workshop_id
								) e ON e.workshop_id = w.workshop_id
                LEFT JOIN (
									SELECT
										w.workshop_id,
										w.participant_actual,
										GROUP_CONCAT( e.first_name, ' ', e.last_name ORDER BY e.first_name) AS participant_actual_name,
										GROUP_CONCAT(DISTINCT ds.designation_name ORDER BY ds.designation_name) AS participant_designation_name
									FROM
										workshop_task w
										LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, w.participant_actual ) 
										LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
										WHERE SUBSTR(w.workshop_at,1,10) BETWEEN '$start' AND '$end'
									GROUP BY
										w.workshop_id
								) ea ON ea.workshop_id = w.workshop_id
                LEFT JOIN xin_employees u ON u.user_id = w.trainer_id
                LEFT JOIN xin_employees ee ON ee.user_id = w.created_by
                WHERE SUBSTR(w.workshop_at,1,10) BETWEEN '$start' AND '$end'
                GROUP BY w.workshop_id
        ";

        return $this->db->query($query)->result();
    }

    function get_detail_workshop()
    {
        $workshop_id = $_POST['workshop_id'];
        $query = "SELECT
                    w.workshop_id,
                    w.`status`,
                    w.type_id,
                    w.commitment,
                    COALESCE(w.documentation,'') AS documentation,
                    t.`name` AS type_name,
                    w.department_id,
                    COALESCE(GROUP_CONCAT(DISTINCT c.`name`, ' - ', d.department_name),'') AS department_name,
                    w.participant_plan,
                    COALESCE(GROUP_CONCAT(DISTINCT e.first_name, ' ', e.last_name),'') AS participant_plan_name,
                    COALESCE(GROUP_CONCAT(DISTINCT ds.designation_name),'') AS participant_designation_name,
                    COALESCE(GROUP_CONCAT(DISTINCT e.profile_picture),'') AS profile_picture_participant_plan,
                    w.participant_actual,
                    COALESCE(GROUP_CONCAT(DISTINCT ea.first_name, ' ', ea.last_name),'') AS participant_actual_name,
                    COALESCE(GROUP_CONCAT(DISTINCT ea.profile_picture),'') AS profile_picture_participant_actual,
                    w.source,
                    w.trainer_id,
                    IF(w.trainer_id IS NULL, w.trainer_name, CONCAT(u.first_name,' ',u.last_name)) AS trainer_name,
                    w.title_name,
                    DATE(w.workshop_at) AS workshop_at,
                    DATE_FORMAT(w.workshop_at, '%H:%i') AS workshop_time,
                    w.created_at,
                    w.created_by,
                    CONCAT(ee.first_name,' ', ee.last_name) AS created_by_name
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
                GROUP BY w.workshop_id
        ";

        return $this->db->query($query)->row();
    }


    function get_workshop_title($workshop_id)
    {
        $query = "SELECT
                        w.workshop_id,
                        w.title_id,
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
                        w.workshop_place AS tempat,
                        COALESCE(w.commitment,'') AS commitment,
                        COALESCE(is_reminder,0) AS is_reminder
                 
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
                    CONCAT(e.first_name, ' ', e.last_name) AS only_name,
                    CONCAT(e.first_name, ' ', e.last_name, ' (',c.`name`,' - ',d.department_name,')') AS participant_name,
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

    function generate_id_workshop()
    {
        $q = $this->db->query("SELECT
        MAX( RIGHT ( workshop_task.workshop_id, 3 ) ) AS kd_max 
        FROM
        workshop_task 
        WHERE
        SUBSTR( workshop_task.created_at, 1, 10 ) = CURDATE( )");
        $kd = "";

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        return 'W' . date('ymd') . $kd;
    }

    function update_reminder($workshop_id)
    {
        $sql = "SELECT is_reminder FROM workshop_task WHERE workshop_id = '$workshop_id'";
        $workshop = $this->db->query($sql)->row();
        $is_reminder = $workshop->is_reminder + 1;
        $data = [
            'is_reminder' => $is_reminder
        ];
        return $this->db->where('workshop_id', $workshop_id)->update('workshop_task', $data);
    }
}
