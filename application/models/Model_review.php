<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_review extends CI_Model
{
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function status($no_jp)
	{
		$query = "SELECT trusmi_job_profile.no_jp, od_review.`status` FROM `trusmi_job_profile` LEFT JOIN od_review ON trusmi_job_profile.no_jp = od_review.id_dokumen WHERE trusmi_job_profile.no_jp='$no_jp' LIMIT 1";
		return $this->db->query($query)->row_object();
	}

	public function no_rv()
	{
		$q = $this->db->query("SELECT
			MAX( RIGHT ( od_review.id_review, 3 ) ) AS rv_max
			FROM
			od_review
			WHERE
			SUBSTR( od_review.created_at, 1, 10 ) = CURDATE()");
		$kd = "";
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				$tmp = ((int)$k->rv_max) + 1;
				$kd = sprintf("%03s", $tmp);
			}
		} else {
			$kd = "001";
		}
		return 'RV' . date('ymd') . $kd;
	}

	public function get_file($id)
	{
		$query = "SELECT id_sop, no_doc, nama_dokumen, department_name, designation_name, file FROM trusmi_sop
		LEFT JOIN xin_designations ON trusmi_sop.designation = xin_designations.designation_id
			LEFT JOIN xin_departments ON trusmi_sop.department = xin_departments.department_id
		 WHERE id_sop='$id'";
		return $this->db->query($query)->row_object();
	}

	function get_review($no_jp)
	{
		return $this->db->query("SELECT id_review, od_status.review AS status, CONCAT(first_name, ' ', last_name) AS employee, od_review.review_note, od_review.created_at FROM od_review LEFT JOIN xin_employees ON od_review.created_by = xin_employees.user_id
		LEFT JOIN od_status ON od_review.status = od_status.id_status WHERE od_review.id_dokumen = '$no_jp'")->result();
	}

    public function data_user($id_user)
	{
        $query = "SELECT
			xin_employees.user_id,
			xin_employees.username,
			CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS employee,
			xin_departments.department_name,
			xin_designations.designation_name,
			CONCAT( report.first_name, ' ', report.last_name ) AS report_to,
			xin_employees.ctm_report_to,
			com.company_id AS company,
			com.name
		FROM
			xin_employees
			JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
			JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
			LEFT JOIN xin_employees AS report ON report.user_id = xin_employees.ctm_report_to
			LEFT JOIN xin_companies AS com ON com.company_id = xin_employees.company_id
		WHERE
			xin_employees.user_id = '$id_user'
			";
        return $this->db->query($query)->row_array();
    }

    public function insert_review($data)
	{
		$jp = $this->db->query("SELECT no_jp, no_dok, doc_type_id FROM trusmi_job_profile WHERE no_jp='".$data['no_jp']."' LIMIT 1")->row_array();
		$cek_review = $this->db->query("SELECT id_dokumen, id_review, status, review_by, review_at, review_note FROM od_review WHERE id_dokumen = '".$jp['no_jp']."' ")->result();
		$id_review = '';
		if (count($cek_review) > 0) { // review sudah ada (update + insert to history)
			foreach ($cek_review as $items) {
				$id_review = $items->id_review;
				$data_history = [
					'id'          => '',
					'id_review'   => $items->id_review,
					'status'      => $items->status,
					'review_by'   => $items->review_by,
					'review_at'   => $items->review_at,
					'review_note' => $items->review_note
				];
				$this->db->insert('od_review_history', $data_history);
			}
			$data_review = [
				'status'      => $data['status'],
				'created_at'  => date('Y-m-d H:i:s'),
				'review_at'   => date('Y-m-d H:i:s'),
				'review_note' => $data['note'],
			];
			$this->db->where('id_review', $id_review);
			return $this->db->update('od_review', $data_review);
		} else {
			$data_review = [
				'id_review'     => $this->no_rv(),
				'id_dokumen'    => $jp['no_jp'],
				'jenis_dokumen' => $jp['doc_type_id'],
				'tipe_menu'     => $data['tipe_menu'],
				'status'        => $data['status'],
				'created_by'    => $data['user_id'],
				'created_at'    => date('Y-m-d H:i:s'),
				'pic_review'    => $data['user_id'],
				'review_by'     => $data['user_id'],
				'review_at'     => date('Y-m-d H:i:s'),
				'review_note'   => $data['note'],
			];
			$this->db->insert('od_review', $data_review);
			return $data_review;
		}
    }

	public function insert_review_sop($data)
	{
		$sop = $this->db->query("SELECT id_sop, jenis_doc FROM trusmi_sop WHERE id_sop='".$data['id_sop']."' LIMIT 1")->row_array();
		$cek_review = $this->db->query("SELECT id_dokumen, id_review, status, review_by, review_at, review_note FROM od_review WHERE id_dokumen = '".$sop['id_sop']."' ")->result();
		$id_review = '';
		if (count($cek_review) > 0) { // review sudah ada (update + insert to history)
			foreach ($cek_review as $items) {
				$id_review = $items->id_review;
				$data_history = [
					'id'          => '',
					'id_review'   => $items->id_review,
					'status'      => $items->status,
					'review_by'   => $items->review_by,
					'review_at'   => $items->review_at,
					'review_note' => $items->review_note
				];
				$this->db->insert('od_review_history', $data_history);
			}
			$data_review = [
				'status'      => $data['status'],
				'created_at'  => date('Y-m-d H:i:s'),
				'review_at'   => date('Y-m-d H:i:s'),
				'review_note' => $data['note'],
			];
			$this->db->where('id_review', $id_review);
			return $this->db->update('od_review', $data_review);
		} else {
			$data_review = [
				'id_review'     => $this->no_rv(),
				'id_dokumen'    => $sop['id_sop'],
				'jenis_dokumen' => $sop['jenis_doc'],
				'tipe_menu'     => $data['tipe_menu'],
				'status'        => $data['status'],
				'created_by'    => $data['user_id'],
				'created_at'    => date('Y-m-d H:i:s'),
				'pic_review'    => $data['user_id'],
				'review_by'     => $data['user_id'],
				'review_at'     => date('Y-m-d H:i:s'),
				'review_note'   => $data['note'],
			];
			return $this->db->insert('od_review', $data_review);
		}
	}

	public function get_history($id_review)
	{
		return $this->db->query("SELECT od_status.review, review_at, review_note FROM od_review_history JOIN od_status ON od_review_history.status = od_status.id_status WHERE id_review='$id_review' ")->result();
	}
}
