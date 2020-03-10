 <div class="col-md-12" style="padding-top: 10px;overflow: scroll;" id="d">
 <h4 class="text-danger"><center>Subscription Package List </center></h4>
   <table id="package" class="table table-bordered table-striped" style="height: 10%;overflow: scroll;">
        <thead>
          <tr class="danger">
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
            <th>Avail?</th>
          </tr>
        </thead>
        <tbody>
        <?php
        foreach($details as $bill_offers){

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
        if ($bill_offers->InActive=="0" || $bill_offers->InActive=="" ){
          $color="text-danger";
          $todo="disable_bill";
          $bg="";

        }elseif($bill_offers->InActive=="1"){
          $color="text-success";
          $todo="enable_bill";
        $bg="class='text-danger'";
        }else{
          $bg="";
        }

        echo 
        '<tr '.$bg.'>
          <td>'.$customer.' customers</td>
          <td>'.$num_months.' months</td>
          <td>'.$num_jobs.'</td>
          <td>'.$orig_price.'</td>
          <td>'.$disc_percent.'%  ('.number_format($less_amount,2).')</td>
          <td>'.$discounted_amount.'</td>
          <td>'.$is_vat_included_at_last_price.'</td>
          <td>'.$vat_per.'%</td>
          <td>'.number_format($vat_amount,2).'</td>
          <td>'.number_format($gross,2).'</td>
          <td>';
          $check_if_active_license =  $this->recruitment_employer_management_model->check_if_active_license($this->session->userdata('employer_id'),$company_id);
          if($check_if_active_license > 0){ echo "You're currently subscribe to other promo"; }else{ 
          ?>

             <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to avail package'
              onclick="avail_package('<?php echo $company_id;?>','<?php echo $this->session->userdata('employer_id');?>','<?php echo $bill_offers->id;?>','subscription');" ><i  class="fa fa-check fa-lg text-success  pull-left"></i></a>
          
          <?php } echo '</td>'
          ;?>
          
        <?php echo '</tr>';
        }
        ?>
        </tbody>
        </table>
</div>
