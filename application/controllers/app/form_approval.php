<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Form_approval extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/form_approval_model");
		$this->load->model("app/notification_approval_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index(){	
		$this->start_here();
	}

	public function start_here(){
		
		$this->data['file_t'] = $this->form_approval_model->get_t_forms(); //transactions
		$this->load->view('app/form_approval/index',$this->data);
	}	

	public function add_no_approver()
	{
		$this->data['action_']='';
		$this->data['flash_id']='';
		$this->data['setting_no_approver'] = $this->form_approval_model->setting_no_approver();
		$this->load->view('app/form_approval/add_no_approver',$this->data);
	}

	public function save_add_no_approver($setting_company,$setting_approver)
	{
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Add Max Form Approvers '.$setting_company.': value: '.$setting_approver.' ,','INSERT',$setting_approver);

		$insert = $this->form_approval_model->save_add_no_approver($setting_company,$setting_approver);
		$this->data['flash_id']=$setting_company;
		$this->data['action_']='add';
		if($insert=='inserted')
		{	
			$this->session->set_flashdata('success_inserted',"Success");
		}
		else
		{
			$this->session->set_flashdata('insert_error',"Error");
		}
		$this->data['setting_no_approver'] = $this->form_approval_model->setting_no_approver();
		$this->load->view('app/form_approval/add_no_approver',$this->data);
	}

	public function delete_setting_no_approver($id)
	{
		$delete = $this->form_approval_model->delete_setting_no_approver($id);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Delete Max Form Approvers '.$id,'DELETE',$id);


		$this->data['flash_id']=$id;
		$this->data['action_']='delete';
		if($delete=='deleted')
		{	
			$this->session->set_flashdata('success_deleted',"Success");
		}
		else
		{
			$this->session->set_flashdata('delete_error',"Error");
		}
		$this->data['setting_no_approver'] = $this->form_approval_model->setting_no_approver();
		$this->load->view('app/form_approval/add_no_approver',$this->data);
	}

	public function edit_setting_no_approver($id,$company)
	{
		$this->data['company_id']= $company;
		 $this->data['no_approver'] = $this->form_approval_model->no_approver($id);
		$this->load->view('app/form_approval/edit_setting_no_approver_form',$this->data);
	}

	public function saveupdate_no_approver_setting($company_id,$setting_approver)
	{
		$update = $this->form_approval_model->saveupdate_no_approver_setting($company_id,$setting_approver);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Update Max Form Approvers '.$company_id.': value: '.$setting_approver.' ,','UPDATE',$setting_approver);


		$this->data['flash_id']=$company_id;
		$this->data['action_']='update';
		if($update=='updated')
		{	
			$this->session->set_flashdata('success_updated',"Success");
		}
		else
		{
			$this->session->set_flashdata('update_error',"Error");
		}
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();
		$this->data['setting_no_approver'] = $this->form_approval_model->setting_no_approver();
		$this->load->view('app/form_approval/add_no_approver',$this->data);
	}

	public function add_approver_choices()
	{
		$this->data['flash_id']='';
		$this->data['action_']='';
		$this->data['approver_list'] = $this->form_approval_model->approver_list();
		$this->load->view('app/form_approval/approver_choices',$this->data);
	}

	public function delete_approver($id)
	{
		$delete = $this->form_approval_model->delete_approver($id);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Delete Approver Choices: '.$id,'DELETE',$id);

		$this->data['flash_id']=$id;
		$this->data['action_']='delete';
		if($delete=='deleted')
		{	
			$this->session->set_flashdata('success_deleted',"Success");
		}
		else
		{
			$this->session->set_flashdata('delete_error',"Error");
		}
		 $this->data['approver_list'] = $this->form_approval_model->approver_list();
		$this->load->view('app/form_approval/approver_choices',$this->data);
	}
	public function showSearchEmployeelist($val = NULL){
		$this->data['showEmployeeList'] = $this->form_approval_model->getSearch_EmployeeList($val); //getEmp //getSearch_Employee
		$this->load->view("app/form_approval/showEmployeeList",$this->data);	
	}

	public function add_new_approver_choices($employee_id)
	{
		$insert = $this->form_approval_model->add_new_approver_choices($employee_id);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Add Approver Choices: '.$employee_id,'INSERT',$employee_id);

		$this->data['flash_id']=$employee_id;
		$this->data['action_']='add';
		if($insert=='inserted')
		{	
			$this->session->set_flashdata('success_inserted',"Success");
		}
		else
		{
			$this->session->set_flashdata('insert_error',"Error");
		}
		$this->data['approver_list'] = $this->form_approval_model->approver_list();
		$this->load->view('app/form_approval/approver_choices',$this->data);
	}

	public function manage_transaction($transaction)
	{
		$this->data['action_']="";
		$this->data['flash_id']="";
 		$this->data['transaction_details'] = $this->form_approval_model->transaction_details($transaction);
 		foreach ($this->data['transaction_details'] as $trans) {
 			$this->data['trans_name']=$trans->form_name;
 			$this->data['trans_id']=$trans->id;
 			$this->data['identification'] = $trans->identification;
 			$this->data['approver_details'] = $this->form_approval_model->approver_details($this->data['identification']); 
 		}
 		$this->load->view('app/form_approval/manage_transaction',$this->data);
	}

	public function manage_transaction_add($id)
	{
		
		$this->data['transaction_details'] = $this->form_approval_model->transaction_details($id);
		$this->data['UserDefine'] = $this->form_approval_model->UserDefine($id);
 		foreach ($this->data['transaction_details'] as $trans) {
 			$this->data['trans_name']=$trans->form_name;
 			$this->data['trans_id']=$trans->id;
 			$this->data['identification'] = $trans->identification;
 		}
		$this->load->view('app/form_approval/manage_transaction_add',$this->data);
	}
	public function load_division($id){	
		$with_division = $this->form_approval_model->with_division($id);	
		$divisionList = $this->form_approval_model->load_division($id);
		echo " <option value='0'  selected='selected' disabled=''>Select</option> ";                        
       
       if($with_division==1){  } else{ echo " <option value='not_included'>Division is not required</option>"; }
       if(empty($divisionList) AND $with_division==1){
       	echo " <option value='0'>No division added in this company.Please add division first to continue. </option>";
       } else {
       	echo " <option value='All'>All</option> ";  
        foreach($divisionList as $div){
        echo "<option value='".$div->division_id."' >".$div->division_name."</option>";
        } }
	}
		public function load_dept($id,$company){	

			$departmentList = $this->form_approval_model->load_dept($id,$company);
			echo ' <option value="0"  selected="selected" disabled="">-Select Department-</option>'; 
				if(empty($departmentList)) { echo " <option value='0'>No department added in this company.Please add department first to continue. </option>"; } else{ echo "<option value='All'>All</option>"; } 	
			foreach($departmentList as $dpt){
	        echo "<option value='".$dpt->department_id."' >".$dpt->dept_name."</option>";
	        }
		}
	public function load_dept_filter($id,$company){	

		$departmentList = $this->form_approval_model->load_dept_filter($id,$company);
		echo ' <option value="0"  selected="selected" disabled="">-Select Department-</option>'; 
			if(empty($departmentList)) { echo " <option value='0'>No department added in this company.Please add department first to continue. </option>"; } else{ echo "<option value='All'>All</option>"; } 	
		foreach($departmentList as $dpt){
        echo "<option value='".$dpt->department_id."' >".$dpt->dept_name."</option>";
        }
	}
	public function load_section($id,$div,$dept){	
		
		$sectionList = $this->form_approval_model->load_section($id,$div,$dept);
		echo '<option value="0"  selected="selected" disabled="">-Select Section-</option>';
			if(empty($sectionList)) { echo " <option value='0'>No section added in this company.Please add section first to continue. </option>"; } else{ echo "<option value='All'>All</option>"; } 	
        foreach($sectionList as $sec){
        echo "<option value='".$sec->section_id."' >".$sec->section_name."</option>";
        }
	}
	public function load_section_filter($id,$div,$dept){	
		
		$sectionList = $this->form_approval_model->load_section_filter($id,$div,$dept);
		echo '<option value="0"  selected="selected" disabled="">-Select Section-</option>';
			if(empty($sectionList)) { echo " <option value='0'>No section added in this company.Please add section first to continue. </option>"; } else{  } 	
        foreach($sectionList as $sec){
        echo "<option value='".$sec->section_id."' >".$sec->section_name."</option>";
        }
	}

	public function load_subsection($val,$div,$dept,$company)
	{ 
		$with_subsection = $this->form_approval_model->with_subsection($val);	
		$subsectionList = $this->form_approval_model->load_subsections($val);


		echo '<option value="0"  selected="selected" disabled="">-Select Subsection-</option>';                     
       	if($with_subsection==1){ 
       		if(empty($subsectionList)) { echo " <option value='0'>No subsection added in this company.Please add subsection first to continue. </option>"; } 
       		else{ echo "<option value='All'>All</option>";
      		
      		foreach($subsectionList as $sub){
       				 echo "<option value='".$sub->subsection_id."' >".$sub->subsection_name."</option>";
        				}
    		}  } else{ echo "<option value='not_included'>Subsection is not required</option>";}
      
        
	}

	public function load_classification($val)
	{
		$classificationList = $this->form_approval_model->classificationList($val);
		if(empty($classificationList)){ echo " <option value='0'>No Classification added in this company. Please add Classification first to continue.</option> "; }
		else{
		echo '<option value="0"  selected="selected" disabled="">-Select Classification-</option><option value="All">All</option>'; 
		foreach ($classificationList as $classs) {
			echo "<option value='".$classs->classification_id."'>".$classs->classification."</option>";
		} }
	}

	public function loadApprover_Numsetting($val)
	{
		$approver_setting = $this->form_approval_model->approver_setting($val);
		if(empty($approver_setting)){ echo "<option value='0'>No setup for Number of Approver in this company. Please add first to continue.</option>"; }
		else
		{
			echo "<option value='0'></option>";
			 $x = 1; 
          while($x <= $approver_setting) {
            if($x=="1"){
              $ext="st";
            }else if($x=="3"){
              $ext="rd";
            }else if($x=="2"){
              $ext="nd";
            }else{
              $ext="th";
            }
              echo '<option value="'.$x.'" >'.$x.$ext.' Approval</option>';
              $x++;
          } 
		}
	}

	public function addnew_showSearchResult($val = NULL,$company = NULL )
	{
		$this->data['addnew_showSearchResult'] = $this->form_approval_model->addnew_showSearchResult($val,$company); 
		$this->load->view("app/form_approval/approver_showEmployeeList",$this->data);
	}

	public function savenew_approver_trans($transaction,$company,$division,$department,$section,$subsection,$employee_id,$position,$classification,$approval_number,$applyOption,$approvallevel,$identification,$location,$leavetype)
	{
		
		$insert = $this->form_approval_model->savenew_approver_trans($company,$division,$department,$section,$subsection,$employee_id,$position,$approval_number,$applyOption,$approvallevel,$identification,$classification,$location,$leavetype);
		
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Add Approver company|division|department|section|subsection|employee_id|position|approval_number|applyOption|approvallevel|identification|classification|location|leavetype: '.$company.'|'.$division.'|'.$department.'|'.$section.'|'.$subsection.'|'.$employee_id.'|'.$position.'|'.$approval_number.'|'.$applyOption.'|'.$approvallevel.'|'.$identification.'|'.$classification.'|'.$location.'|'.$leavetype,'INSERT',$identification);		

		$this->data['flash_id']=$company;
		$this->data['action_']='add';
		$this->session->set_flashdata('success_inserted',"Success");
		$this->data['transaction_details'] = $this->form_approval_model->transaction_details($transaction);
		$this->data['companyList'] = $this->form_approval_model->companyList(); 
 		foreach ($this->data['transaction_details'] as $trans) {
 			$this->data['trans_name']=$trans->form_name;
 			$this->data['trans_id']=$trans->id;
 			$this->data['identification'] = $trans->identification;
 			$this->data['approver_details'] = $this->form_approval_model->approver_details($this->data['identification']); 
 		}


 		$this->load->view('app/form_approval/manage_transaction',$this->data);
	}
	
	public function loadLocation($val)
	{
		$locationList = $this->form_approval_model->locationList($val);
		if(empty($locationList)){ echo " <option value='0'>No location added in this company. Please add location first to cotinue.</option> "; }
		else{
		echo '<option value="0"  selected="selected" disabled="">-Select Location-</option>'; 
			echo " <option value='All'>All</option> ";  
		foreach ($locationList as $loc) {
			echo "<option value='".$loc->location_id."'>".$loc->location_name."</option>";
		} }
	}

	public function loadLocation_all($val)
	{
		$locationList = $this->form_approval_model->locationList($val);
		if(empty($locationList)){ echo " <option value='0'>No location added in this company. Please add location first to cotinue.</option> "; }
		else{
			echo " <option value='All'>All Locations</option> ";  
		foreach ($locationList as $loc) {
			echo "<option value='".$loc->location_id."'>".$loc->location_name."</option>";
		} }
	}

	public function loadLeavetype($val)
	{
		$leavetypeList = $this->form_approval_model->leavetypeList($val);
		if(empty($leavetypeList)){ echo " <option value='0'>No leave type added in this company. Please add leave type first to cotinue.</option> "; }
		else{
		echo '<option value="0"  selected="selected" disabled="">-Select Leave-</option>';
		echo '<option value="All">All</option>';
		foreach ($leavetypeList as $leave) {
			echo "<option value='".$leave->id."'>".$leave->leave_type."</option>";
		} }
	}

	public function approver_list_all()
	{
		$this->data['action_']="";
		$this->data['flash_id']="";
		$this->data['approver'] = $this->form_approval_model->approver_list_all(); 
		$this->load->view("app/form_approval/approver_list_all",$this->data);
	}
	public function Delete_allapprovers($company)
	{
		$deleteall = $this->form_approval_model->Delete_allapprovers($company);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Clear All Approvers of : '.$company.': company.','DELETE',$company);

		$this->data['approver'] = $this->form_approval_model->approver_list_all(); 
		$this->load->view("app/form_approval/approver_list_all",$this->data);	
	}

	public function transfer_approver($identification)
	{
		$this->data['identification']=$identification;
		$this->load->view("app/form_approval/transfer_approver",$this->data);
	}

	public function transfer_approver_employee($val = NULL,$company = NULL )
	{
		$this->data['addnew_showSearchResult'] = $this->form_approval_model->addnew_showSearchResult($val,$company); 
		$this->load->view("app/form_approval/transfer_approver_employee",$this->data);
	} 
	public function save_transfer_approver($company,$approver,$identification,$transfer_id)
	{
		
		
		$update = $this->form_approval_model->save_transfer_approver($company,$approver,$identification,$transfer_id); 
		
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
		*/

		General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Transfer Approver company|approver|identification|transfer_id: '.$company.'|'.$approver.'|'.$identification.'|'.$transfer_id,'TRANSFER',$identification);

		$this->data['identification']=$identification;
		$this->load->view("app/form_approval/transfer_approver",$this->data);
	}

	public function for_pending_approval($company,$identification)
	{
		$this->data['table_name'] = $this->form_approval_model->get_transfer_table_name($identification);
		$this->data['company'] =$company;
		$this->data['identification']=$identification;
		$this->data['pending_approval'] = $this->form_approval_model->pending_approval($company,$identification); 
		$this->load->view("app/form_approval/pending_approval",$this->data); 
	}

	public function pending_transaction_employee($company,$identification)
	{
		$this->data['company'] =$company;
		$this->data['identification']=$identification;
		$pending_approval= $this->form_approval_model->pending_approval_emp($company,$identification);
		echo "<option id='0'>Select</option>";
		if(empty($pending_approval)){ echo "<option>No pending transaction.</option>";}
		else{
			echo "<option value='All'>All Pending Approval in this transaction</option>";
		foreach ($pending_approval as $pending) {
			$res= $this->form_approval_model->pending_approval_emp_comp($company,$pending->approver_id);
			$names = $this->form_approval_model->name($pending->approver_id);
			if($res > 0){
				echo "<option value='".$pending->approver_id."'>All Pending Approval of ".$pending->approver_id.""."[".$names."]"."</option>";
				} else{}
			}
		}
	
	}
	//filtering
	public function approver_filtering($id,$identification)
	{
		$this->data['UserDefine'] = $this->form_approval_model->UserDefine($id);
		$this->data['identification']=$identification;
		$this->load->view("app/form_approval/approver_filtering",$this->data);
	}

	public function approver_filtering_company($company,$identification)
	{
		$this->data['identification']=$identification;
		$this->data['company']=$company;
		$this->data['with_division']=$this->form_approval_model->with_division($company);
		$this->data['resultss']=$this->form_approval_model->filtering($company,'company_id','department');
		$this->load->view("app/form_approval/filtering_results",$this->data);
	}

	public function approver_filtering_company_delete($company,$id,$identification,$name)
	{
		$delete = $this->form_approval_model->approver_delete_by_department($company,$id,$identification,$name);
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Delete Approver company|id|identification|name: '.$company.'|'.$id.'|'.$identification.'|'.$name,'DELETE',$identification);

		$this->data['identification']=$identification;
		$this->data['company']=$company;
		$this->data['with_division']=$this->form_approval_model->with_division($company);
		$this->data['resultss']=$this->form_approval_model->filtering($company,'company_id','department');
		$this->load->view("app/form_approval/filtering_results",$this->data);
	}

	public function approver_filtering_company_location($company,$identification,$location)
	{
		$this->data['identification']=$identification;
		$this->data['location']=$location;
		$this->data['company']=$company;
		$this->data['with_division']=$this->form_approval_model->with_division($company);
		$this->data['resultss']=$this->form_approval_model->filtering($company,'company_id','department');
		$this->load->view("app/form_approval/filtering_results_location",$this->data);
	}
	public function approver_filtering_companyloc_delete($company,$id,$identification,$name,$location)
	{
		$delete = $this->form_approval_model->approver_delete_by_location($company,$id,$identification,$name,$location);
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Delete Approver company|id|identification|name|location: '.$company.'|'.$id.'|'.$identification.'|'.$name.'|'.$location,'DELETE',$identification);

		$this->data['identification']=$identification;
		$this->data['location']=$location;
		$this->data['company']=$company;
		$this->data['with_division']=$this->form_approval_model->with_division($company);
		$this->data['resultss']=$this->form_approval_model->filtering($company,'company_id','department');
		$this->load->view("app/form_approval/filtering_results_location",$this->data);
	}

	
	public function filtering_results_section($company,$division,$department,$identification,$location,$classification,$section)
	{
		$this->data['identification']=$identification;
		$this->data['location']=$location;
		$this->data['classification']=$classification;
		$this->data['company']=$company;
		$this->data['division']=$division;
		$this->data['department']=$department;
		$this->data['sectionss']=$section;
		$this->data['with_division']=$this->form_approval_model->with_division($company);
		$this->data['resultss']=$this->form_approval_model->filtering_sec($company,$division,$department,$section);
		 $this->load->view("app/form_approval/filtering_results_section",$this->data);
	}
	public function approver_filtering_location_classif($company,$identification,$location,$classification)
	{
		$this->data['identification']=$identification;
		$this->data['location']=$location;
		$this->data['classification']=$classification;
		$this->data['company']=$company;
		$this->data['with_division']=$this->form_approval_model->with_division($company);
		$this->data['resultss']=$this->form_approval_model->filtering($company,'company_id','department');
		$this->load->view("app/form_approval/filtering_results_classification",$this->data);
	}
	public function approver_filtering_companylocclass_delete($company,$id,$identification,$name,$location,$classification)
	{
		$delete = $this->form_approval_model->approver_delete_by_classification($company,$id,$identification,$name,$location,$classification);
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Delete Approver company|id|identification|name|location|classification: '.$company.'|'.$id.'|'.$identification.'|'.$name.'|'.$location.'|'.$classification,'DELETE',$identification);

		$this->data['identification']=$identification;
		$this->data['location']=$location;
		$this->data['classification']=$classification;
		$this->data['company']=$company;
		$this->data['with_division']=$this->form_approval_model->with_division($company);
		$this->data['resultss']=$this->form_approval_model->filtering($company,'company_id','department');
		$this->load->view("app/form_approval/filtering_results_classification",$this->data);
	}

	public function approver_filtering_company_div($div,$company,$identification,$location,$classification)
	{
		$this->data['identification']=$identification;
		$this->data['location']=$location;
		$this->data['classification']=$classification;
		$this->data['company']=$company;
		$this->data['division']=$div;
		$this->data['with_division']=$this->form_approval_model->with_division($company);
		$this->data['resultss'] = $this->form_approval_model->filtering_div($div,$company);
		$this->load->view("app/form_approval/filtering_results_division",$this->data);
	}

	public function approver_filtering_companylocclassdiv_delete($company,$id,$identification,$name,$location,$classification,$division)
	{
		$delete = $this->form_approval_model->approver_delete_by_division($company,$id,$identification,$name,$location,$classification,$division);
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Delete Approver company|id|identification|name|location|classification|division: '.$company.'|'.$id.'|'.$identification.'|'.$name.'|'.$location.'|'.$classification.'|'.$division,'DELETE',$identification);

		$this->data['identification']=$identification;
		$this->data['location']=$location;
		$this->data['classification']=$classification;
		$this->data['company']=$company;
		$this->data['division']=$division;
		$this->data['with_division']=$this->form_approval_model->with_division($company);
		$this->data['resultss'] = $this->form_approval_model->filtering_div($division,$company);
		$this->load->view("app/form_approval/filtering_results_division",$this->data);
	}

	public function approver_filtering_companylocclassdivdept_delete($company,$id,$identification,$name,$location,$classification,$division,$department)
	{ 
		$delete = $this->form_approval_model->approver_delete_by_division($company,$id,$identification,$name,$location,$classification,$division);

		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Delete Approver company|id|identification|name|location|classification|division: '.$company.'|'.$id.'|'.$identification.'|'.$name.'|'.$location.'|'.$classification.'|'.$division,'DELETE',$identification);

		$this->data['identification']=$identification;
		$this->data['location']=$location;
		$this->data['classification']=$classification;
		$this->data['company']=$company;
		$this->data['department']=$department;
		$this->data['division']=$division;
		$this->data['with_division']=$this->form_approval_model->with_division($company);
		$this->data['resultss']=$this->form_approval_model->filtering_dept($company,$division,$department);
		$this->load->view("app/form_approval/filtering_results_department",$this->data);
	}

	public function approver_filtering_companylocclassdivsec_delete($company,$id,$identification,$name,$location,$classification,$division,$department,$section)
	{ 
		$delete = $this->form_approval_model->approver_delete_by_division($company,$id,$identification,$name,$location,$classification,$division);
		$this->data['identification']=$identification;
		$this->data['location']=$location;
		$this->data['classification']=$classification;
		$this->data['company']=$company;
		$this->data['department']=$department;
		$this->data['division']=$division;
		$this->data['sectionss']=$section;
		$this->data['with_division']=$this->form_approval_model->with_division($company);
		$this->data['resultss']=$this->form_approval_model->filtering_sec($company,$division,$department,$section);
		$this->load->view("app/form_approval/filtering_results_section",$this->data);
	}

	public function approver_filtering_dept_result($company,$div,$dept,$identification,$location,$classification)
	{ 
		$this->data['identification']=$identification;
		$this->data['location']=$location;
		$this->data['classification']=$classification;
		$this->data['company']=$company;
		$this->data['division']=$div;
		$this->data['department']=$dept;
		$this->data['with_division']=$this->form_approval_model->with_division($company);
		$this->data['resultss']=$this->form_approval_model->filtering_dept($company,$div,$dept);
		$this->load->view("app/form_approval/filtering_results_department",$this->data);
	}

	public function deleteapprover_by_company($company)
	{ 
		$this->data['companyy']=$company;
		$this->data['approver'] = $this->form_approval_model->approver_list_all_per_company($company); 
		$this->load->view("app/form_approval/approver_list_all_per_company",$this->data);
	}

	//setting for automatic approved

	public function status_setting_add($transaction_id)
	{
		$this->data['UserDefine'] = $this->form_approval_model->UserDefine($transaction_id);
		$this->data['transaction_id'] = $transaction_id;
		$this->data['status_setting'] = $this->form_approval_model->status_setting_automatic($transaction_id);
		$this->load->view("app/form_approval/status_setting_add",$this->data);
	}

	public function save_status_setting_add($transaction_id,$company,$days,$status)
	{ 
		$this->data['transaction_id'] = $transaction_id;
		$this->data['UserDefine'] = $this->form_approval_model->UserDefine($transaction_id);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Add Auto Approve Form Settings transaction_id|company|days|status'.$transaction_id.'|'.$company.'|'.$days.'|'.$status,'INSERT',$transaction_id);

		$insert = $this->form_approval_model->insert_status_setting_add($transaction_id,$company,$days,$status);
		$this->data['flash_id']=$company;
		$this->data['transaction_id'] = $transaction_id;
		$this->data['action_']='add';
		if($insert=='inserted')
		{	
			$this->session->set_flashdata('success_inserted',"Success");
		}
		else
		{
			$this->session->set_flashdata('insert_error',"Error");
		}



		$this->data['status_setting'] = $this->form_approval_model->status_setting_automatic($transaction_id);
		$this->load->view("app/form_approval/status_setting_result",$this->data);
	}

	public function delete_status_setting($id,$transaction_id)
	{
		$this->data['transaction_id'] = $transaction_id;
		$this->data['UserDefine'] = $this->form_approval_model->UserDefine($transaction_id);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Delete Auto Approve Form Settings id'.$id,'DELETE',$id);

		$delete = $this->form_approval_model->delete_status_setting($id);
		$this->data['flash_id']=$id;
		$this->data['transaction_id'] = $transaction_id;
		$this->data['action_']='delete';
		if($delete=='deleted')
		{	
			$this->session->set_flashdata('success_deleted',"Success");
		}
		else
		{
			$this->session->set_flashdata('insert_error',"Error");
		}



		$this->data['status_setting'] = $this->form_approval_model->status_setting_automatic($transaction_id);
		$this->load->view("app/form_approval/status_setting_result",$this->data);
	}
	
	public function edit_status_setting_form($id,$company,$transaction_id)
	{ 
		$this->data['company_id']=$company;
		$this->data['transaction_id']=$transaction_id;
		$this->data['UserDefine'] = $this->form_approval_model->UserDefine($transaction_id);
		$this->data['get_data'] = $this->form_approval_model->update_status_setting_form_data($id);
		$this->load->view("app/form_approval/update_status_setting_form",$this->data);
	}

	public function save_status_setting_update($transaction_id,$company,$days,$status,$id)
	{ 
		$this->data['transaction_id'] = $transaction_id;
		$this->data['UserDefine'] = $this->form_approval_model->UserDefine($transaction_id);
		/*
		--------------audit trail composition--------------
		(module,module dropdown,logfiletable,detailed action,action type,key value)
		--------------audit trail composition--------------
		*/

		General::system_audit_trail('Administrator','Form Approval','logfile_admin_form_approval','Update Auto Approve Form Settings transaction_id|company|days|status|id'.$transaction_id.'|'.$company.'|'.$days.'|'.$status.'|'.$id,'UPDATE',$transaction_id);

		$update = $this->form_approval_model->save_status_setting_update($transaction_id,$company,$days,$status,$id);

		$this->data['transaction_id'] = $transaction_id;

		$this->data['flash_id']=$company;
		$this->data['action_']='update';
		if($update=='updated')
		{	
			$this->session->set_flashdata('success_updated',"Success");
		}
		else
		{
			$this->session->set_flashdata('updated_error',"Error");
		}



		$this->data['status_setting'] = $this->form_approval_model->status_setting_automatic($transaction_id);
		$this->load->view("app/form_approval/status_setting_result",$this->data);
	}

	public function request_form($id)
	{
		$this->data['trans_id']=$id;
		$this->data['request_form'] = $this->form_approval_model->request_form_list();
		$this->load->view("app/form_approval/request_form_list",$this->data);
	}
	public function delete_request_form($id)
	{
		$this->data['trans_id']=$id;
		$delete = $this->form_approval_model->delete_request_form($id);
		$this->data['request_form'] = $this->form_approval_model->request_form_list();
		$this->load->view("app/form_approval/request_form_list",$this->data);
	}
	public function status_request_form($id,$option)
	{
		$this->data['trans_id']=$id;
		$update = $this->form_approval_model->status_request_form($id,$option);
		$this->data['request_form'] = $this->form_approval_model->request_form_list();
		$this->load->view("app/form_approval/request_form_list",$this->data);
	}
	public function add_request_form($form)
	{
	
		$add = $this->form_approval_model->add_request_form($form);
		$this->data['request_form'] = $this->form_approval_model->request_form_list();
		$this->load->view("app/form_approval/request_form_list",$this->data);
		
	}

	public function edit_request_form($id)
	{
		$this->data['data'] = $this->form_approval_model->request_form_list_one($id);
		$this->load->view("app/form_approval/edit_request_form_list",$this->data);
	}
	public function update_request_form($id,$form)
	{
		$update = $this->form_approval_model->saveupdate_request_form($id,$form);
		$this->data['request_form'] = $this->form_approval_model->request_form_list();
		$this->load->view("app/form_approval/request_form_list",$this->data);
	}

	

	//start of notifications


	public function add_notifications_approver($type)
	{
		$this->data['type']=$type;
 		$this->load->view('app/form_approval/add_notifications_approver',$this->data);
	}
	public function loadNotification($company)
	{
		$notification = $this->form_approval_model->loadNotification($company);
		if(empty($notification))
		{	
			echo "<option value='0'>No notification found. Please add to continue.</option>";
		}
		else
		{
			echo "<option value='0'>Select</option>";
			foreach($notification as $notif)
			{
				echo "<option value='".$notif->id."'>".$notif->form_name."</option>";
			}
		}
	}

	public function save_notification($type,$company,$division,$department,$section,$subsection,$employee_id,$classification,$approval_number,$approvallevel,$location,$notification,$ApplyOption_result)
	{
		if($ApplyOption_result=='all')
		{
				$get_notifications_forms = $this->form_approval_model->get_with_approver_notifications($company,'all');
		}
		else
		{
				$get_notifications_forms = $this->form_approval_model->get_with_approver_notifications($company,$notification);
		}

		foreach($get_notifications_forms as $nf)
		{

				if($location=='All')
				{
				$locationList = $this->form_approval_model->locationList($company);
				foreach ($locationList as $loc) {
					if($classification=='All')
					{
						$classificationList = $this->form_approval_model->classificationList($company);
						foreach ($classificationList as $class) {
							$insert = $this->form_approval_model->savenew_approver_notification($type,$company,$division,$department,$section,$subsection,$employee_id,$class->classification_id,$approval_number,$approvallevel,$loc->location_id,$nf->id); 


						}
					}
					else
					{
						$insert = $this->form_approval_model->savenew_approver_notification($type,$company,$division,$department,$section,$subsection,$employee_id,$classification,$approval_number,$approvallevel,$location,$nf->id); 


					}
				}
				}	
				else{
						if($classification=='All')
						{
							$classificationList = $this->form_approval_model->classificationList($company);
							foreach ($classificationList as $class) {
							$insert = $this->form_approval_model->savenew_approver_notification($type,$company,$division,$department,$section,$subsection,$employee_id,$classification,$approval_number,$approvallevel,$location,$nf->id); 


							}
						}
					else{ 
							$insert = $this->form_approval_model->savenew_approver_notification($type,$company,$division,$department,$section,$subsection,$employee_id,$classification,$approval_number,$approvallevel,$location,$nf->id); 


						}
					}
/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
							General::system_audit_trail('Administrator','Disc Act Memos Approval','logfile_admin_notif_approval','Add Approvers notifid|company|approval_number|approvallevel'.$nf->id.'|'.$company.'|'.$approval_number.'|'.$approvallevel,'INSERT',$employee_id);



		}
		

		$check_with_division = $this->form_approval_model->with_division($company);
		$this->data['with_division']=$check_with_division;
		$this->data['classification']='All';
		$this->data['location']= 'All';
		$this->data['notification']='All';
		$this->data['flash_id']=$company;
		$this->data['action_']='add';
		$this->session->set_flashdata('success_inserted',"inserted");
		if($check_with_division > 0)
		{
			$this->data['get_division'] = $this->form_approval_model->load_division($company);
		}
		else
		{
			$this->data['get_department'] = $this->form_approval_model->with_department_viewing($company,'All');
		}

		$this->data['classificationList'] = $this->form_approval_model->classificationList($company);
		$this->data['locationList'] = $this->form_approval_model->locationList($company);
		$this->data['notificationList'] = $this->form_approval_model->loadNotification($company);
		$this->data['company']=$company;
		$this->data['company_name'] = $this->notification_approval_model->get_company_name($company);
		$this->load->view('app/notification_approval/manage_notification',$this->data);
	}	
	public function view_notification_approver($type)
	{
		$this->data['type']=$type;
		$this->load->view('app/form_approval/notification_filtering',$this->data);
	}

	public function view_approver_notif($notif,$company)
	{
		$this->data['notif']=$notif;
		$this->data['company']=$company;
		$this->data['details']=$this->form_approval_model->get_approver_by_notifications($notif,$company);
		$this->load->view('app/form_approval/notification_filtering_results',$this->data);
	}

	public function approver_action($action,$id,$notif,$company)
	{
		$action = $this->form_approval_model->approver_action($action,$id,$notif,$company);
		$this->data['notif']=$notif;
		$this->data['company']=$company;
		$this->data['details']=$this->form_approval_model->get_approver_by_notifications($notif,$company);
		$this->load->view('app/form_approval/notification_filtering_results',$this->data);
	}
	//end of notifications



	//start of viewing the transaction by division to subsection

	public function get_company_viewing($trans_id,$company_id,$classification,$location,$leavetype,$department)
	{	
		$this->data['classification']=$classification;
		$this->data['location'] = $location;
		$this->data['leavetype'] = $leavetype;
		$this->data['department'] = $department;
		$this->data['company_id'] = $company_id;
		$this->data['trans_id'] = $trans_id;

		$this->data['action_'] = 'filtering';
		$this->session->set_flashdata('success_filtering',"Success");


		$this->data['trans_id'] = $this->form_approval_model->get_identification($trans_id);
		$check_with_division = $this->form_approval_model->with_division($company_id);
		$this->data['with_division']=$check_with_division;
		if($check_with_division > 0)
		{
			$this->data['get_division'] = $this->form_approval_model->load_division_department($company_id,$department);
		}
		else
		{
			$this->data['get_department'] = $this->form_approval_model->with_department_viewing($company_id,$department);
		}

		$this->load->view('app/form_approval/viewing_of_approvers_all',$this->data);
	}


	public function load_classification_all($val)
	{
		$classificationList = $this->form_approval_model->classificationList($val);
		if(empty($classificationList)){ echo " <option value='0'>No Classification added in this company. Please add Classification first to continue.</option> "; }
		else{
		echo '<option value="All">All Classifications</option>'; 
		foreach ($classificationList as $classs) {
			echo "<option value='".$classs->classification_id."'>".$classs->classification."</option>";
		} }
	}

	public function leavetype_all($val)
	{
		$leavetypeList = $this->form_approval_model->leavetypeList($val);
		if(empty($leavetypeList)){ echo " <option value='0'>No leave type added in this company. Please add leave type first to cotinue.</option> "; }
		else{
		
		echo '<option value="All">All Leave Type</option>';
		foreach ($leavetypeList as $leave) {
			echo "<option value='".$leave->id."'>".$leave->leave_type."</option>";
		} }
	}


	//aditional in viewing list of approvers
	public function get_department_viewing($company)
	{
		$department = $this->form_approval_model->get_departmentlist($company);
		if(empty($department))
		{
			echo "<option value=''>No department found please add to continue.</option>";
		}
		else
		{	
			echo "<option value='All'>All Department</option>";
			foreach($department as $d)
			{
				echo "<option value='".$d->department_id."'>".$d->dept_name."</option>";
			}
		}
	}

	//update form approval delete

	public function delete_selected_approvers($selected,$company_id,$department,$location,$classification,$leavetype,$trans_id)
	{
		
		$delete_approver = $this->form_approval_model->delete_selected_approver($selected);
		
		$this->data['classification']=$classification;
		$this->data['location'] = $location;
		$this->data['leavetype'] = $leavetype;
		$this->data['department'] = $department;
		$this->data['company_id'] = $company_id;
		$this->data['trans_id'] = $trans_id;

		$this->data['action_'] = 'deleted';
		$this->session->set_flashdata('success_deleted',"Success");

		$check_with_division = $this->form_approval_model->with_division($company_id);
		$this->data['with_division']=$check_with_division;
		if($check_with_division > 0)
		{
			$this->data['get_division'] = $this->form_approval_model->load_division_department($company_id,$department);
		}
		else
		{
			$this->data['get_department'] = $this->form_approval_model->with_department_viewing($company_id,$department);
		}

		$this->load->view('app/form_approval/viewing_of_approvers_all',$this->data);
		
	}


	// filtering all approvers / aall forms

	public function filtering_all_approvers()
	{
		$this->data['file_t'] = $this->form_approval_model->get_t_forms();
 		$this->load->view('app/form_approval/filtering_all_approvers_forms',$this->data);
	}

	public function get_approver_viewing($company,$transaction)
	{
		$get_approver = $this->form_approval_model->get_approver_viewing($company,$transaction);
		if(empty($get_approver))
		{
			echo "<option value='not_included'>No Approver found</option>";
		}
		else
		{
			echo "<option value='All'>All Approver</option>";
			foreach($get_approver as $ga)
			{
				echo "<option value='".$ga->approver."'>".$ga->approver."(".$ga->first_name.' '.$ga->fullname.")</option>";
			}
		}
		

	}
	public function get_allfiltering_viewing($trans_id,$company_id,$classification,$location,$leavetype,$department,$approver_viewing)
	{
		
		$this->data['classification']=$classification;
		$this->data['location'] = $location;
		$this->data['leavetype'] = $leavetype;
		$this->data['department'] = $department;
		$this->data['approver'] = $approver_viewing;
		$this->data['trans_idd'] = $trans_id;
		$this->data['company_id'] = $company_id;
		$this->data['action_'] = 'filter';
		$this->session->set_flashdata('success_filtering',"Success");

		$this->data['trans_id'] = $this->form_approval_model->get_identification($trans_id);
		$check_with_division = $this->form_approval_model->with_division($company_id);
		$this->data['with_division']=$check_with_division;
		if($check_with_division > 0)
		{
			$this->data['get_division'] = $this->form_approval_model->load_division_department($company_id,$department);
		}
		else
		{
			$this->data['get_department'] = $this->form_approval_model->with_department_viewing($company_id,$department);
		}

		$this->load->view('app/form_approval/filtering_all_approvers_forms_results',$this->data);
		
	}

	public function delete_selected_form_approvers($trans_id,$company_id,$classification,$location,$leavetype,$department,$approver_viewing,$selected)
	{
		$delete_approver = $this->form_approval_model->delete_selected_approver($selected);

		$this->data['classification']=$classification;
		$this->data['location'] = $location;
		$this->data['leavetype'] = $leavetype;
		$this->data['department'] = $department;
		$this->data['approver'] = $approver_viewing;
		$this->data['trans_idd'] = $trans_id;
		$this->data['company_id'] = $company_id;
		$this->data['action_'] = 'deleted';
		$this->session->set_flashdata('success_deleted',"Success");

		$this->data['trans_id'] = $this->form_approval_model->get_identification($trans_id);
		$check_with_division = $this->form_approval_model->with_division($company_id);
		$this->data['with_division']=$check_with_division;
		if($check_with_division > 0)
		{
			$this->data['get_division'] = $this->form_approval_model->load_division_department($company_id,$department);
		}
		else
		{
			$this->data['get_department'] = $this->form_approval_model->with_department_viewing($company_id,$department);
		}

		$this->load->view('app/form_approval/filtering_all_approvers_forms_results',$this->data);
	}
}//end controller



