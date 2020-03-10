<div class="col-md-12">
                      <!-- adding of data -->
                               <div class="col-md-12" id="q<?php echo $type;?>">
                                  <div class="col-md-12" style="margin-top: 40px;">
                                      <div class="col-md-4 ">
                                        <label class="pull-right">Choices</label>
                                      </div>
                                      <div class="col-md-5">
                                          <input style="width:100%;" type="text" id="choicess" class="form-control" placeholder="Add New Choices">
                                          <input type="hidden" id="choicess_">
                                      </div>
                                      
                                       <?php if($account=='public'){ $comp=$company_id; } else{ $comp= 'by_company'; }?>
                                        <button class="col-md 1 btn btn-danger pull-right" onclick="multiplechoice_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $comp;?>','view','view');">BACK</button>
                                        <button class="col-md-1 btn btn-success pull-right" onclick="multiplechoices_manage('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','save','<?php echo $questions_details->id;?>','save');"  style="margin-right: 5px;">SAVE</button>

                                      
                                       
                                  </div>


                                  <div class="col-md-12" style="margin-top: 10px;">
                                      
                                  </div><br><br><br><br><br><br><br>
                                  <div class="box box-default" class='col-md-12'></div>
                          

                          </div>
                        <!--viewing of data-->
                        <div class="col-md-12" style="padding-top: 20px;">
                        <h5 style="font-weight: bold;padding-bottom: 10px;">Question : <i class="text-danger"><?php echo $questions_details->question;?></i></h5>
                          <table id="<?php echo $type;?>" class="table table-bordered table-striped">
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
                                      $get_fields = $this->recruitment_employer_management_model->get_multiple_choices($id); 
                                      if(empty($get_fields)){} else{ 
                                        $i=1;
                                      foreach($get_fields as $row){?>
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
                                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Edit Question'  onclick="multiplechoices_manage('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','update','<?php echo $questions_details->id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Question' onclick="multiplechoices_manage('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','delete','<?php echo $questions_details->id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                               
                                                <?php 
                                                  if($row->mc_InActive==1){?> 
                                                         <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable Question'  onclick="multiplechoices_manage('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','enable','<?php echo $questions_details->id;?>','<?php echo $row->mc_id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                                                  <?php } else { ?>
                                                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Question'  onclick="multiplechoices_manage('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','disable','<?php echo $questions_details->id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                                                  <?php } ?>
                                            </div>

                                            <div id="u_qchoices<?php echo $row->mc_id;?>" style='display: none;'>
                                              <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="multiplechoices_manage('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','save_update','<?php echo $questions_details->id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>

                                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update'  onclick="multiplechoices_manage('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','cancel','<?php echo $questions_details->id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-times fa-lg  pull-left"></i></a>
                                          
                                            </div>
                                        </td>
                                      </tr>
                                    <?php $i++; } }?>
                                    </tbody>
                          </table>


                       <div class="col-md-12" style='padding-top: 20px;'><i><n class="text-danger">Note:</n>questions pertaining to choose from the enumerated items</i></div>
                       
                    </div>
