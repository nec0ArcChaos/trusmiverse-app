<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_dev extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_dashboard");
        $this->load->model("hr/model_rekap_absen", "model_rekap_absen");
        $this->load->model("model_absen", "absen");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Dashboard";
        $data['js']               = "dashboard/js";
        $data['css']              = "dashboard/css";
        $data['content']          = "dashboard/index";
        $this->load->view('layout/main', $data);
    }

    public function resume_absen_old()
    {
        $data = $this->model_dashboard->resume_absen_new();
        echo json_encode($data);
    }

    public function resume_absen()
    {
        $today = date("Y-m-d");
        $start = date("Y-m-21", strtotime($today . " -1 months"));
        $end = date("Y-m-20");
        $company_id = $this->session->userdata("company_id");
        $department_id = $this->session->userdata("department_id");
        $employee_id = $this->session->userdata("user_id");
        $data = $this->model_rekap_absen->get_absensi($start, $end, $company_id, $department_id, $employee_id)->row(0);
        echo json_encode($data);
    }

    public function detail_absen()
    {
        $data['data'] = $this->model_dashboard->detail_absen($this->input->post('periode') ?? date("Y-m"));
        echo json_encode($data);
    }

    public function check_lock_absen()
    {
        $user_id = $this->input->post("user_id");
        $response = $this->check_absen($user_id);
        if (!empty($response)) {
            echo ($response[0]);
        } else {
            echo $this->getResponseData($status = true, $is_active = 1, $achieve = true, $message = '', $statusCode = 200);
        }
    }

    public function resume_izin_leave()
    {
        $user_id = $this->session->userdata("user_id");
        $data = $this->model_dashboard->resume_izin_leave($user_id);
        echo json_encode($data);
    }


    public function index_get($user_id)
    {
        // $user_id	= $this->uri->segment(3);
        $cek_department = $this->absen->cek_department($user_id);
        $last_month = date("Y-m-01", strtotime("-1 month"));
        $date_of_joining = date("Y-m-01", strtotime($cek_department['date_of_joining']));
        $hours = (int)date("H");
        $department_id  = $cek_department['department_id'];
        $company_id     = $cek_department['company_id'];
        $cek             = $this->absen->get_status($user_id);

        // Lock EAF
        $cek_user_approval    = $this->absen->get_user_approval_eaf($user_id);
        $query_lock_user_approval    = $this->absen->get_lock_eaf($user_id);

        // Lock MEP 08-05-2023
        $cek_designation     = $this->absen->cek_designation($user_id);
        $designation_id     = $cek_designation['designation_id'];
        $lock_user_mep        = $this->absen->get_lock_mep($user_id);

        if (($cek_user_approval == true && $query_lock_user_approval == true)) {
            $lock_user_approval = $query_lock_user_approval;
            if ($lock_user_approval['id'] == '0' || $lock_user_approval['id'] == 0) {
                $id_lock = 35; // trusmi lock di tabel trusmi_m_lock
            } else {
                $id_lock = $lock_user_approval['id'];
            }
            return $this->response([
                'status' => false,
                'data' => array(
                    'aktif' => '1',
                    'achive' => false,
                    'message' => $lock_user_approval['warning_lock'],
                    'no' => 1
                )
            ], 200);

            // disable 08-05-2023 Faisal , enable again 22-05-2023
        } else if ($designation_id == 547 && $lock_user_mep == true) {
            return  $this->response([
                'status' => false,
                'data' => array(
                    'aktif' => '1',
                    'achive' => false,
                    'message' => $lock_user_mep['warning_lock'],
                    'no' => 2
                )
            ], 200);
        } else if ($date_of_joining >= $last_month && $company_id == 2 &&  $hours > 12) {
            // Aris
            $query_kry_training = $this->absen->cek_karyawan_basic_training($user_id);
            $count_kry = $query_kry_training->num_rows();
            if ($count_kry > 0) {
                $d_kry_basic = $query_kry_training->row();
                $msg = $d_kry_basic->warning_lock . ", " . $d_kry_basic->ket;
                return $this->response(
                    [
                        'status' => true,
                        'data' => array(
                            'aktif' => $cek['is_active'],
                            'achive' => false,
                            'message' => $msg,
                            'no' => 3
                        )
                    ],
                    200
                );
            } else if ($company_id == 2 && $department_id == 120 && $hours > 12) {
                $query_kry_training_mkt = $this->absen->cek_karyawan_basic_training_mkt($user_id);
                $count_kry_mkt = $query_kry_training_mkt->num_rows();
                if ($count_kry_mkt > 0) {
                    $d_kry_basic_mkt = $query_kry_training_mkt->row();
                    $msg = $d_kry_basic_mkt->warning_lock . ", " . $d_kry_basic_mkt->ket;
                    return $this->response(
                        [
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => false,
                                'message' => $msg,
                                'no' => 4
                            )
                        ],
                        200
                    );
                } else {
                    $this->lock_absen($user_id, $company_id, $department_id, $cek);
                }
            } else {
                $this->lock_absen($user_id, $company_id, $department_id, $cek);
            }
        } else {
            $this->lock_absen($user_id, $company_id, $department_id, $cek);
        }
    }

    function response($data)
    {
        echo json_encode($data);
    }

    public function lock_absen($user_id, $company_id, $department_id, $cek)
    {
        if (
            $department_id == 24 /* marketing */
            || $department_id == 28 /* project */
            || $department_id == 120 /* marketing executive */
            || $department_id == 27 /* Finance */
            || $department_id == 134 /* aftersales */
            || $department_id == 138 /* SCM */
            || $department_id == 147 /* PURCHASING BT */
            || $department_id == 14 /* STORE BT */
            || $department_id == 9 /* STORE WH BT */
            || $department_id == 106 /* Project Housing */
            // || $department_id == 107 /* Project Infrastruktur Area 2 */
            // || $department_id == 111 /* Surveyor */
            || $department_id == 95 /* SCM BT */
        ) {
            if ($cek) { // user is active
                $cek_mkt        = $this->absen->cek_mkt($user_id, $department_id)->row_array();
                if ($cek_mkt['divisi'] == 2) { // 2 : MARKETING
                    if ($cek_mkt['total'] > 4) {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => true,
                                'message' => '',
                                'no' => 5
                            )
                        ], 200);
                    } else {
                        return $this->response([
                            'status' => false,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => false,
                                'message' => $cek_mkt['warning_lock'],
                                'no' => 6
                            )
                        ], 200);
                    }
                } else if ($cek_mkt['divisi'] == 11) { // 11 : PELAKSANA
                    if ($cek_mkt['total'] > 0 || $cek_mkt['created_at'] == null) {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => true,
                                'message' => '',
                                'no' => 7
                            )
                        ], 200);
                    } else {
                        // if ($cek_mkt['spv'] == 1) {
                        // 	$id_lock = '3';
                        // 	$msg = 'Anda belum melakukan approval Peringatan Vendor atau Approval Bahan. Harap melakukan approval terlebih dahulu.';
                        // } else {
                        // 	$id_lock = '3';
                        // 	$msg = 'Anda belum mencapai minimum target tasklist, Harap penuhi target tasklist anda.';
                        // }
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => false,
                                // 'message' => 'Anda belum mengerjakan tasklist, Harap kerjakan tasklist terlebih dahulu.'
                                // 'message' => $msg,
                                'message' => $cek_mkt['warning_lock'],
                                'no' => 8
                            )
                        ], 200);
                    }

                    // // 8-5-23
                } else if ($cek_mkt['divisi'] == 1477) { // 1477 : PURCHASING CRB BT
                    if ($cek_mkt['absen'] > 0) {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => false,
                                'message' => $cek_mkt['warning_lock'],
                                'no' => 9
                            )
                        ], 200);
                    } else {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => true,
                                // 'message' => 'Anda belum mengerjakan tasklist, Harap kerjakan tasklist terlebih dahulu.'
                                'message' => '',
                                'no' => 10
                            )
                        ], 200);
                    }
                } else if ($cek_mkt['divisi'] == 1400) { // 1477 : STORE CRB BT
                    if ($cek_mkt['absen'] > 0) {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => false,
                                'message' => $cek_mkt['warning_lock'],
                                'no' => '11'
                            )
                        ], 200);
                    } else {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => true,
                                'message' => '',
                                'no' => 12
                            )
                        ], 200);
                    }

                    // // 8-5-23
                } else if ($cek_mkt['divisi'] == 9500) { // 1477 : CRB BT SCM
                    if ($cek_mkt['absen'] > 0) {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => false,
                                'message' => $cek_mkt['warning_lock']
                            )
                        ], 200);
                    } else {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => true,
                                'message' => ''
                            )
                        ], 200);
                    }
                } else {
                    // lock absen admin collect
                    // if (in_array($user_id, ['1031', '2915', '2921'])) {
                    // 	// 1031	Herman
                    // 	// 2915	Favian Andre Lukita 
                    // 	// 2921	Danang Budiharjo 
                    // 	$hours = (int)date("H"); // '20'
                    // 	$cek_adm_collect		= $this->absen->cek_adm_collect($user_id)->row();
                    // 	$msg = $cek_adm_collect->warning_lock . " Ach anda " . $cek_adm_collect->total . "%" . " (" . $cek_adm_collect->actual . "/" . $cek_adm_collect->target . ")";
                    // 	if ($cek_adm_collect->total >= 100 && $hours > 11) {
                    // 		return $this->response(
                    // 			[
                    // 				'status' => true,
                    // 				'data' => array(
                    // 					'aktif' => $cek['is_active'],
                    // 					'achive' => true,
                    // 					'message' => ''
                    // 				)
                    // 			],
                    // 			200
                    // 		);
                    // 	} else {
                    // 		// history lock
                    // 		$this->insert_history(
                    // 			[
                    // 				'employee_id' => $user_id,
                    // 				'lock_type'   => $cek_adm_collect->id_lock,
                    // 				'reason'      => $msg,
                    // 				'created_at'  => date("Y-m-d H:i:s"),
                    // 			]
                    // 		);
                    // 		return $this->response(
                    // 			[
                    // 				'status' => true,
                    // 				'data' => array(
                    // 					'aktif' => $cek['is_active'],
                    // 					'achive' => false,
                    // 					'message' => $msg
                    // 				)
                    // 			],
                    // 			200
                    // 		);
                    // 	}
                    // } else {
                    return $this->response([
                        'status' => true,
                        'data' => array(
                            'aktif' => $cek['is_active'],
                            'achive' => true,
                            'message' => '',
                            'no' => 13
                        )
                    ], 200);
                    // }
                }
            } else {
                return $this->response([
                    'status' => false,
                    'message' => "ID Tidak Ditemukan"
                ], 404);
            }
        } else {


            // cek jam saat ini
            // $dt = date_create("Y-m-d H:i:s", date("Y-m-d H:i:s"));

            // } else if ($query_kry_training->num_rows() > 0 &&  $hours > 14) {
            // 	$d_kry_basic = $query_kry_training->row();
            // 	$msg = $d_kry_basic->warning_lock . ", " . $d_kry_basic->ket;
            // 	$this->response(
            // 		[
            // 			'status' => true,
            // 			'data' => array(
            // 				'aktif' => $cek['is_active'],
            // 				'achive' => false,
            // 				'message' => $msg
            // 			)
            // 		],
            // 		200
            // 	);

            // 08-05-2023 Aris
            // $query_kry_training = $this->absen->cek_karyawan_basic_training($user_id);
            if ($company_id == 2 && in_array($user_id, ['1995', '2535', '2897', '3325']) && in_array($department_id, ['142', '72'])) {
                // Aris
                // 1995	Okawati Nurahma Sari department 72
                // 2535	Nani Handayani department 72
                // 1621	Yan Mugi Satriyo department 142
                // 2897	Riyan Gunawan department 72
                $this->validasi_lock_absen_hr($user_id, $cek);
            } else {
                return $this->response(
                    [
                        'status' => true,
                        'data' => array(
                            'aktif' => $cek['is_active'],
                            'achive' => true,
                            'message' => '',
                            'no' => 14
                        )
                    ],
                    200
                );
            }
            // return $this->response(
            // 	[
            // 		'status' => true,
            // 		'data' => array(
            // 			'aktif' => $cek['is_active'],
            // 			'achive' => true,
            // 			'message' => ''
            // 		)
            // 	],
            // 	200
            // );
        }
    }
    public function validasi_lock_absen_hr($user_id, $cek)
    {
        $dhr = $this->absen->cek_hr($user_id);
        $cek_hr        = $dhr->row();
        $msg = $cek_hr->warning_lock . " Ach anda " . $cek_hr->total . "%" . " (" . $cek_hr->actual . "/" . $cek_hr->target . ")";
        if ($cek_hr->total >= 100) {
            return    $this->response(
                [
                    'status' => true,
                    'data' => array(
                        'aktif' => $cek['is_active'],
                        'achive' => true,
                        'message' => '',
                    )
                ],
                200
            );
        } else {
            return    $this->response(
                [
                    'status' => true,
                    'data' => array(
                        'aktif' => $cek['is_active'],
                        'achive' => false,
                        'message' => $msg
                    )
                ],
                200
            );
        }
    }

    public function check_lock_absen_dev()
    {
        $user_id = $this->input->post("user_id");
        $response = $this->check_absen($user_id);
        echo ($response);
    }

    function check_absen_dev($user_id = null)
    {
        $getProfile = $this->getProfile($user_id);
        $profile = $getProfile->row_array();
        $company_id = $profile['company_id'];
        $department_id = $profile['department_id'];

        $this->isUserValid($getProfile->num_rows());
        $this->isUserActive($profile['is_active']);

        $jam = (int) Date("H");
        $awlBulanLalu = date("Y-m-01", strtotime("-1 month"));
        $dateOfJoining = date("Y-m-01", strtotime($profile['date_of_joining']));
        $isCompanyRsp = in_array($company_id, ['2']) && $jam > 14 && $dateOfJoining >= $awlBulanLalu ? true : false;
        if ($isCompanyRsp) {
            $this->isBasicTrainingKaryawanRsp($user_id);
        }

        // lock basic training mkt rsp
        $isDepartmentMarketing = in_array($department_id, ['120']) ? true : false;
        if ($isDepartmentMarketing) {
            $this->isBasicTrainingMarketingLock($user_id);
        }

        // lock hr rsp
        $isDepartmentHrRsp = in_array($department_id, ['142', '72']) ? true : false;
        if ($isDepartmentHrRsp) {
            $this->isHrRspLock($user_id);
        }

        // lock pelaksana
        $isDepartmentPelaksana = in_array($department_id, ['106', '107', '111', '28']) ? true : false;
        if ($isDepartmentPelaksana) {
            $this->isPelaksanaLock($user_id);
        }

        // lock purchasing bt
        $isDepartmentPurchasingBt = in_array($department_id, ['147']) ? true : false;
        if ($isDepartmentPurchasingBt) {
            $this->isPurchasingBtLock($user_id);
        }

        // lock store bt
        $isDepartmentStoreBt = in_array($department_id, ['14', '9']) ? true : false;
        if ($isDepartmentStoreBt) {
            $this->isStoreBtLock($user_id);
        }

        // lock crb bt scm
        $isDepartmentScmBt = in_array($department_id, ['95']) ? true : false;
        if ($isDepartmentScmBt) {
            $this->isScmBtLock($user_id);
        }

        // lock marketing rsp
        $isDepartmentMarketing = in_array($department_id, ['120']) ? true : false;
        if ($isDepartmentMarketing) {
            $this->isMarketingLock($user_id);
        }

        echo json_encode(array(
            'aktif' => 1,
            'achieve' => true,
            'message' => ''
        ));
    }

    public function check_absen($user_id)
    {
        $getProfile = $this->getProfile($user_id);
        $profile = $getProfile->row_array();
        $company_id = $profile['company_id'];
        $department_id = $profile['department_id'];

        $cek_lock = '';

        // validasi general
        $this->isUserValid($getProfile->num_rows());
        $this->isUserActive($profile['is_active']);

        // lock basic training general karyawan rsp
        // jika date of joining dalam range satu bulan terakhir
        // check sudah mengerjakan basic training / belum
        $jam = (int) Date("H");
        $awlBulanLalu = date("Y-m-01", strtotime("-1 month"));
        $dateOfJoining = date("Y-m-01", strtotime($profile['date_of_joining']));
        $isCompanyRsp = in_array($company_id, ['2']) && $jam > 14 && $dateOfJoining >= $awlBulanLalu ? true : false;
        if ($isCompanyRsp) {
            $cek_lock = $this->isBasicTrainingKaryawanRsp($user_id);
        }

        // lock basic training mkt rsp
        $isDepartmentMarketing = in_array($department_id, ['120']) ? true : false;
        if ($isDepartmentMarketing) {
            $cek_lock = $this->isBasicTrainingMarketingLock($user_id);
        }

        // lock hr rsp
        $isDepartmentHrRsp = in_array($department_id, ['142', '72']) ? true : false;
        if ($isDepartmentHrRsp) {
            $cek_lock = $this->isHrRspLock($user_id);
        }

        // lock pelaksana
        $isDepartmentPelaksana = in_array($department_id, ['106', '107', '111', '28']) ? true : false;
        if ($isDepartmentPelaksana) {
            $cek_lock = $this->isPelaksanaLock($user_id);
        }

        // lock purchasing bt
        $isDepartmentPurchasingBt = in_array($department_id, ['147']) ? true : false;
        if ($isDepartmentPurchasingBt) {
            $cek_lock = $this->isPurchasingBtLock($user_id);
        }

        // lock store bt
        $isDepartmentStoreBt = in_array($department_id, ['14', '9']) ? true : false;
        if ($isDepartmentStoreBt) {
            $cek_lock = $this->isStoreBtLock($user_id);
        }

        // lock crb bt scm
        $isDepartmentScmBt = in_array($department_id, ['95']) ? true : false;
        if ($isDepartmentScmBt) {
            $cek_lock = $this->isScmBtLock($user_id);
        }

        // lock marketing rsp
        $isDepartmentMarketing = in_array($department_id, ['120']) ? true : false;
        if ($isDepartmentMarketing) {
            $cek_lock = $this->isMarketingLock($user_id);
        }

        return $cek_lock;
    }

    private function getProfile($user_id = null)
    {
        $profile = $this->absen->getProfile($user_id);
        return $profile;
    }

    private function isUserActive($is_active)
    {
        if ($is_active == 0) {
            $message = "User anda telah di Nonaktifkan";
            echo json_encode(array(
                'aktif' => 0,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isUserValid($num_rows)
    {
        if ($num_rows < 1) {
            $message = "User tidak ditemukan";
            echo json_encode(array(
                'aktif' => 0,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isPelaksanaLock($user_id)
    {
        $pelaksana = $this->absen->isPelaksanaLock($user_id)->row_array();
        if ($pelaksana['total'] < 1 || $pelaksana['created_at'] != null) {
            $message = $pelaksana['warning_lock'] ?? '';
            echo json_encode(array(
                'aktif' => 1,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isPurchasingBtLock($user_id)
    {
        $purchasingBt = $this->absen->isPurchasingBtLock($user_id)->row_array();
        if ($purchasingBt['absen'] > 0) {
            $message = $purchasingBt['warning_lock'] ?? '';
            echo json_encode(array(
                'aktif' => 1,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isStoreBtLock($user_id)
    {
        $storeBt = $this->absen->isStoreBtLock($user_id)->row_array();
        if ($storeBt['absen'] > 0) {
            $message = $storeBt['warning_lock'] ?? '';
            echo json_encode(array(
                'aktif' => 1,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isScmBtLock($user_id)
    {
        $storeBt = $this->absen->isScmBtLock($user_id)->row_array();
        if ($storeBt['absen'] > 0) {
            $message = $storeBt['warning_lock'] ?? '';
            echo json_encode(array(
                'aktif' => 1,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isMarketingLock($user_id)
    {
        $marketingRsp = $this->absen->isMarketingLock($user_id)->row_array();
        if ($marketingRsp['total'] < 5) {
            $message = $marketingRsp['warning_lock'] ?? '';
            echo json_encode(array(
                'aktif' => 1,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isHrRspLock($user_id)
    {
        $result = true;
        $hrRsp = $this->absen->isHrRspLock($user_id);
        if ($hrRsp->num_rows() > 0) {
            if ($hrRsp['total'] < 100) {
                $message = $hrRsp['warning_lock'] . " Ach anda " . $hrRsp['total'] . "%" . " (" . $hrRsp['actual'] . "/" . $hrRsp['target'] . ")" ?? '';
                echo json_encode(array(
                    'aktif' => 1,
                    'achieve' => false,
                    'message' => $message
                ));
                die();
            }
        }
    }

    private function isBasicTrainingKaryawanRsp($user_id)
    {
        $basicTrainingKryRsp = $this->absen->isBasicTrainingKaryawanRsp($user_id);
        if ($basicTrainingKryRsp->num_rows() > 0) {
            $data = $basicTrainingKryRsp->row_array();
            $message = $data['warning_lock'] . ", " . $data['ket'] ?? '';
            echo json_encode(array(
                'aktif' => 1,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isBasicTrainingMarketingLock($user_id)
    {
        $basicTrainingMkt = $this->absen->isBasicTrainingMarketingLock($user_id);
        if ($basicTrainingMkt->num_rows() > 0) {
            $data = $basicTrainingMkt->row_array();
            $message = $data['warning_lock'] . ", " . $data['ket'] ?? '';
            echo json_encode(array(
                'aktif' => 1,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function getResponseData($status, $is_active, $achieve, $message, $statusCode = 200)
    {
        return $this->response([
            'status' => $status,
            'data' => [
                'aktif' => ($is_active) ? $is_active : 0,
                'achive' => ($achieve) ? $achieve : false,
                'message' => $message,
            ]
        ], $statusCode);
    }
}
