<title>Educational Attainment</title>
<div class="box-header with-border">
  <h3 class="box-title">Educational Attainment</h3>
    <div class="box-tools pull-right">
    <button type="button"  data-toggle="modal" data-target="#add-education" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Education </button>
    </div>
</div><br>

<div ng-init="getEducation()">
<div class="splash col-lg-12 fixed-panel" ng-cloak="">
    <div class="spinner">
      <div class="double-bounce1"></div>
      <div class="double-bounce2"></div>
    </div>
    <center><h3 class="text-primary">Please wait while data loads..</h3></center>
</div>
<div ng-cloak>
  <div ng-show="educations.length == 0">
    <center><h2>No data yet.<br><small>Click 'Add Education' button to add data.</small></h2></center>
  </div>
<div class="col-lg-12 fixed-panel mCustomScrollbar" data-mcs-theme="dark">

<div class="box box-solid" ng-repeat="ed in educations track by $index">
            <div class="box-header with-border">
              <i class="fa fa-graduation-cap fa-border"></i>

              <h4 class="box-title">{{ed.education_name}} <span class="text-info" ng-show="ed.course != null && ed.course.length > 0">({{ed.course}})</span></h4>
               <div class="pull-right">
                          <button type="button" class="btn btn-primary btn-xs" ng-click="editEducation(ed)" data-toggle="modal" data-target="#edit-education"><i class="fa fa-edit"></i> Edit</button>
                <button type="button" class="btn btn-danger btn-xs"  ng-click="editEducation(ed)" data-toggle="modal" data-target="#delete-education"><i class="fa fa-trash"></i> Delete</button>
               </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <dl class="dl-horizontal">
                <dt>School Name</dt>
                <dd>{{ed.school_name}}</dd>
                <dt>School Address</dt>
                <dd>{{ed.school_address}}</dd>
                <dt>Honors</dt>
                <dd>{{ed.honors}}</dd>
                <dt>Education Duration</dt>
                <dd>
                 {{ed.date_start | date: "mediumDate"}} - 
                        
                            <span ng-if="ed.isGraduated == 1">{{ed.date_end | date: "mediumDate"}}</span>
                            <span ng-if="ed.isGraduated == 0">Present</span>
                </dd>
              </dl>
            </div>
            <!-- /.box-body -->
          </div>
</div>

<!-- Edit Education Modal -->
<div id="edit-education" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Educational Attainment</h4>
      </div>
      <div class="modal-body">

            <form name="editeducation" method="post" action="edit_education" onsubmit="return  checkStartDate('edit_date_start', 'editeducation')">
                <input type="hidden" value="{{selected_education.id}}" id="id" name="id">
                <div class="form-group has-feedback">
                    <label>Education Type: </label>
                    <select class="form-control" id="education_id" name="education_id" ng-model="selected_education.education_id" ng-selected="selected_education.education_id">
                        <option ng-repeat="ed in dataList.educations track by ed.education_id" ng-if="ed.InActive == 0" value="{{ed.education_id}}"  ng-disabled="isExisting(ed.education_id) && selected_education.education_id != ed.education_id">{{ed.education_name}}</option>
                    </select>
               </div>

                <div class="form-group has-feedback" ng-class="{'has-error' : editeducation.school_name.$invalid}">
                    <label>School Name: <small ng-show="editeducation.school_name.$invalid"><i>School name is required.</i></small> </label>
                    <input type="text" class="form-control" id="school_name" name="school_name" ng-model="selected_education.school_name" required>
                </div>

                <div class="form-group has-feedback" ng-class="{'has-error' : editeducation.school_address.$invalid}">
                    <label>School Address: <small ng-show="editeducation.school_address.$invalid"><i>School address is required.</i></small> </label>
                    <input type="text" class="form-control" id="school_address" name="school_address" ng-model="selected_education.school_address" required>
                </div>

                <div class="form-group has-feedback">
                    <label>Course: </label>
                    <input type="text" class="form-control" id="course" name="course" ng-model="selected_education.course" ng-disabled="selected_education.education_id < 3">
                 </div>

                <div class="form-group has-feedback">
                    <label>Honors: </label>
                    <input type="text" class="form-control" id="honors" name="honors" ng-model="selected_education.honors">
                 </div>

                <div class="form-group has-feedback col-xs-6" ng-class="{'has-error' : editeducation.date_start.$invalid}">
                    <label>Date Started: <small>*required</small></label><br>
                    <input type="text" id="edit_date_start" name="edit_date_start" ng-model="selected_education.date_start">
                 </div>

                <div class="form-group has-feedback col-xs-6">
                    <label>Date Graduated: <small>*required</small></label><br>
                    <input type="text" ng-model="selected_education.date_end" id="edit_date_end" name="edit_date_end" ng-disabled="isGrad || selected_education.isGraduated == 0">

                    <label><input type="checkbox" name="isGraduated" id="isGraduated" ng-model="isGrad" ng-checked="selected_education.isGraduated == 0" ng-click="detectPresentEd()" value="0"> Not yet finished</label>
                 </div>

                <center><button type="submit" class="btn btn-success btn-block"><i class="fa fa-save"></i> Save Changes</button></center>
            </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End Edit Education -->

<!-- Delete Modal -->
<div id="delete-education" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Educational Attainment Record</h4>
      </div>
      <div class="modal-body"><center>
        <p>Are you sure you want to delete the selected Educational Attainment record?</p>
        <h4><span>{{selected_education.education_name}} - {{selected_education.school_name}}</span></h4>
        <form name="delete_ed" method="post" action="delete_education">
        <input type="hidden" value="{{selected_education.id}}" name="id" id="id">
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


<!-- Add Education Modal -->
<div id="add-education" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center>Add Education</center></h4>
      </div>
      <div class="modal-body">
            <form name="addeducation" method="post" action="add_education" onsubmit="return checkStartDate('date_start', 'addeducation')">

                <div class="form-group has-feedback" ng-class="{'has-error' : addeducation.education_id.$invalid}">
                    <label>Education Type: <small ng-show="addeducation.education_id.$invalid"><i>Education type is required.</i></small></label>
                    <select class="form-control" id="education_id" name="education_id" ng-model="selected_type" required>
                        <option ng-repeat="ed in dataList.educations" value="{{ed.education_id}}"
                        ng-disabled="isExisting(ed.education_id)">{{ed.education_name}}</option>
                    </select>
               </div>

                <div class="form-group has-feedback" ng-class="{'has-error' : addeducation.school_name.$invalid}">
                    <label>School Name: <small ng-show="addeducation.school_name.$invalid"><i>School name is required.</i></small> </label>
                    <input type="text" class="form-control" id="school_name" name="school_name" ng-model="school_name" required>
                </div>

                <div class="form-group has-feedback" ng-class="{'has-error' : addeducation.school_address.$invalid}">
                    <label>School Address: <small ng-show="addeducation.school_address.$invalid"><i>School address is required.</i></small> </label>
                    <input type="text" class="form-control" id="school_address" name="school_address" ng-model="school_address" required>
                </div>

                <div class="form-group has-feedback">
                    <label>Course: </label>
                    <input type="text" class="form-control" id="course" name="course" ng-disabled="selected_type < 3">
                 </div>

                <div class="form-group has-feedback">
                    <label>Honors: </label>
                    <input type="text" class="form-control" id="honors" name="honors">
                 </div>

                <div class="form-group has-feedback col-xs-6" ng-class="{'has-error' : addeducation.date_start.$invalid}">
                    <label>Date Started: *</label><br>
                    <input type="text" id="date_start" name="date_start" ng-model="date_start">
                 </div>

                <div class="form-group has-feedback col-xs-6">
                    <label>Date Graduated: *</label><br>
                    <input type="text" id="date_end" name="date_end" ng-disabled="isGraduated">

                    <label><input type="checkbox" name="isGraduated" id="isGraduated" ng-model="isGraduated" value="0"> Not yet finished</label>
                 </div>

                <center><button type="submit" class="btn btn-success btn-block" ng-disabled="addeducation.$invalid">Add Education</button></center>
            </form>

      </div>
      <div class="modal-footer">
        <button  type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div> <!-- End Add Education Modal -->
</div>
</div>

<script>
$('#date_start').Zebra_DatePicker({
  pair: $('#end_date'),
  direction: -1
});

$('#date_end').Zebra_DatePicker({
  direction: 1
});

$('#edit_date_start').Zebra_DatePicker({
  pair: $('#edit_date_end'),
  direction: -1
});

$('#edit_date_end').Zebra_DatePicker({
});

function checkStartDate(datestart, form_name) {
    var x = document.forms[form_name][datestart].value;
    if (x == "") {
        alert("Please specify the date start field.");
        return false;
    }
}
</script>