<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_transactions_leave_compress extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/employee_transactions_model");
		$this->load->model("employee_portal/employee_transactions_atro_model");
		$this->load->model("app/transaction_employees_model");
		$this->load->model("app/plot_schedules_model");
		$this->load->model("employee_portal/section_management_model");
		$this->load->model("employee_portal/employee_email_model");
		$this->load->model("employee_portal/employee_transactions_policy_model");
		$this->load->model("employee_portal/employee_transactions_leave_compress_model");
		
		General::variable();
	}
	
	//compress
	public function get_leave_compress($start, $end , $leave, $table_id ,$available)
	{	
		$this->data['start'] = $start;
		$this->data['end'] = $end;
		$this->data['leave'] = $leave;
		$this->data['leave_type_id'] = $leave;
		$this->data['table_id'] = $table_id;
		$this->data['available'] = $available;
		$this->data['minimum_per_hour']  = $this->employee_transactions_leave_compress_model->minimum_per_hour();
		$this->load->view('employee_portal/transactions/compress_leave/compress_leave_details', $this->data);
	}

	
	public function hour_minutes($type,$i)
	{
		if($type=='per_hour')
		{
			$allowed_per_hour = $this->employee_transactions_leave_compress_model->get_allowed_per_hour_leave_filing();
			if(empty($allowed_per_hour))
			{?>

				<input type="text" class="form-control" style="margin-top: 5px;" placeholder="Hours" id="hh<?php echo $i;?>" min="0" onkeypress="return isNumberKey(this, event);" onkeyup="checker_minutes_hours('<?php echo $i;?>');" name="hh<?php echo $i;?>" required>
                <input type="text" class="form-control" style="margin-top: 5px;" placeholder="Minutes" id="mm<?php echo $i;?>"  min="0" onkeypress="return isNumberKey(this, event);" onkeyup="checker_minutes_hours('<?php echo $i;?>');" name="mm<?php echo $i;?>" required>
                <input type="hidden" id="with_allowed_per_hr" value="0">


			<?php }
			else
			{

		?>

                <select class="form-control" style="margin-top: 5px;"  id="allowed<?php echo $i;?>"  onchange="checker_allowed_hours('<?php echo $i;?>',this.value);" name="allowed<?php echo $i;?>" required>
						<option value="" disabled selected>Select</option>
						<?php foreach($allowed_per_hour as $p){?>
							<option value="<?php echo $p->total;?>"><?php echo $p->total;?></option>
						<?php } ?>
				</select>

				<input type="hidden" id="with_allowed_per_hr" value="1">


		<?php 
			}
		}
		else
		{?>	
				<input type="hidden" id="hh<?php echo $i;?>"  name="hh<?php echo $i;?>">
                <input type="hidden" class="form-control"  id="mm<?php echo $i;?>" name="mm<?php echo $i;?>">
                <input type="hidden" id="with_allowed_per_hr" value="0">

		<?php }
	}

	public function add_leave_per_hour()
	{		
			$filename="";
			$folder = $this->input->post('table_name');
			$form_name = $this->input->post('form_name');
			$file_name = $this->formulate_file_name($form_name);

			if ($this->input->post('attach_file') == 1) 
			{
				$filename = $this->upload_file($folder, $file_name);	
			}

			$insert = $this->employee_transactions_leave_compress_model->add_leave_per_hour();
			$this->session->set_flashdata('feedback', 'You have succesfully added a new Leave request.');
			redirect('employee_portal/employee_transactions/#employee_leave');
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
                redirect('employee_portal/employee_transactions/#employee_leave');
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
	                redirect('employee_portal/employee_transactions/#employee_leave');
				}	
			}
			else{

			}
		}
		return $filename;
	}

	public function formulate_file_name($form_name)
	{
		$file_name= 'attachment_'. $this->session->userdata('employee_id') . '_' .$form_name. '_'.date('YmdHis');
		return $file_name;
	}




	
}