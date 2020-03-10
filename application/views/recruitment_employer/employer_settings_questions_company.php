<?php


if($questions=='qualifying'){ ?>
  
  
     <!-- adding of data -->
                               <div class="col-md-12">
                                  <div class="col-md-12">
                                      <div class="col-md-4">
                                        <label class="pull-right">Question</label>
                                      </div>
                                      <div class="col-md-6">
                                          <input type="text" id="qquestion" class="form-control" placeholder="Question">
                                          <input type="hidden" id="qquestion_">
                                      </div>
                                  </div>

                                  <div class="col-md-12" style="margin-top: 5px;">
                                      <div class="col-md-4">
                                        <label class="pull-right">Correct Answer?</label>
                                      </div>
                                      <div class="col-md-6">
                                        <input type="radio" value="1" name="qquestion" onclick="allow_upload('1','qquestion_ans','qquestion')" checked> Yes
                                        <input type="radio" value="0"  name="qquestion" value="0" onclick="allow_upload('0','qquestion_ans','qquestion')">  No
                                        <input type="hidden" id="qquestion_ans" value='1'>
                                      </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="col-md-10"> <button class="btn btn-success pull-right" onclick="qualifying_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','save','save');">SAVE</button></div>
                                  </div>

                                  <div class="col-md-12" style="margin-top: 10px;">
                                      
                                  </div><br><br><br><br><br><br><br><br>
                                  <div class="box box-default" class='col-md-12'></div>
                          

                          </div>
                        <!--viewing of data-->
                        <div class="col-md-12" style="padding-top: 30px;">
                          <table id="<?php echo $type;?>" class="table table-bordered table-striped">
                                    <thead>
                                      <tr class="danger">
                                        <th>No.</th>
                                        <th>Question</th>
                                        <th>Correct Answer</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; foreach($details as $row){?>
                                        <tr>
                                        <td><?php echo $i;?></td>

                                        <td><?php if($row->InActive==1) { echo "InActive"; } else{ echo "Active"; }?></td>
                                        <td>
                                          
                                              <div id="o_qquestions<?php echo $row->id;?>"><?php echo $row->question;?></div>

                                              <div id="u_qquestions<?php echo $row->id;?>" style='display: none;'>
                                                <input type="text" class="form-control" id="uqquestions<?php echo $row->id;?>" value="<?php echo $row->question;?>" style='width:100%;'>
                                                <input type="hidden" id="uqquestions_<?php echo $row->id;?>">
                                              </div>
                                        </td>
                                        <td>

                                               <div id="o_qans<?php echo $row->id;?>">  <?php if($row->correct_ans==0){ echo "No"; }  else{ echo "Yes"; }?> </div>

                                               <div id="u_qans<?php echo $row->id;?>" style='display: none;'> 
                                                   <input type="radio" value="1" name="uuqans<?php echo $row->id;?>" onclick="allow_upload('1','uqqanswer','<?php echo $row->id;?>')" <?php if($row->correct_ans==1){ echo "checked"; } ?>> Yes
                                                   <input type="radio" value="0"  name="uuqans<?php echo $row->id;?>" value="0" onclick="allow_upload('0','uqqanswer','<?php echo $row->id;?>')" <?php if($row->correct_ans==0){ echo "checked"; } ?>>  No
                                                   <input type="hidden" id="uqqanswer<?php echo $row->id;?>" value='<?php echo $row->correct_ans;?>'>
                                               </div>

                                        </td>
                                        <td>
                                           <div id="o_qualifying<?php echo $row->id;?>">
                                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Edit Question' onclick="qualifying_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','update','<?php echo $row->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Question' onclick="qualifying_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','delete','<?php echo $row->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                               
                                                <?php 
                                                  if($row->InActive==1){?> 
                                                         <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable Question' onclick="qualifying_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','enable','<?php echo $row->id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                                                  <?php } else { ?>
                                                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Question'  onclick="qualifying_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','disable','<?php echo $row->id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                                                  <?php } ?>
                                            </div>

                                            <div id="u_qualifying<?php echo $row->id;?>" style='display: none;'>
                                         
                                              <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="qualifying_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','save_update','<?php echo $row->id;?>');"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>

                                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update'  onclick="qualifying_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','cancel','<?php echo $row->id;?>');"><i  class="fa fa-times fa-lg  pull-left"></i></a>
                                          
                                            </div>


                                        </td>
                                      </tr>
                                    <?php $i++; } ?>
                                    </tbody>
                          </table>
                       <div class="col-md-12" style='padding-top: 20px;'><i><n class="text-danger">Note:</n>Qualifying Question(s) [Yes/No Questions]</i></div>
                       


<?php  } else if($questions=='hypothetical'){ ?>

    
  
     <!-- adding of data -->
                               <div class="col-md-12" id="q<?php echo $type;?>">
                                  <div class="col-md-12">
                                      <div class="col-md-4">
                                        <label class="pull-right">Question</label>
                                      </div>
                                      <div class="col-md-6">
                                          <input type="text" id="hquestion" class="form-control" placeholder="Question">
                                          <input type="hidden" id="hquestion_">
                                      </div>
                                      <div class="col-md-1"> <button class="btn btn-success pull-right" onclick="hypothetical_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','save','save');">SAVE</button></div>
                                  </div>

                               
                                  <div class="col-md-12" style="margin-top: 10px;">
                                      
                                  </div><br><br><br>
                                  <div class="box box-default" class='col-md-12'></div>
                          

                          </div>
                        <!--viewing of data-->
                        <div class="col-md-12" style="padding-top: 20px;" id="by_company_result<?php echo $type;?>">
                        
                          <table id="<?php echo $type;?>" class="table table-bordered table-striped">
                                    <thead>
                                      <tr class="danger">
                                        <th>No.</th>
                                        <th style="width:50%;">Question</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; foreach($details as $row){?>
                                        <tr>
                                        <td><?php echo $i;?></td>

                                       
                                        <td>
                                          
                                              <div id="o_hquestions<?php echo $row->id;?>"><?php echo $row->question;?></div>

                                              <div id="u_hquestions<?php echo $row->id;?>" style='display: none;'>
                                                <input type="text" class="form-control" id="uhquestions<?php echo $row->id;?>" value="<?php echo $row->question;?>" style='width:100%;'>
                                                <input type="hidden" id="uhquestions_<?php echo $row->id;?>">
                                              </div>
                                        </td>
                                         <td><?php if($row->InActive==1) { echo "InActive"; } else{ echo "Active"; }?></td>
                                        <td>
                                           <div id="o_hypothetical<?php echo $row->id;?>">
                                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Edit Question'onclick="hypothetical_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','update','<?php echo $row->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Question' onclick="hypothetical_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','delete','<?php echo $row->id?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                               
                                                <?php 
                                                  if($row->InActive==1){?> 
                                                         <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable Question' onclick="hypothetical_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','enable','<?php echo $row->id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                                                  <?php } else { ?>
                                                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Question'  onclick="hypothetical_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','disable','<?php echo $row->id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                                                  <?php } ?>
                                            </div>

                                            <div id="u_hypothetical<?php echo $row->id;?>" style='display: none;'>
                                         
                                              <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="hypothetical_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','save_update','<?php echo $row->id;?>');"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>

                                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update'  onclick="hypothetical_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','cancel','<?php echo $row->id;?>');"><i  class="fa fa-times fa-lg  pull-left"></i></a>
                                          
                                            </div>


                                        </td>
                                      </tr>
                                    <?php $i++; } ?>
                                    </tbody>
                          </table>
                       <div class="col-md-12" style='padding-top: 20px;'><i><n class="text-danger">Note:</n>Hypothetical Question(s) [questions pertaining a general idea of a certain situation]</i></div>
                       


<?php } else if($questions=='multiple_choice'){?>

  

     <!-- adding of data -->
                               <div class="col-md-12" id="q<?php echo $type;?>">
                                  <div class="col-md-12">
                                      <div class="col-md-4">
                                        <label class="pull-right">Question</label>
                                      </div>
                                      <div class="col-md-6">
                                          <input type="text" id="hquestion" class="form-control" placeholder="Question">
                                          <input type="hidden" id="hquestion_">
                                      </div>
                                      <div class="col-md-1"> <button class="btn btn-success pull-right" onclick="multiplechoice_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','save','save');">SAVE</button></div>
                                  </div>

                               
                                  <div class="col-md-12" style="margin-top: 10px;">
                                      
                                  </div><br><br>
                                  <div class="box box-default" class='col-md-12'></div>
                          

                          </div>
                        <!--viewing of data-->
                        <div class="col-md-12" style="padding-top: 30px;">
                          <table id="<?php echo $type;?>" class="table table-bordered table-striped">
                                    <thead>
                                      <tr class="danger">
                                        <th>No.</th>
                                        <th style="width:30%;">Question</th>
                                        <th style="width:30%;">choices</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; foreach($details as $row){?>
                                        <tr>
                                        <td><?php echo $i;?></td>

                                       
                                        <td>
                                          
                                              <div id="o_hquestions<?php echo $row->id;?>"><?php echo $row->question;?></div>

                                              <div id="u_hquestions<?php echo $row->id;?>" style='display: none;'>
                                                <input type="text" class="form-control" id="uhquestions<?php echo $row->id;?>" value="<?php echo $row->question;?>" style='width:100%;'>
                                                <input type="hidden" id="uhquestions_<?php echo $row->id;?>">
                                              </div>
                                        </td>
                                        <td>
                                          <?php $get_fields = $this->recruitment_employer_management_model->get_multiple_choices($row->id); ?>

                                           <?php $i=1; if(empty($get_fields)){ echo "No data found"; } foreach($get_fields as $r){?> 
                                               <?php echo $i.") <n class='text-danger'> ".$r->mc_choice;?> </n><br>
                                           <?php $i++; } ?>
                                        </td>
                                        <td><?php if($row->InActive==1) { echo "InActive"; } else{ echo "Active"; }?></td>
                                        <td>
                                           <div id="o_hypothetical<?php echo $row->id;?>">
                                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Edit Question'onclick="multiplechoice_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','update','<?php echo $row->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Question' onclick="multiplechoice_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','delete','<?php echo $row->id?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                               
                                                <?php 
                                                  if($row->InActive==1){?> 
                                                         <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable Question' onclick="multiplechoice_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','enable','<?php echo $row->id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                                                  <?php } else { ?>
                                                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Question'  onclick="multiplechoice_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','disable','<?php echo $row->id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                                                  <?php } ?>

                                                   <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Manage Choices' onclick="multiplechoice_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','manage_choices','<?php echo $row->id?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                                               
                                            </div>

                                            <div id="u_hypothetical<?php echo $row->id;?>" style='display: none;'>
                                         
                                              <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="multiplechoice_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','save_update','<?php echo $row->id;?>');"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>

                                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update'  onclick="multiplechoice_questions('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','cancel','<?php echo $row->id;?>');"><i  class="fa fa-times fa-lg  pull-left"></i></a>
                                          
                                            </div>


                                        </td>
                                      </tr>
                                    <?php $i++; } ?>
                                    </tbody>
                          </table>
                       <div class="col-md-12" style='padding-top: 20px;'><i><n class="text-danger">Note:</n>Multiple Choices[questions pertaining to choose from the enumerated items]</i></div>
                       


<?php } elseif($questions=='hypothetical'){ ?>

  mila

<?php } ?>