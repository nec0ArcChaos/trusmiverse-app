<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_rekap_absen extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function tanggal_periode($start, $end)
    {
        $query = "SELECT date FROM `all_dates` WHERE date BETWEEN '2023-04-21' AND '2023-05-20'";

        return $this->db->query($query);
    }

    public function get_company()
    {
        $query = "SELECT
            xin_companies.company_id,
            xin_companies.`name` AS company 
        FROM
            xin_companies";

        return $this->db->query($query);
    }

    public function get_department($company_id)
    {
        $query = "SELECT
            0 AS `value`,
            'All Departments' AS `text` UNION
        SELECT
            xin_departments.department_id AS `value`,
            xin_departments.department_name AS `text` 
        FROM
            xin_departments 
        WHERE
            xin_departments.company_id != 0 AND xin_departments.company_id = $company_id";

        return $this->db->query($query);
    }

    public function get_employees($company_id, $department_id)
    {
        $query = "SELECT
            0 AS `value`,
            'All Employees' AS `text` UNION
        SELECT
            xin_employees.user_id AS `value`,
            CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS `text` 
        FROM
            xin_employees 
        WHERE
            xin_employees.company_id = $company_id 
            AND xin_employees.department_id = $department_id 
            AND xin_employees.is_active = 1";

        return $this->db->query($query);
    }

    public function get_periode($periode, $start, $end, $tipe)
    {
        if ($tipe == 1) {
            $select = "CASE
                WHEN MONTH(all_dates.date) = 1 THEN 'Januari'
                WHEN MONTH(all_dates.date) = 2 THEN 'Februari'
                WHEN MONTH(all_dates.date) = 3 THEN 'Maret'
                WHEN MONTH(all_dates.date) = 4 THEN 'April'
                WHEN MONTH(all_dates.date) = 5 THEN 'Mei'
                WHEN MONTH(all_dates.date) = 6 THEN 'Juni'
                WHEN MONTH(all_dates.date) = 7 THEN 'Juli'
                WHEN MONTH(all_dates.date) = 8 THEN 'Agustus'
                WHEN MONTH(all_dates.date) = 9 THEN 'September'
                WHEN MONTH(all_dates.date) = 10 THEN 'Oktober'
                WHEN MONTH(all_dates.date) = 11 THEN 'November'
                WHEN MONTH(all_dates.date) = 12 THEN 'Desember'
            END AS bulan,
            COUNT( SUBSTR( all_dates.date, 1, 7 ) ) AS colspan";

            $group  = "GROUP BY SUBSTR( all_dates.date, 1, 7 )";
        } else {
            $select = "all_dates.date, SUBSTR( all_dates.date, 9, 10 ) AS tgl";

            $group  = "";
        }

        $query = "SELECT
            $select
        FROM
            all_dates 
        WHERE
            all_dates.date BETWEEN '$start' 
            AND '$end' 
            $group
        ORDER BY
            all_dates.date";

        return $this->db->query($query);
    }

    public function get_absensi($start, $end, $company_id, $department_id, $employee_id)
    {
        if ($department_id == 0) {
            $department = "";
        } else {
            $department = "AND xin_employees.department_id = $department_id";
        }

        if ($employee_id == 0) {
            $employee = "";
        } else {
            $employee = "AND xin_employees.user_id = $employee_id";
        }

        $query = "SELECT
            rekap.user_id,
            rekap.employee,
            rekap.department,
            rekap.designation,
            rekap.location,
            rekap.date_of_joining,
            max(rekap.attendance_date) AS last_present,
            GROUP_CONCAT( CONCAT( '<td>', rekap.`status`, '</td>' ) ORDER BY rekap.date SEPARATOR '' ) AS absensi,
            COUNT(rekap.`status`) - COUNT(IF(rekap.hari = 'Sun' AND rekap.date >= rekap.date_of_joining, 1, NULL)) - COUNT(IF(rekap.`status` = '', 1, NULL)) AS harus_hadir,
            COUNT(IF(rekap.`status` != '' AND rekap.`status` != 'A' AND rekap.`status` != 'R', 1, NULL)) AS total_hadir,
            COUNT(IF(rekap.`status` = 'T', 1, NULL)) AS telat,
            SUM(IF(rekap.`status` = 'T', rekap.telat, 0)) AS menit_telat,
            COUNT(IF(rekap.`status` = 'DT', 1, NULL)) AS izin_dt,
            COUNT(IF(rekap.`status` = 'PC', 1, NULL)) AS izin_pc,
            COUNT(IF(rekap.`status` = 'DT', 1, NULL)) + COUNT(IF(rekap.`status` = 'PC', 1, NULL)) total_izin_pc_dt,
            COUNT(IF(rekap.`status` = 'F', 1, NULL)) AS absen_sekali,
            COUNT(IF(FIND_IN_SET(rekap.`status`,'C,M,CB,PR,SK,KL,SW,DL,DD,SW,CL'), 1, NULL)) AS total_cuti,
            COUNT(IF(rekap.`status` = 'S', 1, NULL)) AS izin_sakit,
            COUNT(IF(rekap.holiday = 1, 1, NULL)) AS libur_nasional,
            COUNT(IF(rekap.`status` = 'R', 1, NULL)) AS resign,
            COUNT(IF(rekap.`status` = 'A', 1, NULL)) AS absen,
            IF(COUNT(IF(rekap.`status` = 'A', 1, NULL)) - COUNT(IF(rekap.hari = 'Sun', 1, NULL)) < 0, 0, COUNT(IF(rekap.`status` = 'A', 1, NULL)) - COUNT(IF(rekap.hari = 'Sun', 1, NULL))) AS lebih_absen,
            ROUND(COUNT(IF(rekap.`status` != 'A' AND rekap.`status` != 'R', 1, NULL)) / (COUNT(rekap.`status`) - COUNT(IF(rekap.hari = 'Sun', 1, NULL)) - COUNT(IF(rekap.holiday = 1, 1, NULL))) * 100) AS kehadiran,
            ROUND((COUNT(IF(rekap.`status` != 'A' AND rekap.`status` != 'R', 1, NULL)) - COUNT(IF(rekap.`status` = 'PC', 1, NULL)) - COUNT(IF(rekap.`status` = 'DT', 1, NULL)) - COUNT(IF(rekap.`status` = 'F', 1, NULL)) - COUNT(IF(rekap.`status` = 'T', 1, NULL))) / (COUNT(rekap.`status`) - COUNT(IF(rekap.hari = 'Sun', 1, NULL)) - COUNT(IF(rekap.holiday = 1, 1, NULL))) * 100) AS kedisiplinan
        FROM
            (SELECT
                    xin_employees.user_id,
                    CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS `employee`,
                    xin_departments.department_name AS department,
                    xin_designations.designation_name AS designation,
                    xin_office_location.location_name AS location,
                    xin_employees.date_of_joining,
                    xin_employees.date_of_leaving,
                    xin_leave_applications.leave_id,
                    CASE
                        -- Karyawan baru join tidak absen
                        WHEN all_dates.date < xin_employees.date_of_joining THEN ''
                        -- Karyawan baru absen
                        WHEN xin_employees.date_of_joining = xin_attendance_time.attendance_date THEN 'P'
                        --  Resign
                        WHEN xin_employees.date_of_leaving != '' AND xin_employees.date_of_leaving <= all_dates.date THEN 'R'
                        --  Hari Esok
                        WHEN all_dates.date > CURDATE() THEN 'A'
                        --  Pergantian Hari Libur
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 7 THEN
                            CASE
                                WHEN xin_leave_applications.tgl_ph < '$start' THEN 'H'
                                WHEN ganti_libur.holiday_id IS NOT NULL THEN 'H'
                                ELSE 'A'
                            END
                        --  Cuti Tahunan
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 1 THEN 'C'
                        --  Cuti Menikah
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 2 THEN 'M'
                        --  Izin Sakit
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 5 THEN 'S'
                        --  Cuti Bersalin
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND ( xin_leave_applications.leave_type_id = 3 OR xin_leave_applications.leave_type_id = 8 ) THEN
                            CASE
                                --  Libur Mingguan/Pergantian hari libur dalam periode cutoff
                                WHEN xin_office_shift.monday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Mon' THEN 'A'
                                WHEN xin_office_shift.tuesday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Tue' THEN 'A'
                                WHEN xin_office_shift.wednesday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Wed' THEN 'A'
                                WHEN xin_office_shift.thursday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Thu' THEN 'A'
                                WHEN xin_office_shift.friday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Fri' THEN 'A'
                                WHEN xin_office_shift.saturday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sat' THEN 'A'
                                WHEN xin_office_shift.sunday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sun' THEN 'A'
                                --  Hari libur nasional/perhantian hari libur nasional/pergantian hari libur beda periode cut off
                                WHEN xin_holidays.event_name IS NOT NULL THEN 'H'
                                --  Absent
                                ELSE 'CB'
                            END
                        --  Pernikahan anak / saudara
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND ( xin_leave_applications.leave_type_id = 15 OR xin_leave_applications.leave_type_id = 16 ) THEN 'PR'
                        --  Keluarga sakit
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND ( xin_leave_applications.leave_type_id = 21 OR xin_leave_applications.leave_type_id = 22 ) THEN 'SK'
                        --  Kematan Keluarga
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND ( xin_leave_applications.leave_type_id = 9 || xin_leave_applications.leave_type_id = 17 ) THEN 'KL'
                        --  Wisuda/skripsi
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 18 THEN 'SW'
                        --  DLK non driver
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 13 THEN 'DL'
                        --  DLK driver
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 23 THEN 'DD'
                        --  Skripsi/wisuda
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 18 THEN 'SW'
                        --  Cuti thun lalu
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 19 THEN 'CL'
                        --  Izin datang terlambat (lebih 40% termasuk absen)
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 11 THEN
                            CASE
                                WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') > CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ))*0.4) MINUTE THEN 'A'
                                ELSE 'DT'
                            END
                        --  Izin pulang cepat (kurang 60% termasuk absen)
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 10 THEN
                            CASE
                                WHEN xin_attendance_time.clock_out < CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ), CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ))*0.6) MINUTE THEN 'A'
                                ELSE 'PC'
                            END
                        --  Telat (lebih 40% termasuk absen)
                        WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') IS NOT NULL AND IF( DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') > CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), 1, 0 ) = 1 AND xin_leave_applications.leave_id IS NULL THEN
                            CASE
                                WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') > CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ))*0.4) MINUTE THEN 
                                        -- Kondisi Shift Store
                                        CASE
                                            -- WHEN TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) > 509 THEN 'P'
                                            WHEN TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) > 479 AND xin_employees.office_shift_id IN (7,11,12,13,14,18,21) THEN 'P'
                                            ELSE 'A'
                                        END
                                ELSE 
                                    -- Ketika ada penambahan jam kerja
                                    CASE
                                        WHEN CEILING(IF(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00'))>0,TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00')),NULL) / 60) * 60 <= IF(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00'))>0,TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ), DATE_FORMAT(xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00')),NULL) THEN 'P' 
                                        ELSE 
                                            -- Kondisi Shift Store
                                            CASE
                                                -- WHEN TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) > 509 THEN 'P'
                                                WHEN TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) > 479 AND xin_employees.office_shift_id IN (7,11,12,13,14,18,21) THEN 'P'
                                                ELSE 
                                                    CASE
                                                        WHEN xin_attendance_time.clock_out IS NULL AND NOT FIND_IN_SET(xin_employees.designation_id,'731,732,733,734,735,894,898,914,915,916,927,928') THEN 'F'
                                                        ELSE 'T'
                                                    END
                                            END
                                    END
                            END
                        --  Pulang Cepat (kurang 60% termasuk absen)
                        WHEN xin_attendance_time.clock_out IS NOT NULL AND IF( xin_attendance_time.clock_out < CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ), 1, 0 ) = 1 AND xin_leave_applications.leave_id IS NULL THEN
                            CASE
                                WHEN xin_attendance_time.clock_out < CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ), CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ))*0.6) MINUTE THEN 'A'
                                WHEN SUBSTR(CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ))*0.6) MINUTE, 12) = '00:00:00' THEN 'P'
                                ELSE 'NP'
                            END
                        --  Present (hadir)
                        WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') IS NOT NULL AND xin_attendance_time.clock_out IS NOT NULL THEN 'P'
                        --  Absen 1x Karna Lock
                        WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') IS NOT NULL AND xin_attendance_time.clock_out IS NULL AND locked.employee_id IS NOT NULL THEN 
                            CASE
                                WHEN locked.jenis = 'video' THEN 'LV'
                                WHEN locked.jenis = 'tasklist' THEN 'LT'
                                WHEN locked.jenis = 'eaf' THEN 'LE'
                                WHEN locked.jenis = 'training' THEN 'LR'
                                WHEN locked.jenis IS NULL THEN 'LA'
                                ELSE 'lock'
                            END
                        --  Absen 1x di hari libur nasional
                        WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') IS NOT NULL AND xin_attendance_time.clock_out IS NULL AND xin_holidays.event_name IS NOT NULL THEN 'H'
                        --  Absen 1x kecuali marketing
                        WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') IS NOT NULL AND xin_attendance_time.clock_out IS NULL AND NOT FIND_IN_SET(xin_employees.designation_id,'731,732,733,734,735,894,898,914,915,916,927,928') THEN 'F'
                        --  Libur Mingguan/Pergantian hari libur dalam periode cutoff
                        WHEN xin_office_shift.monday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Mon' THEN 'A'
                        WHEN xin_office_shift.tuesday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Tue' THEN 'A'
                        WHEN xin_office_shift.wednesday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Wed' THEN 'A'
                        WHEN xin_office_shift.thursday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Thu' THEN 'A'
                        WHEN xin_office_shift.friday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Fri' THEN 'A'
                        WHEN xin_office_shift.saturday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sat' THEN 'A'
                        WHEN xin_office_shift.sunday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sun' THEN 'A'
                        --  Hari libur nasional/perhantian hari libur nasional/pergantian hari libur beda periode cut off
                        WHEN xin_holidays.event_name IS NOT NULL THEN 'H'
                        --  Absent
                        ELSE 'A'
                    END AS `status`,
                    all_dates.date,
                    xin_attendance_time.attendance_date,
                    xin_employees.office_shift_id,
                    DATE_FORMAT(all_dates.date,'%a') hari,
                    TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) AS jam_kerja,
                    IF(xin_holidays.event_name IS NOT NULL, 1, NULL) AS holiday,
                    DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') AS clock_in,
                    IF(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00'))>0,TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00')),NULL) AS telat,
                    CEILING(IF(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00'))>0,TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00')),NULL) / 60) * 60 AS tambah_menit,
                    IF(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00'))>0,TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ), DATE_FORMAT(xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00')),NULL) AS menit_tambah,
                    CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) AS shift_in,
                    xin_attendance_time.clock_out,
                    CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) AS shift_out,
                    CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ))*0.4) MINUTE AS max_dt,
                    CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ))*0.6) MINUTE AS max_pc
                FROM
                    xin_employees
                    JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
                    JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
                    JOIN xin_office_location ON xin_employees.location_id = xin_office_location.location_id
                    JOIN all_dates ON all_dates.date BETWEEN '$start' AND '$end'
                    LEFT JOIN xin_attendance_time ON xin_employees.user_id = xin_attendance_time.employee_id 
                    AND all_dates.date = xin_attendance_time.attendance_date
                    LEFT JOIN xin_office_shift ON xin_employees.office_shift_id = xin_office_shift.office_shift_id
                    LEFT JOIN xin_holidays ON xin_holidays.start_date <= all_dates.date AND xin_holidays.end_date >= all_dates.date
                    LEFT JOIN xin_leave_applications ON xin_leave_applications.`status` = 2 
                    AND xin_leave_applications.employee_id = xin_employees.user_id 
                    AND xin_leave_applications.from_date <= all_dates.date AND xin_leave_applications.to_date >= all_dates.date 
                    LEFT JOIN xin_holidays AS ganti_libur ON ganti_libur.start_date <= xin_leave_applications.tgl_ph AND ganti_libur.end_date >= xin_leave_applications.tgl_ph
                    LEFT JOIN (
                        SELECT
                            trusmi_history_lock.employee_id,
                            DATE( trusmi_history_lock.created_at ) AS date,
                            trusmi_m_lock.jenis 
                        FROM
                            trusmi_history_lock
                            JOIN trusmi_m_lock ON trusmi_history_lock.lock_type = trusmi_m_lock.id_lock 
                        WHERE
                            trusmi_history_lock.id IN (
                                (
                                SELECT
                                    MAX( trusmi_history_lock.id ) AS id 
                                FROM
                                    trusmi_history_lock 
                                WHERE
                                    DATE( trusmi_history_lock.created_at ) BETWEEN '$start' 
                                    AND '$end' 
                                GROUP BY
                                    trusmi_history_lock.employee_id,
                                    DATE( trusmi_history_lock.created_at ) 
                                ) 
                            )
                    ) AS locked ON locked.employee_id = xin_employees.user_id AND locked.date = all_dates.date
                WHERE
                    xin_employees.company_id = $company_id
                    $department
                    $employee
                    AND ( 
                            (
                                xin_employees.is_active = 1
                                AND xin_employees.date_of_joining <= '$end' 
                            ) OR ( 
                                xin_employees.is_active = 0 
                                AND xin_employees.date_of_leaving > '$start' 
                            )
                        )
                GROUP BY
                    xin_employees.user_id, all_dates.date
                ORDER BY
                    xin_employees.employee_id,
                    CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) ASC,
                    all_dates.date,
                    xin_departments.department_name,
                    xin_designations.designation_name) AS rekap 
        GROUP BY
            rekap.user_id";

        return $this->db->query($query);
    }
}
