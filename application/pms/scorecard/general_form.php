<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employee Portal - <?php echo $this->session->userdata('name_of_user'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/jquery.mCustomScrollbar.css" />

    <link href="<?php echo base_url()?>public/radio.css" rel="stylesheet">

    <!-- Inseparable -->
    <script type="text/javascript" src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/daterangepicker/moment.min.js"></script>
        <script src="<?php echo base_url()?>public/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- Angular JS & Application Controller -->
    <script type="text/javascript" src="<?php echo base_url()?>public/angular.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/angular-route.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/employee_controller.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/slimscroll.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/admin.min.js"></script>

   </head>

<body>

  	<div class="col-lg-12">
      	<div class="col-md-12">
          	<div class="panel panel-default">
	            <div class="panel-body">
                    <div class="box-header with-border">
                    	<h3 class="box-title"><strong style="color:#3c8dbc;">General Appraisal Format <i>(Created by Admin)</i></strong></h3>
					    <i class="fa fa-files-o pull-left">&nbsp;</i>
				    	<br><br>
					    <!-- <h3 class="box-title"><strong style="color:#3c8dbc;"><?=$employee->fullname?></strong></h3>
				    	<br><br> -->

		                <table id='score_criteria' class="table">
							<thead>
		                        <tr class='info'>
		                          	<th scope="col" colspan="4">Part <?=$gforms->part_number?>: <?=$gforms->part_name?></th>
		                      	</tr>
		                      	<tr>
		                          	<th scope="col">Score</th>
									<th scope="col" colspan="2"><?=$gforms->part_name?> Scoring Guide</th>
								</tr>
		                  	</thead>
							<tbody>
								<?php foreach($sc as $s):?>
								<tr id="score_criteria_data">
									<td><?=$s->score?></td>
									<td><?=$s->score_equivalent?></td>
									<td><?=$s->score_guide?></td>
								</tr>
								<?php endforeach?>
							</tbody>
						</table>

						<table id='pos_area' class="table">
							<thead>
		                      	<tr>
		                          	<th scope="col"><?=$gforms->part_name?></th>
									<th scope="col">Description</th>
									<th scope="col">Weight</th>
								</tr>
		                  	</thead>
		                  	<tbody>

							<?php foreach($position_areas as $area):?>
								<tr id='pos_area_data'>
									<td><?=$area->pos_area?></td>
									<td><?=$area->area_desc?></td>
									<td><?=$area->area_weight?></td>
								</tr>
							<?php endforeach?>
								<tr>
									<td></td>
									<td scope="col" colspan="1"><strong>Totals and Rating for Part <?=$gforms->part_number?></strong></td>
									<td scope="col" colspan="1"><?=$sum_weight->total?>%</td>
									<td scope="col" colspan="1"></td>
								</tr>
							</tbody>
		                </table>

                 		<div class="panel">
				        <div class="panel-body">
				        <div class="col-sm-6">     
				        </div>
				        <br><br>
				        	<button id='save_general_form' class="btn btn-success btn-block pull-right">

				        	Click to Use and just modify this Form, to prevent start from scratch form format creation.</button>
						
				        </div>
				        </div>

					</div>
              	</div>
	        </div>
        </div>
	</div>

	<!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
	
    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

	<script type="text/javascript">

	$(document).ready(function(){

		$('#save_general_form').click(function(){
			var posAreaData;
			posAreaData = getPosAreaValues();
			posAreaData = JSON.stringify(posAreaData);

			var scoreCriteriaData;
			scoreCriteriaData = getScoreCriteriaValues();
			scoreCriteriaData = JSON.stringify(scoreCriteriaData);

			var emp_id = '<?=$employee->employee_id?>';
			var form_id = '<?=$gforms->id?>';

			if(confirm("Are you sure you want to file this?")){
				$.ajax({
					url: '<?=base_url()?>employee_portal/pms/add_general_form/',
					type: 'POST',
					data: {emp_id:emp_id, form_id:form_id, posAreaData:posAreaData, scoreCriteriaData:scoreCriteriaData},
					success: function(data){
						window.close();
						window.opener.location.reload();
					}
				});
			}
		});
		
	 });

	function getScoreCriteriaValues() {
		var scoreCriteriaData = new Array();

		$('#score_criteria, #score_criteria_data').each(function(row, tr){
		    scoreCriteriaData[row] = {
		        "score" : $(tr).find('td:eq(0)').text(),
		        "score_equivalent" : $(tr).find('td:eq(1)').text(),
		        "score_guide" : $(tr).find('td:eq(2)').text(),
		    }
		});

		scoreCriteriaData.shift();
	 	return scoreCriteriaData;
	}

	function getPosAreaValues() {
		var posAreaData = new Array();

		$('#pos_area, #pos_area_data').each(function(row, tr){
		    posAreaData[row] = {
		        "pos_area" : $(tr).find('td:eq(0)').text(),
		        "area_desc" : $(tr).find('td:eq(1)').text(),
		        "area_weight" : $(tr).find('td:eq(2)').text(),
		    }
		});

		posAreaData.shift();
	 	return posAreaData;
	}

	</script>