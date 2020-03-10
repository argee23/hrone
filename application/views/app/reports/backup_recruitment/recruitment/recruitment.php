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
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/iCheck/all.css">
     <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <!-- Buttons -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">


    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
      
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php if($this->session->userdata('is_logged_in')){
$current_account_logged_in="admin or employee account";
}else{
$current_account_logged_in="employer_account";
}    
if($current_account_logged_in!="employer_account"){
   require_once(APPPATH.'views/include/sidebar.php');
  }else{
 require_once(APPPATH.'views/include/sidebar_recruitment_employer.php');
  }
?>

<body>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Reports
    <small>Recruitment</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Reports</li>
    <li class="active">Recruitment</li>
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

                <!-- <div class="panel panel-info"> -->
                <div class="panel-heading"><!-- <strong>Select a company</strong> <a onclick="addNewUDFCol()" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="Add"><i class="fa fa-plus-square fa-2x text-primary delete pull-right"></i></a> -->
                  <div class="btn-group-vertical btn-block">
                    <a onclick='jobVacancy()' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Job Vacancies</strong></p></a>
                    <a onclick='jobApplication()' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Job Application</strong></p></a>
                    <a onclick='jobAnalytics()' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Job Analytics</strong></p></a>
                    <a onclick='questions()' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Questions</strong></p></a>
                  </div>
                </div>
                <!-- <div class="box-body"> -->

                <!-- <div id="acccount_security">
                                
                </div> -->

                <!-- </div> box body -->
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     
     <!-- </div>  row -->
        <div class="col-md-10" id="col_2">
        <img src="<?php echo base_url()?>public/img/user.png" id="loading-indicator" style="display:none" /> 
        </div>
      </div>

      </div><!-- Close container-fluid -->

<!-- Loading Indicator -->
    <?php require_once(APPPATH.'views/include/loading.php');?>


                          
<script>  

<!--//=====================//-->




     function jobVacancy()
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

                $('#hireStart').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                calendarWeeks: true,
                endDate: '+3y',         
                }).on('changeDate', function (selected) {
                    var minDate = new Date(selected.date.valueOf());
                    $('#hireEnd').datepicker('setStartDate', minDate);
                    // $("#hireEnd").datepicker('setDate', minDate);
                    reports();
                  });

                $('#hireEnd').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                calendarWeeks: true,
                endDate: '+3y',               
                  }).on('changeDate', function (selected) {
                    reports();
                  });

                $("#jobVacancy").DataTable({
                  dom: 'Bfrtip',
                  buttons: [
                      // 'copy', 'csv', 'excel', 'pdf', 'print'
                      {
                        extend: 'excel',
                        title: 'Job Vacancy'
                      },
                      {
                        extend: 'print',
                        title: 'Job Vacancy'
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }

                });

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_recruitment/job_vacancy/",true);
            xmlhttp.send();

    }
    
    function reports()
    {          
        var comp_id = $('#company').val();
        var job_title = $('#job_title').val();
        job_title = job_title.replace('/','_slash_');
        job_title = job_title.replace('(','_open_par_');
        job_title = job_title.replace(')','_close_par_');
        var slot = $('#slot').val();
        if (!$('#slot').val()){
          slot = "null";
        }
        var salary = $('#salary').val();
        if (!$('#salary').val()){
          salary = "null";
        }
        var hireStart = $('#hireStart').val();
        if (!$('#hireStart').val()){
          hireStart = "null";
        }
        var hireEnd = $('#hireEnd').val();
        if (!$('#hireEnd').val()){
          hireEnd = "null";
        }
        var status = $('#status').val();

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
        
                document.getElementById("fill").innerHTML=xmlhttp.responseText;
                $("#jobVacancy").DataTable({
                  dom: 'Bfrtip',
                  buttons: [
                      // 'copy', 'csv', 'excel', 'pdf', 'print'
                      {
                        extend: 'excel',
                        title: 'Job Vacancy'
                      },
                      {
                        extend: 'print',
                        title: 'Job Vacancy'
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }

                });

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_recruitment/reports/"+comp_id+"/"+job_title+"/"+slot+"/"+salary+"/"+hireStart+"/"+hireEnd+"/"+status,true);
            xmlhttp.send();
    }

    function jobApplication()
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

                $('#date_applied').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                calendarWeeks: true,
                endDate: '+3y',               
                  }).on('changeDate', function (selected) {
                    reportsApplication();
                  });

                $("#jobApplication").DataTable({
                  dom: 'Bfrtip',
                  buttons: [
                      // 'copy', 'csv', 'excel', 'pdf', 'print'
                      {
                        extend: 'excel',
                        title: 'Job Application'
                      },
                      {
                        extend: 'print',
                        title: 'Job Application'
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }

                });
        
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_recruitment/job_application/",true);
            xmlhttp.send();

    }

    function reportsApplication()
    {          
        var comp_id = $('#company').val();
        var position = $('#position').val();
        position = position.replace('/','_slash_');
        position = position.replace('(','_open_par_');
        position = position.replace(')','_close_par_');
        var date_applied = $('#date_applied').val();
        if (!$('#date_applied').val()){
          date_applied = "null";
        }
        var status = $('#status').val();

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
        
                document.getElementById("fill").innerHTML=xmlhttp.responseText;
                $("#jobApplication").DataTable({
                  dom: 'Bfrtip',
                  buttons: [
                      // 'copy', 'csv', 'excel', 'pdf', 'print'
                      {
                        extend: 'excel',
                        title: 'Job Application'
                      },
                      {
                        extend: 'print',
                        title: 'Job Application'
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }

                });

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_recruitment/reports_application/"+comp_id+"/"+position+"/"+date_applied+"/"+status,true);
            xmlhttp.send();
    }

    function jobAnalytics()
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
                 $("#jobAnalytics").DataTable({
                  dom: 'Bfrtip',
                  buttons: [
                      // 'copy', 'csv', 'excel', 'pdf', 'print'
                      {
                        extend: 'excel',
                        title: 'Job Analytics'
                      },
                      {
                        extend: 'print',
                        title: 'Job Analytics',
                        exportOptions: {
                          stripHtml: false
                        }
                        // customize: function ( win ) {
                        //   $(win.document.body)
                        //     .css( 'font-size', '10pt' )
                        //     // .prepend(
                        //     //   '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                        //     // );
 
                        //   $(win.document.body).find( 'table' )
                        //     .addClass( 'compact' )
                        //     .css( 'font-size', 'inherit' );
                        // }
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }

                });
        
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_recruitment/job_analytics/",true);
            xmlhttp.send();

    }

    function reportsAnalytics()
    {          
        var comp_id = $('#company').val();
        var position = $('#position').val();
        position = position.replace('/','_slash_');
        position = position.replace('(','_open_par_');
        position = position.replace(')','_close_par_');
        var slot = $('#slot').val();
        if (!$('#slot').val()){
          slot = "null";
        }
        var cur_avail = $('#cur_avail').val();
        if (!$('#cur_avail').val()){
          cur_avail = "null";
        }

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
        
                document.getElementById("fill").innerHTML=xmlhttp.responseText;
                 $("#jobAnalytics").DataTable({
                  dom: 'Bfrtip',
                  buttons: [
                      // 'copy', 'csv', 'excel', 'pdf', 'print'
                      {
                        extend: 'excel',
                        title: 'Job Analytics'
                      },
                      {
                        extend: 'print',
                        title: 'Job Analytics',
                        exportOptions: {
                          stripHtml: false
                        }
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }

                });

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_recruitment/reports_analytics/"+comp_id+"/"+position+"/"+slot+"/"+cur_avail,true);
            xmlhttp.send();
    }

    function questions()
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
        
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_recruitment/questions/",true);
            xmlhttp.send();

    }

    function questions_sub(val)
    {          

        if(val == 1){
          var title = 'Qualifying Questions';  
        }
        if(val == 2){
          var title = 'Hypothetical Questions';  
        }
        if(val == 3){
          var title = 'Multiple Choice Questions';  
        }

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
        
                document.getElementById("questionBody").innerHTML=xmlhttp.responseText;
                $("#questions").DataTable({
                  dom: 'Bfrtip',
                  buttons: [
                      // 'copy', 'csv', 'excel', 'pdf', 'print'
                      {
                        extend: 'excel',
                        title: title
                      },
                      {
                        extend: 'print',
                        title: title,
                        exportOptions: {
                          stripHtml: false
                        }
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }

                });
        
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_recruitment/questions_sub/"+val,true);
            xmlhttp.send();

    }

    function qualifying()
    {          
        var comp_id = $('#company').val();
        var cor_ans = $('#cor_ans').val();
        var status = $('#status').val();

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
        
                document.getElementById("fill").innerHTML=xmlhttp.responseText;
                 $("#questions").DataTable({
                  dom: 'Bfrtip',
                  buttons: [
                      // 'copy', 'csv', 'excel', 'pdf', 'print'
                      {
                        extend: 'excel',
                        title: 'Qualifying Questions'
                      },
                      {
                        extend: 'print',
                        title: 'Qualifying Questions',
                        exportOptions: {
                          stripHtml: false
                        }
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }

                });

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_recruitment/reports_qualifying_questions/"+comp_id+"/"+cor_ans+"/"+status,true);
            xmlhttp.send();
    }

    function hypothetical()
    {          
        var comp_id = $('#company').val();
        var status = $('#status').val();

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
        
                document.getElementById("fill").innerHTML=xmlhttp.responseText;
                 $("#questions").DataTable({
                  dom: 'Bfrtip',
                  buttons: [
                      // 'copy', 'csv', 'excel', 'pdf', 'print'
                      {
                        extend: 'excel',
                        title: 'Hypothetical Questions'
                      },
                      {
                        extend: 'print',
                        title: 'Hypothetical Questions',
                        exportOptions: {
                          stripHtml: false
                        }
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }

                });

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_recruitment/reports_hypothetical_questions/"+comp_id+"/"+status,true);
            xmlhttp.send();
    }

    function multiple_choice()
    {          
        var comp_id = $('#company').val();
        var status = $('#status').val();

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
        
                document.getElementById("fill").innerHTML=xmlhttp.responseText;
                 $("#questions").DataTable({
                  dom: 'Bfrtip',
                  buttons: [
                      // 'copy', 'csv', 'excel', 'pdf', 'print'
                      {
                        extend: 'excel',
                        title: 'Multiple Choice Questions'
                      },
                      {
                        extend: 'print',
                        title: 'Multiple Choice Questions',
                        exportOptions: {
                          stripHtml: false
                        }
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }

                });

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_recruitment/reports_multiple_choice_questions/"+comp_id+"/"+status,true);
            xmlhttp.send();
    }

</script>

<!-- FILE MAINTENANCE LIST ================================================================================================= -->
             
            <!-- Loading (remove the following to stop the loading)-->   
            <div class="overlay" hidden="hidden" id="loading">
            <i class="fa fa-spinner fa-spin"></i>
            </div>
            <!-- ./ end loading -->

             


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


