<div class="col-md-12" style="padding-top: 20px;">

    <div class="col-md-4">

        <div class="col-md-12">
          <div class="col-md-12"><label>Employers</label></div>
           <div class="col-md-12">
              <select class="form-control" id="re_employer">
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

         <div class="col-md-12" style="padding-top:5px;">
          <div class="col-md-12"><label>Account Type</label></div>
           <div class="col-md-12">
              <select class="form-control" id="re_accounttype" onchange="re_get_subscription_type(this.value,'re_subscriptiontype');">
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
              <select class="form-control" id="re_subscriptiontype">
                <option disabled selected value="">Select</option>
                <option value="all">All</option>
                <?php  foreach($rec_employer_bill_setting_mng as $bill_offers){?>
                <option value="<?php echo $bill_offers->id;?>"><?php echo $bill_offers->customer_type." customer ( ".$bill_offers->no_of_months." month/s validity with".$bill_offers->no_of_jobs." job license)";?></option>
                <?php }?>
              </select>
            </div>
        </div> 

         <div class="col-md-12" style="padding-top:5px;">
          <div class="col-md-12"><label>Account Status</label></div>
           <div class="col-md-12">
              <select class="form-control" id="re_accountstatus">
                <option disabled selected value="">Select</option>
                <option value="all">All</option>
                <option value="1">Active</option>
                <option value="0">Expired</option>
              </select>
            </div>
        </div>

         <div class="col-md-12" style="padding-top:5px;">
          <div class="col-md-12"><label>Registered Date Range</label></div>
          <div class="col-md-12"><input type="checkbox" onclick="re_get_dates('registered_','re_registeredfrom','re_registeredto');"><n class="text-danger"><input type="hidden" id="registered_" value="0"> All Dates</n></div>
           <div class="col-md-6">
             <input type="date" class="form-control" id="re_registeredfrom">
            </div>
             <div class="col-md-6">
             <input type="date" class="form-control" id="re_registeredto">
            </div>
        </div>

        <div class="col-md-12" style="padding-top:5px;">
          <div class="col-md-12"><label>End Date Range</label></div>
          <div class="col-md-12"><input type="checkbox" onclick="re_get_dates('end_','re_endfrom','re_endto');"><n class="text-danger"><input type="hidden" id="end_" value="0"> All Dates</n></div>
           <div class="col-md-6">
             <input type="date" class="form-control" id="re_endfrom">
            </div>
             <div class="col-md-6">
             <input type="date" class="form-control" id="re_endto">
            </div>
        </div>
          <div class="col-md-12">
           <div class="col-md-12" >
           <br>
              <button class="col-md-12 btn btn-success" onclick="get_employers_registered('<?php echo $type;?>');">FILTER</button>
            </div>
        </div>

    </div>

    <div class="col-md-8" id="registered_employees_table">
  <!--   <h4 class="text-danger"><center><u>Filtering Results</u></center></h4> -->
       <table id="<?php echo $type;?>" class="table table-bordered table-striped">
          <thead>
            <tr class="danger">
              <th>Employer</th>
              <th>Account Type</th>
              <th>Account Status</th>
              <th>Registration Date</th>
              <th>End Date</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>

    </div>


</div>