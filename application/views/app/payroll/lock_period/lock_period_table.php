
<?php

$company_id=$this->uri->segment("4");
$pay_type=$this->uri->segment("5");
$payroll_period_group_id = $this->uri->segment("6");

$comp_details=$this->general_model->get_company_info($company_id);
$division_setting=$comp_details->wDivision;

?>
<div class="col-md-8" id="printProfile" >

  <div class="row table-responsive">
    <div class="col-md-12">

      <div class="box box-success ">
        <div class="panel panel-success" >
          <div class="panel-heading table-responsive " >
            <strong>
              
              
            </strong><strong>LOCK PAYROLL PERIOD
            
          </strong>
          
        </div>

        <div class="box-body table-responsive" >
          <div class="panel panel-success">
           <div class="box-body " >
             <div class="row">

               <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id;  ?>">
               <input type="hidden" name="pay_type" id="pay_type" value="<?php echo $pay_type;  ?>">
               <input type="hidden" name="group_id" id="group_id" value="<?php echo $payroll_period_group_id;  ?>">


               
               <div class="col-md-12" >
                <div class="table-responsive">
                  
                 <table id="example1" class="table table-striped table-striped table-bordered table-condensed">
                  <thead >
                    <tr>
                      <th style="text-align:center;">ID</th>
                      <th  style="text-align:center;">PAYCODE</th>
                      <th  style="text-align:center;">DATE FROM</th>
                      <th  style="text-align:center;">DATE TO</th>
                      <th  style="text-align:center;">NO. OF DAYS</th>
                      <th  style="text-align:center;">CREATE TRANSACTION</th>
                      <th  style="text-align:center;">DTR</th>
                      <th  style="text-align:center;">DEDUCT/ADD ADJUSTMENT</th>
                      <th  style="text-align:center;">GENERATE PAYSLIP</th>
                      <!--   <th  style="text-align:center;">STATUSs</th> -->
                      <th  style="text-align:center;">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php foreach($lock_period_table as $lpb){if($lpb->IsDisabled == 0){ $inactive = 'Enabled';}else{ $inactive = 'Disabled';}?>

                   <tr <?php if($lpb->IsDisabled == 1){echo 'style="color:#999;""';}else{echo 'class="text-success"';} ?>>
                     <!--  <input type="hidden" value="<?php echo $lpb->id;  ?>"> -->
                     <input type="hidden" value="<?php echo $lpb->company_id;  ?>">
                     <input type="hidden" value="<?php echo $lpb->payroll_period_group_id;  ?>">
                     <td align="center"><?php echo $lpb->id;  ?></td>
                     <td align="center" ><?php echo $lpb->pay_code;  ?></td>
                     <td align="center" ><?php echo $lpb->month_from; echo '/'; echo $lpb->day_from; echo '/'; echo $lpb->year_from;  ?></td>
                     <td align="center" ><?php echo $lpb->month_to; echo '/'; echo $lpb->day_to; echo '/'; echo $lpb->year_to;  ?></td>
                     <td align="center" ><?php echo $lpb->no_of_days;  ?></td>
                     
                     
                     <?php 
                     $ct  = NULL;
                     $dtr = NULL;
                     $da  = NULL;
                     $gp  = NULL;

                     foreach($LOCKPERIOD as $lp)
                      
                      if($lpb->id == $lp->payroll_period_id){
                        $ct = $lp->create_transaction;
                        $dtr = $lp->d_t_r;
                        $da = $lp->deduct_add_adjustment;
                        $gp = $lp->generate_payslip;
                        
                        $q = $this->payroll_lock_period_model->getLockPeriod($lpb->id,$lp->payroll_period_id);
                        
                        if(empty($q)){
                         $ct = "";
                         $dtr = "";
                         $da = "";
                         $gp = "";
                         
                         
                       }else{
                        $ct = $ct;
                        $dtr = $dtr;
                        $da = $da;
                        $gp = $gp;
                        
                        
                      }
                      
                      
                    }  
                    
                    if($ct == 1){

                      $ct = "checked";
                    }else{
                      $ct = "";
                    }
                    
                    if($dtr == 1){

                      $dtr = "checked";
                    }else{
                      $dtr = "";
                    }
                    
                    if($da == 1){

                      $da = "checked";
                    }else{
                      $da = "";
                    }
                    
                    if($gp == 1){

                      $gp = "checked";
                    }else{
                      $gp = "";
                    }
                    
                    
                    echo "<td align='center'><input type='checkbox'".$ct." disabled/></td>"; 
                    echo "<td align='center'><input type='checkbox'".$dtr." disabled/></td>"; 
                    echo "<td align='center'><input type='checkbox'".$da." disabled/></td>"; 
                    echo "<td align='center'><input type='checkbox'".$gp." disabled/></td>"; 
                    
                    ?>  
                    
                    <!--    <td align="center"><?php echo $inactive?></td> -->

                    <td align="center" style="padding-right: 35px;">

                      <?php if($lpb->IsDisabled == 0){ ?>


                      <?php 
                      $paycode = $lpb->pay_code;
                      $comp_id = $company_id;
                      $paytype = $pay_type;
                      $groupid = $payroll_period_group_id;
                      
                      $id = $lpb->id;
                      $already_exist = $this->payroll_lock_period_model->get_paycode($id,$comp_id);
                      if($already_exist == 1){

                        ?>
                        <?php
                        
                        $to_edit_enabled= $this->session->userdata('check_leave_type_edit_enabled_icon');  
                        echo $edit = '<i '.$to_edit_enabled.' class="fa fa-pencil-square-o fa-lg text-primary pull-right" data-toggle="tooltip" data-placement="left" title="Edit '.$lpb->pay_code.'" onclick="lock_period_table_edit('.$lpb->id.')"></i>';
                        ?>
                        <br>
                        <?php }else{?>

                  <!--           <a href="<?php echo base_url()?>app/payroll_lock_period/deactivate_pay_code/<?php echo $lpb->id;?>"><i <?php echo $this->session->userdata('check_leave_type_todisable_icon'); ?> class="hidden"  data-toggle="tooltip" data-placement="left" title="Click to Disable <?php echo $lpb->pay_code?>'" onclick="return confirm('Are you sure you want to disable <?php echo $lpb->pay_code?> pay code?')"></i></a>
                --> <a><i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="Click to Add <?php echo $lpb->pay_code?>'" onclick="lock_period_table_add('<?php echo $lpb->id?>')"></i></a>

                <?php } ?>

                <?php 



              }else{?>
              <?php if(empty($ct)): ?>
                <i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="cannot add : enable first "></i>
                <br>
              <?php else: ?>
                <a href="<?php echo base_url()?>app/payroll_lock_period/activate_pay_code/<?php echo $lpb->id;?>"><i <?php echo $this->session->userdata('check_leave_type_toenable_icon'); ?> class="hidden" data-toggle="tooltip" data-placement="left" title="Click to Enable <?php echo $lpb->pay_code?>'" onclick="return confirm('Are you sure you want to enable <?php echo $lpb->pay_code?> pay code?')"></i></a>
                
                <i <?php echo $this->session->userdata('check_leave_type_edit_disabled_icon'); ?>  class="hidden" data-toggle="tooltip" data-placement="left" title="cannot edit: enable first <?php //echo $leave_type->leave_type?>'"></i>
              <?php endif; ?>
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




<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->



