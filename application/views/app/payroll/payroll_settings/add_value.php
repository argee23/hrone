<div class="box box-success">
  <div class="panel panel-info">
    <div class="col-md-12"><br>
      <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Payroll Settings | <?php echo $title?></h4></ol>
      <div id="refresh_flashdata" style="padding-bottom: 20px;">
       <?php  if($this->session->flashdata('inserted') AND $val_flash==$policy_id)
                    { 
                      echo '<div id="flashdata_result"><n class="text-danger" style="font-weight:bold;"> <center>New Data is Successfully Added!</center></n></div>';
                    }
              elseif($this->session->flashdata('updated') AND $val_flash==$policy_id )
                    { 
                      echo '<div id="flashdata_result"><n class="text-danger" style="font-weight:bold;"> <center>'.$title.' is Successfully Updated!</center></n></div>';
                    }
              elseif($this->session->flashdata('5_updated') AND $val_flash==$polipolicy_idcy )
                    { 
                      echo '<div id="flashdata_result"><n class="text-danger" style="font-weight:bold;"> <center>'.$title.' Data is Successfully Updated!</center></n></div>';
                    }
              elseif($this->session->flashdata('setting4_inserted') AND $val_flash==$policy_id )
                    { 
                      echo '<div id="flashdata_result"><n class="text-danger" style="font-weight:bold;"> <center>Group Payroll Period is Successfully Inserted!</center></n></div>';
                    }
              elseif($this->session->flashdata('setting4_deleted') AND $val_flash==$policy_id )
                    { 
                      echo '<div id="flashdata_result"><n class="text-danger" style="font-weight:bold;"> <center>ID '.$setting_id.' is Successfully Deleted!</center></n></div>';
                    }
              elseif($this->session->flashdata('setting4_updated') AND $val_flash==$policy_id )
                    { 
                      echo '<div id="flashdata_result"><n class="text-danger" style="font-weight:bold;"> <center>ID '.$setting_id.' is Successfully Updated!</center></n></div>';
                    }
              elseif($this->session->flashdata('setting4_nochanges') AND $val_flash==$policy_id )
                    { 
                      echo '<div id="flashdata_result"><n class="text-danger" style="font-weight:bold;"> <center>No changes made ID '.$setting_id.'!</center></n></div>';
                    }
              elseif($this->session->flashdata('setting4_exist') AND $val_flash==$policy_id )
                    { 
                      echo '<div id="flashdata_result"><n class="text-danger" style="font-weight:bold;"> <center>Already exist!</center></n></div>';
                    }
              else{}
                ?>
        </div>
        <div style="height:295px;">
          <div class="col-md-12">
            <div class="panel panel-success">
              <div class="panel-heading"><strong><center>ADD <?php echo $title?></strong></center>
               </div>
               <div class="panel-body" id="main_result">
                  <?php foreach ($form_type as $roww) {?>
                  <?php if($roww->single_field=='0'){echo "<div class='col-md-12'>"; } else{  echo "<div class='col-md-10'>";}?>
                        <input type="hidden" id="policy_id" value="<?php echo $roww->payroll_main_id?>">
                        <input type="hidden" id="policy_company_id" value="<?php echo $policy_company_id?>">
                      <?php 
                      if(empty($policy_added_data)) { 
                          if($roww->single_field=='1'){ 
                              if($roww->input_type=='text'){?>
                                  <input type="text" class="form-control" name="data" id="data" value="0" <?php if($roww->input_format=='number'){?> onkeypress="return isNumberKey(this, event);" <?php } else{}?>>
                              <?php } elseif($roww->input_type=='dropdown'){?>
                                  <select  class="form-control" name="data" id="data">
                                        <option selected>no setting</option>
                                    <?php  
                                        $var=explode('-',$roww->input_format); 
                                        foreach ($var as $rowww) {
                                         echo "<option>".$rowww."</option>";
                                        }
                                    ?>
                                 </select>
                              <?php } else{ echo "<h3><n class='text-danger'>Error.Please check the input_type payroll setting setup</n></h3>";}?>
                          <?php } elseif($roww->employment_classification =='1'){ if($classification == 'no_data') { echo "<h2><center>No Classification Found!</center></h2>"; } else{?> 
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
                                      ?>
                                      <input type="hidden" id="employment<?php echo $item_count?>" value="<?php echo $row->employment_id?>">
                                      <td>
                                       <?php if($roww->input_type=='text'){?>
                                         <input type="text" class="form-control" id= "<?php echo $employment_id.$item_count?>" value="" placeholder='no setting' <?php if($roww->input_format=='number'){?> onkeypress="return isNumberKey(this, event);" <?php } else{}?>>
                                      <?php } elseif($roww->input_type=='dropdown'){?>
                                          <select class="form-control" id= "<?php echo $employment_id.$item_count?>">
                                            <option value="0">no setting</option>
                                              <?php  
                                                $var=explode('-',$roww->input_format); 
                                                foreach ($var as $rowww) {
                                                 echo "<option>".$rowww."</option>";
                                                }
                                               ?>
                                          </select>
                                      <?php }?>
                                      </td>
                                     <?php } ?>
                                    </tr>
                                     <?php $item_count++; }  ?>
                                </tbody>
                              </table>
                          <?php } }elseif($roww->payroll_period=='1'){ ?>

                                  <div id="setting_action">
                                    <div class="col-md-6">

                                     <div class="col-md-12" style="padding-top: 2px;"> 
                                       <div class="col-md-5"><label>Pay Type</label></div>
                                        <div class="col-md-7">
                                          <select class="form-control" id="select3" onchange="select_3(this.value)">
                                            <option disabled selected value="no_val">Select Pay Type</option>
                                            <?php foreach ($pay_type as $row) {?>
                                              <option value="<?php echo $row->pay_type_id?>"><?php echo $row->pay_type_name ?></option>
                                           <?php  } ?>
                                          </select>
                                        </div>
                                      </div>

                                      <div class="col-md-12" style="padding-top: 2px;" > 
                                        <div class="col-md-5"><label>Employee Group</label></div>
                                          <div class="col-md-7">
                                            <select class="form-control" disabled id="select4" onchange="select_4(this.value)">
                                              <option disabled selected value="no_val">Select Group</option>
                                            </select>
                                        </div>
                                      </div>

                                      <div class="col-md-12" style="padding-top: 2px;" id="edit_4"> 
                                        <div class="col-md-5"><label>Payroll Period</label></div>
                                            <div class="col-md-7">
                                              <select class="form-control" disabled id="select5" onchange="check_all(this.value);">
                                                <option selected value="no_val">Select Payroll Period</option>
                                              </select>
                                        </div>
                                      </div>
                                    </div>

                                  <div class="col-md-6">
                                    <div class="col-md-12">  
                                      <div class="col-md-5"><label>Allow Employee to view payslip</label></div>
                                      <div class="col-md-7">
                                        <select class="form-control" onchange="select_1(this.value);" id="select1" disabled>
                                          <option selected value='no_val'>Select Option</option>
                                          <option>Yes</option>
                                          <option>No</option>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="col-md-12" style="padding-top: 2px;"> 
                                     <div class="col-md-5"><label>Payroll Period Option</label></div>
                                      <div class="col-md-7">
                                        <select class="form-control" id="select2" onchange="select_2(this.value);" disabled>
                                        <option value="no_val" disabled selected>Select</option>
                                          <option value="All" >All Payroll Period</option>
                                          <option>Before</option>
                                          <option>After</option>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="col-md-12" style="padding-top: 10px;"> 
                                      <div class="col-md-12" id="save_button" style='display:none;'>
                                          <button class="btn btn-success pull-right" onclick="save_setting_payroll_period('<?php echo $payroll_main_id;?>');">Save</button></div>
                                      </div>                        
                                  </div>
                                </div>
                         
                                <div class="col-md-12" style="padding-top:40px;" id="paytype_group_list">
                                   <div class="box box-success"></div>
                                   <div class="col-md-12" style="padding-top: 2px;" id="edit_s4"></div>
                                </div>


                   <?php } else{ echo "<h3><n class='text-danger'>Error.Please check the payroll setting setup</n></h3>";} } else {  
                            foreach ($policy_added_data as $rows) {
                             if($roww->single_field=='1'){ 
                              if($roww->input_type=='text'){?>
                                  <input type="text" class="form-control" name="data" id="data" value="<?php echo $rows->single_field?>" readonly>
                              <?php } elseif($roww->input_type=='dropdown'){?>
                                  <select  class="form-control" name="data" id="data" disabled>
                                    <?php  
                                        $var=explode('-',$roww->input_format); 
                                        foreach ($var as $rowss) {?>  
                                      <option <?php if($rowss==$rows->single_field){ echo "selected"; } else{ echo"style='display:none;'";} ?> ><?php echo $rowss?> </option>
                                    <?php } ?>
                                 </select>
                              <?php } else{ echo "<h3><n class='text-danger'>Error.Please check the input_type payroll setting setup</n></h3>";}?>
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
                                           <input type="text" class="form-control" name="data" id= "<?php echo $employment_id.$item_count?>"  value="<?php echo $val_setting?>" readonly <?php if($val_setting==''){echo "placeholder='no setting'";} else{}?>>
                                      <?php } else{?>
                                          <select class="form-control" id= "<?php echo $employment_id.$item_count?>" disabled>
                                            <option value="0">no setting</option>
                                              <?php  
                                                $var=explode('-',$roww->input_format); 
                                                foreach ($var as $rowww) {?>
                                                 <option <?php if($val_setting == $rowww){echo "selected";} else{ echo "style='display:none;'"; } ?>><?php echo $rowww?></option>
                                               <?php }?>
                                          </select>
                                      <?php }?>
                                      </td>
                                     <?php } ?>
                                    </tr>
                                     <?php $item_count++; }  ?>
                                </tbody>
                              </table>
                          <?php }  elseif($roww->payroll_period=='1'){ ?>
                        
                                  <div id="setting_action">
                                    <div class="col-md-6">

                                     <div class="col-md-12" style="padding-top: 2px;"> 
                                       <div class="col-md-5"><label>Pay Type</label></div>
                                        <div class="col-md-7">
                                          <select class="form-control" id="select3" onchange="select_3(this.value)">
                                            <option disabled selected value="no_val">Select Pay Type</option>
                                            <?php foreach ($pay_type as $row) {?>
                                              <option value="<?php echo $row->pay_type_id?>"><?php echo $row->pay_type_name ?></option>
                                           <?php  } ?>
                                          </select>
                                        </div>
                                      </div>

                                      <div class="col-md-12" style="padding-top: 2px;" > 
                                        <div class="col-md-5"><label>Employee Group</label></div>
                                          <div class="col-md-7">
                                            <select class="form-control" disabled id="select4" onchange="select_4(this.value)">
                                              <option disabled selected value="no_val">Select Group</option>
                                            </select>
                                        </div>
                                      </div>

                                      <div class="col-md-12" style="padding-top: 2px;" id="edit_4"> 
                                        <div class="col-md-5"><label>Payroll Period</label></div>
                                            <div class="col-md-7">
                                              <select class="form-control" disabled id="select5" onchange="check_all(this.value);">
                                                <option selected value="no_val">Select Payroll Period</option>
                                              </select>
                                        </div>
                                      </div>
                                    </div>

                                  <div class="col-md-6">
                                    <div class="col-md-12">  
                                      <div class="col-md-5"><label>Allow Employee to view payslip</label></div>
                                      <div class="col-md-7">
                                        <select class="form-control" onchange="select_1(this.value);" id="select1" disabled>
                                          <option selected value='no_val'>Select Option</option>
                                          <option>Yes</option>
                                          <option>No</option>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="col-md-12" style="padding-top: 2px;"> 
                                     <div class="col-md-5"><label>Payroll Period Option</label></div>
                                      <div class="col-md-7">
                                        <select class="form-control" id="select2" onchange="select_2(this.value);" disabled>
                                        <option value="no_val" disabled selected>Select</option>
                                          <option value="All" >All Payroll Period</option>
                                          <option>Before</option>
                                          <option>After</option>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="col-md-12" style="padding-top: 10px;"> 
                                      <div class="col-md-12" id="save_button" style='display:none;'>
                                          <button class="btn btn-success pull-right" onclick="save_setting_payroll_period('<?php echo $payroll_main_id?>');">Save</button></div>
                                      </div>                        
                                  </div>
                                </div>
                         
                                <div class="col-md-12" style="padding-top:40px;" id="paytype_group_list">
                                   <div class="box box-success"></div>
                                   <div class="col-md-12" style="padding-top: 2px;" id="edit_s4"></div>

                                     <table id = "results_datas" class="col-md-12 table table-bordered">
                                        <thead>
                                          <tr>
                                            <th  style="text-align: center;">ID</th>
                                            <th  style="text-align: center;">Pay Type Name</th>
                                            <th  style="text-align: center;">Group Name</th>
                                            <th  style="text-align: center;">Payroll Period(From)</th>
                                            <th  style="text-align: center;">Payroll Period(To)</th>
                                            <th  style="text-align: center;">Allow to View Payroll</th>
                                            <th  style="text-align: center;">Payroll Option</th>
                                            <th  style="text-align: center;">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $setting_payroll = $this->payroll_settings_model->payrollperiod_data($payroll_setting_id);
                                        foreach ($setting_payroll as $row) { $payroll_period = $row->payroll_period_option; if($payroll_period=='not included') { $option='--'; } else{$option = $payroll_period; } ?>
                                           <tr>
                                           <td> <input type="hidden" id="payroll_main_id" value="<?php echo $payroll_main_id?>"><?php echo $row->payroll_setting4_id; ?></td>
                                            <td><?php echo $row->pay_type_name; ?></td>
                                            <td><?php echo $row->group_name; ?></td>
                                            <td><?php echo $row->month_from."-".$row->day_from."-".$row->year_from; ?></td>
                                            <td><?php echo $row->month_to."-".$row->day_to."-".$row->year_to; ?></td>
                                            <td><?php echo $row->allow_view_payroll; ?></td>
                                             <td><?php echo $option; ?></td>
                                            <td>
                                               <a class='fa fa-pencil-square-o' aria-hidden='true' data-toggle='tooltip' title='Click to edit!'  onclick='edit_setting_payroll_period(<?php echo $row->payroll_setting4_id.",".$row->pay_type_id.",".$row->payroll_period_group_id?>)'></a>
                                              <a class='fa fa-trash' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='delete_setting_payroll_period(<?php echo $row->payroll_setting4_id.",".$row->pay_type_id.",".$row->payroll_period_group_id?>)'></a>
                                            </td>
                                          </tr>
                                       <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                   <?php } else{ echo "<h3><n class='text-danger'>Error.Please check the payroll setting setup</n></h3>";} } } ?>
                    </div>  
                   <?php if(empty($policy_added_data)) { if($roww->employment_classification=='1'){?>
                        <button class="btn btn-success pull-right" onclick="save_emp_class('save','add','<?php echo $payroll_main_id?>')">SAVE</button>
                   <?php } elseif($roww->payroll_period=='1'){?> 
                   <?php } elseif($roww->single_field=='1'){?>
                        <button class="btn btn-success pull-right" onclick="save_add(<?php echo $payroll_main_id?>)">SAVE</button> 
                   <?php } else{ echo "<h3><n class='text-danger'>Error.Please check the field payroll setting setup</n></h3>"; }} else{?>
                   <button class="btn btn-success pull-right" onclick="update_form(<?php echo $payroll_main_id?>)" <?php if($roww->payroll_period=='1'){ echo "style='display:none;'";} else{}?>>UPDATE</button>
                   <?php } } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>             
</div>
