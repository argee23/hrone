<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Time_fixed_schedule extends General{

    function __construct(){
        parent::__construct();  
        $this->load->model("app/time_fixed_schedule_model");
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
			
		$this->load->view('app/time/fixed_schedule/index',$this->data);
 	}

    public function view_company_group(){
        $company_id                         = $this->uri->segment("4");
        $this->data['company_name']         = $this->time_fixed_schedule_model->get_company_info($company_id);
        //$this->data['company_group']        = $this->time_fixed_schedule_model->get_company_group($company_id);
        $this->data['company_group']        = $this->time_fixed_schedule_model->get_company_group_new($company_id);
        $this->load->view('app/time/fixed_schedule/view_company_group',$this->data);
    }

    public function add_group(){
        $company_id                         = $this->uri->segment("4");
        $this->data['company_info']         = $this->time_fixed_schedule_model->get_company_info($company_id);
        $this->data['company_division']     = $this->time_fixed_schedule_model->get_division_info($company_id);
        $this->data['company_department']   = $this->time_fixed_schedule_model->get_department_info($company_id);

        $this->load->view('app/time/fixed_schedule/add_group',$this->data);
    }

    public function get_DivisionDepartment(){
        $division_id                       = $this->uri->segment("4");
        if($division_id != 0){
         $this->data['division_department'] = $this->time_fixed_schedule_model->get_division_department_info($division_id);
         $this->load->view('app/time/fixed_schedule/view_division_department',$this->data);
        }
    }

    public function get_DepartmentSection(){
        $department_id                       = $this->uri->segment("4");
        if($department_id != 0){
         $this->data['department_section']   = $this->time_fixed_schedule_model->get_department_section_info($department_id);
         $this->load->view('app/time/fixed_schedule/view_department_section',$this->data);
        }
    }

    public function get_SectionSubsection(){
        $section_id                      = $this->uri->segment("4");
        $section_info                    = $this->time_fixed_schedule_model->get_section_info($section_id);
        $wSubsection                     = $section_info->wSubsection;
        if($section_id != 0 && $wSubsection == 1){
            $this->data['section_subsection']   = $this->time_fixed_schedule_model->get_section_subsection_info($section_id);
            $this->load->view('app/time/fixed_schedule/view_section_subsection',$this->data);
        }
    }

    public function save_add_group(){
        $company_id           = $this->uri->segment("4");
        $company_name         = $this->time_fixed_schedule_model->get_company_info($company_id);

        $alreadyexist = $this->time_fixed_schedule_model->exist_group_name($company_id);
        if($alreadyexist == 1){
              
               $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group is Already Exist to this company ".$company_name->company_name."</div>");

             redirect('app/time_fixed_schedule');

        }else{

     
        $this->data = array(
            'company_id'                =>  $company_id,
            'group_name'                =>  $this->input->post('group_name'),
            'division_id'               =>  $division,
            'department'                =>  $department,
            'section'                   =>  $section,
            'subsection_id'             =>  $subsection,
            'system_user'               =>  $this->session->userdata('employee_id'),
            'date_created'              =>  date("Y-m-d h:i:s a"),
            'InActive'                  =>  0 
        );  

        $this->time_fixed_schedule_model->save_add_group($this->data);

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Fixed Schedule','logfile_time_fixed_schedule','add group name : '.$this->input->post('group_name').' to company id: '.$company_id.'','INSERT',$this->input->post('group_name'));


        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group Successfully added to ".$company_name->company_name."</div>");


        $this->session->set_flashdata('onload',"view_company_group(".$company_id.")");

        redirect('app/time_fixed_schedule');
         }
    }

    public function delete_group(){
        $group_id            = $this->uri->segment("4");
        $group_name          = $this->time_fixed_schedule_model->get_group_name($group_id);

        $this->time_fixed_schedule_model->delete_group($group_id);
        General::logfile('TIME->Fixed schedule->Group','Delete',$group_id);


            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Fixed Schedule','logfile_time_fixed_schedule','delete group id : '.$group_id.' / group name: '.$group_name->group_name.'','DELETE',$group_id);


        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group ".$group_name->group_name." Successfully Deleted.</div>");

        redirect('app/time_fixed_schedule');
    }

    public function edit_group(){
        $group_id                           = $this->uri->segment("4");
        $group_info                         = $this->time_fixed_schedule_model->get_group_name($group_id);
        $company_id                         = $group_info->company_id;
        $this->data['company_info']         = $this->time_fixed_schedule_model->get_company_info($company_id);
        $this->data['group']                = $this->time_fixed_schedule_model->get_group_info($group_id);
        $this->data['company_division']     = $this->time_fixed_schedule_model->get_division_info($company_id);
        $this->data['company_department']   = $this->time_fixed_schedule_model->get_department_info($company_id);
        $this->load->view('app/time/fixed_schedule/edit_group',$this->data);
    }

    public function modify_edit_group(){
        $group_id             = $this->uri->segment("4");
        $group_name           = $this->time_fixed_schedule_model->get_group_name($group_id);
        $group_info           = $this->time_fixed_schedule_model->get_group_info($group_id);
        $company_id           = $group_info->company_id;

          $alreadyexist = $this->time_fixed_schedule_model->exist_group_name($company_id);
        if($alreadyexist == 1){
              
               $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group is Already Exist to this company ".$company_name->company_name."</div>");

             redirect('app/time_fixed_schedule');

        }else{

        $this->data = array(
            'group_name'                =>  $this->input->post('group_name'),
            'division_id'               =>  $division,
            'department'                =>  $department,
            'section'                   =>  $section,
            'subsection_id'             =>  $subsection
        );  

        $this->time_fixed_schedule_model->modify_edit_group($group_id,$this->data);
        General::logfile('TIME->Fixed schedule->Group','Modify',$group_id);
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Fixed Schedule','logfile_time_fixed_schedule','update group name : '.$this->input->post('group_name').' to company id: '.$company_id.'','UPDATE',$this->input->post('group_name'));


        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group ".$group_name->group_name." Successfully Modified.</div>");


        $this->session->set_flashdata('onload',"edit_group(".$group_id.")");
        redirect('app/time_fixed_schedule');
        }
    }

    public function view_group_employee(){
        $group_id                               = $this->uri->segment("4");
        $this->data['group_info']               = $this->time_fixed_schedule_model->get_group_info($group_id);
        $this->data['group_employee']           = $this->time_fixed_schedule_model->get_group_employee($group_id);
        $this->data['group_name']               = $this->time_fixed_schedule_model->get_group_name($group_id);

        $group_details                          = $this->time_fixed_schedule_model->get_group_details($group_id);

        $company                                = $group_details->company_id;
        $division                               = $group_details->division_id;
        $department                             = $group_details->department;
        $section                                = $group_details->section;
        $subsection                             = $group_details->subsection_id;

        $this->data['available_employee']       = $this->time_fixed_schedule_model->get_available_employee($company, $division, $department, $section, $subsection);

        $this->data['available_employee_sec']   = $this->time_fixed_schedule_model->get_available_employee_sec($company, $division, $department, $section, $subsection);
        
        $this->load->view('app/time/fixed_schedule/view_group_employee',$this->data);

    }

    public function remove_employee(){
        $employee_id                        = $this->uri->segment("4");
        $group_id            = $this->uri->segment("5");
        $this->time_fixed_schedule_model->delete_employee_group($employee_id);
        General::logfile('TIME->Fixed schedule->Employee','REMOVE',$employee_id);


            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Fixed Schedule','logfile_time_fixed_schedule','Remove member : '.$employee_id.' to group id: '.$group_id.'','DELETE',$employee_id);


        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " .$employee_id." Employee Successfully Removed from group!</div>");

           $this->session->set_flashdata('onload',"view_group_employee(".$group_id.")");
        redirect('app/time_fixed_schedule');
    }

    public function save_employee_group(){
        $group_id                   = $this->uri->segment("4");
        $group_details              = $this->time_fixed_schedule_model->get_group_details($group_id);
        $company                    = $group_details->company_id;
        $user                       = $this->session->userdata('employee_id');
        $system_user                = $this->time_fixed_schedule_model->get_system_user($user);
        $user_role                  = $system_user->user_role;
        $employee_selected          = $this->input->post('employeeselected');   
        $num_selected               = count($employee_selected);
        for($num = 0; $num < $num_selected; $num++){
            $data_employee = array(
                'group_id'             => $group_id,
                'company_id'           => $company,
                'employee_id'          => $employee_selected[$num],
                'system_user'          => $user_role,
                'date_added'           => date("Y-m-d h:i:s a"),
                'InActive'             => 0
            );
            $this->time_fixed_schedule_model->insert_employee_group($data_employee);
            General::logfile('TIME->Fixed schedule->Employee','INSERT',$employee_selected[$num]);

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Fixed Schedule','logfile_time_fixed_schedule','add employee: '.$employee_selected[$num].' to group id: '.$group_id.'','INSERT',$employee_selected[$num]);

        }
        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " .$num_selected." Employee(s) Successfully Added to group!</div>");
 
         $this->session->set_flashdata('onload',"view_group_employee(".$group_id.")");       
        redirect('app/time_fixed_schedule');
    }

    public function view_edit_employee(){
        $employee_id                            = $this->uri->segment("4");
        $employee                               = $this->time_fixed_schedule_model->get_employee_info($employee_id);
        $company_id                             = $employee->company_id;
        $classification_id                      = $employee->classification;    
        $this->data['shift_in_out_complete']    = $this->time_fixed_schedule_model->get_shift_in_out_complete($company_id,$classification_id);
        $this->data['shift_in_out_half']        = $this->time_fixed_schedule_model->get_shift_in_out_half($company_id,$classification_id);
        $this->data['shift_in_out_hol']         = $this->time_fixed_schedule_model->get_shift_in_out_hol($company_id,$classification_id);
        $this->data['employee']                 = $this->time_fixed_schedule_model->get_employee_details($employee_id);
        $this->load->view('app/time/fixed_schedule/edit_employee',$this->data);
    }

    public function modify_employee_member(){
        $employee_id                = $this->uri->segment("4");

        $this->time_fixed_schedule_model->modify_employee_member($employee_id);

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Fixed Schedule','logfile_time_fixed_schedule','update schedule of : '.$employee_id.'','UPDATE',$employee_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ".$employee_id." employee id Successfully Modified.</div>");


         $this->session->set_flashdata('onload',"view_edit_employee(".$employee_id.")");
         redirect('app/time_fixed_schedule');
    }

    public function view_employee_schedule(){
        $employee_id                            = $this->uri->segment("4");
        $employee                               = $this->time_fixed_schedule_model->get_employee_info($employee_id);
        $company_id                             = $employee->company_id;
        $classification_id                      = $employee->classification;    
        $this->data['shift_in_out_complete']    = $this->time_fixed_schedule_model->get_shift_in_out_complete($company_id,$classification_id);
        $this->data['shift_in_out_half']        = $this->time_fixed_schedule_model->get_shift_in_out_half($company_id,$classification_id);
        $this->data['shift_in_out_hol']         = $this->time_fixed_schedule_model->get_shift_in_out_hol($company_id,$classification_id);
        $this->data['employee']                 = $this->time_fixed_schedule_model->get_employee_details($employee_id);
        $this->load->view('app/time/fixed_schedule/view_employee_schedule',$this->data);
    }

    public function employees_schedule(){
        $group_id                            = $this->uri->segment("4");
        $this->data['group_details']         = $this->time_fixed_schedule_model->get_group_details($group_id);

        $this->data['fixedschedgroup_members'] = $this->time_fixed_schedule_model->get_group_employee($group_id);
        $this->load->view('app/time/fixed_schedule/employees_schedule',$this->data);
    }
    public function master_plot(){
        $group_id                            = $this->uri->segment("4");
        $company_id                            = $this->uri->segment("5");
        $this->data['shift_in_out_half']        = $this->time_fixed_schedule_model->get_distinct_half($company_id);
        $this->data['reg_shifts']         = $this->time_fixed_schedule_model->get_regular_shifts($company_id);
        $this->data['group_details']         = $this->time_fixed_schedule_model->get_group_details($group_id);
        $this->load->view('app/time/fixed_schedule/master_plot',$this->data);
    }

    public function view_employee(){
        $company_id                            = $this->uri->segment("4");
        $division                              = 0;
        $department                            = 0;
        $section                               = 0;
        $subsection                            = 0;
        $this->data['employee_flexi']          = $this->time_fixed_schedule_model->get_employee_flexi($company_id);
        $this->data['employee_fixed']          = $this->time_fixed_schedule_model->get_employee_fixed($company_id);
        $this->data['employee_section']        = $this->time_fixed_schedule_model->get_employee_section($company_id);
        $this->data['employee_admin']          = $this->time_fixed_schedule_model->get_employee_admin($company_id);
        $this->data['company_name']            = $this->time_fixed_schedule_model->get_company_info($company_id);
        $this->data['employee_available']      = $this->time_fixed_schedule_model->get_available_employee($company_id, $division, $department, $section, $subsection);

        $this->load->view('app/time/fixed_schedule/view_all_employee',$this->data);
    }

    public function view_search(){
        $company_id                             = $this->uri->segment("4");
        $search                                 = $this->uri->segment("5");
        $division                              = 0;
        $department                            = 0;
        $section                               = 0;
        $subsection                            = 0;
        $this->data['employee_flexi']          = $this->time_fixed_schedule_model->get_employee_flexi($company_id);
        $this->data['employee_fixed']          = $this->time_fixed_schedule_model->get_employee_fixed($company_id);
        $this->data['employee_section']        = $this->time_fixed_schedule_model->get_employee_section($company_id);
        $this->data['employee_admin']          = $this->time_fixed_schedule_model->get_employee_admin($company_id);
        $this->data['company_name']            = $this->time_fixed_schedule_model->get_company_info($company_id);
        $this->data['employee_available']      = $this->time_fixed_schedule_model->get_available_employee($company_id, $division, $department, $section, $subsection);

        $this->load->view('app/time/fixed_schedule/view_all_employee_search',$this->data);
    }

    public function inactivate_group(){
        $group_id            = $this->uri->segment("4");
        $group_name          = $this->time_fixed_schedule_model->get_group_name($group_id);

        $this->time_fixed_schedule_model->inactive_group($group_id);
        $this->time_fixed_schedule_model->inactive_member($group_id);

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Fixed Schedule','logfile_time_fixed_schedule','deactivate group id : '.$group_id.'','DEACTIVATE',$group_id);


        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group ".$group_name->group_name." Successfully Inactivate.</div>");

        $this->session->set_flashdata('onload',"view_company_group(".$group_name->company_id.")");
        redirect('app/time_fixed_schedule');
    }

    public function save_master_plot(){
        $group_id            = $this->uri->segment("4");
        $group_name          = $this->time_fixed_schedule_model->get_group_name($group_id);

        $group_member=$this->time_fixed_schedule_model->group_active_member($group_id);
        if(!empty($group_member)){
            foreach($group_member as $m){

              $company_id=$m->company_id;
              $location=$m->location; //location id
              $classification=$m->classification_id; //classification id

               //echo "$company_id $location $classification <br>";
              require(APPPATH.'views/include/loc_class_restriction.php');

                    if($allowed>0){ // check this variable at loc_class_restriction

                        $mon=$this->input->post('mon');
                        $tue=$this->input->post('tue');
                        $wed=$this->input->post('wed');
                        $thu=$this->input->post('thu');
                        $fri=$this->input->post('fri');
                        $sat=$this->input->post('sat');
                        $sun=$this->input->post('sun');

                     $query=$this->db->query("update fixed_working_schedule_members set mon='".$mon."',tue='".$tue."',wed='".$wed."',thu='".$thu."',fri='".$fri."',sat='".$sat."',sun='".$sun."' where employee_id='".$m->employee_id."' and group_id='".$group_id."'");

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Fixed Schedule','logfile_time_fixed_schedule','one time update schedule of all members of group id : '.$group_id.'','UPDATE',$group_id);



                    }else{

                    }
            }

        }else{

        }

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Schedule is Successfully plotted to group: ".$group_name->group_name.".</div>");

        $this->session->set_flashdata('onload',"view_group_employee(".$group_id.")");
        redirect('app/time_fixed_schedule');
    }
    public function activate_group(){
        $group_id            = $this->uri->segment("4");
        $group_name          = $this->time_fixed_schedule_model->get_group_name($group_id);

        $this->time_fixed_schedule_model->active_group($group_id);
        $this->time_fixed_schedule_model->active_member($group_id);

         /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Fixed Schedule','logfile_time_fixed_schedule','activate group id : '.$group_id.'','ACTIVATE',$group_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group ".$group_name->group_name." Successfully Activate.</div>");

        $this->session->set_flashdata('onload',"view_company_group(".$group_name->company_id.")");
        redirect('app/time_fixed_schedule');
    }

    public function inactivate_employee(){
        $employee_id            = $this->uri->segment("4");
        $group_id            = $this->uri->segment("5");


        $this->time_fixed_schedule_model->inactive_employee($employee_id);

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Fixed Schedule','logfile_time_fixed_schedule','deactivate member : '.$employee_id.' to group id: '.$group_id.'','DEACTIVATE',$employee_id);


        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee ".$employee_id." Successfully Inactivate.</div>");

        $this->session->set_flashdata('onload',"view_group_employee(".$group_id.")");
        redirect('app/time_fixed_schedule',$this->data);
    }

    public function activate_employee(){
        $employee_id            = $this->uri->segment("4");
        $group_id            = $this->uri->segment("5");

        $this->time_fixed_schedule_model->active_employee($employee_id);
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Fixed Schedule','logfile_time_fixed_schedule','activate member : '.$employee_id.' to group id: '.$group_id.'','ACTIVATE',$employee_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee ".$employee_id." Successfully Activate.</div>");
        $this->session->set_flashdata('onload',"view_group_employee(".$group_id.")");
        redirect('app/time_fixed_schedule');
    }

    public function add_employee($company_id,$group_id){

        $group_id                               = $group_id;
        $company_id                             = $company_id;
        $this->data['group_info']               = $this->time_fixed_schedule_model->get_group_info($group_id);
        $this->data['group_employee']           = $this->time_fixed_schedule_model->get_group_employee($group_id);
        $this->data['group_name']               = $this->time_fixed_schedule_model->get_group_name($group_id);

        $group_details                          = $this->time_fixed_schedule_model->get_group_details($group_id);

        $company                                = $group_details->company_id;
        $division                               = $group_details->division_id;
        $department                             = $group_details->department;
        $section                                = $group_details->section;
        $subsection                             = $group_details->subsection_id;

        $this->data['company_locations']        = $this->time_fixed_schedule_model->get_company_location($company_id);
        $this->data['company_classifications']  = $this->time_fixed_schedule_model->get_company_classification($company_id);
        $this->data['company_isDiv']            = $this->time_fixed_schedule_model->get_company_isDivision($company_id);
        $this->data['company_division']         = $this->time_fixed_schedule_model->get_company_division($company_id);
        $this->data['company_department']       = $this->time_fixed_schedule_model->get_company_department($company_id);
        //$this->data['available_employee']       = $this->time_fixed_schedule_model->get_available_employee($company, $division, $department, $section, $subsection);

        $this->load->view('app/time/fixed_schedule/filter_choices',$this->data);
       // $this->load->view('app/time/fixed_schedule/add_employee',$this->data);

    }

      public function saveGroupMember(){

         $company_id = $this->input->post('company_id');
         $group_id = $this->input->post('group_id');      

         $division_id=$this->input->post('division');
         $department_id=$this->input->post('department');
         $section_id=$this->input->post('section');
         $subsection_id=$this->input->post('subsection');
         $location=$this->input->post('location');
         $classification=$this->input->post('classification');
         $employment=$this->input->post('employment');
         $taxcode=$this->input->post('taxcode');
         $pay_type=$this->input->post('pay_type');
         $civil_status=$this->input->post('civil_status');
         $gender_sex=$this->input->post('gender_sex');
            // echo " below is checker
            // division_id $division_id <br>
            // depar $department_id <br>
            // sect $section_id <br>
            // subsec $subsection_id <br>
            // loc $location <br>
            // class $classification <br>
            // emp $employment <br>
            // taxc $taxcode <br>
            // paytype $pay_type <br>
            // civilstatus $civil_status <br>
            // gender $gender_sex
            // ";

        if($division_id=="All"){
            $division_condition="";
        }else{
            $division_condition="AND a.division_id='".$division_id."' ";
        }

        if($department_id=="All"){
            $department_condition="";
        }else{
            $department_condition="AND a.department='".$department_id."' ";
        }

        if($section_id=="All"){
            $section_condition="";
        }else{
            $section_condition="AND a.section='".$section_id."' ";
        }
        if($subsection_id=="All"){
            $subsection_condition="";
        }else{
            $subsection_condition="AND a.subsection='".$subsection_id."' ";
        }
        if($location=="All"){
            $location_condition="";
        }else{
            $location_condition="AND a.location='".$location."' ";
        }
        if($classification=="All"){
            $classification_condition="";
        }else{
            $classification_condition="AND a.classification='".$classification."' ";
        }
        if($employment=="All"){
            $employment_condition="";
        }else{
            $employment_condition="AND a.employment='".$employment."' ";
        }
        if($taxcode=="All"){
            $taxcode_condition="";
        }else{
            $taxcode_condition="AND a.taxcode='".$taxcode."' ";
        }
        if($pay_type=="All"){
            $pay_type_condition="";
        }else{
            $pay_type_condition="AND a.pay_type='".$pay_type."' ";
        }
        if($civil_status=="All"){
            $civil_status_condition="";
        }else{
            $civil_status_condition="AND a.civil_status='".$civil_status."' ";
        }
        if($gender_sex=="All"){
            $gender_condition="";
        }else{
            $gender_condition="AND a.gender='".$gender_sex."' ";
        }

        $this->data['available_employee']       = $this->time_fixed_schedule_model->CheckAvailableEmp($company_id,$group_id,$division_condition,$department_condition,$section_condition,$subsection_condition,$location_condition,$classification_condition,$employment_condition,$taxcode_condition,$pay_type_condition,$civil_status_condition,$gender_condition);

        $this->data['onload']     = $this->session->flashdata('onload');
        $this->data['message']    = $this->session->flashdata('message');

        // $this->data['group_info']               = $this->time_fixed_schedule_model->get_group_info($group_id);
        // $this->data['group_employee']           = $this->time_fixed_schedule_model->get_group_employee($group_id);
        // $this->data['group_name']               = $this->time_fixed_schedule_model->get_group_name($group_id);

        
        // $this->data['company_isDiv'] = $this->time_fixed_schedule_model->get_company_isDivision($company_id);
        // $this->data['company_division'] = $this->time_fixed_schedule_model->get_company_division($company_id);
        // $this->data['company_department'] = $this->time_fixed_schedule_model->get_company_department($company_id);
        // $this->data['available_employee']       = $this->time_fixed_schedule_model->get_available_employee_new($company_id,$division_id,$department_id,$section_id,$subsection_id,$location,$classification,$employment,$taxcode,$pay_type,$civil_status,$gender_sex);

        
        $this->load->view('app/time/fixed_schedule/employee_table_result',$this->data);

    }

    public function emp_table_result_wo_div($group_id,$company_id,$department_id,$section_id,$subsection_id,$location,$classification,$employment,$taxcode,$pay_type,$civil_status,$gender_sex){

                           
         $group_id                                = $group_id;
         $company_id                             =  $company_id;                    
         $department_id                           = $department_id;
         $section_id                              = $section_id;
         $subsection_id                           = $subsection_id;
         $location                                = $location;
         $classification                          = $classification;
         $employment                              = $employment;
         $taxcode                                 = $taxcode;
         $pay_type                                = $pay_type;
         $civil_status                            = $civil_status;
         $gender_sex                              = $gender_sex;

        $this->data['group_info']               = $this->time_fixed_schedule_model->get_group_info($group_id);
        $this->data['group_employee']           = $this->time_fixed_schedule_model->get_group_employee($group_id);
        $this->data['group_name']               = $this->time_fixed_schedule_model->get_group_name($group_id);

        

        $this->data['company_isDiv'] = $this->time_fixed_schedule_model->get_company_isDivision($company_id);
        $this->data['company_division'] = $this->time_fixed_schedule_model->get_company_division($company_id);
        $this->data['company_department'] = $this->time_fixed_schedule_model->get_company_department($company_id);
        $this->data['available_employee']       = $this->time_fixed_schedule_model->get_available_employee_new_wo_div($company_id,$department_id,$section_id,$subsection_id,$location,$classification,$employment,$taxcode,$pay_type,$civil_status,$gender_sex);

        
        $this->load->view('app/time/fixed_schedule/employee_table_result',$this->data);

    }


    public function get_division_department(){
        $division_id = $this->uri->segment("4");
        $this->data['company_division'] = $this->time_fixed_schedule_model->get_division_department($division_id);
        $this->load->view('app/time/fixed_schedule/division_department_list',$this->data);
    }

    public function get_department_sections(){
        $department_id = $this->uri->segment("4");
        $this->data['department_sections'] = $this->time_fixed_schedule_model->get_department_section($department_id);
        $this->load->view('app/time/fixed_schedule/department_section_list',$this->data);
    }

    public function get_section_subsection(){
        $section_id = $this->uri->segment("4");
        $this->data['section_isSub'] = $this->time_fixed_schedule_model->get_section_isSubsection($section_id);
        $this->data['section_subsection'] = $this->time_fixed_schedule_model->get_section_subsection($section_id);
        $this->load->view('app/time/fixed_schedule/section_subsection_list',$this->data);
    }

}	

