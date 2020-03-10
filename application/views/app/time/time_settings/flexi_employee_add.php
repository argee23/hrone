<div class="well">
<!-- form start -->
      <?php $company_id= $this->uri->segment('4'); 
$location_name=$this->time_settings_model->get_location($company_id);
if(!empty($location_name)){
      $cur_loc= $location_name->company_name; //current location
      $cur_loc_id= $location_name->company_id; //current location
}else{
      $cur_loc ="<i class='fa fa-warning text-danger'></i> Location not found.";
}
?>

  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/time_settings/save_flexi_employee_add/<?php echo $cur_loc_id;?>" >
      <div class="form-group">
        <div class="col-sm-12">
     <i class="fa fa-plus text-danger"></i><strong>Individual Employee Flexi Schedule Tagging  [ <?php echo $cur_loc;?> ]</strong>
        </div>
      </div>
      <input type="hidden" name="company_id" value="<?php echo $cur_loc_id;?>">
      <div class="form-group" id="show_selected_emp">
      <label for="employee"><a type="button" class="btn btn-success btn-xs pull-left" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user-plus"></i></a> &nbsp;&nbsp;[Select Employee]</label>
      <a data-toggle="modal" data-target="#showEmployeeList"><input type="text" class="form-control" placeholder="Select Employee" ></a>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Monday</label>
        <div class="col-sm-6">
          <select name="monday" class="form-control select2" required>
            <option value="0" selected disabled>Select</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Tuesday</label>
        <div class="col-sm-6">
          <select name="tuesday" class="form-control select2" required>
            <option value="0" selected disabled>Select</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Wednesday</label>
        <div class="col-sm-6">
          <select name="wednesday" class="form-control select2" required>
            <option value="0" selected disabled>Select</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Thursday</label>
        <div class="col-sm-6">
          <select name="thursday" class="form-control select2" required>
            <option value="0" selected disabled>Select</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Friday</label>
        <div class="col-sm-6">
          <select name="friday" class="form-control select2" required>
            <option value="0" selected disabled>Select</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Saturday</label>
        <div class="col-sm-6">
          <select name="saturday" class="form-control select2" required>
            <option value="0" selected disabled>Select</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Sunday</label>
        <div class="col-sm-6">
          <select name="sunday" class="form-control select2" required>
            <option value="0" selected disabled>Select</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Start Shift on Actual Time IN</label>
        <div class="col-sm-6">
          <select name="base_on_actual_time_in" class="form-control select2" required>
            <option value="0" selected disabled>Select</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Shift Hours</label>
        <div class="col-sm-6">
          <select name="shift_hours" class="form-control select2" required>
            <option value="0" selected disabled>Select</option>
            <option value="8">8.00 hrs</option>
            <option value="9">9.00 hrs</option>
            <option value="10">10.00 hrs</option>
            <option value="11">11.00 hrs</option>
            <option value="12">12.00 hrs</option>
          </select>
        </div>
      </div>
      <div class="form-group">
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
          </div>
  </form>
  </div>



  <!--//======================================Employee List Modal Container ==============================//-->
<div class="modal modal-primary fade" id="showEmployeeList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Select Employee</h4>
                </div>
          <div class="modal-body"> 

<input type="hidden" name="company_id" value="<?php echo $cur_loc_id;?>">
                                       
<input onKeyUp="get_employees()" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                        <span id="showSearchResult">                        </span>


          </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>                          
          </div>
      </div>
</div><!-- /.box-body -->
<!--//====================================== End Employee List Modal Container ==============================//-->