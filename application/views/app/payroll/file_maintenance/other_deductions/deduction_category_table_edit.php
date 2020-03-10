<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_file_maintenance_deductions/deduction_category_edit_save/<?php echo $this->uri->segment("4");?>" > 
   <div class="box-body">
      <div class="form-group">
      <strong>
     <?php foreach($table_category as $categories)
         $company_id =$categories->company_id;
         $current_comp=$this->payroll_file_maintenance_deductions_model->get_company($company_id);
         if(!empty($current_comp)){
            echo $company_name = $current_comp->company_name;
         }else{
            echo $company_name="company not exist";
         }
         $this->uri->segment("4");
       ?>
           <i class="fa fa-angle-double-right text-danger"></i>
     Edit Other Deductions Category
      </strong>
      </div>
      <?php foreach($table_category as $categories){ ?>
     
     
              <input type="text" name="id" id="id" style="visibility: hidden;"  value="<?php echo $categories->id;?>" readonly/>
    
              <input type="text"  name="company_id" id="company_id"  style="visibility: hidden;"  value="<?php echo $categories->company_id;?>" >
  
<br></br>
        <div class="form-group">
          <label  class="col-sm-4 control-label">Category</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="category" id="category" onchange="return trim(this)" maxlength="20" value="<?php echo $categories->category;?>">
            </div>
        </div>    
 
      <?php } ?>
      <br></br>  
     
   
      <button type="submit" class="btn btn-danger btn-xs pull-right" style="margin-top:10px;" ><i class="fa fa-check fa-2x"  data-toggle="tooltip" data-placement="right" title="Modify" ></i></button>
     <!-- /.box-body -->
  </form>
  </div>




