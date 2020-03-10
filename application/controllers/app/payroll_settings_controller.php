<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class payroll_settings_controller extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_settings_model");
		$this->load->model("app/employee_model");
		$this->load->model("app/payroll_yearly_annual_tax_exemption_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	//index
	public function index(){	
		$this->payroll_settings_home();	
	}
	//home/company list/all employees applied in loans
	public function payroll_settings_home()
	{
	
		$this->load->view('app/payroll/payroll_settings/home',$this->data);
	}
	public function payroll_settings_list($company_id)
	{
		$this->data['notyet_added_policy'] = $this->payroll_settings_model->notyet_added_policy($company_id);
		$this->data['policy_list'] = $this->payroll_settings_model->policy_list($company_id);
		$this->load->view('app/payroll/payroll_settings/company_policy_list',$this->data);

	}
	//payroll topic
	public function payroll_topic($policy_company_id,$company_id,$payroll_main_id)
	{ 
		$this->data['policy_company_id']=$policy_company_id;
		$this->data['payroll_main_id']=$payroll_main_id;
		$this->data['policy_id']='';
		$this->data['val_flash']='';
		$this->data['setting_id']='';
		$this->data['form_type'] = $this->payroll_settings_model->form_type($policy_company_id);
		$title = $this->payroll_settings_model->policy_one($payroll_main_id);
		foreach ($title as $t) {
			$this->data['title'] = $t->title;
		}
		$this->data['policy_added_data'] = $this->payroll_settings_model->policy_added_data($policy_company_id,$company_id);
		$this->data['classification'] = $this->payroll_settings_model->company_classification($company_id);
		$this->data['employment'] = $this->payroll_settings_model->company_employment();
		$this->data['pay_type'] = $this->general_model->paytypeList();
		$this->data['payroll_setting_id'] = $this->payroll_settings_model->get_setting_id($policy_company_id);
		$this->load->view('app/payroll/payroll_settings/add_value',$this->data);
	}

	//save new data
	public function save_new_data($company_id,$payroll_main_id,$policy_id,$data,$policy_company_id)
	{	
		$this->data['policy_company_id']=$policy_company_id;
		$this->data['policy_id']=$policy_id;

		$this->data['payroll_main_id']=$payroll_main_id;
		$title = $this->payroll_settings_model->policy_one($payroll_main_id);
		foreach ($title as $t) {
			$this->data['title'] = $t->title;
		}
		$this->data['insert'] = $this->payroll_settings_model->insert_new_data($policy_id,$policy_company_id,$data);
		$this->data['form_type'] = $this->payroll_settings_model->form_type($policy_company_id);
		$this->data['policy_added_data'] = $this->payroll_settings_model->policy_added_data($policy_company_id,$company_id);
		if($this->data['insert']=='inserted')
		{	
			$this->data['val_flash']=$policy_id;
			$this->session->set_flashdata('inserted',"Inserted");
		}
		else{ $this->data['val_flash']=""; }
		$this->load->view('app/payroll/payroll_settings/add_value',$this->data);
	}

	public function update_form($company_id,$payroll_main_id,$policy_id,$policy_company_id)
	{
		$this->data['policy_company_id']=$policy_company_id;
		$title = $this->payroll_settings_model->policy_one($payroll_main_id);
		foreach ($title as $t) {
			$this->data['title'] = $t->title;
		}

		$this->data['payroll_main_id']=$payroll_main_id;
		$this->data['form_type'] = $this->payroll_settings_model->form_type($policy_company_id);
		$this->data['policy_added_data'] = $this->payroll_settings_model->policy_added_data($policy_company_id,$company_id);
		$this->data['classification'] = $this->payroll_settings_model->company_classification($company_id);
		$this->data['employment'] = $this->payroll_settings_model->company_employment();
		$this->load->view('app/payroll/payroll_settings/update_form',$this->data);
	}
  
	public function save_update_data($company_id,$payroll_main_id,$policy_id,$data,$policy_company_id,$payroll_setting_id)
	{
		$this->data['policy_company_id']=$policy_company_id;
		$this->data['policy_id']=$policy_id;
		$title = $this->payroll_settings_model->policy_one($payroll_main_id);
		foreach ($title as $t) {
			$this->data['title'] = $t->title;
		}
		$this->data['payroll_main_id']=$payroll_main_id;
		$this->data['update'] = $this->payroll_settings_model->update_data($policy_id,$payroll_setting_id,$data);
		if($this->data['update'] =='updated')
		{	
			$this->session->set_flashdata('updated',"Updated");
			$this->data['val_flash']=$policy_id;
		} else{ $this->data['val_flash']=""; }
		$this->data['form_type'] = $this->payroll_settings_model->form_type($policy_company_id);
		$this->data['policy_added_data'] = $this->payroll_settings_model->policy_added_data($policy_company_id,$company_id);
		$this->load->view('app/payroll/payroll_settings/add_value',$this->data);
	}

	//add new policy
	function add_new_policy($company_id,$add_policy_id)
	{
		$this->data['add_new_policy'] = $this->payroll_settings_model->add_new_policy($company_id,$add_policy_id);
		$this->data['notyet_added_policy'] = $this->payroll_settings_model->notyet_added_policy($company_id);
		$this->data['policy_list'] = $this->payroll_settings_model->policy_list($company_id);
		$this->load->view('app/payroll/payroll_settings/company_policy_list',$this->data);
	}

	//saving for policy with employment and classification
	function save_employment_classification($company_id,$payroll_main_id,$policy_id,$policy_company_id,$converted1,$loop,$payroll_setting_id,$action)
	{ 
		$this->data['policy_company_id']=$policy_company_id;
		$this->data['policy_id']=$policy_id;
		$title = $this->payroll_settings_model->policy_one($payroll_main_id);
		foreach ($title as $t) {
			$this->data['title'] = $t->title;
		}
		$this->data['payroll_main_id']=$payroll_main_id;
		$this->data['insert'] = $this->payroll_settings_model->insert_employment_classification($company_id,$policy_id,$policy_company_id,$converted1,$loop,$payroll_setting_id,$action);
		if($action =='update')
		{	
			$this->session->set_flashdata('updated',"Updated");
			$this->data['val_flash']=$policy_id;
		} 
		elseif($action =='add')
		{	
			$this->session->set_flashdata('inserted',"Inserted");
			$this->data['val_flash']=$policy_id;
		}
		else{ $this->data['val_flash']=""; }
		$this->data['form_type'] = $this->payroll_settings_model->form_type($policy_company_id);
		$this->data['policy_added_data'] = $this->payroll_settings_model->policy_added_data($policy_company_id,$company_id);
		$this->data['classification'] = $this->payroll_settings_model->company_classification($company_id);
		$this->data['employment'] = $this->payroll_settings_model->company_employment();
		$this->load->view('app/payroll/payroll_settings/add_value',$this->data);
	}

	//get group by paytype
	public function paytype_result($company_id,$pay_type)
	{	
			
			$group_result = $this->payroll_settings_model->payroll_group_result($company_id,$pay_type);
			
			if($group_result === 'no_data')
				{ echo "<option value='no_value'>No Group Name Under Pay type id".$pay_type."</option>"; }

			else{
				echo "<option value=''  selected>Select Group</option>"; 
				foreach ($group_result as $row) {
					echo "<option value='".$row->payroll_period_group_id."'>".$row->group_name."</option>";
				}
			 }
	}

	//group result
	public function group_result($company_id,$group,$pay_type)
	{
		$payroll_period_result = $this->payroll_settings_model->payroll_period_result($company_id,$group,$pay_type);

		if($payroll_period_result === 'no_data')
				{ echo "<option value='no_value'>No Payroll Period</option>
						<option value='not_included'>Not included</option>"; }

			else{
				echo "<option value='no_value'  selected>Select Payroll Period</option> 
						<option value='not_included'>Not included</option>"; 

				foreach ($payroll_period_result as $row) {
					$payroll_period_from = $row->month_from."-".$row->day_from."-".$row->year_from;
					$payroll_period_to = $row->month_to."-".$row->day_to."-".$row->year_to;
					$date_payroll = $payroll_period_from." to ".$payroll_period_to;

					echo "<option value='".$row->id."'>".$date_payroll."</option>";
				}
			 }
	}

	//save setting with payroll period
	public function save_with_payroll_period($company_id,$payroll_main_id,$policy_id,$policy_company_id,$value1,$value2,$value3,$value4,$value5)
	{
		$setting_payroll_insert = $this->payroll_settings_model->add_setting_with_payroll_period($policy_id,$policy_company_id,$value1,$value2,$value3,$value4,$value5);
		$this->data['policy_company_id']=$policy_company_id;
		$this->data['policy_id']=$policy_id;
		$this->data['form_type'] = $this->payroll_settings_model->form_type($policy_company_id);
		$this->data['policy_added_data'] = $this->payroll_settings_model->policy_added_data($policy_company_id,$company_id);
		$this->data['classification'] = $this->payroll_settings_model->company_classification($company_id);
		$this->data['employment'] = $this->payroll_settings_model->company_employment();
		$this->data['pay_type'] = $this->general_model->paytypeList();
		$this->data['payroll_setting_id'] = $this->payroll_settings_model->get_setting_id($policy_company_id);
		$title = $this->payroll_settings_model->policy_one($payroll_main_id);
		foreach ($title as $t) {
			$this->data['title'] = $t->title;
		}
		$this->data['payroll_main_id']=$payroll_main_id;
		if($setting_payroll_insert=='inserted')
		{	
			$this->session->set_flashdata('setting4_inserted',"inserted");
			$this->data['val_flash']=$policy_id;
		} 
		elseif($setting_payroll_insert=='exist')
		{	
			$this->session->set_flashdata('setting4_exist',"exist");
			$this->data['val_flash']=$policy_id;
		}
		else{ $this->data['val_flash']=""; }
		$this->load->view('app/payroll/payroll_settings/add_value',$this->data);

		
	}
	public function delete_setting_payroll_period($payroll_setting_id,$pay_type,$group,$company_id,$payroll_main_id,$policy_id,$policy_company_id)
	{
		$this->data['delete_setting_payroll_period'] = $this->payroll_settings_model->delete_setting4($payroll_setting_id,$pay_type,$group);
		$this->data['policy_company_id']=$policy_company_id;
		$this->data['policy_id']=$policy_id;
		$this->data['setting_id']=$payroll_setting_id;
		$title = $this->payroll_settings_model->policy_one($payroll_main_id);
		foreach ($title as $t) {
			$this->data['title'] = $t->title;
		}
		$this->data['payroll_main_id']=$payroll_main_id;
		$this->data['form_type'] = $this->payroll_settings_model->form_type($policy_company_id);
		$this->data['policy_added_data'] = $this->payroll_settings_model->policy_added_data($policy_company_id,$company_id);
		$this->data['classification'] = $this->payroll_settings_model->company_classification($company_id);
		$this->data['employment'] = $this->payroll_settings_model->company_employment();
		$this->data['pay_type'] = $this->general_model->paytypeList();
		$this->data['payroll_setting_id'] = $this->payroll_settings_model->get_setting_id($policy_company_id);
		if($this->data['delete_setting_payroll_period']=='deleted')
		{	
			$this->session->set_flashdata('setting4_deleted',"deleted");
			$this->data['val_flash']=$policy_id;
		} 
		else{ $this->data['val_flash']=""; }
		$this->load->view('app/payroll/payroll_settings/add_value',$this->data);
	}
	public function editform_setting_payroll_period($payroll_setting4_id,$pay_type,$group,$company_id,$payroll_main_id,$policy_id,$policy_company_id)
	{ 
		$this->data['payroll_period_result'] = $this->payroll_settings_model->payroll_period_result($company_id,$group,$pay_type);
		$this->data['payroll_details'] = $this->payroll_settings_model->update_payroll_details($payroll_setting4_id,$pay_type,$group);
		$this->data['payroll_setting4_id']= $payroll_setting4_id;
		$this->data['payroll_main_id']=$payroll_main_id;
		foreach ($this->data['payroll_details'] as $row) { 
			$this->data['payroll_period_date']=$row->payroll_period_id;
			$this->data['view_payroll']=$row->allow_view_payroll;
			$this->data['payroll_option']=$row->payroll_period_option;
			}
		$this->load->view('app/payroll/payroll_settings/edit_payroll_period_form',$this->data);
	}

	public function editsave_setting_payroll_period($payroll_setting4_id,$payroll,$allow,$option,$company_id,$payroll_main_id,$policy_id,$policy_company_id)
	{
		$updatesetting_payroll = $this->payroll_settings_model->save_updatesetting_payroll($payroll_setting4_id,$policy_id,$policy_company_id,$payroll,$allow,$option);
		if($updatesetting_payroll=='updated')
		{	
			$this->session->set_flashdata('setting4_updated',"updated");
			$this->data['val_flash']=$policy_id;
		}
		elseif($updatesetting_payroll=='no_changes')
		{
			$this->session->set_flashdata('setting4_nochanges',"no_changes");
			$this->data['val_flash']=$policy_id;
		}
		else{ $this->data['val_flash']=""; }
		$this->data['policy_id']=$policy_id;
		$this->data['setting_id']=$payroll_setting4_id;
		$this->data['policy_company_id']=$policy_company_id;
		$title = $this->payroll_settings_model->policy_one($payroll_main_id);
		foreach ($title as $t) {
			$this->data['title'] = $t->title;
		}
		$this->data['payroll_main_id']=$payroll_main_id;
		$this->data['form_type'] = $this->payroll_settings_model->form_type($policy_company_id);
		$this->data['policy_added_data'] = $this->payroll_settings_model->policy_added_data($policy_company_id,$company_id);
		$this->data['classification'] = $this->payroll_settings_model->company_classification($company_id);
		$this->data['employment'] = $this->payroll_settings_model->company_employment();
		$this->data['pay_type'] = $this->general_model->paytypeList();
		$this->data['payroll_setting_id'] = $this->payroll_settings_model->get_setting_id($policy_company_id);
		$this->load->view('app/payroll/payroll_settings/add_value',$this->data);
	}

	public function add_system_policy()
	{
		$this->load->view('app/payroll/payroll_settings/add_system_policy');
	}

	public function  input_type($input_type)
	{
		if($input_type=='single_field' || $input_type=='employment_classification')
		{
			echo "<option disabled selected>Select Input Field</option>
				  <option>text</option>
			      <option>dropdown</option>";
		}
		else{
			echo "<option disabled selected>Select Input Field</option>
				  <option value='all'>For Payroll Period Field</option>";
		}
	}
	public function  input_format($input_format)
	{
		if($input_format=='text')
		{	
			echo "<select class='form-control' id='input_format_data'>
					<option disabled selected>Select Input Format</option>
				  <option value='number'>numbers only</option>
			      <option value='alphanumerics'>alphanumerics</option>
			      </select>";
		}
		elseif($input_format=='dropdown'){
			echo "<input type='text' class='form-control' id='input_format_data' placeholder='Input dropdown data. Data must be seperated by dash (For example -> yes-no)'>";
		}
		else{ echo "<input type='text' class='form-control' id='input_format_data' value='all' disabled>"; }
	}

	public function save_system_policy($title,$field,$input_type,$input_format_data)
	{ 
		$this->data['insert_system_policy'] = $this->payroll_settings_model->insert_system_policy($title,$field,$input_type,$input_format_data);
		$this->data['policy_list'] = $this->payroll_settings_model->system_policy_list();
		$this->load->view('app/payroll/payroll_settings/policy_list',$this->data);
	}
	public function system_policy_list()
	{
		$this->data['policy_list'] = $this->payroll_settings_model->system_policy_list();
		$this->load->view('app/payroll/payroll_settings/policy_list',$this->data);
	}
	public function delete_policy($payroll_main_id)
	{
		$delete_policy = $this->payroll_settings_model->delete_policy($payroll_main_id);
		$this->data['policy_list'] = $this->payroll_settings_model->system_policy_list();
		$this->load->view('app/payroll/payroll_settings/policy_list',$this->data);
	}
	public function edit_policy($payroll_main_id)
	{
		$this->data['policy_one'] = $this->payroll_settings_model->policy_one($payroll_main_id);
		$this->data['policy_list'] = $this->payroll_settings_model->system_policy_list();
		$this->load->view('app/payroll/payroll_settings/edit_policy',$this->data);
	}

	public function saveupdate_system_policy($payroll_main_id,$field,$input_type,$input_format_data,$title)
	{ echo $payroll_main_id."-".$field."-".$input_type."-".$input_format_data."-".$title;
		// $this->data['update_system_policy'] = $this->payroll_settings_model->update_system_policy($payroll_main_id,$field,$input_type,$input_format_data,$title);
		// $this->data['policy_list'] = $this->payroll_settings_model->system_policy_list();
		// $this->load->view('app/payroll/payroll_settings/policy_list',$this->data);
	}	
}
