<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->library(array('session','ion_auth'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/Users_model','admin/Widget_model','admin/Page_model','admin/News_model','admin/Slider_model','admin/Video_model','admin/Links_model'));
		$this->lang->load('admin_lang', 'english');
		if (!$this->ion_auth->logged_in()){
			redirect('admin/admin');
		}
	}
	
	function all_pages(){
		$data['title'] = ' pages';
		$data['pages'] = $this->Page_model->get_all_pages();
		$data['head'] = $this->load->view('admin/comman/head',$data,TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/layout/all_pages',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	function index($p_id = null){
		if($p_id != null){
			$data['page_id'] = $p_id;
			$data['title'] = 'Update Page';
			
			$Widgets = json_decode(file_get_contents(FCPATH . '/software_files/Widgets.txt'),true);
			if(count($Widgets)){
				$data['widgets'] = $Widgets;
			}
			else{
				$data['widgets'] = $this->Widget_model->all_widgets();
				$json = json_encode($data['widgets']);
				$file = FCPATH . '/software_files/Widgets.txt';
				file_put_contents ($file, $json);
			}
// 			print_r($data['widgets']); die;
			$Newses = json_decode(file_get_contents(FCPATH . '/software_files/News.txt'),true);
			if(count($Newses)){
				$data['News'] = $Newses;
			}
			else{
				$data['Newses'] = $this->News_model->news_list();
				$json = json_encode($data['Newses']);
				$file = FCPATH . '/software_files/News.txt';
				file_put_contents ($file, $json);
			}
				
			$this->db->select('p.*,pi.meta_tag,pi.keywords,pi.page_body,pi.title as page_name');
			$this->db->join('page_item pi','pi.page_id = p.p_id');
			$result = $this->db->get_Where('pages p',array('p.p_id'=>(int)$data['page_id'],'p.status'=>1,'pi.status'=>1,'pi.lang_id'=>(int)$this->session->userdata('language')))->result_array();
			
			
			if(count($result)>0){
				$data['page_details'] = $result;
			}
			else{
				$this->db->select('p.*,pi.meta_tag,pi.keywords,pi.page_body,pi.title as page_name');
				$this->db->join('page_item pi','pi.page_id = p.p_id');
				$result = $this->db->get_Where('pages p',array('p.p_id'=>(int)$data['page_id'],'p.status'=>1,'pi.status'=>1,'pi.lang_id'=>1))->result_array();
								
				$data['page_details'] = $result;
			}
			
			$data['head'] = $this->load->view('admin/comman/head',$data,TRUE);
			$data['header'] = $this->load->view('admin/comman/header','',TRUE);
			$data['navigation'] = $this->load->view('admin/comman/navigation','',TRUE);
			$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
			$data['main_contant'] = $this->load->view('admin/pages/layout/add_page',$data,TRUE);
			$this->load->view('admin/comman/index',$data);
		}
		else{
			$data['title'] = 'create New Page';
			$Widgets = json_decode(file_get_contents(FCPATH . '/software_files/Widgets.txt'),true);
			if(count($Widgets)){
				$data['widgets'] = $Widgets;
			}
			else{
				$data['widgets'] = $this->Widget_model->all_widgets();
				$json = json_encode($data['widgets']);
				$file = FCPATH . '/software_files/Widgets.txt';
				file_put_contents ($file, $json);
			}
			
// 			$Newses = json_decode(file_get_contents(FCPATH . '/software_files/News.txt'),true);
// 			if(count($News)){
// 				$data['News'] = $Newses;
// 			}
// 			else{
// 				$data['Newses'] = $this->News_model->news_list();
// 				$json = json_encode($data['Newses']);
// 				$file = FCPATH . '/software_files/News.txt';
// 				file_put_contents ($file, $json);
// 			}
				
			
			
			$data['head'] = $this->load->view('admin/comman/head',$data,TRUE);
			$data['header'] = $this->load->view('admin/comman/header','',TRUE);
			$data['navigation'] = $this->load->view('admin/comman/navigation','',TRUE);
			$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
			$data['main_contant'] = $this->load->view('admin/pages/layout/add_page',$data,TRUE);
			$this->load->view('admin/comman/index',$data);
		}
	}
	
	function page_create(){
			$data['page_id'] = (int)$this->input->post('page_id');
			if($data['page_id'] == ''){
				// new page create
				$this->db->trans_begin();
				$data['page_name'] = $this->input->post('page_name');
				$data['page_layout'] = $this->input->post('page_layout');
				$data['meta_tag'] = $this->input->post('meta_tag');
				$data['keyword'] = $this->input->post('keyword');
				$data['page_body'] = $this->input->post('page_body',false);
				if($data['page_layout'] == 1){
					$data['component'] = $this->input->post('one_col_maincontent');
				}
				else if($data['page_layout'] == 2){
					$data['left_component'] = $this->input->post('two_col_leftcontent');
					$data['component'] = $this->input->post('two_col_maincontent');
				}
				else {
					$data['left_component'] = $this->input->post('three_col_leftcontent');
					$data['component'] = $this->input->post('three_col_maincontent');
					$data['right_component'] = $this->input->post('three_col_rightcontent');
				}
				
				$this->db->insert('pages',array(
						'page_name' => $data['page_name'],
						'page_layout' => $data['page_layout'],
						'created_at' => date('y-m-d h:i:s'),
						'created_by' => $this->session->userdata('user_id')
				));
				
				$page_id = $this->db->insert_id();
					
				$bulk_data = array();
				if(isset($data['left_component'])){
					foreach($data['left_component'] as  $left){
						$temp = array();
						$temp['page_id'] = $page_id;
						$temp['section'] = 'left_col';
						$temp['widget_id'] = $left;
						$bulk_data[] = $temp;
					}
				}
				
				if(isset($data['component'])){
					foreach($data['component'] as $component){
						$temp = array();
						$temp['page_id'] = $page_id;
						$temp['section'] = 'main_body';
						$temp['widget_id'] = $component;
						$bulk_data[] = $temp;
					}
				}
					
				if(isset($data['right_component'])){
					foreach($data['right_component'] as $right_component){
						$temp = array();
						$temp['page_id'] = $page_id;
						$temp['section'] = 'right_col';
						$temp['widget_id'] = $right_component;
						$bulk_data[] = $temp;
					}
				}
				if(isset($bulk_data) && count($bulk_data)>0 ){
					$this->db->insert_batch('page_components',$bulk_data);
				}
				
				$this->db->insert('page_item',array(
						'lang_id' => $this->session->userdata('language'),
						'page_id' => $page_id,
						'title'  => $data['page_name'],
						'meta_tag' => $data['meta_tag'],
						'keywords' => $data['keyword'],
						'page_body' => $data['page_body'],
						'created_at' => date('y-m-d h:i:s'),
						'created_by' => $this->session->userdata('user_id'),
						'ip'	=> $this->input->ip_address()
				));
// 				print_r($this->db->last_query()); die;	
				if ($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					echo json_encode(array('msg'=>'Page not created successfully.','status'=>500));
				}
				else {
					$this->db->trans_commit();
					echo json_encode(array('msg'=>'Page created successfully.','status'=>200));
				}
				
			}
			else {
				// page update
				$this->db->trans_begin();
				$data['page_id'] = (int)$this->input->post('page_id');
				$data['page_name'] = $this->input->post('page_name');
				$data['page_layout'] = $this->input->post('page_layout');
				$data['meta_tag'] = $this->input->post('meta_tag');
				$data['keyword'] = $this->input->post('keyword');
				$data['page_body'] = $this->input->post('page_body',false);
				
				if($data['page_layout'] == 1){
					$data['component'] = $this->input->post('one_col_maincontent');
				}
				else if($data['page_layout'] == 2){
					$data['left_component'] = $this->input->post('two_col_leftcontent');
					$data['component'] = $this->input->post('two_col_maincontent');
				}
				else {
					$data['left_component'] = $this->input->post('three_col_leftcontent');
					$data['component'] = $this->input->post('three_col_maincontent');
					$data['right_component'] = $this->input->post('three_col_rightcontent');
				}
				
				$result = $this->db->get_where('page_item',array('page_id'=>$data['page_id'],'lang_id'=>$this->session->userdata('language'),'status'=>1))->result_array();
				
				if(count($result)>0){
					$this->db->where('id',$result[0]['id']);
					$this->db->update('page_item',array(
						'lang_id' => $this->session->userdata('language'),
						'page_id' => $data['page_id'],
						'title' => $data['page_name'],
						'meta_tag' => $data['meta_tag'],
						'keywords' => $data['keyword'],
						'page_body' => $data['page_body']
					));
				}
				else{
					$this->db->insert('page_item',array(
							'lang_id' => $this->session->userdata('language'),
							'page_id' => $data['page_id'],
							'title' => $data['page_name'],
							'meta_tag' => $data['meta_tag'],
							'keywords' => $data['keyword'],
							'page_body' => $data['page_body'],
							'created_at' => date('y-m-d h:i:s'),
							'created_by' => $this->session->userdata('user_id')
					));
					
				}
				
				$this->db->where('p_id',$data['page_id']);
				if($this->ion_auth->is_admin()){
					$this->db->update('pages',array(
						//'page_name' => $data['page_name'],
						'page_layout' => $data['page_layout'],
						'updated_at' => date('y-m-d h:i:s'),
						'updated_by' => $this->session->userdata('user_id')
					));
				}
				else{
					$this->db->update('pages',array(
						//'page_name' => $data['page_name'],
						//'page_layout' => $data['page_layout'],
						'updated_at' => date('y-m-d h:i:s'),
						'updated_by' => $this->session->userdata('user_id')
					));
				}
				
				if($this->ion_auth->is_admin()){
					$this->db->update('pages',array(
							//'page_name' => $data['page_name'],
							'page_layout' => $data['page_layout'],
							'updated_at' => date('y-m-d h:i:s'),
							'updated_by' => $this->session->userdata('user_id')
					));
				}
				else{
					$this->db->update('pages',array(
							//'page_name' => $data['page_name'],
							//'page_layout' => $data['page_layout'],
							'updated_at' => date('y-m-d h:i:s'),
							'updated_by' => $this->session->userdata('user_id')
					));
				}
				
				$this->db->where('page_id',$data['page_id']);
				$this->db->update('page_components',array('status'=>0));
					
				$bulk_data = array();
				if(isset($data['left_component'])){
					foreach($data['left_component'] as  $left){
						$temp = array();
						$temp['page_id'] = $data['page_id'];
						$temp['section'] = 'left_col';
						$temp['widget_id'] = $left;
						$bulk_data[] = $temp;
					}
				}
				
				if(isset($data['component'])){
					foreach($data['component'] as $component){
						$temp = array();
						$temp['page_id'] = $data['page_id'];
						$temp['section'] = 'main_body';
						$temp['widget_id'] = $component;
						$bulk_data[] = $temp;
					}
				}
					
				if(isset($data['right_component'])){
					foreach($data['right_component'] as $right_component){
						$temp = array();
						$temp['page_id'] = $data['page_id'];
						$temp['section'] = 'right_col';
						$temp['widget_id'] = $right_component;
						$bulk_data[] = $temp;
					}
				}
				if(isset($bulk_data) && count($bulk_data)>0){
					$this->db->insert_batch('page_components',$bulk_data);
				}
					
				$this->db->where(array('page_id'=>$data['page_id'],'lang_id'=>$this->session->userdata('language')));
				$this->db->update('page_item',array(
						'title'  => $data['page_name'],
						'meta_tag' => $data['meta_tag'],
						'keywords' => $data['keyword'],
						'updated_at' => date('y-m-d h:i:s'),
						'updated_by' => $this->session->userdata('user_id'),
						'ip'	=> $this->input->ip_address()
				));
				
				if ($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					echo json_encode(array('msg'=>'Page not updated successfully.','status'=>500)); 
				}
				else{
					$this->db->trans_commit();
					echo json_encode(array('msg'=>'Page updated Successfully.','status'=>200));
				}
			}
			
		}
		
		
	}
