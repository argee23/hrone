<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Time_work_schedule extends General{

    function __construct(){
        parent::__construct();  
        $this->load->model("app/time_work_schedule_model");
        $this->load->model("general_model");
        $this->load->dbforge();

        if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
        General::variable();
    }

	public function index(){	

		$this->data['onload']     = $this->session->flashdata('onload');
		$this->data['message']    = $this->session->flashdata('message');	
			
		$this->load->view('app/time/emp_work_schedule/index',$this->data);
 	}

 	public function get_emp_work_schedule_group($company,$location,$employment,$classification,$department,$section,$subsection)
 	{
 		$this->data['result']=$this->time_work_schedule_model->get_emp_work_schedule_group($company,$location,$employment,$classification,$department,$section,$subsection);
 		$this->load->view('app/time/emp_work_schedule/result',$this->data);
 	}
 	public function get_location($company)
 	{
 		$location = $this->time_work_schedule_model->load_locations($company);
 		if(empty($location))
 		{
 			echo "<option value='-'>No location/s found.</option>";
 		}
 		else
 		{    
            echo "<option value='-'>Select Location</option>";
 			echo "<option value='All'>All</option>";
 			foreach($location as $l)
 			{
 				echo "<option value='".$l->location_id."'>".$l->location_name."</option>";
 			}
 		}
 	}

 	public function get_classification($company)
 	{
 		$classification = $this->time_work_schedule_model->classificationList($company);
 		if(empty($classification))
 		{
 			echo "<option value='-'>No Classification/s found.</option>";
 		}
 		else
 		{
            echo "<option value='-'>Select Classification</option>";
 			echo "<option value='All'>All</option>";
 			foreach($classification as $c)
 			{
 				echo "<option value='".$c->classification_id."'>".$c->classification."</option>";
 			}
 		}
 	}
    public function get_department($company)
    {
        $department = $this->time_work_schedule_model->load_dept_filter($company);
        if(empty($department))
        {
            echo "<option value='-'>No department/s found.</option>";
        }
        else
        {
            echo "<option value='-'>Select department</option>";
            foreach($department as $d)
            {
                echo "<option value='".$d->department_id."'>".$d->dept_name."</option>";
            }
        }
    }
    public function get_section($company,$department)
    {
        $section = $this->time_work_schedule_model->load_section_filter($department);
        if(empty($section))
        {
            echo "<option value='-'>No section/s found.</option>";
        }
        else
        {
            echo "<option value='-'>Select section</option>";
            foreach($section as $d)
            {
                echo "<option value='".$d->section_id."'>".$d->section_name."</option>";
            }
        }
    }

    public function get_subsection($section)
    {
        $subsection = $this->time_work_schedule_model->load_subsections($section);
        if(empty($subsection))
        {
            echo "<option value='-'>No subsection/s found.".$section."</option>";
        }
        else
        {
            echo "<option value='-'>Select subsection</option>";
            foreach($subsection as $d)
            {
                echo "<option value='".$d->subsection_id."'>".$d->subsection_name."</option>";
            }
        }

    }
    
}	

