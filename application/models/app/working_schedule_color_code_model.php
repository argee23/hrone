<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Working_schedule_color_code_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_color_code()
	{
		$query = $this->db->get('working_schedules_color_code');
		return $query->result();
	}
	
	public function get_color_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('working_schedules_color_code');
		return $query->result();
	}
	public function save_colorcode_update($id)
	{
		$title = $this->input->post('title');
		$desc = $this->input->post('description');
		$color = $this->input->post('color');

		$this->db->where('id',$id);
		$this->db->update('working_schedules_color_code',array('title'=>$title,'color_code'=>$color,'details'=>$desc));
	}
}