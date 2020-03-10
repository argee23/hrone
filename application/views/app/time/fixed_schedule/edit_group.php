<div class="row">
<div class="col-md-7">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong><?php echo $company_info->company_name; ?> > Edit Group Name</strong> 
  <a onclick="view_company_group('<?php echo $company_info->company_id; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="View Group"><i class="fa fa-arrow-circle-left fa-2x text-danger pull-right"></i></a>
  </div>
  <div class="box-body">

   <form method="post" action="<?php echo base_url()?>app/time_fixed_schedule/modify_edit_group/<?php echo $this->uri->segment("4");?>" >
        
          <div class="row">
            <div class="col-md-12">

            <div class="form-group">
              <label>Group name</label>
               <input type="text" name="group_name"  onchange="return trim(this)" class="form-control" placeholder="<?php echo $group->group_name; ?>" value="<?php echo $group->group_name; ?>" required>
            </div>
            
         <!--    <?php if($group->wDivision == 1){ ?>
            <div class="form-group">
              <label>Division</label>
               <select class="form-control" name="division" id="division" onchange="getDivisionDepartment(this.value)" >
                <option selected="selected" value="<?php echo $group->division_id; ?>" ><?php if($group->division_id!=0){echo $group->division_name;} else{ echo 'All division';} ?></option>
                <option value="0" >~select all division~</option>
                <?php
                  foreach($company_division as $division ){
                  if($_POST['company_division'] == $division->division_id){
                      $selected = "selected='selected'";
                  }else{
                      $selected = "";
                  }
                  ?>
                <option value="<?php echo $division->division_id;?>" <?php echo $selected;?>><?php echo $division->division_name;?></option>
                <?php }?>
              </select>
            </div>
            <div id="department">
            <div class="form-group">
            <label>Department</label>
              <input type="text" name="departmment" id="department" class="form-control" placeholder="<?php echo $group->department_id; ?>" value="<?php if($group->department_id!=0){echo $group->dept_name;} else{ echo 'All department';} ?>" disabled>
            </div>
            </div>
            <?php } ?>

            <?php if($group->wDivision == 0){ ?>
            <div class="form-group">
              <label>Department</label>
              <select class="form-control" name="department" id="department" onchange="getDepartmentSection(this.value)" required>
                <option selected="selected" alue="<?php echo $group->department_id; ?>" ><?php if($group->department_id!=0){echo $group->dept_name;} else{ echo 'All department';} ?></option>
                <option value="0" >~select all department~</option>
                <?php
                  foreach($company_department as $department ){
                  if($_POST['company_department'] == $department->department_id){
                      $selected = "selected='selected'";
                  }else{
                      $selected = "";
                  }
                  ?>
                <option value="<?php echo $department->department_id;?>" <?php echo $selected;?>><?php echo $department->dept_name;?></option>
                <?php }?>
              </select>
            </div>
            <?php } ?> -->

<!--             <div id="section">
            <div class="form-group">
            <label>Section</label>
              <input type="text" name="section" id="section" class="form-control" placeholder="<?php echo $group->section_id; ?>" value="<?php if($group->section_id!=0){echo $group->section_name;} else{ echo 'All section';} ?>" disabled>
            </div>
            </div>

            <div id="subsection">
            <div class="form-group">
            <label>Subsection</label>
              <input type="text" name="subsection" id="subsection" class="form-control" placeholder="<?php echo $group->subsection_id; ?>" value="<?php if($group->subsection_id!=0){echo $group->subsection_name;} else{ echo 'All subsection';} ?>" disabled>
            </div>
            </div>
 -->

            </div>
           </div>
     
      <div class="form-group">
       <!-- <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> SAVE </button> -->


          <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>

       </div>
      </form>
     </div> 
     </div>

</div>
</div>

</div>  
</div>


