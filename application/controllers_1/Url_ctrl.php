<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Url_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/Users_model','admin/Slider_model','admin/Widget_model','admin/News_model','Enam_model','admin/Event_model'));
		$this->load->library(array('session'));
		if(!$this->session->userdata('client_language')){
			$newdata = array(
					'client_language'  => '1',
					'lang_folder' => 'english'
			);
			$this->session->set_userdata($newdata);
		}
		//////////////temp/////////////////////////
		if($this->session->userdata('client_language') == 1)
			$this->lang->load('client_lang', 'english');
			else
				$this->lang->load('client_lang', 'hindi');
	}
	
	function index(){
		if($this->session->userdata('client_language') == ''){
			$client_laguage = 1;
		}
		else{
			$client_laguage = $this->session->userdata('client_language');
		}
		
		$c = 1;
		$url_array ='';
		while($this->uri->segment($c) != ''){
			$url_array.= $this->uri->segment($c).'/'; 
			$c = $c + 1;	
		}
		$url_array = strtolower(rtrim($url_array,"/ "));
		
		$this->db->select('m.page_id');
		$this->db->join('pages p','p.p_id = m.page_id');
		$this->db->limit('1');
		$result = $this->db->get_Where('menu m',array('m.cms_url'=>$url_array,'m.status'=>1,'p.status'=>1,'p.publish'=>1,'m.external_link'=>0))->result_array();
		
		if(count($result)>0){
			$this->db->select('*');
			$page_body = $this->db->get_Where('page_item',array('page_id'=>$result[0]['page_id'],'lang_id'=>(int)$client_laguage,'status'=>1))->result_array();
			if(empty($page_body)){
				echo "Sorry! Page content is not converted in this language";
				die;
			}

			$this->db->select('p.page_name,p.page_layout,pc.section,w.name,wi.content,pc.widget_id');
			$this->db->join('page_components pc','(pc.page_id = p.p_id AND pc.status = 1)');
			$this->db->join('widgets w','(w.w_id = pc.widget_id AND w.status = 1)','left');
			$this->db->join('widget_item wi','(wi.widget_id = w.w_id AND wi.status = 1 AND wi.lang_id = '.(int)$client_laguage.')','left');
			$page_component = $this->db->get_where('pages p',array(
					'p.p_id'=>(int)$result[0]['page_id'],
					'p.status' => 1					
			))->result_array();
			
			if(count($page_component)>0){
				$i = 1;
				foreach ($page_component as $pc){
					$page_body[0]['col'][$i] = $pc;
					$i++;
				}
			}
			
			$this->db->select('*');
			$page_detail = $this->db->get_where('pages',array('p_id'=>(int)$result[0]['page_id'],'publish'=>1,'status'=>1))->result_array();
			$page_body[0]['page_layout'] = $page_detail[0]['page_layout'];
			
			$data['page_contents'] = $page_body;
			if(count($data['page_contents']) > 0){	
				////////////////////////////////////
				$str = html_entity_decode($data['page_contents'][0]['page_body']);


				$regex = "/\[(.*?)\]/";
				$data['output'] = $str;
				preg_match_all($regex, $str, $matches);
if(count($matches[1])){
				for($i =0; $i < count($matches[1]); $i++){
					$match = $matches[1][$i];
					$x = explode(':',$match);
					
					if($x[1] == 'krimtel'){
						$data['output'] = str_replace($matches[0][$i],$this->page_render($x[2]),$data['output']);
					}
					else { 
						$data['output'] = str_replace($matches[0][$i],$this->component_render($x[2]),$data['output']);
					}
				}
}
				////////////////////////////////////
				//main logic
				$file_menu = json_decode(file_get_contents(base_url().'software_files/Language.txt'),true);
				if(count($file_menu)){
					$data['languages'] = $file_menu;
				}
				else{
					$data['languages'] = $this->Language_model->get_all_language();
					$json = json_encode($data['languages']);
					$file = FCPATH . '/software_files/Language.txt';
					file_put_contents ($file, $json);
				}
				////-----all widget pages---------------////
				$file_menu = json_decode(file_get_contents(base_url().'software_files/News.txt'),true);
				if(count($file_menu)){
					$data['newses'] = $file_menu;
				}
				else{
					$data['newses'] = $this->News_model->News_list();                                 
					$json = json_encode($data['newses']);
					$file = FCPATH . '/software_files/News.txt';
					file_put_contents ($file, $json, FILE_APPEND);
				}
				$data['news_page'] = $this->load->view('comman/home_notice',$data,TRUE);

				$file_menu = json_decode(file_get_contents(base_url(). 'software_files/Links.txt'),true);
				if(count($file_menu)){
					$data['links'] = $file_menu;
				}
				else{
					$data['links'] = $this->Enam_model->all_links();
					$json = json_encode($data['links']);
					$file = FCPATH . '/software_files/Links.txt';
					file_put_contents ($file, $json, FILE_APPEND);
				}
				$data['quickLinks_page'] = $this->load->view('pages/comman/quickLinks',$data,TRUE);
				
				
				$file_menu = json_decode(file_get_contents(base_url().'software_files/Slider_client.txt'),true);
				if(count($file_menu)){
					$data['sliders'] = $file_menu;
				}
				else{
					$data['sliders'] = $this->Slider_model->slider_list_client();
					$json = json_encode($data['sliders']);
					$file = FCPATH . '/software_files/Slider_client.txt';
					file_put_contents ($file, $json);
				}
				$data['slider_page'] = $this->load->view('pages/comman/slider',$data,TRUE);
				////------------------------------------////
				
				$data['page_layout'] = $page_body[0]['page_layout'];				
				$data['page_title'] = $page_body[0]['title'];
				$data['keywords'] = $page_body[0]['keywords'];
				$data['title'] = 'eNam | '.$page_body[0]['title'].' | '.$data['keywords'];
				$data['head'] = $this->load->view('comman/head',$data,TRUE);
				$data['header'] = $this->load->view('comman/header',$data,TRUE);
				$data['menus'] = $this->Enam_model->all_menus();
				$data['navigation'] = $this->load->view('comman/navigation',$data,TRUE);
				$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
				$data['footer'] = $this->load->view('comman/footer','',TRUE);
				$data['slider'] = $this->load->view('pages/comman/slider','',TRUE);
				$data['links'] = $this->Enam_model->all_links();
				$data['quickLinks'] = $this->load->view('pages/comman/quickLinks',$data,TRUE);
				$data['newses'] = $this->Enam_model->all_news();
				$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
				$data['events'] = $this->Event_model->home_list_events();
				$data['main_contant'] = $this->load->view('pages/layout-page',$data,TRUE);
				$this->load->view('comman/index',$data);
			}
			else{
				echo "no record found";
			}
		}
		else{
			$this->load->view('error');
		}
	}
	
	function page_render($str){
		if($str == 'news'){
			$file_menu = json_decode(file_get_contents(FCPATH . '/software_files/News.txt'),true);
			if(count($file_menu)){
				$data['newses'] = $file_menu;
			}
			else{
				$data['newses'] = $this->News_model->News_list();
				$json = json_encode($data['newses']);
				$file = FCPATH . '/software_files/News.txt';
				file_put_contents ($file, $json, FILE_APPEND);
			}
			$str = $this->load->view('comman/home_notice',$data,TRUE);
		}
		return $str;
	}
	
	function component_render($str){
		if($this->session->userdata('client_language')){
			$language =  $this->session->userdata('client_language');
		}
		else{
			$language = 1;
		}
		$this->db->select('wi.w_title,wi.content');
		$this->db->join('widget_item wi','wi.widget_id = w.w_id');
		$this->db->join('languages l','l.l_id = wi.lang_id');
		$result = $this->db->get_where('widgets w',array('w.status'=>1,'w.name'=>$str,'wi.lang_id'=>$language,'wi.status'=>1))->result_array();
		
		$str = '<div class="mid-top-space natinal-agricul-market pad">';
		$str.='<h3 class="events-title"><span>'.$result[0]['w_title'].'</span></h3>';
		$str.='<div class="commodity-list">';
		$str.='<div class="box_cont">';  
		$str.='<div style="text-align:justify">';
		$str.= $result[0]['content'];
		$str.='</div>';
		$str.='</div>';
		$str.='</div>';
		$str.='</div>';
		return $str; 
	}
}
