<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_budget extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('upload');
        $this->load->database();
    }

    function data_budget($y, $m)
    {
        $sql = "SELECT
					e_biaya.id_biaya,
					budget.employee_name AS user,
					budget.contact_no AS no_hp1, -- add by Ade
					budget.contact AS no_hp2, -- add by Ade
					e_biaya.nama_biaya,
					e_biaya.budget_awal,
					e_biaya.budget,
					e_biaya.minggu,
					e_biaya.bulan,
					e_biaya.tahun_budget,
					e_biaya.note_budget,
					e_biaya.updated_at,
					e_biaya.id_budget ,
                    e_biaya.company_id,
                    -- xin_companies.name AS company_name
                    										e_company.company_name


				FROM
					e_eaf.e_biaya
                    -- add `user`.contact by Ade
					LEFT JOIN ( 
                        SELECT
                        e_jenis_biaya.id_budget,
                        COALESCE(REPLACE(CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)),',',', '),'') AS employee_name,
                            emp.contact_no AS contact,
                            emp.contact_no 
                        FROM
                            e_eaf.e_jenis_biaya
                            LEFT JOIN hris.xin_employees AS emp ON e_jenis_biaya.id_user_approval = emp.user_id
                    ) AS budget ON e_biaya.id_budget = budget.id_budget 
                    -- LEFT JOIN hris.xin_companies ON xin_companies.company_id = e_biaya.company_id
                    LEFT JOIN e_eaf.e_company ON e_company.company_id = e_biaya.company_id
				WHERE
					tahun_budget = $y 
					AND bulan = $m 
				GROUP BY
					id_biaya 
				ORDER BY
					id_biaya";
        return $this->db->query($sql);
    }

    function budget()
    {
        return $this->db->get('e_eaf.e_budget')->result();
    }

    function data_budget_list($company_id)
    {
        return $this->db->query("SELECT * FROM e_eaf.`e_budget` WHERE company_id = $company_id");
    }

    function get_last_budget()
    {
        return $this->db->query("SELECT * FROM e_eaf.`e_biaya` ORDER BY id_biaya DESC limit 1")->result();
    }

    function data_budget_tambah($id_biaya, $bulan, $tahun)
    {
        $sql = "SELECT biaya_penambahan.nominal_tambah, biaya_penambahan.bulan, biaya_penambahan.tahun, biaya_penambahan.updated_at, 
        biaya_penambahan.updated_by, biaya_penambahan.note_penambahan, 
       	COALESCE(REPLACE(CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)),',',', '),'') AS employee_name,
            biaya_penambahan.ba 
        FROM
            e_eaf.e_biaya_penambahan AS biaya_penambahan
	    LEFT JOIN hris.xin_employees AS emp ON biaya_penambahan.updated_by = emp.user_id
        where id_biaya='$id_biaya' and bulan='$bulan' and tahun='$tahun'";
        $data = $this->db->query($sql);

        $pro['data'] = $data->result();
        return $pro;
    }

    function insert_budget()
    {
        date_default_timezone_set('Asia/Jakarta');

        $company_id     = $_POST['company_id'];
        $nama_biaya     = explode('|', $_POST['nama_biaya']);
        // $minggu_biaya 	= $_POST['minggu_biaya'];
        $bulan_biaya     = $_POST['bulan_biaya'];
        $tahun_budget     = $_POST['tahun_budget'];
        // $nominal_budget = $_POST['nominal_budget'];
        $note_budget     = $_POST['note_budget'];
        $tanggal         = date("Y-m-d");
        $id_user         = $this->session->userdata('user_id');

        if ($_POST['nominal_budget'] == '') {
            $nominal_budget = null;
        } else {
            $nom_budget = $_POST['nominal_budget'];
            $nominal_budget = str_replace('.', '', $nom_budget);
        }

        if ($_POST['minggu_biaya'] == '') {
            $minggu_biaya = null;
            $where        = " where id_budget = $nama_biaya[0] AND bulan = $bulan_biaya AND tahun_budget = $tahun_budget AND minggu IS NULL ";
        } else {
            $minggu_biaya     = $_POST['minggu_biaya'];
            $where            = " where id_budget = $nama_biaya[0] AND bulan = $bulan_biaya AND tahun_budget = $tahun_budget AND minggu = $minggu_biaya";
        }

        $cek = $this->db->query("SELECT * from e_eaf.e_biaya $where")->num_rows();

        if ($cek > 0) {
            $data1 = array(
                'budget_awal'    => $nominal_budget,
                'budget'        => $nominal_budget,
                'updated_at'    => $tanggal,
                'note_budget'    => $note_budget,
                'updated_by'    => $id_user,
                'company_id'    => $company_id

            );

            $this->db->where('id_budget', $nama_biaya[0]);
            $this->db->where('tahun_budget', $tahun_budget);
            $this->db->where('bulan', $bulan_biaya);
            $this->db->where('minggu', $minggu_biaya);
            $this->db->update('e_eaf.e_biaya', $data1);
        } else {
            $data = array(
                'nama_biaya'    => $nama_biaya[1],
                'budget_awal'    => $nominal_budget,
                'budget'        => $nominal_budget,
                'minggu'        => $minggu_biaya,
                'bulan'            => $bulan_biaya,
                'tahun_budget'    => $tahun_budget,
                'updated_at'    => $tanggal,
                'note_budget'    => $note_budget,
                'updated_by'    => $id_user,
                'id_budget'     => $nama_biaya[0],
                'company_id'    => $company_id
            );
            $this->db->insert('e_eaf.e_biaya', $data);
        }
    }

    function insert_penambahan()
    {
        $id_biaya_tambah =  $_POST['id_biaya_tambah'];
        $minggu_tambah = $_POST['minggu_tambah'];
        $bulan_tambah = $_POST['bulan_tambah'];
        $tahun_tambah =  $_POST['tahun_tambah'];
        $nominal_tambah =  $_POST['nominal_tambah'];
        $note_penambahan =  $_POST['note_penambahan'];
        $string = $_POST['berita_acara'];
        define('UPLOAD_DIR', './uploads/eaf/');

        $string     = explode(',', $string);
        $img        = str_replace(' ', '+', $string[1]);
        $data       = base64_decode($img);
        $name       = uniqid() . '.' . $string[0];
        $file       = UPLOAD_DIR . $name;
        $success    = file_put_contents($file, $data);

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("Y-m-d");
        $id_user = $this->session->userdata('user_id');

        $data = array(
            'id_biaya' => $id_biaya_tambah,
            'nominal_tambah' => $nominal_tambah,
            'minggu' => $minggu_tambah,
            'bulan' => $bulan_tambah,
            'tahun' => $tahun_tambah,
            'updated_at' => $tanggal,
            'updated_by' => $id_user,
            'ba' => $name,
            'note_penambahan' => $note_penambahan
        );

        $result = $this->db->insert('e_eaf.e_biaya_penambahan', $data);

        if ($result) {
            $budget = $this->get_budget($id_biaya_tambah);

            $total_budget = $budget + $nominal_tambah;

            $this->db->where('id_biaya', $id_biaya_tambah);
            $this->db->update('e_eaf.e_biaya', array('budget' => $total_budget));
        }
    }

    function get_budget($id_biaya)
    {
        $data = $this->db->query("SELECT biaya.budget FROM e_eaf.e_biaya AS biaya WHERE biaya.id_biaya = $id_biaya")->row_array();

        return $data['budget'];
    }
}
