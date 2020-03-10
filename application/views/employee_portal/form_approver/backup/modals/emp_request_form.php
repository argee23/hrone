<!-- Modal -->
<div class="modal fade" id="emp_request_form" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{form_name}}</h4>
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
            </span>
            <span class="col-sm-6">
              <dt>Classification</dt>
              <dd>{{filer.classification_name}}</dd>
              <dt>Position</dt>
              <dd>{{filer.position_name}}</dd>
              <dt>Location</dt>
              <dd>{{filer.location_name}}</dd>
            </span>
          </div>
        </div>
        </div>

        <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a>{{form.doc_no}}</a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-7">
            <dt>Transaction Type</dt>
            <dd>{{form_name}}</dd>
             <dt>Request</dt><br>
             <?php 
               $list = $this->form_approver_model->get_request_list();
             ?>
              <dd><div ng-repeat="item in form.request_list.split('-')"><?php foreach($list as $l){?>
               <div class="col-sm-9" ng-if="'<?php echo $l->id; ?>' == item"><input type='checkbox' checked disabled>&nbsp;<?php echo $l->title?></div>
               <?php } ?></div>
                <div class="col-sm-9" ng-if="form.request_other"><input type='checkbox' checked disabled>&nbsp;Others [{{form.request_other}}]</div>
               </dd>
          </span>
          <span class="dl-horizontal col-sm-5">
            <dt>Date Filed</dt>
            <dd>{{form.date_created | date: "mediumDate"}}</dd>
            <dt>Purpose of Request </dt>
            <dd>{{form.reason}}</dd>
            <dt>Status</dt>
            <dd>{{form.status}}</dd>
          </span>
        </div>
        </div>

        <div class="panel panel-success">
        <form name="respond" action="respond" method="post">
        <div class="panel-heading">Response</div>
        <div class="panel-body">
        <div class="col-sm-6">
        <input type="hidden" name="filer_id" value="{{form.employee_id}}">
        <input type="hidden" name="doc_no" value="{{form.doc_no}}">
        <input type="hidden" name="table" value="{{table_name}}">
        <input type="hidden" name="identification" value="{{identification}}">
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