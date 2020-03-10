<form method="post" action="<?php echo base_url()?>app/payroll_compensation/modify_government_deduction/<?php echo $employee_salary->salary_id; ?>" >

<label>Government Deduction Subject To</label>

<i class="fa fa-times-circle fa-2x text-danger pull-right" data-toggle='tooltip' data-placement='left' title='Close' onclick="view_employee_salary('<?php echo $employee_salary->employee_id; ?>')"></i>

<br>
<div class="box box-danger"></div>

	<div class="col-md-12">

  <table class="table table-striped">
  <tbody>
    <tr>
      <td style="width:5%" >
    <?php if($employee_salary->withholding_tax === '1'){?>
      <input type="hidden" name="withholding_tax" id="withholding_tax" value="0"> 
			<input type="checkbox" name="withholding_tax" id="withholding_tax" value="1" checked=""> 
		<?php } 
		else{ ?>
      <input type="hidden" name="withholding_tax" id="withholding_tax" value="0"> 
			<input type="checkbox" name="withholding_tax" id="withholding_tax" value="1"> 
		<?php } ?>
	  </td>
      <td style="width:20%" ><label>Withholding tax</label></td>
      <td></td>
    </tr>

    <tr>
      <td style="width:5%" >
      	<?php if($employee_salary->pagibig === '1'){?>
      <input type="hidden" name="pagibig" id="pagibig" value="0"> 
			<input type="checkbox" name="pagibig" id="pagibig" value="1" checked> 
		<?php } 
		else{ ?>
      <input type="hidden" name="pagibig" id="pagibig" value="0"> 
			<input type="checkbox" name="pagibig" id="pagibig" value="1" >
		<?php } ?>
	  </td>
      <td style="width:20%" ><label >Pag-ibig</label></td>
      <td><p><?php
      if(!empty($employee_pagibig)){
                                              if($employee_pagibig->cut_off_id==1){
                                                echo "1st Cutoff Deduction";
                                              }elseif($employee_pagibig->cut_off_id==2){
                                                echo "2nd Cutoff Deduction";
                                              }elseif($employee_pagibig->cut_off_id==6){
                                                echo "Per Payday Deduction";
                                              }else{

                                              }
      }else{
        ?>

        <?php
        }

       ?></p></td>
    </tr>

    <tr>
      <td style="width:5%" >
      	<?php 
        if(!empty($employee_salary)){
          if($employee_salary->sss === '1'){

          ?>
              <input type="hidden" name="sss" id="sss" value="0"> 
              <input type="checkbox" name="sss" id="sss" value="1" checked> 
          <?php
          }else{
          ?>
           <input type="hidden" name="sss" id="sss" value="0"> 
      <input type="checkbox" name="sss" id="sss" value="1"> 
          <?php
          }
        }else{

        }

         ?>
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
      	<?php 

        if(!empty($employee_salary)){
          if($employee_salary->philhealth === '1'){
        ?>
              <input type="hidden" name="philhealth" id="philhealth" value="0"> 
              <input type="checkbox" name="philhealth" id="philhealth" value="1" checked> 
        <?php
          }else{
        ?>
      <input type="hidden" name="philhealth" id="philhealth" value="0"> 
      <input type="checkbox" name="philhealth" id="philhealth" value="1"> 
        <?php
          }
        }else{
        ?>
      <input type="hidden" name="philhealth" id="philhealth" value="0"> 
      <input type="checkbox" name="philhealth" id="philhealth" value="1"> 
        <?php
        }

        ?>
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

<div class="form-group">
	<button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> MODIFY</button>
</div>

 </form>