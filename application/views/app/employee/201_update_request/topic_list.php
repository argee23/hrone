<?php if(empty($companySetting)){?>
<br>
<div class="box box-danger" class='col-md-12'></div>
<h4 class="text-danger"><center>Select atleast one topic to continue.</center></h4><br>
<div class="col-md-12"><input type="checkbox" name="topics" class="checkbox_stat" id="check_uncheck" onclick="checkbox_stat();">Check | Uncheck All</div>
<?php $i=0; foreach($topicList as $topic) { ?>
    <div class="col-md-4">
      <input type="checkbox" name="topics" class="topics" value="<?php echo $topic->topic_id?>"><?php echo $topic->topic_title?>
    </div>
<?php $i = $i + 1; } echo "<input type='hidden' id='topic_count' value='".$i."'>";?>

<div class="col-md-12">
  <button class="btn btn-danger pull-right" style="margin-left: 5px;">CANCEL</button>
  <button class="btn btn-success pull-right" onclick="save_setting();">SAVE</button>
</div>

<?php } else {?>
<br>
<div class="box box-danger" class='col-md-12'></div>
<h4 class="text-danger"><center><?php echo $company_title?> 201 Update Setting</center></h4><br>
<?php $i=0; foreach($topicList as $topic) { ?>
    <div class="col-md-4">
      <input type="checkbox" name="topics" class="topics" value="<?php echo $topic->topic_id?>" 
      disabled <?php foreach ($companySetting as $cc){ $da =  explode("-",$cc->topics); foreach ($da as $d) { if($d == $topic->topic_id){ echo "checked"; } } }?> ><?php echo $topic->topic_title?>
    </div>

<?php $i = $i + 1; } echo "<input type='hidden' id='topic_count' value='".$i."'>";?>
<div class="col-md-12">
  <button class="btn btn-danger pull-right" style="margin-left: 5px;" <?php foreach ($companySetting as $cc){?> onclick='deleteSetting("<?php echo $cc->update_setting_id;?>","<?php echo $cc->company_id;?>")' <?php } ?>  >DELETE</button>
  <button class="btn btn-success pull-right" onclick='editSetting("<?php echo $cc->update_setting_id;?>","<?php echo $cc->company_id;?>")'>UPDATE</button>
</div>
<?php } ?>