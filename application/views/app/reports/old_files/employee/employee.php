<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/iCheck/all.css">
     <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <!-- Buttons -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <!-- Dual Listbox -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/listbox/dist/bootstrap-duallistbox.css">
       
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script>
        window.onload = function() { <?php echo $onload; ?> };
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
    Reports
    <small>Employee</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Reports</li>
    <li class="active">Employee</li>
  </ol>
</section>

    <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

      <div class="row">
        <div class="col-md-2">
          <div class="box box-success">
                <div class="panel-heading">
                  <div class="btn-group-vertical btn-block">
                    <a onclick='reportList()' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Report List</strong></p></a>
                    <a onclick='generateReport()' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Generate Report</strong></p></a>
                  </div>
                </div>
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     
     
        <div class="col-md-10" id="col_2"> 
        </div>
      </div>
      
    </div><!-- Close container-fluid -->

<!-- ===========================  Add New Report Modal Container ================================== --> 
        <div class="modal modal-default fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" id="content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add</h4>
                  </div>
                  <div class="modal-body">             
                    <form action="#" role="form" id="form">
                      <div id="alert-msg"></div>
                      <div class="form-group">                    
                        <label for="reportName">Report Name</label>
                          <input type="text" class="form-control" name="report_name"
                          id="reportName" placeholder="Enter Report Name" value="<?php echo set_value('report_name'); ?>"/>
                      </div>

                      <div class="form-group">                      
                        <label for="description">Description</label>
                          <input type="text" class="form-control" name="report_desc"
                          id="description" placeholder="Enter Description" value="<?php echo set_value('report_desc'); ?>"/>
                      </div>

                      <div class="form-group">                      
                        <select id="addListbox" name="duallistbox_demo1[]" multiple="multiple">
                          <?php
                            foreach ($employee_fields as $data) 
                            {
                              echo '<option value="'.$data->id.'">'.$data->field_desc.'</option>';;
                            }
                          ?>
                        </select>
                      </div>
                      
                    </form>    
                  </div>
                  
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnSave" onclick="insert()">Save Report</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div> 

                </div>
            </div>
          </div><!-- /.box-body -->

<!-- ============================= End Add New Report Container =================================== -->


<!-- ============================  Edit Report Modal Container =================================== --> 
        <div class="modal modal-primary fade" id="editReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit</h4>
                </div>

                <div class="modal-body">             
                  <form action="#" role="form" id="form-edit">
                    <div id="alert"></div>
                    <input type="hidden" name="edit_report_id" id="edit_report_id" value="">
                    <div class="form-group">                    
                      <label for="reportName">Report Name</label>
                        <input type="text" class="form-control" name="edit_report_name"
                        id="editReportName" placeholder="Enter Report Name" value="<?php echo set_value('edit_report_name'); ?>"/>
                    </div>

                    <div class="form-group">                      
                      <label for="description">Description</label>
                        <input type="text" class="form-control" name="edit_report_desc" 
                        id="editDescription" placeholder="Enter Description" value="<?php echo set_value('edit_report_desc'); ?>"/>                       
                    </div>

                    <div class="form-group">                      
                      <select id="editListbox" name="duallistbox_demo1[]" multiple="multiple">
                        <?php
                          foreach ($employee_fields as $data) 
                          {
                            echo '<option value="'.$data->id.'">'.$data->field_desc.'</option>';;
                          }
                        ?>
                      </select>                     
                    </div>
                    
                  </form>    
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-outline" onclick="update()">Update Report</button>
                  <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
                </div> 

              </div>
            </div>
          </div><!-- /.box-body -->

<!-- ============================== End Edit Report Container ===================================== -->
<script type="text/javascript">
  function reportList()
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
          document.getElementById("col_2").innerHTML=xmlhttp.responseText;
          $("#reportList").DataTable();
        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/reports_employee/report_list",true);
      xmlhttp.send();
    }

    function generateReport()
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
          document.getElementById("col_2").innerHTML=xmlhttp.responseText;
          $("#reportList").DataTable();
        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/reports_employee/generate_report",true);
      xmlhttp.send();
    }

  //adding data to database
  function insert()
  {
    var report_name = document.getElementById("reportName").value;
    var report_desc = document.getElementById("description").value;
    var report_fields = [];
    var value = document.getElementById("addListbox");
    for (var i = 0; i < value.options.length; i++) {
        if (value.options[i].selected == true) {
            var id = value.options[i].value;
            report_fields.push(id);
        }
    }
    var data = report_fields.join("-");

    if(report_name == '' && report_desc == '' && report_fields == '' || report_fields == null)
    {
      $('#alert-msg').html('<div class="alert alert-danger">Report Name , Description and Selected Fields are required!</div>').fadeIn("slow").delay( 4000 ).fadeOut("slow");
    }
    else if(report_name == '' && report_fields == '' || report_fields == null)
    {
      $('#alert-msg').html('<div class="alert alert-danger">Report Name and Selected Fields are required!</div>').fadeIn("slow").delay( 4000 ).fadeOut("slow");
    }
    else if(report_desc == '' && report_fields == '' || report_fields == null)
    {
      $('#alert-msg').html('<div class="alert alert-danger">Description and Selected Fields are required!</div>').fadeIn("slow").delay( 4000 ).fadeOut("slow");
    }
    else if(report_name == '' || report_desc == '')
    {
      $('#alert-msg').html('<div class="alert alert-danger">Report Name and Description are required!</div>').fadeIn("slow").delay( 4000 ).fadeOut("slow");
    }
    else
    {
      if(report_fields == '' || report_fields == null)
      {
        $('#alert-msg').html('<div class="alert alert-danger">Selected Fields is required! Please select atleast one in Available Fields.</div>').fadeIn("slow").delay( 4000 ).fadeOut("slow");
      }
      else
      {
        {
          $('#modal_form').modal('hide');
          if(window.XMLHttpRequest)
          {
            xmlhttp = new XMLHttpRequest();
          }
          else
          {// code for IE6, IE5
            xmlhttp = new ActiveXObject ("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function()
          {
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
              document.getElementById("col_2").innerHTML = xmlhttp.responseText;
              $("#reportList").DataTable();
            }
          }
          xmlhttp.open("GET","<?php echo base_url();?>app/reports_employee/insert_report/"+report_name+"/"+report_desc+"/"+data,true);
          xmlhttp.send();
        }
      }
    }
  }

  //updating data to database
  function update()
  {
    var report_name = document.getElementById("editReportName").value;
    var report_desc = document.getElementById("editDescription").value;
    var report_id = document.getElementById("edit_report_id").value;
    var report_fields = [];
    var value = document.getElementById("editListbox");
    for (var i = 0; i < value.options.length; i++) {
        if (value.options[i].selected == true) {
            var id = value.options[i].value;
            report_fields.push(id);
        }
    }
    var data = report_fields.join("-");

    if(report_name == '' && report_desc == '' && report_fields == '' || report_fields == null)
    {
      $('#alert').html('<div class="alert alert-danger">Report Name , Description and Selected Fields are required!</div>').fadeIn("slow").delay( 4000 ).fadeOut("slow");
    }
    else if(report_name == '' && report_fields == '' || report_fields == null)
    {
      $('#alert').html('<div class="alert alert-danger">Report Name and Selected Fields are required!</div>').fadeIn("slow").delay( 4000 ).fadeOut("slow");
    }
    else if(report_desc == '' && report_fields == '' || report_fields == null)
    {
      $('#alert').html('<div class="alert alert-danger">Description and Selected Fields are required!</div>').fadeIn("slow").delay( 4000 ).fadeOut("slow");
    }
    else if(report_name == '' || report_desc == '')
    {
      $('#alert').html('<div class="alert alert-danger">Report Name and Description are required!</div>').fadeIn("slow").delay( 4000 ).fadeOut("slow");
    }
    else
    {
      if(report_fields == '' || report_fields == null)
      {
        $('#alert').html('<div class="alert alert-danger">Selected Fields is required! Please select atleast one in Available Fields.</div>').fadeIn("slow").delay( 4000 ).fadeOut("slow");
      }
      else
      {
        {
          $('#editReport').modal('hide');
          if(window.XMLHttpRequest)
          {
            xmlhttp = new XMLHttpRequest();
          }
          else
          {// code for IE6, IE5
            xmlhttp = new ActiveXObject ("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function()
          {
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
              document.getElementById("col_2").innerHTML = xmlhttp.responseText;
              $("#reportList").DataTable();
            }
          }
          xmlhttp.open("GET","<?php echo base_url();?>app/reports_employee/update_report/"+report_name+"/"+report_desc+"/"+data+"/"+report_id,true);
          xmlhttp.send();
        }
      }
    }
  }

  //deleting data to database
  function delete_report(id)
  {
    if (confirm('Are you sure you want to delete this data?')) 
    {
      {
        if(window.XMLHttpRequest)
        {
          xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
          xmlhttp = new ActiveXObject ("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
          if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
          {
            document.getElementById("col_2").innerHTML = xmlhttp.responseText;
            $("#reportList").DataTable();
          }
        }
        xmlhttp.open("GET","<?php echo base_url();?>app/reports_employee/delete_report/"+id,true);
        xmlhttp.send();
      }
    }
  }

  function report_name()
  {
    $('#company').prop('disabled', false);
    $('#btnFilter').prop('disabled', false);
  }

  function age(val)
  {
    if (val == 'All') 
    {
      $('#age_comparator').prop('disabled', true);
      $('#age_comparator').empty();
      $('#age_comparator').append('<option value="All">All</option>');
    }
    else
    {
      $('#age_comparator').prop('disabled', false);
      $('#age_comparator').empty();
      $('#age_comparator').append('<option value="eq">exact</option>');
      $('#age_comparator').append('<option value="gt">above</option>');
      $('#age_comparator').append('<option value="lt">below</option>');
    }
  }

  function years(val)
  {
    if (val == 'All') 
    {
      $('#years_comparator').prop('disabled', true);
      $('#years_comparator').empty();
      $('#years_comparator').append('<option value="All">All</option>');
    }
    else
    {
      $('#years_comparator').prop('disabled', false);
      $('#years_comparator').empty();
      $('#years_comparator').append('<option value="eq">exact</option>');
      $('#years_comparator').append('<option value="gt">above</option>');
      $('#years_comparator').append('<option value="lt">below</option>');
    }
  }

  //populate classification and division or department dropdown list
  function company(id)
  {
    var company_id = id; //or $(this).val();
    $.ajax({
      url: "<?php base_url()?>reports_employee/check_div",
      type: "POST",
      data: {"company_id" : company_id},
      datatype: "JSON",
      success: function(data)
      {
        var value = $.parseJSON(data);

        if (value.div != null) {
          $('#division').prop('disabled', false);
          $('#department').prop('disabled', true);
          $('#section').prop('disabled', true);
          $('#subsection').prop('disabled', true);
          $('#classification').prop('disabled', false);

          $('#division').empty();
          $('#department').empty();
          $('#section').empty();
          $('#subsection').empty();
          $('#classification').empty();

          $('#division').append('<option value="All" selected disabled>- Select Division -</option>');
          $('#division').append('<option value="All">All</option>');
          $('#department').append('<option value="All" selected disabled>- Select Department -</option>');
          $('#section').append('<option value="All" selected disabled>- Select Section -</option>');
          $('#subsection').append('<option value="All" selected disabled>- Select Subsection -</option>');
          $('#classification').append('<option value="All" selected disabled>- Select Classification -</option>');
          $('#classification').append('<option value="All">All</option>');

          $.each(value.div, function(i , d){
            $('#division').append('<option value="' + d.division_id + '">' + d.division_name + '</option>');
          });
          $.each(value.class, function(i , d){
            $('#classification').append('<option value="' + d.classification_id + '">' + d.classification + '</option>');
          });
        }
        else
        {
          $('#department').prop('disabled', false);
          $('#division').prop('disabled', true);
          $('#section').prop('disabled', true);
          $('#subsection').prop('disabled', true);
          $('#classification').prop('disabled', false);

          $('#division').empty();
          $('#department').empty();
          $('#section').empty();
          $('#subsection').empty();
          $('#classification').empty();

          $('#division').append('<option value="All" selected disabled>- Select Division -</option>');
          $('#department').append('<option value="All" selected disabled>- Select Department -</option>');
          $('#department').append('<option value="All">All</option>');
          $('#section').append('<option value="All" selected disabled>- Select Section -</option>');
          $('#subsection').append('<option value="All" selected disabled>- Select Subsection -</option>');
          $('#classification').append('<option value="All" selected disabled>- Select Classification -</option>');
          $('#classification').append('<option value="All">All</option>');

          $.each(value.dept, function(i , d){
            $('#department').append('<option value="' + d.department_id + '">' + d.dept_name + '</option>');
          });
          $.each(value.class, function(i , d){
            $('#classification').append('<option value="' + d.classification_id + '">' + d.classification + '</option>');
          });
        }
      },
      error: function()
      {
        alert("Error");
      }
    });
  }

  //populate department dropdown list
  function division(id)
  {
    var division_id = id; //or $(this).val();
    $.ajax({
      url: "<?php base_url()?>reports_employee/get_dept",
      type: "POST",
      data: {'division_id' : division_id},
      datatype: "JSON",
      success: function(data)
      {
        var value = $.parseJSON(data);
        if(value.dept != "")
        {
          $('#department').prop('disabled', false);
          $('#section').prop('disabled', true);
          $('#subsection').prop('disabled', true);

          $('#department').empty();
          $('#section').empty();
          $('#subsection').empty();

          $('#department').append('<option value="All" selected disabled>- Select Department -</option>');
          $('#department').append('<option value="All">All</option>');
          $('#section').append('<option value="All" selected disabled>- Select Section -</option>');
          $('#subsection').append('<option value="All" selected disabled>- Select Subsection -</option>');

          $.each(value.dept, function(i, d)
          {
            $('#department').append('<option value="' + d.department_id + '">' + d.dept_name + '</option>');
          });
        }
        else
        {
          $('#department').prop('disabled', true);
          $('#section').prop('disabled', true);
          $('#subsection').prop('disabled', true);

          $('#department').empty();
          $('#section').empty();
          $('#subsection').empty();

          $('#department').append('<option value="All" selected disabled>- Select Department -</option>');
          $('#section').append('<option value="All" selected disabled>- Select Section -</option>');
          $('#subsection').append('<option value="All" selected disabled>- Select Subsection -</option>');
        }
      },
      error: function()
      {
        alert('Error');
      }
    }); 
  }

  //populate section dropdown list
  function department(id)
  {
    var department_id = id; //or $(this).val();
    $.ajax({
      url: "<?php base_url()?>reports_employee/get_sec",
      type: "POST",
      data: {'department_id' : department_id},
      datatype: "JSON",
      success: function(data)
      {
        var value = $.parseJSON(data);
        if(value.sec != "")
        {
          $('#section').prop('disabled', false);
          $('#subsection').prop('disabled', true);

          $('#section').empty();
          $('#subsection').empty();

          $('#section').append('<option value="All" selected disabled>- Select Section -</option>');
          $('#section').append('<option value="All">All</option>');
          $('#subsection').append('<option value="All" selected disabled>- Select Subsection -</option>');

          $.each(value.sec, function(i, d)
          {
            $('#section').append('<option value="' + d.section_id + '">' + d.section_name + '</option>');
          });
        }
        else
        {
          $('#section').prop('disabled', true);
          $('#subsection').prop('disabled', true);

          $('#section').empty();
          $('#subsection').empty();

          $('#section').append('<option value="All" selected disabled>- Select Section -</option>');
          $('#subsection').append('<option value="All" selected disabled>- Select Subsection -</option>');
        }
      },
      error: function()
      {
        alert('Error');
      }
    });
  }

  //populate subsection dropdown list
  function section(id)
  {
    var section_id = id;
    $.ajax({
      url: "<?php base_url()?>reports_employee/get_subsec",
      type: "POST",
      data: {'section_id' : section_id},
      datatype: "JSON",
      success: function(data)
      {
        var value = $.parseJSON(data);
        if(value.subsec != "")
        {
          $('#subsection').prop('disabled', false);
          $('#subsection').empty();
          $('#subsection').append('<option value="All" selected disabled>- Select Subsection -</option>');
          $('#subsection').append('<option value="All">All</option>');
          $.each(value.subsec, function(i, d)
          {
            $('#subsection').append('<option value="' + d.subsection_id + '">' + d.subsection_name + '</option>');
          });
        }
        else
        {
          $('#subsection').prop('disabled', true);
          $('#subsection').empty();
          $('#subsection').append('<option value="All" selected disabled>- Select Subsection -</option>');
        }
      },
      error: function()
      {
        alert('Error');
      }
    });
  }

  //filter employee report
  function filter_employee()
  {
    var report_name = document.getElementById("report_name").value;
    var company = document.getElementById("company").value;
    var division = document.getElementById("division").value;
    var department = document.getElementById("department").value;
    var section = document.getElementById("section").value;
    var subsection = document.getElementById("subsection").value;
    var classification = document.getElementById("classification").value;
    var location = document.getElementById("location").value;
    var civil_status = document.getElementById("civil_status").value;
    var employment = document.getElementById("employment").value;
    var gender = document.getElementById("gender").value;
    var religion = document.getElementById("religion").value;
    var date_employed = document.getElementById("date_employed").value;
    var taxcode = document.getElementById("taxcode").value;
    var paytype = document.getElementById("paytype").value;
    var status = document.getElementById("status").value;
    var age = document.getElementById("age").value;
    var age_comparator = document.getElementById("age_comparator").value;
    var years = document.getElementById("years").value;
    var years_comparator = document.getElementById("years_comparator").value;

    if(report_name == '' || report_name == null)
    {
      alert('Select Report Name..');
    }
    else
    {
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
          document.getElementById("col_2").innerHTML=xmlhttp.responseText;
          $("#generateReport").DataTable({
            dom: 'Blfrtip',
            buttons: [
            {
              extend: 'excel',
              title: 'Employee Summary Report'
            },
            {
              extend: 'print',
              title: 'Employee Summary Report'
            }
          ],
            scrollY: 400,
            scrollX: true
          });
        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/reports_employee/filter_employee/"+report_name+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification+"/"+location+"/"+civil_status+"/"+employment+"/"+gender+"/"+religion+"/"+date_employed+"/"+taxcode+"/"+paytype+"/"+status+"/"+age+"/"+age_comparator+"/"+years+"/"+years_comparator,true);
      xmlhttp.send();
      }
    }
  }

  //show add modal
  function add_report()
  {
    $('#form')[0].reset(); //reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add New Report'); // Set title to Bootstrap modal title
  }

  //show update modal
  function edit_report(id)
  {
    $('#form-edit')[0].reset();
    $.ajax({
      type: "GET",
      async: "false",
      url: "<?php base_url()?>reports_employee/edit_report/" +id,
      datatype: "JSON",
      success: function(data)
      {
        var value = $.parseJSON(data);
        var fields = [];
        $.each(value.report_fields, function(i , d){
          var id = d.id;
          fields.push(id);
        });
        $('#edit_report_id').val(value.report_details.report_id);
        $('#editReportName').val(value.report_details.report_name);
        $('#editDescription').val(value.report_details.report_description);
        $('#editListbox').val(fields);
        $('#editListbox').bootstrapDualListbox('refresh', true);
                
        $('#editReport').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Report'); // Set title to Bootstrap modal title
      },
      error: function ()
      {
        alert('Failed to get data from database');
      }
    });
  }
</script>

  <?php require_once(APPPATH.'views/include/footer.php');?></div>

<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>public/app.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
<!-- Date Picker -->
<script src="<?php echo base_url()?>public/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Buttons -->
<script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
<!-- Export To Excel JSZip -->
<script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>
<!-- Dual Listbox -->
 <script type="text/javascript" src="<?php echo base_url()?>public/listbox/dist/jquery.bootstrap-duallistbox.js"></script>

<!-- Load Dual List Box -->
<script>
  var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox({
    nonSelectedListLabel: 'Available Fields',
    selectedListLabel: 'Selected Fields',
    preserveSelectionOnMove: false,
    moveOnSelect: false
  });
</script>

<script>
  function loading(){
    $("#loading").removeAttr("hidden");
  }
</script>

    <script>
      function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
          $('#company_logo')
            .attr('src', e.target.result)
            .width(240)
            .height(240);
          };
            reader.readAsDataURL(input.files[0]);
        }
      }

        $("#userfile").change(function(){
        readURL(this);
    });
    </script>
  </body>
</html>


