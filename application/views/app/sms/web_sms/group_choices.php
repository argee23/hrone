
  <div class="form-group">
    <div class="col-md-12">
      <label class="col-md-12">Grouped Contact</label>
      <select class="form-control" name="grouped_contact" required>
      	<option  value="" selected disabled>Select</option>
          <?php
          if(!empty($ActiveGc)){
            foreach($ActiveGc as $a){
              echo '
              <option value="'.$a->id.'">'.$a->group_name.'</option>
              ';
            }
          }else{

          }
          ?>
      </select>
    </div>
   </div>
     <div class="form-group">
    <div class="col-md-12">
      <label class="col-md-12">Mobile No</label>
      <select class="form-control" name="mobile_no" >
  
        <option value="mobile_1" selected> Mobile No 1</option>
        <option value="mobile_2">Mobile No 2</option>
        <option value="mobile_3">Mobile No 3</option>
        <option value="mobile_4">Mobile No 4</option>
      </select>
    </div>
   </div>