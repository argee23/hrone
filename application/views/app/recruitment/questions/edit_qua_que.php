<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/modify_qua_que/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
      <div class="form-group">
        <label for="question" class="col-sm-2 control-label">Question</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="question" id="question" placeholder="Question" value="<?php echo $qua_que->question?>" required>
        </div>
      </div>
      <div class="form-group">
        <label for="question" class="col-sm-2 control-label">Correct Answer</label>
        <div class="col-sm-10">
        <?php
if($qua_que->correct_ans=="1"){
 $re_check_yes="checked";
}else{
 $re_check_yes="";
}

if($qua_que->correct_ans=="0"){
 $re_check_no="checked";
}else{
 $re_check_no="";
}
        ?>
            <input type="radio" name="correct_ans" value="1" required <?php echo $re_check_yes;?> > Yes &nbsp;
            <input type="radio" name="correct_ans" value="0" <?php echo $re_check_no;?> > No<br>
        </div>
      </div>
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>