<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Transaction_file_maintenance extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/transaction_file_maintenance_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}	
	public function index(){	
		
		$this->session->set_userdata(array(
				 'tab'			=>		'administrator',
				 'module'		=>		'user_management',
				 'subtab'		=>		'',
				 'submodule'	=>		''));
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['file'] = $this->transaction_file_maintenance_model->getAll();
		

		$this->data['tran_sdf_act_deac']=$this->session->userdata('tran_sdf_act_deac');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->load->view('app/transaction/file_maintenance',$this->data);
	}	
	public function activate_transaction(){

		$id = $this->uri->segment("4");
		
		$this->transaction_file_maintenance_model->activate_transaction($id);

		$files = $this->transaction_file_maintenance_model->get_transaction($id);
		foreach($files as $f){}
		// logfile
		$value = $f->form_name;

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Transaction','System Default Forms','logfile_transaction_sdf','Activate : form id  : '.$id.' ,','ACTIVATE',$value);


			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  <strong>".$value."</strong> is Successfully Activated!</div>");

		redirect(base_url().'app/Transaction_file_maintenance/index',$this->data);
	}
			
	public function deactivate_transaction(){

		$id = $this->uri->segment("4");
		
		$this->transaction_file_maintenance_model->deactivate_transaction($id);

		$files = $this->transaction_file_maintenance_model->get_transaction($id);
		foreach($files as $f){}
		// logfile
		$value = $f->form_name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Transaction','System Default Forms','logfile_transaction_sdf','DeActivate : form id  : '.$id.' ,','DeACTIVATE',$value);


			
		$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  <strong>".$value."</strong> is Successfully Deactivated!</div>");

		redirect(base_url().'app/Transaction_file_maintenance/index',$this->data);
	}
	
	public function create(){	
		
		$this->session->set_userdata(array(
				 'tab'			=>		'administrator',
				 'module'		=>		'user_management',
				 'subtab'		=>		'',
				 'submodule'	=>		''));
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('app/transaction/create',$this->data);
	}	
	
	public function next(){	
		
		$this->session->set_userdata(array(
				 'tab'			=>		'administrator',
				 'module'		=>		'user_management',
				 'subtab'		=>		'',
				 'submodule'	=>		''));
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('app/transaction/next',$this->data);
	}	
	
	

	
}//end controller



