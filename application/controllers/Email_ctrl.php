<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->database();
	}
	
	function contact_mail_1(){ 
	$data['email'] = $this->input->post('email');
        $data['co_us_desc'] = $this->input->post('contact_desc');
        $data['mail_opt'] = $this->input->post('mail_opt');
        $data['con_us_name'] = $this->input->post('con_us_name');
        $data['con_us_contact'] = $this->input->post('con_us_contact');
        $data['con_us_add'] =  $this->input->post('con_us_add');
        $data['con_us_stak'] = $this->input->post('con_us_stak');
	
        $message = $this->load->view('pages/email',$data,true);

//print_r($message); die;
	
	$config = Array(
 // 'protocol' => 'smtp',
 // 'smtp_host' => 'ssl://smtp.googlemail.com',
 // 'smtp_port' => 465,
  //'smtp_user' => 'viveka1301@gmail.com', 
  //'smtp_pass' => '13011995', 
  'mailtype' => 'html',
  'charset' => 'iso-8859-1',
  'wordwrap' => TRUE
);

       // echo $email; die;
        $this->load->library('email', $config);
      //$this->email->set_newline("\r\n");
      //$this->email->from('viveka1301@gmail.com'); 
      //if($data['con_us_name']== 'Generals'){
       //  $this->email->to($data['email']);
      // }
      // else{
       //  $this->email->to($data['email']); 
      // }
     // //$this->email->to('vivekgangber190@gmail.com');
     // $this->email->subject('eNAM mail');
     // $this->email->message($message);
      //if($this->email->send())
     //{
		
     // echo 'Email sent.';
    // }
     //else
   // {
    // show_error($this->email->print_debugger());
   // }
		
		
		$this->email->from('viveka1301@gmail.com');
        $this->email->to($data['email']);
        $this->email->set_mailtype("html");
        $this->email->subject('eNAM Mail');
        $this->email->message($message);
        $this->email->send();
		
		if($this->email->send())
     {
		echo json_encode(array('msg'=>'Email Sent Successfull','status'=>200));
     echo 'Email sent.';
    }
     else
   {
	   echo json_encode(array('msg'=>'Something gone wrong.','status'=>500));
    show_error($this->email->print_debugger());
   }
	}
   

          function contact_mail(){
             $this->load->library('email');

$to = "vivekgangber190@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: viveka1301@gmail.com" . "\r\n" .
"CC: somebodyelse@example.com";

mail($to,$subject,$txt,$headers);
if($this->email->send())
     {
		echo json_encode(array('msg'=>'Email Sent Successfull','status'=>200));
     echo 'Email sent.';
    }
     else
   {
	   echo json_encode(array('msg'=>'Something gone wrong.','status'=>500));
    show_error($this->email->print_debugger());
   }
          }





		function email(){
		$data['title'] = 'eNam';
		$data['keywords'] = 'enam home';
		$data['head'] = $this->load->view('comman/head',$data,TRUE);

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

		$data['header'] = $this->load->view('comman/header',$data,TRUE);
		$data['menus'] = $this->Enam_model->all_menus();

		$data['navigation'] = $this->load->view('comman/navigation',$data,TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);

		$file_menu = json_decode(file_get_contents(FCPATH . '/software_files/Slider_client.txt'),true);
		if(count($file_menu)){
			$data['sliders'] = $file_menu;
		}
		else{
			$data['sliders'] = $this->Slider_model->slider_list_client();
			$json = json_encode($data['sliders']);
			$file = FCPATH . '/software_files/Slider_client.txt';
			file_put_contents ($file, $json);
		}
		$data['videos'] = $this->Video_model->video_home_page_list();
//print_r($data['videos']); die;

		$v = array();
		foreach($data['videos'] as $ve){
			$temp = array();
			$temp = $ve;
			$temp['created_at'] = $this->time_elapsed_string(strtotime($ve['created_at']));
			$v[] = $temp;
		}
		$data['videos'] = $v;

		$data['home_body'] = $this->Widget_model->home_content(); 	
		$data['newses'] = $this->Enam_model->all_news();
		$data['events'] = $this->Event_model->home_list_events();
		$data['links'] = $this->Enam_model->all_links();
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks',$data,TRUE);
		//$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['slider'] = $this->load->view('pages/comman/slider',$data,TRUE);
		$data['links'] = $this->Enam_model->all_links();
		//$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['main_contant'] = $this->load->view('pages/email',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
}
?>