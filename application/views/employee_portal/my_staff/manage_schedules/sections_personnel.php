<br><br>

<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">
<h2 class="page-header">Department: <?php if(!empty($department_name)){ echo $department_name; }  else{  echo "unknown"; } ?></h2>

	
			<?php foreach ($sections as $cc) {?>
		
				<div class="box box-solid box-success">
				    <div class="box-header with-border"> <h3 class="box-title"><a>Section:<?php echo $cc->section_name;?></a> </h3></div>
				  		<div class="panel panel-success panel-body">


				  		<?php 
				  			$emp_list = $this->my_staff_manage_schedules_model->get_section_location($cc->section,$department_id,$company_id);
				  			if(empty($emp_list)){ echo "<h3><center>NO PERSONNEL FOUND</center></h3>"; }
				  			else
				  			{
				  				
				  					
				  			?>
				  			 <script type="text/javascript">
				              $(function () {
				                $('#table<?php echo $cc->section;?>').DataTable({
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
				    				<table class="table table-bordered" id="table<?php echo $cc->section;?>">
						                <thead>
											<tr class="danger">   
						                        <th style="width:10%;">Employee ID</th>
						                        <th style="width:20%;">Employee Name</th>
						                        <th style="width:10%;">Subsection</th>
						                        <th style="width:15%;">Location</th>
						                        <th style="width:15%;">Classification</th>
						                        <th style="width:15%;">Employment</th>
						                        <th style="width:10%;">Action</th>
						                    </tr>
						                </thead>
			                  			<tbody>
			                  			<?php foreach($emp_list as $m){?>
			                  				<tr>
			                  					<td><?php echo $m->employee_id;?></td>
			                  					<td><?php echo $m->first_name.' '.$m->last_name;?></td>
			                  					<td><?php if(empty($m->subsection_name)) { echo "no subsection"; } else{ echo $m->subsection_name; }?></td>
			                  					<td><?php echo $m->location_name;?></td>
			                  					<td><?php echo $m->classification;	?></td>
			                  					<td><?php echo $m->employment_name;?></td>
			                  					<td>
									                  	<a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Employee 201 Information'    href="<?php echo base_url();?>employee_portal/my_staff_201_details/personnel_details/<?php echo $m->employee_id; ?>/<?php echo $m->company_id;?>/<?php echo $m->location;?>" target="_blank"><i class="fa fa-user text-info" style="font-size:18px"></i></a>&nbsp;|&nbsp;
						                               <a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Plotted Schedule'   href="<?php echo base_url();?>employee_portal/my_staff_201_details/schedule_details/<?php echo $m->employee_id; ?>/<?php echo $m->company_id;?>/<?php echo $m->location;?>" target="_blank"><i class="fa fa-calendar text-danger" style="font-size:18px"></i></a>&nbsp;|&nbsp;
						                               <a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Attendances'  href="<?php echo base_url();?>employee_portal/my_staff_201_details/attendance_details/<?php echo $m->employee_id; ?>/<?php echo $m->location;?>/<?php echo $m->company_id;?>" target="_blank"><i class="fa fa-clock-o text-success" style="font-size:18px"></i></a>

			                  					</td>
			                  				</tr>
			                  			<?php } ?>
			                  			</tbody>
			              			</table>
				    		</div>
				    	<?php }  ?>
				    </div>
				 </div>
			<?php } ?>	    	
	</div>
</div>	

<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
