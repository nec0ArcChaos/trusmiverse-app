<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_fdk extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_data($start, $end)
    {
        $query = "SELECT
            emp.user_id,
            CONCAT( emp.first_name, ' ', emp.last_name ) AS nama,
            CONCAT( pic_req.first_name, ' ', pic_req.last_name ) AS pic_nama,
            com.`alias` AS company,
            des.designation_name,
            fdk.ktp, 
            fdk.kk,
            fdk.lamaran,
            fdk.cv,
            fdk.ijazah,
            fdk.transkip,
            fdk.npwp,
            fdk.surat_lulus,
            fdk.verklaring,
            fdk.sertifikat,
            fdk.dokumen_lain,
            COALESCE(fdk.updated_at,COALESCE(fdk.created_at,'-')) AS updated_at,
            fdk.created_at,
            COALESCE(ktp.dokumen,'-') AS ktp_status, 
            COALESCE(kk.dokumen,'-') AS kk_status,
            COALESCE(lamaran.dokumen,'-') AS lamaran_status,
            COALESCE(cv.dokumen,'-') AS cv_status,
            COALESCE(ijazah.dokumen,'-') AS ijazah_status,
            COALESCE(transkip.dokumen,'-') AS transkip_status,
            COALESCE(npwp.dokumen,'-') AS npwp_status,
            COALESCE(surat_lulus.dokumen,'-') AS surat_lulus_status,
            COALESCE(verklaring.dokumen,'-') AS verklaring_status,
            COALESCE(sertifikat.dokumen,'-') AS sertifikat_status,
            COALESCE(dokumen_lain.dokumen,'-') AS dokumen_lain_status,
			IF(f_st.status IS NOT NULL, f_st.status, 'Pending') AS fdk_status,
            emp.date_of_joining,
            CASE ja.type
            WHEN 'Sales Inhouse' THEN 'Inhouse'
            WHEN 'Sales Freelance' THEN 'Freelance'
            ELSE '-'
            END AS type_sales,
            COUNT(ct.id) AS contact
			
		    FROM
                    xin_employees emp

                    LEFT JOIN fdk ON emp.user_id = fdk.employee_id
                    LEFT JOIN fdk_contact ct ON fdk.employee_id = ct.employee_id
                    LEFT JOIN fdk_status f_st ON fdk.status = f_st.id
                    LEFT JOIN fdk_status ktp ON fdk.ktp_status = ktp.id
                    LEFT JOIN fdk_status kk ON fdk.kk_status = kk.id
                    LEFT JOIN fdk_status lamaran ON fdk.lamaran_status = lamaran.id
                    LEFT JOIN fdk_status cv ON fdk.cv_status = cv.id
                    LEFT JOIN fdk_status ijazah ON fdk.ijazah_status = ijazah.id
                    LEFT JOIN fdk_status transkip ON fdk.transkip_status = transkip.id
                    LEFT JOIN fdk_status npwp ON fdk.npwp_status = npwp.id
                    LEFT JOIN fdk_status surat_lulus ON fdk.surat_lulus_status = surat_lulus.id
                    LEFT JOIN fdk_status verklaring ON fdk.verklaring_status = verklaring.id
                    LEFT JOIN fdk_status sertifikat ON fdk.sertifikat_status = sertifikat.id
                    LEFT JOIN fdk_status dokumen_lain ON fdk.dokumen_lain_status = dokumen_lain.id
                    JOIN xin_companies com ON emp.company_id = com.company_id
                    JOIN xin_designations des ON emp.designation_id = des.designation_id 
                    LEFT JOIN fack_personal_details fc ON fc.employee_id = emp.user_id
                    LEFT JOIN xin_job_applications ja ON ja.application_id = fc.application_id  AND ja.application_status = 7
                    LEFT JOIN xin_jobs job ON job.job_id = ja.job_id
                    LEFT JOIN xin_employees pic_req ON pic_req.user_id = job.pic
                WHERE
                    -- emp.is_active = 1 
                
                -- AND 
                SUBSTR( emp.date_of_joining, 1, 10 ) BETWEEN '$start' 
            AND '$end' AND fc.employee_id IS NOT NULL
            GROUP BY emp.user_id
            ORDER BY emp.date_of_joining DESC
        ";
        return $this->db->query($query)->result();
    }
    function get_data_appl()
    {
        $query = "SELECT
            emp.user_id,
            CONCAT( emp.first_name, ' ', emp.last_name ) AS nama,
            CONCAT( pic_req.first_name, ' ', pic_req.last_name ) AS pic_nama,
            com.`alias` AS company,
            des.designation_name,
            fdk.ktp, 
            fdk.kk,
            fdk.lamaran,
            fdk.cv,
            fdk.ijazah,
            fdk.transkip,
            fdk.npwp,
            fdk.surat_lulus,
            fdk.verklaring,
            fdk.sertifikat,
            fdk.dokumen_lain,
            COALESCE(ktp.dokumen,'-') AS ktp_status, 
            COALESCE(kk.dokumen,'-') AS kk_status,
            COALESCE(lamaran.dokumen,'-') AS lamaran_status,
            COALESCE(cv.dokumen,'-') AS cv_status,
            COALESCE(ijazah.dokumen,'-') AS ijazah_status,
            COALESCE(transkip.dokumen,'-') AS transkip_status,
            COALESCE(npwp.dokumen,'-') AS npwp_status,
            COALESCE(surat_lulus.dokumen,'-') AS surat_lulus_status,
            COALESCE(verklaring.dokumen,'-') AS verklaring_status,
            COALESCE(sertifikat.dokumen,'-') AS sertifikat_status,
            COALESCE(dokumen_lain.dokumen,'-') AS dokumen_lain_status,
			IF(f_st.status IS NOT NULL, f_st.status, 'Pending') AS fdk_status,
            emp.date_of_joining,
            CASE ja.type
            WHEN 'Sales Inhouse' THEN 'Inhouse'
            WHEN 'Sales Freelance' THEN 'Freelance'
            ELSE '-'
            END AS type_sales
			
		    FROM
                    fdk
                    LEFT JOIN xin_employees emp ON emp.user_id = fdk.employee_id
                    LEFT JOIN fdk_status f_st ON fdk.status = f_st.id
                    LEFT JOIN fdk_status ktp ON fdk.ktp_status = ktp.id
                    LEFT JOIN fdk_status kk ON fdk.kk_status = kk.id
                    LEFT JOIN fdk_status lamaran ON fdk.lamaran_status = lamaran.id
                    LEFT JOIN fdk_status cv ON fdk.cv_status = cv.id
                    LEFT JOIN fdk_status ijazah ON fdk.ijazah_status = ijazah.id
                    LEFT JOIN fdk_status transkip ON fdk.transkip_status = transkip.id
                    LEFT JOIN fdk_status npwp ON fdk.npwp_status = npwp.id
                    LEFT JOIN fdk_status surat_lulus ON fdk.surat_lulus_status = surat_lulus.id
                    LEFT JOIN fdk_status verklaring ON fdk.verklaring_status = verklaring.id
                    LEFT JOIN fdk_status sertifikat ON fdk.sertifikat_status = sertifikat.id
                    LEFT JOIN fdk_status dokumen_lain ON fdk.dokumen_lain_status = dokumen_lain.id
                    JOIN xin_companies com ON emp.company_id = com.company_id
                    JOIN xin_designations des ON emp.designation_id = des.designation_id 
                    LEFT JOIN xin_job_applications ja ON ja.user_id_emp = emp.user_id
                    LEFT JOIN trusmi_interview i ON i.application_id = ja.application_id
                    LEFT JOIN xin_employees pic_req ON pic_req.user_id = i.created_by
                WHERE
                    fdk.status IN ( 2,3)
                    AND (
                        fdk.ktp_status != 2 OR
                        fdk.kk_status != 2 OR
                        fdk.lamaran_status != 2 OR
                        fdk.cv_status != 2 OR
                        fdk.ijazah_status != 2 OR
                        fdk.transkip_status != 2 OR
                        fdk.npwp_status != 2 OR
                        fdk.surat_lulus_status != 2 OR
                        fdk.verklaring_status != 2 OR
                        fdk.sertifikat_status != 2 OR
                        fdk.dokumen_lain_status != 2
                    )
                    GROUP BY fdk.employee_id
            ORDER BY fdk.created_at DESC
        ";
        return $this->db->query($query)->result();
    }
    function karyawan($id)
    {
        $query = "SELECT
        xin_employees.user_id, xin_employees.username, CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS full_name, xin_employees.designation_id, xin_designations.designation_name, fdk.ktp, fdk.kk, fdk.lamaran, fdk.cv, fdk.ijazah, fdk.transkip, fdk.npwp, fdk.surat_lulus, fdk.verklaring, fdk.sertifikat, fdk.dokumen_lain, fdk.status, xin_employees.contact_no, com.name AS company_name,fdk.ktp_status, fdk.kk_status, fdk.lamaran_status, fdk.cv_status, fdk.ijazah_status, fdk.transkip_status, fdk.npwp_status, fdk.surat_lulus_status, fdk.verklaring_status, fdk.sertifikat_status, fdk.dokumen_lain_status,pic_req.user_id AS user_id_pic,pic_req.contact_no AS pic_contact_no, ja.type AS sales_type, fdk.contact
        
        FROM xin_employees
        LEFT JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
        LEFT JOIN xin_companies com ON xin_employees.company_id = com.company_id
        LEFT JOIN fdk ON xin_employees.user_id = fdk.employee_id
        LEFT JOIN xin_job_applications ja ON ja.user_id_emp = xin_employees.user_id
        AND ja.application_status = 7
        LEFT JOIN xin_jobs job ON job.job_id = ja.job_id
        LEFT JOIN xin_employees pic_req ON pic_req.user_id = job.pic 
        
        WHERE xin_employees.user_id = '$id'";
        return $this->db->query($query)->row_array();
    }
    // public function get_required(){

    // }
    function update_dokumen_wajib($user_id, $data)
    {
        // $this->db->where('user_id', $user_id);
        // $query = $this->db->get('fdk');

        // if ($query->num_rows() > 0) {
        //     $this->db->where('user_id', $user_id);
        //     $hasil = $this->db->update('fdk', $data);
        // } else {
        //     $data['user_id'] = $user_id;
            $hasil = $this->db->insert('fdk', $data);
        // }
        return $hasil;
    }
    function update_dokumen_optional($user_id, $data)
    {
        $this->db->where('employee_id', $user_id);
        $hasil = $this->db->update('fdk', $data);
        return $hasil;
    }
    function update_one_file($user_id, $column, $value)
    {
        $this->db->set($column . '_status', 0);
        $this->db->set($column, $value);
        $this->db->where('employee_id', $user_id);
        $hasil = $this->db->update("fdk");
        return $hasil;
    }
    function submit_form($user_id)
    {
        $this->db->set('updated_at', date('Y-m-d H:i:s'));
        $this->db->set('status', 2);
        $this->db->where('employee_id', $user_id);
        return $this->db->update('fdk');
    }
    function get_karyawan()
    {
        $query = "SELECT
        xin_job_applications.application_id ,xin_employees.user_id, xin_employees.username, xin_job_applications.full_name, designation_name, xin_companies.name AS company, CONCAT(xin_employees.first_name,' ',xin_employees.last_name) AS nama_karyawan
        
        FROM xin_employees
        LEFT JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
        LEFT JOIN xin_job_applications ON xin_employees.user_id = xin_job_applications.user_id_emp
        LEFT JOIN xin_companies ON xin_employees.company_id = xin_companies.company_id
        LEFT JOIN fdk ON xin_employees.user_id = fdk.employee_id
        WHERE xin_employees.is_active = '1' AND fdk.employee_id IS NULL
        ORDER BY nama_karyawan ASC
        ";
        return $this->db->query($query)->result();
    }
    function get_detail_karyawan($user_id)
    {
        $query = "SELECT
            ja.application_id,
            CONCAT( pic_req.first_name, ' ', pic_req.last_name ) AS pic_req_name,
            COALESCE (
            IF
                (
                    SUBSTR( REPLACE ( REPLACE ( REPLACE ( pic_req.contact_no, '+', '' ), '-', '' ), ' ', '' ), 1, 1 ) = '0',
                    CONCAT(
                        '62',
                    SUBSTR( REPLACE ( REPLACE ( REPLACE ( pic_req.contact_no, '+', '' ), '-', '' ), ' ', '' ), 2 )),
                    REPLACE ( REPLACE ( REPLACE ( pic_req.contact_no, '+', '' ), '-', '' ), ' ', '' ) 
                ),
                '' 
            ) AS pic_req_no_hp,
            TRIM(
            CONCAT( e.first_name, ' ', REPLACE ( e.last_name, ' (Karyawan Baru)', '' ) )) AS employee_name,
            d.department_name,
            d.publik,-- IF(d.publik = 1,'https://bit.ly/trusmiontime_quiz_130_mkt','https://bit.ly/trusmiontime_quiz_130') AS link_absen,
                CASE
                
                WHEN e.company_id = 3 THEN
                'https://trusmicorp.com/apk/trusmiontime_bali/trusmiontime_bali.apk' ELSE
            IF
                ( d.publik = 1, 'https://bit.ly/trusmiontime_quiz_130_mkt', 'https://bit.ly/trusmiontime_quiz_130' ) 
            END AS link_absen,
            ds.designation_name,
            ol.location_name,
            e.username,
            '12345678' AS `password`,
            COALESCE (
            IF
                (
                    SUBSTR( REPLACE ( REPLACE ( REPLACE ( e.contact_no, '+', '' ), '-', '' ), ' ', '' ), 1, 1 ) = '0',
                    CONCAT(
                        '62',
                    SUBSTR( REPLACE ( REPLACE ( REPLACE ( e.contact_no, '+', '' ), '-', '' ), ' ', '' ), 2 )),
                    REPLACE ( REPLACE ( REPLACE ( e.contact_no, '+', '' ), '-', '' ), ' ', '' ) 
                ),
                '' 
            ) AS contact_no 
        FROM
            xin_employees e
            LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
            LEFT JOIN xin_job_applications ja ON ja.user_id_emp = e.user_id
            LEFT JOIN trusmi_interview i ON i.application_id = ja.application_id
            LEFT JOIN xin_employees pic_req ON pic_req.user_id = i.created_by
            LEFT JOIN xin_departments d ON d.department_id = e.department_id
            LEFT JOIN xin_office_location ol ON ol.location_id = e.location_id 
        WHERE
            e.user_id = '$user_id'";
        return $this->db->query($query)->row_object();
    }
    public function get_print_view($user_id)
    {
        $query = "SELECT
            emp.user_id,
            CONCAT( emp.first_name, ' ', emp.last_name ) AS nama,
            com.`name` AS company,
            des.designation_name,
            fdk.ktp, 
            fdk.kk,
            fdk.lamaran,
            fdk.cv,
            fdk.ijazah,
            fdk.transkip,
            fdk.npwp,
            fdk.surat_lulus,
            fdk.verklaring,
            fdk.sertifikat,
            fdk.dokumen_lain,
            COALESCE(ktp.dokumen,'-') AS ktp_status, 
            COALESCE(kk.dokumen,'-') AS kk_status,
            COALESCE(lamaran.dokumen,'-') AS lamaran_status,
            COALESCE(cv.dokumen,'-') AS cv_status,
            COALESCE(ijazah.dokumen,'-') AS ijazah_status,
            COALESCE(transkip.dokumen,'-') AS transkip_status,
            COALESCE(npwp.dokumen,'-') AS npwp_status,
            COALESCE(surat_lulus.dokumen,'-') AS surat_lulus_status,
            COALESCE(verklaring.dokumen,'-') AS verklaring_status,
            COALESCE(sertifikat.dokumen,'-') AS sertifikat_status,
            COALESCE(dokumen_lain.dokumen,'-') AS dokumen_lain_status,
						IF(f_st.status IS NOT NULL, f_st.status, 'Pending') AS fdk_status,
						fdk.created_at,
						COALESCE(CONCAT(ap_ktp.first_name,' ',ap_ktp.last_name),'-') AS ap_ktp,
						COALESCE(CONCAT(ap_kk.first_name,' ',ap_kk.last_name),'-') AS ap_kk,
						COALESCE(CONCAT(ap_lamaran.first_name,' ',ap_lamaran.last_name),'-') AS ap_lamaran,
						COALESCE(CONCAT(ap_cv.first_name,' ',ap_cv.last_name),'-') AS ap_cv,
						COALESCE(CONCAT(ap_ijazah.first_name,' ',ap_ijazah.last_name),'-') AS ap_ijazah,
						COALESCE(CONCAT(ap_transkip.first_name,' ',ap_transkip.last_name),'-') AS ap_transkip,
						COALESCE(CONCAT(ap_npwp.first_name,' ',ap_npwp.last_name),'-') AS ap_npwp,
						COALESCE(CONCAT(ap_surat_lulus.first_name,' ',ap_surat_lulus.last_name),'-') AS ap_surat_lulus,
						COALESCE(CONCAT(ap_verklaring.first_name,' ',ap_verklaring.last_name),'-') AS ap_verklaring,
						COALESCE(CONCAT(ap_sertifikat.first_name,' ',ap_sertifikat.last_name),'-') AS ap_sertifikat,
						COALESCE(CONCAT(ap_dokumen_lain.first_name,' ',ap_dokumen_lain.last_name),'-') AS ap_dokumen_lain,
                        fdk.ktp_approve_at,
                        fdk.kk_approve_at,
                        fdk.lamaran_approve_at,
                        fdk.cv_approve_at,
                        fdk.ijazah_approve_at,
                        fdk.transkip_approve_at,
                        fdk.npwp_approve_at,
                        fdk.surat_lulus_approve_at,
                        fdk.verklaring_approve_at,
                        fdk.sertifikat_approve_at,
                        fdk.dokumen_lain_approve_at
		    FROM
                    xin_employees emp
                    LEFT JOIN fdk ON emp.user_id = fdk.employee_id
                    LEFT JOIN fdk_status f_st ON fdk.status = f_st.id
                    LEFT JOIN fdk_status ktp ON fdk.ktp_status = ktp.id
                    LEFT JOIN fdk_status kk ON fdk.kk_status = kk.id
                    LEFT JOIN fdk_status lamaran ON fdk.lamaran_status = lamaran.id
                    LEFT JOIN fdk_status cv ON fdk.cv_status = cv.id
                    LEFT JOIN fdk_status ijazah ON fdk.ijazah_status = ijazah.id
                    LEFT JOIN fdk_status transkip ON fdk.transkip_status = transkip.id
                    LEFT JOIN fdk_status npwp ON fdk.npwp_status = npwp.id
                    LEFT JOIN fdk_status surat_lulus ON fdk.surat_lulus_status = surat_lulus.id
                    LEFT JOIN fdk_status verklaring ON fdk.verklaring_status = verklaring.id
                    LEFT JOIN fdk_status sertifikat ON fdk.sertifikat_status = sertifikat.id
                    LEFT JOIN fdk_status dokumen_lain ON fdk.dokumen_lain_status = dokumen_lain.id
										LEFT JOIN xin_employees ap_ktp ON fdk.ktp_approve_by = ap_ktp.user_id
										LEFT JOIN xin_employees ap_kk ON fdk.kk_approve_by = ap_kk.user_id
										LEFT JOIN xin_employees ap_lamaran ON fdk.lamaran_approve_by = ap_lamaran.user_id
										LEFT JOIN xin_employees ap_cv ON fdk.cv_approve_by = ap_cv.user_id
										LEFT JOIN xin_employees ap_ijazah ON fdk.ijazah_approve_by = ap_ijazah.user_id
										LEFT JOIN xin_employees ap_transkip ON fdk.transkip_approve_by = ap_transkip.user_id
										LEFT JOIN xin_employees ap_npwp ON fdk.npwp_approve_by = ap_npwp.user_id
										LEFT JOIN xin_employees ap_surat_lulus ON fdk.surat_lulus_approve_by = ap_surat_lulus.user_id
										LEFT JOIN xin_employees ap_verklaring ON fdk.verklaring_approve_by = ap_verklaring.user_id
										LEFT JOIN xin_employees ap_sertifikat ON fdk.sertifikat_approve_by = ap_sertifikat.user_id
										LEFT JOIN xin_employees ap_dokumen_lain ON fdk.dokumen_lain_approve_by = ap_dokumen_lain.user_id
                    JOIN xin_companies com ON emp.company_id = com.company_id
                    JOIN xin_designations des ON emp.designation_id = des.designation_id 
                WHERE
                    fdk.employee_id = '$user_id'";
        return $this->db->query($query)->row_object();
    }
    public function cek_all_approve($user_id)
    {
        $query = "SELECT 
            CASE WHEN ktp_status = 2 AND kk_status = 2 AND lamaran_status = 2 AND cv_status = 2 AND ijazah_status = 2 THEN 'Approved' 
            ELSE 'Not'
            END AS status_dokumen
            FROM
            fdk
            WHERE
            employee_id = '$user_id'";
        return $this->db->query($query)->row_object();
    }
    public function insert_contact($data)
    {
        return $this->db->insert('fdk_contact', $data);
    }
    public function get_all_contact()
    {
        $query = "SELECT
                id,
                name,
                REPLACE (
                    REPLACE (
                        REPLACE (
                        IF
                            (
                                SUBSTR( fdk_contact.phone, 1, 2 ) != '62',
                                CONCAT(
                                    '62',
                                    SUBSTR(
                                        fdk_contact.phone,
                                        3,
                                    LENGTH( fdk_contact.phone ))),
                                fdk_contact.phone 
                            ),
                            '-',
                            '' 
                        ),
                        '+',
                        '' 
                    ),
                    ' ',
                    '' 
                ) AS phone 
            FROM
                fdk_contact 
            WHERE
                status = 0
                LIMIT 150";
        return $this->db->query($query)->result();
    }
    function get_contact($id)
    {
        $query = "SELECT
	fdk_contact.id,
	fdk_contact.employee_id,
	fdk_contact.name,
	fdk_contact.phone,
	fdk_contact.email,
	fdk_contact.status,
	fdk_status.contact,
	fdk_contact.created_at 
FROM
	fdk_contact
	JOIN fdk_status ON fdk_contact.status = fdk_status.id 
WHERE
	employee_id = '$id'";
        return $this->db->query($query)->result();
    }
    function get_view_fdk_notif()
    {
        $query = "SELECT * FROM view_fdk_notif";
        return $this->db->query($query)->result();
    }
    public function profile_karir($application_id){
        $query = "SELECT
                job.application_id,
                job.full_name,
                job.contact,
                job.email,
                job.tgl_lahir,
                job.alamat_ktp,
                job.id_user_talent,
                prof.photo,
                upro.cv
                FROM
                `xin_job_applications` job
                LEFT JOIN talent_pool.users prof ON prof.id_user = job.id_user_talent
                LEFT JOIN talent_pool.users_profile upro ON upro.id_user = prof.id_user
                WHERE
                application_id = $application_id;";
        return $this->db->query($query)->row_object();
    }
}
