<?php foreach($color_code as $cc){?>
    <input type="hidden" id="<?php echo $cc->color_code;?>" value="<?php echo $cc->identification;?>">
<?php } ?>
<div class="col-md-4">
    <div class="box box-primary">
     
      <div class="box-body">
      	 <div class="col-md-12 panel-heading">
             <input type="hidden" name="i_comp" id="i_comp" value="<?php echo $company;?>">
            <div id='result_act'>
            </div>      
         </div>
           <div id="ip_emp_profile">
           <?php if(empty($emp_info->picture)){ $picture='user.png'; } else{ $picture =$emp_info->picture; }?>
             <center><img style="width: 150px;height:100px;margin-top: 10px;" src="<?php echo base_url() . "public/employee_files/" ?>employee_picture/<?php echo $picture; ?>"></center>
             <n class='text-success'><center><?php  echo $emp_info->employee_id?></center></n>
             <n class='text-success'><center><?php  echo $emp_info->first_name." ".$emp_info->last_name?></center></n>
             <n class='text-success'><center><?php  echo $emp_info->company_name?></center></n>
             <n class='text-success'><center><?php  echo $emp_info->dept_name?></center></n>
             <n class='text-success'><center><?php  echo $emp_info->classification?></center></n>
           </div>
           <div class="col-md-12">
              <div class="box box-danger" class='col-md-12'></div>
            </div>
           <div class="col-md-12" id="ip_emp_plot">
            <label><center>Choose Working Schedule</label>
            <div class="col-md-12">
              <select name="working_sched" id="working_sched" class="form-control select2" required>
                <option value="" disabled selected="">Select</option>
                <option value="restday"> Rest Day</option>
                <option disabled>~~ Regular Whole day Schedule ~~</option>
                <?php 
                $ws_regular=$this->general_model->get_ws_regular($emp_info->classification_id,$emp_info->company_id);
                if(!empty($ws_regular)){
                  foreach($ws_regular as $whole_sched){
                    //reg_ : regular working schedule / whole day
                    echo '<option style="color:#65D8D3;" value="reg_'.$whole_sched->time_in.' to '.$whole_sched->time_out.'">'.$whole_sched->time_in.' to '.$whole_sched->time_out.'</option>';
                  } 
                }else{
                  echo '<option value="" disabled>  </option>';
                }
                ?>
                <option disabled>~~ Half Schedule ~~</option>
                <?php 
                $ws_halfday=$this->plot_schedule_model->get_ws_halfday($emp_info->classification_id,$emp_info->company_id);

                if(!empty($ws_halfday)){
                  foreach($ws_halfday as $half_sched){
                    //haf_ : halfday working schedule
                      echo '<option style="color:#16810B;" value="haf_'.$half_sched->time_in.' to '.$half_sched->time_out.'">'.$half_sched->time_in.' to '.$half_sched->time_out.'</option>';
                    } 
                  }
                else{
                  echo '<option value="" disabled>  </option>';
                }
                ?>
                <option disabled>~~ Restday/Holiday Schedule ~~</option>
                <?php 
                $ws_rd_hol=$this->plot_schedule_model->get_ws_restday_holiday($emp_info->classification_id,$emp_info->company_id);

                if(!empty($ws_rd_hol)){
                  foreach($ws_rd_hol as $rd_hol_sched){
                    //rdh : restday holiday working schedule
                    echo '<option style="color:#DC172C;" value="rdh_'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'">'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'</option>';
                  } 
                }
                else{
                  echo '<option value="" disabled> </option>';
                }
                ?>
              </select>
              <br>
              </div>

          </div>
          <div class="col-md-12">
            <?php echo "<a type='button' style='margin-top:5px;' class='col-md-12 btn btn-xs btn-success pull-right' data-toggle='modal' data-target='#modal' href='".base_url('app/plot_schedules/view_color_code')."/not_fixed'> <b>CLICK TO VIEW COLOR DESC</b></a>"; ?>
            <a type='button' style='margin-top:5px;' class='col-md-12 btn btn-xs btn-success pull-right' onclick="location.reload();"> <b>CLICK TO VIEW GROUP SCHEDULE</b></a>
          </div>
      </div>
    </div>
   </div>

   <!-- CALENDAR -->
   <div class="col-md-8">
   <div class="box box-primary" style="height: 600px;">
   	<div id="calendar_optionss">
    <div id="calendar_option_employee" class="col-md-12">

	</div>
    </div>
   </div>
   </div>

    <div id="modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
       <div class="modal-content modal-md">
       </div>
    </div>
</div>