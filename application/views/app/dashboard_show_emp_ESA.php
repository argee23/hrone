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
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
            <link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
    </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php 

if($this->session->userdata('is_logged_in')){
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Employment Status Alert
    <?php
if($current_account_logged_in!="employer_account"){

}else{
echo ' <small>Employer panel</small>';
}
    ?>
   
  </h1>
<?php echo $message;?>
</section>

<section class="content">

<!-- //====================================================================== -->

              <div class="col-md-12">
                <!-- EMPLOYEE STATUS ALERT -->
                <div id="emp_status_alert">
                  <div class='panel panel-danger'>
                    <div class ='panel-heading'><strong><?php echo $comp->company_name;?> (<?php echo $emp->employment_name;?>)</strong></div>
                      <div class='panel-body'>
                        <div class="col-md-12 collapse" id="employee_contract_view" aria-expanded="true">
                          <div class="panel panel-info">
                            <div class="panel-heading"><strong>Employee Contract</strong><button type="button" class="close" id="close_contract">×</button></div>
                            <div class="panel-body">
                              <dl class="dl-horizontal" id="contract_details"></dl>            
                            <div class="col-md-12">
                                    <label class="col-md-3">Select Action</label>
                                    <input type="hidden" id="employee_id" >
                                    <input type="hidden" id="company_id" >
                                    <input type="hidden" id="baseurl" value="<?php echo base_url();?>app/">

                                    <select class="col-md-6" onchange="onpage_gethref(this.value)" >
                                        <option value="" disabled selected>Select Action</option>
                                        <option value='employee_201_profile/movement_history_view'>Create New Movement</option>
                                        <option value='employee_201_profile/contract_view'>Create New Contract</option>
                                        <option value='employee_201_profile/contract_close'>Close Contract Early</option>
                                        <option value='employee/employee_list'>Resign Employe</option>
                                      </select> 
                                    <script type="text/javascript">
                                        function onpage_gethref(val) 
                                                {
                                                  if(val=='employee/employee_list')
                                                  {
                                                    var data = document.getElementById('company_id').value;
                                                  } 
                                                  else
                                                  {
                                                    var data = document.getElementById('employee_id').value;
                                                  }
                                                  if(val=='employee_201_profile/contract_close')
                                                  {
                                                    
                                                    var base_url = document.getElementById('baseurl').value;
                                                    var location_href =base_url + "employee_201_profile/contract_view" + "/" + data;
                                                    window.open(location_href);        
                                                  }
                                                  else
                                                  {
                                                    var base_url = document.getElementById('baseurl').value;
                                                    var location_href =base_url + val + "/" + data;
                                                    window.open(location_href);
                                                  }
                                                  
                                                    $.ajax({
                                                          'async': false,
                                                          'type': "POST",
                                                          'global': false,
                                                          'url': '<?php echo base_url();?>app/dashboard/session/',
                                                          'data': { "type" : val},
                                                          'success': function (data) {
                                                          }
                                                      });

                                                }
                                    </script>
                                </div>    
                            </div>
                          </div>
                        </div>

                        <div id="employee_contract">
                          <table id="employee_contract_table" class="table table-hover">
                            <thead>
                              <tr>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>From</th>
                                <th>To</th>
                                <th>No. of Day(s) Left</th>
                                <th>No. of Day(s) Due</th>
                                <th>Status</th>
                                <th>Option</th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                  </div> 
                </div>
                <!-- END EMPLOYEE STATUS ALERT -->


          </div><!-- /.col -->


</section>
</div>



 <?php require_once(APPPATH.'views/include/footer.php');?>
    <!-- REQUIRED JS SCRIPTS -->
  <!-- Placed at the end of the document so the pages load faster --> 
<script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script> 
<script src="<?php echo base_url()?>public/app.min.js"></script> 
<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url()?>public/chartjs/Chart.js"></script>
<script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>

<!-- ADDED JS SCRIPTS -->
<link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <script src="<?php echo base_url()?>public/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- ADDED JS SCRIPTS -->

<script type="text/javascript">
 
  //-----employment status-----//

  var id = '<?php echo $this->uri->segment("4")?>';
  var company_id = '<?php echo $this->uri->segment("5")?>';

  //$('#employee_contract_table').DataTable().clear().draw().destroy();
  $('#employee_contract_table').DataTable({
    'ajax': {
      'url': '<?=base_url()?>app/dashboard/get_employees_by_contract_view/',
      "type": "POST",
        "data": {id:id, company_id:company_id}
    },
    "columnDefs": [
      { "width": "20%", "targets": 0 },
      { "width": "20%", "targets": 1 },
      { "width": "10%", "targets": 2 },
      { "width": "10%", "targets": 3 },
      { "width": "20%", "targets": 4 },
      { "width": "20%", "targets": 5 },
    ]
  });
  
  function view_employee_contract(id){
    var data = id;
    $.ajax({
      type: "POST",
      data: {id: data},
      url: '<?=base_url()?>app/dashboard/get_employee_contract/',
      dataType: 'json',
      success: function(data){
            var info = data.data;
            document.getElementById('employee_id').value=info.employee_id;
            document.getElementById('company_id').value=info.company_id;

            if(data){
              if( $('#contract_details').is(':empty') ){
                $("<dt>Employee ID:</dt>" + "<dd>" + info.employee_id + "</dd>").appendTo('#contract_details');

                if(info.name_extension == null) {
                  $("<dt>Full Name:</dt>" + "<dd>" + info.last_name + ", " + info.first_name + " " + info.middle_name + "</dd>").appendTo('#contract_details')
                } else {
                   $("<dt>Full Name:</dt>" + "<dd>" + info.last_name + ", " + info.first_name + " " + info.middle_name + " " + info.name_extension + "</dd>").appendTo('#contract_details');
                }
               
                $("<dt>Division:</dt>" + "<dd>" + info.division_name + "</dd>").appendTo('#contract_details');

                $("<dt>Deparment:</dt>" + "<dd>" + info.dept_name + "</dd>").appendTo('#contract_details');

                $("<dt>Section:</dt>" + "<dd>" + info.section_name + "</dd>").appendTo('#contract_details');

                $("<dt>Subsection:</dt>" + "<dd>" + info.subsection_name + "</dd>").appendTo('#contract_details');
                
                $("<dt>Start of Contract:</dt>" + "<dd>" + info.start_date + "</dd>").appendTo('#contract_details');

                $("<dt>End of Contract:</dt>" + "<dd>" + info.end_date + "</dd>").appendTo('#contract_details');

                $("<dt>Employment Type:</dt>" + "<dd>" + info.employment_name + "</dd>").appendTo('#contract_details');

                $("<dt>Remark:</dt>" + "<dd>" + info.remark + "</dd>").appendTo('#contract_details');

                $("<dt>Document:</dt>" + "<dd>" + info.file + "</dd>").appendTo('#contract_details');

                $("<dt>Actions:</dt><dd><select class='form-control' style='width:40%'><option selected disabled>select action</option></select></dd>").appendTo('#contract_details');

              } else if($('#contract_details').empty()) {
                $("<dt>Employee ID:</dt>" + "<dd>" + info.employee_id + "</dd>").appendTo('#contract_details');

                if(info.name_extension == null) {
                  $("<dt>Full Name:</dt>" + "<dd>" + info.last_name + ", " + info.first_name + " " + info.middle_name + "</dd>").appendTo('#contract_details')
                } else {
                   $("<dt>Full Name:</dt>" + "<dd>" + info.last_name + ", " + info.first_name + " " + info.middle_name + " " + info.name_extension + "</dd>").appendTo('#contract_details');
                }

                $("<dt>Division:</dt>" + "<dd>" + info.division_name + "</dd>").appendTo('#contract_details');

                $("<dt>Deparment:</dt>" + "<dd>" + info.dept_name + "</dd>").appendTo('#contract_details');

                $("<dt>Section:</dt>" + "<dd>" + info.section_name + "</dd>").appendTo('#contract_details');

                $("<dt>Subsection:</dt>" + "<dd>" + info.subsection_name + "</dd>").appendTo('#contract_details');
                
                $("<dt>Start of Contract:</dt>" + "<dd>" + info.start_date + "</dd>").appendTo('#contract_details');

                $("<dt>End of Contract:</dt>" + "<dd>" + info.end_date + "</dd>").appendTo('#contract_details');

                $("<dt>Employment Type:</dt>" + "<dd>" + info.employment_name + "</dd>").appendTo('#contract_details');

                $("<dt>Remark:</dt>" + "<dd>" + info.remark + "</dd>").appendTo('#contract_details');

                $("<dt>Document:</dt>" + "<dd>" + info.file + "</dd>").appendTo('#contract_details');

                $("<dt>Actions:</dt><dd><select class='form-control' style='width:40%'><option selected disabled>select action</option></select></dd>").appendTo('#contract_details');
              } else {
                $('#contract_details').empty();
              }
            } else {
              alert(info.employee_id);
            }
        }
    });
  }

  $('.close').click(function(){
    $('#employee_contract_view').removeClass('in');
  });
  //-----end employment status-----//

</script>

<script>
      $(document).ready(function(){

        var ctx = $("#pieChart").get(0).getContext("2d");

        // pie chart data
        // sum of values = 360
        var data = [
<?php
foreach($companyList as $comp){

$company_id=$comp->company_id;
$count_emp=$this->dashboard_model->count_employee_per_company($company_id);
$array_items = count($count_emp);

echo '{
          value: '.$array_items.',
          color: "cornflowerblue",
          highlight: "lightskyblue",
          label: "'.$comp->company_name.'"

        },';
}

?>
     
        {
          value: <?Php echo $array_items_count_all_emp;?>,
          color: "red",
          highlight: "darkorange",
          label: "MIS"

        }
        ];

        // draw
        var piechart = new Chart(ctx).Pie(data);

        var ctx = $("#pieChart2").get(0).getContext("2d");

        // pie chart data
        // sum of values = 360
        var data = [
        {
          value: 120,
          color: "cornflowerblue",
          highlight: "lightskyblue",
          label: "Manpower"

        },
        {
          value: 63,
          color: "lightgreen",
          highlight: "yellowgreen",
          label: "Engineering"

        },
        {
          value: 52,
          color: "orange",
          highlight: "darkorange",
          label: "MIS"

        }
        ];

        // draw
        var piechart = new Chart(ctx).Pie(data);

      });

      // set the date we're counting down to
      var target_date = new Date('May, 05, 2016').getTime();
       
      // variables for time units
      var days, hours, minutes, seconds;
       
      // get tag element
      var countdown = document.getElementById('countdown');
       
      // update the tag with id "countdown" every 1 second
      setInterval(function () {
       
          // find the amount of "seconds" between now and target
          var current_date = new Date().getTime();
          var seconds_left = (target_date - current_date) / 1000;
       
          // do some time calculations
          days = parseInt(seconds_left / 86400);
          seconds_left = seconds_left % 86400;
           
          hours = parseInt(seconds_left / 3600);
          seconds_left = seconds_left % 3600;
           
          minutes = parseInt(seconds_left / 60);
          seconds = parseInt(seconds_left % 60);
           
          // format countdown string + set tag value
          countdown.innerHTML = '<span class="days">' + days +  ' <b>Days</b></span> <span class="hours">' + hours + ' <b>Hours</b></span> <span class="minutes">'
          + minutes + ' <b>Minutes</b></span> <span class="seconds">' + seconds + ' <b>Seconds</b></span>';  
       
      }, 1000);

    </script>

  </body>

    <style type="text/css">
      .show-calendar{
        width:50%;
      }
    </style>

</html>