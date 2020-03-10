                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Company</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Date Applied</th>
                        <th>Status</th>
                        <th  style="width: 20%;">Option</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($show_applicants as $app){ 
                        $app_stat=$app->ApplicationStatus;
                          ?>                      
                      <tr style="color:<?php echo $app->color_code;?>">

<td>
      <?php 
      $company_id=$app->company_id; 
      $c=$this->general_model->get_company_info($company_id);
      if(!empty($c)){
        echo $c->company_name;
      }else{
        echo "company not exist";
      }
$blink_me='';
$prof_checker=$this->general_model->check_applicant_profile_seen($app->employee_info_id);

if(!empty($prof_checker)){

    $display_app_stat="resume viewed.";
    $blink_me='';


            if(empty($app->ApplicationStatus)){
            $cd=date("Y-m-d");

            if($cd==$app->date_applied){
            $display_app_stat="Application Today";
            $blink_me='';
            }


            }else{
            $display_app_stat=$app->status_title;
            }


}else{
     $display_app_stat="<span class='blink_text'>unread</span>";  // applicants that admin did not change status yet and of previous dates applicant
    $blink_me='blink_text';

            if(empty($app->ApplicationStatus)){
            $cd=date("Y-m-d");

            if($cd==$app->date_applied){
            $display_app_stat="Application Today";
            $blink_me='';
            }


            }else{
            $display_app_stat=$app->status_title;
            }
}
      ?>
</td>
                        <td><?php
 echo '<a href="'.base_url().'app/recruitment/applicant_profile/'.$app->employee_info_id.'" data-toggle="tooltip"  title="Click to view resume of '.$app->fullname.' " role="button" class="btn btn-default btn-xs"><i class="fa fa-arrow-right text-danger '.$blink_me.' "></i> &nbsp;&nbsp;'.$app->fullname.'</a>';
                        ?></td>
                        <td><?php echo $app->job_title?></td>
                        <td><?php echo $app->date_applied;?></td>
                        <td>
                        <?php 
echo $display_app_stat;
                       ?>
                      </td>
                        <td>
                        <?php

                  if(!empty($app_active_optionList)){
                  foreach($app_active_optionList as $stat_opts){

if($stat_opts->app_stat_id=="1"){
?>
<a data-toggle="collapse" data-target="#seemore_<?php echo $app->employee_info_id."_".$app->job_id."_".$app->date_applied?>" class="btn btn-info btn-xs"><?php echo $stat_opts->status_title;?></a><br>

<div id="seemore_<?php echo $app->employee_info_id."_".$app->job_id."_".$app->date_applied?>" class="collapse">


  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/save_for_interview/<?php echo $app->employee_info_id;?>" >
  <input type="hidden" name="for_int_name" value="<?php echo$app->fullname;?>">
    <div class="box-body" style="border:1px solid #ccc;">
      <div class="form-group">
        <label for="interview_date" class="col-sm-12">When</label>
        <div class="col-sm-12">

 
          <input type="date" class="form-control" name="interview_date" id="interview_date" placeholder="Interview Date" required
          value="<?php 
          if($app->ApplicationStatus=="1"){
echo $app->interview_date;
}
          ?>">
        </div>
      </div>
                  <div class="form-group">
            <label class="col-sm-12">Time</label>
              <div class="col-sm-12">
<select class="form-control" name="interview_time_h" required>
<?php
 if($app->ApplicationStatus=="1"){?>
<option value="<?php echo substr($app->interview_time, 0, -3);?>"><?php 
echo substr($app->interview_time, 0, -3);
?></option>
<?php  
}
for ($x = 0; $x <= 23; $x++) {
  $num_padded = sprintf("%02d", $x);
  echo "<option value='$num_padded'> $num_padded </option>";
}
?> 
</select>
<select class="form-control" name="interview_time_m" required>
<?php if($app->ApplicationStatus=="1"){?>
<option value="<?php echo substr($app->interview_time, 3, 2);?>"><?php 
echo substr($app->interview_time, 3, 2);
?></option>
<?php  
}
for ($x = 0; $x <= 60; $x++) {
   $num_padded = sprintf("%02d", $x);
  echo "<option value='$num_padded'> $num_padded </option>";
}
?> 
</select>

              </div>
            </div>
      <div class="form-group">
        <label for="invite_message" class="col-sm-12">Message</label>
        <div class="col-sm-12">
          <textarea type="date" class="form-control" name="invite_message" cols="15" rows="2" placeholder="Message" required><?php if($app->ApplicationStatus=="1"){ echo $app->invite_message; }?></textarea>
        </div>
      </div>

          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>



</div>

<?php
}
else if($stat_opts->app_stat_id=="4"){ // blocked applicants
?>
<a data-toggle="collapse" data-target="#blocked_<?php echo $app->employee_info_id."_".$app->job_id."_".$app->date_applied?>" class="btn btn-danger btn-xs"><?php echo $stat_opts->status_title;?></a><br>

<div id="blocked_<?php echo $app->employee_info_id."_".$app->job_id."_".$app->date_applied?>" class="collapse">


  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/save_for_blocked/<?php echo $app->employee_info_id;?>/<?php echo $app->applicant_id;?>/<?php echo $app->job_id;?>" >
  <input type="hidden" name="for_int_name" value="<?php echo$app->fullname;?>">
    <div class="box-body" style="border:1px solid #ccc;">
       <div class="form-group">
        <label for="blocked_reason" class="col-sm-12">Reason</label>
        <div class="col-sm-12">
          <textarea type="date" class="form-control" name="blocked_reason" cols="15" rows="2" placeholder="State Reason Why" required><?php if($app->ApplicationStatus=="4"){ echo $app->blocked_reason; }?></textarea>
        </div>
      </div>

              </div>
        
 

          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>
<?php
}
else{


                  echo anchor('app/recruitment/change_applicant_status/'.$app->applicant_id.'/'.$app->job_id.'/'.$stat_opts->app_stat_id,'<i style="color:'.$stat_opts->color_code.'" class="fa fa-cog" > '.$stat_opts->status_title.'</i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'change status to : '.$stat_opts->status_title.'?','onclick'=>"return confirm('Are you sure you want to change status to : ".$stat_opts->status_title." (".$app->fullname.")?')"))."<br>"; 
}                  

                  }
                  } else{
                  echo "no application status option(s) setup yet."; 
                  }                       

                        ?>
                      </td>
                      </tr>
                       
                    <?php }?>
                    </tbody>
                  </table>