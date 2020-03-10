<div class="row">
<div class="col-md-12">
<div class="well">
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/leave_type/save_add/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
          <div class="form-group">
       
          <label for="company" class="col-sm-2 control-label">Company<br>(You may click multiple)</label>
           <div class="col-md-10">
          <select multiple="multiple" class="form-control select2" name="company[]" id="company" style="width: 100%;height: 200px;" required="required">
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
        <label for="leave_type" class="col-sm-6 control-label">Gender ( for the purpose of paternity & maternity leave )</label>
        <div class="col-sm-6">
          <input type="checkbox"  name="gender_male" id="gender" placeholder="gender" value="1" checked> Male
          <input type="checkbox"  name="gender_female" id="gender" placeholder="gender" value="2" checked> Female
        </div>
      </div>      
      <div class="form-group">
        <label for="leave_type" class="col-sm-2 control-label">Leave Type</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="leave_type" id="leave_type" placeholder="Leave Type" value="" required>
        </div>
      </div>
      <div class="form-group">
        <label for="leave_code" class="col-sm-2 control-label">Leave Code</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="leave_code" id="leave_code" placeholder="Leave Code" value="" required>
        </div>
      </div>
      <div class="form-group">
        <label for="leave_color_code" class="col-sm-2 control-label">Color Code</label>
        <div class="col-sm-10">
          <input type="color" class="form-control" name="leave_color_code" id="leave_color_code" placeholder="Leave Code" value="" required>
        </div>
      </div>

      </div>
      <div class="form-group">
        <label for="taxable_leave_beyond" class="col-sm-2 control-label">Taxable Leave Beyond (leave convertion)</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="taxable_leave_beyond" id="taxable_leave_beyond" placeholder="Taxable Leave Beyond (leave convertion)" required>
        </div>
      </div>
      <div class="form-group">
        <label for="leave_type" class="col-sm-6 control-label">Classify Leave Type (for reports)</label>
        <div class="col-sm-6">
          <input type="checkbox"  name="leave_type_classifiy" id="leave_type_classifiy" placeholder="gender" value="is_vl" > Is VL? 
          <input type="checkbox"  name="leave_type_classifiy" id="leave_type_classifiy" placeholder="gender" value="is_sl" > Is SL ?
        </div>
      </div>   



          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
</div>
</div>

<div class="col-md-6" id="col_4"></div>

</div>  