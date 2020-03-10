<div id="fsModal"
     class="modal animated bounceIn"
     tabindex="-1"
     role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">
        <h4 id="myModalLabel"
            class="modal-title">
          Subscription Complete Details
        </h4>
      </div>
      
      <div class="modal-body">
       
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
        foreach($rec_employer_bill_setting as $bill_offers){

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


      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary"
                data-dismiss="modal">
          close
        </button>
       
      </div>
    </div>
  </div>
</div>

<!-- new added modal for list of subscription
 -->


<style type="text/css">
  
* {
  box-sizing: border-box;
}


.modal {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  overflow: hidden;
}

.modal-dialog {
  position: fixed;
  margin: 0;
  width: 100%;
  height: 100%;
  padding: 0;
}

.modal-content {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  border: 2px solid #3c7dcf;
  border-radius: 0;
  box-shadow: none;
}

.modal-header {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  height: 50px;
  padding: 10px;
  background: #6598d9;
  border: 0;
}

.modal-title {
  font-weight: 300;
  font-size: 2em;
  color: #fff;
  line-height: 30px;
}

.modal-body {
  position: absolute;
  top: 50px;
  bottom: 60px;
  width: 100%;
  font-weight: 300;
  overflow: auto;
}

.modal-footer {
  position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  height: 60px;
  padding: 10px;
  background: #f1f3f5;
}


.btn-modal {
  position: absolute;
  top: 50%;
  left: 50%;
  margin-top: -20px;
  margin-left: -100px;
  width: 200px;
}

</style>