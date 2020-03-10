<br><br>

<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">
<h2 class="page-header"><?php echo $info->dept_name; ?></h2>

<?php $c_section=1; foreach ($info->sections as $sec) { ?>

	<div class="box box-solid box-success">
	    <div class="box-header with-border"> <h3 class="box-title"><a>Section: <?php echo $sec->section_name; ?></a> </h3>
	    </div>
	    <div class="box-body">
	    	<?php if ($sec->wSubsection == 1)
	    	{ $c_subsec=1; foreach ($sec->subsections as $sub) { ?>
	    		<div class="panel panel-success panel-body">
	    			<p class="text-success"><strong>Subsection: <?php echo ucwords($sub->subsection_name); ?></strong></p>
	    			<?php $c_location=1; foreach ($sub->locations as $loc)
	    			{  if(empty($loc->personnel)){} else{ ?>
	    				<div class="panel panel-default panel-body">
	    				<p class="text-danger"><i class="fa fa-map-marker"></i> <?php echo ucwords($loc->location_name); ?></p>
	    					 <script type="text/javascript">
				              $(function () {
				                $('#table<?php echo $c_section.$c_subsec.$c_location;?>').DataTable({
				                  "pageLength": 5,
				                  "pagingType" : "simple",
				                  "paging": true,
				                   lengthMenu: [[1,5, 10, 15, -1], [1,5, 10, 15, "All"]],
				                  "lengthChange": true,
				                  "searching": true,
				                  "ordering": true,
				                  "info": true,
				                  "autoWidth": false
				                });
				              });
				            </script>
	    					<table class="table table-bordered" id="table<?php echo $c_section.$c_subsec.$c_location;?>">
			                  <thead>

			                      <tr>   
			                        <th style="width:20%;">Employee ID</th>
			                        <th style="width:20%;">Employee Name</th>
			                        <th style="width:20%;">Classification</th>
			                        <th style="width:20%;">Position</th>
			                        <th style="width:20%;">Action</th>
			                      </tr>
			                  </thead>
                  			  <tbody>
                  			  	<?php foreach ($loc->personnel as $per){ ?>
                      			  <tr>
                      			  	<td><?php echo $per->employee_id?></td>
		                          	<td><?php echo $per->first_name . " " . $per->last_name; ?></td>
		                          	<td><?php echo $per->classification_name; ?></td>
		                          	<td><?php echo $per->position_name; ?></td>
		                          	<td>
		                          		 <a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Employee 201 Information'    href="<?php echo base_url();?>employee_portal/my_staff_201_details/personnel_details/<?php echo $per->employee_id; ?>/<?php echo $per->company_id;?>/<?php echo $per->location;?>" target="_blank"><i class="fa fa-user text-info" style="font-size:18px"></i></a>&nbsp;|&nbsp;
			                             <a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Plotted Schedule'   href="<?php echo base_url();?>employee_portal/my_staff_201_details/schedule_details/<?php echo $per->employee_id; ?>/<?php echo $per->company_id;?>/<?php echo $per->location;?>" target="_blank"><i class="fa fa-calendar text-danger" style="font-size:18px"></i></a>&nbsp;|&nbsp;
			                             <a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Attendances'  href="<?php echo base_url();?>employee_portal/my_staff_201_details/attendance_details/<?php echo $per->employee_id; ?>/<?php echo $per->location;?>/<?php echo $per->company_id;?>" target="_blank"><i class="fa fa-clock-o text-success" style="font-size:18px"></i></a>

		                          	</td>
                      			  </tr>
                      			<?php } ?>
                  			  </tbody>
              				</table>
	    				</div>
	    			<?php $c_location++; } }?> <!-- End Locations -->
	    		</div>
	    		<hr>
	    	<?php  $c_subsec++; } //End Subsections
	    	  } else { ?>

	    	  <?php $c_location=1; foreach ($sec->locations as $loc)
	    			{ if(empty($loc->personnel)) {} else{ ?>
	    			 <script type="text/javascript">
				              $(function () {
				                $('#tablenosubsection<?php echo $c_section.$c_location;?>').DataTable({
				                  "pageLength": 5,
				                  "pagingType" : "simple",
				                  "paging": true,
				                   lengthMenu: [[1,5, 10, 15, -1], [1,5, 10, 15, "All"]],
				                  "lengthChange": true,
				                  "searching": true,
				                  "ordering": true,
				                  "info": true,
				                  "autoWidth": false
				                });
				              });
				            </script>
	    			<div class="panel panel-default panel-body">
	    					<p class="text-danger"><i class="fa fa-map-marker"></i> <?php echo ucwords($loc->location_name); ?></p>
	    	  			<table class="table table-bordered" id="tablenosubsection<?php echo $c_section.$c_location?>">
			                  <thead>

			                      <tr>   
			                        <th style="width:20%;">Employee ID</th>
			                        <th style="width:20%;">Employee Name</th>
			                        <th style="width:20%;">Classification</th>
			                        <th style="width:20%;">Position</th>
			                        <th style="width:20%;">Action</th>
			                      </tr>
			                  </thead>
                  			  <tbody>
                  			  	<?php foreach ($loc->personnel as $per){ ?>
                      			  <tr>
                      			  	<td><?php echo $per->employee_id?></td>
		                          	<td><?php echo $per->first_name . " " . $per->last_name; ?></td>
		                          	<td><?php echo $per->classification_name; ?></td>
		                          	<td><?php echo $per->position_name; ?></td>
		                          	<td>
		                          		   <a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Employee 201 Information'    href="<?php echo base_url();?>employee_portal/my_staff_201_details/personnel_details/<?php echo $per->employee_id; ?>/<?php echo $per->company_id;?>/<?php echo $per->location;?>" target="_blank"><i class="fa fa-user text-info" style="font-size:18px"></i></a>&nbsp;|&nbsp;
			                               <a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Plotted Schedule'   href="<?php echo base_url();?>employee_portal/my_staff_201_details/schedule_details/<?php echo $per->employee_id; ?>/<?php echo $per->company_id;?>/<?php echo $per->location;?>" target="_blank"><i class="fa fa-calendar text-danger" style="font-size:18px"></i></a>&nbsp;|&nbsp;
			                               <a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Attendances'  href="<?php echo base_url();?>employee_portal/my_staff_201_details/attendance_details/<?php echo $per->employee_id; ?>/<?php echo $per->location;?>/<?php echo $per->company_id;?>" target="_blank"><i class="fa fa-clock-o text-success" style="font-size:18px"></i></a>
					                </td>
                      			  </tr>
                      			<?php } ?>
                  			  </tbody>
              				</table>
              				</div>
              				<?php $c_location++; }?>
	    	<?php } }?>
	    </div>
    </div>
<?php $c_section++; } ?><!--  End Sections -->
</div>
</div>	

<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
