 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center><i class="fa fa-pencil border"></i>Update Training / Seminar</center></h4>
      </div>
    
      <div class="modal-body">
      
         <div class="panel panel-default">
          <div class="panel-heading">
            <strong><a class="text-danger">All fields are required</i></a></strong>
        </div>

        <div class="panel-body">
            
             <form name="edittraining" method="post" action="edit_training" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $training_id?>" name="id" value="id">
              

                <div class="col-md-6 form-group has-feedback">
                    <label>Training Type: </label>
                    <?php if(empty($data1->training_type)){ $training_type = $data->training_type; } else { $training_type =  $data1->training_type; } ?>

                    <select class="form-control" id="training_type" name="training_type" required>
                        <option value="" disabled selected>Select</option>
                        <option value="training" <?php if($training_type=='training'){ echo "selected"; };?>>Training</option>
                        <option value="seminar" <?php if($training_type=='seminar'){ echo "selected"; };?>>Seminar</option>
                    </select>
                </div>

                <div class="col-md-6 form-group has-feedback">
                    <label>Sub Type: </label>
                     <?php if(empty($data1->sub_type)){ $sub_type = $data->sub_type; } else { $sub_type =  $data1->sub_type; } ?>

                    <select class="form-control" id="sub_type" name="sub_type" required="">
                        <option value="" disabled selected>Select</option>
                        <option value="internal"  <?php if($sub_type=='internal'){ echo "selected"; };?>>Internal(conducted by the company)</option>
                        <option value="external"  <?php if($sub_type=='external'){ echo "selected"; };?>>External(conducted by other agency/company)</option>
                    </select> 
                </div>

                <div class="col-md-6 form-group has-feedback">
                    <label>Training/Seminar Title: </label>
                    <input type="text" class="form-control" id="title" name="training_title"  placeholder="Title of the Training"  value="<?php if(empty($data1->training_title)){ echo $data->training_title; } else { echo $data1->training_title; } ?>"  required>
                </div>

                <div class="col-md-6 form-group has-feedback">
                    <label>Conducted By: </label>
                    <input type="text" class="form-control" id="conducted_by" name="conducted_by"  value="<?php if(empty($data1->conducted_by)){ echo $data->conducted_by; } else { echo $data1->conducted_by; } ?>" required>
                </div>

                <div class="col-md-6 form-group has-feedback">
                    <label>Conducted By Type: </label>
                     <?php if(empty($data1->conducted_by_type)){ $conducted_by_type = $data->conducted_by_type; } else { $conducted_by_type =  $data1->conducted_by_type; } ?>

                    <select class="form-control" id="conducted_by_type" name="conducted_by_type"  required>
                        <option value="" disabled selected>Select</option>
                        <option value="internal"  <?php if($conducted_by_type=='internal'){ echo "selected"; };?>>Internal</option>
                        <option value="external"  <?php if($conducted_by_type=='external'){ echo "selected"; };?>>External</option>
                    </select>
                </div>

                <div class="col-md-6 form-group has-feedback">
                    <label>Purpose / Objective:</label>
                    <input type="text" class="form-control"  name="purpose" id="purpose" placeholder="Purpose / Objective" value="<?php if(empty($data1->purpose)){ echo $data->purpose; } else { echo $data1->purpose; } ?>" required>
                </div>

                <div class="col-md-6 form-group has-feedback">
                    <label>Address Conducted:</label>
                    <input type="text" class="form-control" id="address" name="training_address" placeholder="Venue Address" value="<?php if(empty($data1->training_address)){ echo $data->training_address; } else { echo $data1->training_address; } ?>" required>
                </div>

                
                <div class="col-md-6 form-group">
                    <label>Fee Type: *</label><br>
                     <?php if(empty($data1->fee_type)){ $fee_type = $data->fee_type; } else { $fee_type =  $data1->fee_type; } ?>

                    <select class="form-control" id="fee_type" name="fee_type" onchange="payment(this.value);" required>
                        <option value="" disabled selected>Select</option>
                        <option value="company"  <?php if($fee_type=='company'){ echo "selected"; };?>>Company Shoulder</option>
                        <option value="employee" <?php if($fee_type=='employee'){ echo "selected"; };?> >Employee Shoulder</option>
                        <option value="free" <?php if($fee_type=='free'){ echo "selected"; };?>>Free</option>
                    </select>
                 </div>

                  <?php 
                    if(!empty($data1->fee_type))
                      { 
                        if($data1->fee_type=='company'){ $f=''; }
                        else { $f='display:none;'; }
                      }
                        else
                          { 
                            if($data->fee_type=='company'){ $f=''; } else { $f='display:none;'; } 
                          } 
                  ?>
                
                 <?php if($data->fee_type=='free'){ $d='disabled'; } else{  $d=''; }?>
                 <div class="col-md-6 form-group">
                    <label>Fee Amount: *</label><br>
                    <input type="text" id="fee_amount" name="fee_amount" class="form-control" value="<?php if(empty($data1->fee_amount)){ echo $data->fee_amount; } else { echo $data1->fee_amount; } ?>"   onkeypress="return isNumberKey(this, event);" onkeyup ="check_payment_status();"  <?php echo $d;?>>
                 </div>

                 <?php if($data->fee_type=='free'){ $d='disabled'; } else{  $d=''; }?>
                 <div class="col-md-6 form-group">
                    <label>Payment Status: *</label><br>
                     <?php if(empty($data1->payment_status)){ $payment_status = $data->payment_status; } else { $payment_status =  $data1->payment_status; } ?>

                    <select class="form-control" id="payment_status" name="payment_status" <?php echo $d;?>>
                        <option value="paid" <?php if($payment_status=='paid'){ echo "selected"; };?>>Paid</option>
                        <option value="partial"<?php if($payment_status=='partial'){ echo "selected"; };?>>Partial pay</option>
                    </select>
                     <input type="hidden" id="payment_status_final" name="payment_status_final">
                 </div>


                <div class="col-md-6 form-group has-feedback">
                    <label>Certification Image: <small><i>Accepted Files: PNG, JPG, GIF | File size must not exceed 500 KB</i></small></label>
                    <input type="file" class="btn btn-info" id="file" name="file">
                </div>


                <div class="col-md-6 form-group">
                    <label>Date From: *</label><br>
                    <input type="date" id="date_from" name="date_from" class="form-control" value="<?php if(empty($data1->datefrom)){ echo $data->datefrom; } else { echo $data1->date_from; } ?>"   required onchange="get_compa(event,'<?php echo $data->training_seminar_id;?>');">
                 </div>

                
                <div class="col-md-6 form-group">
                    <label>Date To: *</label><br>
                    <input type="date" id="date_to" name="date_to" value="<?php if(empty($data1->date_to)){ echo $data->dateto; } else { echo $data1->dateto; } ?>"    class="form-control" required onchange="get_compa(event,'<?php echo $data->training_seminar_id;?>');">
                </div>



                  <div class="col-md-12"  style="margin-top: 10px;">
                  <div class="col-md-12">
                    <div class="col-md-2"></div>
                        <div class="col-md-8">
                                        <div class="text-danger" id="date_list">
                                        <?php 
                                              $dates = $this->employee_201_model->get_date_orig($data->training_seminar_id);
                                              $dates_upd = $this->employee_201_model->get_date_upd($data->training_seminar_id);

                                              if(!empty($dates_upd))
                                              {
                                                $g= $dates_upd;
                                              }
                                              else
                                              {
                                                $g= $dates;
                                              }
                                        ?>
                                           
                                                <table class="table table-hover">
                                                <thead>
                                                    <tr class="danger">
                                                        <th>Date</th>
                                                        <th>Time From</th>
                                                        <th>Time In</th>
                                                        <th>Hours</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     <?php 
                                                          $string="";
                                                          $i=1; foreach($g as $d){
                                                          $datee = $d->date;
                                                          $string .= $i."=";
                                                      ?>
                                                        <tr>
                                                              <td>
                                                                  <input type="checkbox" onclick="checker_date_range('<?php echo $i;?>');" class="dateclass" checked> <?php echo $d->date;?> 
                                                                  <input type="hidden" name='date_<?php echo $i?>' id='date_<?php echo $i?>' value='<?php echo $d->date;?>'>
                                                                  <input type='hidden' id="checker<?php echo $i;?>" value='1'> 
                                                              </td>
                                                              
                                                              <td>  <input type="time" style="width: 90%;font-color:red;" name='time_from<?php echo $i?>' id='time_from<?php echo $i?>' class="classtimefrom" value="<?php echo $d->time_from;?>">  </td>
                                                              <td>  <input type="time" style="width: 90%;" name='time_to<?php echo $i?>' id='time_to<?php echo $i?>' class="classtimeto" value="<?php echo $d->time_to;?>"> </td>

                                                              <td>  
                                                                  <input type="number" style="width: 50%;" name='hour<?php echo $i;?>' id='hour<?php echo $i?>' class="classhour" placeholder="Hours" value="<?php echo $d->hours;?>">
                                                              </td>
                                                                
                                                        </tr>
                                                    <?php $i++; } ?>
                                                </tbody>
                                            </table>
                                            </center>
                                             <input type="hidden" id="count_dates" value="<?php echo $i;?>">
                                             <input type="hidden" id="selected_dates"  name="selected_dates" value="<?php echo $string;?>" class="form-control" required>

                                        </div>
                        </div>
                         <div class="col-md-2"></div>
                    </div>
                  </div>
             

                  <br><br>
            <div class="col-md-6" style="padding-top: 20px;"><button type="submit" class="btn btn-success btn-block" ng-disabled="edittraining.$invalid" id="smbt_ind"><i class="fa fa-save"></i> Save Changes</button></div>
            <div class="col-md-6" style="padding-top: 20px;"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>

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