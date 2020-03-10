
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
      <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    <!-- Start Content Wrapper. Contains page content -->
    <div class="content-wrapper2">
    <!-- Start Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <br>
           Reports
           <small>Form Approval Reports</small>
        </h1>
       <ol class="breadcrumb">
          <br>
          <li><a href="<?php echo base_url()?>employee_portal/employee_dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="">Reports</a></li>
          <li class="active">Form Approval Reports</li>
        </ol>
      </section>

      <div class="col-md-12"><?php echo $message;?></div>
     <div class="col-md-3" style="padding-bottom: 50px;margin-top: 10px;"> 
      <div class="box box-solid box-success">
        <div class="box-header">
          <h5 class="box-title">Form Transactions</h5>
          <span class="pull-right"><div class="box-tools"></div></span></div>
          <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark"">
            <ul class="nav nav-pills nav-stacked" >
             
             <?php foreach($transaction as $f){?> 
                <li class="my_hover">
                      <a data-toggle="tab" style="cursor: pointer;" onclick="get_transaction('<?php echo $f->form_id;?>','<?php echo $f->form_identification;?>');"><?php echo $f->form_name;?></a>
                </li>
             <?php } ?>
          </ul>
        </div>
      </div>
    </div> 

    <div class="col-md-9" style="padding-bottom: 50px;padding-top: 10px;"  id="main_action"> 
    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i>CRYSTAL REPORT</b></n>  </a></li>
          </ul>
      </div>
      <div class="col-md-12" style="margin-top: 20px;">
        <div class="col-md-12">
          <table class="table table-hover" id="crystal_report">
              <thead>
                    <tr class="danger">
                        <th>No</th>
                        <th>Transaction</th>
                        <th>Crystal Report</th>
                        <th>Description</th>
                        <th>Date Added</th>
                    </tr>
              </thead>
              <tbody>
                <?php $i=1; foreach($crystal_report as $c){?>

                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $c->form_name;?></td>
                        <td><?php echo $c->title;?></td>
                        <td><?php echo $c->description;?></td>
                        <td><?php echo $c->date_created;?></td>
                       
                    </tr>

                <?php $i++; } ?>
              </tbody>
          </table>
        </div>
      </div>
      <div class="panel panel-info">
          <div class="btn-group-vertical btn-block"> </div> 
      </div>             
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

  function get_transaction(id,identification)
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
                document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                 $("#crystal_report").DataTable({
                        lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]]             
                        });
                }
              }
      xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_form_approval/get_transaction/"+id+"/"+identification,true);
      xmlhttp.send();
  }


  function add_crystal_report(id,identification)
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
                document.getElementById("crystal_report_main").innerHTML=xmlhttp.responseText;
                }
              }
      xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_form_approval/add_crystal_report/"+id+"/"+identification,true);
      xmlhttp.send();
  }

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


  function  action_crystal_report(action, id, identification, crystal_id)
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
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_form_approval/action_crystal_report/"+action+"/"+id+"/"+identification+"/"+crystal_id,true);
            xmlhttp.send();
        }
  }


   function viewupdate_crystal_report(action, id, identification, crystal_id)
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
                          document.getElementById("crystal_report_main").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_form_approval/viewupdate_crystal_report/"+action+"/"+id+"/"+identification+"/"+crystal_id,true);
              xmlhttp.send();
   }

   function generate_report(id,identification)
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
                document.getElementById("crystal_report_main").innerHTML=xmlhttp.responseText;
                }
              }
      xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_form_approval/generate_report/"+id+"/"+identification,true);
      xmlhttp.send();
   }

   function generate_report_employment(id,identification)
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
                document.getElementById("crystal_report_main").innerHTML=xmlhttp.responseText;
                }
              }
      xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_form_approval/generate_report_employment/"+id+"/"+identification,true);
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
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_form_approval/get_classification/"+company,true);
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
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_form_approval/get_location/"+company,true);
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
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_form_approval/get_department/"+company,true);
              xmlhttp.send();
  }

  function emp_get_section(department)
  {
      if(department=='All')
      {
        document.getElementById('section').value='All';
        document.getElementById('section').disabled=true;
      }
      else
      {
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
                xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_form_approval/emp_get_section/"+company+"/"+department,true);
                xmlhttp.send();
    }
  }
  
 </script>