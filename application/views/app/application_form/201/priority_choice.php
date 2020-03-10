<title>Applicant Priority Choice</title>
<div ng-init="getAddress()">
  <div class="box-header with-border">
    <h3 class="box-title">Applicant Priority Choice</h3>
    <div class="box-tools pull-right">
    </div>
  </div>
  <br> 
 <div class="splash col-lg-12" ng-cloak="">
    <div class="spinner">
      <div class="double-bounce1"></div>
      <div class="double-bounce2"></div>
    </div>
    <center><h3 class="text-primary">Please wait while data loads..</h3></center>
  </div>
<div ng-cloak>
	<div class="col-lg-12">
	    <form name="add_info" method="post" action="update_priority_choice">
	       	<div class="col-md-10 pull-right">
	       	  <div class="panel panel-info">
	             <div class="panel-heading"><label>Priority Choice</label><br></div>
	                <div class="panel-body">
	                	<div class="col-md-3"></div>
	                	<div class="col-md-6">
	                	<?php $checker =  $this->application_form_model->check_priority_choice();?>
		                	<input type="checkbox" id="abroad" name="abroad" value="abroad" onclick="check();" <?php if(!empty($checker) AND $checker->abroad==1){ echo "checked"; }?>>Abroad <br>
		       				<input type="checkbox"  id="local" name="local" value="local" onclick="check();" <?php if(!empty($checker) AND  $checker->local==1){ echo "checked"; }?>>Local 
	       				</div>
	       				<div class="col-md-3"></div>
	       				<div class="col-md-12" style="margin-top: 20px;"><button class="col-md-12 btn btn-success btn-sm" id='btn'>UPDATE</button>
	                </div>
	             </div>
	          </div>
	       	</div>
	       	
	    </form>
	</div>	
	</div><!--  ng cloak -->
</div>

<script type="text/javascript">
	$(document).ready(function(){
   	if(document.getElementById('abroad').checked==false && document.getElementById('local').checked==false)
   		{ document.getElementById('btn').disabled=true; } 
   	else{ document.getElementById('btn').disabled=false; }
	});

	function check()
	{
		if(document.getElementById('abroad').checked==false && document.getElementById('local').checked==false)
   		{ document.getElementById('btn').disabled=true; } 
   		else{ document.getElementById('btn').disabled=false; }
	} 
</script>