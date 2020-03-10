
         <table id="results" class="table table-hover">
            <thead>
                <tr class="danger">
                    <th>ID</th>
                    <th>Topic</th>
                    <th>Sub Topic</th>
                    <th>Question</th>
                    <th>Answer</th>
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
                        <div id="question_orig<?php echo $fm->id;?>"><?php echo $fm->question;?></div>
                        <div id="question_upd<?php echo $fm->id;?>" style='display: none;'>
                            <textarea class="form-control" rows="4" id="question_value<?php echo $fm->id;?>"><?php echo $fm->question;?></textarea>
                            <input type="hidden" id="question_value_final<?php echo $fm->id;?>">
                        </div>
                    </td>
                    <td>
                        <div id="answer_orig<?php echo $fm->id;?>"><?php echo $fm->question;?></div>
                        <div id="answer_upd<?php echo $fm->id;?>" style='display:none;'>
                            <textarea class="form-control" rows="4" id="answer_value<?php echo $fm->id;?>"><?php echo $fm->answer;?></textarea>
                            <input type="hidden" id="answer_value_final<?php echo $fm->id;?>">
                        </div>

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

                    <div id="action_orig<?php echo $fm->id;?>">
                     
                      
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_add_view_color;?>'  data-toggle='modal' data-target='#modal' href='<?php echo base_url('app/system_help/manage_keywords')."/".$fm->id."/".$portal."/".$module;?>'; aria-hidden='true' data-toggle='tooltip' title='Click to Manage Question <?php echo $fm->question;?> Keyword'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>

                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Question <?php echo $fm->question;?>' onclick="file_maintenance_action('<?php echo $portal;?>','<?php echo $module;?>','<?php echo $fm->id;?>','delete');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                      
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update Question <?php echo $fm->question;?>' onclick="file_maintenance_action_update_form('update','<?php echo $fm->id;?>')"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                      
                      <?php if($fm->InActive==1)
                            {?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Enable Question <?php echo $fm->question;?>' onclick="file_maintenance_action('<?php echo $portal;?>','<?php echo $module;?>','<?php echo $fm->id;?>','enable');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                           
                            <?php } else{?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'   aria-hidden='true' data-toggle='tooltip' title='Click to Disable Question <?php echo $fm->question;?>' onclick="file_maintenance_action('<?php echo $portal;?>','<?php echo $module;?>','<?php echo $fm->id;?>','disable');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                           
                      <?php } ?>
                    </div>

                    <div id="action_upd<?php echo $fm->id;?>" style='display: none;'>

                     
                      <a aria-hidden='true' data-toggle='tooltip' title='Click to Save Update <?php echo $fm->question;?>' onclick="save_file_maintenance_update('<?php echo $fm->id;?>','<?php echo $portal;?>','<?php echo $module;?>');"><i class="fa fa-check fa-lg  pull-left text-success"></i></a>
                      <a aria-hidden='true' data-toggle='tooltip' title='Click to Cancel Update <?php echo $fm->question;?>' onclick="cancel_file_maintenance_update('<?php echo $fm->id;?>');"><i class="fa fa-times fa-lg  pull-left text-danger"></i></a>
                      

                    </div>

                   </td>

                    </td>
                </tr>


            <?php } ?>  
            </thead> 
        </table>    

 