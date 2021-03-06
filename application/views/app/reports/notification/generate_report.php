  <div class="col-md-3">
  <div class="col-md-12">

                  <div class="col-md-12"><label>Company:</label></div>
                                <div class="col-md-12">
                                      <select class="form-control" id='company' onchange="get_notifications_filter(this.value);">
                                      <option value="" disabled selected>Select</option>
                                      <?php foreach($companyList as $company)
                                      {?>
                                        <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
                                      <?php } ?>
                                      </select>
                                </div>
                    </div>

                     <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Notifications:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='notification' onchange="get_crystal_reports_generate(this.value);">
                                    </select>
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Crystal Report:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='crystal_report'>
                                    </select>
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Status</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='status' onchange="check_status_filter(this.value,'status_view')">
                                        <option value="all">All</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                           </div>
                    </div>
                    
                    <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Status View</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='status_view'>
                                        <option value="all">all</option>
                                        <option value="v">viewed</option>
                                        <option value="a">acknowledge</option>
                                        <option value="nv">not yet viewed</option>
                                        <option value="na">not yet acknowledge</option>

                                    </select>
                           </div>
                    </div>
                    <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Date Range</label></div>
                            <div class="col-md-12"><input type="checkbox" onclick="disabled_date();">&nbsp;All</div>
                              <div class="col-md-12">
                                    <input type="hidden" id="date_range" value='0'>
                                    <input type="date" id="date_from" class="form-control"><br>
                                    <input type="date" id="date_to" class="form-control">
                           </div>
                    </div>
                      <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Employees</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='employee' onchange="check_employee_filter(this.value);">
                                      <option value="one">By employee</option>
                                      <option value="all">All Employees</option>
                                    </select>
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;" id="one_employee">
                            <div class="col-md-12"><label>Employee Name</label></div>
                              <div class="col-md-12">
                                  <a data-toggle="modal" data-target="#search_employee_modal"><input type="text" class="form-control" id="employee_name"></a>
                                  <input type="hidden" id="employee_id">
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;display: none;" id="sdepartment" >
                            <div class="col-md-12"><label>Department</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='department' onchange="get_section(this.value);">
                                    </select>
                           </div>
                    </div>

                      <div class="col-md-12" style="padding-top:10px;display: none;" id="ssection">
                            <div class="col-md-12"><label>Section</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='section' onchange="get_subsection(this.value);">
                                    </select>
                           </div>
                    </div>

                      <div class="col-md-12" style="padding-top:10px;display: none;" id="ssubsection">
                            <div class="col-md-12"><label>Subsection</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='subsection'>
                                    </select>
                           </div>
                    </div>

                      <div class="col-md-12" style="padding-top:10px;display: none;" id="slocation">
                            <div class="col-md-12"><label>Location</label></div>
                              <div class="col-md-12" id="location">
                                    
                            </div>
                    </div>

                      <div class="col-md-12" style="padding-top:10px;display: none;" id="sclassification">
                            <div class="col-md-12"><label>Classification</label></div>
                              <div class="col-md-12" id="classification">
                                    
                           </div>
                    </div>

                      <div class="col-md-12" style="padding-top:10px;display: none;" id="semployment">
                            <div class="col-md-12"><label>Employment</label></div>
                              <div class="col-md-12" id="employment">
                                   
                           </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px;">
                      <div class="col-md-12"><button class="bt btn-success form-control" onclick="filter_report();">FILTER</button></div>
                    </div>
          </div>

<div class="col-md-9" id="crystal_report_action" style="overflow: scroll;">
    <table class="col-md-12 table table-hover" id="crystal_reports">
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