 <br> 
    <div class="col-md-2"><label>Car Model</label></div>
    <div class="col-md-6"><input type="text" class="form-control" id="model_" 
    value="<?php echo $model_details->car_model?>"><input type="hidden" id="model_name"></div>
    <div class="col-md-4"><button class="btn btn-default" onclick="save_model('insert','<?php echo $model_details->id?>')">SAVE CHANGES</button>
    <button class="btn btn-default" onclick="tripticket_home();"><i class="fa fa-arrow-circle-o-left"></i></button>
    </div>