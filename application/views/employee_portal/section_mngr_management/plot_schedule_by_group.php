<br><br>
 <?php require_once(APPPATH.'views/include/calendar.php');?>
<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">
<h2 class="page-header ng-scope">Plot Schedule</h2>
<div class="content-body">
<div class="row">
  <div class="col-md-3">
    <div class="box box-primary">
     <div class="box-header with-border">
          <h3 class="box-title">Schedule Reference</h3>
      </div>

      <div class="box-body" >

      <!-- Classifications -->
      <div class="form-group">
	  <label for="sel1">Choose a classification: </label>
	  	<select class="form-control" id="sel1">
	    	
  	   </select>
	  </div> 

	  <!-- Schedule Type -->
	  <div class="form-group">
	  <label for="sel1">Choose a Schedule Type:</label>
	  	<select class="form-control">
	    	
  	   </select>
	  </div> 

	   <!-- Choose a Shift -->
	  <div class="form-group">
	  <label for="sel1">Choose a Shift: </label>
	  	<select class="form-control" id="sel1" >
	    	
  	   </select>

  	   <div class="checkbox">
  			<label><input type="checkbox">Rest Day Schedule</label>
		</div>

		<hr>
	  </div> 
      </div>
      <div class="panel-footer">
 			<div id="saving" class="alert alert-warning"><strong><i class="fa fa-spinner fa-pulse"></i> Saving changes..</strong></div>
 			<div id="success" class="alert alert-success" style="display: none"><strong><i class="fa fa-check"></i> Changes Saved!</strong></div>
      </div>
    </div>
   </div>

   <!-- CALENDAR -->
   <div class="col-md-6">
   <div class="box box-primary">
      <div id='calendar'></div>
   </div>
   </div>
   <!-- END CALENDAR -->

    <div class="col-md-3">
    <div class="box box-primary">
     <div class="box-header with-border">
          <h3 class="box-title">Group Members</h3>
           <span class="pull-right"><i class="fa fa-users"></i></span>
      </div>
		<div class="box-body">
		  <table class="table table-user-information">
		    <tbody>
		      <tr ng-repeat="m in members">
		        <td>{{m.employee_id}}</td>
		        <td class="text-info"><strong>{{m.last_name + ", " + m.first_name}}</strong></td>
		      </tr>
		    </tbody>
		  </table>
		</div>
	    </div>
   </div>


</div>
</div>
</div>
</div>	
