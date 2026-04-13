<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Sales_mpp extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database();
        $this->load->model('autonotif/model_sales_mpp', 'model');
    }

    public function index()
    {
        $data['data'] = $this->model->sales_locked();
        header('Content-Type: application/json');
        echo json_encode($data['data']);
    }

    public function auto_notif()
    {
        $data = $this->model->get_resume_mpp();
        $resume_managers = $this->model->get_resume_sales_per_manager();
        $response = ['text' => '', 'error' => ''];

        if (!empty($data)) {

            // $kontak[] = '6285860428016'; //Mas Lutfie
            // $kontak[] = '628986997966'; //khael
            $kontak[] = '6282311003803'; //Sheyla Fortemachia Br Tobing
            $kontak[] = '6285721021214'; //Aulia Nurul Maulidaniar
            $kontak[] = '6283120578563'; //Anang Ciptadi
            $kontak[] = '6289513275135'; //Bu Arari HR
            $kontak[] = '628996999783'; //Pak Ali HR
            foreach ($kontak as $key => $value) {
                $msg = "*🚨Pemberitahuan Resume MPP Sales!*\n\n";

                $msg .= "*👤Total Sales Active:* " . $data->total . "/" . $data->mpp . " (" . $data->persentase_all . "%)\n";
                $msg .= "*Kurang Sales:* " . $data->selisih . "\n";
                $msg .= "*Sales:* " . $data->sales . " (" . $data->persentase_sales . "%)\n";
                $msg .= "*Sales Counter:* " . $data->sc . " (" . $data->persentase_sc . "%)\n";
                $msg .= "*Sales Event:* " . $data->se . " (" . $data->persentase_se . "%)\n\n";
                $msg .= "*📋 Resume Sales Aktif per Manager:*\n";
                foreach ($resume_managers as $res) {
                    $nama = !empty($res->employee_name) ? $res->employee_name : 'Non BM';
                    $salesAktif = $res->sales_aktif;
                    $persentase = ($data->total > 0) ? round(($salesAktif / $data->total) * 100) : 0;
                    $msg .= "- {$nama} : {$salesAktif} ({$persentase}%)\n";
                }
                $unregistered = $data->sales_existing;
                $persen_unregistered = ($data->total > 0) ? round(($unregistered / $data->total) * 100) : 0;
                $msg .= "- Unregistered (Training) : {$unregistered} ({$persen_unregistered}%)\n";
                $msg .= "\n";
                $msg .= "*🔐Total Sales Lock:* (" . $data->total_lock . ")\n";
                $msg .= "*Sales Lock:* " . $data->sales_lock . "\n";
                $msg .= "*Sales Counter Lock:* " . $data->sc_lock . "\n";
                $msg .= "*Sales Event Lock:* " . $data->se_lock . "\n\n";


                // Kirim pesan via API
                $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

                $data_text = [
                    "channelID" => "2507194023", // Channel RSP
                    "phone" => $value,
                    "messageType" => "text",
                    "body" => $msg,
                    "withCase" => true
                ];

                $options_text = [
                    'http' => [
                        "method"  => 'POST',
                        "content" => json_encode($data_text),
                        "header" =>  "Content-Type: application/json\r\n" .
                            "Accept: application/json\r\n" .
                            "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                    ]
                ];

                $context_text = stream_context_create($options_text);
                $result_text = @file_get_contents($url, false, $context_text);
            }
            if ($result_text === FALSE) {
                $response['error'] = "Gagal mengirim pesan ke API WhatsApp.";
            } else {
                $response['text'] = json_decode($result_text);
            }
        } else {
            $response['error'] = "Tidak ada data tasklist yang ditemukan.";
        }

        echo json_encode($response);
    }


    public function autoResignSales()
    {
        $activeSalesRaw = $this->model->sales_aktif();
        $activeSalesIds = array_column($activeSalesRaw, 'user_id');
        $locked = $this->model->sales_locked();

        $resignationProcessed = 0;

        foreach ($locked as $row) {
            if (in_array($row->id_hr, $activeSalesIds)) {
                $employee_id = $row->id_hr;
                $company_id = $row->company_id;
                $department_id = $row->department_id;
                $designation_id = $row->designation_id;

                // Validasi apakah sudah pernah resign sebelumnya
                $validasi_double_data = $this->model->check_double_resignation($employee_id);
                if ($validasi_double_data) {
                    continue; // Lewati jika sudah pernah resign
                }

                // Siapkan data resign
                $data_resignation = [
                    'employee_id'       => $employee_id,
                    'company_id'        => $company_id,
                    'designation_id'    => $designation_id,
                    'notice_date'       => date('Y-m-d'),
                    'resignation_date'  => date('Y-m-d'),
                    'category'          => 'Diputus kontrak',
                    'reason'            => 'Diputus kontrak',
                    'detail_reason'     => 'Diputus kontrak',
                    'note'              => 'Auto Resign Not achivement booking',
                    'added_by'          => $employee_id,
                    'created_at'        => date('Y-m-d'),
                ];

                // Simpan data resign ke database
                $store_resignation = $this->db->insert('xin_employee_resignations', $data_resignation);
                $update_date_of_leaving = $this->model->update_date_of_leaving($employee_id, date('Y-m-d'));

                if ($store_resignation && $update_date_of_leaving) {
                    $id_resignation = $this->model->get_last_id_resignation_by_user_id($employee_id);
                    $data_sub_clearance = $this->model->get_subclearance_by_employee_id($employee_id); // jika company rsp maka ada subclearance peminjaman asset
                    $get_atasan = $this->model->get_atasan($employee_id);
                    $get_atasan_rsp = $this->model->get_atasan_rsp($employee_id)->row();

                    $array_company = ['1', '4', '5'];
                    foreach ($data_sub_clearance as $sc) {
                        $pic = $sc->pic;

                        // Custom logic to determine the PIC (Person in Charge)
                        if ($sc->id_clearance == 1) {
                            // Logic for specific conditions
                            $pic = $this->getPicForClearance($sc, $company_id, $department_id, $get_atasan, $get_atasan_rsp);
                        }

                        // Insert exit clearance data
                        $data_exit_clearance = [
                            'id_resignation' => $id_resignation,
                            'karyawan' =>  $employee_id,
                            'subclearance' => $sc->id,
                            'pic' => $pic,
                            'status' => ($pic == '61') ? 1 : 0,
                            'created_at' => date("Y-m-d H:i:s"),
                            'approved_at' => ($pic == '61') ? date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (5 * 60)) : null,
                            'approved_by' => ($pic == '61') ? $pic : null,
                        ];

                        $this->db->insert("trusmi_exit_clearance", $data_exit_clearance);
                    }

                    // Increment the processed resignation count
                    $resignationProcessed++;
                }
            }
        }

        // Response after processing
        if ($resignationProcessed > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => $resignationProcessed . ' resignations successfully processed.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No resignations were processed.'
            ]);
        }
    }

    // Function to determine the PIC for clearance
    private function getPicForClearance($sc, $company_id, $department_id, $get_atasan, $get_atasan_rsp)
    {
        if ($sc->id == '19') {
            return 4138; // specific condition
        } elseif ($company_id == 2 && $department_id == 120) {
            return $get_atasan_rsp->head_id ?? $get_atasan->head_id;
        } else {
            return $get_atasan->head_id;
        }
    }
}
