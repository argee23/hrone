 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center><i class="fa fa-pencil border"></i>Update Work Experience</center></h4>
      </div>
    
      <div class="modal-body">
      
         <div class="panel panel-default">
          <div class="panel-heading">
            <strong><a class="text-danger">All fields are required</i></a></strong>
        </div>

        <div class="panel-body">
        <form name="edit_work_exp" method="post" action="edit_work_ex">
        <input type="hidden" value="{{selected_work.work_experience_id}}" id="work_id" name="work_id">
        <div  ng-if="!update_work.isPresentWork">
         <input type="hidden" value="{{selected_work.isPresentWork}}" id="e_date">
        </div>  
        <div  ng-if="update_work.isPresentWork">
         <input type="text" value="{{update_work.isPresentWork}}" id="e_date">
        </div>
          <div class="col-lg-12">
            <div class="form-group has-feedback" ng-class="{'has-error' : edit_work_exp.position.$invalid}">
              <label>Job Position / Job Title: <small ng-show="edit_work_exp.position.$invalid"><i>Required</i></small></label>
              <div  ng-if="!update_work.position_name">
                 <select class="form-control" id="position" name="position" ng-model="work.position_name" ng-value="work.position_name" required>
                    <?php foreach ($positionList as $position) { if($position->isEmployer==1){}else{?>
                     <option value="<?php echo $position->position_id; ?>" ><?php echo $position->position_name; ?></option>
                    <?php }}?>
                </select>           
              </div>
              <div  ng-if="update_work.position_name">
                   <select class="form-control" id="position" name="position" ng-model="work.position_name" ng-value="work.position_name" required>
                    <?php foreach ($positionList as $position) { if($position->isEmployer==1){}else{?>
                      <option value="<?php echo $position->position_id; ?>" ng-disabled="'<?php echo $position->position_id; ?>' && edit_work_exp.position != '<?php echo $position->position_id; ?>'"><?php echo $position->position_name; ?></option>
                    <?php }}?>
                </select>           
              </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group has-feedback" ng-class="{'has-error' : edit_work_exp.company_name.$invalid}">
                    <label>Company Name: <small ng-show="edit_work_exp.company_name.$invalid"><i>Required</i></small></label>
                  <div  ng-if="!update_work.company_name">
                    <input type="text" class="form-control" id="company_name" name="company_name" ng-model="selected_work.company_name" ng-value="selected_work.company_name" required>
                  </div>
                  <div  ng-if="update_work.company_name">
                    <input type="text" class="form-control" id="company_name" name="company_name" ng-model="update_work.company_name" ng-value="update_work.company_name" required>
                  </div>
                </div>


                <div class="form-group has-feedback" ng-class="{'has-error' : edit_work_exp.company_address.$invalid}" >
                    <label>Company Address: <small ng-show="edit_work_exp.company_address.$invalid"><i>Required</i></small></label>
                    <div  ng-if="!update_work.company_address">
                        <input type="text" class="form-control" id="company_address" name="company_address" ng-model="selected_work.company_address" ng-value="selected_work.company_address" required>
                    </div>
                    <div  ng-if="update_work.company_address">
                        <input type="text" class="form-control" id="company_address" name="company_address" ng-model="update_work.company_address" ng-value="update_work.company_address" required>
                    </div>
                </div>

                <div class="form-group has-feedback">
                    <label>Start Date: *</label><br>
                     <div  ng-if="!update_work.date_start">
                      <input type="date"  name="edit_start_date"  value="{{selected_work.date_start}}" >
                     </div>
                     <div  ng-if="update_work.date_start">
                      <input type="date"  name="edit_start_date"  value="{{update_work.date_start}}">
                     </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label>Company Contact Number:</label>
                    <div  ng-if="!update_work.company_contact">
                      <input type="text" class="form-control" id="company_contact" name="company_contact" >
                    </div>
                     <div  ng-if="update_work.company_contact">
                      <input type="number" class="form-control" id="company_contact" name="company_contact">
                    </div>
                </div>
                <div class="form-group">
                    <label>Salary:</label>
                    <div  ng-if="!update_work.salary">
                      <input type="text" class="form-control" id="salary" name="salary" value="{{selected_work.salary}}" onkeypress="return isNumberKey(this, event);">
                    </div>
                     <div  ng-if="update_work.salary">
                      <input type="text" class="form-control" id="salary" name="salary" value="{{update_work.salary}}" onkeypress="return isNumberKey(this, event);">
                    </div>
               </div>
                <div class="form-group">
                    <label>End Date:</label><br>
                    <div  ng-if="!update_work.date_end">
                    <input type="date"  id ="d" name="edit_end_date"  value="{{selected_work.date_end}}" onclick="end_date();"><br>
                    </div>
                    <div  ng-if="update_work.date_end">
                    <input type="date"  id ="d" name="edit_end_date" value="{{update_work.date_end}}"  onclick="end_date();"><br>
                    </div>
                    <label>
                   <div  ng-if="!update_work.isPresentWork">
                      <div ng-if="selected_work.isPresentWork==1"> <input type="checkbox" name="isPresentWork" id="workk" checked onclick="workss();"> Present Work</label></div>
                      <div ng-if="selected_work.isPresentWork==0"> <input type="checkbox" name="isPresentWork" id="workk"  onclick="workss();"> Present Work</label></div>
                   
                   </div>
                    <label>
                   <div  ng-if="update_work.isPresentWork">
                      <div ng-if="update_work.isPresentWork==1"> <input type="checkbox" name="isPresentWork" id="workk"  checked onclick="workss();"> Present Work</label></div>
                      <div ng-if="update_work.isPresentWork==0"> <input type="checkbox" name="isPresentWork" id="workk"  onclick="workss();"> Present Work</label></div>
                    </div>
                  
                </div>

            </div>
              <div class="form-group">
                  <label for="comment">Job Description:</label>
                  <div  ng-if="!update_work.job_description">
                      <textarea class="form-control" rows="5" id="comment"  id="job_description" name="job_description" ng-model="selected_work.job_description" ng-value="selected_work.job_description"></textarea>
                  </div>
                  <div  ng-if="update_work.job_description">
                      <textarea class="form-control" rows="5" id="comment"  id="job_description" name="job_description" ng-model="update_work.job_description" ng-value="update_work.job_description"></textarea>
                  </div>
                </div>
            <div class="form-group">
                <label>Reason for Leaving:</label>
                <div  ng-if="!update_work.reason_for_leaving">
                   <input type="text" class="form-control" id="reason_for_leaving" name="reason_for_leaving" ng-model="selected_work.reason_for_leaving" ng-value="selected_work.reason_for_leaving">
                </div>
                <div  ng-if="update_work.reason_for_leaving">
                   <input type="text" class="form-control" id="reason_for_leaving" name="reason_for_leaving" ng-model="update_work.reason_for_leaving" ng-value="update_work.reason_for_leaving">
                </div>
             </div>
            <div class="col-md-6"><button type="submit" class="btn btn-success btn-block" ng-disabled="edit_work_exp.$invalid"><i class="fa fa-save"></i> Save Changes</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
          </div>
         </form>

        </div>


        </div>
      </div>
</div>
  
<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});
    function date_ended(val)
    {
      if(document.getElementById('isOneday_').checked)
        { 
            document.getElementById('isOneday').value='1';
            document.getElementById('one_date').disabled=true;
            document.getElementById('one_date').value='';
        } 
        else
        { 
            document.getElementById('isOneday').value='0';
            document.getElementById('one_date').disabled=false;
        }
    }

     function payment(val)
    {
     
      if(val=='free')
      {
         $('#requiredMonthscompany').hide();
         document.getElementById('fee_amount').disabled=true;
         document.getElementById('payment_status').disabled=true;
         document.getElementById('requiredmonths').value=0;
      } 
      else if(val=='company')
      {
        $('#requiredMonthscompany').show();
        document.getElementById('fee_amount').disabled=false;
        document.getElementById('payment_status').disabled=false;
      }
      else
      {
         $('#requiredMonthscompany').hide();
         document.getElementById('fee_amount').disabled=false;
         document.getElementById('payment_status').disabled=false;
         document.getElementById('requiredmonths').value=0;
      }
        
    }
     function isNumberKey(txt, evt) {
      
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
            //Check if the text already contains the . character
            if (txt.value.indexOf('.') === -1) {
                return true;

            } else {
                return false;

            }
        } else {

            if (charCode > 31
                 && (charCode < 48 || charCode > 57))
                return false;

        }
        return true;
    }
    function check_payment_status()
    {

      var fee_amount = document.getElementById('fee_amount').value;
      var payment_amount_given = document.getElementById('payment_amount_given').value;
      var f = new Number(fee_amount);
      var p = new Number(payment_amount_given);

      if(fee_amount==payment_amount_given)
      {
        document.getElementById('payment_status').value="paid";
        document.getElementById('payment_status_final').value="paid";
        
      }
      else
      {
        document.getElementById('payment_status').value="partial";
        document.getElementById('payment_status_final').value="partial";
      }

      if(p > f)
      {
         alert("Fee Amount must greater or equal to Payment amount given");
         document.getElementById('smbt_ind').disabled=true;
      }
      else
      {
         document.getElementById('smbt_ind').disabled=false;
      }
    }
      function get_compa(val,seminarid)
    { 
        var from_date = document.getElementById('date_from').value;
        var to_date = document.getElementById('date_to').value;

        if(to_date==''){ var res = 'true'; }
        else
        {
          if(from_date < to_date){ var res ='true'; }
          else if(from_date==to_date)
          {
            var res = 'true';
          }
          else { var res='false'; }
        }

        if(res=='false')
        {
          alert('Date to must be greater than the from date');
          document.getElementById('smbt_ind').disabled=true;
        }
        else
        {
           document.getElementById('smbt_ind').disabled=false;
            if(from_date!='' && to_date!='')
            {
                get_dates(from_date,to_date,'date_list',seminarid);
               
            }
        }

    }

    function get_dates(from_date,to_date,type,seminarid)
    {

        if (window.XMLHttpRequest)
            {
            xmlhttp=new XMLHttpRequest();
            }
          else
            {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
          xmlhttp.onreadystatechange=function()
            {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
              { 
              document.getElementById(type).innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars/get_datesss/"+from_date+"/"+to_date+"/"+type+"/"+seminarid,true);
          xmlhttp.send();
    }
    
    function checker_date_range(i)
    {
      var checker = document.getElementById('checker'+i).value;
      if(checker==1)
      {

        document.getElementById('checker'+i).value=0;
        document.getElementById('time_from'+i).disabled=true;
        document.getElementById('time_to'+i).disabled=true;
         document.getElementById('hour'+i).disabled=true;

        var selected = document.getElementById('selected_dates').value;

        var res = selected.replace(i+"=", "");
        document.getElementById('selected_dates').value=res;    

      }
      else
      {
        
        document.getElementById('checker'+i).value=1;
        document.getElementById('time_from'+i).disabled=false;
        document.getElementById('time_to'+i).disabled=false;
        document.getElementById('hour'+i).disabled=false;
        var selected = document.getElementById('selected_dates').value;
        var res = selected +=i + "=";
        document.getElementById('selected_dates').value=res; 

      }
    }
</script>