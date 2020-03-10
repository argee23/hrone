 <div class="panel panel-info">
            <div class="col-md-12"><br><br>
            <div class="col-md-12 panel panel-info" style="height:70px;" id="addedit_model">
            <br> 
                 <div class="col-md-2"><label>Car Model</label></div>
                 <div class="col-md-7"><input type="text" class="form-control" id="model_"><input type="hidden" id="model_name"></div>
                 <div class="col-md-3"><button class="btn btn-default" onclick="save_model('insert','insert')">SAVE</button>
                 <button class="btn btn-default" onclick="tripticket_home();"><i class="fa fa-arrow-circle-o-left"></i></button></div>
            </div>

                  <table class="table table-bordered" id="blocked_leave"  style="margin-top:20px;">
                      <thead>
                        <tr class="success">
                          <th> No.</th>
                          <th>Company Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php  if(empty($car_model)){ echo "<tr><td colspan='6'><h3 class='text-danger'>No data found.</h3></td></tr>";} else { foreach ($car_model as $m) {?>
                        <tr>
                          <td><?php echo $m->id?></td>
                          <td> <?php echo $m->car_model?> </td>
                          
                          <td>
                              <a class='fa fa-trash' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick="delete_trip_ticket_model('delete',<?php echo $m->id?>)"></a>
                               <a class='fa fa-pencil ' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='edit_trip_ticket_model(<?php echo $m->id?>)'></a>
                          </td>
                        </tr>
                      <?php } } ?>
                      </tbody>
                    </table>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div> 