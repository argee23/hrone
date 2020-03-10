<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class System_help_link_settings_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_details($option)
	{
		if($option=='portal')
		{
			$query = $this->db->get('admin_help_settings_portal');
		}
		else if($option=='category')
		{
			$this->db->select('a.*,b.portal');
			$this->db->join('admin_help_settings_portal b','b.portal_id=a.portal_id');
			$query = $this->db->get('admin_help_settings_module a');
		}
		else if($option=='module')
		{
			$this->db->select('a.*,b.module,c.portal');
			$this->db->join('admin_help_settings_module b','b.module_id=a.module_id');
			$this->db->join('admin_help_settings_portal c','c.portal_id=b.portal_id');
			$query = $this->db->get('admin_help_settings_topic a');
		}
		else if($option=='topic')
		{
			$this->db->select('a.*,b.topic_id,b.topic,c.module_id,c.module,d.portal,d.portal_id');
			$this->db->join('admin_help_settings_topic b','b.topic_id=a.topic_id');
			$this->db->join('admin_help_settings_module c','c.module_id=b.module_id');
			$this->db->join('admin_help_settings_portal d','d.portal_id=c.portal_id');
			$query = $this->db->get('admin_help_settings_subtopic a');
		}
		else
		{
			
			$this->db->join('admin_help_settings_topic b','b.topic_id=a.topic_id');
			$this->db->join('admin_help_settings_module c','c.module_id=b.module_id');
			$this->db->join('admin_help_settings_portal e','e.portal_id=c.portal_id');
			$query = $this->db->get('admin_help_settings_subtopic a');
		}
		return $query->result();
	}

	public function save_portal($name)
	{
		$this->db->insert('admin_help_settings_portal',array('portal'=>$name,'date_added'=>date('Y-m-d H:i:s'),'InActive'=>0));
	}

	public function portal_action($action,$id,$table,$id_name)
	{
		if($action=='delete')
		{
			$this->db->where($id_name,$id);
			$this->db->delete($table);
		}
		else if($action=='enable')
		{
			$this->db->where($id_name,$id);
			$this->db->update($table,array('InActive'=>0));
		}
		else 
		{
			$this->db->where($id_name,$id);
			$this->db->update($table,array('InActive'=>1));
		}
	}

	public function details($id,$id_name,$table)
	{

		if($table=='admin_help_settings_topic')
		{
			$this->db->select('a.*,b.module,c.portal,c.portal_id');
			$this->db->join('admin_help_settings_module b','b.module_id=a.module_id');
			$this->db->join('admin_help_settings_portal c','c.portal_id=b.portal_id');
			$this->db->where('a.topic_id',$id);
			$query = $this->db->get('admin_help_settings_topic a');
		}
		else if($table=='admin_help_settings_subtopic')
		{
			$this->db->join('admin_help_settings_topic b','b.topic_id=a.topic_id');
			$this->db->join('admin_help_settings_module c','c.module_id=b.module_id');
			$this->db->join('admin_help_settings_portal e','e.portal_id=c.portal_id');
			$this->db->where('subtopic_id',$id);
			$query = $this->db->get('admin_help_settings_subtopic a');
			
		}
		else
		{
			$this->db->where($id_name,$id);
			$query = $this->db->get($table);
				
		}
		return $query->result();
		
	}

	public function save_update_portal($id,$portal)
	{
		$this->db->where('portal_id',$id);
		$query = $this->db->update('admin_help_settings_portal',array('portal'=>$portal));
	}

	public function save_category($category,$portal)
	{
		$this->db->insert('admin_help_settings_module',array('portal_id'=>$portal,'module'=>$category,'date_added'=>date('Y-m-d H:i:s'),'InActive'=>0));
	}

	public function save_update_modules($id,$portal,$category)
	{
		$this->db->where('module_id',$id);
		$query = $this->db->update('admin_help_settings_module',array('portal_id'=>$portal,'module'=>$category));	
	}

	//module

	public function onchange_get_category($id)
	{
		$this->db->where('portal_id',$id);
		$query = $this->db->get('admin_help_settings_module');
		return $query->result();
	}

	public function save_module($portal,$topic,$module)
	{
		$this->db->insert('admin_help_settings_topic',array('module_id'=>$module,'topic'=>$topic,'InActive'=>0,'date_added'=>date('Y-m-d H:i:s')));
	}

	public function get_portal_category($id)
	{
		$this->db->where('portal_id',$id);
		$query = $this->db->get('admin_help_settings_module');
		return $query->result();	
	}

	public function get_portal_module($category_id)
	{
		$this->db->where('module_id',$category_id);
		$query = $this->db->get('admin_help_settings_topic');
		return $query->result();
	}

	public function save_update_topic($id,$portal,$topic,$module)
	{
	
		$this->db->where('topic_id',$id);
		$this->db->update('admin_help_settings_topic',array('module_id'=>$module,'topic'=>$topic));
	}

	public function onchange_get_module($category)
	{
		$this->db->where('module_id',$category);
		$query = $this->db->get('admin_help_settings_topic');
		return $query->result();
	}

	public function save_subtopic($portal,$category,$module,$topic,$subtopic)
	{
		$this->db->insert('admin_help_settings_subtopic',array('topic_id'=>$topic,'subtopic'=>$subtopic,'date_added'=>date('Y-m-d H:i:s'),'InActive'=>0));
	}

	public function get_portal_portal($portal_id)
	{
		$this->db->where('portal_id',$portal_id);
		$query = $this->db->get('admin_help_settings_portal');
		return $query->result();
	}

	public function onchange_get_topic($module)
	{
		$this->db->where('module_id',$module);
		$query = $this->db->get('admin_help_settings_topic');
		return $query->result();
	}	

	public function save_update_subtopic($id,$portal,$topic,$module,$subtopic)
	{
		$this->db->where('subtopic_id',$id);
		$this->db->update('admin_help_settings_subtopic',array('topic_id'=>$topic,'subtopic'=>$subtopic));
	}



	//allow setting 

	public function get_company_name($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('company_info',1);
		return $query->row('company_name');
	}
	
	public function save_allow_settings($company)
	{
		 $portal_list = $this->get_details('portal');
		 
		 
		 foreach($portal_list as $portal)
		 {
		 	$system_help = $this->input->post('system_help'.$portal->portal_id); 
		 	$quick_link = $this->input->post('quick_links'.$portal->portal_id);

		 	
		 	if($company=='not_included')
		 	{
		 		if($portal->portal_id==3 || $portal->portal_id==4)
		 		{
			 		$this->db->where(array('portal_id'=>$portal->portal_id));
				 	$this->db->delete('admin_allow_settings');

				 	$data = array('company_id'=>$company,'portal_id'=>$portal->portal_id,'allow_system_help'=>$system_help,'allow_quick_links'=>$quick_link,'date_added'=>date('Y-m-d H:i:s'));
				 	$this->db->insert('admin_allow_settings',$data);
		 		} else{}
		 	}
		 	else
		 	{
		 		$this->db->where(array('company_id'=>$company,'portal_id'=>$portal->portal_id));
			 	$this->db->delete('admin_allow_settings');

			 	$data = array('company_id'=>$company,'portal_id'=>$portal->portal_id,'allow_system_help'=>$system_help,'allow_quick_links'=>$quick_link,'date_added'=>date('Y-m-d H:i:s'));
			 	$this->db->insert('admin_allow_settings',$data);
		 	}
		 	
		 	
		 }
	}

	public function get_allow_setting_value($id,$company)
	{
		$this->db->where(array('portal_id'=>$id));
		if($id=='3' || $id=='4')
			{} else{ $this->db->where('company_id',$company); }
		$query = $this->db->get('admin_allow_settings',1);
		return $query->row();
	}
}