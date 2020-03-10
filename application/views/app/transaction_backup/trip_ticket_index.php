
<div id="coll_2">
<div class="col-md-12" style="padding-top: 20px;">
  <div class="col-md-4" style="padding-bottom: 50px;"  id="">
      <div class="panel panel-info">
      <h4 class="text-danger" style="font-weight: bold;"><i class="bt btn fa fa-copy pull-right" onclick="manage_car_model();">Manage car Model</i></h4><br><hr>
            <div class="col-md-12" id="add_edit">
               <label>Company: </label>
               <select class="form-control" id="company" onchange="getLocation(this.value);">
               <?php foreach($companyList as $company) { ?>
                 <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
                 <?php } ?>
               </select>
               <br>

               <div id="location">
               </div>

                <label>Car Model</label>
                <select class="form-control" id="model" name="model">
                <?php if(empty($car_model)){ echo "<option value=''>No model found. PLease add to continue.</option>";}
                  else{?>
                    <option>Select Model</option>
                  <?php 
                    foreach ($car_model as $model) {
                     echo  "<option value='".$model->id."'>".$model->car_model."</option>";
                    }
                  } ?>
                </select>
                <br> 

                <label>Car Plate Number</label>
                <input type="text" name="platenumber" id="platenumber" class="form-control">
                <input type="hidden" id="car_p">
                <br> 

                <button class="col-md-12 btn btn-success" onclick="save_trip_ticket();">Save</button>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div> 
    </div>


  <div class="col-md-8" style="padding-bottom: 50px;"  id="fetch_all_result">
      <div class="panel panel-info">
            <div class="col-md-12"><br><br>
                  <table class="table table-bordered" id="blocked_leave"  style="margin-top:20px;">
                      <thead>
                        <tr class="success">
                          <th> No.</th>
                          <th>Company Name</th>
                          <th>Location </th>
                          <th>Car Model</th>
                          <th>Palate Number</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($tripticket as $l) { if(empty($tripticket)){ echo "<tr><td colspan='6'><h3 class='text-danger'>No data found.</h3></td></tr>";} ?>
                        <tr>
                          <td><?php echo $l->id?></td>
                          <td> <?php echo $l->company_name?> </td>
                          <td> <?php echo $l->location_name?> </td>
                          <td> <?php echo $l->model?> </td>
                          <td> <?php echo $l->car_platenumber?> </td>
                          <td>
                              <a class='fa fa-trash' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='delete_trip_ticket(<?php echo $l->id?>)'></a>
                               <a class='fa fa-pencil ' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='edit_trip_ticket(<?php echo $l->id?>)'></a>
                          </td>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div> 
    </div>

</div>
</div>