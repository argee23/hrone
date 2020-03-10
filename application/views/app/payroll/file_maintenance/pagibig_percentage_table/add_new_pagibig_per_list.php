
      
<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_pagibig_percentage_table/save_add_new_pagibig_per_list" >
    <div class="box-body">
      <div class="form-group">
      <strong>    
    <?php 
         $company_id =$this->uri->segment('4');
         $current_comp=$this->payroll_pagibig_percentage_table_model->get_company($company_id);
         if(!empty($current_comp)){
            echo $company_name = $current_comp->company_name;
         }else{
            echo $company_name="company not exist";
         }
         $this->uri->segment("4");
       ?>
           <i class="fa fa-angle-double-right text-danger"></i>
     ADD NEW PAGIBIG PERCENTAGE
      </strong>
      </div>
     
      <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>">
     
      <table class="table table-bordered table-striped">
       
            <tr>
              <td>  
                    <label class="col-sm-4">AMOUNT FROM</label>
                       <input type="number" style="text-align: center;" class="form-control" step="0.01" onchange="return trim(this)" name="amount_from" id="amount_from" placeholder="0.00" required>
                 
                    <label class="col-sm-4">AMOUNT TO</label>
                        <input type="number" style="text-align: center;" class="form-control" step="0.01"  onchange="return trim(this)" name="amount_to" id="amount_to" placeholder="0.00" required>
              </td>
              <td>   
                    <label class="col-sm-4">EMPLOYEE SHARE</label>
                         <input type="number" style="text-align: center;" class="form-control" step="0.01"  onchange="return trim(this)" name="employee_share" id="employee_share" placeholder="0.00" required>
                 
                    <label class="col-sm-4">EMPLOYER SHARE</label>
                      <input type="number" style="text-align: center;" class="form-control" step="0.01"  onchange="return trim(this)" name="employer_share" id="employer_share" placeholder="0.00" required>
                  
                     
              </td>

              <td>   
                    <label class="col-sm-4">COVERED YEAR</label>
                           <select style="text-align: center;" class="form-control"  onchange="return trim(this)" name="covered_year" id="covered_year" placeholder="0.00" required>
                           <?php 
                                $year = date('Y');
                                $min = $year - 22;
                                $max = $year;
                                for( $i=$max; $i>=$min; $i-- ) {
                                  echo '<option value='.$i.'>'.$i.'</option>';
                                }
                              ?>
                           </select>           
              </td>            
            </tr>    
      
        
      </table>
      <br></br>

          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>


