<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class System_help_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_modules_by_usercategory($id)
	{
		$this->db->where('portal_id',$id);
		$query = $this->db->get('admin_help_settings_module');
		return $query->result();
	}

	public function portal_module_details($portal,$module)
	{
		$this->db->join('admin_help_settings_module b','b.portal_id=a.portal_id');
		$this->db->where(array('a.portal_id'=>$portal,'b.module_id'=>$module));
		$query = $this->db->get('admin_help_settings_portal a',1);
		return $query->result();
	}

	public function system_help_file_maintenance($portal,$module)
	{
		$this->db->select('a.*,b.subtopic,c.topic');
		$this->db->join('admin_help_settings_subtopic b','b.subtopic_id=a.subtopic_id');
		$this->db->join('admin_help_settings_topic c','c.topic_id=b.topic_id');
		$this->db->where(array('a.portal_id'=>$portal,'a.module_id'=>$module));
		$query = $this->db->get('admin_system_help_file_maintenance a');
		return $query->result();
	}

	public function system_help_file_maintenance_filter($portal,$module,$topic,$subtopic)
	{
		
		$this->db->select('a.*,b.subtopic,c.topic');
		$this->db->join('admin_help_settings_subtopic b','b.subtopic_id=a.subtopic_id');
		$this->db->join('admin_help_settings_topic c','c.topic_id=b.topic_id');
		$this->db->where(array('a.portal_id'=>$portal,'a.module_id'=>$module,'a.topic_id'=>$topic,'a.subtopic_id'=>$subtopic));
		$query = $this->db->get('admin_system_help_file_maintenance a');
		return $query->result();
	}

	public function get_topic_details($module,$portal)
	{
		$this->db->where('module_id',$module);
		$query = $this->db->get('admin_help_settings_topic');
		return $query->result();
	}

	public function get_sub_topic_list($topic)
	{
		$this->db->where('topic_id',$topic);
		$query = $this->db->get('admin_help_settings_subtopic');
		return $query->result();
	}

	public function save_system_help_file_maintenance($portal,$module,$question,$picture)
	{
		$topic 		=  $this->input->post('topic');
		$subtopic   =  $this->input->post('subtopic_add');
		$answer     =  $this->input->post('answer');
		$status     =  0;
		$date_added = date('Y-m-d H:i:s');

		$data = array('portal_id'=>$portal,'module_id'=>$module,'topic_id'=>$topic,'subtopic_id'=>$subtopic,'question'=>$question,'answer'=>$answer,'InActive'=>$status,'date_added'=>$date_added,'attachment'=>$picture);
		$insert = $this->db->insert('admin_system_help_file_maintenance',$data);
	}

	public function get_file_maintenance_keyword($id)
	{
		$this->db->where('systemhelp_id',$id);
		$query = $this->db->get('admin_system_help_file_maintenance_keywords');
		return $query->result();
	}

	public function file_maintenance_action($portal,$module,$id,$action)
	{
		if($action=='enable')
		{
			$this->db->where('id',$id);
			$query = $this->db->update('admin_system_help_file_maintenance',array('InActive'=>0));
		}
		else if($action=='disable')
		{
			$this->db->where('id',$id);
			$query = $this->db->update('admin_system_help_file_maintenance',array('InActive'=>1));
		}
		else if($action=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('admin_system_help_file_maintenance');

			$this->db->where('systemhelp_id',$id);
			$this->db->delete('admin_system_help_file_maintenance_keywords');
		}
	}

	public function save_file_maintenance_update($id,$picture)
	{
		$question = $this->input->post('question_upd');
		$answer = $this->input->post('answer_upd');

		$this->db->where('id',$id);
		$update = $this->db->update('admin_system_help_file_maintenance',array('question'=>$question,'answer'=>$answer));

		if(!empty($picture))
		{
			$this->db->where('id',$id);
			$update = $this->db->update('admin_system_help_file_maintenance',array('attachment'=>$picture));
		}
	}	
	public function question_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('admin_system_help_file_maintenance');
		return $query->row();
	}

	public function keyword_list($id)
	{
		$this->db->where('systemhelp_id',$id);
		$query = $this->db->get('admin_system_help_file_maintenance_keywords');
		return $query->result();
	}

	public function save_keyword($id,$keyword_final)
	{
		$keyword = $this->convert_char($keyword_final);

		$this->db->insert('admin_system_help_file_maintenance_keywords',array('systemhelp_id'=>$id,'keyword'=>$keyword,'date_added'=>date('Y-m-d H:i:s')));
	}
	public function delete_keywords($id)
	{
		$this->db->where('id',$id);
		$query =  $this->db->delete('admin_system_help_file_maintenance_keywords');
	}

	public function update_keywords($id,$key)
	{
		$keyword = $this->convert_char($key);
		$this->db->where('id',$id);
		$query =  $this->db->update('admin_system_help_file_maintenance_keywords',array('keyword'=>$keyword));
	}

	public function get_topic_details_id($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('admin_system_help_file_maintenance',1);
		return $query->result();
	}



	//SYSTEM HELP

	public function convert_search($val)
	{
		$search = $this->convert_char($val);
		return $search;
	}

	public function search_now($search,$option)
	{	
		$sea = explode(' ',$search);
		$ss = "";
		foreach ($sea as $k) {
			
	          	$ddd = "a.keyword"." LIKE '%".$k."%' or ";
	            $ss .= $ddd;
		}
		$res_ll = substr($ss, 0, -3);
		$sss = "(".$res_ll.")";

		$this->db->select('*');
		$this->db->join('admin_system_help_file_maintenance b','b.id=a.systemhelp_id');
		if($option=='word_by_word')
		{
			$this->db->where($sss);
		}
		else
		{
			//$this->db->where("(`a.keyword` LIKE '%$search%')");
			$this->db->where('a.keyword',$search);
		}
		if(!empty($this->session->userdata('is_applicant')))
        { $this->db->where('b.portal_id',3); }
        else if($this->session->userdata('is_logged_in')){
                if(empty($this->session->userdata('user_role')))
                { $this->db->where('b.portal_id',2); }
                else
                { }
          }
          else{ $this->db->where('b.portal_id',4); } 
		$query = $this->db->get('admin_system_help_file_maintenance_keywords a');
		$query_result = $query->result();

		// $query=$this->db->query("SELECT * FROM `admin_system_help_file_maintenance_keywords` WHERE LOCATE('".$search."',keyword) > 0");
		// $query_result  = $query->result();

		if(empty($query_result))
		{
			return '';
		}
		else
		{
			$string_l="";
	
			foreach($query_result as $a)
			{
				$a->systemhelp_id;
				$aa = $a->systemhelp_id;
	          	$ddd = "a.id"."=".$aa." or ";
	            $string_l .= $ddd;
			}

			$res_l = substr($string_l, 0, -3);
			$where_l = "(".$res_l.")";
			


			if(!empty($where_l))
			{
				$this->db->where($where_l);
				$this->db->join('admin_help_settings_subtopic b','b.subtopic_id=a.subtopic_id');
				$this->db->join('admin_help_settings_topic c','c.topic_id=a.topic_id');
				$this->db->join('admin_help_settings_module d','d.module_id=a.module_id');
				$this->db->join('admin_help_settings_portal e','e.portal_id=a.portal_id');
				$query = $this->db->get('admin_system_help_file_maintenance a');
				return $query->result();
			}
			else
			{
				return '';
			}	
		}
		
		
	}	

	public function get_module_list($id)
	{
		if($id=='All'){} else{ $this->db->where('portal_id',$id); }
		$query = $this->db->get('admin_help_settings_module');
		return $query->result();
	}

	public function get_topic_list($portal,$module)
	{
		$this->db->join('admin_help_settings_module b','b.module_id=a.module_id');
		if($module=='All'){
			if($portal=='All'){} else{ $this->db->where('b.portal_id',$portal); }
		} 
		else{ $this->db->where('a.module_id',$module); }
		$query = $this->db->get('admin_help_settings_topic a');
		return $query->result();
	}

	public function get_subtopic_list($portal,$module,$topic)
	{
		$this->db->join('admin_help_settings_topic b','b.topic_id=a.topic_id');
		$this->db->join('admin_help_settings_module c','c.module_id=b.module_id');
		
			if($topic=='All'){
				if($module=='All'){
					if($portal=='All'){} else{ $this->db->where('c.portal_id',$portal); }
				} else{ $this->db->where('c.module_id',$module); }
			} else{  $this->db->where('a.topic_id',$topic); }
		
		$query = $this->db->get('admin_help_settings_subtopic a');
		return $query->result();
	}

	public function filter_results($portal,$module,$topic,$subtopic)
	{
		
		$this->db->join('admin_help_settings_subtopic b','b.subtopic_id=a.subtopic_id');
		$this->db->join('admin_help_settings_topic c','c.topic_id=a.topic_id');
		$this->db->join('admin_help_settings_module d','d.module_id=a.module_id');
		$this->db->join('admin_help_settings_portal e','e.portal_id=a.portal_id');
		if($portal=='All'){} else{ $this->db->where('a.portal_id',$portal); }
		if($module=='All'){} else{ $this->db->where('a.module_id',$module); }
		if($topic=='All'){} else{ $this->db->where('a.topic_id',$topic); }
		if($subtopic=='All'){} else{ $this->db->where('a.subtopic_id',$subtopic); }
		$query = $this->db->get('admin_system_help_file_maintenance a');
		return $query->result();
	}	

	public function search_filter_now($portal,$module,$topic,$subtopic,$search)
	{
		$this->db->select('*');
		$this->db->where("(`keyword` LIKE '%$search%')");
		$query = $this->db->get('admin_system_help_file_maintenance_keywords');
		$query_result = $query->result();
		if(empty($query_result))
		{
			return '';
		}
		else
		{
			$string_l="";
	
			foreach($query_result as $a)
			{
				$a->systemhelp_id;
				$aa = $a->systemhelp_id;
	          	$ddd = "a.id"."=".$aa." or ";
	            $string_l .= $ddd;
			}

			$res_l = substr($string_l, 0, -3);
			$where_l = "(".$res_l.")";
			

			if(!empty($where_l))
			{
				
				$this->db->where($where_l);
				if($portal=='All'){}
				else { $this->db->where('e.portal_id',$portal); }

				if($module=='All'){}
				else { $this->db->where('d.module_id',$module); }

				if($topic=='All'){}
				else { $this->db->where('c.topic_id',$topic); }

				if($subtopic=='All'){}
				else { $this->db->where('b.subtopic_id',$subtopic); }

				$this->db->join('admin_help_settings_subtopic b','b.subtopic_id=a.subtopic_id');
				$this->db->join('admin_help_settings_topic c','c.topic_id=a.topic_id');
				$this->db->join('admin_help_settings_module d','d.module_id=a.module_id');
				$this->db->join('admin_help_settings_portal e','e.portal_id=a.portal_id');
				$query = $this->db->get('admin_system_help_file_maintenance a');
				return $query->result();
			}
			else
			{
				return '';
			}	
		}
	}

	public function get_keywords($id)
	{
		$this->db->where('systemhelp_id',$id);
		$query = $this->db->get('admin_system_help_file_maintenance_keywords');
		return $query->result();
	}

	public function get_details_portal_filtering()
	{
		if(!empty($this->session->userdata('is_applicant')))
        { $this->db->where('portal_id',3); }
        else if($this->session->userdata('is_logged_in')){
                if(empty($this->session->userdata('user_role')))
                { $this->db->where('portal_id',2); }
                else
                { }
          }
          else{ $this->db->where('portal_id',4); } 
		$query = $this->db->get('admin_help_settings_portal');
		return $query->result();
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