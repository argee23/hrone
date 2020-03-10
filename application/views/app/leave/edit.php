<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/leave_type/modify_leave_type/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
Company : <?php echo $leave_type->company_name;
if($leave_type->gender=="1"){
  $m_c="checked";
  $f_c="";
  $a_c="";
}else if($leave_type->gender=="2"){
  $m_c="";
  $f_c="checked";
  $a_c="";
}else{
  $m_c="";
  $f_c="";
  $a_c="checked";
}

?>
   

      <input type="hidden" class="form-control" name="company_id" id="company_id" value="<?php echo $leave_type->company_id?>">     
      <input type="hidden" class="form-control" name="leave_id" id="leave_id" placeholder="leave id" value="<?php echo $leave_type->id?>">       
      <div class="form-group" style="margin-top: 10px;">
        <label for="leave_type" class="col-sm-6 control-label">Gender ( for the purpose of paternity & maternity leave )</label>
        <div class="col-sm-6">
          <input type="checkbox"  name="gender_male" id="gender" placeholder="gender" value="1" <?php echo $m_c.$a_c;?>> Male 
          <input type="checkbox"  name="gender_female" id="gender" placeholder="gender" value="2" <?php echo $f_c.$a_c;?>> Female
        </div>
      </div>    

      <div class="form-group">
         <label for="leave_type" class="col-sm-2 control-label">Leave Type</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="leave_type" id="leave_type" placeholder="Leave Type" value="<?php echo $leave_type->leave_type?>" required >
        </div>
      </div>
      <div class="form-group">
        <label for="leave_code" class="col-sm-2 control-label">Leave Code</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="leave_code" id="leave_code" placeholder="Leave Code" value="<?php 
  //list($cid,$code) = explode("_",$leave_type->leave_code);
  echo $leave_type->leave_code;
          ?>" required >
        </div>
      </div>     
      <div class="form-group">
        <label for="leave_code" class="col-sm-2 control-label">Color Code</label>
        <div class="col-sm-10">
          <input type="color" class="form-control" name="color_code" id="leave_color_code" value="<?php echo $leave_type->color_code?>" required>
        </div>
      </div>

      <div class="form-group">
        <label for="taxable_leave_beyond" class="col-sm-2 control-label">Taxable Leave Beyond (leave convertion)</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="taxable_leave_beyond" id="taxable_leave_beyond" placeholder="Taxable Leave Beyond (leave convertion)" value="<?php echo $leave_type->taxable_leave_beyond?>" required>
        </div>
      </div>
<?php 
if($leave_type->is_vl==1){
  $checkVL="checked";
  $checkSL="";
}elseif($leave_type->is_sl==1){
  $checkVL="";
  $checkSL="checked";
}else{
  $checkVL="";
  $checkSL="";
}
?>


      <div class="form-group">
        <label for="leave_type" class="col-sm-6 control-label">Classify Leave Type (for reports)</label>
        <div class="col-sm-6">
          <input type="checkbox"  name="leave_type_classifiy" id="leave_type_classifiy" placeholder="gender" value="is_vl" <?php echo $checkVL;?> > Is VL? 
          <input type="checkbox"  name="leave_type_classifiy" id="leave_type_classifiy" placeholder="gender" value="is_sl" <?php echo $checkSL;?> > Is SL ?
        </div>
      </div>   





          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i>Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>