<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class System_help_link_settings extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/system_help_link_settings_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index()
	{
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view('app/admin_help_links_setting/index',$this->data);
	}
	
	public function setting_main($option)
	{
		$this->data['option'] = $option;
		if($option=='portal')
		{
			$this->data['details'] = $this->system_help_link_settings_model->get_details($option);
		}
		else if($option=='category')
		{
			$this->data['portal_details'] = $this->system_help_link_settings_model->get_details('portal');
			$this->data['details'] = $this->system_help_link_settings_model->get_details($option);
		}
		else if($option=='module')
		{
			$this->data['portal_details'] = $this->system_help_link_settings_model->get_details('portal');
			$this->data['details'] = $this->system_help_link_settings_model->get_details($option);
		}
		else if($option=='topic')
		{
			$this->data['portal_details'] = $this->system_help_link_settings_model->get_details('portal');
			$this->data['details'] = $this->system_help_link_settings_model->get_details($option);
		}
		else
		{
			$this->data['portal_details'] = $this->system_help_link_settings_model->get_details('portal');
			$this->data['details'] = $this->system_help_link_settings_model->get_details($option);
		}

		$this->load->view('app/admin_help_links_setting/setting',$this->data);
	}

	public function save_portal($option)
	{
		$portal = $this->input->post('portal');
		$insert = $this->system_help_link_settings_model->save_portal($portal);
		$this->session->set_flashdata('onload',"setting('portal')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>User Category Setting - ".$portal."<strong>".$value."</strong>, is Successfully Added!</div>");
		redirect(base_url().'app/system_help_link_settings/index',$this->data);
	}

	public function portal_action($action,$id,$table,$onload,$id_name)
	{
		if($onload=='portal'){ $ti = 'User Category'; } else if($onload=='category')  { $ti = 'Module'; } else if($onload=='module'){ $ti = 'Topic'; } else{ $ti = 'Sub topic'; }
		$actionn = $this->system_help_link_settings_model->portal_action($action,$id,$table,$id_name);
		$this->session->set_flashdata('onload',"setting('".$onload."')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$ti." Setting - ".$id." is Successfully ".$action."d!</div>");
		
	}

	public function portal_update($id,$option,$id_name,$table)
	{
		$this->data['option'] = $option;

		$this->data['details'] = $this->system_help_link_settings_model->details($id,$id_name,$table);

		if($option=='category')
		{
			$this->data['portal_details'] = $this->system_help_link_settings_model->get_details('portal');
		}
		else if($option=='module')
		{

			$this->data['portal_details'] = $this->system_help_link_settings_model->get_details('portal');
			foreach($this->data['details'] as $cc)
			{ 
				$this->data['category_details'] = $this->system_help_link_settings_model->get_portal_category($cc->portal_id);
			}
		}
		else if($option=='topic')
		{
			$this->data['topic_details'] = $this->system_help_link_settings_model->get_details('topic');
			foreach($this->data['details'] as $cc)
			{
				$this->data['portal_details'] = $this->system_help_link_settings_model->get_details('portal');
				$this->data['module_details'] = $this->system_help_link_settings_model->get_portal_category($cc->portal_id);
				$this->data['topic_details'] = $this->system_help_link_settings_model->get_portal_module($cc->module_id);
			}
		}
		$this->load->view('app/admin_help_links_setting/update',$this->data);

	}

	public function save_update_portal($option)
	{
		$portal = $this->input->post('portal');
		$id = $this->input->post('portal_id');
		$insert = $this->system_help_link_settings_model->save_update_portal($id,$portal);
		$this->session->set_flashdata('onload',"setting('".$option."')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>User Category ID - ".$id." is Successfully Updated!</div>");
		redirect(base_url().'app/system_help_link_settings/index',$this->data);
	}


	//category
	public function save_category($option)
	{
		$category = $this->input->post('category');
		$portal = $this->input->post('portal');
		$insert = $this->system_help_link_settings_model->save_category($category,$portal);
		$this->session->set_flashdata('onload',"setting('category')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Module Setting - ".$category."<strong>".$value."</strong>, is Successfully Added!</div>");
		redirect(base_url().'app/system_help_link_settings/index',$this->data);
	}


	public function save_update_modules($option)
	{
		$portal = $this->input->post('portal');
		$category = $this->input->post('category');
		$id = $this->input->post('module_id');
		$insert = $this->system_help_link_settings_model->save_update_modules($id,$portal,$category);
		$this->session->set_flashdata('onload',"setting('".$option."')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Module ID - ".$id." is Successfully Updated!</div>");
		redirect(base_url().'app/system_help_link_settings/index',$this->data);
	}


	//module

	public function onchange_get_category($portal)
	{
		$module = $this->system_help_link_settings_model->onchange_get_category($portal);
		if(empty($module))
		{
			echo "<option value=''>No Module found.</option>";
		}
		else
		{
			echo "<option value=''>Select Module</option>";
			foreach($module as $c)
			{
				echo "<option value='".$c->module_id."'>".$c->module."</option>";
			}
		}
		
	}

	public function save_module($option)
	{
		$portal = $this->input->post('portal');
		$topic = $this->input->post('topic');
		$module = $this->input->post('module');
		$insert = $this->system_help_link_settings_model->save_module($portal,$topic,$module);
		$this->session->set_flashdata('onload',"setting('module')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Module Topic Setting - ".$module." is Successfully Added!</div>");
		redirect(base_url().'app/system_help_link_settings/index',$this->data);
	}

	public function save_update_topic($option)
	{
		$portal = $this->input->post('portal');
		$topic = $this->input->post('topic');
		$module = $this->input->post('module');
		$id = $this->input->post('topic_id');
		$insert = $this->system_help_link_settings_model->save_update_topic($id,$portal,$topic,$module);
		$this->session->set_flashdata('onload',"setting('".$option."')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Module Topic ID - ".$id." is Successfully Updated!</div>");
		redirect(base_url().'app/system_help_link_settings/index',$this->data);

	}

	public function onchange_get_module($category)
	{
		$module = $this->system_help_link_settings_model->onchange_get_module($category);
		if(empty($module))
		{
			echo "<option value=''>No module found.</option>";
		}
		else
		{
			echo "<option value=''>Select Module</option>";
			foreach($module as $c)
			{
				echo "<option value='".$c->topic_id."'>".$c->topic."</option>";
			}
		}
	}

	public function save_subtopic($option)
	{
		$portal = $this->input->post('portal');
		$category = $this->input->post('category');
		$module = $this->input->post('module');
		$topic = $this->input->post('topic');
		$subtopic = $this->input->post('subtopic');
		$insert = $this->system_help_link_settings_model->save_subtopic($portal,$category,$module,$topic,$subtopic);
		$this->session->set_flashdata('onload',"setting('topic')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Module Sub Topic Setting - ".$topic." is Successfully Added!</div>");
		redirect(base_url().'app/system_help_link_settings/index',$this->data);
	}

	public function onchange_get_topic($module)	
	{
		$topic = $this->system_help_link_settings_model->onchange_get_topic($module);
		if(empty($topic))
		{
			echo "<option value=''>No topic found</option>";
		}
		else
		{
			echo "<option value=''>Select Topic</option>";
			foreach($topic as $c)
			{
				echo "<option value='".$c->topic_id."'>".$c->topic."</option>";
			}
		}
	}

	
	public function save_update_subtopic($option)
	{
		$portal = $this->input->post('portal');
		$topic = $this->input->post('topic');
		$module = $this->input->post('module');
		$subtopic = $this->input->post('subtopic');
		$id = $this->input->post('subtopic_id');
		$insert = $this->system_help_link_settings_model->save_update_subtopic($id,$portal,$topic,$module,$subtopic);
		$this->session->set_flashdata('onload',"setting('".$option."')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Module Sub Topic ID - ".$id." is Successfully Updated!</div>");
		redirect(base_url().'app/system_help_link_settings/index',$this->data);
	}

	public function allow_settting()
	{
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view('app/admin_help_links_setting/allow_setting/index',$this->data);
	}

	public function allow_setting_main($company)
	{
		$this->data['company'] = $company;
		$this->data['company_name'] = $this->system_help_link_settings_model->get_company_name($company);
		$this->data['portal_list'] = $this->system_help_link_settings_model->get_details('portal');
		$this->load->view('app/admin_help_links_setting/allow_setting/allow_setting',$this->data);
	}

	public function save_allow_settings($company)
	{
		 $insert = $this->system_help_link_settings_model->save_allow_settings($company);
		 if($company=='not_included')
		 {
		 	$this->session->set_flashdata('onload',"setting('setting')");
		 	$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Allow Setting for Applicant and Public Employer Successfully Updated!</div>");
		 	 redirect(base_url().'app/system_help_link_settings/index',$this->data);
		 }
		 else
		 {
		 	$this->session->set_flashdata('onload',"setting('".$company."')");
		 	$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Allow Setting for Company ID - ".$company." is Successfully Updated!</div>");
		 	 redirect(base_url().'app/system_help_link_settings/allow_settting',$this->data);
		 }
		
		
		
	}
}//end controller



