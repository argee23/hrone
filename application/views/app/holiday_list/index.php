
<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_holiday=$this->session->userdata('add_holiday');
$edit_holiday=$this->session->userdata('edit_holiday');
$disable_enable_holiday=$this->session->userdata('disable_enable_holiday');
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
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/iCheck/all.css">

    
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
    Administrator
    <small>Holiday List</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Administrator</li>
    <li class="active">Holiday List</li>
  </ol>
</section>

      <div class="container-fluid">
         
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
      <div class="row">
          <!-- Stacked Buttons -->
          <div class="col-md-6">
              
    <div class="box box-primary">
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>Holiday Lists</strong> 
      <a onclick="addNewHoliday()" class="<?php echo $add_holiday;?> btn btn-default btn-xs pull-right" title="Add">
      <?php
      echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
      ?>        
      </a>
      
      <a onclick="CheckedAllLocations()" class="<?php echo $add_holiday;?> btn btn-warning btn-xs" title="Click Me to 'Checked' All locations/branches of Enabled Holidays below">

      <?php
      echo '<i class="fa fa-'.$system_defined_icons->icon_manage.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_manage_color.';" "></i>';
      ?>        
      </a>
      
      </div>

      <div class="col-md-12"> 
        <div class="col-md-4" style="margin: 0 0 2% 0">
        <label>Sort By Year:</label>
        <select class="form-control select2" name="year" id="year" onchange="getYear(this.value)">
          <option selected="selected" value="" disabled="disabled"> Select Year </option>
          <?php foreach($years as $year1){
                  $year = $year1->year;
          ?>
          <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
          <?php }
          ?>
        </select>
        </div>
        <div class="col-md-4" style="margin: 0 0 2% 0">
        <label>Sort By Month:</label>
        <select class="form-control select2" name="month" id="month" onchange="getMonth(this.value)">
          <option selected="selected" value="" disabled="disabled"> Select Month </option>
          <?php for($m=1; $m<=12; ++$m){
              $month = date('F', mktime(0, 0, 0, $m, 1));
          ?>
          <option value="<?php echo $m ?>"><?php echo $month; ?></option>
          <?php }
          ?>
        </select>
        </div>
        <div class="col-md-4" style="margin: 0 0 2% 0">
        <label>Status:</label>
        <select class="form-control select2" name="status" id="status" onchange="getStatus(this.value)">
          <option selected="selected" value="0" > Enabled </option>
          <option value="1"> Disabled </option>
        </select>
        </div>
      </div>
      <div id="arrgh"></div>      
      <table id="user_table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Year</th>
                    <th>Holiday</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Company<i>(new feature,soon to be functional)</i></th>
                    <th>Status</th>
                    <th>Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($holiday_list as $holiday_list){if($holiday_list->holiday_InActive == 0){ $inactive = 'Enabled';}else{ $inactive = 'Disabled';}?>

                  <tr <?php if($holiday_list->holiday_InActive == 1){echo 'class="text-danger"';}else{echo 'class="text-success"';} ?>>

             <td><?php echo $holiday_list->hol_id?></td> 
                 <td><?php echo $holiday_list->year ?></td> 
                    <td><?php echo $holiday_list->holiday?></td>
                    <td><?php echo 
                        date("F", mktime(0, 0, 0, $holiday_list->month, 10)).
                        "&nbsp;". $holiday_list->day;?></td>
                    <td ><?php 

                   $code_type = $this->holiday_list_model->get_holiday_type_string($holiday_list->type);
                  foreach($code_type as $string_type){ 
                    echo $string_holiday=$string_type->cValue;
                  }

                   ?></td>
                    <td > 
<!-- //==================================================================================== -->

                  <?php 

                 // $data = $this->holiday_list_model->getBranches();
                  foreach($locationList as $row){ 

                  $data2 = $this->holiday_list_model->check_if_holiday_is_applicable($row->location_id,$holiday_list->hol_id);

                  if (!empty($data2)){
                  $applicable="checked";
                  }else{
                  $applicable="";
                  }


                  $branch =$row->location_name;
                  echo "<input type='checkbox'".$applicable.">&nbsp;".$branch."<br>";        

                  }

                  ?>  
<!-- //==================================================================================== -->
                    </td>
<!-- //==================================================================================== -->
                  <td>
                    <?php 
                    foreach($companyList as $c){
                      $check_comp = $this->holiday_list_model->check_if_holiday_iscomp_applicable($c->company_id,$holiday_list->hol_id);
                      if(!empty($check_comp)){
                        $comp_app="checked";
                      }else{
                        $comp_app="";
                      }
                      echo "<input type='checkbox' ".$comp_app.">&nbsp;".$c->company_name."<br>";        
                    }

                    ?>
                  </td>
<!-- //==================================================================================== -->

                    <td><?php echo $inactive ?></td> 
                    <td>

                    <?php if($holiday_list->holiday_InActive == 0){ ?>
                          
                        <?php

            echo $edit = '<i class="'.$edit_holiday.'fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" " data-toggle="tooltip" data-placement="left" title="Edit" onclick="editHoliday('.$holiday_list->hol_id.')"></i>';

            echo $en_dis = anchor('app/holiday_list/deactivate_holiday/'.$holiday_list->hol_id,'<i class="'.$disable_enable_holiday.'fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';" "></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Disable','onclick'=>"return confirm('Are you sure you want to disable ".$holiday_list->holiday." ?')"));

                        }else{

                             }


                              ?>
                    </td>
                  </tr>
                  <?php }?>
                </tbody>
              </table>
           
    </div>

          </div>
                       
<script>

<!--//======================   Holiday List //-->
 
function editHoliday(val)
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText; //col_4 before
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/holiday_list/edit_holiday/"+val,true);
        xmlhttp.send();

        }

 function addNewHoliday()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/holiday_list/add_new_holiday/",true);
        xmlhttp.send();

        }

 function CheckedAllLocations()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/holiday_list/CheckedAllLocations/",true);
        xmlhttp.send();

        }

 

  function disableEnterHoliday()
        {          
             
          $("#monthMsg").attr('class','text-danger');
          $("#month").attr('disabled','disabled');  
          $("#type").attr('disabled','disabled'); 

          $("#input_holiday").attr('disabled','disabled');  
          $("#year").attr('disabled','disabled');  
          //$("#month").attr('disabled','disabled');  
          $("#day").attr('disabled','disabled');  
          $("#type").attr('disabled','disabled');    
                  
          $('#manual_input_holiday').hide();     
          //$('#manual_select_month').hide();     
          $('#manual_select_year').hide();     
          $('#manual_select_day').hide();     
          $('#manual_select_type').hide();   

          //$('#testing').hide();     
      }
  function disableSelectHoliday()
        {          
           $('#select_holidays').hide();    
           //$("#department").attr('disabled','disabled');        
      }
  function applyChange()
        {  
          $("#month").attr('disabled','disabled'); 
          //$('#manual_select_month').hide(); 
        var selected_holiday = document.getElementById("selected_holiday").value;
        var month = document.getElementById("month").value;
            
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
            
            document.getElementById("showdate").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/holiday_list/get_date/"+selected_holiday,false);
        xmlhttp2.send();


        $("#user_table").DataTable();

        }

  function getYear(val)
        {  

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
            
            document.getElementById("user_table").innerHTML=xmlhttp.responseText;
            $("#month").val("");
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/holiday_list/get_year/"+val+"/"+status,true);
        xmlhttp.send();

        }

  function getMonth(val)
        {  

        var year = $('#year').val();
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
            
            document.getElementById("user_table").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/holiday_list/get_month/"+val+"/"+year+"/"+status,true);
        xmlhttp.send();

        }

  function getStatus(val)
        {  

        var year = $('#year').val();

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
            
            document.getElementById("user_table").innerHTML=xmlhttp.responseText;
            $('#year').val('');
            $('#month').val('');
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/holiday_list/get_status/"+val,true);
        xmlhttp.send();

        }

</script>
                        <div class="col-md-6" id="col_2">  
                        <!-- lalagyan ng add & edit -->
                    </div>
                </div>
            </div><!-- /.box-body -->
             
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
    <!-- iCheck 1.0.1 -->
    <script src="<?php echo base_url()?>public/plugins/iCheck/icheck.min.js"></script>

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }

      $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();

            //Datemask dd/mm/yyyy
            $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            //Datemask2 mm/dd/yyyy
            $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
            //Money Euro
            $("[data-mask]").inputmask();

            //Date range picker
            $('#reservation').daterangepicker();
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                  ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                  },
                  startDate: moment().subtract(29, 'days'),
                  endDate: moment()
                },
            function (start, end) {
              $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
            );

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
              checkboxClass: 'icheckbox_minimal-blue',
              radioClass: 'iradio_minimal-blue'
            });
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
              checkboxClass: 'icheckbox_minimal-red',
              radioClass: 'iradio_minimal-red'
            });
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
              checkboxClass: 'icheckbox_flat-green',
              radioClass: 'iradio_flat-green'
            });

            //Colorpicker
            $(".my-colorpicker1").colorpicker();
            //color picker with addon
            $(".my-colorpicker2").colorpicker();

            //Timepicker
            $(".timepicker").timepicker({
              showInputs: false
            });
          });
    </script>


  </body>
</html>