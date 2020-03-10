<div class="well">
<!-- form start -->
  <h4 class="text-success">Add a Frequently Asked Question</h4>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_faq/" >
    <div class="box-body">

    <div class="form-group">
        <label class="col-sm-2 control-label">Select Company (Can select multiple)</label>
        <div class="col-sm-10">
        <select class="form-control select2" name="company[]" multiple="multiple" required>
          <?php 
            foreach($companyList as $company){
            if($_POST['company'] == $company->company_id){
                $selected = "selected='selected'";
            }else{
                $selected = "";
            }
            ?>
            <option value="<?php echo $company->company_id;?>" <?php echo $selected;?>><?php echo $company->company_name;?></option>
            <?php }?>
        </select>
        </div>
      </div>
      <div class="form-group">
        <label for="section_name" class="col-sm-2 control-label">Question</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="question" id="question" placeholder="Question" required>
        </div>
      </div>
      <div class="form-group">
        <label for="section_name" class="col-sm-2 control-label">Answer</label>
        <div class="col-sm-10">
          <!--<input type="textfield" class="form-control" name="answer" id="answer" placeholder="Answer" required>-->
          <textarea rows="10" class="form-control" name="answer" id="answer" placeholder="Answer" required></textarea>
        </div>
      </div>
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>