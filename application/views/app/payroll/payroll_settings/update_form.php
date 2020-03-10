<div class="box box-success">
  <div class="panel panel-info">
    <div class="col-md-12"><br>
      <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Payroll Settings | <?php echo $title?></h4></ol>
        <div style="height:295px;">
          <div class="col-md-12">
            <div class="panel panel-success">
              <div class="panel-heading"><strong><center>UPDATE <?php echo $title?></strong></center>
               </div>
               <div class="panel-body" id="main_result">
                  <?php foreach ($form_type as $roww) {?>
                     <?php if($roww->single_field=='0'){echo "<div class='col-md-12'>"; } else{  echo "<div class='col-md-10'>";}?>
                        <input type="hidden" id="policy_id" value="<?php echo $roww->payroll_main_id?>">
                        <input type="hidden" id="policy_company_id" value="<?php echo $policy_company_id?>">
                      <?php  foreach ($policy_added_data as $rows) {
                             if($roww->single_field=='1'){ 
                              if($roww->input_type=='text'){?>
                                  <input type="text" class="form-control" name="data" id="data" value="<?php echo $rows->single_field?>" <?php if($roww->input_format=='number'){?> onkeypress="return isNumberKey(this, event);" <?php } else{}?>>
                              <?php } elseif($roww->input_type=='dropdown'){?>
                                  <select  class="form-control" name="data" id="data">
                                    <?php  
                                        $var=explode('-',$roww->input_format); 
                                        foreach ($var as $row) {?>
                                      <option <?php if($row==$rows->single_field){ echo "selected"; } else{ } ?> ><?php echo $row?> </option>
                                    <?php } ?>
                                 </select>
                              <?php } else{ echo "<h3><n class='text-danger'>Error.Please check the payroll setting setup</n></h3>";}?>
                          <?php } elseif($roww->employment_classification =='1'){ ?>
                                <table id="table_home" class="table table-hover table-striped">
                                <thead>
                                  <tr>
                                        <th>Classification</th>
                                       <?php foreach ($employment as $row1) {?>
                                        <th><?php echo $row1->employment_name?></th>
                                        <?php } ?>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $item_count=1; foreach($classification as $row2) {   $class_id=$row2->classification_id; ?>
                                    <tr>
                                      <td><input type="hidden" id="class<?php echo $item_count?>" value="<?php echo $class_id?>"><?php echo $row2->classification?></td>
                                      <?php 
                                        foreach($employment as $row){ 
                                                $employment_id=$row->employment_id; 
                                                    $employment_id=$row->employment_id; 
                                                    foreach ($policy_added_data as $pol) {
                                                     $payroll_settings_id = $pol->payroll_settings_id;
                                                    }
                                                  $get_setting = $this->payroll_settings_model->get_settings_id($payroll_settings_id,$class_id,$employment_id);
                                                   if(empty($get_setting))
                                                   {
                                                     $val_setting='';
                                                   }
                                                    else{ $val_setting=$get_setting; }
                                      ?>
                                      <input type="hidden" id="employment<?php echo $item_count?>" value="<?php echo $row->employment_id?>">
                                      <td>
                                       <?php if($roww->input_type=='text'){?> 
                                           <input type="text" class="form-control" name="data" id= "<?php echo $employment_id.$item_count?>"  value="<?php echo $val_setting?>"  <?php if($val_setting==''){echo "placeholder='no setting'";} else{}?>>
                                      <?php } else{?>
                                          <select class="form-control" id= "<?php echo $employment_id.$item_count?>">
                                            <option value="0">no setting</option>
                                              <?php  
                                                $var=explode('-',$roww->input_format); 
                                                foreach ($var as $rowww) {?>
                                                 <option <?php if($val_setting == $rowww){echo "selected";} else{ } ?>><?php echo $rowww?></option>
                                               <?php }?>
                                          </select>
                                      <?php }?>
                                      </td>
                                     <?php } ?>
                                    </tr>
                                     <?php $item_count++; }  ?>
                                </tbody>
                              </table>
                          <?php } else{ }?>

                
                    </div>
                    <?php if($roww->employment_classification=='1'){?>
                        <button class="btn btn-success pull-right" onclick="save_emp_class('<?php echo $rows->payroll_settings_id?>','update','<?php echo $payroll_main_id?>')">SAVE CHANGES</button>
                   <?php } elseif($roww->payroll_period=='1'){?>
                        <button class="btn btn-success pull-right" onclick="save_update_payroll_period()">SAVE CHANGES</button> 
                   <?php } elseif($roww->single_field=='1'){?>
                        <button class="btn btn-success pull-right" onclick="save_update('<?php echo $rows->payroll_settings_id?>','<?php echo $rows->payroll_main_id?>')">SAVE CHANGES</button> 
                   <?php } else{ echo "<h3><n class='text-danger'>Error.Please check the payroll setting setup</n></h3>"; }}} ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>             
</div>
