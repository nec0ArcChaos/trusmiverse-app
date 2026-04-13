<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_employees_dev extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function dt_employees()
    {
        $query = "SELECT
                        e.user_id,
                        e.employee_id,
                        CASE WHEN e.profile_picture = '' AND e.gender = 'Male' THEN 'default_male.jpg'
                        WHEN e.profile_picture = '' AND e.gender = 'Female' THEN 'default_female.jpg'
                        ELSE e.profile_picture END AS profile_picture,
                        CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                        c.`name` AS company_name,
                        d.department_name,
                        ds.designation_name,
                        l.location_name,
                        e.username,
                        e.email,
                        e.contact_no,
                        e.ctm_grade,
                        r.role_name,
                        s.shift_name,
                        e.is_active,
                        COALESCE(e.updated_at,'') AS updated_at,
                        COALESCE(CONCAT(u.first_name,' ',u.last_name),'') AS updated_by
                    FROM
                        xin_employees e
                        LEFT JOIN xin_companies c ON c.company_id = e.company_id
                        LEFT JOIN xin_departments d ON d.department_id = e.department_id
                        LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                        LEFT JOIN xin_user_roles r ON r.role_id = e.user_role_id
                        LEFT JOIN xin_office_shift s ON s.office_shift_id = e.office_shift_id
                        LEFT JOIN xin_office_location l ON l.location_id = e.location_id
                        LEFT JOIN xin_employees u ON u.user_id = e.updated_by
                        WHERE e.user_id != 1
                        -- AND SUBSTR( e.created_at, 1, 10 ) > '2024-01'
                        -- AND e.is_active = 1
                        ";
        return $this->db->query($query)->result();
    }

    function reset_password()
    {
        $user_id = $this->input->post('user_id');
        if ($user_id != '') {
            $data = array(
                'password' => '$2y$12$8LhRlAGa9Qp0T.jy1aIK.O0ficmh.DafzR4tM5GnwWkj56U8IYxKq',
                'ctm_password' => '25d55ad283aa400af464c76d713c07ad'
            );
            return $this->db->where('user_id', $user_id)->update('xin_employees', $data);
        }
        return false;
    }
    function detail_employee($user_id, $type)
    {
        if ($type == 1) {
            $query = "SELECT
                emp.first_name,
                emp.last_name,
                emp.user_id,
                emp.employee_id,
                emp.username,
                emp.email,
                emp.company_id,
                emp.location_id,
                emp.department_id,
                emp.designation_id,
                emp.leave_categories,
                com.`name` AS company_name,
                loc.location_name AS location,
                dep.department_name AS departement,
                des.designation_name,
                emp.date_of_joining,
                emp.date_of_leaving,
                emp.ctm_offering AS date_offering,
                rol.role_name,
                emp.ctm_posisi as posisi,
                emp.gender,
                emp.marital_status, 
                emp.state as provinsi,
                emp.contact_no AS contact,
                emp.ctm_nohp as no_kontak,
                emp.is_active as status_active,
                emp.office_shift_id,
                emp.date_of_birth,
                emp.city,
                emp.zipcode,
                ag.ethnicity_type_id AS agama,
                emp.address,
                emp.ctm_tempat_lahir AS place_birth,
                emp.ctm_ayah AS ayah,
                emp.ctm_ibu AS ibu,
                emp.ctm_nokk AS no_kk,
                emp.ctm_noktp AS no_ktp,
                emp.ctm_domisili as domisili,
                emp.ctm_no_npwp as no_npwp,
                emp.ctm_mt as management_talent,
                emp.ctm_faskes_tingkat_pertama as jkn,
                emp.ctm_faskes_dokter_gigi as kpj,
                emp.ctm_pin as mbti,
                emp.ctm_iq as iq,
                emp.ctm_disc as disc,
                emp.ctm_attitude as attitude,
                emp.ctm_performance as performance,
                emp.ctm_jabatan as jabatan,
                emp.ctm_alasan_resign as a_resign,
                fc.no_npwp,
                emp.user_role_id,
                emp.ctm_pt,
                emp.view_companies_id,
                emp.ctm_cutoff -- addnew
                FROM
                xin_employees emp
                LEFT JOIN xin_companies com ON emp.company_id = com.company_id
                LEFT JOIN xin_office_location loc ON loc.location_id = emp.location_id
                LEFT JOIN xin_departments dep ON dep.department_id = emp.department_id
                LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
                LEFT JOIN xin_user_roles rol ON rol.role_id = emp.user_role_id
                LEFT JOIN xin_office_shift sh ON sh.office_shift_id = emp.office_shift_id
                LEFT JOIN xin_ethnicity_type ag ON ag.ethnicity_type_id = emp.ethnicity_type
                LEFT JOIN xin_job_applications app ON app.user_id_emp = emp.user_id
                LEFT JOIN fack_personal_details fc ON fc.application_id = app.application_id 
                WHERE
                emp.user_id = '$user_id'";
            return $this->db->query($query)->row_object();
        } else if ($type == 2) {
            $query = "SELECT 
                fam.application_id,
                fam.id,
                fam.tgl_lahir,
                fam.no_hp,
                fam.`status`,
                fam.nama,
                fam.jenis_kelamin,
                fam.tempat_lahir,
                fam.pendidikan AS id_pendidikan,
                lvl.name AS pendidikan,
                fam.pekerjaan,
                fam.no_hp

                FROM `fack_families` fam
                JOIN xin_employees emp ON fam.employee_id = emp.user_id
                JOIN xin_qualification_education_level lvl ON lvl.education_level_id = fam.pendidikan
                WHERE
                emp.user_id = '$user_id'";
            return $this->db->query($query)->result();
        } else if ($type == 3) {
            $query = "SELECT 
                qualification_id,
                employee_id,
                lv.`name` AS level,
                qu.`name`,
                from_year,
                qu.education_level_id,
                to_year,
                language_id,
                skill_id,
                `description`
                FROM `xin_employee_qualification` qu
                JOIN xin_qualification_education_level lv ON lv.education_level_id = qu.education_level_id
                WHERE employee_id = '$user_id'";
            return $this->db->query($query)->result();
        } else if ($type == 4) {
            $query = "SELECT
                we.id,
                we.salary_awal,
                we.salary_akhir,
                we.alasan_keluar,
                we.nama_perusahaan,
                we.lokasi,
                we.posisi,
                we.tahun_masuk,
                we.tahun_keluar
            FROM
                `fack_work_experience` we
                LEFT JOIN xin_job_applications app ON app.application_id = we.application_id
                LEFT JOIN xin_employees emp ON app.user_id_emp = emp.user_id 
            WHERE
                we.employee_id = '$user_id'";
            return $this->db->query($query)->result();
        } else {
            $query = "SELECT 
                ct.contract_id,
                ct.contract_type_id,
                ct.title,
                ct.from_date,
                ct.to_date,
                ct.description,
                ct.is_active,
                CASE ct.is_active
                WHEN 1 THEN 'Active'
                ELSE 'Inactive'
                END AS status
                FROM `xin_employee_contract` ct 
                JOIN xin_employees emp ON ct.employee_id = emp.user_id
                WHERE
                emp.user_id = '$user_id'";
            return $this->db->query($query)->result();
        }
    }

    function dt_employees_report($company = null, $department = null, $designation = null)
    {
        if ($designation != null && $department != null && $company != null) {
            $sub_query = "WHERE company_id = $company AND department_id = $department AND designation_id = $designation";
        } else if ($designation == null && $department != null && $company != null) {
            $sub_query = "WHERE company_id = $company AND department_id = $department";
        } else if ($designation == null && $department == null && $company != null) {
            $sub_query = "WHERE company_id = $company";
        } else {
            $sub_query = '';
        }
        $query = "SELECT * FROM data_karyawan $sub_query";
        return $this->db->query($query)->result();
    }
    function dt_employees_report_new($company = null, $department = null, $designation = null)
    {
        if ($designation != null && $department != null && $company != null) {
            $sub_query = "WHERE emp.company_id = $company AND emp.department_id = $department AND emp.designation_id = $designation";
        } else if ($designation == null && $department != null && $company != null) {
            $sub_query = "WHERE emp.company_id = $company AND emp.department_id = $department";
        } else if ($designation == null && $department == null && $company != null) {
            $sub_query = "WHERE emp.company_id = $company";
        } else {
            $sub_query = '';
        }

        $query = "SELECT
                emp.user_id,
                emp.employee_id,
                CONCAT(emp.first_name, ' ', emp.last_name) AS nama_karyawan,
                emp.username,
                comp.`name` AS perusahaan,
                dep.department_name AS departement,
                des.designation_name AS penunjukan,
                rol.role_name,
                sh.shift_name AS shift,
                round((timestampdiff(MONTH, emp.`date_of_joining`, curdate()) / 12), 1) AS `masa_kerja`,
                (case when (emp.`is_active` = 1) then 'Aktif' else 'Tidak Aktif' end) AS `status`,
                emp.`marital_status` AS `marital_status`,
                emp.email,
                emp.date_of_joining AS tgl_gabung,
                abs.tgl AS attendance_date,
                emp.date_of_leaving AS tgl_resign,
                emp.gender AS jenis_kelamin,
                emp.contact_no AS no_kontak,
                emp.address AS alamat,
                emp.city AS kota,
                emp.state AS provinsi,
                emp.zipcode AS kodepos,
                emp.ctm_tempat_lahir,
                emp.date_of_birth,
                emp.ctm_ayah AS ayah,
                emp.ctm_ibu AS ibu,
                `fam`.`suami` AS `suami`,
                `fam`.`istri` AS `istri`,
                `fam`.`banyak_anak` AS `banyak_anak`,
                `fam`.`nama_anak` AS `nama_anak`,
                
                -- PENYESUAIAN ALIAS AGAR COCOK DENGAN DATATABLES
                emp.ctm_noktp AS no_ktp,
                emp.ctm_no_npwp AS npwp,
                agm.type AS agama,
                
                -- PENAMBAHAN KOLOM YANG KURANG SEBELUMNYA (Sesuaikan nama field asli DB jika beda)
                emp.ctm_nokk AS no_kk,
                emp.ctm_faskes_tingkat_pertama AS no_jkn,
                emp.ctm_faskes_dokter_gigi AS no_kpj,
                 concat(`bank`.`account_number`, ' (', `bank`.`bank_name`, ')') AS `bank_account`,
                
                `ctc`.`contract` AS `contract`,
                
                -- Kolom Pendidikan
                edu.pendidikan_1,
                edu.pendidikan_2,
                edu.pendidikan_3,
                edu.pendidikan_4,
                edu.pendidikan_5,
                
                -- Kolom Pengalaman Kerja Baru
                wrk.wrk_1,
                wrk.wrk_2,
                wrk.wrk_3,
                wrk.wrk_4,
                wrk.wrk_5,
                dokumen.`docs` AS `dokumen`,
                loc.location_name AS lokasi_karyawan,
                concat(`up`.`first_name`, ' ', `up`.`last_name`) AS `nama_atasan`,
                emp.wa_notif_reg AS status_nomor

            FROM
                `xin_employees` emp
                LEFT JOIN xin_companies comp ON comp.company_id = emp.company_id
                LEFT JOIN xin_departments dep ON dep.department_id = emp.department_id
                LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
                LEFT JOIN xin_user_roles rol ON rol.role_id = emp.user_role_id
                LEFT JOIN xin_office_shift sh ON sh.office_shift_id = emp.office_shift_id
                LEFT JOIN `xin_employee_bankaccount` bank on `bank`.`employee_id` = `emp`.`user_id`
                LEFT JOIN (
                    SELECT employee_id, attendance_date AS tgl
                    FROM (
                        SELECT 
                            employee_id, 
                            attendance_date,
                            ROW_NUMBER() OVER(PARTITION BY employee_id ORDER BY DATE(attendance_date) DESC) as rn
                        FROM xin_attendance_time
                        WHERE attendance_date IS NOT NULL 
                        AND DATE(attendance_date) <= CURDATE()
                    ) sub_abs
                    WHERE rn = 1
                ) abs ON abs.employee_id = emp.user_id
                LEFT JOIN (
                    select
                        `fack_families`.`employee_id` AS `employee_id`,
                        if((`fack_families`.`status` = 'Istri'), `fack_families`.`nama`, '') AS `istri`,
                        if((`fack_families`.`status` = 'Suami'), `fack_families`.`nama`, '') AS `suami`,
                        count(
                            if(
                            (
                                (substr(`fack_families`.`status`, 1, 4) = 'Anak')
                                and (`fack_families`.`nama` is not null)
                                and (`fack_families`.`nama` <> '')
                            ),
                            1,
                            NULL
                            )
                        ) AS `banyak_anak`,
                        group_concat(if((substr(`fack_families`.`status`, 1, 4) = 'Anak'), `fack_families`.`nama`, NULL) separator ',') AS `nama_anak`
                    from `fack_families`
                    where (`fack_families`.`employee_id` is not null)
                    group by `fack_families`.`employee_id`
                ) `fam` on ((`fam`.`employee_id` = emp.`user_id`))
                LEFT JOIN xin_ethnicity_type agm ON agm.ethnicity_type_id = emp.ethnicity_type
                
                -- PIVOT DATA PENDIDIKAN
                LEFT JOIN (
                    SELECT 
                        employee_id,
                        MAX(CASE WHEN rn = 1 THEN detail_pendidikan END) AS pendidikan_1,
                        MAX(CASE WHEN rn = 2 THEN detail_pendidikan END) AS pendidikan_2,
                        MAX(CASE WHEN rn = 3 THEN detail_pendidikan END) AS pendidikan_3,
                        MAX(CASE WHEN rn = 4 THEN detail_pendidikan END) AS pendidikan_4,
                        MAX(CASE WHEN rn = 5 THEN detail_pendidikan END) AS pendidikan_5
                    FROM (
                        SELECT 
                            employee_id,
                            CONCAT(nama_instansi, ' - (', tahun_masuk_keluar, ')') AS detail_pendidikan,
                            ROW_NUMBER() OVER(PARTITION BY employee_id ORDER BY created_at DESC) as rn
                        FROM fack_education_level
                    ) sub_edu
                    GROUP BY employee_id
                ) edu ON edu.employee_id = emp.user_id

                -- PIVOT DATA PENGALAMAN KERJA (wrk_1 s/d wrk_5)
                LEFT JOIN (
                    SELECT 
                        employee_id,
                        MAX(CASE WHEN rn = 1 THEN detail_pekerjaan END) AS wrk_1,
                        MAX(CASE WHEN rn = 2 THEN detail_pekerjaan END) AS wrk_2,
                        MAX(CASE WHEN rn = 3 THEN detail_pekerjaan END) AS wrk_3,
                        MAX(CASE WHEN rn = 4 THEN detail_pekerjaan END) AS wrk_4,
                        MAX(CASE WHEN rn = 5 THEN detail_pekerjaan END) AS wrk_5
                    FROM (
                        SELECT 
                            employee_id,
                            CONCAT(nama_perusahaan, ' - ', IFNULL(posisi, ''), ' (', IFNULL(tahun_masuk, '-'), ' - ', IFNULL(tahun_keluar, 'Sekarang'), ')') AS detail_pekerjaan,
                            ROW_NUMBER() OVER(PARTITION BY employee_id ORDER BY created_at DESC) as rn
                        FROM fack_work_experience
                    ) sub_wrk
                    GROUP BY employee_id
                ) wrk ON wrk.employee_id = emp.user_id
                
                LEFT JOIN (
                    select
                        `dokumen`.`employee_id` AS `employee_id`,
                        group_concat(`dokumen`.`dok` separator ', ') AS `docs`
                    from
                        (
                            select
                                `xin_employee_documents`.`employee_id` AS `employee_id`,
                                concat(`xin_employee_documents`.`title`, ' - ', `xin_employee_documents`.`description`) AS `dok`
                            from `xin_employee_documents`
                            group by `xin_employee_documents`.`employee_id`
                        ) `dokumen`
                    group by `dokumen`.`employee_id`
                ) `dokumen` on (`dokumen`.`employee_id` = emp.`user_id`)
                LEFT JOIN `xin_office_location` `loc` on ((`loc`.`location_id` = emp.`location_id`))
                LEFT JOIN `xin_employees` `up` on ((`up`.`user_id` = emp.`ctm_report_to`))
                LEFT JOIN (
                    select
                        `kontrak`.`employee_id` AS `employee_id`,
                        group_concat(`kontrak`.`kt` order by `kontrak`.`to_date` ASC separator ', ') AS `contract`
                    from
                        (
                            select
                                `xin_employee_contract`.`employee_id` AS `employee_id`,
                                `xin_employee_contract`.`to_date` AS `to_date`,
                                concat(`xin_employee_contract`.`title`, ' (', `xin_employee_contract`.`from_date`, ' - ', `xin_employee_contract`.`to_date`, ')') AS `kt`
                            from `xin_employee_contract`
                        ) `kontrak`
                    group by `kontrak`.`employee_id`
                ) `ctc` ON `ctc`.`employee_id` = emp.`user_id`

            $sub_query ;";

        return $this->db->query($query)->result();
    }

    public function get_pendidikan($user_id)
    {
        return $this->db->query("SELECT
			CONCAT( pendidikan.`name`, ' - ', pendidikan.description, ' (', pendidikan.from_year, ' sd ', pendidikan.to_year, ')' ) AS pend 
		FROM
			(
			SELECT
				xin_employee_qualification.employee_id,
				xin_employee_qualification.`name`,
				xin_employee_qualification.description,
				xin_employee_qualification.from_year,
				xin_employee_qualification.to_year 
			FROM
				xin_employee_qualification 
			WHERE
				xin_employee_qualification.employee_id = $user_id 
			ORDER BY
			xin_employee_qualification.to_year ASC 
			) AS pendidikan")->result();
    }

    public function get_work($user_id)
    {
        return $this->db->query("SELECT
			CONCAT( `work`.company_name, ' - ', `work`.post, ' (', `work`.from_date, ' sd ', `work`.to_date, ')' ) AS wrk 
		FROM
			(
			SELECT
				xin_employee_work_experience.company_name,
				xin_employee_work_experience.post,
				xin_employee_work_experience.from_date,
				xin_employee_work_experience.to_date 
			FROM
				xin_employee_work_experience 
			WHERE
				xin_employee_work_experience.employee_id = $user_id
			ORDER BY
				to_date DESC 
			) AS `work` 
		ORDER BY
			`work`.to_date ASC 
			LIMIT 5")->result();
    }


    public function get_last_attendance($user_id)
    {
        $data = $this->db->query("SELECT
			xin_attendance_time.employee_id,
			MAX( xin_attendance_time.attendance_date ) AS attendance_date 
		FROM
			xin_attendance_time 
		WHERE
			xin_attendance_time.employee_id = $user_id 
		GROUP BY
			xin_attendance_time.employee_id")->row_array();

        return $data['attendance_date'];
    }
}
