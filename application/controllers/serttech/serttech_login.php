<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Serttech_login extends General{

	function __construct(){
		parent::__construct();	
		//$this->load->model('login_model');
		$this->load->model('serttech/serttech_login_model');
		$this->load->model('general_model');
		//$this->load->model('app/roles_model');
		General::variable();
	}
	
	public function index(){

	$this->login();

	}
	
	function login(){
		ob_start();
		//Get the ipconfig details using system commond
		system('ipconfig /all');
		// Capture the output into a variable
		$mycom=ob_get_contents();
		// Clean (erase) the output buffer
		ob_clean();
		$findme = "Physical";
		//Search the "Physical" | Find the position of Physical text
		$pmac = strpos($mycom, $findme);
		// Get Physical Address
		$mac=substr($mycom,($pmac+36),17);
		//Display Mac Address
		// echo $mac;
		$this->data['nbd'] = $mac;
		
		$this->data['get_nbd'] = $this->general_model->get_nbd();
		$this->load->view("serttech/index",$this->data);		
	}
	
	function validate_credentials(){
		if($this->serttech_login_model->validate_nbd()){
			return true;	
		}else{
			$this->form_validation->set_message("validate_credentials","Invalid Login Credentials");
			return false;
		}
	}
	//|callback_validate_credentials
	public function validate_login(){
		$this->form_validation->set_rules("username","Username","trim|required");	
		$this->form_validation->set_rules("password","Password","trim|required");	
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){
			 
			 $user_info = $this->serttech_login_model->getUserLoggedIn($this->input->post('username'));
			 //$user_info = $this->serttech_login_model->validate_nbd();
			
			 if ($user_info)
			 {
				$this->data = $this->session->set_userdata(array(
	                    'username'          		=>          $user_info->username,
	                    'is_serttech_logged_in'     =>          true,
						'picture'					=>			$user_info->picture
	             ));  
				//$this->myhome();
				redirect(base_url().'serttech/serttech_login/myhome',$this->data);			
			 }

        }else{
        	
           redirect(base_url().'serttech/serttech_login/login/');  
        }
	}

	public function myhome(){

		if($this->session->userdata('is_serttech_logged_in')){ // if ang nakalogin account ni serttech for system management

			$this->data['serttech_account'] = $this->serttech_login_model->getUserLoggedIn($this->input->post('username'));
			$this->data['message'] = $this->session->flashdata('message');	
			$this->data['my_emp_license'] = $this->serttech_login_model->getMyEmployeeLicense();
			$this->load->view('serttech/home',$this->data);	

		}else if  ($this->session->userdata('is_applicant')) { // if ang nakalogin account ni applicant
			redirect(base_url().'app/application_form/dashboard');
		}else if  ($this->session->userdata('is_logged_in')) { // if ang nakalogin account ni MyHRIS Admin
			redirect(base_url().'app/dashboard');
		}
		else{
			redirect(base_url().'serttech/serttech_login/login/');
		}  
				
	}


	public function employee_license(){
		$this->form_validation->set_rules("employee_license","Employee License","trim|required");	
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){
			 
			$this->serttech_login_model->save_employee_license();
			$value=$this->input->post('employee_license');

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee License is Successfully Updated to <strong>".$value."</strong> </div>");

			$this->myhome();   	

	
        }else{
        	
            $this->login();        
        }
	}

	public function company_license(){
		$this->form_validation->set_rules("company_license","Employee License","trim|required");	
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){
			 
			$this->serttech_login_model->save_company_license();
			$value=$this->input->post('company_license');

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee License is Successfully Updated to <strong>".$value."</strong> </div>");

			$this->myhome();   	

	
        }else{
        	
            $this->login();        
        }
	}
	public function serttech_account(){
		$this->form_validation->set_rules("username","Username","trim|required");	
		$this->form_validation->set_rules("password","Password","trim|required");	
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){
			 
			$this->serttech_login_model->save_serttech_account();
			//$value=$this->input->post('employee_license');

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Serttech Account is successfully updated  </div>");

			redirect(base_url().'serttech/serttech_login/myhome',$this->data);  	

	
        }else{
        	
            $this->myhome();      
        }
	}
	public function disable_feature(){

		$pm = $this->uri->segment("4");
		$page_module=urldecode($pm);

		//$this->serttech_login_model->disable_feature($page_module);

		$this->db->query("update pages set InActive='1' where page_module = '".$page_module."' ");

		// logfile
		$value = $page_module;

		General::logfile('Module Dropdown','DISABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Disabled!</div>");

		redirect(base_url().'serttech/serttech_login/myhome',$this->data);
	}
	
	public function enable_feature(){

		$pm = $this->uri->segment("4");
		$page_module=urldecode($pm);

		//$this->serttech_login_model->disable_feature($page_module);

		$this->db->query("update pages set InActive='0' where page_module = '".$page_module."' ");

		// logfile
		$value = $page_module;

		General::logfile('Module Dropdown','DISABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Enabled!</div>");

		redirect(base_url().'serttech/serttech_login/myhome',$this->data);
	}
	
	public function logout(){
        $this->session->unset_userdata(array(
                'username'          =>      '',
                'is_serttech_logged_in'      =>      false,
				'employee_id'		=>		''
        ));
        $this->session->sess_destroy();    
        redirect(base_url().'login');
    }
	
}













