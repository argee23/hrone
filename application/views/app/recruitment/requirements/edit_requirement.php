<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/modify_requirement/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
      <div class="form-group">
        <label for="item_name" class="col-sm-2 control-label">Item Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Item Name" value="<?php echo $requirement->item_name?>" required>
        </div>
      </div>

      <div class="form-group">
        <label for="IsUploadable" class="col-sm-2 control-label">Correct Answer</label>
        <div class="col-sm-10">
        <?php
if($requirement->IsUploadable=="1"){
 $re_check_yes="checked";
}else{
 $re_check_yes="";
}

if($requirement->IsUploadable=="0"){
 $re_check_no="checked";
}else{
 $re_check_no="";
}
        ?>
            <input type="radio" name="IsUploadable" value="1" required <?php echo $re_check_yes;?> > Yes &nbsp;
            <input type="radio" name="IsUploadable" value="0" <?php echo $re_check_no;?> > No<br>
        </div>
      </div>      
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>