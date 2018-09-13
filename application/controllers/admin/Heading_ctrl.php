<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Heading_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file','form'));
		$this->load->library(array('session','ion_auth','form_validation'));
		$this->load->database();
		$this->load->model(array('admin/Language_model'));
		$this->lang->load('admin_lang', 'english');
		if (!$this->ion_auth->logged_in()){
			redirect('admin/admin');
		}
	}
	
	public function index(){
//   print_r($this->session->all_userdata()); die;
	    $data['title'] = 'eNam Admin';
	    $file_menu = json_decode(file_get_contents(FCPATH . '/software_files/Language.txt'),true);
	    if(count($file_menu)){
	        $data['languages'] = $file_menu;
	    }
	    else{
	        $data['languages'] = $this->Language_model->get_all_language();
	        $json = json_encode($data['languages']);
	        $file = FCPATH . '/software_files/Language.txt';
	        file_put_contents ($file, $json);
	    }
	    
	    $data['head'] = $this->load->view('admin/comman/head','',TRUE);
	    $data['header'] = $this->load->view('admin/comman/header','',TRUE);
	    $data['navigation'] = $this->load->view('admin/comman/navigation','',TRUE);
	    $data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
	    $data['main_contant'] = $this->load->view('admin/pages/heading/heading',$data,TRUE);
	    $this->load->view('admin/comman/index',$data);
	}
	
	public function allList(){
	    $this->db->select('id, heading');
	    $this->db->order_by('id','DESC');
	    $result = $this->db->get_where('heading', array('status'=>1))->result_array();
	    if(count($result) > 0){
	        echo json_encode(array('result'=>$result, 'status'=>200));
	    }else{
	        echo json_encode(array('status'=>500));
	    }
	}
	
	public function delete(){
	    $id = $this->input->post('delete_id');
	    $this->db->trans_begin();
	    $this->db->where('id', $id);
	    $this->db->update('heading', array('status'=>0));
	    
	    $this->db->where('heading_id', $id);
	    $this->db->update('heading_item', array('status'=>0));
	    if ($this->db->trans_status() === FALSE)
	    {
	        $this->db->trans_rollback();
	    }
	    else
	    {
	        $this->db->trans_commit();
	        echo json_encode(array('status'=>200));
	    }
	}
	
	
	public function insert(){
	    $data = $this->input->post();
	    $data['created_by'] = $this->session->userdata('user_id');
	    $date = $date = date('Y-m-d H:i:s');
	    $data['created_at'] = $date;
	    
	    $this->db->trans_begin();
	    //---------insert headng---------------------------------
	    $this->db->insert('heading', $data);
	   
	    //-----insert heading item table-------------------------
	    $data1['heading_id'] = $this->db->insert_id();
 	    $data1['heading_item'] = $this->input->post('heading');
	    $data1['language_id']= $this->session->userdata('language');
	    $data1['created_by'] = $this->session->userdata('user_id');
	    $date = $date = date('Y-m-d H:i:s');
	    $data1['created_at'] = $date;
	    $this->db->insert('heading_item', $data1);
	   
	    //------------------------------------------------------
	    if ($this->db->trans_status() === FALSE)
	    {
	        $this->db->trans_rollback();
	    }
	    else
	    {
	        $this->db->trans_commit();
	        echo json_encode(array('msg'=>'Insert Successfully', 'status'=>200));
	    }
	
	}
	
	public function update(){
	    $id = $this->input->post('id');
	    $data['heading'] = $this->input->post('heading');
	    $data['updated_by'] = $this->session->userdata('user_id');
	    $date = $date = date('Y-m-d H:i:s');
	    $data['updated_at'] = $date;
	    
	    $this->db->trans_begin();
	    //--------update heading table----------------
	    $this->db->where('id', $id);
	    $this->db->update('heading', $data);
	    
	    //--------update heading item table-----------
	    $data1['heading_item'] = $this->input->post('heading');
	    $data1['language_id']= $this->session->userdata('language');
	    $data1['updated_by'] = $this->session->userdata('user_id');
	    $date = $date = date('Y-m-d H:i:s');
	    $data1['updated_at'] = $date;
	    
	    $this->db->where('heading_id', $id);	
	    $this->db->update('heading_item', $data1);
	    
	    if ($this->db->trans_status() === FALSE)
	    {
	        $this->db->trans_rollback();
	    }
	    else
	    {
	        $this->db->trans_commit();
	        echo json_encode(array('msg'=>'Update Successfully', 'status'=>200));
	    }
	}
	
	
	public function headingItemList(){
	    $language_id = $this->session->userdata('language');
	    
	    $this->db->select('h.*,hi.heading_item as heading_item');
	    $this->db->join('heading_item hi','hi.heading_id = h.id AND hi.language_id ='.$language_id, 'left');
	    $result = $this->db->get_where('heading h',array('h.status'=>1))->result_array();
	    
	    if(count($result) > 0){
	        echo json_encode(array('result'=>$result, 'status'=>200));
	    }else{
	        echo json_encode(array('status'=>500));
	    }
	}
	
	public function insert_heading_item(){
	    
	    $this->db->trans_begin();
	    $temp_data = $this->input->post();
	    $language_id = $this->session->userdata('language');
	    $cre_a_up_by = $this->session->userdata('user_id');
	    $date = $date = date('Y-m-d H:i:s');
	    $cre_a_up_at = $date;
	    
	    foreach($temp_data['data'] as $data){
	        $this->db->select('*');
	        $result = $this->db->get_where('heading_item',array(
	            'heading_id'=>$data['heading_id'],
	            'language_id' => $language_id,
	            'status'=> 1
	        ))->result_array();
	        
	        if(count($result) > 0){
	            foreach($result as $res){
	            $val1 = array();
	            $val1['heading_item'] = $data['heading_item'];
	            $val1['language_id'] = $language_id;
	            $val1['updated_by'] = $cre_a_up_by;
	            $val1['updated_at'] = $cre_a_up_at;
	            
	            $this->db->where('id', $res['id']);
	            $this->db->where('heading_id', $res['heading_id']);
	            $this->db->update('heading_item', $val1);
	          }
	        }
	        else{ 
	            $val = array();
	            $val['heading_id'] = $data['heading_id'];
	            $val['heading_item'] = $data['heading_item'];
	            $val['language_id'] = $language_id;
	            $val['created_by'] = $cre_a_up_by;
	            $val['created_at'] = $cre_a_up_at;
	            $this->db->insert('heading_item',$val);  
	        }
	    }
	    
	    if ($this->db->trans_status() === FALSE)
	    {
	        $this->db->trans_rollback();
	    }
	    else
	    {
	        $this->db->trans_commit();
	        echo json_encode(array('msg'=>'Process Successfully', 'status'=>200));
	    }
	
	}//end of function//////////////
		
}//end of class//////////////