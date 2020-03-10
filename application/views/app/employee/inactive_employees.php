<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    201 Employee Files
    <small>Employees Masterlist (Inactive employee)</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>201 Employee Files</li>
    <li>Employees Masterlist</li>
    <li class="active">Inactive employees</li>
  </ol>
</section>

      <!-- <div class="container-fluid"> --><section class="content">
      <!-- ===================================================================================== -->
      
              <?php echo $message;?>
              <?php echo validation_errors(); ?>
              <div class="box box-danger">
              <br>
                <div class="box-header">
                <!-- <h3 class="box-title"></h3> -->
                <div class="btn-toolbar">
                <!--  class="btn-toolbar/M11" -->

                
                  <a href="<?php echo base_url().'app/employee/index';?>" type="button" class="btn btn-primary btn-xs btn pull-right" title="View Inactive Employee" ><i class="fa fa-user"></i>  Active Employee</a>


                  </div><!-- /.btn-toolbar/M11 -->


                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="collapse" id="filter">
                    <!-- <form class="" name="myForm"> -->
                    <div class="well">


                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="company">Company</label>
                          <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="getLocation(this.value); applyFiltercompany();">
                            <option selected="selected" value="0">-All Company-</option>
                            <?php 
                              foreach($companyList as $company){
                              if($_POST['company'] == $company->company_id){
                                  $selected = "selected='selected'";
                              }else{
                                  $selected = "";
                              }
                              ?>
                              <option value="<?php echo $company->company_id;?>" <?php echo $selected;?>><?php echo $company->company_name;?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="department">Department</label>
                          <select class="form-control select2" name="department" id="department" style="width: 100%;" onchange="getSection(this.value); applyFilterdepartment();">
                            <option selected="selected" value="0">-All Departments-</option>
                            <?php 
                              foreach($departmentList as $department){
                              if($_POST['department'] == $department->department_id){
                                  $selected = "selected='selected'";
                              }else{
                                  $selected = "";
                              }
                              ?>
                              <option value="<?php echo $department->department_id;?>" <?php echo $selected;?>><?php echo $department->dept_name;?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Employment Type</label>
                          <select class="form-control select2" name="employment" id="employment" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="0">-All Employments-</option>
                            <?php 
                              foreach($employmentList as $employment){
                              if($_POST['employment'] == $employment->employment_id){
                                  $selected = "selected='selected'";
                              }else{
                                  $selected = "";
                              }
                              ?>
                              <option value="<?php echo $employment->employment_id;?>" <?php echo $selected;?>><?php echo $employment->employment_name;?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>


                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Classification</label>
                          <select class="form-control select2" name="classification" id="classification" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="0">-All Classifications-</option>
                            <?php 
                              foreach($classificationList as $classification){
                              if($_POST['classification'] == $classification->classification_id){
                                  $selected = "selected='selected'";
                              }else{
                                  $selected = "";
                              }
                              ?>
                              <option value="<?php echo $classification->classification_id;?>" <?php echo $selected;?>><?php echo $classification->classification;?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>

                      </div>

                      <div class="row">

                      <div class="col-md-3">
                         <div id="location">
                         </div>
                      </div>

                      <div class="col-md-3">
                         <div id="section">
                         </div>
                      </div>

                      </div>



                  <!--   </div> -->
<script>   
    var templocation = 0;
    var tempsection = 0;
    function applyFilter()
        {  

        var company = document.getElementById("company").value;
        var location = templocation;
        var department = document.getElementById("department").value;
        var section = tempsection;
        var classification = document.getElementById("classification").value;
        var employment = document.getElementById("employment").value;
        var status = document.getElementById("status").value;
            
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
            
            document.getElementById("search_here").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee/search/"+company+"/"+location+"/"+department+"/"+section+"/"+classification+"/"+employment+"/"+status,false);
        xmlhttp.send();


        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });

        }

        function applyFiltercompany()
        {  

        var company = document.getElementById("company").value;
        var location = 0;
        var department = document.getElementById("department").value;
        var section = tempsection;
        var classification = document.getElementById("classification").value;
        var employment = document.getElementById("employment").value;
        var status = document.getElementById("status").value;
        templocation = location;
            
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
            
            document.getElementById("search_here").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee/search/"+company+"/"+location+"/"+department+"/"+section+"/"+classification+"/"+employment+"/"+status,false);
        xmlhttp.send();


        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });

        }

        function applyFilterdepartment()
        {  

        var company = document.getElementById("company").value;
        var location = templocation;
        var department = document.getElementById("department").value;
        var section = 0;
        var classification = document.getElementById("classification").value;
        var employment = document.getElementById("employment").value;
        var status = document.getElementById("status").value;
        tempsection = section;
            
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
            
            document.getElementById("search_here").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee/search/"+company+"/"+location+"/"+department+"/"+section+"/"+classification+"/"+employment+"/"+status,false);
        xmlhttp.send();


        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });

        }

        function applyFilterlocation(val)
        {  

        var company = document.getElementById("company").value;
        var location = val;
        var department = document.getElementById("department").value;
        var section = tempsection;
        var classification = document.getElementById("classification").value;
        var employment = document.getElementById("employment").value;
        var status = document.getElementById("status").value;
        templocation = val;

            
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
            
            document.getElementById("search_here").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee/search/"+company+"/"+location+"/"+department+"/"+section+"/"+classification+"/"+employment+"/"+status,false);
        xmlhttp.send();


        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
        

        }

        
        function applyFiltersection(val)
        {  

        var company = document.getElementById("company").value;
        var location = templocation;
        var department = document.getElementById("department").value;
        var section = val;
        var classification = document.getElementById("classification").value;
        var employment = document.getElementById("employment").value;
        var status = document.getElementById("status").value;
        tempsection = val;
            
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
            
            document.getElementById("search_here").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee/search/"+company+"/"+location+"/"+department+"/"+section+"/"+classification+"/"+employment+"/"+status,false);
        xmlhttp.send();


        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
        

        }

        function getLocation(val)
        {  
            
        if (window.XMLHttpRequest)
          {
          xmlhttp1=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp1.onreadystatechange=function()
          {
          if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
            {
            
            document.getElementById("location").innerHTML=xmlhttp1.responseText;
            }
          }
        xmlhttp1.open("GET","<?php echo base_url();?>app/employee/get_company_locations_demography/"+val,true);
        xmlhttp1.send();

        }

        function getSection(val)
        {  
            
        if (window.XMLHttpRequest)
          {
          xmlhttp1=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp1.onreadystatechange=function()
          {
          if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
            {
            
            document.getElementById("section").innerHTML=xmlhttp1.responseText;
            }
          }
        xmlhttp1.open("GET","<?php echo base_url();?>app/employee/get_department_sections_demography/"+val,true);
        xmlhttp1.send();

        }

    </script>
                    <div class="row">

                      <div class="col-md-3">                        
                        <div class="form-group">
                          <label>Status</label>
                          <select class="form-control select2" id="status" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="2">-All Status-</option>
                            <option value="0">Applicant</option>
                            <option value="1">Employee</option>
                          </select>
                        </div><!-- /.form-group -->
                      </div>

                      <div class="col-md-3"></div>

                      <div class="col-md-3"></div>

                      <div class="col-md-3"></div>

                    </div>
                    

                    <!-- </form> -->

                    </div> <!-- end well -->

                  </div>
                  <div id="search_here">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Emp. ID</th>
                        <th>Employee Name</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Department</th>
                        <th>Section</th>
                        <th>Options</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($employee as $employee){ ?>

                      <tr>
                        <td><?php echo $employee->employee_id?></td>
                        <td><?php echo $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name.' '.$employee->name_extension; ?></td>
                        <td><?php echo $employee->company_name;?></td>
                        <td><?php echo $employee->location_name;?></td>
                        <td><?php echo $employee->department_name;?></td>
                        <td><?php echo $employee->section_name;?></td>
                        <td>  

                            <a href="<?php echo base_url(); ?>app/employee/employee_profile/<?php echo $employee->employee_id?>"><i class="fa fa-file-text fa-lg" style="color:blue;" class="hidden"  data-toggle="tooltip" data-placement="left" title="View <?php echo $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name.' '.$employee->name_extension; ?>'s 201 Record" ></i>
                            </a>

                          
                            <a href="#myModal" data-toggle="modal" id="<?php echo $employee->employee_id; ?>" data-target="#activate-employee"
                            <i  class="<?php echo $deactivate_employee;?> fa fa-power-off fa-lg" style="color:red;" class="hidden"  data-toggle="tooltip" data-placement="left" title="Activate employee"></i></a>


                        </td>
                      </tr>
                      <?php }?>
                    </tbody>
                  </table>
                  </div>
                </div><!-- /.box-body -->

              </div><!-- /.box -->

             <!-- Modal for reason to activate employee -->
              <div id="activate-employee" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">

                            <div class="box box-success">
                            <div class="panel panel-success">
                              <div class="panel-heading"><strong>Activate Employee</strong>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                              </button>
                              </div>
                          </div>
                            <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/employee/activate_employee/<?php echo $this->uri->segment("4");?>" >
                                <div class="box-body">
                                  <div class="form-group">
                                      <div class="modal-body">
                                          <input type="hidden" name="employeeID" id="employeeID" value=""/>
                                      
                                    <div class="form-group">
                                    <label class="col-sm-3 control-label">Date of Activation:</label>
                                    <div class="col-sm-9">
                                     <input type="text" id="date_event" name="date_event" class="form-control" placeholder="birthday" value="<?php  echo date('Y-m-d'); ?>" required>
                                    </div>
                                    </div>

                                    <div class="form-group">
                                    <label for="label" class="col-sm-3 control-label">Reason(s):</label>
                                    <div class="col-sm-8">
                                      <textarea rows="4" cols="50" class="form-control" name="reason" id="reason" placeholder="Reason(s)" value="" required></textarea>
                                    </div>
                                    </div>
                                    </div>
                                  </div>
                                  <br>
                                      <button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-user"></i> Activate</button>
                                </div><!-- /.box-body -->
                              </form>
                      </div>
                  </div>

              </div>
              <!--End  Modal for reason to activate employee -->

               <!-- Modal for reason to activate employee -->
              <div id="blocked-employee" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">

                            <div class="box box-success">
                            <div class="panel panel-success">
                              <div class="panel-heading"><strong>Block Employee</strong>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                              </button>
                              </div>
                          </div>
                            <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/employee/blocked_employee/<?php echo $this->uri->segment("4");?>" >
                                <div class="box-body">
                                  <div class="form-group">
                                      <div class="modal-body">
                                          <input type="text" name="employeeIDD" id="employeeIDD" value=""/>
                                    
                                    <div class="form-group">
                                    <label for="label" class="col-sm-3 control-label">Reason(s):</label>
                                    <div class="col-sm-8">
                                      <textarea rows="4" cols="50" class="form-control" name="reason" id="reason" placeholder="Reason(s)" value="" required></textarea>
                                    </div>
                                    </div>
                                    </div>
                                  </div>

                                  <br>
                                      <button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-times"></i> Blocked</button>
                                </div><!-- /.box-body -->
                              </form>
                      </div>
                  </div>

              </div>
              <!--End  Modal for reason to activate employee -->



      <!-- ===================================================================================== -->
      </div>
      </section>
             
<!-- Loading (remove the following to stop the loading)-->   
<div class="overlay" hidden="hidden" id="loading">
<i class="fa fa-spinner fa-spin"></i>
</div>
<!-- ./ end loading -->
             


 <?php require_once(APPPATH.'views/include/footer.php');?>
    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>

    <script>
        $('#activate-employee').on('show.bs.modal', function(e) {
            
            var $modal = $(this),
                employee_id = e.relatedTarget.id;
                    //$modal.find('.edit-content').html(employee_id);
                     $(".modal-body #employeeID").val( employee_id );
        })

    </script>

    <script>

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

      function loading(){
        $("#loading").removeAttr("hidden");
      }


      $(function () {

        $('#date_event').Zebra_DatePicker({
            direction: ['1952-01-01', currentdate] 
        });
        $(".select2").select2();

        $("#example1").DataTable();
      });
    </script>

  </body>
</html>