<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Downloadable_forms extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/downloadable_forms_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index()
	{
		$this->data['message'] = $this->session->flashdata('message');

		$this->data['add_dl_forms']=$this->session->userdata('add_dl_forms');
		$this->data['edit_dl_forms']=$this->session->userdata('edit_dl_forms');
		$this->data['ena_dis_dl_forms']=$this->session->userdata('ena_dis_dl_forms');
		$this->data['download_dl_forms']=$this->session->userdata('download_dl_forms');
		$this->data['del_dis_dl_forms']=$this->session->userdata('del_dis_dl_forms');

		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->data['downloadable']=$this->downloadable_forms_model->get_downloadable_forms();
		$this->load->view('app/downloadable_forms/index',$this->data);
	}
	public function get_downloadable_company($company)
	{


		$this->data['add_dl_forms']=$this->session->userdata('add_dl_forms');
		$this->data['edit_dl_forms']=$this->session->userdata('edit_dl_forms');
		$this->data['ena_dis_dl_forms']=$this->session->userdata('ena_dis_dl_forms');
		$this->data['download_dl_forms']=$this->session->userdata('download_dl_forms');
		$this->data['del_dis_dl_forms']=$this->session->userdata('del_dis_dl_forms');

		if($company=='All'){ $this->data['company_name']='All Companies'; }
		else{ $this->data['company_name']=$this->downloadable_forms_model->get_company_name($company); }
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['company_id']=$company;
		$this->data['downloadable']=$this->downloadable_forms_model->get_downloadable_company($company);
		$this->load->view('app/downloadable_forms/downloadable_by_company',$this->data);
	}

	public function add_downloadable_forms($company)
	{
		$this->data['company']=$company;
		$this->load->view('app/downloadable_forms/add_downloadable_forms',$this->data);
	}
	public function save_downloadable_forms($company)
	{
		
		$picture 			= '';
		$error 				= false;
		$title = $this->input->post('title');
		$description = $this->input->post('description');


	/*
	--------------audit trail composition--------------
	(module,module dropdown,logfiletable,detailed action,action type,key value)
	--------------audit trail composition--------------
	*/

	General::system_audit_trail('Administrator','Downloadable Forms','logfile_admin_dl_forms','Add '.$title.'|'.$description,'INSERT',$title);

		if(!empty($_FILES['file']['name'])){
                $config['upload_path'] 		= './public/downloadable_forms/';
                 $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= "downloadable_forms".'_'.$company.'_'.$currentDateTime;
                $fileName 					= $config['file_name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                $file_size = $_FILES['file']['size'];
              
			    if ($file_size > 2500000000){      
			    	$error = true;
			    }
			    else{
	                if($this->upload->do_upload('file')){
	                    $uploadData = $this->upload->data();
	                    $picture = $uploadData['file_name'];
	                }
	                else
	                {
	                	$msg = 'The filetype you are attempting to upload is not allowed!';
	                	$error=true;
	                }
	            }
	           
        }
        else
        {
        	$msg = 'Sorry uploaded file exceeds the maximum limit size!';	
        }

        if($error==false)
        {
        	$insert = $this->downloadable_forms_model->save_downloadable_forms($company,$title,$description,$picture);
        	$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>New Donwloadable form is successfully added!</div>");
        }
        else
        {
        	$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$msg."</div>");
        }

        
    	redirect('app/downloadable_forms/get_downloadable_company/'.$company,$this->data);

	}

	public function update_downloadable_forms($company,$id)
	{
		$this->data['company']=$company;
		$this->data['id']=$id;
		$this->data['details']=$this->downloadable_forms_model->update_downloadable_forms($company,$id);
		$this->load->view('app/downloadable_forms/update_downloadable_forms',$this->data);
	}
	public function action_downloadable($action,$company,$id)
	{

	/*
	--------------audit trail composition--------------
	(module,module dropdown,logfiletable,detailed action,action type,key value)
	--------------audit trail composition--------------
	*/
	General::system_audit_trail('Administrator','Downloadable Forms','logfile_admin_dl_forms',$action.' '.$company.'|'.$id,$action,$id);


		$action = $this->downloadable_forms_model->action_downloadable($action,$company,$id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$action."</div>");
	}
	public function download_forms($filename)
	{

        $this->load->helper('download');            
		$path    =   file_get_contents(base_url().'public/downloadable_forms/'.$filename);
		$name    =   $filename;
		force_download($name, $path); 

		$value = $name;

		General::logfile('Downloadable_forms','DOWNLOAD',$value);

	}
	public function save_update_downloadable_forms($id,$company)
	{
			$picture 			= '';
		$error 				= false;
		$title = $this->input->post('title');
		$description = $this->input->post('description');
	/*
	--------------audit trail composition--------------
	(module,module dropdown,logfiletable,detailed action,action type,key value)
	--------------audit trail composition--------------
	*/
	General::system_audit_trail('Administrator','Downloadable Forms','logfile_admin_dl_forms','Update '.$title.'|'.$description,'UPDATE',$title);
		if(!empty($_FILES['file']['name'])){
                $config['upload_path'] 		= './public/downloadable_forms/';
                 $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= "downloadable_forms".'_'.$company.'_'.$currentDateTime;//$_FILES['file']['name'];
                $fileName 					= $config['file_name'];//$_FILES['file']['name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                $file_size = $_FILES['file']['size'];
              
			    if ($file_size > 2500000000){      
			    	$error = true;
			    }
			    else{
	                if($this->upload->do_upload('file')){
	                    $uploadData = $this->upload->data();
	                    $picture = $uploadData['file_name'];
	                }
	            }

        } else { $picture = $this->input->post('file_old') ; }
        
        $res = $this->downloadable_forms_model->saveupdate_downloadable_forms($company,$title,$description,$picture,$id);
       	
       	$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$res."</div>");
       	
     	redirect('app/downloadable_forms/get_downloadable_company/'.$company,$this->data);
	}

	public function employee_downloadable_forms()
	{
		$company = $this->session->userdata('company_id');
		$this->data['downloadable']=$this->downloadable_forms_model->get_downloadable_company_employee($company);
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/downloadable_forms', $this->data);
		$this->load->view('employee_portal/footer');		
	}
}//end controller



