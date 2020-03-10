<div class="row">
<div class="col-md-7">

<div class="box box-default">
<div class="panel panel-default">
  <div class="panel-heading"><strong><?php echo $company_info->company_name; ?></strong> (add group)
   <a onclick="view_company_group('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="View Group list"><i class="fa fa-arrow-circle-left fa-2x text-info pull-right"></i></a>
  </div>
  <div class="box-body">

   <form method="post" action="<?php echo base_url()?>app/time_fixed_schedule/save_add_group/<?php echo $this->uri->segment("4");?>" >
        

          <div class="row">
            <div class="col-md-12">

            <div class="form-group">
              <label>Group name</label>
               <input type="text" name="group_name" class="form-control" placeholder="group name" onchange="return trim(this)" value="" required>
            </div>
            
         <!--    <?php if($company_info->wDivision == 1){ ?>
            <div class="form-group">
              <label>Division</label>
               <select class="form-control" name="division" id="division" onchange="getDivisionDepartment(this.value)" required>
                <option selected="selected" value="0" >~select all division~</option>
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
            <?php } ?>

            <?php if($company_info->wDivision == 0){ ?>
            <div class="form-group">
              <label>Department</label>
              <select class="form-control" name="department" id="department" onchange="getDepartmentSection(this.value)" required>
                <option selected="selected" value="0" >~select all department~</option>
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

            <div id="department">
            </div>

            <div id="section">
            </div>

            <div id="subsection">
            </div>


            </div>
           </div>
     
      <div class="form-group">
       <!-- <button type="submit" class="form-control btn btn-warning"><i class="fa fa-floppy-o"></i> SAVE </button> -->
      
          <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Save';
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


