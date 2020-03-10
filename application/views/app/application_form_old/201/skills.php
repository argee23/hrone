<title>Skills</title>

<div class="box-header with-border">
    <h3 class="box-title">Skills</h3>
    <div class="box-tools pull-right">
  <button type="button" data-toggle="modal" data-target="#add-skills" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> Add Skills </button>
    </div>
</div><br>
<div ng-init="getSkills()">
   <div class="splash col-lg-12" ng-cloak="">
    <div class="spinner">
      <div class="double-bounce1"></div>
      <div class="double-bounce2"></div>
    </div>
    <center><h3 class="text-primary">Please wait while data loads..</h3></center>
  </div>
<div ng-cloak>
 <table class="table table-responsive table-bordered table-striped table-hover">
   <thead>
      <tr>
        <th>Skill Name</th>
        <th>Skill Description</th>
        <th>Action</th>
      </tr>
      <tbody>
      <tr ng-repeat="skill in skills">
        <td><strong>{{skill.skill_name}}</strong></td>
        <td>{{skill.skill_description}}</td>
        <td>
        <center>
        <button type="button" ng-click="copySkill(skill)" data-toggle="modal" data-target="#edit-skill" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit </button>
        <button type="button" data-toggle="modal" data-target="#delete-skill" ng-click="copySkill(skill)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
        </center></td>
      </tr>
    </tbody>
    </thead>
 </table>
 </div>
</div>


<!-- Modal -->
<div id="add-skills" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Skills</h4>
      </div>
      <div class="modal-body">
    <form name="addskill" method="post" action="add_skill">
        <div class="form-group has-feedback" ng-class="{'has-error' : addskill.skill_name.$invalid}">
          <label for="title">Skill Name: <small ng-show="addskill.skill_name.$invalid"><i>Skill name is required</i></small></label>
          <input type="text" name="skill_name" id="skill_name" class="form-control" ng-model="skill_name" required>
        </div>
        <div class="form-group">
          <label for="title">Skill Description: </label>
          <input type="text" name="skill_description" id="skill_description" class="form-control" ng-model="skill_description">
        </div>
         <center><button type="submit"  ng-disabled="addskill.$invalid" class="btn btn-success btn-block"><i class="fa fa-plus"></i> Add Skill</button></center>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Delete Modal -->
<div id="delete-skill" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Skill</h4>
      </div>
      <div class="modal-body"><center>
        <p>Are you sure you want to delete the selected skill?</p>
        <h4>{{selected_skill.skill_name | uppercase }} - {{selected_skill.skill_description}}</h4>
        <form name="delete_skill" method="post" action="delete_skill">
        <input type="hidden" value="{{selected_skill.skill_id}}" name="skill_id" id="skill_id">
        <button type="submit" class=" btn btn-warning">Yes</button>
        <button type="button" data-dismiss="modal" class="btn btn-info">No</button>
        </form>
        </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div> <!-- Delete Modal -->

<!-- Modal -->
<div id="edit-skill" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Skills</h4>
      </div>
      <div class="modal-body">
    <form name="editskill" method="post" action="edit_skill">
        <div class="form-group has-feedback" ng-class="{'has-error' : editskill.skill_name.$invalid}">
          <input type="hidden" value="{{selected_skill.skill_id}}" name="skill_id" id="skill_id">
          <label for="title">Skill Name: <small ng-show="editskill.skill_name.$invalid"><i>Skill name is required</i></small></label>
          <input type="text" name="skill_name" id="skill_name" class="form-control" ng-model="selected_skill.skill_name" required>
        </div>
        <div class="form-group">
          <label for="title">Skill Description: </label>
          <input type="text" name="skill_description" id="skill_description" class="form-control" ng-model="selected_skill.skill_description">
        </div>
         <center><button type="submit"  ng-disabled="editskill.$invalid" class="btn btn-success btn-block"><i class="fa fa-save"></i> Save Changes</button></center>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


