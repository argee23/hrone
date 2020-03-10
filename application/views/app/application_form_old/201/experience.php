<?php require_once(APPPATH.'views/app/application_form/footer.php');?>
<title>Work Experience</title>
<div class="box-header with-border">
  <h3 class="box-title">Work Experience</h3>
    <div class="box-tools pull-right">
      <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-success btn-sm">
    <i class="fa fa-plus"></i> Add Work Experience 
  </button>
    </div>
</div><br>

<div ng-init="getWorkExperience()">
  <div class="splash col-lg-12 fixed-panel" ng-cloak="">
    <div class="spinner">
      <div class="double-bounce1"></div>
      <div class="double-bounce2"></div>
    </div>
    <center><h3 class="text-primary">Please wait while data loads..</h3></center>
  </div>
 <div ng-cloak>
 <div ng-show="experiences.length == 0">
      <center>
      <h2>
        No work experience added yet.<br><small>Click 'Add Work Experience' button to add data.</small>
      </h2>
      </center>
  </div>
  <div class="col-lg-12 fixed-panel mCustomScrollbar" data-mcs-theme="dark">
<div class="box box-solid">
  <div ng-repeat="exp in experiences">
            <div class="box-header with-border bg-gray disabled color-palette">
              <i class="fa fa-black-tie"></i>

              <h4 class="box-title">{{exp.position_name}}</h4>
              <div class="pull-right">
                     <button type="button" class="btn btn-primary btn-xs" ng-click="copyWork(exp)" data-toggle="modal" data-target="#edit-work"><i class="fa fa-edit"></i> Edit</button>
                  <button type="button" class="btn btn-danger btn-xs" ng-click="copyWork(exp)" data-toggle="modal" data-target="#delete-work"><i class="fa fa-trash"></i> Delete</button>
                  </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <dl class="dl-horizontal">
                <dt>Company Name</dt>
                <dd>{{exp.company_name}}</dd>
                <dt>Company Address</dt>
                <dd>{{exp.company_address}}</dd>
                <dt>Reason for Leaving</dt>
                <dd>{{exp.reason_for_leaving}}</dd>
                <dt>Job  Description</dt>
                <dd><span class="multi_lines_text">{{ exp.job_description }}</span></dd>
                <dt>Work Duration</dt>
                <dd>{{exp.date_start | date: "mediumDate"}} - 
                      <span ng-show="exp.isPresentWork == 1">Present</span>
                      <span ng-show="exp.isPresentWork == 0">{{exp.date_end | date: "mediumDate"}}</span></dd>
                <dt>Salary</dt>
                <dd>{{exp.salary}}</dd>

              </dl>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
  </div>


  <!-- Add Experience Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Work Experience</h4>
        </div>
        <div class="modal-body">
           <form name="addworkexp" method="post" action="<?php echo base_url()?>app/application_form/update_work_experience" onsubmit="return  checkStartDate('start_date', 'addworkexp')">

            <div class="col-lg-12">
            <div class="col-lg-12">
              <div class="form-group has-feedback" ng-class="{'has-error' : addworkexp.position.$invalid}">
                <label>Job Position / Job Title: <small ng-show="addworkexp.position.$invalid"><i>Required</i></small></label>
                <select class="form-control" id="position" name="position" ng-model="work.position_name" ng-value="work.position_name" required>
                  <option value="" disabled selected>Select</option>
                  <?php 
                  $positionList = $this->general_model->position_applicant();
                  foreach($positionList as $pos)
                  {?>
                    <option><?php echo $pos->position_name;?></option>
                  <?php }?>
                </select>
              </div>
            </div>
              <div class="col-lg-6">

                  <div class="form-group has-feedback" ng-class="{'has-error' : addworkexp.company_name.$invalid}">
                      <label>Company Name: <small ng-show="addworkexp.company_name.$invalid"><i>Required</i></small></label>
                      <input type="text" class="form-control" id="company_name" name="company_name" ng-model="work.company_name" ng-value="work.company_name" required>
                  </div>


                  <div class="form-group has-feedback" ng-class="{'has-error' : addworkexp.company_address.$invalid}" >
                      <label>Company Address: <small ng-show="addworkexp.company_address.$invalid"><i>Required</i></small></label>
                      <input type="text" class="form-control" id="company_address" name="company_address" ng-model="work.company_address" ng-value="work.company_address" required>
                  </div>

                  <div class="form-group has-feedback">
                      <label>Start Date: *</label><br>
                      <input type="text" id="start_date" name="start_date" ng-model="work.date_start" ng-value="work.date_start">
                  </div>
              </div>


              <div class="col-lg-6">
                  <div class="form-group">
                      <label>Company Contact Number:</label>
                      <input type="text" class="form-control" id="company_contact" name="company_contact" ng-model="work.company_contact" ng-value="work.company_contact" data-inputmask="'mask': '+63-999-9999[-999]'">
                  </div>

                  <div class="form-group">
                      <label>Salary:</label><br>
                      <input type="text" class="form-control" id="salary" name="salary" ng-model="work.salary" ng-value="work.salary" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                  </div>

                  <div class="form-group">
                      <label>End Date:</label><br>
                      <input type="text" id="end_date" name="end_date" ng-model="work.date_end" ng-value="end.date_start" ng-disabled="work.isPresentWork == 1"><br>
                     <label><input type="checkbox" name="isPresentWork" id="isPresentWork" ng-model="work.isPresentWork" value="1"> Present Work</label>
                  </div>

              </div>
            
                <div class="form-group">
                  <label for="comment">Job Description:</label>
                  <textarea class="form-control" rows="5" id="comment"  id="job_description" name="job_description" ng-model="work.job_description" ng-value="work.job_description"></textarea>
                </div>
           

              <div class="form-group">
                  <label>Reason for Leaving:</label>
                  <input type="text" class="form-control" id="reason_for_leaving" name="reason_for_leaving" ng-model="work.reason_for_leaving" ng-value="work.reason_for_leaving">
              </div>

              <button type="submit" id="add_btn" class="btn btn-success btn-block" ng-disabled="addworkexp.$invalid"> Add Work Experience</button>
            </div>

           </form>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button> -->
        </div>
      </div>

    </div>
  </div> <!-- End Add Experience Modal -->

  <!-- Delete Modal -->
<div id="delete-work" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Experience</h4>
      </div>
      <div class="modal-body"><center>
        <p>Are you sure you want to delete the selected work experience?</p>
        <h4>{{selected_work.position_name}} - {{selected_work.company_name}}</h4>
        <form name="delete_work_ex" method="post" action="delete_work_ex">
        <input type="hidden" value="{{selected_work.work_experience_id}}" name="work_id" id="work_id">
        <button type="submit" class=" btn btn-warning">Yes</button>
        <button type="button" data-dismiss="modal" class="btn btn-info">No</button>
        </form>
        </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div> <!-- Delete Modal -->

<!-- Edit Experience Modal -->
<div id="edit-work" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Work Experience</h4>
      </div>
      <div class="modal-body">
        <form name="edit_work_exp" method="post" action="edit_work_ex" onsubmit="return  checkStartDate('edit_start_date', 'edit_work_exp')">
        <input type="hidden" value="{{selected_work.work_experience_id}}" id="work_id" name="work_id">
          <div class="col-lg-12">

            <div class="form-group has-feedback" ng-class="{'has-error' : edit_work_exp.position.$invalid}">
              <label>Job Position / Job Title: <small ng-show="edit_work_exp.position.$invalid"><i>Required</i></small></label>
              <input type="text" class="form-control" id="position" name="position" ng-model="selected_work.position_name" ng-value="selected_work.position_name" required>            
            </div>

            <div class="col-lg-6">
                <div class="form-group has-feedback" ng-class="{'has-error' : edit_work_exp.company_name.$invalid}">
                    <label>Company Name: <small ng-show="edit_work_exp.company_name.$invalid"><i>Required</i></small></label>
                    <input type="text" class="form-control" id="company_name" name="company_name" ng-model="selected_work.company_name" ng-value="selected_work.company_name" required>
                </div>


                <div class="form-group has-feedback" ng-class="{'has-error' : edit_work_exp.company_address.$invalid}" >
                    <label>Company Address: <small ng-show="edit_work_exp.company_address.$invalid"><i>Required</i></small></label>
                    <input type="text" class="form-control" id="company_address" name="company_address" ng-model="selected_work.company_address" ng-value="selected_work.company_address" required>
                </div>

                <div class="form-group has-feedback">
                    <label>Start Date: *</label><br>
                    <input type="text" id="edit_start_date" name="edit_start_date" ng-model="selected_work.date_start" ng-value="selected_work.date_start">
                </div>
            </div>


            <div class="col-lg-6">

                <div class="form-group">
                    <label>Company Contact Number:</label>
                    <input type="text" class="form-control" id="company_contact" name="company_contact" ng-model="selected_work.company_contact" ng-value="selected_work.company_contact" data-inputmask="'mask': '+63-999-9999[-999]'">
                </div>

                <div class="form-group">
                    <label>Salary:</label>
                    <input type="text" class="form-control" id="salary" name="salary" ng-model="selected_work.salary" ng-value="selected_work.salary"  data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                </div>

                <div class="form-group">
                    <label>End Date:</label><br>
                    <input type="text" id="edit_end_date" name="edit_end_date" ng-model="selected_work.date_end" ng-value="selected_work.end_date" ng-disabled="selected_work.isPresentWork == 1 || isPWork"><br>
                   <label><input type="checkbox" name="isPresentWork" id="isPresentWork" ng-model="isPWork" ng-checked="selected_work.isPresentWork == 1" ng-click="detectPresentWork()" value="1"> Present Work</label>
                </div>



            </div>

              <div class="form-group">
                  <label for="comment">Job Description:</label>
                  <textarea class="form-control" rows="5" id="comment"  id="job_description" name="job_description" ng-model="selected_work.job_description" ng-value="selected_work.job_description"></textarea>
                </div>
           

            <div class="form-group">
                <label>Reason for Leaving:</label>
                <input type="text" class="form-control" id="reason_for_leaving" name="reason_for_leaving" ng-model="selected_work.reason_for_leaving" ng-value="selected_work.reason_for_leaving">
            </div>


            <button type="submit" class="btn btn-success btn-block" ng-disabled="edit_work_exp.$invalid"><i class="fa fa-save"></i> Save Changes</button>
          </div>

         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

</div>
</div>



<script>
$('#start_date').Zebra_DatePicker({
  pair: $('#end_date'),
  direction: -1
});

$('#end_date').Zebra_DatePicker({
  direction: 1
});

$('#edit_start_date').Zebra_DatePicker({
  pair: $('#edit_end_date')
});

$('#edit_end_date').Zebra_DatePicker({
  direction: 0
});

function checkStartDate(datestart, form_name) {
    var x = document.forms[form_name][datestart].value;
    if (x == "") {
        alert("Please specify the date start field.");
        return false;
    }
}
</script>