<div id="flashdata_result" style="margin-bottom: 20px;">
      <?php echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>'.$msg.'</center></n></div>'; ?>
    </div>
     <table class="col-md-12 table table-hover" id="inproc">
              <thead>
                <tr class="danger">
                  <th>ID</th>
                  <th>Numbering</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Color Code</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=1; foreach($details as $d){
                  $ddd=$d->interview_id;
                  ?>
                  <tr>
                    <td><?php echo $d->interview_id;?></div>   
                    </td>
                    <td>
                      <div id="ip_viewing<?php echo $i;?>"> 
                        <?php echo $d->numbering;?>
                        <input type="hidden" id="ipid<?php echo $i;?>" value="<?php echo $d->interview_id;?>">
                      </div>
                      <div id="ip_update<?php echo $i;?>" style="display: none;">
                        <select class="form-control ip_value" id="numberingvaluee<?php echo $i;?>"> 
                          <?php $co_o = count($details);  
                             
                              for ($x = 1; $x <= $co_o; $x++) {?>
                              <option <?php if($d->numbering==$x){ echo "selected"; }?>><?php echo $x;?></option>";
                              <?php }?>
                              </select>
                      </div>

                    </td>
                    <td>
                        <div id="title_orig<?php echo $ddd;?>"> <?php echo $d->title;?></div>
                        <div id="title_upd<?php echo $ddd;?>" style="display: none;"><input type="text" class="form-control" id="titleupdate<?php echo $ddd;?>" value="<?php echo $d->title;?>"></div> 
                        <input type='hidden' id='t<?php echo $ddd;?>'>
                    </td>
                    <td>
                        <div id="desc_orig<?php echo $ddd;?>"><?php echo $d->description;?></div>
                        <div id="desc_upd<?php echo $ddd;?>" style="display: none;"><input type="text" class="form-control" id="descupdate<?php echo $ddd;?>" value="<?php echo $d->description;?>"></div> 
                        <input type='hidden' id='d<?php echo $ddd;?>'>  
                    </td>
                    <td>
                        <div id="color_orig<?php echo $ddd;?>"><input type="color" value="<?php echo $d->color_code;?>" disabled></div>
                        <div id="color_upd<?php echo $ddd;?>" style="display: none;"> <input type="color" value="<?php echo $d->color_code;?>" id="colorupdate<?php echo $ddd;?>"></div>
                        <input type='hidden' id='c<?php echo $ddd;?>'>
                    </td>
                    <td>
                      <?php if($d->InActive==1)
                      {?>

                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable interview process' onclick="interview_process_action('<?php echo $company_id;?>','<?php echo $d->interview_id;?>','enable','<?php echo $account;?>');">
                        <i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                           
                      <?php } 
                      else
                      { ?>

                      <div id="update<?php echo $d->interview_id;?>" style="display: none;">
                            <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="interview_process_updatesave('<?php echo $company_id;?>','<?php echo $d->interview_id;?>','<?php echo $account;?>');"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>
                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update' onclick="interview_process_update_form_cancel('<?php echo $d->interview_id;?>');" ><i  class="fa fa-times fa-lg  pull-left"></i></a>
                      </div>
                      <div id="original<?php echo $d->interview_id;?>">
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to update interview process' onclick="interview_process_update_form('<?php echo $d->interview_id;?>');">
                        <i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                        

                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hid<?php echo $d->interview_id;?>den='true' data-toggle='tooltip' title='Click to delete interview process' onclick="interview_process_action('<?php echo $company_id;?>','<?php echo $d->interview_id;?>','delete','<?php echo $account;?>');">
                        <i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                        
                         <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable interview process' onclick="interview_process_action('<?php echo $company_id;?>','<?php echo $d->interview_id;?>','disable','<?php echo $account;?>');">
                        <i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                      </div> 

                      <?php }
                      ?>
                    </td>
                  </tr>
                <?php $i++; } echo "<input type='text' id='ip_count' value='".$i."'' style='display:none;'>";  ?>

              </tbody>
          </table>