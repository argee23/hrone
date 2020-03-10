
                    <table id="multiplechoices" class="table table-bordered table-striped">
                      <thead>
                        <tr class="danger">
                          <th>No.</th>
                          <th>Choices</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $i=1;
                            foreach($choices as $row){?>
                              <tr>
                                <td><?php echo $i;?></td>
                                <td>
                                    <div id="o_choices<?php echo $row->mc_id;?>"><?php echo $row->mc_choice;?></div>
                                    <div id="u_choices<?php echo $row->mc_id;?>" style='display: none;'>
                                      <input type="text" class="form-control" id="uuchoices<?php echo $row->mc_id;?>" value="<?php echo $row->mc_choice;?>" style='width:100%;'>
                                      <input type="hidden" id="uuchoices_<?php echo $row->mc_id;?>">
                                    </div>
                                </td>
                                <td><?php if($row->mc_InActive==1) { echo "InActive"; } else{ echo "Active"; }?></td>
                                <td>
                                  <div id="o_qchoices<?php echo $row->mc_id;?>">
                                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Edit Question'  onclick="multiplechoices_manage('<?php echo $company_id;?>','update','<?php echo $id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Question' onclick="multiplechoices_manage('<?php echo $company_id;?>','delete','<?php echo $id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                               
                                      <?php 
                                        if($row->mc_InActive==1){?> 
                                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable Question'  onclick="multiplechoices_manage('<?php echo $company_id;?>','enable','<?php echo $id;?>','<?php echo $row->mc_id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                                        <?php } else { ?>
                                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Question'  onclick="multiplechoices_manage('<?php echo $company_id;?>','disable','<?php echo $id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                                                  <?php } ?>
                                            </div>

                                            <div id="u_qchoices<?php echo $row->mc_id;?>" style='display: none;'>
                                              <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="multiplechoices_manage('<?php echo $company_id;?>','save_update','<?php echo $id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>

                                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update'  onclick="multiplechoices_manage('<?php echo $company_id;?>','cancel','<?php echo $id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-times fa-lg  pull-left"></i></a>
                                          
                                            </div>
                                        </td>
                                      </tr>
                                    <?php $i++;  }?>
                                    </tbody>
                          </table>
               