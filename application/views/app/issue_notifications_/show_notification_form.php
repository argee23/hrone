
<br><br>
<h4 class="text-danger" style="font-weight: bold;"><center><u><?php echo $form_details->form_name;?></u></center></h4>

<div class="col-md-12">

<div class="col-md-12" style="padding-top: 40px;">
<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/issue_notifications/save_issue_notification" >
          
          <input type="hidden" name="employee_id" value="<?php echo $employee_details->employee_id;?>">
          <input type="hidden" name="notif_id" value="<?php echo $notif_id;?>">
          <input type="hidden" name="company_id" value="<?php echo $company_id;?>">
          <input type="hidden" name="table" value="<?php echo $form_details->t_table_name;?>">
          <input type="hidden" name="identification" value="<?php echo $form_details->identification;?>">
           <div class="col-md-12">

            
            <div class="col-md-12">
              <div class="col-md-4">
                  <label>Employee Name :</label>
              </div>
              <div class="col-md-6">
                <n> <?php echo $employee_details->fullname;?></n>
              </div>
            </div>

            <div class="col-md-12" style="margin-top: 5px;">
              <div class="col-md-4">
                <label>Company Code of Discipline Article No. :</label>
              </div>
              <div class="col-md-6">
                <select  class="form-control" name="code" id="code" onchange="get_disciplinary_data('disobedience',this.value,'<?php echo $company_id;?>');">
                    <?php
                      if(empty($code_of_discipline)){ echo "<option value=''>No Code of Discipline found.</option>";}
                      else
                        {
                          echo "<option value='' disabled selected>Select</option>";
                            foreach($code_of_discipline as $code){

                              echo "<option value='".$code->cod_id."'>".strip_tags($code->title)."</option>";

                            }  
                        }
                    ?>
                </select>
              </div>
              <div class="col-md-2">
                 <a class="text-danger" style="cursor: pointer;">*optional</a>
              </div>
            </div>

            <div class="col-md-12" style="margin-top: 5px;">
              <div class="col-md-4">
                  <label>Disobedience Section :</label>
              </div>
              <div class="col-md-6">
                  <select  class="form-control" id="disobedience" name="disobedience"  onchange="get_disciplinary_data('disobedience_no',this.value,'<?php echo $company_id;?>');">
                   </select>
              </div>
              <div class="col-md-2">
                  <a class="text-danger" style="cursor: pointer;">*optional</a>
              </div>
            </div>

            <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4">
                  <label>Disobedience No. :</label>
                 </div>
                <div class="col-md-6">
                  <select  class="form-control" id="disobedience_no" name="disobedience_no">
                  </select>
                </div>
                <div class="col-md-2">
                   <a class="text-danger" style="cursor: pointer;">*optional</a>
                </div>
            </div>

          </div>
            
            <div class="col-md-12" style="padding-top: 40px;">

                   <?php $i=0; foreach($field_list as $fl){?>

                <input type="hidden" name="field_name<?php echo $i;?>" value="<?php echo $fl->TextFieldName;?>">
               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4">
                    <label><?php echo $fl->udf_label;?> :</label>
                </div>
                <div class="col-md-6">
                 <?php 
                 if($fl->udf_type=='Textarea')
                 {?>
                      <textarea class="form-control" disabled id="field<?php echo $i;?>" name="field<?php echo $i;?>"></textarea>
                 <?php }
                 elseif($fl->udf_type=='Selectbox')
                 {?>
                       <select class="form-control" disabled id="field<?php echo $i;?>" name="field<?php echo $i;?>"></select>
                 <?php }
                 else if($fl->udf_type=='Textfield')
                 {?>
                        <input type="text" class="form-control" disabled id="field<?php echo $i;?>" name="field<?php echo $i;?>">
                 <?php }
                 elseif($fl->udf_type=='Datepicker')
                 {?>
                        <input type="date" class="form-control" disabled id="field<?php echo $i;?>" name="field<?php echo $i;?>">
                 <?php } ?> 
                </div>
                <div class="col-md-2">
                  <a style="cursor: pointer;" data-toggle='collapse' data-target='#fl<?php echo $fl->tran_udf_col_id;?>' style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to assign who fill up field'>Assign. .  </a>
                </div>
              </div>

               <div class="col-md-12 collapse" style="margin-top: 5px;" id="fl<?php echo $fl->tran_udf_col_id;?>">
                <div class="col-md-4"></div>
                <div class="col-md-6">
                <div class="col-md-12">
                      <input type="radio" name="assign<?php echo $fl->tran_udf_col_id;?>" onclick="assign('<?php echo $i;?>','admin','admin');">Admin
                  </div>
                  <div class="col-md-12">
                      <input type="radio" name="assign<?php echo $fl->tran_udf_col_id;?>" onclick="assign('<?php echo $i;?>','employee','<?php echo $employee_details->employee_id;?>');" checked><?php echo $employee_details->fullname;?> (Employee)
                  </div>

                  <?php
 
                    if($wApprover==1){
                      if(count($approvers)==0){ echo "<n>no approve/s found.</n>";} else{
                      ?>
                      <div class="col-md-12">
                       <input type="radio"  name="assign<?php echo $fl->tran_udf_col_id;?>"  onclick="assign('<?php echo $i;?>','approver','approver');"> Approver/s
                      </div>
                    <?php 
                     }
                   foreach($approvers as $app){
                      if ($app->approval_level=="1"){
                      $ext="st";
                      }else if($app->approval_level=="2"){
                        $ext="nd";
                      }else if($app->approval_level=="3"){
                        $ext="rd";
                      }else{
                        $ext="th";
                      }
                    ?>
                    <div class="col-md-12">
                      <n class="text-danger" style='margin-left:20px;'><?php echo $app->fullname."(".$app->approval_level."".$ext." approver)";?></n>
                    </div>
                    
                  <?php } echo ' <input type="hidden" name="assigns'.$i.'" id="assign'.$i.'" value="'.$employee_details->employee_id.'">'; }

                   else{
                       echo ' <input type="hidden" name="assigns'.$i.'" id="assign'.$i.'" value="'.$employee_details->employee_id.'">';
                   } ?>

                 
                </div>
                <div class="col-md-2"> </div>
              </div>

              <?php $i++; } echo "<input type='hidden' id='count_field' name='count_field' value='".$i."'>"; ?>

            </div>

             <br>

            <?php  
            if($wApprover==1)
            {
              $approvers_count = count($approvers);
              if($approvers_count > 0){ } else{?>
                 <div class="col-md-12" style="margin-top: 30px;">
                  <h4 class="text-danger"><i>Note: Please assign approvers to continue.</i></h4>
                 </div>
            <?php }  } else{ $approvers_count=1; }?>

            <div class="col-md-12" style="padding-top: 10px;">
                <div class="box box-danger" class='col-md-12'></div>
            </div>
            <div class="col-md-12">
              <button type="submit" class="btn btn-success pull-right" <?php if($approvers_count==0){ echo "disabled"; } else{}?> >SUBMIT</button>
            </div>
</form>