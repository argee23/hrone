  <div class="datagrid">
    <table>
      <thead>
          <tr>
            <th colspan="4"><?php if($type=='free_trial'){ echo "Free Trial"; } else{ echo "Subscription"; } ?> License Details</th>
          </tr>
      </thead>
      <tbody>

      <?php if($type=='free_trial')
      { 
        $job_licensee = $this->recruitment_employer_model->check_active_license($company);
        $jleft = $job_licensee[2] - $job_licensee[0];
        // $date = date('Y-m-d',strtotime($details->date_registered));
        // $date_end = date('Y-m-d', strtotime('+'.$details->free_trial_months_can_post.' month', strtotime($date)));
      ?>

          <tr>
            <td><strong>Job License</strong></td>
            <td><?php echo $details->free_trial_jobs_can_post;?> Job/s</td>
            <td><strong>Validity</strong></td>
            <td><?php echo $details->free_trial_months_can_post;?> Month/s </td>
          </tr>

           <tr>
            <td><strong>Remaining Job License</strong></td>
            <td><?php echo $jleft;?></td>
            <td><strong>Valid Until</strong></td>
            <td><?php echo $details->date_end;?></td>
          </tr>

      <?php } 
      else{?>


        <?php foreach($license as $bill_offers){
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

      ?>

      <tr>
            <td><strong>License Start Date</strong></td>
            <td><?php if(!empty($details->date_registered)) { echo $details->date_registered; }?></td>


            <td><strong>License End Date</strong></td>
            <td> <?php 
                 if(!empty($details->date_registered)) {
                    $date = date('Y-m-d',strtotime($details->date_registered));
                    echo $date_end = date('Y-m-d', strtotime('+'.$details->validity_license.' month', strtotime($date)));
                  }
                  ?>
            </td>
      </tr>


      <tr>
            <td><strong>Remaining Job License</strong></td>
            <td>
              <?php 
                    $get_job_posted = $this->recruitment_employer_management_model->get_employer_posted_job('package',$company,$this->session->userdata('employer_id'),$details->package_id);
                    $job = $details->job_license - $get_job_posted;

                    ?>
                   You still have <?php echo $job;?> job(s) left
            </td>
            <td><strong>Customer Type</strong></td>
            <td><?php echo $customer;?> customers</td>
      </tr>

       <tr>
            <td><strong>Validity License</strong></td>
            <td> <?php echo $details->validity_license;?> month(s) </td>
            <td><strong>Job License</strong></td>
            <td><?php echo $details->job_license;?> job(s)</td>
      </tr>

       <tr>
            <td><strong>Original Price</strong></td>
            <td><?php echo $orig_price;?></td>
            <td><strong>Discounted %</strong></td>
            <td><?php echo $disc_percent." % ".number_format($less_amount,2);?></td>
      </tr>

       <tr>
            <td><strong>Discounted Price</strong></td>
            <td><?php echo $discounted_amount;?></td>
            <td><strong>VAT Included already</strong></td>
            <td><?php echo $is_vat_included_at_last_price;?></td>
      </tr>

       <tr>
            <td><strong>VAT Percentage</strong></td>
            <td><?php echo $vat_per;?></td>
            <td><strong>Amount of VAt</strong></td>
            <td><?php echo number_format($vat_amount,2);?></td>
      </tr>

        <tr>
            <td><strong>Gross</strong></td>
            <td><?php echo number_format($gross,2);?></td>
            <td><strong>Payment Status</strong></td>
            <td></td>
      </tr>

      <?php } ?>


      <?php } ?>

      </tbody>
    </table>
  </div>