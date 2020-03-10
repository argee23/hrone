
<div class="col-md-9">
  <div class="tab-content">
    <div class="tab-pane active" id="p_info">
      <div class="panel panel-success"> 
        <div class="panel-heading">
          <span class="pull-right"> 
            <?php if($setting=='allowed') { if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else{ ?><button type="button" data-toggle="modal" data-target="#add-inventory" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> Add Inventory </button><?php } }  else{?>
              <a href="#editable_topics">View editable topic</a>
            <?php } ?>
          </span>
          <h4 class="text-danger"><?php if($setting=='allowed') { ?> Inventory <?php } else{?> You're not allowed to edit and delete <b>Skills</b> <?php } ?></h4>
          
          <table class="table table-responsive table-bordered table-striped table-hover " style="background-color: #fff" id="inventory_table">
             <thead>
                <tr>
                  <th>Inventory Name</th>
                  <th>File Name</th>
                  <th>Remarks</th>
                  <th>Download File</th>  
                  <th>Action</th>
                </tr>
                <tbody>
                
            <?php foreach ($info as $d) {
              $update = null;
            foreach($update_info as $obj) {
                if ($d->inventory_id == $obj->id) {
                    $update = $obj;
                    break;
                 } }
              ?>
              <tr <?php if($d->request_status) {?>  class="text-danger"<?php } else{ ?> class="text-primary" <?php } ?> >
                  <td><strong><?php echo $d->inventory_name; ?></strong> 
                      <?php if(empty($update->inventory_name) || $update->inventory_name==$d->inventory_name) { } else { ?><br> 
                      <?php echo "<n class='text-danger'>"." - ".$update->inventory_name."</n>";} ?>
                  </td>
                  <td><?php echo $d->file; ?>
                     <?php if(empty($update->file) || $update->file==$d->file) { } else { ?><br> 
                      <?php echo "<n class='text-danger'>"." - ".$update->file."</n>";} ?>
                  </td>
                  <td><?php echo $d->comment; ?>
                   <?php if(empty($update->comment) || $update->comment==$d->comment) { } else { ?><br> 
                      <?php echo "<n class='text-danger'>"." - ".$update->comment."</n>";} ?>
                  </td>
                   <?php if($d->request_status) {?>
                   <td colspan='2'><a type="button" class="btn btn-default btn-xs" disabled>
                <?php if($pending==0){ ?>Waiting for you to send the update request <?php 
                  } else {?>Waiting for HR Approval<?php } ?>&nbsp;</a></td>
                  <?php } else {?>
                   <td><a type="button" class="btn btn-success btn-xs" href="download/inventory/<?php echo $d->file; ?>">Download</a>
                  <td>
                  <center>
                   <button type="button" class="btn btn-primary btn-xs" ng-click="getInventory(<?php echo $d->inventory_id; ?>)" data-toggle="modal" data-target="#edit-inventory" <?php if($setting=='allowed') { if($pending > 0) { echo "disabled"; } else{} } else{ echo "disabled";}?>><i class="fa fa-edit"></i> Edit</button>
                    <button type="button" class="btn btn-danger btn-xs" ng-click="getInventory(<?php echo $d->inventory_id; ?>)" data-toggle="modal" data-target="#delete-inventory" <?php if($setting=='allowed') {if($pending > 0) { echo "disabled"; } else{} } else{ echo "disabled";}?>><i class="fa fa-trash"></i> Delete</button>
                  </center></td>
                  <?php } ?>
                  <td>
              </tr>
              <?php }?>
            <?php foreach ($update_info as $sk) { if($sk->id==null){
              ?>
              <tr class="text-primary">
                  <td><strong><?php echo $sk->inventory_name; ?></strong></td>
                  <td><?php echo $sk->file; ?></td>
                  <td><?php echo $sk->comment; ?></td>
                  <td><a type="button" class="btn btn-success btn-xs" href="download/inventory/<?php echo $sk->file; ?>">Download</a>
                  <td>
                  <center>
                  <span class="label label-success">
                <?php if($pending==0){ ?>Waiting for you to send the update request <?php 
                  } else {?>Waiting for HR Approval<?php } ?>&nbsp;<i class="fa fa-hourglass-start"></i></span>
                  </center>
                  </td>
              </tr>
              <?php } else{}  } ?>
            </tbody>
            </thead>
         </table>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div id="add-inventory" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4> <n class="text-danger"><i class=" fa fa-area-chart"></i><b> Add Employee Inventory</b></n></h4>
      </div>
      <div class="modal-body">
         <form name="addtraining" method="post" action="add_inventory" enctype="multipart/form-data">

                <div class="form-group has-feedback" ng-class="{'has-error' : addtraining.name.$invalid}">
                    <label>Name: <small ng-show="addtraining.name.$invalid"><i>Name of inventory is required.</i>
                    </small> </label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Inventory Name" ng-model="name" required>
                </div>

                <div class="form-group has-feedback">
                    <label>File: <small><i>Accepted Files: PNG, JPG, GIF | File size must not exceed 500 KB | File is required.</i></small></label>
                    <input type="file" class="btn btn-info" id="file" name="file" required>
                </div>

                <div class="form-group">
                  <label for="comment">Comment/Remarks:</label>
                  <textarea class="form-control" rows="5" id="comment"  id="comment" name="comment" ng-model="comment"></textarea>
                </div>

                <div class="col-md-6"><button type="submit" class="btn btn-success btn-block" ng-disabled="addtraining.$invalid"><i class="fa fa-plus-circle"></i> Add Inventory</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
         </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>

  </div>
</div>
<!-- End: Add Modal -->

<!-- Edit Modal -->
<div id="edit-inventory" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4> <n class="text-danger"><i class=" fa fa-area-chart"></i><b> Edit Employee Inventory</b></n></h4>
      </div>
      <div class="modal-body">
         <form name="edittraining" method="post" action="edit_inventory" enctype="multipart/form-data">
         <input type="hidden" name="id" id="id" value="{{inventory.inventory_id}}">
               
                <div class="form-group has-feedback" ng-class="{'has-error' : edittraining.name.$invalid}">
                    <label>Name: <small ng-show="edittraining.name.$invalid"><i>Name of inventory is required.</i>
                    </small> </label>
                     <div  ng-if="!uinventory.inventory_name">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Inventory Name" ng-model="inventory.inventory_name" required>
                     </div>
                     <div  ng-if="uinventory.inventory_name">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Inventory Name" ng-model="uinventory.inventory_name" required>
                     </div>
                </div>
                <div ng-if="!uinventory.file">
                  <input type="hidden" name="old_file" id="old_file" value="{{inventory.file}}">
                </div>
                <div ng-if="uinventory.file">
                  <input type="hidden" name="old_file" id="old_file" value="{{uinventory.file}}">
                </div>
                <div class="form-group has-feedback">
                    <label>File: <small><i>Accepted Files: PNG, JPG, GIF | File size must not exceed 500 KB</i></small></label>
                        <input type="file" class="btn btn-info" id="file" name="file">   
                </div>

                <div class="form-group">
                  <label for="comment">Comment/Remarks:</label>
                  <div  ng-if="!uinventory.comment">
                    <textarea class="form-control" rows="3" id="comment"  id="comment" name="comment" ng-model="inventory.comment"></textarea>
                  </div>
                  <div  ng-if="uinventory.comment">
                    <textarea class="form-control" rows="3" id="comment"  id="comment" name="comment" ng-model="uinventory.comment"></textarea>
                  </div>
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
<!-- End: Edit Modal -->



<!-- Delete Modal -->
<div id="delete-inventory" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4> <n class="text-danger"><i class=" fa fa-area-chart"></i><b> Delete Employee Inventory</b></n></h4>
      </div>
      <div class="modal-body"><center>
        <p>Are you sure you want to delete the selected inventory?</p>
        <h4>{{inventory.inventory_name | uppercase }}</h4>
        <form name="delete_inventory" method="post" action="delete_inventory">
        <input type="hidden" value="{{inventory.inventory_id}}" name="id" id="id">
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



