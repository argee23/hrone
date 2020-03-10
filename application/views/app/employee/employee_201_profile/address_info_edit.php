<div class="row">
<div class="col-md-8">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>ADDRESS</strong> (edit)</div>

    <form method="post" action="<?php echo base_url()?>app/employee_201_profile/address_info_modify/<?php echo $this->uri->segment("4");?>" >

    <div class="box-body"></div>

    <div class="box-body">


          <div class="row">
            
          <div class="col-md-6">

          <div class="panel panel-info">
            <div class="panel-heading">Permanent Address</div>
            <div class="panel-body">

            <div class="form-group">  
              <label for="per_address">Address</label>
              <input type="text" name="per_address" id="per_address" class="form-control" placeholder="Address" value="<?php echo $address_info_view->permanent_address; ?>">
            </div>

            <div class="form-group">
              <label for="per_province">Province</label>
              <select class="form-control" name="per_province" id="per_province" onchange="getPercities(this.value)">
                <option selected="selected" value="<?php echo $address_info_view->permanent_province;?>"><?php echo $address_info_view->permanent_province_name; ?></option>
                <?php 
                  foreach($provinceList as $province){
                  if($_POST['province'] == $province->id){
                      $selected = "selected='selected'";
                  }else{
                      $selected = "";
                  }
                  ?>
                  <option value="<?php echo $province->id;?>" <?php echo $selected;?>><?php echo $province->name;?></option>
                  <?php }?>
              </select>
            </div>

            <div id="per_cities">
            <div class="form-group">
              <label for="per_address">City</label>
              <select class="form-control" name="per_city" id="per_city">
              <?php $cities = $this->employee_201_profile_model->get_province_cities($address_info_view->permanent_province);
                foreach ($cities as $c) {
              ?>
                  <option value="<?php echo $c->id?>" <?php if($c->id==$address_info_view->permanent_city){ echo "selected"; }?>><?php echo $c->city_name?></option>
              <?php } ?>
              </select>
            </div>
            </div>

            <div class="form-group">
              <label for="per_stay">Years of stay</label>
              <input type="number" name="per_stay"  id="per_stay" class="form-control" placeholder="Years of stay" value="<?php echo $address_info_view->permanent_address_years_of_stay; ?>">
            </div>

            </div>
            </div>

            </div>
            

            <div class="col-md-6">
            <div class="panel panel-info">
            <div class="panel-heading">Present Address</div>
            <div class="panel-body">

            <div class="form-group">
              <label for="pre_address">Address</label>
              <input type="text" name="pre_address" id="pre_address" class="form-control" placeholder="Address" value="<?php echo $address_info_view->present_address; ?>">
              <input style="display:none;" type="text"  name="copy_address" id="copy_address" class="form-control" placeholder="Address">
            </div>

            <div class="form-group">
              <label>Province</label>
              <select class="form-control" name="pre_province" id="pre_province" onchange="getPrecities(this.value)">
                <option selected="selected" value="<?php echo $address_info_view->present_province;?>"><?php echo $address_info_view->present_province_name;?></option>
                <?php 
                  foreach($provinceList as $province){
                  if($_POST['province'] == $province->id){
                      $selected = "selected='selected'";
                  }else{
                      $selected = "";
                  }
                  ?>
                  <option value="<?php echo $province->id;?>" <?php echo $selected;?>><?php echo $province->name;?></option>  
                  <?php }?>
              </select>

               <select style="display: none;" class="form-control" name="copy_province" id="copy_province" >
                <option selected="selected" value="<?php echo $address_info_view->present_province;?>"><?php echo $address_info_view->present_province_name;?></option>
                <?php 
                  foreach($provinceList as $province){
                 
                  ?>
                  <option value="<?php echo $province->id;?>"><?php echo $province->name;?></option>  
                  <?php }?>
              </select>
             

            </div>

            <div id="pre_cities">
            <div class="form-group">
              <label for="pre_address">City</label>
              <select class="form-control" id="pre_city" name="pre_city">
                <?php $cities = $this->employee_201_profile_model->get_province_cities($address_info_view->present_province);
                  foreach ($cities as $c) {
                ?>
                    <option value="<?php echo $c->id?>" <?php if($c->id==$address_info_view->present_city){ echo "selected"; }?>><?php echo $c->city_name?></option>
                <?php } ?>
              </select>

              <select style="display: none;" class="form-control" id="copy_city" name="copy_city">
                <?php $cities = $this->employee_201_profile_model->get_cities();
                  foreach ($cities as $c) {
                ?>
                    <option value="<?php echo $c->id?>" ><?php echo $c->city_name?></option>
                <?php } ?>
              </select>

            </div>
            </div>

            <div class="form-group">
              <label for="pre_stay">Years of stay</label>
              <input type="number" name="pre_stay" id="pre_stay" class="form-control" placeholder="Years of stay" value="<?php echo $address_info_view->present_address_years_of_stay; ?>">
               <input style="display: none;" type="number" name="copy_stay" id="copy_stay" class="form-control">
            </div>
              <label><input type="checkbox" onclick="copy_permanent();" id="copy">Same with permanent address</label>
              <input  type="hidden" name="copy_id_value" id="copy_id_value">
              <input  type="hidden" name="_stay" id="stay" class="form-control">
              <input  type="hidden" name="_address" id="address" class="form-control">
              <input  type="hidden" name="_city" id="city" class="form-control">
              <input  type="hidden" name="_province" id="province" class="form-control">
            </div>

            </div>
            </div>

            </div>
     <br>
     <div class="form-group">
     <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> SAVE CHANGES</button>
     </div>
    </div><!-- /.box-body -->
    </form>

</div>
</div>

</div>  
</div>


