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
        $union = "UNION SELECT
            xin_departments.department_id AS `value`,
            CONCAT(xin_departments.department_name, ' (Bali)') AS `text` 
        FROM
            xin_departments 
        WHERE
            xin_departments.department_id IN (175, 177, 180)";

        $query = "SELECT
            0 AS `value`,
            'All Departments' AS `text` UNION
        SELECT
            xin_departments.department_id AS `value`,
            xin_departments.department_name AS `text` 
        FROM
            xin_departments 
        WHERE
            xin_departments.company_id != 0 AND xin_departments.company_id = $company_id AND xin_departments.hide = 0
        $union";

        return $this->db->query($query);
    }

    public function get_employees($company_id, $department_id)
    {
        $bali = array(175, 177, 180);

        $company = (in_array($department_id, $bali)) ? "" : "AND xin_employees.company_id = $company_id" ;

        $query = "SELECT
            0 AS `value`,
            'All Employees' AS `text` UNION
        SELECT
            xin_employees.user_id AS `value`,
            CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS `text` 
        FROM
            xin_employees 
        WHERE
            xin_employees.department_id = $department_id 
            AND xin_employees.is_active = 1
            $company";

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

    function get_sub_emp($department_id, $posisi, $employee_id)
    {
        if ($this->session->userdata('user_id') == 1426) {
            $kondisi = "xin_employees.designation_id IN (509,810,1241)";
        } else {
            $kondisi = "xin_employees.department_id = $department_id";
        }
        $query = "SELECT
            GROUP_CONCAT( x.user_id ) AS id 
        FROM
            (
            SELECT
                xin_employees.user_id 
            FROM
                xin_employees 
            WHERE
                $kondisi
                AND xin_employees.is_active = 1 
                AND xin_employees.user_id != 1 
                AND xin_employees.ctm_posisi IN ( $posisi ) UNION
            SELECT
                xin_employees.user_id 
            FROM
                xin_departments
                JOIN xin_employees ON xin_departments.department_id = xin_employees.department_id 
                AND xin_employees.is_active = 1 
            WHERE
            head_id = $employee_id 
            ) AS x";

        $data = $this->db->query($query)->row_array();

        return $data['id'];
    }

    public function get_absensi($start, $end, $company_id, $department_id, $employee_id, $sub_emp, $periode = NULL)
    {
        $bali = array(175, 177, 180);

        // $company    = (in_array($department_id, $bali)) ? "" : ($department_id == 0 ) ? "xin_employees.company_id = $company_id" : "AND xin_employees.company_id = $company_id" ;
        // $department = ($department_id == 0) ? "" : ($sub_emp != 0) ? "" : "xin_employees.department_id = $department_id" ;

        if (in_array($department_id, $bali)) {
            $company = "";
        } else {
            if ($department_id == 0) {
                $company = "xin_employees.company_id = $company_id";
            } else {
                if ($sub_emp != 0) {
                    $company = "xin_employees.company_id = $company_id";
                } else {
                    $company = "AND xin_employees.company_id = $company_id";
                }
            }
        }

        if ($department_id == 0) {
            $department = "";
        } else {
            if ($sub_emp != 0) {
                $department = "";
            } else {
                $department = "xin_employees.department_id = $department_id";
            }
        }
        
        if ($employee_id == 0) {
            $employee = "";
        } else {
            if ($sub_emp == 0) {
                $employee = "AND xin_employees.user_id = $employee_id";
            } else {
                $employee = "AND xin_employees.user_id IN ( $sub_emp )";
            }
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
            COALESCE(
            trusmi_harus_hadir.harus_hadir,
            CASE
                WHEN rekap.designation_id IN (9,10,395,441) THEN 21
                WHEN rekap.designation_id = 458 THEN COUNT(rekap.`status`)
                WHEN rekap.user_role_id = 8 THEN COUNT(IF(rekap.`status` NOT IN ('','A','F','LV','LT','LE','LR','LA','R'), 1, NULL))
                WHEN COUNT(IF(rekap.`status` = 'R', 1, NULL)) > 0 THEN COUNT(IF(rekap.`status` NOT IN ('','R'), 1, NULL)) - COUNT(IF(rekap.libur_aktif = 1, 1, NULL))
                ELSE COUNT(rekap.`status`) - IF(rekap.libur > 0, rekap.libur, COUNT(IF(rekap.hari = 'Sun' AND rekap.date >= rekap.date_of_joining, 1, NULL))) - COUNT(IF(rekap.`status` = '', 1, NULL)) 
            END) AS harus_hadir,
            COUNT(IF(rekap.`status` NOT IN ('','A','F','LV','LT','LE','LR','LA','R'), 1, NULL)) AS total_hadir,
            -- terlambat
            COUNT(IF(rekap.`status` = 'T', 1, NULL)) AS telat,
            COUNT(IF(rekap.`status` = 'NP', 1, NULL)) AS bolos,
            SUM(IF(rekap.`status` = 'T' OR rekap.`status` = 'T', rekap.telat, 0)) + SUM(IF(rekap.`status` = 'NP' OR rekap.`status` = 'T', rekap.telat_pc, 0)) + SUM(IF(rekap.`status` = 'DT', rekap.telat_idt, 0)) + SUM(IF(rekap.`status` = 'PC', rekap.telat_ipc, 0)) AS menit_telat,
            -- off
            COUNT(IF(rekap.`status` = 'A', 1, NULL)) AS absen,
            -- ijin pulang cepat dan datang terlambat
            COUNT(IF(rekap.`status` = 'DT', 1, NULL)) AS izin_dt,
            COUNT(IF(rekap.`status` = 'PC', 1, NULL)) AS izin_pc,
            COUNT(IF(rekap.`status` = 'DT', 1, NULL)) + COUNT(IF(rekap.`status` = 'PC', 1, NULL)) total_izin_pc_dt,
            -- lock absen
            COUNT(IF(rekap.`status` = 'LV', 1, NULL)) AS lock_video,
            COUNT(IF(rekap.`status` = 'LT', 1, NULL)) AS lock_tasklist,
            COUNT(IF(rekap.`status` = 'LE', 1, NULL)) AS lock_eaf,
            COUNT(IF(rekap.`status` = 'LR', 1, NULL)) AS lock_training,
            COUNT(IF(rekap.`status` = 'LA', 1, NULL)) AS lock_other,
            COUNT(IF(rekap.`status` = 'LV', 1, NULL)) + COUNT(IF(rekap.`status` = 'LT', 1, NULL)) + COUNT(IF(rekap.`status` = 'LE', 1, NULL)) + COUNT(IF(rekap.`status` = 'LR', 1, NULL)) + COUNT(IF(rekap.`status` = 'LA', 1, NULL)) AS total_lock,
            -- finger 1x
            COUNT(IF(rekap.`status` = 'F', 1, NULL)) AS absen_sekali,
            -- cuti khususu
            COUNT(IF(rekap.`status` IN ('C','CL'), 1, NULL)) AS cuti_tahunan,
            COUNT(IF(rekap.`status` = 'CB', 1, NULL)) AS cuti_bersalin,
            COUNT(IF(rekap.`status` = 'KL', 1, NULL)) AS kematian_keluarga,
            COUNT(IF(rekap.`status` = 'M', 1, NULL)) AS karyawan_menikah,
            COUNT(IF(rekap.`status` = 'PR', 1, NULL)) AS pernikahan_anak,
            COUNT(IF(rekap.`status` = 'KA', 1, NULL)) AS khitan_anak,
            COUNT(IF(rekap.`status` = 'SW', 1, NULL)) AS skripsi_wisuda,
            COUNT(IF(rekap.`status` IN ('C','CL'), 1, NULL)) + COUNT(IF(rekap.`status` = 'CB', 1, NULL)) + COUNT(IF(rekap.`status` = 'KL', 1, NULL)) + COUNT(IF(rekap.`status` = 'M', 1, NULL)) + COUNT(IF(rekap.`status` = 'PR', 1, NULL)) + COUNT(IF(rekap.`status` = 'KA', 1, NULL)) + COUNT(IF(rekap.`status` = 'SW', 1, NULL)) AS total_cuti_khusus,
            -- dinas luar kota
            COUNT(IF(rekap.`status` = 'DL', 1, NULL)) AS non_driver,
            COUNT(IF(rekap.`status` = 'DD', 1, NULL)) AS driver,
            COUNT(IF(rekap.`status` = 'DL', 1, NULL)) + COUNT(IF(rekap.`status` = 'DD', 1, NULL)) AS total_dinas,
            -- sakit
            COUNT(IF(rekap.`status` = 'S', 1, NULL)) AS karyawan_sakit,
            COUNT(IF(rekap.`status` = 'SK', 1, NULL)) AS keluarga_sakit,
            COUNT(IF(rekap.`status` = 'S', 1, NULL)) + COUNT(IF(rekap.`status` = 'SK', 1, NULL)) AS total_sakit,

            COUNT(IF(rekap.holiday = 1, 1, NULL)) AS libur_nasional,
            COUNT(IF(rekap.`status` = 'R', 1, NULL)) AS resign
        FROM
            (SELECT
                    xin_employees.user_id,
                    CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS `employee`,
                    xin_departments.department_name AS department,
                    xin_designations.designation_name AS designation,
                    xin_office_location.location_name AS location,
                    xin_employees.user_role_id,
                    xin_employees.date_of_joining,
                    xin_employees.date_of_leaving,
                    xin_employees.designation_id,
                    xin_leave_applications.leave_id,
                    xin_departments.libur,
                    IF(xin_employees.date_of_leaving != '' AND xin_employees.date_of_leaving < all_dates.date, NULL,IF(DATE_FORMAT(all_dates.date,'%a') = 'Sun' AND IF(all_dates.date < xin_employees.date_of_joining, '', NULL) != '',1,NULL)) AS libur_aktif,
                    CASE
                        -- Karyawan baru join tidak absen
                        WHEN all_dates.date < xin_employees.date_of_joining THEN ''
                        -- Karyawan baru absen
                        WHEN xin_employees.date_of_joining = xin_attendance_time.attendance_date THEN 'P'
                        --  Resign
                        WHEN xin_employees.date_of_leaving != '' AND xin_employees.date_of_leaving < all_dates.date THEN 'R'
                        --  Hari Esok
                        WHEN all_dates.date > CURDATE() THEN 
                            CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                        --  Pergantian Hari Libur
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 7 THEN
                            CASE
                                WHEN xin_leave_applications.tgl_ph < '$start' THEN 
                                    CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'H' END
                                WHEN ganti_libur.holiday_id IS NOT NULL THEN 
                                    CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'H' END
                                WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') IS NOT NULL AND xin_attendance_time.clock_out IS NOT NULL THEN 'P'
                                ELSE 
                                    CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                            END
                        --  Cuti Tahunan
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id IN (1,14) THEN 'C'
                        --  Cuti Menikah
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 2 THEN 'M'
                        --  Izin Sakit
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 5 THEN 'S'
                        --  Cuti Bersalin
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id IN (3,8) THEN
                            CASE
                                --  Libur Mingguan/Pergantian hari libur dalam periode cutoff
                                WHEN xin_office_shift.monday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Mon' THEN 
                                    CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                                WHEN xin_office_shift.tuesday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Tue' THEN 
                                    CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                                WHEN xin_office_shift.wednesday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Wed' THEN 
                                    CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                                WHEN xin_office_shift.thursday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Thu' THEN 
                                    CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                                WHEN xin_office_shift.friday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Fri' THEN 
                                    CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                                WHEN xin_office_shift.saturday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sat' THEN 
                                    CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                                WHEN ( xin_office_shift.sunday_in_time = '' OR xin_leave_applications.leave_type_id IN (3,8) ) AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sun' THEN 
                                    CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                                --  Hari libur nasional/perhantian hari libur nasional/pergantian hari libur beda periode cut off
                                WHEN xin_holidays.event_name IS NOT NULL THEN 
                                    CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'H' END
                                --  Absent
                                ELSE 'CB'
                            END
                        --  Pernikahan anak / saudara
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND ( xin_leave_applications.leave_type_id = 15 OR xin_leave_applications.leave_type_id = 16 ) THEN 'PR'
                        --  Khitan Anak
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 25 THEN 'KA'
                        --  Keluarga sakit
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND ( xin_leave_applications.leave_type_id = 21 OR xin_leave_applications.leave_type_id = 22 ) THEN 'SK'
                        --  Kematan Keluarga
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND ( xin_leave_applications.leave_type_id = 9 || xin_leave_applications.leave_type_id = 17 ) THEN 'KL'
                        --  Wisuda/skripsi
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 18 THEN 'SW'
                        --  DLK non driver
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 13 AND IF(IF(xin_leave_applications.to_date = all_dates.date, xin_leave_applications.end_time, NULL) < IF(xin_leave_applications.to_date = all_dates.date, CONCAT(xin_attendance_time.shift_in, ':00'), NULL), 1, 0) = 0 THEN 'DL'
                        --  DLK driver
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 23 THEN 'DD'
                        --  Skripsi/wisuda
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 18 THEN 'SW'
                        --  Cuti thun lalu
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 19 THEN 'CL'
                        --  Telat (lebih 40% termasuk absen)
                        WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') IS NOT NULL AND IF( DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') > CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), 1, 0 ) = 1 AND xin_leave_applications.leave_id IS NULL THEN
                            CASE
                                WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') > CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))*0.4) MINUTE THEN 
                                        -- Kondisi Shift Store
                                        CASE
                                            WHEN TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) > 479 AND xin_employees.office_shift_id IN (7,11,12,13,14,18,21) THEN 'P'
                                            -- Jam masuk dan jam pulang sama
                                            WHEN TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) < 11 THEN 'F'
                                            ELSE 
                                                CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                                        END
                                ELSE 
                                    -- Kondisi Shift Store
                                    CASE
                                        WHEN TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) > 479 AND xin_employees.office_shift_id IN (7,11,12,13,14,18,21) THEN 'P'
                                        ELSE 
                                            CASE
                                                WHEN xin_attendance_time.clock_out IS NULL THEN 'F'
                                                ELSE 
                                                    CASE
                                                        WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') IS NOT NULL AND xin_attendance_time.clock_out IS NULL AND locked.employee_id IS NOT NULL THEN 
                                                                CASE
                                                                    WHEN locked.jenis = 'tasklist' THEN 'LT'
                                                                    WHEN locked.jenis = 'eaf' THEN 'LE'
                                                                    WHEN locked.jenis = 'training' THEN 'LR'
                                                                    WHEN locked.jenis IS NULL THEN 'LA'
                                                                    ELSE 'lock'
                                                                END
                                                        ELSE 
                                                            CASE
                                                                WHEN TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) < 11 THEN 'F'
                                                                WHEN xin_attendance_time.clock_in IS NOT NULL AND xin_attendance_time.clock_out IS NULL THEN 'F'
                                                                ELSE 'T'
                                                            END
                                                    END
                                            END
                                    END
                            END
                        --  Pulang Cepat (kurang 60% termasuk absen)
                        WHEN xin_attendance_time.clock_out IS NOT NULL AND IF( xin_attendance_time.clock_out < IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ), 1, 0 ) = 1 AND xin_leave_applications.leave_id IS NULL THEN
                            CASE
                                WHEN xin_attendance_time.clock_out < CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))*0.6) MINUTE THEN 
                                    CASE
                                        WHEN TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) < 11 THEN 'F'
                                        ELSE 
                                            CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                                    END
                                WHEN SUBSTR(CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))*0.6) MINUTE, 12) = '00:00:00' THEN 
                                    -- Jam masuk dan jam pulang sama
                                    CASE
                                        WHEN TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) < 11 THEN 'F'
                                        ELSE 'P'
                                    END
                                ELSE
                                    CASE
                                        WHEN TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) < 11 THEN 'F'
                                        ELSE 'NP'
                                    END
                            END
                        --  Absen 1x Karna Lock
                        WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') IS NOT NULL AND xin_attendance_time.clock_out IS NULL AND locked.employee_id IS NOT NULL THEN 
                            CASE
                                WHEN locked.jenis = 'video' THEN 'LV'
                                WHEN locked.jenis = 'tasklist' THEN 'LT'
                                WHEN locked.jenis = 'eaf' THEN 'LE'
                                WHEN locked.jenis = 'training' THEN 'LR'
                                WHEN locked.jenis IS NULL THEN 'LA'
                                ELSE ''
                            END
                        --  Izin datang terlambat (lebih 40% termasuk absen)
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 11 THEN
                            CASE
                                WHEN xin_attendance_time.clock_out IS NULL THEN 'F'
                                WHEN IF(DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') > DATE_FORMAT(CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))*0.4) MINUTE, '%Y-%m-%d %H:%i:00'),TIMESTAMPDIFF(MINUTE,DATE_FORMAT(CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))*0.4) MINUTE, '%Y-%m-%d %H:%i:00'),DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00')),0) > 10 THEN 'A' 
                                ELSE 'DT'
                            END
                        --  Izin pulang cepat (kurang 60% termasuk absen)
                        WHEN xin_leave_applications.leave_id IS NOT NULL AND xin_leave_applications.leave_type_id = 10 THEN
                            CASE
                                WHEN xin_attendance_time.clock_out IS NULL THEN 'F'
                                WHEN xin_attendance_time.clock_out < CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))*0.6) MINUTE THEN 
                                    CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                                WHEN IF(DATE_FORMAT(xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00') < DATE_FORMAT(CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))*0.6) MINUTE, '%Y-%m-%d %H:%i:00'),TIMESTAMPDIFF(MINUTE,DATE_FORMAT(xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00'),DATE_FORMAT(CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))*0.6) MINUTE, '%Y-%m-%d %H:%i:00')),0) > 10 THEN 'A'
                                ELSE 'PC'
                            END
                        -- Flat Shift
                        WHEN (CASE
                                WHEN xin_attendance_time.clock_in IS NOT NULL AND (xin_employees.office_shift_id = 166 OR xin_designations.trusmi_shift = 31) THEN 480
                                WHEN xin_attendance_time.clock_in IS NOT NULL AND (xin_employees.office_shift_id = 167 OR xin_designations.trusmi_shift = 32) THEN 540
                                WHEN xin_attendance_time.clock_in IS NOT NULL AND (xin_employees.office_shift_id = 168 OR xin_designations.trusmi_shift = 33) THEN 600
                                WHEN xin_attendance_time.clock_in IS NOT NULL AND (xin_employees.office_shift_id = 169 OR xin_designations.trusmi_shift = 34) THEN 660
                                WHEN xin_attendance_time.clock_in IS NOT NULL AND (xin_employees.office_shift_id = 170 OR xin_designations.trusmi_shift = 35) THEN 720
                                ELSE NULL 
                            END) > TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) THEN 'NP'
                        --  Absen 1x di hari libur nasional
                        WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') IS NOT NULL AND xin_attendance_time.clock_out IS NULL AND xin_holidays.event_name IS NOT NULL THEN 
                            CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'H' END
                        --  Absen 1x kecuali
                        WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') IS NOT NULL AND xin_attendance_time.clock_out IS NULL THEN 'F'
                        -- Jam masuk dan pulang sama
                        WHEN TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) < 11 THEN 'F'
                        --  Libur Mingguan/Pergantian hari libur dalam periode cutoff
                        WHEN xin_office_shift.monday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Mon' THEN 
                            CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                        WHEN xin_office_shift.tuesday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Tue' THEN 
                            CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                        WHEN xin_office_shift.wednesday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Wed' THEN 
                            CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                        WHEN xin_office_shift.thursday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Thu' THEN 
                            CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                        WHEN xin_office_shift.friday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Fri' THEN 
                            CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                        WHEN xin_office_shift.saturday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sat' THEN 
                            CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                        WHEN xin_office_shift.sunday_in_time = '' AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sun' THEN 
                            CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                        --  Hari libur nasional/perhantian hari libur nasional/pergantian hari libur beda periode cut off
                        WHEN xin_holidays.event_name IS NOT NULL AND xin_attendance_time.clock_in IS NULL AND xin_attendance_time.clock_out IS NULL THEN 
                            CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'H' END
                        -- lock manual
                        WHEN manual_locked.jenis IS NOT NULL AND manual_locked.jenis = 'video' THEN 'LV'
                        WHEN manual_locked.jenis IS NOT NULL AND manual_locked.jenis = 'other' THEN 'LA'
                        --  Absent
                        --  Present (hadir)
                        WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') IS NOT NULL AND xin_attendance_time.clock_out IS NOT NULL THEN 'P'
                        -- Tidak Absen karna Lock
                        WHEN DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') IS NULL AND xin_attendance_time.clock_out IS NULL AND locked.employee_id IS NOT NULL THEN 
                            CASE
                                WHEN locked.jenis = 'video' THEN 'LV'
                                WHEN locked.jenis = 'tasklist' THEN 'LT'
                                WHEN locked.jenis = 'eaf' THEN 'LE'
                                WHEN locked.jenis = 'training' THEN 'LR'
                                WHEN locked.jenis IS NULL THEN 'LA'
                                ELSE ''
                            END
                        ELSE 
                            CASE WHEN xin_employees.user_role_id = 8 THEN '' ELSE 'A' END
                    END AS `status`,
                    all_dates.date,
                    xin_attendance_time.attendance_date,
                    xin_employees.office_shift_id,
                    xin_designations.trusmi_shift,
                    DATE_FORMAT(all_dates.date,'%a') hari,
                    CASE
                        WHEN xin_attendance_time.clock_in IS NOT NULL AND (xin_employees.office_shift_id = 166 OR xin_designations.trusmi_shift = 31) THEN 480
                        WHEN xin_attendance_time.clock_in IS NOT NULL AND (xin_employees.office_shift_id = 167 OR xin_designations.trusmi_shift = 32) THEN 540
                        WHEN xin_attendance_time.clock_in IS NOT NULL AND (xin_employees.office_shift_id = 168 OR xin_designations.trusmi_shift = 33) THEN 600
                        WHEN xin_attendance_time.clock_in IS NOT NULL AND (xin_employees.office_shift_id = 169 OR xin_designations.trusmi_shift = 34) THEN 660
                        WHEN xin_attendance_time.clock_in IS NOT NULL AND (xin_employees.office_shift_id = 170 OR xin_designations.trusmi_shift = 35) THEN 720
                        ELSE NULL 
                    END AS jam_flat,
                    TIMESTAMPDIFF(MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out) AS jam_kerja,
                    IF(xin_holidays.event_name IS NOT NULL, 1, NULL) AS holiday,
                    DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') AS clock_in,
                    CONCAT('JM',DATE_FORMAT(xin_attendance_time.clock_in, '%H:%i'),'JP',DATE_FORMAT(xin_attendance_time.clock_out, '%H:%i')) AS jam_absen,
                    IF(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00'))>0,TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00')),NULL) AS telat,
                    IF(TIMESTAMPDIFF(MINUTE, DATE_FORMAT(xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00'), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))>0,TIMESTAMPDIFF(MINUTE, DATE_FORMAT(xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00'), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) )),NULL) AS telat_pc,
                    CEILING(IF(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00'))>0,TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00')),NULL) / 60) * 60 AS tambah_menit,
                    IF(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00'))>0,TIMESTAMPDIFF(MINUTE, IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ), DATE_FORMAT(xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00')),NULL) AS menit_tambah,
                    IF(IF(xin_leave_applications.to_date = all_dates.date, xin_leave_applications.end_time, NULL) < IF(xin_leave_applications.to_date = all_dates.date, CONCAT(xin_attendance_time.shift_in, ':00'), NULL), 1, 0) AS dlk_aktif,
                    CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) AS shift_in,
                    xin_attendance_time.clock_out,
                    IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ) AS shift_out,
                    CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))*0.4) MINUTE AS max_dt,
                    IF(DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00') > DATE_FORMAT(CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))*0.4) MINUTE, '%Y-%m-%d %H:%i:00'),TIMESTAMPDIFF(MINUTE,DATE_FORMAT(CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))*0.4) MINUTE, '%Y-%m-%d %H:%i:00'),DATE_FORMAT(xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00')),0) AS telat_idt,
                    CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))*0.6) MINUTE AS max_pc,
                    IF(DATE_FORMAT(xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00') < DATE_FORMAT(CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))*0.6) MINUTE, '%Y-%m-%d %H:%i:00'),TIMESTAMPDIFF(MINUTE,DATE_FORMAT(xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00'),DATE_FORMAT(CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(TIMESTAMPDIFF(MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), IF( xin_attendance_time.shift_in > '17:00', CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) ))*0.6) MINUTE, '%Y-%m-%d %H:%i:00')),0) AS telat_ipc
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
                    LEFT JOIN (SELECT
                        lock_manual.employee_id,
                        lock_manual.type_lock AS jenis,
                        all_dates.date 
                    FROM
                        (
                        SELECT
                            trusmi_lock_absen_manual.id,
                            trusmi_lock_absen_manual.type_lock,
                            trusmi_lock_absen_manual.employee_id,
                            MIN( DATE( trusmi_lock_absen_manual.created_at ) ) AS start_periode,
                            COALESCE ( DATE( trusmi_lock_absen_manual.updated_by ), CURDATE( ) ) AS end_periode 
                        FROM
                            trusmi_lock_absen_manual 
                        WHERE
                            trusmi_lock_absen_manual.`status` = 1 
                            AND (
                                ( DATE( trusmi_lock_absen_manual.created_at ) BETWEEN '$start' AND '$end' ) 
                                OR ( COALESCE ( DATE( trusmi_lock_absen_manual.updated_by ), CURDATE( ) ) BETWEEN '$start' AND '$end' ) 
                            ) 
                        GROUP BY
                            trusmi_lock_absen_manual.employee_id 
                        ) AS lock_manual
                        JOIN all_dates ON all_dates.date BETWEEN lock_manual.start_periode 
                        AND lock_manual.end_periode 
                    WHERE
                        all_dates.date BETWEEN '$start' 
                        AND '$end') manual_locked ON manual_locked.employee_id = xin_employees.user_id AND manual_locked.date = all_dates.date
                WHERE
                    $department
                    $company
                    $employee
                    
                    AND (
                        ( xin_employees.is_active = 1 AND xin_employees.date_of_joining <= '$end' ) 
                        OR (
                            xin_employees.is_active = 0 
                        AND
                        IF ( IF ( xin_employees.date_of_leaving = '' OR xin_employees.date_of_leaving IS NULL, '$start' - INTERVAL 1 DAY, xin_employees.date_of_leaving ) > '$end', '$end', IF ( xin_employees.date_of_leaving = '' OR xin_employees.date_of_leaving IS NULL, '$start' - INTERVAL 1 DAY, xin_employees.date_of_leaving )) BETWEEN '$start' 
                            AND '$end' 
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
        LEFT JOIN trusmi_harus_hadir ON rekap.user_id = trusmi_harus_hadir.employee_id AND trusmi_harus_hadir.periode = '$periode'    
        GROUP BY
            rekap.user_id
        ORDER BY
            rekap.department,
            rekap.designation,
            rekap.employee";

        $this->db->query("SET @@group_concat_max_len = 4096");

        return $this->db->query($query);
    }

    public function cek_harus_hadir($periode, $employee_id)
    {
        return $this->db->query("SELECT harus_hadir FROM trusmi_harus_hadir WHERE periode = '$periode' AND employee_id = $employee_id");
    }
}
