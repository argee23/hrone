<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i> Lock Plotting per Payroll Period Management </h4></ol>

<div class="col-md-12">
    <div class="col-md-6">
        <div class="col-md-4"><label><u>Company</u></label></div>
        <div class="col-md-8">
            <select class="form-control" onchange="get_payroll_period(this.value,'none');" id="lock_company">
                <option value="none">Select Company</option>
                <?php foreach($companyList as $company) { ?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-5">
        <div class="col-md-4"><label><u>Group Name</u></label></div>
        <div class="col-md-8">
          <select class="form-control" id="pp_group" disabled  onchange="get_payroll_period('company',this.value);">
            <option value='none' selected disabled>Select Group</option>
          </select>
        </div>
    </div><br><br><br>
    <div class="box box-default" class='col-md-12'></div>
</div>
  
<div class="col-md-12" style="padding-top:10px;" id='lock_pp'>
         
      <table class="table table-bordered" id="table_lockplotting">
          <thead>
           <tr  class="success">
              <th style="width:5%;"></th>
              <th style="width:20%;">Group Name</th>
              <th style="width:15%;">Paycode</th>
              <th style="width:10%;">Cutoff</th>
              <th style="width:15%;">From</th>
              <th style="width:15%;">To</th>
              <th style="width:10%;">No. of Days</th>
              <th style="width:5%;">Locked</th>
              <th style="width:5%;">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
      </table>
</div>              