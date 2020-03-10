
<div class="content-body" style="background-color: #D7EFF7;">
	<div class="col-lg-12">
		<h2 class="page-header"><?php echo $info->dept_name; ?> Department Groups
			<span class="pull-right">
				<input type="hidden" id="division_list" value="<?php echo $division_id?>">
		  		<input type="hidden" id="department_list" value="<?php echo $department_id?>">
		  		<input type="hidden" id="has_division" value="<?php echo $has_division?>">
				<button type="button" class="btn btn-success" style="margin-right:5px;" onclick="add_group_form();"><i class="fa fa-plus-circle"></i> Create a Group 
				</button>
				<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#upload_template"><i class="fa fa-upload"> </i> Import Working Schedule Using Template</button>
			</span>
		</h2>
	<div id='main_body_groups'>
		<?php if ( (count($info->groups)) == 0 )
		{ ?>
			<div class="jumbotron">
				<center><h1>No groups yet</h1> <h2>Click 'Create a Group' button to start plotting schedules.</h2></center>
			</div>
		<?php  } else { $gg=1;
		foreach ($info->groups as $group) {  ?>

			<div class="panel panel-body">
			  <?php if ($group->manager_in_charge == $this->session->userdata('employee_id'))
		    { ?>
				<span class="pull-right">
					<button type="button" class="btn btn-default btn-xs" onclick="delete_group('<?php echo $group->id?>');"><i class="fa fa-trash"></i> Delete Group</button>
					<a type="button" class="btn btn-default btn-xs" onclick="edit_group('<?php echo $group->id?>');"><i class="fa fa-edit"></i> Edit Group</a>
				</span>

			<?php } ?>
				<div class="col-md-3"> <!-- start col-md-3 -->
					<h3><?php echo $group->group_name; ?></h3>
					<!-- Display Group Info here -->
					<div class="panel-body">
		              <div class="row">
		                  <table class="table table-user-information">
		                    <tbody>
		                      <tr>
		                        <td>Group Name</td>
		                        <td class="text-info"><strong><?php echo $group->group_name; ?></strong></td>
		                      </tr>
		                      <tr>
		                        <td>Date Created</td>
		                        <td><?php echo date("F d, Y", strtotime($group->date_created)); ?></td>
		                      </tr>
		                      <tr>
		                        <td>Department</td>
		                        <td><?php echo $info->dept_name; ?></td>
		                      </tr>
		                      <tr>
		                        <td>Created By</td>
		                        <td><?php echo $group->last_name . ", " . $group->first_name; ?></td>
		                      </tr>
		 
		                    </tbody>
		                  </table>
		                  <?php if ($group->manager_in_charge == $this->session->userdata('employee_id'))
		                  { ?>
		                    <a href="<?php echo base_url();?>employee_portal/section_mngr_management/plot_schedule/<?php echo $group->id; ?>" class="btn btn-primary btn-block">Plot Schedule</a>
		                  <?php }
		                  else
		                  { ?>
		              		<div class="btn btn-warning btn-block " data-toggle="tooltip" title="You may not delete and or plot schedule for all groups that you did not create." disabled>Plotting not allowed</div>
		                  <?php } ?>
		              </div>
					</div>
				</div> <!-- End Col-md-3 -->

				<div class="col-md-9">
					<h3>Group Members</h3>
				
				   <script type="text/javascript">
                      $(function () {
                        $('#table<?php echo $gg;?>').DataTable({
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
                <table class="col-md-12 offset col-md-1 table table-bordered" id="table<?php echo $gg;?>">
                        <thead>
                            <tr class="default">   
                              <th style="width:20%;">Employee ID</th>
                              <th style="width:20%;">Employee Name</th>
                              <th style="width:20%;">Location</th>
                              <th style="width:20%;">Classification</th>
                              <th style="width:20%;">Position</th>
                            </tr>
                        </thead>
                          <tbody>
                            <?php   foreach ($group->personnels as $per) { ?>
                              <tr>
                                <td><?php echo $per->info->employee_id; ?></td>
                                <td><?php echo $per->info->first_name . " " . $per->info->last_name; ?></td>
                                <td><?php echo $per->info->location_name; ?></td>
                                <td><?php echo $per->info->classification_name; ?></td>
                                <td><?php echo $per->info->position_name; ?></td>
                              </tr>
                            <?php } ?>
                          </tbody>
                      </table>

				</div>
			</div>
		<?php  $gg++; } } ?>
		</div>
	</div>