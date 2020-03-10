	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_training_seminars_final extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/employee_training_seminars_final_model");
		$this->load->model("app/employee_201_profile_model");
		$this->load->model("app/form_approval_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	//settings
	public function index()
	{
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['settings'] = $this->employee_training_seminars_final_model->get_settings();
		$this->load->view('app/employee_training_seminars_final/index',$this->data);
	}



	public function save_settings($company,$setting)
	{
		$insert = $this->employee_training_seminars_final_model->save_settings($company,$setting);
		if($insert=='inserted')
        {
        	$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Training and Seminar setting for company id ".$company." is successfully added!</div>");
        }
        else
        {
        	$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Company ID - ".$company." Setting already exist!</div>");
        }
	}

	public function settings_action($id,$action)
	{
		$setting_action = $this->employee_training_seminars_final_model->settings_action($id,$action);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Training and Seminar setting id ".$id." is successfully ".$action."d!</div>");
	}

	public function settings_action_edit($id,$action)
	{
		$this->data['details'] = $this->employee_training_seminars_final_model->settings_action($id,$action);
		$this->load->view('app/employee_training_seminars_final/setting_update',$this->data);
	}

	public function saveupdate_settings($company,$setting)
	{
		$update = $this->employee_training_seminars_final_model->saveupdate_settings($company,$setting);
		if($update=='updated')
		{
			$msg = 'Training and Seminar setting for company id'.$company.'is successfully updated';
		}
		else
		{
			$msg = 'No changes made in setting company id - '.$company;
		}
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$msg."</div>");
	}

	//file maintenance

	public function file_maintenance()
	{
		$this->data['file_maintenance'] = $this->employee_training_seminars_final_model->file_maintenance_list();
		$this->load->view('app/employee_training_seminars_final/file_maintenance',$this->data);
	}

	public function adding_file_maintenance()
	{
		$this->load->view('app/employee_training_seminars_final/adding_file_maintenance',$this->data);
	}

	public function view_conducted_by_filemaintenance($type,$company)
	{

		if($type=='internal')
		{
			$employees  = $this->employee_training_seminars_final_model->get_employees($company);
			echo '<select class="form-control" name="conducted_by" id="conducted_by">';
			foreach($employees as $em){?>
				<option value="<?php echo $em->employee_id;?>"><?php echo $em->fullname."(".$em->employee_id.")";?></option>
		<?php } echo '</select>';
		}
		else
		{?>	
			<input type="text" class="form-control" name="conducted_by" id="conducted_by" required>
		<?php }
	}		

	public function get_dates_file_maintenance($from_date,$to_date,$type)
	{
		$this->data['from_date'] = $from_date;
		$this->data['to_date'] = $to_date;
		$this->data['type'] = $type;
		$this->load->view('app/employee_training_seminars_final/file_maintenance_adding_dates',$this->data);
	}

	public function save_file_maintenance()
	{
        $add = $this->employee_training_seminars_final_model->save_file_maintenance();
        $this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>FILE MAINTENANCE TRAINING AND SEMINAR successfully added.</div>");
			
		$this->session->set_flashdata('onload',"file_maintenance()");
		redirect(base_url().'app/employee_training_seminars_final/index',$this->data);	
	}

	public function file_maintence_trainingseminars_filtering($company)
	{
		$this->data['file_maintenance'] = $this->employee_training_seminars_final_model->filtering_file_maintenance($company);
		$this->load->view('app/employee_training_seminars_final/filtering_file_maintenance',$this->data);
	}

	public function delete_fincoming_trainings($id)
	{	
		$delete = $this->employee_training_seminars_final_model->delete_fincoming_trainings($id);
		$this->session->set_flashdata('onload',"file_maintenance()");

		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> FILE MAINTENANCE TRAINING AND SEMINAR id ".$id." successfully deleted.</div>");
	}

	public function view_fincoming_trainingsseminars($id)
	{

		$this->data['details'] = $this->employee_training_seminars_final_model->get_fincoming_trainingseminars($id);
		$this->data['dates'] = $this->employee_training_seminars_final_model->get_fincoming_trainingseminars_date($id);
		$this->load->view('app/employee_training_seminars_final/view_file_maintenance',$this->data);
	}

	public function edit_fincoming_trainingsseminars($id)
	{
		$this->data['id']=$id;
		$this->data['details'] = $this->employee_training_seminars_final_model->get_fincoming_trainingseminars($id);
		$this->data['dates'] = $this->employee_training_seminars_final_model->get_fincoming_trainingseminars_date($id);
		$this->load->view('app/employee_training_seminars_final/edit_file_maintenance',$this->data);
	}

	public function filemaintenance_training_seminar_modify($id){

		$this->employee_training_seminars_final_model->fincoming_trainingseminar_save_modify($id);
		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>FILE MAINTENANCE TRAINING AND SEMINAR successfully modified.</div>");
			
		$this->session->set_flashdata('onload',"file_maintenance()");
		redirect(base_url().'app/employee_training_seminars_final/index',$this->data);
	}

	public function get_datess_incoming_file_maintenance($from_date,$to_date,$type,$seminarid)
	{	
		
		$this->data['seminarid'] = $seminarid;
		$this->data['from_date'] = $from_date;
		$this->data['to_date'] = $to_date;
		$this->data['type'] = $type;
		$this->load->view('app/employee_training_seminars_final/file_maintenance_edit_dates',$this->data);

	}


	//individual adding

	public function individual_adding()
	{
		$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view('app/employee_training_seminars_final/individual_adding',$this->data);
	}


	public function ip_employee_list($company,$location,$search)
	{
		$this->data['query'] = $this->employee_training_seminars_final_model->employeelist_model($search,$company,$location);		
		$this->load->view('app/employee_training_seminars_final/search_employee_list',$this->data);
	}

	public function get_individual_ts($employee_id)
	{
		echo "<a href='".base_url()."app/employee_201_profile/training_seminar_view/".$employee_id."' target='_blank' style='font-size:20px;'><i class='fa fa-external-link btn-lg'></i></a>";
	}

	public function get_location($company)
	{
		$locationList = $this->employee_training_seminars_final_model->locationList($company);
		if(empty($locationList)){ echo "<option value=''>No location found.Please add first to continue.</option>"; }
		else
		{
			echo "  
					<option value='all' selected>All</option>";
			foreach($locationList as $loc)
			{
				echo "<option value='".$loc->location_id."'>".$loc->location_name."</option>";
			}
		}
	}

	public function get_all_trainingslist_filemaintenance($company_id,$val,$sub_type,$type)
	{
		$trainings_seminar = $this->employee_training_seminars_final_model->get_all_trainingslist_filemaintenance($val,$company_id,$sub_type,$type);
		if(empty($trainings_seminar)){ echo "<option value=''>No Trainings and Seminars found.</option>"; }
		else
		{
			echo "<option value=''>Select Trainings and Seminars.".$val."=".$company_id."=".$sub_type."</option>"; 
			foreach($trainings_seminar as $ts)
			{
				echo "<option value='".$ts->id."'>".$ts->training_title."</option>"; 
			}
		}
		
	}

	public function get_all_trainings_details($training_id)
	{
		$this->data['id']=$training_id;
		$this->data['dates'] = $this->employee_training_seminars_final_model->get_all_trainings_details_dates($training_id);
		$this->data['details'] = $this->employee_training_seminars_final_model->get_all_trainings_details($training_id);
		$this->load->view('app/employee_training_seminars_final/file_maintenance_training_details',$this->data);
	}

	public function save_individual_adding($type)
	{
		$picture 			= '';
		$error 				= false;
		$employee_id = $this->input->post('employee_id');
		if(!empty($_FILES['file']['name'])){
                $config['upload_path'] 		= './public/employee_files/training_seminar';
                 $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= "training_seminar".'_'.$employee_id.'_'.$currentDateTime;
                $fileName 					= $config['file_name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                $file_size = $_FILES['file']['size'];
              
			    if ($file_size > 2500000000){      
			    	$error = true;
			    	$msg = 'Sorry uploaded file exceeds the maximum limit size!';	
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

        if($error==false)
        {
        	$add = $this->employee_training_seminars_final_model->save_individual_adding($employee_id,$picture);
        	$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> TRAINING AND SEMINAR of employee id ".$employee_id." successfully added.</div>");
        	General::logfile('Employee 201->TrainingSeminar','INSERT',$employee_id);
        }
        else
        {
        	$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$msg."</div>");
        	
        }
		
		if($type=='individual_adding')
		{
			$this->session->set_flashdata('onload',"individual_adding()");
			redirect('app/employee_training_seminars_final/index/',$this->data);
		}
		else
		{

			redirect('app/employee_201_profile/training_seminar_view/'.$employee_id);
		}

	}

	//mass adding

	public function mass_adding()
	{
		$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view('app/employee_training_seminars_final/mass_adding',$this->data);
	}

	
	public function get_all_trainings_details_mass_adding($training_id)
	{
		$this->data['id']=$training_id;
		$this->data['dates'] = $this->employee_training_seminars_final_model->get_all_trainings_details_dates($training_id);
		$this->data['details'] = $this->employee_training_seminars_final_model->get_all_trainings_details($training_id);
		$this->load->view('app/employee_training_seminars_final/file_maintenance_training_details_mass_adding',$this->data);
	}

	public function add_mass_employees($company_id)
	{
		$this->data['company_id'] = $company_id;
		$this->load->view('app/employee_training_seminars_final/mass_adding_employee_modal',$this->data);
	}
	
	public function get_filtered_employees($company,$location,$classification,$department,$sectin,$subsection)
	{
		$this->data['query']=$this->employee_training_seminars_final_model->get_filtered_employees($company,$location,$classification,$department,$sectin,$subsection);
		$this->load->view('app/employee_training_seminars_final/mass_filtered_employees',$this->data);
	}

	public function getemp_location($company)
	{
		$locationList = $this->employee_training_seminars_final_model->locationList($company);

		if(empty($locationList))
		{
			echo "<option value='not_included'>No location found</option>";
		}
		else
		{
			echo "<option value='not_included' selected disabled>Select</option>";
			echo "<option value='all'>All</option>";
			foreach($locationList as $loc){?>
				<option value="<?php echo $loc->location_id;?>"><?php echo $loc->location_name;?></option>
			<?php }
		}
	}


	public function getemp_classification($company)
	{
		$classificationList = $this->form_approval_model->classificationList($company);
		if(empty($classificationList))
		{
			echo "<option value='not_included'>No classification found</option>";
		}
		else
		{
			echo "<option value='not_included' selected disabled>Select</option>";
			echo "<option value='all'>All</option>";
			foreach($classificationList as $c){
				echo '<option value="'.$c->classification_id.'">'.$c->classification.'</option>';
			 }
		}
	}

	public function getemp_department($company)
	{
		$departmentList = $this->employee_training_seminars_final_model->departmentList($company);
		if(empty($departmentList))
		{
			echo "<option value='not_included'>No department found</option>";
		}
		else
		{
			echo "<option value='not_included' selected disabled>Select</option>";
			echo "<option value='all'>All</option>";
			foreach($departmentList as $d){
				echo '<option value="'.$d->department_id.'">'.$d->dept_name.'</option>';
			 }
		}
	}


	public function getemp_section($department,$company)
	{
		$sectionList = $this->employee_training_seminars_final_model->sectionList($department,$company);
		if(empty($sectionList))
		{
			echo "<option value='not_included'>No section found</option>";
		}
		else
		{
			echo "<option value='not_included' selected disabled>Select</option>";
			echo "<option value='all'>All</option>";
			foreach($sectionList as $d){
				echo '<option value="'.$d->section_id.'">'.$d->section_name.'</option>';

			 }
		}
	}


	public function getemp_subsection($section,$department,$company)
	{
		$subsectionList = $this->employee_training_seminars_final_model->subsectionList($section,$department,$company);
		if(empty($subsectionList))
		{
			echo "<option value='not_included'>No subsection found</option>";
		}
		else
		{
			echo "<option value='not_included' selected disabled>Select</option>";
			echo "<option value='all'>All</option>";
			foreach($subsectionList as $d){

			echo '<option value="'.$d->subsection_id.'">'.$d->subsection_name.'</option>';

			 }
		}
	}

	public function mass_add_emp($employees,$company)
	{
		$this->data['employees']=$employees;
		$this->data['company'] = $company;
		$this->load->view('app/employee_training_seminars_final/mass_selected_employees',$this->data);

	}


	public function save_mass_adding()
	{
		$picture 			= '';
		$error 				= false;
		if(!empty($_FILES['file']['name'])){
                $config['upload_path'] 		= './public/employee_files/training_seminar';
                 $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= "training_seminar".'_'.'mass_adding'.'_'.$currentDateTime;
                $fileName 					= $config['file_name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                $file_size = $_FILES['file']['size'];
              
			    if ($file_size > 2500000000){      
			    	$error = true;
			    	$msg = 'Sorry uploaded file exceeds the maximum limit size!';	
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
      
       	 if($error==false)
        {
        	$finalemployee = $this->input->post('finalemployee');
			$var = explode("-",$finalemployee);
			$add = $this->employee_training_seminars_final_model->save_mass_adding($finalemployee,$picture);
        	$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> MASS ADDING OF TRAINING AND SEMINAR ATTAINMENT successfully added.</div>");
		
        	foreach($var as $em)
			{
				General::logfile('Employee 201->TrainingSeminar','INSERT',$em);
			}
        }
        else
        {
        	$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$msg."</div>");
        	
        }
		$this->session->set_flashdata('onload',"mass_adding()");
		redirect('app/employee_training_seminars_final/index/',$this->data);
		

	}

	public function viewing_of_incoming_trainings_seminar()
	{ 
		$this->data['details'] = $this->employee_training_seminars_final_model->incoming_trainings_seminar();
		$this->load->view('app/employee_training_seminars_final/viewing_of_incoming_trainings_seminar',$this->data);
	}


	public function add_incoming_trainings_seminar()
	{
		$this->load->view('app/employee_training_seminars_final/incoming_trainings_seminars_adding',$this->data);
	}


	public function get_all_trainings_details_incoming($training_id)
	{
		$this->data['id']=$training_id;
		$this->data['dates'] = $this->employee_training_seminars_final_model->get_all_trainings_details_dates($training_id);
		$this->data['details'] = $this->employee_training_seminars_final_model->get_all_trainings_details($training_id);
		$this->load->view('app/employee_training_seminars_final/incoming_trainings_seminars_details',$this->data);
	}

	public function save_incoming_trainings()
	{
		$picture 			= '';
		$error 				= false;
		if(!empty($_FILES['file']['name'])){
                $config['upload_path'] 		= './public/employee_files/training_seminar';
                 $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= "training_seminar".'_'.'incoming'.'_'.$currentDateTime;
                $fileName 					= $config['file_name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                $file_size = $_FILES['file']['size'];
              
			    if ($file_size > 2500000000){      
			    	$error = true;
			    	$msg = 'Sorry uploaded file exceeds the maximum limit size!';	
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
      
       	 if($error==false)
        {
        	$finalemployee = $this->input->post('finalemployee');
			$var = explode("-",$finalemployee);
			$add = $this->employee_training_seminars_final_model->save_incoming_trainings($finalemployee,$picture);
        	$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> INCOMING TRAINING AND SEMINAR ATTAINMENT successfully added.</div>");
		
        }
        else
        {
        	$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$msg."</div>");
        	
        }
		$this->session->set_flashdata('onload',"viewing_of_incoming_trainings_seminar()");

		redirect(base_url().'app/employee_training_seminars_final/index',$this->data);
	}


	public function filter_incoming_by_company($company)
	{
		$details = $this->employee_training_seminars_final_model->get_filter_bycompany($company);
		$system_defined_icons = $this->general_model->system_defined_icons();

	?>

		 <table class="table table-hover" id="incomingtrainings">
            <thead>
                <tr class="danger">
                  <th>ID</th>
                  <th>Training Title</th>
                  <th>Date Added</th>
                  <th>Training Date</th>
                  <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($details as $d){?>
              <tr>
                  <td><?php echo $d->training_seminar_id;?></td>
                  <td><?php echo $d->training_title;?></td>
                  <td>
                        <?php 
                          $month=substr($d->date_added, 5,2);
                          $day=substr($d->date_added, 8,2);
                          $year=substr($d->date_added, 0,4);

                          echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                        ?>
                  </td>
                  <td>
                     <?php 
                          $month=substr($d->datefrom, 5,2);
                          $day=substr($d->datefrom, 8,2);
                          $year=substr($d->datefrom, 0,4);

                          $month1=substr($d->dateto, 5,2);
                          $day1=substr($d->dateto, 8,2);
                          $year1=substr($d->dateto, 0,4);


                          $from = date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                          $to = date("F", mktime(0, 0, 0, $month1, 10))." ". $day1.", ". $year1;

                          if($from==$to){ echo $from; } else{ echo $from." to ".$to; }
                        ?>

                  </td>
                  <td>
                       <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="edit_incoming_trainingsseminars(<?php echo $d->training_seminar_id;?>);"  aria-hidden='true' data-toggle='tooltip' title='Update Settings'><i class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>

                       <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="view_incoming_trainingsseminars(<?php echo $d->training_seminar_id;?>);" aria-hidden='true' data-toggle='tooltip' title='Update Settings'><i class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>

                       <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="delete_incoming_trainings(<?php echo $d->training_seminar_id;?>);" aria-hidden='true' data-toggle='tooltip' title='Delete Incoming Trainings and Semianr'><i class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>

                  </td>
              </tr>
            <?php } ?>
            </tbody>
        </table>


	<?php 
	}	

	public function delete_incoming_trainings($id)
	{	
		$delete = $this->employee_training_seminars_final_model->delete_incoming_trainings($id);
		$this->session->set_flashdata('onload',"viewing_of_incoming_trainings_seminar()");

		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> INCOMING TRAINING AND SEMINAR id ".$id." successfully deleted.</div>");

	}

	public function view_incoming_trainingsseminars($id)
	{	
		$this->data['details'] = $this->employee_training_seminars_final_model->get_incoming_trainingseminars($id);
		$this->data['dates'] = $this->employee_training_seminars_final_model->get_incoming_trainingseminars_date($id);
		$this->data['employees'] = $this->employee_training_seminars_final_model->get_incoming_trainingseminars_employees($id);
		$this->load->view('app/employee_training_seminars_final/view_incoming_trainingsseminars',$this->data);
	}

	public function edit_incoming_trainingsseminars($id)
	{
		$this->data['id'] = $id;
		$this->data['details'] = $this->employee_training_seminars_final_model->get_incoming_trainingseminars($id);
		$this->data['dates'] = $this->employee_training_seminars_final_model->get_incoming_trainingseminars_date($id);
		$this->data['employees'] = $this->employee_training_seminars_final_model->get_incoming_trainingseminars_employees($id);
		$this->load->view('app/employee_training_seminars_final/edit_incoming_trainingsseminars',$this->data);	
		
	}


	public function get_datess_incoming($from_date,$to_date,$type,$seminarid)
	{	
				$begin = new DateTime( $from_date );
				$end = new DateTime( $to_date );
				$end = $end->modify( '+1 day' );

				$interval = new DateInterval('P1D');
				$daterange = new DatePeriod($begin, $interval ,$end);
				?>
			
				<table style="width: 100%;">
				<tbody>
				<?php
				$i=1;
				$string="";
				foreach($daterange as $date)
				{
					$datee = $date->format('Y-m-d');
					$string .= $i."=";
					$date_details = $this->employee_training_seminars_final_model->get_date_details_incoming($datee,$seminarid);

				?>
				<tr>
					<td colspan="2">
							<input type="checkbox" onclick="checker_date_range('<?php echo $i;?>');" class="dateclass" checked> <?php echo $date->format('Y-m-d');?> 
							<input type="hidden" name='date_<?php echo $i?>' id='date_<?php echo $i?>' value='<?php echo $date->format('Y-m-d');?>'>
							<input type='hidden' id="checker<?php echo $i;?>" value='1'> 
					</td>
					
				</tr>
				<tr>
						
					<td>	
							<input type="time" style="width: 90%;font-color:red;" name='time_from<?php echo $i?>' id='time_from<?php echo $i?>' class="classtimefrom" value="<?php if(!empty($date_details->time_from)){ echo $date_details->time_from; };?>">	
					</td>
					<td>	
							<input type="time" style="width: 90%;" name='time_to<?php echo $i?>' id='time_to<?php echo $i?>' class="classtimeto" value="<?php if(!empty($date_details->time_to)){ echo $date_details->time_to; };?>">						
					</td>
					<td>	
							<input type="number" style="width: 50%;" name='hour<?php echo $i?>' id='hour<?php echo $i?>' class="classhour" placeholder="Hours" value="<?php if(!empty($date_details->hours)){ echo $date_details->hours; };?>">	
					</td>
						
				</tr>
				<?php $i++; } ?>
					
				</table>
				<input type="hidden" id="count_dates" value="<?php echo $i;?>">
				<input type="hidden" id="selected_dates"  name="selected_dates" value="<?php echo $string;?>" class="form-control" required>


				 <?php

	}

	public function incomingtraining_seminar_modify($id){

		$this->employee_training_seminars_final_model->incomingtrainingseminar_save_modify($id);
		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>FILE MAINTENANCE TRAINING AND SEMINAR successfully modified.</div>");
			
		$this->session->set_flashdata('onload',"viewing_of_incoming_trainings_seminar()");
		redirect(base_url().'app/employee_training_seminars_final/index',$this->data);
	}

	public function view_assign_employee($company_id)
	{ ?> 
		<a style="cursor: pointer;" id="show_selection_employee" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/employee_training_seminars_final/add_mass_employees/'.$company_id.'');?>" class="pull-right" ><i class="fa fa-user"></i>Assign Employee</a>
	<?php }


	
}//end controller



