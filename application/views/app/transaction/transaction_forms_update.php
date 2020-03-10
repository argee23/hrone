<br><br>
<h4 class="text-danger"><center><?php echo $form_details->form_name;?></center></h4>
<div class="col-md-12">
  <table class="table table-bordered" id="settings_action_table"  style="margin-top:20px;">
      <thead>
        <tr class="danger">
          <th>Company Name</th>
          <?php if($datas[2]=='TS1')
          {?>
            <th>
              Previous Days Allowed to File 
            </th>
          <?php } elseif($datas[2]=='TS2'){?>
          <th>Late Filing Type</th>
          <?php } else if($datas[2]=='TS3') {?>
           <th>With Attachment</th>
          <?php } else if($datas[2]=='TS4'){?>
           <th>Attachment Required</th>
          <?php } else if($datas[2]=='TS5'){?>
          <th>Leave Options</th>
          <?php } else if($datas[2]=='TS6'){?>
          <th>Cancellation Option</th>
          <?php } else if($datas[2]=='TS7'){?>
          <th>Maximum allowed undertime hrs to be filed</th>
          <?php } else if($datas[2]=='TS8')
          {?>
          <th>Update raw in and out in TK ?</th>
          <?php }
          if($datas[2]=='TS5' || $datas[2]=='TS7' || $datas[2]=='TS8') {} else{ ?><th>Apply to all form</th> <?php }?>
        </tr>
      </thead>
      <tbody>
      <?php
        $i=0;
        foreach($company_list as $comp)
        {
           $data = $this->transaction_employees_model->get_settings_data($comp->company_id,$datas[0],$datas[2],'none');
          if(empty($data)){ $d = ''; }
          else{ $d= $data; }
          ?>

          <tr>
            <td><?php echo $comp->company_name;?></td>
            <td><input type="text" class="company_class" value="<?php echo $comp->company_id;?>" style='display: none;'>
                <?php if($datas[2]=='TS1')
                {?>
                  <input type="number" class="form-control" id="settingdata<?php echo $i;?>" style="width: 100%;" onkeyup="for_disbled_checkbox('<?php echo $i;?>',this.value);" value="<?php echo $data;?>">
                <?php }
                else if($datas[2]=='TS2')
                {?>
                  <select class="form-control" id="settingdata<?php echo $i;?>" onchange="for_disbled_checkbox('<?php echo $i;?>',this.value);"> 
                      <option value="no_settings" <?php if($d=='no_settings'){ echo "selected"; }?> >no_settings</option>
                      <option value="prior_to_paydate_of_payroll_period" <?php if($d=='prior_to_paydate_of_payroll_period'){ echo "selected"; }?> >prior to paydate of payroll period</option>
                      <option value="prior_to_the_affected_date" <?php if($d=='prior_to_the_affected_date'){ echo "selected"; }?>>prior to the affected date</option>
                  </select>
                <?php } else if($datas[2]=='TS3'){?>
                  <select class="form-control" id="settingdata<?php echo $i;?>" onchange="for_disbled_checkbox('<?php echo $i;?>',this.value);"> 
                      <option value="no_settings" <?php if($data=='no_settings'){ echo "selected"; }?>>no_settings</option>
                      <option value="1" <?php if($d=='1'){ echo "selected"; }?>>yes</option>
                      <option value="0" <?php if($d=='0'){ echo "selected"; }?>>no</option>
                  </select>
                <?php } else if($datas[2]=='TS4'){?>
                   <select class="form-control" id="settingdata<?php echo $i;?>" onchange="for_disbled_checkbox('<?php echo $i;?>',this.value);"> 
                      <option value="no_settings" <?php if($data=='no_settings'){ echo "selected"; }?>>no_settings</option>
                      <option value="1" <?php if($d=='1'){ echo "selected"; }?>>required</option>
                      <option value="0" <?php if($d=='0'){ echo "selected"; }?>>not_required</option>
                  </select>
                <?php } else if($datas[2]=='TS5')
                {?>
                  <select class="form-control" id="settingdata<?php echo $i;?>" onchange="for_disbled_checkbox('<?php echo $i;?>',this.value);"> 
                      <option value="no_settings" <?php if($d=='no_settings'){ echo "selected"; }?>>no_settings</option>
                      <option value="always" <?php if($d=='always'){ echo "selected"; }?>>always with pay when there is available leave balances</option>
                      <option value="with_pay_option" <?php if($data=='with_pay_option'){ echo "selected"; }?>>allow without pay option</option>
                  </select>
                <?php } else if($datas[2]=='TS7'){?>
                   <input type="number" class="form-control" id="settingdata<?php echo $i;?>" style="width: 100%;" onkeyup="for_disbled_checkbox('<?php echo $i;?>',this.value);" value="<?php echo $data;?>">
                <?php } else if($datas[2]=='TS8'){?>
                     <select class="form-control" id="settingdata<?php echo $i;?>" onchange="for_disbled_checkbox('<?php echo $i;?>',this.value);"> 
                      <option value="no_settings" <?php if($d=='no_settings'){ echo "selected"; }?>>no_settings</option>
                      <option value="yes" <?php if($d=='yes'){ echo "selected"; }?>>yes</option>
                      <option value="no" <?php if($d=='no'){ echo "selected"; }?>>no</option>
                  </select>
                <?php } else {?>
                  <select class="form-control" id="settingdata<?php echo $i;?>" onchange="for_disbled_checkbox('<?php echo $i;?>',this.value);"> 
                      <option value="no_settings" <?php if($d=='no_settings'){ echo "selected"; }?>>no_settings</option>
                      <option value="3" <?php if($d=='0'){ echo "selected"; }?>>Disable Cancellation</option>
                      <option value="1" <?php if($d=='1'){ echo "selected"; }?>>Cancellation within the day of pending status</option>
                      <option value="2" <?php if($d=='2'){ echo "selected"; }?>>Allow cancellation while pending status</option>
                  </select>
                <?php }?>
            </td>
            <?php if($datas[2]=='TS5' || $datas[2]=='TS7' || $datas[2]=='TS8') {?> <input type="hidden" id="<?php echo $i;?>" class="company_apply_all"> <?php } else{ ?><td><center><i><input type="checkbox" disabled id="<?php echo $i;?>" class="company_apply_all"></i></center></td> <?php } ?>
          </tr>
      <?php $i++;  } echo "<input type='text' style='display:none;' value='".$i."' id='counts_data'>";?>
      </tbody>
   </table>
    <input type="hidden" id="company_data">  
    <input type="hidden" id="settings_value"> 
    <input type="hidden" id="settings_checked">          
  </div>
<div class="col-md-12">
      <button class="btn btn-success pull-right" onclick="save_setting_action();">SAVE CHANGES</button>
   </div> 
