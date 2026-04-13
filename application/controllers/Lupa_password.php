<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lupa_password extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_lupa_password');
        $this->load->library('session');
        $this->load->library('filter');
        $this->load->library('whatsapp_lib');
        $this->load->helper('url');
        $this->load->database();
    }

    public function reset_password()
    {
        $this->load->view('lupa_password/reset_password');
    }

    public function send_otp()
    {
        $username = $this->filter->sanitaze_input($this->input->post('username'));

        if ($username == "") {
            $this->session->set_flashdata('error', 'Username tidak boleh kosong');
            redirect('lupa_password/reset_password');
        }
        $user = $this->Model_lupa_password->check_username($username);

        if ($user) {
            $otp = rand(100000, 999999);
            $this->Model_lupa_password->save_otp($username, $otp);

            $message = "Halo *" . $user['first_name'] . "*, 

Ini adalah kode OTP Anda untuk melakukan reset password : 

*" . $otp . "* 

Kode ini hanya berlaku selama 5 menit. Jangan bagikan kode ini kepada siapa pun, termasuk pihak yang mengaku dari layanan kami. 

Terima kasih!";
            $this->whatsapp_lib->send_single_msg('rsp', $user['contact_no'], $message);

            $this->session->set_userdata('username', $username);
            redirect('lupa_password/otp_verification');
        } else {
            $this->session->set_flashdata('error', 'Username tidak valid/tidak aktif');
            redirect('lupa_password/reset_password');
        }
    }

    public function otp_verification()
    {
        $this->load->view('lupa_password/otp_verification');
    }

    public function verify_otp()
    {
        $username = $this->filter->sanitaze_input($this->session->userdata('username'));
        $otp = $this->filter->sanitaze_input($this->input->post('otp'));

        if ($this->Model_lupa_password->verify_otp($username, $otp)) {
            $this->session->set_userdata('otp', $otp);
            redirect('lupa_password/new_password');
        } else {
            $this->session->set_flashdata('error', 'OTP tidak valid atau kedaluwarsa');
            redirect('lupa_password/otp_verification');
        }
    }

    public function new_password()
    {
        $username = $this->filter->sanitaze_input($this->session->userdata('username'));
        $otp = $this->filter->sanitaze_input($this->session->userdata('otp'));
        if ($this->Model_lupa_password->verify_otp($username, $otp)) {
            $this->load->view('lupa_password/new_password');
        } else {
            $this->session->set_flashdata('error', 'OTP tidak valid atau kedaluwarsa');
            redirect('lupa_password/otp_verification');
        }
    }

    public function update_password()
    {
        $username = $this->filter->sanitaze_input($this->session->userdata('username'));
        $new_password = $this->filter->sanitaze_input($this->input->post('password'));
        if ($this->Model_lupa_password->update_password($username, $new_password)) {
            $this->session->set_flashdata('success', 'Password berhasil diubah');
            redirect('lupa_password/thankyou');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengubah password');
            redirect('lupa_password/new_password');
        }
    }

    public function thankyou()
    {
        $this->load->view('lupa_password/thankyou');
    }
}
