<div class="row">
<div class="col-md-7">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong><?php echo $company_name->company_name; ?></strong> (edit group)
  <a onclick="view_company_group('<?php echo $company_name->company_id; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="View Group"><i class="fa fa-arrow-circle-left fa-2x text-danger pull-right"></i></a>
  </div>
  <div class="box-body">

   <form method="post" action="<?php echo base_url()?>app/time_flexi_schedule/modify_edit_group/<?php echo $this->uri->segment("4");?>" >
          <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_name->company_id; ?>">

          <div class="row">
            <div class="col-md-12">

              <?php foreach($group_info as $group){?>

              <div class="form-group">
                <label for="reference_name">Group name</label>
                <input type="text" name="group_name" class="form-control" placeholder="group name" onchange="return trim(this)" value="<?php echo $group->group_name; ?>">
                <p style="color:#ff0000;">Group name is required</p>
              </div>

              <div class="form-group">
                <label for="reference_position">Group description</label>
                <input type="text" name="group_description" class="form-control" placeholder="group description" value="<?php echo $group->group_description; ?>">
                <p style="color:#ff0000;">Group description is required</p>
              </div>

              <div class="form-group">
                <label>Group type</label>
                <input type="text" name="group_type" class="form-control" placeholder="group description" value="<?php if($group->group_type === 'full_flexi'){ echo 'Full flexi'; } else if($group->group_type === 'controlled_flexi'){ echo 'Controlled flexi'; }?>" disabled>
              </div>

              <!-- <div class="form-group">
                <label for="reference_position">Group type</label>
                <select class="form-control" name="group_type" id="group_type" onchange="get_timelimit(this.value)" required>
                    <option selected="selected" value="<?php echo $group->group_type; ?>" ><?php if($group->group_type === 'full_flexi'){ echo 'Full flexi'; } else if($group->group_type === 'controlled_flexi'){ echo 'Controlled flexi'; }?></option>
                    <option value="controlled_flexi" >Controlled flexi</option>
                    <option value="full_flexi" >Full flexi</option>
                </select>
                <p style="color:#ff0000;">Group type is required</p>
              </div>

              <div id="time_limit">
                <?php if($group->group_type === '102'){?>
                    <div class="form-group" >
                      <label for="reference_company">Controlled Time limit (format: 23:59)</label>
                      <input type="text" name="controlled_time_limit" id="controlled_time_limit" class="form-control" placeholder="e.g 23:59" pattern ="^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$" minlength="5" maxlength="5" value="<?php echo $group->controlled_time_limit; ?>" required>
                      <p style="color:#ff0000;">Controlled Time limit is required</p>
                    </div>
                <?php }?>
              </div> -->

              <?php } ?>

            </div>
           </div>
     
      <div class="form-group">
       <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> SAVE CHANGES </button>
       </div>
      </form>
     </div> 
     </div>

</div>
</div>

</div>  
</div>


