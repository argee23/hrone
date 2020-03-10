<?php
//echo $selected_spec_cov;

if($selected_spec_cov=="by_individual"){
?>

    <div class="col-md-12"  id="show_selected_emp">
      <label for="next" class="col-sm-3 control-label"><a type="button" class="" data-toggle="modal" data-target="#showEmployeeList"></a>Invidual Employee</label>
        <div class="col-sm-6" >
          <span id="hey" style="display: none;font-style: italic;color: #ff0000;">(Invidual employee processing is hidden as you have chosen to process via group) </span>
              <a data-toggle="modal" data-target="#showEmployeeList" id="ieh"><input type="text" id="selected_individual_employee_id" class="form-control col-sm-12" placeholder="For Individual Report Only : Click to Select Employee" onclick="disable_group_process()"></a>
        </div>
    </div>  

<?php
}else{

}
?>

