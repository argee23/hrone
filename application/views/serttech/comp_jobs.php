
<?php $cid = $this->uri->segment("4");
$company_id=$cid;
$cinfo=$this->general_model->get_company_info($company_id);
$cname=$cinfo->company_name;
?>
 <table id="example2" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th width="15%">Company</th>
        <th width="20%">Position</th>
        <th width="20%">Posted to the public Status </th>
        <th width="40%">Option
<?php
echo '<a href="'.base_url().'serttech/mypublic_recruitment/approve_all/'.$cid.'" class="btn btn-success btn-sm pull-right" ><i class="fa fa-check text-success"></i>Approve All</a>'.'&nbsp;&nbsp;&nbsp;';
echo '<a href="'.base_url().'serttech/mypublic_recruitment/disapprove_all/'.$cid.'" class="btn btn-danger btn-sm pull-right" ><i class="fa fa-remove text-danger"></i>Disapprove All</a>'.'&nbsp;&nbsp;&nbsp;';
?>


        </th>
      </tr>
      </thead>
    <tbody>

<?php 
$alljobsList= $this->serttech_login_model->company_jobs($company_id);
echo '<a href="#" class="btn btn-success btn-sm" >Jobs Posted : '.count($alljobsList).'</a>';
foreach($alljobsList as $jobs){
$job_specs=$this->recruitment_model->getjob_specs($jobs->job_specialization);
$thejob_specizalization=$job_specs->cValue;

if($this->session->userdata('is_serttech_logged_in')){
  if($jobs->admin_verified=="1"){
      $admin_verification_result="<td class='text-success'>displayed to the public</td>";
  }else if($jobs->admin_verified=="waiting"){
      $admin_verification_result="<td class='text-warning'>waiting for admin verification</td>";
  }else if($jobs->admin_verified=="0"){
       $admin_verification_result="<td class='text-danger'>not allowed to be displayed to public</td>";
  }else{
        $admin_verification_result="<td>code error";
  }
}else{
  $admin_verification_result='';
}
        ?>
      <tr>
      <td><?php echo $jobs->company_name; ?></td>

      <td><b><?php echo $jobs->job_title; ?></b>

<button data-toggle="collapse" data-target="#seemore_<?php echo $jobs->job_id."_".$jobs->company_id;?>" class="btn-info pull-right">see more</button>

<div id="seemore_<?php echo $jobs->job_id."_".$jobs->company_id;?>" class="collapse">
Slot: <button class="btn-default"><?php echo $jobs->job_vacancy; ?></button><br>
Salary: <button class="btn-danger"><?php echo $jobs->salary; ?></button><br>
Job Specialization: <button class="btn-default"><?php echo $thejob_specizalization; ?></button><br>
Job Description: <button class="btn-default"><?php echo nl2br($jobs->job_description); ?></button><br>
Job Qualification: <button class="btn-default"><?php echo nl2br($jobs->job_qualification); ?></button><br>
<span class="label label-primary">Hiring Start : <?php echo $jobs->hiring_start; ?></span><br>
<span class="label label-warning">Closed On : <?php echo $jobs->hiring_end; ?></span>
</div>
      </td>   

       <?php 
 $cd=date('Y-m-d');
if($jobs->hiring_end<=$cd){
  $automatic_close_job=$this->recruitment_model->closed($jobs->job_id,$jobs->company_id);
}else{
  $automatic_open_job=$this->recruitment_model->open($jobs->job_id,$jobs->company_id);
}
       echo $admin_verification_result; ?>
      <td>
<?php
if ($jobs->admin_verified=="waiting"){
$color="text-danger";
$todo="approve_job";
$bg="";

}elseif($jobs->admin_verified=="1"){
$color="text-success";
$todo="disapprove_job";
$bg="class='text-danger'";
}elseif($jobs->admin_verified=="0"){
$color="text-danger";
$todo="approve_job";
$bg="class='text-danger'";
}else{
$color="";
$todo="";
$bg="";
}

echo  $enable_disable= '<a href="'.base_url().'serttech/mypublic_recruitment/'.$todo.'/'.$jobs->job_id.'"  " ><i class="fa fa-power-off '.$color.' pull-right"></i></a>'.'<br>';
?>
      </td>

      </tr>
      <?php } ?>  
      </tbody>
    </table>   