

<div class="box-body">
<div class="panel panel-success">
<div class="box-body">
<div class="row">

<form method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/sss_save/<?php echo $this->uri->segment("4");?>" >
<div class="col-md-12">
<div class="form-group">

          <?php 
                
              $pay_type_id          = $this->uri->segment("4");
              $company              = $this->uri->segment("5");
              $date                 = $this->uri->segment("6");
                    
                    
                     ?>
             <a onclick="sss_table_add('<?php echo $company; ?>','<?php echo $pay_type_id; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a> 
  

  <?php 
$check = false;
?>
<?php if (count($payroll_sss) > 0){ ?>
     <table class="table table-bordered table-striped">
      <colgroup span="2"></colgroup>
      <colgroup span="2"></colgroup>

      <thead>
      <tr>
        <th scope="col" rowspan="3" style="width:20%; text-align: center;" >PAY TYPE</th>
              <th scope="col" rowspan="3" style="width:20%; text-align: center;" >RANGE OF COMPENSATION</th>
        <th scope="col" rowspan="3" style="width:10%" > MONTHLY SALARY CREDIT</th>
        <th scope="col" colspan="7" > EMPLOYER-EMPLOYEE</th>
        <th scope="col" colspan="1" style="width:10%" > SE/VM/OFW</th>
        <th scope="col" rowspan="3" ><!--  <a onclick="sss_table_add('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a>  --> </th>
      </tr>
      <tr>
        <th scope="col"  colspan="3" >SOCIAL SECURITY</th>
        <th scope="col"  colspan="1" >EC</th>
        <th scope="col"  colspan="3" >TOTAL CONTRIBUTION</th>
        <th rowspan="2"  >TOTAL <br> CONTRIBUTION</th>
      </tr>
      <tr>
        <th scope="col">ER</th>
        <th scope="col">EE</th>
        <th scope="col">TOTAL</th>
        <th scope="col">ER</th>
        <th scope="col">ER</th>
        <th scope="col">EE</th>
        <th scope="col">TOTAL</th>
      </tr>
      </thead>
      <tbody>
          <?php foreach($payroll_sss as $sss){ ?>
          <tr>
            <td align="center">
              <?php 
                    $pay_type_id = '';
                    $pay_type = $sss->pay_type_id;

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


                ?>
            </td>
            <td align="center" ><?php echo $sss->range_of_compensation_from.' - '.$sss->range_of_compensation_to;  ?></td>
            <td align="center" ><?php echo $sss->monthly_salary_credit;  ?></td>
            <td align="center" ><?php echo $sss->ss_er;  ?></td>
            <td align="center" ><?php echo $sss->ss_ee;  ?></td>
            <td align="center" ><?php echo $sss->total_ss;  ?></td>
            <td align="center" ><?php echo $sss->ec_er;  ?></td>
            <td align="center" ><?php echo $sss->tc_er;  ?></td>
            <td align="center" ><?php echo $sss->tc_ee;  ?></td>
            <td align="center" ><?php echo $sss->total_tc;  ?></td>
            <td align="center" ><?php echo $sss->total_contribution;  ?></td>
           
            <td>
            <a  class="fa fa-trash fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/payroll_file_maintenance/sss_table_delete/'. $sss->sss_id.''); ?>" onClick="return confirm('Are you sure you want to delete?')"></a>

            <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="sss_table_edit('<?php echo $sss->sss_id; ?>')"></i></div>
            </td>
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

<?php }

else{ ?>
  <div class="col-md-12">
  <div class="form-group">
    <h5><strong>No field(s) yet.</strong></h5>
  </div>
  </div>
<?php }?>


