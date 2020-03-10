    <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Plot_schedules extends General{


    public function __construct(){
        parent::__construct();
        $this->load->dbforge();
        $this->load->model('app/plot_schedules_model');
        $this->load->model('app/transaction_employees_model');
        $this->load->model('employee_portal/section_management_model');
        $this->load->model('employee_portal/employee_transactions_policy_model');
        $this->load->model("general_model");
        $this->load->model('app/employee_model');
        $this->load->model("employee_portal/employee_transactions_model");
        
        if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
        General::variable();    
        

    }
    
    public function index(){    
         $this->data['time_lock_pp']=$this->session->userdata('time_lock_pp');
         $this->data['time_manage_schedule']=$this->session->userdata('time_manage_schedule');
         $this->data['time_view_sec_mng_plotted']=$this->session->userdata('time_view_sec_mng_plotted');

        $this->data['system_defined_icons'] = $this->general_model->system_defined_icons();       
        $this->load->view('app/time/plot_schedules/index',$this->data);     
    }   

    //start lock plotting
    public function lock_plotting()
    {
        $this->load->view('app/time/plot_schedules/lock_plotting',$this->data); 
    }
    public function get_payroll_period($company,$group)
    {
        $this->data['msg']="";
        $this->data['company_payroll_period'] =  $this->plot_schedules_model->get_payroll_period($company,$group);
        $this->load->view('app/time/plot_schedules/lock_payrollperiod',$this->data);    
    }
    
    public function get_group_list($company)
    {
        $group=  $this->plot_schedules_model->get_group_list($company);
        if(empty($group)) { echo "<option disabled selected value='none'>No group found.</option>"; }
        else{ echo "<option value='All'>All</option>";
        foreach($group as $grp)
            {
                echo "<option value='".$grp->payroll_period_group_id."'>".$grp->group_name."</option>";
            }
        }
    }

    public function IsLock($val,$id,$company,$group)
    { 
        $employee_id = $this->session->userdata('employee_id');
        if($val=='0'){ $d= 'Unlock'; } else{ $d='Lock'; }
        $this->data['msg']="ID - ".$id." for Company - ".$company." is Successfully ".$d." ";
        $lock =  $this->plot_schedules_model->IsLock($val,$id);
        $this->data['company_payroll_period'] =  $this->plot_schedules_model->get_payroll_period($company,$group);
        $this->load->view('app/time/plot_schedules/lock_payrollperiod',$this->data);
        $eventd = $d." Payroll Period ID - ".$id." (Company id - ". $company.")";
         General::logfile_time_ws($employee_id,'Lock plotting of schedules by payroll period',$d." Payroll Period", $eventd , $val);
    }

    //end lock plotting
    //start create admin
    public function group_by_admin()
    {
        $this->data['groups'] = $this->plot_schedules_model->groups_created_by_admin('All');
        $this->load->view('app/time/plot_schedules/group_by_admin',$this->data);
    }

    public function save_admin_group($company,$grp_name,$grp_desc,$idd)
    {
        $g_name_old = $this->plot_schedules_model->grp_details($idd);
        $employee_id = $this->session->userdata('employee_id');
        $g_name = $this->plot_schedules_model->convert_char($grp_name);
        $action = $this->plot_schedules_model->save_admin_group($company,$grp_name,$grp_desc,$idd);
        $this->data['groups'] = $this->plot_schedules_model->groups_created_by_admin('All');
        $this->load->view('app/time/plot_schedules/list_group_by_admin',$this->data);
        if($action=='inserted')
        {
            General::logfile_time_ws($employee_id,'Group Created by Admin','Create New Group Created by Admin ID- '.$employee_id,'Insert the Group Name for Company ID- '.$company.' /  ('.$g_name.') created by Admin ID - '.$employee_id,'Group Name ->'.$g_name);
        }   
        elseif($action=='updated')
        {
            General::logfile_time_ws($employee_id,'Group Created by Admin','Update Group created by Admin ID - '.$employee_id,'Update the Group Name for Company ID- '.$company.' /  ('.$g_name.') created by Admin ID - '.$employee_id,'Old Group Name ('.$g_name_old->group_name.')'." to ".'New Group Name'."(".$g_name.")");
        } else{}
    }
    
    public function view_group_filter($company)
    {
        $this->data['groups'] = $this->plot_schedules_model->groups_created_by_admin($company);
        $this->load->view('app/time/plot_schedules/list_group_by_admin',$this->data);
    }
    public function edit_grp_admin($id)
    { 
        $this->data['grp_details'] = $this->plot_schedules_model->grp_details($id);
        $this->load->view('app/time/plot_schedules/edit_group_details',$this->data);
    }
    public function edd_group($option,$id)
    {
        $g_name = $this->plot_schedules_model->grp_details($id);
        $employee_id = $this->session->userdata('employee_id');
        $action = $this->plot_schedules_model->edd_group($option,$id);
        $this->data['groups'] = $this->plot_schedules_model->groups_created_by_admin('All');
        $this->load->view('app/time/plot_schedules/group_by_admin',$this->data);
        if($action=='deleted'){
            General::logfile_time_ws($employee_id,'Group Created by Admin','Delete Group Id- '.$id,'Delete Group ID - '.$id.' ( '.$g_name->group_name.' ) created by Admin ID - '.$employee_id,'Delete Group Name ->'.$g_name->group_name."(".$id.")");
        }
        else if($action=='enabled'){
            General::logfile_time_ws($employee_id,'Group Created by Admin','Enable Group Id- '.$id,'Enable Group ID - '.$id.' ( '.$g_name->group_name.' ) created by Admin ID - '.$employee_id,'Enable Group Name ->'.$g_name->group_name."(".$id.")");
        }
        else if($action=='disabled'){
            General::logfile_time_ws($employee_id,'Group Created by Admin','Disable Group Id- '.$id,'Disable Group ID - '.$id.' ( '.$g_name->group_name.' ) created by Admin ID - '.$employee_id,'Disable Group Name ->'.$g_name->group_name."(".$id.")");
        }
        else{}
        
    }

    //start of individual plotting

    public function individual_plotting()
    {
        $this->load->view('app/time/plot_schedules/individual_plotting',$this->data);
    }

    public function get_ip_location($company)
    {
        $location = $this->plot_schedules_model->get_location_by_company($company);
        if(empty($location)){ echo "<option value='none'>No location found. Please add to continue.</option>";}
        else{ 
                echo "
                        <option value='none'>Select</option>
                        <option value='All'>All</option>
                    ";
                foreach ($location as $loc) {
                    echo "<option value='".$loc->location_id."'>".$loc->location_name."</option>";
                }
            }

    }
    public function ip_employee_list($company,$location,$search)
    {
        $this->data['query'] = $this->plot_schedules_model->ip_employeelist_model($search,$company,$location);
        $this->load->view('app/time/plot_schedules/ip_search_employee_list',$this->data);
    }
    public function ip_plot_selected_employee($company,$location,$employee_id)
    {
        $this->data['company'] = $company;
        $this->data['location'] = $company;
        $this->data['employee_list'] = $this->plot_schedules_model->get_company_location_employees($company,$location);
        $this->data['color_code'] = $this->plot_schedules_model->get_color_code();
        $this->data['check_if_fixed_schedule'] = $this->plot_schedules_model->check_if_fixed_schedule($employee_id);
        $this->data['company']=$company;
        $this->data['emp_info'] = $this->plot_schedules_model->employee_details($company,$employee_id);
        $this->load->view('app/time/plot_schedules/ip_plot_selected_employee',$this->data);
    }

    public function eventClick()
    {
        $date = $this->input->post('date');
        $employee_id = $this->input->post('employee_id');
        $res = $this->plot_schedules_model->remove_eventClick($date,$employee_id);  
        if($res=='deleted')
        {
            General::logfile_time_ws($this->session->userdata('employee_id'),'Indivual Plotting of Employee ID- '.$employee_id,'Remove working schedule dated('.$date.')','Remove the working schedule dated ('.$date.') of Employee ID - '.$employee_id, 'remove '.$date);
        }
        echo json_encode($res);
    }
    public function dayClick()
    {
        $date = $this->input->post('date');
        $employee_id = $this->input->post('employee_id');

        $data = $this->plot_schedules_model->add_eventClick($date,$employee_id);
                General::logfile_time_ws($this->session->userdata('employee_id'),'Indivual Plotting of Employee ID- '.$employee_id,'Add working schedule dated('.$date.')','Add the working schedule dated ('.$date.') of Employee ID - '.$employee_id, 'Add '.$this->input->post('value'));

        echo json_encode($data);
    }
    public function check_with_pp()
    {
        $employee_id = $this->input->post('employee');
        $company_id = $this->input->post('company');
        $data = $this->plot_schedules_model->check_if_with_pp($company_id,$employee_id);
        echo json_encode($data);
    }

    //end of individual plotting

    //start of viewing of plotted schedules of section managers

    public function view_section_mngr_group()
        { 
            $this->load->view('app/time/plot_schedules/sm_section_mngr_group',$this->data);
        }
    public function sm_section_managers($company)
    {
        $this->data['sec_mngrs'] = $this->plot_schedules_model->get_section_managers($company);
        $this->load->view('app/time/plot_schedules/sm_section_mngr_list',$this->data);
    }
    public function sm_group_members($group)
    {
        $this->data['id']=$group;
        $this->data['group'] = $this->plot_schedules_model->group_details($group,'by_row');
        $this->data['g_members'] = $this->plot_schedules_model->get_group_members($group,'members');
        $this->load->view('app/time/plot_schedules/sm_group_members_modal',$this->data);
    }
    public function view_group_list($manager,$company)
    {
        $this->data['sm_grp']= $this->plot_schedules_model->get_section_managers_group($manager);
        $this->data['manager_details'] = $this->plot_schedules_model->manager_details($manager,$company);
        $this->load->view('app/time/plot_schedules/sm_group_list',$this->data);
    }
    public function sm_view_group_schedule($group)
    {
        $this->data['color_code'] = $this->plot_schedules_model->get_color_code();
        $this->data['group'] = $this->plot_schedules_model->group_details($group,'by_row');
        $this->data['g_members'] = $this->plot_schedules_model->get_group_members($group,'members');
        $this->load->view('app/time/plot_schedules/sm_view_group_schedule',$this->data);
    }
    public function get_schedule($id,$option)
    {
        
        $start = $this->input->get('start');
        $end = $this->input->get('end');

        $data = $this->plot_schedules_model->get_schedule_for_the_month($id, $start, $end,$option);
        echo json_encode($data);
    }
    public function get_schedule_updated($id,$option)
    {
        $start = $this->input->get('start');
        $end = $this->input->get('end');
        if($option=='individual')
        {
            $check_fixed = $this->plot_schedules_model->check_if_fixed_schedule($id);
            if(empty($check_fixed))
            {
                $data = $this->plot_schedules_model->get_schedule_for_the_month_for_updated($id, $start, $end,$option);
            }
            else
            {
                $data = $this->plot_schedules_model->get_schedule_for_the_month_for_fixed_schedule($id, $start, $end,$option);
            }
        }
        else
        {
            $data = $this->plot_schedules_model->get_schedule_for_the_month_for_updated($id, $start, $end,$option);
        }
        
        echo json_encode($data);
    }
    public function get_emp_all_schedule($employee_id,$group)
    {
        $this->data['grp']=$group;
        $this->data['empp']=$this->plot_schedules_model->manager_details($employee_id,$group);
        $this->load->view('app/time/plot_schedules/sm_emp_all_schedule',$this->data);
    }
    //end of viewing of plotted schedules of section managers

    //start of admin enrolling of employees
    public function enrol_employees($group,$company)
    {
        $this->data['group']=$group;
        $this->data['company']=$company;
        $this->data['grp_members'] = $this->plot_schedules_model->admin_grp_members($group);
        $this->data['grp_details'] = $this->plot_schedules_model->enrol_grp_details($group,$company);
        $this->load->view('app/time/plot_schedules/enrol_employee_bygroup',$this->data);
    }

    public function admin_update_members($company,$group,$manager)
    {
        $this->data['group'] = $group;
        $this->data['company'] = $company;
        $this->data['grp_members'] = $this->plot_schedules_model->admin_grp_members($group);
        $pp = $this->plot_schedules_model->pp_member($group);
        if(empty($pp)){ $this->data['ppp']=""; }
        else { $this->data['ppp']=$pp; }
        $string="";
        foreach($this->data['grp_members'] as $emp)
        {
                $dd = $emp->employee_id."-";
                $string .= $dd;
        }
        $this->data['grp_employees'] = $string;
        $this->data['company_employees'] = $this->plot_schedules_model->company_employees($company);
        $this->load->view('app/time/plot_schedules/admin_update_grp_members',$this->data);
    }

    public function admin_update_members_group($company,$group,$employees)
    {
        
        $insert = $this->plot_schedules_model->admin_update_members_group($group,$employees,$company);
        General::logfile_time_ws($this->session->userdata('employee_id'),'Update Group Members','Update Members of Group ID -'.$group, 'Update Members of Group ID -'.$group.' created by admin id'.$this->session->userdata('employee_id'),'New members: '.$employees);
        $this->data['group'] = $group;
        $this->data['company'] = $company;
        $this->data['grp_members'] = $this->plot_schedules_model->admin_grp_members($group);
        $this->data['grp_details'] = $this->plot_schedules_model->enrol_grp_details($group,$company);
        $employee_id = $this->session->userdata('employee_id');
        
        $this->load->view('app/time/plot_schedules/enrol_employee_bygroup',$this->data);
    }
    public function enrol_employee_ac($option,$id,$company,$group)
    {
        $emp_id = $this->plot_schedules_model->enrol_employee_action('view',$id);
        $action = $this->plot_schedules_model->enrol_employee_action($option,$id);
        if($action=='deleted'){
            General::logfile_time_ws($this->session->userdata('employee_id'),'Delete Group Member','Delete Employee ID- '.$emp_id,'Delete Employee ID - '.$emp_id.' for Group ID - '.$group,'Delete employee id -'.$emp_id);
        }
        else if($action=='enabled'){
            General::logfile_time_ws($this->session->userdata('employee_id'),'Enable Group Member','Enable Employee ID- '.$emp_id,'Enable Employee ID - '.$emp_id.' for Group ID - '.$group,'Enable employee_id -'.$emp_id);
        }
        else if($action=='disabled'){
            General::logfile_time_ws($this->session->userdata('employee_id'),'Disable Group Member','Disable Employee ID- '.$emp_id,'Disable Employee ID - '.$emp_id.' for Group ID - '.$group,'Disable employee_id -'.$emp_id);
        }
        else{}
        $this->data['group'] = $group;
        $this->data['company'] = $company;
        $this->data['grp_members'] = $this->plot_schedules_model->admin_grp_members($group);
        $this->data['grp_details'] = $this->plot_schedules_model->enrol_grp_details($group,$company);
        $this->load->view('app/time/plot_schedules/enrol_employee_bygroup',$this->data);
    }
    public function admin_group_plot_sched(){

        $company_id =$this->uri->segment('5'); //company id
        $group_id =$this->uri->segment('4');
        $this->data['company_id']=$company_id;
        $this->data['group_id']=$group_id;
        $this->load->view("app/time/plot_schedules/admin_group_plot_sched",$this->data);    
        
    }
    public function admin_group_plot_sched_2(){

        $this->data['selected_payroll_period']=$this->uri->segment('4');
        $this->data['company_id']=$this->uri->segment('5');
        $this->data['group_id']=$this->uri->segment('6');
        $this->data['check_with_lock'] = $this->plot_schedules_model->check_with_lock($this->uri->segment('6'),$this->uri->segment('4'));
        $this->load->view("app/time/plot_schedules/admin_group_plot_sched_2",$this->data);  
    }

    public function save_admin_group_plot_sched()
    {
        
        $insert = $this->plot_schedules_model->inser_pp_ws();
        $pp = 'Group ID - '.$this->input->post('group_id')." (with payroll period ".$this->input->post('payroll_period_from')." to ".$this->input->post('payroll_period_to').")";
        
        $company = $this->input->post('company_id');
        $group = $this->input->post('group_id');
        $this->data['company_id']=$company;
        $this->data['group_id']=$group;
        $this->load->view("app/time/plot_schedules/admin_group_plot_sched",$this->data);
        General::logfile_time_ws($this->session->userdata('employee_id'),'Plot working schedules by payroll period','Update Working Schedules','Update payroll period working schedules for Group ID - '.$this->input->post('group_id'),$pp);   

    }
    public function view_emp_selected_grp($employees)
    {
        $emp= substr_replace($employees, "", -1);
        $employee = explode('-',$emp);
        $this->data['employees'] = $employee;
        $this->load->view("app/time/plot_schedules/view_emp_selected_grp",$this->data); 
    }
    
    
    //end of admin enrolling of employees

    //manual upload
    public function manual_upload()
    {
        $this->load->view("app/time/plot_schedules/manual_upload",$this->data); 
    }
    public function download_ws()
    {
        $this->load->helper('download');            
        $path    =   file_get_contents(base_url()."public/downloadable_templates/download_working_schedules.xls");
        $name    =   "working_schedules.xls";
        force_download($name, $path);
        $value = $name;
        General::logfile('Download Working Schedules Template','DOWNLOAD',$value); 
    }



    
    //end of manual upload





    //added by mi (viewing ng by group na working schedule)
    public function get_schedule_by_group($id,$option)
    {
        
        $start = $this->input->get('start');
        $end = $this->input->get('end');

        $data = $this->plot_schedules_model->get_schedule_for_the_month_by_group($id, $start, $end,$option);
        echo json_encode($data);
    }
    
    public function view_emp_fixed_schedules($employee_id,$company_id)
    {
        $this->data['check_if_fixed_schedule'] = $this->plot_schedules_model->check_if_fixed_schedule($employee_id);
        $this->data['emp_info'] = $this->plot_schedules_model->employee_details($company_id,$employee_id);
        $this->load->view("app/time/plot_schedules/view_emp_fixed_schedules",$this->data);  
    }
    public function view_color_code($option)
    {
        $this->data['option']=$option;
        $this->data['color_code'] = $this->plot_schedules_model->get_color_code();
        $this->load->view("app/time/plot_schedules/view_color_code",$this->data);   
    }


    
}//end controller



