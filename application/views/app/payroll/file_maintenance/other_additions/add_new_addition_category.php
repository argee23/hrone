<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_file_maintenance_additions/save_add_new_addition_category" >
    <div class="box-body">
      <div class="form-group">
      <strong>    
    <?php 
         $company_id =$this->uri->segment('4');
         $current_comp=$this->payroll_file_maintenance_additions_model->get_company($company_id);
         if(!empty($current_comp)){
            echo $company_name = $current_comp->company_name;
         }else{
            echo $company_name="company not exist";
         }
         $this->uri->segment("4");
       ?>
           <i class="fa fa-angle-double-right text-danger"></i>
     Add New Other Additions Category
      </strong>
      </div>
     
      <input type="hidden" name="company_name" value="<?php echo $company_name; ?>">
      <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
      <input type="hidden" class="form-control" name="company_id" id="company_id" placeholder="" value="<?php echo $company_id; ?>" required maxlength="10">
      <br></br>
      <div class="form-group">
        <label class="col-sm-4 control-label">Category</label>
         <div class="col-sm-8">  <input type="text" class="form-control"  onchange="return trim(this)" name="category" id="category" placeholder="Category" required maxlength="20">
         </div>
      </div>
      <br></br>

          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>


   

