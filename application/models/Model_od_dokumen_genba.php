<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_od_dokumen_genba extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function getGenba($start, $end)
	{
		$sql = "SELECT
		g.id_genba,
		CONCAT(xe.first_name, ' ', xe.last_name) AS pic,
		c.name AS nama_company,
		d.department_name AS nama_department,
		g.divisi,
		s.nama_dokumen,
		DATE_FORMAT(s.tgl_terbit, '%d-%m-%Y') AS tgl_terbit,
		s.penjelasan,
		COALESCE(GROUP_CONCAT(DISTINCT des.designation_name SEPARATOR ', '), '-') AS designation_name,
		g.temuan,
		g.tanggal,
		g.analisa,
		g.other,
		g.solusi,
		r.rekomendasi,
		m.masalah,
		g.keluhan,
		g.keinginan,
		g.file,
		g.evaluasi,
		g.created_at,
		CONCAT(e.first_name, ' ', e.last_name) AS created_by,
		GROUP_CONCAT(DISTINCT CONCAT(ne.first_name, ' ', ne.last_name) SEPARATOR ', ') AS narasumber
	FROM
		`trusmi_genba_od` g
		LEFT JOIN xin_employees e ON g.created_by = e.user_id
		LEFT JOIN xin_employees xe ON g.pic = xe.user_id
		LEFT JOIN xin_companies c ON g.company_id = c.company_id
		LEFT JOIN xin_departments d ON g.department_id = d.department_id
		LEFT JOIN trusmi_sop s ON g.id_dokumen = s.id_sop
		LEFT JOIN xin_designations des ON FIND_IN_SET(des.designation_id, s.designation)
		LEFT JOIN trusmi_m_rekomendasi r ON g.rekomendasi = r.id
		LEFT JOIN trusmi_m_masalah m ON g.masalah = m.id
		LEFT JOIN xin_employees ne ON FIND_IN_SET(ne.user_id, g.narasumber) > 0
	WHERE
		g.id_genba IS NOT NULL" . ($start != '' && $end != '' ? " AND DATE(g.created_at) BETWEEN '$start' AND '$end'" : "") . "
	GROUP BY
		g.id_genba";
		return $this->db->query($sql)->result();
	}

	function getDetailGenba($id)
	{
		$sql = "SELECT
		g.id_genba,
		CONCAT(xe.first_name, ' ', xe.last_name) AS pic,
		c.name AS nama_company,
		d.department_name AS nama_department,
		g.divisi,
		s.nama_dokumen,
		g.temuan,
		g.tanggal,
		g.analisa,
		g.other,
		g.solusi,
		r.rekomendasi,
		m.masalah,
		g.keluhan,
		g.keinginan,
		g.file,
		g.evaluasi,
		g.created_at,
		CONCAT(e.first_name, ' ', e.last_name) AS created_by,
		GROUP_CONCAT(DISTINCT CONCAT(ne.first_name, ' ', ne.last_name) SEPARATOR ', ') AS narasumber
	FROM
		`trusmi_genba_od` g
		LEFT JOIN xin_employees e ON g.created_by = e.user_id
		LEFT JOIN xin_employees xe ON g.pic = xe.user_id
		LEFT JOIN xin_companies c ON g.company_id = c.company_id
		LEFT JOIN xin_departments d ON g.department_id = d.department_id
		LEFT JOIN trusmi_sop s ON g.id_dokumen = s.id_sop
		LEFT JOIN trusmi_m_rekomendasi r ON g.rekomendasi = r.id
		LEFT JOIN trusmi_m_masalah m ON g.masalah = m.id
		LEFT JOIN xin_employees ne ON FIND_IN_SET(ne.user_id, g.narasumber) > 0
	WHERE
		g.id_genba = '$id'
	GROUP BY
		g.id_genba";
		return $this->db->query($sql)->result();
	}

	function getPic()
	{
		$sql = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS nama
		FROM xin_employees
		WHERE department_id IN (1, 72, 73, 156, 157, 167)
			AND is_active = 1;
		";
		return $this->db->query($sql)->result();
	}

	function getCompany()
	{
		return $this->db->select('company_id,name')->get('xin_companies')->result();
	}

	function getDepartemen($id)
	{
		return $this->db->where('company_id', $id)->get('xin_departments')->result();
	}

	function getNarasumber($id)
	{
		return $this->db->select("CONCAT(E.first_name,' ',E.last_name) AS nama, E.user_id, D.designation_name")
			->from('xin_employees E')
			->join('xin_designations D', 'D.designation_id = E.designation_id')
			->where('E.department_id', $id)
			->where('is_active', 1)
			->get()
			->result();
	}

	function getDokumen($id)
	{
		$sql = "SELECT
		id_sop,
		c.company_id,
		c.NAME AS company_name,
		sop.type_department,
		STATUS.review AS status_review,
		sop.department AS department,
		IF(sop.type_department = 1, sop.department, CONCAT('[', sop.department, ']')) AS department_id,
		GROUP_CONCAT(DISTINCT dp.department_name SEPARATOR ', ') AS department_name,
		sop.designation AS designation,
		CONCAT('[', sop.designation, ']') AS designation_id,
		GROUP_CONCAT(DISTINCT ds.designation_name SEPARATOR ', ') AS designation_name,
		jenis_doc,
		no_doc,
		DATE_FORMAT(tgl_terbit, '%d-%m-%Y') AS tgl_terbit,
		DATE_FORMAT(tgl_update, '%d-%m-%Y') AS tgl_update,
		DATE_FORMAT(start_date, '%d-%m-%Y') AS start_date,
		DATE_FORMAT(end_date, '%d-%m-%Y') AS end_date,
		nama_dokumen,
		file,
		word,
		penjelasan,
		jadwal_diskusi,
		draft,
		CONCAT(e.first_name, ' ', e.last_name) AS created_by,
		e.user_id AS id_user,
		e.contact_no
	FROM
		trusmi_sop AS sop
		LEFT JOIN xin_companies c ON c.company_id = sop.company
		LEFT JOIN xin_departments dp ON FIND_IN_SET(dp.department_id, sop.department)
		LEFT JOIN xin_designations ds ON FIND_IN_SET(ds.designation_id, sop.designation)
		LEFT JOIN xin_employees e ON e.user_id = sop.created_by
		LEFT JOIN od_review AS review ON sop.id_sop = review.id_dokumen
		LEFT JOIN od_status AS STATUS ON review.STATUS = STATUS.id_status
	WHERE
		FIND_IN_SET($id, sop.department)
	GROUP BY
		id_sop
	ORDER BY
		id_sop DESC";
		return $this->db->query($sql)->result();
	}

	function getRekomendasi()
	{
		return $this->db->get('trusmi_m_rekomendasi')->result();
	}

	function getMasalah()
	{
		return $this->db->get('trusmi_m_masalah')->result();
	}
}
