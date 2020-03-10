<div class="col-md-9">
  <div class="tab-content">
    <div class="tab-pane active" id="p_info">
      <div class="panel panel-success"> 
        <div class="panel-heading">
          <span class="pull-right"> 
            <?php if($setting=='allowed') { if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else{ ?><button type="button" data-toggle="modal" data-target="#add-skills" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> Add Skills </button><?php } } else{?>
              <a href="#editable_topics">View editable topic</a>
            <?php } ?>
          </span>
          <h4 class="text-danger"><?php if($setting=='allowed') { ?> Skills <?php } else{?> You're not allowed to edit and delete <b>Skills</b> <?php } ?></h4>
  
          <table class="table table-responsive table-bordered table-striped table-hover " style="background-color: #fff">
             <thead>
                <tr>
                  <th style="width:30%;">Skill Name</th>
                  <th style="width:50%;">Skill Description</th>
                  <th style="width:20%;text-align: center;">Action</th>
                </tr>
                <tbody>
            <?php foreach ($info as $d) {
              $update = null;
              foreach($update_info as $obj) {
                  if ($d->skill_id == $obj->id) {
                      $update = $obj;
                      break;
                  } }
              ?>
              <tr   <?php if($d->request_status) { echo "class='text-danger '"; } else{ ?> class="text-primary" <?php }?>>
                  <td><strong><?php echo $d->skill_name; ?></strong>
                  <?php if(empty($update->skill_name) || $update->skill_name==$d->skill_name) { } else { ?><br> 
                  <?php echo "<n class='text-danger'>"." - ".$update->skill_name."</n>";} ?></td>
                  <td><?php echo $d->skill_description; 
                  if(empty($update->skill_description) || $update->skill_description==$d->skill_description ) { } else {?><br> <?php echo "
                  <n class='text-danger'>"." - ".$update->skill_description."</n>";} ?> </td>
                 <?php if($d->request_status) { ?>
                   <td colspan='2'><a type="button" class="btn btn-default btn-xs" disabled>
                <?php if($pending==0){ ?>Waiting for you to send the update request <?php 
                  } else {?>Waiting for HR Approval<?php } ?>&nbsp;</a></td>
                 <?php } else { ?>
                  <td>
                  <center>
                  <button type="button" ng-click="getSkill(<?php echo $d->skill_id; ?>)" data-toggle="modal" data-target="#edit-skill" class="btn btn-primary btn-xs"  <?php if($setting=='allowed') { if($pending > 0) { echo "disabled"; } else{} } else{ echo "disabled";}?>><i class="fa fa-edit"></i> Edit </button>
                  <button type="button" data-toggle="modal" data-target="#delete-skill" ng-click="getSkill(<?php echo $d->skill_id; ?>)"  class="btn btn-danger btn-xs" <?php if($setting=='allowed') { if($pending > 0) { echo "disabled"; } else{} } else{ echo "disabled";}?>><i class="fa fa-trash"></i> Delete</button>
                  </center></td>
                 <?php } ?>
              </tr>
              <?php }?>
            <?php foreach ($update_info as $sk) { if($sk->id==null){
              ?>
              <tr class="text-primary">
                  <td><strong><?php echo $sk->skill_name; ?></strong></td>
                  <td><?php echo $sk->skill_description; ?></td>
                  <td>
                  <center>
                  <span class="label label-success">
                <?php if($pending==0){ ?>Waiting for you to send the update request <?php 
                  } else {?>Waiting for HR Approval<?php } ?>&nbsp;<i class="fa fa-hourglass-start"></i></span>
                  </center>
                  <td>
              </tr>
              <?php } else{} }?>
            </tbody>
            </thead>
         </table>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div id="add-skills" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4> <n class="text-danger"><i class="fa fa-cogs"></i><b> Add Skill/s<b></n></h4>
      </div>
      <div class="modal-body">
    <form name="addskill" method="post" action="add_skill">
        <div class="form-group has-feedback" ng-class="{'has-error' : addskill.skill_name.$invalid}">
          <label for="title">Skill Name: <small ng-show="addskill.skill_name.$invalid"><i>Skill name is required</i></small></label>
          <input type="text" name="skill_name" id="skill_name" class="form-control" ng-model="skill_name" required>
        </div>
        <div class="form-group">
          <label for="title">Skill Description: </label>
          <input type="text" name="skill_description" id="skill_description" class="form-control" ng-model="skill_description">
        </div>
        
          <div class="col-md-6"><button type="submit"  ng-disabled="addskill.$invalid" class="btn btn-success btn-block"><i class="fa fa-plus"></i> Add Skill</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
    </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div>

<!-- Delete Modal -->
<div id="delete-skill" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4> <n class="text-danger"><i class="fa fa-cogs"></i><b> Delete Skill/s<b></n></h4>
      </div>
      <div class="modal-body"><center>
        <p>Are you sure you want to delete the selected skill?</p>
        <h4>{{selected_skill.skill_name | uppercase }} - {{selected_skill.skill_description}}</h4>
        <form name="delete_skill" method="post" action="delete_skill">
        <input type="hidden" value="{{selected_skill.skill_id}}" name="id" id="id">
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

<!-- Modal -->
<div id="edit-skill" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4> <n class="text-danger"><i class="fa fa-cogs"></i><b> Edit Skill/s<b></n></h4>
      </div>
      <div class="modal-body">
    <form name="editskill" method="post" action="edit_skill">
        <div class="form-group has-feedback" >
          <input type="hidden" value="{{selected_skill.skill_id}}" name="skill_id" id="skill_id">
          <label for="title">Skill Name: <small ng-show="editskill.skill_name.$invalid"><i>Skill name is required</i></small></label>
          <div ng-if="!uskill.skill_name">
            <input type="text" name="skill_name" id="skill_name" class="form-control" ng-model="selected_skill.skill_name" required>
          </div>
          <div ng-if="uskill.skill_name">
            <input type="text" name="skill_name" id="skill_name" class="form-control" ng-model="uskill.skill_name" required>
          </div>
        </div>
        <div class="form-group">
          <label for="title">Skill Description: </label>
          <div ng-if="!uskill.skill_description">
            <input type="text" name="skill_description" id="skill_description" class="form-control" ng-model="selected_skill.skill_description">
          </div>
          <div ng-if="uskill.skill_description">
            <input type="text" name="skill_description" id="skill_description" class="form-control" ng-model="uskill.skill_description">
          </div>
        </div>
       
         <div class="col-md-6"><button type="submit"  ng-disabled="editskill.$invalid" class="btn btn-success btn-block"><i class="fa fa-save"></i> Save Changes</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
    </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div>