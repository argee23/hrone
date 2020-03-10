
<div class="well">
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/holiday_list/save_add/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">

      <!-- //============================================================== select predefined holidays-->
      <div class="form-group" >
        <label for="location" class="col-sm-2 control-label">Location</label>
        <div class="col-sm-10">
                    <?php
                    $max_id=$search_for_highest_id->AUTO_INCREMENT; 
                      // foreach (($search_for_highest_id ? $search_for_highest_id : array()) as $max_id){
                      // //foreach($search_for_highest_id as $max_id){ 
                      // $max=$max_id->hol_id;                
                      // $max_id=$max+1;
                          
                      // }
            echo "<input type='hidden' name='hol_id' value='".$max_id."'>";
            foreach($locationList as $branch){                
                    ?>
            <input type="checkbox" name="branch_id[]" value="<?php echo $branch->location_id;?>" checked >&nbsp;<?php echo $branch->location_name;?>
            <br>  
                    <?php 
                    }
                    ?>

        </div>
      </div> 

       <div class="form-group" id="select_holidays"> <!-- <<= ID is for disabling this div -->
        <label for="month" class="col-sm-2 control-label">Select Holiday</label>
        <div class="col-sm-10">
           <select class="form-control select2" name="" id="selected_holiday" style="width:100%;" onchange="applyChange()" onclick="disableEnterHoliday()">
            <option selected="selected" disabled>-Select Holidays-</option>
              <?php 
                foreach($legal_holidays as $holiday){
                  if($_POST['holiday'] == $holiday->param_id){
                    $selected = "selected='selected'";
                        }else{
                    $selected = "";
                        }
                        ?>
            <option value="<?php echo $holiday->param_id;?>" <?php echo $selected;?>><?php echo $holiday->cValue;?></option>
                        <?php }?>
           </select>                       
      </div>  
      </div> 
                      <div id="showdate"> 

      <!-- //============================================================== type holiday-->
       <div class="form-group" id="manual_input_holiday">
        <label for="month" class="col-sm-2 control-label">Enter Holiday</label>
        <div class="col-sm-10">
        <input type="text" name="holiday" id="input_holiday" placeholder="Enter Holiday" class="form-control" onclick="disableSelectHoliday()" required />
        </div>
      </div> 
<div id="testing">
      <div class="form-group" id="manual_select_year">
        <label for="year" class="col-sm-2 control-label">Year</label>
        <div class="col-sm-10">
          <select name="true_year" class="form-control" id="year" required >
          <?php
                  echo "<option value='".date("Y")."'>". date("Y") ."</option>";
                  echo "<option value='".date("Y",strtotime("-1 year"))."'>". date("Y",strtotime("-1 year")) ."</option>";
               
          ?>
          </select>
        </div>
      </div>
      <div class="form-group" id="manual_select_month">
        <label for="month" class="col-sm-2 control-label">Month</label>
        <div class="col-sm-10">
          <select name="true_month" class="form-control" id="month" required >
          <option value="" selected="" disabled="">Select Month</option>
          <?php
              for($M =1;$M<=12;$M++){
                  echo "<option value='".$month_no = sprintf("%02d", $M)."'>". date("F", mktime(0, 0, 0, $M, 10)) ."</option>";
                }
          ?>
          </select>
        </div>
      </div>
</div>
      <div class="form-group" id="manual_select_day">
        <label for="day" class="col-sm-2 control-label">Day</label>
        <div class="col-sm-10">
         <select name="day" class="form-control" id="day" required>
          <option value="" selected="" disabled="">Select Day</option>
          <?php
              $D = 1;
              while ( $D <= 31 ) {
              echo "<option value=".sprintf("%02d", $D).">".sprintf("%02d", $D)."</option>";
              $D++;
              }
          ?>
          </select>
        </div>
      </div>

      <div class="form-group" id="manual_select_type">
        <label for="month" class="col-sm-2 control-label">Type</label>
        <div class="col-sm-10">
        <select name="true_type" class="form-control" id="type" required >
        <option value="" selected="" disabled="">Select Type</option>
        <?php
            foreach($holiday_type as $holiday_type){
                echo "<option value='".$holiday_type->code."'>". $holiday_type->cValue."</option>";
              }
        ?>
        </select>
        </div>
      </div> 



                      </div>



          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i>Save</button>
    </div> <!-- /.box-body -->
  </form>
</div>


<div class="col-md-6" id="col_4"></div>



