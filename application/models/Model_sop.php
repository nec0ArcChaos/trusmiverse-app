<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sop extends CI_Model
{

    function d()
    {
        return $this->db->get('divisi')->result();
    }

    function sd($id_divisi)
    {
        return $this->db->get_where('sub_divisi', array('id_divisi' => $id_divisi))->result();
    }

    function ssd($id_sub_divisi)
    {
        return $this->db->get_where('sub_sub_divisi', array('id_sub_divisi' => $id_sub_divisi))->result();
    }

    function get_pic($id)
    {
        $searchForValue = ',';
        if (strpos($id, $searchForValue) !== false) {
            $query = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS employee_name, contact_no FROM xin_employees WHERE department_id IN ('$id') OR ctm_posisi IN ('Supervisor','Assisten Manager','Manager','Head','Direktur') AND is_active = 1 ORDER BY employee_name ASC";
        } else {
            $query = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS employee_name, contact_no FROM xin_employees WHERE department_id = '$id' AND ctm_posisi IN ('Supervisor','Assisten Manager','Manager','Head','Direktur') AND is_active = 1 OR user_id IN (68,323,1186) ORDER BY employee_name ASC";
        }
        return $this->db->query($query)->result();
    }

    function get_departments($company_id)
    {
        if ($company_id == 0) {
            $sort = "";
        } else {
            $sort = "WHERE xin_departments.company_id = $company_id";
        }
        return $this->db->query("SELECT department_id, department_name FROM xin_departments $sort");
    }

    function getSOP()
    {
        $department = $this->session->userdata('department_id');
        $user_id    = $this->session->userdata('user_id');
        if ($department == 1 || $department == 72 || $department == 73 || $department == 156 || $department == 157 || $department == 167 || $department == 133 || $user_id == 2521 || $user_id == 68 || $user_id == 2069 || $user_id == 3961 || $user_id == 77 || $user_id == 2843 || $user_id == 8167) {
            $kondisi = "";
        } else {
            $kondisi = "WHERE FIND_IN_SET($department, sop.department)";
        }

        $sql = "SELECT
        id_sop,
        c.company_id,
        c.name as company_name,
        sop.type_department,
        status.review AS status_review,
        sop.department AS department,
        IF(sop.type_department = 1, sop.department, CONCAT('[',sop.department,']')) AS department_id,
        GROUP_CONCAT(DISTINCT dp.department_name SEPARATOR ', ') as department_name,
        sop.designation AS designation,
        CONCAT('[',sop.designation,']') AS designation_id,
        GROUP_CONCAT(DISTINCT ds.designation_name SEPARATOR ', ') as designation_name,
        jenis_doc,
        no_doc,
        DATE_FORMAT(tgl_terbit, '%d-%m-%Y') AS tgl_terbit,
        DATE_FORMAT(tgl_update, '%d-%m-%Y') AS tgl_update,
        DATE_FORMAT(start_date, '%d-%m-%Y') AS start_date,
        DATE_FORMAT(end_date, '%d-%m-%Y') AS end_date,
        nama_dokumen,
        file,
        word,
        penjelasan,
        jadwal_diskusi,
        draft,
        CONCAT(e.first_name,' ',e.last_name) AS created_by,
        e.user_id AS id_user,
        e.contact_no
    FROM
        trusmi_sop AS sop
        LEFT JOIN xin_companies c ON c.company_id = sop.company
        LEFT JOIN xin_departments dp ON FIND_IN_SET(dp.department_id, sop.department)
        LEFT JOIN xin_designations ds ON FIND_IN_SET(ds.designation_id, sop.designation)
        LEFT JOIN xin_employees e ON e.user_id = sop.created_by
        LEFT JOIN od_review AS review ON sop.id_sop = review.id_dokumen
        LEFT JOIN od_status AS status ON review.status = status.id_status
    $kondisi
    GROUP BY
        id_sop
    ORDER BY
        id_sop DESC";

        $list_sop = $this->db->query($sql)->result();
        $response_sop['status'] = 200;
        $response_sop['error']  = false;
        $response_sop['data']   = $list_sop;
        return $response_sop;
    }

    function get_sop_review($id_sop)
    {
        $query = "SELECT
        id_sop,
        c.company_id,
        c.name as company_name,
        sop.type_department,
        IF(sop.type_department = 1, sop.department, CONCAT('[',sop.department,']')) AS department_id,
        GROUP_CONCAT(dp.department_name SEPARATOR ', ') as department_name,
        ds.designation_id as designation_id,
        ds.designation_name as designation_name,
        jenis_doc,
        no_doc,
        nama_dokumen,
        file,
        word,
        CONCAT(e.first_name,' ',e.last_name) AS created_by
    FROM
        trusmi_sop AS sop
        LEFT JOIN xin_companies c ON c.company_id = sop.company
        LEFT JOIN xin_departments dp ON FIND_IN_SET(dp.department_id, sop.department)
        LEFT JOIN xin_designations ds ON ds.designation_id = sop.designation
        LEFT JOIN xin_employees e ON e.user_id = sop.created_by
        WHERE
            sop.id_sop = '$id_sop'";
        return $this->db->query($query)->result();
    }

    public function no_jp()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(trusmi_job_profile.no_jp, 3)) AS kd_max FROM trusmi_job_profile WHERE SUBSTR(trusmi_job_profile.created_at, 1, 10) = CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        return 'JP' . date('ymd') . $kd;
    }

    function getDd()
    {
        $sql = "SELECT id_sop, nama_dokumen FROM trusmi_sop AS sop";
        return $this->db->query($sql);
    }

    function getDetail($id)
    {
        $sql = "SELECT
        relasi.id_parent,
        relasi.id_child,
        no_doc,
        nama_dokumen
        FROM
        trusmi_relasi AS relasi
        LEFT JOIN trusmi_sop ON relasi.id_child = id_sop
        WHERE
        relasi.id_parent = $id";
        $list_detail = $this->db->query($sql)->result();

        $response_dtl['status'] = 200;
        $response_dtl['error']  = false;
        $response_dtl['data']   = $list_detail;
        return $response_dtl;
    }

    function insert()
    {
        $config['upload_path']   = './assets/files/';
        $config['allowed_types'] = '*';
        $config['max_size']      = 0;
        $config['file_name']     = time();

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            echo $this->upload->display_errors();
        } else {
            $files = $this->upload->data();
            $file_upload = $files['raw_name'] . $files['file_ext'];
        }

        if (!$this->upload->do_upload('word')) {
            echo $this->upload->display_errors();
        } else {
            $word = $this->upload->data();
            $word_upload = $word['raw_name'] . $word['file_ext'];
        }

        if ($_POST['type_department'] == 1) {
            $department = ($_POST['department'] == null || $_POST['department'] == '') ? 0 : $_POST['department'];
        } else {
            $department = implode(',', $_POST['department_multi']);
        }

        if ($_POST['type_department'] == 1) {
            $designation = ($_POST['designation'] == null || $_POST['designation'] == '') ? 0 : implode(',', $_POST['designation']);
        } else {
            $designation = implode(',', $_POST['designation_multi']);
        }

        $id_user = $this->session->userdata('user_id');
        if (isset($_POST['start_date'])) {
            $data = array(
                'company'        => $_POST['company'],
                'type_department'=> $_POST['type_department'],
                'department'     => $department,
                'designation'    => $designation,
                'jenis_doc'      => $_POST['jenis_doc'],
                'no_doc'         => $_POST['no_doc'],
                'tgl_terbit'     => date('Y-m-d', strtotime($_POST['tgl_terbit'])),
                'tgl_update'     => date('Y-m-d', strtotime($_POST['tgl_update'])),
                'start_date'     => date('Y-m-d', strtotime($_POST['start_date'])) . ' 01:00:00',
                'end_date'       => date('Y-m-d', strtotime($_POST['end_date'])) . ' 23:59:59',
                'nama_dokumen'   => $_POST['nama_doc'],
                'file'           => $file_upload,
                'word'           => $word_upload,
                'created_at'     => date("Y-m-d H:i:s"),
                'created_by'     => $id_user
            );
        } else {
            $data = array(
                'company'        => $_POST['company'],
                'type_department'=> $_POST['type_department'],
                'department'     => $department,
                'designation'    => $designation,
                'jenis_doc'      => $_POST['jenis_doc'],
                'no_doc'         => $_POST['no_doc'],
                'tgl_terbit'     => date('Y-m-d', strtotime($_POST['tgl_terbit'])),
                'tgl_update'     => date('Y-m-d', strtotime($_POST['tgl_update'])),
                'nama_dokumen'   => $_POST['nama_doc'],
                'file'           => $file_upload,
                'word'           => $word_upload,
                'created_at'     => date("Y-m-d H:i:s"),
                'created_by'     => $id_user
            );
        }

        $this->db->insert('trusmi_sop', $data);
    }

    function update()
    {
        if ($_POST['type_department'] == 1) {
            $department = ($_POST['department'] == null || $_POST['department'] == '') ? 0 : $_POST['department'];
        } else {
            $department = implode(',', $_POST['department_multi']);
        }

        if ($_POST['type_department'] == 1) {
            $designation = ($_POST['designation'] == null || $_POST['designation'] == '') ? 0 : implode(',', $_POST['designation']);
        } else {
            $designation = implode(',', $_POST['designation_multi']);
        }

        if ($_FILES['word']['size'] > 0 && $_FILES['file']['size'] > 0) {
            $config['upload_path']   = './assets/files/';
            $config['allowed_types'] = '*';
            $config['max_size']      = 0;
            $config['file_name']     = time();

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file')) {
                echo $this->upload->display_errors();
            } else {
                $files = $this->upload->data();
                $file_upload = $files['raw_name'] . $files['file_ext'];
            }

            if (!$this->upload->do_upload('word')) {
                echo $this->upload->display_errors();
            } else {
                $files = $this->upload->data();
                $word_upload = $files['raw_name'] . $files['file_ext'];
            }

            $data = array(
                'company'        => $_POST['company'],
                'type_department'=> $_POST['type_department'],
                'department'     => $department,
                'designation'    => $designation,
                'jenis_doc'      => $_POST['jenis_doc'],
                'no_doc'         => $_POST['no_doc'],
                'tgl_terbit'     => date('Y-m-d', strtotime($_POST['tgl_terbit'])),
                'tgl_update'     => date('Y-m-d', strtotime($_POST['tgl_update'])),
                'start_date'     => date('Y-m-d', strtotime($_POST['start_date'])) . ' 01:00:00',
                'end_date'       => date('Y-m-d', strtotime($_POST['end_date'])) . ' 23:59:59',
                'nama_dokumen'   => $_POST['nama_doc'],
                'file'           => $file_upload,
                'word'           => $word_upload,
            );
        } else if ($_FILES['file']['size'] > 0) {
            $config['upload_path']   = './assets/files/';
            $config['allowed_types'] = '*';
            $config['max_size']      = 0;
            $config['file_name']     = time();

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                echo $this->upload->display_errors();
            } else {
                $files = $this->upload->data();
                $file_upload = $files['raw_name'] . $files['file_ext'];
            }

            $data = array(
                'company'        => $_POST['company'],
                'type_department'=> $_POST['type_department'],
                'department'     => $department,
                'designation'    => $designation,
                'jenis_doc'      => $_POST['jenis_doc'],
                'no_doc'         => $_POST['no_doc'],
                'tgl_terbit'     => date('Y-m-d', strtotime($_POST['tgl_terbit'])),
                'tgl_update'     => date('Y-m-d', strtotime($_POST['tgl_update'])),
                'start_date'     => date('Y-m-d', strtotime($_POST['start_date'])) . ' 01:00:00',
                'end_date'       => date('Y-m-d', strtotime($_POST['end_date'])) . ' 23:59:59',
                'nama_dokumen'   => $_POST['nama_doc'],
                'file'           => $file_upload,
            );
        } else if ($_FILES['word']['size'] > 0) {
            $config['upload_path']   = './assets/files/';
            $config['allowed_types'] = '*';
            $config['max_size']      = 0;
            $config['file_name']     = time();

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('word')) {
                echo $this->upload->display_errors();
            } else {
                $files = $this->upload->data();
                $word_upload = $files['raw_name'] . $files['file_ext'];
            }

            $data = array(
                'company'        => $_POST['company'],
                'type_department'=> $_POST['type_department'],
                'department'     => $department,
                'designation'    => $designation,
                'jenis_doc'      => $_POST['jenis_doc'],
                'no_doc'         => $_POST['no_doc'],
                'tgl_terbit'     => date('Y-m-d', strtotime($_POST['tgl_terbit'])),
                'tgl_update'     => date('Y-m-d', strtotime($_POST['tgl_update'])),
                'start_date'     => date('Y-m-d', strtotime($_POST['start_date'])) . ' 01:00:00',
                'end_date'       => date('Y-m-d', strtotime($_POST['end_date'])) . ' 23:59:59',
                'nama_dokumen'   => $_POST['nama_doc'],
                'word'           => $word_upload,
            );
        } else {
            $data = array(
                'company'        => $_POST['company'],
                'type_department'=> $_POST['type_department'],
                'department'     => $department,
                'designation'    => $designation,
                'jenis_doc'      => $_POST['jenis_doc'],
                'no_doc'         => $_POST['no_doc'],
                'tgl_terbit'     => date('Y-m-d', strtotime($_POST['tgl_terbit'])),
                'tgl_update'     => date('Y-m-d', strtotime($_POST['tgl_update'])),
                'start_date'     => date('Y-m-d', strtotime($_POST['start_date'])) . ' 01:00:00',
                'end_date'       => date('Y-m-d', strtotime($_POST['end_date'])) . ' 23:59:59',
                'nama_dokumen'   => $_POST['nama_doc']
            );
        }

        $this->db->where('id_sop', $_POST['id_sop']);
        $this->db->update('trusmi_sop', $data);
    }

    public function data_user($id_user)
    {
        $query = "SELECT
            xin_employees.user_id,
            xin_employees.username,
            xin_employees.contact_no,
            CONCAT(xin_employees.first_name, ' ', xin_employees.last_name) AS employee,
            xin_departments.department_name,
            xin_designations.designation_name,
            CONCAT(report.first_name, ' ', report.last_name) AS report_to,
            xin_employees.ctm_report_to,
            com.name
        FROM
            xin_employees
            JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
            JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
            LEFT JOIN xin_employees AS report ON report.user_id = xin_employees.ctm_report_to
            LEFT JOIN xin_companies AS com ON com.company_id = xin_employees.company_id
        WHERE
            xin_employees.user_id = '$id_user'";
        return $this->db->query($query)->result();
    }

    function save_request($data)
    {
        return $this->db->insert('trusmi_sop', $data);
    }

    function get_golongan_jp()
    {
        return $this->db->query("SELECT level_romawi AS `level`, role_name FROM xin_user_roles WHERE level_romawi IS NOT NULL AND role_id NOT IN (1,11,12,13) ORDER BY level_romawi")->result();
    }

    function send_wa($phone, $jabatan, $divisi, $perusahaan, $user)
    {
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            "channelID"   => "2219204182",
            "phone"       => $phone,
            "messageType" => "text",
            "body"        => "✅ Pemberitahuan Update Pembuatan Job Profile\n\nJabatan: $jabatan\nDivisi: $divisi\nPerusahaan: $perusahaan\nUser: $user\n\nsudah selesai dibuat dan dapat diajukan untuk pembuatan FPK melalui HR System",
            "withCase"    => true
        );

        $options_text = array(
            'http' => array(
                "method"  => 'POST',
                "content" => json_encode($data_text),
                "header"  => "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "API-Key: 5ada255e91b7be8b730b9c4b2913b4af75debbc2aef4f1454f5983587d27190f"
            )
        );
        $context_text = stream_context_create($options_text);
        $result_text  = file_get_contents($url, false, $context_text);
        $response['text'] = json_decode($result_text);
    }
}
