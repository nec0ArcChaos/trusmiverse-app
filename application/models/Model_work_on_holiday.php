<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_work_on_holiday extends CI_Model
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_spv_up($user){
        $query = "SELECT
        user_id,
        first_name,
        last_name 
    FROM
        `xin_employees` emp
        JOIN xin_user_roles role ON role.role_id = emp.user_role_id
        WHERE emp.user_id = '$user' AND (role.role_id IN (1,2,3,4,5,10) OR emp.user_id = 3648)";
        return $this->db->query($query)->num_rows();
    }
    function get_data($start, $end){
        $user = $this->session->userdata('user_id');
        $cek_user = $this->db->query("SELECT user_id, first_name FROM xin_employees emp JOIN xin_user_roles role ON role.role_id = emp.user_role_id WHERE emp.user_id = '$user' AND role.role_id IN (1,2)")->num_rows();
        if($cek_user > 0){
            $kondisi = "";
        }else{
            $kondisi = "AND pk_job.pic ='$user' OR pk_job.created_by='$user'";
        }
        $query = "SELECT
        id_pk,
        xin_companies.name AS company,
        xin_departments.department_name,
        xin_designations.designation_name,
        CONCAT(pic.first_name, ' ', pic.last_name) AS pic,
        tgl_masuk,
        note,
        pk_job.created_at,
        pk_job.created_by AS id_created_by,
        IF(pk_job.created_by = '$user',1,0) AS is_created,
        CONCAT(user.first_name,' ',user.last_name) AS created_by,
        (SELECT MAX(verified_at) FROM pk_job_item WHERE pk_job_item.id_pk = pk_job.id_pk) AS verified_at,
        (SELECT COUNT(*) FROM pk_job_item WHERE pk_job_item.id_pk = pk_job.id_pk) AS total_job,
        (SELECT COUNT(*) FROM pk_job_item WHERE pk_job_item.id_pk = pk_job.id_pk AND status = 2) AS job_progres,
        (SELECT COUNT(*) FROM pk_job_item WHERE pk_job_item.id_pk = pk_job.id_pk AND status = 3) AS job_done,
        (SELECT COUNT(*) FROM pk_job_item WHERE pk_job_item.id_pk = pk_job.id_pk AND status = 3 AND COALESCE(verified_status,'0') = 2) AS job_verified,
        (SELECT COUNT(*) FROM pk_job_item WHERE pk_job_item.id_pk = pk_job.id_pk AND COALESCE(verified_status,'0') = 1) AS job_revisi
    FROM
        `pk_job`
        LEFT JOIN xin_employees user ON user.user_id = pk_job.created_by
        LEFT JOIN xin_employees pic ON pic.user_id = pk_job.pic
        LEFT JOIN xin_designations ON pic.designation_id = xin_designations.designation_id
        LEFT JOIN xin_companies ON pic.company_id = xin_companies.company_id
        LEFT JOIN xin_departments ON pic.department_id = xin_departments.department_id
        WHERE SUBSTR(pk_job.created_at,1,10) BETWEEN '$start' AND '$end' 
        $kondisi
        ";
        return $this->db->query($query)->result();
    }
    function get_karyawan(){
        $user = $this->session->userdata('user_id');
        $query = "SELECT xin_employees.user_id, xin_employees.username, designation_name, xin_companies.name AS company, CONCAT(xin_employees.first_name,' ',xin_employees.last_name) AS nama_karyawan, xin_departments.department_name,xin_departments.department_id
        
        FROM xin_employees
        LEFT JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
        LEFT JOIN xin_companies ON xin_employees.company_id = xin_companies.company_id
        LEFT JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
        WHERE xin_employees.is_active = '1' AND xin_employees.user_id != '$user'
        ORDER BY nama_karyawan ASC
        ";
        return $this->db->query($query)->result();
    }

    function save($data,$item){
        $data_id_pk = [];
        // jika pekerjaan lebih dari 1
        if(count($item['job']) > 1){

            // $id_pk = $this->no_pk();
            if (count($data['pic']) > 1) { // jika karyawan lebih dari satu

                 foreach ($data['pic'] as $i) {
                    
                    $id_pk = $this->no_pk();

                    $list_pic = [
                        'id_pk' => $id_pk,
                        'pic' => $i,
                        'tgl_masuk'=> $data['tgl_masuk'],
                        'note'=> $data['note'],
                        'created_at'=>date('Y-m-d H:i:s'),
                        'created_by'=> $this->session->userdata('user_id'),
                    ];
                    $this->db->insert('pk_job', $list_pic);

                    foreach($item['job'] as $j ){
                        $list_job = [
                            'id_item'=>'',
                            'id_pk'=>$id_pk,
                            'job'=>$j,
                            'status'=>1
                        ];
                        $this->db->insert('pk_job_item',$list_job);
                    }

                    // add to array id_pk
                    $data_id_pk[] = $id_pk;

                }

            } else { // jika karyawan hanya 1

                $id_pk = $this->no_pk();
            
            foreach($item['job'] as $i ){
                $list_job = [
                    'id_item'=>'',
                        // 'id_pk'=>$item['id_pk'],
                        'id_pk'=>$id_pk,
                    'job'=>$i,
                    'status'=>1
                ];
                $this->db->insert('pk_job_item',$list_job);
            }

                 $list_pic = [
                    // 'id_pk' => $data['id_pk'],
                    'id_pk' => $id_pk,
                    'pic' => implode('', $data['pic']),
                    'tgl_masuk'=> $data['tgl_masuk'],
                    'note'=> $data['note'],
                    'created_at'=>date('Y-m-d H:i:s'),
                    'created_by'=> $this->session->userdata('user_id'),
                ];

                $this->db->insert('pk_job', $list_pic);

                // add to array id_pk
                $data_id_pk[] = $id_pk;
            }

        }else{ // jika pekerjaan hanya 1
            // $list_job = [
            //     'id_item'=>'',
            //     'id_pk'=>$item['id_pk'],
            //     'job'=> implode('', $item['job']),
            //     'status'=>1
            // ];
            // $this->db->insert('pk_job_item',$list_job);

            // jika karyawan lebih dari satu
            if (count($data['pic']) > 1) {

                foreach ($data['pic'] as $i) {
                    
                    $id_pk = $this->no_pk();

                    $list_pic = [
                        'id_pk' => $id_pk,
                        'pic' => $i,
                        'tgl_masuk'=> $data['tgl_masuk'],
                        'note'=> $data['note'],
                        'created_at'=>date('Y-m-d H:i:s'),
                        'created_by'=> $this->session->userdata('user_id'),
                    ];
                    $this->db->insert('pk_job', $list_pic);

                    // insert ke job_item
            $list_job = [
                'id_item'=>'',
                        'id_pk'=> $id_pk,
                'job'=> implode('', $item['job']),
                'status'=>1
            ];
            $this->db->insert('pk_job_item',$list_job);

                    // add to array id_pk
                    $data_id_pk[] = $id_pk;
                }

            } else { // jika karyawan hanya 1

                $id_pk = $this->no_pk();

                $list_job = [
                    'id_item'=>'',
                    // 'id_pk'=>$item['id_pk'],
                    'id_pk'=>$id_pk,
                    'job'=> implode('', $item['job']),
                    'status'=>1
                ];
                $this->db->insert('pk_job_item',$list_job);
                
                $list_pic = [
                    // 'id_pk' => $data['id_pk'],
                    'id_pk' => $id_pk,
                    'pic' => implode('', $data['pic']),
                    'tgl_masuk'=> $data['tgl_masuk'],
                    'note'=> $data['note'],
                    'created_at'=>date('Y-m-d H:i:s'),
                    'created_by'=> $this->session->userdata('user_id'),
                ];
                $this->db->insert('pk_job', $list_pic);

                // add to array id_pk
                $data_id_pk[] = $id_pk;
        }

        }
        // return $item['id_pk'];
        return $data_id_pk;
    }

    // addnew
    function no_pk()
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
    
    function get_data_detail($id){
        $query = "SELECT
        id_pk,
        pic,
        (SELECT GROUP_CONCAT(CONCAT(pic.first_name, ' ', pic.last_name) SEPARATOR ', ') FROM xin_employees pic WHERE FIND_IN_SET(pic.user_id, pk_job.pic)) AS pic_name,
        tgl_masuk,
        note,
        pk_job.created_at,
        CONCAT(user.first_name,' ',user.last_name) AS created_by
    FROM
        `pk_job`
        JOIN xin_employees user ON user.user_id = pk_job.created_by
        WHERE id_pk = '$id' ";
        return $this->db->query($query)->row_object();
    }
    function get_list_job($id){
        $query = "SELECT
         id_item AS id, id_pk, job, COALESCE(status,1) AS status,
          CASE status
          WHEN 1 THEN 'Waiting'
          WHEN 2 THEN 'Progres'
          WHEN 3 THEN 'Done'
          ELSE 'Waiting'
            END AS status_desc,
            COALESCE(updated_at,'-') AS updated_at,
            COALESCE(note,'') AS note, file,
            COALESCE(verified_status,'0')AS verified_status,
            COALESCE(verified_note,'')AS verified_note,
            CASE verified_status
          WHEN 1 THEN 'Revisi'
          WHEN 2 THEN 'Approved'
          ELSE '-'
            END AS status_verif

           FROM pk_job_item WHERE id_pk='$id'";
        return $this->db->query($query)->result();
    }
    function get_pic($id){
        $query = "SELECT CONCAT(first_name,' ',last_name) AS name, contact_no, xin_designations.designation_name, xin_companies.name as company FROM xin_employees LEFT JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
        LEFT JOIN xin_companies ON xin_employees.company_id = xin_companies.company_id WHERE user_id='$id'";
        return $this->db->query($query)->row_object();
    }
    function get_approval($user,$start,$end){
        if($user == 1 || $user == 979){//it & personalia
            $kodisi = "WHERE SUBSTR(pk.created_at,1,10) BETWEEN '$start' AND '$end' ";
        }else{
            $kodisi = "WHERE pk.created_by = '$user' AND SUBSTR(pk.created_at,1,10) BETWEEN '$start' AND '$end' ";
        }
        $query = "SELECT
                id_item,
                item.id_pk,
                CONCAT(pic.first_name, ' ', pic.last_name) AS pic,
                COUNT(item.id_pk) AS jumlah_job,
                SUM(CASE item.status
                WHEN 3 THEN 1
                ELSE 0
                END) AS jumlah_done
                
            FROM
                pk_job_item item
                LEFT JOIN pk_job pk ON pk.id_pk = item.id_pk
                LEFT JOIN xin_employees pic ON pic.user_id = pk.pic
                $kodisi
                GROUP BY item.id_pk
                HAVING NOT (
                    SUM(CASE item.status WHEN 3 THEN 1 ELSE 0 END) = COUNT(item.id_pk)
                    AND SUM(CASE WHEN COALESCE(item.verified_status,'0') = 2 THEN 1 ELSE 0 END) = COUNT(item.id_pk)
                )
                ";
        return $this->db->query($query)->result();
    }
    function update_progres($data, $file = null){
        $user = $this->session->userdata('user_id');
        $date = date('Y-m-d H:i:s');
        $this->db->query("UPDATE pk_job_item 
        SET `status`='$data[status]', `note`='$data[note]', `file`='$file',
         updated_at='$date' , updated_by='$user', `verified_status`=0
         WHERE id_item='$data[id]'");
        return true;
    }
    function update_verif($data){
        $user = $this->session->userdata('user_id');
        $date = date('Y-m-d H:i:s');
        if($data['status'] == 1){

            $this->db->query("UPDATE pk_job_item 
            SET `verified_status`='$data[status]', `verified_note`='$data[note]', 
             verified_at='$date' , verified_by='$user', status='1', file=NULL, note=NULL
             WHERE id_item='$data[id]'");
            return true;
        }else{

            $this->db->query("UPDATE pk_job_item 
            SET `verified_status`='$data[status]', `verified_note`='$data[note]', 
             verified_at='$date' , verified_by='$user'
             WHERE id_item='$data[id]'");
            return true;
        }
    }
    function get_detail_job_notif($id_pk){
        $query = "SELECT
        ROW_NUMBER() OVER (ORDER BY pk_job_item.id_pk) AS no,
        pk_job.id_pk,
        pk_job.tgl_masuk,
        job,
        user.contact_no,
    CASE
        STATUS 
            WHEN 1 THEN
            'Waiting' 
            WHEN 2 THEN
            'Progres' 
            WHEN 3 THEN
            'Done' ELSE 'Waiting' 
        END AS status_desc,
        CASE 
            WHEN file IS NULL THEN 'Tidak Terlampir'
            ELSE 'Terlampir'
            END AS file
        FROM pk_job_item
        LEFT JOIN pk_job ON pk_job.id_pk = pk_job_item.id_pk
        LEFT JOIN xin_employees user ON user.user_id = pk_job.created_by
        WHERE pk_job_item.id_pk = '$id_pk'";
        return $this->db->query($query)->result();
    }
}