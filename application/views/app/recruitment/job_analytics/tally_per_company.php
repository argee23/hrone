                  <table id="example1" class="table table-bordered table-striped">
      <thead>
      <tr>
      <th >Company : </th>
      <th >Position</th>
      <th >Slot</th>
      <th >Current Available</th>
<?php
              if(!empty($app_active_optionList)){
                  foreach($app_active_optionList as $stat_opts){
?>
<th><?php echo $stat_opts->status_title; ?></th>
<?php
                 } }else{
                  }
?>
      </tr>
      </thead>
      <tbody>
      <?php foreach($job_tally_per_comp as $jobs){?>
      <tr>
      <td><?php echo $jobs->company_name; ?></td>
      <td><b><?php echo $jobs->job_title; ?></b> </td>
     <td><?php echo $jobs->job_vacancy; ?></td>
     <td><?php
       $jobs->company_id; 
$hired_app=$this->general_model->hired_applicantList($jobs->company_id,$jobs->job_id);
$array_items = count($hired_app);
echo $jobs->job_vacancy-$array_items;

      ?></td>
<?php
              if(!empty($app_active_optionList)){
                  foreach($app_active_optionList as $stat_opts){
?>
<td><?php 


$app_stat=$this->general_model->appStatus_List($jobs->company_id,$jobs->job_id,$stat_opts->app_stat_id);
$array_items2 = count($app_stat);

 if($array_items2=="0"){
  $change_bg="";
 }else{
  $change_bg='style="background-color:#ff0000;"';
 }
echo '<a data-toggle="collapse" data-target="#seemore_'.$jobs->company_id.'_'.$jobs->job_id.'_'.$stat_opts->app_stat_id.'" ><span class="badge" '.$change_bg.'>'.$array_items2.'</span></a><br>
<div id="seemore_'.$jobs->company_id.'_'.$jobs->job_id.'_'.$stat_opts->app_stat_id.'" class="collapse">';

foreach($app_stat as $app){
  //echo $app->fullname."<br>";

   echo '<a href="'.base_url().'app/recruitment/applicant_profile/'.$app->employee_info_id.'" data-toggle="tooltip"  title="Click to view resume of '.$app->fullname.' " role="button" class="btn btn-default btn-xs"><i class="fa fa-arrow-right text-danger"></i> &nbsp;&nbsp;'.$app->fullname.'</a><br>';
}


echo '</div>';


?></td>
<?php
              } }else{
                  }
?>
      </tr>
      <?php } ?>  
      </tbody>
    </table>   