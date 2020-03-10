	<br><br>
	
	<script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
	
  	<div class="col-lg-12">
  	<h2 class="page-header">Performance Appraisal</h2>
  	<?php echo $message;?>
  	<?php echo validation_errors(); ?>
      	<div class="col-md-5">
          	<div class="panel panel-default">
	            <div class="panel-body">
                    <div class="box-header with-border">
					    <h3 class="box-title"><strong style="color:#3c8dbc;">Approver Management</strong></h3>
					    <i class="fa fa-users pull-left">&nbsp;</i>
					   	<br><br>
					    <table class="table table-hover table-alternate">
							<thead>
		                        <tr class="danger">
		                          <th>Employee ID</th>
		                          <th>Employee Name</th>
		                          <th>Action</th>
		                        </tr>
		                  	</thead>
							<tbody>
								<?php foreach($evaluee as $eval):?>
								<tr>
									<td><?=$eval->employee_id;?></td>
									<td><?=$eval->fullname;?></td>
									<td><button onclick="approvers('<?=$eval->employee_id;?>');" class="btn btn-primary" data-toggle="tooltip" title="View Approvers">View Approvers</button>
									</td>
								</tr>
								<?php endforeach ?>
							</tbody>
	                    </table>
					</div>
              	</div>
	        </div>
        </div>

        <div class="col-md-7">
	        <div id="employee_table">
	        	
	        </div>
	    </div>

	</div>

	<script src="<?php echo base_url()?>public/plugins/slimScroll/jquery.slimscroll.min.js"></script>
   	<!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
	
    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>


	<script type="text/javascript">
		function approvers(emp_id){
			$.ajax({
		  		url: "<?php echo base_url();?>employee_portal/pms/view_approvers/"+emp_id,
		  		success: function(data){
		  			$('#employee_table').html(data);
		  		}
			});
		}

	</script>