
<div id='whole_body'>
<br><br>

<div class="content-body" style="background-color: #D7EFF7;">
	<div class="col-lg-12">
		<h2 class="page-header"><?php echo $info->dept_name; ?> Department Groups
			<span class="pull-right">
				<input type="hidden" id="division_list" value="<?php echo $division_id?>">
		  		<input type="hidden" id="department_list" value="<?php echo $department_id?>">
		  		<input type="hidden" id="has_division" value="<?php echo $has_division?>">
				<button type="button" class="btn btn-success" style="margin-right:5px;" onclick="add_group_form();"><i class="fa fa-plus-circle"></i> Create a Group 
				</button>
			</span>
		</h2>
	<div id='main_body_groups'>
		<?php if ( (count($info->groups)) == 0 )
		{  ?>
			<div class="jumbotron">
				<center><h1>No groups yet</h1> <h2>Click 'Create a Group' button to start plotting schedules.</h2></center>
			</div>
		<?php  } else { $gg=1; 
		foreach ($info->groups as $group) {  
			$checker_per_locations = $this->section_mngr_management_model->checker_location_access($group->id,$location_access);
		
			
			
		?>

			<div class="panel panel-body">
			  
				<span class="pull-right">
					<button type="button" class="btn btn-default btn-xs" onclick="delete_group('<?php echo $group->id?>');"><i class="fa fa-trash"></i> Delete Group</button>
					<a type="button" class="btn btn-default btn-xs" onclick="edit_group('<?php echo $group->id?>');"><i class="fa fa-edit"></i> Edit Group</a>
				</span>
				<div class="col-md-3"> <!-- start col-md-3 -->
					<h3><?php echo $group->group_name; ?>q</h3> 
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
		                 
		                    <a target="_blank"  href="<?php echo base_url();?>employee_portal/section_mngr_management/plot_schedule/<?php echo $group->id; ?>" class="btn btn-primary btn-block btn-sm">Calendar Plotting</a>
		                 	<!-- <a target="_blank" href="<?php// echo base_url();?>employee_portal/section_mngr_management_plotting/plot_schedule_dropdown/<?php echo $group->id; ?>" class="btn btn-success btn-block btn-sm">Dropdown Selection Plotting</a> -->
		                 	<a data-toggle="modal" data-target="#excel_upload"  class="btn btn-success btn-block btn-sm" onclick="excel_mass_upload('<?php echo $group->id;?>','<?php echo $group->group_name;?>');">
		                 		Manual Excel Upload
		                 	</a>
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
		<?php  $gg++;   }  } ?>
		</div>
	</div>
  </div>

  <div class="modal modal-primary fade" id="excel_upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" >
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel"><center>Schedule Excel Upload<br><center><b><span id="group_name"></span></b></center></center></h4>
                  </div>
                 <div class="modal-body" style="height: 180px;">                             
                    		
                 		<div class="col-md-12">
                 		<div class="col-md-1"></div>
	                 		<div class="col-md-10">
	                 			 <form action="<?php echo base_url(); ?>employee_portal/section_mngr_management_plotting/excel_upload_schedule" method="post" name="upload_excel"  target="_blank" enctype="multipart/form-data">
	                 				<div class="col-md-12" style="margin-top: 5px;">
	                                   <select class="form-control" name="action" id="action" required>
	                                      <option value="" disabled selected >Select Action</option>
	                                      <option>Save</option>
	                                      <option>Review</option>
	                                   </select>
	                                </div>
	                                <div class="col-md-12" style="margin-top: 5px;">
		                                <div class="col-md-12 btn btn-info" id="upload">
		                                    <input type="file" name="file" id="file" ng-model="first_name" accept=".xls,.xlsx" required>
		                                </div>  
	                                </div>
	                                <input type="hidden" name="group_id_modal" id="group_id_modal" value="">
	                                <div class="col-md-12">
                   						 <button type="submit" name="import" id="import" class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="myFunction();" >IMPORT</button>
                   						 <a class="col-md-12 btn btn-danger btn-sm" style="margin-top: 2px;" href="<?php echo base_url(); ?>employee_portal/section_mngr_management_plotting/download_ws">DOWNLOAD TEMPLATE</a>
	                                </div>
	                            </form>
	                 		</div>
                 		<div class="col-md-1"></div>
                 		</div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>                          
            </div>
        </div>
  </div>
 

  <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
  <?php require_once(APPPATH.'views/employee_portal/section_mngr_management/js_functions.php');?>

  <script type="text/javascript">
  	function excel_mass_upload(group_id,group_name)
  	{
  		document.getElementById("group_name").innerHTML = '[ '+group_name+' ]';
  		document.getElementById('group_id_modal').value=group_id;
  	}

  	 function myFunction() {
            alert("NOTE: If there's a downloaded file open/check it to correct the template!");
           if(document.getElementById("file").value =='' || document.getElementById("file").value ==null)
           {
            alert("Select File to continue");
           }
           if(document.getElementById("action").value =="")
           {
              alert("Select Action to continue");
           }
      }
  </script>