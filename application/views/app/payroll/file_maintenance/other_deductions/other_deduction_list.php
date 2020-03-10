

<div class="col-md-12" id="printProfile" >

<div class="row table-responsive">
<div class="col-md-12">

<div class="box box-success ">
<div class="panel panel-success" >
  <div class="panel-heading table-responsive " >
        <strong>
        <?php 
           $company_id =$this->uri->segment('4');
           $current_comp=$this->payroll_file_maintenance_deductions_model->get_company($company_id);
           if(!empty($current_comp)){
              echo $company_name = $current_comp->company_name;
           }else{
              echo $company_name="classification not exist";
           }
        
         ?>
      </strong><strong>(OTHER DEDUCTIONS)</strong>

      

      <strong> <a onclick="add_new_deduction_list(<?php echo $company_id;?>)" type="button" class="btn btn-xs btn-default pull-right " data-toggle="tooltip" data-placement="left" title="Add New Other Deduction"><i class="fa fa-plus text-danger"></i>Add New Other Deduction</a></strong>
      
    
       </div>

<div id="add_edit_table"></div>


  <div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">




      
          <div class="col-md-12" >
      <div class="table-responsive">
      
   <table id="example1" class="table table-striped table-striped table-bordered table-condensed">
        <thead>
            <tr>
                    <th style="text-align:center;">ID</th>
                    <th style="text-align:center;">CODE</th>
                    <th style="text-align:center;">TYPE</th>
                    <th style="text-align:center;">RATE</th>
                    <th style="text-align:center;">AMOUNT</th>
                    <th style="text-align:center;">TAXABLE</th>
                    <th style="text-align:center;">ALPHA LIST NON-TAX  <br>(de minimis)</th>
                    <th style="text-align:center;">BONUS</th>
                    <th style="text-align:center;">13th MONTH PAY</th>
                    <th style="text-align:center;">BASIC</th>
                    <th style="text-align:center;">OT</th>
                    <th style="text-align:center;">LEAVE</th>
                    <th style="text-align:center;">EXCLUDE TO ALPHALIST</th>
                    <th style="text-align:center;">CATEGORY</th>
                   <!--  <th style="text-align:center;">DATETIME ADDED/UPDATED</th> -->
                    <th style="text-align:center;">STATUS</th>
                    <th style="text-align:center;">ACTION</th>
            </tr>
        </thead>
        <tbody>
           <?php foreach($deduction_list as $deductlist){if($deductlist->InActive_type == 0){ $inactive = 'Enabled';}else{ $inactive = 'Disabled';}?>

                  <tr <?php if($deductlist->InActive_type == 1){echo 'style="color:#999;""';}else{echo 'class="text-success"';} ?>>
                   <input type="hidden" value="<?php echo $deductlist->company_id;  ?>">
                    <td align="center" ><?php echo $deductlist->id;  ?></td>
                    <td align="center" ><?php echo $deductlist->other_deduction_code;  ?></td>
                    <td align="center" ><?php echo $deductlist->other_deduction_type;  ?></td>
                    <td align="center" ><?php echo $deductlist->rate;  ?></td>
                    <td align="center" ><?php echo $deductlist->amount;  ?></td>
                  
                            <?php 
                                $taxable = FALSE;
                                $non_tax = FALSE;
                                $bonus = FALSE;
                                $th_month_pay = FALSE;
                                $basic = FALSE;
                                $ot = FALSE;
                                $other_addition_leave = FALSE;
                                $exclude = FALSE;
                               
                                                 if ($deductlist->taxable == 1) {
                                                      $taxable = TRUE;
                                                  } else {
                                                      $taxable = FALSE;
                                                  }
                                                 if ($deductlist->non_tax == 1) {
                                                      $non_tax = TRUE;
                                                  } else {
                                                      $non_tax = FALSE;
                                                  }
                                                 if ($deductlist->bonus == 1) {
                                                      $bonus = TRUE;
                                                  } else {
                                                      $bonus = FALSE;
                                                  }
                                                 if ($deductlist->th_month_pay == 1) {
                                                      $th_month_pay = TRUE;
                                                  } else {
                                                      $th_month_pay = FALSE;
                                                  }     
                                                 if ($deductlist->basic == 1) {
                                                      $basic = TRUE;
                                                  } else {
                                                      $basic = FALSE;
                                                  }     
                                                 if ($deductlist->ot == 1) {
                                                      $ot = TRUE;
                                                  } else {
                                                      $ot = FALSE;
                                                  }     
                                                 if ($deductlist->other_deduction_leave == 1) {
                                                      $other_deduction_leave = TRUE;
                                                  } else {
                                                      $other_deduction_leave = FALSE;
                                                  }     
                                                 if ($deductlist->exclude == 1) {
                                                      $exclude = TRUE;
                                                  } else {
                                                      $exclude = FALSE;
                                                  }     

                            ?>


                   <td align="center"> <input type="checkbox" id="checkbox" <?php echo ($taxable==TRUE)? 'checked':'';?> disabled/></td>
                   <td align="center"><input type="checkbox" id="checkbox" <?php echo ($non_tax==TRUE)? 'checked':'';?> disabled/></td>
                   <td align="center"><input type="checkbox" id="checkbox" <?php echo ($bonus==TRUE)? 'checked':'';?> disabled/></td>
                   <td align="center"><input type="checkbox" id="checkbox" <?php echo ($th_month_pay==TRUE)? 'checked':'';?> disabled/></td>
                   <td align="center"><input type="checkbox" id="checkbox" <?php echo ($basic==TRUE)? 'checked':'';?> disabled/></td>
                   <td align="center"><input type="checkbox" id="checkbox" <?php echo ($ot==TRUE)? 'checked':'';?> disabled/></td>
                   <td align="center" ><input type="checkbox" id="checkbox" <?php echo ($other_deduction_leave==TRUE)? 'checked':'';?> disabled/></td>
                   <td align="center" ><input type="checkbox" id="checkbox" <?php echo ($exclude==TRUE)? 'checked':'';?> disabled/></td>
                   <?php 
                    $deductcategory = $deductlist->category;
                  foreach($category as $cat){
                    if($deductcategory == $cat->id){
                     echo "<td align='center'>".$cat->category."</td>";
                    }else{
                      echo "";
                    }
                  
                  }
                  ?>
                <!--     <td align="center"><?php echo $deductlist->date;?></td> -->
                    <td align="center"><?php echo $inactive?></td>
                    <td style="padding-right: 30px;" align="center">

                    <?php if($deductlist->InActive_type == 0){ ?>
                                
                        <?php
                          $to_edit_enabled= $this->session->userdata('check_leave_type_edit_enabled_icon');  
                         echo $edit = '<i '.$to_edit_enabled.' class="hidden" data-toggle="tooltip" data-placement="left" title="Edit '.$deductlist->other_deduction_code.' " onclick="deduction_list_table_edit('.$deductlist->id.')"></i>'; 
                        ?>
                       <br>
                        <a href="<?php echo base_url()?>app/payroll_file_maintenance_deductions/deactivate_other_deduction_list/<?php echo $deductlist->id;?>"><i <?php echo $this->session->userdata('check_leave_type_todisable_icon'); ?> class="hidden"  data-toggle="tooltip" data-placement="left" title="Click to Disable <?php echo $deductlist->other_deduction_code?>'" onclick="return confirm('Are you sure you want to disable <?php echo $deductlist->other_deduction_code?> other deduction code?')"></i></a>
                       <br>
                        <a href="<?php echo base_url()?>app/payroll_file_maintenance_additions/delete_list/<?php echo $deductlist->id;?>/<?php echo $deductlist->company_id;?>"><i class="fa fa-remove fa-lg text-success pull-right"  data-toggle="tooltip" data-placement="left" title="Click to Delete <?php echo $deductlist->other_deduction_code?>'" onclick="return confirm('Are you sure you want to delete <?php echo $deductlist->company_id.' : '.$deductlist->other_deduction_code?> other deduction code?')"></i></a>
                       
                    <?php 



                    }else{?>

                        <i <?php echo $this->session->userdata('check_leave_type_edit_disabled_icon'); ?>  class="hidden" data-toggle="tooltip" data-placement="left" title="cannot edit: enable first <?php //echo $leave_type->leave_type?>'"></i>
                        <br>
                        <a href="<?php echo base_url()?>app/payroll_file_maintenance_deductions/activate_other_deduction_list/<?php echo $deductlist->id;?>"><i <?php echo $this->session->userdata('check_leave_type_toenable_icon'); ?> class="hidden" data-toggle="tooltip" data-placement="left" title="Click to Enable <?php echo $deductlist->other_deduction_code?>'" onclick="return confirm('Are you sure you want to enable <?php echo $deductlist->other_deduction_code?> other deduction code?')"></i></a>
                        <br>
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
