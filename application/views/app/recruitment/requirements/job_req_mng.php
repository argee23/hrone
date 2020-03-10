
<?php $cid = $this->uri->segment("4");
$company_id=$cid;
$cinfo=$this->general_model->get_company_info($company_id);
$cname=$cinfo->company_name;
?>
  <div class="col-md-12">
  <div class="box box-default">
  <div class="box-header">
  <strong>
    </strong>

  </div>
  <div class="box-body">


<!-- Position (s) -->

  <div class="col-md-12">
  <div class="panel panel-info">
  <div class="panel-heading">
  <strong>Job Requirements

  </strong> 
  </div>
  <div class="panel-body">
  
    <table id="" class="table table-bordered table-striped">
      <thead>
      <tr>
      <th width="20%">Position</th>
      <th width="50">Requirements</th>
      <th width="15%">Job Status</th>
      <th width="7%">Option</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach($jobsList as $job){?>
      <tr>

      <td><b><?php echo $job->job_title; ?></b>
      <td>
    <?php 
echo $jobs_not_allow=anchor('app/recruitment/to_not_allow_upload_all/'.$job->job_id,'<i class="fa fa-power-off fa-lg text-danger"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Not Allowed to upload?' ))." All : Not Allowed &nbsp;&nbsp;&nbsp;";

echo $jobs_allow=anchor('app/recruitment/to_allow_upload_all/'.$job->job_id,'<i class="fa fa-power-off fa-lg text-success"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Not Allowed to upload?' ))." All : Allowed";
echo "<br><br>";
          foreach($act_req_List as $act_req){
            $req_id=$act_req->req_id;
$may_check=$this->general_model->list_req_of_job($job->job_id,$req_id);
                 if (!empty($may_check)){
                 foreach($may_check as $checkfile){
                   if($checkfile->is_uploadable=="1"){
                      $fileuploadable="uploadable";
                      $cl = anchor('app/recruitment/to_not_allow_upload/'.$job->job_id.'/'.$req_id,'<i class="fa fa-power-off fa-lg text-danger"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Not Allowed to upload?' ));
                   }else{
                      $fileuploadable="not uploadable";
                      $cl = anchor('app/recruitment/to_allow_upload/'.$job->job_id.'/'.$req_id,'<i class="fa fa-power-off fa-lg text-success"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Allowed to upload?' ));                      
                   }
                  echo $cl ." (<i>".$fileuploadable."</i>)&nbsp;&nbsp;";
                 }
                  $applicable="checked";
                  echo '<input type="checkbox" name="req_id[]" value="'.$req_id.'" '.$applicable.' disabled>&nbsp;'.$act_req->item_name."<br>";
                  }else{
                  $applicable="";
                  }            
          }
        ?>
      </td>
      <td><?php
 $cd=date('Y-m-d');
$company_id=$cid;

if($job->hiring_end<=$cd){
  $automatic_close_job=$this->recruitment_model->closed($job->job_id,$company_id);
}else{
  $automatic_open_job=$this->recruitment_model->open($job->job_id,$company_id);
}

       if($job->status_per_company=="1"){ 
    echo " open";

        }else {

    echo " closed";

           } ?></td>
  
      <td>
      <?php

    echo $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="Edit" onclick="editPosition('.$job->job_id.','.$job->company_id.')"></i>';
      ?>

      </td>

      </tr>
      <?php } ?>  
      </tbody>
    </table>      
  </div>
  </div>
  </div>
    
  </div>
  </div>
  </div>