

<div class="col-md-4" id="printProfile" >

<div class="row table-responsive">
<div class="col-md-12">

<div class="box box-success ">
<div class="panel panel-success" >
  <div class="panel-heading table-responsive " >
        <strong>
       
        <?php 

           $company_id = $this->uri->segment('4');
           $current_comp=$this->payroll_other_deduction_emp_enrollment_model->get_company($company_id);
           if(!empty($current_comp)){
              echo $company_name = $current_comp->company_name;
           }else{
              echo $company_name="classification not exist";
           }
        
         ?>
      </strong><strong>(PAYROLL OTHER DEDUCTION SELECT OPTION)</strong>

      

     
    
       </div>

  <div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">




      
          <div class="col-md-12" >
              <div class="form-group">
                  <div class="btn-group-vertical btn-block">
                     <a onclick="other_deduction_manual_encoding(<?php echo $company_id;?>)" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>MANUAL ENCODING OF DEDUCTION</strong></p></a>
                     <a onclick="manual_excel_upload(<?php echo $company_id;?>)" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>MANUAL EXCEL UPLOAD</strong></p></a>
                     <a onclick="automatic_deduction(<?php echo $company_id;?>)" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>SET AUTOMATIC DEDUCTION</strong></p></a>
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
