<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Send_wa extends CI_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index()
    {
        echo "Hello World!";
    }


    public function internal()
    {
        try {
            $phone = @$_POST['phone'];
            $msg = @$_POST['msg'];
            $user_id = @$_POST['user_id'];


            $send_wa = $this->send_wa($phone, urldecode($msg), $user_id);
            if (preg_match('/Workflow was started/', json_encode($send_wa))) {
                echo json_encode(array('status' => 'success'));
            } else {
                echo json_encode(array('status' => 'failed', 'message' => $send_wa));
            }
        } catch (\Throwable $th) {
            echo json_encode(array('status' => 'failed'));
        }
    }

    function send_wa($phone, $msg, $user_id = '')
    {
        try {
            $user_id = empty($user_id) ? '' : $user_id;
            $this->load->library('WAJS');
            return $this->wajs->send_wajs_notif($phone, $msg, 'text', 'trusmicorp', $user_id);
        } catch (\Throwable $th) {
            return "Server WAJS Error";
        }
    }

    function var_dumps()
    {
        try {
            $this->load->library('WAJS');
            // $this->notif_log('send_wa');
            // $this->notif_log($msg);
            echo json_encode(preg_match('/Workflow was started/', json_encode($this->wajs->send_wajs_notif('628986997966', urldecode('test'), 'text', 'trusmicorp', '1'))));
        } catch (\Throwable $th) {
            return "Server WAJS Error";
        }
    }

    public function redirect_to_whatsapp()
    {
        header('Location: https://api.whatsapp.com/send/?phone=6288971936684&text=/TG');
    }
}
