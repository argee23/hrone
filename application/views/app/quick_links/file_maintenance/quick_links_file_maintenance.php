<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>
<?php foreach($details as $d){ echo $d->portal." | ".$d->module; }?>

<button class="btn btn-info btn-xs pull-right" onclick="quick_links_file_maintenance_action('<?php echo $portal;?>','<?php echo $module;?>');"><i class="fa fa-arrow-left"></i></button>
<?php
if($this->session->userdata('serttech_account')=="1"){
?>

<button class="btn btn-danger btn-xs pull-right" style="margin-right: 5px;" onclick="show_hide_system_help('actionn_filter','actionn_add');">Filter</button>
<button class="btn btn-success btn-xs pull-right" style="margin-right: 5px;" onclick="show_hide_system_help('actionn_add','actionn_filter');">ADD</button>

<?php
}else{
  
}
?>


</h4></ol>
<div class="col-md-12"><br>

  <div class="col-md-12" id="actionn_update" style="display: none;">

  </div>
 
  <div class="col-md-12" id="actionn_add" style="display: none;">
        <div class="col-md-3"></div>
          <div class="col-md-6" id="actionnn">

          <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/quick_links/save_quick_links_file_maintenance/<?php echo $portal;?>/<?php echo $module;?>" >
              <div class="col-md-12">
               <select class="form-control" name="topic" required>
                <?php if(empty($topic)){ echo "<option value=''>No topic found</option>"; } else{?>
                  <option value="">Select Topic</option>
                  <?php foreach($topic as $t){
                    $check_exist =  $this->quick_links_model->check_if_topic_exist($t->topic_id);
                    if(!empty($check_exist)){} else{
                    ?>
                    <option value="<?php echo $t->topic_id;?>"><?php echo $t->topic;?></option>
                  <?php }} }?>
               </select>
              </div>

          
              <div class="col-md-12" style="margin-top: 10px;">
                 <input type="text" class="form-control" placeholder="Input Table Name" name="tablename" required>
              </div>

              <div class="col-md-12" style="margin-top: 10px;" >
                 <input type="text" class="form-control"  placeholder="Input Link" name="link" required>
              </div>


              <div class="col-md-12" style="margin-top: 10px">
                <button class="col-md-12 btn btn-success btn-sm">SAVE</button>
              </div>
          </form>

          </div>
          <div class="col-md-3"></div>
      
  </div>

  <div class="col-md-12" id="actionn_filter" style="display: none;">
       <div class="col-md-3"></div>
          <div class="col-md-6" id="actionnn">

            <div class="col-md-12">
               <select class="form-control" id="topic_filter" name="topic" onchange="get_sub_topic_list(this.value,'subtopic_filter');" required>
                 <?php if(empty($topic)){ echo "<option value=''>No topic found</option>"; } else{?>
                  <option value="">Select Topic</option>
                  <?php foreach($topic as $t){?>
                    <option value="<?php echo $t->topic_id;?>"><?php echo $t->topic;?></option>
                  <?php } }?>
               </select>
              </div>

             
              <div class="col-md-12" style="margin-top: 10px">
                <button class="col-md-12 btn btn-success btn-sm" onclick="filter_quick_links_file_maintenance('<?php echo $portal;?>','<?php echo $module;?>');">FILTER</button>
              </div>
         

          </div>
          <div class="col-md-3"></div>
  </div>

 

  <div class="col-md-12" style="margin-top: 20px;" id="system_help_file_maintenance_view">

         <table id="results" class="table table-hover">
            <thead>
                <tr class="danger">
                    <th>ID</th>
                    <th>Topic</th>
                    <th>Link</th>
                    <th>Table</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($file_maintenance as $fm){?>

                <tr>
                    <td><?php echo $fm->id;?></td>
                    <td><?php echo $fm->topic;?></td>
                    <td>
                        <a href="<?php echo base_url().$fm->link;?>" target="_blank"><?php echo $fm->link;?></a>
                        <?php 
                          $check = $this->quick_links_model->check_link_valid($fm->portal_id,$fm->link);
                        ?>
                    </td>
                    <td>
                        <?php echo $fm->table;?>
                    </td>
                    <td>
      <?php
if($this->session->userdata('serttech_account')=="1"){
      ?>           
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Qiick Link <?php echo $fm->id;?>' onclick="file_maintenance_action('<?php echo $portal;?>','<?php echo $module;?>','<?php echo $fm->id;?>','delete');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                      
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update Quick Link <?php echo $fm->id;?>' onclick="file_maintenance_action_update_form('update','<?php echo $fm->id;?>','<?php echo $portal;?>','<?php echo $module;?>')"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                      



                      <?php  

}else{}

                      if($fm->InActive==1)
                            {?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Enable Quick Link <?php echo $fm->id;?>' onclick="file_maintenance_action('<?php echo $portal;?>','<?php echo $module;?>','<?php echo $fm->id;?>','enable');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                           
                            <?php } else{?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'   aria-hidden='true' data-toggle='tooltip' title='Click to Disable Quick Link <?php echo $fm->id;?>' onclick="file_maintenance_action('<?php echo $portal;?>','<?php echo $module;?>','<?php echo $fm->id;?>','disable');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                           
                      <?php } ?>
                   </td>
                  </td>
                </tr>

            <?php } ?>  
            </thead> 
        </table>    

  </div>    


</div>  
<div class="btn-group-vertical btn-block"> </div>   
              
   
    