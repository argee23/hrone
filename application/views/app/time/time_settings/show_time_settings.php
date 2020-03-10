<!--// ts_topic: time settings topic -->
<?php 
 $company_id=$this->uri->segment('4');
 '<input type="text" id="company_id" value="'.$company_id.'">';
foreach($ts_topic as $ts_topic){
$topic_id= $ts_topic->time_setting_id;

  ?>

    <div class="col-md-7" id="">
      <div class="box box-success">
        <div class="box-header"><i class="fa fa-gears text-success"></i><strong>
         <?php echo $ts_topic->time_setting_topic;?></strong>
<?php 
//echo $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right" data-toggle="tooltip" data-placement="left" title="Edit " onclick="edit('.$ts_topic->time_setting_id.')"></i>';
?>

<?php
echo $edit='<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x pull-right" style="color:'.$system_defined_icons->icon_edit_color.';" " data-toggle="tooltip" data-placement="left" title="Edit " onclick="edit('.$ts_topic->time_setting_id.')"></i> ';
?>

         </div>
        <div class="box-body">
<!--//=======================================with per classification settings  -->        
        <?php 
         if($ts_topic->with_by_classification=="1"){
/*+++*/          $topic_id= $ts_topic->time_setting_id;
          ?>
             <div class="table-responsive">
<?php

//===========night differential 0.13%
if($ts_topic->time_setting_id=="3"){
echo '
  <div class="col-md-12">
    <div class="panel panel-success">
      <div class="panel-heading"><strong>Time</strong></div>
    <div class="panel-body">
      '.$ts_topic->night_diff_time_from.' to '.$ts_topic->night_diff_time_to.'
    </div>   </div>
  </div>';

}else if($ts_topic->time_setting_id=="8"){

//===========regular night differential 
echo '
  <div class="col-md-12">
    <div class="panel panel-success">
      <div class="panel-heading"><strong>Time</strong></div>
    <div class="panel-body">
      '.$ts_topic->reg_night_diff_time_from.' to '.$ts_topic->reg_night_diff_time_to.'
    </div>   </div>
  </div>';
}else if($ts_topic->time_setting_id=="7"){

}else{

}
//===========
if($ts_topic->time_setting_id=="7"){


}else{

}
?>
      <table id="<?php echo $ts_topic->data_table_id; ?>" class="table table-hover table-striped">
      <thead>
        <tr>
          <td><b>Classification</b></td>
         <?php 
         foreach($employmentList as $employment){
          echo '<td>'.$employment->employment_name.'</td>';
         }//employment
         ?>   
        </tr>
      </thead>
      <tbody>
       <?php 
            foreach($myclassificationList as $cl){     
/*+++*/         $class_id=$cl->classification_id;      
        ?>
        <tr >
          <td><?php echo $cl->classification;?></td>
          <?php 
         foreach($employmentList as $employment){
/*+++*/         $employment_id=$employment->employment_id;

        $get_setting = $this->time_settings_model->get_settings_value2($topic_id,$class_id, $employment_id,$company_id);
          if(!empty($get_setting)){
              foreach($get_setting as $setting){
               $setting_value= $setting->setting_value;
              }
          }else{
            $setting_value= "no setting";
          }


          echo '<td ><input readonly type="text" value="'.$setting_value.'" size="8px" style="text-align: center;"/></td>';
         }//employment
         ?>  
        </tr>
          <?php 
            }//classificationList
            ?>

            </tbody>  
      </table>
      <!-- // late deduction reference : for late settings only  -->
      </div>
  <?php if($topic_id=="1"){ ?>
  <div class="col-md-12">
    <div class="panel panel-success">
      <div class="panel-heading"><strong>Late Deduction Table</strong>
      <a onclick="add_late_deduction_reference()" type="button" class="btn btn-sm btn-default pull-right" title="Add Late Deduction Table">
     <!--  <i class="fa fa-plus"></i> -->

<?php
echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
?>
      </a>
      </div>
       <div class="panel-body">
           <table class="table table-hover table-striped">
      <thead>
        <tr>
          <th>From Minute(s)</th>
          <th>To Minute(s)</th>
          <th>Equivalent Deduction</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($late_deduction_ref as $late_ded){ ?>
        <tr>
          <td><?php echo $late_ded->from_minute;?></td>
          <td><?php echo $late_ded->to_minute;?></td>
          <td><?php echo $late_ded->deduction;?></td>
          <td>
          <?php 

		$location_name=$this->time_settings_model->get_location($company_id);
		$loc_name=$location_name->company_name;

      echo  $edit = '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" " data-toggle="tooltip" data-placement="left" title="Edit" onclick="edit_late_deduction_reference('.$late_ded->id.')"></i>';

      echo  $delete = anchor('app/time_settings/delete_late_deduction_reference/'.$late_ded->id.'/'.$company_id,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';" "></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete << ".$loc_name." : Late Deduction Reference >> From Minute(s): ".$late_ded->from_minute. " To Minute(s): ".$late_ded->to_minute. " ( Equivalent Deduction: ".$late_ded->deduction.") ?')"));

          ?>
          </td>
        </tr>
      <?php } ?>  
      </tbody>
      </table>
       </div>
    </div>
  </div>
     <?php } elseif($ts_topic->time_setting_id==70){?>

           <div class="col-md-12" id="#minimum_deduction">
              <div class="panel panel-success">
                <div class="panel-heading"><strong>Minimum Hours/Minutes Choices</strong>
                <a onclick="add_minimum_hour_mins_perhour_leave('time_settings_minimum_hours_mins')" type="button" class="btn btn-sm btn-default pull-right" title="Add minimum hours/minutes for per hour filing">
               <!--  <i class="fa fa-plus"></i> -->

          <?php
          echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
          ?>
                </a>
                </div>
                 <div class="panel-body">
                     <table class="table table-hover table-striped">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Hours</th>
                          <th>Minutes</th>
                          <th>Total</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $get_minimum_hrs_mins = $this->time_settings_model->get_minimum_hours_minutes($company_id,'time_settings_minimum_hours_mins');
                          foreach($get_minimum_hrs_mins as $data){
                        ?>
                        <tr>
                            <td><?php echo $data->id;?></td>
                            <td><?php echo $data->minimum_hour;?></td>
                            <td><?php echo $data->minimum_mins;?></td>
                            <td><?php echo $data->total;?></td>
                            <td>
                                <?php 
                                  if($data->InActive==1)
                                  {
                                      echo  $active = anchor('app/time_settings/status_hours_minutes/time_settings_minimum_hours_mins/'.$data->id.'/'.$company_id.'/'.$data->InActive,'<i class="fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';" "></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Enable','onclick'=>"return confirm('Are you sure you want to enable id ".$data->id." ?')"));
                                  }
                                  else
                                  {
                                      echo  $inactive = anchor('app/time_settings/status_hours_minutes/time_settings_minimum_hours_mins/'.$data->id.'/'.$company_id.'/'.$data->InActive,'<i class="fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';" "></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Disable','onclick'=>"return confirm('Are you sure you want to disable id ".$data->id." ?')"));
                                  }
                                  
                                ?>

                                <?php 
                                  echo  $delete = anchor('app/time_settings/delete_hours_minutes/time_settings_minimum_hours_mins/'.$data->id.'/'.$company_id,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';" "></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete id ".$data->id." ?')"));
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                      </table>
                 </div>
              </div>
            </div>

             <div class="col-md-12" id="#minimum_deduction">
              <div class="panel panel-success">
                <div class="panel-heading"><strong>Allowed Per hour leave filing</strong>
                <a onclick="add_minimum_hour_mins_perhour_leave('time_settings_allowed_per_hour')" type="button" class="btn btn-sm btn-default pull-right" title="Add minimum hours/minutes for per hour filing">
               <!--  <i class="fa fa-plus"></i> -->

          <?php
          echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
          ?>
                </a>
                </div><div class="panel-body">
                     <table class="table table-hover table-striped">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Hours</th>
                          <th>Minutes</th>
                          <th>Total</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $get_minimum_hrs_mins = $this->time_settings_model->get_minimum_hours_minutes($company_id,'time_settings_allowed_per_hour');
                          foreach($get_minimum_hrs_mins as $data){
                        ?>
                        <tr>
                            <td><?php echo $data->id;?></td>
                            <td><?php echo $data->minimum_hour;?></td>
                            <td><?php echo $data->minimum_mins;?></td>
                            <td><?php echo $data->total;?></td>
                            <td>
                                <?php 
                                  if($data->InActive==1)
                                  {
                                      echo  $active = anchor('app/time_settings/status_hours_minutes/time_settings_allowed_per_hour/'.$data->id.'/'.$company_id.'/'.$data->InActive,'<i class="fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';" "></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Enable','onclick'=>"return confirm('Are you sure you want to enable id ".$data->id." ?')"));
                                  }
                                  else
                                  {
                                      echo  $inactive = anchor('app/time_settings/status_hours_minutes/time_settings_allowed_per_hour/'.$data->id.'/'.$company_id.'/'.$data->InActive,'<i class="fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';" "></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Disable','onclick'=>"return confirm('Are you sure you want to disable id ".$data->id." ?')"));
                                  }
                                  
                                ?>

                                <?php 
                                  echo  $delete = anchor('app/time_settings/delete_hours_minutes/time_settings_allowed_per_hour/'.$data->id.'/'.$company_id,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';" "></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete id ".$data->id." ?')"));
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                      </table>
                 </div>
              </div>
            </div>

      <?php 
        }
      
          
          }else{//with_by_classification=0
            echo "";
          }
        ?>
<!--//=======================================with single field settings  -->
<?php 

if($ts_topic->with_single_field_setting=="1"){
?>  
  <?php if($topic_id=="10"){ ?>
  <div class="form-group"   >
      <label for="sfs" class="col-sm-1 control-label"><i class="fa fa-arrow-circle-right pull-right text-danger"></i> </label>
        <div class="col-sm-11" >
  <input readonly type="text" class="form-control" value="<?php if($ts_topic->overtime_filing=="single_and_by_batch"){
echo "single filing and by batch filing";
    }else if($ts_topic->overtime_filing=="by_group"){echo "by_group";}else{echo "general";} ?>">
        </div>
  </div>

  <?php }elseif($topic_id=="70"){ echo "After ".$ts_topic->single_field_setting." Minutes From Shift Out";}else{?>

    <div class="form-group"   >
      <label for="sfs" class="col-sm-1 control-label"><i class="fa fa-arrow-circle-right pull-right text-danger"></i> </label>
        <div class="col-sm-11" >
  <input readonly type="text" class="form-control" value="<?php 
  //Machine attendance option
   if($ts_topic->single_field_setting=="FILO"){
    echo "First IN Last OUT";
   }else if($ts_topic->single_field_setting=="FIFO"){
    echo "First IN First Out";
   }else if($ts_topic->single_field_setting=="LIFO"){
    echo "Last IN First OUT";
   }else if($ts_topic->single_field_setting=="LILO"){
    echo "Last IN Last OUT";
   }
  //No work shedule treatment
   else if($ts_topic->single_field_setting=="mark_as_absent"){
    echo "Mark as absent";
   }
   else if($ts_topic->single_field_setting=="no_absent_but_no_reg_hour_work"){
    echo "No Absent but no reg hour work";
   }
   // else if($ts_topic->single_field_setting=="3_no_work_sched_treatment"){
   //  echo "Convert to flexi time : with attendance";
   // }
  //Allow employee to view DTR
   else if($ts_topic->single_field_setting=="1_dtr_view"){
    echo "YES";
   }
   else if($ts_topic->single_field_setting=="2_dtr_view"){
    echo "After Posting of Payroll";
   }
   else if($ts_topic->single_field_setting=="3_dtr_view"){
    echo "No";
   }
  //Regular Holiday hours allocation
   else if($ts_topic->single_field_setting=="1_reg_hol_hrs_alloc"){
    echo "will add to regular hours work";
   }
   else if($ts_topic->single_field_setting=="2_reg_hol_hrs_alloc"){
    echo "will NOT add to regular hours work";
   }
  //Advance DTR computation
   else if($ts_topic->single_field_setting=="yes_absent_adv_dtr_comp"){
    echo "Yes (mark as absent)";
   }
   else if($ts_topic->single_field_setting=="yes_present_adv_dtr_comp"){
    echo "Yes (mark as present)";
   }
   else if($ts_topic->single_field_setting=="no_adv_dtr_comp"){
    echo "NO";
   }
  //Rest day falling on Regular Hol. w/o attendance
   else if($ts_topic->single_field_setting=="1_rd_on_reg_hol_wo_attendance"){
    echo "add another column for rest day regular holiday without attendance type 2";
   }
   else if($ts_topic->single_field_setting=="2_rd_on_reg_hol_wo_attendance"){
    echo "add to regular hours";
   }
  //web bundy type
   else if($ts_topic->single_field_setting=="1_web_bundy_type"){
    echo "3 function buttons";
   }
   else if($ts_topic->single_field_setting=="2_web_bundy_type"){
    echo "8 function buttons";
   }
  //automatic over time option
   else if($ts_topic->single_field_setting=="1_aut_ot_option"){
    echo "automatic file OT";
   }
   else if($ts_topic->single_field_setting=="2_aut_ot_option"){
    echo "built in OT + employee file";
   }
   else if($ts_topic->single_field_setting=="ao_actual_total_absent"){
    echo "Actual DTR total absent value";
   }
   else if($ts_topic->single_field_setting=="ao_wholeday_absent"){
    echo "Count whole day absences only";
   }
   else if($ts_topic->single_field_setting=="ao_wholeday_halfday_absent"){
    echo "Count whole day & halfday absent ( will count 0.5 absent as +1 occurence not as occurence +0.5 occurence )";
   }else{//display the actual content of field name
    echo $ts_topic->single_field_setting;
   }
   ?>">
        </div>
    </div>

<?php 

}
}else{
echo '';
}
?>
<!--//=======================================process employee with date hired on current period -->
<?php 
//datehired_on_cur_period_sts : process employee with date hired on current period SAVE TIME SUMMARY (sts)
//datehired_on_cur_period_dwa : process employee with date hired on current period MARK DAYS W/O ATTENDANCE (dwa)
if(($ts_topic->datehired_on_cur_period_sts<>"not_included")AND($ts_topic->datehired_on_cur_period_dwa<>"not_included")) {
?>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">save time summary </label>
        <div class="col-sm-8" >
  <input readonly type="text" class="form-control" value="<?php echo $ts_topic->datehired_on_cur_period_sts;?>">
        </div>
    </div>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">mark days not yet hired as </label>
        <div class="col-sm-8" >
  <input readonly type="text" class="form-control" value="<?php if($ts_topic->datehired_on_cur_period_dwa=="not_paid_not_absent"){ echo "not paid but not counted as absent"; }else{ echo $ts_topic->datehired_on_cur_period_dwa; }?>">
        </div>
    </div>
<?php 
}else{
echo "";
}
?>        
<!--//======================================= regular_holiday_multi_policy/snw_holiday_multi_policy-->
<?php 
if(($ts_topic->regular_holiday_multi_policy<>"not_included")AND($ts_topic->snw_holiday_multi_policy<>"not_included")){

//======================================= absent before the holiday
//regular_holiday_multi_policy : absent before the regular holiday
//snw_holiday_multi_policy : absent before the special holiday
if($ts_topic->time_setting_id=="25" OR $ts_topic->time_setting_id=="60" OR $ts_topic->time_setting_id=="61" OR $ts_topic->time_setting_id=="62" OR $ts_topic->time_setting_id=="63" OR $ts_topic->time_setting_id=="64"){
?>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">Regular Holiday </label>
        <div class="col-sm-8" >
  <input readonly type="text" class="form-control" value="<?php echo $ts_topic->regular_holiday_multi_policy;?>">
        </div>
    </div>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">Special Non-Working Holiday</label>
        <div class="col-sm-8" >
  <input readonly type="text" class="form-control" value="<?php echo $ts_topic->snw_holiday_multi_policy;?>">
        </div>
    </div>
<?php
}else if($ts_topic->time_setting_id=="65"){
?>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label"><span style="color:#ff0000">working day </span>: regular holiday<br> next day : regular day</label>
        <div class="col-sm-8" >
  <input readonly type="text" class="form-control" value="<?php if($ts_topic->regular_holiday_multi_policy=="att_ot_followInDate"){
              echo "Follow type of day of 'IN' date( for attendance and OT)";
            }elseif($ts_topic->regular_holiday_multi_policy=="att_actual_otBaseIsInDate"){
              echo "Follow Actual Date( OT type falls on 'IN' Date )";
            }elseif($ts_topic->regular_holiday_multi_policy=="att_ot_actual"){
              echo "Follow Actual Date( for attendance and OT)";
            }else{
            }?>">
        </div>
    </div>
    <br><br>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">working day : regular day<br><span style="color:#ff0000">next day </span>: regular holiday</label>
        <div class="col-sm-8" >
  <input readonly type="text" class="form-control" value="<?php  if($ts_topic->snw_holiday_multi_policy=="att_ot_followInDate"){
              echo "Follow type of day of 'IN' date( for attendance and OT)";
            }elseif($ts_topic->snw_holiday_multi_policy=="att_actual_otBaseIsInDate"){
              echo "Follow Actual Date( OT type falls on 'IN' Date )";
            }elseif($ts_topic->snw_holiday_multi_policy=="att_ot_actual"){
              echo "Follow Actual Date( for attendance and OT)";
            }else{
            }?>">
        </div>
    </div>


<?php
}else if($ts_topic->time_setting_id=="66"){
?>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label"><span style="color:#ff0000">working day </span>: special non-working holiday<br> next day : regular day</label>
        <div class="col-sm-8" >
  <input readonly type="text" class="form-control" value="<?php if($ts_topic->regular_holiday_multi_policy=="att_ot_followInDate"){
              echo "Follow type of day of 'IN' date( for attendance and OT)";
            }elseif($ts_topic->regular_holiday_multi_policy=="att_actual_otBaseIsInDate"){
              echo "Follow Actual Date( OT type falls on 'IN' Date )";
            }elseif($ts_topic->regular_holiday_multi_policy=="att_ot_actual"){
              echo "Follow Actual Date( for attendance and OT)";
            }else{
            }?>">
        </div>
    </div>
    <br><br>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">working day : regular day<br><span style="color:#ff0000">next day </span>: special non-working holiday</label>
        <div class="col-sm-8" >
  <input readonly type="text" class="form-control" value="<?php  if($ts_topic->snw_holiday_multi_policy=="att_ot_followInDate"){
              echo "Follow type of day of 'IN' date( for attendance and OT)";
            }elseif($ts_topic->snw_holiday_multi_policy=="att_actual_otBaseIsInDate"){
              echo "Follow Actual Date( OT type falls on 'IN' Date )";
            }elseif($ts_topic->snw_holiday_multi_policy=="att_ot_actual"){
              echo "Follow Actual Date( for attendance and OT)";
            }else{
            }?>">
        </div>
    </div>

<?php  
}else if($ts_topic->time_setting_id=="67"){
?>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">working day : <span style="color:#ff0000">special non-working holiday</span><br> next day : <span style="color:#ff0000">regular holiday</span></label>
        <div class="col-sm-8" >
  <input readonly type="text" class="form-control" value="<?php if($ts_topic->regular_holiday_multi_policy=="att_ot_followInDate"){
              echo "Follow type of day of 'IN' date( for attendance and OT)";
            }elseif($ts_topic->regular_holiday_multi_policy=="att_actual_otBaseIsInDate"){
              echo "Follow Actual Date( OT type falls on 'IN' Date )";
            }elseif($ts_topic->regular_holiday_multi_policy=="att_ot_actual"){
              echo "Follow Actual Date( for attendance and OT)";
            }else{
            }?>">
        </div>
    </div>
    <br><br>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">working day : <span style="color:#ff0000">regular holiday</span><br>next day : <span style="color:#ff0000">special non-working holiday</span></label>
        <div class="col-sm-8" >
  <input readonly type="text" class="form-control" value="<?php  if($ts_topic->snw_holiday_multi_policy=="att_ot_followInDate"){
              echo "Follow type of day of 'IN' date( for attendance and OT)";
            }elseif($ts_topic->snw_holiday_multi_policy=="att_actual_otBaseIsInDate"){
              echo "Follow Actual Date( OT type falls on 'IN' Date )";
            }elseif($ts_topic->snw_holiday_multi_policy=="att_ot_actual"){
              echo "Follow Actual Date( for attendance and OT)";
            }else{
            }?>">
        </div>
    </div>


<?php
}else{

}
?>

  <?php 
  }else{

  }
  ?> 



<!--//=======================================COUNTING OF NO. OF DAYS/ REGULAR DAYS PRESENT(AUTO ADDITION/DEDUCTION FORMULA REFERENCE) -->
<?php 
//countdays_present_option: counting option
//countdays_present_rd: count if present on rest day
//countdays_present_rh: count if present on regular holiday
//countdays_present_sh: count if present on special holiday
//countdays_present_lwp: count if present on leave with pay

//countdays_not_present_rd: count if NOT present on rest day
//countdays_not_present_rh: count if NOT present on regular holiday
//countdays_not_present_sh: count if NOT present on special holiday
//countdays_not_present_lwp: count if NOT present on leave with pay

if(($ts_topic->countdays_present_option<>"not_included")
  AND($ts_topic->countdays_present_rd<>"not_included")
  AND($ts_topic->countdays_present_rh<>"not_included")
  AND($ts_topic->countdays_present_sh<>"not_included")
  AND($ts_topic->countdays_present_lwp<>"not_included")
  AND($ts_topic->countdays_not_present_rd<>"not_included")
  AND($ts_topic->countdays_not_present_rh<>"not_included")
  AND($ts_topic->countdays_not_present_sh<>"not_included")
  AND($ts_topic->countdays_not_present_lwp<>"not_included")) {
?>
  <div class="col-md-4">
    <div class="panel panel-info">
      <div class="panel-heading"><strong> counting option </strong>
      </div>
       <div class="panel-body">
          <div class="form-group"   >
          <div class="col-sm-12" >
          <?php if($ts_topic->countdays_present_option=="1"){echo "always count 1 on present";}else{ echo "count only 0.5 on half day";} ?>
          </div>
          </div>
    </div>
  </div>
</div>
  <div class="col-md-4">
    <div class="panel panel-success">
      <div class="panel-heading"><strong> count if present on </strong>
      </div>
       <div class="panel-body">
            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Rest Day</label>
            <div class="col-sm-4" >
            <input type="checkbox" <?php if($ts_topic->countdays_present_rd=="on"){ echo "checked";}else{echo "";}  ?> onclick="return false" >
            </div>
            </div>
            <br>
            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Regular Holiday</label>
            <div class="col-sm-4" >
            <input type="checkbox" <?php if($ts_topic->countdays_present_rh=="on"){ echo "checked";}else{echo "";}  ?> onclick="return false" >
            </div>
            </div>
            <br>
            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Special Holiday</label>
            <div class="col-sm-4" >
            <input type="checkbox" <?php if($ts_topic->countdays_present_sh=="on"){ echo "checked";}else{echo "";}  ?> onclick="return false" >
            </div>
            </div>
            <br>
            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Leave with pay</label>
            <div class="col-sm-4" >
            <input type="checkbox" <?php if($ts_topic->countdays_present_lwp=="on"){ echo "checked";}else{echo "";}  ?> onclick="return false" >
            </div>
            </div>
       </div>
      </div>
      </div>
 <div class="col-md-4">
    <div class="panel panel-danger">
      <div class="panel-heading"><strong> count if NOT present on</strong>
      </div>
       <div class="panel-body">
            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Rest Day</label>
            <div class="col-sm-4" >
            <input type="checkbox" <?php if($ts_topic->countdays_not_present_rd=="on"){ echo "checked";}else{echo "";}  ?> onclick="return false" >
            </div>
            </div>
            <br>
            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Regular Holiday</label>
            <div class="col-sm-4" >
            <input type="checkbox" <?php if($ts_topic->countdays_not_present_rh=="on"){ echo "checked";}else{echo "";}  ?> onclick="return false" >
            </div>
            </div>
            <br>
            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Special Holiday</label>
            <div class="col-sm-4" >
            <input type="checkbox" <?php if($ts_topic->countdays_not_present_sh=="on"){ echo "checked";}else{echo "";}  ?> onclick="return false" >
            </div>
            </div>
            <br>
            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Leave with pay</label>
            <div class="col-sm-4" >
            <input type="checkbox" <?php if($ts_topic->countdays_not_present_lwp=="on"){ echo "checked";}else{echo "";}  ?> onclick="return false" >
            </div>
            </div>
       </div>
      </div>
      </div>
<?php 
}else{
echo "";
}
?> 
<!--//=======================================Rest day auto match schedule-->
<?php 
//countdays_present_option: counting option

if(($ts_topic->rd_auto_match_sched_allow<>"not_included")
  AND($ts_topic->rd_auto_match_sched_base_sched_at<>"not_included")
  AND($ts_topic->rd_auto_match_sched_match_at<>"not_included")) {
?>

<?php
echo '  <div class="col-md-12">
    <div class="panel panel-success">
      <div class="panel-heading"><strong> <a target="_blank"  href="'.base_url().'app/time_shift_table"><i class="fa fa-arrow-right"></i> Shift Reference Table</a></strong></div>
  </div>
  </div>';
?>
 <div class="col-md-4">
    <div class="panel panel-danger">
      <div class="panel-heading"><strong> allow schedule matching</strong>
      </div>
       <div style="text-align: center;" class="panel-body">
            <div class="form-group"   >
            <div class="col-sm-12" >
           <?php if($ts_topic->rd_auto_match_sched_allow=="1"){echo "YES";}else{echo "NO";} ?>
            </div>
            </div>
       </div>
    </div>
  </div>
 <div class="col-md-4">
    <div class="panel panel-danger">
      <div class="panel-heading"><strong> base schedule at</strong>
      </div>
       <div style="text-align: center;" class="panel-body">
            <div class="form-group"   >
            <div class="col-sm-12" >
           <?php if($ts_topic->rd_auto_match_sched_base_sched_at=="actual_in"){echo "Actual IN";}else{echo "actual OUT";} ?>
            </div>
            </div>
       </div>
    </div>
  </div>
 <div class="col-md-4">
    <div class="panel panel-danger">
      <div class="panel-heading"><strong> match at</strong>
      </div>
       <div style="text-align: center;" class="panel-body">
            <div class="form-group"   >
            <div class="col-sm-12" >
           <?php if($ts_topic->rd_auto_match_sched_match_at=="rd_hol_shift_table"){echo "Rest day auto match schedule references";}else{echo "Regular Shift Table";} ?>
            </div>
            </div>
       </div>
    </div>
  </div>

<?php 
}else{
echo "";
}
?> 

<!--//=======================================Case treated as halfday by the system due to count undertime as halfday absent policy  -->
<?php 
//ut_display_to_dtr : display undertime on dtr for representation purpose ?
//ut_include_to_occurence : include to counting of undertime occurrence ?
if(($ts_topic->ut_display_to_dtr<>"not_included")AND($ts_topic->ut_include_to_occurence<>"not_included")) {

?>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-6 control-label">display undertime on dtr for representation purpose ? </label>
        <div class="col-sm-6" >
  <input readonly type="text" class="form-control" value="<?php echo $ts_topic->ut_display_to_dtr;?>">
        </div>
    </div>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-6 control-label">include to counting of undertime occurrence ?</label>
        <div class="col-sm-6" >
  <input readonly type="text" class="form-control" value="<?php echo $ts_topic->ut_include_to_occurence;?>">
        </div>
    </div>
<?php 
}else{
echo "";
}
?> 
<!--//=======================================Case treated as halfday by the system due to count late as halfday absent policy  -->
<?php 
//late_display_to_dtr : display late on dtr for representation purpose ?
//late_include_to_occurence : include to counting of late occurrence ?
if(($ts_topic->late_display_to_dtr<>"not_included")AND($ts_topic->late_include_to_occurence<>"not_included")) {

?>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-6 control-label">display late on dtr for representation purpose ? </label>
        <div class="col-sm-6" >
  <input readonly type="text" class="form-control" value="<?php echo $ts_topic->late_display_to_dtr;?>">
        </div>
    </div>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-6 control-label">include to counting of late occurrence ?</label>
        <div class="col-sm-6" >
  <input readonly type="text" class="form-control" value="<?php echo $ts_topic->late_include_to_occurence;?>">
        </div>
    </div>
<?php 
}else{
echo "";
}
?>   


        </div><!-- main -->
      </div><!-- main -->

    </div> <!-- main -->
    

<?php   } //main ?>