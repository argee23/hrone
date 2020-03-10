<div class="well">

<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/sms/save_edit_mess_template" >
<input type="hidden" name="id" value="<?php echo $mtInfo->id;?>">
<input type="hidden" name="company_id" value="<?php echo $company_id;?>">
  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Message Key Topic</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="message_key_topic" id="message_key_topic" placeholder="Key Word/Topic of the Template" required value="<?php echo $mtInfo->message_key_topic?>">
    </div>
  </div>	
  <div class="form-group">
    <label for="group_desc" class="col-sm-3 control-label">Message Template</label>
    <div class="col-sm-9">
<textarea class="form-control" name="message_template" rows="8" placeholder="Write Message Content" required><?php echo $mtInfo->message_template;?></textarea>
    </div>
  </div>
  


  <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
</form>
</div>