<div class="box box-success">
  <div class="panel panel-info">
    <div class="col-md-12"><br>
      <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Account Management | <?php echo $title?></h4></ol>
            <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:295px;">
          <div class="col-md-12">
            <div class="panel panel-success">
             
               <div class="panel-body" id="main_result">

                    <?php foreach($policy_details as $row){ echo "<input type='hidden' id='account_management_policy_id' value='".$row->account_management_policy_id."'>"; if($row->account_security==1){
                    if(empty($check_data))
                      { 
                    ?>
                        <div class='col-md-12'>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <div class="btn-toolbar">
                                  <?php $var=explode('-',$row->additional_functions); 
                                        foreach ($var as $row2) { if($row2=='download'){?>
                                    <a href="<?php echo base_url(); ?>app/employee_account_management/reset_all_password_default/" type="button" class="btn btn-danger btn-xs pull-right" title="Reset all password to default" onClick="return confirm('Are you sure you want to RESET ALL PASSWORD to its default form?')" ><i class="fa fa-wrench"></i> RESET ALL PASSWORD</a>
                                   <?php } elseif($row2=='reset'){?>
                                    <a href="<?php echo base_url(); ?>app/employee_account_management/download_employee_all_account/" type="button" class="btn btn-primary btn-xs pull-right" title="Download all account list"><i class="fa fa-download"></i> ACCOUNT LIST</a>
                                  <?php } else{} }?>
                                  </div>
                                </div>
                            </div>
                            <br>
                            
                            <div class="col-md-3" style="padding-bottom: 10px;">
                                <label>Default Password :</label>
                            </div>

                            <div class="col-md-9" style="padding-bottom: 10px;">
                              <select class="form-control" id='default_password'>
                                <option selected disabled>Select default password</option>
                                <?php foreach ($selection as $row1) {?>
                                 <option value="<?php echo $row1->id?>" ><?php echo $row1->field_desc?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="col-md-12">
                              <n class='text-danger'><b>Note:</b><?php echo $row->note?> </n> 
                            </div>
                            
                             <div class='col-md-12' style="padding-top: 10px;">
                              <button class='btn btn-success pull-right' onclick="account_security('insert','account_sec','<?php echo $row->account_management_policy_id?>');">Save</button>
                             </div>
                          </div>
                      <div>
                    <?php } else{ ?>

                             <div class='col-md-12'>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <div class="btn-toolbar">
                                  <?php $var=explode('-',$row->additional_functions); 
                                        foreach ($var as $row2) { if($row2=='download'){


if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> RESET ALL PASSWORD TO DEFAULT PASSWORD</i> ";
}else{

                                          ?>
                                    <a href="<?php echo base_url(); ?>app/employee_account_management/reset_all_password_default/" type="button" class="btn btn-danger btn-xs pull-right" title="Reset all password to default" onClick="return confirm('Are you sure you want to RESET ALL PASSWORD to its default form?')" ><i class="fa fa-wrench"></i> RESET ALL PASSWORD</a>
                                   <?php 
}
                                 }

                                    elseif($row2=='reset'){

        if($this->session->userdata('serttech_account')=="1"){
                                    ?>
                                    <a href="<?php echo base_url(); ?>app/employee_account_management/download_employee_all_account/" type="button" class="btn btn-primary btn-xs pull-right" title="Download all account list"><i class="fa fa-download"></i> ACCOUNT LIST</a>
                                  <?php
        }else{}

                                   } else{} }?>
                                  </div>
                                </div>
                            </div>
                            <br>

                            <div class="col-md-3" style="padding-bottom: 10px;">
                                <label>Default Password :</label>
                            </div>

                            <div class="col-md-9" style="padding-bottom: 10px;">
                              <select class="form-control" id='default_password' disabled>
                                <?php foreach ($selection as $row1) {?>
                                 <option value="<?php echo $row1->id?>" <?php if($default_password==$row1->id) { echo "selected"; } ?>><?php echo $row1->field_desc?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="col-md-12">
                              <n class='text-danger'><b>Note:</b><?php echo $row->note?> </n> 
                            </div>

                             <div class='col-md-12' style="padding-top: 10px;">
<?php
if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
?>

                              <button class='btn btn-success pull-right' onclick="update();" id='update_form'>UPDATE</button>
                              <button class='btn btn-success pull-right' onclick="account_security('update','account_sec','<?php echo $row->account_management_policy_id?>');" style="display: none;" id='update_save'>SAVE CHANGES</button>

<?php

}
?>

                             </div>

                        </div>     
                      <?php } } elseif($row->government_fields==1){ //if the govenrment fields==1?>

                            <table class="table table-hover table-striped" id='table_show'>
                                <thead class='text-success'>
                                  <tr>
                                        <th>Fields</th>
                                       <?php $var=explode('-',$row->additional_functions); 
                                          foreach ($var as $additional) { $additional_data = str_replace("_"," ",$additional);?>
                                        <th><?php echo $additional_data?></th>
                                        <?php } ?>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php  foreach ($govt_fields as $govt) {?>
                                    <tr>
                                         <td><?php echo $govt->field_name?></td>
                                          <?php $var=explode('-',$row->additional_functions); 
                                          foreach ($var as $additional) { $additional_data = str_replace("_"," ",$additional);?>
                                          <td>  <?php if($additional=='field_option')
                                                { echo "<select  class='form-control' disabled>";?>
                                                            <option selected disabled>Select</option>
                                                            <option value='1' <?php if($govt->$additional=='1'){ echo "selected";}?>>required</option>
                                                            <option value='0' <?php if($govt->$additional=='0'){ echo "selected";}?> >optional</option>
                                                      <?php echo "</select>";} 
                                                elseif($additional=='field_max_length')
                                                { ?> <input type="text" class="datas form-control" onkeypress="return isNumberKey(this, event);" value='<?php echo $govt->$additional?>' disabled>
                                               <?php } else{?>
                                                      <input type="text"  class="datas form-control" value='<?php echo $govt->$additional?>' disabled>
                                               <?php }?>
                                          </td> 
                                           <?php } ?>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                              </table>
                           
                              <input type='hidden' id='additional_functions' value="<?php echo $row->additional_functions?>">
                             <table class="table table-hover table-striped" id='table_home' style="display: none;">
                                <thead class='text-success'>
                                  <tr>
                                        <th>Fields</th>
                                       <?php $var=explode('-',$row->additional_functions); 
                                          foreach ($var as $additional) { $additional_data = str_replace("_"," ",$additional);?>
                                        <th><?php echo $additional_data?></th>
                                        <?php } ?>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php $item_count=1; foreach ($govt_fields as $govt) {?>
                                    <tr>
                                         <td><input type="hidden" id="field<?php echo $item_count?>" value="<?php echo $govt->field_id?>"><?php echo $govt->field_name?></td>
                                          <?php $ii=1; $var=explode('-',$row->additional_functions); 
                                          foreach ($var as $additional) { $additional_data = str_replace("_"," ",$additional);?>
                                          <td>  <input type='hidden' value='<?php echo $additional?>' id='fn<?php echo $ii.$item_count?>'><?php if($additional=='field_option')
                                                { echo "<select id='".$ii.$item_count."' class='form-control'>";?>
                                                            <option selected disabled>Select</option>
                                                            <option value='1' <?php if($govt->$additional=='1'){ echo "selected";}?>>required</option>
                                                            <option value='0' <?php if($govt->$additional=='0'){ echo "selected";}?> >optional</option>
                                                      <?php echo "</select>";} 
                                                elseif($additional=='field_max_length')
                                                { ?> <input type="text" id="<?php echo $ii.$item_count?>" class="datas form-control" onkeypress="return isNumberKey(this, event);" value='<?php echo $govt->$additional?>'>
                                               <?php } else{?>
                                                      <input type="text" id="<?php echo $ii.$item_count?>" class="datas form-control" value='<?php echo $govt->$additional?>'>
                                               <?php }?>
                                          </td> 
                                           <?php $ii= $ii+1;} echo "<input type='hidden' value='".$ii."' id='number_fields'>";?>
                                    </tr>
                                    <?php $item_count++; }  echo "<input type='hidden' value='".$item_count."' id='item_count'>"; ?>
                                </tbody>
                              </table>

                               <div class="col-md-12">
                              <n class='text-danger'><b>Note:</b><?php echo $row->note?> </n> 
                            </div>

                             <div class='col-md-12' style="padding-top: 10px;">
<?php
if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
?>

                               <button class='btn btn-success pull-right' id='update_form' onclick="update_govt_fields_form();" style='margin-left: 5px;'>UPDATE</button>

                              <button style='display:none;' id='save_update' class='btn btn-success pull-right' onclick="save_govt_fields('insert','govt_fields','<?php echo $row->account_management_policy_id?>');" id='save_update'>UPDATE CHANGES</button>
<?php
}
?>



                             </div>
                    <?php } elseif($row->disable_account==1){ //disable account?>
                     <div id='ss'>
                     </div> 
                    
                        <div class="col-md-3" style="padding-bottom: 10px;">
                                <label>Disable Account By: </label>
                            </div>

                            <div class="col-md-9" style="padding-bottom: 10px;">
                              <select class="form-control" id='disable' onchange="disable_by(this.value);" >
                                  <option disabled selected>Select</option>
                                  <?php 
                                  $var=explode('-',$row->additional_functions); 
                                        foreach ($var as $disable) { ?>
                                          <option><?php echo $disable?></option>
                                  <?php } ?>
                              </select>
                            </div>
                            <div id='option_view_result'>
                            </div>
                            <div class="col-md-12" style="padding-top: 30px;">
<?php
if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

?>
                            <button class='btn btn-success pull-right' id='save_disable' onclick="save_disable('<?php echo $row->account_management_policy_id?>');" style='margin-left: 5px;'>Save</button>
<?php
}
?>


                            </div>
                    <?php } elseif($row->emp_hired_notif=='1'){  ?>
                        <div id='notification_main_div'>
                           <div class="col-md-12">
                            <div class="col-md-3" style="padding-bottom: 10px;">
                                <label>Select Company:</label>
                            </div>

                            <div class="col-md-9" style="padding-bottom: 10px;">
                              <select class="form-control" id='notif_company_id' onchange='notif_action("notif_option_choices",<?php echo $row->account_management_policy_id?>,this.value);'>
                              <option selected disabled>Select Company</option>
                               <?php foreach($companyList as $row_c){?>
                               <option value="<?php echo $row_c->company_id?>"><?php echo $row_c->company_name;?></option>
                                <?php } ?>
                              </select>
                            </div>
                            </div>

                         <!--    option result will view here -->
                            <div class="col-md-12" id="notif_option_choices">

                            </div>
                          <!--    notif_option_choices result will view here -->
                            <div class="col-md-12" id="notif_option_action">

                            </div>
                        </div>


                     <?php } elseif($row->others=='1') { ?>
                        <?php 
                            $policy_id=$row->account_management_policy_id;
                            $policy_main =  $this->employee_account_management_model->get_policy_fields($policy_id);
                            
                        ?>
                      <div id='ss'></div> 
                      <?php if(empty($others_data)){?>
                             <table class="table table-hover table-striped" id='table_others'>
                                <thead class='text-success'>
                                  <tr>
                                      <th style="width: 30%;"></th>
                                      <th style="width: 70%;"></th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php $item_count=1; foreach ($policy_main as $others) { ?>
                                    <tr>
                                        <td><?php echo $others->title." :"?><input type='hidden' id='fieldno<?php echo $item_count?>' value='<?php echo $others->account_management_others_setup_id?>'></td>
                                        <td>
                                           <?php if($others->input_type=='text'){?>
                                              <input type='text' id="data<?php echo $item_count?>" placeholder="" class="form-control" <?php if($others->input_format=='Number'){?>onkeypress="return isNumberKey(this, event);" <?php } else{} ?>>
                                          <?php } elseif($others->input_type=='dropdown'){?>
                                                <select class="form-control" id="data<?php echo $item_count?>"> 
                                                    <option disabled selected value='0'>Select</option>
                                                     <?php $var=explode('-',$others->input_format); 
                                                  foreach ($var as $rowf) { 
                                                        echo "<option>".$rowf."</option>";
                                                    }?>
                                                </select>
                                          <?php } else{?>
                                                <input type="<?php echo $others->input_format?>" id="data<?php echo $item_count?>" class="form-control"> 
                                          <?php }?>
                                        </td>
                                    </tr>
                                    <?php $item_count++; }  echo "<input type='hidden' value='".$item_count."' id='item_count'>"; ?>
                                </tbody>
                              </table>
                            <div class="col-md-12" style="padding-top: 30px;">
                            <button class='btn btn-success pull-right' id='save_disable' onclick="save_others('insert','others','<?php echo $row->account_management_policy_id?>');" style='margin-left: 5px;'>Save</button>
                            <div class="col-md-12" id='loaderr' style="display: none;"> <h4 class="text-info pull-right"><label><div class="loader"></div>S A V I N G . .</label></h4></div>
                            </div>
                      <?php } else{?>

                            <table class="table table-hover table-striped" id='table_others_update'>
                                <thead class='text-success'>
                                  <tr>
                                      <th style="width: 30%;"></th>
                                      <th style="width: 70%;"></th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php $item_count=1; 
                                      foreach ($others_data as $otherdata) { ?>
                                    <tr>
                                        <td><?php echo $otherdata->title." :"?><input type='hidden' id='fieldno<?php echo $item_count?>' value='<?php echo $otherdata->account_management_others_setup_id?>'></td>
                                        <td>
                                           <?php if($otherdata->input_type=='text'){?>
                                              <input type='text' id="data<?php echo $item_count?>" placeholder="" class="form-control" <?php if($otherdata->input_format=='Number'){?>onkeypress="return isNumberKey(this, event);" <?php } else{} ?> value="<?php echo $otherdata->datas?>"  disabled>
                                          <?php } elseif($otherdata->input_type=='dropdown'){?>
                                                <select class="form-control" id="data<?php echo $item_count?>" disabled> 
                                                   
                                                     <?php $var=explode('-',$otherdata->input_format); 
                                                  foreach ($var as $rowf) { ?>
                                                        <option <?php if($otherdata->datas==$rowf){ echo "disabled selected";}?>><?php echo $rowf?></option>
                                                  <?php  }?>
                                                </select>
                                          <?php } else{?>
                                                <input type="<?php echo $otherdata->input_format?>" id="data<?php echo $item_count?>" class="form-control" value="<?php echo $otherdata->datas?>" disabled> 
                                          <?php }?>
                                        </td>
                                    </tr>
                                    <?php $item_count++; }  echo "<input type='hidden' value='".$item_count."' id='item_counts'>"; ?>
                                </tbody>
                              </table>
                          <div class="col-md-12" style="padding-top: 30px;">
<?php

if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
?>

<button class='btn btn-success pull-right' id='other_form' onclick="disabled_other_form()" style='margin-left: 5px;'>Update</button>
<button class='btn btn-success pull-right' id='other_update_form' onclick="save_update_others('update','others','<?php echo $row->account_management_policy_id?>');" style='margin-left: 5px;display: none;'>Save Changes</button>
<?php
}
?>


                             <div class="col-md-12" id='loaderr' style="display: none;"> <h4 class="text-info pull-right"><label><div class="loader"></div>S A V I N G . .</label></h4></div>
                            </div>
                      <?php }?>

                      
                        
                     <?php } 
                     elseif ($row->mob_tel_format==1) {?>
                     <div class="col-md-12">
                      <div class="col-md-2">Company</div>
                      <div class="col-md-10">
                          <select class="form-control" onchange="mob_tel_action(this.value);">
                            <option>Select Company</option>
                            <?php  foreach ($companyList as $company) { ?>
                                <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
                            <?php }?>
                          </select>
                      </div>
                       </div>
                      <div id="mob_tel_action" class="col-md-12">
                        

                      </div>

                     <?php   }  else { echo "Error"; } }?>
               </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>             
</div>

<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 40px;
  height: 40px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
     