<div class="col-md-9">
 <div class="tab-content">
  <div class="tab-pane active" id="p_info">
  <div class="panel panel-success"> 
    <div class="panel-heading">
     <span class="pull-right"> 
         <?php if($setting=='allowed') {  if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else{?><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add_family_form"  ><i class="fa fa-plus"></i> Add Family</button><?php } } else{?>
         <a href="#editable_topics">View editable topic</a>
         <?php } ?>
      </span>
     <h4 class="text-danger"><?php if($setting=='allowed') { ?>Family Data <?php } else{?> You're not allowed to edit,delete and add <b>Family Data</b> <?php } ?></h4>

<?php foreach ($info as $fam) { 
$update = null;
foreach($update_info as $obj) {
    if ($fam->family_id == $obj->family_id) {
        $update = $obj;
        break;
    }
}
?>
		<div class="box box-solid" >
            <div class="box-header bg-olive with-border">
              <i class="fa fa-users fa-border"></i>

              <h4 class="box-title">
                <?php echo $fam->name;  
                  if (empty($update->name)) { } 
                  elseif($update->name==$fam->name) { }
                  else { echo  ' <span class="label label-info"> ' . $update->name . '</span>'; } ?></h4>
               <?php if($setting=='allowed') {  if($pending > 0) { } else{  ?><div class="pull-right">
                 <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit_family" ng-click="getFamily(<?php echo $fam->family_id; ?>)"><i class="fa fa-edit"></i> Edit</button>
                 <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete_family" ng-click="getFamily(<?php echo $fam->family_id; ?>);"><i class="fa fa-trash"></i> Delete</button>
               </div>
               <?php } } else{ }?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <dl class="dl-horizontal">
                <dt>Relationship</dt>
                <dd><?php echo $fam->relationship_name; ?></dd>
                <?php 
                    if (empty($update->relationship)) { } 
                    elseif($update->relationship==$fam->relationship) { }
                    else { echo  '<dd class="text-primary">' . $update->relationship_name . '</dd>'; } ?>
                <dt>Occupation</dt>
                <dd><?php echo $fam->occupation; ?></dd>
                <?php 
                    if (empty($update->occupation)) {} 
                    elseif($update->occupation==$fam->occupation) { }
                    else{ echo  '<dd class="text-primary">' . $update->occupation . '</dd>'; }?>
                <dt>Birthday</dt>
                <dd><?php if (!empty($fam->birthday)) { echo date("F d, Y", strtotime($fam->birthday)); }?></dd>
                <?php 
                    if (empty($update->birthday)) { } 
                    elseif($update->birthday==$fam->birthday) { }
                    else { echo  '<dd class="text-primary">' . date("F d, Y", strtotime($update->birthday)) . '</dd>'; } ?>
                <dt>Age</dt>
                <dd><?php echo $fam->age; ?> yrs. old</dd>
                <?php 
                    if (empty($update->age)) { }
                    elseif($update->age==$fam->age) { }
                    else { echo  '<dd class="text-primary">' . $update->age . ' yrs. old</dd>'; } ?>
                <dt>Contact Number</dt>
                <dd><?php echo $fam->contact_no; ?></dd>
                <?php 
                    if (empty($update->contact_no)) { } 
                    elseif($update->contact_no==$fam->contact_no) { }
                    else{ echo  '<dd class="text-primary">' . $update->contact_no . '</dd>'; } ?>
                <?php if ($fam->relationship == 72 || $fam->relationship_name == 'Spouse')
                { ?>
                    <dt>Date of Marriage</dt>
                    <dd><?php if (!empty($fam->date_of_marriage)) { echo date("F d, Y", strtotime($fam->date_of_marriage)); }?></dd>
                    <?php if (empty($update->date_of_marriage) || $update->date_of_marriage!=$fam->date_of_marriage ) {} else { echo  '<dd class="text-primary">' . date("F d, Y", strtotime($update->date_of_marriage)) . '</dd>'; } ?>
                <?php
                }?>
              </dl>
            </div>
            <!-- /.box-body -->

            <?php if ($fam->request_status) { ?>
             <div class="overlay">
              <i class="fa fa-trash-o"></i>
            </div>
            <?php } ?>
          </div>
          <!-- Modal -->

          <?php } ?>

          <?php foreach ($update_info as $update)
          { 
            if (!($update->family_id)) {?>
               <div class="box box-solid">
            <div>
            <div class="box-header with-border bg-gray disabled color-palette">
              <i class="fa fa-users fa-border"></i>

              <h4 class="box-title"><?php echo $update->name; ?></h4>
              <div class="pull-right">
                <span class="label label-success">
                <?php if($pending==0){ ?>Waiting for you to send the update request <?php 
                  } else {?>Waiting for HR Approval<?php } ?>&nbsp;<i class="fa fa-hourglass-start"></i></span>
               </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <dl class="dl-horizontal text-info">

               <dt>Relationship</dt>
                <dd><?php echo $update->relationship_name; ?></dd>
                <dt>Occupation</dt>
                <dd><?php echo $update->occupation; ?></dd>
                <dt>Birthday</dt>
                <dd><?php if (!empty($update->birthday)) { echo date("F d, Y", strtotime($update->birthday)); }?></dd>
                <dt>Age</dt>
                <dd><?php echo $update->age; ?> yrs. old</dd>
                <dt>Contact Number</dt>
                <dd><?php echo $update->contact_no; ?></dd>
                <?php if ($update->relationship == 72 || $update->relationship_name == 'Spouse')
                { ?><br>
                    <dt>Date of Marriage</dt>
                    <dd><?php if (!empty($update->date_of_marriage)) { echo date("F d, Y", strtotime($update->date_of_marriage)); }?></dd>
                <?php
                }?>
              </dl>
            </div>
            <!-- /.box-body -->
          </div>
          </div> <?php }
          }

          ?>
</div>
</div>
</div>
</div>
</div>
<script>

$('#birthday').Zebra_DatePicker({
direction: -1
});
$('#birthday_').Zebra_DatePicker({
direction: -1
});

$('#add_birthday').Zebra_DatePicker({
direction: -1
});

$('#date_of_marriage').Zebra_DatePicker({
direction: -1
});

$('#add_date_of_marriage').Zebra_DatePicker({
direction: -1
});
          
</script>

<!-- Add Family Modal -->
<div id="add_family_form" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><n class="text-danger"><i class="fa fa-users fa-border"></i><b> Add Family Member Form</b></n></h4>
      </div>
      <div class="modal-body">
         <form class="form-horizontal" name="add_form" action="add_family" method="post">
          <div class="form-group has-feedback" ng-class="{'has-error' : add_form.name.$invalid}">
            <label class="control-label col-sm-3" for="email">Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="name" name="name" ng-model="add_name" placeholder="Name" value="" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="email">Occupation</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Occupation" value="">
            </div>
          </div>
          <div class="form-group has-feedback" ng-class="{'has-error' : add_form.relationship.$invalid}">
            <label class="control-label col-sm-3" for="email">Relationship</label>
            <div class="col-sm-9">
              <select class="form-control" ng-model="add_relationship" name="relationship" id="relationship" required>
                <?php foreach ($relationshipList as $rel)
                { ?>
                     <option value="<?php echo $rel->param_id; ?>" ng-disabled="'<?php echo $rel->status; ?>'"><?php echo $rel->cValue; ?></option>
                  <?php
                } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="email">Contact No.</label>
            <div class="col-sm-9">
              <input type="number" class="form-control" id="contact_no" name="contact_no" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="email">Birthday</label>
            <div class="col-sm-9">
              <input type="text" id="add_birthday" name="add_birthday" placeholder="Birthday" value="">
            </div>
          </div>

          <div class="form-group" ng-show="add_relationship == 72"><!--  //Show if selected relationship is 72 => Spouse -->
            <label class="control-label col-sm-3" for="email">Date of Marriage</label>
            <div class="col-sm-9">
              <input type="text" id="add_date_of_marriage" name="add_date_of_marriage" placeholder="Date of Marriage" value="">
            </div>
          </div>

          <div class="form-group">        
            <div class="col-sm-offset-3 col-sm-9">
              <button type="submit" class="btn btn-success" ng-disabled="add_form.$invalid"><i class="fa fa-plus-circle"></i> Add Family</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<div id="edit_family" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><n class="text-danger"><i class="fa fa-users fa-border"></i><b>Edit Family Data</b></n></h4>
      </div>
      <div class="modal-body"> 
         <form class="form-horizontal" name="pinfo_form" action="update_family_info" method="post">
         <input type="hidden" name="family_id" id="family_id" value="{{family.family_id}}">
          <div class="form-group has-feedback" ng-class="{'has-error' : pinfo_form.name.$invalid}">
            <label class="control-label col-sm-3" for="email">Name</label>
            <div class="col-sm-9" ng-if="!update_family.name">
              <input type="text" class="form-control" id="name" name="name" placeholder="Name" ng-model = "family.name" required>
            </div>
            <div class="col-sm-9" ng-if="update_family.name">
              <input type="text" class="form-control" id="name" name="name" placeholder="Name" ng-model = "update_family.name" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="email">Occupation</label>
            <div class="col-sm-9" ng-if="!update_family.occupation">
              <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Occupation" ng-model="family.occupation">
            </div>
            <div class="col-sm-9" ng-if="update_family.occupation">
              <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Occupation" ng-model="update_family.occupation">
            </div>
          </div>
          <div class="form-group has-feedback" ng-class="{'has-error' : pinfo_form.relationship.$invalid}">
            <label class="control-label col-sm-3" for="email">Relationship</label>
            <div class="col-sm-9" ng-if="!update_family.relationship">
              <select class="form-control" name="relationship" id="relationship" ng-model="family.relationship" required>

                <?php foreach ($relationshipList as $rel)
                { ?>
                      <option value="<?php echo $rel->param_id; ?>" ng-disabled="'<?php echo $rel->status; ?>' && family.relationship != '<?php echo $rel->param_id; ?>'"><?php echo $rel->cValue; ?></option>
                  <?php
                }?>
              </select>
            </div>
             <div class="col-sm-9" ng-if="update_family.relationship">
              <select class="form-control" name="relationship" id="relationship" ng-model="update_family.relationship" required>
                <?php foreach ($relationshipList as $rel)
                { ?>
                      <option value="<?php echo $rel->param_id; ?>" ng-disabled="'<?php echo $rel->status; ?>' && family.relationship != '<?php echo $rel->param_id; ?>'"><?php echo $rel->cValue; ?></option>
                  <?php
                }?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="email">Contact No.</label>
            <div class="col-sm-9" ng-if="!update_family.contact_no">
              <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="Contact Number" ng-model="family.contact_no" >
            </div>
            <div class="col-sm-9" ng-if="update_family.contact_no">
              <input type="number" class="form-control" id="contact_no" name="contact_no" placeholder="Contact Number" ng-model="update_family.contact_no" data-inputmask="'mask': '+63999-999-9999'" placeholder="+639xx-xxx-xxxx">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="email">Birthday</label>
            <div class="col-sm-9" ng-if="!update_family.birthday">
              <input type="date"  name="birthday" placeholder="Contact Number" value="{{family.birthday}}" >
            </div>
             <div class="col-sm-9" ng-if="update_family.birthday">
              <input type="date"  name="birthday" placeholder="Contact Number" value="{{update_family.birthday}}" >
            </div>
          </div>

          <div class="form-group" ng-show="family.relationship == 72">
            <label class="control-label col-sm-3" for="email">Date of Marriage</label>
            <div class="col-sm-9" ng-if="!update_family.date_of_marriage">
              <input type="date" name="date_of_marriage" value="{{family.date_of_marriage}}">
            </div>
            <div class="col-sm-9" ng-if="update_family.date_of_marriage">
              <input type="date"  name="date_of_marriage" value="{{update_family.date_of_marriage}}">
            </div>
          </div>

        <div class="form-group">        
          <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-success" ng-disabled="pinfo_form.$invalid"><i class="fa fa-save"></i> Save Changes</button>
             <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
          </div>
        </div>

        </form>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>

  </div>
</div>

<!-- Delete Modal -->
<div id="delete_family" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><n class="text-danger"><i class="fa fa-users fa-border"></i><b>Delete Family Data</b></n></h4>
      </div>
      <div class="modal-body"><center>
        <p>Are you sure you want to delete the selected Family Record?</p>
        <h4><span>{{family.name}}</span></h4>
        <form name="delete_family" method="post" action="delete_family">
        <input type="hidden" value="{{family.family_id}}" name="id" id="id">
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