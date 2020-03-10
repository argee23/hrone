<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Settings | <?php if($option=='setting'){ echo "Allow Setting";  } else { echo $option; } ?></h4></ol>
<div class="col-md-12" ><br>
  
  <?php if($option=='portal'){?> 

   
             
      <div class="col-md-12">
          <div class="col-md-3"></div>
          <div class="col-md-6" id="actionnn">

          <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/system_help_link_settings/save_portal/<?php echo $option;?>" >
              <div class="col-md-12">
                <input type="text" name="portal" id="portal" class="form-control"  required>
              </div>
              <div class="col-md-12" style="margin-top: 10px">
                <button class="col-md-12 btn btn-success btn-sm">SAVE</button>
              </div>
          </form>

          </div>
          <div class="col-md-3"></div>
      </div> 
    
    <div class="col-md-12">
        <table id="results" class="table table-hover">
            <thead>
                <tr class="danger">
                    <th>ID</th>
                    <th>Portal</th>
                    <th>Status</th>
                    <th>Date Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($details as $d){?>
                <tr>
                   <td><?php echo $d->portal_id;?></td>
                   <td><?php echo $d->portal;?></td>
                   <td><?php if($d->InActive==1){ echo "InActive"; } else{ echo "Active"; } ?></td>
                   <td><?php echo $d->date_added;?></td>
                   <td>
                   <?php if($d->IsDefault==1)
                   {
                      echo "<n class='text-danger'>You are not allowed to update the 'Default' portal.</n>";
                   }
                   else
                   {?>

                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete <?php echo $d->portal;?>' onclick="portal_action('delete','<?php echo $d->portal_id;?>','admin_help_settings_portal','portal','portal_id');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                      
                     <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update <?php echo $d->portal;?>' onclick="portal_update('<?php echo $d->portal_id;?>','<?php echo $option;?>','portal_id','admin_help_settings_portal');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                      
                      <?php if($d->InActive==1)
                            {?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Enable <?php echo $d->portal;?>'  onclick="portal_action('enable','<?php echo $d->portal_id;?>','admin_help_settings_portal','portal','portal_id');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                           
                            <?php } else{?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'   aria-hidden='true' data-toggle='tooltip' title='Click to Disable <?php echo $d->portal;?>' onclick="portal_action('disable','<?php echo $d->portal_id;?>','admin_help_settings_portal','portal','portal_id');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                           
                      <?php } }?>
                  
                   </td>
                </tr>
            <?php } ?>
            </thead> 
        </table>
    </div>

  <?php } else if($option=='category'){?>

     <div class="col-md-12">
          <div class="col-md-3"></div>
          <div class="col-md-6" id="actionnn">

          <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/system_help_link_settings/save_category/<?php echo $option;?>" >

              <div class="col-md-12">
                <select class="form-control" name="portal" id="portal" required>
                    <option value=""  selected>Select Portal</option>
                    <?php foreach($portal_details as $p){?>
                       <option value="<?php echo $p->portal_id;?>"><?php echo $p->portal;?></option>
                    <?php } ?>
                </select>
              </div>

              <div class="col-md-12" style="margin-top: 10px;">
                <input type="text" name="category" name="category" class="form-control" required>
              </div>
              <div class="col-md-12" style="margin-top: 10px" required>
                <button class="col-md-12 btn btn-success btn-sm">SAVE</button>
              </div>
          </form>

          </div>
          <div class="col-md-3"></div>
      </div> 
    
    <div class="col-md-12">
        <table id="results" class="table table-hover">
            <thead>
                <tr class="danger">
                    <th>ID</th>
                    <th>Portal</th>
                    <th>Module</th>
                    <th>Status</th>
                    <th>Date Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($details as $d){?>
                <tr>
                   <td><?php echo $d->module_id;?></td>
                   <td><?php echo $d->portal;?></td>
                   <td><?php echo $d->module;?></td>
                   <td><?php if($d->InActive==1){ echo "InActive"; } else{ echo "Active"; } ?></td>
                   <td><?php echo $d->date_added;?></td>
                   <td>
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete <?php echo $d->portal;?>' onclick="portal_action('delete','<?php echo $d->module_id;?>','admin_help_settings_module','category','module_id');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                      
                     <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update <?php echo $d->portal;?>' onclick="portal_update('<?php echo $d->module_id;?>','<?php echo $option;?>','module_id','admin_help_settings_module');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                      
                      <?php if($d->InActive==1)
                            {?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Enable <?php echo $d->portal;?>'  onclick="portal_action('enable','<?php echo $d->module_id;?>','admin_help_settings_module','category','module_id');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                           
                            <?php } else{?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'   aria-hidden='true' data-toggle='tooltip' title='Click to Disable <?php echo $d->portal;?>' onclick="portal_action('disable','<?php echo $d->module_id;?>','admin_help_settings_module','category','module_id');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                           
                      <?php } ?>
                     
                   </td>
                </tr>
            <?php } ?>
            </thead> 
        </table>
    </div>

  <?php } else if($option=='module'){?>

    <div class="col-md-12">
          <div class="col-md-3"></div>
          <div class="col-md-6" id="actionnn">

          <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/system_help_link_settings/save_module/<?php echo $option;?>" >

              <div class="col-md-12">
                <select class="form-control" name="portal" id="portal" required onchange="get_category(this.value);">
                    <option value="" selected>Select Portal</option>
                     <?php foreach($portal_details as $p){?>
                       <option value="<?php echo $p->portal_id;?>"><?php echo $p->portal;?></option>
                    <?php } ?>
                </select>
              </div>

              <div class="col-md-12" style="margin-top: 10px;">
                <select class="form-control" name="module" id="module" required>
                    <option value=""  selected>Select Module</option>
                </select>
              </div>

              <div class="col-md-12" style="margin-top: 10px;">
                <input type="text" name="topic" name="topic" class="form-control" required>
              </div>
              <div class="col-md-12" style="margin-top: 10px" required>
                <button class="col-md-12 btn btn-success btn-sm">SAVE</button>
              </div>
          </form>

          </div>
          <div class="col-md-3"></div>
      </div> 
    
    <div class="col-md-12">
        <table id="results" class="table table-hover">
            <thead>
                <tr class="danger">
                    <th>ID</th>
                    <th>Portal</th>
                    <th>Module</th>
                    <th>Topic</th>
                    <th>Status</th>
                    <th>Date Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($details as $d){?>
                <tr>
                   <td><?php echo $d->topic_id;?></td>
                   <td><?php echo $d->portal;?></td>
                   <td><?php echo $d->module;?></td>
                   <td><?php echo $d->topic;?></td>
                   <td><?php if($d->InActive==1){ echo "InActive"; } else{ echo "Active"; } ?></td>
                   <td><?php echo $d->date_added;?></td>
                   <td>
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete <?php echo $d->portal;?>' onclick="portal_action('delete','<?php echo $d->topic_id;?>','admin_help_settings_topic','module','topic_id');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                      
                     <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update <?php echo $d->portal;?>' onclick="portal_update('<?php echo $d->topic_id;?>','<?php echo $option;?>','module_id','admin_help_settings_topic');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                      
                      <?php if($d->InActive==1)
                            {?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Enable <?php echo $d->portal;?>'  onclick="portal_action('enable','<?php echo $d->topic_id;?>','admin_help_settings_topic','module','topic_id');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                           
                            <?php } else{?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'   aria-hidden='true' data-toggle='tooltip' title='Click to Disable <?php echo $d->portal;?>' onclick="portal_action('disable','<?php echo $d->topic_id;?>','admin_help_settings_topic','module','topic_id');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                           
                      <?php } ?>
                     
                   </td>
                </tr>
            <?php } ?>
            </thead> 
        </table>
    </div>


  <?php } else if($option=='topic'){ ?>

  <div class="col-md-12">
          <div class="col-md-3"></div>
          <div class="col-md-6" id="actionnn">

          <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/system_help_link_settings/save_subtopic/<?php echo $option;?>" >

              <div class="col-md-12">
                <select class="form-control" name="portal" id="portal" required onchange="get_category(this.value);">
                    <option value="" selected>Select Portal</option>
                     <?php foreach($portal_details as $p){?>
                       <option value="<?php echo $p->portal_id;?>"><?php echo $p->portal;?></option>
                    <?php } ?>
                </select>
              </div>

              <div class="col-md-12" style="margin-top: 10px;">
                <select class="form-control" name="module" id="module" required onchange="get_topic(this.value);">
                    <option value=""  selected>Select Module</option>
                </select>
              </div>

               <div class="col-md-12" style="margin-top: 10px;">
                <select class="form-control" name="topic" id="topic" required>
                    <option value=""  selected>Select Topic</option>
                </select>
              </div>

              <div class="col-md-12" style="margin-top: 10px;">
                <input type="text" name="subtopic" name="subtopic" class="form-control" required>
              </div>
              <div class="col-md-12" style="margin-top: 10px" required>
                <button class="col-md-12 btn btn-success btn-sm">SAVE</button>
              </div>
          </form>

          </div>
          <div class="col-md-3"></div>
      </div> 
    
    <div class="col-md-12">
        <table id="results" class="table table-hover">
            <thead>
                <tr class="danger">
                    <th>ID</th>
                    <th>Portal</th>
                    <th>Module</th>
                    <th>Topic</th>
                    <th>SubTopic</th>
                    <th>Status</th>
                    <th>Date Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($details as $d){?>
                <tr>
                   <td><?php echo $d->subtopic_id;?></td>
                   <td><?php echo $d->portal;?></td>
                    <td><?php echo $d->module;?></td>
                   <td><?php echo $d->topic;?></td>
                   <td><?php echo $d->subtopic; ?></td>
                    <td><?php if($d->InActive==1){ echo "InActive"; } else{ echo "Active"; } ?></td>
                   <td><?php echo $d->date_added;?></td>
                   <td>
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete <?php echo $d->portal;?>' onclick="portal_action('delete','<?php echo $d->subtopic_id;?>','admin_help_settings_subtopic','topic','subtopic_id');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                      
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update <?php echo $d->portal;?>' onclick="portal_update('<?php echo $d->subtopic_id;?>','<?php echo $option;?>','subtopic_id','admin_help_settings_subtopic');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i><?php echo $d->subtopic_id;?></a>
                      
                      <?php if($d->InActive==1)
                            {?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Enable <?php echo $d->portal;?>'  onclick="portal_action('enable','<?php echo $d->subtopic_id;?>','admin_help_settings_subtopic','topic','subtopic_id');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                           
                            <?php } else{?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'   aria-hidden='true' data-toggle='tooltip' title='Click to Disable <?php echo $d->portal;?>' onclick="portal_action('disable','<?php echo $d->subtopic_id;?>','admin_help_settings_subtopic','topic','subtopic_id');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                           
                      <?php } ?>
                     
                   </td>
                </tr>
            <?php } ?>
            </thead> 
        </table>
    </div>


  <?php } else {?>

    
    <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/system_help_link_settings/save_allow_settings/<?php echo 'not_included';?>" >
    <div class="col-md-12">
        <table id="results" class="table table-hover">
            <thead>
                <tr class="danger">
                    <th>ID</th>
                    <th>Portal</th>
                    <th>Allow to view System help</th>
                    <th>Allow to view Quick links</th>
                </tr>
            </thead>
            <tbody>
            <?php
               $portal =  $this->system_help_link_settings_model->get_details('portal');
               foreach($portal as $p){
                if($p->portal_id==1 || $p->portal_id==2){} else{
                  $value = $this->system_help_link_settings_model->get_allow_setting_value($p->portal_id,$this->session->userdata('company_id'));
            ?>

                 <tr>
                    <td><?php echo $p->portal_id;?></td>
                    <td><?php echo $p->portal;?></td>
                    <td>
                        <select class="form-control" style="width: 100%;" name="system_help<?php echo $p->portal_id;?>">
                         <option value="0" <?php if(empty($value->allow_system_help) || $value->allow_system_help==0){ echo "selected"; }?>>No</option>
                         <option value="1" <?php if(!empty($value->allow_system_help) AND $value->allow_system_help=='1'){ echo "selected"; } ?>>Yes</option>
                       
                        </select>
                    </td>
                    <td>
                        <select class="form-control" style="width: 100%;" name="quick_links<?php echo $p->portal_id;?>">
                          <option value="0" <?php if(empty($value->allow_quick_links) || $value->allow_quick_links==0){ echo "selected"; }?>>No</option>
                          <option value="1" <?php if(!empty($value->allow_quick_links) AND $value->allow_quick_links=='1'){ echo "selected"; } ?>>Yes</option>
                        </select>
                    </td>
                  </tr>

            <?php } } ?>
            </thead> 
        </table>
    </div>

    <div class="col-md-3 pull-right" style="margin-top: 30px;">
        <?php if(!empty($portal)){ ?> <button class="col-md-12 btn btn-success"> <i class="fa fa-check"></i>SAVE SETTING</button> <?php  } 
        else { echo "No portal found."; }?>
    </div>

    </form>

  <?php } ?>

</div>  
<div class="btn-group-vertical btn-block"> </div>   
     