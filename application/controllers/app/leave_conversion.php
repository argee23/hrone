<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Leave_conversion extends General{

	function __construct(){
		parent::__construct();	
		 $this->load->model("app/leave_conversion_model");
		 $this->load->model("app/payroll_generate_payslip_model");
		 $this->load->model("app/Payroll_generate_13th_month_model");
		$this->load->model("general_model");
		$this->load->database();
		$this->load->dbforge();
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');


		$total_companies=$this->general_model->countCompanies();
		$this->data['total_comp']=$total_companies->total_company;
		$this->data['t_company_id']=$total_companies->company_id;


		$this->data['comp_leave_typ']=$this->leave_conversion_model->get_company_leave($total_companies->company_id);

		$this->data['AllPayrollPeriodGroup']=$this->leave_conversion_model->AllPayrollPeriodGroup();
		$this->data['lc_regpay']=$this->leave_conversion_model->getLeaveConversionPayslipRegPay();
		$this->data['lc_seppay']=$this->leave_conversion_model->getLeaveConversionPayslipSepPay();

		$this->load->view('app/payroll/leave_conversion/index',$this->data);
	}

	public function view_posted_lc(){
		$release_type=$this->input->post('release_type');
		$pay_date=$this->input->post('pay_date');
		if($release_type=="reg_payroll"){
			list($pay_date,$company_id,$pay_period_from,$pay_period_to) = explode('M', $pay_date);

			$this->data['emp']=$this->leave_conversion_model->show_lc_payslip($pay_date);
		}else{

		}
		$this->data['pay_period_from']=$pay_period_from;
		$this->data['pay_period_to']=$pay_period_to;


		$this->data['company_info'] = $this->general_model->get_company_info($company_id);


		//$this->load->view('app/payroll/leave_conversion/lc_print_payslip',$this->data);
		$this->load->view('app/payroll/leave_conversion/lc_print_payslip',$this->data);
		
	}

	public function getCompLeave($company_id){
	
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();
		$this->data['comp_leave_typ']=$this->leave_conversion_model->get_company_leave($company_id);
		$total_companies=$this->general_model->countCompanies();
		$this->data['total_comp']=$total_companies->total_company;
		$this->data['company_id']=$company_id;

		$this->load->view('app/payroll/leave_conversion/leave_table',$this->data);
	}


	public function view_emp($leave_id,$covered_year,$company_id){

		//echo "leave id : $leave_id | year : $covered_year | comp: $company_id  ";


		list($leave_id,$payroll_period_group_id) = explode('M', $leave_id);


		$cy=$current_year=date('Y');
		$this->data['leave_credit']=$this->leave_conversion_model->get_leave_credit($cy,$leave_id);
		$this->data['leave_id']=$leave_id;
		$this->data['covered_year']=$covered_year;
		$this->data['company_id']=$company_id;
		$this->data['payroll_period_group_id']=$payroll_period_group_id;
		$this->data['oa_typ']=$this->leave_conversion_model->get_oa_types($company_id);
		$this->load->view('app/payroll/leave_conversion/leave_type_credit',$this->data);
	}


	public function convert_credit($covered_year){	
		//$covered_year=$this->input->post('covered_year');


		$other_add_typ=$this->input->post('other_add_typ');
		$releasing_type=$this->input->post('releasing_type');

		$pay_date=$this->input->post('pay_date');
		if($releasing_type=="sep_payroll"){
			$pay_date_details=$pay_date;
		}else{
		
		list($pay_date,$pay_date_details) = explode('/', $pay_date);

		}

		
		
		$leave_id=$this->input->post('leave_id');
		$action=$this->input->post('action');
	
		if($action=="review"){
			$action_result="review mode";
		}elseif($action=="save"){
			$action_result="not saved";
		}elseif($action=="reset"){
			$action_result="";
		}		

		$lv=$this->leave_conversion_model->getLeaveTypDetails($leave_id);
		$leave_type_name=$lv->leave_type;
		$taxable_leave_beyond=$lv->taxable_leave_beyond;

		$compensation_initial_decimal_place=2;//if no setup this is the standard	
		$round_off_payslip="yes";//default if not setup
		$total_companies=$this->general_model->countCompanies();
		$total_comp=$total_companies->total_company;

		if($total_comp=="1"){
			$company_id=$total_companies->company_id;
			$payroll_policy=$this->payroll_generate_payslip_model->check_single_setup_payroll($company_id);
			if(!empty($payroll_policy)){
				foreach ($payroll_policy as $pol){
						$payroll_policy_main_id=$pol->payroll_main_id;
						$payroll_policy_company=$pol->company_id;
						$payroll_policy_single_field=$pol->single_field;
						$payroll_policy_title=$pol->title;

						if($payroll_policy_main_id=="21"){//Compensation (daily rate,hourly rate) Decimal Place
							$compensation_initial_decimal_place=$payroll_policy_single_field;
						}elseif($payroll_policy_main_id=="5"){//Round it off payslip decimal place
							$round_off_payslip=$payroll_policy_single_field;
						}else{}
				}
			}else{}
		
		}else{}
		

		echo '
		<table width="100%" border=1>
			<thead>
				<tr>
					<th colspan="10">Leave Type: '.$leave_type_name.'</th>
				</tr>
				<tr>
					<th>Employee ID </th>
					<th>Name</th>
					<th>Credit</th>
					<th>Non-Taxable Credit <br>( Credit * Daily Rate )</th>
					<th>Taxable Credit <span style="color:#ff0000;">(Beyond '.$taxable_leave_beyond.' Its Taxable)</span></th>
					<th>Wtax</th>
					<th>Salary Details Chosen</th>
					<th>Daily Rate</th>
					<th style="background-color:#DBFC94;">Total Amount(Non-Taxable Credit+Taxable Credit)-Wtax</th>
					<th>Action Taken</th>
				</tr>
			</thead>
		<tbody>';

				
		if(!empty($this->input->post('employeeselected'))){
		foreach ($this->input->post('employeeselected') as $key => $raw_employee_id)
		{
				$taxable_credit=0;
				
				list($employee_id,$name,$pay_type,$employment_id,$taxcode_id) = explode('/', $raw_employee_id);


				$credit=$this->input->post('credit'.$employee_id);
				$cash_convert=$this->input->post('cash_convert'.$employee_id);
				$salary_details=$this->input->post('salary_details'.$employee_id);

				//$non_taxable_credit=$cash_convert;

				if($taxable_leave_beyond==""){
					
				}elseif(is_null($taxable_leave_beyond)){
					
				}else{
					if($cash_convert>=$taxable_leave_beyond){
						//5 taxable beyond
						//6 credit
						$taxable_credit=$cash_convert-$taxable_leave_beyond;

					}else{

					}

				}

				$non_taxable_credit=$cash_convert-$taxable_credit;

				$tags=explode('/' , $salary_details);
				$c_tags=count($tags);
				if($c_tags=="7"){
				list($salary_rate,$salary_rate_name,$salary_amount,$no_of_hours,$no_of_days_monthly,$no_of_days_yearly,$salary_id) = explode('/', $salary_details);


					if($salary_rate=="3"){
						$daily_rate=$salary_amount;
						$daily_rate_formula="";
					}else{
						/*( Salary amount / No. of Days Yearly )* No. of Months yearly*/
						$daily_rate=($salary_amount/$no_of_days_yearly)*$no_of_days_monthly;
						$daily_rate_formula="Daily Rate Formula: ($salary_amount/$no_of_days_yearly)*$no_of_days_monthly";
					}

                    if($round_off_payslip=="yes"){// round off
                        $daily_rate=round($daily_rate, $compensation_initial_decimal_place);
                    }else{
                        $daily_rate=bcdiv($daily_rate, 1, $compensation_initial_decimal_place); 
                    }   

                    $nontax_amount=$non_taxable_credit*$daily_rate;
                    $nontax_amount_how="$non_taxable_credit*$daily_rate";
                    $nontax_amount_nf=number_format($nontax_amount,$compensation_initial_decimal_place);

                    $taxable_amount=$taxable_credit*$daily_rate;
                    $taxable_amount_how="$taxable_credit*$daily_rate";
                    $taxable_amount_nf=number_format($taxable_amount,$compensation_initial_decimal_place);

// =================start check tax
		$tax_table_name="tax_table_".$company_id;
		$taxable_formula_value=$taxable_amount;

		//==== tax
		$taxcodeList= $this->general_model->taxcodeList();
		
		$payroll_formula=$this->payroll_generate_payslip_model->formula_setup($company_id,$employment_id,$pay_type,$salary_rate);
		if(!empty($payroll_formula)){		
				$wtax_formula=$payroll_formula->wtax_formula_code;
				$wtax_formula_desc=$payroll_formula->wtax_formula_desc;
		}else{			
		}
		//==== tax


$validate_tax_table=$this->payroll_generate_payslip_model->check_tax_table($tax_table_name);
if(!empty($validate_tax_table)){

			$wtax_table_setup=$this->payroll_generate_payslip_model->get_wtax_table($company_id,$pay_type,$salary_rate,$covered_year,$taxcode_id,$taxable_formula_value);
// 			if($employee_id=="378000"){
// //echo "$company_id,$pay_type,$salary_rate,$covered_year,$taxcode_id,$taxable_formula_value";
// 			}else{

// 			}

			if(!empty($wtax_table_setup)){
					$tax_code_field="tax_code_".$taxcode_id;
					$exempt_percentage=$wtax_table_setup->exempt_percentage;
					$exempt_value=$wtax_table_setup->exempt_value;
					$tax_code_field=$wtax_table_setup->taxcodefield;

					//option 1
					foreach($taxcodeList as $tc_list){
						$tcid=$tc_list->taxcode_id;
						$transpose_var='tax_code_'.$tcid;
						$$transpose_var=$tax_code_field; // yes this is double dollar sign.
					}
					//option 2
					
					// start compute tax

				        $wtax_formula_text=str_replace("[","{",$wtax_formula);
				        $wtax_formula_text=str_replace("]","}",$wtax_formula_text);
				        $wtax_formula_text = $wtax_formula_text;

						$string = "$wtax_formula_text";
						$newword='tax_code_'.$taxcode_id; // get the taxcode id
						$newstring = str_replace("tax_code", $newword, $string);
						$wtax_formula_text=$newstring;

					        $for_translation=$wtax_formula_text;
					        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
					        $wtax_formula_1st=str_replace("[","",$wtax_formula);
					        $wtax_formula_2nd=str_replace("]","",$wtax_formula_1st);    

						$string_2 = "$wtax_formula_2nd";
						$newword_2='tax_code_1';
						$newstring_2 = str_replace("tax_code", $newword_2, $string_2);
						$wtax_formula_3=$newstring_2;
							   		     
					    	
					    	$witheld_tax = eval('return '.$wtax_formula_3.';');
					    	$wtax_formula_text=$wtax_formula_desc."<br> $for_translation = $witheld_tax";

		}else{
			$witheld_tax=0;
			$wtax_formula_text="";

		}

}else{}



// =================end check tax
                    

                    if($taxable_amount<=0){
                    	$tax_class='style="color:#ccc;"';
                    }else{
                    	$tax_class="";
                    }

                    $amount_converted=($nontax_amount+$taxable_amount)-$witheld_tax;
                    $amount_converted_nf=number_format($amount_converted,$compensation_initial_decimal_place);
                    $amount_converted_how="($nontax_amount+$taxable_amount)-$witheld_tax";

					$sd="<a title='Salary ID is: ".$salary_id."'>Salary Rate : $salary_rate_name</a> <br>
						Amount : $salary_amount <br>
						No of Hrs : $no_of_hours <br>
						No of days monthly : $no_of_days_monthly <br>
						No of days yearly : $no_of_days_yearly <br>
						$daily_rate_formula
					";
				}else{
					$sd="";
				}



				echo '<tr>
				<td>'.$employee_id.'</td>
				<td>'.$name.'</td>
				<td>'.$cash_convert.'</td>

				';

				if($c_tags=="7"){
					echo '
				<td>formula: '.$nontax_amount_how.'<br>amount: '.$nontax_amount_nf.'</td>
				<td '.$tax_class.'>formula: '.$taxable_amount_how.'<br>amount: '.$taxable_amount_nf.'</td>	
				<td>'.$wtax_formula_text."<br>".$witheld_tax.'</td>
				<td>'.$sd.'</td>


					<td>'.$daily_rate.'</td>
					<td style="background-color:#DBFC94;">formula :'.$amount_converted_how."<br>amount: ".$amount_converted_nf.'</td>
					
					';	
//==== start pag may salary info saka lang mase-save
				if($action=="reset"){
					$query=$this->db->query("DELETE FROM payslip_leave_conversion WHERE employee_id='".$employee_id."' AND covered_year='".$covered_year."' AND leave_id='".$leave_id."'  AND pay_date='".$pay_date."' ");
			
					$action_result="Successfully Cleared/Reset Leave Conversion for covered year : $covered_year | pay date : $pay_date_details | leave type : $leave_type_name";					

				}else{
				}
				if($action=="review" OR $action=="save"){
						$isPosted=$this->leave_conversion_model->checkPostedLeaveCo($employee_id,$covered_year,$leave_id,$pay_date);
						if(!empty($isPosted)){
								if($action=="review"){
									$action_result="you are on review mode<br>(note: the computation shown is already posted previously)";	
								}else{

								}
											
						}else{
						}
				}else{
				}	

				if($action=="save"){
					$query=$this->db->query("DELETE FROM payslip_leave_conversion WHERE employee_id='".$employee_id."' AND covered_year='".$covered_year."' AND leave_id='".$leave_id."'  AND pay_date='".$pay_date."' ");

					$leaveConversiondata = array(
						'employee_id'				=>	$employee_id,
						'covered_year'				=>	$covered_year,
						'credits_for_conversion'	=>	$cash_convert,
						'nontax_amount'				=>	$nontax_amount,
						'nontax_amount_how'			=>	$nontax_amount_how,
						'taxable_amount'			=>	$taxable_amount,
						'taxable_amount_how'		=>	$taxable_amount_how,
						'witheld_tax'				=>	$witheld_tax,
						'wtax_formula_text'			=>	$wtax_formula_text,
						'salary_details'			=>	$sd,
						'taxable_leave_beyond'		=>	$taxable_leave_beyond,
						'non_taxable_credit'		=>	$non_taxable_credit,
						'taxable_credit'			=>	$taxable_credit,
						'other_add_typ'			=>	$other_add_typ,
						'releasing_type'			=>	$releasing_type,
						'pay_date'			=>	$pay_date,
						'leave_id'			=>	$leave_id,
						'amount_converted'			=>	$amount_converted,
						'amount_converted_how'			=>	$amount_converted_how,
						'entry_date'			=>	date('Y-m-d H:i:s')
					);
					$this->leave_conversion_model->insertLeaveConvertedVal($leaveConversiondata);

					if(!empty($isPosted)){
						$action_result="re-saved";
					}else{
						$action_result="saved";
					}
					
				}else{}
//==== end pag may salary info saka lang mase-save
					

					echo '<td>'.$action_result.'</td>';

				}else{
					echo '
					<td ></td>
					<td></td>
					<td></td>
					<td></td>
					<td>notice : kindly check salary setup.</td>
					<td></td>
					<td style="background-color:#ff0000;color:#fff;">notice : kindly check salary setup.</td>
					';				
				}

				echo '
				</tr>';

	
		}// end of foreach

	}else{
		echo '<tr><td colspan="10">notice:  you havent selected employee.</td></tr>';
	}
echo '
	</tbody>
</table>
';

	}

	public function getProcessingParameter($val,$payroll_period_group_id){
		$this->data['val']=$val;
		$this->data['payroll_period_group_id']=$payroll_period_group_id;
		$this->load->view('app/payroll/leave_conversion/release_covered',$this->data);
	}


}// end of controller