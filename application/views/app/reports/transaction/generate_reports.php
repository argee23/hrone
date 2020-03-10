
            <div class="col-md-3">
                      
                     <div class="col-md-12" style="padding-top:10px;">
                          <div class="col-md-12"><label>Type:</label></div>
                            <div class="col-md-12">
                                  <select class="form-control" id='gtype' onchange="g_filtertype(this.value);">
                                      <option value="" selected disabled>Select</option>
                                      <option value="default">System Default</option>
                                      <option value="user">User Default</option>
                                  </select>
                         </div>
                    </div>

                     <div class="col-md-12" style="padding-top:10px;">
                          <div class="col-md-12"><label>Company:</label></div>
                            <div class="col-md-12">
                                  <select class="form-control" id='gcompany' onchange="g_filter_company(this.value);">
                                  <option value="" selected disabled>Select</option>
                                  <?php foreach($companyList as $c){?>
                                     <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                                  <?php } ?>
                                  </select>
                         </div>
                    </div>

                    <div class="col-md-12">
                          <div class="col-md-12"><label>Transaction</label></div>
                            <div class="col-md-12">
                                  <select class="form-control" id='gtransaction' onchange="g_company_details(this.value);">
                                  </select>
                         </div>
                    </div>

                    <div class="col-md-12" id="filter_company"  style="padding-top:10px;">
                            <div class="col-md-12"><label>Crystal Report:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='gcrystalreport'>
                                    </select>
                              </div>
                    </div>
                  
                    <div class="col-md-12" style="padding-top:10px;">
                          <div class="col-md-12"><label>Employees:</label></div>
                            <div class="col-md-12">
                                  <select class="form-control" id='gemployees' onchange="g_employees(this.value);">
                                      <option value="" selected disabled>Select</option>
                                      <option value="one">Employee</option>
                                      <option value="all">All</option>
                                  </select>
                         </div>
                    </div>
                     <div class="col-md-12" style="padding-top:10px;display: none;" id="fg_employee">
                          <div class="col-md-12"><label>Employee Name:</label></div>
                            <div class="col-md-12">
                                  <a data-toggle="modal" data-target="#search_employee_modal"><input type="text" class="form-control" id="gemployeename"></a>
                                  <input type="hidden" id="gemployeeid">
                         </div>
                    </div>
                    <div class="col-md-12" style="padding-top:10px;">
                          <div class="col-md-12"><label>Filter Type:</label></div>
                            <div class="col-md-12">
                                  <select class="form-control" id='gfiltertype' onchange="get_filtertype_option(this.value);">
                                  </select>
                         </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;display: none;" id="fg_daterange">
                            <div class="col-md-12"><label>Date Range</label></div>
                            <div class="col-md-12"><input type="checkbox" onclick="disabled_date();">&nbsp;All</div>
                              <div class="col-md-12">
                                    <input type="hidden" id="date_range" value='0'>
                                    <input type="date" id="date_from" class="form-control"><br>
                                    <input type="date" id="date_to" class="form-control">
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;display: none;" id="fg_payrollperiod">
                           <div class="col-md-12"><label>Payroll Period:</label></div>
                            <div class="col-md-12">
                                  <select class="form-control" id='gpayrollperiod'>
                                  </select>
                         </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;">
                          <div class="col-md-12"><label>Status:</label></div>
                            <div class="col-md-12">
                                  <select class="form-control" id='gstatus'>
                                      <option value="" selected disabled>Select</option>
                                      <option value="all">All</option>
                                      <option value="approved">Approved</option>
                                      <option value="pending">Pending</option>
                                      <option value="cancelled">Cancelled</option>
                                      <option value="rejected">Rejected</option>
                                  </select>
                         </div>
                    </div>

                   

                    <div class="col-md-12" style="padding-top:10px;display: none;" id="fg_division">
                          <div class="col-md-12"><label>Division:</label></div>
                            <div class="col-md-12">
                                  <select class="form-control" id='gdivision' onchange="g_get_department(this.value);">
                                  </select>
                         </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;display: none;" id="fg_department">
                          <div class="col-md-12"><label>Department:</label></div>
                            <div class="col-md-12">
                                  <select class="form-control" id='gdepartment' onchange="g_get_section(this.value);">
                                  </select>
                         </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;display: none;" id="fg_section">
                          <div class="col-md-12"><label>Section:</label></div>
                            <div class="col-md-12">
                                 <select class="form-control" id='gsection' onchange="g_get_subsection(this.value);">
                                  </select>
                         </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;display: none;" id="fg_subsection">
                          <div class="col-md-12"><label>SubSection:</label></div>
                            <div class="col-md-12">
                                  <select class="form-control" id='gsubsection'>
                                  </select>
                            </div>
                    </div>
                   <div class="col-md-12" style="padding-top:10px;display: none;" id="fg_location" >
                          <div class="col-md-12"><label>Location:</label></div>
                            <div class="col-md-12" id="glocation">
                         </div>
                    </div>

                       <div class="col-md-12" style="padding-top:10px;display: none;" id="fg_classification">
                          <div class="col-md-12"><label>Classification:</label></div>
                            <div class="col-md-12" id="gclassification">
                                  
                         </div>
                    </div>

                   <div class="col-md-12" style="padding-top:10px;display: none;" id="fg_employment">
                          <div class="col-md-12"><label>Employment:</label></div>
                          <div class="col-md-12">

                            <?php $i=0; foreach($employmentList as $e){?>
                                <div class="col-md-12">
                                  <di class="col-md-12"><n class="text-danger"><input type="checkbox" id="employment<?php echo $i;?>" value="<?php echo $e->employment_id;?>" 
                                  class="class_employment" checked><?php echo $e->employment_name;?></n></di>
                                </div>
                            <?php $i++; } echo "<input type='hidden' value='".$i."' id='countemployment'> ";  ?>
                          </div>
                    </div>
                    <div class="col-md-12" style="padding-top:10px;">
                         <div class="col-md-12">
                              <button class="col-md-12 btn btn-success" onclick="generate_filter_reports();">GENERATE REPORTS</button>    
                         </div>
                    </div>

            </div>

            <div class="col-md-9" id="crystal_report_action" style="overflow: scroll;">
                <table class="col-md-12 table table-hover" id="generate_report">
                  <thead>
                    <tr class="danger">
                      <th>No.</th>
                      <th>Company</th>
                      <th>Transaction</th>
                      <th>Employee ID</th>
                      <th>Doc No</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>

            </div>
    </div>

    
  <!---END LIST-->
 