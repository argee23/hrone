<div class="col-md-9">
  <div class="tab-content">
    <div class="tab-pane active" id="p_info">
      <div class="panel panel-success"> 
        <div class="panel-heading">
          <span class="pull-right"> 
            <?php if($setting=='allowed') {  if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else{ ?> 
             <?php echo "<a type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#modal' href='".base_url('employee_portal/employee_201/add_dependent_modal')."/".$this->session->userdata('employee_id')."'>";?><i class="fa fa-plus"></i> Add Dependent/s</a>
              <?php } } else{?>  <a href="#editable_topics">View editable topic</a>  <?php } ?>
          </span>
          <h4 class="text-danger"><?php if($setting=='allowed') { ?> Dependents <?php } else{?> You're not allowed to edit,delete and add <b>Dependents</b> <?php } ?></h4>
          <?php foreach ($info as $dependent) { ?>

               <?php

              $update = null;
              foreach($update_info as $obj) {
                  if ($dependent->dependent_id == $obj->id) {
                      $update = $obj;
                      break;
                  }
              }
              ?>
		<div class="box box-solid" >
            <div class="box-header bg-olive with-border">
              <i class="fa fa-users fa-border"></i>


              <h4 class="box-title"><?php echo $dependent->first_name . " " . $dependent->middle_name . " " . $dependent->last_name . " " . $dependent->name_ext; ?></h4>
               <div class="pull-right">
               <?php if($setting=='allowed') { if($pending > 0) {} else{ ?>
                 <?php echo "<a type='button' class='btn btn-primary btn-xs' data-toggle='modal' data-target='#modal' href='".base_url('employee_portal/employee_201/getDependent')."/".$dependent->dependent_id."'>";?><i class="fa fa-edit"></i>Edit</a>

                  <?php echo "<a type='button' class='btn btn-danger btn-xs' data-toggle='modal' data-target='#modal' href='".base_url('employee_portal/employee_201/delDependent')."/".$dependent->dependent_id."'>";?><i class="fa fa-edit"></i>Delete</a>

                <?php } } else{}?>
               </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <dl class="dl-horizontal">
                <dt>First Name</dt>
                <dd><?php echo $dependent->first_name; ?></dd>
                <?php if (empty($update->first_name) || $update->first_name==$dependent->first_name) {} else { echo  '<dd class="text-primary">' . $update->first_name . '</dd>'; } ?>
                <dt>Middle Name</dt>
                <dd><?php echo $dependent->middle_name; ?></dd>
                <?php if (empty($update->middle_name) || $update->middle_name==$dependent->middle_name) {} else { echo  '<dd class="text-primary">' . $update->middle_name . '</dd>'; }?>
                <dt>Last Name</dt>
                <dd><?php echo $dependent->last_name; ?></dd>
                <?php if (empty($update->last_name) || $update->last_name==$dependent->last_name) {} else { echo  '<dd class="text-primary">' . $update->last_name . '</dd>'; }?>
                <dt>Birthday</dt>
                <dd><?php echo date("F d, Y", strtotime($dependent->birthday)); ?></dd>
                <?php if (empty($update->birthday) || $update->birthday==$dependent->birthday) { } elseif($update->birthday=='0000-00-00') {} else { echo  '<dd class="text-primary">' . date("F d, Y", strtotime($update->birthday)) . '</dd>'; } ?>
                <dt>Gender</dt>
                <dd><?php echo $dependent->gender_name; ?></dd>
                <?php if (empty($update->gender) || $update->gender==$dependent->gender) { } else { echo  '<dd class="text-primary">' . $update->gender_name . '</dd>'; } ?>
                <dt>Civil Status</dt>
                <dd><?php echo $dependent->civil_status_name; ?></dd>
                <?php if (empty($update->civil_status) || $update->civil_status==$dependent->civil_status) {} else { echo  '<dd class="text-primary">' . $update->civil_status_name. '</dd>'; } ?>
                <dt>Relationship</dt>
                <dd><?php echo $dependent->relationship_name; ?></dd>
                <?php if (empty($update->relationship) || $update->relationship==$dependent->relationship) {} else { echo  '<dd class="text-primary">' . $update->relationship_name . '</dd>'; } ?>
              </dl>
            </div>
            <!-- /.box-body -->
            <?php if ($dependent->request_status) { ?>
             <div class="overlay">
              <i class="fa fa-trash-o"></i>
            </div>
            <?php } ?>
          </div>


 <?php } ?>


<?php foreach ($update_info as $dependent){
  if (!($dependent->id)) { ?>

      <div class="box box-solid" >
            <div class="box-header bg-gray with-border">
              <i class="fa fa-users fa-border"></i>


              <h4 class="box-title"><?php echo $dependent->first_name . " " . $dependent->middle_name . " " . $dependent->last_name . " " . $dependent->name_ext; ?></h4>
               <div class="pull-right">
             <span class="label label-success">
                <?php if($pending==0){ ?>Waiting for you to send the update request <?php 
                  } else {?>Waiting for HR Approval<?php } ?>&nbsp;<i class="fa fa-hourglass-start"></i></span>
               </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <dl class="dl-horizontal">
                <dt>First Name</dt>
                <dd><?php echo $dependent->first_name; ?></dd>
                <?php if ($dependent->middle_name) {?>
                <dt>Middle Name</dt>
                <dd><?php echo $dependent->middle_name; ?></dd>
                 <?php } ?>
                <dt>Last Name</dt>
                <dd><?php echo $dependent->last_name; ?></dd>
                <dt>Birthday</dt>
                <dd><?php echo date("F d, Y", strtotime($dependent->birthday)); ?></dd>
                <dt>Gender</dt>
                <dd><?php echo $dependent->gender_name; ?></dd>
                <dt>Civil Status</dt>
                <dd><?php echo $dependent->civil_status; ?></dd>
                <dt>Relationship</dt>
                <dd><?php echo $dependent->relationship_name; ?></dd>
              </dl>
            </div>
            <!-- /.box-body -->
          </div>
    <?php
  }
} ?>
 </div>
      </div>
    </div>
  </div>
</div>
 <div id="modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
       <div class="modal-content modal-md">
       </div>
    </div>
</div>


<!-- End: Edit Modal -->

<script>

$('#birthday').Zebra_DatePicker({
direction: -1
});

$('#add_birthday').Zebra_DatePicker({
direction: -1
});

function checkStartDate(datestart, form_name) {
    var x = document.forms[form_name][datestart].value;
    if (x == "") {
        alert("Please specify the birthday field.");
        return false;
    }
}
   
      
</script>


