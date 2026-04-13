<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_leave extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function get_leave_type()
    {
        $user_id = $this->session->userdata('user_id');
        if ((int)date("d") <= 20) {
            $periode = (int)date("m");
        } else {
            $periode = (int)date("m") + 1;
        }

        $cek_masa_kerja = $this->db->query("SELECT TIMESTAMPDIFF(MONTH,e.date_of_joining,CURRENT_DATE) AS masa_kerja FROM xin_employees e WHERE user_id = '$user_id'")->row_array();
        if ($cek_masa_kerja['masa_kerja'] < 12) {
            // if (date('Y-m-d') <= date('Y-03-20')) {
            //     $leave_custom = '1';
            // } else {
            $leave_custom = '1,19';
            // }
            $cond = "AND lt.leave_type_id NOT IN (SELECT leave_type_id FROM xin_leave_type WHERE leave_type_id IN ($leave_custom))"; // jika belum setahun cuti tidak tampil
        // } else  if ($cek_masa_kerja['masa_kerja'] >= 12 && $cek_masa_kerja['masa_kerja'] < 14) {
        //     $leave_custom = '19';
        //     $cond = "AND lt.leave_type_id NOT IN (SELECT leave_type_id FROM xin_leave_type WHERE leave_type_id IN ($leave_custom))"; // jika belum setahun cuti tidak tampil
        } else {
            $cond = "";
        }
        if ($user_id) {
            $query = "SELECT
                        lt.leave_type_id,
                        lt.type_name,
                        COALESCE(lt.warning,'') AS warning,
                        (lt.days_per_year*1) AS days_per_year,
                        COALESCE(((COALESCE(x.jml_hari,0) / (lt.days_per_year*1)) * 100),0) AS persen,
                        COALESCE(CASE WHEN lt.leave_type_id = 19 THEN 
                            last_year_cuti.jml_cuti
                        ELSE
                            COALESCE(x.jml_hari,0) 
                        END,0) AS jml_hari,
                        COALESCE(CASE WHEN lt.leave_type_id = 19 THEN 
                            last_year_cuti.sisa_cuti
                        ELSE
                        (lt.days_per_year*1) - COALESCE(x.jml_hari,0) END,0) AS sisa_izin,
                        CASE WHEN COALESCE(((COALESCE(x.jml_hari,0) / (lt.days_per_year*1)) * 100),0) >= 75 THEN
                                'bg-danger'
                        WHEN COALESCE(((COALESCE(x.jml_hari,0) / (lt.days_per_year*1)) * 100),0) >= 50 THEN
                            'bg-warning'
                        ELSE
                            'bg-primary'
                        END AS style
                    FROM
                    xin_employees e
                    LEFT JOIN xin_leave_type lt ON FIND_IN_SET( lt.leave_type_id, e.leave_categories ) AND lt.leave_type_id != 14
                    LEFT JOIN 
                    (
                            SELECT
                                la.periode,
                                la.employee_id,
                                la.leave_type_id,
                                la.to_date,
                                SUM(la.jml_hari) AS jml_hari
                                FROM
                                (
                                        SELECT
                                            CASE WHEN DAY(from_date) <= 20 THEN MONTH(from_date)
                                            ELSE IF(MONTH(from_date) + 1 = 13, 1, MONTH(from_date) + 1) END periode,
                                            la.employee_id,
                                            from_date,
                                            to_date,
                                            la.leave_type_id,
                                            TIMESTAMPDIFF(DAY,from_date,to_date) + 1 AS jml_hari
                                        FROM
                                            xin_leave_applications la
                                        WHERE
                                            employee_id = '$user_id' AND 
                                            SUBSTR(from_date,1,4) = YEAR(CURRENT_DATE) AND la.`status` = 2 
                                            -- AND CASE WHEN DAY(from_date) <= 20 THEN MONTH(from_date) ELSE IF(MONTH(from_date) + 1 = 13, 1, MONTH(from_date) + 1) END = '$periode'
                                ) AS la 
                            LEFT JOIN xin_leave_type lt ON lt.leave_type_id = la.leave_type_id
                            GROUP BY la.leave_type_id
                            -- , la.periode
                    ) AS x ON x.leave_type_id = lt.leave_type_id
                    LEFT JOIN (
                        SELECT 
                            e.user_id AS employee_id, 
                            COALESCE(SUM(lc.jml_cuti),0) AS jml_cuti,
                            IF(TIMESTAMPDIFF(YEAR,e.date_of_joining ,CURRENT_DATE) >= 1,12,0) - COALESCE(SUM(lc.jml_cuti),0) AS sisa_cuti 
                        FROM xin_employees e
						LEFT JOIN
							(
                            SELECT
                                a.employee_id,
                                SUM(DATEDIFF(a.to_date,a.from_date)+1) AS jml_cuti
                            FROM
                                xin_leave_applications a 
                            WHERE
                                a.employee_id = '$user_id' AND leave_type_id = 1 AND SUBSTR(a.to_date,1,4) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) AND a.`status` = 2
                                GROUP BY a.employee_id
                                UNION ALL
                            SELECT
                                b.employee_id,
                                SUM(DATEDIFF(b.to_date,b.from_date)+1) AS jml_cuti
                            FROM
                                xin_leave_applications b 
                            WHERE
                                b.employee_id = '$user_id' AND b.leave_type_id = 19 AND SUBSTR(b.to_date,1,4) = YEAR(CURDATE()) AND b.`status` = 2
                                GROUP BY b.employee_id
                        ) AS lc ON e.user_id = lc.employee_id
						WHERE e.user_id = '$user_id'
                    ) AS last_year_cuti ON last_year_cuti.employee_id = e.user_id
                WHERE
                    user_id = '$user_id' $cond
                ORDER BY lt.type_name";

                // echo "<pre>".$query."</pre>";
                // die();
            return $this->db->query($query)->result();
        }
        return false;
    }


    public function get_leave_type_detail($user_id)
    {
        if ((int)date("d") <= 20) {
            $periode = (int)date("m");
        } else {
            $periode = (int)date("m") + 1;
        }

        $cek_masa_kerja = $this->db->query("SELECT TIMESTAMPDIFF(MONTH,e.date_of_joining,CURRENT_DATE) AS masa_kerja FROM xin_employees e WHERE user_id = '$user_id'")->row_array();
        if ($cek_masa_kerja['masa_kerja'] < 12) {
            if (date('Y-m-d') <= date('Y-03-20')) {
                $leave_custom = '1,14';
            } else {
                $leave_custom = '1,19,14';
            }
            $cond = "AND lt.leave_type_id NOT IN (SELECT leave_type_id FROM xin_leave_type WHERE leave_type_id IN ($leave_custom))"; // jika belum setahun cuti tidak tampil
        } else {
            $cond = "";
        }
        if ($user_id) {
            $query = "SELECT
                        lt.leave_type_id,
                        lt.type_name,
                        COALESCE(lt.warning,'') AS warning,
                        (lt.days_per_year*1) AS days_per_year,
                        COALESCE(((COALESCE(x.jml_hari,0) / (lt.days_per_year*1)) * 100),0) AS persen,
                        COALESCE(CASE WHEN lt.leave_type_id = 19 THEN 
                            last_year_cuti.jml_cuti
                        ELSE
                            COALESCE(x.jml_hari,0) 
                        END,0) AS jml_hari,
                        COALESCE(CASE WHEN lt.leave_type_id = 19 THEN 
                            last_year_cuti.sisa_cuti
                        ELSE
                        (lt.days_per_year*1) - COALESCE(x.jml_hari,0) END,0) AS sisa_izin,
                        CASE WHEN COALESCE(((COALESCE(x.jml_hari,0) / (lt.days_per_year*1)) * 100),0) >= 75 THEN
                                'bg-danger'
                        WHEN COALESCE(((COALESCE(x.jml_hari,0) / (lt.days_per_year*1)) * 100),0) >= 50 THEN
                            'bg-warning'
                        ELSE
                            'bg-primary'
                        END AS style
                    FROM
                    xin_employees e
                    LEFT JOIN xin_leave_type lt ON FIND_IN_SET( lt.leave_type_id, e.leave_categories ) AND lt.leave_type_id != 14
                    LEFT JOIN 
                    (
                            SELECT
                                la.periode,
                                la.employee_id,
                                la.leave_type_id,
                                la.to_date,
                                SUM(la.jml_hari) AS jml_hari
                                FROM
                                (
                                        SELECT
                                            CASE WHEN DAY(from_date) <= 20 THEN MONTH(from_date)
                                            ELSE IF(MONTH(from_date) + 1 = 13, 1, MONTH(from_date) + 1) END periode,
                                            la.employee_id,
                                            from_date,
                                            to_date,
                                            la.leave_type_id,
                                            TIMESTAMPDIFF(DAY,from_date,to_date) + 1 AS jml_hari
                                        FROM
                                            xin_leave_applications la
                                        WHERE
                                            employee_id = '$user_id' AND 
                                            SUBSTR(from_date,1,4) = YEAR(CURRENT_DATE) AND la.`status` = 2 
                                            -- AND CASE WHEN DAY(from_date) <= 20 THEN MONTH(from_date) ELSE IF(MONTH(from_date) + 1 = 13, 1, MONTH(from_date) + 1) END = '$periode'
                                ) AS la 
                            LEFT JOIN xin_leave_type lt ON lt.leave_type_id = la.leave_type_id
                            GROUP BY la.leave_type_id
                            -- , la.periode
                    ) AS x ON x.leave_type_id = lt.leave_type_id
                    LEFT JOIN (
                        SELECT 
                            e.user_id AS employee_id, 
                            COALESCE(SUM(lc.jml_cuti),0) AS jml_cuti,
                            IF(TIMESTAMPDIFF(YEAR,e.date_of_joining ,CURRENT_DATE) >= 1,12,0) - COALESCE(SUM(lc.jml_cuti),0) AS sisa_cuti 
                        FROM xin_employees e
						LEFT JOIN
							(
                            SELECT
                                a.employee_id,
                                SUM(DATEDIFF(a.to_date,a.from_date)+1) AS jml_cuti
                            FROM
                                xin_leave_applications a 
                            WHERE
                                a.employee_id = '$user_id' AND leave_type_id = 1 AND SUBSTR(a.to_date,1,4) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) AND a.`status` = 2
                                GROUP BY a.employee_id
                                UNION ALL
                            SELECT
                                b.employee_id,
                                SUM(DATEDIFF(b.to_date,b.from_date)+1) AS jml_cuti
                            FROM
                                xin_leave_applications b 
                            WHERE
                                b.employee_id = '$user_id' AND b.leave_type_id = 19 AND SUBSTR(b.to_date,1,4) = YEAR(CURDATE()) AND b.`status` = 2
                                GROUP BY b.employee_id
                        ) AS lc ON e.user_id = lc.employee_id
						WHERE e.user_id = '$user_id'
                    ) AS last_year_cuti ON last_year_cuti.employee_id = e.user_id
                WHERE
                    user_id = '$user_id' $cond
                ORDER BY lt.type_name";
            return $this->db->query($query)->result();
        }
        return false;
    }


    public function get_statistic_leave($employee_id)
    {
        $user_id = $employee_id;
        if ((int)date("d") <= 20) {
            $periode = (int)date("m");
        } else {
            $periode = (int)date("m") + 1;
        }
        if ($user_id) {
            $query = "SELECT
                    lt.leave_type_id,
                    lt.type_name,
                    COALESCE(lt.warning,'') AS warning,
                    (lt.days_per_year*1) AS days_per_year,
                    COALESCE(((COALESCE(x.jml_hari,0) / (lt.days_per_year*1)) * 100),0) AS persen,
                    CASE WHEN lt.leave_type_id = 19 THEN 
                        last_year_cuti.jml_cuti
                    ELSE
                    COALESCE(x.jml_hari,0) END AS jml_hari,
                    CASE WHEN lt.leave_type_id = 19 THEN 
                        last_year_cuti.sisa_cuti
                    ELSE (lt.days_per_year*1) - COALESCE(x.jml_hari,0) END  AS sisa_izin,
                    CASE WHEN COALESCE(((COALESCE(x.jml_hari,0) / (lt.days_per_year*1)) * 100),0) >= 75 THEN
                            'bg-danger'
                            WHEN COALESCE(((COALESCE(x.jml_hari,0) / (lt.days_per_year*1)) * 100),0) >= 50 THEN
                            'bg-warning'
                        ELSE
                            'bg-primary'
                    END AS style
                FROM
                    xin_employees e
                    LEFT JOIN xin_leave_type lt ON FIND_IN_SET( lt.leave_type_id, e.leave_categories )
                    LEFT JOIN 
                    (
                                SELECT
                                la.periode,
                                la.employee_id,
                                la.leave_type_id,
                                la.to_date,
                                SUM(la.jml_hari) AS jml_hari
                                FROM
                                (
                                        SELECT
                                            CASE WHEN DAY(from_date) <= 20 THEN MONTH(from_date)
                                            ELSE IF(MONTH(from_date) + 1 = 13, 1, MONTH(from_date) + 1) END periode,
                                            la.employee_id,
                                            from_date,
                                            to_date,
                                            la.leave_type_id,
                                            TIMESTAMPDIFF(DAY,from_date,to_date) + 1 AS jml_hari
                                        FROM
                                            xin_leave_applications la
                                        WHERE
                                            employee_id = '$user_id' AND 
                                            SUBSTR(from_date,1,4) = YEAR(CURRENT_DATE) AND la.`status` = 2
                                ) AS la 
                            LEFT JOIN xin_leave_type lt ON lt.leave_type_id = la.leave_type_id
                            GROUP BY la.leave_type_id
                    ) AS x ON x.leave_type_id = lt.leave_type_id
                    LEFT JOIN (
                        SELECT 
                            lc.employee_id, 
                            SUM(lc.jml_cuti) AS jml_cuti,
                            IF(TIMESTAMPDIFF(YEAR,e.date_of_joining ,CURRENT_DATE) >= 1,12,0) - SUM(lc.jml_cuti) AS sisa_cuti 
                        FROM(
                            SELECT
                                a.employee_id,
                                SUM(DATEDIFF(a.to_date,a.from_date)+1) AS jml_cuti
                            FROM
                                xin_leave_applications a 
                            WHERE
                                a.employee_id = '$user_id' AND leave_type_id = 1 AND SUBSTR(a.to_date,1,4) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) AND a.`status` = 2
                                GROUP BY a.employee_id
                                UNION ALL
                            SELECT
                                b.employee_id,
                                SUM(DATEDIFF(b.to_date,b.from_date)+1) AS jml_cuti
                            FROM
                                xin_leave_applications b 
                            WHERE
                                b.employee_id = '$user_id' AND b.leave_type_id = 19 AND SUBSTR(b.to_date,1,4) = YEAR(CURDATE()) AND b.`status` = 2
                                GROUP BY b.employee_id
                        ) AS lc
                        LEFT JOIN xin_employees e ON e.user_id = lc.employee_id
                    ) AS last_year_cuti ON last_year_cuti.employee_id = e.user_id
                WHERE
                    user_id = '$user_id'
                ORDER BY lt.type_name";
            return $this->db->query($query)->result();
        }
        return false;
    }


    public function get_user($user_id)
    {
        $query = "SELECT e.user_id, CONCAT( e.first_name, ' ', e.last_name ) AS employee_name, e.company_id, c.`name` AS company_name, e.department_id, d.department_name 
    FROM
        xin_employees e
        LEFT JOIN xin_companies c ON c.company_id = e.company_id
        LEFT JOIN xin_departments d ON d.department_id = e.department_id 
    WHERE
        user_id = $user_id";
        return $this->db->query($query)->row_array();
    }

    public function get_detail_leave($leave_id)
    {
        $query = "SELECT
                l.leave_id,
                l.leave_type_id,
                l.employee_id,
                COALESCE(CONCAT(c.first_name, ' ', c.last_name),'') AS employee_name,
                cp.name AS company_name,
                dp.department_name,
                DATE_FORMAT(l.applied_on, '%d-%m-%Y') AS applied_on_2,
                DATE_FORMAT(l.applied_on, '%d %M %Y') AS applied_on,
                t.type_name,
                CONCAT(l.from_date,' ', COALESCE(l.start_time,'')) AS `start_date`,
                CONCAT(l.to_date,' ', COALESCE(l.end_time,''))  AS `end_date`,
                DATE_FORMAT(l.from_date, '%d-%m-%Y') AS from_date,
                DATE_FORMAT(l.to_date, '%d-%m-%Y') AS to_date,
                IF(l.tgl_ph is not null, DATE_FORMAT(l.tgl_ph, '%d-%m-%Y'),'') AS tgl_ph,
                DATEDIFF(l.from_date, l.to_date) + 1 AS total_day,
                l.reason,
                COALESCE(l.remarks,'') AS remarks,
                COALESCE(l.leave_attachment,'') AS leave_attachment,
                COALESCE(l.approved_at,'') AS approved_at,
                COALESCE(CONCAT(e.first_name, ' ', e.last_name),'') AS approved_by,
                l.`status` AS id_status,
                CASE WHEN l.`status` = 1 THEN 'bg-warning' 
                WHEN l.`status` =  4 THEN 'bg-primary' 
                WHEN l.`status` =  2 THEN 'bg-success' 
                WHEN l.`status` =  3 THEN 'bg-danger' 
                ELSE 'bg-warning' END AS `bg_status`,
                CASE WHEN l.`status` = 1 THEN 'Pending' 
                WHEN l.`status` =  4 THEN 'First Level Approval' 
                WHEN l.`status` =  2 THEN 'Approved' 
                WHEN l.`status` =  3 THEN 'Reject' 
                ELSE '' END AS `status`
            FROM
                xin_leave_applications l
            LEFT JOIN xin_leave_type t ON t.leave_type_id = l.leave_type_id
            LEFT JOIN xin_employees c ON c.user_id = l.employee_id
            LEFT JOIN xin_companies cp ON cp.company_id = c.company_id
            LEFT JOIN xin_departments dp ON dp.department_id = c.department_id
            LEFT JOIN xin_employees e ON e.user_id = l.approved_by
            WHERE l.leave_id = '$leave_id'
            ORDER BY SUBSTR(l.from_date,1,10) DESC";
        return $this->db->query($query)->row_array();
    }

    public function get_last_detail_leave($leave_id)
    {
        $data_employee = $this->db->query("SELECT a.employee_id FROM xin_leave_applications a WHERE a.leave_id = '$leave_id'")->row();
        $employee_id = $data_employee->employee_id;
        $query = "SELECT
                l.leave_id,
                l.leave_type_id,
                l.employee_id,
                COALESCE(CONCAT(c.first_name, ' ', c.last_name),'') AS employee_name,
                cp.name AS company_name,
                dp.department_name,
                DATE_FORMAT(l.applied_on, '%d-%m-%Y') AS applied_on_2,
                DATE_FORMAT(l.applied_on, '%d %M %Y') AS applied_on,
                t.type_name,
                l.from_date AS `start_date`,
                l.to_date AS `end_date`,
                DATE_FORMAT(l.from_date, '%d-%m-%Y') AS from_date,
                DATE_FORMAT(l.to_date, '%d-%m-%Y') AS to_date,
                IF(l.tgl_ph is not null, DATE_FORMAT(l.tgl_ph, '%d-%m-%Y'),'') AS tgl_ph,
                DATEDIFF(l.to_date,l.from_date) + 1 AS total_day,
                l.reason,
                l.remarks,
                l.leave_attachment,
                COALESCE(l.approved_at,'') AS approved_at,
                COALESCE(CONCAT(e.first_name, ' ', e.last_name),'') AS approved_by,
                l.`status` AS id_status,
                CASE WHEN l.`status` = 1 THEN 'bg-warning' 
                WHEN l.`status` =  4 THEN 'bg-primary' 
                WHEN l.`status` =  2 THEN 'bg-success' 
                WHEN l.`status` =  3 THEN 'bg-danger' 
                ELSE 'bg-warning' END AS `bg_status`,
                CASE WHEN l.`status` = 1 THEN 'Pending' 
                WHEN l.`status` =  4 THEN 'First Level Approval' 
                WHEN l.`status` =  2 THEN 'Approved' 
                WHEN l.`status` =  3 THEN 'Reject' 
                ELSE '' END AS `status`
            FROM
                xin_leave_applications l
            LEFT JOIN xin_leave_type t ON t.leave_type_id = l.leave_type_id
            LEFT JOIN xin_employees c ON c.user_id = l.employee_id
            LEFT JOIN xin_companies cp ON cp.company_id = c.company_id
            LEFT JOIN xin_departments dp ON dp.department_id = c.department_id
            LEFT JOIN xin_employees e ON e.user_id = l.approved_by
            WHERE l.leave_id != '$leave_id' AND l.employee_id = '$employee_id'
            ORDER BY SUBSTR(l.from_date,1,10) DESC LIMIT 1";
        return $this->db->query($query)->row_array();
    }

    public function get_kota()
    {
        $data = $this->db->query("SELECT
		trusmi_kota.id,
		trusmi_kota.state_id,
		trusmi_kota.city,
		trusmi_kota.zona,
		trusmi_provinsi.state 
		FROM
		trusmi_kota
		JOIN trusmi_provinsi ON trusmi_kota.state_id = trusmi_provinsi.state_id")->result();

        return $data;
    }

    public function add_leave_record($data)
    {
        $this->db->insert('xin_leave_applications', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function cek_leave($user_id, $start, $end, $type)
    {
        $data = $this->db->query("SELECT
			COALESCE( SUM( DATEDIFF( xin_leave_applications.to_date, xin_leave_applications.from_date ) + 1 ), 0 ) AS total
			FROM
			xin_leave_applications 
			WHERE
			xin_leave_applications.employee_id = $user_id 
			AND xin_leave_applications.leave_type_id IN $type
			AND xin_leave_applications.`status` IN (1,2)
			AND from_date BETWEEN '$start' 
			AND '$end'")->row_array();

        return $data['total'];
    }

    public function cek_driver($user_id, $start, $end)
    {
        return $this->db->query("SELECT
		IF ( SUM( DATE_FORMAT( TIMEDIFF( CONCAT( to_date, ' ', end_time ), CONCAT( from_date, ' ', start_time ) ), '%k' ) - IF ( xin_leave_applications.employee_id IN ( 64, 14 ), 9, 11 )  ) >= IF ( xin_leave_applications.employee_id IN ( 64, 14 ), 9, 11 ), 1, 0 ) AS driver,
		IF ( xin_leave_applications.employee_id IN ( 64, 14 ), 9, 11 ) AS max_work
		FROM
		xin_leave_applications 
		WHERE
		xin_leave_applications.employee_id = $user_id 
		AND xin_leave_applications.leave_type_id = 23 
		AND xin_leave_applications.`status` = 2 
		AND xin_leave_applications.from_date BETWEEN '$start' 
		AND '$end'")->row_array();
    }
}
