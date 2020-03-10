 <div class="col-md-4"><center><u>Company</u></center></div>
  <div class="col-md-3"><center><u>Group Name</u></center></div>
  <div class="col-md-4"><center><u>Group Desc</u></center></div>

  <div class="col-md-4">
    <select class="form-control" id="editt_grp_admin_company" disabled>
      <option value="none" disabled selected>Select</option>
      <?php foreach($companyList as $company){?>
      <option value="<?php echo $company->company_id?>" <?php if($grp_details->company_id==$company->company_id){ echo "selected"; } ?> ><?php echo $company->company_name?></option>
      <?php }?>
    </select>
  </div>
  <div class="col-md-3">
      <input type="text" class="form-control" id="edit_grp_admin_grpname" value="<?php if(empty($grp_details->group_name)) {} else{ echo $grp_details->group_name; }?>">
      <input type="hidden"  id="edit_grpname">
  </div>
  <div class="col-md-4">
      <input type="text" class="form-control"  id="edit_grp_admin_grpdesc" value="<?php if(empty($grp_details->group_desc)) {} else{ echo $grp_details->group_desc; }?>">
      <input type="hidden" id="edit_grpdesc">
  </div>
  <div class="col-md-1"><button class="fa fa-check btn btn-success" onclick="update_admin_group('<?php echo $grp_details->id?>');"></button></div>
  <br><br><br>
  <div class="box box-default" class='col-md-12'></div>