  <br>
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
                            <div class="col-md-12"><label>Crystal Report:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='crystal_report'>
                                    </select>
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Training Type:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='training_type'>
                                        <option value="all">All</option>
                                        <option value="seminar">Seminars</option>
                                        <option value="training">Trainings</option>
                                    </select>
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Sub Type:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='sub_type'>
                                        <option value="all">All</option>
                                        <option value="internal">Internal</option>
                                        <option value="external">External</option>
                                    </select>
                           </div>
                    </div>


                    <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Conducted By Type:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='conducted_by_type'>
                                        <option value="all">All</option>
                                        <option value="internal">Internal</option>
                                        <option value="external">External</option>
                                    </select>
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Fee Type:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='fee_type' onchange="fee_type_choice(this.value);">
                                        <option value="all">All</option>
                                        <option value="company">Company</option>
                                        <option value="employee">Employee</option>
                                    </select>
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;display: none;" id="if_company_shouldered">
                            <div class="col-md-12"><label>Company Shouldered Fee:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='company_shouldered_fee' onchange="fee_type_required(this.value);">
                                        <option value="all">All</option>  
                                        <option value="with">View all employees with required length of service to be totally shouldered by the company</option>
                                        <option value="without">View all employees without required length of service to be totally shouldered by the company</option>
                                    </select>
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;display:none;" id="if_required_length">
                            <div class="col-md-12"><label>With Required length of service:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='with_required_service_length' >
                                        <option value="all">All</option>
                                        <option value="ymeet">View all employees who meets the required length of service</option>
                                        <option value="nmeet">View all employees who does not meet yet the required length of service</option>
                                    </select>
                           </div>
                    </div>


                    <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Payment Status:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='payment_status'>
                                        <option value="all">All</option>
                                        <option value="paid">Paid</option>
                                        <option value="partial">Partial</option>
                                    </select>
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Others:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='others' onchange="others_view(this.value);">
                                        <option value="all">All</option>
                                        <option value="during">Attended during employment period</option>
                                        <option value="before">Attended Before Employed</option>
                                        <option value="upcoming">Upcoming Trainings and Seminars</option>
                                    </select>
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;" id="dd_daterange">
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
                                      <option value="" disabled selected>Select</option>
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