<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_job_assessment extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_m_assessment()
    {
        $query = "SELECT * FROM m_assessment";
        return $this->db->query($query)->result();
    }
    function get_level()
    {
        $query = "SELECT role_id, role_name, 'from' AS label FROM xin_user_roles WHERE role_id IN (6,7) UNION ALL
                SELECT role_id, role_name, 'to' AS label FROM xin_user_roles WHERE role_id IN (5)";
        return $this->db->query($query)->result();
    }
    function get_spv_up($user)
    {
        $query = "SELECT
        user_id,
        first_name,
        last_name 
    FROM
        `xin_employees` emp
        JOIN xin_user_roles role ON role.role_id = emp.user_role_id
        WHERE emp.user_id = '$user' AND (role.role_id IN (1,2,3,4,5,10) OR emp.user_id = 3648)";
        return $this->db->query($query)->num_rows();
    }
    function get_data($start, $end)
    {
        $query = "SELECT
                asm.id_assessment,
                asm.user_id,
                CONCAT(emp.first_name,' ',emp.last_name) AS nama,
                xin_companies.name AS company,
                xin_designations.designation_name,
                xin_departments.department_name,
                fr.role_name AS role_from,
                t.role_name AS role_to,
                COALESCE(m_pst.psikotest,'-') AS hasil_psikotest,
                CASE asm.hasil_psikotest 
                    WHEN 1 THEN 'primary'
                    WHEN 2 THEN 'success'
                    WHEN 3 THEN 'danger'
                    ELSE 'warning'
                END AS warna_psikotest,
                COALESCE(m_pnl.panelis,'-') AS hasil_panelis,
                CASE asm.hasil_panelis 
                    WHEN 1 THEN 'primary'
                    WHEN 2 THEN 'success'
                    WHEN 3 THEN 'danger'
                    ELSE 'warning'
                END AS warna_panelis,
                COALESCE(m_ksm.kesimpulan,'-') AS kesimpulan,
                CASE asm.kesimpulan 
                    WHEN 1 THEN 'primary'
                    WHEN 2 THEN 'danger'
                    WHEN 3 THEN 'warning'
                    ELSE 'danger'
                END AS warna_kesimpulan,
                asm.due_date,
                asm.actual_date,
                asm.created_at,
                CONCAT(crt.first_name,' ',crt.last_name) AS created_by
            FROM
                `trusmi_assessment` asm
                JOIN xin_employees emp ON asm.user_id = emp.user_id
                JOIN xin_employees crt ON asm.created_by = crt.user_id
                LEFT JOIN m_assessment m_pst ON m_pst.id = asm.hasil_psikotest
                LEFT JOIN m_assessment m_pnl ON m_pnl.id = asm.hasil_panelis
                LEFT JOIN m_assessment m_ksm ON m_ksm.id = asm.kesimpulan
                LEFT JOIN xin_designations ON emp.designation_id = xin_designations.designation_id
                LEFT JOIN xin_companies ON emp.company_id = xin_companies.company_id
                LEFT JOIN xin_departments ON emp.department_id = xin_departments.department_id
                JOIN xin_user_roles fr ON fr.role_id = asm.`from`
                JOIN xin_user_roles t ON t.role_id = asm.to
            WHERE SUBSTR(asm.created_at,1,10) BETWEEN '$start' AND '$end'
                ";
        return $this->db->query($query)->result();
    }
    function get_detail($id)
    {
        $query = "SELECT
                asm.id_assessment,
                asm.user_id,
                CONCAT(emp.first_name,' ',emp.last_name) AS nama,
                xin_companies.name AS company,
                xin_designations.designation_name,
                xin_departments.department_name,
                fr.role_name AS role_from,
                t.role_name AS role_to,
                COALESCE(asm.avg_panelis,'-') AS avg_panelis,
                COALESCE(asm.spesifikasi_teknis,'-') AS spesifikasi_teknis,
                COALESCE(m_pst.psikotest,'-') AS hasil_psikotest,
                CASE asm.hasil_psikotest 
                    WHEN 1 THEN 'primary'
                    WHEN 2 THEN 'success'
                    WHEN 3 THEN 'danger'
                    ELSE 'warning'
                END AS warna_psikotest,
                COALESCE(m_pnl.panelis,'-') AS hasil_panelis,
                CASE asm.hasil_panelis 
                    WHEN 1 THEN 'primary'
                    WHEN 2 THEN 'success'
                    WHEN 3 THEN 'danger'
                    ELSE 'warning'
                END AS warna_panelis,
                COALESCE(m_ksm.kesimpulan,'-') AS kesimpulan,
                CASE asm.kesimpulan 
                    WHEN 1 THEN 'primary'
                    WHEN 2 THEN 'danger'
                    ELSE 'warning'
                END AS warna_kesimpulan,
                CASE asm.kesimpulan 
                    WHEN 1 THEN 'bi bi-check-square-fill'
                    WHEN 2 THEN 'bi bi-x-square-fill'
                    ELSE 'warning'
                END AS warna_kesimpulan,
                asm.due_date,
                asm.actual_date,
                asm.created_at,
                CONCAT(crt.first_name,' ',crt.last_name) AS created_by
            FROM
                `trusmi_assessment` asm
                JOIN xin_employees emp ON asm.user_id = emp.user_id
                JOIN xin_employees crt ON asm.created_by = crt.user_id
                LEFT JOIN m_assessment m_pst ON m_pst.id = asm.hasil_psikotest
                LEFT JOIN m_assessment m_pnl ON m_pnl.id = asm.hasil_panelis
                LEFT JOIN m_assessment m_ksm ON m_ksm.id = asm.kesimpulan
                LEFT JOIN xin_designations ON emp.designation_id = xin_designations.designation_id
                LEFT JOIN xin_companies ON emp.company_id = xin_companies.company_id
                LEFT JOIN xin_departments ON emp.department_id = xin_departments.department_id
                JOIN xin_user_roles fr ON fr.role_id = asm.`from`
                JOIN xin_user_roles t ON t.role_id = asm.to
            WHERE asm.id_assessment = '$id'
                ";
        return $this->db->query($query)->row_object();
    }
    function hasil_psikotest($id)
    {
        $query = "SELECT trusmi_assessment_hr.`id`, 
        `id_assessment`, 
        COALESCE(`army_alpha`,'-') AS army_alpha, COALESCE(`cfit`,'-') AS cfit, COALESCE(`iq`,'-') AS iq, 
        COALESCE(`tiu`,'-') AS tiu, COALESCE(`disc`,'-') AS disc, COALESCE(`mbti`,'-') AS mbti, `keterangan`, 
        `created_at`, `created_by`, `updated_at`, 
        `updated_by`, m_pst.psikotest
        FROM trusmi_assessment_hr
        LEFT JOIN m_assessment m_pst ON m_pst.id = trusmi_assessment_hr.keterangan
        WHERE id_assessment = '$id'";
        return $this->db->query($query)->row_object();
    }
    function hasil_panelis($id)
    {
        $query = "SELECT `id`,
         `id_assessment`, 
        `panelis_id`, 
        `poin_kompetensi`, 
        `nilai`, 
        trusmi_assessment_panelis.`created_at`, 
        trusmi_assessment_panelis.`created_by`,
         trusmi_assessment_panelis.`updated_at`,
         trusmi_assessment_panelis.`updated_by`,
         CONCAT(pnl.first_name,' ',pnl.last_name) AS nama_panelis
        FROM trusmi_assessment_panelis 
        JOIN xin_employees pnl ON trusmi_assessment_panelis.panelis_id = pnl.user_id
        WHERE id_assessment = '$id'
        GROUP BY id_assessment";
        return $this->db->query($query)->result();
    }
    function data_for_panelis()
    {
        $user = $this->session->userdata('user_id');
        $allowed_users = [1, 5203];
        if(in_array($user, $allowed_users)){
            $kondisi = "";
        }else{
            $kondisi ="AND pnl.panelis_id = '$user'";
        }
        $query = "SELECT
                asm.id_assessment,
                asm.user_id,
                pnl.panelis_id,
                CONCAT(emp.first_name,' ',emp.last_name) AS nama,
                CONCAT(panelis.first_name,' ',panelis.last_name) AS nama_panelis,
                xin_companies.name AS company,
                xin_designations.designation_name,
                xin_departments.department_name,
                fr.role_name AS role_from,
                t.role_name AS role_to,
                COALESCE(m_pst.psikotest,'-') AS hasil_psikotest,
                CASE asm.hasil_psikotest 
                    WHEN 1 THEN 'primary'
                    WHEN 2 THEN 'success'
                    WHEN 3 THEN 'danger'
                    ELSE 'warning'
                END AS warna_psikotest,
                COALESCE(m_pnl.panelis,'-') AS hasil_panelis,
                CASE asm.hasil_panelis 
                    WHEN 1 THEN 'primary'
                    WHEN 2 THEN 'success'
                    WHEN 3 THEN 'danger'
                    ELSE 'warning'
                END AS warna_panelis,
                COALESCE(m_ksm.kesimpulan,'-') AS kesimpulan,
                CASE asm.kesimpulan 
                    WHEN 1 THEN 'primary'
                    WHEN 2 THEN 'danger'
                    ELSE 'warning'
                END AS warna_kesimpulan,
                asm.due_date,
                asm.actual_date,
                asm.created_at,
                CONCAT(crt.first_name,' ',crt.last_name) AS created_by,
                'Waiting' AS status_poin
            FROM
                `trusmi_assessment` asm
                JOIN xin_employees emp ON asm.user_id = emp.user_id
                JOIN xin_employees crt ON asm.created_by = crt.user_id
                LEFT JOIN m_assessment m_pst ON m_pst.id = asm.hasil_psikotest
                LEFT JOIN m_assessment m_pnl ON m_pnl.id = asm.hasil_panelis
                LEFT JOIN m_assessment m_ksm ON m_ksm.id = asm.kesimpulan
                LEFT JOIN xin_designations ON emp.designation_id = xin_designations.designation_id
                LEFT JOIN xin_companies ON emp.company_id = xin_companies.company_id
                LEFT JOIN xin_departments ON emp.department_id = xin_departments.department_id
                JOIN xin_user_roles fr ON fr.role_id = asm.`from`
                JOIN xin_user_roles t ON t.role_id = asm.to
                JOIN trusmi_assessment_panelis pnl ON asm.id_assessment = pnl.id_assessment
                JOIN xin_employees panelis ON pnl.panelis_id = panelis.user_id

            WHERE 
            pnl.updated_at IS NULL
            $kondisi
GROUP BY 
asm.id_assessment,pnl.panelis_id
                ";
        return $this->db->query($query)->result();
    }
    function get_karyawan()
    {
        $user = $this->session->userdata('user_id');
        $query = "SELECT xin_employees.user_id, xin_employees.username, designation_name, xin_companies.name AS company, CONCAT(xin_employees.first_name,' ',xin_employees.last_name) AS nama_karyawan, xin_departments.department_name,xin_departments.department_id, xin_employees.user_role_id
        
        FROM xin_employees
        LEFT JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
        LEFT JOIN xin_companies ON xin_employees.company_id = xin_companies.company_id
        LEFT JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
        WHERE xin_employees.is_active = '1' AND xin_employees.user_id != '$user'
        AND xin_employees.user_role_id IN (2,3,4,5,6,7)
        ORDER BY nama_karyawan ASC
        ";
        return $this->db->query($query)->result();
    }
    function save($table, $data)
    {
        return $this->db->insert($table, $data);
    }
    function get_data_detail($id)
    {
        $query = "SELECT
        id_pk,
        pic,
        (SELECT GROUP_CONCAT(CONCAT(pic.first_name, ' ', pic.last_name) SEPARATOR ', ') FROM xin_employees pic WHERE FIND_IN_SET(pic.user_id, pk_job.pic)) AS pic_name,
        tgl_masuk,
        note,
        pk_job.created_at,
        CONCAT(user.first_name,' ',user.last_name) AS created_by
    FROM
        `pk_job`
        JOIN xin_employees user ON user.user_id = pk_job.created_by
        WHERE id_pk = '$id' ";
        return $this->db->query($query)->row_object();
    }

    public function update_psikotest($data, $id, $ket)
    {
        $this->db->where('id_assessment', $id);
        $this->db->update('trusmi_assessment_hr', $data);
        return $this->db->update('trusmi_assessment', ['hasil_psikotest' => $ket], ['id_assessment' => $id]);
    }

    public function get_data_panelis($id)
    {
        $user = $this->session->userdata('user_id');
        $query = "SELECT 
            pnl.id,
            pnl.id_assessment,
            pnl.panelis_id,
            CONCAT(emp.first_name,' ',emp.last_name) AS nama_panelis,
            pnl.poin_kompetensi,
            pnl.nilai,
            CASE 
                WHEN pnl.panelis_id = '$user' THEN 'true'
                ELSE 'false'
            END AS status_user,
            COALESCE((SELECT SUM(pnl_inner.nilai) FROM `trusmi_assessment_panelis` pnl_inner WHERE pnl_inner.panelis_id = pnl.panelis_id AND pnl_inner.id_assessment = pnl.id_assessment),'-') AS total_nilai,
            COALESCE(ROUND((SELECT AVG(pnl_inner.nilai) FROM `trusmi_assessment_panelis` pnl_inner WHERE pnl_inner.panelis_id = pnl.panelis_id AND pnl_inner.id_assessment = pnl.id_assessment),1),'-') AS rata_rata,
            IF(pnl.updated_by IS NULL, 'Waiting', 'Submitted') AS status_poin
            FROM `trusmi_assessment_panelis` pnl
            JOIN xin_employees emp ON emp.user_id = pnl.panelis_id
            WHERE pnl.id_assessment = '$id'
            GROUP BY pnl.id
            ORDER BY CONCAT(emp.first_name,' ',emp.last_name)";
        return $this->db->query($query)->result();
    }
    public function get_item_poin($id, $panelis_id)
    {
        $query = "SELECT 
            pnl.id,
            pnl.id_assessment,
            pnl.panelis_id,
            CONCAT(emp.first_name,' ',emp.last_name) AS nama_panelis,
            pnl.poin_kompetensi
        FROM `trusmi_assessment_panelis` pnl
        JOIN xin_employees emp ON emp.user_id = pnl.panelis_id
        WHERE 
        pnl.id_assessment = '$id'
        AND pnl.panelis_id = '$panelis_id'
        ";
        return $this->db->query($query)->result();
    }
    function get_tiu_disc_mbti($id){
        $query = "SELECT
                xja.full_name,
                COALESCE(iq,'Tidak Ada Data') AS iq,
                COALESCE(CONCAT ('Current : ',disc1,' | ', 'Presure : ',disc2,' | ','Self : ',disc3),'Tidak Ada Data') AS disc,
                COALESCE ( GROUP_CONCAT( t_mbti.mbti ), 'Tidak Ada Data' ) AS mbti 
            FROM
                xin_employees e
                LEFT JOIN xin_job_applications xja ON xja.user_id_emp = e.user_id
                LEFT JOIN trusmi_interview ti ON ti.application_id = xja.application_id
                LEFT JOIN trusmi_psikotes ON xja.application_id = trusmi_psikotes.application_id
                LEFT JOIN trusmi_t_mbti t_mbti ON trusmi_psikotes.application_id = t_mbti.application_id 
            WHERE
                e.user_id = '$id'";
		return $this->db->query($query)->row_object();
    }
}
