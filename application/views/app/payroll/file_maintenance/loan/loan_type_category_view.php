

<div class="col-md-7" id="printProfile" >

<div class="row table-responsive">
<div class="col-md-12">

<div class="box box-success ">
<div class="panel panel-success" >
  <div class="panel-heading table-responsive " >
        <strong>
        <?php 
        //$key_location="1";
           $company_id =$this->uri->segment('4');
           $current_comp=$this->payroll_loan_category_model->get_company($company_id);
           if(!empty($current_comp)){
              echo $company_name = $current_comp->company_name;
           }else{
              echo $company_name="classification not exist";
           }
        
         ?>
      </strong><strong>(LOAN CATEGORY)</strong>

      

       <a onclick="add_new_category(<?php echo $company_id;?>)" type="button" class="btn btn-xs btn-default pull-right " data-toggle="tooltip" data-placement="left" title="Add Category"><i class="fa fa-plus text-danger"></i>Add New Category</a>
      
    
       </div>

  <div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">




      
          <div class="col-md-12" >
      <div class="form-group">
      
   <table class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>
                <th style="text-align:center;">ID</th>
                <th style="text-align:center;">CATEGORY</th>
                <th style="text-align:center;">STATUS</th>
                <th style="text-align:center;">ACTION</th>
            </tr>
        </thead>
        <tbody>

      <?php foreach($category as $categories){if($categories->InActive == 0){ $inactive = 'Enabled';}else{ $inactive = 'Disabled';}?>

                  <tr <?php if($categories->InActive == 1){echo 'style="color:#999;""';}else{echo 'class="text-success"';} ?>>
                    <td align="center"><?php echo $categories->id?></td>
                    <td align="center"><?php echo $categories->category; ?></td>
                    <td align="center"><?php echo $inactive?></td>
                    <td colspan="2" align="center" style="padding-right:70px;">

                    <?php if($categories->InActive == 0){ ?>
                                
                        <?php
                          $to_edit_enabled= $this->session->userdata('check_leave_type_edit_enabled_icon');  
                         echo $edit = '<i '.$to_edit_enabled.' class="hidden" data-toggle="tooltip" data-placement="left" title="Edit '.$categories->category.'" onclick="category_table_edit('.$categories->id.')"></i>'; 
                        ?>

                        <a href="<?php echo base_url()?>app/payroll_loan_category/deactivate_loan_category/<?php echo $categories->id;?>"><i <?php echo $this->session->userdata('check_leave_type_todisable_icon'); ?> class="hidden"  data-toggle="tooltip" data-placement="left" title="Click to Disable <?php echo $categories->category?>'" onclick="return confirm('Are you sure you want to disable <?php echo $categories->category?> category?')"></i></a>

                        <a href="<?php echo base_url()?>app/payroll_loan_category/delete_category/<?php echo $categories->id;?>/<?php echo $categories->company_id;?>"><i class="fa fa-remove fa-lg text-success pull-right"  data-toggle="tooltip" data-placement="left" title="Click to Delete <?php echo $categories->category?>'" onclick="return confirm('Are you sure you want to delete <?php echo $categories->company_id.' : '.$categories->category?> category?')"></i></a>

                    <?php 



                    }else{?>

                        <i <?php echo $this->session->userdata('check_leave_type_edit_disabled_icon'); ?>  class="hidden" data-toggle="tooltip" data-placement="left" title="cannot edit: enable first <?php //echo $leave_type->leave_type?>'"></i>

                        <a href="<?php echo base_url()?>app/payroll_loan_category/activate_loan_category/<?php echo $categories->id;?>"><i <?php echo $this->session->userdata('check_leave_type_toenable_icon'); ?> class="hidden" data-toggle="tooltip" data-placement="left" title="Click to Enable <?php echo $categories->category?>'" onclick="return confirm('Are you sure you want to enable <?php echo $categories->category?> category?')"></i></a>
               
                        <i class="fa fa-remove fa-lg text-muted pull-right"  data-toggle="tooltip" data-placement="left" title="cannot delete : enable first "></i>

                    <?php 

                    }?>
                    </td>
                  </tr>
                  <?php }?>

       
              </tbody>
            </table>

           

      </div>
      </div>

  
     </div> 
         </div><!-- /.box-body --> 

   </div>

   </div>
</div>

</div>
</div>

</div>
</div>
<div class="col-md-4"  id="col_3">
    
  </div>
