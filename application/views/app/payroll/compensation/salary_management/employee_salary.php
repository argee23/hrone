
<div class="col-md-12">

<div class="box-body">
<div class="row">



  <div class="col-md-12">
  <div class="form-group">
  <div class="col-sm-4">
  <p>Employee ID</p>
  </div>
  <div class="col-sm-7">
    <label>
        <label><?php echo $employee_employment->employee_id; ?></label>
    </label>
  </div>
  </div>
  </div>

  <div class="col-md-12">
  <div class="form-group">
  <div class="col-sm-4">
  <p>Employee name</p>
  </div>
  <div class="col-sm-7">
    <label>
        <label><?php echo $employee_employment->name; ?></label>
    </label>
  </div>
  </div>
  </div>

  <div class="col-md-12">
  <div class="form-group">
  <div class="col-sm-4">
  <p>Company name</p>
  </div>
  <div class="col-sm-7">
    <label>
        <label><?php echo $employee_employment->company_name; ?></label>
    </label>
  </div>
  </div>
  </div>

</div> 
</div><!-- /.box-body --> 

   <!-- Salary information -->
   <div id="add_employee_salary">

	<div class="panel panel-info">
  	<div class="panel-heading"><strong>SALARY INFORMATION</strong>

    <i class="fa fa-arrow-circle-left fa-2x text-danger pull-right" data-toggle='tooltip' data-placement='right' title='back' onclick="get_company_employee('<?php echo $employee_employment->company_id; ?>')"></i>

  	<a onclick="view_salary_history('<?php echo $employee_employment->employee_id; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="history"><i class="fa fa-history fa-2x text-warning pull-right"></i></a>

  	<a onclick="add_employee_salary('<?php echo $employee_employment->employee_id; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-primary pull-right"></i></a>

    <?php if(count($employee_salary) > 0){?>
          <a onclick="update_employee_salary('<?php echo $employee_salary->salary_id; ?>','<?php echo $employee_salary->employee_id;?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Update Salary"><i class="fa fa-pencil-square fa-2x text-warning pull-right"></i></a><?php echo $employee_salary->salary_id; ?>
    <?php } ?>
  	

  	</div>
  	<div class="box-body">
  		

	  	<?php if(count($employee_salary) > 0){?>

		  <div class="col-md-12">

          <table class="table table-striped">
          <tbody>
            <tr>
              <td>Effective Date</td>
              <td><label><?php echo date('d M Y', strtotime($employee_salary->date_effective)); ?></label></td>
            </tr>
            <tr>
              <td>Salary Rate</td>
              <td><label><?php echo $employee_salary->salary_rate_name; ?></label></td>
            </tr>
            <tr>
              <td>Salary Amount</td>
              <td><label><?php echo $employee_salary->salary_amount; ?></label></td>
            </tr>
            <tr>
              <td>No. of Hours</td>
              <td><label><?php echo $employee_salary->no_of_hours; ?></label></td>
            </tr>
            <tr>
              <td>No. of Days Monthly</td>
              <td><label><?php echo $employee_salary->no_of_days_monthly; ?></label></td>
            </tr>
            <tr>
              <td>No. of Days Yearly</td>
              <td><label><?php echo $employee_salary->no_of_days_yearly; ?></label></td>
            </tr>
            <tr>
              <td>Reason</td>
              <td><label><?php echo $employee_salary->reason_title; ?></label></td>
            </tr>
            <tr>
              <td>Fixed salary amount</td>
              <td><label><?php if($employee_salary->is_salary_fixed == 1){echo 'yes';} else{echo 'no';} ?></label></td>
            </tr>
            <tr>
              <td>Date added</td>
              <td><label><?php echo date('d M Y h:i:s', strtotime($employee_salary->date_added)); ?></label></td>
            </tr>
          </tbody>
          </table>

          </div>
          <br>
          <label>COMPUTATION</label>
    	  <div class="box box-info"></div>
          <br>
          <div class="well">
          <table class="table table-striped">
          <thead>
          	<tr>
	          	<th></th>
	          	<th>AMOUNT(PHP)</th>
              <th style="width:1%"></th>
	          	<th>FORMULA</th>
          	</tr>
          </thead>
          <tbody>

            <tr>
              <td>Pay Check Amount</td>
              <td><label><?php echo $computation->pay_check_amount; ?></label></td>
              <td><font color="blue"> = </font></td>
              <?php if($employee_salary->salary_rate === '3'){?>
              <td><label>
              <font color="red"> ( </font> Salary amount 
              <font color="orange"> * </font> No. of Days Monthly
              <font color="red"> ) </font>
              <font color="green"> / </font> 2
              </label></td>
              <?php } ?>
              <?php if($employee_salary->salary_rate === '4'){?>
              <td><label>
              Salary amount 
              <font color="green"> / </font> 2
              </label></td>
              <?php } ?>
            </tr>
            <tr>
              <td>Hourly Amount</td>
              <td><label><?php echo $computation->hourly_amount; ?></label></td>
              <td><font color="blue"> = </font></td>
              <?php if($employee_salary->salary_rate === '3'){?>
              <td><label>
              Salary amount 
              <font color="green"> / </font> No. of hours
              </label></td>
              <?php } ?>
              <?php if($employee_salary->salary_rate === '4'){?>
              <td><label>
              <font color="brown"> ( </font> 
              <font color="red"> ( </font> Salary amount 
              <font color="green"> / </font> No. of Days Yearly
              <font color="red"> ) </font> <br>
              <font color="orange"> * </font> No. of Months yearly
              <font color="brown"> ) </font>
              <font color="green"> / </font> No. of Hours
              </label></td>
              <?php } ?>
            </tr>
            <tr>
              <td>Daily Amount</td>
              <td><label><label><?php echo $computation->daily_amount; ?></label></label></td>
              <td><font color="blue"> = </font></td>
              <?php if($employee_salary->salary_rate === '3'){?>
              <td><label>
              Salary amount 
              </label></td>
              <?php } ?>
              <?php if($employee_salary->salary_rate === '4'){?>
              <td><label>
              <font color="red"> ( </font> Salary amount 
              <font color="green"> / </font> No. of Days Yearly
              <font color="red"> ) </font> <br>
              <font color="orange"> * </font> No. of Months yearly
              </label></td>
              <?php } ?>
            </tr>
            <tr>
              <td>Monthly amount</td>
              <td><label><label><?php echo $computation->monthly_amount; ?></label></label></td>
              <td><font color="blue"> = </font></td>
              <?php if($employee_salary->salary_rate === '3'){?>
              <td><label>
              Salary amount 
              <font color="orange"> * </font> No. of Days Monthly
              </label></td>
              <?php } ?>
              <?php if($employee_salary->salary_rate === '4'){?>
              <td><label>
              Salary amount 
              </label></td>
              <?php } ?>
            </tr>
          </tbody>
          </table>
          </div>

          <div id="edit_government">
          <br>
		  <label>Government Deduction Subject To</label>
		  
          <i class='fa fa-pencil-square-o fa-2x text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="edit_government_deduction('<?php echo $employee_salary->salary_id; ?>')"></i>
          <br>
    	   <div class="box box-info"></div>

    	   	<div class="col-md-12">

	          <table class="table table-striped">
	          <tbody>
	            <tr>
	              <td style="width:5%" >
	              	<?php if($employee_salary->withholding_tax === '1'){?>
						<input type="checkbox" name="withholding_tax" id="withholding_tax" checked> 
					<?php } 
					else{ ?>
						<input type="checkbox" name="withholding_tax" id="withholding_tax"> 
					<?php } ?>
				  </td>
	              <td style="width:20%" ><label>Withholding tax</label></td>
	              <td></td>
	            </tr>

	            <tr>
	              <td style="width:5%" >
	              	<?php if($employee_salary->pagibig === '1'){?>
						<input type="checkbox" name="pagibig" id="pagibig" checked> 
					<?php } 
					else{ ?>
						<input type="checkbox" name="pagibig" id="pagibig">
					<?php } ?>
				  </td>
	              <td style="width:20%" ><label >Pag-ibig</label></td>
	            
                <td><p><?php 
                                      if(empty($employee_pagibig->cut_off_id)){
                                          echo "";

                                      }else{
                                              if($employee_pagibig->cut_off_id==1){
                                                echo "1st Cutoff Deduction";
                                              }elseif($employee_pagibig->cut_off_id==2){
                                                echo "2nd Cutoff Deduction";
                                              }elseif($employee_pagibig->cut_off_id==6){
                                                echo "Per Payday Deduction";
                                              }else{

                                              }
                                      }
                                    
                 ?>
                   
                 </p>
                </td>
	            </tr>

	            <tr>
	              <td style="width:5%" >
	              	<?php if($employee_salary->sss === '1'){?>
						<input type="checkbox" name="sss" id="sss" checked> 
					<?php } 
					else{ ?>
						<input type="checkbox" name="sss" id="sss"> 
					<?php } ?>
				  </td>
	              <td style="width:20%" ><label >SSS</label></td>
	              <td><p><?php 
                if(!empty($employee_sss)){
                  if($employee_sss->cut_off_id==1){
                    echo "1st Cutoff Deduction";
                  }elseif($employee_sss->cut_off_id==2){
                    echo "2nd Cutoff Deduction";
                  }elseif($employee_sss->cut_off_id==6){
                    echo "Per Payday Deduction";
                  }else{

                  }
                }else{

                }
                ?></p></td>
	            </tr>
	            
	            <tr>
	              <td style="width:5%" >
	              	<?php if($employee_salary->philhealth === '1'){?>
						<input type="checkbox" name="philhealth" id="philhealth" checked> 
					<?php } 
					else{ ?>
						<input type="checkbox" name="philhealth" id="philhealth"> 
					<?php } ?>
				  </td>
	              <td style="width:20%" ><label >PhilHealth</label></td>
	              <td><p><?php 
                if(!empty($employee_philhealth)){
                  if($employee_philhealth->cut_off_id==1){
                    echo "1st Cutoff Deduction";
                  }elseif($employee_philhealth->cut_off_id==2){
                    echo "2nd Cutoff Deduction";
                  }elseif($employee_philhealth->cut_off_id==6){
                    echo "Per Payday Deduction";
                  }else{

                  }
    
                }else{
                  
                }
                ?></p></td>
	            </tr>

	          </tbody>
	          </table>

	         </div>
	         </div>

	  	<?php }


	  	else{ ?>
	  	  <p style="color:#ff0000;" class='text-center'><strong>No Salary Information yet.</strong></p>
	  	<?php }?>

  	</div>
  	</div>

   </div>
   <!-- End of Salary Information -->
</div>