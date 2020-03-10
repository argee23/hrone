
 <div class="form-group">
        <label for="month" class="col-sm-2 control-label">Date<br><br>Type</label>
        <div class="col-sm-10">
                      <div id="here">
<?php 
    if($this->uri->segment("4") == 0){?>

<!--         <select class="form-control select2" name=""  >
      <option selected="selected" value="0">-Select Month-</option>
    </select> -->

    <?php }else{

        foreach($get_date as $date){
        
        ?>
        <input type="hidden" name="true_year" value="<?php echo date('Y');?>" >
        <input type="hidden" name="holiday" value="<?php echo $date->cValue;?>" >
        <input type="hidden" name="true_month" value="<?php echo $date->month;?>" >
        <input readonly type="text" class="form-control" name="month"  placeholder="Month" value="<?php echo date("F", mktime(0, 0, 0, $date->month, 10));?>" style="width:50%;float:left;">
         <input readonly type="text" class="form-control" name="day"  placeholder="Month" value="<?php echo $date->day;?>" style="width:50%;float:left;">
         <input type="hidden" name="true_type" value="<?php echo $date->type;?>" >
            <?php 
                $type=$date->type;

            }
            }
             $data = $this->holiday_list_model->get_holiday_type_string($type);
                 
                  foreach($data as $row){
                        echo 
'<input readonly type="text" class="form-control" name="type"  placeholder="Month" value="'. $type_final=$row->cValue.'" style="width:100%;">';
                        
                      }
                      
        ?>

</div>
      </div>  
      </div>      

   