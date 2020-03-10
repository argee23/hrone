<!DOCTYPE html>
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
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
    </head>


    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    
  </head>


<body>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->

  <section class="content">

<div class="row">
<div class="col-md-12">  
<form method="POST" action="<?php echo base_url()?>employee_portal/pms_employee/saveEmployeeForm/<?php echo $form_id;?>/<?php echo $employee_id;?>/<?php echo $position_id;?>" >
	<button  type="submit" class="btn btn-danger col-md-12">Save this general form as scorecard of employee: <?php echo $employee_id;?> ?
	</button>
</form>



</div>
<!-- //======================================== Form Details -->
  <div class="col-md-12">  
<div class="box box-primary">
<div class="panel-body">
  <div class="col-md-6">  
	  <button class="btn btn-success col-md-12"><?php echo $GenFormFormat->part_name?> </button>
	  <label>Description</label>
	  <p class="bg-default"><?php echo $GenFormFormat->part_desc?> </p>
	  <label>Weight</label>
	  <p class="bg-danger"><?php echo $GenFormFormat->form_weight?>% </p>
  </div>
  <div class="col-md-6">  
  <label>Instruction</label>
	  <p class="bg-danger"><?php echo $GenFormFormat->instructions?>% </p>
  </div>

  </div>
  </div>
  </div>
<!-- //======================================== Score Rates -->
  <div class="col-md-6">  
    <div class="box box-primary">
        <div class="panel-heading"><strong>Scoring Guide</strong></div>
      <div class="panel-body">

      <div class="table-responsive">
      	<table class="table table">
      		<thead>
      			<tr>
      				<th>Score</th>
      				<th>Scoring Guide</th>
      				<th>Percentage</th>
      			</tr>
      		</thead>
      		<tbody>
      			<?php
      			if(!empty($FormFormatScoring)){
      				foreach($FormFormatScoring as $s){
      					echo '
      						<tr>
      							<td>'.$s->score.'</td>
      							<td>'.$s->score_equivalent.'</td>
      							<td>'.$s->score_guide.'</td>
      						</tr>

      					';
      				}
      			}else{

      			}

      			?>
      		</tbody>
      	</table>
      </div>

      </div>
    </div>
  </div>

<!-- //======================================== Score Criteria -->
  <div class="col-md-6">  
    <div class="box box-primary">
        <div class="panel-heading"><strong>Criteria</strong></div>
      <div class="panel-body">

      <div class="table-responsive">
      	<table class="table table">
      		<thead>
      			<tr>
      				<th>Topic</th>
      				<th>Description</th>
      				<th>Weight</th>
      			</tr>
      		</thead>
      		<tbody>
      			<?php
      			if(!empty($GenFormCriteria)){
      				foreach($GenFormCriteria as $a){
      					echo '
      						<tr>
      							<td>'.$a->pos_area.'</td>
      							<td>'.$a->area_desc.'</td>
      							<td>'.$a->area_weight.'</td>
      						</tr>

      					';
      				}
      			}else{

      			}

      			?>
      		</tbody>
      	</table>
      </div>

      </div>
    </div>
  </div>



</div>

 
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

             
<!-- Loading (remove the following to stop the loading)-->   
<div class="overlay" hidden="hidden" id="loading">
<i class="fa fa-spinner fa-spin"></i>
</div>
<!-- ./ end loading -->
             


<footer class="footer ">
<div class="container-fluid">

<strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.


<div class="text-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</div>
</div>
</footer>
    <!--END footer-->
    <!--//==========Start Js/bootstrap==============================//-->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
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
///

	$(document).ready(function(){

		$('#save_general_form').click(function(){
			// var posAreaData;
			// posAreaData = getPosAreaValues();
			// posAreaData = JSON.stringify(posAreaData);

			// var scoreCriteriaData;
			// scoreCriteriaData = getScoreCriteriaValues();
			// scoreCriteriaData = JSON.stringify(scoreCriteriaData);

			var employee_id = '<?=$employee_id?>';
			var form_id = '<?=$form_id?>';

			if(confirm("Are you sure you want to file this?")){
				$.ajax({
					url: '<?=base_url()?>employee_portal/pms_employee/saveEmployeeForm/',
					type: 'POST',
					data: {employee_id:employee_id, form_id:form_id},
					success: function(data){
						window.close();
						window.opener.location.reload();
					}
				});
			}
		});
		
	 });



    </script>

  </body>
</html>