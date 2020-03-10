<div class="well">
<!-- form start -->
  <form method="post" action="<?php echo base_url()?>app/payroll_loan_type/loan_edit_save/<?php echo $this->uri->segment("4");?>" > 
   <div class="box-body">
      <div class="form-group">
      <strong>
     <?php foreach($table_loan as $loans)
         $company_id =$loans->company_id;
         $current_comp=$this->payroll_loan_model->get_company($company_id);
         if(!empty($current_comp)){
            echo $company_name = $current_comp->company_name;
         }else{
            echo $company_name="company not exist";
         }
         $this->uri->segment("4");
       ?>
           <i class="fa fa-angle-double-right text-danger"></i>
     Edit Loan Type
      </strong>
      </div>
   
      <?php foreach($table_loan as $loans){ ?>
     
     
              <input type="text" name="loan_type_id" id="loan_type_id" style="visibility: hidden;"  value="<?php echo $loans->loan_type_id;?>" readonly/>
    
              <input type="text"  name="company_id" id="company_id"  style="visibility: hidden;"  value="<?php echo $loans->company_id;?>" >
  

        <div class="form-group">
          <label  class="col-sm-4 control-label">Loan Type</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="loan_type" id="loan_type" onchange="return trim(this)" required maxlength="15" value="<?php echo $loans->loan_type;?>">
            </div>
        </div>
     <br></br>
<!-- <?php echo var_dump($category); ?> -->
       <div class="form-group">
          <label  class="col-sm-4 control-label">Category</label>
            <div class="col-sm-8">
    
                <select name="loan_category" id="myCheck1" class="form-control" required>
                  <option selected="selected" value="<?php echo $loans->loan_category; ?>"> 
                 <?php 
                    $loan_category = $loans->loan_category;
                  foreach($category as $cat){
                    if($loan_category == $cat->id){
                     echo "<td align='center'>".$cat->category."</td>";
                    }else{
                      echo "";
                    }
                  
                  }
                  ?>
                    
                  </option>
                    <?php foreach($category as $cat)
                   { 
                  echo "<option value='".$cat->id."' >".$cat->category."</option>";
                  }
                  ?>
                </select>

             </div>
        </div><!-- /.form-group -->
     <br></br>
     
  
       
         <div class="form-group">
          <label  class="col-sm-4 control-label">Loan Code</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="loan_type_code" id="loan_type_code" onchange="return trim(this)" maxlength="10" value="<?php echo $loans->loan_type_code;?>">
            </div>
        </div>
     
      <br></br>
       <div class="form-group">
          <label  class="col-sm-4 control-label">Description</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="loan_type_desc" id="loan_type_desc" required maxlength="30" onchange="return trim(this)" value="<?php echo $loans->loan_type_desc;?>">
            </div>
        </div> 
        <br></br>
         <div class="form-group">
          <label class="col-sm-4 control-label">Allow employee to file this loan</label>
           <div class="col-sm-8">  
              <select class="form-control" name="allow_to_file" id="allow_to_file" required>
                  <option value="1" <?php if($loans->allow_to_file==1){ echo "selected"; }?>>Yes</option>
                  <option value="0" <?php if($loans->allow_to_file!=1){ echo "selected"; }?>>No</option>
              </select>
         </div>
         </div>


      <?php } ?>
      <br></br>  
     
   
      <button type="submit" class="btn btn-danger btn-xs pull-right" style="margin-top:10px;" ><i class="fa fa-check fa-2x"  data-toggle="tooltip" data-placement="right" title="Modify" ></i></button>
     <!-- /.box-body -->
  </form>
  </div>




