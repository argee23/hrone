
  <div class="col-md-12">
    <div class="panel panel-default">
     <div class="col-md-12 panel-heading">
          <div class="col-md-3"><img style="width: 150px;height:100px;" src="<?php echo base_url() . "public/employee_files/" ?>employee_picture/<?php echo $emp_info->picture; ?>"></div>
           <div class="col-md-6"><br><br>
           <n class='text-success'><?php  echo $emp_info->employee_id?></n><br>
           <n class='text-success'><?php  echo $emp_info->fullname?></n><br>
          <n class='text-success'><?php  echo $emp_info->company_name?></n><br>
         </div>
     </div>
        <div class="box-body" style="height:auto;">
        <div class="col-md-12" style="height:30px;margin-top: 20px;"><label>Employee Message:</label><n class='text-danger'>Kindly approved my request!</n></div>
           <table id="action_req" class="table table-bordered table-striped">
                <thead>
                  <tr  class='success'>
                    <th style="width:20%;">Topic</th>
                    <th style="width:20%;">Action</th>
                    <th style="width:20%;">Action on checked and unchecked </th>
                    <th style="width:10%;">Save</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $n = 0; foreach($pending as $s) { 
                    $actions = $this->employee_emp_prof_update_request_model->actions_list($s->request_id,$s->request_topic_id); $i =0; if(empty($actions)) {} else{ ?>
                <tr>
                  <td><?php echo $s->topic_title?> </td>
                  <td>
                  <?php  foreach($actions as $ss) { ?>
                      <input type="checkbox" value="<?php echo $ss->request_action_id?>" class="<?php echo $s->table_name?>" <?php if($s->topic_id==1 || $s->topic_id==17){?> checked disabled <?php } ?>>
                      <?php echo "<a type='button' class='btn btn-xs btn-default' data-toggle='modal' data-target='#modal' href='".base_url('app/employee_emp_prof_update_request/edit_modal')."/".$ss->request_action_id."'>";?><?php echo $ss->action?></a> &nbsp;
                  <?php $i = $i + 1; } ?>
                    
                  </td>
                  
                  <td> <?php $n = $n+1;?>
                   <input type="checkbox" checked disabled>
                    <select id='<?php echo $n?>checked_val'>
                      <option value="Pending">Review</option>
                      <option value="Approved">Approved</option>
                      <option value="Reject">Reject</option>
                    </select>

                    <input type="checkbox" <?php if($s->topic_id==1 || $s->topic_id==17){?> style='display: none'; <?php }?> >
                    <select  id='<?php echo $n?>unchecked_val' <?php if($s->topic_id==1 || $s->topic_id==17){?> style='display: none'; <?php }?>>
                     <option value="Pending">Review</option>
                      <option value="Approved">Approved</option>
                      <option value="Reject">Reject</option>
                    </select>

                  </td>
                  <td>
                    <a class='fa fa-check-circle-o' aria-hidden='true' data-toggle='tooltip' title='Click to save the changes!' onclick="update_request('<?php echo $emp_info->employee_id?>','<?php echo $s->topic_id?>','<?php echo $s->request_id?>','<?php echo $i?>','<?php echo $n?>','<?php echo $s->table_name?>');" id='send_id<?php echo $s->topic_id?>'></a>
                       <div id="send_load<?php echo $s->topic_id?>" style="display:none;margin-top: 5px;"><center><i class="text-primary fa fa-spinner fa-spin" style="font-size:30px"></i> saving . . .</center></div>
                  </td>
                </tr>
                <?php  }  }?>
                </tbody>
            </table>
            
    </div>   

  </div>
</div>

 <div id="modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
       <div class="modal-content modal-md">
       </div>
    </div>
</div>