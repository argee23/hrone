<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Time_flexi_schedule extends General{

    function __construct(){
        parent::__construct();  
        $this->load->model("app/time_flexi_schedule_model");
        $this->load->model("app/time_fixed_schedule_model");
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
			
		$this->load->view('app/time/flexi_schedule/index',$this->data);
 	}	

 	public function view_company_group(){
 		$company_id 						= $this->uri->segment("4");
 		$this->data['company_name'] 		= $this->time_flexi_schedule_model->get_company_name($company_id);
 		$this->data['company_group'] 		= $this->time_flexi_schedule_model->get_company_group($company_id);
 		$this->load->view('app/time/flexi_schedule/view_company_group',$this->data);
 	}

 	public function add_group(){
 		$company_id 						= $this->uri->segment("4");
        $this->data['group_type']           = $this->time_flexi_schedule_model->get_group_type();
 		$this->data['company_name'] 		= $this->time_flexi_schedule_model->get_company_name($company_id);
 		$this->data['company_group']        = $this->time_flexi_schedule_model->get_company_group($company_id);
 		$this->load->view('app/time/flexi_schedule/add_group',$this->data);
 	}

    public function save_add_group(){
        $company_id                 = $this->uri->segment("4");

        $company_name               = $this->time_flexi_schedule_model->get_company_name($company_id);
        
        $alreadyexist = $this->time_flexi_schedule_model->exist_group_name($company_id);
        if($alreadyexist == 1){
             $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group is Already Exist to this company ".$company_name->company_name."</div>");
              redirect('app/time_flexi_schedule');

        }else{

        $this->time_flexi_schedule_model->save_add_group($company_id);
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Flexi Schedule','logfile_time_flexi_schedule','Add group : '.$this->input->post('group_name').' to company id: '.$company_id.'','INSERT',$this->input->post('group_name'));

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group Successfully added to ".$company_name->company_name."</div>");

        $this->session->set_flashdata('onload',"view_company_group(".$company_id.")");
        redirect('app/time_flexi_schedule');
        }
    }

    public function get_timelimit(){
        $group_type_id                         = $this->uri->segment("4");
        if($group_type_id == 'controlled_flexi'){
            $this->load->view('app/time/flexi_schedule/view_time_limit',$this->data);
        }
    }

    public function inactivate_group(){
        $group_id            = $this->uri->segment("4");
        $group_name          = $this->time_flexi_schedule_model->get_group_name($group_id);

        $this->time_flexi_schedule_model->inactive_group($group_id);
        $this->time_flexi_schedule_model->inactive_member($group_id);
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Flexi Schedule','logfile_time_flexi_schedule','Deactivate group & member of group id : '.$group_id.'','DEACTIVATE',$group_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group ".$group_name->group_name." Successfully Deactivate.</div>");

        $this->session->set_flashdata('onload',"view_company_group(".$group_name->company_id.")");
        redirect('app/time_flexi_schedule');
    }

    public function activate_group(){
        $group_id            = $this->uri->segment("4");
        $group_name               = $this->time_flexi_schedule_model->get_group_name($group_id);

        $this->time_flexi_schedule_model->active_group($group_id);
        $this->time_flexi_schedule_model->active_member($group_id);

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Flexi Schedule','logfile_time_flexi_schedule','Activate group & member of group id : '.$group_id.'','ACTIVATE',$group_id);


        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group ".$group_name->group_name." Successfully Activate.</div>");

        $this->session->set_flashdata('onload',"view_company_group(".$group_name->company_id.")");
        redirect('app/time_flexi_schedule');
    }

    public function delete_group(){
        $group_id            = $this->uri->segment("4");
        //echo $group_id;
        $group_name          = $this->time_flexi_schedule_model->get_group_name($group_id);

        $this->time_flexi_schedule_model->delete_group($group_id);
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Flexi Schedule','logfile_time_flexi_schedule','Delete group & member of group id : '.$group_id.'','DELETE',$group_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group ".$group_name->group_name." Successfully Deleted.</div>");

        $this->session->set_flashdata('onload',"view_company_group(".$group_name->company_id.")");
        redirect('app/time_flexi_schedule');
    }

    public function edit_group(){
        $group_id                           = $this->uri->segment("4");
        $this->data['group_type']           = $this->time_flexi_schedule_model->get_group_type();
        $this->data['company_name']         = $this->time_flexi_schedule_model->get_group_company_name($group_id);
        $this->data['group_info']           = $this->time_flexi_schedule_model->get_group_info($group_id);
        $this->load->view('app/time/flexi_schedule/edit_group',$this->data);
    }

    public function modify_edit_group(){
        $group_id                 = $this->uri->segment("4");
        $group_name_               = $this->time_flexi_schedule_model->get_group_name($group_id);
        $company_id = $this->input->post("company_id");
        $group_name = $this->input->post('group_name');
        $group_description = $this->input->post('group_description');
        /*$alreadyexist = $this->time_flexi_schedule_model->exist_group_name($company_id,$group_description);
        if($alreadyexist == 1){
*/          $this->form_validation->set_rules("group_name","Flexi Time Groupname","trim|required|callback_validate_group_name");
            $this->form_validation->set_rules("group_description","Flexi Time Description","trim|required|callback_validate_group_des");
            $this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

        if($this->form_validation->run()){

             $this->time_flexi_schedule_model->modify_edit_group($group_id);
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Flexi Schedule','logfile_time_flexi_schedule','Update group name of : '.$group_id.' to '.$group_name.'','UPDATE',$group_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group ".$group_name_->group_name." Successfully Modified.</div>");

        $this->session->set_flashdata('onload',"view_company_group(".$group_name_->company_id.")");
        redirect('app/time_flexi_schedule');
         
        }else{

        $this->session->set_flashdata('onload',"view_company_group(".$company_id.")");
        redirect('app/time_flexi_schedule');
       
      }
    }
     public function validate_group_name(){
        $company_id =$this->input->post('company_id');     
        $value = $this->input->post('group_name');
        $group_id   = $this->uri->segment("4");
        if($this->time_flexi_schedule_model->validate_group_name($group_id)){
            $this->form_validation->set_message("validate_group_name"," Group Name, <strong>".$value."</strong>, Already Exists.");
            return false;
        }else{
            return true;
        }
    }
    public function validate_group_des(){
        $company_id =$this->input->post('company_id');     
        $value = $this->input->post('group_description');
         $group_id  = $this->uri->segment("4");
        if($this->time_flexi_schedule_model->validate_group_des($group_id)){
            $this->form_validation->set_message("validate_group_des"," Group Description, <strong>".$value."</strong>, Already Exists.");
            return false;
        }else{
            return true;
        }
    }

    public function view_group_employee(){
        $group_id                               = $this->uri->segment("4");
        $this->data['group_name']               = $this->time_flexi_schedule_model->get_group_name($group_id);
        $this->data['group_employee']           = $this->time_flexi_schedule_model->get_group_employee($group_id);
        $this->data['employee_group']           = $this->time_flexi_schedule_model->get_employee($group_id);
        $group_details                          = $this->time_flexi_schedule_model->get_group_details($group_id);
        $company_id                             = $group_details->company_id;
        $this->data['available_employee']       = $this->time_flexi_schedule_model->get_available_employee($company_id);
        //$this->data['available_employee_sec']   = $this->time_flexi_schedule_model->get_available_employee_sec($company_id);
        
        $this->load->view('app/time/flexi_schedule/view_group_employee',$this->data);
    }

    public function get_group_employee($group_id){
        $group_id                       = $this->uri->segment("4");
        $this->data['group_name']       = $this->time_flexi_schedule_model->get_group_name($group_id);
        $this->data['group_employee']   = $this->time_flexi_schedule_model->get_group_employee($group_id);
        
        $this->load->view('app/time/flexi_schedule/view_group_employee',$this->data);
    }

    public function save_employee_group(){
        $group_id                   = $this->uri->segment("4");
        $group_details              = $this->time_flexi_schedule_model->get_group_details($group_id);
        $company_id                 = $group_details->company_id;
        $group_type                 = $group_details->group_type;
        $employee_selected          = $this->input->post('employeeselected');   
        $num_selected               = count($employee_selected);
        for($num = 0; $num < $num_selected; $num++){
            $data_employee = array(
                'flexi_group_id'       => $group_id,
                'company_id'           => $company_id,
                'employee_id'          => $employee_selected[$num],
                'mon'                  => $group_type,
                'tue'                  => $group_type,
                'wed'                  => $group_type,
                'thu'                  => $group_type,
                'fri'                  => $group_type,
                'sat'                  => $group_type,
                'sun'                  => $group_type,
                'date_added'           => date("Y-m-d h:i:s a"),
                'InActive'             => 0
            );
            $this->time_flexi_schedule_model->insert_employee_group($data_employee);
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Flexi Schedule','logfile_time_flexi_schedule','Add member: '.$employee_selected[$num].' to group id: '.$group_id.'','INSERT',$employee_selected[$num]);

        }
        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " .$num_selected." Employee(s) Successfully Added to group!</div>");

        $this->session->set_flashdata('onload',"view_group_employee(".$group_id.")");

        redirect('app/time_flexi_schedule/index');
    }

    public function remove_employee(){
        $employee_id                    = $this->uri->segment("4");
        $group_id                    = $this->uri->segment("5");
        $this->time_flexi_schedule_model->delete_employee_group($employee_id);

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Flexi Schedule','logfile_time_flexi_schedule','Delete/Remove: '.$employee_id.' to group id: '.$group_id.'','DELETE',$employee_id);


        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " .$employee_id." Employee Successfully Removed from group!</div>");

        $this->session->set_flashdata('onload',"view_group_employee(".$group_id.")");        
        redirect('app/time_flexi_schedule/index');
    }

    public function employees_schedule(){
        $group_id                            = $this->uri->segment("4");
         $this->data['group_details']         = $this->time_flexi_schedule_model->get_group_name($group_id);

         $this->data['fixedschedgroup_members'] = $this->time_flexi_schedule_model->get_employee($group_id);
         $this->load->view('app/time/flexi_schedule/employees_schedule',$this->data);
    }

    public function master_plot(){
        $group_id                            = $this->uri->segment("4");
        $company_id                          = $this->uri->segment("5");

        $this->data['reg_shifts']            = $this->time_fixed_schedule_model->get_regular_shifts($company_id);
        $this->data['group_details']         = $this->time_flexi_schedule_model->get_group_name($group_id);
        $this->load->view('app/time/flexi_schedule/master_plot',$this->data);
    }
    public function save_master_plot(){
        $group_id                            = $this->uri->segment("4");
        $company_id                          = $this->uri->segment("5");

        $this->time_flexi_schedule_model->go_save_master_plot($group_id,$company_id);

            //event details
            $ed="Mon: ".$this->input->post('mon')."Tue: ".$this->input->post('tue')."Wed: ".$this->input->post('wed')."Thu: ".$this->input->post('thu')."Fri: ".$this->input->post('fri')."Sat: ".$this->input->post('sat')."Sun: ".$this->input->post('sun')." Standard Shift: ".$this->input->post('shift_in_out');
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Flexi Schedule','logfile_time_flexi_schedule','Master Plot Schedule of members of group id: '.$group_id.' '.$ed.'','UPDATE',$group_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ".$employee_id." Schedule is Successfully Modified.</div>");

        $this->session->set_flashdata('onload',"view_group_employee(".$group_id.")");   
        redirect('app/time_flexi_schedule');
    }
    public function view_edit_employee(){
        $employee_id                            = $this->uri->segment("4");
        $employee                               = $this->time_flexi_schedule_model->get_employee_info($employee_id);
        $company_id                             = $employee->company_id;
        $classification_id                      = $employee->classification;    
        $this->data['shift_in_out_complete']    = $this->time_flexi_schedule_model->get_shift_in_out_complete($company_id,$classification_id);
        $this->data['shift_in_out_half']        = $this->time_flexi_schedule_model->get_shift_in_out_half($company_id,$classification_id);
        $this->data['shift_in_out_hol']         = $this->time_flexi_schedule_model->get_shift_in_out_hol($company_id,$classification_id);
        $this->data['employee']         = $this->time_flexi_schedule_model->get_employee_details($employee_id);
        $this->load->view('app/time/flexi_schedule/edit_employee',$this->data);
    }


    public function modify_employee_member(){
        $employee_id                = $this->uri->segment("4");

        $this->time_flexi_schedule_model->modify_employee_member($employee_id);
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Flexi Schedule','logfile_time_flexi_schedule','Update Schedule of: '.$employee_id.' a member of group id: '.$group_id.'','UPDATE',$employee_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ".$employee_id." Schedule is Successfully Modified.</div>");

        $this->session->set_flashdata('onload',"view_edit_employee(".$employee_id.")");   
        redirect('app/time_flexi_schedule');
    }

    public function view_employee_schedule(){
        $employee_id                            = $this->uri->segment("4");
        $employee                               = $this->time_flexi_schedule_model->get_employee_info($employee_id);
        $company_id                             = $employee->company_id;
        $classification_id                      = $employee->classification;    
        $this->data['shift_in_out_complete']    = $this->time_flexi_schedule_model->get_shift_in_out_complete($company_id,$classification_id);
        $this->data['shift_in_out_half']        = $this->time_flexi_schedule_model->get_shift_in_out_half($company_id,$classification_id);
        $this->data['shift_in_out_hol']         = $this->time_flexi_schedule_model->get_shift_in_out_hol($company_id,$classification_id);
        $this->data['employee']                 = $this->time_flexi_schedule_model->get_employee_details($employee_id);
        $this->load->view('app/time/flexi_schedule/view_employee_schedule',$this->data);
    }

    public function view_employee(){
        $company_id                             = $this->uri->segment("4");
        $this->data['employee_flexi']           = $this->time_flexi_schedule_model->get_employee_flexi($company_id);
        $this->data['employee_fixed']           = $this->time_flexi_schedule_model->get_employee_fixed($company_id);
        $this->data['employee_section']         = $this->time_flexi_schedule_model->get_employee_section($company_id);
        $this->data['employee_admin']           = $this->time_flexi_schedule_model->get_employee_admin($company_id);
        $this->data['company_name']             = $this->time_flexi_schedule_model->get_company_name($company_id);
        $this->data['employee_available']       = $this->time_flexi_schedule_model->get_available_employee($company_id);
        $this->data['employee_available_sec']   = $this->time_flexi_schedule_model->get_available_employee_sec($company_id);
        $this->load->view('app/time/flexi_schedule/view_all_employee',$this->data);
    }
    
    public function view_search(){
        $company_id                             = $this->uri->segment("4");
        $search                                 = $this->uri->segment("5");
        //echo '$company_id: '.$company_id.' $search:'.$search;
        $this->data['search']                   = $this->uri->segment("5");
        
        $this->data['employee_flexi']           = $this->time_flexi_schedule_model->get_employee_flexi($company_id);
        $this->data['employee_fixed']           = $this->time_flexi_schedule_model->get_employee_fixed($company_id);
        $this->data['employee_section']         = $this->time_flexi_schedule_model->get_employee_section($company_id);
        $this->data['employee_admin']           = $this->time_flexi_schedule_model->get_employee_admin($company_id);
        $this->data['company_name']             = $this->time_flexi_schedule_model->get_company_name($company_id);
        $this->data['employee_available']       = $this->time_flexi_schedule_model->get_available_employee($company_id);

        $this->load->view('app/time/flexi_schedule/view_all_employee_search',$this->data);
    }

    public function inactivate_employee(){
        $employee_id            = $this->uri->segment("4");
        $group_id            = $this->uri->segment("5");

        $this->time_flexi_schedule_model->inactive_employee($employee_id);
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Flexi Schedule','logfile_time_flexi_schedule','Deactivate member: '.$employee_id.' to group id: '.$group_id.'','DEACTIVATE',$employee_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee ".$employee_id." Successfully Deactivated.</div>");

        $this->session->set_flashdata('onload',"view_group_employee(".$group_id.")");
        redirect('app/time_flexi_schedule');
    }

    public function activate_employee(){
        $employee_id            = $this->uri->segment("4");
        $group_id            = $this->uri->segment("5");

        $this->time_flexi_schedule_model->active_employee($employee_id);
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Flexi Schedule','logfile_time_flexi_schedule','Activate member: '.$employee_id.' to group id: '.$group_id.'','ACTIVATE',$employee_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee ".$employee_id." Successfully Activated.</div>");

        $this->session->set_flashdata('onload',"view_group_employee(".$group_id.")");
        redirect('app/time_flexi_schedule');
    }

 public function add_employee($company_id,$group_id){

        $group_id                               = $group_id;
        $company_id                             = $company_id;
        $this->data['group_info']               = $this->time_flexi_schedule_model->get_group_info($group_id);
        $this->data['group_employee']           = $this->time_flexi_schedule_model->get_group_employee($group_id);
        $this->data['group_name']               = $this->time_flexi_schedule_model->get_group_name($group_id);

        $this->data['company_locations']        = $this->time_flexi_schedule_model->get_company_location($company_id);
        $this->data['company_classifications']  = $this->time_flexi_schedule_model->get_company_classification($company_id);
        $this->data['company_isDiv']            = $this->time_flexi_schedule_model->get_company_isDivision($company_id);
        $this->data['company_division']         = $this->time_flexi_schedule_model->get_company_division($company_id);
        $this->data['company_department']       = $this->time_flexi_schedule_model->get_company_department($company_id);
       // $this->data['available_employee']       = $this->time_flexi_schedule_model->get_available_employee($company, $division, $department, $section, $subsection);

        
       $this->load->view('app/time/flexi_schedule/add_employee',$this->data);

    }

     public function emp_table_result($group_id,$company_id,$division_id,$department_id,$section_id,$subsection_id,$location,$classification,$employment,$taxcode,$pay_type,$civil_status,$gender_sex){
          $group_id                               = $group_id;
         $company_id                              = $company_id;                  
         $division_id                             = $division_id;
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

        $this->data['group_info']               = $this->time_flexi_schedule_model->get_group_info($group_id);
        $this->data['group_employee']           = $this->time_flexi_schedule_model->get_group_employee($group_id);
        $this->data['group_name']               = $this->time_flexi_schedule_model->get_group_name($group_id);

        

        $this->data['company_isDiv'] = $this->time_flexi_schedule_model->get_company_isDivision($company_id);
        $this->data['company_division'] = $this->time_flexi_schedule_model->get_company_division($company_id);
        $this->data['company_department'] = $this->time_flexi_schedule_model->get_company_department($company_id);
        $this->data['available_employee']       = $this->time_flexi_schedule_model->get_available_employee_new($company_id,$division_id,$department_id,$section_id,$subsection_id,$location,$classification,$employment,$taxcode,$pay_type,$civil_status,$gender_sex);

        
        $this->load->view('app/time/flexi_schedule/employee_table_result',$this->data);

    }

    public function emp_table_result_wo_div($group_id,$company_id,$department_id,$section_id,$subsection_id,$location,$classification,$employment,$taxcode,$pay_type,$civil_status,$gender_sex){

                           
         $group_id                                = $group_id;
         $company_id                              = $company_id;                   
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

        $this->data['group_info']               = $this->time_flexi_schedule_model->get_group_info($group_id);
        $this->data['group_employee']           = $this->time_flexi_schedule_model->get_group_employee($group_id);
        $this->data['group_name']               = $this->time_flexi_schedule_model->get_group_name($group_id);

        

        $this->data['company_isDiv'] = $this->time_flexi_schedule_model->get_company_isDivision($company_id);
        $this->data['company_division'] = $this->time_flexi_schedule_model->get_company_division($company_id);
        $this->data['company_department'] = $this->time_flexi_schedule_model->get_company_department($company_id);
        $this->data['available_employee']       = $this->time_flexi_schedule_model->get_available_employee_new_wo_div($company_id,$department_id,$section_id,$subsection_id,$location,$classification,$employment,$taxcode,$pay_type,$civil_status,$gender_sex);

        
        $this->load->view('app/time/flexi_schedule/employee_table_result',$this->data);

    }


   /* public function add_employee(){

        $company_id                             = $this->uri->segment("4");
        $group_id                               = $this->uri->segment("5");
        
        $this->data['group_name']               = $this->time_flexi_schedule_model->get_group_name($group_id);
        $this->data['group_employee']           = $this->time_flexi_schedule_model->get_group_employee($group_id);
        $this->data['available_employee']       = $this->time_flexi_schedule_model->get_available_employee($company_id);

        $this->load->view('app/time/flexi_schedule/add_employee',$this->data);

    }*/
}