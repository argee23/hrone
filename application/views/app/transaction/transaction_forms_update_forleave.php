<br><br>
<h4 class="text-danger"><center><?php echo $form_details->form_name;?></center></h4>
<div class="col-md-12">
  <table class="table table-bordered" id="settings_action_table"  style="margin-top:20px;">
      <thead>
        <tr class="danger">
          <th>Leave Type</th>
          <?php if($datas[2]=='TS1')
          {?>
            <th>
              Previous Days Allowed to File
            </th>
          <?php } elseif($datas[2]=='TS2'){?>
          <th>Late Filing Type</th>
          <?php } 
          elseif($datas[2] == 'TS3')
          {
            echo "<th>With Attachment</th>";
          }
          elseif($datas[2] == 'TS4')
          {
             echo "<th>Required Attachment</th>";
          }
          elseif($datas[2] == 'TS5')
          {
             echo "<th>With Pay Option</th>";
          }
          elseif($datas[2] == 'TS6')
          {
             echo "<th>Employee Leave Cancellation</th>";
          }
          ?>


        </tr>
      </thead>
      <tbody>
     
        <?php $i=0;

            foreach($leavedetails as $l)
            {
               $data = $this->transaction_employees_model->get_settings_data($datas[1],$datas[0],$datas[2],$l->id);
                if(empty($data)){ $d = ''; }
                else{ $d= $data; }
        ?>

          <tr>
            <td><?php echo $l->leave_type;?>
                <input type="hidden" id="settingdataltype<?php echo $i;?>" value="<?php echo $l->id;?>">
            </td>
            <td>
                <?php if($datas[2]=='TS1')
                {?>
                  <input type="number" class="form-control" id="settingdataleave<?php echo $i;?>" style="width: 100%;" onkeyup="for_disbled_checkbox('<?php echo $i;?>',this.value);" value="<?php echo $d;?>">
                <?php }
                else if($datas[2]=='TS2')
                {?>
                  <select class="form-control" id="settingdataleave<?php echo $i;?>" onchange="for_disbled_checkbox('<?php echo $i;?>',this.value);"> 
                      <option value="no_settings" <?php if($d=='no_settings'){ echo "selected"; }?> >no_settings</option>
                      <option value="prior_to_paydate_of_payroll_period" <?php if($d=='prior_to_paydate_of_payroll_period'){ echo "selected"; }?> >prior to paydate of payroll period</option>
                      <option value="prior_to_the_affected_date" <?php if($d=='prior_to_the_affected_date'){ echo "selected"; }?>>prior to the affected date</option>
                  </select>
                <?php }  
                elseif($datas[2] == 'TS3')
                {?>
                  <select class="form-control" id="settingdataleave<?php echo $i;?>"> 
                      <option value="no_settings" <?php if($d=='no_settings'){ echo "selected"; }?> >no_settings</option>
                      <option value="yes" <?php if($d=='yes'){ echo "selected"; }?> >yes</option>
                      <option value="no" <?php if($d=='no'){ echo "selected"; }?>>no</option>
                  </select>
                <?php }
                elseif($datas[2] == 'TS4')
                {?>
                 <select class="form-control" id="settingdataleave<?php echo $i;?>"> 
                      <option value="no_settings" <?php if($d=='no_settings'){ echo "selected"; }?> >no_settings</option>
                      <option value="yes" <?php if($d=='yes'){ echo "selected"; }?> >yes</option>
                      <option value="no" <?php if($d=='no'){ echo "selected"; }?>>no</option>
                  </select>
                <?php } elseif($datas[2] == 'TS5'){?>
                  <select class="form-control" id="settingdataleave<?php echo $i;?>" onchange="for_disbled_checkbox('<?php echo $i;?>',this.value);"> 
                      <option value="no_settings" <?php if($d=='no_settings'){ echo "selected"; }?>>no_settings</option>
                      <option value="always" <?php if($d=='always'){ echo "selected"; }?>>always with pay when there is available leave balances</option>
                      <option value="with_pay_option" <?php if($data=='with_pay_option'){ echo "selected"; }?>>allow without pay option</option>
                  </select>
                <?php }
                elseif($datas[2] == 'TS6')
                {?>
                  <select class="form-control" id="settingdataleave<?php echo $i;?>" onchange="for_disbled_checkbox('<?php echo $i;?>',this.value);"> 
                      <option value="no_settings" <?php if($d=='no_settings'){ echo "selected"; }?>>no_settings</option>
                      <option value="3" <?php if($d=='0'){ echo "selected"; }?>>Disable Cancellation</option>
                      <option value="1" <?php if($d=='1'){ echo "selected"; }?>>Cancellation within the day of pending status</option>
                      <option value="2" <?php if($d=='2'){ echo "selected"; }?>>Allow cancellation while pending status</option>
                  </select>
                <?php }


                ?>
            </td>
          </tr>
      <?php $i++; }  echo "<input type='text' style='display:none;' value='".$i."' id='counts_data_forleave'>";?>
      </tbody>
   </table>
    <input type="hidden" id="settings_valueleave">  
    <input type="hidden" id="settings_valueleavetype">        
  </div>
<div class="col-md-12">
      <button class="btn btn-success pull-right" onclick="save_setting_action_forleave('<?php echo $datas[0];?>','<?php echo $datas[1];?>','<?php echo $datas[2];?>','<?php echo $datas[3];?>');">SAVE CHANGES</button>
   </div> 
