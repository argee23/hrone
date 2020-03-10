
	 <div class="modal-content">
	      <div class="modal-body" style="height: 220px;">
	      	<div class="panel panel-danger" style="margin-top: 20px;">
	      	<form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>employee_portal/training_request/respond_employee_training_request">
	      		<div class="panel-heading">

	      			<h4><center>Do you want to join the <?php echo strtoupper($details->training_title);  echo $details->training_type;?> ?</center></h4>
	      			<center><input type="radio" name="final" checked onclick="respond('1');"> <label>Yes , I will join the <?php echo $details->training_type;?></label> </center>
	      			<center><input type="radio" name="final"onclick="respond('0');"> <label>No , I will not join the <?php echo $details->training_type;?></label></center> 

	      			<input type="hidden" name="finalans" id="finalans" value="1">
	      			<input type="hidden" name="training_title" id="training_title" value="<?php echo $details->training_title;?>">
	      			<input type="hidden" name="training_seminar_id" id="training_seminar_id" value="<?php echo $details->training_seminar_id;?>">
	      		</div>
	   	
	   			<div class="col-md-2 pull-right" style="margin-top: 20px;margin-bottom: 10px;">
		    		<button type="submit" class="btn btn-success pull-right" style="margin-right: 5px;">RESPOND</button>
		    	</div>
		    </form>
		    	<div class="col-md-10 pull-right" style="margin-top: 20px;margin-bottom: 10px;">
		    		<button class="btn btn-info pull-right" onclick="location.reload();" style="margin-right: 5px;"> CLOSE</button>
		    	</div>

		  

	    	</div>
	      </div>
	</div>


 <script type="text/javascript">
 	function respond(val)
 	{
 		document.getElementById('finalans').value=val;
 	}
 </script>
