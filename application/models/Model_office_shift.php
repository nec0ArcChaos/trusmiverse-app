<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_office_shift extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_office_shifts()
	{
		$this->db->select('
        office_shift_id,
        s.company_id,
        c.name AS company,
        shift_name,
        monday_in_time,
        monday_out_time,
        tuesday_in_time,
        tuesday_out_time,
        wednesday_in_time,
        wednesday_out_time,
        thursday_in_time,
        thursday_out_time,
        friday_in_time,
        friday_out_time,
        saturday_in_time,
        saturday_out_time,
        sunday_in_time,
        sunday_out_time
    ');
		$this->db->from('xin_office_shift s');
		$this->db->join('xin_companies c', 'c.company_id = s.company_id', 'left');

		return $this->db->get()->result();
	}


	public function get_shift()
	{
		return $this->db->query("SELECT xin_office_shift.office_shift_id, xin_office_shift.shift_name FROM xin_office_shift");
	}
}
