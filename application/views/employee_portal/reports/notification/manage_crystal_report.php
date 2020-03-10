<div class="col-md-12">
  <h4 class="text-danger"><center>Manage Crystal Report</center></h4>

   <div class="col-md-12">
          <div class='col-md-6'>
            <div class="col-md-4"><label>Company:</label></div>
              <div class="col-md-8">
                    <select class="form-control" id='fcompany' onchange="get_notifications(this.value);">
                    <option value="" disabled selected>Select</option>
                    <?php foreach($companyList as $company)
                    {?>
                      <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
                    <?php } ?>
                    </select>
              </div>
          </div>

           <div class='col-md-6'>
            <div class="col-md-4"><label>Notifications:</label></div>
              <div class="col-md-8">
                    <select class="form-control" id='fnotification' onchange="get_crystal_reports('view',this.value);">
                    </select>
              </div>
          </div>
  </div>
  <br><br>
  <div class="box box-default" class='col-md-12'></div>
      <div class="col-md-12" id="crystal_report_action">
        
        <table class="col-md-12 table table-hover" id="crystal_report">
          <thead>
            <tr class="danger">
              <th>No.</th>
              <th>Report ID</th>
              <th>Report Name</th>
              <th>Report Description</th>
              <th>Fields</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>

      </div>
</div>