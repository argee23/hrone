<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Transaction_employees extends General{


	public function __construct(){
		parent::__construct();
		$this->load->model("app/transaction_employees_model");
		$this->load->model("general_model");
		$this->load->library("excel");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}	
	public function index(){	
		
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['file'] = $this->transaction_employees_model->getAll();
		
		$this->load->view('app/transaction/employee_transactions',$this->data);
	}
	// Download/Upload Transaction Records
	public function page_dl_ul_tran_record(){	

		$this->load->view('app/transaction/download_upload_tran_rec',$this->data);
	}
	//Approve Transaction
	public function page_approve_tran(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['file'] = $this->transaction_employees_model->getAll();
		$this->load->view('app/transaction/approve_tran_rec',$this->data);
	}
	//Cancel Transaction
	public function page_cancel_tran(){	
		
		$this->load->view('app/transaction/cancel_tran_rec',$this->data);
	}
	//Cancel Transaction on Employee Account
	public function page_cancel_tran_emp_acc(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['file'] = $this->transaction_employees_model->getAll();
		$this->load->view('app/transaction/cancel_tran_rec_on_emp_account',$this->data);
	}
	//Attach File on transactions filing
	public function page_attach_file_on_tran_filing(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['file'] = $this->transaction_employees_model->getAll();
		$this->load->view('app/transaction/attach_file_tran_filing',$this->data);
	}
	//Delete Transaction
	public function page_del_tran(){	
		
		$this->load->view('app/transaction/delete_tran_rec');
	}
	//Error Transaction
	public function page_err_tran(){	
		
		$this->load->view('app/transaction/error_tran_rec');
	}
	//Transfer Transaction Approval
	public function page_trans_tran_app(){	
		
		$this->load->view('app/transaction/transfer_tran_app');
	}
	//Assign Employee for Transaction Encoding
	public function page_ass_emp_tran_enc(){	
		
		$this->load->view('app/transaction/assign_emp_tran',$this->data);
	}

	public function get_section(){	
		$dept_id=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('app/transaction/show_section',$this->data);
	}
	//Mass Transaction Encoding
	public function page_mass_tran_enc(){	
		
		$this->load->view('app/transaction/mass_transaction_encoding',$this->data);
	}
	//Mass Transaction Encoding
	public function mass_tran_enc(){	
		//mass_tran_enc_rec: mass transaction encoding records
		$form = $this->input->post('form');
		$location = $this->input->post('location');
		$clas = $this->input->post('classification');
		$dept = $this->input->post('department');
		$sect = $this->input->post('section');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');

		$this->data['employee'] = $this->transaction_employees_model->mass_tran_enc_rec($location,$clas,$dept,$sect,$date_from,$date_to); 
		$this->load->view('app/transaction/mass_transaction_encoding_actual',$this->data);
	}
	//Late Filing Transaction Options
	public function page_late_fil_tran_opt(){	
		$this->data['file'] = $this->transaction_employees_model->get_late_filing_trans();	
		$this->load->view('app/transaction/late_filing_tran',$this->data);
	}

	public function save_late_fil_tran_opt(){
		$this->form_validation->set_rules("late_filing_option","Filing Option","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){
			// save data	
			$late_filing_option = $this->input->post('late_filing_option');
			$identification = $this->input->post('identification');	
			$form_name = $this->input->post('form_name');	
			$cur_form_controller = $this->input->post('cur_form_controller');	

			$this->transaction_employees_model->save_late_fil_tran_opt($late_filing_option,$identification);
			// logfile

			$value = $form_name;
			General::logfile('Late Filing Options','EDIT',$value);			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Late Filing Options of <strong>".$value."</strong>, is Successfully Updated !</div>");					
			// redirect
			redirect(base_url().'app/transaction_employees/index/'.$cur_form_controller,$this->data);
		}else{
			$this->index();
		}		
	}
	//Sending Email Transaction
	public function page_send_email_tran(){	
		//tse = transaction sending email
		$this->data['tse'] = $this->transaction_employees_model->tran_send_email_getAll();
		$this->load->view('app/transaction/send_email_rec',$this->data);
	}
	//add sending email transactions
	public function save_sending_email(){
		$this->form_validation->set_rules('form','Transaction','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required');
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){
			// save data			
		$this->transaction_employees_model->save_sending_email();

		foreach ($this->input->post('location') as $key => $value)
			{
			$this->data = array(
			'employee_id'	=>		$this->input->post('assigned_employee'),
			'transaction'	=>		$this->input->post('form'),
			'tran_send_email_location'	=>		$value
			);
			$this->db->insert("transaction_sending_email_location",$this->data);
			}
			// logfile
		$value = $this->input->post('form');
		$the_form=$this->transaction_employees_model->get_form_form_name($value);
		$form_name=$the_form->form_name;
			General::logfile('Sending Email For Transactions','INSERT',$value);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Sending Email For : (<strong><u>".$form_name." </u>transaction)</strong>, is Successfully Added!</div>");					
			// redirect
			redirect(base_url().'app/transaction_employees/index',$this->data);
		}else{
			$this->index();
		}		
	}
	public function save_edit_sending_email(){
		$this->form_validation->set_rules('email','Email','trim|required');
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){
			// save data	
		$tse_id=	$this->input->post('tse');
		$employee=	$this->input->post('employee');
		$form=		$this->input->post('form');
		$ui=$form."_".$employee; // ui: unique identification
		$this->db->query("delete from transaction_sending_email_location where transaction='".$form."' and employee_id ='".$employee."' ");		

		$this->transaction_employees_model->save_edit_sending_email($tse_id);

		foreach ($this->input->post('location') as $key => $value)
			{
			$this->data = array(
			'employee_id'				=>		$employee,
			'transaction'				=>		$form,
			'unique_identification'		=>		$ui,	// ui: unique identification
			'tran_send_email_location'	=>		$value
			);
			$this->db->insert("transaction_sending_email_location",$this->data);
			}
			// logfile
		$value = $form;
		$the_form=$this->transaction_employees_model->get_form_form_name($value);
		$form_name=$the_form->form_name;
			General::logfile('Sending Email For Transactions','INSERT',$value);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Sending Email For : (<strong><u>".$form_name." </u>transaction)</strong>, is Successfully Updated!</div>");					
			// redirect
			redirect(base_url().'app/transaction_employees/index',$this->data);
		}else{
			$this->index();
		}		
	}

	public function delete_sending_email(){

		$id = $this->uri->segment("4");
		$value = $this->uri->segment("5");
		$the_form=$this->transaction_employees_model->get_form_form_name($value);

		$this->transaction_employees_model->delete_sending_email($id);
		// logfile
		$value =  $the_form->form_name;

		General::logfile('Transaction Sending Email','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Transaction Sending Email For ".$value."</strong> is Successfully Deleted!</div>");

		redirect(base_url().'app/transaction_employees/index',$this->data);
	}
	public function editSendingEmail(){
		//tse = transaction sending email
		$id = $this->uri->segment("4");
		$this->data['tse'] = $this->transaction_employees_model->get_sending_email($id);
		$this->load->view('app/transaction/edit_sending_email',$this->data);
	}
	//Apply Leave with or without pay option
	public function page_app_leave_pay_opt(){	
		
		$this->load->view('app/transaction/apply_leave_option');
	}

	public function save_app_leave_pay_opt(){
		$this->form_validation->set_rules("leave_pay_option","Leave Pay Option","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){
			// save data	
			$leave_pay_option = $this->input->post('leave_pay_option');
			$apply_leave_details = $this->transaction_employees_model->get_form_db();
			$table_name=$apply_leave_details->t_table_name;	
			$identification=$apply_leave_details->identification;	
			$form_name=$apply_leave_details->form_name;	

			$this->transaction_employees_model->save_app_leave_pay_opt($leave_pay_option,$identification);
			// logfile

			$value = $form_name;
			General::logfile($form_name. ' Pay Options','EDIT',$value);			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong>,  Pay Option is Successfully Updated !</div>");					
			// redirect
			redirect(base_url().'app/transaction_employees/index/'.$cur_form_controller,$this->data);
		}else{
			$this->index();
		}		
	}
	//List of Pending Transaction
	public function page_list_pend_tran(){	
		
		$this->load->view('app/transaction/pending_tran_rec');
	}
	//download template
	public function get_template(){	
		
		$this->load->view('app/transaction/get_template');
	}	
	public function download_template(){	
		$template_name= $this->uri->segment('4');

		$this->load->helper('download');     

		$path    =  file_get_contents(base_url()."public/downloadable_templates/".$template_name.".xls");
		$name    =  $template_name.".xls";
		force_download($name, $path); 

		$value = $name;
		General::logfile($template_name,'DOWNLOAD',$value);
	}
	//upload template
	public function upload_template(){
		$this->load->view('app/transaction/download_upload_tran_rec_view');

  //       if(isset($_POST["Import"]))
  //           {
  //               $filename=$_FILES["file"]["tmp_name"];
  //               if($_FILES["file"]["size"] > 0)
  //                 {
  //                $row=1;
  //                   $file = fopen($filename, "r");
  //                    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
  //                    {
  //                    	 $num = count($emapData);    
  //      	for ($c = 0; $c < $num; $c++) {
  //          $csvData = $emapData[$c];
  //          $data = array(
  //                               'gender_name' => $emapData[0],                           
  //                               'InActive' => $c,                           
  //                               );
  //                           $this->db->insert('gender', $data);
  //      	}    
  //      	$row++;
		// //$ito=	$this->escape_str($emapData[0]);
                                 
  //                    }
  //                   fclose($file);
  //                   redirect(base_url().'app/transaction_employees/index',$this->data);
  //                 }
			// $xls = fopen($filename, "r");
			// $xls->fgetcsv($_FILES['file']['tmp_name']);	// replace with your excel file

			// $no_of_columns = $xls->sheets[0]['numCols']; //total
			// $no_of_rows = $xls->sheets[0]['numRows'];    //total
			// $vans=0;
			// for($i= 1; $i<= $no_of_rows; $i++) {
			// if($nxt==1){  $strt=1; $nxt="";}
			// for($j= 1; $j <= $no_of_columns; $j++) {
			// $edata = $xls->sheets[0]['cells'][$i][$j];
			// $edata = $edata;
			// $vans++;

			// if($vans==1){
			// $gender_name = $edata;
			// $data = array(
			// 'gender_name' => $gender_name                          
			// );
			// $this->db->insert('gender', $data);
			// }
			// }
   //          }
        
//}
}
	
	//Transactions History
	public function trans_history(){
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		
		$t_table_name=$this->uri->segment('4');//important
		//employee leave transactions
		if($t_table_name!=""){
			$this->data['file'] = $this->transaction_employees_model->get_transaction_on_history($t_table_name);			
			$this->load->view('app/transaction/history',$this->data);
		}else{
			$this->data['file'] = $this->transaction_employees_model->getAll();			
			$this->load->view('app/transaction/employee_transactions',$this->data);
		}	
	}
	//view_transactions
	public function view_transactions(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		

		$t_table_name=$this->uri->segment('4');//important
		//employee leave transactions
		if($t_table_name=="employee_leave"){
			$this->data['file'] = $this->transaction_employees_model->get_employee_leave_transaction();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee request of change of schedule
		else if($t_table_name=="emp_change_sched"){
			$this->data['file'] = $this->transaction_employees_model->change_sched_req_getAll();			
			//mass encoding : automatic approve
			$this->data['file_h'] = $this->transaction_employees_model->get_transaction_with_mass_encoding($t_table_name);			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee time keeping complaint
		else if($t_table_name=="emp_time_complaint"){
			$this->data['file'] = $this->transaction_employees_model->time_comp_req_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee request of change of rest day
		else if($t_table_name=="emp_change_rest_day"){
			$this->data['file'] = $this->transaction_employees_model->change_rest_day_req_getAll();			
			//mass encoding : automatic approve
			$this->data['file_h'] = $this->transaction_employees_model->get_transaction_with_mass_encoding($t_table_name);		
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee request of cancellation of leave
		else if($t_table_name=="employee_leave_cancel"){
			$this->data['file'] = $this->transaction_employees_model->cancel_leave_req_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee request of undertime
		else if($t_table_name=="emp_under_time"){
			$this->data['file'] = $this->transaction_employees_model->under_time_req_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee request of authorization to render overtime
		else if($t_table_name=="emp_atro"){
			$this->data['file'] = $this->transaction_employees_model->atro_req_getAll();
			//mass encoding : automatic approve
			$this->data['file_h'] = $this->transaction_employees_model->get_transaction_with_mass_encoding($t_table_name);					
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee official business form
		else if($t_table_name=="emp_official_business"){
			$this->data['file'] = $this->transaction_employees_model->off_business_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee loans
		else if($t_table_name=="emp_loans"){
			$this->data['file'] = $this->transaction_employees_model->emp_loans_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee trip ticket
		else if($t_table_name=="emp_trip_ticket"){
			$this->data['file'] = $this->transaction_employees_model->emp_trip_ticket_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee gate pass
		else if($t_table_name=="emp_gate_pass"){
			$this->data['file'] = $this->transaction_employees_model->emp_gate_pass_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee sworn declaration
		else if($t_table_name=="emp_sworn_declaration"){
			$this->data['file'] = $this->transaction_employees_model->emp_sworn_dec_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee authority to deduct
		else if($t_table_name=="emp_authority_to_deduct"){
			$this->data['file'] = $this->transaction_employees_model->emp_authority_to_deduct_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee request for grievance
		else if($t_table_name=="emp_grievance_request"){
			$this->data['file'] = $this->transaction_employees_model->emp_grievance_req_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee grocery items loan
		else if($t_table_name=="emp_grocery_items_loan"){
			$this->data['file'] = $this->transaction_employees_model->emp_grocery_loan_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee bap claim
		else if($t_table_name=="emp_bap_claim"){
			$this->data['file'] = $this->transaction_employees_model->emp_bap_claim_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee call out form
		else if($t_table_name=="emp_call_out"){
			$this->data['file'] = $this->transaction_employees_model->emp_call_out_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee request form
		else if($t_table_name=="emp_request_form"){
			$this->data['file'] = $this->transaction_employees_model->emp_request_form_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee paternity notifications
		else if($t_table_name=="emp_paternity_notif"){
			$this->data['file'] = $this->transaction_employees_model->emp_paternity_notif_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee payroll complaint
		else if($t_table_name=="emp_payroll_complaint"){
			$this->data['file'] = $this->transaction_employees_model->emp_payroll_comp_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee medicine reimbursement
		else if($t_table_name=="emp_medicine_reimburse"){
			$this->data['file'] = $this->transaction_employees_model->emp_medicine_reimburse_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}//employee hdmf cancellation
		else if($t_table_name=="emp_hdmf_cancellation"){
			$this->data['file'] = $this->transaction_employees_model->emp_hdmf_cancel_getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}else{
			$this->data['file'] = $this->transaction_employees_model->getAll();			
			$this->load->view('app/transaction/employee_transactions',$this->data);
		}		
	}
	//transfer_transactions
	public function transfer_transactions_approval(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		

		$t_table_name=$this->uri->segment('4');	//variable name important 
		$current_form=$this->uri->segment('6'); //variable name important  

		if($current_form!=""){
			$this->data['file'] = $this->transaction_employees_model->form_approvers($current_form);			
			$this->data['emp'] = $this->transaction_employees_model->get_emp($current_form);			
			$this->load->view('app/transaction/transfer_tran_app',$this->data);
		}else{
			$this->data['file'] = $this->transaction_employees_model->getAll();			
			$this->load->view('app/transaction/employee_transactions',$this->data);
		}	
	}
	public function save_transfer_transactions_approval(){
		$this->form_validation->set_rules("cur_form","Current Form","trim|required");
		$this->form_validation->set_rules("from_approver","Old Approver","trim|required");
		$this->form_validation->set_rules("to_approver","New Approver","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){
			// save data	
			$from_approver = $this->input->post('from_approver');
			$new_approver = $this->input->post('to_approver');	
			$current_form = $this->input->post('cur_form');

			$new=$this->transaction_employees_model->get_new_app_info($new_approver);
			$position=$new->position;
			$new_approver_name=$new->name;

			$old=$this->transaction_employees_model->get_old_app_info($from_approver);
			$old_approver_name=$old->name;

			$this->transaction_employees_model->save_transfer_approval($position);
			// logfile

			$value = $this->input->post('cur_form')."-transfer approval-"."from-".$from_approver."-to-".$new_approver;
			$cur_form=$this->input->post('cur_form');
			General::logfile('Transfer Approval','TRANSFER',$value);			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Approval of <strong>".$old_approver_name."</strong>, is Successfully Transferred to ".$new_approver_name." !</div>");					
			// redirect
			redirect(base_url().'app/transaction_employees/index',$this->data);
		}else{
			$this->index();
		}		
	}
	
	//to delete_transactions
	public function delete_transactions(){	
		$t_table_name=$this->uri->segment('4');
		$identification=$this->uri->segment('6');

		if($t_table_name!=""){

			$this->data['onload'] = $this->session->flashdata('onload');
			$this->data['message'] = $this->session->flashdata('message');	
			$this->data['file'] = $this->transaction_employees_model->to_delete_trans($identification,$t_table_name);			
			//file_d: deleted transactions
			$this->data['file_d'] = $this->transaction_employees_model->deleted_transactions($t_table_name);			
			$this->load->view('app/transaction/delete_tran_rec',$this->data);
		}else{
			$this->data['file'] = $this->transaction_employees_model->getAll();			
			$this->load->view('app/transaction/index',$this->data);
		}	
	}
	
	//view error transactions
	public function error_transactions(){	
		$t_table_name=$this->uri->segment('4');
		$identification=$this->uri->segment('6');

		if($t_table_name!=""){

			$this->data['onload'] = $this->session->flashdata('onload');
			$this->data['message'] = $this->session->flashdata('message');	
			$this->data['file'] = $this->transaction_employees_model->error_list($identification,$t_table_name);			
			$this->load->view('app/transaction/error_tran_rec',$this->data);
		}else{
			$this->data['file'] = $this->transaction_employees_model->getAll();			
			$this->load->view('app/transaction/index',$this->data);
		}	
	}
	
	//view pending transactions
	public function pending_transactions(){	
		$t_table_name=$this->uri->segment('4');
		$identification=$this->uri->segment('6');

		if($t_table_name!=""){

			$this->data['onload'] = $this->session->flashdata('onload');
			$this->data['message'] = $this->session->flashdata('message');	
			$this->data['file'] = $this->transaction_employees_model->pending_list($identification,$t_table_name);			
			$this->load->view('app/transaction/pending_transactions',$this->data);
		}else{
			$this->data['file'] = $this->transaction_employees_model->getAll();			
			$this->load->view('app/transaction/index',$this->data);
		}	
	}
	//to cancel_transactions
	public function cancel_transactions(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		

		$t_table_name=$this->uri->segment('4');

		if($t_table_name!=""){
			$this->data['onload'] = $this->session->flashdata('onload');
			$this->data['message'] = $this->session->flashdata('message');	
			$this->data['file'] = $this->transaction_employees_model->get_to_cancel_transaction($t_table_name);	
			$this->load->view('app/transaction/cancel_tran_rec',$this->data);
		}	
		else{
			$this->data['file'] = $this->transaction_employees_model->getAll();			
			$this->load->view('app/transaction/cancel_tran_rec',$this->data);
		}	
	}
	//to approve_transactions
	public function approve_transactions(){		
		$t_table_name=$this->uri->segment('4');

		if($t_table_name!=""){
			$this->data['onload'] = $this->session->flashdata('onload');
			$this->data['message'] = $this->session->flashdata('message');	
			$this->data['file'] = $this->transaction_employees_model->get_not_approve_transactions($t_table_name);	
			$this->load->view('app/transaction/approve_tran_rec',$this->data);
		}else{
			$this->data['file'] = $this->transaction_employees_model->getAll();			
			$this->load->view('app/transaction/view_transactions',$this->data);
		}	
	}
	public function approve_all_transactions(){
		$t_table_name=$this->uri->segment('4');
		$t_form=urldecode($this->uri->segment('5'));
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		

		$this->transaction_employees_model->save_approve_all_transactions($t_table_name);

		$value = $t_form;

			General::logfile($t_form,'APPROVE ALL',$value);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>All  <strong>".$value."</strong>, is Successfully Approved!</div>");					
			// redirect
		redirect(base_url().'app/transaction_employees/index',$this->data);
	}
	public function cancel_all_transactions(){

		$t_table_name=$this->uri->segment('4');
		$t_form=urldecode($this->uri->segment('5'));
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		

		$this->transaction_employees_model->cancel_all_transactions($t_table_name);

		$value = $t_form;

			General::logfile("All ".$t_form,'APPROVE',$value);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>All <strong>".$value."</strong>, is Successfully Cancelled!</div>");					
			// redirect
		redirect(base_url().'app/transaction_employees/index',$this->data);
	}
	public function delete_all_transactions(){

		$t_table_name=$this->uri->segment('4');
		$t_form=urldecode($this->uri->segment('5'));
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		

		$this->transaction_employees_model->delete_all_leave_transactions($t_table_name);

		$value = $t_form;//$this->input->post('Apply Leave Transactions');

			General::logfile("All ".$t_form,'DELETE',$value);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>All <strong>".$value."</strong>, is Successfully Deleted!</div>");					
			// redirect
		redirect(base_url().'app/transaction_employees/index',$this->data);
	}
	//============================================= start assigned employees
	public function filing_control(){			
		$this->load->view('app/transaction/assign_emp_tran_filing',$this->data);
	}
	//employee assigned transaction filling /filer
	public function save_filer(){
		$this->form_validation->set_rules('form','Transaction','trim|required');
		$this->form_validation->set_rules('location','Location','trim|required');
		$this->form_validation->set_rules("classification","Classification","trim|required");
		$this->form_validation->set_rules("department","Department","trim|required");
		$this->form_validation->set_rules("section","Section","trim|required");
		$this->form_validation->set_rules('assigned_employee','Assigned Employee','trim|required');
		$this->form_validation->set_rules("position","Assigned Employee Position","trim|required");
		//$this->form_validation->set_rules("option","Option","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){
			// save data			
		$this->transaction_employees_model->save_filer();
			// logfile
		$value = $this->input->post('form');
		$the_form=$this->transaction_employees_model->get_form_form_name($value);
		$form_name=$the_form->form_name;
			General::logfile('Transaction Filing Assigned','INSERT',$value);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Transactions filler to : (<strong><u>".$form_name." </u>transactions)</strong>, is Successfully Added!</div>");					
			// redirect
			redirect(base_url().'app/transaction_employees/index',$this->data);
		}else{
			$this->index();
		}		
	}
	public function showSearchEmployee($val = NULL){

		$this->data['showEmployeeList'] = $this->transaction_employees_model->getSearch_Employee($val); //getEmp //getSearch_Employee
		$this->load->view("app/transaction/showEmployeeList",$this->data);	
	}

	public function select_emp($val = NULL){	
		$selected_emp=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['emp'] = $this->transaction_employees_model->get_selected_emp($selected_emp);
		
		$this->load->view('app/transaction/show_employee',$this->data);
	}
	//============================================= end assigned employees
	public function save_approve_transactions(){
		$cd=date("Y-m-d h:i:sa");
		$t_table_name=$this->uri->segment('4');
		$the_form=urldecode($this->uri->segment('5'));
					// 
		$t_form = $this->transaction_employees_model->get_not_approve_transactions($t_table_name);	
			//$array_edit="";
			foreach($t_form as $tran_form){
				//$array_edit.=$tran_form->doc_no;
				$input_name=$tran_form->id;
				$input_value=$this->input->post($input_name);

				$this->data = array(
					'remarks'					=>		$input_value,
					'status_update_date'		=>		$cd
				);	
				$this->db->where(array(
					'id'						=>		$input_name
				));
				$this->db->update($t_table_name,$this->data);	//update comments|remarks
			}					
			foreach ($this->input->post('doc_no') as $key) 
			{
				$this->data = array(
					
					'status'	=>		'approve',
					'status_update_date'	=>$cd
					);
				$this->db->where(array(
					'doc_no'			=>		$key
				));	
				$this->db->update($t_table_name,$this->data);	//update status				
			}				
			// logfile
			$all_trans="";
			foreach ($this->input->post('doc_no') as $trans) 
			{
				$all_trans.=$trans.",";
			}
				
			$value = $all_trans;
			General::logfile($the_form,'APPROVE',$value);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Selected <strong>on ".$the_form."</strong>,Transactions is Successfully Approved/Updated!</div>");					
			
			redirect(base_url().'app/transaction_employees/index',$this->data);		
	}
	public function save_cancel_opt_on_emp_acc(){		
			// save data			
		$t_form=$this->transaction_employees_model->getAll();
			$array_edit="";
			foreach($t_form as $tran_form){

				$array_edit.=$tran_form->form_name;
				$input_name=$tran_form->id;
				$input_value=$this->input->post($input_name);

				$this->data = array(
					'cancellation_option'		=>		$input_value
				);	
				$this->db->where(array(
					'id'						=>		$input_name
				));
				$this->db->update("transaction_file_maintenance",$this->data);
			}
			// logfile
			$value = $array_edit." , ";
			General::logfile('Cancellation Option on Employee Account','UPDATE',$value);			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Cancellation on Employee Account: <strong>".$value."</strong> is Successfully Updated!</div>");					
			// redirect
			redirect(base_url().'app/transaction_employees/index',$this->data);
				
	}
	public function save_attach_file_on_tran_filing(){		
			// save data			
		$t_form=$this->transaction_employees_model->getAll();
			$array_edit="";
			foreach($t_form as $tran_form){

				$array_edit.=$tran_form->form_name;
				$input_name=$tran_form->id;
				$input_value=$this->input->post($input_name);

				$this->data = array(
					'attach_file'		=>		$input_value
				);	
				$this->db->where(array(
					'id'						=>		$input_name
				));
				$this->db->update("transaction_file_maintenance",$this->data);
			}
			// logfile
			$value = $array_edit." , ";
			General::logfile('Attach File on Transactions Filing Setting','UPDATE',$value);			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Attach File on Transactions Filing Settings for : <strong>".$value."</strong> is Successfully Updated!</div>");					
			// redirect
			redirect(base_url().'app/transaction_employees/index',$this->data);
				
	}
	//cancel leave transaction
	public function save_cancel_transactions(){
		$cd=date("Y-m-d h:i:sa");
		
		$t_table_name=$this->uri->segment('4');
		$the_form=urldecode($this->uri->segment('5'));
		
		$t_form = $this->transaction_employees_model->get_to_cancel_transaction($t_table_name);
			//$array_edit="";
			foreach($t_form as $tran_form){
				//$array_edit.=$tran_form->doc_no;
				$input_name=$tran_form->id;
				$input_value=$this->input->post($input_name);

				$this->data = array(
					'remarks'					=>		$input_value
				);	
				$this->db->where(array(
					'id'						=>		$input_name
				));
				$this->db->update($t_table_name,$this->data);	//update comments|remarks
			}	
			foreach ($this->input->post('doc_no') as $key) 
			{
				$this->data = array(
					'status'	=>		'cancel',
					'status_update_date'	=>$cd
					);
				$this->db->where(array(
					'doc_no'			=>		$key
				));	
				$this->db->update($t_table_name,$this->data);						
			}
			// logfile
			$all_trans="";
			foreach ($this->input->post('doc_no') as $trans) 
			{
				$all_trans.=$trans.",";
			}
			$value = $the_form;

			General::logfile($the_form,'CANCEL',$all_trans);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Selected <strong>".$value."</strong>,Transactions is Successfully Cancelled/Updated!</div>");					
			
			redirect(base_url().'app/transaction_employees/index',$this->data);		
	}
	//cancel leave transaction
	public function save_delete_transactions(){
		$cd=date("Y-m-d h:i:sa");
	
		$t_table_name=$this->uri->segment('4');		
		$the_form=urldecode($this->uri->segment('5'));
		$identification=urldecode($this->uri->segment('6'));
					// 
		$t_form = $this->transaction_employees_model->to_delete_trans($identification,$t_table_name);	
			//$array_edit="";
			foreach($t_form as $tran_form){
				//$array_edit.=$tran_form->doc_no;
				$input_name=$tran_form->id;
				$input_value=$this->input->post($input_name);

				$this->data = array(
					'remarks'					=>		$input_value,
					'status_update_date'		=>$cd
				);	
				$this->db->where(array(
					'id'						=>		$input_name
				));
				$this->db->update($t_table_name,$this->data);	//update comments|remarks
			}	

			foreach ($this->input->post('doc_no') as $key) 
			{
				$this->data = array(
					'IsDeleted'	=>		'1',
					'status_update_date'	=>$cd
					);
				$this->db->where(array(
					'doc_no'			=>		$key
				));	
				$this->db->update($t_table_name,$this->data);						
			}
			// logfile
			$all_trans="";
			foreach ($this->input->post('doc_no') as $trans) 
			{
				$all_trans.=$trans.",";
			}
			$value = $the_form;

			General::logfile($the_form,'DELETE',$all_trans);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Selected <strong>".$the_form."</strong>, is Successfully Updated/Deleted!</div>");							
			redirect(base_url().'app/transaction_employees/index',$this->data);		
	}
	public function form_view(){
		$doc=$this->uri->segment('4');
		$t_table_name=$this->uri->segment('5');
		if($t_table_name=="employee_leave"){

		$this->data['file'] = $this->transaction_employees_model->form_view_emp_leave($doc);			
		$this->load->view('app/transaction/form_view_employee_leave',$this->data);
		}
		else if($t_table_name=="emp_change_sched"){
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_change_sched($doc);			
		$this->load->view('app/transaction/form_view_emp_change_sched',$this->data);
		}
		else if($t_table_name=="emp_time_complaint"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_time_comp($doc);			
		$this->load->view('app/transaction/form_view_emp_time_comp',$this->data);	
		}
		else if($t_table_name=="emp_change_rest_day"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_change_rest_day($doc);			
		$this->load->view('app/transaction/form_view_emp_change_rest_day',$this->data);	
		}
		else if($t_table_name=="employee_leave_cancel"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_cancel_leave($doc);			
		$this->load->view('app/transaction/form_view_emp_cancel_leave',$this->data);	
		}
		else if($t_table_name=="emp_under_time"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_under_time($doc);			
		$this->load->view('app/transaction/form_view_emp_under_time',$this->data);	
		}
		else if($t_table_name=="emp_atro"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_atro($doc);			
		$this->load->view('app/transaction/form_view_emp_atro',$this->data);	
		}
		else if($t_table_name=="emp_official_business"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_off_business($doc);			
		$this->load->view('app/transaction/form_view_off_business',$this->data);	
		}
		else if($t_table_name=="emp_loans"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_loans($doc);			
		$this->load->view('app/transaction/form_view_emp_loans',$this->data);	
		}
		else if($t_table_name=="emp_trip_ticket"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_trip_ticket($doc);			
		$this->load->view('app/transaction/form_view_emp_trip_ticket',$this->data);	
		}
		else if($t_table_name=="emp_gate_pass"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_gate_pass($doc);			
		$this->load->view('app/transaction/form_view_emp_gate_pass',$this->data);	
		}
		else if($t_table_name=="emp_sworn_declaration"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_sworn_dec($doc);			
		$this->load->view('app/transaction/form_view_emp_sworn_dec',$this->data);	
		}
		else if($t_table_name=="emp_authority_to_deduct"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_authority_to_deduct($doc);			
		$this->load->view('app/transaction/form_view_emp_authority_to_deduct',$this->data);	
		}
		else if($t_table_name=="emp_grievance_request"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_grievance_req($doc);			
		$this->load->view('app/transaction/form_view_emp_grievance_req',$this->data);	
		}
		else if($t_table_name=="emp_grocery_items_loan"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_grocery_loan($doc);			
		$this->load->view('app/transaction/form_view_emp_grocery_loan',$this->data);	
		}
		else if($t_table_name=="emp_bap_claim"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_bap_claim($doc);			
		$this->load->view('app/transaction/form_view_emp_bap_claim',$this->data);	
		}
		else if($t_table_name=="emp_call_out"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_call_out($doc);			
		$this->load->view('app/transaction/form_view_emp_call_out',$this->data);	
		}
		else if($t_table_name=="emp_request_form"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_request_form($doc);			
		$this->load->view('app/transaction/form_view_emp_request_form',$this->data);	
		}
		else if($t_table_name=="emp_paternity_notif"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_paternity_notif($doc);			
		$this->load->view('app/transaction/form_view_emp_paternity_notif',$this->data);	
		}
		else if($t_table_name=="emp_payroll_complaint"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_payroll_comp($doc);			
		$this->load->view('app/transaction/form_view_emp_payroll_comp',$this->data);	
		}
		else if($t_table_name=="emp_medicine_reimburse"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_medicine_reimburse($doc);			
		$this->load->view('app/transaction/form_view_emp_medicine_reimburse',$this->data);	
		}
		else if($t_table_name=="emp_hdmf_cancellation"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_hdmf_cancel($doc);			
		$this->load->view('app/transaction/form_view_emp_hdmf_cancel',$this->data);	
		}
		else{
			redirect(base_url().'app/transaction_employees/index',$this->data);	
		}

	}	

	//== mass encode atro/change sched/change restday
	public function save_mass_encode(){
		$cd=date("Y-m-d h:i:sa");
	
		$t_table_name=$this->uri->segment('4');	// table name
		$the_form=urldecode($this->uri->segment('5'));	// form string
		$identification=urldecode($this->uri->segment('6'));// form identification
		$location=urldecode($this->uri->segment('7'));	//location
		$clas=urldecode($this->uri->segment('8')); //classification
		$dept=urldecode($this->uri->segment('9')); //department
		$sect=urldecode($this->uri->segment('10')); //section

		$date_from=urldecode($this->uri->segment('11'));
		$date_to=urldecode($this->uri->segment('12'));

		$begin = new DateTime( $date_from );
		$end   = new DateTime( $date_to );

	//== mass encode atro
if($t_table_name=="emp_atro"){

		$t_form = $this->transaction_employees_model->mass_tran_enc_rec($location,$clas,$dept,$sect);
		$array_edit="";
				if(!empty($t_form)){

		for($i = $begin; $begin <= $end; $i->modify('+1 day')){			
			$atro_date=$i->format("Y-m-d");
			// sunday
			$day_style = date('D', strtotime($atro_date)); 
				if($day_style=="Sun"){
						$IsSunday="1";
				}else{
						$IsSunday="0";
				}
			//holiday
			list($year, $month, $day) = explode("-", $atro_date);

			$holiday=$this->transaction_employees_model->validate_date($month,$day);
			if(!empty($holiday)){
						foreach($holiday as $getholiday){
						 $the_holiday=$getholiday->holiday;
						 $holiday_id=$getholiday->hol_id;
						 $holiday_type= $getholiday->code;
						}
					}else{
						$the_holiday="NONE";
						$holiday_id="NONE";
						$holiday_type="NONE";
					}

		foreach($t_form as $tran_form){

			$last_id=$this->transaction_employees_model->get_transaction_last_id($t_table_name);
				if($last_id->id==NULL){
					$LI="000000"; //LI : last id
				}else{
					$LI=$last_id->id;	//LI : last id
				}
			$array_edit.=$tran_form->name;
			$employee=$tran_form->employee_id;
			
			$emp_fn=$tran_form->first_name;
			$emp_mn=$tran_form->middle_name;
				// if($emp_mn==""){
				// 	$emp_mn="_";
				// }else{
				// 	$emp_mn=$tran_form->middle_name;
				// }
			$emp_ln=$tran_form->last_name;

			$fn=$emp_fn[0];
			$mn=$emp_mn[0];
			$ln=$emp_ln[0];

			//$classification=$tran_form->classification;
			$department=$tran_form->department;
			$section=$tran_form->section;

			$input_name=$tran_form->employee_id."_".$atro_date;
			$input_value=$this->input->post($input_name);

				$this->data = array(
					//'classification'				=>		$classification,
					'holiday'						=>		$the_holiday,
					'holiday_id'					=>		$holiday_id,
					'holiday_type'					=>		$holiday_type,
					'IsSunday'						=>		$IsSunday,
					'doc_no'						=>		$identification."_".$LI."_".$fn.$mn."_".$emp_ln,
					'department'					=>		$department,
					'section'						=>		$section,
					'remarks'						=>		'approved:still subject to actual time in/time out & shift schedule',
					'IsDeleted'						=>		'0',
					'InActive'						=>		'0',
					'atro_date'						=>		$atro_date,
					'no_of_hours'					=>		$input_value,
					'employee_id'					=>		$employee,
					'status'						=>		'approve',
					'date_created'					=>		$cd,
					'entry_type'					=>		'mass encoding: automatic overtime'
				);	

			$this->db->insert($t_table_name,$this->data);

		}//foreach employee
	}//for loop date
				}//not null records
					else{

					}	
}//== end mass encode atro
else if($t_table_name=="emp_change_sched"){
			$t_form = $this->transaction_employees_model->mass_tran_enc_rec($location,$clas,$dept,$sect);
		$array_edit="";
				if(!empty($t_form)){
for($i = $begin; $begin <= $end; $i->modify('+1 day')){			
			$atro_date=$i->format("Y-m-d");
			// sunday
			$day_style = date('D', strtotime($atro_date)); 
				if($day_style=="Sun"){
						$IsSunday="1";
				}else{
						$IsSunday="0";
				}
			//holiday
			list($year, $month, $day) = explode("-", $atro_date);

			$holiday=$this->transaction_employees_model->validate_date($month,$day);
			if(!empty($holiday)){
						foreach($holiday as $getholiday){
						 $the_holiday=$getholiday->holiday;
						 $holiday_id=$getholiday->hol_id;
						 $holiday_type= $getholiday->code;
						}
					}else{
						$the_holiday="NONE";
						$holiday_id="NONE";
						$holiday_type="NONE";
					}
		foreach($t_form as $tran_form){

			$last_id=$this->transaction_employees_model->get_transaction_last_id($t_table_name);
				if($last_id->id==NULL){
					$LI="000000"; //LI : last id
				}else{
					$LI=$last_id->id;	//LI : last id
				}
			$array_edit.=$tran_form->name;
			$employee=$tran_form->employee_id;
			
			$emp_fn=$tran_form->first_name;
			$emp_mn=$tran_form->middle_name;
				// if($emp_mn==""){
				// 	$emp_mn="_";
				// }else{
				// 	$emp_mn=$tran_form->middle_name;
				// }
			$emp_ln=$tran_form->last_name;

			$fn=$emp_fn[0];
			$mn=$emp_mn[0];
			$ln=$emp_ln[0];

			//$classification=$tran_form->classification;
			$department=$tran_form->department;
			$section=$tran_form->section;

			$input_name=$tran_form->employee_id."_".$atro_date;
			$input_value=$this->input->post($input_name);
			if (strpos($input_value, 'Rest day') !== false){ // if rest day 
				$time_from="";
				$time_to="";
				$rest_day="1";
			}else{
				$time_from=substr($input_value, 0,5);
				$time_to=substr($input_value, 5,5);
				$rest_day="0";
			}
				$this->data = array(
					'doc_no'						=>		$identification."_".$LI."_".$fn.$mn."_".$emp_ln,
					'remarks'						=>		'automatic approve',
					'IsDeleted'						=>		'0',
					'InActive'						=>		'0',
					'time_from'						=>		$time_from,
					'time_to'						=>		$time_to,
					'rest_day'						=>		$rest_day,
					'date_from'						=>		$atro_date,
					'date_to'						=>		$atro_date,
					'employee_id'					=>		$employee,
					'status'						=>		'approve',
					'date_created'					=>		$cd,
					'entry_type'					=>		'mass encoding: change schedule'
				);	

			$this->db->insert($t_table_name,$this->data);

		}//foreach employee
}//for loop
				}//not null records
					else{

					}
}else{}
			$value = $array_edit.",";
			General::logfile($the_form,'INSERT',$the_form);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Mass Encoding of ".$the_form."<strong> for ".$value."</strong> is Successfully Added!</div>");					
			
			redirect(base_url().'app/transaction_employees/index',$this->data);		
	}
}