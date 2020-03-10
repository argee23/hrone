
<div class="box-body">
<div class="panel panel-success">
<div class="box-body">
<div class="row">

<form method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/philhealth_save/<?php echo $this->uri->segment("4");?>" >
<div class="col-md-12">
<div class="form-group">
            <?php 
                
              $pay_type_id          = $this->uri->segment("4");
              $company              = $this->uri->segment("5");
              $date                 = $this->uri->segment("6");
                    
                    
                     ?>
            <a onclick="philhealth_table_add('<?php echo $company; ?>','<?php echo $pay_type_id; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-info pull-right"></i></a>


<?php 
$check = false;
?>
<?php if (count($payroll_philhealth) > 0){ ?>
    <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width:15%" >PAY TYPE</th>
                <th style="width:15%" > MONTHLY SALARY RANGE</th>
                <th > PERCENT VALUE</th>
                <th style="width:15%" >EMPLOYEE SHARE </th>
                <th style="width:15%" >EMPLOYER SHARE </th>
                <th style="width:15%" >TYPE</th>
                <th style="width:10%" >Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $check = false;
              foreach($payroll_philhealth as $philhealth){ ?>
              <tr>
                <td align="center" ><?php 
                    $pay_type_id = '';
                    $pay_type = $philhealth->pay_type_id;

                    if($pay_type == 1){
                      $pay_type_id = "Weekly";
                    }else if($pay_type == 2){
                      $pay_type_id = "Bi-Weekly";
                    }else if($pay_type == 3){
                      $pay_type_id = "Semi-Monthly";
                    }else{
                      $pay_type_id = "Monthly";
                    }

                echo $pay_type_id; 


                ?></td>
                <td align="center" ><?php echo $philhealth->monthly_salary_range_from.' - '.$philhealth->monthly_salary_range_to; ?></td>
                <td align="center" ><?php echo $philhealth->percent_value; ?></td>
                <td align="center" ><?php echo $philhealth->employee_share; ?></td>
                <td align="center" ><?php echo $philhealth->employer_share; ?></td>
                <td align="center" ><?php echo $philhealth->philhealth_type_name; ?></td>
                <td>

                <a  class="fa fa-trash fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/payroll_file_maintenance/philhealth_table_delete/'. $philhealth->monthly_salary_bracket.''); ?>" onClick="return confirm('Are you sure you want to delete?')"></a>

                <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="philhealth_table_edit('<?php echo $philhealth->monthly_salary_bracket; ?>')"></i></div>
                </td>
              </tr>
              <?php $check = true;
              } ?>
            </tbody>
            </table>

            <?php if($check === false){ ?>
                <tr>
                  <p class='text-center' style='color:#ff0000;'><strong>No Philhealth Data yet.</strong></p>
                </tr>
            <?php } ?>
        </tbody>
     </table>
     </div>

</div>
</div>  

</div>
</div>
</div>
</div>

<?php }

else{ ?>
  <div class="col-md-12">
  <div class="form-group">
    <h5><strong>No field(s) yet.</strong></h5>
  </div>
  </div>
<?php }?>




