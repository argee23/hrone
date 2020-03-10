
<div class="col-md-12">
<br>
<div class="col-md-3"></div>
<div class="col-md-6">
      <select class="form-control" onchange="get_settings_filter(this.value,'<?php echo $type;?>');">
        <option value='SD1'>Package List</option>
        <option value='SD12'>Free Trial Requirement List</option>
        <option value='SD3'>Subscription Requirement List</option>
        <option value='SD6'>Email Settings</option>
        <option value='others'>Others</option>
      </select>
</div>
<div class="col-md-3"></div>
<div class="col-md-12" id="setting_filter">
      <table id="<?php echo $type;?>" class="table table-bordered table-striped">
          <thead>

            <tr class="danger">
              <th>No</th>
              <th>Customer Type</th>
              <th>Validity</th>
              <th>Jobs License</th>
              <th>Orig Price</th>
              <th>Discount %</th>
              <th>Discounted Price</th>
              <th>Vat Included already</th>
              <th>Vat Percentage</th>
              <th>Amount of Vat</th>
              <th>Gross</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $i=1;
          foreach($rec_employer_bill_setting_mng as $bill_offers){

          if ($bill_offers->InActive=="0"){
            $color="";
            $todo="disable_bill";
            $bg="";

          }elseif($bill_offers->InActive=="1"){
            $color="";
            $todo="enable_bill";
          $bg="";
          }else{

          }

          $enable_disable= '<a href="'.base_url().'serttech/mypublic_recruitment/'.$todo.'/'.$bill_offers->id.'"  " ><i class="fa fa-power-off '.$color.' pull-right"></i></a>'.'<br>';
          $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right"   data-toggle="tooltip" data-placement="left" title="Edit" onclick="editbill('.$bill_offers->id.')"></i>';
          $delete = anchor('serttech/mypublic/delete_bill/'.$bill_offers->id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-right"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ?')"));


          $customer=$bill_offers->customer_type;
          $num_months=$bill_offers->no_of_months;
          $num_jobs=$bill_offers->no_of_jobs;
          $orig_price=$bill_offers->orig_price;
          $disc_percent=$bill_offers->discount_percentage;

          $vat_per=$bill_offers->vat_percentage;
          $is_vat_included_at_last_price=$bill_offers->is_vat_included_at_last_price;

          $less_amount = ($disc_percent / 100) * $orig_price;
          $discounted_amount = $orig_price-$less_amount;
          $vat_amount= ($vat_per / 100) * $discounted_amount;

          if($is_vat_included_at_last_price=="no"){
            $gross=$discounted_amount+$vat_amount;
          }else{
            $gross=$discounted_amount-$vat_amount;
          }

          echo '<tr '.$bg.'>';
          echo '<td>'.$i.'</td>';
          echo '<td>'.$customer.' customers</td>';
          echo '<td>'.$num_months.' months</td>';
          echo '<td>'.$num_jobs.'</td>';
          echo '<td>'.$orig_price.'</td>';
          echo '<td>'.$disc_percent.'%  ('.number_format($less_amount,2).')</td>';
          echo '<td>'.$discounted_amount.'</td>';
          echo '<td>'.$is_vat_included_at_last_price.'</td>';
          echo '<td>'.$vat_per.'%</td>';
          echo '<td>'.number_format($vat_amount,2).'</td>';
          echo '<td>'.number_format($gross,2).'</td>';

          echo '</tr>';
        $i++; }
          ?>
          </tbody>
    </table>
</div>
</div>