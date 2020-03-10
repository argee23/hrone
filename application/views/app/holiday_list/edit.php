<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/holiday_list/modify_holiday/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
      <input type="hidden" class="form-control" name="holiday_id" id="holiday_id" placeholder="leave id" value="<?php echo $holiday_list->hol_id?>">

      <div class="form-group">
         <label for="location" class="col-sm-2 control-label">Location</label>
        <div class="col-sm-10">
                <?php 

                 // $data = $this->holiday_list_model->getBranches();
                  foreach($locationList as $row){ 

                  $data2 = $this->holiday_list_model->check_if_holiday_is_applicable($row->location_id,$holiday_list->hol_id);

                  if (!empty($data2)){
                  $applicable="checked";
                  }else{
                  $applicable="";
                  }

                  $branch =$row->location_name; 
                  $b_id=$row->location_id;

                  echo "<input type='checkbox' name='branch_id[]' value='".$b_id."'".$applicable.">&nbsp;".$branch."<br>";        

                  }

                  ?>  

        </div>
      </div>               
      <div class="form-group">
         <label for="holiday" class="col-sm-2 control-label">Holiday</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="holiday" id="holiday" placeholder="Holiday" value="<?php echo $holiday_list->holiday?>" required>
        </div>
      </div>
        <div class="form-group" id="">
        <label for="year" class="col-sm-2 control-label">Year</label>
        <div class="col-sm-10">
          <select name="true_year" class="form-control" id="year" required >
          <option value="<?php echo $holiday_list->year?>" selected=""><?php echo $holiday_list->year?></option>
          <?php
                  echo "<option value='".date("Y")."'>". date("Y") ."</option>";
                  echo "<option value='".date("Y",strtotime("-1 year"))."'>". date("Y",strtotime("-1 year")) ."</option>";
               
          ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="month" class="col-sm-2 control-label">Month</label>
        <div class="col-sm-10">
          <select name="month" class="form-control" id="month" required >
          <option value="<?php echo $holiday_list->month?>" selected=""><?php echo date("F", mktime(0, 0, 0, $holiday_list->month, 10)) ;?></option>
          <?php
              for($M =1;$M<=12;$M++){
                  echo "<option value='".$month_no = sprintf("%02d", $M)."'>". date("F", mktime(0, 0, 0, $M, 10)) ."</option>";
                }
          ?>
          </select>
        </div>
      </div>     
      <div class="form-group">
        <label for="day" class="col-sm-2 control-label">Day</label>
        <div class="col-sm-10">
        <select name="day" class="form-control" id="day" required>
          <option value="<?php echo $holiday_list->day?>" selected="" ><?php echo $holiday_list->day?></option>
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
      <div class="form-group">
        <label for="type" class="col-sm-2 control-label">Type</label>
        <div class="col-sm-10">
       
        <?php 
        $type=$holiday_list->type;
        $data = $this->holiday_list_model->get_holiday_type_string($type);
                 
foreach($data as $row)
//echo '<input  type="text" class="form-control" name="type"  placeholder="Month" value="'. $type_final=$row->cValue.'" style="width:100%;">'                   ?>
 
 <select name="type" class="form-control" id="type" required >
        <option value="<?php echo $holiday_list->type?>" selected="" ><?php echo $type_final=$row->cValue?></option>
        <?php
            foreach($holiday_type as $holiday_type){
                echo "<option value='".$holiday_type->code."'>". $holiday_type->cValue."</option>";
              }
        ?>
        </select>

  
        </div>
      </div>
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i>Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>