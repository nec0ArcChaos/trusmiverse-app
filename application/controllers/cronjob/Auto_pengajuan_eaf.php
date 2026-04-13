<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Auto_pengajuan_eaf extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('eaf/Model_pengajuan', 'model_pengajuan');
    }

    function index()
    {
        date_default_timezone_set('Asia/Jakarta');

        $sql = "
            SELECT 
                p.*, 
                tp.nama_tipe, tp.nama_bank, tp.no_rek,
                ap.id_user_approval, ap.level,
                dk.nama_keperluan, dk.nominal_uang, dk.note AS detail_note, dk.tgl_nota,
                ph.photo_acc, ph.flag AS photo_flag
            FROM e_eaf.e_pengajuan p
            LEFT JOIN e_eaf.e_tipe_pembayaran tp ON tp.id_pengajuan = p.id_pengajuan
            LEFT JOIN e_eaf.e_approval ap ON ap.id_pengajuan = p.id_pengajuan
            LEFT JOIN e_eaf.e_detail_keperluan dk ON dk.id_pengajuan = p.id_pengajuan
            LEFT JOIN e_eaf.e_photo_acc ph ON ph.id_pengajuan = p.id_pengajuan
            WHERE p.is_auto_generated = 0
                AND p.tgl_akhir_auto_pengajuan IS NOT NULL
                AND CURDATE() <= p.tgl_akhir_auto_pengajuan
        ";

        $data = $this->db->query($sql)->result_array();

        if (empty($data)) {
            echo 'Tidak ada data auto EAF untuk hari ini.';
            return;
        }

        $success = 0;

        foreach ($data as $row) {
            if ($this->insert_pengajuan($row)) {
                $success++;
            }
        }

        echo json_encode([
            'status' => 'OK',
            'inserted' => $success,
            'message' => 'Auto EAF berhasil dieksekusi',
        ]);
    }

    // Helper (untuk insert)
    function insert_pengajuan($data)
    {
        $this->db->trans_begin();

        $id_pengajuan = $this->model_pengajuan->getideaf();
        $tgl_input = date('Y-m-d H:i:s');

        // Insert pengajuan
        $pengajuan = [
            'id_pengajuan' => $id_pengajuan,
            'tgl_input' => $tgl_input,
            'nama_penerima' => $data['nama_penerima'],
            'pengaju' => $data['pengaju'],
            'id_kategori' => $data['id_kategori'],
            'status' => 1,
            'id_divisi' => $data['id_divisi'],
            'id_user' => $data['id_user'],
            'flag' => $data['flag'],
            'jenis' => $data['jenis'],
            'budget' => $data['budget'],
            'leave_id' => $data['leave_id'],
            'note' => 'Auto Pengajuan',
            'tgl_akhir_auto_pengajuan' => $data['tgl_akhir_auto_pengajuan'],
            'is_auto_generated' => 1 /* AUTO EAF */
        ];
        $this->db->insert('e_eaf.e_pengajuan', $pengajuan);

        // Insert tipe pembayaran
        $this->db->insert('e_eaf.e_tipe_pembayaran', [
            'id_pengajuan' => $id_pengajuan,
            'nama_tipe' => $data['nama_tipe'],
            'nama_bank' => $data['nama_bank'],
            'no_rek' => $data['no_rek'],
        ]);

        // Insert approval
        $this->db->insert('e_eaf.e_approval', [
            'id_pengajuan' => $id_pengajuan,
            'id_user_approval' => $data['id_user_approval'],
            'level' => $data['level'],
            'flag' => 'Pengajuan',
        ]);

        // Insert detail keperluan
        $this->db->insert('e_eaf.e_detail_keperluan', [
            'id_pengajuan' => $id_pengajuan,
            'nama_keperluan' => $data['nama_keperluan'],
            'nominal_uang' => $data['nominal_uang'],
            'note' => $data['detail_note'],
            'tgl_nota' => $data['tgl_nota'],
        ]);

        // Insert foto (jika ada)
        if (!empty($data['photo_acc'])) {
            $this->db->insert('e_eaf.e_photo_acc', [
                'id_pengajuan' => $id_pengajuan,
                'photo_acc' => $data['photo_acc'],
                'flag' => $data['photo_flag'],
            ]);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }
}
