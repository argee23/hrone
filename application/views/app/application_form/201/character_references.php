<title>Character References</title>

<div class="box-header with-border">
  <h3 class="box-title">Character References</h3>
    <div class="box-tools pull-right">
      <button type="button"  data-toggle="modal" data-target="#add-reference" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>  Add Character Reference</button>
    </div>
</div><br>

<div ng-init="getReferences()">
  <div class="splash col-lg-12" ng-cloak="">
    <div class="spinner">
      <div class="double-bounce1"></div>
      <div class="double-bounce2"></div>
    </div>
    <center><h3 class="text-primary">Please wait while data loads..</h3></center>
  </div>  
<div ng-cloak>
<div class="splash col-lg-12 fixed-panel" ng-cloak="">
    <div class="spinner">
      <div class="double-bounce1"></div>
      <div class="double-bounce2"></div>
    </div>
    <center><h3 class="text-primary">Please wait while data loads..</h3></center>
</div>
      <div ng-show="references.length == 0">
        <center><small><h2>No data yet.<br>Click 'Add Character Reference' button to add data.</h2></small></center>
      </div>

      <div class="col-lg-12 fixed-panel mCustomScrollbar">
        <div class="panel panel-default" ng-repeat="ref in references">
          <div class="panel-body">

          <div class="col-lg-9">
              <h3 class="text-primary"><span ng-repeat="s in dataList.titles" ng-if="s.param_id == ref.reference_title">{{s.cValue}}</span> {{ref.reference_name}}</h3>

              <table class="table table-hover table-condensed">
                  <tbody>
                    <tr>
                      <td><i class="fa fa-black-tie"> </i></td>
                      <td><b>{{ref.reference_position}}</b>, {{ref.reference_company}}</td>
                    </tr>
                    <tr ng-show="ref.reference_address != undefined || ref.reference_address != ''">
                      <td><i class="fa fa-map-marker"> </i></td>
                      <td>{{ref.reference_address}}</td>
                    </tr>
                    <tr ng-show="ref.reference_email != undefined || ref.reference_email != ''">
                      <td><i class="fa fa-envelope"> </i></td>
                      <td>{{ref.reference_email}}</td>
                    </tr>
                    <tr ng-show="ref.reference_contact != ''">
                      <td><i class="fa fa-phone"> </i></td>
                      <td>{{ref.reference_contact}}</td>
                    </tr>
                  </tbody>
              </table>
          </div>
          <div class="col-lg-3">
            <div class="pull pull-right">
              <button type="button" ng-click="editReference(ref)" data-toggle="modal" data-target="#edit-reference" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</button>
              <button type="button" data-toggle="modal" ng-click="editReference(ref)" data-target="#delete-reference" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
            </div>
          </div>
          </div>
        </div>
      </div>


</div> <!-- ng cloak -->
</div>

<!-- Add Reference Modal -->
<div id="add-reference" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><center>Add Character Reference</center></h4>
  </div>
  <div class="modal-body">
        <form name="addreference" method="post" action="add_reference">

            <div class="form-group has-feedback">
                <label>Title: </label>
                <select class="form-control" id="reference_title" name="reference_title">
                    <option ng-repeat="name in dataList.titles" value="{{name.param_id}}">{{name.cValue}}</option>
                </select>
           </div>

            <div class="form-group has-feedback" ng-class="{'has-error' : addreference.reference_name.$invalid}">
                <label>Name: <small ng-show="addreference.reference_name.$invalid"><i>Character reference is required.</i></small> </label>
                <input type="text" class="form-control" id="reference_name" name="reference_name" ng-model="reference_name" required>
            </div>

            <div class="form-group has-feedback">
                <label>Position:</label>
                <input type="text" class="form-control" id="reference_position" name="reference_position">
            </div>

            <div class="form-group has-feedback">
                <label>Company/Institution:</label>
                <input type="text" class="form-control" id="reference_company" name="reference_company">
            </div>

            <div class="form-group has-feedback">
                <label>Address:</label>
                <input type="text" class="form-control" id="reference_address" name="reference_address">
            </div>

            <div class="form-group has-feedback">
                <label>Contact Number:</label>
                <input type="text" class="form-control" id="reference_contact" name="reference_contact" data-inputmask="'mask': '+63999-999-9999'" placeholder="+639xx-xxx-xxxx">
            </div>

            <div class="form-group has-feedback" ng-class="{'has-error' : addreference.reference_email.$invalid}">
                <label>Email Address: <small ng-show="addreference.reference_email.$invalid"><i>Not a valid email address.</i>
                </small> </label>
                <input type="email" class="form-control" id="reference_email" name="reference_email" ng-model="reference_email">
            </div>
            <center><button type="submit" class="btn btn-success btn-block" ng-disabled="addreference.$invalid">Add Character Reference</button></center>
        </form>

  </div>
  <div class="modal-footer">
    <button  type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>

</div>
</div>
<!-- Add Reference Modal -->

<!-- Edit Reference Modal -->
<div id="edit-reference" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><center>Edit Reference</center></h4>
  </div>
  <div class="modal-body">
        <form name="editreference" method="post" action="edit_reference">
        <input type="hidden" value="{{selected_reference.character_reference_id}}" name="id" id="id">
            <div class="form-group has-feedback">
                <label>Title: </label>
                <select class="form-control" id="reference_title" name="reference_title" ng-model="selected_reference.reference_title" ng-selected="selected_reference.reference_title">
                    <option ng-repeat="name in dataList.titles" value="{{name.param_id}}" >{{name.cValue}}</option>
                </select>
           </div>

            <div class="form-group has-feedback" ng-class="{'has-error' : editreference.reference_name.$invalid}">
                <label>Name: <small ng-show="editreference.reference_name.$invalid"><i>Character reference name is required.</i></small> </label>
                <input type="text" class="form-control" id="reference_name" name="reference_name" ng-model="selected_reference.reference_name" required>
            </div>

            <div class="form-group has-feedback">
                <label>Position:</label>
                <input type="text" class="form-control" id="reference_position" name="reference_position" ng-model="selected_reference.reference_position" >
            </div>

            <div class="form-group has-feedback">
                <label>Company/Institution:</label>
                <input type="text" class="form-control" id="reference_company" name="reference_company" ng-model="selected_reference.reference_company" >
            </div>

            <div class="form-group has-feedback">
                <label>Address:</label>
                <input type="text" class="form-control" id="reference_address" name="reference_address" ng-model="selected_reference.reference_address" >
            </div>

            <div class="form-group has-feedback">
                <label>Contact:</label>
                <input type="text" class="form-control" id="reference_contact" name="reference_contact" ng-model="selected_reference.reference_contact" data-inputmask="'mask': '+63999-999-9999'" placeholder="+639xx-xxx-xxxx">
            </div>

            <div class="form-group has-feedback" ng-class="{'has-error' : editreference.reference_email.$invalid}">
                <label>Email Address: <small ng-show="editreference.reference_email.$invalid"><i>Not a valid email address.</i>
                </small> </label>
                <input type="email" class="form-control" id="reference_email" name="reference_email" ng-model="selected_reference.reference_email">
            </div>
            <center><button type="submit" class="btn btn-success btn-block" ng-disabled="editreference.$invalid"><i class="fa fa-save"></i> Save Changes</button></center>
        </form>

  </div>
  <div class="modal-footer">
    <button  type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>

</div>
</div>
<!-- Edit Reference Modal -->

<!-- Delete Modal -->
<div id="delete-reference" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Character Reference</h4>
      </div>
      <div class="modal-body"><center>
        <p>Are you sure you want to delete the selected Character Reference?</p>
        <h4>{{selected_reference.reference_name | uppercase }}</h4>
        <form name="delete_reference" method="post" action="delete_reference">
        <input type="hidden" value="{{selected_reference.character_reference_id}}" name="ref_id" id="ref_id">
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

<?php require_once(APPPATH.'views/app/application_form/footer.php');?>