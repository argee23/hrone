<div class="col-md-9">
  <div class="tab-content">
    <div class="tab-pane active" id="p_info">
      <div class="panel panel-success"> 
        <div class="panel-heading">
          <span class="pull-right"> 
            <?php if($setting=='allowed') { if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else{ ?> <?php } } else{?>
              <a href="#editable_topics">View editable topic</a>
            <?php } ?>
          </span>
          <h4 class="text-danger"><?php if($setting=='allowed') { ?> Employee Government Accounts <?php } else{?> You're not allowed to edit,delete and add <b>Employee Government Accounts</b> <?php } ?></h4>

         <table class="table table-responsive table-bordered table-striped table-hover" style="background-color: #fff">
           <thead>
              <tr>
                <th>Account Type</th>
                <th>Account Number</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
               <tr>
                <td><strong>Bank Number</strong></td>
                <td><?php echo $info->bank; ?>
                  <?php if (empty($info_update->bank) || $info_update->bank==$info->bank) { } else { echo  '<br/><span class="text-primary">' . $info_update->bank  . '</span>'; } ?>
                </td>
                <td>
                    
                <center>
                <button type="button" data-toggle="modal" data-target="#bank" class="btn btn-primary btn-xs" <?php if($setting=='allowed') { if($pending > 0) { echo "disabled"; } else{} }  else{ echo "disabled";}?>><i class="fa fa-edit"></i> Edit </button>
                </center></td>
              </tr>

              <tr>
                <td><strong>SSS Number</strong></td>
                <td><?php echo $info->sss; ?>
                  <?php if (empty($info_update->sss) || $info_update->sss==$info->sss) { } else { echo  '<br/><span class="text-primary">' . $info_update->sss  . '</span>'; } ?>
                </td>
                <td>
                    
                <center>
                <button type="button" data-toggle="modal" data-target="#sss" class="btn btn-primary btn-xs" <?php if($setting=='allowed') { if($pending > 0) { echo "disabled"; } else{} }  else{ echo "disabled";}?>><i class="fa fa-edit"></i> Edit </button>
                </center></td>
              </tr>

               <tr>
                <td><strong>Philhealth Number</strong></td>
                <td><?php echo $info->philhealth; ?>
                            <?php if (empty($info_update->philhealth) || $info_update->philhealth==$info->philhealth) { } else { echo  '<br/><span class="text-primary">' . $info_update->philhealth  . '</span>'; } ?>
                </td>
                <td>

                <center>
                <button type="button" data-toggle="modal" data-target="#philhealth" class="btn btn-primary btn-xs" <?php if($setting=='allowed') {  if($pending > 0) { echo "disabled"; } else{}  } else{ echo "disabled";}?>><i class="fa fa-edit"></i> Edit </button>
                </center></td>
              </tr>

               <tr>
                <td><strong>PAGIBIG Number</strong></td>
                <td><?php echo $info->pagibig; ?>
                <?php if (empty($info_update->pagibig) || $info_update->pagibig==$info->pagibig) {} else { echo  '<br/><span class="text-primary">' . $info_update->pagibig  . '</span>'; } ?>
                </td>
                <td>

                <center>
                <button type="button" data-toggle="modal" data-target="#pagibig" class="btn btn-primary btn-xs" <?php if($setting=='allowed') {  if($pending > 0) { echo "disabled"; } else{}  } else{ echo "disabled";}?>><i class="fa fa-edit"></i> Edit </button>
                </center></td>
              </tr>

               <tr>
                <td><strong>TIN Number</strong></td>
                <td><?php echo $info->tin; ?>      
                <?php if (empty($info_update->tin) || $info_update->tin==$info->tin) { } else { echo  '<br/><span class="text-primary">' . $info_update->tin  . '</span>'; }?>
                </td>
                <td>

                <center>
                <button type="button" data-toggle="modal" data-target="#tin" class="btn btn-primary btn-xs" <?php if($setting=='allowed') {  if($pending > 0) { echo "disabled"; } else{}  } else{ echo "disabled";}?>><i class="fa fa-edit"></i> Edit </button>
                </center></td>
              </tr>
              </tbody>
          </table>
          
        </div>
      </div>
    </div>
  </div>
</div>


  <!-- Modal -->
  <div class="modal fade" id="sss" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4> <n class="text-danger"><i class="glyphicon glyphicon-edit"></i><b> Edit SSS Number</b></n></h4>
        </div>
        <div class="modal-body">
        <form name="sssinfo" role="form" method="post" action="edit_acc">

        <div class="form-group has-feedback" ng-class="{'has-error' : sssinfo.sss.$invalid}">
        <label>SSS No. <i>A <b><u>valid</u></b> SSS number format: <?php echo $sss_set?></i></label>
        <input type="hidden" name="type" id="type" value="sss">
          <input type="text" class="form-control" id="sss" name="sss"
          <?php if(empty($info_update->sss)) {?>  value='<?php echo $info->sss; ?>' <?php } else{?> value='<?php echo $info_update->sss; ?>' <?php } ?> pattern="<?php echo $sss_setting?>" placeholder="<?php echo $sss_set?>" required>  
          
        </div>

        <div class="form-group">
          <label></label>
            
             <div class="col-md-6"><button type="submit" ng-disabled="sssinfo.$invalid" class="btn btn-block btn-success"><i class="fa fa-save"></i>  Save Changes</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
        </div>
      </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!-- SSS Edit -->

  <!-- Modal -->
  <div class="modal fade" id="philhealth" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4> <n class="text-danger"><i class="glyphicon glyphicon-edit"></i><b> Edit Philhealth Number</b></n></h4>
         
        </div>
        <div class="modal-body">
        <form name="philhealthinfo" role="form" method="post" action="edit_acc">
        <input type="hidden" id="type" name="type" value="philhealth">
        <div class="form-group  has-feedback" ng-class="{'has-error' : philhealthinfo.philhealth.$invalid}">
          <label>PhilHealth No. <i>A <b><u>valid</u></b> Philhealth number format: <?php echo $philhealth_set?></i></label>  
            <input type="text" class="form-control" id="philhealth" name="philhealth"  pattern="<?php echo $philhealth_setting?>" placeholder="<?php echo $philhealth_set?>"
              <?php if(empty($info_update->philhealth)) { ?> value='<?php echo $info->philhealth; ?>' <?php } else {?> value='<?php echo $info_update->philhealth; ?>'  <?php } ?>  >
           
        </div>
        <div class="form-group">
          <label></label>
           
             <div class="col-md-6"> <button type="submit" ng-disabled="philhealthinfo.$invalid" class="btn btn-block btn-success"><i class="fa fa-save"></i>  Save Changes</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
        </div>
      </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!-- Philhealth Edit -->

    <!-- Modal -->
  <div class="modal fade" id="pagibig" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
         <h4> <n class="text-danger"><i class="glyphicon glyphicon-edit"></i><b> Edit Pagibig Number</b></n></h4>
        </div>
        <div class="modal-body">
        <form name="pagibiginfo" role="form" method="post" action="edit_acc">
        <input type="hidden" id="type" name="type" value="pagibig">


      <div class="form-group has-feedback" ng-class="{'has-error' : pagibiginfo.pagibig.$invalid}">
        <label>Pagibig No. <i>A <b><u>valid</u></b> Philhealth number format: <?php echo $pagibig_set?></i></label>
          <input type="text" class="form-control" id="pagibig" name="pagibig" 
           <?php if(empty($info_update->pagibig)) {?> value='<?php echo $info->pagibig; ?>' <?php } else { ?> value= '<?php echo $info_update->pagibig; ?>'  <?php } ?> pattern="<?php echo $pagibig_setting?>" placeholder="<?php echo $pagibig_set?>">
          
      </div>

        <div class="form-group">
          <label></label>
            
              <div class="col-md-6"><button type="submit" ng-disabled="pagibiginfo.$invalid" class="btn btn-block btn-success"><i class="fa fa-save"></i>  Save Changes</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
        </div>
      </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!-- PAGIBIG Edit -->

  <!-- Modal -->
  <div class="modal fade" id="tin" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
         <h4> <n class="text-danger"><i class="glyphicon glyphicon-edit"></i><b> Edit TIN Number</b></n></h4>
        </div>
        <div class="modal-body">
        <form name="tininfo" role="form" method="post" action="edit_acc">
        <input type="hidden" id="type" name="type" value="tin">
      <div class="form-group has-feedback" ng-class="{'has-error' : tininfo.tin.$invalid}">
        <label>TIN No. <i>A <b><u>valid</u></b> Tin number format: <?php echo $tin_set?></i></label>
        <input type="text" class="form-control" id="tin" name="tin" 
              <?php if(empty($info_update->tin)) { ?> value= '<?php echo $info->tin; ?>' <?php } else {?> value='<?php echo $info_update->tin; ?>' <?php } ?> pattern="<?php echo $tin_setting?>" placeholder="<?php echo $tin_set?>">
           
      </div>

        <div class="form-group">
          <label></label>
            
             <div class="col-md-6"><button type="submit" ng-disabled="tininfo.$invalid" class="btn btn-block btn-success"><i class="fa fa-save"></i>  Save Changes</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
        </div>
      </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!--TIN Edit -->

   <!-- Modal -->
  <div class="modal fade" id="bank" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4> <n class="text-danger"><i class="glyphicon glyphicon-edit"></i><b> Edit Bank Account</b></n></h4>
        </div>
        <div class="modal-body">
        <form name="bankinfo" role="form" method="post" action="edit_acc">
        <input type="hidden" id="type" name="type" value="bank">
      <div class="form-group has-feedback" ng-class="{'has-error' : bankinfo.bank.$invalid}">
        <label>Bank No. <i>A <b><u>valid</u></b> Bank number format: <?php echo $bank_set?></i></label>
           <input type="text" class="form-control" id="bank" name="bank" 
              <?php if(empty($info_update->bank)) { ?> value= '<?php echo $info->bank; ?>' <?php } else {?> value = '<?php echo $info_update->bank; ?>'  <?php } ?>  pattern="<?php echo $bank_setting?>" placeholder="<?php echo $bank_set?>" >
           
      </div>

        <div class="form-group">
          <label></label>
            
            <div class="col-md-6"><button type="submit" ng-disabled="bankinfo.$invalid" class="btn btn-block btn-success"><i class="fa fa-save"></i>  Save Changes</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
        </div>
      </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!--TIN Edit -->