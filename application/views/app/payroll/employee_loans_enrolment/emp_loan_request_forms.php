<div style="margin-top: 5px;margin-bottom: 20px;">

<ol class="breadcrumb">
  <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>
  FILTERING OF EMPLOYEE REQUEST LOAN FORMS
    <button type="button" class="btn btn-warning pull-right btn-xs" style="margin-left: 3px;margin-right: 3px;" onclick="emp_loan_request_forms();">
      <i class="fa fa-arrow-left"></i> Back
    </button>

  </h4>
</ol>

</div>
<div id="fetch_actions">
          <div class="col-md-12" style="margin-bottom: 10px;">
              <div class="col-md-6">
               
                <div class="col-md-12">
                  <select class="form-control" id="company_filter" onchange="get_company_loan_type(this.value);">
                  <option value='all' selected disabled>Select Company </option>
                    <?php
                      foreach($companyList as $company)
                      {
                        echo "<option value='".$company->company_id."'>".$company->company_name."</option>";
                      } 

                    ?>
                  </select>
                </div>

              </div>
              <div class="col-md-6">
               
                <div class="col-md-12">
                  <select class="form-control" id="loan_filter" onchange="filter_forms();">
                      <option value='all' selected disabled>Select Company Loan Type </option>
                  </select>
                </div>
              </div>

              <div class="col-md-6" style="padding-top: 10px;">
                <div class="col-md-12">
                  <select class="form-control" id="status_filter" onchange="check_status(this.value);">
                       <option value='all' selected disabled>Select Form Status </option>
                       <option value='all'>All</option>
                       <option value='pending'>Pending</option>
                       <option value='approved'>Approved</option>
                       <option value='cancelled'>Cancelled</option>
                  </select>
                </div>
              </div>

              <div class="col-md-6" style="padding-top: 10px;">
                <div class="col-md-12">
                  <select class="form-control" disabled id="approved_filter" onchange="filter_forms();">
                       <option value="all" selected>All(For Approved Form Status Only)</option>
                       <option value='added'>Added In employee Loans</option>
                       <option value='not_yet_added'>Not Yet Added</option>
                  </select>
                </div>
              </div>

          </div>

          <br><br><br><br><br><br>
          <div class="box box-danger" class='col-md-12'></div>

          <div id="status" style="margin: 0px 10px 0px 10px">

          <table id="employee_loan_list" class="table table-hover table-striped">
                <thead>
                  <tr class="danger">
                    <th>Doc Number</th>
                    <th>Employee Name</th>
                    <th>Date Created</th>
                    <th>Loan Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
          </table>

       </div>
</div>

