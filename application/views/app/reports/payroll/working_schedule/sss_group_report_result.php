<style type="text/css">
	.align-right{
		text-align: center;
	}
	.company{
		font-weight: bold;
		/*text-transform: uppercase;*/
	}
</style>
          <div class="col-md-12">    
        
<?php
		


if($groupings_type=="g_company"){
	
	if(!empty($companyList)){
		echo '<table class="table table-hover table-striped">';
		$a=0;
		foreach($companyList as $comp){
			echo '<tr>';
			$a+=1;
			$company=$comp->company_id;
			echo "<td>"."<span class='company'>".$comp->company_name."</span>";

			$ws_data = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);

				echo '<table  id="print_table'.$a.'" class="table table-hover table-striped"><thead>
				<tr>
				<th>Employee ID</th>
				<th>Name</th>
				<th>Social Security Number</th>
				<th>Employee</th>
				<th>Employer</th>
				<th>EC</th>
				<th>Total</th>
				</tr></thead><tbody>

				';
			if(!empty($ws_data)){


				$overall_total="";
				$ee_total="";
				$er_total="";
				$ec_total="";
				foreach($ws_data as $emp){
						$total=$emp->sss_employee+$emp->sss_employer+$emp->sss_ec_er;
						$overall_total+=$total;
						$ee_total+=$emp->sss_employee;
						$er_total+=$emp->sss_employer;
						$ec_total+=$emp->sss_ec_er;
				

					echo '<tr>';
					echo '<td class="bg-success" width="10%">'.$emp->employee_id.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->name_lname_first.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_number.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_employee.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_employer.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_ec_er.'</td>';
					echo '<td class="bg-success" width="10%">'.$total.'</td>';
					echo '</tr>';
				}
				echo '<tr>
				<td >TOTAL</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td class="" width="10%">Total: '.$ee_total.'</td>
				<td class="" width="10%">Total: '.$er_total.'</td>
				<td class="" width="10%">Total: '.$ec_total.'</td>
				<td class="" width="10%">Total: '.$overall_total.'</td>

				</tr>';

				
			}else{
				// echo '<tr>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>	
				// <td >&nbsp;</td>								
				// </tr>';
			}


			echo '</tbody></table>';

				echo '</td></tr>';



		}
		echo '</table>';
	
	}else{}

	
}elseif($groupings_type=="g_location"){


	if(!empty($companyList)){
		echo '<table class="table table-hover table-striped">';
		$a=0;
		foreach($companyList as $comp){
			echo '<tr>';
			
			$company=$comp->company_id;
			$company_id=$comp->company_id;
			echo "<td>"."<button class='btn btn-success'>".$comp->company_name."</button>";
		
			$myloc=$this->general_model->get_company_locations($company_id);
			if(!empty($myloc)){

				foreach($myloc as $loc){
						$a+=1;
					$location=$loc->location_id;
				//	echo '<i class="fa fa-arrow-right"></i>'.$loc->location_name;
					$ws_data = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);

				echo '<table  id="print_table'.$a.'" class="table table-hover table-striped"><thead>
				<tr>
				<th>Location<i class="fa fa-arrow-right text-danger"></i>'.$loc->location_name.'</th>
				<th>Employee ID</th>
				<th>Name</th>
				<th>Pagibig Number</th>
				<th>Employee</th>
				<th>Employer</th>
								<th>EC</th>
				<th>Total</th>
				
				</tr></thead><tbody>

				';
			if(!empty($ws_data)){

				$overall_total="";
				$ee_total="";
				$er_total="";
				$ec_total="";
				foreach($ws_data as $emp){
						$total=$emp->sss_employee+$emp->sss_employer+$emp->sss_ec_er;
						$overall_total+=$total;
						$ee_total+=$emp->sss_employee;
						$er_total+=$emp->sss_employer;
						$ec_total+=$emp->sss_ec_er;
				

					echo '<tr>';
					echo '<td class="bg-success" width="10%">'.$loc->location_name.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->employee_id.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->name_lname_first.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_number.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_employee.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_employer.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_ec_er.'</td>';
					echo '<td class="bg-success" width="10%">'.$total.'</td>';
					
					echo '</tr>';
				}
				echo '<tr>
				<td >TOTAL</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td class="" width="10%">Total: '.$ee_total.'</td>
				<td class="" width="10%">Total: '.$er_total.'</td>
				<td class="" width="10%">Total: '.$ec_total.'</td>
				<td class="" width="10%">Total: '.$overall_total.'</td>

				</tr>';

				
			}else{
				// echo '<tr>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>	
				// <td >&nbsp;</td>								
				// </tr>';
			}




							} // foreach location

						}else{}// check location

					echo '</tbody></table>'; // table of location

				echo '</td></tr>';// row of company list

		} // foreach of company
		echo '</table>'; // table of companylist
	
	}else{}// check company

}elseif($groupings_type=="g_div"){

	if(!empty($div_companyList)){
		echo '<table class="table table-hover table-striped">';
		$a=0;
		foreach($div_companyList as $comp){
			echo '<tr>';
			
			$company=$comp->company_id;
			$company_id=$comp->company_id;
			echo "<td>"."<button class='btn btn-success'>".$comp->company_name."</button>";
		
			$mydiv=$this->general_model->get_company_divisions($company_id);
			if(!empty($mydiv)){

				foreach($mydiv as $div){
						$a+=1;
					$division=$div->division_id;
					//echo '<i class="fa fa-arrow-right"></i>'.$div->division_id;
					$ws_data = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);

				echo '<table  id="print_table'.$a.'" class="table table-hover table-striped"><thead>
				<tr>
				<th>Division<i class="fa fa-arrow-right text-danger"></i>'.$div->division_name.'</th>
				<th>Employee ID</th>
				<th>Name</th>
				<th>Pagibig Number</th>
				<th>Employee</th>
				<th>Employer</th>
								<th>EC</th>
				<th>Total</th>
				
				</tr></thead><tbody>

				';
			if(!empty($ws_data)){

				$overall_total="";
				$ee_total="";
				$er_total="";
				$ec_total="";
				foreach($ws_data as $emp){
						$total=$emp->sss_employee+$emp->sss_employer+$emp->sss_ec_er;
						$overall_total+=$total;
						$ee_total+=$emp->sss_employee;
						$er_total+=$emp->sss_employer;
						$ec_total+=$emp->sss_ec_er;

					echo '<tr>';
					echo '<td class="bg-success" width="10%">'.$div->division_name.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->employee_id.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->name_lname_first.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_number.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_employee.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_employer.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_ec_er.'</td>';
					echo '<td class="bg-success" width="10%">'.$total.'</td>';
					
					echo '</tr>';
				}
				echo '<tr>
				<td >TOTAL</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td class="" width="10%">Total: '.$ee_total.'</td>
				<td class="" width="10%">Total: '.$er_total.'</td>
				<td class="" width="10%">Total: '.$ec_total.'</td>
				<td class="" width="10%">Total: '.$overall_total.'</td>

				</tr>';

				
			}else{
				// echo '<tr>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>	
				// <td >&nbsp;</td>								
				// </tr>';
			}




							} // foreach division

						}else{}// check division

					echo '</tbody></table>'; // table of division

				echo '</td></tr>';// row of company list

		} // foreach of company
		echo '</table>'; // table of companylist
	
	}else{}// check company

}elseif($groupings_type=="g_dept"){

	if(!empty($heyList)){ 
		echo '<table class="table table-hover table-striped">';
		$a=0; 
		foreach($heyList as $comp){
			echo '<tr>';
			
			$company=$comp->company_id;
			$company_id=$comp->company_id;
			$wDiv=$comp->wDivision;
			echo "<td>"."<button class='col-md-12 btn btn-success'>".$comp->company_name."</button>";
		
			$mydept=$this->general_model->get_company_departments($company_id);
			if(!empty($mydept)){

				foreach($mydept as $dept){
						$a+=1;
					$department=$dept->department_id;
					//echo '<i class="fa fa-arrow-right"></i>'.$dept->department_id;
					$ws_data = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);

				echo '<table  id="print_table'.$a.'" class="table table-hover table-striped"><thead>
				<tr>
				<th>Division</th>
				<th>Department<i class="fa fa-arrow-right text-danger"></i>'.$dept->dept_name.'</th>
				<th>Employee ID</th>
				<th>Name</th>
				<th>Pagibig Number</th>
				<th>Employee</th>
				<th>Employer</th>
								<th>EC</th>
				<th>Total</th>
				
				</tr></thead><tbody>

				';
			if(!empty($ws_data)){

				$overall_total="";
				$ee_total="";
				$er_total="";
				$ec_total="";
				foreach($ws_data as $emp){
						$total=$emp->sss_employee+$emp->sss_employer+$emp->sss_ec_er;
						$overall_total+=$total;
						$ee_total+=$emp->sss_employee;
						$er_total+=$emp->sss_employer;
						$ec_total+=$emp->sss_ec_er;

					if($wDiv=="1"){
						$mydivision_name=$emp->division_name;
					}else{
						$mydivision_name="n/a";
					}

	
				

					echo '<tr>';
					echo '<td class="bg-success" width="10%">'.$mydivision_name.'</td>';
					echo '<td class="bg-success" width="10%">'.$dept->dept_name.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->employee_id.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->name_lname_first.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_number.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_employee.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_employer.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_ec_er.'</td>';
					echo '<td class="bg-success" width="10%">'.$total.'</td>';
					
					echo '</tr>';
				}
				echo '<tr>
				<td >TOTAL</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td class="" width="10%">Total: '.$ee_total.'</td>
				<td class="" width="10%">Total: '.$er_total.'</td>
				<td class="" width="10%">Total: '.$ec_total.'</td>
				<td class="" width="10%">Total: '.$overall_total.'</td>

				</tr>';

				
			}else{
				// echo '<tr>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>	
				// <td >&nbsp;</td>								
				// </tr>';
			}




							} // foreach department

						}else{}// check department

					echo '</tbody></table><br><br><br>'; // table of department

				echo '</td></tr>';// row of company list

		} // foreach of company
		echo '</table>'; // table of companylist
	
	}else{ }// check company

}elseif($groupings_type=="g_sect"){

	if(!empty($forGroupSec)){ 
		echo '<table class="table table-hover table-striped">';
		$a=0; 
		foreach($forGroupSec as $comp){
			echo '<tr>';
			
			$company=$comp->company_id;
			$company_id=$comp->company_id;
			$wDiv=$comp->wDivision;
			echo "<td>"."<button class='col-md-12 btn btn-success'>".$comp->company_name."</button>";
		
			$mydept=$this->general_model->get_company_departments($company_id);
			if(!empty($mydept)){

				foreach($mydept as $dept){
						
					$department=$dept->department_id;
					$dept_id=$dept->department_id;
					$mysect=$this->general_model->getSec($dept_id);

					foreach($mysect as $sect){
						$section=$sect->section_id;
						$a+=1;
					$ws_data = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);

				echo '<table  id="print_table'.$a.'" class="table table-hover table-striped"><thead>
				<tr>
				<th>Division</th>
				<th>Department</th>
				<th>Section<i class="fa fa-arrow-right text-danger"></i>'.$sect->section_name.'</th>
				<th>Employee ID</th>
				<th>Name</th>
				<th>Pagibig Number</th>
				<th>Employee</th>
				<th>Employer</th>
				<th>Total</th>
								<th>EC</th>
				</tr></thead><tbody>';

			if(!empty($ws_data)){

				$overall_total="";
				$ee_total="";
				$er_total="";
				$ec_total="";
				foreach($ws_data as $emp){
						$total=$emp->sss_employee+$emp->sss_employer+$emp->sss_ec_er;
						$overall_total+=$total;
						$ee_total+=$emp->sss_employee;
						$er_total+=$emp->sss_employer;
						$ec_total+=$emp->sss_ec_er;

					if($wDiv=="1"){
						$mydivision_name=$emp->division_name;
					}else{
						$mydivision_name="n/a";
					}


					echo '<tr>';
					echo '<td class="bg-success" width="10%">'.$mydivision_name.'</td>';
					echo '<td class="bg-success" width="10%">'.$dept->dept_name.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->section_name.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->employee_id.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->name_lname_first.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_number.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_employee.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_employer.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_ec_er.'</td>';
					echo '<td class="bg-success" width="10%">'.$total.'</td>';
					
					echo '</tr>';
				}
				echo '<tr>
				<td >TOTAL</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td class="" width="10%">Total: '.$ee_total.'</td>
				<td class="" width="10%">Total: '.$er_total.'</td>
				<td class="" width="10%">Total: '.$ec_total.'</td>
				<td class="" width="10%">Total: '.$overall_total.'</td>

				</tr>';

				
			}else{
				// echo '<tr>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>	
				// <td >&nbsp;</td>								
				// </tr>';
			}


								} // foreach section

							} // foreach department

						}else{}// check department

					echo '</tbody></table><br><br><br>'; // table of department

				echo '</td></tr>';// row of company list

		} // foreach of company
		echo '</table>'; // table of companylist
	
	}else{ }// check company

}elseif($groupings_type=="g_subsect"){

	if(!empty($forGroupSec)){ 
		echo '<table class="table table-hover table-striped">';
		$a=0; 
		foreach($forGroupSec as $comp){
			echo '<tr>';
			
			$company=$comp->company_id;
			$company_id=$comp->company_id;
			$wDiv=$comp->wDivision;
			echo "<td>"."<button class='col-md-12 btn btn-success'>".$comp->company_name."</button>";
		
			$mydept=$this->general_model->get_company_departments($company_id);
			if(!empty($mydept)){

				foreach($mydept as $dept){
						

					$department=$dept->department_id;
					$dept_id=$dept->department_id;

					$mysect=$this->reports_payroll_model->subsec_base_section($dept_id);

					foreach($mysect as $sect){
						$section=$sect->section_id;
						$section_id=$sect->section_id;
						$wSubsect=$sect->wSubsection;

					$mysubsect=$this->general_model->get_sec_subsection($section_id);
					foreach($mysubsect as $subsec){
						$subsection=$subsec->subsection_id;
						$a+=1;
					$ws_data = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);

				echo '<table  id="print_table'.$a.'" class="table table-hover table-striped"><thead>
				<tr>
				<th>Division</th>
				<th>Department</th>
				<th>Section</th>
				<th>Sub-Section<i class="fa fa-arrow-right text-danger"></i>'.$subsec->subsection_name.'</th>
				<th>Employee ID</th>
				<th>Name</th>
				<th>Pagibig Number</th>
				<th>Employee</th>
				<th>Employer</th>
				<th>EC</th>
				<th>Total</th>
				</tr></thead><tbody>';

			if(!empty($ws_data)){
				$overall_total="";
				$ee_total="";
				$er_total="";
				$ec_total="";
				foreach($ws_data as $emp){
						$total=$emp->sss_employee+$emp->sss_employer+$emp->sss_ec_er;
						$overall_total+=$total;
						$ee_total+=$emp->sss_employee;
						$er_total+=$emp->sss_employer;
						$ec_total+=$emp->sss_ec_er;

					if($wDiv=="1"){
						$mydivision_name=$emp->division_name;
					}else{
						$mydivision_name="n/a";
					}

				

					echo '<tr>';
					echo '<td class="bg-success" width="10%">'.$mydivision_name.'</td>';
					echo '<td class="bg-success" width="10%">'.$dept->dept_name.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->section_name.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->subsection_name.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->employee_id.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->name_lname_first.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_number.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_employee.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_employer.'</td>';
					echo '<td class="bg-success" width="10%">'.$emp->sss_ec_er.'</td>';
					echo '<td class="bg-success" width="10%">'.$total.'</td>';
					
					echo '</tr>';
				}
				echo '<tr>
				<td >TOTAL</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td class="" width="10%">Total: '.$ee_total.'</td>
				<td class="" width="10%">Total: '.$er_total.'</td>
				<td class="" width="10%">Total: '.$ec_total.'</td>
				<td class="" width="10%">Total: '.$overall_total.'</td>

				</tr>';

				
			}else{
				// echo '<tr>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>
				// <td >&nbsp;</td>	
				// <td >&nbsp;</td>								
				// </tr>';
			}

									} // foreach subsection

								} // foreach section

							} // foreach department

						}else{}// check department

					echo '</tbody></table><br><br><br>'; // table of department

				echo '</td></tr>';// row of company list

		} // foreach of company
		echo '</table>'; // table of companylist
	
	}else{ }// check company

}else{// other feautures

}


?>

  </div>