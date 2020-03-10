<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Recruitment_setting extends General{

	function __construct(){
		parent::__construct();	
		//$this->load->model('login_model');
		$this->load->model('serttech/serttech_login_model');
		$this->load->model('serttech/serttech_recruitment_setting_model');
		$this->load->model('general_model');
		$this->load->model('recruitment_employer/recruitment_employer_model');
		$this->load->model('app/recruitment_model');
		$this->load->model('app/recruitments_model');
		//$this->load->model('app/roles_model');
		General::variable();
	} 



//START OF SETTINGS

	public function index(){

		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['serttech_account'] = $this->serttech_login_model->getUserLoggedIn($this->input->post('username'));
		$this->data['details'] = $this->serttech_recruitment_setting_model->recruitment_settings_list_active();
		$this->load->view('serttech/recruitment_settings',$this->data);	
	}
	public function refresh_main()
	{
		$details = $this->serttech_recruitment_setting_model->recruitment_settings_list_active();
		foreach($details as $row) { ?>
				<li class="my_hover">
                   <a data-toggle="tab" href="#" style="cursor: pointer;" onclick="get_setting('<?php echo $row->code;?>');"><i class="fa fa-folder-open"></i><span><?php echo $row->policy_title;?></span></a>
                </li>
		<?php } 
	}
	
	public function get_setting($type)
	{
		$this->data['type']=$type;
		$this->data['action']='';
		$this->data['msg'] = $this->session->flashdata('success_save');
		$this->data['setting_details']=$this->serttech_recruitment_setting_model->setting_details($type);
		if($type=='view_all_settings')
		{
			$this->data['details'] = $this->serttech_recruitment_setting_model->recruitment_settings_list();
		}
		else if($type=='add_new_settings')
		{
			$this->data['details'] = $this->serttech_recruitment_setting_model->recruitment_default_settings_list();
		}
		elseif($type=='SD3' || $type=='SD12')
		{
				$this->data['details'] = $this->serttech_recruitment_setting_model->get_recruitment_list($type);
		} 
		elseif($type=='SD2' || $type=='SD1' || $type=='SD4' || $type=='SD5')
		{
				$this->data['details'] = $this->serttech_recruitment_setting_model->get_free_trial();
		}
		else if($type=='SD6')
		{
				$this->data['details'] = $this->serttech_recruitment_setting_model->get_email_settings('serttech_host');
		}

		else
		{
			$this->data['details'] = $this->serttech_recruitment_setting_model->get_recruitment_settings_details($type);
		}

		$this->load->view('serttech/recruitment_by_settings',$this->data);
	}
	public function save_requirements($type,$title,$desc,$note,$action,$id,$uploadable)
	{
		$actionn = $this->serttech_recruitment_setting_model->save_requirements($type,$title,$desc,$note,$action,$id,$uploadable);
		$this->data['type']=$type;
		$this->data['id']=$id;
		$this->data['details'] = $this->serttech_recruitment_setting_model->get_recruitment_list($type);
		$this->data['setting_details']=$this->serttech_recruitment_setting_model->setting_details($type);
		$this->session->set_flashdata('success_'.$action,"success_".$action);
		$this->load->view('serttech/recruitment_by_settings',$this->data);
	}
	public function save_free_trial($type,$months,$post,$id)
	{
		$this->data['type']=$type;
		$action = $this->serttech_recruitment_setting_model->save_free_trial($type,$months,$post,$id);
		$this->session->set_flashdata('success_save_update',"success_save_update");
		$this->data['details'] = $this->serttech_recruitment_setting_model->get_free_trial();
		$this->data['setting_details']=$this->serttech_recruitment_setting_model->setting_details($type);
		$this->load->view('serttech/recruitment_by_settings',$this->data);
	}

	public function save_package_settings($type,$action,$id,$customertype,$validity,$license,$price,$discount,$vat,$vat_included,$applicant)
	{ 
		$this->data['type']=$type;
		$this->data['action']=$action;
		$this->data['id']=$id;
		$actionn = $this->serttech_recruitment_setting_model->save_package_settings($type,$action,$id,$customertype,$validity,$license,$price,$discount,$vat,$vat_included,$applicant);
		$this->data['details'] = $this->serttech_recruitment_setting_model->get_free_trial();
		$this->data['rec_employer_bill_setting_mng'] = $this->general_model->rec_employer_bill_setting_mng();
		$this->data['setting_details']=$this->serttech_recruitment_setting_model->setting_details($type);
		$this->session->set_flashdata('success_'.$action,"Success");
		$this->load->view('serttech/recruitment_by_settings',$this->data);
	}

	public function update_package_settings($id,$type)
	{
		$this->data['type']=$type;
		$this->data['details'] = $this->serttech_recruitment_setting_model->get_free_trial();
		$this->data['details_one'] = $this->serttech_recruitment_setting_model->package_details($id);
		$this->load->view('serttech/recruitment_update_package_setting',$this->data);
	}
	public function save_action_settings($type,$action,$id,$title,$note)
	{  
		$this->data['type']=$type;
		$action = $this->serttech_recruitment_setting_model->save_action_settings($type,$action,$id,$title,$note);
		$this->data['details'] = $this->serttech_recruitment_setting_model->recruitment_settings_list();
		$this->data['setting_details']=$this->serttech_recruitment_setting_model->setting_details($type);
		$this->load->view('serttech/recruitment_by_settings',$this->data);

	}
	
	public function save_new_rec_settings($choices,$title,$note,$code,$field,$format1,$format2)
	{
		$this->data['type']='view_all_settings';
		$checker = $this->serttech_recruitment_setting_model->checker_recruitment_settings_list($code);
		if($checker>0){
			$this->session->set_flashdata('exist',"exist");
		}
		else
		{
			$action = $this->serttech_recruitment_setting_model->save_new_rec_settings($choices,$title,$note,$code,$field,$format1,$format2);
			$this->session->set_flashdata('inserted',"inserted");
		}
		$this->data['details'] = $this->serttech_recruitment_setting_model->recruitment_settings_list();
		$this->load->view('serttech/recruitment_by_settings',$this->data);
	}
	public function single_field_data($type,$format,$idd,$action,$data)
	{	
		$this->data['type']=$type;
		$action = $this->serttech_recruitment_setting_model->single_field_data($type,$format,$idd,$action,$data);
		$this->session->set_flashdata('success_save',"success_save");
		$this->data['details'] = $this->serttech_recruitment_setting_model->get_recruitment_settings_details($type);
		$this->data['setting_details']=$this->serttech_recruitment_setting_model->setting_details($type);
		$this->load->view('serttech/recruitment_by_settings',$this->data);
	}
	public function save_months_setting($type,$id,$option,$data,$table)
	{
		$this->data['type']=$type;
		$action = $this->serttech_recruitment_setting_model->save_months_setting($type,$id,$option,$data,$table);
		$this->data['details'] = $this->serttech_recruitment_setting_model->get_free_trial();
		$this->session->set_flashdata('success_save_update',"success_save_update");
		$this->data['setting_details']=$this->serttech_recruitment_setting_model->setting_details($type);
		$this->load->view('serttech/recruitment_by_settings',$this->data);
	}

	public function save_email_setting($type,$action,$id,$host,$port,$username,$password,$send_mail_from,$typp,$security_type)
	{
		$this->data['type']=$type;
		$actionn = $this->serttech_recruitment_setting_model->save_email_settings($type,$action,$id,$host,$port,$username,$password,$send_mail_from,$typp,$security_type);$this->session->set_flashdata('success_'.$action,"success_".$action);

		$this->data['details'] = $this->serttech_recruitment_setting_model->get_email_settings('serttech_host');
		$this->data['setting_details']=$this->serttech_recruitment_setting_model->setting_details($type);
		$this->load->view('serttech/recruitment_by_settings',$this->data);
	}

	public function search_settings($value)
	{
		$search = $this->serttech_recruitment_setting_model->search_settings($value);
		foreach($search as $row) { ?>
				<li class="my_hover">
                   <a data-toggle="tab" href="#" style="cursor: pointer;" onclick="get_setting('<?php echo $row->code;?>');"><i class="fa fa-folder-open"></i><span><?php echo $row->policy_title;?></span></a>
                </li>
		<?php } 
	}



//END OF SETTINGS




//START OF EMPLOYER'S REQUIREMENTS STATUS


public function requirement_status()
{	
	$this->data['message'] = $this->session->flashdata('message');	
	$this->data['onload'] = $this->session->flashdata('onload');
	$this->data['details'] = $this->serttech_recruitment_setting_model->employer_requirement_status('All');
	$this->data['package']=$this->serttech_recruitment_setting_model->get_recruitment_list('SD3');
	$this->data['free_trial']=$this->serttech_recruitment_setting_model->get_recruitment_list('SD12');
	$this->data['serttech_account'] = $this->serttech_login_model->getUserLoggedIn($this->input->post('username'));
	$this->load->view('serttech/recruitment_requirement_status_index',$this->data);	
}
public function get_requirement_list_by_type($type)
{
	if($type=='new_uploaded_file')
	{
			$this->notifications($type);
	}
	else
	{
			$this->data['package']=$this->serttech_recruitment_setting_model->get_recruitment_list('SD3');
			$this->data['free_trial']=$this->serttech_recruitment_setting_model->get_recruitment_list('SD12');
			if($type=='payment' || $type=='manual_activation')
			{
				$this->data['details'] = $this->serttech_recruitment_setting_model->employer_requirement_status_not_paid($type);
			}
			else
			{
				$this->data['details'] = $this->serttech_recruitment_setting_model->employer_requirement_status($type);
			}
			
			$this->data['type']=$type;
			$this->load->view('serttech/recruitment_requirement_status_by_type',$this->data);
	}
		
}
public function notifications($type)
{
	$this->data['type']=$type;
	$this->data['details'] = $this->serttech_recruitment_setting_model->get_new_uploaded_file($type);
	$this->load->view('serttech/notifications',$this->data);
}
public function mark_as_active($option,$action,$id,$type)
{
	$action = $this->serttech_recruitment_setting_model->mark_as_active_paid($option,$action,$id,$type);
	$this->session->set_flashdata('onload',"recruitment_requirement_stat('payment')");
	$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Package License Request is successfully mark as paid.</div>");
}

public function view_details_employer_requirements($option,$action,$id,$type)
{
	$this->data['view_option']=$option;
	$this->data['view_action']=$action;
	$this->data['id']=$id;
	$this->data['type']=$type;
	$this->data['details_req'] = $this->serttech_recruitment_setting_model->view_details_employer_requirements($option,$action,$id,$type);
	$this->load->view('serttech/recruitment_view_details_employer_requirements',$this->data);
}







//END OF EMPLOYER'S REQUIREMENTS STATUS



//START OF REGISTERED EMPLOYERS

public function registered_employers()
{	
	$this->data['details'] = $this->serttech_recruitment_setting_model->registered_employers();
	$this->data['serttech_account'] = $this->serttech_login_model->getUserLoggedIn($this->input->post('username'));
	$this->load->view('serttech/recruitment_requirement_registered_employers_index',$this->data);	
}

//END OF REGISTERED EMPLOYERS



//START OF JOB MANAGEMENT

public function job_management()
{	
	$this->data['jobs'] = $this->serttech_recruitment_setting_model->job_management('waiting','all');
	$this->data['serttech_account'] = $this->serttech_login_model->getUserLoggedIn($this->input->post('username'));
	$this->load->view('serttech/recruitment_job_management_index',$this->data);	
}
public function save_job_management_action($action,$status,$job_id,$status_res,$comment_,$company)
{ 
	$this->data['status']=$status;
	$this->data['company_id']=$company;
	$this->data['status_res']=$status_res;
	$this->data['job_id']=$job_id;
	$this->data['action']=$action;
	$action = $this->serttech_recruitment_setting_model->save_job_management_action($action,$status,$job_id,$status_res,$comment_);
	$this->data['jobs'] = $this->serttech_recruitment_setting_model->job_management($status,$company);
	$this->session->set_flashdata('success_'.$status_res,"success_".$status_res);
	$this->load->view('serttech/recruitment_job_management_by_status',$this->data);	
}

public function get_company_job_manage($company,$status)
{
	$this->data['status']=$status;
	$this->data['company']=$company;
	$this->data['jobs'] = $this->serttech_recruitment_setting_model->job_management($status,$company);
	$this->load->view('serttech/recruitment_job_management_by_company',$this->data);	
}
//END OF JOB MANAGEMENT

//for approving of requirements

function save_requirement_request_action($option,$action,$employer_id,$req_id,$comment_,$type)
{ 
	
	if($action=='update_comment')
	{
		$t = 'Requirement Comment is successfully added';
	}
	else
	{
		$t = 'Requirement is successfully approved';
	}
	$this->session->set_flashdata('onload',"view_details_employer_requirements('view_employer_req','Update_req','".$employer_id."','All')");
	$action = $this->serttech_recruitment_setting_model->save_requirement_request_action($option,$action,$employer_id,$req_id,$comment_);
	$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$t."</div>");
}

//by company requirements status

public function recruitment_requirement_stat_by_company($type,$company)
{
	$this->data['type']=$type;
	$this->data['company']=$company;
	$this->data['details'] = $this->serttech_recruitment_setting_model->employer_requirement_status_by_company($type,$company);
	$this->load->view('serttech/recruitment_requirement_status_by_company',$this->data);
}
	
//by company filtering registered employees

public function registered_employers_by_company($company)
{
	$this->data['details'] = $this->serttech_recruitment_setting_model->registered_employers_by_company($company);
	$this->load->view('serttech/recruitment_requirement_registered_employers_by_company',$this->data);
}
//end


public function save_ed8_settings($id,$type,$format,$action)
{	
	$update = $this->serttech_recruitment_setting_model->save_ed8_settings($id,$type,$format);
	$this->session->set_flashdata('onload',"get_setting('".$type."')");
	$this->session->set_flashdata('success_save',"success_save");
	redirect('serttech/recruitment_setting/index',$this->data);
}

}