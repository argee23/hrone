<?php if($action=='request_history'){ $i=0; if(empty($history)){ echo "<h2><center>No History Found.</center></h2>"; } else { foreach($history as $h){?>
  <div class="datagrid" style="padding-top: 10px;">
        <table>
          <thead>
              <tr>
                <th colspan="4">
                  <?php 
                    if($h->type=='free_trial')
                    { echo "Free Trial"; } else{ echo "Subscription"; }
                  ?>

                </th>
              </tr>
          </thead>
          <tbody>
           
              <?php 
                 if($h->type=='free_trial'){ ?>
              <tr>                    
                <td><strong> Validity</strong></td>
                <td><?php echo $h->free_trial_validity_license;?> Months</td>
                <td><strong>Job License</strong></td>
                <td><?php echo $h->free_trial_job_license;?> Jobs</td>
              </tr>   
               <?php  } else { ?>
              
               <tr>                    
                <td colspan="2"><strong><center>Subscription Details</center></strong></td>
                <td colspan="2"><strong><center>Requirements Details</center></strong></td>
                
              </tr>
              <tr>
                <?php 
                                      $package_details = $this->recruitment_employer_management_model->get_bill_setting('subscription',$company,$h->package_id);
                                      foreach($package_details as $bill_offers){
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
                                        }?>
                                      
                                      <?php echo '
                                       
                                        <td style="width:25%;text-align:center;">Validity<br>
                                        Job License<br>
                                        Orig Price<br>
                                        Discount %<br>
                                        Discounted Price<br>
                                        Vat Included already<br>
                                        Vat Percentage<br>
                                        Amount of Vat<br></td>

                                        <td style="width:25%;text-align:center;">'.$num_months.'months<br>
                                       '.$num_jobs.'<br>
                                        '.$orig_price.'<br>
                                       '.$less_amount.'<br>
                                        '.$discounted_amount.'<br>
                                       '.$is_vat_included_at_last_price.'<br>
                                       '.$vat_per.'<br>
                                        '.$vat_amount.'<br></td>'
                                        ;?>
                                   </div>
                  <?php }?>

                  <td colspan="2">
                     <?php
                                    $get_requirements = $this->recruitment_employer_management_model->get_req_history($company,$h->id);
                                    if(empty($get_requirements)){ echo "<n class='text-danger'>no requirements required</n>"; }
                                    else
                                    {?>
                                  <center>
                                  <?php 
                                      foreach($get_requirements as $row)
                                      {?>
                                          <?php 
                                            if(empty($row->file))
                                              { echo $row->title."<br>"; } else{?>
                                                  <a href="<?php echo base_url(); ?>recruitment_employer/recruitment_employer_management/download_requirement/<?php echo $row->file; ?>" title="Download File" ><?php echo $row->title."<br>";?></a>

                                              <?php  }
                                          ?>
                                      <?php }
                                    }
                                  ?>
                                  </center>
                  </td>
              </tr>
                <tr>
                  <td colspan="4"><br></td>
                </tr>
               <?php } ?>
           
            <tr class="alt"><td colspan="4" >
              <?php if(!empty($h->remarks)){ ?><n>Remarks: <?php echo $h->remarks;?></n> <?php }?>
              <n class="pull-right"><b><?php echo strtoupper($h->status);?>&nbsp;<?php if($h->status=='pending'){ echo "-&nbsp;<n class='text-danger'>(Waiting for Sert Tech Approval)</n>"; } else{ echo "(".$h->date_status_update.")"; } ?></b></n>  
            </td></tr>
          </tbody>
        </table>
  </div>

<?php } } } else{?>
   
     <?php $i=0; if(empty($history)){ echo "<h2><center>No History Found.</center></h2>"; } else {  foreach($history as $row) {?>

      <div class="datagrid">
        <table>
          <thead>
              <tr>
                <th colspan="4"><?php if($row->active_usage_type=='free_trial'){ echo "Free Trial"; } else{ echo "Subscription"; } ?></th>
              </tr>
          </thead>
          <tbody>
            <tr class="alt">
             <td colspan="2">
                <b><center> License Details </center></b>
              </td>
              <td colspan="2">
                <b> <center>Company Details</center></b>
              </td>
             

            </tr>

            <tr>
                <?php if($row->active_usage_type=='free_trial'){?>

                  <td colspan="2" style="text-align: center;width:50%;">
                    
                    Free Trial for  <u><?php echo $row->free_trial_months_can_post?>  Month (s)</u><br>
                    Can Post Job Up to  <u><?php echo $row->free_trial_jobs_can_post ?> Job (s)</u>

                    <br>

                    Original Validity -  <u><?php echo $row->original_date_end?></u><br>
                    Validity License -  <u><?php echo $row->date_end?></u><br>
                    Remarks -  <u><?php echo $row->remarks?> </u>

                  </td>
                 
                <?php }
                else{
                                     $usage_id = $row->package_id;
                                      $myactive_bill=$this->serttech_login_model->rec_bill($usage_id);  
                                      $myactive_bill=$this->serttech_login_model->rec_bill($usage_id);  

                                      $customer=$myactive_bill->customer_type;
                                      $num_months=$myactive_bill->no_of_months;
                                      $num_jobs=$myactive_bill->no_of_jobs;
                                      $orig_price=$myactive_bill->orig_price;
                                      $disc_percent=$myactive_bill->discount_percentage;

                                      $vat_per=$myactive_bill->vat_percentage;
                                      $is_vat_included_at_last_price=$myactive_bill->is_vat_included_at_last_price;

                                      $less_amount = ($disc_percent / 100) * $orig_price;
                                      $discounted_amount = $orig_price-$less_amount;
                                      $vat_amount= ($vat_per / 100) * $discounted_amount;

                                      if($is_vat_included_at_last_price=="no"){
                                        $my_gross=$discounted_amount+$vat_amount;
                                      }else{
                                        $my_gross=$discounted_amount;//-$vat_amount
                                      }
                                      $date = date('Y-m-d',strtotime($row->date_registered));
                                      $date_end = date('Y-m-d', strtotime('+'.$row->free_trial_months_can_post.' month', strtotime($date)));
                  ?>

                  <td>
                   
                      Subscription Date <br>
                      Validity<br>
                      Job License<br>
                      Orig Price:<br>
                      Discount %<br>
                      Discounted Price<br>
                      Vat Included already<br>
                      Vat Percentage<br>
                      Amount of Vat<br>
                      Gross<br>
                   
                  </td>
                  <td>
                     
                     <?php echo date('F d Y', strtotime($row->date_registered))." to ".date('F d Y', strtotime($date_end)).'<br>
                      '.$num_months.' month/s<br>
                      '.$num_jobs.'<br>
                      '.$orig_price.'<br>
                      '.$less_amount.'<br>
                      '.$discounted_amount.'<br>
                      '.$is_vat_included_at_last_price.'<br>
                      '.$vat_per.'<br>
                      '.$vat_amount.'<br>
                      '.$my_gross;?>
                   
                  </td>

                <?php } ?>  
                

                <td>
                    Industry <br>
                    Employees <br>
                    Company TIN  <br>
                    Contact Person<br>
                    Designation <br>
                    Website<br>
                    Telephone No.<br>
                    Mobile No.<br>
                     
                </td>
                
                 <td>
                 <?php $details_req = $this->serttech_recruitment_setting_model->view_details_employer_requirements('view_employer_details','view',$row->employer_id,'none');

                  foreach($details_req as $row1){?>
                    <?php echo $row1->cValue."<br>";?>
                    <?php echo $row1->employee_counts."<br>";?> Employees
                    <?php echo $row1->company_tin."<br>";?>
                    <?php echo $row1->contact_person."<br>";?>
                    <?php echo $row1->designation."<br>";?>
                    <?php echo $row1->company_website."<br>";?>
                    <?php echo $row1->tel_no."<br>";?>
                    <?php echo $row1->mobile_no."<br>";?>
                <?php } ?>   
                </td>



            </tr>
            <tr class="alt">
             <td colspan="4"> </td>
            </tr>

          </tbody>
        </table>
      </div>

<?php } } } ?>
</div>