<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Work_on_holiday extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->library('Whatsapp_lib');
        $this->load->model('Model_work_on_holiday', 'model');
        $this->load->model("model_profile");
    }
    function index(){
        $user = $this->session->userdata('user_id');
        $data['pageTitle']        = "Work On Holiday";
        $data['css']              = "work_on_holiday/css";
        $data['js']               = "work_on_holiday/js";
        $data['content']          = "work_on_holiday/index";
        $data['karyawan']= $this->model->get_karyawan();
        $data['is_spv_up']=$this->model->get_spv_up($user);
        // var_dump($data['is_spv_up']);die();
        // var_dump($data['is_spv_up']);die();
        $this->load->view('layout/main', $data);

    }
    function get_data(){
        $start = $_POST['start'];
        $end = $_POST['end'];
        $data['data'] = $this->model->get_data($start,$end);
        echo json_encode($data);
    }
    function get_approval($start,$end){
        $user = $this->session->userdata('user_id');
        $data['data'] = $this->model->get_approval($user,$start,$end);
        echo json_encode($data);
    }
    public function no_pk()
	{
		$q = $this->db->query("SELECT
			MAX( RIGHT ( pk_job.id_pk, 4 ) ) AS rv_max 
			FROM
			pk_job 
			WHERE
			SUBSTR( pk_job.created_at, 1, 10 ) = LEFT(CURDATE(),10)");
		$kd = "";
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				$tmp = ((int)$k->rv_max) + 1;
				$kd = sprintf("%04s", $tmp);
			}
		} else {
			$kd = "0001";
		}
		return 'PK' . date('ymd') . $kd;
	}
    function get_karyawan(){
        $data = $this->model->get_karyawan();
        echo json_encode($data);
    }
    function get_list_job($id){
        $data = $this->model->get_list_job($id);
        echo json_encode($data);
    }
    function save(){

        $id_pk = $this->no_pk();
        $data = [
            // 'id_pk'=>$id_pk,
            // 'pic' => $this->input->post('id'),
            'pic' => $this->input->post('list_karyawan'),
            'tgl_masuk'=>$this->input->post('tgl'),
            'note'=>$this->input->post('note'),
            // 'created_at'=>date('Y-m-d H:i:s'),
            // 'created_by'=> $this->session->userdata('user_id'),
        ];
        $item = [
            'id_item'=>'',
            // 'id_pk'=>$id_pk,
            'job'=>$this->input->post('list_job')
        ];
        // for notdev
        $hasil = $this->model->save($data,$item); // return array id_pk

        $this->send_notif($hasil);
//         $data_pk = $this->model->get_data_detail($hasil);

//         $data_job = $this->db->get_where('pk_job_item',['id_pk'=>$hasil])->result();
//         $no = 1;
//         $job = '';
//         foreach($data_job as $data){
//             $job .= '*'.$no.'. '.$data->job.'*
// ';
//             $no++;
//         }
//         $data_pic = explode(',',$data_pk->pic);
        
//         foreach($data_pic as $id){
//             $pic = $this->model->get_pic($id);
//             $msg = "📢Alert Perintah Kerja!!📢
            
// Kami ingin memberitahukan bahwa Anda mendapat *Perintah Kerja* dari *".$data_pk->created_by."* pada *".$data_pk->tgl_masuk."* : 

//   👤Nama        : ".$pic->name."
//   🔰Jabatan     : ".$pic->designation_name."
//   🏭Departemen  :  ".$pic->company."

// Berikut list perkerjaan yang harus di kerjaan di hari tersebut :
// ".$job."

// Demikian Perintah Kerja ini dibuat agar dapat di laksanakan.";
//             $this->whatsapp_lib->send_single_msg('rsp',$pic->contact_no,$msg);
//             $this->whatsapp_lib->send_single_msg('rsp','6281120012145',$msg);//comben 
//         }

        echo json_encode($hasil);
    }

     // addnew notdev
    function send_notif($list_pk)
    {
        foreach ($list_pk as $id_pk) {
            // echo $id_pk;
            $data_pk = $this->model->get_data_detail($id_pk);

            $pic = $this->model->get_pic($data_pk->pic);

            $data_job = $this->db->get_where('pk_job_item',['id_pk'=>$id_pk])->result();
            $no = 1;
            $job = '';
            foreach($data_job as $data){
                $job .= '*'.$no.'. '.$data->job.'*
';
                $no++;
            }

            $msg = "📢Alert Perintah Kerja!!📢
            
Kami ingin memberitahukan bahwa Anda mendapat *Perintah Kerja* dari *".$data_pk->created_by."* pada *".$data_pk->tgl_masuk."* : 

👤Nama        : ".$pic->name."
🔰Jabatan     : ".$pic->designation_name."
🏭Departemen  :  ".$pic->company."

Berikut list perkerjaan yang harus di kerjaan di hari tersebut :
".$job."

Demikian Perintah Kerja ini dibuat agar dapat di laksanakan.";
            $this->send_wa($pic->contact_no, $msg, $data_pk->pic);
            $this->send_wa('6281120012145', $msg, 78);//comben 

            // echo $pic->contact_no; echo '<br/>';
            // echo $msg; echo '<br/><br/>';
        }
    }

    function update_progres(){
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $note = $this->input->post('note');
        $data_item = [
            'id' => $id,
            'status'=>$status,
            'note'=>$note
        ];
        if (empty($_FILES['file']['name'])) {
            $hasil = $this->model->update_progres($data_item);
            echo json_encode($id);
        }else{
            $file_name = time();
            $config['upload_path']          = './uploads/work_on_holiday/';
            $config['allowed_types']        = 'gif|jpg|png|doc|docx|xls|xlsx|ppt|pptx|pdf'; // Format file yang diterima
            $config['max_size']             = 7000; // Ukuran maksimum file (dalam kilobytes)
            $config['file_name']            = $file_name;
        
            $this->load->library('upload', $config);
        
            if ( ! $this->upload->do_upload('file')) {
                $error = array('error' => $this->upload->display_errors());
                echo json_encode($error);
            } else {
                $data = array('upload_data' => $this->upload->data());
                $this->model->update_progres($data_item,$data['upload_data']['file_name']);
                echo json_encode($data);
            }

        }
    
    }

    function send_notif_approval($id_pk){
        $user = $this->session->userdata('user_id');
        $pic = $this->model->get_pic($user);
        $job = $this->model->get_detail_job_notif($id_pk);
        $list = '';
        $tgl_masuk = '';
        $no_hp = '';
        foreach ($job as $data ) {
            $tgl_masuk = $data->tgl_masuk;
            $no_hp = $data->contact_no;
            $list .= '
'.$data->no.'. '.$data->job.'
Status : ('.$data->status_desc.') | File : ('.$data->file.')
';
        }
        $msg = "📢Alert Approval Progress Perintah Kerja !!📢

    👤Nama         : ".$pic->name."
    🔰Jabatan      : ".$pic->designation_name."
    🏭Departemen  :  ".$pic->company."
    
🔑".$id_pk."
📅Tgl Masuk : ".$tgl_masuk."
📃Berikut detail progres job : 
    ".$list."    
Silahkan Cek dan Approval di Menu Work On Holiday Trusmiverse
Terima Kasih

";
        $hasil = $this->send_wa($no_hp, $msg, $user);
        echo json_encode($hasil);

    }

    function update_verif(){
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $note = $this->input->post('note');
        $data_item = [
            'id' => $id,
            'status'=>$status,
            'note'=>$note
        ];
        $hasil = $this->model->update_verif($data_item);
        echo json_encode($hasil);
        // $this->model->update_verif($data_item);
    }
    function delete(){
        $no_pk = $this->input->post('no_pk');
        $this->db->where('no_pk',$no_pk);
        $this->db->delete('pk_job');
    }

    public function hapus_pk($id_pk)
{
    // Pastikan id_pk tidak kosong
    if (empty($id_pk)) {
        echo json_encode(['status' => 'error', 'message' => 'ID PK tidak valid.']);
        return;
    }

    // Hapus dulu child table (pk_job_item) berdasarkan id_pk
    $this->db->where('id_pk', $id_pk);
    $this->db->delete('pk_job_item');

    // Hapus parent table (pk_job)
    $this->db->where('id_pk', $id_pk);
    $this->db->delete('pk_job');

    if ($this->db->affected_rows() >= 0) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'PK ' . $id_pk . ' berhasil dihapus.'
        ]);
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal menghapus data.'
        ]);
    }
}
function send_wa($phone, $msg, $user_id = '')
{
    // Format nomor ke 62xxx (sudah include di sini, beda dengan Trusmi_memo)
    $filter_plus = str_replace('+', '', $phone);
    $filter_min  = str_replace('-', '', $filter_plus);
    $filter_nol  = ltrim($filter_min, '0');
    $phone_fmt   = "62" . $filter_nol;

    try {
        $this->load->library('WAJS');
        return $this->wajs->send_wajs_notif($phone_fmt, $msg, 'text', 'trusmiverse', $user_id);
    } catch (\Throwable $th) {
        return "Server WAJS Error";
    }
}
    
}