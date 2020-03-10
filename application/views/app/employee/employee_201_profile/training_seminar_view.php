<?php include('header.php');?>

  <div id="col_2">
    <div class="row">
      <div class="col-md-8">
        <div class="box box-success">
          <div class="panel panel-success">
            <div  class="panel-heading"><strong>TRAINING AND SEMINAR ATTAINMENT</strong>

                <?php if($checker_inactive==0){?>
                      <a onclick="training_seminar_add('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a>
                <?php } ?>
            </div>

            <?php  if(count($employee_training_seminar) == 0){ ?>
                <div style="height: 553px;overflow-y: scroll;">
                  <div>
                      <div class="force-overflow">
                        <div class="col-md-12">
                            <h4 class="text-danger"><br><br><center><i class="fa fa-exclamation-circle"></i>No Trainings and Seminars found.</center></h4>
                        </div>
                      </div>
                  </div>
                </div>
            <?php } else{?>
            <div style="height: auto;overflow-y: scroll;">
                  <div><br>
                      <div class="force-overflow">
                        <div class="col-md-12">

                            <?php foreach($employee_training_seminar as $training_seminar){ ?>
                              <div class="col-md-12"><label>Topic : <?php echo $training_seminar->training_title; ?></label>

                                    <?php if($training_seminar->file_name!=null){ ?>
                                         <a href="<?php echo base_url(); ?>app/employee_201_profile/download_training_certificate/<?php echo $training_seminar->file_name; ?>"
                                         class="fa fa-download fa-lg text-info pull-right" title="Download Certificate" ></a>
                                    <?php } ?>

                                    <?php if($checker_inactive==0){?>
                                      <a  class="fa fa-trash fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/employee_201_profile/training_seminar_delete/'. $training_seminar->training_seminar_id.''); ?>" onClick="return confirm('Are you sure you want to delete?')"></a>
<?php
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
?>
                                      <i  class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="training_seminar_edit('<?php echo $training_seminar->training_seminar_id; ?>')"></i>

                                    <?php } } ?>

                                    <div class="box box-success"></div>
                                    <div class="row">

                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <div class="col-sm-4">
                                                <p>Training Type</p>
                                              </div>
                                              <div class="col-sm-7">
                                                  <label><?php echo $training_seminar->training_type;?></label>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <div class="col-sm-4">
                                                <p>Sub Type</p>
                                              </div>
                                              <div class="col-sm-7">
                                                <label><?php echo $training_seminar->sub_type;?></label>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <div class="col-sm-4">
                                                <p>Purpose</p>
                                              </div>
                                              <div class="col-sm-7">
                                                <label><?php echo $training_seminar->purpose;?></label>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <div class="col-sm-4">
                                                <p>Conducted Type</p>
                                              </div>
                                              <div class="col-sm-7">
                                                <label><?php echo $training_seminar->conducted_by_type;?></label>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <div class="col-sm-4">
                                                <p>Conducted by</p>
                                              </div>
                                              <div class="col-sm-7">
                                                <label><?php echo $training_seminar->conducted_by;?></label>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <div class="col-sm-4">
                                                <p>Address</p>
                                              </div>
                                              <div class="col-sm-7">
                                                <label><?php echo $training_seminar->training_address;?></label>
                                              </div>
                                            </div>
                                          </div>


                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <div class="col-sm-4">
                                                <p>Fee Type</p>
                                              </div>
                                              <div class="col-sm-7">
                                                <label><?php  if($training_seminar->fee_type=='employee'){ echo "Shoulder by employee"; } else if($training_seminar->fee_type=='free'){ echo "Free"; } else{ echo "Shoulder by company"; } ?></label>
                                              </div>
                                            </div>
                                          </div>

                                          <?php if($training_seminar->fee_type!='free'){?>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <div class="col-sm-4">
                                                <p>Fee Amount</p>
                                              </div>
                                              <div class="col-sm-7">
                                                <label><?php echo number_format($training_seminar->fee_amount,2);?></label>
                                              </div>
                                            </div>
                                          </div>


                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <div class="col-sm-4">
                                                <p>Payment Status</p>
                                              </div>
                                              <div class="col-sm-7">
                                                <label><?php echo $training_seminar->payment_status;?></label>
                                              </div>
                                            </div>
                                          </div>

                                          <?php }  if($training_seminar->fee_type=='company') {?>

                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <div class="col-sm-12">
                                                <p>Required length of service to be totally shouldered by the company :
                                                 <label><b><?php if($training_seminar->monthsRequired==0){ echo "No required month"; } else { echo $training_seminar->monthsRequired." Months"; } ?></b></label>
                                                </p>
                                            </div>
                                            </div>
                                          </div>

                                          <?php } ?>

                                       <div class="col-md-12">
                                        <div class="form-group">
                                          <div class="col-sm-12">
                                            <?php  $dates = $this->employee_201_profile_model->get_all_dates($training_seminar->training_seminar_id); ?>
                                            <table class="table table-bordered" id="bb<?php echo $training_seminar->training_seminar_id;?>">
                                                <thead>
                                                    <tr class="danger">
                                                        <th>Date</th>
                                                        <th>Time From</th>
                                                        <th>Time In</th>
                                                        <th>Time Hours</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($dates as $d){?>
                                                    <tr>
                                                        <td>
                                                            <?php 
                                                                $month=substr($d->date, 5,2);
                                                                $day=substr($d->date, 8,2);
                                                                $year=substr($d->date, 0,4);

                                                                echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                                            ?>

                                                        </td>
                                                        <td><?php echo $d->time_from;?></td>
                                                        <td><?php echo $d->time_to;?></td>
                                                        <td><?php echo $d->hours;?></td>
                                                    </tr>
                                                <?php } ?>
                                                 <tr>
                                                        <td colspan='4' ><n class="text-danger pull-right"><center>Total Hours:&nbsp;&nbsp;<b><?php echo $training_seminar->total_hours;?></center></b></n> </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>



                                    </div>

                              </div>
                            <?php } ?>


                        </div>
                      </div>
                  </div>
              </div>
          <?php } ?>
          </div> 
        </div>
      </div>
    </div>
  </div>  

  <div class="modal modal-primary fade" id="add_conducted_by_type" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
                 <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                       <h4 class="modal-title" id="myModalLabel">Select Employee</h4>
                    </div>
                     <div class="modal-body">
                        <input onKeyUp="ip_conducted_by_type(this.value)" class="form-control input-sm" name="conductedSearch" id="conductedSearch" type="text" placeholder="Search here">
                          <span id="add_showSearchConducted"> </span>
                    </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>                          
           </div>
        </div>
  </div>

<?php include('footer.php');?>

<script type="text/javascript">

      function training_seminar_add(val)
      {          

        var today = new Date();
        var dd    = today.getDate();
        var mm    = today.getMonth()+1;
        var yyyy  = today.getFullYear();

        if(dd<10) {
            dd = '0'+dd
        } 

        if(mm<10) {
            mm = '0'+mm
        } 

        currentdate = yyyy + '-' + mm + '-' + dd;

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
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            $('#date_start').Zebra_DatePicker({
                direction: ['1852-01-01', currentdate],
                pair: $('#date_end')
            });
            $('#date_end').Zebra_DatePicker({
                  direction: [true,currentdate]
            });

          }
        }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/training_seminar_add/"+val,true);
        xmlhttp.send();
      }

      function training_seminar_edit(val)
      {          

        var today = new Date();
        var dd    = today.getDate();
        var mm    = today.getMonth()+1;
        var yyyy  = today.getFullYear();

        if(dd<10) {
            dd = '0'+dd
        } 

        if(mm<10) {
            mm = '0'+mm
        } 

        currentdate = yyyy + '-' + mm + '-' + dd;

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
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            $('#date_start').Zebra_DatePicker({
                direction: ['1852-01-01', currentdate],
                pair: $('#date_end')
            });
            $('#date_end').Zebra_DatePicker({
                  direction: [true,currentdate]
            });

          }
        }

        xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/training_seminar_edit/"+val,true);
        xmlhttp.send();

      }

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

      function payment(val)
      {
        if(val=='free' || val=='company')
        {
           document.getElementById('fee_amount').disabled=true;
           document.getElementById('payment_amount_given').disabled=true;
        } 
        else
        {
           document.getElementById('fee_amount').disabled=false;
           document.getElementById('payment_amount_given').disabled=false;
           var fee_amount = document.getElementById('fee_amount').value;
           var payment_amount_given = document.getElementById('payment_amount_given').value;

          if(payment_amount_given > fee_amount)
          {
             alert("Fee Amount must greater or equal to Payment amount given");
             document.getElementById('smbt_ind').disabled=true;
          }
          else
          {
             document.getElementById('smbt_ind').disabled=false;
          }
        }
      }

      function get_compa(val)
      { 
          var from_date = document.getElementById('date_from').value;
          var to_date = document.getElementById('date_to').value;

          if(to_date==''){ var res = 'true'; }
          else
          {

            if(from_date < to_date || from_date==to_date){ var res ='true'; }
            else { var res='false'; }
          }

          if(res=='false')
          {
            alert('Date to must be greater than the from date');
            document.getElementById('smt_btn').disabled=true;
          }
          else
          {
             document.getElementById('smt_btn').disabled=false;
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

      function get_compan(val)
      { 
          var from_date = document.getElementById('date_from').value;
          var to_date = document.getElementById('date_to').value;
          var seminarid = document.getElementById('seminarid').value;
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
                  get_datess(from_date,to_date,'date_list',seminarid);
                 
              }
          }

      }

      function get_datess(from_date,to_date,type,seminarid)
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
          xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/employee_get_datess/"+from_date+"/"+to_date+"/"+type+"/"+seminarid,true);
          xmlhttp.send();
      }

      function view_conducted_by()
      {
        var conducted_by_type = document.getElementById('conducted_by_type').value;
        
          
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
                document.getElementById("div_conducted_by").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars/view_conducted_by/"+conducted_by_type,true);
            xmlhttp.send();
       
      }

      function ip_conducted_by_type(val)
      {
        var company = document.getElementById('company').value;
        var location ='all';

        var search = '-'+val;

        if(company==''){ alert("Please fill up all company to continue"); }
        else{
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
                document.getElementById("add_showSearchConducted").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars/ip_conducted_by_type/"+company+"/"+location+"/"+search,true);
            xmlhttp.send();
        }
      }

      function ip_select_conducted_by(id,name)
      {
        document.getElementById('conducted_by_employee').value=id;
        document.getElementById('conducted_by').value=name;
      }

      function payment(val)
      {
        if(val=='free')
        {
          
           document.getElementById('requiredmonths').disabled=true;
           document.getElementById('fee_amount').disabled=true;
           document.getElementById('payment_status').disabled=true;
           document.getElementById('requiredmonths').value=0;
        } 
        else if(val=='company')
        {
          document.getElementById('requiredmonths').disabled=false;
          document.getElementById('fee_amount').disabled=false;
          document.getElementById('payment_status').disabled=false;
        }
        else
        {
           document.getElementById('requiredmonths').disabled=true;
           document.getElementById('fee_amount').disabled=false;
           document.getElementById('payment_status').disabled=false;
           document.getElementById('requiredmonths').value=0;
        }
          
      }

      function get_all_trainings_individual(vall,type)
      {

        var company_id = document.getElementById('company').value;
        var sub_type = document.getElementById('sub_type').value;
        var val = document.getElementById('training_type').value;

        if(company_id==''){ alert("Fill up company to continue"); }
        else if(val=='' || sub_type==''){ alert("Please fill up the training type and sub type for training and seminars list"); }
        else 
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
                document.getElementById("title").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/get_all_trainingslist_filemaintenance/"+company_id+"/"+val+"/"+sub_type+"/"+type,true);
            xmlhttp.send();
        }
      }

      function get_all_trainings_details(training_id)
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
                document.getElementById("for_training_details").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/get_all_trainings_details/"+training_id,true);
            xmlhttp.send();
      }


     function payment_file_maintenance(val)
      {
          if(val=='free')
          {
             document.getElementById('requiredmonths').disabled=true;
             document.getElementById('fee_amount').disabled=true;
             document.getElementById('payment_status').disabled=true;
             document.getElementById('requiredmonths').value=0;
          } 
          else if(val=='company')
          {
             document.getElementById('requiredmonths').disabled=false;
             document.getElementById('fee_amount').disabled=false;
             document.getElementById('payment_status').disabled=false;
          }
          else
          {
             document.getElementById('requiredmonths').disabled=true;
             document.getElementById('fee_amount').disabled=false;
             document.getElementById('payment_status').disabled=false;
             document.getElementById('requiredmonths').value=0;
          }
      }

      function get_compan_file_maintenance(val)
      { 

          var from_date = document.getElementById('date_from').value;
          var to_date = document.getElementById('date_to').value;
          var seminarid = document.getElementById('seminarid').value;


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
                  get_datess_file_maintenance(from_date,to_date,'date_list',seminarid);
                 
              }
          }

      }

      function get_datess_file_maintenance(from_date,to_date,type,seminarid)
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
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/get_datess_incoming_file_maintenance/"+from_date+"/"+to_date+"/"+type+"/"+seminarid,true);
            xmlhttp.send();
      } 


</script>
