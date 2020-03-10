<div class="row">
<div class="col-md-7">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>Add</strong><small> (User Define Fields) </small></div>

  <form method="post" action="<?php echo base_url()?>app/employee_user_define_fields/save_udf_col/<?php echo $this->uri->segment("4");?>" >


    <div class="box-body">
    <div class="row">
    <div class="col-md-12">

      <div class="form-group">
        <label>Field name</label>
        <input type="text" class="form-control" name="label" id="label" placeholder="Label" value="" required>
        <p style="color:#ff0000;">Field name is required</p>
      </div>


      <div class="form-group">
        <label>Filed type</label>
          <select class="form-control" name="type" id="type" data-toggle="collapse" onclick="add_forTextfield(this.value)" required>
              <option selected="selected" value="" disabled="">~ Select Type ~</option>
              <option value="Datepicker">Date picker</option>
              <option value="Selectbox">Select box</option>
              <option value="Textarea">Text area</option>
              <option value="Textfield">Text field</option>
          </select>
        <p style="color:#ff0000;">Field type is required</p>
      </div>

      <div id="addforTextfield">
                                
      </div>

      <div class="form-group">
          <input type="hidden" value="no" name="not_null">
          <input type="checkbox" name="not_null" value="yes">
          <label>  Not null</label>
      </div>


      <div class="form-group">
        <label>Company</label>
          <select class="form-control" name="company" id="company" required>
            <option selected="selected" value="" disabled="">~ Select Company ~</option>
            <option value="0">Select All Company</option>
              <?php 
                foreach($companyList as $company){
                  echo "<option value='".$company->company_id."' >".$company->company_name."</option>";
                }
              ?>
          </select>   
          <p style="color:#ff0000;">Company is required</p> 
        </div>

       <div class="form-group">
          <button type="submit" class="form-control btn btn-success"><i class="fa fa-floppy-o"></i> SAVE </button>
       </div>
    
    </div>
    </div>
    </div>
    </div><!-- /.box-body -->
  

  </form>
</div>
</div>


<div class="col-md-6" id="col_3"></div>
</div>  
</div>

