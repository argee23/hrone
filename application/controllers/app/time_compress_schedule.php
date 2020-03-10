<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Time_compress_schedule extends General{

    function __construct(){
        parent::__construct();  
        $this->load->model("app/time_compress_schedule_model");
        $this->load->model("app/sms_model");
        $this->load->model("general_model");
        $this->load->dbforge();

        if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
        General::variable();
    }

	public function index(){	

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
			
		$this->load->view('app/time/compress_schedule/index',$this->data);
 	}

    public function view_compress_group($val){
        $this->data['myComp'] = $this->general_model->get_company_info($val);
        $this->data['CompGroup']=$this->time_compress_schedule_model->view_compress_group($val);
        $this->load->view('app/time/compress_schedule/view_compress_group',$this->data);
    }

public function filter_for_grouped_employees(){
    $group_id=$this->input->post('group_id');
    $company_id=$this->input->post('company_id');
    $division=$this->input->post('division');
    $department=$this->input->post('department');
    $section=$this->input->post('section');
    $sub_section=$this->input->post('sub_section');
    // echo below for checking.

    // echo 
    // "
    // division: $division <br>
    // department: $department <br>
    // section: $section <br>
    // sub-section $sub_section <br>
    // ";
    //no_data_yet
$this->data['gcInfo']=$this->time_compress_schedule_model->getGroupDet($group_id);

if($division=="ignore_me" OR $division=="All"){
    $division_condition="";
}else{
    if($division=="no_data_yet"){
        $division_condition="AND division_id='no_data_yet' ";//no setup for division list yet. force a 0 (zero) RESULT on query.
    }else{
        $division_condition="AND division_id='".$division."' ";     
    }
}

if($department=="ignore_me" OR $department=="All"){
    $department_condition="";
}else{
    if($department=="no_data_yet"){
        $department_condition="AND department='no_data_yet' ";//no setup for department list yet. force a 0 (zero) RESULT on query.
    }else{
        $department_condition="AND department='".$department."' ";      
    }
}

if($section=="ignore_me" OR $section=="All"){
    $section_condition="";
}else{
    if($section=="no_data_yet"){
        $section_condition="AND section='no_data_yet' ";//no setup for section list yet. force a 0 (zero) RESULT on query.
    }else{
        $section_condition="AND section='".$section."' ";       
    }
}

if($sub_section=="ignore_me" OR $sub_section=="All"){
    $sub_section_condition="";
}else{
    if($sub_section=="no_data_yet"){
        $sub_section_condition="AND subsection='no_data_yet' ";//no setup for sub_section list yet. force a 0 (zero) RESULT on query.
    }else{
        $sub_section_condition="AND subsection='".$sub_section."' ";        
    }
}

//== start location checking
        $location_condition="";

        if($this->input->post('location')){
            foreach ($this->input->post('location') as $key => $location){
                $location_condition.="location='".$location."'  OR ";
                
            }
        $location_condition=substr($location_condition, 0,-4);  

        }else{

        }

        if($location_condition!=""){
            $location_condition="AND ($location_condition)";
        }else{
            $location_condition="AND location='no_data_yet' ";//no selected locations: force no result on query
        }

//== end location checking


//== start classification checking
        $classification_condition="";

        if($this->input->post('classification')){
            foreach ($this->input->post('classification') as $key => $classification){
                $classification_condition.="classification='".$classification."'  OR ";
                
            }
        $classification_condition=substr($classification_condition, 0,-4);  

        }else{

        }

        if($classification_condition!=""){
            $classification_condition="AND ($classification_condition)";
        }else{
            $classification_condition="AND classification='no_data_yet' ";//no selected classification: force no result on query
        }

//== end classification checking

//== start employment checking
        $employment_condition="";

        if($this->input->post('employment')){
            foreach ($this->input->post('employment') as $key => $employment){
                $employment_condition.="employment='".$employment."'  OR ";
                
            }
        $employment_condition=substr($employment_condition, 0,-4);  

        }else{

        }

        if($employment_condition!=""){
            $employment_condition="AND ($employment_condition)";
        }else{
            $employment_condition="AND employment='no_data_yet' ";//no selected classification: force no result on query
        }

//== end employment checking

        $this->data['employeeList']=$this->time_compress_schedule_model->filter_for_grouped_employees($company_id,$division_condition,$department_condition,$section_condition,$sub_section_condition,$location_condition,$classification_condition,$employment_condition,$group_id);

        $this->data['already_enrolled_list']=$this->time_compress_schedule_model->check_enrolled_emp_for_grouped_contact($company_id,$group_id);
        $this->data['all_grouped_enrolled']=$this->time_compress_schedule_model->check_other_grouped_enrolled($company_id,$group_id);

        $this->data['onload'] = $this->session->flashdata('onload');
        $this->data['message'] = $this->session->flashdata('message');  
        $this->data['company_id']=$company_id;
        $this->data['group_id']=$group_id;


        $this->load->view('app/time/compress_schedule/emp_choices',$this->data);
}


    public function enrol_employee_grouped_contact(){
        $group_id=$this->input->post('group_id');
        $company_id=$this->input->post('company_id');
        foreach ($this->input->post('employee_id') as $key => $employee_id)
        {   
            $date_reg=date('Y-m-d H:i:s');

        $save_values = array(
            'company_id'                => $company_id,
            'group_id'                => $group_id,
            'employee_id'           => $employee_id,
            'InActive'           => 0,
            'date_enrolled'            => $date_reg
        );              

        $this->time_compress_schedule_model->save_selected_gc_emp($save_values);

        $value="$group_id|$employee_id";
        /*
        --------------audit trail composition--------------
        (module,module dropdown,logfiletable,detailed action,action type,key value)
        --------------audit trail composition--------------
        */
        General::system_audit_trail('SMS','Compress Work Schedule','logfile_time_compress_work_schedule','INSERT '.$value.': value: '.$value.' ,','INSERT',$value);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Successfully Saved</div>");

        }


        $this->session->set_flashdata('onload',"view_compress_group('".$company_id."')");
        redirect(base_url().'app/time_compress_schedule/index',$this->data);  
    }


    public function un_enrol_employee_grouped_contact(){
            $company_id=$this->input->post('company_id');
            foreach ($this->input->post('un_employee_id') as $key => $employee_id)
            {   
                $date_reg=date('Y-m-d H:i:s');
                $value="$employee_id remove from compress sched.";
                $query=$this->db->query("delete from compress_work_employees where employee_id='".$employee_id."' ");
    
                /*
                --------------audit trail composition--------------
                (module,module dropdown,logfiletable,detailed action,action type,key value)
                --------------audit trail composition--------------
                */
                General::system_audit_trail('SMS','Compress Work Schedule','logfile_time_compress_work_schedule','DELETE '.$value.': value: '.$value.' ,','INSERT',$value);


            }

            $this->session->set_flashdata('onload',"view_compress_group('".$company_id."')");
            redirect(base_url().'app/time_compress_schedule/index',$this->data);  


    }
    public function viewEnrolled(){
        $company_id=$this->uri->segment('4');
        $group_id=$this->uri->segment('5');
        $this->data['already_enrolled_list']=$this->time_compress_schedule_model->check_enrolled_emp_for_grouped_contact($company_id,$group_id);
        $this->load->view('app/time/compress_schedule/view_enrolled',$this->data);
    }


    public function enroll_emp_grouped_contact(){
        
        $group_id=$this->uri->segment('5');
        $company_id=$this->uri->segment('4');
        $comp_div_set=$this->sms_model->checkCompDivSettting($company_id);
        $wDivision=$comp_div_set->wDivision;
        $this->data['wDivision']=$wDivision;
        if($wDivision=="1"){
            $this->data['comp_div']=$this->general_model->get_company_divisions($company_id);
        }else{
            $this->data['comp_div']="";
        }
        $this->data['compLoc']=$this->general_model->get_company_locations($company_id);
        $this->data['compClass']=$this->general_model->get_company_classifications($company_id);


        $this->data['gcInfo']=$this->time_compress_schedule_model->getGroupDet($group_id);
        $this->load->view('app/time/compress_schedule/add_emp',$this->data);

    }


    public function en_dis_time_compress_group(){
        $id = $this->uri->segment('4');
        $current_stat = $this->uri->segment('5');
        $group_name = $this->uri->segment('6');
        $cGinfo = $this->time_compress_schedule_model->getGroupDet($id);

        if($current_stat=="1"){
            $content="0";
        }else{
            $content="1";
        }
        
        $this->time_compress_schedule_model->en_dis_time_compress_group($id,$content);
        if($content=="0"){
            $act="ENABLE";
            $act_name="Enabled";
        }else{
            $act="DISABLE";
            $act_name="Disabled";
        }
        // logfile
        $value = $id;
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
        General::system_audit_trail('SMS','Compress Work Schedule','logfile_time_compress_work_schedule',' '.$act.' '.$value.': value:'.$value.' '.$value.' ,',''.$act.'',$value);
            
        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group Name <strong>".$group_name."</strong>, is Successfully $act_name!</div>");

            $this->session->set_flashdata('onload',"view_compress_group('".$cGinfo->company_id."')");
             redirect(base_url().'app/time_compress_schedule/index',$this->data);  
    }



    public function del_time_compress_group($c_group_id,$compress_group_name){
        $value="$c_group_id | $compress_group_name";
        $verifyGroupEmp=$this->time_compress_schedule_model->verifyGroupEmp($c_group_id);
        $cGinfo = $this->time_compress_schedule_model->getGroupDet($c_group_id);
        if(!empty($verifyGroupEmp)){
            $this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group:  <strong>".$compress_group_name."</strong>, is Not allowede to be deleted, as there is/are employee currently enrolls in it</div>");
            // redirect

          
        }else{

            $this->db->query("delete from compress_work_group WHERE c_group_id = ".$c_group_id);

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('SMS','Compress Work Schedule','logfile_time_compress_work_schedule','delete '.$value.': value: '.$value.' ,','DELETE',$value);

            $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group:  <strong>".$compress_group_name."</strong>, is Successfully Deleted!</div>");
        }
            $this->session->set_flashdata('onload',"view_compress_group('".$cGinfo->company_id."')");
            redirect(base_url().'app/time_compress_schedule/index',$this->data);  

    }


    public function add_time_compress_group($val){

        $this->data['myComp'] = $this->general_model->get_company_info($val);
        $this->load->view('app/time/compress_schedule/add_compress_group',$this->data);
    }

    public function edit_time_compress_group($val){
        $this->data['cGinfo'] = $this->time_compress_schedule_model->getGroupDet($val);
        $this->load->view('app/time/compress_schedule/edit_compress_group',$this->data);

    }

    public function update_time_compress_group(){

        $this->form_validation->set_rules("compress_group_name","Group","required|trim|xss_clean|callback_validate_update_group_name");

        $this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
            $compress_group_name = $this->input->post('compress_group_name');
            $value=$compress_group_name;
            $c_group_id = $this->input->post('c_group_id');
            $c_mon = $this->input->post('c_mon');
            $c_tue = $this->input->post('c_tue');
            $c_wed = $this->input->post('c_wed');
            $c_thu = $this->input->post('c_thu');
            $c_fri = $this->input->post('c_fri');
            $c_sat = $this->input->post('c_sat');
            $c_sun = $this->input->post('c_sun');
            $count_as_halfday_due_to_late = $this->input->post('count_as_halfday_due_to_late');
            $count_as_halfday_due_to_ut = $this->input->post('count_as_halfday_due_to_ut');
            $halfday_required_hrs = $this->input->post('halfday_required_hrs');
             $allow_per_hour_filing=$this->input->post('allow_per_hour_filing');
            $getGroupDet=$this->time_compress_schedule_model->getGroupDet($c_group_id);
        if($this->form_validation->run()){
            
            $data_update_time_compress_group = array(
                'compress_group_name'  =>  $compress_group_name,
                'c_mon'  =>  $c_mon,
                'c_tue'  =>  $c_tue,
                'c_wed'  =>  $c_wed,
                'c_thu'  =>  $c_thu,
                'c_fri'  =>  $c_fri,
                'c_sat'  =>  $c_sat,
                'c_sun'  =>  $c_sun,
                'count_as_halfday_due_to_late'  =>  $count_as_halfday_due_to_late,
                'count_as_halfday_due_to_ut'  =>  $count_as_halfday_due_to_ut,
                'halfday_required_hrs'  =>  $halfday_required_hrs,
                'allow_per_hour_filing' =>  $allow_per_hour_filing

                );

            $this->time_compress_schedule_model->update_time_compress_group($data_update_time_compress_group,$c_group_id);

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('SMS','Compress Work Schedule','logfile_time_compress_work_schedule','update '.$value.': value: '.$value.' ,','UPDATE',$value);

            $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group:  <strong>".$value."</strong>, is Successfully Updated!</div>");
            // redirect

            $this->session->set_flashdata('onload',"view_compress_group('".$getGroupDet->company_id."')");
            redirect(base_url().'app/time_compress_schedule/index',$this->data);

        }else{

            $this->index();
        }        
    }

    public function save_time_compress_group(){

        $this->form_validation->set_rules("compress_group_name","Group","required|trim|xss_clean|callback_validate_group_name");

        $this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
            $compress_group_name = $this->input->post('compress_group_name');
            $value=$compress_group_name;
            $company_id = $this->input->post('company_id');
            $c_mon = $this->input->post('c_mon');
            $c_tue = $this->input->post('c_tue');
            $c_wed = $this->input->post('c_wed');
            $c_thu = $this->input->post('c_thu');
            $c_fri = $this->input->post('c_fri');
            $c_sat = $this->input->post('c_sat');
            $c_sun = $this->input->post('c_sun');
            $count_as_halfday_due_to_ut = $this->input->post('count_as_halfday_due_to_ut');
            $count_as_halfday_due_to_late = $this->input->post('count_as_halfday_due_to_late');
            $halfday_required_hrs = $this->input->post('halfday_required_hrs');
            $allow_per_hour_filing=$this->input->post('allow_per_hour_filing');
            $date_created=date('Y-m-d H:i:s');
        if($this->form_validation->run()){
            
            $data_save_time_compress_group = array(
                'company_id'  =>  $company_id,
                'compress_group_name'  =>  $compress_group_name,
                'c_mon'  =>  $c_mon,
                'c_tue'  =>  $c_tue,
                'c_wed'  =>  $c_wed,
                'c_thu'  =>  $c_thu,
                'c_fri'  =>  $c_fri,
                'c_sat'  =>  $c_sat,
                'c_sun'  =>  $c_sun,
                'halfday_required_hrs'  =>  $halfday_required_hrs,
                'count_as_halfday_due_to_ut'  =>  $count_as_halfday_due_to_ut,
                'count_as_halfday_due_to_late'  =>  $count_as_halfday_due_to_late,
                'InActive'  =>  0,
                'date_created'  =>  $date_created,
                'allow_per_hour_filing' => $allow_per_hour_filing

                );

            $this->time_compress_schedule_model->save_time_compress_group($data_save_time_compress_group);

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('SMS','Compress Work Schedule','logfile_time_compress_work_schedule','add '.$value.': value: '.$value.' ,','INSERT',$value);

            $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group:  <strong>".$value."</strong>, is Successfully Added!</div>");
            // redirect

            $this->session->set_flashdata('onload',"view_compress_group('".$company_id."')");
            redirect(base_url().'app/time_compress_schedule/index',$this->data);

        }else{

            $this->index();
        }        
    }


    public function validate_update_group_name(){

        $value = $this->input->post('compress_group_name');
        $c_group_id = $this->input->post('c_group_id');
        $company_id = $this->input->post('company_id');
        $affected = 0;

            if($this->time_compress_schedule_model->validate_update_group_name($value,$company_id)){
        
                $this->form_validation->set_message("validate_update_group_name"," Group Name, <strong>".$value."</strong>, Already Exists");
                $affected++;
            }
        
        if($affected > 0){
            return false;
        }
        else{
            return true;
        }

    }


    public function validate_group_name(){

        $value = $this->input->post('compress_group_name');
        $company_id = $this->input->post('company_id');
        $affected = 0;

            if($this->time_compress_schedule_model->validate_group_name($value,$company_id)){
        
                $this->form_validation->set_message("validate_group_name"," Group Name, <strong>".$value."</strong>, Already Exists");
                $affected++;
            }
        
        if($affected > 0){
            return false;
        }
        else{
            return true;
        }

    }


}//end controller