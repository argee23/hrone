<div class="panel panel-default">
  <div class="panel-body">
    <h4 class="panel-header">Apply Leave <small>Employee Leave Form</small></h4><hr>
      <?php if (count($approvers) == 0)
      { ?>
            <div class="callout callout-danger">
              <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>
              <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
            </div>
      <?php } else { require_once(APPPATH.'views/employee_portal/transactions/compress_leave/per_hour_credits.php');?>


                  <!--  START OF FILING LEAVE -->

                  <form class="form-horizontal" name="add_med_re" method="post"  enctype="multipart/form-data"  action="<?php echo base_url();?>employee_portal/employee_transactions_leave_compress/add_leave_per_hour" onsubmit="document.getElementById('submit').disabled=true;">


                    <div class="form-group"><label class="control-label col-sm-2" for="email">Leave Type</label>
                      <div class="col-sm-10">
                        <select class="form-control" id="sel1" name="leave_type_id"  required onchange="pay_option(this.value);">
                          <option value="" required selected>Select a Leave Type</option>
                          <?php foreach ($leaves as $leave) {
                            $checker = $this->employee_transactions_model->getLeaveTypes_approver($leave->leave_type_id);
                            if($checker > 0 ){  $a=''; $b=''; } else{ $a='disabled'; $b=' (No approver/s yet.)'; } 
                            if($leave->is_system_default=="1"){}else{?>
                            <option value="<?php echo $leave->id; ?>" <?php echo $a;?>><?php echo $leave->leave_type."".$b."";  ?></option>
                            <?php } }
                                 //=========================Start incentive leave
                            if(!empty($incentive_leave)){
                              $checker = $this->employee_transactions_model->getLeaveTypes_approver($il_leave_type->id);
                              if($checker > 0 ){  $a=''; $b=''; } else{ $a='disabled'; $b=' (No approver/s yet.)'; } 
                              ?>
                              <option value="<?php echo $il_leave_type->id; ?>" <?php echo $a;?>><?php echo $il_leave_type->leave_type."".$b."";?></option>
                              <?php } else{} ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-2" for="email">Address while on Leave</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="email"  name="address" required>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-sm-2" for="email">Inclusive Dates</label>
                          <div class="col-sm-5">
                            <label class="control-label" for="email">From</label>
                            <input type="text" class="form-control" id="from_date" name="from_date" disabled required>
                          </div>
                          <div class="col-sm-5">
                            <label class="control-label" for="email">To</label>
                            <input type="text" class="form-control" id="to_date" name="to_date" disabled required>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-sm-2" for="email"></label>
                          <div class="col-sm-10">
                            <div class="splash" ng-cloak="">
                              <div class="spinner">
                                <div class="double-bounce1"></div>
                                <div class="double-bounce2"></div>
                              </div>
                            </div>
                            <div id="date_list">
                              
                          </div>
                          <div class="help-block with-errors"><span class="text-danger" id="errors"></span></div>
                        </div>
                      </div>
                      <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">
                      <input type="hidden" id="form_id" value="<?php echo $form_id; ?>">
                      <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">
                      <div class="form-group" id="attachment_required"></div>

                      <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Reason</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" rows="2" name="reason" id="comment"></textarea>
                        </div>
                      </div>

                      <div class="form-group">
                      <div class="panel">
                        <label class="control-label col-sm-2">Warnings</label>
                        <div class="col-sm-10">
                            <div class="bg-danger panel-body">
                                <span id="warnings">Please select atleast 1 valid day.</span>
                            </div><br>
                        </div>
                      </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-sm-4" for="email"></label>
                        <div class="col-sm-8">
                          <button type="submit" id="submit" class="btn btn-success btn-md"  disabled>Submit</button>
                        </div>
                      </div>
                    </form>
            <!-- END OF FILING -->

  <?php } ?>
  </div>
</div>



<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>
<script type="text/javascript">
  
          function pay_option(id)
          {
             var available = document.getElementById('id'+id).value;
             document.getElementById('from_date').disabled=false;
             document.getElementById('to_date').disabled=false;
             document.getElementById('from_date').value='';
             document.getElementById('to_date').value='';
             attachment_required(id);
             $("#date_list").load(location.href + " #date_list");
          }

          var starting = null;
          var end_date = null;
          $(document).ready(function()
          {
            
            $('#to_date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false }).on('change', function(e, date)
            {
              end_date = moment(date);
              document.getElementById('submit').disabled=false;
              document.getElementById('errors').innerHTML="";
              var leave_t = document.getElementById('sel1').value;
              var id = document.getElementById('form_id').value;
              var available = document.getElementById('id'+leave_t).value;
              if (starting != null)
              {
                get_dates(starting.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'),leave_t,id);
                //Function get_schedules description is in index.php of transactions folder. :)
              }
            });

            $('#from_date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false  }).on('change', function(e, date)
            {
              starting = date;
              document.getElementById('submit').disabled=false;
              document.getElementById('errors').innerHTML="";
              var leave_t = document.getElementById('sel1').value;
              var id = document.getElementById('form_id').value;
              var available = document.getElementById('id'+leave_t).value;
              $('#to_date').bootstrapMaterialDatePicker('setMinDate', date);
              starting = date;
              if (end_date != null)
              {
                get_dates(starting.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'),leave_t,id); 
                //Function get_schedules description is in index.php of transactions folder. :)
              }
            }); 
            $.material.init()
          });


          function get_dates(start,end,leave,id)
          {
              var available = document.getElementById('id'+leave).value;

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
                        document.getElementById("date_list").innerHTML=xmlhttp.responseText;
                        get_with_pay_option(leave);


                  }
                }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_transactions_leave_compress/get_leave_compress/"+start+"/"+end+"/"+leave+"/"+id+"/"+available,true);
              xmlhttp.send();

              

          } 

        function get_with_pay_option(leave)
        {
            var with_pay_option = document.getElementById('with_pay_option').value;
            var available = document.getElementById('id'+leave).value;
           
            if(with_pay_option=='invalid')
            {
              document.getElementById('submit').disabled=true;
              document.getElementById('warnings').innerHTML="Not enough credit please file "+available + " credit/s only";
            }
            else
            {
              document.getElementById('submit').disabled=false;
              document.getElementById('warnings').innerHTML="No warning/s found";

                  if (!($('[name="dates[]"]:checked').length > 0))
                        {
                            document.getElementById('submit').disabled=true;
                            document.getElementById('warnings').innerHTML="Please select atleast 1 valid day.";
                        }
                   else
                        {
                            document.getElementById('submit').disabled=false;
                            document.getElementById('warnings').innerHTML="No warning/s found";
                        }
            }
        }

         function isNumberKey(data,no,type) {
            if(type=='h')
            {
              if(data < '12' )
              {
                alert("ok");
              }
              else
              {
                alert("notok");
              }
            }
            else
            {
               if(data < '59' )
                {
                  alert("ok");
                }
                else
                {
                  alert("notok");
                }
            }
        }


        function get_leave_option(value,i,hrs)
        {

          hour_minutes(value,i);
          var minimum_hrs = document.getElementById('minimum_per_hour_filing').value;

          if(value=='per_hour')
          {
            document.getElementById("leave_"+i).innerHTML = 0;
            document.getElementById("deduction_"+i).innerHTML = 0;
            document.getElementById("deduction"+i).value = 0;

          } 
          else 
          {
                if(value=='halfday')
                {
                  var data = hrs / 2;
                  var total_hm = data * 60;
                  document.getElementById("leave_"+i).innerHTML = data;
                  var tminutes = data * 60;
                  var deduc = tminutes/ 60;
                  var deduction = deduc / 8;
                  document.getElementById("deduction_"+i).innerHTML = deduction;
                  document.getElementById("deduction"+i).value = deduction;

                }
                else
                {
                  document.getElementById("leave_"+i).innerHTML = hrs;
                  var total_hm = hrs * 60;
                  var tminutes = hrs * 60;
                  var deduc = tminutes/ 60;
                  var deduction = deduc / 8;
                  document.getElementById("deduction_"+i).innerHTML = deduction;
                  document.getElementById("deduction"+i).value = deduction;
                }
                
                  if(minimum_hrs=='no_setting' || minimum_hrs <=total_hm || minimum_hrs=="no setting")
                  {
                            document.getElementById('warningerr'+i).innerHTML="";
                            document.getElementById('cdate'+i).value=1;
                            document.getElementById('date'+i).checked=true;
                            document.getElementById('date'+i).disabled=false; 
                  }
                  else
                  {
                            document.getElementById('cdate'+i).value=0;
                            document.getElementById('date'+i).checked=false;
                            document.getElementById('date'+i).disabled=true;
                            document.getElementById('warningerr'+i).innerHTML="Minimum allowed per hour filing is " + minimum_hrs +" min/s";
                  }

                  var count = document.getElementById('total_dates').value;
                  var datas =0;
                  for (i=1;i < count; i++)
                  {
                    var checker = document.getElementById('cdate'+i).value;
                    if(checker==1)
                    {
                       var total_deduction = document.getElementById('deduction'+i).value;
                    }
                    else
                    {
                         var total_deduction = 0;
                    }
                   
                    var data_ = (+total_deduction);
                    datas +=data_;
                  }
                  document.getElementById('total_hours').innerHTML=datas;
                  document.getElementById('total_hours_per_form').value=datas;
                  var leave = document.getElementById('sel1').value;
                  var available = document.getElementById('id'+leave).value;
                  

                  if(available > 0)
                  { 
                      if(datas > available)
                      {
                        document.getElementById('with_pay_option').value='invalid';
                        document.getElementById('submit').disabled=true;
                        document.getElementById('warnings').innerHTML="Not enough credit please file "+available + " credit/s only";
                        document.getElementById('with_pay_option_msg').innerHTML="Not enough credit please file "+available + " credit/s only";
                        
                      } 
                      else
                      {
                        document.getElementById('with_pay_option').value='1';
                        document.getElementById('submit').disabled=false;
                        document.getElementById('warnings').innerHTML="No warning/s found";
                        document.getElementById('with_pay_option_msg').innerHTML="with pay";
                      }
                  }
                  else
                  {
                      document.getElementById('with_pay_option').value='0';
                      document.getElementById('submit').disabled=false;
                      document.getElementById('warnings').innerHTML="without pay";
                  }


          }
        }          


        function select_dates(i,hrs)
        {
          if(document.getElementById('date'+i).checked==true)
          {
            document.getElementById('option'+i).disabled=false;
            document.getElementById('cdate'+i).value='1';
          }
          else
          {
            document.getElementById('option'+i).disabled=true;
            document.getElementById('cdate'+i).value='0';

            var schedulehour = document.getElementById('schedule_hours'+i).value;
            document.getElementById('leave_'+i).innerHTML=schedulehour;
            var tminutes = schedulehour * 60;
            var deduc = tminutes/ 60;
            var deduction = deduc / 8;
            document.getElementById("deduction_"+i).innerHTML = deduction;
            document.getElementById("deduction"+i).value = deduction;

            hour_minutes('wholeday',i);
            document.getElementById('option'+i).value='wholeday';
          }

          var count = document.getElementById('total_dates').value;
          
          


              var count = document.getElementById('total_dates').value;
              var datas =0;
              for (i=1;i < count; i++)
              {
                var checker = document.getElementById('cdate'+i).value;
                if(checker==1)
                {
                   var total_deduction = document.getElementById('deduction'+i).value;
                }
                else
                {
                     var total_deduction = 0;
                }
               
                var data_ = (+total_deduction);
                datas +=data_;
              }
              document.getElementById('total_hours').innerHTML=datas;
              document.getElementById('total_hours_per_form').value=datas;
              var leave = document.getElementById('sel1').value;
              var available = document.getElementById('id'+leave).value;
              
              if(available > 0)
              { 
                  if(datas > available)
                  {
                    document.getElementById('with_pay_option').value='invalid';
                    document.getElementById('submit').disabled=true;
                    document.getElementById('warnings').innerHTML="Not enough credit please file "+available + " credit/s only";
                    document.getElementById('with_pay_option_msg').innerHTML="Not enough credit please file "+available + " credit/s only";
                    
                  } 
                  else
                  {
                    document.getElementById('with_pay_option').value='1';
                    document.getElementById('submit').disabled=false;
                    document.getElementById('warnings').innerHTML="No warning/s found";
                    document.getElementById('with_pay_option_msg').innerHTML="with pay";
                  }
              }
              else
              {
                  document.getElementById('with_pay_option').value='0';
                  document.getElementById('submit').disabled=false;
                  document.getElementById('warnings').innerHTML="without pay";
              }


              if (!($('[name="dates[]"]:checked').length > 0))
              {
                  document.getElementById('submit').disabled=true;
                  document.getElementById('warnings').innerHTML="Please select atleast 1 valid day.";
              }
              else
              {
                  document.getElementById('submit').disabled=false;
                  document.getElementById('warnings').innerHTML="No warning/s found";

              }
          


        }
        
        function checker_minutes_hours(i)
        {
           var option= document.getElementById('option'+i).value;
           var minimum_hrs = document.getElementById('minimum_per_hour_filing').value;
          if(option=='per_hour')
          {
              var thour = document.getElementById('hh'+i).value;
              var tmin = document.getElementById('mm'+i).value;

              if(thour > '1') { var hrs = ' hrs '; } else { var hrs = ' hr '; }
              if(tmin > '1') { var mins = ' mins '; } else { var mins = ' min '; }

              var hrs_mins = thour + hrs + ' and ' + tmin + mins;
              document.getElementById("leave_"+i).innerHTML = hrs_mins;

              var vhours = document.getElementById("hh"+i).value;
              var vminutes = document.getElementById("mm"+i).value;
              var fhours = vhours * 60;
              var total_hm = (+fhours) + (+vminutes);
              var total = total_hm / 60;
              var deduc = total / 8;
              var deduction = deduc.toFixed(9);
              document.getElementById("deduction_"+i).innerHTML = deduction;
              document.getElementById("deduction"+i).value = deduction;

                if(minimum_hrs=='no_setting' || minimum_hrs <=total_hm || minimum_hrs=="no setting")
                {
                    var schedulehours = document.getElementById('schedule_hours'+i).value;
                    var total_hr_min = total;
                    if(total_hr_min > schedulehours)
                    {
                      
                        document.getElementById('cdate'+i).value=0;
                        document.getElementById('date'+i).checked=false;
                        document.getElementById('date'+i).disabled=true;
                        document.getElementById('warningerr'+i).innerHTML="Maximum allowed per hour filing is " + schedulehours + "hr/s";
                    }
                    else
                    {
                        document.getElementById('warningerr'+i).innerHTML="";
                        document.getElementById('cdate'+i).value=1;
                        document.getElementById('date'+i).checked=true;
                        document.getElementById('date'+i).disabled=false;
                    }


                    
                }
                else
                {
                    document.getElementById('cdate'+i).value=0;
                    document.getElementById('date'+i).checked=false;
                    document.getElementById('date'+i).disabled=true;
                    document.getElementById('warningerr'+i).innerHTML="Minimum allowed per hour filing is " + minimum_hrs +" min/s";
                }


          }

              var count = document.getElementById('total_dates').value;
              var datas =0;
              for (i=1;i < count; i++)
              {
                var checker = document.getElementById('cdate'+i).value;
                if(checker==1)
                {
                   var total_deduction = document.getElementById('deduction'+i).value;
                }
                else
                {
                     var total_deduction = 0;
                }
               
                var data_ = (+total_deduction);
                datas +=data_;
              }
              document.getElementById('total_hours').innerHTML=datas;
              document.getElementById('total_hours_per_form').value=datas;
              var leave = document.getElementById('sel1').value;
              var available = document.getElementById('id'+leave).value;
              

              if(available > 0)
              { 
                  if(datas > available)
                  {
                    document.getElementById('with_pay_option').value='invalid';
                    document.getElementById('submit').disabled=true;
                    document.getElementById('warnings').innerHTML="Not enough credit please file "+available + " credit/s only";
                    document.getElementById('with_pay_option_msg').innerHTML="Not enough credit please file "+available + " credit/s only";
                    
                  } 
                  else
                  {
                    document.getElementById('with_pay_option').value='1';
                    document.getElementById('submit').disabled=false;
                    document.getElementById('warnings').innerHTML="No warning/s found";
                    document.getElementById('with_pay_option_msg').innerHTML="with pay";
                  }
              }
              else
              {
                  document.getElementById('with_pay_option').value='0';
                  document.getElementById('submit').disabled=false;
                  document.getElementById('warnings').innerHTML="without pay";
              }


        }

        function hour_minutes(type,i)
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
                    document.getElementById("hr_mins"+i).innerHTML=xmlhttp.responseText;
                  }
                }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_transactions_leave_compress/hour_minutes/"+type+"/"+i,true);
              xmlhttp.send();
        }
        
         function attachment_required(id)
          {
            if (window.XMLHttpRequest)
                {
                xmlhttp2=new XMLHttpRequest();
                }
              else
                {// code for IE6, IE5
                xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
                }
              xmlhttp2.onreadystatechange=function()
                {
                if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
                  {
                    document.getElementById("attachment_required").innerHTML=xmlhttp2.responseText;
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/employee_transactions/attachment_required/"+id,false);
              xmlhttp2.send();
          }

          function checker_allowed_hours(i,hr)
          {
            var tmin_ = hr - Math.floor(hr);
            var tmin = tmin_ * 60;
            var thour = parseInt(hr, 10);
            var minimum_hrs = document.getElementById('minimum_per_hour_filing').value;
            var option= document.getElementById('option'+i).value;
            if(option=='per_hour')
            {


                if(thour > '1') { var hrs = ' hrs '; } else { var hrs = ' hr '; }
                if(tmin > '1') { var mins = ' mins '; } else { var mins = ' min '; }

                var hrs_mins = thour + hrs + ' and ' + tmin + mins;
                document.getElementById("leave_"+i).innerHTML = hrs_mins;

                
                var fhours = thour * 60;
                var total_hm = (+fhours) + (+tmin);
                var total = total_hm / 60;
                var deduc = total / 8;
                var deduction = deduc.toFixed(9);
                document.getElementById("deduction_"+i).innerHTML = deduction;
                document.getElementById("deduction"+i).value = deduction;


                if(minimum_hrs=='no_setting' || minimum_hrs <=total_hm || minimum_hrs=="no setting")
                {

                    var schedulehours = document.getElementById('schedule_hours'+i).value;
                    var total_hr_min = total;
                    alert(total_hr_min);
                    if(total_hr_min > schedulehours)
                    {
                      
                        document.getElementById('cdate'+i).value=0;
                        document.getElementById('date'+i).checked=false;
                        document.getElementById('date'+i).disabled=true;
                        document.getElementById('warningerr'+i).innerHTML="Maximum allowed per hour filing is " + schedulehours + "hr/s";
                    }
                    else
                    {
                        document.getElementById('warningerr'+i).innerHTML="";
                        document.getElementById('cdate'+i).value=1;
                        document.getElementById('date'+i).checked=true;
                        document.getElementById('date'+i).disabled=false;
                    }
                }
                else
                {
                    document.getElementById('cdate'+i).value=0;
                    document.getElementById('date'+i).checked=false;
                    document.getElementById('date'+i).disabled=true;
                    document.getElementById('warningerr'+i).innerHTML="Minimum allowed per hour filing is " + minimum_hrs + " min/s";
                }
                
              
            }

            var count = document.getElementById('total_dates').value;
            var datas =0;
                for (i=1;i < count; i++)
                {
                  var checker = document.getElementById('cdate'+i).value;
                  if(checker==1)
                  {
                     var total_deduction = document.getElementById('deduction'+i).value;
                  }
                  else
                  {
                       var total_deduction = 0;
                  }
                  
                  var data_ = (+total_deduction);
                  datas +=data_;
                }
                document.getElementById('total_hours').innerHTML=datas;
                document.getElementById('total_hours_per_form').value=datas;
            
              var leave = document.getElementById('sel1').value;
              var available = document.getElementById('id'+leave).value;
              

              if(available > 0)
              { 
                  if(datas > available)
                  {
                    document.getElementById('with_pay_option').value='invalid';
                    document.getElementById('submit').disabled=true;
                    document.getElementById('warnings').innerHTML="Not enough credit please file "+available + " credit/s only";
                    document.getElementById('with_pay_option_msg').innerHTML="Not enough credit please file "+available + " credit/s only";
                    
                  } 
                  else
                  {
                    document.getElementById('with_pay_option').value='1';
                    document.getElementById('submit').disabled=false;
                    document.getElementById('warnings').innerHTML="No warning/s found";
                    document.getElementById('with_pay_option_msg').innerHTML="with pay";
                  }
              }
              else
              {
                  document.getElementById('with_pay_option').value='0';
                  document.getElementById('submit').disabled=false;
                  document.getElementById('warnings').innerHTML="without pay";
              }

           }

          function isNumberKey(txt, evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 46) {
                //Check if the text already contains the . character
                if (txt.value.indexOf('.') === 0) {
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
</script>


