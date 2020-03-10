<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Application_forms extends General{

	function __construct(){
		parent::__construct();
		$this->load->model("app/application_forms_model");
		$this->load->model("app/application_form_model");
		$this->load->model("app/final_recruitments_model");
		$this->load->model("general_model");
		
		General::variable();
	}
	
	
	public function applications()
	{
		$this->data['message'] = $this->session->flashdata('message');	
		$applicant = $this->session->userdata('employee_id');
		$this->data["statusList"] = $this->application_forms_model->get_statusList($applicant);
		$this->data["jobs"] = $this->application_forms_model->get_job_applications($applicant);
		$this->load->view('app/application_form/header');
		$this->load->view('app/application_form/app_applications', $this->data);
	}

	public function manage_requirements($app_id,$applicant_id,$job_id)
	{ 
		$this->data['job_id']=$job_id;
		$this->data['applicant_id']=$applicant_id;
		$this->data['app_id']=$app_id;
		$this->data['job_details'] = $this->application_forms_model->get_job_details($job_id);
		$this->data['req'] = $this->application_forms_model->get_applicant_requirements($app_id,$applicant_id,$job_id);
		$this->load->view('app/application_form/app_requirements', $this->data);
	}

	public function manage_questions($app_id,$applicant_id,$job_id)
	{
		$this->data['type']='qualifying';
		$this->data['job_id']=$job_id;
		$this->data['applicant_id']=$applicant_id;
		$this->data['app_id']=$app_id;
		$this->data['qq'] =$this->application_forms_model->get_questions($job_id,'qualifying');
		$this->data['job_details'] = $this->application_forms_model->get_job_details($job_id);
		$this->load->view('app/application_form/app_questions', $this->data);
	}
	public function get_questions($job_id,$applicant_id,$app_id,$type)
	{ 

		$this->data['type']=$type;
		$this->data['job_id']=$job_id;
		$this->data['applicant_id']=$applicant_id;
		$this->data['app_id']=$app_id;
		$this->data['qq'] =$this->application_forms_model->get_questions($job_id,$type);
		$this->load->view('app/application_form/app_questions_filtered', $this->data);

	}
	public function manage_job_status($job_id,$applicant_id,$app_id)
	{
		// $this->data['job_id']=$job_id;
		// $this->data['applicant_id']=$applicant_id;
		$this->data['app_id']=$app_id;
		$this->load->view('app/application_form/app_job_status', $this->data);
	}
	public function get_status_applications_list($status)
	{
		$applicant = $this->session->userdata('employee_id');
		$this->data["jobs"] = $this->application_forms_model->get_job_applications_bystatus($applicant,$status);
		$this->load->view('app/application_form/app_status_applications', $this->data);
	}
	public function get_search($category,$data)
	{
		$applicant = $this->session->userdata('employee_id');
		$this->data["jobs"] = $this->application_forms_model->get_search_job_applications($applicant,$category,$data);
		$this->load->view('app/application_form/app_search_applications', $this->data);
	}
	public function save_answers($job_id)
	{
		$save_questions = $this->application_forms_model->save_applicant_questions($job_id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Answered Question/s are successfully added!</div>");
		
		redirect(base_url().'app/application_forms/applications/',$this->data);
	}
	public function save_requirements_applicant($job_id,$applicant_id,$app_id)
	{
		
		$count = $this->input->post('req_count');
		$picture 			= '';
		$error 				= false;

		$requirements = $this->application_forms_model->get_applicant_requirements($app_id,$applicant_id,$job_id);

		foreach($requirements as $req)
		{
			$i=$req->id;
		
			if(!empty($_FILES['file'.$i]['name'])){
				
                $config['upload_path'] 		= './public/applicant_files/requirements/';
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= $applicant_id.$i.'_'.$currentDateTime;//$_FILES['file']['name'];
                $fileName 					= $config['file_name'];//$_FILES['file']['name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                $file_size = $_FILES['file'.$i]['size'];
               
                $ii = 1;
			    if ($file_size > 2500000000){      
			    	$error = true;
			    }
			    else{
	                if($this->upload->do_upload('file'.$i)){
	                    $uploadData = $this->upload->data();
	                    $picture = $uploadData['file_name'];
	                    
	                    $save_requirement = $this->application_forms_model->save_applicant_requirements($picture,$i,$job_id,$applicant_id,$app_id);
	                	$ii++;
	                }
	            }
       		 }     
		}
		if($ii > 1)
       		 {
       		 	$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$ii." Uploaded Job Requirement/s are successfully added!</div>");
       		 }
       	else
       	{
       		$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>No file found. Please check file.</div>");
       		 
       	}
       	redirect(base_url().'app/application_forms/applications/',$this->data);
	           
        
	}
	public function download_requirements($id)
	{
        $this->load->helper('download');            
		$path    =   file_get_contents(base_url().'public/applicant_files/requirements/'.$id);
		$name    =   $filename;
		force_download($name, $path); 

	}
	public function view_other_applicants($applicant,$job_id)
	{
		$this->data["applicants"] = $this->application_forms_model->view_other_applicants($applicant,$job_id);
		$this->data['job_details'] = $this->application_forms_model->get_job_details($job_id);
		$this->load->view('app/application_form/app_applicants', $this->data);
	}
	public function application_status($id,$applicant_id,$job_id,$process_id,$numbering,$idd)
	{
		$this->data['job_id']=$job_id;
		$this->data['applicant_id']=$applicant_id;
		$this->data['app_id']=$id;
		$this->data['idd']=$idd;
		$this->data['process_id']=$process_id;
		$this->data['numbering']=$numbering;
		$this->data["application"] = $this->application_forms_model->view_application_status($id,$applicant_id,$job_id,$process_id,$numbering,$idd);
		$this->data['job_details'] = $this->application_forms_model->get_job_details($job_id);
		$this->load->view('app/application_form/app_applicants_jobstatus', $this->data);
	}
	public function reschedule_form($response)
	{
		if($response=='reschedule'){
		?>
			<br>
		    <dt>New Date</dt>
            <dd><input type="date" name="new_date" class="form-control" required></dd>
            <br>
            <dt>New Time</dt>
            <dd><input type="time" name="new_time" class="form-control" required></dd>
            <br>
            <dt>Reason</dt>
            <dd><textarea class="form-control" rows="3" name="reason" required></textarea></dd>
         <?php } else{}
	}

	public function save_applicant_response_interview($job_id,$applicant_id,$app_id)
	{
		$response = $this->input->post('response');
		$save_response = $this->application_forms_model->save_applicant_response_interview($response,$app_id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Interview Invitation Response successfully saved!</div>");
       	redirect(base_url().'app/application_forms/applications/',$this->data);
	}


	//additional
	public function final_applicant_response($app_id,$val)
	{
		$save_response = $this->application_forms_model->final_applicant_response($app_id,$val);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Interview Invitation Response successfully saved!</div>");
       	redirect(base_url().'app/application_forms/applications/',$this->data);
	}

	public function referral_points($app_id,$applicant_id,$job_id)
	{
		$this->data['job_id']=$job_id;
		$this->data['applicant_id']=$applicant_id;
		$this->data['app_id']=$app_id;
		$this->data['companyL'] = $this->application_forms_model->CompanyList();
		$this->data['withEmployees'] = $this->application_forms_model->get_with_employees($app_id,$applicant_id);
		$string="";
		foreach($this->data['withEmployees'] as $e)
		{
			$dd =$e->employee_id;
			$string .= $dd."-";
		}
		$this->data['string'] = $string;
		$this->load->view('app/application_form/referral_points', $this->data);
	}

	public function get_all_employees($company)
	{
		
		$this->data['employees'] = $this->application_forms_model->get_all_employees($company);
		$this->load->view('app/application_form/referral_points_employees', $this->data);
	}

	public function get_all_selected_employees($selected)
	{
		$emp = substr_replace($selected, "", -1);
		$var=explode('-',$emp);
	?>
		<table class="table table-hover" id="referral_points_selected">
                      <thead>
                        <tr class="danger">
                          <th></th>
                          <th>Company</th>
                          <th>Employee ID</th>
                          <th>Employee Name</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if($selected=='none'){} else { foreach($var as $e){
                        	$data = $this->application_forms_model->get_emp_details($e);
                        ?>
					      <tr>
					        <td><a style="cursor: pointer;" onclick="remove_selected_emp('<?php echo $e;?>');"><i class="fa fa-times text-danger"></i></a>
					        </td>
					        <td><?php echo $data->company_name;?></td>
					        <td><?php echo $e;?></td>
					        <td><?php echo $data->fullname;?></td>
					      </tr>
					    <?php } } ?>
                      </tbody>
                  </table>
    <?php
		
	}

	public function save_referral_points($job_id,$applicant_id,$app_id)
	{
		$employee_id = $this->input->post('selected_employeee');
		$insert = $this->application_forms_model->save_referral_points($job_id,$applicant_id,$app_id,$employee_id);
		if($employee_id!='')
       		 {
       		 	$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Assigning Employee Referral Points is successfully added!. </div>");
       		 }
       	else
       	{
       		$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Erro.Please select atleast one employee to continue!</div>");
       		 
       	}
    	redirect(base_url().'app/application_forms/applications/',$this->data);
	}


	//update
	public function save_first_interview_response($response,$date,$time,$message_final,$id,$option)
	{
		$insert = $this->application_forms_model->save_first_interview_response($response,$date,$time,$message_final,$id,$option);
	}

	public function save_last_employee_response($id,$response)
	{ 
		$insert = $this->application_forms_model->save_last_employee_response($id,$response);
	}

	public function view_terms_condition($option)
	{
		$this->data['option']=$option;
		$this->data['details'] = $this->application_forms_model->view_terms_condition_policy($option);
		$this->load->view('app/application_form/terms_and_conditions', $this->data);
	}

	public function application_status_updates($id,$employee_info_id,$job_id,$status)
	{

		$this->data['job_id']=$job_id;
		$this->data['status']=$status;
		$this->data['job_application_status_details'] = $this->application_forms_model->job_application_status_details($id);
		$this->data['job_details'] = $this->application_forms_model->get_job_details($job_id);
		$this->load->view('app/application_form/app_applicants_jobstatus_infos', $this->data);
	}

	public function applicant_interviews()
	{
		$this->load->view('app/application_form/header');
		$this->load->view('app/application_form/applicant_interview_calendar_viewing', $this->data);
	}

	public function calendar_viewing_scheduled_interview()
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$data =  $this->application_forms_model->calendar_viewing_scheduled_interview($start,$end);
		echo json_encode($data);
	}	


	//final referral

	public function referral_points_applicant($app_id,$applicant_id,$job_id)
	{
		$this->data['referrals'] = $this->application_forms_model->referrals($app_id,$applicant_id,$job_id);
		$this->data['job_id']=$job_id;
		$this->data['applicant_id']=$applicant_id;
		$this->data['app_id']=$app_id;
		$this->load->view('app/application_form/referral_points_applicants', $this->data);
	}
	
	public function add_referral($name)
	{
		$this->data['name_orig'] = $name;
		$this->data['names'] = $this->application_forms_model->get_names($name);
		$this->load->view('app/application_form/referrals_action', $this->data);
	}

	public function save_referral($app_id,$applicant_id,$job_id,$names)
	{ 
		$insert = $this->application_forms_model->save_referral($app_id,$applicant_id,$job_id,$names);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Applicant Referral is successfully updated!</div>");
	}
}