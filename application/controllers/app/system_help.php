<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class System_help extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/system_help_model");
		$this->load->model("app/system_help_link_settings_model");
		$this->load->model("recruitment_employer/recruitment_employer_model");
		$this->load->model("app/application_form_model");
		//$this->load->model("employee_portal/pms_model");
		$this->load->model("general_model");
		
		General::variable();
	}
	
	public function file_maintenance()
	{
		$this->data['active'] = $this->session->flashdata('active');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['user_category'] = $this->system_help_link_settings_model->get_details('portal');
		$this->load->view('app/system_help/file_maintenance/index',$this->data);
	}

	public function system_help_file_maintenance_action($portal,$module)
	{
		$this->data['portal'] = $portal;
		$this->data['module'] = $module;
		$this->data['topic'] = $this->system_help_model->get_topic_details($module,$portal);
		$this->data['details'] = $this->system_help_model->portal_module_details($portal,$module);
		$this->data['file_maintenance'] = $this->system_help_model->system_help_file_maintenance($portal,$module);
		$this->load->view('app/system_help/file_maintenance/system_help_file_maintenance',$this->data);
	}
		
	public function get_sub_topic_list($topic)
	{
		$topic_ = $this->system_help_model->get_sub_topic_list($topic);
		if(empty($topic_))
		{
			echo "<option value=''>No Subtopic found. Please add to continue.</option>";
		}
		else
		{
			echo "<option value=''>Select Subtopic</option>";
			foreach($topic_ as $top)
			{
				echo "<option value='".$top->subtopic_id."'>".$top->subtopic."</option>";
			}
		}
	}

	public function save_system_help_file_maintenance($portal,$module)
	{
		$picture 			= '';
		$error 				= false;
		if(!empty($_FILES['file']['name'])){
                $config['upload_path'] 		= './public/system_help_files/';
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= "file".$module.'_'.$currentDateTime;
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
	                    $error=false;
	                    $msg='Uploaded';
	                }
	                else
	                {
	                	$msg = 'The filetype you are attempting to upload is not allowed!';
	                	$error=true;
	                	$picture='';
	                }
	            }
	           
        }
        else
        {
        	$error='no_file';
        	$msg='no_file';
	        $picture='';
        }
        
        if($error==true AND $error!='no_file')
		{
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Sorry.".$msg."</div>");	
		}
		else
		{
			$question = $this->input->post('question');
			$insert = $this->system_help_model->save_system_help_file_maintenance($portal,$module,$question,$picture);
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Question - ".$question." is Successfully Added!</div>");	
		}
		$this->session->set_flashdata('active',$portal);
		$this->session->set_flashdata('onload',"system_help_file_maintenance_action('".$portal."','".$module."')");
		redirect(base_url().'app/system_help/file_maintenance',$this->data);
	}

	public function file_maintenance_action($portal,$module,$id,$action)
	{

		$actionn = $this->system_help_model->file_maintenance_action($portal,$module,$id,$action);
		$this->session->set_flashdata('onload',"system_help_file_maintenance_action('".$portal."','".$module."')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>System Help File Maintenance iD - ".$id." is Successfully ".$action."d!</div>");
	}

	public function save_file_maintenance_update($id,$question_final,$answer_final,$portal,$module,$file)
	{
		
		$update = $this->system_help_model->save_file_maintenance_update($portal,$module,$id,$question_final,$answer_final);
		$this->session->set_flashdata('onload',"system_help_file_maintenance_action('".$portal."','".$module."')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>System Help File Maintenance iD - ".$id." is Successfully Updated!</div>");
	}

	public function manage_keywords($id,$portal,$module)
	{
		$this->data['id'] = $id;
		$this->data['portal'] = $portal;
		$this->data['module'] = $module;
		$this->data['keywords'] = $this->system_help_model->keyword_list($id);
		$this->data['question_details'] = $this->system_help_model->question_details($id);
		$this->load->view('app/system_help/file_maintenance/manage_keywords',$this->data);
	}

	public function save_keyword($id,$keyword_final,$portal,$module)
	{

		$this->data['portal'] = $portal;
		$this->data['module'] = $module;
		$this->data['id'] = $id;
		$this->data['flash_id']=$id;
		$this->data['action_']='add';
		$this->session->set_flashdata('success_inserted',"Success");
		$insert = $this->system_help_model->save_keyword($id,$keyword_final);
		$this->data['keywords'] = $this->system_help_model->keyword_list($id);
		$this->load->view('app/system_help/file_maintenance/manage_keywords_details',$this->data);
	}

	public function function_reload_keyword($portal,$module)
	{
		$this->session->set_flashdata('onload',"system_help_file_maintenance_action('".$portal."','".$module."')");
	}

	public function delete_keywords($portal,$module,$id,$idd)
	{
		$this->data['portal'] = $portal;
		$this->data['module'] = $module;	
		$this->data['id'] = $idd;
		$this->data['flash_id']=$id;
		$this->data['action_']='delete';
		$this->session->set_flashdata('success_deleted',"Deleted");
		$delete = $this->system_help_model->delete_keywords($id);
		$this->data['keywords'] = $this->system_help_model->keyword_list($idd);
		$this->load->view('app/system_help/file_maintenance/manage_keywords_details',$this->data);
		
	}

	public function save_keyword_update($id,$portal,$module,$keyword,$idd)
	{
		$this->data['portal'] = $portal;
		$this->data['module'] = $module;	
		$this->data['id'] = $idd;
		$this->data['flash_id']=$id;
		$this->data['action_']='update';
		$this->session->set_flashdata('success_updated',"Updated");
		$update = $this->system_help_model->update_keywords($id,$keyword);
		$this->data['keywords'] = $this->system_help_model->keyword_list($idd);
		$this->load->view('app/system_help/file_maintenance/manage_keywords_details',$this->data);
	}

	public function filter_system_help_file_maintenance($portal,$module,$topic,$subtopic)
	{
		$this->data['portal'] = $portal;
		$this->data['module'] = $module;
		$this->data['topic'] = $this->system_help_model->get_topic_details($module,$portal);
		$this->data['details'] = $this->system_help_model->portal_module_details($portal,$module);
		$this->data['file_maintenance'] = $this->system_help_model->system_help_file_maintenance_filter($portal,$module,$topic,$subtopic);
		$this->load->view('app/system_help/file_maintenance/system_help_file_maintenance_filter',$this->data);
	}

	public function download_system_help($filename)
	{

        $this->load->helper('download');            
		$path    =   file_get_contents(base_url().'public/system_help_files/'.$filename);
		$name    =   $filename;
		force_download($name, $path); 

		$value = $name;

		General::logfile('System_Help_Attachment','DOWNLOAD',$value);

	}

	public function file_maintenance_action_update_form($id,$portal,$module)
	{
		$this->data['portal'] = $portal;
		$this->data['module'] = $module;
		$this->data['id'] = $id;
		$this->data['topic'] = $this->system_help_model->get_topic_details($module,$portal);
		$this->data['details'] = $this->system_help_model->get_topic_details_id($id);
		foreach($this->data['details'] as $dd)
		{
			$this->data['subtopic'] = $this->system_help_model->get_sub_topic_list($dd->topic_id);
		}
		$this->load->view('app/system_help/file_maintenance/system_help_file_maintenance_update',$this->data);
	}

	public function save_system_help_file_maintenance_update($portal,$module)
	{
		$picture 			= '';
		$error 				= false;
		if(!empty($_FILES['file']['name'])){
                $config['upload_path'] 		= './public/system_help_files/';
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= "file".$module.'_'.$currentDateTime;
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
	                    $error=false;
	                    $msg='Uploaded';
	                }
	                else
	                {
	                	$msg = 'The filetype you are attempting to upload is not allowed!';
	                	$error=true;
	                	$picture='';
	                }
	            }
	           
        }
        else
        {
        	$error='no_file';
        	$msg='no_file';
	        $picture='';
        }
        
        if($error==true AND $error!='no_file')
		{
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Sorry.".$msg."</div>");	
		}
		else
		{
			$id = $this->input->post('system_help_id');
			$update = $this->system_help_model->save_file_maintenance_update($id,$picture);
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Question ID - ".$id." is Successfully Updated!</div>");	
		}
		$this->session->set_flashdata('onload',"system_help_file_maintenance_action('".$portal."','".$module."')");
		redirect(base_url().'app/system_help/file_maintenance',$this->data);

	}








	//SYSTEM HELP

	public function system_help()
	{
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['portal_list'] = $this->system_help_model->get_details_portal_filtering();
		$this->data['user_category'] = $this->system_help_link_settings_model->get_details('portal');
		$this->load->view('app/system_help/system_help/index',$this->data);
	}

	public function system_help_action($portal,$module)
	{
		$this->data['portal'] = $portal;
		$this->data['module'] = $module;

		$this->data['topic'] = $this->system_help_model->get_topic_details($module,$portal);
		$this->data['details'] = $this->system_help_model->portal_module_details($portal,$module);
		$this->load->view('app/system_help/system_help/system_help_search',$this->data);
	}

	public function search_now($search,$option)
	{
		$searchh = $this->system_help_model->convert_search($search);
		$this->data['portal_list'] = $this->system_help_model->get_details_portal_filtering();
		$this->data['search'] = $searchh;
		$this->data['results'] = $this->system_help_model->search_now($searchh,$option);
		$this->load->view('app/system_help/system_help/search_result',$this->data);
	}

	public function get_module_list($portal)
	{
		$module = $this->system_help_model->get_module_list($portal);

		if(empty($module))
		{
			echo "<option value=''>No Module Found.</option>";
		}
		else
		{
			echo "<option value=''>Select Module</option>";
			echo "<option value='All'>All</option>";
			foreach($module as $m)
			{
				echo "<option value='".$m->module_id."'>".$m->module."</option>";
			}
		}
		
	}

	public function get_topic_list($portal,$module)
	{
		$topic = $this->system_help_model->get_topic_list($portal,$module);

		if(empty($topic))
		{
			echo "<option value=''>No Topic Found.</option>";
		}
		else
		{
			echo "<option value=''>Select Topic</option>";
			echo "<option value='All'>All</option>";
			foreach($topic as $t)
			{
				echo "<option value='".$t->topic_id."'>".$t->topic."</option>";
			}
		}
	}
	public function get_subtopic_list($portal,$module,$topic)
	{
		$subtopic = $this->system_help_model->get_subtopic_list($portal,$module,$topic);

		if(empty($subtopic))
		{
			echo "<option value=''>No Subtopic Found.".$subtopic."</option>";
		}
		else
		{
			echo "<option value=''>Select Subtopic</option>";
			echo "<option value='All'>All</option>";
			foreach($subtopic as $s)
			{
				echo "<option value='".$s->subtopic_id."'>".$s->subtopic."</option>";
			}
		}
	}


	public function filter_results($portal,$module,$topic,$subtopic)
	{
		$this->data['filter'] = array($portal,$module,$topic,$subtopic);
		$this->data['portal_list'] = $this->system_help_link_settings_model->get_details('portal');
		$this->data['results'] = $this->system_help_model->filter_results($portal,$module,$topic,$subtopic);
		$this->load->view('app/system_help/system_help/filter_result',$this->data);
	}


	public function search_filter_results($portal,$module,$topic,$subtopic,$search)
	{

		$searchh = $this->system_help_model->convert_search($search);
		$this->data['search'] = $searchh;
		$this->data['results'] = $this->system_help_model->search_filter_now($portal,$module,$topic,$subtopic,$searchh);
		$this->load->view('app/system_help/system_help/search_result_filter',$this->data);
		
	}

	public function keyword_search($search,$portal,$module,$topic,$subtopic)
	{
		$searchh = $this->system_help_model->convert_search($search);
		$this->data['search'] = $searchh;
		$this->data['results'] = $this->system_help_model->search_filter_now($portal,$module,$topic,$subtopic,$searchh);
		$this->load->view('app/system_help/system_help/search_result_filter',$this->data);
	}

}//end controller
 	


