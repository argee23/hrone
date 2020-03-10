<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/email_settings/save_company_email_settings" enctype="multipart/form-data" onSubmit="return confirm('Are you sure you want to save?');">
  <input type="hidden" name="company" value="<?php echo $company?>">
  <table class="table table-hover table-striped" id="email_table">
      <thead class='text-success'>
        <tr class="danger">
          <th style="width:5%;"><i class="btn btn fa fa-modx"  aria-hidden='true' data-toggle='tooltip' title='Click to Clear Fields' onclick="clear_fields('all','all');"></i></th>
          <th style="width:10%;">Location</th>
          <th style="width:15%;">SMTP Host</th>
          <th style="width:15%;">SMTP Port</th>
          <th style="width:20%;">Username</th>
          <th style="width:10%;">Password</th>
          <th style="width:10%;">Send Mail From</th>
          <th style="width:10%;">Security Type</th>
          <th style="width:5%;">Status</th>
        </tr>
      </thead>
      <tbody>
      <?php $i =0 ; foreach($location as $loc){
        $location = $this->email_settings_model->per_comp_loc($company,$loc->location_id);
        ?>
        <tr>
        <td><i class="btn btn fa fa-modx"  aria-hidden='true' data-toggle='tooltip' title='Click to Clear Fields' onclick="clear_fields('one',<?php echo $i?>);"></i></td>
          <td>
            <input type="hidden" name="location<?php echo $i?>" value="<?php echo $loc->location_id?>">
            <?php echo $loc->location_name?>
          </td>
          <td><input type="text" class="form-control"  id="smtp_host<?php echo $i?>" name="smtp_host<?php echo $i?>" value="<?php if(empty($location)){}else{ echo $location->smtp_host; }?>"></td>
          <td><input type="text" class="form-control"  id="smtp_port<?php echo $i?>" name="smtp_port<?php echo $i?>" style="width:100%;" value="<?php if(empty($location)){}else{ echo $location->smtp_port; }?>"></td>
          <td><input type="text" class="form-control" id="username<?php echo $i?>" name="username<?php echo $i?>" value="<?php if(empty($location)){}else{ echo $location->username; }?>"></td>
          <td><input type="password" class="form-control" id="password<?php echo $i?>" name="password<?php echo $i?>" value="<?php if(empty($location)){}else{ echo $location->password; }?>"></td>
          <td><input type="email" class="form-control" id="send_mail_from<?php echo $i?>"  name="send_mail_from<?php echo $i?>" value="<?php if(empty($location)){}else{ echo $location->send_mail_from; }?>"></td>
          <td><input type="text" class="form-control" id="security_type<?php echo $i?>" name="security_type<?php echo $i?>" style="width:100%;" value="<?php if(empty($location)){}else{ echo $location->security_type; }?>"></td>
          <td>
            <select class="form-control" name="status<?php echo $i?>" id="status<?php echo $i?>">
              <option value=""></option>
              <option value="1" <?php if(!empty($location) AND $location->status==1){ echo "selected"; }?>>Enable</option>
              <option value="0"<?php if(!empty($location) AND $location->status==0){ echo "selected"; }?>>Disable</option>
            </select>
          </td>
        </tr>  
        <?php $i = $i +1; } echo "<input style='display:none;' type='text' value='".$i."' id='count' name='count'>"; ?>                          
      </tbody>
    </table>
    <div class="col-md-12" style="padding-bottom: 30px;">
      <button type="submit" class="btn btn-success pull-right" style="margin-right:10px;">Save Changes</button>
    </div>
    <n class='text-info'><b><i><n class="text-success">Reminders:</n> <n class="text-danger">All Fields are required.</n> Those location with incomplete details will not be saved..  </i></b></n>
</form>                      