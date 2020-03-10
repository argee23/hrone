  <?php if($action=='Designation'){ ?>
  <div class="col-md-12">
          <div class="col-md-2"></div>
          <div class="col-md-3">Company :</div>
          <div class="col-md-6">
            <select class="form-control" name="company" id="company" required onchange="result_onchange_val('division',this.value)">
              <option selected disabled value=""> Select Company</option>
               <?php foreach ($companyList as $row) {?>
               <option value="<?php echo $row->company_id?>"><?php echo $row->company_name?></option>
              <?php } ?>
            </select><br>
          </div>
      </div>
     
      </div>
       <div class="col-md-12">
        <div class="col-md-2"></div>
          <div class="col-md-3">Division :</div>
          <div class="col-md-6">
            <select class="form-control" name="division" id="division" required onchange="result_onchange_val('department',this.value)">
            <option selected value=""> Select Division</option>
            </select><br>
          </div>
      </div>

      <div class="col-md-12">
       <div class="col-md-2"></div>
          <div class="col-md-3">Department :</div>
          <div class="col-md-6">
            <select class="form-control" name="department" id="department" required onchange="result_onchange_val('section',this.value)">
              <option selected value=""> Select Department</option>
            </select><br>
          </div>
      </div>

      <div class="col-md-12">
       <div class="col-md-2"></div>
          <div class="col-md-3">Section :</div>
          <div class="col-md-6"> 
            <select class="form-control" name="section" id="section" required onchange="result_onchange_val('subsection',this.value)">
              <option selected value=""> Select Section</option>
            </select><br></div>
      </div>

       <div class="col-md-12">
        <div class="col-md-2"></div>
          <div class="col-md-3">Sub Section :</div>
          <div class="col-md-6">
            <select class="form-control" name="sub_section" id="subsection" required onchange="result_onchange_val('location',this.value)">
              <option selected disabled value=""> Select Sub Section</option>
            </select><br></div>
      </div>
       <div class="col-md-12" id='location'>
        <div class="col-md-2"></div>
         </div>
      </div>

      </div>
      <div class="col-md-12" name="classification" id="classification">
      </div>
      <div class="col-md-12">
       <div class="col-md-2"></div>
          <div class="col-md-3">Employment :</div>
          <div class="col-md-6">
              <?php foreach ($employment as $row) {
                echo "<input type='checkbox' class='employment' value='".$row->employment_id."' onchange='employment();'> ".$row->employment_name."<br>";
              }?>
              <br>
          </div>
      </div>

      <div class="col-md-12">
       <div class="col-md-2"></div>
          <div class="col-md-3">Employee Status :</div>
          <div class="col-md-6">
            <select class="form-control" id="status">
              <option value='All'>All</option>
              <option value="0" selected>Active</option>
              <option value="1">InActive</option>
            </select>
           </div>
          </div>
      </div>

     <div class="col-md-12" style="padding-top: 20px;">
          <div class="col-md-7 pull-right"><button class="btn btn-success col-md-3" onclick="save_designantion_value();">SAVE</button></div>
      </div>    
    <?php } else{?>
          <div class="col-md-12"><button class="btn btn-success col-md-3 pull-right" onclick="save_all_value();">SAVE</button></div>
      
    <?php } ?>
