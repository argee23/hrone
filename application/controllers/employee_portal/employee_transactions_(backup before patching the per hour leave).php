<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_transactions extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/employee_transactions_model");
		$this->load->model("employee_portal/employee_transactions_atro_model");
		$this->load->model("app/transaction_employees_model");
		$this->load->model("app/plot_schedules_model");
		$this->load->model("employee_portal/section_management_model");
		$this->load->model("employee_portal/employee_email_model");
		$this->load->model("employee_portal/employee_transactions_policy_model");
		General::variable();
	}

	public function index()
	{
		
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/transactions/index');
		$this->load->view('employee_portal/footer');		
	}

	public function transactions()
	{

		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/transactions/transactions');
		$this->load->view('employee_portal/footer');	
	}	

	public function get_active_transactions()
	{
		$data = $this->employee_transactions_model->getActiveTransactions();

		echo json_encode($data);
	}
	
	public function history($table = "")
	{
		$f = $this->employee_transactions_model->getIdentification($table);

		$this->data['setting'] = $f;
		$this->data['payrollPeriods'] = $this->employee_transactions_model->getPayrollPeriods();
		$this->data['table_name'] = $table;

		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/transactions_view/history', $this->data);
		$this->load->view('employee_portal/footer');	
	}
	public function test()
	{
		//echo var_dump($this->employee_transactions_model->get_day_details('2017-09-10'));
		echo var_dump($this->employee_transactions_model->is_enrolled_to_incentive());
	}

	public function formulate_file_name($form_name)
	{
		$file_name= 'attachment_'. $this->session->userdata('employee_id') . '_' .$form_name. '_'.date('YmdHis');
		return $file_name;
	}

	public function redirect_to($page)
	{
		
		$f = $this->employee_transactions_model->getIdentification($page);
		$form_name = $f->identification;
		$this->data['form_name'] = $f->identification;
		$this->data['setting'] = $f;
		$this->data['form_id'] = $f->id;
		$this->data['table_name'] = $page;
		$this->data['late_filing_type'] = $f->late_filing_type;
		$this->data['late_filing'] = $f->late_filing;


		$this->data['setting_attachment'] = $this->employee_transactions_model->get_transaction_setting($f->id,'TS3');
		$this->data['setting_required'] = $this->employee_transactions_model->get_transaction_setting($f->id,'TS4');

		$this->data["approvers"] = $this->employee_transactions_model->get_approvers($form_name);

		if ($f->IsUserDefine == 1)
		{

			$this->data['fields'] = $this->employee_transactions_model->get_transaction_fields($f->id);
			$this->data['name'] = $f->form_name;
			$this->data['id'] = $f->id;
			$this->load->view('employee_portal/transactions/user_defined', $this->data);
		}
		else
		{
			if ($page == 'employee_leave')
			{
				$il_leave_type = $this->employee_transactions_model->get_il_details();
				$this->data['incentive_leave_subject_approval'] = $this->employee_transactions_model->incentive_leave_subject_approval($this->session->userdata('employee_id'),$il_leave_type->id);
				//get system default incentive leave type details.
				$this->data['il_leave_type'] = $this->employee_transactions_model->get_il_details();
				//get incentive leave credits
				$this->data['incentive_leave'] = $this->employee_transactions_model->get_incentive_leave_credit($this->session->userdata('employee_id'),$il_leave_type->id);

				$this->data['salary_rate']= $this->employee_transactions_model->get_salary_rate();
				$this->data['leave_details'] = $this->employee_transactions_model->leave_details();
				$this->data['leaves'] = $this->employee_transactions_model->getLeaveTypes();
				$this->load->view('employee_portal/transactions/' . $page, $this->data);
			}
			else if ($page == 'emp_request_form')
			{
				$this->data['request_form'] = $this->employee_transactions_model->get_request_form_list();
				$this->load->view('employee_portal/transactions/' . $page, $this->data);
			}
			else if ($page == 'emp_loans')
			{
				$this->data['cutoff'] = $this->employee_transactions_model->cutoff();
				$this->data['pay_type'] = $this->employee_transactions_model->pay_type_details();
				$this->data['loanTypes'] = $this->employee_transactions_model->getLoanTypes();
				$this->load->view('employee_portal/transactions/' . $page, $this->data);
			}
			else if ($page == 'emp_authority_to_deduct')
			{
				$this->data['pay_type'] = $this->employee_transactions_model->check_paytype_list();
				$this->data['advanceTypes'] = $this->employee_transactions_model->getAdvanceTypes();
				$this->load->view('employee_portal/transactions/' . $page, $this->data);
			}
			else if($page == 'emp_trip_ticket')
			{
				$this->data['car_model'] = $this->employee_transactions_model->carmodel();
				$this->load->view('employee_portal/transactions/' . $page, $this->data);
			}

			else if ($page == 'emp_bap_claim')
			{
				$this->data['relationshipList'] = $this->employee_transactions_model->getRelationshipList();
				$this->data['religionList'] = $this->employee_transactions_model->getReligionList();
				$this->load->view('employee_portal/transactions/' . $page, $this->data);
			}
			else if  ($page == 'emp_hdmf_cancellation' || $page == 'emp_grocery_items_loan')
			{
				$this->data['payrollPeriods'] = $this->employee_transactions_model->getPayrollPeriods();
				$this->load->view('employee_portal/transactions/' . $page, $this->data);	
			}
			else if ($page == 'emp_change_rest_day')
			{
				$this->data['trans_late_filing_type'] = $this->employee_transactions_policy_model->get_transaction_policy($f->id,'TS2','none');
				$this->data['trans_late_filing'] = $this->employee_transactions_policy_model->get_transaction_policy($f->id,'TS1','none');

				$this->data['flexi_type'] = $this->employee_transactions_model->flexi_type($this->session->userdata('employee_id'));
				$this->data['payrollPeriods'] = $this->employee_transactions_model->getPayrollPeriods();
				$this->load->view('employee_portal/transactions/' . $page, $this->data);	
			}	
			else if ($page == 'emp_change_sched')
			{
			
				$this->data['flexi_type'] = $this->employee_transactions_model->flexi_type($this->session->userdata('employee_id'));
				$this->data['regular_shift'] = $this->employee_transactions_model->get_schedule_reference('working_schedule_ref_complete');
				$this->data['halfday_shift'] = $this->employee_transactions_model->get_schedule_reference('working_schedule_ref_half');
				$this->load->view('employee_portal/transactions/' . $page, $this->data);	
			}

			else if ($page == 'emp_atro')
			{
				$me = $this->employee_transactions_model->getInfo($this->session->userdata('id'));

				$this->data['limit'] = $this->employee_transactions_model->convert_limit($this->employee_transactions_model->get_time_setting(34));
				$this->data['incentive_enrollment'] = $this->employee_transactions_model->is_enrolled_to_incentive();
				$this->data['type_of_filing'] = $this->employee_transactions_model->get_time_setting(10);
				$this->data['minimum_overtime']	= $this->employee_transactions_model->get_time_setting_value(4, $me->classification, $me->employment);
				$this->data['advance_overtime']	= $this->employee_transactions_model->get_time_setting_value(6, $me->classification, $me->employment);
				$this->load->view('employee_portal/transactions/' . $page, $this->data);	
			}
			else if ($page == 'emp_payroll_complaint')
			{
				$this->data['payroll_period']= $this->employee_transactions_model->payroll_period();
				$this->data['payroll_complaint']= $this->employee_transactions_model->payroll_complaint_list();
				$this->load->view('employee_portal/transactions/' . $page, $this->data);
			}
			else if ($page == 'emp_under_time')
			{
				$this->data['max_hours'] = $this->employee_transactions_model->get_transaction_setting($f->id,'TS7');
				$this->load->view('employee_portal/transactions/' . $page, $this->data);
			}
			else if($page == 'employee_leave_cancel')
			{
				$cancellation_option= $this->employee_transactions_model->get_cancellation_option('employee_leave');
				$this->data['cancellation']=$cancellation_option;
				$this->data['get_leave'] = $this->employee_transactions_model->get_leave_pending($this->session->userdata('employee_id'),$cancellation_option->cancellation_option);
				$this->load->view('employee_portal/transactions/' . $page, $this->data);
			}
			else if($page == 'emp_time_complaint')
			{
				$this->data['allow_update'] = $this->employee_transactions_model->get_transaction_setting($f->id,'TS8');
				$this->load->view('employee_portal/transactions/' . $page, $this->data);
			}
			else if($page == 'emp_sss_cancellation')
			{
				$this->data['payrollPeriods'] = $this->employee_transactions_model->getPayrollPeriods();
				$this->load->view('employee_portal/transactions/' . $page, $this->data);
			}
			else {
				$this->load->view('employee_portal/transactions/' . $page, $this->data);
			}
		}
	}

	public function test2()
	{

		$filing = 'advance';

		$time_in = "09:30";
		$time_out = "23:11";

		$shift_in = "06:00";
		$shift_out = "15:00";

		if ($filing == 'late')
		{
			$actual = $this->get_actual_excess($shift_in, $time_out);
		}
		else if ($filing =='advance')
		{
			if ($this->detect_late())
			{
				$actual = $this->get_actual_excess($shift_in, $time_out);
			}
			else
			{
				$actual = $this->get_actual_excess($time_in, $time_out);
			}
		}

		$shift = $this->get_actual_excess($shift_in, $shift_out);
		
		$e = $actual - $shift;

		echo "<b> and the final calculation is : </b>" . $e;
		echo "<b> and another is : </b>" . $this->calculate_the_difference_between();
	}

	public function detect_late()
	{
		$shift_in = "23:00";
		$time_in = "00:55";


		$date_in = "2017-08-16";
		$date_selected = "2017-08-15";

		$start = new DateTime($date_selected . " " . $shift_in);
		$actual = new DateTime($date_in . " " . $time_in);

		echo "SHIFT: " . $start->format('Y-m-d H:i:s') . " <br> ";
		echo "ACTUAL: " .$actual->format('Y-m-d H:i:s') . " <br> ";

		if ($actual <= $start)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function calculate_the_difference_between()
	{
		$time_out = "23:11";
		$shift_out = "15:00";
		list($hour1, $minute1) = explode(':', $shift_out);
		list($hour2, $minute2) = explode(':', $time_out);

		$hr=0;
		for ($i=$hour1; $i != $hour2;$i++)
		{
			if ($i==24)
			{
				$i = 0;
			}

			$hr++;
		}

		return ($hr * 60) + $minute2;
	}

	public function get_actual_excess($time_in, $time_out)
	{
		$actual = 0;
		$max_hour = 0;
		$max_minute = 0;

		list($hour1, $minute1) = explode(':', $time_in);
		list($hour2, $minute2) = explode(':', $time_out);

		$hours = 0;

		for ($i=$hour1; $i != $hour2; $i++)
		{
			if ($i == 24)
			{
				$i = 0; //Back to 24
			}

			$hours++;
		}

		//$hbm = ( ((($hours * 60) + $minute2) - $minute1) /  60 ) - 8;
		$hbm = ( ($hours * 60) + $minute2) - $minute1;

		echo "==============================================<br>";
		echo "Total excess: " . $hours . " <br> ";
		echo "Total excess by minutes: " . $hbm . " <br> ";

		echo "Hour 1: " . $hour1 . " <br> ";
		echo "Min 1: " . $minute1 . " <br> ";
		echo "Hour 2: " . $hour2 . " <br> ";
		echo "Min 2: " . $minute2 . " <br> ";
		echo "==============================================<br>";
		return $hbm;

	}

	public function fetch($page)
	{
		$this->data['payrollPeriods'] = $this->employee_transactions_model->getPayrollPeriods();
			
		if($page=='filter_all_forms')
		{
			$this->load->view('employee_portal/transactions_view/all_forms', $this->data);
		}
		else
		{
			$f = $this->employee_transactions_model->getIdentification($page);
			$this->db->where('identification',$f->identification);
			$query1= $this->db->get('transaction_file_maintenance');
			$this->data['table_name'] = $query1->row('t_table_name');
			$this->data['form_name'] =	$f->identification;
			$this->data['name'] =	$f->form_name;
			$this->data['t_id'] =	$f->id;
			$this->data['identification'] = $f->identification;
			$this->data['transList'] = $this->employee_transactions_model->getEmployeeTransactions($this->data['table_name']);
			
			if ($f->IsUserDefine == 1)
			{
				$this->data['name'] = $f->form_name;
				$this->load->view('employee_portal/transactions_view/user_defined', $this->data);
			}
			
			else
			{
			$this->load->view('employee_portal/transactions_view/content', $this->data);
			}	

		}
	
	}

public function get_filed_in_between($payroll_period, $status, $tbl , $form_name , $option , $date_from , $date_to)
	{	
		if($tbl=='All')
		{
			$this->data['payroll_period']=$payroll_period;
			$this->data['status']=$status;
			$this->data['option']=$option;
			$this->data['date_from']=$date_from;
			$this->data['date_to']=$date_to;
			$this->load->view('employee_portal/transactions_view/filter_all_forms', $this->data);
		}
		else
		{	
			$f = $this->employee_transactions_model->getIdentification($tbl);
			$this->data['identification'] = $f->identification;
			$this->data['table_name']=$tbl;
			$this->data['form_name']=$form_name;
			$this->data['transList'] = $this->employee_transactions_model->getFiledTransactionsfilter($tbl,$payroll_period,$status,$option,$date_from,$date_to);
			$this->load->view('employee_portal/transactions_view/history', $this->data);
		}
		
	}

	public function cancel_transaction($table_name, $doc_no)
	{
		  $this->employee_transactions_model->cancel_transaction($table_name, $doc_no);
		  $this->session->set_flashdata('feedback', 'You have succesfully cancelled the document: ' . $doc_no . '.');
		  redirect('employee_portal/employee_transactions/transactions/#' . $table_name);
	}

	public function view($doc_no, $table_name, $identification)
	{
		$doc=$doc_no;
		$t_table_name=$table_name;
		$this->data["companyInfo"] = $this->employee_transactions_model->get_company_info();
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
		else if($t_table_name=="emp_sss_cancellation"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_sss_cancel($doc);			
		$this->load->view('app/transaction/form_view_emp_sss_cancel',$this->data);	
		}
		else if($t_table_name==$table_name)
		{
			$this->db->where('identification',$identification);
			$query = $this->db->get('transaction_file_maintenance');
			$n = $query->row('form_name');
			$this->data['name']=$n;
			$this->data['file'] = $this->transaction_employees_model->form_view_emp_user_define($doc,$table_name);			
			$this->load->view('app/transaction/form_view_emp_user_define',$this->data);	
		}
	}

	public function upload_file($folder, $file_name)
	{
		$config = array(
			'upload_path' => './public/transactions_attached/' . $folder . '/',
			'allowed_types' => 'gif|jpg|png|PNG|GIF|JPG|PDF|pdf',
			'max_size' => 500,
			'file_name' =>	$file_name
		);

		$filename = "";
		$this->load->library('upload', $config);

		$required = $this->input->post('required');

		if ($required == 1)
		{
			if($this->upload->do_upload('file_attached'))
			{
				$data = $this->upload->data();
				$filename = $data['file_name'];
			}
			else
			{
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('error', $error['error']);
                redirect('employee_portal/employee_transactions/#' . $folder);
			}		
		}
		else
		{
			if ($_FILES['file_attached']['error'] !== 4) //
			{
				if($this->upload->do_upload('file_attached'))
				{
					$data = $this->upload->data();
					$filename = $data['file_name'];
				}	
				else{
					
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('error', $error['error']);
	                redirect('employee_portal/employee_transactions/#' . $folder);
				}	
			}
			else{

			}
		}
		return $filename;
	}

	// ADD FORM SUBMISSIONS
	public function add_medical_reimbursement()
	{
		$folder = $this->input->post('table_name');

		$this->form_validation->set_rules('amount', 'AMOUNT', 'trim|required');
		$this->form_validation->set_rules('med_for', 'MEDICATION FOR', 'trim|required');


		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#' . $folder);
        }
        else
        {
			$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}	

        	$this->employee_transactions_model->add_medical_reimbursement($filename);
	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Purchashed Medical Reimbursement request.');
	        redirect('employee_portal/employee_transactions/#'); 
				
        }
	}

	public function add_atro()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('atro_date', 'Date', 'trim|required');
		$this->form_validation->set_rules('myDecimal', 'Number of Hours', 'trim|required');
		$this->form_validation->set_rules('optradio', 'ATRO Conversion', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_atro');
        }
        else
        {
        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

        	$this->employee_transactions_model->add_atro($filename);

	        $this->session->set_flashdata('feedback', 'You have succesfully added a new ATRO request.');
	        redirect('employee_portal/employee_transactions/#emp_atro');
        }
	}

	public function add_call_out()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('date', 'Call Out Date', 'trim|required');
		$this->form_validation->set_rules('time_in', ' Call Out Time In', 'trim|required');
		$this->form_validation->set_rules('time_out', ' Call Out Time Out', 'trim|required');
		$this->form_validation->set_rules('time_in_date', 'Call Out Time In Date', 'trim|required');
		$this->form_validation->set_rules('time_out_date', 'Call Out Time Out Date', 'trim|required');
		$this->form_validation->set_rules('reason', 'Reason', 'trim|required');


		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_call_out');
        }
        else
        {
        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

        	$this->employee_transactions_model->add_call_out($filename);

	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Call Out request.');
	        redirect('employee_portal/employee_transactions/#emp_call_out');
        }
	}


	public function add_emp_request()
	{
		
		$final_request = $this->input->post('final_request');

		$others = $this->input->post('others');
		$reason = $this->input->post('reason');

		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('reason', 'Reason', 'trim|required');
		$this->form_validation->set_rules('employment', 'Employment Period', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_request_form');
        }
        else
        {
        	if($final_request=='' AND $others=='')
        	{
        		$this->session->set_flashdata('error', 'Select or Input Atleast one request.');
            	redirect('employee_portal/employee_transactions/#emp_request_form');
        	}
        	else
        	{
        		$form_name = $this->input->post('form_name');
				$file_name = $this->formulate_file_name($form_name);

				$filename = null;

				if ($this->input->post('attach_file') == 1) 
				{
					$filename = $this->upload_file($folder, $file_name);	
				}

	        	$this->employee_transactions_model->add_request_form($filename);

		        $this->session->set_flashdata('feedback', 'You have succesfully added a new Employee request.');
		      redirect('employee_portal/employee_transactions/#emp_request_form');
        	}
        }
	}

	public function add_trip_ticket()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('purpose', 'Purpose', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_trip_ticket');
        }
        else
        {
        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

        	$this->employee_transactions_model->add_trip_ticket($filename);

	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Trip Ticket Request.');
	        redirect('employee_portal/employee_transactions/#emp_trip_ticket');
        }
	}

	public function add_payroll_complaint()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('data_title', $data_title, 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_payroll_complaint');
        }
        else
        {
        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);
			$filename = null;
			
			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

        	$this->employee_transactions_model->add_payroll_complaint($filename);
	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Payroll Complaint request.');
	       

	        redirect('employee_portal/employee_transactions/#emp_payroll_complaint');
        }
	}


	public function add_loan()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('loan_amount', 'LOAN AMOUNT', 'trim|required');
		$this->form_validation->set_rules('deduction', 'REQUESTED SCHEDULE DEDUCTION', 'trim|required');
		$this->form_validation->set_rules('amortization', 'AMORTIZATION', 'trim|required');
		$this->form_validation->set_rules('date_granted', 'DATE GRANTED', 'trim|required');
		$this->form_validation->set_rules('loan_type', 'LOAN TYPE OPTION', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_loans');
        }
        else
        {
        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

        	$this->employee_transactions_model->add_loan($filename);

	        $this->session->set_flashdata('feedback', 'You have succesfully added a new LOAN request.');
	        redirect('employee_portal/employee_transactions/#emp_loans');
        }
	}

	public function add_authority_to_deduct()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('amount_of_advance', 'ADVANCE AMOUNT', 'trim|required');
		$this->form_validation->set_rules('type_of_advance', 'ADVANCE TYPE', 'trim|required');
		$this->form_validation->set_rules('deduction_start', 'DEDUCTION START DATE', 'trim|required');
		$this->form_validation->set_rules('deduction_amount', 'DEDUCTION AMOUNT', 'trim|required');
		$this->form_validation->set_rules('deduction_type', 'DEDUCTION TYPE', 'trim|required');
		$this->form_validation->set_rules('monthly_amortization', 'MONTHLY AMORTIZATION AMOUNT', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_authority_to_deduct');
        }
        else
        {
        	$this->employee_transactions_model->add_authority_to_deduct();
	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Authority to Deduct request.');
	        redirect('employee_portal/employee_transactions/#emp_authority_to_deduct');
        }
	}

	public function add_sworn()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('no_of_dependents', 'Number of Dependents', 'trim|required');
		$this->form_validation->set_rules('name_of_wife', 'Name of Spouse', 'trim|required');
		$this->form_validation->set_rules('employer_name', 'Name of Employer', 'trim|required');
		$this->form_validation->set_rules('employer_address', 'Employer Address', 'trim|required');
		$this->form_validation->set_rules('taxable_year', 'Taxable Year', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_sworn_declaration');
        }
        else
        {
        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

        	$this->employee_transactions_model->add_sworn($filename);

	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Sworn Declaration request.');
	        redirect('employee_portal/employee_transactions/#emp_sworn_declaration');
        }
	}

	public function add_bap()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('deceased_name', 'Name of the Deceased', 'trim|required');
		$this->form_validation->set_rules('deceased_bdate', 'Birthday of the Deceased', 'trim|required');
		$this->form_validation->set_rules('relation_to_claimant', 'Relationship with the Deceased', 'trim|required');
		$this->form_validation->set_rules('death_date', 'Date of Death of the Deceased', 'trim|required');
		$this->form_validation->set_rules('burial_date', 'Date of Burial', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_bap_claim');
        }
        else
        {
        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

        	$this->employee_transactions_model->add_bap($filename);

	        $this->session->set_flashdata('feedback', 'You have succesfully added a new BAP Claim request.');
	        redirect('employee_portal/employee_transactions/#emp_bap_claim');
        }
	}

	public function add_gatepass()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('destination', 'Destination', 'trim|required');
		$this->form_validation->set_rules('time_in', 'Time IN', 'trim|required');
		$this->form_validation->set_rules('time_out', 'Time OUT', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_gate_pass');
        }
        else
        {
        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

        	$this->employee_transactions_model->add_gatepass($filename);

	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Gate Pass request.');
	        redirect('employee_portal/employee_transactions/#emp_gate_pass');
        }
	}

	public function add_grievance()
	{

		//Check if time is valid
		$folder = $this->input->post('table_name');
		$form_name = $this->input->post('form_name');
		$file_name = $this->formulate_file_name($form_name);

		$filename = null;

		if ($this->input->post('attach_file') == 1) 
		{
			$filename = $this->upload_file($folder, $file_name);	
		}
		$this->employee_transactions_model->add_grievance($filename);

	    $this->session->set_flashdata('feedback', 'You have succesfully added a new Grievance request.');
	    redirect('employee_portal/employee_transactions/#emp_grievance_request');
	}

	public function add_undertime()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('date_ut', 'Undertime Date', 'trim|required');
		$this->form_validation->set_rules('hours', 'Number of hours', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_under_time');
        }
        else
        {
        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

        	$this->employee_transactions_model->add_undertime($filename);

	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Under Time request.');
	        redirect('employee_portal/employee_transactions/#emp_under_time');
        }
	}

	public function add_paternity()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('spouse_name', 'Name of Spouse', 'trim|required');
		$this->form_validation->set_rules('spouse_address', 'Address of the Spouse', 'trim|required');
		$this->form_validation->set_rules('give_birth_date', 'Delivery Date', 'trim|required');

		$this->form_validation->set_rules('child_level', 'Child Level', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_paternity_notif');
        }
        else
        {
        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

        	$this->employee_transactions_model->add_paternity($filename);

	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Paternity Notification request.');
	        redirect('employee_portal/employee_transactions/#emp_paternity_notif');
	    }
	}

	public function add_tk()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('time_in', 'Time IN', 'trim|required');
		$this->form_validation->set_rules('time_out', 'Time OUT', 'trim|required');
		$this->form_validation->set_rules('time_out_date', 'Time OUT date', 'trim|required');
		$this->form_validation->set_rules('time_in_date', 'Time IN date', 'trim|required');
		$this->form_validation->set_rules('reason', 'Reason', 'trim|required');

		$time_in = $this->validate_time($this->input->post('time_in'));
		$time_in = $this->validate_time($this->input->post('time_out'));

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_time_complaint');
        }
        else
        {
        	if($time_in===false)
        	{
        		$this->session->set_flashdata('feedback', 'Invalid Time In format');	
        	}
        	else if($time_out===false)
        	{
        		$this->session->set_flashdata('feedback', 'Invalid Time Out format');	
        	}
        	else
        	{
        		$form_name = $this->input->post('form_name');
				$file_name = $this->formulate_file_name($form_name);

				$filename = null;

				if ($this->input->post('attach_file') == 1) 
				{
					$filename = $this->upload_file($folder, $file_name);	
				}

	        	$this->employee_transactions_model->add_tk($filename);

		        $this->session->set_flashdata('feedback', 'You have succesfully added a new Time Keeping Complaint request.');	
        	}
        	
	        redirect('employee_portal/employee_transactions/#emp_time_complaint');
	    }

	}

	public function add_cancel_hdmf()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('payroll_period', 'Payroll Period', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_hdmf_cancellation');
        }
        else
        {
        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

        	$this->employee_transactions_model->add_cancel_hdmf($filename);

	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Cancellation of HDMF Loan Payment request.');
	        redirect('employee_portal/employee_transactions/#emp_hdmf_cancellation');
	    }

	}

	public function add_change_restday()
	{
		$this->form_validation->set_rules('rest_day', 'Original Rest Day date', 'trim|required');
		$this->form_validation->set_rules('new_restday', 'New Rest Day date', 'trim|required');
		$folder = $this->input->post('table_name');
		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_change_rest_day');
        }
        else
        {
        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

        	$this->employee_transactions_model->add_change_restday($filename);

	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Change of Rest Day request.');
	        redirect('employee_portal/employee_transactions/#emp_change_rest_day');
	    }

	}

	public function add_ob()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
		$this->form_validation->set_rules('company_address', 'Company Address', 'trim|required');
		$this->form_validation->set_rules('from_date', 'Date from', 'trim|required');
		$this->form_validation->set_rules('to_date', 'Date To', 'trim|required');
		$this->form_validation->set_rules('from_time', 'Time From', 'trim|required');
		$this->form_validation->set_rules('to_time', 'Time To', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_official_business');
        }
        else
        {
        	if (empty($this->input->post('dates')))
			{
				$this->session->set_flashdata('error', "Unable to create form. You need to select atleast 1 inclusive day.");
				redirect('employee_portal/employee_transactions/#emp_official_business');
			}

			if (!$this->checkDates($this->input->post('from_date'), $this->input->post('to_date')))
			{
				$this->session->set_flashdata('error', "Unable to create form. 'date from' must be before 'date to'.");
				redirect('employee_portal/employee_transactions/#emp_official_business');
			}

			$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

        	$this->employee_transactions_model->add_ob($filename);
	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Official Business (OB) request.');
	        redirect('employee_portal/employee_transactions/#emp_official_business');
	    }

	}

	public function add_leave()
	{
		$folder = $this->input->post('table_name');
		$leave_type = $this->input->post('leavetype_');
		$available = $this->input->post('available_l');
		if($this->input->post('count')==1) { $count_days = 	$this->input->post('halfday_val'); }
		else { $count_days  = count($this->input->post('dates')); }

		$this->form_validation->set_rules('from_date', 'Date from', 'trim|required');
		$this->form_validation->set_rules('to_date', 'Date To', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#employee_leave');
        }
        else
        {
        	if ($available > 0 AND $available < $count_days)
        	{
        		$this->session->set_flashdata('error', 'You filed '.$count_days.' days ,not enough credits.Please file '.$available.' day/s only.');
        		redirect('employee_portal/employee_transactions/#employee_leave');
        	}
        	else
        	{
			        	if (empty($this->input->post('dates')))
						{
							$this->session->set_flashdata('error', "Unable to create form. You need to select atleast 1 inclusive day.");
							redirect('employee_portal/employee_transactions/#employee_leave');
						}

						if (!$this->checkDates($this->input->post('from_date'), $this->input->post('to_date')))
						{
							$this->session->set_flashdata('error', "Unable to create form. 'date from' must be before 'date to'.");
							redirect('employee_portal/employee_transactions/#employee_leave');
						}

						$form_name = $this->input->post('form_name');
						$file_name = $this->formulate_file_name($form_name);

						$filename = null;

						if ($this->input->post('attach_file') == 1) 
						{
							$filename = $this->upload_file($folder, $file_name);	
						}


			        	$this->employee_transactions_model->add_leave($filename);
				        $this->session->set_flashdata('feedback', 'You have succesfully added a new Leave request.');
				        redirect('employee_portal/employee_transactions/#employee_leave');
			}
	    }

	}



	public function add_leave_cancel()
	{
		$folder = $this->input->post('table_name');

		$this->form_validation->set_rules('reason', 'Reason', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/employee_leave_cancel');
        }
        else
        {

        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);
			
			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}


        	$this->employee_transactions_model->add_leave_cancel($filename);
	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Cancel Leave request.');
	      redirect('employee_portal/employee_transactions/#employee_leave_cancel');
	    }

	}

	public function add_change_sched()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('date_from', 'Date from', 'trim|required');
		$this->form_validation->set_rules('date_to', 'Date To', 'trim|required');
		$this->form_validation->set_rules('time_to', 'New Time/Working Schedule', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_official_business');
        }
        else
        {
        	if (empty($this->input->post('dates')))
			{
				$this->session->set_flashdata('error', "Unable to create form. You need to select atleast 1 inclusive day.");
				redirect('employee_portal/employee_transactions/#emp_change_sched');
			}

			if (!$this->checkDates($this->input->post('date_from'), $this->input->post('date_to')))
			{
				$this->session->set_flashdata('error', "Unable to create form. 'date from' must be before 'date to'.");
				redirect('employee_portal/employee_transactions/#emp_change_sched');
			}

			$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}


        	$this->employee_transactions_model->add_change_sched($filename);
	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Change of Working Schedule request.');
	        redirect('employee_portal/employee_transactions/#emp_change_sched');
	    }
	}

	public function add_grocery()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('grocery_items_worth', 'Total worth of Grocery Items', 'trim|required');
		$this->form_validation->set_rules('net_pay', 'Net Pay', 'trim|required');
		$this->form_validation->set_rules('coop_balance', 'Coop Balance', 'trim|required');
		$this->form_validation->set_rules('last_payroll_period', 'Payroll Period', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_grocery_items_loan');
        }
        else
        {
        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}
        	$this->employee_transactions_model->add_grocery($form_name);

	        $this->session->set_flashdata('feedback', 'You have succesfully added a new Grocery Item Loan request.');
	        redirect('employee_portal/employee_transactions/#emp_grocery_items_loan');
	    }
	}

	public function add_user_defined()
	{
		$this->employee_transactions_model->add_user_defined();
		$this->session->set_flashdata('feedback', 'You have succesfully added a new ' . $this->input->post('name') . ' request.');
	    redirect('employee_portal/employee_transactions/#' . $this->input->post('tablename'));
	}

	public function hahaa()
	{
		$ne = '2017-07-05';
		$fe = strtotime($ne);

		 $m =  date("m", strtotime($ne));
		 $d = date("d", strtotime($ne));
		 $y = date("Y", strtotime($ne));

		 echo $m . '*' . $d . '*'. $y;

	}

	public function checkDay()
	{
		$date = $this->input->post('date');
		$type = $this->input->post('type');

		// $date = "2017-08-14";
		// $type="leave";

		if ($type == 'holiday')
		{
			$data = $this->employee_transactions_model->is_holiday($date);
			echo $data;
		}
		else if ($type == 'rest_day')
		{
			$data = $this->employee_transactions_model->is_restday($date);
			echo json_encode($data);
		}
		else if ($type == 'leave') {
			$data = $this->employee_transactions_model->has_leave($date);
			echo $data;
		}
		

	}

	public function get_schedules($start, $end , $leave, $table_id)
	{
		$data = $this->employee_transactions_model->get_schedules($start, $end , $leave, $table_id);
		echo json_encode($data);
	}

	
	public function checkDates($dateStart, $dateEnd)
	{
		if ($dateEnd) //If date end is not null
		{
			$start = strtotime($dateStart);
			$end = strtotime($dateEnd);

			if ($start > $end)
			{
				return false;
			}
			else {
				return true;
			}
		}
		else
		{
			return true;
		}
	}

	public function getRestDays($payroll_period_id)
	{
		$data = $this->employee_transactions_model->getRestDays($payroll_period_id);
		echo json_encode($data);
	}

	public function get_attendance($date)
	{
		$data = $this->employee_transactions_model->get_day($date);
		echo json_encode($data);
	}

	public function get_day_details($date)
	{
		$filing_type = $this->employee_transactions_atro_model->get_time_setting(10); 
		$filing_type_gen = $this->employee_transactions_atro_model->get_time_setting_gen(10);

		
			
			if($filing_type=='late')
			{
				$data = $this->employee_transactions_atro_model->get_day_atro_details_late_filing($date,$filing_type,$filing_type_gen);
			}
			else if($filing_type=='pre_approve')
			{
				$data = $this->employee_transactions_atro_model->get_day_atro_details_preapproved_filing($date,$filing_type,$filing_type_gen);
			}
			else if($filing_type=='advance')
			{
				$data = $this->employee_transactions_atro_model->get_day_atro_details_advance_filing($date,$filing_type,$filing_type_gen);
			}
			else
			{
				$get_group_policy_type_checker = $this->employee_transactions_model->get_group_policy_type_checker();
				$get_group_policy_type = $this->employee_transactions_model->get_group_policy_type();
						
					if($get_group_policy_type_checker==0)
					{
							$data = $this->employee_transactions_atro_model->no_atro_group($date,$filing_type,$filing_type_gen);
					}
					else
					{
							$policyt = $get_group_policy_type->cValue;
							if($policyt=='Late Filing')
							{
								$data = $this->employee_transactions_atro_model->get_day_atro_details_late_filing($date,$filing_type,$filing_type_gen);
							}
							else if($policyt=='Pre Approved')
							{
								$data = $this->employee_transactions_atro_model->get_day_atro_details_preapproved_filing($date,$filing_type,$filing_type_gen);
							}
							else
							{
								$data = $this->employee_transactions_atro_model->get_day_atro_details_advance_filing($date,$filing_type,$filing_type_gen);
							}
					}	
			}
		
		echo json_encode($data);	
		
	}

	public function check_late_filing($start,$end,$id)
	{
		$data = $this->employee_transactions_model->check_late_filing($start,$end,$id);
		echo json_encode($data);
	}
	


	public function see()
	{
		$d1=new DateTime("2017-08-20 09:00");
		$d2=new DateTime("2017-08-20 18:00");
		$diff=$d2->diff($d1);

		$days = $diff->format('%d');
		$hours = $diff->format('%h');
		$min = $diff->format('%i');

		for ($i = 0; $i < $days; $i++)
		{
			$hours = $hours + 24;
		}

		$converted_min = $min / 60;

		$hours = $hours + $converted_min;
		$hours = $hours - 1; //This is for lunch break

		echo $hours;

	}




	public function get_platenumber($id)
	{
		$platenumber = $this->employee_transactions_model->get_platenumber($id);
		if(empty($platenumber)){ echo "<option value=''> No plate number found. Please add to continue.</option>"; }
		else
		{
			echo "<option>Select Car Plate Number</option>";
			foreach ($platenumber as $p) {
				echo "<option value='".$p->car_platenumber."'>".$p->car_platenumber."</option>";
			}
		}
	}

	public function check_restday_filing()
	{
		$date = $this->input->post('date');
		$form_id = $this->input->post('form_id');
		$late_filing_type = $this->input->post('late_filing_type');
		$late_filing = $this->input->post('late_filing');
		$company_id = $this->session->userdata('company_id');
		
		$result="";
		if($late_filing_type=='prior_to_the_affected_date')
		{
			$dates = date('Y-m-d');
			$file_date = date('Y-m-d', strtotime($date. ' + '.$late_filing.' days'));
			if($dates > $file_date){  $result = 'false'; }  else { $result = 'true'; }

		}
		elseif($late_filing_type=='prior_to_paydate_of_payroll_period')
		{
			$dates = date('Y-m-d');
			$yy = date("Y", strtotime($date));
			$mm = date("m", strtotime($date));
			$employee_id = $this->session->userdata('employee_id');
			$group_id = $this->get_payroll_period_id($employee_id);
			$pay_date = $this->get_payrollperiod($group_id,$date);
			if(empty($pay_date)){ $result = true; }		
			else{ 	
					$file_date = date('Y-m-d', strtotime($pay_date. ' - '.$late_filing.' days'));
					if($dates > $file_date)  {  $result = 'false'; }
					else { $result = 'true'; }
				}
						
		
		}
		echo json_encode($result);
	}

		public function tk_get_attendance_in($date,$option,$allow_update)
	{
		$m =  date("m", strtotime($date));
		$employee_id = $this->session->userdata('employee_id');
		$result = $this->employee_transactions_model->tk_get_attendance($date,$option,$m,$employee_id);
		if($allow_update=='yes'){ $r = ''; } else{ $r='disabled'; }

		echo "<input type='text' class='form-control'  value='".$result."' name='".$option."' placeholder='24 hour format ex. 13:00 for 1PM' 
		onchange='validateHhMm(this);' id='time_in_time' required ".$r.">";
		
		

	}
	public function tk_get_attendance_out($date,$option,$allow_update)
	{
		$m =  date("m", strtotime($date));
		$employee_id = $this->session->userdata('employee_id');
		$result = $this->employee_transactions_model->tk_get_attendance($date,$option,$m,$employee_id);
		if($allow_update=='yes'){ $r = ''; } else{ $r='disabled'; }
		
			echo "<input type='text' class='form-control'  value='".$result."' name='".$option."' placeholder='24 hour format ex. 13:00 for 1PM' 
			onchange='validateHhMm(this);' id='time_out_time' required ".$r.">";	
		
		
	}

	//new added code for emp_loans / 06-11-2018

	public function get_active_loans($loan)
	{
		$get_active_loans = $this->employee_transactions_model->get_active_loans($loan);

		if(empty($get_active_loans))
		{
			echo "<option value='' disabled selected>No Active loans found.</option>";
		}
		else
		{
			echo "<option value='' disabled selected>Select Active Loans</option>";
			foreach($get_active_loans as $active)
			{
				if(empty($active->loan_amt)){ $amt = $active->loan_amt; }
				else { $amt = number_format($active->loan_amt); }
				echo "<option value='".$active->emp_loan_id."'>".$active->loan_type." with loan amount of ".$amt." / date granted ".$active->date_granted." / date effective ".$active->date_effective."</option>";
			}
			
		}
		
	}
	
	// END ADD FORM SUBMISSIONS

	
	public function attachment_required($leave_id)
	{
		$setting_attachment = $this->employee_transactions_model->get_transaction_setting_leave(2,'TS3',$leave_id);
		$setting_required = $this->employee_transactions_model->get_transaction_setting_leave(2,'TS4',$leave_id);
		$required = '';
		if($setting_attachment=='yes')
		{
			 if ($setting_required == 'yes')
			    {
			        $required = 'required';
			        $req = 1;
			    }
		?>
	
		  <label class="control-label col-sm-2" for="email">File Attachment</label>
          <div class="col-sm-10">
              <input type="file"  id="file_attached" name="file_attached" <?php echo $required;?>>
              <div class="help-block with-errors"><span class="text-danger"> <small><i>Accepted Files: PNG, JPG, GIF, PDF | File size must not exceed 500 KB</i></small></span>
          </div>

	<?php } ?>
		   <input type="hidden" name="required" value="<?php if($setting_required=='yes'){ echo 1; } else{ echo 0; } ?>">
		   <input type="hidden" name="attach_file" value="<?php if($setting_attachment=='yes'){ echo 1; } else{ echo 0; } ?>">
	<?php }



	//time validation checker

	public function validate_time($time)
	{
		if(strtotime($time)) {
			$length =  strlen($time);
			if($length==5)
			{
           		return true;
			}
			else
			{
				return false;
			}
        } else {
           return false;
        }
	}

	//sss cancellation

	public function add_cancel_sss()
	{
		$folder = $this->input->post('table_name');
		$this->form_validation->set_rules('payroll_period', 'Payroll Period', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_transactions/#emp_sss_cancellation');
        }
        else
        {
        	$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			$filename = null;

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

        	$this->employee_transactions_model->add_cancel_sss($filename);

	        $this->session->set_flashdata('feedback', 'You have succesfully added a new SSS Cancellation request.');
	        redirect('employee_portal/employee_transactions/#emp_sss_cancellation');
	    }

	}


	
	//viewing applied leave

	public function get_leave_details($id)
	{
		$this->data['leave_type_id'] = $id;
		$this->data['leave_type_name'] = $this->employee_transactions_model->leave_type_name($id);
		$this->data['incentive_leave'] = $this->employee_transactions_model->get_incentive_leave_credit($this->session->userdata('employee_id'),$id);
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/transactions/apply_leave_details', $this->data);
		$this->load->view('employee_portal/footer');	
	}

}