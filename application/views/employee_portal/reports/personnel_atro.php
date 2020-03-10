<link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
<br><br>

<div class="content-body" id="app" style="background-color: #D7EFF7;" ng-app="myApp" ng-controller="appCtrl" ng-cloak>
<div class="col-lg-12">
<h2 class="page-header ng-scope">Personnel ATRO Summary</h2>


<!-- START -->
  <div class="col-md-4">

  	<div class="panel panel-success">
  		<div class="panel-heading">
  			Generate Report
  		</div>

  		<div class="panel-body">
  			 <form  class="form-horizontal" nosubmit>
  			   <div class="form-group">
			    <label class="control-label col-sm-4" for="email">From</label>
			    <div class="col-sm-8">
			      <input type="text" class="form-control" id="date_from" name="date_from">
			    </div>
			  </div>

			   <div class="form-group">
			    <label class="control-label col-sm-4" for="email">To</label>
			    <div class="col-sm-8">
			      <input type="text" class="form-control" id="date_to" name="date_to">
			    </div>
			  </div>

			 <div class="form-group">
		      <label class="control-label col-sm-4" for="email" required> Classication</label>
		      <div class="col-sm-8">
		      <select class="form-control" id="classification" name="div_id" ng-model="classification">
		      <option value='all'>All</option>
		        <?php foreach ($classifications as $div) { ?>
 					<option value='<?php echo $div->classification_id; ?>'><?php echo $div->classification; ?></option>
		         <?php } ?>
		      </select>
		      </div>
		    </div>




		  <?php if ($has_division) 
		  { ?>
		    <div class="form-group">
		      <label class="control-label col-sm-4" for="email" required> Division</label>
		      <div class="col-sm-8">
		      <select class="form-control" name="div_id" id="div_id" ng-model="div_id" ng-change="getDepartments()">
		        <?php foreach ($divisions as $div) { ?>
 					<option value='<?php echo $div->division; ?>'><?php echo $div->division_name; ?></option>
		         <?php } ?>
		      </select>
		      </div>
		    </div>
		  <?php } else { ?>

        <span ng-init="getDepartments()"></span>
      <?php  } ?>





	    <div class="form-group">
	      <label class="control-label col-sm-4" for="email" required> Department</label>
	      <div class="col-sm-8">
	      <select class="form-control" name="dept_id" id="dept_id" ng-model="dept_id" ng-change="getSections()" ng-disabled="div_id == '' && has_division">
	        <option ng-repeat="dept in deptList" value="{{dept.department}}">{{dept.dept_name}}</option>
	      </select>
	      </div>
	    </div>
	    <div class="form-group">
	      <label class="control-label col-sm-4" for="email" required> Section</label>
	      <div class="col-sm-8">
	      <select class="form-control" name="filter_type" id="sec_id" ng-model="sec_id" ng-change="getSubsections()" ng-disabled="dept_id == ''">
	      <option ng-repeat="sec in secList" value="{{sec.section}}">{{sec.section_name}}</option>
	      </select>
	      </div>
	    </div>
	    <div class="form-group">
	      <label class="control-label col-sm-4" for="email" required> Subsection</label>
	      <div class="col-sm-8">
	      <select class="form-control" id="sub_id" ng-model="sub_id" ng-change="getLocations()" ng-disabled="sec_id == ''">
	        <option ng-show="subList.length == 0" ng-disabled="true">No subsections</option>
	        <option ng-repeat="sub in subList" value="{{sub.subsection}}">{{sub.subsection_name}}</option>
	      </select>
	      </div>
	    </div>

	    <div class="form-group">
	      <label class="control-label col-sm-4" for="email" required> Location</label>
	      <div class="col-sm-8">
	      <select class="form-control" id="loc_id" ng-model="loc_id">
	        <option ng-repeat="loc in locList" value="{{loc.location}}" >{{loc.location_name}}</option>
	      </select>
	      </div>
	    </div>


			   <div class="form-group">
			    <label class="control-label col-sm-4" for="email"></label>
			    <div class="col-sm-8">
			     	<button class="btn btn-success btn-block btn-flat" ng-click="generate_atro()" >Generate Report</button>
			    </div>
			  </div>

  			 </form>
  		</div>
  	</div>
  </div>

  <div class="col-md-8">
  <div class="panel panel-success">
  	<div class="panel-heading">
  	Report
  	<span class="box-tools pull-right">
  	<!-- 	<a type="button" class="btn btn-xs btn-success" ng-disabled="!reports.length > 0" ng-click="download()"><i class="fa fa-file-excel-o" ></i> Export to Excel</a> -->
  	</span>
  	</div>
  	<div class="panel-body">
		<table id="example" class="table table-hover" cellspacing="0" width="100%">
		        <thead>
		            <tr>
		                <th>Employee ID</th>
		                <th>Employee Name</th>
		                <th>Document No</th>
		                <th>No of Hours</th>
		                <th>ATRO Date</th>
		                <th>Status</th>
		            </tr>
		        </thead>
		        <tbody>
		        		<tr><td></td></tr>

		        </tbody>
		    </table>
  	</div>
  </div>

  </div>
<!--  END -->
</div>
</div>

<script>
function view_data(classification, div_id, dept_id, sec_id, sub_id, loc_id, from_date, to_date)
{

	$('#example').DataTable( {
		 "pageLength": 15,
		"pagingType" : "simple",
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
 		"processing": true,
        "serverSide": true,
		"info": false,
        "ajax": {
        	"url": "<?php echo base_url();?>employee_portal/reports/get_atro_summary/" + classification + '/' + div_id + '/' + dept_id + '/' + sec_id + '/' + sub_id + '/' + loc_id + '/' + from_date + '/' + to_date,
        	"type": "POST",
        	"dataType": "json",
        	"dataSrc": ""
    		},
    	"columns": [ 
	        { "data": "employee_id" },
	        { "data": "name" },
	        { "data": "doc_no" },
	        { "data": "no_of_hours" },
	        { "data": "atro_date" },
	        { "data": "status" }
	        ],

        "bDestroy": true,
     "dom": 'Bfrtip',
        // "buttons": [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ]

          buttons: [
            { extend: 'copy', className: 'copyButton' },
            { extend: 'excel', title: 'PersonnelATROSummary', className: 'excelButton' }
        ]
    } );
}

</script>
<!-- DataTables -->
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Buttons -->
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <!-- Export To Excel JSZip -->
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>    

<script>
var app = angular.module('myApp', []);
app.controller('appCtrl', ['$scope', '$http', '$location', '$window', function($scope, $http, $location, $window) {

  $scope.from_date = '';
  $scope.to_date = '';
  $scope.div_id = '';
  $scope.dept_id = '';
  $scope.sec_id = '';
  $scope.sub_id = '';
  $scope.loc_id = '';
  $scope.zero = '0';
  $scope.locList = {};


  $scope.generate_atro = function()
  {

		view_data($scope.classification, $scope.div_id, $scope.dept_id, $scope.sec_id, $scope.sub_id, $scope.loc_id, $scope.from_date, $scope.to_date);

  }

  $scope.set_from = function(date)
  {
    $scope.from_date = date;
  }

  $scope.set_to = function(date)
  {
  	$scope.to_date = date;
  }

  $scope.copyData = function()
  {
    $scope.memberList.map(function(element)
    {
      return element.value = $scope.allowed;
    });
  }

  $scope.getDivisions = function()
  {
    $scope.div_id = '';
    $scope.dept_id = '';
    $scope.sec_id = '';
      $http.post('<?php echo base_url();?>employee_portal/overtime_management/get_divisions').success(function(data)
      {
        $scope.divList = data;
      });
  }

  $scope.getDepartments = function()
  {
      $scope.dept_id = '';
      $scope.sec_id = '';
      $http.post('<?php echo base_url();?>employee_portal/overtime_management/get_departments/' + $scope.div_id).success(function(data)
      {
        $scope.deptList = data;
      });
  }

  $scope.getSections = function()
  {
    $scope.sec_id = '';
      $http.post('<?php echo base_url();?>employee_portal/overtime_management/get_sections/' + $scope.dept_id).success(function(data)
      {
        $scope.secList = data;
      });
  }

  $scope.getSubsections = function()
  {
     $scope.sub_id = '';
      $http.post('<?php echo base_url();?>employee_portal/overtime_management/get_subsections/' + $scope.sec_id).success(function(data)
      {
        $scope.subList = data;
      });

      console.log($scope.subList);
if(typeof $scope.subList == "undefined") {
    // obj is a valid variable, do someaaaaaaaaaaaaathing here.
$scope.getLocations();

    $scope.d_id = 0;
    $scope.s_id = 0;


    if ($scope.div_id == '' || !$scope.div_id)
    {
      $scope.d_id = 0;
    }

    if ($scope.sub_id == '' || !$scope.sub_id)
    {
      $scope.s_id = 0;
    }

}
  }

  $scope.getLocations = function()
  {      

//     console.log('called!');
//      console.log('div_id' + $scope.div_id);
//      console.log('dept_id' + $scope.dept_id);
//      console.log('sec_id' + $scope.sec_id);
//      console.log('sub_id' + $scope.sub_id);

// //      $scope.f = "";
// // if(typeof $scope.subList !== "undefined") {
// //     // obj is a valid variable, do someaaaaaaaaaaaaathing here.
// // $scope.f = $scope.sub_id;
// // }



      $http.post('<?php echo base_url();?>employee_portal/overtime_management/get_locations/' + $scope.div_id + '/' + $scope.dept_id + '/' + $scope.sec_id + '/' + $scope.sub_id + '/').success(function(data)
      {
        $scope.locList = data;
      });
  }

}]);

</script>



<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>

<script type="text/javascript">
    $(document).ready(function()
    {
      $('#date_from').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false }).on('change', function(e, date)
      {
         angular.element('#app').scope().set_from(date.format('YYYY-MM-DD')); 
         $('#date_to').bootstrapMaterialDatePicker('setMinDate', date);
      });
      
      $('#date_to').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false }).on('change', function(e, date)
      {
         angular.element('#app').scope().set_to(date.format('YYYY-MM-DD')); 

      });
    });
</script>
