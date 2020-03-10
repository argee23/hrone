

<div class="box box-solid">
<div class="box-body">
<div class="box-group" id="accordion">
<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->

<form name="myform" role="form" method="post" action="<?php echo base_url()?>app/roles/updateRolePages" onSubmit="return confirm('Are you sure you want to save?');">
<input type="hidden" name="id" id="id" value="<?php echo $roles->role_id?>">

<div class="panel box box-warning">
<div class="box-body">
  

<div class="row">
    <div class="col-md-4">
      <h4><strong>Role Name:</strong><span> <?php echo $roles->role_name?></h4></span>
    </div>
    <div class="col-md-4">
      <h4><strong>Role Description:</strong><span> <?php echo $roles->role_description?></h4></span>         
    </div>
    <div class="col-md-4"><button class="btn btn-primary pull-right" name="btnSubmit" id="btnSubmit" type="submit">Update User Role Pages</button></div>
    
</div>
<h4 class="box-title">Role Permissions</h4>
<div class="box box-success">
      <a data-toggle="collapse"  data-parent="#accordion" href="#collapse_sampple">
  <h4 class="box-title">
Company Access
  </h4>
         </a>   
<div id="collapse_sampple" class="panel-collapse collapse">
<div class="box-body">                                         
<ul style="list-style: none;" >

<?php 
foreach($unrestricted_companyList as $company){
?>
<li><b> <?php echo $company->company_name."</b>"; echo "<ul><span class='text-info'><i class='fa fa-cog'></i> Locations</span><br>";

$company_id=$company->company_id;
//show company lcoations
$loc_per_comp=$this->general_model->get_company_locations($company_id);
if(!empty($loc_per_comp)){
  foreach($loc_per_comp as $myloc){

$check_the_loc=$this->roles_model->get_company_access($company_id,$myloc->location_id,$roles->role_id);
        if(!empty($check_the_loc)){
          if(($myloc->location_id == $check_the_loc->location_id)AND ($company_id == $check_the_loc->company_id)){
              $loc_checked = "checked";
                  }else {
              $loc_checked = "";
                  }
                  }else {
              $loc_checked = "";  
                  }

?>
 <li class="bg-danger">  <input type="checkbox" name="location_id[]" id="location_selected[]" class="flat-red" value="<?php echo $myloc->location_id."/".$company_id;?>"  <?php echo $loc_checked;?>/> <?php echo $myloc->location_name;?></li> 

<?php
  }// locations


}else{
echo "<li><i class='fa fa-warning text-danger'></i> warning: no locations set yet.</li>";
}

echo "<br><span class='text-info'><i class='fa fa-cog'></i> Classifications</span><br>";
//show company lcoations
$class_per_comp=$this->general_model->get_company_classifications($company_id);
if(!empty($class_per_comp)){
  foreach($class_per_comp as $myclass){

$check_the_class=$this->roles_model->get_classification_access($company_id,$myclass->classification_id,$roles->role_id);
        if(!empty($check_the_class)){
          if(($myclass->classification_id == $check_the_class->classification_id)AND ($company_id == $check_the_class->company_id)){
              $class_checked = "checked";
                  }else {
              $class_checked = "";
                  }
                  }else {
              $class_checked = "";  
                  }

?>
 <li class="bg-info">  <input type="checkbox" name="classification_id[]" id="classification_selected[]" class="flat-red" value="<?php echo $myclass->classification_id."/".$company_id;?>"  <?php echo $class_checked;?>/> <?php echo $myclass->classification;?></li> 

<?php
  }// classification


}else{
echo "<li><i class='fa fa-warning text-danger'></i> warning: no classifications set yet.</li>";
}

  echo "</ul>";
?>

</li>
<?php
}// company
?>



</ul>
</div>
</div>

</div>


<?php


$num = 0;
foreach($mysidebar as $mysidebar){
$num = $num + 1;
  $SidebarCBox = & get_instance();
  $SidebarCBox->load->model('app/roles_model');
  $SB_access_leveL = $SidebarCBox->roles_model->getRole_AccessLevel($mysidebar->page_id,$roles->role_id);
    if(!empty($SB_access_leveL)){
        if($mysidebar->page_id == $SB_access_leveL->page_id){
            $SidebarChecked = "checked";
              }else {
            $SidebarChecked = "";
              }
              }else {
            $SidebarChecked = "";  
              }
?>
<div class="box box-success">
<!-- <div class="box-header with-border"> -->
  <h4 class="box-title">
      <a data-toggle="collapse"  data-parent="#accordion" href="#collapse<?php echo $num;?>">
         <?php echo $mysidebar->sidebar;?>
       </a>   
     <!-- <input type="checkbox" id="checkAll" value="<?php //echo $mysidebar->page_id;?>" name="page_id_of_sidebar[]" <?php// echo $SidebarChecked;?> > -->  
  </h4>
<!-- </div>   -->
<div id="collapse<?php echo $num;?>" class="panel-collapse collapse">
<div class="box-body">                                         
<ul style="list-style: none;">
<li>
<h4><input type="checkbox" class="minimal" id="checkAll" value="<?php echo $mysidebar->page_id;?>" name="page_id_of_sidebar[]" <?php echo $SidebarChecked;?>/> <?php echo $mysidebar->sidebar;?></h4>

<?php 
  $ci_New = & get_instance();
  $ci_New->load->model('app/roles_model');
  $links = $ci_New->roles_model->getPageBySidebarModule($mysidebar->sidebar);
foreach($links as $links){                            
  $ci_New2 = & get_instance();
  $ci_New2->load->model('app/roles_model');
      $access_level2 = $ci_New2->roles_model->getRole_AccessLevel($links->page_id,$roles->role_id);
        if(!empty($access_level2)){
          if($links->page_id == $access_level2->page_id){
              $ModuleChecked = "checked";
                  }else {
              $ModuleChecked = "";
                  }
                  }else {
              $ModuleChecked = "";  
                  }
  ?>                  
<div class="col-sm-3">
<strong>

<!-- this checkbox is reference only to check all its associated siblings -->
 <?php echo $links->page_module;?> </strong><!-- <input type='checkbox' class="minimal-red" name='title' /> -->
<!-- <span style="color:#ff0000;font-size: 0.9em;">[check all]</span>   -->                             
                  
<?php
  $ci_obje = & get_instance();
  $ci_obje->load->model('app/roles_model');
  $pages = $ci_obje->roles_model->getPageByPageModule($links->page_module);
      foreach($pages as $pages){                           
          //get the access level of user
      $ci_obj2e = & get_instance();
      $ci_obj2e->load->model('app/roles_model');
      $access_level = $ci_obj2e->roles_model->getRole_AccessLevel($pages->page_id,$roles->role_id);
        if(!empty($access_level)){
        if($pages->page_id == $access_level->page_id){
            $checked = "checked";
              }else {
            $checked = "";
              }
              }else {
            $checked = "";  
              }
      ?>                                                                    
<ul style="list-style: none;">  
  <li><input type="checkbox" name="page_id[]" id="selected[]" class="flat-red" value="<?php echo $pages->page_id;?>" <?php echo $checked;?>  /> <?php echo $pages->page_name_view;?> </li>
</ul>
              <?php }?> 

</div>
              <?php } ?> 
</li>
</ul>                      
      </div><!-- body -->
  </div> <!-- collapse container -->
  </div>
                  <?php }?>
</form>
</div> <!-- accordion -->
</div><!-- /.box-body -->
</div><!-- /.box -->