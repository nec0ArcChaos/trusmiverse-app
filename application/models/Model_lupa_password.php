<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_lupa_password extends CI_Model
{

    public function check_username($username)
    {
        return $this->db->get_where('xin_employees', [
            'username' => $username,
            'is_active' => 1
        ])->row_array();
    }

    public function save_otp($username, $otp)
    {
        $data = [
            'username' => $username,
            'otp' => $otp,
            'otp_created_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('otp_requests', $data);
    }

    public function verify_otp($username, $otp)
    {
        $this->db->where('username', $username);
        $this->db->where('otp', $otp);
        $this->db->where('TIMESTAMPDIFF(MINUTE, otp_created_at, NOW()) <=', 5); // OTP berlaku 5 menit
        return $this->db->get('otp_requests')->row_array();
    }

    public function update_password($username, $new_password)
    {
        if ($username == "") {
            return false;
        }
        $options = array('cost' => 12);
        $password_hash = password_hash($new_password, PASSWORD_BCRYPT, $options);
        return $this->db->where('username', $username)->update('xin_employees', [
            'password' => $password_hash,
            'ctm_password' => md5($new_password)
        ]);
    }
}
