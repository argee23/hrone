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
    <link rel="stylesheet" href="<?php echo base_url()?>public/duallistbox-master/dist/bootstrap-duallistbox.css">
       
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
                    <a onclick="location.href='<?php echo base_url();?>app/reports_employee/generate_report'" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Generate Report</strong></p></a>
                  </div>
                </div>
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->    
        <div class="col-md-10" id="col_2">
            <div class="box box-success">
              <div class="box-header">
                <?php
                  if ($this->session->flashdata('error_msg')) {   
                ?>
                <div class="alert alert-danger">
                  <?php echo $this->session->flashdata('error_msg'); ?>
                </div>
                <?php
                  }
                ?>
                <h3>Employee Report List</h3>
                <div id="msg"></div>
                <a type="button" class="btn btn-success btn-sm" title="Add Report" onclick="add_report()"><i class="fa fa-plus-square"></i> Add New Report </a>
              </div> <!-- /.box-header -->

              <div class="box-body">
                <table id="reportList" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Report ID</th>
                      <th>Report Name</th>
                      <th>Description</th>
                      <th>Option</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    foreach ($record as $data) 
                    {      
                  ?>
                    <tr>
                      <td><?php echo $data->report_id; ?></td>
                      <td><?php echo $data->report_name; ?></td>
                      <td><?php echo $data->report_description; ?></td>
                      <td>
                        <a type="button" class="btn btn-info fa fa-edit" title="Edit Report" onclick="edit_report(<?php echo $data->report_id;?>)"></a>
                        <a type="button" class="btn btn-danger fa fa-remove" title="Delete Report" onclick="delete_report(<?php echo $data->report_id;?>)"></a>
                      </td>
                    </tr>
                  <?php
                     }
                  ?>
                  </tbody>
                </table>
              </div>
          </div>
        </div>
      </div>
    </div><!-- Close container-fluid -->

<!-- ===========================  Add New Report Modal Container ================================== --> 
        <div class="modal modal-default fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" id="content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit</h4>
                  </div>
                  <div class="modal-body">             
                    <form action="#" role="form" id="form">
                      <div id="alert-msg"></div>
                      <!-- <div class="alert alert-danger"><?php echo validation_errors(); ?></div> -->
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
                        <select multiple id="exampleInputEmail" name="duallistbox_demo1[]">
                          <?php
                            foreach ($employee_mass_update as $data) 
                            {
                              echo '<option value="'.$data->field_desc.'">'.$data->field_desc.'</option>';;
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
                    <input type="hidden" name="report_id" id="report_id" value="">
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
                      <select multiple id="editListbox" name="duallistbox_demo1[]">
                        <?php
                          foreach ($employee_mass_update as $data) 
                          {
                            echo '<option value="'.$data->field_desc.'">'.$data->field_desc.'</option>';;
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
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_employee/report_list/",true);
            xmlhttp.send();
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
<script src="<?php echo base_url()?>public/duallistbox-master/dist/jquery.bootstrap-duallistbox.js"></script>

<!-- Load Dual List Box -->
<script>
  var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox({
  nonSelectedListLabel: 'Available Fields',
  selectedListLabel: 'Selected Fields',
  preserveSelectionOnMove: false,
  moveOnSelect: false
  });
</script>

<!-- Insert, Update, Delete function -->
<script>
  //show add modal
  function add_report()
  {
    $('#form')[0].reset(); //reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add New Report'); // Set title to Bootstrap modal title
  }
      
  //adding data to database
  function insert()
  {
    $.ajax({
      url: "<?php base_url()?>insert_report",
      type: "POST",
      data: $('#form').serialize(),
      datatype: "JSON",
      success: function(data)
      {
        if (data == 'YES') 
        {
          $('#modal_form').modal('hide');
          $('#msg').html('<div class="alert alert-success text-center">Record Added Successfully!</div>').fadeIn('slow').delay( 1000 ).fadeOut('slow');
          window.setTimeout(function(){location.href = "<?php base_url()?>employee_report_list"},1500);
        }
        else
        {
          $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>').fadeIn("slow").delay( 2000 ).fadeOut("slow");
        }
      },
      error: function()
      {
        alert('Failed to Add Record');
      }
    });
  }

  //show update modal
  function edit_report(id)
  {
    $('#form-edit')[0].reset();

    $.ajax({
      type: "GET",
      async: "false",
      url: "<?php base_url()?>edit_report/" +id,
      datatype: "JSON",
      success: function(data)
      {
        var value = $.parseJSON(data);
        var fields = value.report_fields;
        var array = fields.split(",");

        $('#report_id').val(value.report_id);
        $('#editReportName').val(value.report_name);
        $('#editDescription').val(value.report_description);
        $('#editListbox').val(array);
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

  //updating data to database
  function update()
  {
    $.ajax({
      url: "<?php base_url()?>update_report",
      type: "POST",
      data: $('#form-edit').serialize(),
      datatype: "JSON",
      success: function(data)
      {
        if (data == 'YES') 
        {
          $('#editReport').modal('hide');
          $('#msg').html('<div class="alert alert-info text-center">Record Updated Successfully!</div>').fadeIn('slow').delay( 1000 ).fadeOut('slow');
          window.setTimeout(function(){location.href = "<?php base_url()?>employee_report_list"},1500);
        }
        else
        {
          $('#alert').html('<div class="alert alert-danger">' + data + '</div>').fadeIn("slow").delay( 2000 ).fadeOut("slow");
        } 
      },
      error: function()
      {
        alert('Failed to Update Record');
      }
    });
  }

  //deleting data to database
  function delete_report(id)
  {
    if (confirm('Are you sure you want to delete this data?')) 
    {
      $.ajax({
        url: "<?php base_url()?>delete_report/" +id,
        type: "POST",
        datatype: "JSON",
        success: function(data)
        {
          if (data == 'YES') 
          {
            $('#msg').html('<div class="alert alert-danger text-center">Record Deleted Successfully!</div>').fadeIn('slow').delay( 1000 ).fadeOut('slow');
            window.setTimeout(function(){location.href = "<?php base_url()?>employee_report_list"},1500);
          }
        },
        error: function()
        {
          alert('Failed to Delete Record');
        }
      });
    }
  }
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

  <script>
    $(function () {
      $("#reportList").DataTable();
    });
  </script>