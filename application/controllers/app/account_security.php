<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Account_security extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/account_security_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/employee/account_security/account_security',$this->data);	
	}

	public function view_all(){

		$this->load->view('app/employee/account_security/view_all', $this->data);
	}

	public function view_account_per_company(){
		$company_id = $this->uri->segment('4');
		$this->data['users'] = $this->account_security_model->view_all($company_id);
		$this->load->view('app/employee/account_security/view_accounts', $this->data);
	}

	public function change_password(){

		$data['id'] = $this->uri->segment("4");
		$data['info'] = $this->account_security_model->get_emp_pass($data);
		$this->load->view('app/employee/account_security/edit_password', $data);
	}

	public function export_to_excel(){

		$company_id = $this->uri->segment('4');
		$query = $this->account_security_model->view_all($company_id);
		$this->load->helper('download');
		$this->table->set_heading(
				'EMP ID',
				'Last Name',
				'First Name',
				'Location',
				'Username',
				'Password',
				'Status',
				'Date Change Password'
				);

		foreach ($query as $users)
		{
			if($users->InActive == 0){
            	$status = "Active";
            }
           else{
            	$status = "InActive";
            }

			$this->table->add_row( 
				$users->employee_id,
				$users->last_name,
				$users->first_name,
				$users->location_name,
				$users->username,
				$users->password,
				$status,
				$users->passChangeDate
			); 

		}

		$data['table'] = $this->table->generate();
		force_download('users.xls',$data['table']);

	}

	public function edit_password(){
		$this->form_validation->set_rules("password", "New Password", "trim|required");
		$this->form_validation->set_rules("confirm_password", "Confirm Password", "required|matches[password]");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			$this->account_security_model->edit_password($id);

			// logfile
			 $pass = $this->input->post('password');
			 $username= $this->input->post('username');
			 $value = $username.' = '.$pass;
			 General::logfile('Password','MODIFY', $value);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Password for <strong>".$username."</strong> is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"view_all()");
			redirect(base_url().'app/account_security/index');
		}
		else{
			$this->session->set_flashdata('onload',"view_all()");
			$this->index();
		}

	}
}