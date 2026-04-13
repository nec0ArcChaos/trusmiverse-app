<?php defined('BASEPATH') or exit('No direct script access allowed');


class Bsc_so extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('Filter');
        $this->load->library('Whatsapp_lib');
        $this->load->model('Model_bsc_so', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Strategi Objektif - Strategi Inisiatif";
        $data['css']              = "bsc_so/css";
        $data['js']               = "bsc_so/js";
        $data['content']          = "bsc_so/index";

        $this->load->view('layout/main', $data);
    }



    public function get_strategi_objektif()
    {
        $response = $this->model->get_strategi_objektif();
        echo json_encode($response);
    }

    public function get_strategi_inisiatif()
    {
        $response = $this->model->get_strategi_inisiatif();
        echo json_encode($response);
    }

    public function get_strategi_task()
    {
        $response = $this->model->get_strategi_task();
        echo json_encode($response);
    }

    public function get_strategi_ketercapaian()
    {
        $response = $this->model->get_strategi_ketercapaian();
        echo json_encode($response);
    }

    public function get_detail_ketercapaian()
    {
        $response = $this->model->get_detail_ketercapaian();
        echo json_encode($response);
    }

    public function dt_sosi()
    {
        $response['data'] = $this->model->dt_sosi();
        echo json_encode($response);
    }

    public function dt_detail_ketercapaian()
    {
        $response['data'] = $this->model->dt_detail_ketercapaian();
        echo json_encode($response);
    }



    // =============
    function get_strategi_sosi($category)
	{
		// $periode  = $_GET['periode'];
        $periode  = '2024-04';

		// $category  = $_GET['category'];

		$data1 = $this->model->get_strategi_sosi($periode, 1, $category, 0, 0)->result();
		$data = "";

		// if ($cek_issue > 0) {
			foreach ($data1 as $val) {
				$data .= '<tr>
							<td rowspan="' . $val->rowspan1 . '">' . $val->strategy . '</td>
							<td rowspan="' . $val->rowspan1 . '">
                                <textarea class="form-control" class="formatNumberInput" id="val_target_so_' . $val->category . '_' . $val->id_so . '" 
                                value="' . $val->target . '"  class="excel" rows="1" 
                                onfocusin="expandTextarea_draft(&apos;val_target_so_' . $val->category . '_' . $val->id_so . '&apos;)" 
                                >' . $val->target . '</textarea>
                            </td>
							<td rowspan="' . $val->rowspan1 . '">
                                <textarea class="form-control" id="val_actual_so_' . $val->category . '_' . $val->id_so . '" 
                                value="' . $val->actual . '"  class="excel" rows="1" 
                                onfocusin="expandTextarea_draft(&apos;val_actual_so_' . $val->category . '_' . $val->id_so . '&apos;)" 
                                >' . $val->actual . '</textarea>
                            </td>
							<td rowspan="' . $val->rowspan1 . '">
                            <select class="form-control" id="val_select_statusso_' . $val->id_so . '" onchange="submit_update_draft(&apos;kategori_draft_' . $val->id_so . '_' . '&apos;)">
                            <option value="">- Choose -</option>';

                            $data .= '<option value="Berhasil" '.($val->status == 'Berhasil' ? 'selected' : '').'>Berhasil</option>
                            <option value="Progress" '.($val->status == 'Progress' ? 'selected' : '').'>Progress</option>
                            <option value="Tidak Berhasil" '.($val->status == 'Tidak Berhasil' ? 'selected' : '').'>Tidak Berhasil</option>
                            <option value="Tidak Berjalan" '.($val->status == 'Tidak Berjalan' ? 'selected' : '').'>Tidak Berjalan</option>';
                           

                            $data .= '</select>
                            </td>'
                            ;
				$data2 = $this->model->get_strategi_sosi($periode, 2, $category, $val->id_so, 0)->result();

				foreach ($data2 as $val2) {
					
                    $data .= '<td>' . $val2->strategy_si .'</td>
                                <td><textarea class="form-control" id="val_target_si_' . $val2->category . '_' . $val2->id_so . '_' . $val2->id_so. '" 
                                value="' . $val2->target_si . '"  class="excel" rows="1" 
                                onfocusin="expandTextarea_draft(&apos;val_target_si_' . $val2->category . '_' . $val2->id_so . '_' . $val2->id_so. '&apos;)" 
                                >' . $val2->target_si . '</textarea></td>
                                <td><textarea class="form-control" id="val_target_si_' . $val2->category . '_' . $val2->id_so . '_' . $val2->id_so. '" 
                                value="' . $val2->actual_si . '"  class="excel" rows="1" 
                                onfocusin="expandTextarea_draft(&apos;val_target_si_' . $val2->category . '_' . $val2->id_so . '_' . $val2->id_so. '&apos;)" 
                                >' . $val2->actual_si . '</textarea></td>
                                <td><select class="form-control" id="val_select_statussi_' . $val2->id_si . '" onchange="submit_update_draft(&apos;kategori_draft_' . $val2->id_si . '_' . '&apos;)">
                                <option value="">- Choose -</option>';
    
                                $data .= '<option value="Berhasil" '.($val2->status == 'Berhasil' ? 'selected' : '').'>Berhasil</option>
                                <option value="Progress" '.($val2->status == 'Progress' ? 'selected' : '').'>Progress</option>
                                <option value="Tidak Berhasil" '.($val2->status == 'Tidak Berhasil' ? 'selected' : '').'>Tidak Berhasil</option>
                                <option value="Tidak Berjalan" '.($val2->status == 'Tidak Berjalan' ? 'selected' : '').'>Tidak Berjalan</option>';
                               
    
                                $data .= '</select></td>
                                </tr>';
                                // if($val2->total_disc > 0){
                                //     $span = "danger" ;
                                // } else {
                                //     $span = "primary";
                                // }
                                // $data .= '<td><span class="label label-'.$span.' px-3" style="cursor:pointer;" onclick="mdl_kapstore_det(1,\''. $start. '\', \'' . $end . '\', 5,' . 
                                //                 $val2->id_category . ','. 
                                //                 $val2->id_subcategory . ',\'' .
                                //                 $val2->cmt_bahan. '\',' .
                                //                 $val2->cmt_teknik. ',' .
                                //                 $val2->cmt_rh_start. ',' .
                                //                 $val2->cmt_rh_end . ');">' . $val2->total_disc . '</span></td>';

                                // if($val2->total_exis > 0){
                                //     $span = "primary" ;
                                // } else {
                                //     $span = "danger";
                                // }
                                // $data .= '<td><span class="label label-'.$span.' px-3" style="cursor:pointer;" onclick="mdl_kapstore_det(0,\''. $start. '\', \'' . $end . '\', 5,' . 
                                //                 $val2->id_category . ','. 
                                //                 $val2->id_subcategory . ',\'' .
                                //                 $val2->cmt_bahan. '\',' .
                                //                 $val2->cmt_teknik. ',' .
                                //                 $val2->cmt_rh_start. ',' .
                                //                 $val2->cmt_rh_end . ');">' . $val2->total_exis . '</span></td>
                                // <td>' . $val2->selisih . '</td>
                                // <td>' . $val2->qty_sale . '</td>

                                // </tr>';
                        
						
					
				}
					// $data .= '</tr>';

			}
		// }

		$result['table'] = $data;
		echo json_encode($result);
	}

    

    public function get_dt_so()
    {
		$periode  = $_POST['periode'];

        $response['data'] = $this->model->get_dt_so($periode)->result();
        echo json_encode($response);
    }

    public function get_dt_so_h()
    {
		$periode  = $_POST['periode'];
        $id_so  = $_POST['id_so'];

        $response['data'] = $this->model->get_dt_so_h($periode, $id_so)->result();
        echo json_encode($response);
    }
    
    public function insert_so()
    {
        if (!empty($_FILES['so_file']['name'])) {

            // Proses unggah file
            $config['upload_path']   = './uploads/so/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $new_name = time();
            $config['file_name']     = $this->session->userdata('user_id') . "_" . $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('so_file')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

        $week = $this->model->get_week();

        $data = array(
            'id_so'             => $this->filter->sanitaze_input($this->input->post('so_id_so')),
            'category'          => $this->filter->sanitaze_input($this->input->post('so_category')),
           
            'target'            => str_replace('.','',$this->filter->sanitaze_input($this->input->post('so_target'))),

            'actual'            => str_replace('.','',$this->filter->sanitaze_input($this->input->post('so_actual'))),
            'achieve'           => $this->filter->sanitaze_input($this->input->post('so_acv')),
            'status'            => $this->filter->sanitaze_input($this->input->post('so_status')),
            'periode'           => $this->filter->sanitaze_input($this->input->post('periode')),
            'lampiran'          => $file_name,
            'link'              => $this->filter->sanitaze_input($this->input->post('so_link')),
            'created_at'        => date("Y-m-d H:i:s"),
            'created_by'        => $this->session->userdata('user_id'),
            'resume'            => $this->filter->sanitaze_input($this->input->post('so_resume')),
            'company_id'            => $this->filter->sanitaze_input($this->input->post('so_company_id_so')),

        );

        $data0 = array(
           

            'actual'            => str_replace('.','',$this->filter->sanitaze_input($this->input->post('so_actual'))),
            'achieve'           => $this->filter->sanitaze_input($this->input->post('so_acv')),
            'status'            => $this->filter->sanitaze_input($this->input->post('so_status')),
            'lampiran'          => $file_name,
            'link'              => $this->filter->sanitaze_input($this->input->post('so_link')),
            'updated_at'        => date("Y-m-d H:i:s"),
            'updated_by'        => $this->session->userdata('user_id'),
            'resume'            => $this->filter->sanitaze_input($this->input->post('so_resume')),
        );

        $this->db->where("id_so", $this->filter->sanitaze_input($this->input->post('so_id_so')));
        $response['update1']     =  $this->db->update("bsc_so", $data0);

        $response['status']     = 'success';
        $response['message']    = 'success';
        $response['update']     = $this->db->insert('bsc_so_h', $data);
        $response['datas']    = $data;

        

        echo json_encode($response);
    }

    public function get_dt_si()
    {
		$periode  = $_POST['periode'];

        $response['data'] = $this->model->get_dt_si($periode)->result();
        echo json_encode($response);
    }

    public function get_dt_si_h()
    {
		$periode  = $_POST['periode'];
        $id_so  = $_POST['id_so'];
        $id_si  = $_POST['id_si'];


        $response['data'] = $this->model->get_dt_si_h($periode, $id_so, $id_si)->result();
        echo json_encode($response);
    }

    public function insert_si()
    {
        if (!empty($_FILES['si_file']['name'])) {

            // Proses unggah file
            $config['upload_path']   = './uploads/so/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $new_name = time();
            $config['file_name']     = $this->session->userdata('user_id') . "_" . $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('si_file')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

        $week = $this->model->get_week();

        $data = array(
            'id_so'             => $this->filter->sanitaze_input($this->input->post('si_id_so')),

            'id_si'             => $this->filter->sanitaze_input($this->input->post('si_id_si')),
            'category'          => $this->filter->sanitaze_input($this->input->post('si_category')),
           
            'target'            => str_replace('.','',$this->filter->sanitaze_input($this->input->post('si_target'))),

            'actual'            => str_replace('.','',$this->filter->sanitaze_input($this->input->post('si_actual'))),
            'achieve'           => $this->filter->sanitaze_input($this->input->post('si_acv')),
            'status'            => $this->filter->sanitaze_input($this->input->post('si_status')),
            'periode'           => $this->filter->sanitaze_input($this->input->post('periode')),
            'lampiran'          => $file_name,
            'link'              => $this->filter->sanitaze_input($this->input->post('si_link')),
            'created_at'        => date("Y-m-d H:i:s"),
            'created_by'        => $this->session->userdata('user_id'),
            'resume'            => $this->filter->sanitaze_input($this->input->post('si_resume')),

        );

        $data0 = array(
           

            'actual'            => str_replace('.','',$this->filter->sanitaze_input($this->input->post('si_actual'))),
            'achieve'           => $this->filter->sanitaze_input($this->input->post('si_acv')),
            'status'            => $this->filter->sanitaze_input($this->input->post('si_status')),
            'lampiran'          => $file_name,
            'link'              => $this->filter->sanitaze_input($this->input->post('si_link')),
            'updated_at'        => date("Y-m-d H:i:s"),
            'updated_by'        => $this->session->userdata('user_id'),
            'resume'            => $this->filter->sanitaze_input($this->input->post('si_resume')),
        );

        
        $response['status']     = 'success';
        $response['message']    = 'success';
        $response['update']     = $this->db->insert('bsc_si_h', $data);
        $response['datas']    = $data;

        $this->db->where("id_si", $this->filter->sanitaze_input($this->input->post('si_id_si')));
        $response['update1']     =  $this->db->update("bsc_si", $data0);
        

        echo json_encode($response);
    }

    public function get_dt_goal()
    {
        $periode  = $_POST['periode'];

        $response['data'] = $this->model->get_dt_goal($periode)->result();
        echo json_encode($response);
    }

    public function get_dt_goal_h()
    {
		$periode  = $_POST['periode'];
        $goal_id  = $_POST['goal_id'];
        $response['data'] = $this->model->get_dt_goal_h($periode, $goal_id)->result();
        echo json_encode($response);
    }

    public function insert_goal()
    {
        if (!empty($_FILES['goal_file']['name'])) {

            // Proses unggah file
            $config['upload_path']   = './uploads/so/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $new_name = time();
            $config['file_name']     = $this->session->userdata('user_id') . "_" . $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('goal_file')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

        $data = array(
            'id'             => $this->filter->sanitaze_input($this->input->post('goal_id')),
            'target'            => str_replace('.','',$this->filter->sanitaze_input($this->input->post('goal_target'))),
            'actual'            => str_replace('.','',$this->filter->sanitaze_input($this->input->post('goal_actual'))),
            'periode'           => $this->filter->sanitaze_input($this->input->post('goal_periode')),
            'lampiran'          => $file_name,
            'link'              => $this->filter->sanitaze_input($this->input->post('goal_link')),
            'created_at'        => date("Y-m-d H:i:s"),
            'created_by'        => $this->session->userdata('user_id'),
            'resume'            => $this->filter->sanitaze_input($this->input->post('goal_resume')),

        );

        $data0 = array(           
            'actual'            => str_replace('.','',$this->filter->sanitaze_input($this->input->post('goal_actual'))),
            'lampiran'          => $file_name,
            'link'              => $this->filter->sanitaze_input($this->input->post('goal_link')),
            'updated_at'        => date("Y-m-d H:i:s"),
            'updated_by'        => $this->session->userdata('user_id'),
            'resume'            => $this->filter->sanitaze_input($this->input->post('goal_resume')),
        );

        
        $response['status']     = 'success';
        $response['message']    = 'success';
        $response['update']     = $this->db->insert('bsc_m_h', $data);
        $response['datas']    = $data;

        $this->db->where("id", $this->filter->sanitaze_input($this->input->post('goal_id')));
        $response['update1']     =  $this->db->update("bsc_m", $data0);
        

        echo json_encode($response);
    }

    public function cek_akses(){

        $response['data'] = $this->model->cek_akses();
        echo json_encode($response);
    }

    public function master_goals()
    {
        $data['pageTitle']        = "Master BSC SO SI";
        $data['css']              = "bsc_so/css";
        $data['js']               = "bsc_so/master_js";
        $data['content']          = "bsc_so/master";

        $this->load->view('layout/main', $data);
    }

    public function add_list_goals()
    {
        $data['pageTitle']        = "Add List Goals";
        $data['css']              = "bsc_so/css";
        $data['js']               = "bsc_so/add_list_goals_js";
        $data['content']          = "bsc_so/add_list_goals";
        $data['get_company']  = $this->model->get_company()->result();

        $this->load->view('layout/main', $data);
    }

    public function get_dt_master_goals()
    {
		$company  = $_POST['company'];
        $department  = $_POST['department'];
        $response['data'] = $this->model->get_dt_master_goals($company, $department)->result();
        echo json_encode($response);
    }

    public function get_department()
    {
		$company_id  = $_POST['company_id'];
        $response = $this->model->get_department($company_id)->result();
        echo json_encode($response);
    }
    
    public function get_dt_goal_master() 
    {
        $periode     = $_POST['periode'];
        $data['data'] = $this->model->get_dt_goal($periode)->result();

        echo json_encode($data);
    }

    function save_list_goals()
	{
        $id_user 			= $this->session->userdata('user_id');
		$company            = $this->session->userdata('company');
		$department         = $this->input->post('department');
		$periode            = $this->input->post('periode');

		
			$detail_data = array();
			if (isset($_POST['add_company_id'])) {
				foreach ($_POST['add_company_id'] as $key => $val) {					

                    $cek_dobel_data    = $this->db->query("SELECT CASE WHEN id IS NOT NULL THEN 1 ELSE 0 END AS hasil_cek, CONCAT(perspective, ' | ',category, ' | ', periode, '<br>') as hasil_cek_text FROM hris.bsc_m WHERE department = '".$_POST['add_department'][$key]."' AND category = '".$_POST['add_category'][$key]."' AND company_id = '".$_POST['add_company_id'][$key]."' AND periode = '$periode'")->row_array();
                    $data_array[]  = array(
                        $cek_dobel_data['hasil_cek_text']   => $cek_dobel_data['hasil_cek'],
                    );  
                    $data_array2[]  = array($cek_dobel_data['hasil_cek_text']);                                            
				}

                // $key = array_search("1", $data_array);
                $convert_array = array_reduce($data_array, 'array_merge', array());
                $convert_array2 = array_reduce($data_array2, 'array_merge', array());
                // $result['data_array'] = $convert_array;

                if (in_array("1", $convert_array)) {
                // if ($key !== false) {
                    // echo "Found apple in the array!";
                    $result['cek_data_tidak_double'] = false;
                    $result['insert_detail'] = false;
                    // Menghapus nilai yang kosong atau null dari array
                    $filtered_array = array_filter($convert_array2, function($value) {
                        return $value !== "" && $value !== null;
                    });
                    $result['list_double'] = implode($filtered_array);
                    // $result['list_double'] = $filtered_array;
                    // $result['list_doublea'] = $data_array2;

                } else {
                    // echo "Apple not found in the array.";
                    foreach ($_POST['add_company_id'] as $key => $val) {					
                        $detail_data  = array(
                            'perspective'   => $_POST['add_perspective'][$key],
                            'sub'           => $_POST['add_sub'][$key],
                            'category'      => $_POST['add_category'][$key],
                            'project'       => $_POST['add_project'][$key] != '' ? $_POST['add_tipe'][$key] : Null,
                            'pm'            => $_POST['add_pm'][$key] != '' ? $_POST['add_tipe'][$key] : Null,
                            'target'        => str_replace('.','',$_POST['add_target'][$key]) != '' ? str_replace('.','',$_POST['add_target'][$key]) : 0,
                            'bobot' 	    => str_replace('.','',$_POST['add_bobot'][$key]) != '' ? str_replace('.','',$_POST['add_bobot'][$key]) : 0,
                            'department' 	=> $_POST['add_department'][$key],
                            'periode' 	    => $_POST['periode'],
                            'tipe' 	        => $_POST['add_tipe'][$key] ,
                            'spend' 	    => $_POST['add_spend'][$key] != '0' ? $_POST['add_spend'][$key] : Null,
                            'company_id' 	=> $_POST['add_company_id'][$key],
                            'datas' 	    => $_POST['add_datas'][$key],
    
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by' 	=> $id_user,
    
                        );
                        $result['insert_detail data'] = $this->db->insert('bsc_m', $detail_data);			
                    }
                    $result['cek_data_tidak_double'] = true;
                    $result['insert_detail'] = $detail_data; 
                    $result['list_double'] = false;

                }
		    }

		echo json_encode($result);

	}

    function save_target_so()
	{
        $id_user 			= $this->session->userdata('user_id');
		$company            = $this->session->userdata('company');
		$a_so_company_id    = $this->input->post('a_so_company_id');
		$a_so_periode       = $this->input->post('a_so_periode');
		$a_so_category      = $this->input->post('a_so_category');
		$a_so_department    = $this->input->post('a_so_department');
		$a_so_target        = $this->input->post('a_so_target');
		$a_so_spend         = $this->input->post('a_so_spend');
		$a_so_tipe          = $this->input->post('a_so_tipe');
        $a_so_so          = $this->input->post('a_so_so');
	
            $detail_data  = array(
                'id_bsc' 	    => $a_so_department,
                'category' 	    => $a_so_category,
                'strategy' 	    => $a_so_so,
                'tipe' 	        => $a_so_tipe,
                'spend' 	    => $a_so_spend,
                'target' 	    => str_replace('.','',$a_so_target),
                'periode' 	    => $a_so_periode,
                'company_id' 	=> $a_so_company_id,
                'department' 	=> $a_so_department,
                'created_at'    => date('Y-m-d H:i:s'),
                'created_by' 	=> $id_user,            
            );

            $result['status'] = $this->db->insert('bsc_so', $detail_data);	
            // $result['status'] = true;			                    		                    
            $result['insert_detail'] = $detail_data; 

		echo json_encode($result);

	}

    function save_target_si()
	{
        $id_user 			= $this->session->userdata('user_id');
		$company            = $this->session->userdata('company');
		$a_si_company_id    = $this->input->post('a_si_company_id');
		$a_si_periode       = $this->input->post('a_si_periode');
		$a_si_category      = $this->input->post('a_si_category');
		$a_si_department    = $this->input->post('a_si_department');
		$a_si_target        = $this->input->post('a_si_target');
		$a_si_spend         = $this->input->post('a_si_spend');
		$a_si_tipe          = $this->input->post('a_si_tipe');
        $a_si_si          = $this->input->post('a_si_si');
        $a_si_id_so          = $this->input->post('a_si_id_so');

            $detail_data  = array(
                'id_so' 	    => $a_si_id_so,
                'category' 	    => $a_si_category,
                'strategy' 	    => $a_si_si,
                'tipe' 	        => $a_si_tipe,
                'spend' 	    => $a_si_spend,
                'target' 	    => str_replace('.','',$a_si_target),
                'periode' 	    => $a_si_periode,
                'company_id' 	=> $a_si_company_id,
                'created_at'    => date('Y-m-d H:i:s'),
                'created_by' 	=> $id_user,            
            );

            $result['status'] = $this->db->insert('bsc_si', $detail_data);	
            // $result['status'] = true;			                    		                    
            $result['insert_detail'] = $detail_data; 

		echo json_encode($result);

	}
}
