<div class="col-md-12" style="padding-top: 20px;">

    <div class="col-md-4">

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
              <button class="col-md-12 btn btn-success" onclick="get_job_management('<?php echo $type;?>');">FILTER</button>
            </div>
        </div>

    </div>

    <div class="col-md-8" id="registered_employees_table">
  <!--   <h4 class="text-danger"><center><u>Filtering Results</u></center></h4> -->
       <table id="<?php echo $type;?>" class="table table-bordered table-striped">
          <thead>
            <tr class="danger">
              <th>Employer</th>
              <th>Position</th>
              <th>Comment</th>
              <th>Status</th>
              <th>Date Send</th>
              <th>Status Date Update</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>

    </div>


</div>