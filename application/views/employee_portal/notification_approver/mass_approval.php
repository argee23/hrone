
<br><br>
<div class="col-md-12 content-body" style="padding-top:10px;background-color: #D7EFF7;">
<div class="col-sm-12">
<h2 class="page-header ng-scope">Mass Approval: <?php echo $form_name->form_name . " (" . $form_name->identification . ")"; ?> </h2>
<form class="form-horizontal" method="post" action="<?php echo base_url()?>employee_portal/notification_approver/mass_respond_notification" >
<input type="hidden" name="table_name" id="table_name" value="<?php echo $form_name->t_table_name;?>">
<input type="hidden" name="identification" value="<?php echo $form_name->identification;?>">
<div class="panel panel-default">
  <div class="panel-body">
    <a data-toggle="collapse" href="#collapse2"><h4 class="box-title"><i class='fa fa-user'></i> <span>Click here for One Time Selection</span></h4></a>
      <div class="col-md-12"  id="collapse2" class="collapse">
        <div class='col-md-3'></div>
        <div class='col-md-1'>
          <n class='text-info' style='font-weight: bold;'>Response:</n>
        </div>
        <div class='col-md-1'>
           <input name="choices" value="approved" type="radio" onclick="mass_approved(this.value);">&nbsp;Approve
        </div>
        <div class='col-md-1'>
          <input  name="choices" value="cancelled" type="radio" onclick="mass_approved(this.value);">&nbsp;Cancel
        </div>
        <div class='col-md-1'>
          <input name="choices" value="rejected" type="radio" onclick="mass_approved(this.value);"> &nbsp;Reject
        </div>
         <div class='col-md-1'>
         <n class='text-info' style='font-weight: bold;'> Comment </n>
        </div>
        <div class="col-md-4">  <textarea class="form-control" rows="1"  id="comment" onkeyup="mass_approved(this.value);"></textarea></div>
      </div>
      </div>
  </div>
 

    <?php $ud=1;  foreach($forms as $form) {  

        $assign=$this->issue_notifications_model->get_assign_to_fillup($form->doc_no,$form_name->t_table_name."_assign");
        $doc_details=$this->issue_notifications_model->get_doc_details($form->doc_no,$form_name->t_table_name);
        $doc_no = $form->doc_no;
    ?>

    <div class="box panel-success">
    <div class="box-header">
    <center><span class="text-info"><strong><?php echo $form->doc_no;?></strong></span></center>
    </div>
    <div class="box-body">
      <div class="col-md-8"> <!-- Form Content -->
        <span class="dl-horizontal col-sm-4">
          <input type="hidden" name="<?php echo $form->doc_no;?>_doc_no" value="<?php echo $form->doc_no;?>">
          <input type="hidden" name="<?php echo $form->doc_no;?>_filer_id" value="<?php echo $form->info->filer->employee_id;?>">
          <dt>Employee Name</dt>
          <dd><?php echo strtoupper($form->info->filer->last_name) . ", " . $form->info->filer->first_name . " " . $form->info->filer->middle_name;?></dd>
          <dt>Employee ID</dt>
          <dd><?php echo strtoupper($form->info->filer->employee_id);?></dd>
           <dt>Date Filed</dt>
          <dd><?php echo date("F d, Y", strtotime($form->info->form->date_created)); ?></dd>
          <dt>Status</dt>
          <dd><strong><?php echo strtoupper($form->info->form->status); ?></strong></dd>
          <br>


          <dt>Code of Discipline</dt>
          <dd>
             <?php 
                    $code_ = $this->issue_notifications_model->get_data_cc('title','company_code_of_discipline','cod_id',$doc_details->code_of_discipline);
                    echo strip_tags($code_);

                ?>
          </dd>
          <dt>Disobedience Section</dt>
          <dd>
              <?php 
                  $disob_ = $this->issue_notifications_model->get_data_cc('disob_title','cod_disobedience','cod_disob_id',$doc_details->disobedience_section);
                  echo strip_tags($disob_);

                ?>
          </dd>
           <dt>Disobedience No.</dt>
          <dd><?php 
                    $disob_no = $this->issue_notifications_model->get_data_cc('num_days','cod_disob_punish','pun_id',$doc_details->disobedience_no);
                    $disob_title = $this->issue_notifications_model->get_data_cc('disob','cod_disob_punish','pun_id',$doc_details->disobedience_no);
                    echo strip_tags($disob_title);

                ?></dd>
          <dt>Punishment</dt>
          <dd><strong><?php echo strtoupper($form->info->form->status); ?></strong></dd>
            
        </span>
        <span class="dl-horizontal col-sm-8">
              <?php 
                $i=1; foreach($field_list as $fl)
                {
                  $title = $fl->TextFieldName;
                 echo $data = $doc_details->$title;
                  $assign_employee_id = $assign->$title;
                  if(empty($assign_employee_id)){
                      $dis  ='disabled';
                      $req='';
                      $name='';
                  }
                  else
                  {
                    $name=$this->issue_notifications_model->get_name($assign_employee_id);
                    if($assign_employee_id == 'approver')
                    {
                      $dis = '';
                      $req = 'required';
                      $border = "style='border:1px solid red;'";

                    } else { 

                      $dis='disabled';
                       $req='';
                        $border = '';
                     
                    }
                  }
                ?>
                <span class="dl-horizontal col-sm-12">
                  <dt><?php echo $fl->udf_label?></dt>
                  <dd>
                    <?php  if($assign_employee_id!='admin'){?>
                       <?php 
                        
                       if($req=='required')
                       {
                             if($fl->udf_type=='Textarea')
                             {?>
                                  <textarea class="form-control"  id="field<?php echo $i;?>" name="field<?php echo $fl->TextFieldName.$doc_no;?>" <?php echo $dis; echo $req;?> <?php echo $border;?> ><?php if(empty($data)){} else{ echo $data; }?></textarea>
                                  <center><n class="text-danger">(to be fill out by <?php if($assign_employee_id=='admin'){ echo "admin"; } elseif($assign_employee_id=='approver'){ echo "approver"; } else{  echo $name->first_name." ".$name->last_name; }?>)</n></center>

                             <?php }
                             elseif($fl->udf_type=='Selectbox')
                             {?>
                                   <select class="form-control" <?php echo $border;?> id="field<?php echo $i;?>" name="field<?php echo $fl->TextFieldName.$doc_no;?>" <?php echo $dis; echo $req;?>>
                                        <?php 
                                          $datas = $this->notification_approver_model->get_selectbox_value($fl->tran_udf_col_id);
                                            if(empty($datas)){ echo "<option value=''>No data found.</option>";}
                                            else{
                                              foreach ($datas as $row) {?>
                                                  <option <?php if(empty($data)){} else{ if($data==$row->optionLabel){ echo "selected"; }}?> ><?php echo $row->optionLabel;?></option>
                                               <?php   }
                                               } ?>
                                   </select>
                                    <center><n class="text-danger">(to be fill out by <?php if($assign_employee_id=='admin'){ echo "admin"; } elseif($assign_employee_id=='approver'){ echo "approver"; } else{  echo $name->first_name." ".$name->last_name; }?>)</n></center>
                             <?php }
                             else if($fl->udf_type=='Textfield')
                             {?>
                                    <input type="text" <?php echo $border;?> class="form-control" id="field<?php echo $i;?>" value="<?php if(empty($data)){} else{ echo $data; }?>" name="field<?php echo $fl->TextFieldName.$doc_no;?>" <?php echo $dis; echo $req;?>> 
                                     <center><n class="text-danger">(to be fill out by <?php if($assign_employee_id=='admin'){ echo "admin"; } elseif($assign_employee_id=='approver'){ echo "approver"; } else{  echo $name->first_name." ".$name->last_name; }?>)</n></center>
                             <?php }
                             elseif($fl->udf_type=='Datepicker')
                             {?>
                                    <input type="date" <?php echo $border;?> class="form-control" value="<?php if(empty($data)){} else{ echo $data; }?>" id="field<?php echo $i;?>" name="field<?php echo $fl->TextFieldName.$doc_no;?>" <?php echo $dis; echo $req;?>>
                                     <center><n class="text-danger">(to be fill out by <?php if($assign_employee_id=='admin'){ echo "admin"; } elseif($assign_employee_id=='approver'){ echo "approver"; } else{  echo $name->first_name." ".$name->last_name; }?>)</n></center>
                             <?php }

                             } 
                          else
                          {?>
                              <div class="underline"><p><input type="hidden" id="field<?php echo $i;?>" name="field<?php echo $fl->TextFieldName.$doc_no;?>"><?php echo $doc_details->$title;?></p></div>
                               <center><n class="text-danger">(to be fill out by  <?php if($assign_employee_id=='admin'){ echo "admin"; } elseif($assign_employee_id=='approver'){ echo "approver"; } else{  echo $name->first_name." ".$name->last_name; }?>)</n></center>
                          <?php }
                        }

                       else{?>
                       <div class="underline"><p><input type="hidden" id="field<?php echo $i;?>" name="field<?php echo $fl->TextFieldName.$doc_no;?>"><?php echo $data;?></p></div>
                       <div><center><n class="text-danger"><?php if(empty($assign_employee_id)){?>(fill up by admin)<?php } else{?>(fill up by  <?php if($assign_employee_id=='admin'){ echo "admin"; } elseif($assign_employee_id=='approver'){ echo "approver"; } else{  echo $name->first_name." ".$name->last_name; }?>)<?php } ?></n></center></div>
                       <?php  } ?> 
                       <br><br>
                  </dd>
                </span>       
                  <style type="text/css">
                  .underline{
                    border-bottom: 1px solid currentColor;
                    width: 100%;
                    display: block;
                }
                </style>
            <?php $i++; }    ?>
        </span>
      </div> <!-- End form  content -->

      <div class="col-md-1">
      <strong>Response:</strong>
      <div class="radio">
          <label for="radio4">
          <input name="<?php echo $form->doc_no;?>_status" value="approved" id='approved<?php echo $ud?>'  type="radio" onclick="set_status_mass_approval('one',this.value,'<?php echo $doc_no;?>')">
              Approve
          </label>
      </div>
      <div class="radio">
        <label for="radio4">
          <input name="<?php echo $form->doc_no;?>_status" value="cancelled" id='cancelled<?php echo $ud?>' type="radio" onclick="set_status_mass_approval('one',this.value,'<?php echo $doc_no;?>')">
              Cancel
        </label>
      </div>
      <div class="radio">
        <label for="radio4">
          <input name="<?php echo $form->doc_no;?>_status" value="rejected" id='rejected<?php echo $ud?>' type="radio" onclick="set_status_mass_approval('one',this.value,'<?php echo $doc_no;?>')">
              Reject
        </label>
      </div>
       <input name="<?php echo $form->doc_no;?>_final_status" value="" id='<?php echo $form->doc_no;?>_final_status' type="hidden">
       <input  value="<?php echo $form->doc_no;?>" id='i<?php echo $ud;?>' type="hidden">
      </div>

      <div class="col-md-3">
        <label for="comment">Comment:</label>
        <textarea class="form-control" rows="1" name="<?php echo $form->doc_no;?>_comment" id="comment<?php echo $ud?>"></textarea>
      </div>
    </div>  <!-- end form -->
    </div>
    <?php   $ud=$ud+1; } echo "<input type='hidden' id='count_app' value='".$ud."'>
    ";?>
  </div>
  <div class="panel-footer">
    <center><button class="btn btn-success btn-lg" type="submit">Submit Approvals</button></center>
  </div>
</div>
</form>
</div>
</div>
<div class="col-md-1"></div>
<script>
  
  function mass_approved(val)
  {
   var count = document.getElementById('count_app').value;
    if(val=='approved')
    {
      for(i=1;i < count;i++)
      {
         var a = document.getElementById('i'+i).value;
         document.getElementById(a + '_final_status').value=val;

         document.getElementById(val+i).checked=true;
         document.getElementById('rejected'+i).checked=false;
         document.getElementById('cancelled'+i).checked=false;
      }
     
    }
    else if(val=='rejected')
    {
        for(i=1;i < count;i++)
        {
          var a = document.getElementById('i'+i).value;
          document.getElementById(a + '_final_status').value=val;

           document.getElementById(val+i).checked=true;
           document.getElementById('approved'+i).checked=false;
           document.getElementById('cancelled'+i).checked=false;
        }
       
    }
    else if(val=='cancelled')
    {
        for(i=1;i < count;i++)
        {
          var a = document.getElementById('i'+i).value;
          document.getElementById(a + '_final_status').value=val;

          document.getElementById(val+i).checked=true;
          document.getElementById('approved'+i).checked=false;
          document.getElementById('rejected'+i).checked=false;
        }
    }
    else{
       for(i=1;i < count;i++)
        {
           document.getElementById('comment'+i).value=val;
          
        }
    }


  }
  function set_status_mass_approval(option,value,i) 
  {
      document.getElementById(i + '_final_status').value=value;
  }
</script>
