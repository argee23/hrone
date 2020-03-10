<?php
$company_id=$this->uri->segment('4');

    $comp_details=$this->general_model->get_company_info($company_id);
    $division_setting=$comp_details->wDivision;
?>
<div class="collapse" id="add_group" >
 <div class="panel box-default">
    <div class="box-header with-border"><strong><i class="fa fa-angle-double-right"></i> Add Group</strong> </div>
      <div class="box-body">

  <form name="f" method="post" action="<?php echo base_url()?>app/time_fixed_schedule/add_group/<?php echo $company_id;?>" target="_blank">     
<div class="form-group"   >
    <label for="next" class="col-sm-2 control-label">Location</label>
  <div class="col-sm-10">
    <?php
    $comp_loc=$this->general_model->get_company_locations($company_id);
    if(!empty($comp_loc)){
      foreach($comp_loc as $loc){
        echo '<input type="checkbox" value="'.$loc->location_id.'" checked name="location[]">'.$loc->location_name.'<br>';  
      }
    }else{
      echo 'warning: no location setup yet.';   

    }
    ?>

  </div>
</div>  
<?php
if($division_setting=="1"){// show division option
?>
<div class="form-group"   >
    <label for="next" class="col-sm-2 control-label">Division</label>
  <div class="col-sm-10">
    <select name="division" class="form-control" id="division_id"  required  onchange="fetch_division_dept();">
    <option value="All" selected>All</option> 
    <?php
    $comp_div=$this->general_model->get_company_divisions($company_id);
    if(!empty($comp_div)){
      foreach($comp_div as $div){
        echo '<option value="'.$div->division_id.'">'.$div->division_name.'</option>';
      }
    }else{
      echo '<option value="" disabled selected>warning : no division created yet.</option>';  

    }
    ?>
</select>
  </div>
</div> 
<div  id="show_div_dept">
<div class="form-group" >
    <label for="department" class="col-sm-2 control-label">Division - Department(s)</label>
  <div class="col-sm-10">
    <select name="department" class="form-control" id="department_id"  required onchange="fetch_section()">
    <option value="All" selected>All</option>
    
    </select>
  </div>
</div> 
</div> 
<?php
}else{
?>
<div class="form-group"  >
    <label for="department" class="col-sm-2 control-label">Department</label>
  <div class="col-sm-10">
    <select name="department" class="form-control" id="department_id"  required onchange="fetch_section()">
    <option value="" selected>All</option>
    <?php
    $comp_dept=$this->general_model->get_company_departments($company_id);
    if(!empty($comp_dept)){
      foreach($comp_dept as $dept){
        echo '<option value="'.$dept->department_id.'">'.$dept->dept_name.'</option>';
      }
    }else{
      echo '<option value="" disabled selected>warning : no department created yet.</option>';    

    }
    ?>
    </select>
  </div>
</div> 

<?php
}
?>

 
<div class="form-group"   >
    <label for="section" class="col-sm-2 control-label">Section</label>
  <div class="col-sm-10" id="show_section">
    <select name="section" class="form-control" id="section"  required >
        <option value="All" selected>-All-</option>
    
    </select>
  </div>
</div>  
<div id="show_sub_section">

</div>
<div class="form-group"   >
    <label for="next" class="col-sm-2 control-label">Classification</label>
  <div class="col-sm-10">
    <?php
    $comp_class=$this->general_model->get_company_classifications($company_id);
    if(!empty($comp_class)){
      foreach($comp_class as $clas){
        echo '<input type="checkbox" value="'.$clas->classification_id.'" checked name="classification[]">'.$clas->classification.'<br>'; 
      }
    }else{
      echo '<span class="text-danger">warning: no classification setup yet.</span>';    

    }
    ?>

  </div>
</div>  

      <button type="submit" class="btn btn-success btn-xs pull-left"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to Show Employees"><i class="fa fa-filter"></i> Show Employees</button>

</form>
      </div>
    </div>
</div>
<div class="box-header"><strong><i class="fa fa-angle-double-right"></i> Group List</strong>
 <button type="button" class="btn btn-danger pull-right btn-xs" data-toggle="collapse" data-target="#add_group" ><i class="fa fa-plus"> Add Group</i></button>
</div>

<?php

if(!empty($fixed_sched_group)){
  foreach($fixed_sched_group as $group_list){
    $group_name= $group_list->group_name ;
    $group_creator_name= $group_list->group_creator_name ;
    $group_id= $group_list->id ;
    $dept= $group_list->dept_name ;
    $sect= $group_list->section_name ;
?>
<div class="col-md-6">
 <div class="box box-success">
    <div class="box-header with-border"> 

 <?php echo $group_name; ?>

  <a class="btn btn-danger btn-xs pull-right" href="<?php echo base_url()?>app/time_fixed_schedule/delete_group/<?php echo $group_id;?>" data-toggle="tooltip" data-placement="left" title="Click to Delete <?php echo $group_name;?>'" onclick="return confirm('Are you sure you want to delete <?php echo $group_name; ?> ?')"  >  <i class="fa fa-times"></i> delete group </a>

<button data-toggle="collapse" data-target="#group_name_edit<?php echo $group_id;?>" class="btn btn-info btn-xs pull-right" >edit group</button>

  <a class="btn btn-warning btn-xs pull-right" href="<?php echo base_url()?>app/time_fixed_schedule/plot_fixed_schedule/<?php echo $group_id;?>/<?php echo $company_id;?>" target="_blank" data-toggle="tooltip" data-placement="left" title="Click to Plot Schedule for <?php echo $group_name;?>'" > <i class="fa fa-calendar"></i> plot schedule </a>

  <a class="btn btn-default btn-xs pull-right" href="<?php echo base_url()?>app/time_fixed_schedule/view_fixed_schedule/<?php echo $group_id;?>/<?php echo $company_id;?>" target="_blank" data-toggle="tooltip" data-placement="left" title="Click to View Schedule for <?php echo $group_name;?>'" > <i class="fa fa-eye"></i> view schedule</a>
     </div>
      <div class="box-body">

<div id="group_name_edit<?php echo $group_id;?>" class="collapse">
<form method="post" action="<?php echo base_url()?>app/time_fixed_schedule/save_edit_group_name" > 

<div class="form-group">
<input type="text" class="form-control" value="<?php echo $group_name;?>" name="group_name">
<input type="hidden" class="form-control" value="<?php echo $group_id;?>" name="group_id">

</div>
<div class="form-group">
      <button type="submit" class="btn btn-danger btn-sm" name="submit"><i class="fa fa-floppy-o"></i> Save</button>
</div>

</form>
</div>
                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <strong><i class="fa fa-get-pocket margin-r-5"></i> Group Name </strong>
                      <span class="text-muted pull-right">
                        <?php echo $group_name; ?>
                      </span>
                    </li>
                    <li class="list-group-item">
                      <strong><i class="fa fa-user margin-r-5"></i> Created By</strong>
                      <span class="text-muted pull-right">
                        <?php echo $group_creator_name;?>
                        <br>
                      </span>
                    </li>
                    <li class="list-group-item">                   
                        <strong><i class="fa fa-building margin-r-5"></i> Department</strong>                    
                      <span class="text-muted pull-right">
                       <?php if($dept==""){ echo 'all';}else{echo $dept;} ?>
                      </span>
                    </li>                   
                    <li class="list-group-item">
                      <strong><i class="fa fa-building-o margin-r-5"></i> Section</strong>
                      <span class="text-muted pull-right">
                             <?php if($sect==""){ echo 'all';}else{echo $sect;} ?>
                      </span>
                    </li>
            <li class="list-group-item">
                      <a data-toggle="collapse" href="#<?php echo $group_id;?>" aria-expanded="false" aria-controls="collapseEmployment">
                        <strong><i class="fa fa-angle-double-down margin-r-5"></i> Members 
<?php
$get_members=$this->time_fixed_schedule_model->get_members_of_group($company_id,$group_id);
echo '<span class="badge">'.count($get_members).'</span>';
?>
                         </strong>
                      </a>
                      <span class="text-muted pull-right">
                        &nbsp;
                      </span>
                    </li>
                      <div class="collapse" id="<?php echo $group_id;?>">       
<?php

$get_members=$this->time_fixed_schedule_model->get_members_of_group($company_id,$group_id);
if(!empty($get_members)){
     foreach($get_members as $member){
      echo  '<li class="list-group-item">
                      <strong><i class="fa fa-user margin-r-5"></i> '.$member->member_name.'</strong>
                      <span class="text-muted pull-right"> </span>
                    </li>';
    }
}else{
      echo '<li class="list-group-item">
                      <strong><i class="fa fa-user margin-r-5"></i> --  None -- </strong>
                      <span class="text-muted pull-right"> </span>
                    </li>';
}

?>

                      </div>
                  </ul>
        </div><!-- /.box -->
</div>
</div>
<?php
  }

}else{
echo 'no group/s yet.';

}
?>
