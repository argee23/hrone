<div class="col-md-12" style="padding-top: 20px;">

    <div class="col-md-4">

         <div class="col-md-12">
          <div class="col-md-12">
            <div class="col-md-12"><label>Filtering Type</label></div>
             <div class="col-md-12">
                <select class="form-control" id="s_type" onchange="get_req_status(this.value);">
                  <option value="" disabled selected>Select</option>
                  <option value="view_not_viewed">view not yet viewed requirements</option>
                  <option value="view_new_uploaded">view new uploaded file</option>
                  <option value="view_requirements">view employer's requirements</option>
                  <option value="view_payment">view payment status</option>
                </select>
              </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="col-md-12">
             <div class="col-md-12"><label>Employer</label></div>
             <div class="col-md-12">
                 <select class="form-control" id="s_employer" disabled>
                    <?php  $companyList=$this->serttech_recruitment_setting_model->employers_job();  ?>
                        <option value="" disabled selected>Select Company</option>
                        <option value="all">All</option>
                        <?php if(empty($companyList)){ echo "<option value=''>No company found.</option>"; } else{
                                  foreach($companyList as $comp){?>
                                  <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                    <?php } }?>
                </select>
              </div>
          </div>
        </div>
        
        <div class="col-md-12" style="display: none;padding-top: 5px;" id="view_payment">
          <div class="col-md-12">
             <div class="col-md-12"><label>Payment Status</label></div>
             <div class="col-md-12">
              <select class="form-control" id="s_payment">
                    <option value="" disabled selected>Select</option>
                    <option value="all">All</option>
                    <option value="paid">Paid</option>
                    <option value="unpaid">Unpaid</option>
              </select>
              </div>
          </div>

           <div class="col-md-12">
             <div class="col-md-12"><label>Request License Status</label></div>
              <div class="col-md-12">
              <select class="form-control" id="s_license">
                    <option value="" disabled selected>Select</option>
                    <option value="all">All</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
              </select>
              </div>
          </div>

          <div class="col-md-12" style="padding-top:5px;">
              <div class="col-md-12"><label>Account Type</label></div>
               <div class="col-md-12">
                  <select class="form-control" id="ss_accounttype" onchange="re_get_subscription_type(this.value,'ss_subscriptiontype');">
                    <option selected disabled>Select</option>
                    <option value="all">All</option>
                    <option value="free_trial">Free Trial</option>
                    <option value="subscription">Subscription</option>
                  </select>
                </div>
            </div>
            

             <div class="col-md-12" style="padding-top:5px;"> 
              <div class="col-md-12"><label>Subscription Type</label></div>
               <div class="col-md-12">
                  <select class="form-control" id="ss_subscriptiontype">
                    <option disabled selected value="">Select</option>
                    <option value="all">All</option>
                    <?php  foreach($rec_employer_bill_setting_mng as $bill_offers){?>
                    <option value="<?php echo $bill_offers->id;?>"><?php echo $bill_offers->customer_type." customer ( ".$bill_offers->no_of_months." month/s validity with".$bill_offers->no_of_jobs." job license)";?></option>
                    <?php }?>
                  </select>
                </div>
            </div> 

            <div class="col-md-12">
             <div class="col-md-12"><label>Date Range (based on date send)</label></div>
             <div class="col-md-12"><input type="checkbox" onclick="re_get_dates('view_payment_','_view_not_viewed_from','_view_not_viewed_to');"><n class="text-danger"><input type="hidden" id="view_payment_" value="0"> All Dates</n></div>
              <div class="col-md-12">
                 <input type="date" class="form-control" id="_view_not_viewed_from">
              </div>
               <div class="col-md-12"  style="padding-top: 5px;">
                <input type="date" class="form-control"  id="_view_not_viewed_to">
              </div>
              
            </div>

        </div>

        <div class="col-md-12" style="display: none;padding-top: 5px;" id="view_not_viewed">
          <div class="col-md-12">
             <div class="col-md-12"><label>Date Range (based on date send)</label></div>
             <div class="col-md-12"><input type="checkbox" onclick="re_get_dates('view_not_viewed_','view_not_viewed_from','view_not_viewed_to');"><n class="text-danger"><input type="hidden" id="view_not_viewed_" value="0"> All Dates</n></div>
              <div class="col-md-12">
                 <input type="date" class="form-control" id="view_not_viewed_from">
              </div>
               <div class="col-md-12"  style="padding-top: 5px;">
                <input type="date" class="form-control"  id="view_not_viewed_to">
              </div>
              
          </div>
        </div>

        <div class="col-md-12" style="display: none;padding-top: 5px;" id="view_new_uploaded">
          <div class="col-md-12">
             <div class="col-md-12"><label>Date Range (based on date uploaded)</label></div>
              <div class="col-md-12"><input type="checkbox" onclick="re_get_dates('view_new_uploaded_','view_new_uploaded_from','view_new_uploaded_to');"><n class="text-danger"><input type="hidden" id="view_new_uploaded_" value="0"> All Dates</n></div>
              <div class="col-md-12">
                 <input type="date" class="form-control"  id="view_new_uploaded_from">
              </div>
               <div class="col-md-12"  style="padding-top: 5px;">
                <input type="date" class="form-control"  id="view_new_uploaded_to">
              </div>
              
          </div>
        </div>
       
        <div class="col-md-12" style="display: none;padding-top: 5px;" id="view_requirements">
             <div class="col-md-12" style="padding-top:5px;">
              <div class="col-md-12"><label>Account Type</label></div>
               <div class="col-md-12">
                  <select class="form-control" id="s_accounttype" onchange="re_get_subscription_type(this.value,'s_subscriptiontype');">
                    <option selected disabled>Select</option>
                    <option value="all">All</option>
                    <option value="free_trial">Free Trial</option>
                    <option value="subscription">Subscription</option>
                  </select>
                </div>
            </div>
            

             <div class="col-md-12" style="padding-top:5px;"> 
              <div class="col-md-12"><label>Subscription Type</label></div>
               <div class="col-md-12">
                  <select class="form-control" id="s_subscriptiontype">
                    <option disabled selected value="">Select</option>
                    <option value="all">All</option>
                    <?php  foreach($rec_employer_bill_setting_mng as $bill_offers){?>
                    <option value="<?php echo $bill_offers->id;?>"><?php echo $bill_offers->customer_type." customer ( ".$bill_offers->no_of_months." month/s validity with".$bill_offers->no_of_jobs." job license)";?></option>
                    <?php }?>
                  </select>
                </div>
            </div> 
           <!--   <div class="col-md-12" style="padding-top:5px;">
                <div class="col-md-12"><label>Payment Status</label></div>
                 <div class="col-md-12">
                    <select class="form-control" id="s_payment">
                      <option disabled selected value="">Select</option>
                      <option value="all">All</option>
                      <option value="approved">Paid</option>
                      <option value="cancelled">Unpaid</option>
                    </select>
                  </div>
              </div> -->

          <div class="col-md-12">
             <div class="col-md-12"><label>Requirement Status</label></div>
              <div class="col-md-12">
                <select class="form-control" id="s_status">
                  <option value="" disabled selected>Select</option>
                  <option value="all">All</option>
                  <option value="approved">approved</option>
                  <option value="pending">pending</option>
                </select>
              </div>
              
          </div>

          <div class="col-md-12" style="padding-top:5px;">
            <div class="col-md-12"><label>Date Range (based on Date Added)</label></div>
            <div class="col-md-12"><input type="checkbox" onclick="re_get_dates('view_requirements_to_','view_requirements_from','view_requirements_to');"><n class="text-danger"><input type="hidden" id="view_requirements_to_" value="0"> All Dates</n></div>
             <div class="col-md-12">
               <input type="date" class="form-control" id="view_requirements_from">
              </div>
               <div class="col-md-12" style="padding-top: 5px;">
               <input type="date" class="form-control" id="view_requirements_to">
              </div>
          </div>

        </div>


        <div class="col-md-12">
          <div class="col-md-12">
           <div class="col-md-12">
           <br>
              <button class="col-md-12 btn btn-success" onclick="get_requirement_status('<?php echo $type;?>');">FILTER</button>
            </div>
            </div>
        </div>

    </div>

    <div class="col-md-8" id="req_status_table" style="overflow: scroll;">
  <!--   <h4 class="text-danger"><center><u>Filtering Results</u></center></h4> -->
       <table id="<?php echo $type;?>" class="table table-bordered table-striped">
          <thead>
            <tr class="danger">
              <th>Employer</th>
              <th>Account Type</th>
              <th>Account Status</th>
              <th>Requirements</th>
              <th>Requirements Status</th>
              <th>Date Approved</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>

    </div>


</div>