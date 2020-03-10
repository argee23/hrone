<div class="row">
<div class="col-md-6">
<?php
$t_table_name = $this->uri->segment('5');
$company_id = $this->uri->segment('6');
?>
 <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/transaction_user_define_fields/save_udf_col1_new/<?php echo $this->uri->segment("4");?>" >
<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>Add to</strong><strong>(<?php echo $companyName3->form_name ?>)<input type="hidden" name="t_table_name" id="t_table_name" value="<?php echo $t_table_name; ?>"><input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>"><input type="hidden" name="fname" id="fname" value="<?php echo $companyName3->form_name; ?>"> </strong></div>





 
    <div class="box-body">



     
    
      <div class="form-group">
        <label for="label" class="col-sm-2 control-label">Label</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="label" id="label" placeholder="Label" onchange="return trim(this)" value="" required>
        </div>
      </div>
      <div class="form-group">
        <label for="type" class="col-sm-2 control-label">Type</label>
        <div class="col-sm-10">
          <select class="form-control" name="type" id="type" data-toggle="collapse" onclick="add_forTextfield1(this.value)" required>
              <option selected="selected" value="" disabled="">~ Select Type ~</option>
              <option value="Datepicker">Date picker</option>
              <option value="Selectbox">Select box</option>
              <option value="Textarea">Text area</option>
              <option value="Textfield">Text field</option>
          </select>
        </div>
      </div>

      <div id="addforTextfield">
                                
      </div>

      <div class="form-group">
        <label for="not_null" class="col-sm-2 control-label">Not null</label>
        <div class="col-sm-10">
          <br>
          <input type="hidden" value="no" name="not_null">
          <input type="checkbox" name="not_null" value="yes">
        </div>
      </div>



      
  
          <button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
</div>
</div>


<div class="col-md-6" id="col_3"></div>
</div>  
</div>

