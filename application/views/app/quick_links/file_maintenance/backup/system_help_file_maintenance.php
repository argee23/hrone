<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>
<?php foreach($details as $d){ echo $d->portal." | ".$d->module; }?>

<button class="btn btn-info btn-xs pull-right" onclick="system_help_file_maintenance_action('<?php echo $portal;?>','<?php echo $module;?>');"><i class="fa fa-arrow-left"></i></button>
<button class="btn btn-danger btn-xs pull-right" style="margin-right: 5px;" onclick="show_hide_system_help('actionn_filter','actionn_add');">Filter</button>
<button class="btn btn-success btn-xs pull-right" style="margin-right: 5px;" onclick="show_hide_system_help('actionn_add','actionn_filter');">ADD</button>


</h4></ol>
<div class="col-md-12"><br>

  <div class="col-md-12" id="actionn_update" style="display: none;">

  </div>
 
  <div class="col-md-12" id="actionn_add" style="display: none;">
        <div class="col-md-3"></div>
          <div class="col-md-6" id="actionnn">

          <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/system_help/save_system_help_file_maintenance/<?php echo $portal;?>/<?php echo $module;?>" >
              <div class="col-md-12">
               <select class="form-control" name="topic" required onchange="get_sub_topic_list(this.value,'subtopic_add');">
                  <option value="">Select Topic</option>
                  <?php foreach($topic as $t){?>
                    <option value="<?php echo $t->topic_id;?>"><?php echo $t->topic;?></option>
                  <?php } ?>
               </select>
              </div>

              <div class="col-md-12" style="margin-top: 10px;">
                <select class="form-control" name="subtopic_add" id="subtopic_add" required>
                    <option value="">Select Sub Topic</option> 
                </select>
              </div>

              <div class="col-md-12" style="margin-top: 10px;">
                 <input type="text" class="form-control" placeholder="Input Question" name="question" required>
              </div>

              <div class="col-md-12" style="margin-top: 10px;" >
                 <input type="text" class="form-control"  placeholder="Input Answer" name="answer" required>
              </div>


              <div class="col-md-12" style="margin-top: 10px;">
                  <input type="file" name="file" id="file">
                  <n class='text-danger'>Allowed files: 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx'</n> 
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
                  <option value="">Select Topic</option>
                  <?php foreach($topic as $t){?>
                    <option value="<?php echo $t->topic_id;?>"><?php echo $t->topic;?></option>
                  <?php } ?>
               </select>
              </div>

              <div class="col-md-12" style="margin-top: 10px;">
                <select class="form-control" name="subtopic" required id="subtopic_filter">
                    <option value="">Select Sub Topic</option> 
                </select>
              </div>
             
              <div class="col-md-12" style="margin-top: 10px">
                <button class="col-md-12 btn btn-success btn-sm" onclick="filter_system_help_file_maintenance('<?php echo $portal;?>','<?php echo $module;?>');">FILTER</button>
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
                    <th>Sub Topic</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>with Attachment</th>
                    <th>Keyboard</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($file_maintenance as $fm){?>

                <tr>
                    <td><?php echo $fm->id;?></td>
                    <td><?php echo $fm->topic;?></td>
                    <td><?php echo $fm->subtopic;?></td>
                    <td>
                        <?php echo $fm->question;?>
                    </td>
                    <td>
                        <?php echo $fm->question;?>
                    </td>
                    <td>
                        
                            <?php if(!empty($fm->attachment)){ 
                            if(!empty($fm->attachment)){?>
                              <a style='cursor:pointer;' href="<?php echo base_url(); ?>app/system_help/download_system_help/<?php echo $fm->attachment; ?>" aria-hidden='true' data-toggle='tooltip' title='Click to Dowload Attachment for question -  <?php echo $fm->question;?>'>Download Attachment</a>
                            <?php } } else{ echo "No Attachment Found"; } ?>
                        
                    </td>
                    <td>
                      <?php 
                        $keyword = $this->system_help_model->get_file_maintenance_keyword($fm->id);
                        if(empty($keyword)){ echo "No keyword found."; }
                        else
                        {
                          $i=1;
                          foreach($keyword as $k)
                          {
                            echo "<n class='text-danger'>".$i.") ".$k->keyword."<br>"."</n>";
                            $i++;
                          }
                        }
                      ?>
                    </td>
                    <td>

                 
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_add_view_color;?>'  data-toggle='modal' data-target='#modal' href='<?php echo base_url('app/system_help/manage_keywords')."/".$fm->id."/".$portal."/".$module;?>'; aria-hidden='true' data-toggle='tooltip' title='Click to Manage Question <?php echo $fm->question;?> Keyword'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>

                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Question <?php echo $fm->question;?>' onclick="file_maintenance_action('<?php echo $portal;?>','<?php echo $module;?>','<?php echo $fm->id;?>','delete');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                      
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update Question <?php echo $fm->question;?>' onclick="file_maintenance_action_update_form('update','<?php echo $fm->id;?>','<?php echo $portal;?>','<?php echo $module;?>')"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                      
                      <?php  if($fm->InActive==1)
                            {?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Enable Question <?php echo $fm->question;?>' onclick="file_maintenance_action('<?php echo $portal;?>','<?php echo $module;?>','<?php echo $fm->id;?>','enable');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                           
                            <?php } else{?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'   aria-hidden='true' data-toggle='tooltip' title='Click to Disable Question <?php echo $fm->question;?>' onclick="file_maintenance_action('<?php echo $portal;?>','<?php echo $module;?>','<?php echo $fm->id;?>','disable');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                           
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
              
   
    