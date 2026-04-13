<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Workshop_autonotif extends CI_Controller
{
    /*
    Worksho Autonotif
    Rule : Mengirim autonotif pengingat workshop pada saat hari H workshop ke setiap peserta
    Tgl Dibuat : 25-03-2024
    */
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("autonotif/model_workshop_autonotif", "model");
        $this->load->library('Whatsapp_lib');
        $this->load->library('Filter');
    }


    public function autonotif_daily()
    {
        $workshop = $this->model->check_workshop_reminder();
        if ($workshop) {
            $count = 0;
            foreach ($workshop as $row) {
                $this->send_notif_workshop_reminder($row->workshop_id);
                $count++;
            }
        }
    }

    public function send_notif_workshop_reminder($workshop_id)
    {
        $workshop_id = $this->filter->sanitaze_input($workshop_id);
        $workshop = $this->model->get_workshop_title($workshop_id);
        $workshop_participant = $this->model->get_workshop_list_participant($workshop_id);
        $msg = "📌REMINDER📌

*Mengingatkan kepada seluruh Karyawan* yang ada di daftar Nama terlampir dibawah ini untuk dapat mengikuti Workshop *" . $workshop->title_name . "* yang akan diisi oleh *" . $workshop->trainer_name . "* pada

🗓️ Hari: *" . $workshop->tanggal . "* 
⏰ Jam: *" . $workshop->jam . "* 
📍 Tempat: *" . $workshop->tempat . "*

Mengingat pentingnya Workshop kali ini harap Bapak/ibu agar dapat hadir memenuhi undangan ini tepat waktu.

Atas perhatian dan dedikasi Bapak/Ibu  kami ucapkan terimakasih 🙏🙏

*Note:*
Materi Workshop dapat anda akses di aplikasi e-training dengan judul *" . $workshop->title_name . "*.
link aplikasi :
https://trusmicorp.com/e-training

*List Karyawan:*
";
        $no = 1;
        foreach ($workshop_participant as $row) {
            $msg .= $no . ". " . $row->participan_name . "\n";
            $no++;
        }
        foreach ($workshop_participant as $participant) {
            $this->whatsapp_lib->send_single_msg('rsp', $participant->contact_no, $msg);
        }
        $this->model->update_reminder($workshop_id);
    }
}
