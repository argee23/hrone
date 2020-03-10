
<ol class="breadcrumb">
  <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Create Group
      <a class='btn btn-default btn-xs pull-right' style="margin-right: 5px;" onclick="group_by_admin();" aria-hidden='true' data-toggle='tooltip' title='Home'>Home</a>
      <a class='btn btn-default btn-xs pull-right' style="margin-right: 5px;" onclick="display_action('filter');" aria-hidden='true' data-toggle='tooltip' title='Filter by company'>Filter</a>
      <a class='btn btn-info btn-xs pull-right' style="margin-right: 5px;" onclick="display_action('add');" aria-hidden='true' data-toggle='tooltip' title='Click to add new group'>Add Group</a>
  </h4>
</ol>

<div class="col-md-12" id="create_admin_action_add" style="display: none;">
  <div class="col-md-4"><center><u>Company</u></center></div>
  <div class="col-md-3"><center><u>Group Name</u></center></div>
  <div class="col-md-4"><center><u>Group Desc</u></center></div>

  <div class="col-md-4">
    <select class="form-control" id="grp_admin_company">
      <option value="none" disabled selected>Select</option>
      <?php foreach($companyList as $company){?>
      <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
      <?php }?>
    </select>
  </div>
  <div class="col-md-3">
      <input type="text" class="form-control" placeholder="Input Group Name" id="grp_admin_grpname">
      <input type="hidden"  id="grpname">
  </div>
  <div class="col-md-4">
      <input type="text" class="form-control" placeholder="Input Group Desc" id="grp_admin_grpdesc">
      <input type="hidden" id="grpdesc">
  </div>
  <div class="col-md-1"><button class="fa fa-check btn btn-success" onclick="save_admin_group();"></button></div>
  <br><br><br>
  <div class="box box-default" class='col-md-12'></div>
</div>

<div class="col-md-12" id="create_admin_action_filter" style="display: none;">
  <div class="col-md-6">
    <div class="col-md-3"><label>Company :</label></div>
      <div class="col-md-9">
        <select class="form-control" onchange="view_group_filter(this.value);">
            <option value="">Select</option>
            <?php  foreach($companyList as $company){?>
                <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
            <?php }?>
        </select>
      </div>
    </div>
  <br><br><br>
  <div class="box box-default" class='col-md-12'></div>
</div>
  
<div class="col-md-12" id="edit_admin_action_filter" style="display: none;">
</div>
<div class="col-md-12" style="padding-top:10px;" id='view_grp_by_admin'>
         
      <table class="table table-bordered" id="table_grp_admin">
          <thead>
           <tr  class="success">

              <th style="width:5%;"></th>
              <th style="width:25%;">Company Name</th>
              <th style="width:30%;">Group Name</th>
              <th style="width:25%;">Group Description</th>
              <th style="width:15%;">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($groups as $grp){
            $count = $this->plot_schedules_model->employee_enrolled($grp->id);?>
            <tr>

              <td><span class="badge"><?php echo $count?></span></td>
              <td><?php echo $grp->company_name?></td>
              <td><?php echo $grp->group_name?></td>
              <td><?php if(empty($grp->group_desc)) { echo "No description found. "; } else { echo $grp->group_desc; } ?></td>
              <td>
                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="edit_grp_admin('edit_admin_action_filter','<?php echo $grp->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Group details' ><i  class="fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-left"></i></a>
                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="edd_group('delete','<?php echo $grp->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to delete group' ><i  class="fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg pull-left"></i></a>
                <?php if($grp->stat==0){?>
                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>' onclick="edd_group('disabled','<?php echo $grp->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to disable group'><i  class="fa fa-power-off fa-lg pull-left"></i></a>
                <?php }else{ ?>
                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' onclick="edd_group('enabled','<?php echo $grp->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to enable group'><i  class="fa fa-power-off fa-lg pull-left"></i></a>
                <?php } ?>
                 <a style='cursor:pointer;' onclick="enrol_employees('<?php echo $grp->id?>','<?php echo $grp->company_id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to update group members'><i  class="fa fa-user fa-lg text-danger pull-left"></i></a>
                  <a style='cursor:pointer;' href="<?php echo base_url()?>app/plot_schedules/admin_group_plot_sched/<?php echo $grp->id;?>/<?php echo $grp->company_id;?>" target="_blank" aria-hidden='true' data-toggle='tooltip' title='Click to plot schedule for the selected group'><i  class="fa fa-calendar fa-lg text-warning pull-left"></i></a>
              </td>
            </tr> 
          <?php } ?>
          </tbody>
      </table>
</div>              