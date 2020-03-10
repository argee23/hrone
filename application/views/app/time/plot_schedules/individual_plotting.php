<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Individual Plotting</h4></ol>

<div class="col-xs-2 col-xs-offset-3">
    <label>Company:</label>
</div>
  
<div class="col-xs-4">
    <select class="form-control" id="ip_company" onchange="get_ip_location(this.value)">
       <option value="none" disabled selected>Select</option>
         <?php foreach ($companyList as $company) {?>
            <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
        <?php } ?>
      </select>
</div>

<div class="col-xs-2 col-xs-offset-3" style="margin-top:10px;">
    <label>Location:</label>
</div>
  
<div class="col-xs-4" style="margin-top:10px;">
    <select class="form-control" id="ip_location">
       <option value="none">Select</option>
      </select>
</div>

<div class="col-xs-2 col-xs-offset-3" style="margin-top:10px;">
    <label>Employee</label>
</div>
  
<div class="col-xs-4" style="margin-top:10px;">
    <input type="hidden" id="ip_employee_id">
      <a data-toggle="modal" data-target="#search_employee_modal"><input type="text" class="form-control" placeholder="Select Employee" id="ip_name" required></a>
</div>

<div class="col-xs-5 col-xs-offset-4" style="margin-top:10px;">
     <button class="btn btn-success pull-right" onclick="ip_show_employee();">PLOT</button>
</div>            
<br><br><br><br><br><br><br><br><br>
<input type="hidden" name="emp_pp_value" id="emp_pp_value">
<div class="box box-danger" class='col-md-12'></div>
