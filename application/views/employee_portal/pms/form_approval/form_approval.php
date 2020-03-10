 <link href="<?php echo base_url()?>public/radio.css" rel="stylesheet">
<br><br>

<div ng-app="app" ng-controller="appCtrl">
<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-sm-12">
<h2 class="page-header ng-scope">PMS Scorecard Approval</h2>
<div class="container">
    <!-- Success Feedback -->
        <?php if ($this->session->flashdata('feedback')) { ?>
             <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success!</strong> <?php echo $this->session->flashdata('feedback'); ?>
            </div>
        <?php } ?>

        <!-- Failed Feedback -->
        <?php if ($this->session->flashdata('error')) { ?>
         <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Error:</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php } ?>


  <div class="panel panel-body table-responsive">
  
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <strong style="color:#3c8dbc">{{form.doc_no}}</strong>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </h3>
        </div>
        <div class="modal-body">
          <div class="well well-sm bg-olive">
                              <!-- Left-aligned -->
          <div class="media">
            <div class="media-left media-middle">
              <span ng-if="filer.isApplicant=='1'">
                <img src="<?php echo base_url()?>public/applicant_files/employee_picture/{{filer.picture}}" class="media-object" style="width:150px">
              </span>
              <span ng-if="filer.isApplicant=='0'||filer.isApplicant==null||filer.isApplicant==''">
                <img src="<?php echo base_url()?>public/employee_files/employee_picture/{{filer.picture}}" class="media-object" style="width:120px">
              </span>
            </div>
            <div class="media-body">
              <h4 class="media-heading text-black"><strong>{{filer.last_name + ", " + filer.first_name + " "  + filer.middle_name}}</strong></h4>

              <span class="col-sm-6">
                <dt ng-if="filer.division_name != null||filer.division_name == ''">Division</dt>
                <dd ng-if="filer.division_name != null||filer.division_name == ''">{{filer.division_name}}</dd>
                <dt>Department</dt>
                <dd>{{filer.dept_name}}</dd>
                <dt>Section</dt>
                <dd>{{filer.section_name}}</dd>
                <dt ng-if="filer.subsection_name != null||filer.subsection_name == ''">Subsection</dt>
                <dd ng-if="filer.subsection_name!= null||filer.subsection_name == ''">{{filer.subsection_name}}</dd>
                <dt>Classification</dt>
                <dd>{{filer.classification_name}}</dd>
              </span>
              <span class="col-sm-6">
                
                <dt>Position</dt>
                <dd>{{filer.position_name}}</dd>
                <dt>Location</dt>
                <dd>{{filer.location_name}}</dd>
                <dt>Date Filed</dt>
                <dd>{{form.date_created | date: "medium"}}</dd>
                <dt>Appraisal Period</dt>
                <dd>{{form.date_from | date: "mediumDate"}} - {{form.date_to | date: "mediumDate"}}</dd>
                <dt>Status</dt>
                <dd>{{form.status}}</dd>
              </span>
            </div>
          </div>
          </div>

          <div class="panel panel-default">
          <div class="panel-heading">
          <strong><a>Final Rating for {{filer.last_name + ", " + filer.first_name + " "  + filer.middle_name}}</a></strong>
          </div>
          <div class="panel-body">
            <!-- <span class="dl-horizontal col-sm-9"> -->
              <table class="table table-alternate">
                <thead>
                  <tr>
                    <th scope="col" colspan="2"><center>Final Rating Table</center></th>
                    <th><center>Total Weight</center></th>
                    <th><center>Part Ratings</center></th>
                    <th><center>Ratings</center></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="x in form_det">
                    <td><center>{{x.part_number}}</center></td>
                    <td><center>{{x.part_name}}</center></td>
                    <td><center>{{x.form_weight}}</center></td>
                    <td><center>{{x.total_rating}}</center></td>
                    <td><center>{{x.part_rating}}</center></td>
                    <!-- <td><center>{{((x.form_weight.replace('%', '') * .01) * x.total_rating).toFixed(2)}}</center></td> -->
                  </tr>
                  <tr>
                    <td scope="col" colspan="2"><center><strong>Final Rating</strong></cnter></td>
                    <td><center><strong>{{weight.total_weight}}%</strong></center></td>
                    <td></td>
                    <td><center><strong>{{weight.total_ratings}}</strong></center></td>
                  </tr>
                </tbody>
              </table>
            <!-- </span> -->
          </div>
          </div>

          <div class="panel panel-default">
          <div class="panel-heading">
          <strong><a>Recommendations by Immediate Superior or Rater</a></strong>
          </div>
          <div class="panel-body">
            <table class="table table-alternate col-md-6">
                <thead>
                  <tr>
                    <th>Recommendations</th>
                    <th>Effectivity Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="a in recommendation">
                    <td>{{a.recommendations}}</td>
                    <td ng-if ="a.date_to != null">{{a.date_from | date: "mediumDate"}} - {{a.date_to | date: "mediumDate"}}</td>
                    <td ng-if ="a.date_to == null">{{a.date_from | date: "mediumDate"}}</td>
                  </tr>
                </tbody>
              </table>
          </div>
          </div>

          <form name="respond" action="<?php echo base_url();?>employee_portal/pms/respond" method="post">
          <div class="panel panel-success">
          <div class="panel-body">
          <div class="col-sm-6">
          <input type="hidden" name="filer_id" value="{{form.employee_id}}">
          <input type="hidden" name="doc_no" value="{{form.doc_no}}">
          <input type="hidden" name="table" value="pms_form_request_approval">
          <input type="hidden" name="identification" value="{{id}}">
          <div class="radio">
              <label style="font-size: 1.5em">
                  <input type="radio" name="status" value="approved" ng-model="stat">
                  <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                  Approve
              </label>
          </div>
          <div class="radio">
              <label style="font-size: 1.5em">
                  <input type="radio" name="status" value="cancelled" ng-model="stat">
                  <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                  Cancel
              </label>
          </div>        
          <div class="radio">
              <label style="font-size: 1.5em">
                  <input type="radio" name="status" value="rejected" ng-model="stat">
                  <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                  Reject
              </label>
          </div>
          </div>
          <div class="col-sm-6">
           <div class="form-group">
              <label for="comment">Comment:</label>
              <textarea class="form-control" rows="2" name="comment" id="comment"></textarea>
            </div> 
            <button type="submit" class="btn btn-success btn-block" ng-disabled="!stat">Submit Response</button>

          </div>
          </div>
          </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <div class="box box-primary">
        
        <div class="box-header with-border">
          <?php if($get_forms){?>
        <h3 class="box-title"> PMS FORMS</h3>
              <!-- <div class="pull-right box-tools">
                <a href="<?php echo base_url();?>employee_portal/pms/mass_approval/<?=$approval->id?>/<?=$type?>" class="btn btn-primary btn-xs"  data-toggle="tooltip" title="Mass Approval">
                  Mass Approval</a>
              </div> -->
        </div>
        <div class="box-body">
          <table class="table table-responsive">
            
            <thead>
              <tr>
                <th>Document No.</th>
                <th>Filed By</th>
                <th>File Date</th>
                <th>Appraisal Period</th>
                <th>Details</th>
              </tr>
            </thead>
            <tbody>
              
               <?php foreach ($get_forms as $form){ ?>
                <tr class="my_hover">
                  <td><a ng-click="get_form('<?php echo $form->doc_no; ?>', '<?php echo $form->form_part_id;?>'); identification='<?php echo $form->form_part_id; ?>'" href="#myModal" data-toggle="modal"><strong><?php echo $form->doc_no; ?></strong></a></td>
                  <td><?php echo strtoupper($form->last_name) . ", " . $form->first_name . " " . $form->middle_name; ?></td>
                  <td><?php echo date("F d, Y", strtotime($form->date_created)); ?></td>
                  <td><?php echo date("F d, Y", strtotime($form->date_from)); ?> to <?php echo date("F d, Y", strtotime($form->date_to)); ?></td>
                  <td><a href="<?php echo base_url();?>employee_portal/pms/view/<?php echo $form->doc_no; ?>/" target="_blank"><span class="badge bg-green">View Details</span></a></td>
                </tr>
                <?php  } ?>
                 
          </tbody>
          </table>
          </div>
            <?php } else {?>
           <center><h3><strong>NO PENDING FORMS</strong></h3></center>
                <?php } ?>
          </div>
  </div>
</div>
</div>
</div>


</div>




<!-- Angular Js Script -->
<script>
var app = angular.module('app', []);

app.controller('appCtrl', ['$scope', '$http', function($scope, $http) {

  $scope.identification = '';

  $scope.get_form = function(doc_no, type, form_part_id)
  {
      $http.post('<?php echo base_url();?>employee_portal/pms/get_form_details/'+doc_no+'/'+type+'/'+form_part_id).success(function(data){
        $scope.form = data.form;
        $scope.filer = data.filer;
        $scope.form_det = data.form_det;
        $scope.weight = data.weight;
        $scope.recommendation = data.recommendation;
        $scope.days = data.days
        });
  }

}]);

</script>
