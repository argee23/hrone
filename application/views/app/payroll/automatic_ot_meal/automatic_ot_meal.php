<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$view_ot_meal_table=$this->session->userdata('view_ot_meal_table');
$view_ot_meal_emp=$this->session->userdata('view_ot_meal_emp');
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
    Payroll
    <small>Automatic OT Meal</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Payroll</li>
    <li class="active">Automatic OT Meal</li>
  </ol>
</section>

      <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

      <div class="row">

      <div class="col-md-3">
          <div class="box box-primary">
            <div class="panel panel-info">
            <div class="panel-heading"><strong>Automatic OT Meal</strong></div>
            <div class="btn-group-vertical btn-block">

                <a onclick="ot_meal_table()" type='button' class='<?php echo $view_ot_meal_table;?> btn btn-default btn-flat'><p class='text-left'><strong>OT Meal Allowance Table</strong></p></a>
                <a onclick="ot_meal_enrollment()" type='button' class='<?php echo $view_ot_meal_emp;?> btn btn-default btn-flat'><p class='text-left'><strong>OT Meal Allowance Enrollment</strong></p></a>
            </div>  
           </div>             
          </div> <!-- box box-primary -->  
       </div> <!-- col-md-4 -->     
     <!-- </div>  row -->

     <!-- SCRIPT -->
  <script>

    function ot_meal_table()
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
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/ot_meal_table_view/",true);
      xmlhttp.send();
    }

    function get_company_table(val)
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

          document.getElementById("company_table").innerHTML=xmlhttp.responseText;
            $('#ot_allowance').DataTable( {
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "scrollX": true,
              "columnDefs": [
                { "width": "500px", "targets": 0 },
              ]
            });
          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/company_table_view/"+val,true);
      xmlhttp.send();
    }

    function ot_meal_table_add(val)
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

          document.getElementById("company_table").innerHTML=xmlhttp.responseText;
            $('#ot_allowance_add').DataTable( {
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "scrollX": true,
              "fixedColumns": true,
              "columnDefs": [
                { "width": "10%px", "targets": 0 },
                { "width": "10%px", "targets": 1 }
              ]
            });

            $('#location_add').selectpicker().change(function(){
              toggleSelectAll($(this));
            }).trigger('change');
            
            $('#every_hour_add').on('keyup', function(){
              if($('#every_hour_add').val() != ''){
                $('#every_hour_add').prop('required', true);
                $('#from_hour_add, #to_hour_add').prop('required', false);
                $('#from_hour_add, #to_hour_add').prop('disabled', true);
              } else {
                $('#every_hour_add').prop('required', true);
                $('#to_hour_add, #from_hour_add').prop('required', true);
                $('#to_hour_add, #from_hour_add').prop('disabled', false);
              }
            });

            $("#from_hour_add, #to_hour_add").on('keyup', function(){
              if($("#from_hour_add").val() != ''){
                $('#every_hour_add').prop('required', false);
                $('#every_hour_add').prop('disabled', true);
                $('#from_hour_add, #to_hour_add').prop('required', true);
                $('#from_hour_add, #to_hour_add').prop('disabled', false);
              }else if($("#to_hour_add").val() != ''){
                $('#every_hour_add').prop('required', false);
                $('#every_hour_add').prop('disabled', true);
                $('#from_hour_add, #to_hour_add').prop('required', true);
                $('#from_hour_add, #to_hour_add').prop('disabled', false);
              }else{
                $('#every_hour_add').prop('required', true);
                $('#every_hour_add').prop('disabled', false);
              }
            });

          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/ot_meal_table_add_view/"+val,true);
      xmlhttp.send();
    }

      function toggleSelectAll(control) {

        var allOptionIsSelected = (control.val() || []).indexOf("all") > -1;

        function valuesOf(elements) {
            return $.map(elements, function(element) {
                return element.value;
            });
        }

        if (control.data('allOptionIsSelected') != allOptionIsSelected) {
            if (allOptionIsSelected) {
                control.selectpicker('val', valuesOf(control.find('option')));
            } else {
                control.selectpicker('val', []);
            }
        } else {
            if (allOptionIsSelected && control.val().length != control.find('option').length) {
                control.selectpicker('val', valuesOf(control.find('option:selected[value!=all]')));
                allOptionIsSelected = false;
            } else if (!allOptionIsSelected && control.val().length == control.find('option').length - 1) {
                control.selectpicker('val', valuesOf(control.find('option')));
                allOptionIsSelected = true;
            }
        }
        control.data('allOptionIsSelected', allOptionIsSelected);
    }


    function ot_meal_table_edit(val)
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
            document.getElementById("company_table").innerHTML=xmlhttp.responseText;
            $('#ot_allowance_edit').DataTable( {
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "scrollX": true,
            });

            $("#ot_allowance_edit tbody").on('click', '#save_edit_ot_meal', function(){

              var ot_type_edit = $("select#ot_type_edit :selected").val();
              var location_edit = $("select#location_edit :selected").val();
              var classification_edit = $("select#classification_edit :selected").val();
              var emp_type_edit = $("select#emp_type_edit :selected").val();
              var every_hour_edit = $("input#every_hour_edit").val();
              var from_hour_edit = $("input#from_hour_edit").val();
              var to_hour_edit = $("input#remittance_date_edit").val();
              var amount_edit = $("input#amount_edit").val();

              $.ajax({
                url: '<?php echo base_url()?>app/payroll_automatic_ot_meal/edit_save/'+val,
                type: "post",
                data: { ot_type_edit:ot_type_edit, location_edit:location_edit, classification_edit:classification_edit, emp_type_edit:emp_type_edit, every_hour_edit:every_hour_edit, from_hour_edit:from_hour_edit, to_hour_edit:to_hour_edit, amount_edit:amount_edit },
                success: function(data){
                  location.reload();
                }
              });
            });

            if($('#every_hour_edit').val() != ''){
              $('#from_hour_edit, #to_hour_edit').prop('disabled', true);
            }else if($('#from_hour_edit, #to_hour_edit').val() != ''){
              $('#every_hour_edit').prop('disabled', true);
            }

            $('#every_hour_edit').on('keyup', function(){
              if($('#every_hour_edit').val() != ''){
                $('#from_hour_edit, #to_hour_edit').prop('disabled', true);
              }else{
                $('#from_hour_edit, #to_hour_edit').prop('disabled', false);
              }
            });

            $('#from_hour_edit, #to_hour_edit').on('keyup', function(){
              if($('#from_hour_edit, #to_hour_edit').val() != ''){
                $('#every_hour_edit').prop('disabled', true);
              }else{
                $('#every_hour_edit').prop('disabled', false);
              }
            });
           
          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/ot_meal_table_edit_view/"+val,true);
      xmlhttp.send();
    }

    function ot_meal_enrollment()
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
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/ot_meal_enrollment_view/",true);
      xmlhttp.send();
    }

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
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/company_employee_view/"+val,true);
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

    function ot_meal_employee_add(val)
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
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/ot_meal_employee_add_view/"+val,true);
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
    xmlhttp.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
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
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
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
      xmlhttp1.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
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
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
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
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
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
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
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
      xmlhttpDep.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/get_division_department/"+val,true);
      xmlhttpDep.send();
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
      xmlhttp1.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/get_department_section/"+val,true);
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
      xmlhttp1.open("GET","<?php echo base_url();?>app/payroll_automatic_ot_meal/get_section_subsection/"+val,true);
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