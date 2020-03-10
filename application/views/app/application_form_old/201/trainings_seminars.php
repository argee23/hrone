<title>Trainings and Seminars</title>
<div class="box-header with-border">
  <h3 class="box-title">Trainings and Seminars</h3>
    <div class="box-tools pull-right">
    <button type="button" data-toggle="modal" data-target="#add-training" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Training/Seminar </button>
    </div>
</div><br>
<div ng-init="getTrainings()">
    <div class="splash col-lg-12 fixed-panel" ng-cloak="">
    <div class="spinner">
  <div class="double-bounce1"></div>
  <div class="double-bounce2"></div>
</div>
<center><h3 class="text-primary">Please wait while data loads..</h3></center>
    </div>
<div ng-cloak>
<div ng-show="trainings.length == 0">
<center><h2>No data yet.<br><small>Click 'Add Training/Seminar' button to add data. </center> </h2></small>

</div>
<div class="col-lg-12 fixed-panel mCustomScrollbar" data-mcs-theme="dark">

<div class="panel panel-default" ng-repeat="training in trainings">
  <div class="panel-body">
    
    <div class="col-lg-8">
    <strong><h4 class="text-success">{{training.training_title}}</h4></strong>
      <strong>Held at</strong> {{training.training_address}}<br>
      <strong>Conducted by</strong> {{training.conducted_by}}, {{training.training_institution}} <br>
      <b>{{training.date_start | date: "mediumDate"}} <span ng-show="training.isOneDay != 1"> - {{training.date_end | date: "mediumDate"}} </span></b>
      <br><br>
      <center>
      <button type="button" ng-click="editTraining(training)" data-toggle="modal" data-target="#edit-training" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</button>
      <button type="button" ng-click="editTraining(training)" data-toggle="modal" data-target="#delete-training" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
      </center>
    </div>
    <div class="col-lg-4">
      <div ng-show="training.file_name != ''">
        <img src="<?php echo base_url()?>public/applicant_files/certificates/{{training.file_name}} ?>" class="img-responsive img-thumbnail" style="width:200px">
      </div>

       <div ng-show="training.file_name == ''">
        <img src="<?php echo base_url()?>public/applicant_files/certificates/empty.png ?>" class="img-responsive img-thumbnail" style="width:200px">
      </div>
    </div>
  </div>
</div>
</div>

<!-- Modal -->
<div id="add-training" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center>Add Training / Seminar</center></h4>
      </div>
      <div class="modal-body">
         <form name="addtraining" method="post" action="add_training" enctype="multipart/form-data" onsubmit="return  checkStartDate('date_start', 'addtraining')">

                <div class="form-group has-feedback" ng-class="{'has-error' : addtraining.training_title.$invalid}">
                    <label>Training/Seminar Title: <small ng-show="addtraining.training_title.$invalid"><i>Training/Seminar title is required.</i></small> </label>
                    <input type="text" class="form-control" id="training_title" name="training_title" ng-model="training_title" placeholder="Title of the Training" required>
                </div>

                <div class="form-group has-feedback" ng-class="{'has-error' : addtraining.training_address.$invalid}">
                    <label>Venue: <small ng-show="addtraining.training_address.$invalid"><i>Venue is required.</i></small> </label>
                    <input type="text" class="form-control" id="training_address" name="training_address" placeholder="Venue Address" ng-model="training_address" required>
                </div>

                <div class="form-group has-feedback" ng-class="{'has-error' : addtraining.training_institution.$invalid}">
                    <label>Institution: <small ng-show="addtraining.training_institution.$invalid"><i>Institution is required.</i>
                    </small> </label>
                    <input type="text" class="form-control" id="training_institution" name="training_institution" placeholder="Training Institution" ng-model="training_institution" required>
                </div>

                <div class="form-group has-feedback" ng-class="{'has-error' : addtraining.conducted_by.$invalid}">
                    <label>Conducted By: <small ng-show="addtraining.conducted_by.$invalid"><i>This field is required.</i></small> </label>
                    <input type="text" class="form-control" id="conducted_by" name="conducted_by" ng-model="conducted_by" required>
                </div>

                <div class="form-group">
                    <label>Date Started: *</label><br>
                    <input type="text" id="date_start" name="date_start" required>
                 </div>

                <div class="form-group">
                    <label>Date Ended: *</label><br>
                    <input type="text" id="date_end" name="date_end" ng-disabled="isOneDay" required><br>

                    <label><input type="checkbox" name="isOneDay" id="isOneDay" ng-model="isOneDay" value="1"> One day event</label>
                </div>

                <div class="form-group has-feedback">
                    <label>Certification Image: <small><i>Accepted Files: PNG, JPG, GIF | File size must not exceed 500 KB</i></small></label>
                    <input type="file" class="btn btn-info" id="file_name" name="file_name">
                </div>

                <center><button type="submit" class="btn btn-success btn-block" ng-disabled="addtraining.$invalid">Add Training/Seminar</button></center>

         </form>
      </div>
      <div class="modal-footer">
        <button  type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Edit Training Modal -->
<div id="edit-training" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center>Edit Training / Seminar</center></h4>
      </div>
      <div class="modal-body">
         <form name="edittraining" method="post" action="edit_training" enctype="multipart/form-data" onsubmit="return  checkStartDate('edit_date_start', 'edittraining')">
            <input type="hidden" value="{{selected_training.training_seminar_id}}" name="id" value="id">
                <div class="form-group has-feedback" ng-class="{'has-error' : edittraining.training_title.$invalid}">
                    <label>Training/Seminar Title: <small ng-show="edittraining.training_title.$invalid"><i>Training/Seminar title is required.</i></small> </label>
                    <input type="text" class="form-control" id="training_title" name="training_title" ng-model="selected_training.training_title" placeholder="Title of the Training" required>
                </div>

                <div class="form-group has-feedback" ng-class="{'has-error' : edittraining.training_address.$invalid}">
                    <label>Venue: <small ng-show="edittraining.training_address.$invalid"><i>Venue is required.</i></small> </label>
                    <input type="text" class="form-control" id="training_address" name="training_address" placeholder="Venue Address" ng-model="selected_training.training_address" required>
                </div>

                <div class="form-group has-feedback" ng-class="{'has-error' : edittraining.training_institution.$invalid}">
                    <label>Institution: <small ng-show="edittraining.training_institution.$invalid"><i>Institution is required.</i>
                    </small> </label>
                    <input type="text" class="form-control" id="training_institution" name="training_institution" placeholder="Training Institution" ng-model="selected_training.training_institution" required>
                </div>

                <div class="form-group has-feedback" ng-class="{'has-error' : edittraining.conducted_by.$invalid}">
                    <label>Conducted By: <small ng-show="edittraining.conducted_by.$invalid"><i>This field is required.</i></small> </label>
                    <input type="text" class="form-control" id="conducted_by" name="conducted_by" ng-model="selected_training.conducted_by" required>
                </div>

                <div class="form-group">
                    <label>Date Started: *</label><br>
                    <input type="text" id="edit_date_start" name="edit_date_start" ng-value="selected_training.date_start" ng-model="selected_training.date_start">
                 </div>

                <div class="form-group">
                    <label>Date Ended: *</label><br>
                    <input type="text" id="edit_date_end" name="edit_date_end" ng-disabled="selected_training.isOneDay == 1 || isOneDay" ng-model="selected_training.date_end"><br>

                    <label><input type="checkbox" name="isOneDay" id="isOneDay" ng-click="trackTraining()" ng-checked="selected_training.isOneDay == 1" ng-model="isOneDay" value="1" > One day event</label>
                </div>


                <div class="form-group has-feedback">
                    <label>Certification Image: <small><i>Accepted Files: PNG, JPG, GIF | File size must not exceed 500 KB</i></small></label>
                    <input type="file" class="btn btn-info" id="file_name" name="file_name">
                </div>

                <center><button type="submit" class="btn btn-success btn-block" ng-disabled="edittraining.$invalid"><i class="fa fa-save"></i> Save Changes</button></center>

         </form>
      </div>
      <div class="modal-footer">
        <button  type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Edit Training Modal -->

  <!-- Delete Modal -->
  <div id="delete-training" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Training/Seminar</h4>
        </div>
        <div class="modal-body"><center>
          <p>Are you sure you want to delete the selected Training/Seminar?</p>
          <h4>{{selected_training.training_title}}</h4>
          <form name="delete_training" method="post" action="delete_training">
          <input type="hidden" value="{{selected_training.training_seminar_id}}" name="id" id="id">
          <input type="hidden" value="{{selected_training.file_name}}" name="file_name" id="file_name">
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

</div>
</div>
<?php require_once(APPPATH.'views/app/application_form/footer.php');?>

<script>

$('#date_start').Zebra_DatePicker({
  pair: $('#end_date'),
  direction: -1 //Allow Past Days only
});

$('#date_end').Zebra_DatePicker({
});

$('#edit_date_start').Zebra_DatePicker({
  pair: $('#edit_end_date'),
  direction: -1 //Allow Past Days only
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