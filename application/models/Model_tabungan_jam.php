<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_tabungan_jam extends CI_Model
{
    protected $userId;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->userId = $this->session->userdata('user_id');
    }

    function list_tabungan_jam($periode)
    {

        if (!in_array($this->userId, [1, 1784, 778, 979])) {
            $kondisi = "AND la.employee_id = $this->userId";
        } else {
            $kondisi = "";
        }

        $query = "SELECT
        la.employee_id,
        cmp.`name` AS company_name,
        dpm.department_name,
        lt.type_name AS leave_type,
        CONCAT( emp.first_name, ' ', emp.last_name ) AS nama,
        CONCAT(
            DATE_FORMAT( DATE_SUB( DATE_FORMAT( max(la.from_date), '%Y-%m-21' ), INTERVAL 2 MONTH ), '%Y %b %d' ),
            ' s/d ',
            DATE_FORMAT( DATE_ADD( DATE_FORMAT( max(la.to_date), '%Y-%m-20' ), INTERVAL 0 MONTH ), '%Y %b %d' ) 
        ) AS periode,
        GROUP_CONCAT( cuti.leave_id ) AS leave_ids,
        COUNT( cuti.leave_id ) AS total_leaves,
        COALESCE(SUM( cuti.tabungan_jam ),0) AS grand_total,
        IF(COALESCE(SUM( cuti.tabungan_jam ),0) > 10,CONCAT('Bisa ganti hari sebanyak ',ROUND(COALESCE(SUM( cuti.tabungan_jam ),0)/11),' kali'),'Belum bisa ganti hari') AS keterangan,
        DATE_FORMAT( max(la.from_date), '%Y-%m-21' ) - INTERVAL 2 MONTH AS start_periode,
        DATE_FORMAT( max(la.from_date), '%Y-%m-20' ) AS end_periode
    FROM
        `xin_leave_applications` la
        LEFT JOIN xin_employees emp ON emp.user_id = la.employee_id
        LEFT JOIN xin_companies cmp ON cmp.company_id = emp.company_id
        LEFT JOIN xin_departments dpm ON dpm.department_id = emp.department_id
        LEFT JOIN xin_leave_type lt ON lt.leave_type_id = la.leave_type_id
        LEFT JOIN (
        SELECT
            la.leave_id,
            la.employee_id,
            TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( to_date, ' ', end_time ) ) AS total_jam,
        IF
            (
                DATEDIFF( to_date, from_date ) = 0,
                GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( to_date, ' ', end_time )) - 11 ),
                (
                    GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( from_date, ' 23:59:59' )) - 11 ) + GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( to_date, ' 00:00:00' ), CONCAT( to_date, ' ', end_time )) - 11 ) + GREATEST( 0, ( DATEDIFF( to_date, from_date ) - 1 ) * ( 24 - 11 ) ) 
                ) 
            ) AS tabungan_jam 
        FROM
            `xin_leave_applications` la 
        WHERE
            la.leave_type_id = 23 
            AND la.`status` = 2 
            -- AND la.ganti_hari IS NULL 
            AND la.start_time IS NOT NULL
            AND IF
        (
            DATEDIFF( to_date, from_date ) = 0,
            GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( to_date, ' ', end_time )) - 11 ),
            (
                GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( from_date, ' 23:59:59' )) - 11 ) + GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( to_date, ' 00:00:00' ), CONCAT( to_date, ' ', end_time )) - 11 ) + GREATEST(
                    0,
                ( DATEDIFF( to_date, from_date ) - 1 ) * ( 24 - 11 )) 
            ) 
        ) > 0             
        ) cuti ON cuti.leave_id = la.leave_id 
    WHERE
        la.leave_type_id = 23 
        $kondisi
        AND la.`status` = 2 
        AND la.start_time IS NOT NULL 
        AND la.from_date BETWEEN DATE_FORMAT('$periode', '%Y-%m-21') - INTERVAL 2 MONTH AND DATE_FORMAT('$periode', '%Y-%m-20')
        -- AND la.ganti_hari IS NULL 
        AND emp.is_active = 1 
    GROUP BY
        employee_id
    ORDER BY 
		periode DESC";

        return $this->db->query($query)->result_array();
    }

    function get_leave_details($id, $start, $end)
    {
        $query = "SELECT
        la.employee_id,
        CONCAT( emp.first_name, ' ', emp.last_name ) AS nama,
        lt.type_name,
        tk.city AS kota,
        la.`status`,
        CONCAT(from_date,' ',start_time) AS start_date,
        CONCAT(to_date,' ',end_time) AS end_date,
        leave_attachment,
        reason,
        TIMESTAMPDIFF(
            HOUR,
            CONCAT( from_date, ' ', start_time ),
        CONCAT( to_date, ' ', end_time )) AS total_jam,
    IF
        (
            DATEDIFF( to_date, from_date ) = 0,
            GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( to_date, ' ', end_time )) - 11 ),
            (
                GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( from_date, ' 23:59:59' )) - 11 ) + GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( to_date, ' 00:00:00' ), CONCAT( to_date, ' ', end_time )) - 11 ) + GREATEST(
                    0,
                ( DATEDIFF( to_date, from_date ) - 1 ) * ( 24 - 11 )) 
            ) 
        ) AS tabungan_jam 
    FROM
        `xin_leave_applications` la
        LEFT JOIN xin_employees emp ON emp.user_id = la.employee_id
        LEFT JOIN xin_leave_type lt ON lt.leave_type_id = la.leave_type_id
        LEFT JOIN trusmi_kota tk ON tk.id = la.kota
    WHERE
        la.leave_type_id = 23 
        AND la.employee_id = $id 
        AND la.`status` = 2
        AND la.from_date BETWEEN '$start' AND '$end'
        AND start_time IS NOT NULL
        -- HAVING
		-- 		tabungan_jam > 0
                ";

        return $this->db->query($query)->result_array();
    }

    function cekJumlahCuti($id, $periode)
    {
        $query = "SELECT
        la.employee_id,
        -- GROUP_CONCAT( cuti.leave_id ) AS leave_ids,
        SUM( cuti.tabungan_jam ) AS grand_total
    FROM
        `xin_leave_applications` la
        LEFT JOIN xin_employees emp ON emp.user_id = la.employee_id
        LEFT JOIN xin_leave_type lt ON lt.leave_type_id = la.leave_type_id
        LEFT JOIN (
        SELECT
            la.leave_id,
            la.employee_id,
            TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( to_date, ' ', end_time ) ) AS total_jam,
        IF
            (
                DATEDIFF( to_date, from_date ) = 0,
                GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( to_date, ' ', end_time )) - 11 ),
                (
                    GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( from_date, ' 23:59:59' )) - 11 ) + GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( to_date, ' 00:00:00' ), CONCAT( to_date, ' ', end_time )) - 11 ) + GREATEST( 0, ( DATEDIFF( to_date, from_date ) - 1 ) * ( 24 - 11 ) ) 
                ) 
            ) AS tabungan_jam 
        FROM
            `xin_leave_applications` la 
        WHERE
            la.leave_type_id = 23 
            AND la.`status` = 2 
            -- AND la.ganti_hari IS NULL 
            AND la.start_time IS NOT NULL 
        ) cuti ON cuti.leave_id = la.leave_id 
        AND cuti.employee_id = la.employee_id 
    WHERE
        la.leave_type_id = 23 
        AND la.`status` = 2 
        AND la.start_time IS NOT NULL 
        AND la.from_date BETWEEN DATE_FORMAT('$periode', '%Y-%m-21') - INTERVAL 2 MONTH  AND DATE_FORMAT('$periode', '%Y-%m-20')
        AND la.employee_id = '$id'
        -- AND la.ganti_hari IS NULL 
        AND emp.is_active = 1 
    GROUP BY
        employee_id";
        return $this->db->query($query)->result_array();
    }

    function getDataTabungan($periode)
    {
        $user = $this->userId;
        $query = "SELECT
        la.leave_id,
        TIMESTAMPDIFF(
            HOUR,
            CONCAT( from_date, ' ', start_time ),
        CONCAT( to_date, ' ', end_time )) AS total_jam,
        la.ganti_hari,
    IF
        (
            DATEDIFF( to_date, from_date ) = 0,
            GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( to_date, ' ', end_time )) - 11 ),
            (
                GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( from_date, ' 23:59:59' )) - 11 ) + GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( to_date, ' 00:00:00' ), CONCAT( to_date, ' ', end_time )) - 11 ) + GREATEST(
                    0,
                ( DATEDIFF( to_date, from_date ) - 1 ) * ( 24 - 11 )) 
            ) 
        ) AS tabungan_jam 
    FROM
        `xin_leave_applications` la
    WHERE
        la.leave_type_id = 23 
        AND la.employee_id = '$user' 
        AND la.`status` = 2 
        AND la.from_date BETWEEN DATE_SUB( DATE_FORMAT( '$periode', '%Y-%m-21' ), INTERVAL 2 MONTH ) 
        AND DATE_FORMAT( '$periode', '%Y-%m-20' ) 
        -- AND la.ganti_hari IS NULL 
        AND start_time IS NOT NULL
        HAVING tabungan_jam > 0";

        return $this->db->query($query)->result_array();
    }

    function getTotalPengajuan($periode)
    {
        $user = $this->userId;
        $query = "SELECT
        COUNT( la.leave_id ) AS total_pengajuan 
        FROM
            `xin_leave_applications` la 
        WHERE
            la.leave_type_id = 24 
            AND la.employee_id = $user 
            -- AND la.`status` = 2 
            AND la.from_date BETWEEN DATE_SUB( DATE_FORMAT( '$periode', '%Y-%m-21' ), INTERVAL 2 MONTH ) 
            AND DATE_FORMAT( '$periode', '%Y-%m-20' )";

        return $this->db->query($query)->row();
    }

    function cekTotalHari($periode)
    {
        $user = $this->userId;
        $query = "SELECT
        la.employee_id,
        ROUND( COALESCE ( SUM( cuti.tabungan_jam ), 0 )/ 11 ) AS total_hari
    FROM
        `xin_leave_applications` la
        LEFT JOIN xin_employees emp ON emp.user_id = la.employee_id
        LEFT JOIN (
        SELECT
            la.leave_id,
            la.employee_id,
            TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( to_date, ' ', end_time ) ) AS total_jam,
        IF
            (
                DATEDIFF( to_date, from_date ) = 0,
                GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( to_date, ' ', end_time )) - 11 ),
                (
                    GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( from_date, ' 23:59:59' )) - 11 ) + GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( to_date, ' 00:00:00' ), CONCAT( to_date, ' ', end_time )) - 11 ) + GREATEST( 0, ( DATEDIFF( to_date, from_date ) - 1 ) * ( 24 - 11 ) ) 
                ) 
            ) AS tabungan_jam 
        FROM
            `xin_leave_applications` la 
        WHERE
            la.leave_type_id = 23 
            AND la.`status` = 2 
            AND la.start_time IS NOT NULL 
        AND
        IF
            (
                DATEDIFF( to_date, from_date ) = 0,
                GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( to_date, ' ', end_time )) - 11 ),
                (
                    GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( from_date, ' ', start_time ), CONCAT( from_date, ' 23:59:59' )) - 11 ) + GREATEST( 0, TIMESTAMPDIFF( HOUR, CONCAT( to_date, ' 00:00:00' ), CONCAT( to_date, ' ', end_time )) - 11 ) + GREATEST(
                        0,
                    ( DATEDIFF( to_date, from_date ) - 1 ) * ( 24 - 11 )) 
                ) 
            ) > 0 
        ) cuti ON cuti.leave_id = la.leave_id 
    WHERE
        la.leave_type_id = 23 
        AND la.employee_id = $user
        AND la.`status` = 2 
        AND la.start_time IS NOT NULL 
        AND la.from_date BETWEEN DATE_FORMAT( '$periode', '%Y-%m-21' ) - INTERVAL 2 MONTH 
        AND DATE_FORMAT( '$periode', '%Y-%m-20' ) 
        AND emp.is_active = 1 
    GROUP BY
        employee_id ";

        return $this->db->query($query)->row();
    }
}
