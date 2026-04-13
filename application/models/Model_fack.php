<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_fack extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function company(){
        $query = "SELECT * FROM xin_companies";
        return $this->db->query($query)->result();
    }
    public function department($id){
        $query = "SELECT * FROM xin_departments WHERE company_id = '$id'";
        return $this->db->query($query)->result();
    }


    public function dt_fack($start, $end)
    {
        $query = "SELECT
                    fa.application_id,
                    fa.employee_id,
                    COALESCE(fa.pas_foto,'') AS pas_foto,
                    COALESCE(fa.nama,'') AS employee_name,
                    COALESCE(fa.no_ktp,'') AS no_ktp,
                    COALESCE(fa.no_npwp,'') AS no_npwp,
                    COALESCE(fa.tempat_lahir,'') AS tempat_lahir,
                    COALESCE(fa.tgl_lahir,'') AS tgl_lahir,
                    COALESCE(fa.`status`,'') AS `status`,
                    COALESCE(fa.`agama`,'') AS `id_agama`,
                    COALESCE(m_agama.`type`,'') AS `agama`,
                    COALESCE(fa.`kewarganegaraan`,'') AS `kewarganegaraan`,
                    COALESCE(fa.`alamat_ktp`,'') AS `alamat_ktp`,
                    COALESCE(fa.`alamat_saat_ini`,'') AS `alamat_saat_ini`,
                    COALESCE(fa.`no_hp`,'') AS `no_hp`,
                    COALESCE(fa.`email`,'') AS `email`,
                    COALESCE(ja.gender,'') AS gender,
                    COALESCE(ja.type,'') AS type,
                    COALESCE(ja.grade,'') AS grade,
                    COALESCE(fa.kesediaan_1,'') AS tgl_bersedia_gabung,
                    COALESCE(REPLACE(fa.kesediaan_3,'\n',''),'') AS kesediaan_kendaraan,
                    COALESCE(REPLACE(fa.kesediaan_4,'\n',''),'') AS kesediaan_laptop,
                    COALESCE(REPLACE(fa.kesediaan_5,'\n',''),'') AS kesediaan_mess,
                    -- c.`name` AS company_name,
                    c2.`company_name` AS company_name,
                    jt.type AS job_type,
                    ur.role_name AS job_level,
                    j.job_title,
                    j.short_description,
                    ja.contact,
                    COALESCE(fa.is_link_expired,'') AS is_link_expired,
                    COALESCE(e.user_id,'') AS user_id,
                    COALESCE(e.date_of_joining,'') AS date_of_joining,
                    COALESCE(e.ctm_kendaraan,'') AS ctm_kendaraan,
                    COALESCE(e.ctm_laptop,'') AS ctm_laptop,
                    COALESCE(e.ctm_mess,'') AS ctm_mess,
                    COALESCE(ta.keterangan,'') AS keterangan,
                    COALESCE(tjr.job_id,'') AS job_request_id
                FROM
                    fack_personal_details fa
                    LEFT JOIN `xin_job_applications` ja ON ja.application_id = fa.application_id
                    LEFT JOIN xin_employees e ON e.user_id = ja.user_id_emp
                    LEFT JOIN xin_jobs j ON j.job_id = ja.job_id
                    LEFT JOIN xin_users u ON ja.user_id = u.company_id
                    LEFT JOIN xin_companies c ON c.company_id = u.company_id
                    LEFT JOIN xin_users c2 ON c2.user_id = u.company_id
                    LEFT JOIN xin_job_type jt ON jt.job_type_id = j.job_type
                    LEFT JOIN xin_user_roles ur ON j.position_id = ur.role_id
                    LEFT JOIN xin_ethnicity_type m_agama ON m_agama.ethnicity_type_id = fa.agama
                    LEFT JOIN trusmi_administrasi ta ON ta.application_id = fa.application_id
                    LEFT JOIN trusmi_jobs_request tjr ON tjr.job_id = j.reff_job_id
                    -- LEFT JOIN xin_users tu ON tjr.employer_id = tu.user_id
                WHERE
                    ja.application_status IN (5,7) AND SUBSTR(fa.created_at,1,10) BETWEEN '$start' AND '$end'";
        return $this->db->query($query)->result();
    }


    public function get_data_calon_karyawan_by_id($applicant_id)
    {
        $query = "SELECT
                    a.application_id,
                    a.user_id_emp AS employee_id,
                    a.full_name,
                    COALESCE(fp.no_hp,a.contact) AS no_hp,
                    COALESCE(fp.email,a.email) AS email,
                    COALESCE(fp.no_ktp,'') AS no_ktp,
                    COALESCE(fp.no_kk,'') AS no_kk,
                    COALESCE(fp.no_npwp,'') AS no_npwp,
                    COALESCE(fp.pas_foto,'') AS pas_foto,
                    a.message,
                    a.pendidikan AS pendidikan,
                    el.`name` AS pendidikan_name,
                    a.tempat_pendidikan,
                    a.posisi_kerja_terakhir,
                    a.tempat_kerja_terakhir,
                    a.masa_kerja_terakhir,
                    a.jurusan,
                    a.gender,
                    COALESCE(fp.tempat_lahir,a.tempat_lahir) AS tempat_lahir,
                    COALESCE(fp.tgl_lahir,a.tgl_lahir) AS tgl_lahir,
                    a.domisili,
                    COALESCE(fp.alamat_ktp,a.alamat_ktp) AS alamat_ktp,
                    COALESCE(fp.alamat_saat_ini,'') AS alamat_saat_ini,
                    a.agama AS id_agama,
                    et.type AS agama,
                    a.status_pernikahan,
                    a.salary,
                    j.job_title,
                    COALESCE(fp.motivasi,'') AS motivasi,
                    COALESCE(fp.kesediaan_1,'') AS kesediaan_1,
                    COALESCE(fp.kesediaan_2,'') AS kesediaan_2,
                    COALESCE(fp.kesediaan_3,'') AS kesediaan_3,
                    COALESCE(fp.kesediaan_4,'') AS kesediaan_4,
                    COALESCE(fp.kesediaan_5,'') AS kesediaan_5,
                    COALESCE(fp.hobi,'') AS hobi,
                    COALESCE(fp.is_link_expired,'') AS is_link_expired,
                    a.job_resume,

                    a.status_interview,
                    a.tgl_interview,
                    a.jam_interview,
                    a.lokasi_interview,
                    a.alasan_interview,
                    a.is_lolos,
                    a.hasil_interview
                FROM
                    `xin_job_applications` a
                    LEFT JOIN fack_personal_details fp ON fp.application_id = a.application_id
                    LEFT JOIN xin_jobs j ON j.job_id = a.job_id
                    LEFT JOIN xin_ethnicity_type et ON et.ethnicity_type_id = a.agama
                    LEFT JOIN xin_qualification_education_level el ON el.education_level_id = a.pendidikan
                    WHERE a.application_id = '$applicant_id'";
        return $this->db->query($query)->row_array();
    }

    public function get_agama()
    {
        $query = "SELECT ethnicity_type_id AS id_agama, type AS agama FROM `xin_ethnicity_type`";
        return $this->db->query($query)->result();
    }

    public function get_pendidikan()
    {
        $query = "SELECT education_level_id AS id_pendidikan, `name` AS pendidikan FROM `xin_qualification_education_level`";
        return $this->db->query($query)->result();
    }

    public function check_status_sudah_input($application_id)
    {
        $query = "SELECT `status` AS status_ada FROM fack_families WHERE application_id = '$application_id'";
        return $this->db->query($query)->result();
    }

    public function check_status_sudah_input_tingkat_pendidikan($application_id)
    {
        $query = "SELECT `tingkat_pendidikan` AS tingkat_pendidikan_ada FROM fack_education_level WHERE application_id = '$application_id '";
        return $this->db->query($query)->result();
    }

    public function get_designation($id = null)
    {
        $kondisi = "";
        if($id != null){
            $kondisi = "AND ds.department_id = '$id'";
        }
        $query = "SELECT
                    CONCAT( ds.designation_id, '|', d.department_id, '|', d.company_id ) AS id_designation_administrasi,
                    CONCAT( ds.designation_name, ', ', d.department_name, ', ', c.`name` ) AS designation_administrasi,
                    ds.designation_name
                FROM
                    `xin_designations` ds
                    JOIN xin_departments d ON d.department_id = ds.department_id 
                    AND d.company_id = ds.company_id
                    JOIN xin_companies c ON c.company_id = d.company_id
                    WHERE ds.hide != 1
                    $kondisi
                    GROUP BY ds.designation_id
	                ORDER BY designation_name";
        return $this->db->query($query)->result();
    }

    public function get_office_shifts()
    {
        $query = "SELECT office_shift_id, shift_name FROM xin_office_shift ORDER BY shift_name ASC";
        return $this->db->query($query)->result();
    }

    public function get_user_roles()
    {
        $query = "SELECT role_id, role_name FROM xin_user_roles WHERE role_id NOT IN (1) ORDER BY `level` DESC, level_sto ASC";
        return $this->db->query($query)->result();
    }

    public function get_leaves_type()
    {
        $query = "SELECT leave_type_id, type_name FROM xin_leave_type ORDER BY type_name";
        return $this->db->query($query)->result();
    }

    public function get_location()
    {
        $query = "SELECT l.location_id, CONCAT(l.location_name,' ( ',COALESCE(c.`name`,'No Data Company'),' ) ') AS location_name FROM `xin_office_location` l
        LEFT JOIN xin_companies c ON c.company_id = l.company_id ORDER BY l.location_name ASC";
        return $this->db->query($query)->result();
    }
    public function get_pt()
    {
        $query = "SELECT id_pt, CONCAT(kode_pt,'*',nama_pt) AS nama_pt FROM `trusmi_m_pt`";
        return $this->db->query($query)->result();
    }

    public function get_send_offering_result($application_id)
    {
        return $this->db->query("SELECT
                                    jobs.job_id,
                                    comp.`name` AS company,
                                    dep.department_name AS department,
                                    COALESCE ( dg.designation_name, req.job_title ) AS position,
                                    role.role_name AS `level`,
                                    jobs.job_vacancy AS need,
                                    type.type AS `status`,
                                    jobs.long_description AS jobdesk,
                                    app.full_name,
                                    adm.keterangan,
                                    em.ctm_kendaraan AS kendaraan,
                                    em.ctm_laptop AS laptop,
                                    em.ctm_mess AS mess,
                                    em.date_of_joining,
                                    COALESCE (
                                    IF
                                        (
                                            LEFT ( pic.contact_no, 1 ) = '0',
                                            CONCAT(
                                                REPLACE ( LEFT ( pic.contact_no, 1 ), '0', '62' ),
                                            SUBSTR( pic.contact_no, 2 )),
                                            pic.contact_no 
                                        ),
                                        '' 
                                    ) AS pic_contact,
                                    COALESCE (
                                    IF
                                        (
                                            LEFT ( requester.contact_no, 1 ) = '0',
                                            CONCAT(
                                                REPLACE ( LEFT ( requester.contact_no, 1 ), '0', '62' ),
                                            SUBSTR( requester.contact_no, 2 )),
                                            requester.contact_no 
                                        ),
                                        '' 
                                    ) AS req_contact,
                                    COALESCE (
                                    IF
                                        (
                                            LEFT ( aprv.contact_no, 1 ) = '0',
                                            CONCAT(
                                                REPLACE ( LEFT ( aprv.contact_no, 1 ), '0', '62' ),
                                            SUBSTR( aprv.contact_no, 2 )),
                                            aprv.contact_no 
                                        ),
                                        '' 
                                    ) AS aprv_contact,
                                    COALESCE (
                                    IF
                                        (
                                            LEFT ( usr_interview.contact_no, 1 ) = '0',
                                            CONCAT(
                                                REPLACE ( LEFT ( usr_interview.contact_no, 1 ), '0', '62' ),
                                            SUBSTR( usr_interview.contact_no, 2 )),
                                            usr_interview.contact_no 
                                        ),
                                        '' 
                                    ) AS interview_contact 
                                FROM
                                    trusmi_administrasi AS adm
                                    JOIN xin_job_applications AS app ON app.application_id = adm.application_id
                                    LEFT JOIN trusmi_interview AS intv ON intv.application_id = app.application_id
                                    JOIN xin_jobs AS jobs ON jobs.job_id = app.job_id
                                    LEFT JOIN trusmi_jobs_request AS req ON req.job_id = jobs.reff_job_id
                                    LEFT JOIN xin_users AS emp ON emp.user_id = req.employer_id
                                    LEFT JOIN xin_designations AS dg ON dg.designation_id = jobs.designation_id
                                    LEFT JOIN xin_companies AS comp ON comp.company_id = COALESCE ( dg.company_id, emp.company_id )
                                    LEFT JOIN xin_departments AS dep ON dep.department_id = COALESCE ( dg.department_id, req.department_id )
                                    LEFT JOIN xin_employees AS lvl ON lvl.designation_id = dg.designation_id
                                    LEFT JOIN xin_user_roles AS role ON role.role_id = COALESCE ( lvl.user_role_id, req.position_id )
                                    LEFT JOIN xin_job_type AS type ON type.job_type_id = jobs.job_type
                                    LEFT JOIN xin_employees AS em ON em.user_id = app.user_id_emp
                                    LEFT JOIN (
                                    SELECT
                                        user_id,
                                        CONCAT( first_name, ' ', last_name ) AS employee_name,
                                        REPLACE ( REPLACE ( REPLACE ( contact_no, '+', '' ), '-', '' ), ' ', '' ) AS contact_no 
                                    FROM
                                        xin_employees 
                                    ) AS pic ON pic.user_id = req.pic
                                    LEFT JOIN (
                                    SELECT
                                        user_id,
                                        CONCAT( first_name, ' ', last_name ) AS employee_name,
                                        REPLACE ( REPLACE ( REPLACE ( contact_no, '+', '' ), '-', '' ), ' ', '' ) AS contact_no 
                                    FROM
                                        hris.xin_employees 
                                    WHERE
                                        is_active = 1 
                                    ) AS requester ON requester.user_id = req.created_by
                                    LEFT JOIN (
                                    SELECT
                                        user_id,
                                        CONCAT( first_name, ' ', last_name ) AS employee_name,
                                        REPLACE ( REPLACE ( REPLACE ( contact_no, '+', '' ), '-', '' ), ' ', '' ) AS contact_no 
                                    FROM
                                        hris.xin_employees 
                                    WHERE
                                        is_active = 1 
                                    ) AS aprv ON aprv.user_id = req.approved_by
                                    LEFT JOIN (
                                    SELECT
                                        user_id,
                                        CONCAT( first_name, ' ', last_name ) AS employee_name,
                                        REPLACE ( REPLACE ( REPLACE ( contact_no, '+', '' ), '-', '' ), ' ', '' ) AS contact_no 
                                    FROM
                                        hris.xin_employees 
                                    WHERE
                                        is_active = 1 
                                    ) AS usr_interview ON usr_interview.user_id = intv.created_by 
                                WHERE
                                    adm.application_id = '$application_id' 
                                    LIMIT 1")->row_array();
    }

    public function dt_fack_card($start, $end, $nama_user)
    {
        if (!$nama_user) {
            $query = "SELECT
                fa.application_id,
                COALESCE(fa.nama,'') AS employee_name,
                c.`name` AS company_name,
                j.designation_name as job_title,
                COALESCE(e.user_id,'') AS user_id,
                COALESCE(e.date_of_joining,'') AS date_of_joining,
                COALESCE(e.id_card_status,'') AS is_printed,
                COALESCE(e.id_card_printed_date,'') AS is_printed_date,
                COALESCE(e.profile_picture,'') AS profile_picture
            FROM
                fack_personal_details fa
                LEFT JOIN `xin_job_applications` ja ON ja.application_id = fa.application_id
                LEFT JOIN xin_employees e ON e.user_id = ja.user_id_emp
                LEFT JOIN xin_designations j ON j.designation_id = e.designation_id
                LEFT JOIN xin_users u ON ja.user_id = u.user_id
                LEFT JOIN xin_companies c ON c.company_id = u.company_id
                WHERE
                e.is_active = '1' AND
                SUBSTR(fa.created_at,1,10) BETWEEN '$start' AND '$end'";
        } else {
            $query = "SELECT
                    c.`name` AS company_name,
                    j.designation_name as job_title,
                    COALESCE(e.user_id,'') AS user_id,
                    CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
                    COALESCE(e.date_of_joining,'') AS date_of_joining,
                    COALESCE(e.id_card_status,'') AS is_printed,
                    COALESCE(e.id_card_printed_date,'') AS is_printed_date,
                COALESCE(e.profile_picture,'') AS profile_picture
                FROM
                    xin_employees e 
                    LEFT JOIN xin_designations j ON j.designation_id = e.designation_id
                    LEFT JOIN xin_companies c ON c.company_id = e.company_id
                    WHERE e.is_active = '1' AND CONCAT(e.first_name, ' ', e.last_name) LIKE '%$nama_user%'
                    LIMIT 20";
        }
        return $this->db->query($query)->result();
    }

    public function isPrinted($id)
    {
        $query = "UPDATE xin_employees
        SET id_card_status = '1', id_card_printed_date = '" . date('Y-m-d H:i:s') . "'
        WHERE user_id = $id";
        return $this->db->query($query);
    }

    public function isRevisi($id)
    {
        $query = "UPDATE xin_employees
        SET id_card_status = '2'
        WHERE user_id = $id";
        return $this->db->query($query);
    }

    public function unRevisi($id)
    {
        $query = "UPDATE xin_employees
        SET id_card_status = '3'
        WHERE user_id = $id";
        return $this->db->query($query);
    }


    public function dummy()
    {
        // $query = "UPDATE trusmi_navigation
        // SET no_urut = 20
        // WHERE menu_id = 39";
        // return $this->db->query($query);
    }

    public function get_alasan($step)
    {
        return $this->db->query("SELECT * FROM trusmi_m_gagal_join WHERE step = '$step'")->result();
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
    public function pendidikan_karir($application_id){
        $query = "SELECT
            job.application_id,
            job.full_name,
            job.user_id_emp AS employee_id,
            pend.pendidikan AS id_pendidikan,
            mpen.pendidikan,
            pend.nama_sekolah,
            pend.jurusan,
            pend.nilai,
            pend.dari,
            pend.sampai
            FROM
            `xin_job_applications` job
            LEFT JOIN talent_pool.users prof ON prof.id_user = job.id_user_talent
            LEFT JOIN talent_pool.users_pendidikan pend ON prof.id_user = pend.id_user
            JOIN talent_pool.m_pendidikan mpen ON mpen.id = pend.pendidikan
            WHERE
            application_id = $application_id;";
        return $this->db->query($query)->result();
    }
    public function pengalaman_karir($application_id){
        $query = " SELECT
                job.application_id,
                job.user_id_emp AS employee_id,
                job.full_name,
                exp.nama,
                exp.posisi,
                exp.tempat,
                exp.deskripsi,
                exp.dari,
                exp.sampai
                FROM
                `xin_job_applications` job
                LEFT JOIN talent_pool.users prof ON prof.id_user = job.id_user_talent
                LEFT JOIN talent_pool.users_pengalaman exp ON exp.id_user = prof.id_user

                WHERE
                application_id = $application_id
                AND exp.tipe = 1;";
        return $this->db->query($query)->result();

    }
    public function organisasi_karir($application_id){
        $query = "SELECT
            job.application_id,
            job.user_id_emp AS employee_id,
            job.full_name,
            exp.nama,
            exp.posisi,
            exp.tempat,
            exp.deskripsi,
            exp.dari,
            exp.sampai
            FROM
            `xin_job_applications` job
            LEFT JOIN talent_pool.users prof ON prof.id_user = job.id_user_talent
            LEFT JOIN talent_pool.users_pengalaman exp ON exp.id_user = prof.id_user

            WHERE
            application_id = $application_id
            AND exp.tipe = 2;";
        return $this->db->query($query)->result();
    }

}
