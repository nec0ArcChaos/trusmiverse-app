<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Marketing extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function auto_non_aktif_mkt()
    {
        // Marketing yang tidak absen lebih dari 3x berturut-turut dalam 5 hari terakhir (tanpa input izin di menu manage leave) maka akun absen mkt akan auto non aktif!
        $this->load->database();
        $get_mkt = $this->db->query("SELECT x.user_id, x.employee_name, x.spv, x.manager, x.gm, x.absen, x.tdk_absen FROM (
            SELECT 
                                m.user_id,
                                m.employee_name,
                                m.spv,
                                m.manager,
                                m.gm,
                                TIMESTAMPDIFF(DAY,CURRENT_DATE - INTERVAL 10 DAY,CURRENT_DATE - INTERVAL 1 DAY) + 1  AS harus_absen,
                                SUM(IF(att.clock_in IS NULL AND att.clock_out IS NULL AND a.leave_type_id IS NULL, 0,1)) AS absen,
                                SUM(IF(att.clock_in IS NULL AND att.clock_out IS NULL AND a.leave_type_id IS NULL, 1,0)) AS tdk_absen 
                                FROM
                                (		
                                    SELECT 
                                            a.attendance_date, 
                                            employee.*
                                    FROM 
                                    (
                                        SELECT
                                        attendance_date 
                                        FROM
                                        xin_attendance_time 
                                        WHERE
                                        SUBSTR( attendance_date, 1, 7 ) = SUBSTR( CURRENT_DATE, 1, 7 ) 
                                        AND attendance_date BETWEEN ( CURRENT_DATE - INTERVAL 10 DAY ) 
                                        AND ( CURRENT_DATE - INTERVAL 1 DAY ) 
                                        GROUP BY
                                        attendance_date
                                    ) AS a, 
                                    (
                                        SELECT 
                                            e.user_id, 
                                            CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                                            spv.employee_name AS spv,
                                            manager.employee_name AS manager,
                                            COALESCE(gm.employee_name,'-') AS gm
                                        FROM xin_employees e 
                                        LEFT JOIN rsp_project_live.`user` u ON u.join_hr = e.user_id
                                        LEFT JOIN rsp_project_live.`user` spv ON spv.id_user = u.spv
                                        LEFT JOIN rsp_project_live.`user` manager ON manager.id_user = spv.id_manager
                                        LEFT JOIN rsp_project_live.`user` gm ON gm.id_user = manager.id_gm
                                        WHERE e.is_active = 1 AND e.department_id = 120 AND u.isActive = 1 AND u.id_user != u.id_gm AND u.id_user != u.id_manager AND u.id_user != u.spv
                                    ) AS employee
                                ) AS m
                            LEFT JOIN xin_attendance_time att ON att.employee_id = m.user_id AND m.attendance_date = att.attendance_date
                            LEFT JOIN xin_leave_applications a ON a.employee_id = m.user_id AND m.attendance_date >= DATE( a.from_date ) AND m.attendance_date <= DATE( a.to_date ) AND a.status IN (4,2)
                            GROUP BY m.user_id
                                            ) x WHERE x.tdk_absen > 10 AND x.user_id NOT IN (SELECT id_hr FROM `view_absen_lock` WHERE `status` = 0)");

        $non_aktif_counter = 0;
        if ($get_mkt->num_rows() > 0) {
            $data_mkt = $get_mkt->result();
            foreach ($data_mkt as $row) {
                $user_id = $row->user_id;
                $akun_mkt = array(
                    'is_active' => 0,
                    'auto_non_active' => 1,
                    'auto_non_active_at' => date("Y-m-d H:i:s"),
                );
                $update = $this->db->where('user_id', $user_id)->update('xin_employees', $akun_mkt);
                $akun_mkt_rsp = array(
                    'isActive' => 0,
                    'auto_non_active_at' => date("Y-m-d H:i:s"),
                );
                $update_rsp = $this->db->where('join_hr', $user_id)->update('rsp_project_live.`user`', $akun_mkt_rsp);
                if ($update) {
                    $non_aktif_counter += 1;
                }
            }
            $response['data_mkt'] = $get_mkt->result();
        }

        $response['non_aktif_counter'] = $non_aktif_counter;
        $response['num_rows'] = $get_mkt->num_rows();
        echo json_encode($response);
    }
}
