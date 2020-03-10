
               <label>Company: </label>
               <br> <input type="text"  class="form-control" value="<?php echo $car_details->company_name?>" disabled>
               <br>

               <label>Location: </label>
               <br> <input type="text"  class="form-control" value="<?php echo $car_details->location_name?>" disabled>
               <br>


                <label>Car Model</label>
                    <select class="form-control" id="model" name="model">
                    <?php if(empty($car_model)){ echo "<option value=''>No model found. PLease add to continue.</option>";}
                      else{?>
                      <?php 
                        foreach ($car_model as $model) {?>
                        <option value="<?php echo $model->id?>" <?php if($model->id==$car_details->car_model){ echo "selected"; }?>><?php echo $model->car_model?></option>
                        <?php } } ?>
                    </select>
                <br> 

                <label>Car Plate Number</label>
                <input type="text" name="platenumber" id="platenumber" class="form-control" value="<?php echo $car_details->car_platenumber?>">
                <input type="hidden" id="car_p">
                <br> 

                <button class="col-md-12 btn btn-success" onclick="save_updated_tripticket(<?php echo $id?>);">Save</button>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div> 
   