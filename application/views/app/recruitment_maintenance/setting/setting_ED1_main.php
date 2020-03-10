 <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment_hris/ED1_email_settings/<?php echo $company_id."/".$code;?>">
<div class="col-md-12">	
      	
      <u><h4 class="text-danger"><center>Company Recruitment Email Settings</center></h4></u>	
      
      <div class="col-md-12" style="margin-top: 20px">

      <div class="col-md-6">
        <label>SMTP HOST</label>
        <input type="text"  style="margin-top: 5px;" class="form-control" name="smtp_host" id="smtp_host"  placeholder="SMTP HOST" value="<?php if(!empty($details->smtp_host)){ echo $details->smtp_host; }?>"><br>
      </div>

      <div class="col-md-6">
        <label>SMTP PORT</label>
        <input type="text"  style="margin-top: 5px;" class="form-control" name="smtp_port" id="smtp_port" value="<?php if(!empty($details->smtp_port)){ echo $details->smtp_port; }?>" placeholder="SMTP PORT"><br>
      </div>

      <div class="col-md-6">
        <label>USERNAME</label>
        <input type="text"  style="margin-top: 5px;" class="form-control" name="username" id="username" value="<?php if(!empty($details->username)){ echo $details->username; }?>" placeholder="USERNAME"><br>
      </div>

      <div class="col-md-6">
        <label>PASSWORD</label>
        <input type="text"  style="margin-top: 5px;" class="form-control" name="password" id="password" value="<?php if(!empty($details->password)){ echo $details->password; }?>" placeholder="PASSWORD"><br>
      </div>

      <div class="col-md-6">
        <label>SEND MAIL FROM</label>
        <input type="text"  style="margin-top: 5px;" class="form-control" name="send_mail_from" id="send_mail_from" value="<?php if(!empty($details->send_mail_from)){ echo $details->send_mail_from; }?>" placeholder="SEND EMAIL FROM"><br>
      </div>

      <div class="col-md-6">
        <label>SECURITY TYPE</label>
        <select type="text"  style="margin-top: 5px;" class="form-control" name="security_type" id="security_type" value="">
          <option <?php if(!empty($details->smtp_host)){ if($details->security_type=='tls'){ echo "selected";} }?>>tls</option>
         <option <?php if(!empty($details->smtp_host)){ if($details->security_type=='ssl'){ echo "selected";} }?>>ssl</option>
        </select><br>
      </div>

      <div class="col-md-12">  <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;"> SAVE</button> </div>
        
      </div>
      
</div>

</form>