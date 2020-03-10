<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/save_qua_que" >
    <div class="box-body">
      <div class="form-group">
        
        <label class="col-sm-10">Select Company: (Can Select Multiple)</label>
        
        <div class="col-sm-12">
          <select class="form-control select2" name="qua_company[]" id="qua_company" style="width: 100%;" multiple="multiple" required="required">
            <?php 
                foreach($companyList as $company){
                if($_POST['company'] == $company->company_id){
                    $selected = "selected='selected'";
                }
                else{
                    $selected = "";
                }
            ?>
          <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
            <?php }?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="question" class="col-sm-2 control-label">Question</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="question" id="question" placeholder="Question" required>
        </div>
      </div>
      <div class="form-group">
        <label for="question" class="col-sm-2 control-label">Correct Answer</label>
        <div class="col-sm-10">
            <input type="radio" name="correct_ans" value="1" required> Yes &nbsp;
            <input type="radio" name="correct_ans" value="0"> No<br>
        </div>
      </div>
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>
