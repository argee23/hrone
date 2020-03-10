<ol class="breadcrumb">
  <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Add Incoming Trainings and Seminar
      <button class="btn btn-danger btn-xs pull-right" style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/employee_training_seminars/add_mass_employees');?>" ><i class="fa fa-plus"></i>&nbsp;Assign Employees</button>
  </h4>
</ol>

<form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_training_seminars/save_incoming_trainings" >
            
<div>
    <div class="col-md-8">

        <div class="col-md-12">
          <div class="col-md-4"><label>Training Type</label></div>
          <div class="col-md-8">
             <select class="form-control" id="training_type" name="training_type" required>
                <option value="" disabled selected>Select Training Type</option>
                <option value="training">Training</option>
                <option value="seminar">Seminar</option>
              </select>
          </div>
        </div>

         <div class="col-md-12" style="margin-top: 5px;">
          <div class="col-md-4"><label>Sub Type</label></div>
          <div class="col-md-8">
            <select class="form-control" id="sub_type" name="sub_type" required required >
                <option value="" disabled selected>Select</option>
                <option value="internal">Internal(conducted by the company)</option>
                <option value="external">External(conducted by other agency/company)</option>
            </select>
          </div>
        </div>

         <div class="col-md-12" style="margin-top: 5px;">
          <div class="col-md-4"><label>Title/Topic</label></div>
          <div class="col-md-8">
            <textarea class="form-control" id="title" name="title" rows="3" required></textarea>
          </div>
        </div>

         <div class="col-md-12" style="margin-top: 5px;">
          <div class="col-md-4"><label>Conducted By Type</label></div>
          <div class="col-md-8">
              <select class="form-control" id="conducted_by_type" name="conducted_by_type" required onchange="view_conducted_by();">
                <option value="" disabled selected>Select</option>
                <option value="internal">Internal</option>
                <option value="external">External</option>
              </select>
          </div>
        </div>

         <div class="col-md-12" style="margin-top: 5px;">
          <div class="col-md-4"><label>Conducted By</label></div>
          <div class="col-md-8" id="div_conducted_by">
            <input type="text" class="form-control" name="conducted_by" id="conducted_by">
          </div>
        </div>

         <div class="col-md-12" style="margin-top: 5px;">
          <div class="col-md-4"><label>Purpose / Objective</label></div>
          <div class="col-md-8">
            <textarea class="form-control" name="purpose" id="purpose" rows="3" required></textarea>
          </div>
        </div>

         <div class="col-md-12" style="margin-top: 5px;">
          <div class="col-md-4"><label>Address Conducted</label></div>
          <div class="col-md-8">
            <input type="text" class="form-control" id="address" name="address" required>
          </div>
        </div>

         <div class="col-md-12" style="margin-top: 5px;">
          <div class="col-md-4"><label>Fee Type</label></div>
          <div class="col-md-8">
            <select class="form-control" id="fee_type" name="fee_type" onchange="payment(this.value);" required>
                <option value="" disabled selected>Select</option>
                <option value="company">Company Shoulder</option>
                <option value="employee">Employee Shoulder</option>
                <option value="free">Free</option>
            </select>
          </div>
        </div>

        <div class="col-md-12"  style="margin-top: 10px;display: none;" id="requiredMonthscompany">
            <div class="col-md-4"><label>Required Months</label></div>
              <div class="col-md-8">
                <input type="text" class="form-control" id="requiredmonths" name="requiredmonths" value="0" onkeypress="return isNumberKey(this, event);" required>
                <n class="text-danger"><i>Length of service to be totally shouldered by the company</i></n>
              </div>
        </div>

         <div class="col-md-12" style="margin-top: 5px;">
          <div class="col-md-4"><label>Attachment</label></div>
          <div class="col-md-8">
            <input type="file" name="file" id="file">
          </div>
        </div>

         <div class="col-md-12" style="margin-top: 5px;">
          <div class="col-md-4"><label>Fee Amount</label></div>
          <div class="col-md-8">
            <input type="text" class="form-control" id="fee_amount" name="fee_amount" value="0" onkeypress="return isNumberKey(this, event);" onkeyup ="check_payment_status();" >
          </div>
        </div>

        <div class="col-md-12"  style="margin-top: 10px;">
          <div class="col-md-4"><label>Date From</label></div>
            <div class="col-md-8">
              <input type="date" class="form-control" id="date_from" name="date_from" required onchange="get_compa(event);" required>
            </div>
        </div>

        <div class="col-md-12"  style="margin-top: 10px;">
          <div class="col-md-4"><label>Date To</label></div>
            <div class="col-md-8">
              <input type="date" class="form-control" id="date_to" name="date_to" required onchange="get_compa(event);" required>
            </div>
        </div>
        
        <div class="col-md-12"  style="margin-top: 10px;">
          <div class="col-md-4"><label>Dates</label></div>
            <div class="col-md-8">
              <div class="text-danger" id="date_list">
                <n class="text-danger"><i>Fill up first the date from to date to</i></n>
                  <input type="hidden" id="selected_dates" value="" required>
              </div>
         </div>
        </div>




    </div>


     <div class="col-md-4" id="selected_employee_ts" style="height: 570px;overflow-y:scroll;">
       <table class="table table-bordered" id="table_emp">
          <thead>
              <tr class="danger">
                  <th style="width: 100%;"><center>LIST OF SELECTED EMPLOYEES</center></th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td></td>
              </tr>
          </tbody>
       </table>

     </div>

     <div class="col-md-12" style="margin-top: 10px;">
        <div class="col-md-12"><button type="submit" class="col-md-12 btn btn-success" id="smt_btn" disabled>SAVE TRAININGS AND SEMINAR</button></div>
     </div>


</div>

  </form>
