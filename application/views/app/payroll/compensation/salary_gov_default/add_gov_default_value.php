<?php 

    $company_id = $this->uri->segment('4');
   // echo $company_id;
    $location_id = $this->uri->segment('5');
   // echo $location_id;
  ?>

<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_compensation/save_add_def_value" >
    <div class="box-body">
      <div class="form-group">
      <strong>    
    <?php 
         $company_id =$this->uri->segment('4');
         $current_comp=$this->payroll_compensation_model->get_company($company_id);
         if(!empty($current_comp)){
            echo $company_name = $current_comp->company_name;
         }else{
            echo $company_name="company not exist";
         }
         $this->uri->segment("4");
       ?>

            <i class="fa fa-angle-double-right text-danger"></i>
     Government Subject to Default Value
      </strong>
      </div>
      <div class="form-group">
      <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>">  
       <input type="hidden" name="location_id" id="location_id" value="<?php echo $location_id; ?>">    
   <br></br>  
     
    
       <table class="table table-bordered table-striped">
       
           <thead>
                      <tr>
                        <th style="text-align: center;">Location ID</th>
                        <th style="text-align: center;">With Holding TAX</th>
                        <th style="text-align: center;">Pag-Ibig</th>
                        <th style="text-align: center;">SSS</th>
                        <th style="text-align: center;">Philhealth</th>
                        
                       
                        
                      </tr>
            </thead>
            <tbody>
                     
                      <tr>
                          <td align="center">
                              <?php echo $location_id; ?>
                          </td>
                          <td align="center">
                                  <input type="hidden" name="withholding_tax" id="withholding_tax" value="0"> 
                                  <input type="checkbox" name="withholding_tax" id="withholding_tax" value="1"> 
                          </td> 
                          <td align="center">
                                  <input type="hidden" name="pagibig" id="pagibig" value="0"> 
                                  <input type="checkbox" name="pagibig" id="pagibig" value="1"> 
                          </td> 
                          <td align="center">
                                  <input type="hidden" name="sss" id="sss" value="0"> 
                                  <input type="checkbox" name="sss" id="sss" value="1"> 
                          </td>
                          <td align="center">
                                  <input type="hidden" name="philhealth" id="philhealth" value="0"> 
                                  <input type="checkbox" name="philhealth" id="philhealth" value="1">
                          </td>
            </tr>
            </tbody>
        
      </table>
      <br></br>
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>
