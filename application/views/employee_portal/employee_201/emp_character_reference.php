<div class="col-md-9">
  <div class="tab-content">
    <div class="tab-pane active" id="p_info">
      <div class="panel panel-success"> 
        <div class="panel-heading">
          <span class="pull-right"> 
            <?php if($setting=='allowed') { if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else{ ?> <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add-reference"><i class="fa fa-plus"></i> Add Character Reference</button><?php } } else{?>
              <a href="#editable_topics">View editable topic</a>
            <?php } ?>
          </span>
          <h4 class="text-danger"><?php if($setting=='allowed') { ?> Character Reference <?php } else{?> You're not allowed to edit,delete and add <b>Character Reference</b> <?php } ?></h4>
     
          <?php  foreach ($info as $character_ref) {
          $update = null;
          foreach($update_info as $obj) {
              if ($character_ref->character_reference_id == $obj->id) {
                  $update = $obj;
                  break;
              }
            }
         ?>
          <div class="box box-solid bg-gray">
            <div class="box-body">

            <div class="col-lg-12">
                <h3 class="text-info"><?php echo $character_ref->reference_name; 
                  if (empty($update->reference_name) || $update->reference_name==$character_ref->reference_name) {} else {?> <n class='text-danger' style='font-size:15px;'><?php  echo "- > ".$update->reference_name; ?></n> <?php } ?></h3>
                     
                  <table class="table table-hover">
                    <tbody>
                      <tr>
                        <td><i class="fa fa-black-tie"> </i></td>
                        
                        <td><b><?php echo $character_ref->reference_position; ?></b>
                        <?php if (empty($update->reference_position) || $update->reference_position==$character_ref->reference_position) {} 
                        else {?> <n class='text-danger'><?php  echo "- > ".$update->reference_position; ?></n> <?php } ?></td>
                      </tr>
                      <tr>
                        <td><i class="fa fa-building"> </i></td>
                        <td><?php echo $character_ref->reference_company; ?>
                          <?php if (empty($update->reference_company) || $update->reference_company==$character_ref->reference_company) {} 
                          else {?> <n class='text-danger'><?php  echo "- > ".$update->reference_company; ?></n> <?php } ?></td>
                      </tr>
                      <tr>
                        <td><i class="fa fa-map-marker"> </i></td>
                        <td><?php echo $character_ref->reference_address; ?>
                        <?php if (empty($update->reference_address) || $update->reference_address==$character_ref->reference_address) {} else {?> <n class='text-danger'><?php  echo "- > ".$update->reference_address; ?></n> <?php } ?></td>
                      </tr>
                      <tr>
                        <td><i class="fa fa-envelope"> </i></td>
                        <td><?php echo $character_ref->reference_email; ?>
                         <?php if (empty($update->reference_email) || $update->reference_email==$character_ref->reference_email) {} else {?> <n class='text-danger'><?php  echo "- > ".$update->reference_email; ?></n> <?php } ?></td>
                      </tr>
                      <tr>
                        <td><i class="fa fa-phone"> </i></td>
                        <td><?php echo $character_ref->reference_contact; ?>
                         <?php if (empty($update->reference_contact) || $update->reference_contact==$character_ref->reference_contact) {} else {?> <n class='text-danger'><?php  echo "- > ".$update->reference_contact; ?></n> <?php } ?></td>
                      </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-3">
            <?php if($setting=='allowed') { if($pending > 0) {} else{ ?>
               <div class="pull pull-right">
                <button type="button" ng-click="getReference(<?php echo $character_ref->character_reference_id; ?>)" data-toggle="modal" data-target="#edit-reference" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</button>
                <button type="button" data-toggle="modal" ng-click="getReference(<?php echo $character_ref->character_reference_id; ?>)" data-target="#delete-reference" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
              </div>
            <?php } }?>
            </div>
            </div>
            <?php if ($character_ref->request_status) { ?>
             <div class="overlay">
              <i class="fa fa-trash-o"></i>
            </div>
            <?php } ?> 
          </div>
          <?php } ?>
          <?php  foreach ($update_info as $reference) { if($reference->id==null){?>
          <div class="box box-solid bg-gray">
            <div class="box-body">

            <div class="col-lg-12">
                <h3 class="text-info"><?php echo $reference->reference_name; ?></h3>

                <table class="table table-hover">
                    <tbody>
                      <tr>
                        <td><i class="fa fa-black-tie"> </i></td>
                        <td><b><?php echo $reference->reference_position; ?></b>
                        </td>
                      </tr>
                      <tr>
                        <td><i class="fa fa-building"> </i></td>
                        <td><?php echo $reference->reference_company; ?>
                         </td>
                      </tr>
                      <tr>
                        <td><i class="fa fa-map-marker"> </i></td>
                        <td><?php echo $reference->reference_address; ?>
                          </td>
                      </tr>
                      <tr>
                        <td><i class="fa fa-envelope"> </i></td>
                        <td><?php echo $reference->reference_email; ?>
                         </td>
                      </tr>
                      <tr>
                        <td><i class="fa fa-phone"> </i></td>
                        <td><?php echo $reference->reference_contact; ?>
                         </td>
                      </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12">
              <div class="pull pull-right">
              <span class="label label-success">
                <?php if($pending==0){ ?>Waiting for you to send the update request <?php 
                  } else {?>Waiting for HR Approval<?php } ?>&nbsp;<i class="fa fa-hourglass-start"></i></span>
              </div>
            </div>
            </div>
          </div>
          <?php } else{} }  ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Edit Reference Modal -->
<div id="edit-reference" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4> <n class="text-danger"><i class="fa fa-users"></i><b> Edit Character Reference</b></n></h4>
  </div>
  <div class="modal-body">
        <form name="editreference" method="post" action="edit_reference">
        <input type="hidden" value="{{reference.character_reference_id}}" name="id" id="id">
            <div class="form-group has-feedback" ng-class="{'has-error' : editreference.reference_name.$invalid}">
                <label>Name: <small ng-show="editreference.reference_name.$invalid"><i>Character reference name is required.</i></small> </label>
              <div ng-if="!ref_update.reference_name">
                <input type="text" class="form-control" id="reference_name" name="reference_name" ng-model="reference.reference_name" required>
              </div>
               <div ng-if="ref_update.reference_name">
                <input type="text" class="form-control" id="reference_name" name="reference_name" ng-model="ref_update.reference_name" required>
              </div>
            </div>

            <div class="form-group has-feedback">
                <label>Position:</label>
                  <div ng-if="!ref_update.reference_position">
                    <input type="text" class="form-control" id="reference_position" name="reference_position" ng-model="reference.reference_position" >
                  </div>
                   <div ng-if="ref_update.reference_position">
                    <input type="text" class="form-control" id="reference_position" name="reference_position" ng-model="ref_update.reference_position" >
                  </div>
            </div>

            <div class="form-group has-feedback">
                <label>Company/Institution:</label>
                <div ng-if="!ref_update.reference_company">
                  <input type="text" class="form-control" id="reference_company" name="reference_company" ng-model="reference.reference_company" >
                </div>
                  <div ng-if="ref_update.reference_company">
                  <input type="text" class="form-control" id="reference_company" name="reference_company" ng-model="ref_update.reference_company" >
                </div>
            </div>

            <div class="form-group has-feedback">
                <label>Address:</label>
              <div ng-if="!ref_update.reference_address">
                <input type="text" class="form-control" id="reference_address" name="reference_address" ng-model="reference.reference_address" >
              </div>
              <div ng-if="ref_update.reference_address">
                <input type="text" class="form-control" id="reference_address" name="reference_address" ng-model="ref_update.reference_address" >
              </div>
            </div>

            <!-- <div class="form-group has-feedback">
                <label>Contact:</label>
              <div ng-if="!ref_update.reference_contact">
                <input type="number" class="form-control" id="reference_contact" name="reference_contact" ng-model="reference.reference_contact">
              </div>
              <div ng-if="ref_update.reference_contact">
                <input type="number" class="form-control" id="reference_contact" name="reference_contact" ng-model="ref_update.reference_contact" >
              </div>
            </div> -->

            <div class="form-group has-feedback">
                <label>Contact:</label>
                <div ng-if="!ref_update.reference_contact">
                  <input type="text" class="form-control" id="reference_contact" name="reference_contact" ng-model="reference.reference_contact" >
                </div>
                  <div ng-if="ref_update.reference_contact">
                  <input type="text" class="form-control" id="reference_contact" name="reference_contact" ng-model="ref_update.reference_contact" >
                </div>
            </div>

            <div class="form-group has-feedback" ng-class="{'has-error' : editreference.reference_email.$invalid}">
                <label>Email Address: <small ng-show="editreference.reference_email.$invalid"><i>Not a valid email address.</i>
                </small> </label>
                <div ng-if="!ref_update.reference_email">
                  <input type="email" class="form-control" id="reference_email" name="reference_email" ng-model="reference.reference_email">
                </div>
                 <div ng-if="ref_update.reference_email">
                  <input type="email" class="form-control" id="reference_email" name="reference_email" ng-model="ref_update.reference_email">
                </div>
            </div>
           
            <div class="col-md-6"><button type="submit" class="btn btn-success btn-block" ng-disabled="editreference.$invalid"><i class="fa fa-save"></i> Save Changes</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
        </form>

  </div>
  <div class="modal-footer">
    
  </div>
</div>

</div>
</div>
<!-- Edit Reference Modal -->

<!-- Add Reference Modal -->
<div id="add-reference" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4> <n class="text-danger"><i class="fa fa-users"></i><b> Add Character Reference</b></n></h4>
  </div>
  <div class="modal-body">
        <form name="addreference" method="post" action="add_reference">

            <div class="form-group has-feedback" ng-class="{'has-error' : addreference.reference_name.$invalid}">
                <label>Name: <small ng-show="addreference.reference_name.$invalid"><i>Character reference is required.</i></small> </label>
                <input type="text" class="form-control" id="reference_name" name="reference_name" ng-model="reference_name" required>
            </div>

            <div class="form-group has-feedback">
                <label>Position:</label>
                <input type="text" class="form-control" id="reference_position" name="reference_position">
            </div>

            <div class="form-group has-feedback">
                <label>Company/Institution:</label>
                <input type="text" class="form-control" id="reference_company" name="reference_company">
            </div>

            <div class="form-group has-feedback">
                <label>Address:</label>
                <input type="text" class="form-control" id="reference_address" name="reference_address">
            </div>

            <div class="form-group has-feedback">
                <label>Contact Number:</label>
                <input type="number" class="form-control" id="reference_contact" name="reference_contact" >
            </div>

            <div class="form-group has-feedback" ng-class="{'has-error' : addreference.reference_email.$invalid}">
                <label>Email Address: <small ng-show="addreference.reference_email.$invalid"><i>Not a valid email address.</i>
                </small> </label>
                <input type="email" class="form-control" id="reference_email" name="reference_email" ng-model="reference_email">
            </div>
          
             <div class="col-md-6"><button type="submit" class="btn btn-success btn-block" ng-disabled="addreference.$invalid">Add Character Reference</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
        </form>

  </div>
  <div class="modal-footer">
   
  </div>
</div>

</div>
</div>
<!-- Add Reference Modal -->

<!-- Delete Modal -->
<div id="delete-reference" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4> <n class="text-danger"><i class="fa fa-users"></i><b> Delete Character Reference</b></n></h4>
      </div>
      <div class="modal-body"><center>
        <p>Are you sure you want to delete the selected Character Reference?</p>
        <h4>{{reference.reference_name | uppercase }}</h4>
        <form name="delete_reference" method="post" action="delete_reference">
        <input type="hidden" value="{{reference.character_reference_id}}" name="id" id="id">
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

<?php require_once(APPPATH.'views/app/application_form/footer.php');?>