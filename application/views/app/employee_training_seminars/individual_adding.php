

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sert Technology Inc</title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
     <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
  </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>
<body>
<!-- Start Content Wrapper. Contains page content -->
<div class="content-wrapper2">
<!-- Start Content Header (Page header) -->
  <section class="content-header">
    <h1>
      201 Employee
       <small>Trainings and Seminar</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">201 Employee</a></li>
      <li class="active">Trainings and Seminar</li>
    </ol>
  </section>
  <br>
  <div class="col-md-12">
     <?php echo $message;?>
        <?php echo validation_errors(); ?>
  </div>
   <div class="col-md-12" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result"><br>
            <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Trainings and Seminars
              <a class='btn btn-primary btn-xs pull-right'  href="<?php echo base_url();?>app/employee_training_seminars/individual_adding" style="margin-right: 5px;" >Individual Adding</a>
              <a class='btn btn-danger btn-xs pull-right' href="<?php echo base_url();?>app/employee_training_seminars/mass_adding"  style="margin-right: 5px;" >Mass Adding</a>
              <a class='btn btn-success btn-xs pull-right' href="<?php echo base_url();?>app/employee_training_seminars" style="margin-right: 5px;" >Setting</a>
            </h4></ol>

            <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_training_seminars/save_individual_adding/individual_adding" >
            
                  <div class="col-md-12">
                        <div class="col-md-12">
                            <h4 class="text-danger"><center>Add New Employee Trainings and Seminars</center></h4>
                            <hr>
                            <div class="col-md-12">

                            <div class="col-md-6">
                                <div class="col-md-4"><label>Company</label></div>
                                <div class="col-md-8">
                                  <select class="form-control" id="company" name="company" onchange="get_location(this.value);">
                                    <option value="" disabled selected>Select</option>
                                    <?php foreach($companyList as $comp){?>
                                    <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                            </div>

                             <div class="col-md-6" style="margin-top: 10px;">
                                <div class="col-md-4"><label>Location</label></div>
                                <div class="col-md-8">
                                  <select class="form-control" id="location" name="location">
                                   
                                  </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                 <div class="col-md-4"><label>Employee</div>
                                <div class="col-md-6">
                                  <a data-toggle="modal" data-target="#add_employee"> 
                                      <input type="text" class="form-control" name="employee_name" id="employee_name">
                                  </a>
                                  <input type="hidden" class="form-control" name="employee_id" id="employee_id" required>
                                </div>
                                <div class="col-md-2" id="training_seminar_link">
                                    <a style="font-size:20px;"><i class="fa fa-external-link btn-lg" disabled></i></a>
                                </div>
                            </div>

                             

                             <div class="col-md-6" style="margin-top: 10px;">
                                <div class="col-md-4"><label>Training Type</label></div>
                                <div class="col-md-8">
                                  <select class="form-control" id="training_type" name="training_type" required>
                                    <option value="" disabled selected>Select</option>
                                    <option value="training">Training</option>
                                    <option value="seminar">Seminar</option>
                                  </select>
                                </div>
                            </div>

                            <div class="col-md-6" style="margin-top: 10px;">
                                <div class="col-md-4"><label>Sub Type</label></div>
                                <div class="col-md-8">
                                  <select class="form-control" id="sub_type" name="sub_type" required >
                                    <option value="" disabled selected>Select</option>
                                    <option value="internal">Internal(conducted by the company)</option>
                                    <option value="external">External(conducted by other agency/company)</option>
                                  </select>
                                </div>
                            </div>
                           
                            <div class="col-md-6" style="margin-top: 10px;">
                                 <div class="col-md-4"><label>Title/Topic</label></div>
                                <div class="col-md-8">
                                  <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6" style="margin-top: 10px;">
                                <div class="col-md-4"><label>Purpose/Objective</label></div>
                                <div class="col-md-8">
                                  <input type="text" class="form-control" name="purpose" id="purpose" required> 
                                </div>
                            </div>


                             <div class="col-md-6"  style="margin-top: 10px;">
                                <div class="col-md-4"><label>Conducted by type</label></div>
                                <div class="col-md-8">
                                  <select class="form-control" id="conducted_by_type" name="conducted_by_type" required onchange="view_conducted_by();">
                                    <option value="" disabled selected>Select</option>
                                    <option value="internal">Internal</option>
                                    <option value="external">External</option>
                                  </select>
                                </div>
                            </div>

                            <div class="col-md-6"  style="margin-top: 10px;">
                              <div class="col-md-4"><label>Conducted by</label></div>
                                  <div class="col-md-8" id="div_conducted_by">
                                    <input type="text" class="form-control" name="conducted_by" id="conducted_by">
                              </div>
                            </div>


                            <div class="col-md-6"  style="margin-top: 10px;">
                                <div class="col-md-4"><label>Address Conducted</label></div>
                                <div class="col-md-8">
                                  <input type="text" class="form-control" id="address" name="address" required>
                                </div>
                            </div>
                            <div class="col-md-6"  style="margin-top: 10px;">
                                <div class="col-md-4"><label>Date From</label></div>
                                <div class="col-md-8">
                                  <input type="date" class="form-control" id="date_from" name="date_from" onchange="get_compa(event);"  required>
                                </div>
                            </div>
                            <div class="col-md-6"  style="margin-top: 10px;"> 
                                <div class="col-md-4"><label>Date To</label></div>
                                <div class="col-md-8">
                                  <input type="date" class="form-control" id="date_to" name="date_to" required onchange="get_compa(event);">
                                </div>
                            </div>
                            <div class="col-md-6"  style="margin-top: 10px;">
                                    <div class="col-md-4"><label>Dates</label></div>
                                    <div class="col-md-8">
                                        <div class="text-danger" id="date_list">
                                        <n class="text-danger"><i>Fill up first the date from to date to</i></n>
                                            <input type="hidden" id="selected_dates" value="" required>
                                        </div>
                                    </div>
                            </div>
                             

                            <div class="col-md-6"  style="margin-top: 10px;">
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

                         
                              <div class="col-md-6"  style="margin-top: 10px;display: none;" id="requiredMonthscompany">
                                  <div class="col-md-4"><label>Required length of service <i>(months)</i> to be totally shouldered by the company</label></div>
                                  <div class="col-md-8">
                                     <input type="text" class="form-control" id="requiredmonths" name="requiredmonths" value="0" onkeypress="return isNumberKey(this, event);" required>
                                  </div>
                              </div>


                            <div class="col-md-6"  style="margin-top: 10px;">
                                <div class="col-md-4"><label>Fee Amount</label></div>
                                <div class="col-md-8">
                                  <input type="text" class="form-control" id="fee_amount" name="fee_amount" value="0" onkeypress="return isNumberKey(this, event);" onkeyup ="check_payment_status();" >
                                </div>
                            </div>

                          
                            <div class="col-md-6"  style="margin-top: 10px;">
                                <div class="col-md-4"><label>Payment Status</label></div>
                                <div class="col-md-8">
                                   <select class="form-control" id="payment_status" name="payment_status" required>
                                    <option value="" disabled selected>Select</option>
                                    <option value="paid">Paid</option>
                                     <option value="unpaid">Unpaid</option>
                                    <option value="partial">Partial pay</option>
                                  </select>
                                  <input type="hidden" id="payment_status_final" name="payment_status_final">
                                </div>
                            </div>
                            </div>
                            
                              <div class="col-md-6"  style="margin-top: 10px;">
                                <div class="col-md-12">
                                  <div class="col-md-4"><label>File Attachment</label></div>
                                  <div class="col-md-8">
                                   <input type="file" name="file" id="file">
                                  </div>
                                </div>
                              </div>

                             <div class="col-md-12"  style="margin-top: 10px;">
                                <div class="col-md-12">
                                  <div class="col-md-2"></div>
                                  <div class="col-md-8"><button type="submit" class="col-md-12 btn btn-success pull-right" id="smbt_ind">SAVE</button></div>
                                  <div class="col-md-2"></div>
                                </div>
                            </div>
                        </div>
                </div>


            </form>
              
           
            </div>

            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 

      <div class="modal modal-primary fade" id="add_employee" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h4 class="modal-title" id="myModalLabel">Select Employee</h4>
                  </div>
                   <div class="modal-body">
                      <input onKeyUp="ip_employee_list(this.value)" class="form-control input-sm" name="ccSearch" id="ccSearch" type="text" placeholder="Search here">
                        <span id="add_showSearchResultss"> </span>
                  </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

   
    <!--Start footer-->
    <footer class="footer">
    <div class="container-fluid">
    <br>
    <strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.
    <span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
    </div>
    </footer>
    <!--END footer-->
    <!--//==========Start Js/bootstrap==============================//-->
   <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <!--//==========End Js/bootstrap==============================//-->

<script>
 $(function () {
        $('#table_ts').DataTable({
          "pageLength": -1,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

 function get_location(company)
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
            document.getElementById("location").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars/get_location/"+company,false);
        xmlhttp2.send();
 }
  function ip_employee_list(val)
    {
      var company = document.getElementById('company').value;
      var location = document.getElementById('location').value;
      var search = '-'+val;

     
      if(company=='' || location==''){ alert("Please fill up all fields to continue"); }
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
              document.getElementById("add_showSearchResultss").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars/ip_employee_list/"+company+"/"+location+"/"+search,true);
          xmlhttp.send();
      }
    }
    function ip_select_emp(employee_id,name)
    {
      document.getElementById('employee_name').value=name;
      document.getElementById('employee_id').value=employee_id;
      document.getElementById('ccSearch').value='';
      $("#add_showSearchResultss").load(location.href + " #add_showSearchResultss");

      get_work_sched(employee_id);
    }

    function get_work_sched(employee_id)
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
              document.getElementById("training_seminar_link").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars/get_work_sched/"+employee_id,true);
          xmlhttp.send();
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

</script>
     
