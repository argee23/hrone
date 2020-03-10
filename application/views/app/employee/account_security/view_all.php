<!-- <div class="well"> -->
  <div class="box box-success">
    <div class="box-header">
      <!-- <h1>Coachella</h1> -->
    </div>
    <div class="box-body">
    <div class="row">
    <div class="col-md-3">
        <label>Filter by Company:</label>
        <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="viewPerCompany(this.value)">
        <option selected="selected" disabled="disabled" value="0">- Select Company -</option>
        <?php 
          foreach($companyList as $company){
          if($_POST['company'] == $company->company_id){
              $selected = "selected='selected'";
          }else{
              $selected = "";
          }
          ?>
          <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
          <?php }?>
        </select>
    </div>
    </div>
    <!-- <div class="row"> -->
    <div class="col-md-12" id="fill" style="padding: 0 0 1% 0">
    
    </div>
    </div>
    </div>
  </div>
<!-- </div> -->

<!-- return confirm('Are you sure to delete <?php echo addslashes($user->first_name)."\'s"." ".addslashes($user->event_title) ?> event?') -->
<div id="edit" class="modal-success modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Password</h4>
      </div>
      <div class="modal-body">
        <span id="content"> 
            
        </span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- return confirm('Are you sure to delete <?php echo addslashes($user->first_name)."\'s"." ".addslashes($user->event_title) ?> event?') -->
<div id="edit" class="modal-success modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Password</h4>
      </div>
      <div class="modal-body">
        <span id="content"> 
            
        </span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>