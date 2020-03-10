<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$view_wb_employee=$this->session->userdata('view_wb_employee');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/
?>

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
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/iCheck/all.css">

    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    
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
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Time
    <small>Web Bundy</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Time</li>
    <li class="active">Web Bundy</li>
  </ol>
</section>

      <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

  <div class="row">
  <!-- //============ start web bundy allowed ip address -->
<?php
if($wb_allowed_ip_management->single_value=="yes"){
?>
    <div class="col-md-12">
      <div class="box box-danger">
        <div class="panel panel-danger">
          <div class="panel-heading"><strong>Allowed IP Addresses in Web Bundy</strong></div>
          <div class="box-body">
            <div class="panel panel-success">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="company">Select a Company</label>
                      <select class="form-control" name="company" id="company" onchange="get_allowed_ip(this.value)" required>
                        <option selected="selected" value="" disabled>~select a company~</option>
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

                  <div id = "web_bundy_allowed_ip">
                  </div>

                </div> 
              </div>
            </div>
          </div>
        </div>
      </div>  
    </div>    
    

<?php
}else{

}
?>


  <!-- //============ end web bundy allowed ip address -->


  <!-- //============ start web bundy settings -->
  <?php 
if(!empty($wb_function_management)){
  $wbfm=$wb_function_management->single_value;
  if($wbfm=="147"){//system parameters : individual setup
    $show_wb_function_mngmt="1";
  }else{
    $show_wb_function_mngmt=0;
  }
}else{
  $wbfm="";
   $show_wb_function_mngmt=0;
}

if($show_wb_function_mngmt=="1"){

  ?>


    <div class="col-md-12">
      <div class="box box-danger">
        <div class="panel panel-danger">
          <div class="panel-heading"><strong>Web Bundy Settings</strong></div>
          <div class="box-body">
            <div class="panel panel-success">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="company">Select a Company</label>
                      <select class="form-control" name="company" id="company" onchange="get_web_bundy_settings(this.value)" required>
                        <option selected="selected" value="" disabled>~select a company~</option>
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

                  <div id = "web_bundy_setting">
                  </div>

                </div> 
              </div>
            </div>
          </div>
        </div>
      </div>  
    </div>    

<?php

}else{
  
}
?>    
  <!-- //============ end web bundy settings -->

    <div class="col-md-12">
      <div class="box box-danger">
        <div class="panel panel-danger">
          <div class="panel-heading"><strong>Web Bundy Enrollment</strong></div>
          <div class="box-body">
            <div class="panel panel-success">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="company">Select a Company</label>
                      <select class="form-control" name="company" id="company" onchange="get_company_employee(this.value)" required>
                        <option selected="selected" value="" disabled>~select a company~</option>
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

 
                  <div id = "company_employee">
                  </div>

                </div> 
              </div>
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>

     <!-- SCRIPT -->
  <script>

    function get_company_employee(val)
    { 
      tempcompany           = val;
      templocation          = 0;
      tempdivision          = 0;
      tempdepartment        = 0;
      tempsection           = 0;
      tempsubsection        = 0;
      tempclassification    = 0;     

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
          document.getElementById("company_employee").innerHTML=xmlhttp.responseText;
          $("#example1").DataTable({       
          });
          $('.datatable').DataTable();
          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/time_web_bundy/company_employee_view/"+val,true);
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

    function web_bundy_employee_add(val)
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
            document.getElementById("company_employee").innerHTML=xmlhttp.responseText;
            $('#example1').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
            } );
            $('.datatable').DataTable();
            $("#selectall").click(function () {
                $('.case').attr('checked', this.checked);
            });
            $(".case").click(function(){

              if($(".case").length == $(".case:checked").length) {
                $("#selectall").attr("checked", "checked");
              } else {
                $("#selectall").removeAttr("checked");
              }

            });
          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/time_web_bundy/web_bundy_employee_add_view/"+val,true);
      xmlhttp.send();
    }

    var tempcompany         = 0;
    var templocation        = 0;
    var tempdivision        = 0;
    var tempdepartment      = 0;
    var tempsection         = 0;
    var tempsubsection      = 0;
    var tempclassification  = 0;

    function applyFilterlocation(val)
    {
      var company           = tempcompany;
      var location          = val;
      var division          = tempdivision;
      var department        = tempdepartment;
      var section           = tempsection;
      var subsection        = tempsubsection;
      var classification    = tempclassification;
      
      templocation          = location;
      tempdivision          = division;
      tempdepartment        = department;
      tempsection           = section;
      tempsubsection        = subsection;
      tempclassification    = classification;
      tempcompany           = company;

        
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
        $('#example1').DataTable( {
              "scrollY":        "400px",
              "scrollCollapse": true,
              "paging":         false
          } );
          $('.datatable').DataTable();
          $("#selectall").click(function () {
              $('.case').attr('checked', this.checked);
          });
          $(".case").click(function(){

            if($(".case").length == $(".case:checked").length) {
              $("#selectall").attr("checked", "checked");
            } else {
              $("#selectall").removeAttr("checked");
            }

          });
        }
      }
    xmlhttp.open("GET","<?php echo base_url();?>app/time_web_bundy/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
    xmlhttp.send();

    }

    function applyFilterclassification(val)
    {
      var company           = tempcompany;
      var location          = templocation;
      var division          = tempdivision;
      var department        = tempdepartment;
      var section           = tempsection;
      var subsection        = tempsubsection;
      var classification    = val;
      
      templocation          = location;
      tempdivision          = division;
      tempdepartment        = department;
      tempsection           = section;
      tempsubsection        = subsection;
      tempclassification    = classification;
      tempcompany           = company;
  
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
            $('#example1').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
            } );
            $('.datatable').DataTable();

            $("#selectall").click(function () {
                $('.case').attr('checked', this.checked);
            });
            $(".case").click(function(){

              if($(".case").length == $(".case:checked").length) {
                $("#selectall").attr("checked", "checked");
              } else {
                $("#selectall").removeAttr("checked");
              }

            });
          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/time_web_bundy/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
      xmlhttp.send();
    }

    function applyFilterdivision(val)
    {
      var company           = tempcompany;
      var location          = templocation;
      var division          = val;
      var department        = 0;
      var section           = 0;
      var subsection        = 0;
      var classification    = tempclassification;
      
      templocation          = location;
      tempdivision          = division;
      tempdepartment        = department;
      tempsection           = section;
      tempsubsection        = subsection;
      tempclassification    = classification;
      tempcompany           = company;
          
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
            document.getElementById("search_here").innerHTML=xmlhttp1.responseText;
            $('#example1').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
            } );
            $('.datatable').DataTable();

            $("#selectall").click(function () {
                $('.case').attr('checked', this.checked);
            });
            $(".case").click(function(){

              if($(".case").length == $(".case:checked").length) {
                $("#selectall").attr("checked", "checked");
              } else {
                $("#selectall").removeAttr("checked");
              }

            });
          }
        }
      xmlhttp1.open("GET","<?php echo base_url();?>app/time_web_bundy/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
      xmlhttp1.send();
    }

    function applyFilterdepartment(val)
    { 
      var company           = tempcompany;
      var location          = templocation;
      var division          = tempdivision;
      var department        = val;
      var section           = 0;
      var subsection        = 0;
      var classification    = tempclassification;
      
      templocation          = location;
      tempdivision          = division;
      tempdepartment        = department;
      tempsection           = section;
      tempsubsection        = subsection;
      tempclassification    = classification;
      tempcompany           = company;
        
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
            $('#example1').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
            } );
            $('.datatable').DataTable();

            $("#selectall").click(function () {
                $('.case').attr('checked', this.checked);
            });
            $(".case").click(function(){

              if($(".case").length == $(".case:checked").length) {
                $("#selectall").attr("checked", "checked");
              } else {
                $("#selectall").removeAttr("checked");
              }

            });
          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/time_web_bundy/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
      xmlhttp.send();
    }

    function applyFiltersection(val)
    {
      var company           = tempcompany;
      var location          = templocation;
      var division          = tempdivision;
      var department        = tempdepartment;
      var section           = val;
      var subsection        = 0;
      var classification    = tempclassification;
      
      templocation          = location;
      tempdivision          = division;
      tempdepartment        = department;
      tempsection           = section;
      tempsubsection        = subsection;
      tempclassification    = classification;
      tempcompany           = company;

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
          $('#example1').DataTable( {
              "scrollY":        "400px",
              "scrollCollapse": true,
              "paging":         false
          } );
          $('.datatable').DataTable();
          $("#selectall").click(function () {
              $('.case').attr('checked', this.checked);
          });
          $(".case").click(function(){

            if($(".case").length == $(".case:checked").length) {
              $("#selectall").attr("checked", "checked");
            } else {
              $("#selectall").removeAttr("checked");
            }

          });
        }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/time_web_bundy/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
      xmlhttp.send();
    }

    function applyFiltersubsection(val)
    {
      var company           = tempcompany;
      var location          = templocation;
      var division          = tempdivision;
      var department        = tempdepartment;
      var section           = tempsection;
      var subsection        = val;
      var classification    = tempclassification;
      
      templocation          = location;
      tempdivision          = division;
      tempdepartment        = department;
      tempsection           = section;
      tempsubsection        = subsection;
      tempclassification    = classification;
      tempcompany           = company;
 
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
          $('#example1').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
            } );
          $('.datatable').DataTable();
          $("#selectall").click(function () {
              $('.case').attr('checked', this.checked);
          });
          $(".case").click(function(){

            if($(".case").length == $(".case:checked").length) {
              $("#selectall").attr("checked", "checked");
            } else {
              $("#selectall").removeAttr("checked");
            }

          });

          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/time_web_bundy/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
      xmlhttp.send();
    }

    function getDepartment(val)
    {
      if (window.XMLHttpRequest)
        {
        xmlhttpDep=new XMLHttpRequest();
        }
      else
        {// code for IE6, IE5
        xmlhttpDep=new ActiveXObject("Microsoft.XMLHTTP");
        }
      xmlhttpDep.onreadystatechange=function()
        {
        if (xmlhttpDep.readyState==4 && xmlhttpDep.status==200)
          {
          
          document.getElementById("department").innerHTML=xmlhttpDep.responseText;
          }
        }
      xmlhttpDep.open("GET","<?php echo base_url();?>app/time_web_bundy/get_division_department/"+val,true);
      xmlhttpDep.send();
    }

    function get_web_bundy_settings(val)
    {
      if (window.XMLHttpRequest)
        {
        xmlhttpDep=new XMLHttpRequest();
        }
      else
        {// code for IE6, IE5
        xmlhttpDep=new ActiveXObject("Microsoft.XMLHTTP");
        }
      xmlhttpDep.onreadystatechange=function()
        {
        if (xmlhttpDep.readyState==4 && xmlhttpDep.status==200)
          {
          
          document.getElementById("web_bundy_setting").innerHTML=xmlhttpDep.responseText;
          }
        }
      xmlhttpDep.open("GET","<?php echo base_url();?>app/time_web_bundy/get_web_bundy_settings/"+val,true);
      xmlhttpDep.send();
    }   

     function get_allowed_ip(val)
    {
      if (window.XMLHttpRequest)
        {
        xmlhttpDep=new XMLHttpRequest();
        }
      else
        {// code for IE6, IE5
        xmlhttpDep=new ActiveXObject("Microsoft.XMLHTTP");
        }
      xmlhttpDep.onreadystatechange=function()
        {
        if (xmlhttpDep.readyState==4 && xmlhttpDep.status==200)
          {
          
          document.getElementById("web_bundy_allowed_ip").innerHTML=xmlhttpDep.responseText;
          }
        }
      xmlhttpDep.open("GET","<?php echo base_url();?>app/time_web_bundy/get_allowed_ip/"+val,true);
      xmlhttpDep.send();

      $("#example1").DataTable();


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
      xmlhttp1.open("GET","<?php echo base_url();?>app/time_web_bundy/get_department_section/"+val,true);
      xmlhttp1.send();
    }

    function getSubsection(val)
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
          
          document.getElementById("subsection").innerHTML=xmlhttp1.responseText;
          }
        }
      xmlhttp1.open("GET","<?php echo base_url();?>app/time_web_bundy/get_section_subsection/"+val,true);
      xmlhttp1.send();
    }

    </script>
    <!-- END OF SCRIPT -->

                  <div class="col-md-8" id="col_2"></div>
                </div>
            </div><!-- /.box-body -->
             
                        <!-- Loading (remove the following to stop the loading)-->   
            <div class="overlay" hidden="hidden" id="loading">
            <i class="fa fa-spinner fa-spin"></i>
            </div>
            <!-- ./ end loading -->

             


    <?php require_once(APPPATH.'views/include/footer.php');?></div> 

    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <!-- Bootstrap Select -->
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <!-- Vex -->
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>

    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>


      <script>

    $( function(){

    });
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>
  </body>
</html>