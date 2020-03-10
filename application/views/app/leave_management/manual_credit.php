<?php
$current_leave_id=$this->uri->segment("4");
$company_id=$this->uri->segment("5");
$company_name=$leave_type->company_name;
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
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    
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
    <small>Leave Management</small>
   
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Administrator</li>
    <li class="active">Leave Management</li>
  </ol>
</section>

      <div class="container-fluid">
         
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

<div class="row">
<div class="col-md-12">
<div class="well">
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/leave_management/save_manual_credit"  >

	<div class="box box-primary">        
	Manual Encode Credits for <strong><?php echo $leave_type->leave_type;?></strong>



                


                
<!--     <a  type="button" class="btn btn-warning btn-xs pull-right" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user-plus"></i> Import Excel</a> -->

<!--     <a href="<?php //echo base_url()?>app/leave_management/export_to_excel_leave/<?php //echo $leave_type->id;?>" type="button" class="btn btn-danger btn-xs pull-right" title="Export To Excel"><i class="fa fa-user-plus"></i> Export To Excel</a>  -->

	</div>

    <div class="box-body">

      <div class="form-group"   >
        <label for="cutoff" class="col-sm-2 control-label">Covered Cutoff</label>
      <div class="col-sm-10" >
        <select class="form-control" name="year">
        <?php 
        if($leave_type->cutoff=="yearly"){
        	$text_cutoff=date('Y');
        }else{
        	$text_cutoff=$leave_type->cutoff;
        }
        ?>
        <option value="<?php echo date('Y');?>"><?php echo $text_cutoff;?></option>
        </select>
    </div>

  <input type="hidden" name="leave_id" value="<?php echo $this->uri->segment("4");?>">
  <input type="hidden" name="leave_type" value="<?php echo $leave_type->leave_type?>">  
  <input type="hidden" name="company_id" value="<?php echo $company_id?>">  

<!-- emp_table -->



<input type="hidden" name="n1" id="n1" onkeyup="sync()">


<table id="emp_table" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Employee ID</th>
			<th>Name</th>
			<th>Date Employed</th>
			<th>Classification</th>
			<th>Employment</th>
			<th><u><?php echo $leave_type->leave_type;?></u> Credit</th>
      <th>Leave Used</th>
      <th>Updated Available Leave <br>(Credit-Leave Used)</th>
		</tr>
	</thead>
	<tbody>
	<?php
  $the_nos=0;
	if(!empty($emp_list)){
		foreach($emp_list as $e){
       $sum_use_leave = 0;
      $the_nos++;

  		$employee_id=$e->employee_id;
  		$fiscal_year=date('Y');

  		$my_credit=$this->leave_management_model->check_leave_credit($current_leave_id,$employee_id,$fiscal_year);
      $incentive_leave_subject_approval = $this->leave_management_model->incentive_leave_subject_approval($employee_id,$current_leave_id);
  		if(!empty($my_credit)){
        if($current_leave_id==1)
        {
          $the_credit=$my_credit->available + $incentive_leave_subject_approval;
        }
        else
        {
          $the_credit=$my_credit->available;
        }
        $thecredit = $my_credit->available;
      }else{
        if($current_leave_id==1)
        {
          $the_credit=""+$incentive_leave_subject_approval;
        }
        else
        {
          $the_credit="";
        }
        $thecredit = "0";
      }



$raw_use_leave = $this->leave_management_model->check_use_leave($current_leave_id,$employee_id,$leave_type->cutoff,$e->date_employed);
        foreach($raw_use_leave as $use_leave){ 
         //$sum_use_leave+=$use_leave->no_of_days; // add all leave for specific employee
          if($use_leave->no_of_days=="0.5"){
                $sum_use_leave+=$use_leave->no_of_days;
            }else{
                $sum_use_leave+=$use_leave->days;                       
            }

        } 


			echo '
			<tr>
			<td>'.$e->employee_id.'</td>
			<td>'.$e->name_lname_first.'</td>
			<td>'.$e->date_employed.'</td>
			<td>'.$e->classification_name.'</td>
			<td>'.$e->employment_name.'</td>
			<td>';

      if($current_leave_id==1){
      echo'('.$thecredit.' (manual credit) + ( <a  href="'.base_url().'app/leave_management/earned_from_ot/'.$current_leave_id.'/'.$employee_id.'" target="_blank" title="Click to View Approved OT (Earned Credits)" role="button" class="btn btn-success btn-xs"><i class="fa fa-eye"></i>'.$incentive_leave_subject_approval.' OT</a> ) = '.$sum = $thecredit + $incentive_leave_subject_approval.'<br>';
      } else { echo '
      <span style="color:#fff;">'.$the_credit.'</span>'; } echo '
			<input type="number" style="width:100%;" step="any" class="fomr-control" name="credit_'.$e->employee_id.'" value="'.$thecredit.'" placeholder="encode credits here" id="nnn'.$the_nos.'" >
			<input type="hidden" name="employee_id[]" value="'.$e->employee_id.'"> 
			</td>
      <td>';
  
                          if($sum_use_leave==0){
                            echo $sum_use_leave=0;
                          }else{

echo ' <a  href="'.base_url().'app/leave_management/leave_usage/'.$current_leave_id.'/'.$employee_id.'/'.$e->first_name.' '.$e->middle_name.' '.$e->last_name.'/'.$e->date_employed.'" target="_blank" title="Click to View Leave Usage" role="button" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> '.$sum_use_leave.'</a>';





                          }

 echo     '</td>
 <td>'.$a=$the_credit-$sum_use_leave.'</td>
			</tr>
			';



		}
	}else{

	}

    ?>

    <script>
      function sync(){
        var x =<?php echo $the_nos;?>;
        var i;
        for (i = 0; i < x; i++) {
          nnn<?php echo $the_nos;?>.value = n1.value;
        }
      }
    </script>

	</tbody>
</table>

 <button type="submit" class="btn btn-lg btn-danger pull-right"> Save </button>

</div>

</form>


</div>
</div>
</div>


</div>
 <?php require_once(APPPATH.'views/include/footer.php');?>




    <!-- REQUIRED JS SCRIPTS -->
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
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
    <!--//==========End Js/bootstrap==============================//-->

    <script type="text/javascript">

      // $(function () {
      //   $("#example1").DataTable();
      // });
      $(document).ready(function() {
                             $("#emp_table").DataTable({
                                    "dom": '<"top">Bfrt<"bottom"li><"clear">',
                                    "pageLength":-1,
                                    lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                                    buttons:
                                    [
                                      {
                                        extend: 'excel',
                                        title: 'Leave Credits'
                                      },
                                      {
                                        extend: 'print',
                                        title: 'Leave Credits'
                                      }
                                    ]              
                                  });




      } );

    </script>

  </body>
</html>