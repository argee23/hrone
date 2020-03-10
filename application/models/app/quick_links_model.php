<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Quick_links_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	public function get_t_forms(){ 
		$this->db->order_by('form_name','asc');
		$this->db->where(array(
			'IsActive'			=>		1,
			'form_type'			=>		'T'
		));
		$query = $this->db->get("transaction_approver");
		return $query->result();
	}

	public function quick_links_file_maintenance($portal,$module)
	{
		$this->db->select('a.*,c.topic');
		$this->db->join('admin_help_settings_topic c','c.topic_id=a.topic_id');
		$this->db->where(array('a.portal_id'=>$portal,'a.module_id'=>$module));
		$query = $this->db->get('admin_quick_links_file_maintenance a');
		return $query->result();
	}

	public function save_quick_links_file_maintenance($portal,$module)
	{
		$topic = $this->input->post('topic');
		$subtopic = $this->input->post('subtopic_add');
		$link = $this->input->post('link');
		$tablename = $this->input->post('tablename');

		$data = array('portal_id'=>$portal,'module_id'=>$module,'topic_id'=>$topic,'link'=>$link,'table'=>$tablename,'InActive'=>0,'date_added'=>date('Y-m-d H:i:s'));
		$this->db->insert('admin_quick_links_file_maintenance',$data);
	}

	public function file_maintenance_action($portal,$module,$id,$action)
	{
		if($action=='enable')
		{
			$this->db->where('id',$id);
			$query = $this->db->update('admin_quick_links_file_maintenance',array('InActive'=>0));
		}
		else if($action=='disable')
		{
			$this->db->where('id',$id);
			$query = $this->db->update('admin_quick_links_file_maintenance',array('InActive'=>1));
		}
		else if($action=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('admin_quick_links_file_maintenance');
		}
	}

	public function get_topic_details_id($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('admin_quick_links_file_maintenance',1);
		return $query->result();
	}

	public function save_file_maintenance_update($portal,$module)
	{
		$id = $this->input->post('quick_link_id');
		$table = $this->input->post('tablename_upd');
		$link = $this->input->post('linnk_upd');

		$this->db->where('id',$id);
		$update = $this->db->update('admin_quick_links_file_maintenance',array('table'=>$table,'link'=>$link));
	}

	//quick links
	public function portal()
	{
		if(!empty($this->session->userdata('is_applicant')))
        { $this->db->where('portal_id',3); }
        else if($this->session->userdata('is_logged_in')){

                if(empty($this->session->userdata('user_role')))
                { $this->db->where('portal_id',2); }
                else
                { $this->db->where('portal_id',1); }

        } else { $this->db->where('portal_id',4); }
		$query = $this->db->get('admin_help_settings_portal');
		return $query->result();
	}

	public function quick_links_details($portal,$module)
	{
		
		$this->db->join('admin_help_settings_topic c','c.topic_id=a.topic_id');
		$this->db->where(array('a.portal_id'=>$portal,'a.module_id'=>$module));
		$query = $this->db->get('admin_quick_links_file_maintenance a');
		return $query->result();
	}

	public function check_if_topic_exist($id)
	{
		$this->db->where('topic_id',$id);
		$query = $this->db->get('admin_quick_links_file_maintenance');
		return $query->result();
	}

	public function check_link_valid($portal,$link)
	{
		
	}
    
    public function check_user_role($module_id)
    {
    	$this->db->where('module_id',$module_id);
    	$query = $this->db->get('admin_help_settings_module',1);
    	$module_name = $query->row('module');
    	$user_id = $this->session->userdata('user_id');
    	$user_role = $this->session->userdata('user_role');

    	$this->db->join('pages b','b.page_id=a.page_id');
    	$this->db->where('b.sidebar',$module_name);
    	$this->db->where(array('a.role_id'=>$user_role));
    	$query = $this->db->get('user_roles_pages a');

    	return $query->num_rows();
    }

	public function convert_char($title)
	{
		$a = str_replace("-a-","?",$title);
		$b = str_replace("-b-","!",$a);
		$c = str_replace("-c-","/",$b);
		$d = str_replace("-d-","|",$c);
		$e = str_replace("-e-","[",$d);
		$f = str_replace("-f-","]",$e);
		$g = str_replace("-g-","(",$f);
		$h = str_replace("-h-",")",$g);
		$i = str_replace("-i-","{",$h);
		$j = str_replace("-j-","}",$i);

		$k = str_replace("-k-","'",$j);
		$l = str_replace("-l-",",",$k);
		$m = str_replace("-m-","'",$l);
		$n = str_replace("-n-","_",$m);

		$o = str_replace("-o-","@",$n);
		$p = str_replace("-p-","#",$o);
		$q = str_replace("-q-","%",$p);
		$r = str_replace("-r-","$",$q);

		$s = str_replace("-s-","^",$r);
		$t = str_replace("-t-","&",$s);
		$u = str_replace("-u-","*",$t);
		$v = str_replace("-v-","+",$u);

		$w = str_replace("-w-","=",$v);
		$x = str_replace("-x-",":",$w);
		$y = str_replace("-y-",";",$x);
		$z = str_replace("-z-"," ",$y);
		
		$aa = str_replace("-zz-",".",$z);
		$bb = str_replace("-aa-","<",$aa);
		$cc = str_replace("-bb-",">",$bb);
		$dd = str_replace("%20"," ",$cc);
		return $dd;

	}

}