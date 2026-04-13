<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticket_autonotif extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }

public function index()
{
    $data = $this->db->query("
        SELECT
  CONCAT(xin_employees_denda.first_name, ' ', xin_employees_denda.last_name) AS denda_dari,
  DATE_FORMAT(trusmi_denda.created_at, '%e %M %Y jam %H:%i:%s') AS created_at,
  trusmi_denda.keterangan,
  CONCAT(xin_employees_buat.first_name, ' ', xin_employees_buat.first_name) AS dibuat_oleh,
  DATE_ADD(trusmi_denda.created_at, INTERVAL 1 DAY) AS tanggal_muncul
FROM hris.trusmi_denda AS trusmi_denda
JOIN hris.xin_employees AS xin_employees_denda
  ON trusmi_denda.employee_id = xin_employees_denda.user_id
JOIN hris.xin_employees AS xin_employees_buat
  ON trusmi_denda.created_by = xin_employees_buat.user_id
WHERE trusmi_denda.created_at >= '2025-12-01'
limit 1

    ")->result_array();

    if (empty($data)) {
        echo json_encode(['status' => false, 'message' => 'No data']);
        return;
    }

    foreach ($data as $item) {

        $msg = "📌 *Notifikasi Denda*

Berikut informasi denda yang diterapkan:

• *Denda dari* : {$item['denda_dari']}
• *Diterapkan pada* : {$item['created_at']}
• *Keterangan* : {$item['keterangan']}

Mohon ditindaklanjuti sesuai ketentuan yang berlaku.
Terima kasih 🙏
        ";

        // kirim WA
        $this->send_wa('62882000489612', $msg, '0');
    }

    echo json_encode(['status' => true]);
}


  function send_wa($phone, $msg, $user_id = '')
  {
    try {
      $this->load->library('WAJS');
      return $this->wajs->send_wajs_notif($phone, $msg, 'text', 'trusmicorp', $user_id);
    } catch (\Throwable $th) {
      return "Server WAJS Error";
    }
  }

  function send_wa_eksternal($phone, $msg)
  {
    try {
      $this->load->library('WAJS_eksternal');
      return $this->wajs_eksternal->send_wajs_notif_eksternal($phone, $msg, 'text', 'trusmicorp');
    } catch (\Throwable $th) {
      return "Server WAJS Error";
    }
  }
}
