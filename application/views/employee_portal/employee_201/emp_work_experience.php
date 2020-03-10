
<div class="col-md-9">
  <div class="tab-content">
    <div class="tab-pane active" id="p_info">
      <div class="panel panel-success"> 
        <div class="panel-heading">
          <span class="pull-right"> 
            <?php if($setting=='allowed') { if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else{  ?><button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Work Experience</button><?php } } else{?>
              <a href="#editable_topics">View editable topic</a>
            <?php } ?>
          </span>
          <h4 class="text-danger"><?php if($setting=='allowed') { ?> Employment Experience <?php } else{?> You're not allowed to edit,delete and add <b>Employment Experience</b> <?php } ?></h4>
                  <?php foreach ($info as $work)
                  { 
                    $update = null;
                    foreach($update_info as $obj) {
                        if ($work->work_experience_id == $obj->id) {
                            $update = $obj;
                            break;
                        }
                    }  
                    ?>

                      <div class="box box-solid" >
                        <div class="box-header with-border bg-gray disabled color-palette">
                          <i class="fa fa-black-tie fa-border"></i>
                          <h4 class="box-title"><?php echo $work->position_name;  if (empty($update->position_name) || $work->position_name == $update->position_name) { } else { echo  ' <span class="label label-info"> ' . $update->position_name . '</span>'; } ?></h4>
                            <?php if($setting=='allowed') {  if($pending > 0) {} else { ?>
                          <div class="pull-right">
                              <button type="button" class="btn btn-primary btn-xs" ng-click="getExperience(<?php echo $work->work_experience_id; ?>)" data-toggle="modal" data-target="#edit-work"><i class="fa fa-edit"></i> Edit</button>
                              <button type="button" class="btn btn-danger btn-xs"  ng-click="getExperience(<?php echo $work->work_experience_id; ?>)" data-toggle="modal" data-target="#delete-work"><i class="fa fa-trash"></i> Delete</button>
                           </div>
                           <?php } } ?>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                        <dl class="dl-horizontal text-primary">

                            <dt>Company Name</dt>
                            <dd><?php echo $work->company_name; ?></dd>
                            <?php 
                                if (empty($update->company_name) || $update->company_name==$work->company_name) { } 
                                else { echo  '<dd class="text-success">- > ' . $update->company_name. '</dd>'; } ?>
                            <dt>Company Address</dt>
                            <dd><?php echo $work->company_address; ?></dd>
                            <?php 
                                if (empty($update->company_address) || $update->company_address==$work->company_address) { } 
                                else { echo  '<dd class="text-success">- > ' . $update->company_address. '</dd>'; } ?>
                            <dt>Reason for Leaving</dt>
                            <dd><?php echo $work->reason_for_leaving; ?></dd>
                            <?php 
                                if (empty($update->reason_for_leaving) || $update->reason_for_leaving==$work->reason_for_leaving) { }
                                else { echo  '<dd class="text-success">- > ' . $update->reason_for_leaving. '</dd>'; } ?>
                            <dt>Job  Description</dt>
                            <dd><span class="multi_lines_text"><?php echo $work->job_description; ?></span></dd>
                            <?php 
                                if (empty($update->job_description) || $update->job_description==$work->job_description) { } 
                                else { echo  '<dd class="text-success">- > ' . $update->job_description. '</dd>'; } ?>
                            <dt>Work Duration</dt>
                            <dd> <i>From</i>
                                <?php 
                                 
                                    echo date("F d, Y", strtotime($work->date_start)); ?>
                                    <i> to</i>
                                    <?php if ($work->isPresentWork > 0 )
                                    {
                                      echo "Present";
                                    } 
                                    else {
                                      
                                      echo date("F d, Y", strtotime($work->date_end));
                                    } 
                                if(!empty($update->date_start) || !empty($update->date_end) || !empty($update->isPresentWork))
                                { echo "<br> <n class='text-danger'>";
                                    if(empty($update->date_start)) { echo date("F d, Y", strtotime($work->date_start)); } else{ echo date("F d, Y", strtotime($update->date_start)); } ?>
                                    <i> to</i>
                                    <?php 
                                    if(empty($update->date_end)) { if(empty($update->isPresentWork)) { if($work->isPresentWork==1){ echo 'Present'; } else{} } else{ if($update->isPresentWork==1){ echo 'Present'; } else{} }  } else{ echo date("F d, Y", strtotime($update->date_end)); }   
                                  echo "</n>";
                                }

                                ?>
                            </dd>
                             
                            <dt>Salary</dt>
                            <dd><?php echo $work->salary; ?></dd>
                             <?php if (empty($update->salary) || $update->salary==$work->salary) { } else { echo  '<dd class="text-success">- > ' . $update->salary. '</dd>'; } ?>
                          </dl>
                        </div>

                         <?php if ($work->request_status) { ?>
             <div class="overlay">
              <i class="fa fa-trash-o"></i>
            </div>
            <?php } ?>
          
                        <!-- /.box-body -->
                      </div>
                      <?php   
                    }
                ?>

                <?php foreach ($update_info as $up)
                { if (!($up->id)) {?>
                  <div class="box box-solid" >
                        <div class="box-header with-border bg-gray disabled color-palette">
                          <i class="fa fa-black-tie fa-border"></i>
                          <h4 class="box-title"><?php echo $up->position_name; ?></h4>
                           <div class="pull-right">
                            <span class="label label-success">
                          <?php if($pending==0){ ?>Waiting for you to send the update request <?php 
                              } else {?>Waiting for HR Approval<?php } ?>&nbsp;<i class="fa fa-hourglass-start"></i></span>
                           </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                        <dl class="dl-horizontal text-primary">

                            <dt>Company Name</dt>
                            <dd><?php echo $up->company_name; ?></dd>
                            <dt>Company Address</dt>
                            <dd><?php echo $up->company_address; ?></dd>
                            <dt>Reason for Leaving</dt>
                            <dd><?php echo $up->reason_for_leaving; ?></dd>
                            <dt>Job  Description</dt>
                            <dd><span class="multi_lines_text"><?php echo $up->job_description; ?></span></dd>
                            <dt>Work Duration</dt>
                            <dd>                  <i>From</i>
                                <?php echo date("F d, Y", strtotime($up->date_start)); ?>
                                <i> to</i>
                                <?php if ($up->isPresentWork > 0 )
                                {
                                  echo "Present";
                                }
                                else {
                                  
                                  echo date("F d, Y", strtotime($up->date_end));
                                }
                                ?>
                            </dd>
                            <dt>Salary</dt>
                            <dd><?php echo $up->salary; ?></dd>
                          </dl>
                        </div>
                        <!-- /.box-body -->
                      </div>
                      <?php
                    }
                  }
              ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Delete Modal -->
    <div id="delete-work" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><n class="text-danger"><i class="fa fa-black-tie"></i><b> Delete Work Experience</b></n></h4>
          </div>
          <div class="modal-body"><center>
            <p>Are you sure you want to delete the selected work experience?</p>
            <h4>{{selected_work.position_name}} - {{selected_work.company_name}}</h4>
            <form name="delete_work_ex" method="post" action="delete_work">
            <input type="hidden" value="{{selected_work.work_experience_id}}" name="id" id="id">
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

   
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4><n class="text-danger"><i class="fa fa-black-tie"></i><b> Edit Work Experience</b></n></h4>
      </div>
      <div class="modal-body">
        <form name="edit_work_exp" method="post" action="edit_work_ex">
        <input type="hidden" value="{{selected_work.work_experience_id}}" id="work_id" name="work_id">
        <div  ng-if="!update_work.isPresentWork">
         <input type="hidden" value="{{selected_work.isPresentWork}}" id="e_date">
        </div>  
        <div  ng-if="update_work.isPresentWork">
         <input type="text" value="{{update_work.isPresentWork}}" id="e_date">
        </div>
          <div class="col-lg-12">
            <div class="form-group has-feedback" ng-class="{'has-error' : edit_work_exp.position.$invalid}">
              <label>Job Position / Job Title: <small ng-show="edit_work_exp.position.$invalid"><i>Required</i></small></label>
              <div  ng-if="!update_work.position_name">
                 <select class="form-control" id="position" name="position"  ng-model="selected_work.position_id" ng-selected="selected_work.position_id" required>
                    <?php foreach ($positionList as $position) { if($position->isEmployer==1){}else{?>
                     <option value="<?php echo $position->position_id; ?>" <?php if($position->position_id=='{{selected_work.position_id}}'){ echo "selected"; }?>><?php echo $position->position_name; ?></option>
                    <?php }}?>
                </select>           
              </div>
              <div  ng-if="update_work.position_name">
                <select class="form-control" id="position" name="position"  ng-model="update_work.position_id" ng-selected="update_work.position_id" required>
                    <?php foreach ($positionList as $position) { if($position->isEmployer==1){}else{?>
                     <option value="<?php echo $position->position_id; ?>" <?php if($position->position_id=='{{update_work.position_id}}'){ echo "selected"; }?>><?php echo $position->position_name; ?></option>
                    <?php }}?>
                </select>        
              </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group has-feedback" ng-class="{'has-error' : edit_work_exp.company_name.$invalid}">
                    <label>Company Name: <small ng-show="edit_work_exp.company_name.$invalid"><i>Required</i></small></label>
                  <div  ng-if="!update_work.company_name">
                    <input type="text" class="form-control" id="company_name" name="company_name" ng-model="selected_work.company_name" ng-value="selected_work.company_name" required>
                  </div>
                  <div  ng-if="update_work.company_name">
                    <input type="text" class="form-control" id="company_name" name="company_name" ng-model="update_work.company_name" ng-value="update_work.company_name" required>
                  </div>
                </div>


                <div class="form-group has-feedback" ng-class="{'has-error' : edit_work_exp.company_address.$invalid}" >
                    <label>Company Address: <small ng-show="edit_work_exp.company_address.$invalid"><i>Required</i></small></label>
                    <div  ng-if="!update_work.company_address">
                        <input type="text" class="form-control" id="company_address" name="company_address" ng-model="selected_work.company_address" ng-value="selected_work.company_address" required>
                    </div>
                    <div  ng-if="update_work.company_address">
                        <input type="text" class="form-control" id="company_address" name="company_address" ng-model="update_work.company_address" ng-value="update_work.company_address" required>
                    </div>
                </div>

                <div class="form-group has-feedback">
                    <label>Start Date: *</label><br>
                     <div  ng-if="!update_work.date_start">
                      <input type="date"  name="edit_start_date"  value="{{selected_work.date_start}}" >
                     </div>
                     <div  ng-if="update_work.date_start">
                      <input type="date"  name="edit_start_date"  value="{{update_work.date_start}}">
                     </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label>Company Contact Number:</label>
                    <div  ng-if="!update_work.company_contact">
                      <input type="text" class="form-control" id="company_contact" name="company_contact" >
                    </div>
                     <div  ng-if="update_work.company_contact">
                      <input type="number" class="form-control" id="company_contact" name="company_contact">
                    </div>
                </div>
                <div class="form-group">
                    <label>Salary:</label>
                    <div  ng-if="!update_work.salary">
                      <input type="text" class="form-control" id="salary" name="salary" value="{{selected_work.salary}}" onkeypress="return isNumberKey(this, event);">
                    </div>
                     <div  ng-if="update_work.salary">
                      <input type="text" class="form-control" id="salary" name="salary" value="{{update_work.salary}}" onkeypress="return isNumberKey(this, event);">
                    </div>
               </div>
                <div class="form-group">
                    <label>End Date:</label><br>
                    <div  ng-if="!update_work.date_end">
                    <input type="date"  id ="d" name="edit_end_date"  value="{{selected_work.date_end}}" onclick="end_date();"><br>
                    </div>
                    <div  ng-if="update_work.date_end">
                    <input type="date"  id ="d" name="edit_end_date" value="{{update_work.date_end}}"  onclick="end_date();"><br>
                    </div>
                    <label>
                   <div  ng-if="!update_work.isPresentWork">
                      <div ng-if="selected_work.isPresentWork==1"> <input type="checkbox" name="isPresentWork" id="workk" checked onclick="workss();"> Present Work</label></div>
                      <div ng-if="selected_work.isPresentWork==0"> <input type="checkbox" name="isPresentWork" id="workk"  onclick="workss();"> Present Work</label></div>
                   
                   </div>
                    <label>
                   <div  ng-if="update_work.isPresentWork">
                      <div ng-if="update_work.isPresentWork==1"> <input type="checkbox" name="isPresentWork" id="workk"  checked onclick="workss();"> Present Work</label></div>
                      <div ng-if="update_work.isPresentWork==0"> <input type="checkbox" name="isPresentWork" id="workk"  onclick="workss();"> Present Work</label></div>
                    </div>
                  
                </div>

            </div>
              <div class="form-group">
                  <label for="comment">Job Description:</label>
                  <div  ng-if="!update_work.job_description">
                      <textarea class="form-control" rows="5" id="comment"  id="job_description" name="job_description" ng-model="selected_work.job_description" ng-value="selected_work.job_description"></textarea>
                  </div>
                  <div  ng-if="update_work.job_description">
                      <textarea class="form-control" rows="5" id="comment"  id="job_description" name="job_description" ng-model="update_work.job_description" ng-value="update_work.job_description"></textarea>
                  </div>
                </div>
            <div class="form-group">
                <label>Reason for Leaving:</label>
                <div  ng-if="!update_work.reason_for_leaving">
                   <input type="text" class="form-control" id="reason_for_leaving" name="reason_for_leaving" ng-model="selected_work.reason_for_leaving" ng-value="selected_work.reason_for_leaving">
                </div>
                <div  ng-if="update_work.reason_for_leaving">
                   <input type="text" class="form-control" id="reason_for_leaving" name="reason_for_leaving" ng-model="update_work.reason_for_leaving" ng-value="update_work.reason_for_leaving">
                </div>
             </div>
            <div class="col-md-6"><button type="submit" class="btn btn-success btn-block" ng-disabled="edit_work_exp.$invalid"><i class="fa fa-save"></i> Save Changes</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
          </div>
         </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
<!-- Edit Modal -->

 <!-- Add Experience Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4> <n class="text-danger"><i class="fa fa-black-tie"></i><b> Add Work Experience</b></n></h4>
        </div>
        <div class="modal-body">
           <form name="addworkexp" method="post" action="add_work_experience" onsubmit="return  checkStartDate('start_date', 'addworkexp')">
            <div class="col-lg-12">
              <div class="form-group has-feedback" ng-class="{'has-error' : addworkexp.position.$invalid}">
                <label>Job Position / Job Title: <small ng-show="addworkexp.position.$invalid"><i>Required</i></small></label>
             
                <select class="form-control" id="position" name="position" ng-model="work.position_name" ng-value="work.position_name" required>
                    <?php foreach ($positionList as $position) { if($position->isEmployer==1){}else{?>
                      <option value="<?php echo $position->position_id;?>"><?php echo $position->position_name;?></option>
                    <?php }}?>
                </select>
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
                      <input type="number" class="form-control" id="company_contact" name="company_contact" >
                  </div>
                  <div class="form-group">
                      <label>Salary:</label><br>
                      <input type="text" class="form-control" id="salary" name="salary" onkeypress="return isNumberKey(this, event);">
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
              

              <div class="col-md-6"><button type="submit" id="add_btn" class="btn btn-success btn-block" ng-disabled="addworkexp.$invalid"> Add Work Experience</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
            
            </div>
           </form>
        </div>
        <div class="modal-footer">
         
        </div>
      </div>
    </div>
  </div> <!-- End Add Experience Modal -->
<script>
$('#start_date').Zebra_DatePicker({
  direction: -1
});

$('#end_date').Zebra_DatePicker({
  direction: -1
});

$('#edit_start_date').Zebra_DatePicker({
   direction: -1
});

$('#edit_end_date').Zebra_DatePicker({
  direction: -1
});

function checkStartDate(datestart, form_name) {
    var x = document.forms[form_name][datestart].value;
    if (x == "") {
        alert("Please specify the date start field.");
        return false;
    }
}

function end_date()
{
  var work = document.getElementById("e_date").value;
  if(work==1){ 
    document.getElementById("d").disabled=true;
    alert("This field is not required for present work");
  }
  else{ document.getElementById("d").disabled=false; }
}

function workss()
{
    if(document.getElementById('workk').checked==true)
      {  
        document.getElementById('d').disabled=true;
        document.getElementById('e_date').value=1;
      }
    else
      { 
        document.getElementById('d').disabled=false;
        document.getElementById('e_date').value=0;
      }
  alert("j");
}
 function isNumberKey(txt, evt) {
      
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
            //Check if the text already contains the . character
            if (txt.value.indexOf('.') === -1) {
                return true;

            } else {
                return false;

            }
        } else {

            if (charCode > 31
                 && (charCode < 48 || charCode > 57))
                return false;

        }
        return true;
    }

</script>
<?php require_once(APPPATH.'views/app/application_form/footer.php');?>
       