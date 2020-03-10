<title>Full Resume</title>
<div class="box-header with-border">
<h3 class="box-title">My Resume</h3>
<div class="box-tools pull-right">
  <button ng-click="printToCart('print' , '<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css', '<?php echo base_url()?>public/AdminLTE.min.css' )" class="btn btn-success btn-sm"><i class="fa fa-print"></i> Print</button>
</div>
</div><br>

 <body class="signup-bg" ng-app="myApp" ng-controller="appCtrl"ng-cloak>
<div ng-init="getData()">
  <div class="splash col-sm-12 fixed-panel" ng-cloak="">
  <div class="spinner">
    <div class="double-bounce1"></div>
    <div class="double-bounce2"></div>
  </div>
    <center><h3 class="text-primary">Please wait while data loads..</h3></center>
  </div>
  <div ng-cloak>
     <div class="col-sm-12">
   <div id="print">
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                <img src="<?php echo base_url()?>public/applicant_files/employee_picture/<?php echo $this->session->userdata('picture'); ?>">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">{{personal_info.last_name + ", " + personal_info.first_name}} {{personal_info.middle_name | limitTo: 1}}.</h3>
              <h5 class="widget-user-desc"><?php echo $this->session->userdata('job_title'); ?></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li ng-if="address_info.present_address.length > 0 && address_info.present_city > 0 && address_info.present_province > 0"><a>{{address_info.present_address}}, <span>{{address_info.present_city_name}}</span> <span>{{address_info.present_province_name}}</span> <span class="pull-right badge bg-blue"><i class="fa fa-map-marker"></i></span></a></li>
                <li ng-if="contact_info.mobile_1.length > 0"><a>{{contact_info.mobile_1}} <span ng-show="contact_info.mobile_2 != null">| {{contact_info.mobile_2}}</span><span class="pull-right badge bg-aqua"><i class="fa fa-mobile"></i></span></a></li>
                <li ng-if="contact_info.email != null"><a>{{contact_info.email}} <span class="pull-right badge bg-green"><i class="fa fa-at"></i></span></a></li>
              </ul>
            </div>
          </div> <!-- Applicant Basic Details -->

          <div id="skills">
              <table class="table table-striped">
              <thead>
                <tr>
                  <th><center>Skills</center></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <dl ng-repeat="sk in skills">
                      <dt>{{sk.skill_name}}</dt>
                      <dd>{{sk.skill_description}}</dd>
                    </dl>
                  </td>
                </tr>
              </tbody>
            </table>
          </div><!--  skills -->

          <div id="educational-attainment">
            <table class="table table-striped">
              <thead>
                  <center><strong>Educational Background</strong></center>
              </thead>
              <tbody>
                <tr ng-repeat="ed in educations">
                  <td>
                  <strong>{{ed.education_name}}</strong>
                  </td>
                  <td>
                    {{ed.school_name}}<br>
                    {{ed.school_address}}<br>
                    {{ed.date_start | date: "mediumDate"}} - <i ng-if="ed.isGraduated == 0">Present</i><i ng-if="ed.isGraduated != 0">{{ed.date_end | date: "mediumDate"}}</i><br>
                    <p ng-if="ed.honors != null">Honors: {{ed.honors}}</p><br>
                  </td>
                </tr>
              </tbody>
            </table>
          </div><!-- Educational Attainment -->

          <div id="work-experiences">
              <table class="table table-striped">
              <thead>
                <tr>
                  <th><center>Work Experiences</center></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="ex in experiences">
                  <td>
                  <h4><strong>{{ex.position_name}}</strong><span class="pull pull-right"><i>{{ex.date_start | date: "mediumDate"}} - <i ng-if="ex.isPresentWork == 0"> {{ex.date_end | date: "mediumDate"}}</i><i ng-if="ex.isPresentWork == 1"> Present</i></i></span></h4>
                  {{ex.company_name}}<br>
                  {{ex.company_address}}<br>
                  <p ng-show="ex.company_contact != null">Company Contact Number: {{ex.company_contact}}</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div><!--  Work Experiences -->

          <div id="training-seminars">
              <table class="table table-striped">
              <thead>
                <tr>
                  <th><center>Trainings and Seminars Attended</center></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="training in trainings">
                  <td>
                  <h4><strong>{{training.training_title}}</strong></h4>
                  Held at {{training.training_address}}<br>
                  Conducted by {{training.conducted_by}}, {{training.training_institution}}<br>
                  {{training.date_start | date: "mediumDate"}} <span ng-if="training.isOneDay != 1"> - {{training.date_end | date: "mediumDate"}} </span><br>
                  </td>
                </tr>
              </tbody>
            </table>
          </div><!--  Trainings and seminars -->

          <div id="char-ref">
              <table class="table table-striped">
              <thead>
                <tr>
                  <th><center>Character References</center></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="ref in references">
                  <td>
                  <h4><strong>{{ref.reference_name}}</strong></h4>
                  <b>{{ref.reference_position}}</b>, {{ref.reference_company}}<br>
                  {{ref.reference_address}}<br>
                  <span ng-show="ref.reference_email != null || ref.reference_email != ''"><i class="fa fa-envelope"> </i> {{ref.reference_email}}</span><br>
                  <span ng-show="ref.reference_contact != ''"><i class="fa fa-phone"> </i> {{ref.reference_contact}}</span> 
                  </td>
                </tr>
              </tbody>
            </table>
          </div><!--  Character References -->


          <div id="char-ref">
              <table class="table table-striped">
              <thead>
                <tr>
                  <th><center>Applicant Priority Choice</center></th>
                </tr>
              </thead>
              <tbody>
              <?php $checker =  $this->application_form_model->check_priority_choice();?>
                <tr>
                    <td><?php if($checker->abroad==1 AND $checker->local==1){ echo "Local and Abroad"; }
                        else if($checker->abroad==1){ echo "Abroad only"; } elseif($checker->local){ echo "Local only"; } else{} ?></td>
                </tr>
                
              </tbody>
            </table>
          </div><!--  Character References -->


</div> <!-- printable div -->
     </div>
  </div>
</div>