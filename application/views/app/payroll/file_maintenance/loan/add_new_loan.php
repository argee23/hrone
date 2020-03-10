<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_loan_type/save_add_new_loan" >
    <div class="box-body">
      <div class="form-group">
      <strong>    
    <?php 
         $company_id =$this->uri->segment('4');
         $current_comp=$this->payroll_loan_model->get_company($company_id);
         if(!empty($current_comp)){
            echo $company_name = $current_comp->company_name;
         }else{
            echo $company_name="company not exist";
         }
         $this->uri->segment("4");
       ?>
           <i class="fa fa-angle-double-right text-danger"></i>
     Add New Loan
      </strong>
      </div>
      <div class="form-group">
      <input type="hidden" name="company_name" value="<?php echo $company_name; ?>">
      <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
      <input type="hidden" class="form-control" name="company_id" id="company_id" placeholder="" value="<?php echo $company_id; ?>" required maxlength="10">
   <br></br> 
     
      <div class="form-group">
        <label class="col-sm-4 control-label">Loan Type</label>
         <div class="col-sm-8">  <input type="text" class="form-control" name="loan_type" id="loan_type" onchange="return trim(this)" placeholder="Loan Type" required maxlength="15">
         </div>
      </div>
       <div class="form-group">
        <label  class="col-sm-4 control-label">Loan Category</label>
        <div class="col-sm-8">
               <select  class="form-control" name="loan_category"  id="myCheck1" required>
                  <option selected="selected" value=""  required>~ Select Category ~</option>
                  <?php 
                  foreach($category as $cat){
                  echo "<option value='".$cat->id."' >".$cat->category."</option>";
                  }
                  ?>
               </select> 
          </div>
      </div>
     
    


       <div class="form-group">
        <label  class="col-sm-4 control-label">Loan Code</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="loan_type_code" id="loan_type_code" onchange="return trim(this)" placeholder="Loan Code"  maxlength="10">
        </div>
      </div>
     
      <div class="form-group">
        <label  class="col-sm-4 control-label">Description</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="loan_type_desc" id="loan_type_description" onchange="return trim(this)" placeholder="Description" required maxlength="30">
        </div>
      </div>
      
        <div class="form-group">
        <label class="col-sm-4 control-label">Allow employee to file this loan</label>
         <div class="col-sm-8">  
            <select class="form-control" name="allow_to_file" id="allow_to_file" required>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
         </div>
      </div>

       <div class="form-group">
        <label  class="col-sm-4 control-label" style="visibility: hidden;">InActive</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="InActive" id="InActive" style="visibility: hidden;" placeholder="Auto-generate" value="0">
        </div>
      </div>

          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>



   

<script >
         /* document.getElementById('yourBox').onchange = function() {
           document.getElementById('yourText').disabled = !this.checked;
};
*/ </script>
   <!--   <input type="text" id="yourText" disabled />
      <input type="checkbox" id="yourBox" />
 -->