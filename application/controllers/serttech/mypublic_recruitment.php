<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Mypublic_recruitment extends General{

	function __construct(){
		parent::__construct();	
		//$this->load->model('login_model');
		$this->load->model('serttech/serttech_login_model');
		$this->load->model('general_model');
		$this->load->model('recruitment_employer/recruitment_employer_model');
		$this->load->model('app/recruitment_model');
		//$this->load->model('app/roles_model');
		General::variable();
	}
	
	public function index(){

		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['serttech_account'] = $this->serttech_login_model->getUserLoggedIn($this->input->post('username'));
		$this->load->view('serttech/package_mng',$this->data);	
	}
	public function registered_employers(){
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['serttech_account'] = $this->serttech_login_model->getUserLoggedIn($this->input->post('username'));
		$this->load->view('serttech/reg_employers',$this->data);	
	}
	public function job_mng(){
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['serttech_account'] = $this->serttech_login_model->getUserLoggedIn($this->input->post('username'));
		$this->load->view('serttech/job_mng',$this->data);	
	}
	
	public function edit_bill(){
		$id= $this->uri->segment("4");
		$this->data['bill'] = $this->general_model->spec_bill($id);
		$this->load->view('serttech/edit_bill',$this->data);
	}
	public function view_company_jobs(){

		 $this->load->view('serttech/comp_jobs',$this->data);
	}
	public function add_bill(){

		$this->load->view('serttech/add_bill',$this->data);
	}
	public function modify_bill(){
		$this->form_validation->set_rules("customer_type","Customer Type","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");
			$bill = $this->general_model->spec_bill($id);

			// save data
			$this->serttech_login_model->modify_bill($id);

			// logfile
			$value = $id;
			General::logfile('Bill','MODIFY',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Package, <strong>".$value."</strong>, is Successfully Modified </div>");

			redirect(base_url().'serttech/mypublic_recruitment/index',$this->data);
		}else{

			$this->index();
		}
	}
	public function save_bill(){
		$this->form_validation->set_rules("customer_type","Customer Type","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

	
			// save data
			$this->serttech_login_model->save_bill();

			// logfile
			$value = "Add New";
			General::logfile('Bill Package','Add',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> New Package, <strong>".$value."</strong>, is Successfully Added </div>");

			redirect(base_url().'serttech/mypublic_recruitment/index',$this->data);
		}else{

			$this->index();
		}
	}
	public function approve_all_c(){

		$this->db->query("update jobs set admin_verified='1' where 1");
			
		// logfile
		$value = "all company";

		General::logfile('Job Posting','Approved',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Successfully Approve All Job Posting of All companies!</div>");

		redirect(base_url().'serttech/mypublic_recruitment/job_mng',$this->data);
	}
	public function disapprove_all_c(){

						$this->db->query("update jobs set admin_verified='0' where 1 ");
			
		// logfile
		$value = "all company";

		General::logfile('Job Posting','DisApproved',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Successfully DisApprove All Job Posting of All companies!</div>");

		redirect(base_url().'serttech/mypublic_recruitment/job_mng',$this->data);
	}
	public function approve_all(){

		$company_id = $this->uri->segment("4");
		$myjobs=$this->serttech_login_model->company_jobs($company_id);
		if(!empty($myjobs)){
			foreach ($myjobs as $jobs){
				$job_id=$jobs->job_id;
						$this->db->query("update jobs set admin_verified='1' where job_id = '".$job_id."' ");
			}
		// logfile
		$value = $company_id;

		General::logfile('Job Posting','Approved All',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Successfully Approve All Job Posting!</div>");

		}else{
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>No Job Posting Request Yet!</div>");			

		}
		redirect(base_url().'serttech/mypublic_recruitment/job_mng',$this->data);
	}
	public function disapprove_all(){

		$company_id = $this->uri->segment("4");
		$myjobs=$this->serttech_login_model->company_jobs($company_id);
		if(!empty($myjobs)){
			foreach ($myjobs as $jobs){
				$job_id=$jobs->job_id;
						$this->db->query("update jobs set admin_verified='0' where job_id = '".$job_id."' ");
			}
		// logfile
		$value = $company_id;

		General::logfile('Job Posting','DisApproved All',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Successfully DisApprove All Job Posting!</div>");

		}else{
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>No Job Posting Request Yet!</div>");			

		}
		redirect(base_url().'serttech/mypublic_recruitment/job_mng',$this->data);
	}
	public function approve_job(){

		$id = $this->uri->segment("4");
		$this->db->query("update jobs set admin_verified='1' where job_id = '".$id."' ");

		// logfile
		$value = $id;

		General::logfile('Job Posting','Approved',$id);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Successfully Approve Job Posting!</div>");

		redirect(base_url().'serttech/mypublic_recruitment/job_mng',$this->data);
	}
	public function disapprove_job(){

		$id = $this->uri->segment("4");
		$this->db->query("update jobs set admin_verified='0' where job_id = '".$id."' ");

		// logfile
		$value = $id;

		General::logfile('Job Posting','Dis-Approved',$id);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Successfully disapprove Job Posting!</div>");

		redirect(base_url().'serttech/mypublic_recruitment/job_mng',$this->data);
	}
	public function disable_bill(){

		$id = $this->uri->segment("4");
		$this->db->query("update recruitment_employer_billing_setting set InActive='1' where id = '".$id."' ");

		// logfile
		$value = $id;

		General::logfile('Bill','DISABLED',$id);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Successfully Disabled!</div>");

		redirect(base_url().'serttech/mypublic_recruitment/index',$this->data);
	}
	
	public function enable_bill(){

		$id = $this->uri->segment("4");
		$this->db->query("update recruitment_employer_billing_setting set InActive='0' where id = '".$id."' ");
		// logfile
		$value = $id;

		General::logfile('Bill','ENABLED',$id);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Successfully Enabled!</div>");
		redirect(base_url().'serttech/mypublic_recruitment/index',$this->data);
	}
	public function modify_free_trial(){

		$validity=$this->input->post('validity');
		$no_of_jobs=$this->input->post('no_of_jobs');
		$this->db->query("update recruitment_employers_setting_main set free_trial_months_can_post='".$validity."',free_trial_jobs_can_post='".$no_of_jobs."' where id = '1' ");
		// logfile
		$value = $validity."".$no_of_jobs;

		General::logfile('Free Trial','MODIFIED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Free Trial Successfully Modified</div>");

		redirect(base_url().'serttech/mypublic_recruitment/index',$this->data);
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













