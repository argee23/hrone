<div class="row">
<div class="col-md-6">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>New Transaction Form</strong><small> Document No. Identification : UDF_01 </small></div>

  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/transaction_user_define_fields/save_udf_col/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">





         <div class="form-group">
        <label for="label" class="col-sm-2 control-label">Form Title</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="formT" id="formT" placeholder="Form Title" value="" required>
        </div>
      </div>

       <div class="form-group">
        <label for="label" class="col-sm-2 control-label">Form Description</label>
        <div class="col-sm-10">
          <TEXTAREA type="text" class="form-control" name="formD" id="formD" placeholder="Form Description" value="" required> </TEXTAREA>
        </div>
      </div>

      <div class="form-group">
        <label for="company_id" class="col-sm-2 control-label">Company id</label>
        <div class="col-sm-10">
          <select class="form-control" name="company" id="company" required>
            <option selected="selected" value="" disabled="">~ Select Company ~</option>
            <option value="0">Select All Company</option>
              <?php 
                foreach($companyList as $company){
                  echo "<option value='".$company->company_id."' >".$company->company_name."</option>";
                }
              ?>
          </select>    
        </div>

      </div>


<?php 
  if($this->uri->segment("4")!=""){
    $count=$this->uri->segment("4");
    $nof = "0"; 
  while($nof!=$count){
  $nof++;
  echo '  

      <div class="box box-default">
      </br>
        <div class="form-group">
        <label for="label" class="col-sm-2 control-label">Label</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="label" id="label" placeholder="Label" value="" required>
        </div>
      </div>




      <div class="form-group">
        <label for="type" class="col-sm-2 control-label">Input Type</label>
        <div class="col-sm-10">
          <select class="form-control" name="type" id="type" data-toggle="collapse" onclick="add_forTextfield(this.value)" required>
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
          </div>
    ';
   }
   }else{
       echo "";
    }

  
   ?>

    









          <button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
</div>
</div>


<div class="col-md-6" id="col_3"></div>
</div>  
</div>

