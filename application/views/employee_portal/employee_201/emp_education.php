<div class="col-md-9">
  <div class="tab-content">
    <div class="tab-pane active" id="p_info">
      <div class="panel panel-success"> 
        <div class="panel-heading">
          <span class="pull-right"> 
            <?php if($setting=='allowed') {   if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else{ ?><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add-education"><i class="fa fa-plus"></i> Add Educational Attainment</button><?php } } else{?>
              <a href="#editable_topics">View editable topic</a>
            <?php } ?>
          </span>
          <h4 class="text-danger"><?php if($setting=='allowed') { ?> Educational Attainment <?php } else{?> You're not allowed to edit,delete and add <b>Educational Attainment</b> <?php } ?></h4>
        
        <?php foreach ($info as $educ){?>
                <div class="box box-solid" >
                <div class="box-header with-border  bg-gray">
                  <i class="fa fa-graduation-cap fa-border"></i>
                  <h4 class="box-title"><?php echo $educ->education_name; ?> 
                    <?php if(!empty($educ->course))  echo "<span class='text-info'> - ". $educ->course ."</span>"; ?>
                  </h4>
                   <?php if($setting=='allowed') {  if($pending > 0) {} else{ ?>
                   <div class="pull-right">
                   <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit_education" ng-click="getEducation(<?php echo $educ->id; ?>);"><i class="fa fa-edit"></i> Edit</button>
                   <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete_education" ng-click="getEducation(<?php echo $educ->id; ?>);"><i class="fa fa-trash"></i> Delete</button>
                   </div>
                   <?php } } else{} ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <dl class="dl-horizontal text-info">
                    <dt>School Name</dt>
                    <dd><?php echo $educ->school_name; ?></dd>
                     <?php foreach ($update_info as $update) { if (empty($update->school_name)) { } elseif($update->id==$educ->id) { echo  '<dd class="text-primary">' . $update->school_name . '</dd>'; } } ?>
                    <dt>School Address</dt>
                    <dd><?php echo $educ->school_address; ?></dd>
                     <?php foreach ($update_info as $update) { if (empty($update->school_address)) { } elseif($update->id==$educ->id) { echo  '<dd class="text-primary">' . $update->school_address . '</dd>'; } } ?>
                    <dt>Honors</dt>
                    <dd><?php echo $educ->honors; ?></dd>
                     <?php foreach ($update_info as $update) { if (empty($update->honors)) { } elseif($update->id==$educ->id) { echo  '<dd class="text-primary">' . $update->honors . '</dd>'; } } ?>
                    <dt>Education Duration</dt>
                    <dd> <i>From</i>
                                <?php 
                                 
                                    echo date("F d, Y", strtotime($educ->date_start)); ?>
                                    <i> to</i>
                                    <?php if ($educ->isGraduated > 0 )
                                    {
                                      echo "Present";
                                    } 
                                    else {
                                      
                                      echo date("F d, Y", strtotime($educ->date_end));
                                    } 
                                if(!empty($update->date_start) || !empty($update->date_end) || !empty($update->isGraduated))
                                { echo "<br> <n class='text-danger'>";
                                    if(empty($update->date_start)) { echo date("F d, Y", strtotime($educ->date_start)); } else{ echo date("F d, Y", strtotime($update->date_start)); } ?>
                                    <i> to</i>
                                    <?php 
                                    if(empty($update->date_end)) { if(empty($update->isGraduated)) { if($educ->isGraduated==1){ echo 'Present'; } else{} } else{ if($update->isGraduated==1){ echo 'Present'; } else{} }  } else{ echo date("F d, Y", strtotime($update->date_end)); }   
                                  echo "</n>";
                                }

                                ?>
                            </dd>
                  </dl>
                </div>

            <?php if ($educ->request_status) { ?>
             <div class="overlay">
              <i class="fa fa-trash-o"></i>
            </div>
            <?php } ?>
          </div>
                <!-- /.box-body -->
              </div>
          <?php }  ?>

       <?php foreach ($update_info as $update){
          if (!($update->id)) { ?>
                <div class="box box-solid" >
                <div class="box-header with-border  bg-gray">
                  <i class="fa fa-graduation-cap fa-border"></i>
                  <h4 class="box-title"><?php echo $update->education_name; ?> 
                    <?php if(!empty($update->course))  echo "<span class='text-info'> - ". $update->course ."</span>"; ?>
                  </h4>
                    <div class="pull-right">
                 <span class="label label-success">
                <?php if($pending==0){ ?>Waiting for you to send the update request <?php 
                  } else {?>Waiting for HR Approval<?php } ?>&nbsp;<i class="fa fa-hourglass-start"></i></span>
                   </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <dl class="dl-horizontal text-info">
                    <dt>School Name</dt>
                    <dd><?php echo $update->school_name; ?></dd>
                    <dt>School Address</dt>
                    <dd><?php echo $update->school_address; ?></dd>
            
                    <dt>Honors</dt>
                    <dd><?php echo $update->honors; ?></dd>
                
                    <dt>Education Duration</dt>
                    <dd>
                      <i>From</i>
                        <?php echo date("F d, Y", strtotime($update->date_start)); ?>
                        <i> to</i>
                        <?php if ($update->isGraduated > 0 )
                        {
                          echo date("F d, Y", strtotime($update->date_end));
                        }
                        else {
                          echo "Present";
                        }
                        ?>
                    </dd>
                  </dl>
                </div>
                <!-- /.box-body -->
              </div>
          <?php }  } ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Edit Education Modal -->
<div id="edit_education" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><n class="text-danger"><i class="fa fa-graduation-cap"></i><b>Edit Educational Attainment</b></n></h4>
      </div>
      <div class="modal-body">
            <form name="editeducation" method="post" action="edit_education">
                <input type="hidden" value="{{education.id}}" id="id" name="id">
                <div class="form-group has-feedback">
                    <label>Education Type: </label>
                    <select class="form-control" id="education_id" name="education_id" ng-model="education.education_type_id" ng-selected="education.education_type_id">
                      <?php foreach ($edList as $type) {
                        ?>
                            <option value="<?php echo $type->education_id; ?>" ng-disabled="'<?php echo $type->status; ?>' && education.education_type_id != '<?php echo $type->education_id; ?>'"><?php echo $type->education_name; ?></option>
                        <?php
                      } ?>
                    </select>
               </div>
             
                <div class="form-group has-feedback" ng-class="{'has-error' : editeducation.school_name.$invalid}">
                    <label>School Name: <small ng-show="editeducation.school_name.$invalid"><i>School name is required.</i></small> </label>
                    <div ng-if="!update_educ.school_name">
                    <input type="text" class="form-control" id="school_name" name="school_name" ng-model="education.school_name" required>
                    </div>
                    <div ng-if="update_educ.school_name">
                    <input type="text" class="form-control" id="school_name" name="school_name" ng-model="update_educ.school_name" required>
                    </div>
                </div>

                <div class="form-group has-feedback" ng-class="{'has-error' : editeducation.school_address.$invalid}">
                    <label>School Address: <small ng-show="editeducation.school_address.$invalid"><i>School address is required.</i></small> </label>
                    <input type="text" class="form-control" id="school_address" name="school_address" ng-model="education.school_address" required>
                </div>

                <div class="form-group has-feedback">
                    <label>Course: </label>
                    <div ng-if="!update_educ.course">
                        <input type="text" class="form-control" id="course" name="course" ng-model="education.course" ng-disabled="education.education_type_id < 3">
                    </div>
                     <div ng-if="update_educ.course">
                        <input type="text" class="form-control" id="course" name="course" ng-model="update_educ.course" ng-disabled="education.education_type_id < 3">
                    </div>
                 </div>

                <div class="form-group has-feedback">
                    <label>Honors: </label>
                    <div ng-if="!update_educ.honors">
                      <input type="text" class="form-control" id="honors" name="honors" ng-model="education.honors">
                    </div>
                    <div ng-if="update_educ.honors">
                      <input type="text" class="form-control" id="honors" name="honors" ng-model="update_educ.honors">
                    </div>
                 </div>

                <div class="form-group has-feedback col-xs-6" ng-class="{'has-error' : editeducation.date_start.$invalid}">
                    <label>Date Started: <small>*required</small></label><br>
                    <div ng-if="!update_educ.honors">
                    <input type="date"  name="edit_date_start" value="{{education.date_start}}">
                    </div>
                     <div ng-if="update_educ.honors">
                    <input type="date" name="edit_date_start" value="{{update_educ.date_start}}">
                    </div>
                 </div>

                <div class="form-group has-feedback col-xs-6">
                    <label>Date Graduated: <small>*required</small></label><br>
                    <div ng-if="!update_educ.honors">
                      <input type="date" value="{{education.date_end}}" name="edit_date_end">
                    </div>
                    
                    <div ng-if="update_educ.honors">
                      <input type="date" value="{{update_educ.date_end}}" name="edit_date_end">
                    </div>
                    <label><input type="checkbox" name="isGraduated" id="isGraduated" ng-click="setIsGrad()" ng-checked="isGrad"> Not yet finished</label>
                 </div>
               
                  <div class="col-md-6"><button type="submit" class="btn btn-success btn-block" ng-disabled="editeducation.$invalid"><i class="fa fa-save"></i> Save Changes</button></div>
                  <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button></div>
               
            </form>

      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div>
<!-- End Edit Education -->

<!-- Add Education Modal -->
<div id="add-education" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><n class="text-danger"><i class="fa fa-graduation-cap"></i><b>Add Educational Attainment</b></n></h4>
      </div>
      <div class="modal-body">
            <form name="addeducation" method="post" action="add_education" onsubmit="return checkStartDate('date_start', 'addeducation')">

                <div class="form-group has-feedback" ng-class="{'has-error' : addeducation.education_id.$invalid}">
                    <label>Education Type: <small ng-show="addeducation.education_id.$invalid"><i>Education type is required.</i></small></label>
                     <select class="form-control" id="education_id" name="education_id" ng-model="selected_type" required>
                    <?php foreach ($edList as $type) {
                        ?>
                            <option value="<?php echo $type->education_id; ?>" ng-disabled="'<?php echo $type->status; ?>' && education.education_type_id != '<?php echo $type->education_id; ?>'"><?php echo $type->education_name; ?></option>
                        <?php
                      } ?>
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
                    <input type="text" id="date_end" name="date_end">

                    <label><input type="checkbox" name="isGraduated" id="isGraduated" ng-model="isGraduated" value="0"> Not yet finished</label>
                 </div>
                   <div class="col-md-6"><button type="submit" class="btn btn-success btn-block" ng-disabled="addeducation.$invalid"><i class="fa fa-save"></i> Add Education</button></div>
                  <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button></div>
               
       
            </form>

      </div>
      <div class="modal-footer">
       
      </div>
    </div>

  </div>
</div> <!-- End Add Education Modal -->

<!-- Delete Modal -->
<div id="delete_education" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><n class="text-danger"><i class="fa fa-graduation-cap"></i><b>Delete Educational Attainment</b></n></h4>
      </div>
      <div class="modal-body"><center>
        <p>Are you sure you want to delete the selected Educational Attainment record?</p>
        <h4><span>{{education.school_name}}</span></h4>
        <form name="delete_ed" method="post" action="delete_education">
        <input type="hidden" value="{{education.id}}" name="id" id="id">
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

<script>
$('#date_start').Zebra_DatePicker({
  direction: -1
});

$('#date_end').Zebra_DatePicker({
  direction: -1
});

$('#edit_date_start').Zebra_DatePicker({
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
