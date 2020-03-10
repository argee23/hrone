 <div class="modal-content">
      <div class="modal-header" >
        <h4 class="modal-title text-success"><b><?php echo $form_details->form_name;?></center></b></h4>
      
      </div>
      <div class="modal-body">
             <div class="well well-sm bg-olive">
                            <!-- Left-aligned -->
        <div class="media">
           <div class="media-left media-middle">
            <span>
              <img src="<?php echo base_url()?>public/employee_files/employee_picture/<?php echo $file->picture;?>" class="media-object" style="width:150px">
            </span>
           
          </div>
          <div class="media-body">
            <h4 class="media-heading text-black"><strong><?php echo $file->first_name." ".$file->middle_name." ".$file->last_name;?></strong></h4>

            <span class="col-sm-6">
               <?php  if($file->division_id==''){}
                else{?>
                  <dt>Division</dt>
                  <dd>
                    <?php 
                    $subsec=$this->notification_approver_model->get_emp_data_emp('division','division_id','division_name',$file->division_id);
                    if(!empty($subsec)){ echo $subsec; }
                    ?>
                  </dd>
                  
                <?php } ?>
              <dt>Department</dt>
              <dd>
                  <?php 
                  $dept=$this->transaction_employees_model->get_emp_dept($file->department);
                  foreach($dept as $dpt){
                    echo $dpt->dept_name;
                  }
                  ?>
              </dd>
              <dt>Section</dt>
              <dd>
                   <?php 
                    $sec=$this->transaction_employees_model->get_emp_sect($file->section);
                    foreach($sec as $sect){
                      echo $sect->section_name;
                    }
                    ?>
              </dd>
              <?php  if($file->subsection==''){}
                else{?>
                  <dt>Subsection</dt>
                  <dd>
                    <?php 
                    $subsec=$this->notification_approver_model->get_emp_data_emp('subsection','subsection_id','subsection_name',$file->subsection);
                    if(!empty($subsec)){ echo $subsec; }
                    ?>
                  </dd>
                  
                <?php } ?>
              </span>
            <span class="col-sm-6">
              <dt>Classification</dt>
              <dd>
                   <?php 
                    $clas=$this->transaction_employees_model->get_emp_clas($file->classification);
                    foreach($clas as $class){
                      echo $class->classification;
                    }
                    ?>
              </dd>
              <dt>Position</dt>
              <dd>  
                  <?php 
                      $pos=$file->position;
                      $pos=$this->transaction_employees_model->get_emp_pos($pos);
                      foreach($pos as $position){
                        echo $position->position_name;
                  }?>
              </dd>
              <dt>Location</dt>
              <dd>
                  <?php 
                    $loc=$this->notification_approver_model->get_emp_data_emp('location','location_id','location_name',$file->location);
                    if(!empty($loc)){ echo $loc; }
                    ?>
              </dd>
            </span>

          </div>
        </div>
        </div>

        <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a><?php echo $doc_details->doc_no;?></a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-6">
            <dt>Transaction Type</dt>
            <dd><?php echo $form_details->form_name;?></dd>
            <dt>Status</dt>
            <dd><?php echo $doc_details->status;?></dd>
           
          </span>
          <span class="dl-horizontal col-sm-6">
            <dt>Filed By:</dt>
            <dd>admin</dd>
            <dt>Date Filed</dt>
            <dd><?php echo date("F d, Y", strtotime($doc_details->date_created)); ?></dd>
          </span>
        </div>
        </div>

        <?php if(!empty($doc_details->code_of_discipline))
        {
        ?>
         <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a>Code of Discipline Details</a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-6">
            <dt>Code of Discipline</dt>
            <dd>
                <?php 
                    $code_ = $this->issue_notifications_model->get_data_cc('title','company_code_of_discipline','cod_id',$doc_details->code_of_discipline);
                    echo strip_tags($code_);

                ?>
            </dd>
            <dt>Disobedience No</dt>
            <dd>
                <?php 
                  $disob_ = $this->issue_notifications_model->get_data_cc('disob_title','cod_disobedience','cod_disob_id',$doc_details->disobedience_section);
                  echo strip_tags($disob_);

                ?>

            </dd>
           
          </span>
          <span class="dl-horizontal col-sm-6">
            <dt>Disobedience Section</dt>
            <dd>
                 <?php 
                    $disob_no = $this->issue_notifications_model->get_data_cc('num_days','cod_disob_punish','pun_id',$doc_details->disobedience_no);
                    $disob_title = $this->issue_notifications_model->get_data_cc('disob','cod_disob_punish','pun_id',$doc_details->disobedience_no);
                    echo strip_tags($disob_title);

                ?>

            </dd>
            <dt>Punishment</dt>
            <dd>
                <?php 
                    $punish = $this->issue_notifications_model->get_data_cc('punish','cod_disob_punish','pun_id',$doc_details->disobedience_no);
                    echo strip_tags($punish);
                ?>
            </dd>
           
          </span>
        </div>
        </div>
        <?php } ?>

         <form class="form-horizontal" method="post" action="<?php echo base_url()?>employee_portal/employee_notifications/answer_notification" >
         <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a><?php echo $form_details->form_name;?> Details</a></strong>
        </div>
        <div class="panel-body">
         
                <?php 
                $i=1; foreach($field_list as $fl)
                {
                  $title = $fl->TextFieldName;
                  $data = $doc_details->$title;
                  $assign_employee_id = $assign->$title;
                  if(empty($assign_employee_id)){
                      $dis  ='disabled';
                      $req='';
                      $name='';
                  }
                  else
                  {
                    $name=$this->issue_notifications_model->get_name($assign_employee_id);
                    if($assign_employee_id != 'approver' AND $assign_employee_id!='admin')
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
                <span class="dl-horizontal col-sm-9">
                  <dt><?php echo $fl->udf_label?></dt>
                  <dd>
                       <?php  if($assign_employee_id!='approver' AND $assign_employee_id!='admin'){?>
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
               <?php $i++;} ?>
               <style type="text/css">
                  .underline{
                    border-bottom: 1px solid currentColor;
                    width: 100%;
                    display: block;
                }
                </style>
          </span>
        </div>
        </div>
         <input type="hidden" name="filer_id" value="<?php echo $employee_id;?>">
        <input type="hidden" name="doc_no" value="<?php echo $doc_no;?>">
        <input type="hidden" name="table" value="<?php echo $form_details->t_table_name;?>">
        <input type="hidden" name="identification" value="<?php echo $form_details->identification;?>">

      <div class="modal-footer">
        <?php 
          $eff=$this->employee_notifications_model->get_employee_fields_tofill($form_details->id,$doc_details->doc_no,$form_details->t_table_name);

              if(!empty($doc_details->time_acknowledge)){}  else{
                ?>

            <button type="submit" class="btn btn-success" id="submit"><?php if($eff==1){?>Submit Response<?php } else{?>Click to acknowledge<?php }?></button>
        <?php 
          }
        ?>
        <button type="button" class="btn btn-default" onclick="location.reload();">Close</button>
      </div>
    </div>
    </form>

  <script>

     $('#modal').on('hidden.bs.modal', function () {
    $(this).removeData('bs.modal');
  });

  </script>