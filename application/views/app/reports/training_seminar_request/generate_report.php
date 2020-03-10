  <br>
  <div class="col-md-3">
  <div class="col-md-12">

      <div id="filtering1">
          <div class="col-md-12"><label>Report Option:</label></div>
              <div class="col-md-12">
                <select class="form-control" id='report_option' onchange="f_report_option(this.value);">
                      <option value="">Select</option>
                      <option value="training_seminar">Trainings and Seminars</option>
                      <option value="training_seminar_attendees">Trainings and Seminars Attendees</option>
                </select>
              </div>
      </div>
      
      
      <div id="filtering2">
          <div class="col-md-12"><label>Company</label></div>
              <div class="col-md-12">
                 <select class="form-control" id='company' onchange="f_get_crystal_report(this.value);">
                    <option value="" disabled selected>Select</option>
                    <?php foreach($companyList as $company)
                    {?>
                        <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
                    <?php } ?>
                  </select>
          </div>

          <div class="col-md-12"><label>Crystal Report</label></div>
              <div class="col-md-12">
                 <select class="form-control" id='crystal_report' onchange="get_notifications_filter(this.value);" disabled>
                    <option value="">Select Crystal Report</option>
                  </select>
              </div>


      </div>


      <div id="if_training_seminar">

          <div class="col-md-12"><label>Training Date</label></div>
          <div class="col-md-12">
                 <select class="form-control" id='training_date' onchange="f_training_date(this.value);">
                    <option value="All">All</option>
                    <option value="date_range" selected>Date Range</option>
                 </select>
          </div>

          <div class="col-md-12" id='dfrom'><label>Training Date From</label></div>
          <div class="col-md-12" id='ddfrom'>
              <input type="date" class="form-control" id="trainingfrom" onchange="get_all_training('date_range');">
          </div>

          <div class="col-md-12" id='dto'><label>Training Date To</label></div>
          <div class="col-md-12" id='ddto'>
               <input type="date" class="form-control" id="trainingto" onchange="get_all_training('date_range');">  
          </div>

          <div class="col-md-12"><label>Training Title</label></div>
          <div class="col-md-12">
                 <select class="form-control" id='training_title' onchange="f_get_training_filter(this.value);" disabled>
                    <option value="">Select Training and Seminars</option>
                    <option value="All">All</option>
                 </select>
          </div>

      </div>  

      <div id="filtering_all_trainingattendees" style="display: none;">

          <div class="col-md-12"><label>Employee Respond</label></div>
          <div class="col-md-12">
                 <select class="form-control" id='employeerespond'>
                    <option value="All">All</option>
                    <option value="1">Accept</option>
                    <option value="0">Decline</option>
                    <option value="none">No Response</option>
                 </select>
          </div>
      </div>


      <div id="filtering_all_training" style="display: none;">

          <div class="col-md-12"><label>Training Type</label></div>
          <div class="col-md-12">
                 <select class="form-control" id='training_type'>
                    <option value="All">All</option>
                    <option value="training">Training</option>
                    <option value="seminar">Seminar</option>
                 </select>
          </div>

          <div class="col-md-12"><label>Sub Type</label></div>
          <div class="col-md-12">
                 <select class="form-control" id='sub_type'>
                    <option value="All">All</option>
                    <option value="internal">Internal</option>
                    <option value="external">External</option>
                  </select>
          </div>

          <div class="col-md-12"><label>Conducted By Type</label></div>
          <div class="col-md-12">
                 <select class="form-control" id='conducted_by_type'>
                    <option value="All">All</option>
                    <option value="internal">Internal</option>
                    <option value="external">External</option>
                 </select>
          </div>

          <div class="col-md-12"><label>Fee Type</label></div>
          <div class="col-md-12">
                 <select class="form-control" id='fee_type'>
                    <option value="All">All</option>
                    <option value="company" >Company</option>
                    <option value="employee" >Employee</option>
                    <option value="free" >Free</option>
                 </select>
          </div>

          
      </div>
 

  </div>

        
  <div class="col-md-12" style="margin-top: 10px;">
          <div class="col-md-12"><button class="bt btn-success form-control" onclick="filter_report_option();">FILTER</button></div>
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