<ol class="breadcrumb">
  <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Enroll Employees</h4>
</ol>
  
  <div class="col-md-12">
      <div class="col-md-6">
          <div class="col-md-4"><label>Company:</label> </div>
          <div class="col-md-8"><n class="text-danger"><u><?php echo $grp_details->company_name?></u></n></div>
      </div>
      <div class="col-md-6">
          <div class="col-md-4"><label>Manager: </label> </div>
          <div class="col-md-8"><n class="text-danger"><u><?php echo $grp_details->first_name." ".$grp_details->last_name?></u></n></div>
      </div>
      <div class="col-md-6">
          <div class="col-md-4"><label>Group:</label> </div>
          <div class="col-md-8"><n class="text-danger"><u><?php echo $grp_details->group_name?></u></n></div>
      </div>
      <div class="col-md-6">
          <div class="col-md-4"><label>Group Details:</label> </div>
          <div class="col-md-8"><n class="text-danger"><u><?php echo $grp_details->group_desc?></u></n></div>
      </div>
  </div>
  <br><br><br><br>
  <div class="box box-default" class='col-md-12'></div></div>
  
<div class="col-md-12" id="edit_admin_action_filter" style="display: none;">
</div>
<div class="col-md-12" style="padding-top:10px;" id='admin_enroll_employee'>
    <div class="col-md-12"><center><h4><b>List of Employees Enrolled</b></h4></center></div>
        <table class="table table-bordered" id="enroll_employee_grp">
          <thead>
           <tr  class="success">
             <th style="width:3%;">ID</th>  
              <th style="width:10%;">Emp ID</th>
              <th style="width:15%;">Name</th>
              <th style="width:20%;">Department</th>
              <th style="width:20%;">Section</th>
              <th style="width:10%;">Location</th>
              <th style="width:15%;">Classification</th>
              <td style="width:7%;">Action</td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($grp_members as $gm) {
              $name = $gm->first_name." ".$gm->last_name;?>
                <tr>
                  <td><?php echo $gm->a_id?></td>
                  <td><?php echo $gm->employee_id?></td>
                  <td><?php echo $name?></td>
                  <td><?php echo $gm->dept_name?></td>
                  <td><?php echo $gm->section_name?></td>
                  <td><?php echo $gm->location_name?></td>
                  <td><?php echo $gm->cname?></td>
                  <td> <?php if($grp_details->ii==1){ }else {?><a onclick="enrol_employee_ac('delete','<?php echo $gm->a_id?>','<?php echo $company?>','<?php echo $group?>')" ><i  class="fa fa-times fa-lg text-info pull-left"></i></a>
                        <?php if($gm->stat==0){?>
                        <a onclick="enrol_employee_ac('disabled','<?php echo $gm->a_id?>','<?php echo $company?>','<?php echo $group?>')" ><i  class="fa fa-power-off fa-lg text-success pull-left"></i></a>
                        <?php }else{ ?>
                        <a onclick="enrol_employee_ac('enabled','<?php echo $gm->a_id?>','<?php echo $company?>','<?php echo $group?>')" ><i  class="fa fa-power-off fa-lg text-danger pull-left"></i></a>
                        <?php }} ?>
                        
                  </td>
                </tr>
            <?php } ?>
          </tbody>
      </table>
      <div class="col-md-12" id='upd_members'>
        <button class="btn btn-danger pull-right" style="margin-left:5px;" onclick="group_by_admin();">BACK</button>
        <button class="btn btn-success pull-right" onclick="admin_update_members('<?php echo $grp_details->company_id?>','<?php echo $grp_details->idd?>','<?php echo $grp_details->manager_in_charge?>' );" <?php if($grp_details->ii==1){ echo "disabled aria-hidden='true' data-toggle='tooltip' title='Not allowed to update members for Inactive group' "; }?> >UPDATE MEMBER/S</button>
      </div>
         <div class="col-md-12" id='loader' style="display: none;"> <h4 class="text-info pull-right"><label><div class="loader"></div>L O A D I N G . .</label></h4></div>
      <br><br><br><br><br>
       <div class="box box-default" class='col-md-12'></div></div>
</div>              
<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 40px;
  height: 40px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>