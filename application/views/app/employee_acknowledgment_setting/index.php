<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz_niceditor/js/nicEdit.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/tinymce.min.js"></script>
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
       Administrator
       <small>Employee Aknowledgement Settings</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Administrator</a></li>
      <li class="active">Employee Acknowledgement Setting</li>
    </ol>
  </section>
  <br>
    <div class="col-md-12">
        <?php echo $message;?>
        <?php echo validation_errors(); ?>
    </div>
  <div class="col-md-3" style="padding-bottom: 50px;" id="add_filtering">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
            <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">
                <ul class="nav nav-pills nav-stacked">
                  <?php
                   foreach ($companyList as $company)
                    { ?>
                        <li class="my_hover"><a style='cursor: pointer;' onclick="get_settings('<?php echo $company->company_id;?>');"><i class='fa fa-circle-o'></i> <span>  <?php echo $company->company_name?> </span></a></li>
                      <?php
                    }
                  ?>
                </ul>
                 
            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
  <div class="col-md-9" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info"  id="fetch_all_result">
       <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Employee Aknowledgement Setting</h4></ol>
            <div class="col-md-12"><br>
               
            </div>  
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
    

     <div id="modal" class="modal fade" role="dialog">
       <div class="modal-dialog">
           <div class="modal-content modal-lg">
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
    <script type="text/javascript">
       $(function () {
        $('#downloadable').DataTable({
          "pageLength": 6,
           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] ,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

      function get_settings(company)
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
              document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
               tinymce.remove();
                        tinymce.init({
                            selector: 'textarea',
                            height: 400,
                            theme: 'modern',
                            menubar:false,
                            plugins: 'emoticons print preview fullpage searchreplace autolink directionality link charmap hr advlist lists textcolor wordcount link contextmenu colorpicker textpattern help',
                            toolbar1: 'formatselect | fontsizeselect | fontselect | bold italic underline strikethrough superscript subscript undo redo cut copy paste find and replace hr forecolor backcolor | link | charmap | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat preview emoticons',
                            font_formats: 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats',
                            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                            image_advtab: true
                    });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_acknowledgment_settings/get_settings/"+company,false);
        xmlhttp2.send();
      }

      function update_settings(company)
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
                document.getElementById("actions").innerHTML=xmlhttp.responseText;
                
                  tinymce.remove();
                        tinymce.init({
                            selector: 'textarea',
                            height: 400,
                            theme: 'modern',
                            menubar:false,
                            plugins: 'emoticons print preview fullpage searchreplace autolink directionality link charmap hr advlist lists textcolor wordcount link contextmenu colorpicker textpattern help',
                            toolbar1: 'formatselect | fontsizeselect | fontselect | bold italic underline strikethrough superscript subscript undo redo cut copy paste find and replace hr forecolor backcolor | link | charmap | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat preview emoticons',
                            font_formats: 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats',
                            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                            image_advtab: true
                    });
               
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_acknowledgment_settings/update_settings/"+company,true);
            xmlhttp.send();
      }
    </script>