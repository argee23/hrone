<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_user_define_fields extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/employee_user_define_fields_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		
		$this->load->view('app/employee/udf/user_define_fields',$this->data);	
	}

	public function user_define_fields(){
		

		$this->data['udf_add']=$this->session->userdata('udf_add');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->data['message'] = $this->session->flashdata('message');		 
		$this->load->view('app/employee/udf/user_define_fields',$this->data);		
	}

	public function save_udf_col(){

		$value 			= $this->input->post('label');
		$company 		= $this->input->post('company');
		$checktemp 		= true;
		$companyList 	= $this->general_model->companyList();

		if($company==0){
			foreach($companyList as $company){
				$companyid 	= $company->company_id;
				$check 		= $this->employee_user_define_fields_model->check_udf_label($companyid);
				if($check===false){
					$checktemp = false;
				}
			}

			if($checktemp===true){
				foreach($companyList as $company){
					$companyid = $company->company_id;
					$this->employee_user_define_fields_model->create_udf_store($companyid);
					$this->employee_user_define_fields_model->create_udf($companyid);

					//For option
					$lastUDF 		= $this->employee_user_define_fields_model->get_latest_insert_udf();
					$Lastudf 		= $lastUDF->emp_udf_col_id;

					$max_length 	= $this->employee_user_define_fields_model->colName_udf_store($Lastudf);
					$maxLength 		= $max_length->udf_max_length;
					$type 			= $max_length->udf_type;

					if(!empty($maxLength) && $maxLength > 0 && $type === 'Selectbox'){
						$num1=1;
						for($num=0; $num<$maxLength; $num++){
							$label 	= 'option_'.$num1;	
							$field 	= $this->input->post($label);
							$this->employee_user_define_fields_model->create_udf_opt($Lastudf,$field);
							$num1++;
						}
					}
					//for option
				}



				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields successfully Added!</div>");
					redirect(base_url().'app/employee_user_define_fields/user_define_fields',$this->data);
			}
			else{
				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields already exist.</div>");
				redirect(base_url().'app/employee_user_define_fields/user_define_fields',$this->data);
			}
		}
		else{
			$check = $this->employee_user_define_fields_model->check_udf_label($company);
			if($check===true){
				$this->employee_user_define_fields_model->create_udf_store($company);
				$this->employee_user_define_fields_model->create_udf($company);
				
				//For option
				$lastUDF 		= $this->employee_user_define_fields_model->get_latest_insert_udf();
				$Lastudf 		= $lastUDF->emp_udf_col_id;

				$max_length 	= $this->employee_user_define_fields_model->colName_udf_store($Lastudf);
				$maxLength 		= $max_length->udf_max_length;
				$type 			= $max_length->udf_type;

				if(!empty($maxLength) && $maxLength > 0 && $type === 'Selectbox'){
					$num1=1;
					for($num=0; $num<$maxLength; $num++){
						$label 	= 'option_'.$num1;	
						$field 	= $this->input->post($label);
						$this->employee_user_define_fields_model->create_udf_opt($Lastudf,$field);
						$num1++;
					}
				}
				//for option

				$logtrailtitle="company|value";
				$logtraildata="$company|$value";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','User Define Fields','logfile_employee_udf','add : user define 201 fields '.$company.' '.$logtrailtitle,'INSERT',$logtraildata);

				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields:  <strong>".$value."</strong> is Successfully Added!</div>");
				redirect(base_url().'app/employee_user_define_fields/user_define_fields',$this->data);
			}
			else{
				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> already exist.</div>");
				redirect(base_url().'app/employee_user_define_fields/user_define_fields',$this->data);
			}
		}

	}

	public function save_udf_opt(){
		$id    = $this->uri->segment("4");
		$value = $this->input->post('option');

		$this->employee_user_define_fields_model->create_udf_option($id);


				$logtrailtitle="id|value";
				$logtraildata="$id|$value";

		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','User Define Fields','logfile_employee_udf','add : option to udf select box '.$company.' '.$logtrailtitle,'INSERT',$logtraildata);


		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: Option <strong>".$value."</strong> is Successfully Added!</div>");

		redirect(base_url().'app/employee_user_define_fields/user_define_fields',$this->data);
	}


	public function modify_udf_col(){

		$id 		= $this->uri->segment("4");
		$value 		= $this->input->post('label');
		$check 		= $this->employee_user_define_fields_model->check_udf_label($id );
		if($check===true){
				$colName 	= $this->employee_user_define_fields_model->colName_udf_store($id);
				$label 		= $colName->udf_label;
				$company 	= $colName->company_id;
				$delcolName = $label.'_'.$company;

				$this->employee_user_define_fields_model->modify_udf_store($delcolName,$company);
				$this->employee_user_define_fields_model->modify_udf($id);
				

			$logtrailtitle="user define delcolName|value";
			$logtraildata="$delcolName|$value";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','User Define Fields','logfile_employee_udf','update : user define 201 fields '.$id.' '.$logtrailtitle,'UPDATE',$logtraildata);

				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> is Successfully Modified!</div>");

				redirect(base_url().'app/employee_user_define_fields/user_define_fields',$this->data);
		}
		else{
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> already exist.</div>");
			redirect(base_url().'app/employee_user_define_fields/user_define_fields',$this->data);
		}

	}
	
	public function modify_udf_opt(){

		$id 	= $this->uri->segment("4");
		$value 	= $this->input->post('optlabel');

		$this->employee_user_define_fields_model->modify_udf_opt($id);


				$logtrailtitle="id|value";
				$logtraildata="$id|$value";

		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','User Define Fields','logfile_employee_udf','edit : option to udf select box '.$company.' '.$logtrailtitle,'UPDATE',$logtraildata);




			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> is Successfully Modified!</div>");

			redirect(base_url().'app/employee_user_define_fields/user_define_fields',$this->data);
	}

	public function del_udf_col(){
		$id 		= $this->uri->segment("4");
		$colName 	= $this->employee_user_define_fields_model->colName_udf_store($id);
		$delcolName = $colName->udf_label;
		$labelold 	= str_replace(' ', '_', $delcolName);
		$delcolCom 	= $colName->company_id;
		$delColumn 	= $labelold.'_'.$delcolCom;
		$this->employee_user_define_fields_model->del_udf_store($delColumn);
		$data 		= $this->employee_user_define_fields_model->del_udf($id);
		$delopt 	= $this->employee_user_define_fields_model->del_udf_optcol($id);

		if($data){


			$logtrailtitle="user define delcolName ";
			$logtraildata="$delcolName";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','User Define Fields','logfile_employee_udf','delete : user define 201 fields '.$id.' '.$logtrailtitle,'DELETE',$logtraildata);



			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$delcolName."</strong> is Successfully Deleted!</div>");
			redirect(base_url().'app/employee_user_define_fields/user_define_fields',$this->data);
		}

	}

	public function del_udf_opt(){

		$id = $this->uri->segment("4");
		$udf_option = $this->employee_user_define_fields_model->del_udf_option($id);

				$logtrailtitle="id";
				$logtraildata="$id";

		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','User Define Fields','logfile_employee_udf','delete : option to udf select box '.$company.' '.$logtrailtitle,'DELETE',$logtraildata);



	


		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User Define Field: <strong>".$delcolName."</strong>Option is Successfully Deleted!</div>");

		redirect(base_url().'app/employee_user_define_fields/user_define_fields',$this->data);
	}

	public function add_new_emp_udf(){
		
		$this->load->view('app/employee/udf/add_udf_emp',$this->data);
	}

	public function add_opt_emp_udf(){
		$id = $this->uri->segment("4");
		$this->data['user_define_edit'] = $this->employee_user_define_fields_model->get_udf_col($id);	
		$this->load->view('app/employee/udf/add_opt_udf_emp',$this->data);
	}

	public function edit_emp_udf(){
		$id = $this->uri->segment("4");
		$this->data['user_define_edit'] = $this->employee_user_define_fields_model->get_udf_col($id);	
			$this->load->view('app/employee/udf/edit_udf_emp',$this->data);
	}

	public function edit_emp_udf_opt(){
		$id = $this->uri->segment("4");
		$this->data['user_define_edit'] = $this->employee_user_define_fields_model->get_udf_opt($id);
		$this->load->view('app/employee/udf/edit_udf_opt',$this->data);
	}

	public function view_emp_udf(){	
		$id 				= $this->uri->segment("4");
		$user_define_fields = $this->employee_user_define_fields_model->get_udf_col_All($id);
		$companyName 		= $this->general_model->companyName($id);

	/*	$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Label','Type','Accept value','Max length','Not null','Company');

				
		$this->table->add_row(			
			$user_define_fields->udf_label,
			$user_define_fields->udf_type,
			$user_define_fields->udf_accept_value,
			$user_define_fields->udf_max_length,
			$user_define_fields->udf_not_null,
			$companyName->company_name
			);


		$this->data['table_user_define_fields'] = $this->table->generate();			*/

		$this->data['user_define_fields'] = $this->employee_user_define_fields_model->get_udf_col_All($id);
	//	$this->load->view('app/employee/udf/view_udf_emp',$this->data);
		$this->load->view('app/employee/udf/view_emp_udf',$this->data);
	}

	public function view_emp_udf_opt(){	

		$id 				= $this->uri->segment("4");
		$Optvalue 			= $this->employee_user_define_fields_model->get_udf_col_All($id);
		$Optlabel 			= $Optvalue->udf_label;
		$user_define_fields = $this->employee_user_define_fields_model->getOptlabel($id);

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading($Optlabel.' Option(s)','<i class="fa fa-plus-square fa-lg text-warning pull-right" data-toggle="tooltip" data-placement="left" title="Add" onclick="addUDFOption('.$id.')"></i>');

		foreach($user_define_fields as $user_define_fields){
			
			$edit = '<i class="fa fa-pencil-square-o fa-lg text-warning pull-right" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editUDFOpt('.$user_define_fields->emp_udf_opt_id.')"></i>';
			$delete = anchor('app/employee_user_define_fields/del_udf_opt/'.$user_define_fields->emp_udf_opt_id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-right"></i>',array('data-toggle'=>'tooltip','data-placement'=>'right','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete User Define fields (option) : ".$user_define_fields->optionLabel."?')"));	
			
			$this->table->add_row(			
				$user_define_fields->optionLabel,
				$delete.' '.$edit
			);
		}

		$this->data['table_udf_opt'] = $this->table->generate();			
		$this->load->view('app/employee/udf/view_udf_emp_opt',$this->data);

	}

	public function view_add_forTextfield(){
		$value = $this->uri->segment("4");
		if($value === 'Textfield'){
			$this->load->view('app/employee/udf/add_forTextfield',$this->data);
		}
		else if($value === 'Selectbox'){
			$this->load->view('app/employee/udf/add_forSelectbox',$this->data);
		}
	}

	public function view_edit_forTextfield(){

		$value = $this->uri->segment("4");
		if($value === 'Textfield'){	
			$this->load->view('app/employee/udf/edit_forTextfield',$this->data);
		}
		else if($value === 'Selectbox'){
			$this->load->view('app/employee/udf/add_forSelectbox',$this->data);
		}

	}

	public function view_company_udf(){

		$this->data['udf_edit']=$this->session->userdata('udf_edit');
		$this->data['udf_del']=$this->session->userdata('udf_del');

		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$value = $this->uri->segment("4");
		if($value==0){
			$this->data['user_define_field'] = $this->general_model->user_define_fields();
			$this->load->view('app/employee/udf/udf_company_selected',$this->data);
		}
		else{
			$this->data['user_define_field'] = $this->employee_user_define_fields_model->get_udf_company($value);
			$this->load->view('app/employee/udf/udf_company_selected',$this->data);
		}
	}

	public function view_add_option(){

		$this->load->view('app/employee/udf/add_udf_option',$this->data);
	}

}
