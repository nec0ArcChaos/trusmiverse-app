<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leave extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_leave");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $get_level_sto = $this->db->query("SELECT e.ctm_posisi, r.level_sto FROM xin_employees e LEFT JOIN xin_user_roles r ON r.role_name = e.ctm_posisi WHERE e.user_id = '$user_id'")->row_array();
        $user_role_id = $this->session->userdata('user_role_id');
        $super_role = ['1'];
        $user_level_sto = $get_level_sto['level_sto'];
        if (in_array($user_role_id, $super_role)) {
            $data['select_stat'] = "";
            $data['select_class'] = "";
            $data['txz'] = true;
            $data['spv'] = true;
        } elseif ($user_level_sto >= 4) {
            $data['select_stat'] = "disabled";
            $data['select_class'] = "d-none";
            $data['txz'] = false;
            $data['spv'] = true;
        } else {
            $data['select_stat'] = "disabled";
            $data['select_class'] = "d-none";
            $data['txz'] = false;
            $data['spv'] = false;
        }
        $data['pageTitle']        = "Manage Leave";
        $data['js']               = "leave/js";
        $data['css']              = "leave/css";
        $data['content']          = "leave/index";
        $data['company']          = $this->db->query("SELECT company_id, `name` AS company_name FROM xin_companies")->result();
        $data['user']             = $this->model_leave->get_user($user_id);
        $this->load->view('layout/main', $data);
    }

    public function detail($leave_id)
    {
        $user_id = $this->session->userdata('user_id');
        $get_level_sto = $this->db->query("SELECT e.ctm_posisi, r.level_sto FROM xin_employees e LEFT JOIN xin_user_roles r ON r.role_name = e.ctm_posisi WHERE e.user_id = '$user_id'")->row_array();
        $user_level_sto = $get_level_sto['level_sto'];
        $user_role_id = $this->session->userdata('user_role_id');
        $super_role = ['1'];
        if (in_array($user_role_id, $super_role)) {
            $data['pageTitle']             = "Leave Details";
            $data['js']                    = "leave/detail_js";
            $data['css']                   = "leave/detail_css";
            $data['content']               = "leave/detail_index";
            $data['company']               = $this->db->query("SELECT company_id, `name` AS company_name FROM xin_companies")->result();
            $data['detail_leave']          = $this->model_leave->get_detail_leave($leave_id);
            $data['last_detail_leave']     = $this->model_leave->get_last_detail_leave($leave_id);
            $this->load->view('layout/main', $data);
        } elseif ($user_level_sto >= 4) {
            $detail_leave = $this->model_leave->get_detail_leave($leave_id);
            if ($detail_leave['employee_id'] != $user_id) {
                $data['pageTitle']             = "Leave Details";
                $data['js']                    = "leave/detail_js";
                $data['css']                   = "leave/detail_css";
                $data['content']               = "leave/detail_index";
                $data['company']               = $this->db->query("SELECT company_id, `name` AS company_name FROM xin_companies")->result();
                $data['detail_leave']          = $detail_leave;
                $data['last_detail_leave']     = $this->model_leave->get_last_detail_leave($leave_id);
                $this->load->view('layout/main', $data);
            } else {
                echo "Anda Tidak Memiliki Akses Ke Halaman Ini";
                exit();
            }
        } else {
            echo "Anda Tidak Memiliki Akses Ke Halaman Ini";
            exit();
        }
    }

    public function available_leave()
    {
        $data_izin = $this->model_leave->get_leave_type();

        echo json_encode($data_izin);
    }

    public function statistic_leave()
    {
        $employee_id = $this->input->post('employee_id');
        $data_statistic = $this->model_leave->get_statistic_leave($employee_id);
        echo json_encode($data_statistic);
    }

    public function test_year()
    {
        echo date("Y-m-d");
    }

    public function applied_leave()
    {
        // Ambil data input dan session
        $user_id      = $this->session->userdata('user_id');
        $user_role_id = $this->session->userdata('user_role_id');
        $periode      = $this->input->post('periode');
        $start        = $this->input->post('start');
        $end          = $this->input->post('end');
        $department_id_input = htmlspecialchars($this->input->post('department_id'));
        $month        = date("m", strtotime($periode));
        $today        = date("Y-m-d", strtotime($periode));

        // Ambil data role dan level STO
        $dt_user_role = $this->db->query("SELECT * FROM xin_user_roles WHERE role_id = $user_role_id")->row_array();
        $level_sto    = $dt_user_role['level_sto'];
        $get_level_sto = $this->db->query("
                    SELECT e.ctm_posisi, r.level_sto 
                    FROM xin_employees e 
                    LEFT JOIN xin_user_roles r ON r.role_name = e.ctm_posisi 
                    WHERE e.user_id = '$user_id'
                ")->row_array();

        // Cek apakah user merupakan kepala departemen
        $head_department = $this->db->query("
                SELECT d.head_id, GROUP_CONCAT(DISTINCT d.department_id) AS str_department_id 
                FROM xin_departments d 
                WHERE head_id = '$user_id' 
                GROUP BY head_id ");
        $data_manage_leave['head_row'] = $head_department->num_rows();

        // Inisialisasi kondisi filter
        $condition_company    = "";
        $condition_department = "";
        $condition_employee   = "";

        $super_role = ['1'];

        // Kondisi untuk super role
        if (in_array($user_role_id, $super_role)) {
            $company_id  = htmlspecialchars($this->input->post('company_id'));
            $employee_id = htmlspecialchars($this->input->post('employee_id'));

            $condition_company    = ($company_id == 'all') ? "" : "AND l.company_id = '$company_id'";
            $condition_department = ($department_id_input == 'all') ? "" : "AND l.department_id = '$department_id_input'";
            $condition_employee   = ($employee_id == 'all') ? "" : "AND l.employee_id = '$employee_id'";
        }
        // Kondisi untuk kepala departemen
        elseif ($head_department->num_rows() > 0) {
            $data_head          = $head_department->row_array();
            $department_id_arr  = $data_head['str_department_id'];
            $head_level_sto     = $get_level_sto['level_sto'];
            $data_manage_leave['department_id_arr'] = $department_id_arr;

            if ($user_id == 1369) { // Kondisi khusus
                $condition_company    = "";
                $condition_department = "AND (l.company_id IN (1,4,5) OR (l.department_id IN ($department_id_arr) OR l.employee_id = '$user_id' OR (us.level_sto <= $head_level_sto AND l.department_id = $department_id_input)))";
                $condition_employee   = " ";
            } else {
                $condition_company    = "";
                $condition_department = "AND (l.department_id IN ($department_id_arr) OR l.employee_id = '$user_id' OR (us.level_sto <= $head_level_sto AND l.department_id = $department_id_input))";
                $condition_employee   = " ";
            }
        }
        // Kondisi untuk user biasa
        else {
            $company_id    = $this->session->userdata('company_id');
            $department_id = $this->session->userdata('department_id');
            $employee_id   = $this->session->userdata('user_id');
            $user_level_sto = $get_level_sto['level_sto'];

            $condition_company    = "AND l.company_id = '$company_id'";
            $condition_department = "AND dpc.department_id = '$department_id'";
            $condition_employee   = ($user_level_sto >= 4)
                ? "AND (l.employee_id = '$employee_id' OR us.level_sto <= $user_level_sto)"
                : "AND l.employee_id = '$employee_id'";
        }

        // Filter status leave
        $status_leave = htmlspecialchars($this->input->post('status_leave'));
        $condition_status = ($status_leave == 'all') ? "" : "AND l.status = '$status_leave'";

        // Kondisi spesial untuk user_id tertentu
        $kondisi_spesial = "";

        if ($user_id == 323) {
            $kondisi_spesial = " OR (l.employee_id IN (6488,340) $condition_status)";
        } else if ($user_id == 10231) {
            $kondisi_spesial = " OR (l.employee_id IN (2,321,3325,4498,7731,8298,9621,9645,9825,10214,10321,10379) $condition_status)";
        } else if ($user_id == 1721) {
            $kondisi_spesial = " OR (l.company_id = 3 AND l.department_id NOT IN (47,116,168,169))";
        }

        // Kondisi khusus approvable
        $approvable = ($user_id == 979) ? "$user_id = 979 OR" : "";

        // Buat query utama
        $query = "SELECT
                l.leave_id,
                l.employee_id,
                COALESCE(CONCAT(c.first_name, ' ', c.last_name),'') AS employee_name,
                cp.name AS company_name,
                dp.department_name,
                DATE_FORMAT(l.applied_on, '%d-%m-%Y') AS applied_on_2,
                DATE_FORMAT(l.applied_on, '%d %M %Y') AS applied_on,
                t.type_name,
                DATE_FORMAT(l.from_date, '%d-%m-%Y') AS from_date,
                DATE_FORMAT(l.to_date, '%d-%m-%Y') AS to_date,
                IF(l.tgl_ph IS NOT NULL, DATE_FORMAT(l.tgl_ph, '%d-%m-%Y'), '') AS tgl_ph,
                DATEDIFF(l.to_date, l.from_date) + 1 AS total_day,
                COALESCE(SUBSTR(l.start_time, 1, 5), '') AS start_time,
                COALESCE(SUBSTR(l.end_time, 1, 5), '') AS end_time,
                l.reason,
                l.remarks,
                l.leave_attachment,
                COALESCE(l.approved_at, '') AS approved_at,
                COALESCE(DATE_FORMAT(l.approved_at, '%d-%m-%Y'), '') AS tgl_approve,
                COALESCE(DATE_FORMAT(l.approved_at, '%H:%i'), '') AS jam_approve,
                COALESCE(l.verified_at, '') AS verified_at,
                COALESCE(CONCAT(e.first_name, ' ', e.last_name), '') AS approved_by,
                COALESCE(CONCAT(v.first_name, ' ', v.last_name), '') AS verified_by,
                l.`status` AS id_status,
                CASE 
                    WHEN l.`status` = 1 THEN 'bg-warning' 
                    WHEN l.`status` = 4 THEN 'bg-primary' 
                    WHEN l.`status` = 2 THEN 'bg-success' 
                    WHEN l.`status` = 3 THEN 'bg-danger' 
                    ELSE 'bg-warning' 
                END AS bg_status,
                CASE 
                    WHEN l.`status` = 1 THEN 'Pending' 
                    WHEN l.`status` = 4 THEN 'First Level Approval' 
                    WHEN l.`status` = 2 THEN 'Approved' 
                    WHEN l.`status` = 3 THEN 'Reject' 
                    ELSE '' 
                END AS `status`,
                COALESCE(kot.city, '') AS kota,
                IF($approvable ($level_sto > us.level_sto) OR ($level_sto = us.level_sto AND $user_id = dpc.head_id), 1, 0) AS approveable,
                IF($user_id != l.employee_id, 1, 0) AS editable,
                $user_role_id AS role_id,
                c.user_role_id AS role_id_em,
                dpc.head_id AS ehad_id_em,
                us.level_sto AS sto_level
            FROM
                xin_leave_applications l
            LEFT JOIN xin_leave_type t ON t.leave_type_id = l.leave_type_id
            LEFT JOIN xin_employees c ON c.user_id = l.employee_id
            LEFT JOIN xin_departments dpc ON dpc.department_id = c.department_id
            LEFT JOIN xin_user_roles us ON us.role_name = c.ctm_posisi
            LEFT JOIN xin_departments dp ON dp.department_id = l.department_id
            LEFT JOIN xin_companies cp ON cp.company_id = dp.company_id
            LEFT JOIN xin_employees e ON e.user_id = l.approved_by
            LEFT JOIN xin_employees v ON v.user_id = l.verified_by
            LEFT JOIN trusmi_kota kot ON kot.id = l.kota
            WHERE SUBSTR(l.from_date, 1, 10) BETWEEN '$start' AND '$end'
                $condition_status
                $condition_company
                $condition_department
                $condition_employee
                $kondisi_spesial
            ORDER BY SUBSTR(l.from_date, 1, 10) DESC";
        
        $data_manage_leave['data'] = $this->db->query($query)->result();
        echo json_encode($data_manage_leave);
    }



    public function pending_leave()
    {
        $user_id = $this->session->userdata('user_id');
        $periode = $this->input->post('periode');
        // $start = $this->input->post('start');
        // $end = $this->input->post('end');
        $month = date("m", strtotime($periode));

        $today = date("Y-m-d", strtotime($periode));
        $start = date("Y-m-21", strtotime(date("Y-m-21") . " -4 months"));
        $end = date("Y-m-20", strtotime(date("Y-m-20") . " +2 months"));


        $user_role_id = $this->session->userdata('user_role_id');
        $super_role = ['1'];
        $get_level_sto = $this->db->query("SELECT e.ctm_posisi, r.level_sto FROM xin_employees e LEFT JOIN xin_user_roles r ON r.role_name = e.ctm_posisi WHERE e.user_id = '$user_id'")->row_array();
        $head_department = $this->db->query("SELECT d.head_id, GROUP_CONCAT(DISTINCT d.department_id) AS str_department_id FROM xin_departments d WHERE head_id = '$user_id' GROUP BY head_id");
        $data_manage_leave['head_row'] = $head_department->num_rows();
        $company_id = htmlspecialchars($this->input->post('company_id'));
        $department_id = htmlspecialchars($this->input->post('department_id'));
        $employee_id = htmlspecialchars($this->input->post('employee_id'));
        if (in_array($user_role_id, $super_role)) {
            if ($company_id == 'all') {
                $condition_company = "";
            } else {
                $condition_company = "AND l.company_id = '$company_id'";
            }
            if ($department_id == 'all') {
                $condition_department = "";
            } else {
                $condition_department = "AND l.department_id = '$department_id'";
            }
            if ($employee_id == 'all') {
                $condition_employee = "";
            } else {
                $condition_employee = "AND l.employee_id = '$employee_id'";
            }
        } else if ($head_department->num_rows() > 0) {
            $data_head = $head_department->row_array();
            $department_id_arr = $data_head['str_department_id'];
            $head_level_sto = $get_level_sto['level_sto'];
            $data_manage_leave['department_id_arr'] = $department_id_arr;
            $condition_company = "";
            $condition_department = "AND (l.department_id IN ($department_id_arr) OR dpc.department_id = '$department_id')";
            $condition_employee = " AND us.level_sto <= $head_level_sto";
        } else {
            $company_id    = $this->session->userdata('company_id');
            $department_id = $this->session->userdata('department_id');
            $employee_id   = $this->session->userdata('user_id');

            $user_level_sto = $get_level_sto['level_sto'];
            $condition_company = "AND l.company_id = '$company_id'";
            // $condition_department = "AND l.department_id = '$department_id'";
            $condition_department = "AND dpc.department_id = '$department_id'";
            if ($user_level_sto >= 4) {
                $condition_employee = "AND ( l.employee_id = '$employee_id' OR us.level_sto <= $user_level_sto )";
            } else {
                $condition_employee = "AND l.employee_id = '$employee_id'";
            }
        }

        $status_leave = htmlspecialchars($this->input->post('status_leave'));

        if ($status_leave == 'all') {
            $condition_status = "";
        } else {
            $condition_status = " l.status = '$status_leave'";
        }

        $query = "SELECT
                    l.leave_id,
                    l.employee_id,
                    COALESCE(CONCAT(c.first_name, ' ', c.last_name),'') AS employee_name,
                    cp.name AS company_name,
                    dp.department_name,
                    DATE_FORMAT(l.applied_on, '%d-%m-%Y') AS applied_on_2,
                    DATE_FORMAT(l.applied_on, '%d %M %Y') AS applied_on,
                    t.type_name,
                    DATE_FORMAT(l.from_date, '%d-%m-%Y') AS from_date,
                    DATE_FORMAT(l.to_date, '%d-%m-%Y') AS to_date,
                    IF(l.tgl_ph is not null, DATE_FORMAT(l.tgl_ph, '%d-%m-%Y'),'') AS tgl_ph,
                    DATEDIFF(l.to_date, l.from_date) + 1 AS total_day,
                    COALESCE(SUBSTR(l.start_time,1,5),'') AS start_time,
                    COALESCE(SUBSTR(l.end_time,1,5),'') AS end_time,
                    l.reason,
                    l.remarks,
                    l.leave_attachment,
                    COALESCE(l.approved_at,'') AS approved_at,
                    COALESCE(DATE_FORMAT(l.approved_at, '%d-%m-%Y'),'') AS tgl_approve,
                    COALESCE(DATE_FORMAT(l.approved_at, '%H:%i'),'') AS jam_approve,
                    COALESCE(l.verified_at,'') AS verified_at,
                    COALESCE(CONCAT(e.first_name, ' ', e.last_name),'') AS approved_by,
                    COALESCE(CONCAT(v.first_name, ' ', v.last_name),'') AS verified_by,
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
                LEFT JOIN xin_departments dpc ON dpc.department_id = c.department_id
                LEFT JOIN xin_user_roles us ON us.role_name = c.ctm_posisi
                LEFT JOIN xin_companies cp ON cp.company_id = c.company_id
                LEFT JOIN xin_departments dp ON dp.department_id = c.department_id
                LEFT JOIN xin_employees e ON e.user_id = l.approved_by
                LEFT JOIN xin_employees v ON v.user_id = l.verified_by
                WHERE 
                -- SUBSTR(l.from_date,1,10) BETWEEN '$start' AND '$end' 
                $condition_status $condition_company $condition_department $condition_employee
                ORDER BY SUBSTR(l.from_date,1,10) DESC";

        $data_manage_leave['data'] = $this->db->query($query)->result();

        echo json_encode($data_manage_leave);
    }

    public function get_department()
    {
        $department = "";
        $company_id = $this->input->post('company_id');
        if ($company_id != "") {
            if ($company_id == "all") {
                $department = $this->db->query("SELECT department_id, department_name FROM xin_departments ORDER BY department_name")->result();
            } else {
                $department = $this->db->query("SELECT department_id, department_name FROM xin_departments WHERE company_id = '$company_id' ORDER BY department_name")->result();
            }
        }
        echo json_encode($department);
    }
    public function get_employee()
    {
        $department = "";
        $department_id = $this->input->post('department_id');
        if ($department_id != "") {
            if ($department_id == "all") {
                $employee = $this->db->query("SELECT user_id AS employee_id, CONCAT(first_name,' ',last_name) AS employee_name FROM xin_employees WHERE is_active = 1 ORDER BY CONCAT(first_name,' ',last_name)")->result();
            } else {
                $employee = $this->db->query("SELECT user_id AS employee_id, CONCAT(first_name,' ',last_name) AS employee_name FROM xin_employees WHERE department_id = '$department_id' AND is_active = 1 ORDER BY CONCAT(first_name,' ',last_name)")->result();
            }
        }
        echo json_encode($employee);
    }

    public function update_leave()
    {
        $response['status'] = false;
        $response['update'] = "";
        $leave_id = $this->input->post('leave_id') ?? "";
        $employee_id = $this->input->post('employee_id') ?? "";
        if ($leave_id != "" && $employee_id != "") {
            // $remarks = htmlspecialchars($this->input->post('remarks'));
            $reason = htmlspecialchars($this->input->post('reason'));
            $data = [
                // 'remarks' => $remarks,
                'reason' => $reason,
            ];
            $update = $this->db->where('leave_id', $leave_id)->where('employee_id', $employee_id)->update('xin_leave_applications', $data);
            $response['update'] = $update;
            $response['status'] = true;
        }
        echo json_encode($response);
    }

    public function update_leave_hr()
    {
        // user yang bisa change leave type
        // $user_allowed = ['979'];
        $user_id = $this->session->userdata('user_id');
        $leave_id   = htmlspecialchars($this->input->post('leave_id'));
        if (isset($leave_id)) {
            $leave_type_id = htmlspecialchars($this->input->post('leave_type_id'));
            $id_status = htmlspecialchars($this->input->post('id_status'));
            $start_date = explode(' ', $this->input->post('start_date'));
            $end_date   = explode(' ', $this->input->post('end_date'));
            $remarks    = htmlspecialchars($this->input->post('remarks'));
            $from_date  = $start_date[0];
            $to_date    = $end_date[0];
            // dlk 13 and 23
            $dlk = ['13', '23'];
            if (in_array($leave_type_id, $dlk) == 1) {
                $start_time = $start_date[1] ?? null;
                $end_time   = $end_date[1] ?? null;
            } else {
                $start_time =  null;
                $end_time   =  null;
            }

            $leave_type = htmlspecialchars($this->input->post('leave_type'));
            $data = [
                'leave_type_id' => $leave_type,
                'from_date'     => $from_date,
                'to_date'       => $to_date,
                'start_time'    => $start_time,
                'end_time'      => $end_time,
                'verified_by'   => $this->session->userdata('user_id'),
                'verified_at'   => date("Y-m-d H:i:s"),
                'updated_by'   => $this->session->userdata('user_id'),
                'updated_at'   => date("Y-m-d H:i:s"),
                'is_notify'     => 0
            ];

            $update = $this->db->where('leave_id', $leave_id)->update('xin_leave_applications', $data);

            $response['status'] = $update;
            $response['data'] = $data;
        } else {
            $response = "";
        }
        echo json_encode($response);
    }
    public function approve_leave()
    {
        // user yang bisa change leave type
        // $user_allowed = ['979'];
        $user_id = $this->session->userdata('user_id');
        $leave_id   = htmlspecialchars($this->input->post('leave_id'));
        if (isset($leave_id)) {
            $leave_type_id = htmlspecialchars($this->input->post('leave_type_id'));
            $id_status = htmlspecialchars($this->input->post('id_status'));
            $start_date = explode(' ', $this->input->post('start_date'));
            $end_date   = explode(' ', $this->input->post('end_date'));
            $remarks    = htmlspecialchars($this->input->post('remarks'));
            $from_date  = $start_date[0];
            $to_date    = $end_date[0];
            // dlk 13 and 23
            $dlk = ['13', '23'];
            if (in_array($leave_type_id, $dlk) == 1) {
                $start_time = $start_date[1] ?? null;
                $end_time   = $end_date[1] ?? null;
            } else {
                $start_time =  null;
                $end_time   =  null;
            }

            // if (in_array($user_id, $user_allowed) == 1) {
            //     $leave_type = htmlspecialchars($this->input->post('leave_type'));
            //     $data = [
            //         'leave_type_id' => $leave_type,
            //         'from_date'     => $from_date,
            //         'to_date'       => $to_date,
            //         'remarks'       => $remarks,
            //         'start_time'    => $start_time,
            //         'end_time'      => $end_time,
            //         'verified_by'   => $this->session->userdata('user_id'),
            //         'verified_at'   => date("Y-m-d H:i:s"),
            //         'updated_by'   => $this->session->userdata('user_id'),
            //         'updated_at'   => date("Y-m-d H:i:s"),
            //     ];
            // } else {
            if ($id_status != 1) {
                $data = [
                    'from_date'     => $from_date,
                    'to_date'       => $to_date,
                    'remarks'       => $remarks,
                    'start_time'    => $start_time,
                    'end_time'      => $end_time,
                    'status'        => 2,
                    'updated_by'   => $this->session->userdata('user_id'),
                    'updated_at'   => date("Y-m-d H:i:s"),
                ];
            } else {
                $data = [
                    'from_date'     => $from_date,
                    'to_date'       => $to_date,
                    'remarks'       => $remarks,
                    'start_time'    => $start_time,
                    'end_time'      => $end_time,
                    'status'        => 2,
                    'approved_by'   => $this->session->userdata('user_id'),
                    'approved_at'   => date("Y-m-d H:i:s"),
                    'updated_by'   => $this->session->userdata('user_id'),
                    'updated_at'   => date("Y-m-d H:i:s"),
                ];
            }
            // }

            $update = $this->db->where('leave_id', $leave_id)->update('xin_leave_applications', $data);

            $response['status'] = $update;
            $response['data'] = $data;
        } else {
            $response = "";
        }
        echo json_encode($response);
    }

    public function reject_leave()
    {
        $leave_id      = htmlspecialchars($this->input->post('leave_id'));
        if (isset($leave_id)) {
            $leave_type_id = htmlspecialchars($this->input->post('leave_type_id'));
            $id_status     = htmlspecialchars($this->input->post('id_status'));
            $start_date = explode(' ', $this->input->post('start_date'));
            $end_date   = explode(' ', $this->input->post('end_date'));
            $remarks    = htmlspecialchars($this->input->post('remarks'));
            $from_date  = $start_date[0];
            $to_date    = $end_date[0];
            // dlk 13 and 23
            $dlk = ['13', '23'];
            if (in_array($leave_type_id, $dlk)) {
                $start_time =  null;
                $end_time   =  null;
            } else {
                $start_time = $start_date[1] ?? null;
                $end_time   = $end_date[1] ?? null;
            }

            if ($id_status != 1) {
                $data = [
                    'from_date'     => $from_date,
                    'to_date'       => $to_date,
                    'remarks'       => $remarks,
                    'start_time'    => $start_time,
                    'end_time'      => $end_time,
                    'status'        => 3,
                    'verified_by'   => $this->session->userdata('user_id'),
                    'verified_at'   => date("Y-m-d H:i:s"),
                ];
            } else {
                $data = [
                    'from_date'     => $from_date,
                    'to_date'       => $to_date,
                    'remarks'       => $remarks,
                    'start_time'    => $start_time,
                    'end_time'      => $end_time,
                    'status'        => 3,
                    'approved_by'   => $this->session->userdata('user_id'),
                    'approved_at'   => date("Y-m-d H:i:s"),
                ];
            }

            $update = $this->db->where('leave_id', $leave_id)->update('xin_leave_applications', $data);

            $response['status'] = $update;
            $response['data'] = $data;
        } else {
            $response = "";
        }
        echo json_encode($response);
    }

    function delete_leave()
    {
        $user_role_id = $this->session->userdata('user_role_id');
        $super_role = ['1'];
        $destroy = false;
        $leave_id      = htmlspecialchars($this->input->post('leave_id'));
        if (in_array($user_role_id, $super_role)) {
            if (isset($leave_id)) {
                $destroy =  $this->db->where('leave_id', $leave_id)->delete('xin_leave_applications');
            }
        }
        // $response['user_role_id'] = $user_role_id;
        // $response['leave_id'] = $leave_id;
        $response['status'] = $destroy;
        echo json_encode($response);
    }

    public function get_leave_type()
    {
        $response['leave_type'] = $this->model_leave->get_leave_type();
        $response['kota'] = $this->model_leave->get_kota();
        echo json_encode($response);
    }

    public function get_leave_type_detail()
    {
        $user_id = $this->input->post('user_id');
        $response['leave_type'] = $this->model_leave->get_leave_type_detail($user_id);
        $response['kota'] = $this->model_leave->get_kota();
        echo json_encode($response);
    }


    function test_date()
    {

        $st_date = date("Y-m-14");
        $ed_date = date("Y-m-14");
        $day = date('d', strtotime($st_date));
        $company_id = $this->session->userdata('company_id');
        $department_id = $this->session->userdata('department_id');
        if ($company_id == 3 && ($department_id != "175" || $department_id != "177" || $department_id != "180")) {
            if ((int)$day < 16) {
                $start = date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m', strtotime($st_date)) . '-16')));
                $end = date('Y-m-15', strtotime(date('Y-m', strtotime($ed_date))));
            } else {
                $start = date('Y-m-16');
                $end = date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m', strtotime($ed_date)) . '-15')));
            }
        } else {
            if ((int)$day < 21) {
                $start = date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m', strtotime($st_date)) . '-21')));
                $end = date('Y-m-20', strtotime(date('Y-m', strtotime($ed_date))));
            } else {
                $start = date('Y-m-21');
                // $end = date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-20'))));
                $end = date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m', strtotime($ed_date)) . '-20')));
            }
        }

        $pc_dt = "(10, 11)";
        $total_pc_dt = $this->model_leave->cek_leave($this->session->userdata('user_id'), $start, $end, $pc_dt);
        echo $start;
        echo $end;
        echo json_encode($total_pc_dt);
    }


    public function add_leave()
    {

        if ($this->input->post('leave_type') != '') {
            /* Define return | here result is used to return user data and error for error message */
            $start_date = explode(' ', $this->input->post('start_date'));
            $end_date = explode(' ', $this->input->post('end_date'));

            $st_date = strtotime($start_date[0]);
            $ed_date = strtotime($end_date[0]);


            // jika bali dan department 175, 177, 180 maka cut off sama dengan cirebon
            $day = (int)date('d', strtotime($st_date));
            $company_id = $this->session->userdata('company_id');
            $department_id = $this->session->userdata('department_id');
            if ($company_id == 3 && ($department_id != "175" || $department_id != "177" || $department_id != "180")) {
                if ($day < 16) {
                    // start: 16 bulan lalu, dihitung dari $st_date
                    $start = date('Y-m-d', strtotime('16 last month', strtotime($st_date)));
                    // end: 15 bulan ini, dihitung dari $ed_date
                    $end   = date('Y-m-d', strtotime('15 this month', strtotime($ed_date)));
                } else {
                    // start: 16 bulan ini
                    $start = date('Y-m-d', strtotime('16 this month', strtotime($st_date)));
                    // end: 15 bulan depan
                    $end   = date('Y-m-d', strtotime('15 next month', strtotime($ed_date)));
                }
            } else {
                if ($day < 21) {
                    // start: 21 bulan lalu, dihitung dari $st_date
                    $start = date('Y-m-d', strtotime('21 last month', strtotime($st_date)));
                    // end: 20 bulan ini, dihitung dari $ed_date
                    $end   = date('Y-m-d', strtotime('20 this month', strtotime($ed_date)));
                } else {
                    // start: 21 bulan ini
                    $start = date('Y-m-d', strtotime('21 this month', strtotime($st_date)));
                    // end: 20 bulan depan
                    $end   = date('Y-m-d', strtotime('20 next month', strtotime($ed_date)));
                }
            }

            $pc_dt = "(10, 11)";
            $total_pc_dt = $this->model_leave->cek_leave($this->session->userdata('user_id'), $start, $end, $pc_dt);

            $bersalin = "(8)";
            $total_bersalin = $this->model_leave->cek_leave($this->session->userdata('user_id'), $start, $end, $bersalin);

            $sakit_dk = "(21)";
            $total_sakit_dk = $this->model_leave->cek_leave($this->session->userdata('user_id'), $start, $end, $sakit_dk);

            $sakit_lk = "(22)";
            $total_sakit_lk = $this->model_leave->cek_leave($this->session->userdata('user_id'), $start, $end, $sakit_lk);

            $kematian_kl = "(9)";
            $total_kematian_kl = $this->model_leave->cek_leave($this->session->userdata('user_id'), $start, $end, $kematian_kl);

            $driver    = $this->model_leave->cek_driver($this->session->userdata('user_id'), $start, $end);


            /* Server side PHP input validation */
            if ($this->input->post('leave_type') === '') {
                $Return['error'] = "Leave Type is Empty";
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }

            if (($this->input->post('leave_type') == 10 || $this->input->post('leave_type') == 11) && $total_pc_dt > 3) {
                $Return['error'] = "Pengajuan Datang Terlambat dan Pulang Cepat Anda Sudah Lebih dari 3x dalam Satu Periode Cut Off " . $start . ' s/d ' . $end;
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('leave_type') == 8 && $total_bersalin >= 2) {
                $Return['error'] = "Pengajuan Istri Bersalin / Keguguran Melebihi Batas Cut Off " . $start . ' s/d ' . $end;
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('leave_type') == 21 && $total_sakit_dk >= 1) {
                $Return['error'] = "Pengajuan Istri/Suami/Anak Sakit (Dalam Kota) Melebihi Batas Cut Off " . $start . ' s/d ' . $end;
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('leave_type') == 22 && $total_sakit_lk >= 2) {
                $Return['error'] = "Pengajuan Istri/Suami/Anak Sakit (Luar Kota) Melebihi Batas Cut Off " . $start . ' s/d ' . $end;
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('leave_type') == 9 && $total_kematian_kl >= 2) {
                $Return['error'] = "Pengajuan Kematian Keluarga Melebihi Batas Cut Off " . $start . ' s/d ' . $end;
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('leave_type') == 7 && $this->input->post('tgl_ph') == "") {
                $Return['error'] = "Harap Isi Tgl Pergantian Hari Libur.";
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }

            // check libur dan dlk
            if ($this->input->post('leave_type') == 7 && $this->input->post('tgl_ph') != "") {
                $tgl_ph = $this->input->post('tgl_ph');
                $user_id = $this->session->userdata('user_id');
                $check_dlk =  $this->db->query("SELECT COUNT(employee_id) AS libur FROM `xin_leave_applications` WHERE leave_type_id = 13 AND '$tgl_ph' BETWEEN SUBSTR(from_date,1,10) AND SUBSTR(to_date,1,10) AND employee_id = $user_id AND `status` = 2")->row_array();
                $check_masuk =  $this->db->query("SELECT COUNT(employee_id) AS masuk FROM `xin_attendance_time` WHERE attendance_date = '$tgl_ph' AND employee_id = $user_id AND clock_in IS NOT NULL AND clock_out IS NOT NULL")->row_array();
                $Return['check_dlk'] = $check_dlk['libur'];
                $Return['check_masuk'] = $check_masuk['masuk'];
                if ($check_masuk['masuk'] > 0 || $check_dlk['libur'] > 0) {
                } else {
                    $Return['error'] = "Maaf anda tidak memenuhi syarat pergantian hari libur.";
                    $Return['status'] = false;
                    echo json_encode($Return);
                    exit();
                }
            }

            // check libur driver dan dlk driver
            if ($this->input->post('leave_type') == 24 && $this->input->post('tgl_ph') != "") {
                $tgl_ph = $this->input->post('tgl_ph');
                $user_id = $this->session->userdata('user_id');
                $check_dlk =  $this->db->query("SELECT COUNT(employee_id) AS libur FROM `xin_leave_applications` WHERE leave_type_id = 23 AND '$tgl_ph' BETWEEN SUBSTR(from_date,1,10) AND SUBSTR(to_date,1,10) AND employee_id = $user_id AND `status` = 2")->row_array();
                // $check_masuk =  $this->db->query("SELECT COUNT(employee_id) AS masuk FROM `xin_attendance_time` WHERE attendance_date = '$tgl_ph' AND employee_id = $user_id AND clock_in IS NOT NULL AND clock_out IS NOT NULL")->row_array();
                $Return['check_dlk'] = $check_dlk['libur'];
                // $Return['check_masuk'] = $check_masuk['masuk'];
                if ($check_dlk['libur'] > 0) {
                } else {
                    $Return['error'] = "Maaf anda tidak memenuhi syarat pergantian hari libur. belum ada pengajuan dlk yang sudah di approve di tgl tersebut.";
                    $Return['status'] = false;
                    echo json_encode($Return);
                    exit();
                }
            }
            // if ($this->input->post('leave_type') == 24 && $driver['driver'] == 0) {
            //     $Return['error'] = "Kelebihan Jam Kerja Belum Mencapai " . $driver['max_work'] . " Jam Per Cut Off " . $start . ' s/d ' . $end;
            //     $Return['status'] = false;
            //     echo json_encode($Return);
            //     exit();
            // }
            if ($this->input->post('start_date') === '') {
                $Return['error'] = 'start_date';
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('end_date') === '') {
                $Return['error'] = 'end_date';
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if (($this->input->post('leave_type') == 13 || $this->input->post('leave_type') == 23) && $this->input->post('kota') === "") {
                $Return['error'] = "Harap Pilih Kota Tujuan.";
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($st_date > $ed_date) {
                $Return['error'] = 'start_end_date is empty';
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->session->userdata('company_id') === '') {
                $Return['error'] = 'any_field is empty';
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->session->userdata('user_id') === '') {
                $Return['error'] = 'employee_id is empty';
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('reason') === '') {
                $Return['error'] = 'leave_type_reason is empty';
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }

            if ($this->input->post('leave_half_day') != 1) {
                $leave_half_day_opt = 0;
            } else {
                $leave_half_day_opt = $this->input->post('leave_half_day');
            }
            if (!empty($_FILES['attachment']['tmp_name'])) {
                if (is_uploaded_file($_FILES['attachment']['tmp_name'])) {
                    //checking image type
                    $allowed =  array('png', 'jpg', 'jpeg', 'pdf', 'gif');
                    $filename = $_FILES['attachment']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    if (in_array($ext, $allowed)) {
                        $tmp_name = $_FILES["attachment"]["tmp_name"];
                        $profile = "/var/www/trusmiverse/hr/uploads/leave/";
                        // $profile = "/uploads/leave/";
                        $set_img = base_url() . "uploads/leave/";
                        // basename() may prevent filesystem traversal attacks;
                        // further validation/sanitation of the filename may be appropriate
                        $name = basename($_FILES["attachment"]["name"]);
                        $newfilename = 'tv_leave_' . round(microtime(true)) . '.' . $ext;
                        move_uploaded_file($tmp_name, $profile . $newfilename);
                        $fname = $newfilename;
                    } else {
                        $Return['error'] = '';
                    }
                }
            } else {
                $fname = '';
            }

            // 7 = Pergantian Hari Libur
            // 24 = Pergantian Hari Libur Driver
            if (in_array($this->input->post('leave_type'), [7, 24])) {
                $tgl_ph = (isset($_POST['tgl_ph'])) ? $_POST['tgl_ph'] : NULL;
            } else {
                $tgl_ph = null;
            }

            $kota = (isset($_POST['kota'])) ? $_POST['kota'] : NULL;

            if ($this->input->post('leave_type') == 13 || $this->input->post('leave_type') == 23 || $this->input->post('leave_type') == 20) {
                $data = array(
                    'employee_id' => $this->session->userdata('user_id'),
                    'company_id' => $this->session->userdata('company_id'),
                    'department_id' => $this->session->userdata('department_id'),
                    'leave_type_id' => $this->input->post('leave_type'),
                    'from_date' => substr($this->input->post('start_date'), 0, 10),
                    'start_time' => substr($this->input->post('start_date'), 11, 5),
                    'to_date' => substr($this->input->post('end_date'), 0, 10),
                    'end_time' => substr($this->input->post('end_date'), 11, 5),
                    'applied_on' => date('Y-m-d h:i:s'),
                    'reason' => $this->input->post('reason'),
                    'leave_attachment' => $fname,
                    'status' => '1',
                    'is_notify' => '1',
                    'is_half_day' => $leave_half_day_opt,
                    'tgl_ph' => $tgl_ph,
                    'kota' => $kota,
                    'created_at' => date('Y-m-d h:i:s')
                );
            } else {
                $data = array(
                    'employee_id' => $this->session->userdata('user_id'),
                    'company_id' => $this->session->userdata('company_id'),
                    'department_id' => $this->session->userdata('department_id'),
                    'leave_type_id' => $this->input->post('leave_type'),
                    'from_date' => substr($this->input->post('start_date'), 0, 10),
                    'to_date' => substr($this->input->post('end_date'), 0, 10),
                    'applied_on' => date('Y-m-d h:i:s'),
                    'reason' => $this->input->post('reason'),
                    'leave_attachment' => $fname,
                    'status' => '1',
                    'is_notify' => '1',
                    'is_half_day' => $leave_half_day_opt,
                    'tgl_ph' => $tgl_ph,
                    'created_at' => date('Y-m-d h:i:s')
                );
            }

            $Return['status'] = true;
            $Return['data'] = $data;
            $result = $this->model_leave->add_leave_record($data);
            // $result = true;
            $Return['result'] = $result;
            echo json_encode($Return);
        }
    }
}
