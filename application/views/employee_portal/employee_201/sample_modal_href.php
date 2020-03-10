<div class="col-md-9">
  <div class="tab-content">
    <div class="tab-pane active" id="p_info">
      <div class="panel panel-success"> 
        <div class="panel-heading">
          <span class="pull-right"> 
            <?php if($setting=='allowed') { if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else{  ?><button type="button" data-toggle="modal" data-target="#add-training" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Training/Seminar </button><?php } } else{?>
              <a href="#editable_topics">View editable topic</a>
            <?php } ?>
          </span>
          <h4 class="text-danger"><?php if($setting=='allowed') { ?> Training and Seminar Attainment <?php } else{?> You're not allowed to edit,delete and add <b>Training and Seminar Attainment</b> <?php } ?></h4>
           <?php foreach ($info as $training_seminar) {
            $update = null;
            foreach($update_info as $obj) { 
                if ($training_seminar->training_seminar_id == $obj->training_seminar_id) {
                    $update = $obj;
                    break;
                }
            }
            ?>
             <div class="box box-solid">
            <div class="box-body bg-gray">
              <div class="col-lg-6">
                  <strong>
                  <h4 class="text-primary"><?php echo $training_seminar->training_title;
                  if(empty($update->training_title) || $update->training_title==$training_seminar->training_title){} else{ echo  ' <span class="label label-info"> ' . $update->training_title . '</span>';  } 
                if($setting=='allowed') { if($pending > 0) { } else { ?>
                    <div class="box-tools pull-right">
                          <button type="button" ng-click="getTraining(<?php echo $training_seminar->training_seminar_id; ?>)" data-toggle="modal" data-target="#edit-training" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</button>
                          <button type="button" ng-click="getTraining(<?php echo $training_seminar->training_seminar_id; ?>)" data-toggle="modal" data-target="#delete-training" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
                      </div>
                  <?php } } ?>
                  </h4>
                  </strong>
                  <table class="table table-responsive">
                    <tbody>
                      <tr>
                        <td><b>Venue</b></td>
                        <td><?php echo $training_seminar->training_address; ?>
                         <?php 
                           if (empty($update->training_address) || $update->training_address==$training_seminar->training_address) 
                              { } else { echo  '<br><n class="text-primary">' . $update->training_address . '</n>'; } ?>
                        </td>

                      </tr>
                      <tr>
                        <td><b>Conducted By</b></td>
                        <td><?php echo $training_seminar->conducted_by; ?>
                        <?php 
                          if (empty($update->conducted_by) || $update->conducted_by==$training_seminar->conducted_by) { } else { echo  '<br><n class="text-primary">' . $update->conducted_by . '</n>'; } ?>
                        </td>
                      </tr>
                      <tr>
                        <td><b>Institution</b></td>
                        <td><?php echo $training_seminar->training_institution; ?>
                        <?php if (empty($update->training_institution) || $update->training_institution==$training_seminar->training_institution) { } else { echo  '<br><n class="text-primary">' . $update->training_institution . '</n>'; } ?>
                        </td>
                      </tr>
                      <tr>
                        <td><b>Date</b></td>
                        <td>     <b>
                        <?php echo date("F d, Y", strtotime($training_seminar->date_start)); ?>
                       
                        <?php if ($training_seminar->isOneDay != 1 )
                        {
                          echo  ' <i> to </i> ' . date("F d, Y", strtotime($training_seminar->date_end));
                        }
                        else {
                        }
                        echo "</b>";
                       

                        if(!empty($update->date_start) || !empty($update->date_end) || !empty($update->isOneDay) AND $update->date_end!='0000-00-00' || $update->date_start!='0000-00-00')
                        { 
                          echo "<br><n class='text-primary'>";
                            if(empty($update->date_start)){ echo date("F d, Y", strtotime($training_seminar->date_start)); } 
                            else{ echo date("F d, Y", strtotime($update->date_start)); }

                            if(empty($update->date_end)) {if(empty($update->isOneDay)) { if($training_seminar->isOneDay==1){} else{ echo  ' <i> to </i> ' . date("F d, Y", strtotime($training_seminar->date_end)); } } else{ if($update->isOneDay==1){  } else{ echo  ' <i> to </i> ' . date("F d, Y", strtotime($update->date_end)); } }  } else{ echo  ' <i> to </i> ' .date("F d, Y", strtotime($update->date_end)); } 
                          echo "</n>";
                        }

                      
                        ?>
                      
                      </td>
                      </tr>
                    </tbody>
                  </table>
                  </div>
                  <div class="col-lg-6">
                    <div class="col-lg-6">
                        <img src="<?php echo $this->employee_201_model->get_general_url(); ?>certificates/<?php if (!empty($training_seminar->file_name)) { echo $training_seminar->file_name; } else { echo 'empty.png'; }?>" class="img-responsive img-thumbnail" style="width:200px;height: 200px;"><br><br>
                        <a type="button" class="btn btn-success btn-sm" href="download/certificates/<?php if (!empty($training_seminar->file_name)) { echo $training_seminar->file_name; } else { } ?>"><i class="fa fa-download"></i> Download</a>
                    </div>
                    <div class="col-lg-6" id='del_img'>
                      <?php if(empty($update->file_name)){} else{?>
                        <img src="<?php echo $this->employee_201_model->get_general_url(); ?>certificates/<?php if (!empty($update->file_name)) { echo $update->file_name; } else {  }?>" class="img-responsive img-thumbnail" style="width:200px;height: 200px;"><br><br>
                        <a type="button" class="btn btn-default btn-sm" href="download/certificates/<?php if (!empty($update->file_name)) { echo $update->file_name; } else { echo 'empty.png'; } ?>"><i class="fa fa-download"></i> Download</a> |  <a type="button" class="btn btn-default btn-sm" onclick="del_image('<?php echo $update->training_seminar_id?>');"><i class="fa fa-remove"></i> Remove</a>
                      <?php }?>
                    </div>
                  </div>
              </div>
               <?php if ($training_seminar->request_status) { ?>
             <div class="overlay">
              <i class="fa fa-trash-o"></i>
            </div>
            <?php } ?> 
            </div>

          </div>
            <?php } ?>

          <?php foreach ($update_info as $training)
          { if (!($training->training_seminar_id)) { ?>

          <div class="box box-solid">
            <div class="box-body bg-gray">
              <div class="col-lg-6">
                  <strong>
                  <h4 class="text-primary"><?php echo $training->training_title; ?>
                    <div class="box-tools pull-right">
                     <span class="label label-success">
                    <?php if($pending==0){ ?>Waiting for you to send the update request <?php 
                    } else {?>Waiting for HR Approval<?php } ?>&nbsp;<i class="fa fa-hourglass-start"></i></span>
                    </div>
                  </h4>
                  </strong>
                  <table class="table table-responsive">
                    <tbody>
                      <tr>
                        <td><b>Venue</b></td>
                        <td><?php echo $training->training_address; ?>
                        </td>
                      </tr>
                      <tr>
                        <td><b>Conducted By</b></td>
                        <td><?php echo $training->conducted_by; ?>
                        </td>
                      </tr>
                      <tr>
                        <td><b>Institution</b></td>
                        <td><?php echo $training->training_institution; ?>
                        </td>
                      </tr>
                      <tr>
                        <td><b>Date</b></td>
                        <td>     <b>
                        <?php echo date("F d, Y", strtotime($training->date_start)); ?>
                       
                        <?php if ($training->isOneDay != 1 )
                        {
                          echo  ' <i> to </i> ' . date("F d, Y", strtotime($training->date_end));
                        }
                        else {
                        }
                        ?>
                      </b>
                      </td>
                      </tr>
                    </tbody>
                  </table>
                  </div>
                  <div class="col-lg-6">
                    <div class="col-lg-6">
                        <img src="<?php echo $this->employee_201_model->get_general_url(); ?>certificates/<?php if (!empty($training->file_name)) { echo $training->file_name; } else { echo 'empty.png'; }?>" class="img-responsive img-thumbnail" style="width:200px"><br><br>
                        <a type="button" class="btn btn-success btn-sm" href="download/certificates/<?php if (!empty($training->file_name)) { echo $training->file_name; } else { echo 'empty.png'; } ?>"><i class="fa fa-download"></i> Download</a>
                    </div>
                    <div class="col-lg-6"></div>
                  </div>
              </div>
            </div>
        <?php  } } ?>
         </div>
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
        <h4 class="modal-title"><center></center></h4>
        
        <h4> <n class="text-danger"><i class="glyphicon glyphicon-certificate"></i><b>Add Training / Seminar</b></n></h4>
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

                
                <div class="col-md-6"><button type="submit" class="btn btn-success btn-block" ng-disabled="addtraining.$invalid">Add Training/Seminar</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>

         </form>
      </div>
      <div class="modal-footer">
        
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
       
         <h4> <n class="text-danger"><i class="glyphicon glyphicon-certificate"></i><b>Edit Training / Seminar</b></n></h4>
      </div>
      <div class="modal-body">
         <form name="edittraining" method="post" action="edit_training" enctype="multipart/form-data">
            <input type="hidden" value="{{selected_training.training_seminar_id}}" name="id" value="id">
                <div class="form-group has-feedback" ng-class="{'has-error' : edittraining.training_title.$invalid}">
                    <label>Training/Seminar Title: <small ng-show="edittraining.training_title.$invalid"><i>Training/Seminar title is required.</i></small> </label>
                    <div ng-if="!utraining.training_title">
                      <input type="text" class="form-control" id="training_title" name="training_title" ng-model="selected_training.training_title" placeholder="Title of the Training" required>
                    </div>
                     <div ng-if="utraining.training_title">
                      <input type="text" class="form-control" id="training_title" name="training_title" ng-model="utraining.training_title" placeholder="Title of the Training" required>
                    </div>
                </div>
                 <div  ng-if="!utraining.isOneDay">
                 <input type="hidden" value="{{selected_training.isOneDay}}" id="one_date_val">
                </div>  
                <div  ng-if="utraining.isOneDay">
                 <input type="hidden" value="{{utraining.isOneDay}}" id="one_date_val">
                </div>
                <div ng-if="!utraining.file_name">
                 <input type="hidden" id="old_filename" name="old_filename" value="{{selected_training.file_name}}">
                </div>
                <div ng-if="utraining.file_name">
                 <input type="hidden" id="old_filename" name="old_filename" value="{{utraining.file_name}}">
                </div>
                <div class="form-group has-feedback" ng-class="{'has-error' : edittraining.training_address.$invalid}">
                    <label>Venue: <small ng-show="edittraining.training_address.$invalid"><i>Venue is required.</i></small> </label>
                      <div ng-if="!utraining.training_address">
                        <input type="text" class="form-control" id="training_address" name="training_address" placeholder="Venue Address" ng-model="selected_training.training_address" required>
                      </div>
                      <div ng-if="utraining.training_address">
                        <input type="text" class="form-control" id="training_address" name="training_address" placeholder="Venue Address" ng-model="utraining.training_address" required>
                      </div>
                </div>

                <div class="form-group has-feedback" ng-class="{'has-error' : edittraining.training_institution.$invalid}">
                    <label>Institution: <small ng-show="edittraining.training_institution.$invalid"><i>Institution is required.</i>
                    </small> </label>
                    <div ng-if="!utraining.training_institution">
                      <input type="text" class="form-control" id="training_institution" name="training_institution" placeholder="Training Institution" ng-model="selected_training.training_institution" required>
                    </div>
                    <div ng-if="utraining.training_institution">
                      <input type="text" class="form-control" id="training_institution" name="training_institution" placeholder="Training Institution" ng-model="utraining.training_institution" required>
                    </div>
                </div>

                <div class="form-group has-feedback" ng-class="{'has-error' : edittraining.conducted_by.$invalid}">
                    <label>Conducted By: <small ng-show="edittraining.conducted_by.$invalid"><i>This field is required.</i></small> </label>
                    <input type="text" class="form-control" id="conducted_by" name="conducted_by" ng-model="selected_training.conducted_by" required>
                </div>

                <div class="form-group">
                    <label>Date Started: *</label><br>
                      <div ng-if="!utraining.date_start">
                        <input type="date"  name="edit_date_start" value="{{selected_training.date_start}}" >
                      </div>
                      <div ng-if="utraining.date_start">
                        <input type="date"  name="edit_date_start" value="{{utraining.date_start}}">
                      </div>
                 </div>

                <div class="form-group">
                    <label>Date Ended: *</label><br>
                    <div ng-if="!utraining.date_end">
                        <input type="date"  name="edit_date_end" id="one_date" value="{{selected_training.date_end}}" onclick="dday()"><br>
                    </div>
                    <div ng-if="utraining.date_end">
                        <input type="date"  name="edit_date_end" id="one_date" value="{{utraining.date_end}}" onclick="dday()"><br>
                    </div>
                    <label>
                   <div  ng-if="!update_work.isOneDay">
                      <div ng-if="selected_training.isOneDay==1 AND !update_work.isOneDay"> <input type="checkbox" name="isOneDay" id="One"  checked onclick="Onedday();">One day event</label></div>
                      <div ng-if="selected_training.isOneDay==0 AND !update_work.isOneDay"> <input type="checkbox" name="isOneDay" id="One"  onclick="Onedday();"> One day event</label></div>
                   </div>
                    <label>
                   <div  ng-if="utraining.isOneDay">
                      <div ng-if="utraining.isOneDay==1"> <input type="checkbox" name="isOneDay" id="One"  checked onclick="Onedday();">One day event</label></div>
                      <div ng-if="utraining.isOneDay==0"> <input type="checkbox" name="isOneDay" id="One"  onclick="Onedday();"> One day event</label></div>
                    </div>
                  </div>

                <div class="form-group has-feedback">
                    <label>Certification Image: <small><i>Accepted Files: PNG, JPG, GIF | File size must not exceed 500 KB</i></small></label>
                    <input type="file" class="btn btn-info" id="file_name" name="file_name">
                </div>
                
                 <div class="col-md-6"><button type="submit" class="btn btn-success btn-block" ng-disabled="edittraining.$invalid"><i class="fa fa-save"></i> Save Changes</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>

         </form>
      </div>
      <div class="modal-footer">
        
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

function dday()
{
  var val = document.getElementById("one_date_val").value;
  if(val==1){ 
    document.getElementById("one_date").disabled=true;
    alert("This field is not required for present work");
  }
  else{ document.getElementById("one_date").disabled=false; }
  
}

function Onedday()
{ 
    if(document.getElementById('One').checked==true)
      { 
        document.getElementById("one_date").disabled=true; 
       document.getElementById('one_date_val').value=1;
      }
    else
      { 
        document.getElementById("one_date").disabled=false;
        document.getElementById('one_date_val').value=0;
      }
}

 function del_image(id)
  {  
      var option= 'emp_trainings_seminars_for_update';
      var idd='file_name';
      var result = confirm("Are you sure you want to update the ststus?");
      if(result == true)
      {
        $("#del_img").load(location.href + " #del_img");
       {
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                 { 
                  document.getElementById("del_img").innerHTML=xmlhttp.responseText;

                 }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_201/del_per_image/"+id+"/"+option+"/"+idd,true);
            xmlhttp.send();
        } }
        else{}


  }

</script>