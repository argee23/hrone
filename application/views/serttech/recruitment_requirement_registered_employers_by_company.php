
                   <table class="table table-user-information" id="by_company">
                      <thead>
                          <tr>
                              <th>Company Name</th>
                              <th>Details</th>
                              <th>Account Type</th>
                              <th>Account Status</th>
                              <th>Registration Date</th>
                              <th>End Date</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php $i=0; foreach($details as $row) {?>
                          <tr>
                              <td><?php echo $row->company_name;?></td>
                              <td>
                              <button data-toggle="collapse" data-target='#id<?php echo $i;?>' class="btn btn-sm">view employer details</button>
                                <div class="col-md-12 collapse" id="id<?php echo $i;?>">
                                  <?php $details_req = $this->serttech_recruitment_setting_model->view_details_employer_requirements('view_employer_details','view',$row->employer_id,'none');

                                foreach($details_req as $row1){?>
                              
                                <div class="col-md-12">Industry <br><strong><?php echo $row1->cValue;?></strong></div>
                                <div class="col-md-12">Employees  <br><strong><?php echo $row1->employee_counts;?> Employees</strong></div>
                                <div class="col-md-12">Company TIN  <br><strong><?php echo $row1->company_tin;?></strong></div>
                                <div class="col-md-12">Contact Person  <br><strong><?php echo $row1->contact_person;?></strong></div>
                                <div class="col-md-12">Designation  <br><strong><?php echo $row1->designation;?></strong></div>
                                <div class="col-md-12">Website  <br><strong><?php echo $row1->company_website;?></strong></div>
                                <div class="col-md-12">Telephone No.  <br><strong><?php echo $row1->tel_no;?></strong></div>
                                <div class="col-md-12">Mobile No.  <br><strong><?php echo $row1->mobile_no;?></strong></div>
                             
                             
                          <?php } ?>
                          </div>
                              
                              </td>
                              <td>
                              <?php if($row->active_usage_type=='free_trial')
                              {?>
                                <button data-toggle="collapse" data-target='#type<?php echo $i;?>' class="btn btn-sm">free trial</button>
                              <?php } else{?>
                                <button data-toggle="collapse" data-target='#type<?php echo $i;?>' class="btn btn-sm">view subscription</button>
                              <?php } ?>
                               <div class="col-md-12 collapse" id="type<?php echo $i;?>">
                                    <?php if($row->active_usage_type=='free_trial')
                                    {?>
                                      <div class="col-md-12"><strong>Free Trial for  <?php echo $row->free_trial_months_can_post?>  Month (s)<br></strong></div>
                                      <div class="col-md-12"><strong>Can Post Job Up to  <?php echo $row->free_trial_jobs_can_post ?> Job (s)</strong></div>
                                    <?php 
                                    }else{ 
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

                                    <div class="col-md-12 collapse" id="bill<?php echo $id;?>">
                                    <?php echo '
                                        Subscription Date: '.date('F d Y', strtotime($row->date_registered))." to ".date('F d Y', strtotime($date_end)).'<br>
                                        Validity: '.$num_months.'months<br>
                                        Job License: '.$num_jobs.'<br>
                                        Orig Price: '.$orig_price.'<br>
                                        Discount %: '.$less_amount.'<br>
                                        Discounted Price: '.$discounted_amount.'<br>
                                        Vat Included already: '.$is_vat_included_at_last_price.'<br>
                                        Vat Percentage: '.$vat_per.'<br>
                                        Amount of Vat: '.$vat_amount.'<br>
                                        Gross: '.$my_gross.''?>
                                   </div>
                                       
                                   <?php }?>
                                  
                                  
                                </div>
                              </td>
                              <td><?php if($row->is_usage_active=='1'){ echo "Active"; } else{ echo "Not Active"; } ?></td>
                              <td><?php echo $row->date_registered;?></td>
                              <td>
                              <?php 
                                  $date = date('Y-m-d',strtotime($row->date_registered));
                                  $date_end = date('Y-m-d', strtotime('+'.$row->free_trial_months_can_post.' month', strtotime($date)));
                              ?>
                              <?php echo $date_end;?>
                              </td>
                          </tr>
                      <?php $i++; } ?> 
                      </tbody>
                  </table>
