<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_uat extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function get_data($id_task)
	{
		$query = "SELECT
					t.id_task,
					t.task,
					t.type,
					t.created_by,
					CONCAT(xe1.first_name,' ',xe1.last_name) as pic,
					CONCAT(xe2.first_name,' ',xe2.last_name) as requester,
					DATE_FORMAT(SUBSTR(t.uat_leadtime,1,10),'%d %M %Y') as uat_leadtime,
					t.`status`,
					t.progress,
					t.description,
					t.note
				FROM
					ticket_task t
					JOIN xin_employees xe1 ON xe1.user_id = t.pic
					JOIN xin_employees xe2 ON xe2.user_id = t.created_by
				WHERE
					id_task = '$id_task';";
		return $this->db->query($query)->row_array();
	}
	function get_ticket_uat($id_task, $pic)
	{
		$query = "SELECT
					CONCAT( xe.first_name, ' ', xe.last_name ) AS pic,
					t.id_task,
					t.task,
					t.description,
					DATE_FORMAT( t.uat_leadtime, '%d %M %Y' ) AS uat_leadtime,
				IF
					(
						LEFT ( xe.contact_no, 2 ) = '08',
						CONCAT( '628', RIGHT ( xe.contact_no, LENGTH( xe.contact_no ) - 2 ) ),
						CONCAT( '628', RIGHT ( xe.contact_no, LENGTH( xe.contact_no ) - 3 ) ) 
					) AS contact,
					uat.note,
				CASE
						uat.`status` 
						WHEN 0 THEN
						'Tidak Sesuai' ELSE 'Sesuai' 
					END AS `status` 
				FROM
					ticket_task t
					JOIN xin_employees xe ON xe.user_id = $pic
					JOIN ( SELECT id_task, `status`, note FROM ticket_uat WHERE id_task = '$id_task' ORDER BY id_uat DESC LIMIT 1 ) AS uat ON uat.id_task = t.id_task 
				WHERE
					t.id_task = '$id_task';";
		return $this->db->query($query)->row_array();
	}
	function get_pic_ticket($id_task)
	{
		$query = "SELECT pic FROM ticket_task WHERE id_task = '$id_task'";
		return $this->db->query($query)->row_array();
	}
}
