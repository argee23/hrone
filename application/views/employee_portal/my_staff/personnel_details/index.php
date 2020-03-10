

    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script> 
    <div class="content-wrapper2">
      <section class="content-header">
        <h1>
          <br>
          Reports
           <small>Attendance Report</small>
        </h1>
       <ol class="breadcrumb">
          <br>
          <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="">Reports</a></li>
          <li class="active">Working Schedule Reports</li>
        </ol>
      </section>
     <div class="col-md-12"><?php echo $message;?></div>
     <div class="col-md-3" style="padding-bottom: 50px;margin-top: 10px;"> 
      <div class="box box-success box-solid">

            <div class="box-body" id="quickview">              
              <br>
              <ul class="nav nav-pills nav-stacked">  
                    <li class="bg-success">CRYSTAL REPORT</li>
                      <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onClick="window.location.reload();"><i class='fa fa-list'></i> Manage Crystal Report <span></span></a></li>
                      <li class="bg-success">GENERATE REPORT</li>
                      <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="date_range_report();"><i class='fa fa-calendar'></i> <span> Date Range Report</span></a></li>
                      <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="payroll_period_report();"><i class='fa fa-calendar'></i> <span>Payroll Period Report</span></a></li>
                       <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="employment_report();"><i class='fa fa-calendar'></i> <span>Employment Report</span></a></li>
                </ul>
                
                <br><br>
            </div>
      </div>
    </div> 

  <div class="col-md-9" style="padding-bottom: 50px;padding-top: 10px;" id="action"> 
    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i>CRYSTAL REPORT LIST</b></n></a></li>
          </ul>
      </div>
      <div class="col-md-12" style="padding-top: 30px;" id="all_action">
              <div class="col-md-12" style="margin-bottom: 10px;"><button class="btn btn-success btn-xs pull-right" onclick="add_crystal_report();"><i class="fa fa-plus"></i>ADD CRYSTAL REPORT</button></div>
              <div class="col-md-12">
                <table class="table table-hover" id="crystal_report">
                    <thead>
                          <tr class="danger">
                              <th>No</th>
                              <th>Crystal Report</th>
                              <th>Description</th>
                              <th>Date Added</th>
                              <th>Action</th>
                          </tr>
                    </thead>
                    <tbody>
                     
                    </tbody>
                </table>
              </div>   
            <div class="col-md-12" id="main_action" style="margin-top: 30px;"></div>
      </div>
      <div class="panel panel-info"><div class="btn-group-vertical btn-block"> </div></div>             
    </div> 
  </div> 
 
  <script type="text/javascript">
   
   $(function () {
        $('#crystal_report').DataTable({
          "pageLength": 6,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
  
     function reset()
       {
          var count= document.getElementById("crystal_fields").value;
          var checks = document.getElementsByClassName("option_check");
          var data=document.getElementById('ccc').value;
          if(data == '0'){ res = true; document.getElementById('ccc').value='1'; } 
          else{ res = false;  document.getElementById('ccc').value='0'; }
          for (i=0;i < count; i++)
          {
             document.getElementById("r_" + i).checked=res;
          }     
       }

  function add_crystal_report()
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
                document.getElementById("all_action").innerHTML=xmlhttp.responseText;
                }
              }
      xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_attendance/add_crystal_report/",true);
      xmlhttp.send();
  
  }

   function  action_crystal_report(action,crystal_id)
  {
        msg = 'Are you sure you want to ' + action + ' ID - ' + crystal_id; 
        var result = confirm(msg);
        if(result == true)
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
                        location.reload();
                      }
                    }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_attendance/action_crystal_report/"+action+"/"+"/"+crystal_id,true);
            xmlhttp.send();
        }
  }

   function viewupdate_crystal_report(action, crystal_id)
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
                          document.getElementById("all_action").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_attendance/viewupdate_crystal_report/"+action+"/"+crystal_id,true);
              xmlhttp.send();
   }

   function date_range_report()
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
                          document.getElementById("action").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_attendance/date_range_report/",true);
              xmlhttp.send();
   }

   function payroll_period_report()
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
                          document.getElementById("action").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_attendance/payroll_period_report/",true);
              xmlhttp.send();
   }

   function pp_get_paytypegroup()
   {  
      var company  = document.getElementById('company').value;
      var pay_type = document.getElementById('paytype').value;

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
                          document.getElementById("paytypegroup").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_attendance/pp_get_paytype_group/"+company+"/"+pay_type,true);
              xmlhttp.send();

   }


   function pp_get_payroll_period(group)
   {
      var company  = document.getElementById('company').value;
      var pay_type = document.getElementById('paytype').value;

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
                          document.getElementById("payrollperiod").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_attendance/pp_get_payroll_period/"+company+"/"+pay_type+"/"+group,true);
              xmlhttp.send();

   }

   function employment_report()
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
                          document.getElementById("action").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_attendance/employment_report/",true);
              xmlhttp.send();
   }

   function emp_get_department(value)
   {
    if(value=='All')
    {
        document.getElementById('company').value="All";
        document.getElementById('department').value="All";
        document.getElementById('section').value="All";
        document.getElementById('classification').value="All";
        document.getElementById('location').value="All";



        document.getElementById('department').disabled=true;
        document.getElementById('section').disabled=true;
        document.getElementById('classification').disabled=true;
        document.getElementById('location').disabled=true;
    }
    else
    {
        document.getElementById('department').disabled=false;
        document.getElementById('classification').disabled=false;
        document.getElementById('location').disabled=false;

        get_department(value);
        get_location(value);
        get_classification(value);
    }
   }


  function get_classification(company)
  {
    var xmlhttp;
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
                          document.getElementById("classification").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_attendance/get_classification/"+company,true);
              xmlhttp.send();
  }


  function get_location(company)
  {
    var xmlhttp;
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
                          document.getElementById("location").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_attendance/get_location/"+company,true);
              xmlhttp.send();
  }

  function get_department(company)
  {
     var xmlhttp;
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
                          document.getElementById("department").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_attendance/get_department/"+company,true);
              xmlhttp.send();
  }

  function emp_get_section(department)
  {
    if(department=='All')
    {
      document.getElementById('section').value='All';
      document.getElementById('section').disabled=true;
    }
    else {
      var company  = document.getElementById('company').value;
      document.getElementById('section').disabled=false;
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
                          document.getElementById("section").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_attendance/emp_get_section/"+company+"/"+department,true);
              xmlhttp.send();
    }
  }
 </script>