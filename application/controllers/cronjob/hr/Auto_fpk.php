<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auto_fpk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // cron job function
    public function check_fpk()
    {
        $this->load->database();
        $get_spv = $this->get_spv();
        $response['cron_text'] = 'Auto FPK Marketing';

        foreach ($get_spv as $spv) {
            $created_at = date('Y-m-d H:i:s');
            if ($spv->last_job_id == 0) {
                $permintaan = [
                    "employer_id"       => 3,
                    "department_id"     => 120,
                    "job_title"         => 'Sales',
                    "designation_id"    => 731,
                    "job_vacancy"       => $spv->kurang_pengajuan,
                    "location_id"       => 17,
                    "position_id"       => 7,
                    "job_type"          => 1,
                    "type_contract"     => 2,
                    "gender"            => 2,
                    "perencanaan"       => 'Sesuai MPP',
                    "dasar"             => 'Posisi Baru',
                    "salary"            => '1000000',
                    "latar_kebutuhan"   => 'Pemenuhan MPP',
                    "long_description"  => '<p>• Melakukan aktivitas promosi agar mendapatkan database konsumen setiap harinya sesuai dengan target yang sudah ditetapkan.</p><p>• Mendampingi konsumen selama proses pembelian agar konsumen mengetahui informasi penting selama proses pembelian.</p>',
                    "kpi"               => '• Total Booking (Total Booking / Target Booking) • Total Akad (Total Akad / Target Akad)',
                    "bawahan_langsung"  => 0,
                    "pendidikan"        => 'SMA SEDERAJAT',
                    "financial"         => 'Tidak ada',
                    "bawahan_tidak"     => 0,
                    "minimum_experience" => 1,
                    "kemampuan"         => 'Komunikasi, Media sosial',
                    "komp_kunci"        => '1. Selling Skill 2. Komunikasi 3. Marketing Strategy 4. Problem solving',
                    "komp_pemimpin"     => 'no',
                    'created_at'        => $created_at,
                    'created_by'        => $spv->join_hr ?? 0,
                    'status'            => 4,
                    'auto_fpk'          => $created_at,
                ];

                $dataDepartment = $this->db->query("SELECT * FROM xin_departments WHERE department_id = 120")->row();
                $permintaan += [
                    'verified_at' => $created_at,
                    'verified_by' => @$dataDepartment->head_id ?? 1,
                    'approved_by' => 8663,
                    'approved_at' => $created_at
                ];

                $response['insert'] = $this->db->insert("trusmi_jobs_request", $permintaan);
            } else {
                $last_job_id = $spv->last_job_id;
                $get_last_job_request = $this->db->query("SELECT job_vacancy FROM trusmi_jobs_request WHERE job_id = $last_job_id")->row();
                $new_job_vacancy = $get_last_job_request->job_vacancy + $spv->kurang_pengajuan;
                $permintaan = [
                    "job_vacancy"       => $new_job_vacancy,
                    'auto_fpk'          => $created_at
                ];
                if ($last_job_id != "") {
                    $response['update'] = $this->db->where("job_id", $last_job_id)->update("trusmi_jobs_request", $permintaan);
                }
            }
            $fpk = $this->db->query("SELECT * FROM trusmi_jobs_request WHERE job_title = 'Sales' AND created_by = $spv->join_hr AND created_at = '$created_at'")->row_array();
            $response['fpk'] = $fpk;
            $response['send_wa'] = $this->send_wa_fpk($fpk['job_id']);
        }


        echo json_encode($response);
    }

    function get_spv()
    {
        $this->load->database();
        $query = "SELECT 
                        spv.*,
                        COALESCE(max_job_id,0) AS last_job_id,
                        COALESCE(fpk.job_vacancy,0) AS sudah_pengajuan_fpk,
                        spv.kurang_tim - COALESCE(fpk.job_vacancy,0) AS kurang_pengajuan
                    FROM (

                    SELECT
                        x.id_user AS id_spv,
                        x.join_hr,
                        x.date_of_joining,
                        x.employee_name AS spv,
                        x.jml_mkt,
                        8 - x.jml_mkt AS kurang_tim
                    FROM
                        (
--                         SELECT
--                             spv.id_user,
--                             spv.join_hr,
--                             spv.date_of_joining,
--                             spv.employee_name,
--                             COUNT( mkt.id_user ) AS jml_mkt 
--                         FROM
--                             rsp_project_live.`user` spv
--                             LEFT JOIN rsp_project_live.`user` mkt ON mkt.spv = spv.id_user
--                             LEFT JOIN xin_employees e ON e.user_id = spv.join_hr
--                             AND mkt.isActive = 1 
--                         WHERE
--                             spv.id_user = spv.spv 
--                             AND spv.id_divisi = 2 AND e.is_active = 1 
--                             AND spv.id_user != spv.leader 
--                             AND spv.id_user != spv.id_gm 
--                             AND spv.id_user != spv.id_manager 
--                             AND spv.isActive = 1 
--                         GROUP BY
--                         spv.id_user 
                            
                          SELECT
                              spv.id_user,
                              spv.join_hr,
                              spv.date_of_joining,
                              spv.employee_name,
                              e.designation_id, 
                              COUNT( mkt.id_user ) AS jml_mkt 
                          FROM
                              rsp_project_live.`user` spv
                              LEFT JOIN rsp_project_live.`user` mkt ON mkt.spv = spv.id_user
                              LEFT JOIN xin_employees e ON e.user_id = spv.join_hr
                              AND mkt.isActive = 1 
                          WHERE
                              spv.id_user = spv.spv 
                              AND spv.id_divisi = 2 AND e.is_active = 1 
                              AND spv.isActive = 1 
                              AND e.designation_id in (734,735)
                          GROUP BY
                          spv.id_user 
                        ) AS x
                        WHERE x.jml_mkt < 8
                        ) AS spv
                        LEFT JOIN (
                        SELECT
                                max(trusmi_jobs_request.job_id) AS max_job_id,
                                created.user_id AS created_by,
                                CONCAT( created.first_name, ' ', created.last_name ) AS created,
                                trusmi_jobs_request.job_title,
                                xin_users.first_name AS company,
                                xin_departments.department_name AS department,
                                sum(trusmi_jobs_request.job_vacancy) AS job_vacancy,
                                trusmi_jobs_request.`status` AS id_status,
                                trusmi_status.`status`,
                                DATE( trusmi_jobs_request.created_at ) AS created_at,
                                DATE( trusmi_jobs_request.verified_at ) AS verified_at,
                                CONCAT( verified.first_name, ' ', verified.last_name ) AS verified,
                                CONCAT( pic.first_name, ' ', pic.last_name ) AS pic,
                                trusmi_jobs_request.alasan_reject,
                                IF (
                                        TIMESTAMPDIFF( HOUR, trusmi_jobs_request.created_at, trusmi_jobs_request.verified_at ) > 24,
                                        CONCAT( DATEDIFF( trusmi_jobs_request.verified_at, trusmi_jobs_request.created_at ), ' Hari' ),
                                        CONCAT( TIMESTAMPDIFF( HOUR, trusmi_jobs_request.created_at, trusmi_jobs_request.verified_at ), ' Jam' ) 
                                ) AS lt_verif,
                                IF (
                                        TIMESTAMPDIFF( HOUR, trusmi_jobs_request.verified_at, trusmi_jobs_request.approved_at ) > 24,
                                        CONCAT( DATEDIFF( trusmi_jobs_request.approved_at, trusmi_jobs_request.verified_at ), ' Hari' ),
                                        CONCAT( TIMESTAMPDIFF( HOUR, trusmi_jobs_request.verified_at, trusmi_jobs_request.approved_at ), ' Jam' ) 
                                ) AS lt_approve 
                            FROM
                                trusmi_jobs_request
                                JOIN xin_users ON trusmi_jobs_request.employer_id = xin_users.user_id
                                JOIN xin_departments ON trusmi_jobs_request.department_id = xin_departments.department_id
                                JOIN xin_user_roles ON trusmi_jobs_request.position_id = xin_user_roles.role_id
                                JOIN trusmi_status ON trusmi_jobs_request.`status` = trusmi_status.id
                                JOIN xin_employees AS created ON created.user_id = trusmi_jobs_request.created_by
                                LEFT JOIN xin_employees AS verified ON verified.user_id = trusmi_jobs_request.verified_by 
                                LEFT JOIN xin_employees AS pic ON pic.user_id = trusmi_jobs_request.pic
                                LEFT JOIN xin_jobs AS jobs ON jobs.reff_job_id = trusmi_jobs_request.job_id
                            WHERE
                                trusmi_jobs_request.`status` = 4
                                AND xin_departments.department_id = 120 AND xin_user_roles.role_id = 7 AND trusmi_jobs_request.designation_id = 731
                                GROUP BY created.user_id
                        ) AS fpk ON fpk.created_by = spv.join_hr
                        WHERE (spv.kurang_tim - COALESCE(fpk.job_vacancy,0)) > 0";
        return $this->db->query($query)->result();
    }

    public function send_wa_fpk($job_id)
    {
        // $kontak[] = '628986997966'; // Umam testing
        // $kontak[] = '6285860428016'; //Mas Lutfie
        // $kontak[] = '6282316041423'; //Mas Ari
        $kontak[] = '628996999783'; // Ali95
        $kontak[] = '628157720291'; // nani1283
        $this->load->model('recruitment/Model_permintaan_karyawan', 'model');
        $fpk        = $this->model->detail_send_fpk($job_id);

        $str = $fpk['jobdesk'];
        $deskripsi = str_replace("&lt;ol&gt;", "&lt;ul&gt;", $str);
        $deskripsi = str_replace("&lt;/ol&gt;", "&lt;/ul&gt;", $deskripsi);

        foreach ($kontak as $key => $value) {
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2507194023",
                "phone" => $value,
                "messageType" => "text",
                "body" => "👤Alert!!! 
*There is New Request FPK*

🏣Company : " . $fpk['company'] . "
🗃️Department : " . $fpk['department'] . "
📍Position : *" . $fpk['position'] . "*
🎚️Level : " . $fpk['level'] . "
📝Need : " . $fpk['need'] . "
🔒Status : " . $fpk['status'] . "
📑Jobdesc : " . strip_tags(htmlspecialchars_decode($deskripsi)) . "

👤Requested By : " . $fpk['created'] . "
🕐Requested At : " . $fpk['created_at'] . "",
                "withCase" => true
            );

            $options_text = array(
                'http' => array(
                    "method"  => 'POST',
                    "content" => json_encode($data_text),
                    "header" =>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                )
            );

            $context_text   = stream_context_create($options_text);
            $result_text['wa_api']    = file_get_contents($url, false, $context_text);
        }
        return $result_text;
    }

    function html_kompetensi($komp)
    {
        $job_kompetensi = htmlspecialchars_decode($komp);
        $job_kompetensi = str_replace(['<li>', '</li>', '<p>', '</p>'], ["\n", '', "\n", ''], $job_kompetensi);
        $job_kompetensi = str_replace('&nbsp;', ' ', $job_kompetensi);
        $job_kompetensi = strip_tags($job_kompetensi);
        $job_kompetensi = trim($job_kompetensi);
        $job_kompetensi = preg_replace('/\s*\n\s*/', "\n", $job_kompetensi);
        $job_kompetensi = preg_replace("/\n+/", "\n", $job_kompetensi);
        return $job_kompetensi;
    }

    function new_fpk()
    {
        $this->load->database();
        $query = "SELECT
        * 
        FROM
            `v_auto_fpk` 
        HAVING
        total_need > 0";

        $get_fpk = $this->db->query($query)->result();

        $response['title'] = 'Auto FPK By standar MPP Designation';

        foreach ($get_fpk as $fpk) {
            $created_at = date('Y-m-d H:i:s');
            if ($fpk->last_job_id == 0) {
                $permintaan = [
                    "employer_id"       => $fpk->employer_id,
                    "department_id"     => $fpk->department_id,
                    "job_title"         => $fpk->designation_name,
                    "designation_id"    => $fpk->designation_id,
                    "job_vacancy"       => $fpk->total_need,
                    "location_id"       => 3,
                    "position_id"       => 7,
                    "job_type"          => 1,
                    "type_contract"     => 2,
                    "gender"            => 2,
                    "perencanaan"       => 'Sesuai MPP',
                    "dasar"             => 'Posisi Baru',
                    "salary"            => 0,
                    "latar_kebutuhan"   => 'Pemenuhan MPP',
                    "long_description"  => $fpk->job_desc,
                    "kpi"               => $fpk->job_kpi,
                    "bawahan_langsung"  => 0,
                    "pendidikan"        => $fpk->pendidikan,
                    "financial"         => 'Tidak ada',
                    "bawahan_tidak"     => 0,
                    "minimum_experience" => 1,
                    "kemampuan"         => '',
                    "komp_kunci"        => $this->html_kompetensi($fpk->kompetensi),
                    "komp_pemimpin"     => '',
                    'created_at'        => $created_at,
                    'created_by'        => 8663,
                    'status'            => 1,
                    'auto_fpk'          => $created_at,
                ];
                $response['insert'] = $this->db->insert("trusmi_jobs_request", $permintaan);
            } else {
                $last_job_id = $fpk->last_job_id;
                $get_last_job_request = $this->db->query("SELECT job_vacancy FROM trusmi_jobs_request WHERE job_id = $last_job_id")->row();
                $new_job_vacancy = $get_last_job_request->job_vacancy + $fpk->total_need;
                $permintaan = [
                    "job_vacancy"       => $new_job_vacancy,
                    'auto_fpk'          => $created_at
                ];
                if ($last_job_id != "") {
                    $response['update'] = $this->db->where("job_id", $last_job_id)->update("trusmi_jobs_request", $permintaan);
                }
            }
            $fpk = $this->db->query("SELECT * FROM trusmi_jobs_request WHERE job_title = '$fpk->designation_name' AND created_by = 8663 AND auto_fpk = '$created_at'")->row_array();
            $response['fpk'] = $fpk;
            $response['send_wa'] = $this->send_wa_fpk($fpk['job_id']);
        }
        header('Content-type: application/json');
        echo json_encode($response);
    }
}
