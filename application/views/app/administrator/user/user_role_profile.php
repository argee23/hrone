<div class="box box-warning">

	<div class="box-header with-border">
    <blockquote>
      <p><strong><?php echo $user_role->role_name?></strong></p>
      <h5><?php echo $user_role->role_description?></h5>
    </blockquote>
  </div>


	<div class="box-body">

  <!-- <ul>
  <li><a href="#collapseExample" data-toggle="collapse" aria-expanded="false" aria-controls="collapseExample"><strong>Administrator</strong></a>
  <div class="collapse" id="collapseExample">
  <ul>
  <li>File Maintenance
  <ul>
  <li>Sub-dropdown Menu 1</li>
  <li>Sub-dropdown Menu 2</li>
  <li>Sub-dropdown Menu 3</li>
  <li>Sub-dropdown Menu 4</li>
  <li>Sub-dropdown Menu 5</li>
  </ul>
  </li>
  </ul>
  </div>			
  </li>		
  </ul> -->
	
	
<?php 
$num = 0;
foreach($mysidebar as $mysidebar){
$num = $num + 1;
  $SidebarCBox = & get_instance();
  $SidebarCBox->load->model('app/user_model');
  $SB_access_leveL = $SidebarCBox->user_model->getRole_AccessLevel($mysidebar->page_id,$user_role->role_id);
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
    <ul>
      <li>
            <a data-toggle="collapse" aria-expanded="false" aria-controls="collapseExample" href="#collapse<?php echo $num;?>">
                  <strong><?php echo $mysidebar->sidebar;?>   </strong><?php  $page_role_id=$mysidebar->role_id;?> 
            </a>   
                       <div id="collapse<?php echo $num;?>" class="collapse">                                  
                    <?php 
                      $ci_New = & get_instance();
                      $ci_New->load->model('app/user_model');
                      $links = $ci_New->user_model->getPageBySidebarModule($mysidebar->sidebar,$page_role_id);
                    foreach($links as $links){                            
                      $ci_New2 = & get_instance();
                      $ci_New2->load->model('app/user_model');
                          $access_level2 = $ci_New2->user_model->getRole_AccessLevel($links->page_id,$user_role->role_id);
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
                    <ul>        
                    <li>     
<!-- this checkbox is reference only to check all its associated siblings --><strong><?php echo $links->page_module;?> </strong>
              
                      <?php
                        $ci_obje = & get_instance();
                        $ci_obje->load->model('app/user_model');
                        $pages = $ci_obje->user_model->getPageByPageModule($links->page_module,$page_role_id);
                            foreach($pages as $pages){                           
                                //get the access level of user
                            $ci_obj2e = & get_instance();
                            $ci_obj2e->load->model('app/user_model');
                            $access_level = $ci_obj2e->user_model->getRole_AccessLevel($pages->page_id,$user_role->role_id);
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
        <ul> <li><?php echo $pages->page_name_view;?></li></ul>
         </li>
              <?php }?> 
                    
                  </ul>
 
              <?php } ?> 



     </div> 
       </li>   

        </ul>
                  <?php }?>



</div><!--orig-->
