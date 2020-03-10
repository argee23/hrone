<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">

<!-- DataTables -->
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url()?>public/jquery-1.7.2.min.js"></script>

<div class="col-md-12">
<a onclick="get_company_employee('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="View Enrolled Employee list"><i class="fa fa-arrow-circle-left fa-2x text-danger pull-right"></i></a>
</div>

<div class="col-md-12">

	<div id = "location">
	<div class="col-md-4">
	<div class="form-group">
	    <label for="location">Location</label>
	    <select class="form-control select2" name="location" id="location" style="width: 100%;" onchange="applyFilterlocation(this.value);">
	      <option selected="selected" value="0">-all location-</option>
	      <?php 
	        foreach($company_locations as $location){
	        if($_POST['location'] == $location->location_id){
	            $selected = "selected='selected'";
	        }else{
	            $selected = "";
	        }
	        ?>
	        <option value="<?php echo $location->location_id;?>" <?php echo $selected;?>><?php echo $location->location_name;?></option>
	        <?php }?>
	    </select>
	</div>
	</div>
	</div>

	<div id = "classification">
	<div class="col-md-4">
	<div class="form-group">
	    <label for="classification">Classification</label>
	    <select class="form-control select2" name="classification" id="classification" style="width: 100%;" onchange="applyFilterclassification(this.value);">
	      <option selected="selected" value="0">-all classification-</option>
	      <?php 
	        foreach($company_classification as $classification){
	        if($_POST['classification'] == $classification->classification_id){
	            $selected = "selected='selected'";
	        }else{
	            $selected = "";
	        }
	        ?>
	        <option value="<?php echo $classification->classification_id;?>" <?php echo $selected;?>><?php echo $classification->classification;?></option>
	        <?php }?>
	    </select>
	</div>
	</div>
	</div>

	<?php if($company_info->wDivision === "1"){ ?>
	<div id = "division">
	<div class="col-md-4">
	<div class="form-group">
	<label >Division</label>
	<select class="form-control" name="division" id="division" onchange="getDepartment(this.value); applyFilterdivision(this.value)">
	  <option selected="selected" value="0">~all division~</option>
	  <?php 
	     foreach($company_division as $division ){
	    if($_POST['division_employee'] == $division->division_id){
	        $selected = "selected='selected'";
	    }else{
	        $selected = "";
	    }
	    ?>
	    <option value="<?php echo $division->division_id;?>" <?php echo $selected;?>><?php echo $division->division_name;?></option>
	    <?php }?>
	</select>
	</div>
	</div>
	</div>

	<div id = "department">
	<div class="col-md-4">
	<div class="form-group">
	<label for="department">Department</label>
	<select class="form-control" name="department" id="department" >
	  <option selected="selected" value="0">~all department~</option>
	</select>
	</div>
	</div>
	</div>

	<?php } ?>

	<?php if($company_info->wDivision === "0"){ ?>
	<div id = "department">
	<div class="col-md-4">
	<div class="form-group">
	<label for="department">Department</label>
	<select class="form-control" name="department" id="department" onchange="getSection(this.value); applyFilterdepartment(this.value);">
	    <option selected="selected" value="0">~all department~</option>
	    <?php 
	      foreach($company_department as $department){
	      if($_POST['department'] == $department->department_id){
	          $selected = "selected='selected'";
	      }else{
	          $selected = "";
	      }
	      ?>
	      <option value="<?php echo $department->department_id;?>" <?php echo $selected;?>><?php echo $department->dept_name;?></option>
	      <?php }?>
	</select>
	</div>
	</div>
	</div>
	<?php } ?>

	<div id = "section">
	<div class="col-md-4">
	<div class="form-group">
	<label>Section</label>
	<select class="form-control" name="section" id="section" >
	  <option selected="selected" value="0">~all section~</option>
	</select>
	</div>
	</div>
	</div>

	<div id = "subsection">
	</div>

</div>





<form method="post" action="<?php echo base_url()?>app/payroll_incentive_leave/save_employee_incentive/<?php echo $this->uri->segment("4");?>" >


<div class="col-md-12">
<div class="col-md-6">
<div class="form-group">
<label >Equivalent Incentive Leave</label>
<select class="form-control" name="equivalent_incentive_leave" id="equivalent_incentive_leave" required>
  <option selected="selected" value="" disabled="">~select incentive leave equivalent~</option>
  <option value="force_incentive_leave">Force to incentive leave</option>
  <option value="has_an_option" >Has an option(OT pay or Incentive Leave)</option>
</select>
<p style="color:#ff0000;">Equivalent Incentive Leave is required</p>
</div>
</div>
</div>

<div id = "search_here">

<div class="col-md-12">
<div class="col-md-6">
<div class="form-group">
<!--<input type="hidden" value="<?php echo $this->uri->segment("11");?>" name="selectvalue">
<input type="checkbox" name="selectall" id="selectall" value="yes" onclick="select_all_employee(this.value);" > -->
<input type="checkbox" class="checkall" id="selectall">

<label >Select All Employee</label>
</div>
</div>
</div>

<div class="col-md-12">
<!-- <div id = "search_here"> -->
<div class="form-group">
<!-- <div class="scrollbar_all" id="style-1"> -->
<!-- <div class="force-overflow"> -->
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Employee ID</th>
          <th>Employee Name</th>
          <!-- <th>Equivalent Incentive Leave</th> -->
        </tr>
      </thead>
      <tbody>
       <?php 
       $display = 'A';
       foreach($available_employee as $employee){ ?>
        <tr>
          <td>
          <!-- <input type="checkbox" name="employeeselected[]" value="<?php echo $employee->employee_id?>" onclick="incentive_leave_equivalent('<?php echo $display; ?>');" > -->
          <input type="checkbox" name="employeeselected[]" class="case" name="case" value="<?php echo $employee->employee_id?>" >
          <?php echo '   '.$employee->employee_id?> </td>
          <td><?php echo $employee->first_name.' '.$employee->last_name.' '.$employee->middle_name.' '.$employee->name_extension?></td>
          <!-- <td>
          	<div id= "<?php echo $display ?>">
          	</div>
          </td> -->
        </tr>
       <?php $display++; } ?>
      </tbody>
    </table>
<!-- </div> -->
<!-- </div> -->
</div>
</div>

<div class="form-group">
<button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-user-plus"></i> ADD EMPLOYEE(S)</button>
</div>

<!--</div> -->

</div>

</form>


<script>
$(function () {

  $("#example1").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false
  });
  /*$("#example1").DataTable();
  $('#example2').DataTable( {
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false
    } );*/

});

</script>

<style>

      .scrollbar {

        height: 320px;
        overflow-x: hidden;
        overflow-y: scroll;
      }

      .scrollbar_all {

        height: 450px;
        overflow-x: hidden;
        overflow-y: scroll;
      }


      .force-overflow {
          min-height: 250px;
      }

      #style-1::-webkit-scrollbar {
          width: 5px;
          background-color: #d9edf7;
      } 

      #style-1::-webkit-scrollbar-thumb {
          background-color: #3c8dbc;
      }

      #style-1::-webkit-scrollbar-track {
          -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.3);
          background-color: #d9edf7;
      }
</style>
