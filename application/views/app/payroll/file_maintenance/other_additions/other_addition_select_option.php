

<div class="col-md-4" id="printProfile" >

<div class="row table-responsive">
<div class="col-md-12">

<div class="box box-success ">
<div class="panel panel-success" >
  <div class="panel-heading table-responsive " >
        <strong>
        <?php 
           $company_id =$this->uri->segment('4');
           $current_comp=$this->payroll_file_maintenance_additions_model->get_company($company_id);
           if(!empty($current_comp)){
              echo $company_name = $current_comp->company_name;
           }else{
              echo $company_name="classification not exist";
           }
        
         ?>
      </strong><strong>(OTHER ADDITIONS)</strong>

      

     
    
       </div>

  <div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">




      
          <div class="col-md-12" >
              <div class="form-group">
                  <div class="btn-group-vertical btn-block">
                     <a onclick="other_addition_category_view(<?php echo $company_id;?>)" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Other Additions Category</strong></p></a>
                     <a onclick="other_addition_list(<?php echo $company_id;?>)" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Types of Other Additions</strong></p></a>
                 </div>


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
