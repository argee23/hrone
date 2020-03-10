<br>
  <ol class="breadcrumb">
    <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Generate Reports | 
    <?php if($code=='CRRS1'){ echo "Serttech Settings"; } elseif($code=='CRRS2') { echo "Registered Employers"; }
    else if($code=='CRRS4'){ echo "Requirement Status"; } else{ echo "Payment Status"; }?>
    </h4>
  </ol>

  <div class="col-md-12" id="action_here_div">

  <?php if($code=='CRRS1'){?>
  <div class="col-md-3"></div>
  <div class="col-md-6">

      <select class="col-md-12 form-control" id="code" name="code" onchange="get_crystal_report('<?php echo $code;?>',this.value)">
        <option value="" disabled selected>Select Setting</option>
        <?php foreach($setting as $s){?>
           <option value="<?php echo $s->code;?>"><?php echo $s->policy_title;?></option>
        <?php } ?>
           <option value="single_field">SINGLE FIELD SETTINGS (all settings with single field)</option>
           <option value="setting_list">SERTTECH SETTINGS (list of sert tech settings)</option>
           <option value="default_setting">DEFAULT SERTTECH SETTINGS (list of default sert tech settings)</option>
           <option value="not_default_setting">ADDITIONAL SERTTECH SETTINGS (list of additional (not default)  sert tech settings)</option>
      </select>

      <select class="col-md-12 form-control" id="crystal_report" name="crystal_report" style="margin-top: 5px;">
          <option value="" disabled selected>Select Crystal Report</option>
      </select>

      <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="generate_report_settings_results('<?php echo $code;?>');">GENERATE REPORT</button>
  </div>
  <div class="col-md-3"></div>




  <?php }
  else if($code=='CRRS2'){?>

      <div class="col-md-3"></div>
       <div class="col-md-6">

       <div class="col-md-12" style="padding-top:5px;">
          <div class="col-md-12"><label>Crystal Report</label></div>
           <div class="col-md-12">
              <select class="form-control" id="crystal_report" name="crystal_report">
                <option selected disabled>Select Crystal Report</option>
                <option value="default">Default</option>
                <?php foreach($crystal_report as $c){?>
                    <option value="<?php echo $c->id;?>"><?php echo $c->title;?></option>
                <?php } ?>
              </select>
            </div>
        </div>

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
              <button class="col-md-12 btn btn-success" onclick="get_employers_registered('<?php echo $code;?>');">FILTER</button>
            </div>
        </div>
      <div class="col-md-3"></div>
    </div>
  <?php }
  else if($code=='CRRS3'){?>

      <div class="col-md-3"></div>
      <div class="col-md-6">
            <div class="col-md-12" style="padding-top:5px;">
              <div class="col-md-12"><label>Crystal Report</label></div>
               <div class="col-md-12">
                  <select class="form-control" id="crystal_report" name="crystal_report">
                    <option selected disabled>Select Crystal Report</option>
                    <option value="default">Default</option>
                    <?php foreach($crystal_report as $c){?>
                        <option value="<?php echo $c->id;?>"><?php echo $c->title;?></option>
                    <?php } ?>
                  </select>
                </div>
            </div>

           <div class="col-md-12">
            <div class="col-md-12"><label>Employers</label></div>
             <div class="col-md-12">
                <select class="form-control" id="j_employer">
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
            <div class="col-md-12"><label>Account Status</label></div>
             <div class="col-md-12">
                <select class="form-control" id="j_accountstatus">
                  <option disabled selected value="">Select</option>
                  <option value="all">All</option>
                   <option value="waiting">Pending</option>
                  <option value="1">Approved</option>
                  <option value="cancelled">Cancelled</option>
                  <option value="rejected">Rejected</option>
                </select>
              </div>
          </div>
          
          <div class="col-md-12" style="padding-top:5px;">
            <div class="col-md-12"><label>Date Range  (Send)</label></div>
            <div class="col-md-12"><input type="checkbox" onclick="re_get_dates('registered_','re_registeredfrom','re_registeredto');"><n class="text-danger"><input type="hidden" id="registered_" value="0"> All Dates</n></div>
             <div class="col-md-6">
               <input type="date" class="form-control" id="re_registeredfrom">
              </div>
               <div class="col-md-6">
               <input type="date" class="form-control" id="re_registeredto">
              </div>
          </div>

          <div class="col-md-12" style="padding-top:5px;">
            <div class="col-md-12"><label>Date Range (Update Status)</label></div>
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
                <button class="col-md-12 btn btn-success" onclick="get_job_management('<?php echo $code;?>');">FILTER</button>
              </div>
          </div>
      </div>
      <div class="col-md-3"></div>
  <?php }
  else if($code=='CRRS4'){?>

      <div class="col-md-3"></div>
      <div class="col-md-6">

            <div class="col-md-12" style="padding-top:5px;">
              <div class="col-md-12"><label>Crystal Report</label></div>
               <div class="col-md-12">
                  <select class="form-control" id="crystal_report" name="crystal_report">
                    <option selected disabled>Select Crystal Report</option>
                    <option value="default">Default</option>
                    <?php foreach($crystal_report as $c){?>
                        <option value="<?php echo $c->id;?>"><?php echo $c->title;?></option>
                    <?php } ?>
                  </select>
                </div>
            </div>

            <div class="col-md-12">
              <div class="col-md-12"><label>Employer</label></div>
               <div class="col-md-12">
                   <select class="form-control" id="s_employer">
                      <?php  $companyList=$this->serttech_recruitment_setting_model->employers_job();?>
                          <option value="" disabled selected>Select Company</option>
                          <option value="all">All</option>
                          <?php if(empty($companyList)){ echo "<option value=''>No company found.</option>"; } else{
                                    foreach($companyList as $comp){?>
                                    <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                      <?php } }?>
                  </select>
              </div>
            </div>

            <div class="col-md-12" style="margin-top: 10px;">
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

            <div class="col-md-12" style="margin-top: 10px;display: none;">
              <div class="col-md-12"><label>Subscription Type</label></div>
              <div class="col-md-12">
                    <select class="form-control" id="ss_subscriptiontype">
                      <option value="all">All</option>
                     
                    </select>
              </div>
            </div>

            <div class="col-md-12" style="margin-top: 10px;">
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

            <div class="col-md-12" style="margin-top: 10px;">
              <div class="col-md-12"><label>Date Range (based on date send)</label></div>
              <div class="col-md-12"><input type="checkbox" onclick="re_get_dates('daterangevalue','date_rangefrom','date_rangeto');"><n class="text-danger"><input type="hidden" id="daterangevalue" value="0"> All Dates</n></div>
                 <div class="col-md-6">
                   <input type="date" class="form-control" id="date_rangefrom">
                  </div>
                  <div class="col-md-6">
                   <input type="date" class="form-control" id="date_rangeto">
                  </div>
              </div>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
            <div class="col-md-12">
              <div class="col-md-3"></div>
              <div class="col-md-6">
                <div class="col-md-12"><button class="col-md-12 btn btn-success" onclick="get_requirement_status('<?php echo $code;?>');">FILTER</button></div>
              </div>
              <div class="col-md-3"></div>
            </div>
            </div>

      </div>
      <div class="col-md-3"></div>

  <?php } else if($code=='CRRS5'){?>

      <div class="col-md-3"></div>
      <div class="col-md-6">

            <div class="col-md-12" style="padding-top:5px;">
              <div class="col-md-12"><label>Crystal Report</label></div>
               <div class="col-md-12">
                  <select class="form-control" id="crystal_report" name="crystal_report">
                    <option selected disabled>Select Crystal Report</option>
                    <option value="default">Default</option>
                    <?php foreach($crystal_report as $c){?>
                        <option value="<?php echo $c->id;?>"><?php echo $c->title;?></option>
                    <?php } ?>
                  </select>
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 10px;">
              <div class="col-md-12"><label>Employer</label></div>
               <div class="col-md-12">
                   <select class="form-control" id="s_employer">
                      <?php  $companyList=$this->serttech_recruitment_setting_model->employers_job();?>
                          <option value="" disabled selected>Select Company</option>
                          <option value="all">All</option>
                          <?php if(empty($companyList)){ echo "<option value=''>No company found.</option>"; } else{
                                    foreach($companyList as $comp){?>
                                    <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                      <?php } }?>
                  </select>
              </div>
            </div>

            <div class="col-md-12" style="margin-top: 10px;">
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

            <div class="col-md-12" style="margin-top: 10px;">
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

            <div class="col-md-12" style="margin-top: 10px;">
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

            <div class="col-md-12" style="margin-top: 10px;">
              <div class="col-md-12"><label>Date Range (based on date send)</label></div>
              <div class="col-md-12"><input type="checkbox" onclick="re_get_dates('daterangevalue','date_rangefrom','date_rangeto');"><n class="text-danger"><input type="hidden" id="daterangevalue" value="0"> All Dates</n></div>
                 <div class="col-md-6">
                   <input type="date" class="form-control" id="date_rangefrom">
                  </div>
                  <div class="col-md-6">
                   <input type="date" class="form-control" id="date_rangeto">
                  </div>
              </div>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
            <div class="col-md-12">
              <div class="col-md-3"></div>
              <div class="col-md-6">
                <div class="col-md-12"><button class="col-md-12 btn btn-success" onclick="get_payment_status('<?php echo $code;?>');">FILTER</button></div>
              </div>
              <div class="col-md-3"></div>
            </div>
            </div>

      </div>
      <div class="col-md-3"></div>

  <?php }
  else{}?>


  <br><br><br><br><br><br><br><br>
  <!-- <div class="box box-default" class='col-md-12'></div> -->
    <div class="col-md-12" id="generate_reports" style="overflow:scroll;">
    </div>
  </div>