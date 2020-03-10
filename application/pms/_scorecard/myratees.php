<br><br><br>
<div>
    <!-- Start of Side View -->
    <div class="col-md-6">
      <div class="panel box box-success">
        <div class="panel-heading"><h4>My Ratees  <span class="pull-right"><i class="fa fa-gear"></i></span></h4></div>
        <div class="panel-body  fixed-panel-side mCustomScrollbar" data-mcs-theme="dark"">

        <div class="table-responsive">

			<table id="example1" class="table table-hover table-alternate">
				<thead>
					<tr class="info">
						<th>Employee ID</th>
						<th>Employee Name</th>
						<th>Position</th>
						<th>Date Employed</th>
						<th>Action</th>
					</tr>
				</thead>
			<tbody>
				<?php 
					if($ratee){
					foreach($ratee as $r):
					//$checkForm=$this->pms_model->checkForm($r->employee_id);
				?>
				<tr>
				<td><?=$r->employee_id;?></td>
				<td><?=$r->fullname;?></td>

				<td><?=$r->position_name;?></td>
				<td><?=$r->date_employed;?></td>
				<td>
				<?php
				// if(!empty($checkForm)){
				// $the_action="View/Update Form Format";
				// $clr="btn-primary";
				// }else{
				// $the_action="Create Form Format";
				// $clr="btn-danger";
				// }
				?>


	<!-- 			<button onclick="scorecard('<?=$r->employee_id;?>')" type="button" class="btn <?php //echo $clr;?>"><?php //echo $the_action;?>
				</button> -->
				<button onclick="scorecard('<?=$r->employee_id;?>')" type="button" class="btn btn-danger">Manage Form Format
				</button>
				</td>
				</tr>
				<?php endforeach ?>

				<?php } else {?>
				<tr><td scope="col" colspan="3"><h3><center><strong>No Ratee(s) Assigned</strong></center><h3></td></tr>
				<?php }?>
			</tbody>
			</table>
        	
        </div>


        </div>
      </div>
    </div>

  <div class="col-md-6" id="employee_table">
    <div class="panel box box-success" >

    </div>
  </div>
</div>

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



<script type="text/javascript">
       $(document).ready(function() {
                             $("#example1").DataTable({
                                    "dom": '<"top">Bfrt<"bottom"li><"clear">',
                                    "pageLength":-1,
                                    lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                                    buttons:
                                    [
                                      {
                                        extend: 'excel',
                                        title: 'Report'
                                      },
                                      {
                                        extend: 'print',
                                        title: 'Report'
                                      }
                                    ]              
                                  });




      } );



	function scorecard(employee_id){
		$.ajax({
	  		url: "<?php echo base_url();?>employee_portal/pms_employee/view_scorecards/"+employee_id,
	  		success: function(data){
	  			$('#create, #view').attr("disabled", "disabled");
	  			$('#employee_table').html(data);
	  		}
		});
	}


</script>
