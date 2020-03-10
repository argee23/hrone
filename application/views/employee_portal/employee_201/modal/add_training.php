 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Add Training / Seminar</center></h4>
      </div>
      <div class="modal-body">
         <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger"><i>(All fields are required)</i></a></strong>
        </div>
        <div class="panel-body">
            <form name="addtraining" method="post" action="add_training" enctype="multipart/form-data" onsubmit="return  checkStartDate('date_start', 'addtraining')">
                <div class="col-md-6 form-group has-feedback">
                    <label>Training Type: </label>
                    <select class="form-control" id="training_type" name="training_type" required>
                        <option value="" disabled selected>Select</option>
                        <option value="training">Training</option>
                        <option value="seminar">Seminar</option>
                    </select>
                </div>

                <div class="col-md-6 form-group has-feedback">
                    <label>Sub Type: </label>
                    <select class="form-control" id="sub_type" name="sub_type" required>
                      <!--   <option value="" disabled selected>Select</option> --><!-- 
                        <option value="internal">Internal(conducted by the company)</option> -->
                        <option value="external">External(conducted by other agency/company)</option>
                    </select>
                </div>

                <div class="col-md-6 form-group has-feedback">
                    <label>Training/Seminar Title: </label>
                    <input type="text" class="form-control" id="title" name="title"  placeholder="Title of the Training" required>
                </div>

                <div class="col-md-6 form-group has-feedback">
                    <label>Conducted By: </label>
                    <input type="text" class="form-control" id="conducted_by" name="conducted_by" required>
                </div>

                <div class="col-md-6 form-group has-feedback">
                    <label>Conducted By Type: </label>
                    <select class="form-control" id="conducted_by_type" name="conducted_by_type" required>
                       <!--  <option value="" disabled selected>Select</option>
                        <option value="internal">Internal</option> -->
                        <option value="external">External</option>
                    </select>
                </div>

                <div class="col-md-6 form-group has-feedback">
                    <label>Purpose / Objective:</label>
                    <input type="text" class="form-control"  name="purpose" id="purpose" placeholder="Purpose / Objective" required>
                </div>

                <div class="col-md-6 form-group has-feedback">
                    <label>Address Conducted:</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Venue Address" required>
                </div>

                
                

                <div class="col-md-6 form-group">
                    <label>Fee Type: *</label><br>
                    <select class="form-control" id="fee_type" name="fee_type" onchange="payment(this.value);" required>
                        <option value="" disabled selected>Select</option>
                        <option value="company">Company Shoulder</option>
                        <option value="employee">Employee Shoulder</option>
                        <option value="free">Free</option>
                    </select>
                 </div>

             
                 <div class="col-md-6 form-group">
                    <label>Fee Amount: *</label><br>
                    <input type="text" id="fee_amount" name="fee_amount" class="form-control" onkeypress="return isNumberKey(this, event);" 
                    onkeyup ="check_payment_status();" >
                 </div>

                
                 <div class="col-md-6 form-group">
                    <label>Payment Status: *</label><br>
                    <select class="form-control" id="payment_status" name="payment_status" >
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                        <option value="partial">Partial pay</option>
                    </select>
                     <input type="hidden" id="payment_status_final" name="payment_status_final">
                 </div>


                <div class="col-md-6 form-group has-feedback">
                    <label>Certification Image: <small><i>Accepted Files: PNG, JPG, GIF | File size must not exceed 500 KB</i></small></label>
                    <input type="file" class="btn btn-info" id="file" name="file">
                </div>


                <div class="col-md-6 form-group">
                    <label>Date From: *</label><br>
                    <input type="date" id="date_from" name="date_from" class="form-control" required onchange="get_compa(event);">
                 </div>

                 

                <div class="col-md-6 form-group">
                    <label>Date To: *</label><br>
                    <input type="date" id="date_to" name="date_to"   class="form-control" required onchange="get_compa(event);">
                </div>


                <div class="col-md-12"  style="margin-top: 10px;">
                  <div class="col-md-12">
                    <div class="col-md-2"></div>
                        <div class="col-md-8">
                                        <div class="text-danger" id="date_list">
                                        <n class="text-danger"><i>Fill up first the date from to date to continue</i></n>
                                            <input type="hidden" id="selected_dates" value="" required>
                                        </div>
                        </div>
                         <div class="col-md-2"></div>
                    </div>
                  </div>
             
                    

                <div class="col-md-6" style="margin-top: 30px;"><button type="submit" class="btn btn-success btn-block" ng-disabled="addtraining.$invalid" id="smbt_ind">Add Training/Seminar</button></div>
            <div class="col-md-6" style="margin-top: 30px;"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>

         </form>
        </div>
        </div>
      </div>

</div>
  
<script type="text/javascript">
  


   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});
    function date_ended(val)
    {
      if(document.getElementById('isOneday_').checked)
        { 
            document.getElementById('isOneday').value='no';
            document.getElementById('date_end').disabled=true;
            document.getElementById('date_end').value='';
        } 
        else
        { 
            document.getElementById('isOneday').value='yes';
            document.getElementById('date_end').disabled=false;
        }
    }
    function payment(val)
    {
     
      if(val=='free')
      {
         
         document.getElementById('fee_amount').disabled=true;
         document.getElementById('payment_status').disabled=true;
         document.getElementById('requiredmonths').value=0;
      } 
      else if(val=='company')
      {}
      else
      {
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
      function get_compa(val)
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
                get_dates(from_date,to_date,'date_list');
               
            }
        }

    }

    function get_dates(from_date,to_date,type)
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
          xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars/get_dates/"+from_date+"/"+to_date+"/"+type,true);
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