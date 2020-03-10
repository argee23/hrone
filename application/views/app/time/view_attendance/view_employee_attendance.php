<?php
  if(!empty($employee)){
    $company_id=$employee->company_id;
  }else{
    $company_id="";
  }
?>

<div class="col-md-12">
<div class="box box-primary">
<div class="panel panel-info">

<div class="panel-heading"><strong>ATTENDANCE RECORD</strong>

<a <?php echo "onclick='fetch_employees(".$company_id.")'";?> type="button" class="btn btn-primary btn-xs pull-right" title="Select employee" ><i class="fa fa-arrow-circle-left"></i> Select a employee</a></div>

	<div class="box-body">
	<div class="panel panel-success">
	<div class="box-body">

	<div class="col-md-12">
	<div class="row">


	<?php  
  if(!empty($employee)){

    $employee_id = $employee->employee_id; ?>
            
          <table class="table table-striped">
          <tbody>
            <tr>
              <td style="width:15%">Employee ID</td>
              <td><label><?php echo $employee->employee_id; ?></label></td>
            </tr>
            <tr>
              <td style="width:15%">Fullname</td>
              <td><label><?php echo $employee->name; ?></label></td>
            </tr>
            <tr>
              <td>Company</td>
              <td><label><?php echo $employee->company_name; ?></label></td>
              <td>Location</td>
              <td><label><?php echo $employee->location_name; ?></label></td>
              
              <?php if($employee->wDivision == 1){ ?>
              <td>Division</td>
              <td><label><?php echo $employee->division_name; ?></label></td>
              <?php } ?>
            </tr>
            <tr>
              <td>Department</td>
              <td><label><?php echo $employee->dept_name; ?></label></td>
              <td>Section</td>
              <td><label><?php echo $employee->section_name; ?></label></td>
               <?php if($employee->wSubsection == 1){ ?>
              <td>Subsection</td>
              <td><label><?php echo $employee->subsection_name; ?></label></td>
              <?php } ?>
            </tr>
          </tbody>
          </table>

    <?php }else{ // employee not found.
      } ?>

    <div class="col-md-4">
      <div class="form-group">
        <label for="company">Year</label>
        <select class="form-control" name="year" id="year" onchange="get_monthList(<?php echo $employee_id; ?>);">
          <option selected="selected" value="0" disabled>-Select Year-</option>
          <?php
            foreach($covered_year as $year){
              if($_POST['year'] == $year->yy){
                $selected = "selected='selected'";
              }else{
                $selected = "";
              }
            ?>
            <option value="<?php echo $year->yy;?>" <?php echo $selected;?>><?php echo $year->yy;?></option>
          <?php }?>
          </select>
      </div>
    </div>

    <div id="get_month">
    </div>

    <div id="get_day">
    </div>

    <!-- ================================================Display================================================== -->
    <div id="search_attendance">
  
  </div>




    <!-- ============================================== Display end ============================================== -->

	</div>
	</div>

	</div>
	</div>
	</div>

</div>
</div>
</div>