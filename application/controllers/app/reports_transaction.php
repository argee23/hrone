<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class reports_transaction extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/employee_model");
		$this->load->model("app/report_transaction");
		$this->load->model("app/report_time_model");
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
		$this->data['details']= $this->report_transaction->get_crystal_reports_list_all();
		$this->load->view('app/reports/transaction/index',$this->data); 
	}

	public function get_transaction($company,$type)
	{
		$transaction = $this->report_transaction->get_transaction_list($company,$type);
		if(empty($transaction))
		{
			echo "<option value=''>No transaction found.</option>";
		}
		else
		{
			echo "<option value=''>Select</option>";
			foreach($transaction as $t)
			{
				echo "<option value='".$t->id."'>".$t->form_name."</option>";
			}
		}
	}

	public function get_crystal_reports_list($company,$transaction,$type)
	{
		$this->data['company']=$company;
		$this->data['transaction']=$transaction;
		$this->data['type']=$type;
		$this->data['details']= $this->report_transaction->get_crystal_reports_list($company,$transaction,'admin');
		$this->load->view('app/reports/transaction/crystal_report',$this->data); 
	}
	public function add_crystal_report($company,$transaction,$type)
	{
		$this->data['company']=$company;
		$this->data['transaction']=$transaction;
		$this->data['type']=$type;
		$this->data['transaction_field']=$this->report_transaction->get_transaction_fields($company,$transaction,$type);
		$this->data['trans']=$this->report_transaction->get_transaction_details($transaction);
		$this->load->view('app/reports/transaction/add_reports',$this->data); 
	}

	public function save_new_report($fields,$report_name,$report_desc,$transaction_id,$transaction_name,$company,$type)
	{
		$this->data['company']=$company;
		$this->data['transaction']=$transaction_id;
		$this->data['type']=$type;
		$this->data['transaction_name']=str_replace("%20"," ",$transaction_name);
		$this->data['transaction_id']=$transaction_id;
		$insert = $this->report_transaction->add_new_report($fields,$report_name,$report_desc,$transaction_id,$company,'admin');
		$this->data['details'] = $this->report_transaction->report_list($transaction_id,$company,'admin');
		$this->load->view('app/reports/transaction/crystal_report',$this->data);

	}
	
	public function stat_crystal_report($transaction,$company,$type,$action,$id)
	{
		
		$this->data['company']=$company;
		$this->data['transaction']=$transaction;
		$this->data['type']=$type;
		$this->data['id']=$id;
		if($action=='view' || $action=='edit')
		{
			$this->data['transaction_field']=$this->report_transaction->get_transaction_fields($company,$transaction,$type);
			$this->data['details']=$this->report_transaction->get_crystal_report_details($id);
			$this->data['trans']=$this->report_transaction->get_transaction_details($transaction);
			if($action=='edit')
			{
				$this->load->view('app/reports/transaction/crystal_report_edit',$this->data);
			}
			else
			{
				$this->load->view('app/reports/transaction/crystal_report_view',$this->data);
			}
			
		}
		
		else
		{
			$a = $this->report_transaction->action_crystal_report($id,$action);
			$this->data['details'] = $this->report_transaction->report_list($transaction,$company,'admin');
			$this->load->view('app/reports/transaction/crystal_report',$this->data);
		}
		
	}
	public function saveupdate_new_report($fields,$report_name,$report_desc,$transaction_id,$transaction_name,$company,$type,$crystal_id)
	{
		$this->data['company']=$company;
		$this->data['transaction']=$transaction_id;
		$this->data['type']=$type;
		$this->data['transaction_name']=str_replace("%20"," ",$transaction_name);
		$this->data['transaction_id']=$transaction_id;
		$update = $this->report_transaction->saveupdate_new_report($fields,$report_name,$report_desc,$transaction_id,$company,$crystal_id);
		$this->data['details'] = $this->report_transaction->report_list($transaction_id,$company,'admin');
		$this->load->view('app/reports/transaction/crystal_report',$this->data);
	}


	//generate reports

	public function generate_reports()
	{
		$this->load->view('app/reports/transaction/generate_reports',$this->data);
	}

	public function generate_crystal_report($company,$transaction)
	{
		$creport=$this->report_transaction->report_list($transaction,$company,'admin');
		if(empty($creport))
		{
			echo "<option value='' selected disabled>No Crystal Report found. Please add to continue.".$company."</option>";
		}
		else
		{
			echo "<option value='' selected disabled>Select</option>";
			foreach($creport as $c)
			{
				echo "<option value='".$c->id."'>".$c->title."</option>";
			}
		}
		
	}
	public function generate_classification($company)
	{
		$classification = $this->report_transaction->get_classification($company);
		if(empty($classification))
		{
			echo "<input type='hidden' value='none' id='countclassification'> ";
		}
		else
		{?>
			    <?php $i=0; foreach($classification as $c){?>
                                <div class="col-md-12">
                                  <di class="col-md-12"><n class="text-danger"><input type="checkbox" id="classification<?php echo $i;?>" value="<?php echo $c->classification_id;?>" 
                                  class="class_classification" checked><?php echo $c->classification.$c->classification_id;?></n></di>
                                </div>
                <?php $i++; } echo "<input type='hidden' value='".$i."' id='countclassification'> ";  ?>
		<?php }
	}
	public function generate_location($company)
	{

		$location = $this->report_transaction->get_location($company);
		if(empty($location))
		{
			echo "<input type='hidden' value='none' id='countlocation'> ";
		}
		else
		{?>
			    <?php $i=0; foreach($location as $l){?>
                                <div class="col-md-12">
                                  <di class="col-md-12"><n class="text-danger">
                                  <input type="checkbox" id="location<?php echo $i;?>" value="<?php echo $l->location_id;?>" class="class_location" checked><?php echo $l->location_name;?></n></di>
                                </div>
                <?php $i++; } echo "<input type='hidden' value='".$i."' id='countlocation'> ";  ?>
		<?php }
	}

	public function employee_list($company,$val)
	{
		$this->data['query']=$this->report_transaction->search_employee_list($company,$val);
		$this->load->view('app/reports/transaction/search_employee_list',$this->data);
	}
	public function generate_division($company)
	{
		$division = $this->report_transaction->get_division($company);
		$wDivision = $this->report_transaction->get_wdivision($company);
		if(count($wDivision) == 0)
		{
			echo "<option value='' selected disabled>Select</option>";
			echo "<option value='not_included'>No division or not applicable</option>";
		}
		else
		{
			echo "<option value='' selected disabled>Select</option>";
			if(empty($division))
			{
				echo "<option value='not_included' selected disabled>No division or not applicable</option>";
			}
			else
			{
				echo "<option value='all'>All</option>";
				foreach($division as $d)
				{
					echo "<option value='".$d->division_id."'>".$d->division_name."</option>";
				}
			}
		}
		
	}
	public function generate_department($company,$division)
	{
		$wDivision = $this->report_transaction->get_wdivision($company);
		if(count($wDivision) == 0) { $div = 'not_included'; } else{ $div=$division; }

		$department = $this->report_transaction->get_department($company,$div);

		echo "<option value='' selected disabled>Select</option>";
		if(empty($department))
			{
				echo "<option value='not_included' selected disabled>No department or not applicable</option>";
			}
			else
			{	
				echo "<option value='all'>All</option>";
				foreach($department as $d)
				{
					echo "<option value='".$d->department_id."'>".$d->dept_name."</option>";
				}
			}
 	}
 	public function generate_section($company,$department,$division)
 	{
 		$section = $this->report_transaction->get_section($company,$department,$division);

		echo "<option value='' selected disabled>Select</option>";
		if(empty($section))
			{
				echo "<option value='not_included' selected disabled>No section or not applicable</option>";
			}
			else
			{
				echo "<option value='all'>All</option>";
				foreach($section as $d)
				{
					echo "<option value='".$d->section_id."'>".$d->section_name."</option>";
				}
			}
 	}
 	public function generate_subsection($section,$company,$division,$department)
 	{
 		if($section=='all')
 		{
 			$wsubsection=1;
 		}
 		else 
 		{ $wsubsection = $this->report_transaction->get_wsubsection($section); }
 		
 		$subsection = $this->report_transaction->get_subsection($section,$company,$division,$department);
 		if(count($wsubsection)==0)
 		{
 			echo "<option value='not_included' selected>No subsection or not applicable</option>";
 		}
 		else
 		{	
 			echo "<option value='' selected disabled>Select</option>";
 			if(empty($subsection))
 			{
 				echo "<option value='not_included' selected disabled>No subsection or not applicable</option>";
 			}
 			else
 			{
 				echo "<option value='all'>All</option>";
 				foreach($subsection as $ss)
	 			{
	 				echo "<option value='".$ss->subsection_id."'>".$ss->subsection_name."</option>";
	 			}
 			}
 			
 		}
 	}
 	public function generate_filtertype($val,$transaction)
 	{
 		echo "<option value='' disabled selected>Select</option>";
 		if($val=='all')
 		{
 			echo "<option value='daterange_datefiled'>Date Range (based on date filed)</option>";
 			if($transaction==2 || $transaction==3 || $transaction==8 || $transaction==15 || $transaction==23 || $transaction==25 || $transaction==26 || $transaction==27)
	 		{
	 			echo "<option value='daterange_transactiondate'>Date Range (based on transaction dates)</option>";
	 		}
 		}
 		else
 		{
 			echo "<option value='daterange_datefiled'>Date Range (based on date filed)</option>";
 			echo "<option value='payrollperiod_datefiled'>By Payroll Period (based on date filed)</option>";
 			if($transaction==2 || $transaction==3 || $transaction==8 || $transaction==15 || $transaction==23 || $transaction==25 || $transaction==26 || $transaction==27)
	 		{
	 			echo "<option value='daterange_transactiondate'>Date Range (based on transaction dates)</option>";
 				echo "<option value='payrollperiod_transactiondate'>By Payroll Period (based on transaction dates)</option>";
	 		}

 		}
 	}

 	public function generate_payrollperiod($employee_id)
 	{
 		$pp = $this->report_transaction->get_payroll_period_list($employee_id);
 		if(empty($pp))
 		{
 		echo "<option value='not_included' disabled selected>No Payroll Period Found</option>";
 		}
 		else
 		{
 			echo "<option value='' disabled selected>Select</option>";
 			foreach($pp as $p)
 			{
 				$fmonth=substr($p->complete_from, 5,2);
			    $fday=substr($p->complete_from, 8,2);
			    $fyear=substr($p->complete_from, 0,4);

			   	$f = date("F", mktime(0, 0, 0, $fmonth, 10))." ". $fday.", ". $fyear;

			   	$tmonth=substr($p->complete_to, 5,2);
			    $tday=substr($p->complete_to, 8,2);
			    $tyear=substr($p->complete_to, 0,4);

			   	$t = date("F", mktime(0, 0, 0, $tmonth, 10))." ". $tday.", ". $tyear;

				echo "<option value='".$p->id."'>".$f." to ".$t."</option>";
 			}
 		}
 		
 	}

 	public function get_generate_report_result($company,$type,$transaction,$crystalreport,$employees,$status,$filtertype,$employeeid,$division,$department,$section,$subsection,$employment,$classification,$payrollperiod,$datefrom,$dateto,$location)
 	{
 		$this->data['transaction_id']=$transaction;
 		$this->data['trans']=$this->report_transaction->get_transaction_details($transaction);
 		$this->data['fields'] = $this->report_transaction->get_crystal_reports($crystalreport);
 		$this->data['details']=$this->report_transaction->get_generate_report_result($company,$type,$transaction,$crystalreport,$employees,$status,$filtertype,$employeeid,$division,$department,$section,$subsection,$employment,$classification,$payrollperiod,$datefrom,$dateto,$location);
 		$this->load->view('app/reports/transaction/generate_report_result',$this->data);
 	}

 	
}	
