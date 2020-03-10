<form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_training_seminars_final/save_file_maintenance">
<div class="modal-content" style="overflow: scroll;">
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Select Employees</center></h4>
      </div>
     

      <div class="modal-body">
       
         <div class="panel panel-default">
        
        <div class="panel-body">
          <span class="dl-horizontal col-sm-6">
            <dt style="margin-top: 5px;">Company</dt>
            <dd  style="margin-top: 5px;">
                <select class="form-control" onchange="get_location_department_classification(this.value);" id="company" name="company">
                <option value="not_included" selected disabled>Select</option>
                    <?php foreach($companyList as $comp){?>
                            <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                    <?php } ?>
                </select>
            </dd>

            <dt  style="margin-top: 5px;">Training Type</dt>
            <dd  style="margin-top: 5px;">
                <select class="form-control" id="training_type" name="training_type" required>
                    <option value="" disabled selected>Select</option>
                    <option value="training">Training</option>
                    <option value="seminar">Seminar</option>
                </select>
            </dd>
           
            <dt  style="margin-top: 5px;">Sub Type</dt>
            <dd  style="margin-top: 5px;">
                <select class="form-control" id="sub_type" name="sub_type" required >
                    <option value="" disabled selected>Select</option>
                    <option value="internal">Internal(conducted by the company)</option>
                    <option value="external">External(conducted by other agency/company)</option>
                </select>
            </dd>

            <dt  style="margin-top: 5px;">Address</dt>
            <dd  style="margin-top: 5px;">
             <textarea class="form-control" rows="3" name="address" id="address"></textarea> 
            </dd>

            <dt  style="margin-top: 5px;">Conducted By</dt>
            <dd  style="margin-top: 5px;"> 
                <div id="div_conducted_by">
                    <input type="text" class="form-control" name="conducted_by" id="conducted_by">
                </div>
            </dd>

            
            <dt  style="margin-top: 5px;">Fee Amount</dt>
            <dd  style="margin-top: 5px;"> 
               <input type="text" class="form-control" id="fee_amount" name="fee_amount" value="0" onkeypress="return isNumberKey(this, event);">
            </dd>

             <dt  style="margin-top: 5px;">Payment Status</dt>
            <dd  style="margin-top: 5px;"> 
               <select class="form-control" id="payment_status" name="payment_status">Select
                    <option value="not_included" selected disabled></option>
                    <option value="paid">Paid</option>
                    <option value="unpaid">Unpaid</option>
                    <option value="partial">Partial pay</option>
               </select>
            </dd>

          </span>
          <span class="dl-horizontal col-sm-6">
            <dt  style="margin-top: 5px;">Title / Topic</dt>
            <dd  style="margin-top: 5px;">
             <textarea class="form-control" rows="3" id="title" name="title" required></textarea> 
            </dd>
            <dt  style="margin-top: 5px;">Purpose/ Objectives</dt>
            <dd  style="margin-top: 5px;">
               <textarea class="form-control" rows="3" name="purpose" id="purpose" required></textarea>
            </dd>
          
            <dt  style="margin-top: 5px;">Conducted By Type</dt>
            <dd  style="margin-top: 5px;"> 
                <select class="form-control" id="conducted_by_type" name="conducted_by_type" required onchange="view_filemaintenance_conducted_by();">
                      <option value="" disabled selected>Select</option>
                      <option value="internal">Internal</option>
                      <option value="external">External</option>
                </select>
            </dd>

            <dt  style="margin-top: 5px;">Fee Type</dt>
            <dd  style="margin-top: 5px;"> 
                <select class="form-control" id="fee_type" name="fee_type" onchange="payment_file_maintenance(this.value);" required>
                    <option value="" disabled selected>Select</option>
                    <option value="company">Company Shoulder</option>
                    <option value="employee">Employee Shoulder</option>
                    <option value="free">Free</option>
                </select>
            </dd>

            <dt  style="margin-top: 5px;">Number of Month</dt>
            <dd  style="margin-top: 5px;"> 
               <input type="text" class="form-control" id="requiredmonths" name="requiredmonths" value="0" onkeypress="return isNumberKey(this, event);" placeholder="Required Length of service" required disabled>
               <n></n>
            </dd>

            <dt  style="margin-top: 5px;">Type</dt>
            <dd  style="margin-top: 5px;"> 
                <select class="form-control" name="type_option" id="type_option" required>
                  <option disabled selected>Select Option</option>
                  <option value="employee">Employee Trainings and Seminars</option>
                  <option value="incoming">Incoming Trainings and Seminars</option>
                </select>
               <n></n>
            </dd>

          </span>
        </div>
        </div>
 <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger"><center>Trainings and Seminars Schedules Date</center></i></a></strong>
        </div>
        <div class="panel-body">

          <div class="col-md-12" style="padding-bottom: 10px;">
            <div class="col-md-6">
                <div class="col-md-4">Date From: </div> <div class="col-md-6"><input type="date" class="form-control" id="date_from" name="date_from" onchange="get_dates_filemaintenance(event);"  required></div></div>
            <div class="col-md-6"><div class="col-md-4">Date To: </div> <div class="col-md-6"><input type="date" class="form-control" id="date_to" name="date_to" required onchange="get_dates_filemaintenance(event);"></div></div>
          </div>

          <span class="dl-horizontal col-sm-12" id="selected_employees_here">
                <div class="col-md-2"></div>
                <div class="col-md-8" id='date_list'></div>
                <div class="col-md-2"></div>
          </span>
          
        </div>
        </div>

        <input type="hidden" id="selectedemployees_filtered" class="form-control">
        <input type="hidden" id="check_uncheck" class="form-control" value="0">

        <div class="modal-footer">
            <button type="submit" class="btn btn-success"  id="smt_btn">Add</button>
            <button type="button" class="btn btn-default" class="close" data-dismiss="modal">Close</button>
      </div>
      </div>

</div>
</form>