<div class="well">
<!-- form start -->

<?php if($job->admin_verified=="1"){
  $disable_title_edit='readonly';
} else{
  $disable_title_edit='';
}

$company_id=$this->uri->segment("4");
$cn=$this->general_model->get_company_info($company_id);
$company_name=$cn->company_name;
?>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/modify_position/<?php echo $this->uri->segment("4");?>/<?php echo $disable_title_edit?>" >



    <div class="box-baody">

    <div class="panel panel-warning">
  <div class="panel-heading"><strong>Edit Position - <?php echo $company_name;?></strong> </div>
      <div class="panel-body">

      <div class="form-group">
        <label for="position" class="col-sm-2 control-label">Position</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="position" id="position" placeholder="Position" value="<?php echo $job->job_title?>" required <?php echo $disable_title_edit;?>>
        </div>
      </div>
            <div class="form-group">
        <label for="job_description" class="col-sm-2 control-label">Job Description</label>
        <div class="col-sm-10">
          <textarea type="text" class="form-control" name="job_description" id="job_description" placeholder="Job Description"><?php echo $job->job_description?></textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="job_qualification" class="col-sm-2 control-label">Qualification</label>
        <div class="col-sm-10">
          <textarea type="text" class="form-control" name="job_qualification" id="job_qualification" placeholder="Qualification"><?php echo $job->job_qualification?></textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="salary" class="col-sm-2 control-label">Salary</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="salary" id="salary" placeholder="Salary" value="<?php echo $job->salary?>">
        </div>
      </div>
      <div class="form-group">
        <label for="job_vacancy" class="col-sm-2 control-label">Vacancy (slot)</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="job_vacancy" id="job_vacancy" placeholder="Vacancy (slot)" value="<?php echo $job->job_vacancy?>" >
        </div>
      </div>
      <div class="form-group">
        <label for="hiring_start" class="col-sm-2 control-label">Hiring Start</label>
        <div class="col-sm-10">
          <input type="date" class="form-control" name="hiring_start" id="hiring_start"  required value="<?php echo $job->hiring_start?>">
        </div>
      </div>
      <div class="form-group">
        <label for="hiring_end" class="col-sm-2 control-label">Hiring Closed</label>
        <div class="col-sm-10">
          <input type="date" class="form-control" name="hiring_end" id="hiring_end" required value="<?php echo $job->hiring_end?>">
        </div>
      </div>      
<!--           <div class="form-group"   >
      <label for="pay_date" class="col-sm-2 control-label ">Company</label>
        <div class="col-sm-10" >
    <?php 
//           foreach($companyList as $select_comp){
//             $company_id=$select_comp->company_id;
// $may_check=$this->general_model->list_company_of_job($job->job_id,$company_id);
//                  if (!empty($may_check)){
//                   $applicable="checked";
//                   }else{
//                   $applicable="";
//                   }

//             echo '<input type="checkbox" name="company_id[]" value="'.$company_id.'" '.$applicable.'>&nbsp;'.$select_comp->company_name."<br>";
//           }
        ?>
        </div>
    </div> -->
          <div class="form-group"   >
      <label for="pay_date" class="col-sm-2 control-label ">Requirements</label>
        <div class="col-sm-10" >
    <?php 
          foreach($act_req_List as $act_req){
            $req_id=$act_req->req_id;
$may_check=$this->general_model->list_req_of_job($job->job_id,$req_id);
                 if (!empty($may_check)){
                 foreach($may_check as $checkfile){
                   if($checkfile->is_uploadable=="1"){
                      $fileuploadable="uploadable";
                   }else{
                      $fileuploadable="not uploadable";
                   }
                  echo "(<i>".$fileuploadable."</i>)&nbsp;&nbsp;";
                 }
                  $applicable="checked";
                  }else{
                  $applicable="";
                  }

            echo '<input type="checkbox" name="req_id[]" value="'.$req_id.'" '.$applicable.'>&nbsp;'.$act_req->item_name."<br>";
          }
        ?>
        </div>
    </div>
          <div class="form-group"   >
      <label for="qua_question" class="col-sm-2 control-label ">Qualifying Questions</label>
        <div class="col-sm-10" >
    <?php 
          foreach($act_qualifying_questionsList as $qq){
            $ques_id=$qq->id;
$may_check=$this->general_model->list_qua_ques_of_job($job->job_id,$ques_id);
                 if (!empty($may_check)){
                  $applicable="checked";
                  }else{
                  $applicable="";
                  }

            echo '<input type="checkbox" name="ques_id[]" value="'.$ques_id.'" '.$applicable.'>&nbsp;'.$qq->question."<br>";
          }
        ?>
        </div>
    </div>
          <div class="form-group">
      <label for="hypoQues_id" class="col-sm-2 control-label ">Hypothetical Question(s)</label>
        <div class="col-sm-10">
    <?php 
          foreach($act_hypothetical_preQueList as $hq){
            $pre_ques_id=$hq->id;
$may_check=$this->general_model->list_pre_ques_of_job($job->job_id,$pre_ques_id);
                 if (!empty($may_check)){
                  $applicable="checked";
                  }else{
                  $applicable="";
                  }
            echo '<input type="checkbox" name="hypoQues_id[]" value="'.$pre_ques_id.'" '.$applicable.'>&nbsp;'.$hq->question."<br>";
          }
        ?>
        </div>
    </div>
          <div class="form-group">
      <label for="hypoQues_id" class="col-sm-2 control-label ">Multiple Choice Question(s)</label>
        <div class="col-sm-10">
    <?php 
          foreach($act_mc_preQueList as $mc){
            $pre_ques_id=$mc->id;
$may_check=$this->general_model->list_pre_ques_of_job($job->job_id,$pre_ques_id);
                 if (!empty($may_check)){
                  $applicable="checked";
                  }else{
                  $applicable="";
                  }            
            echo '<input type="checkbox" name="mcQues_id[]" value="'.$pre_ques_id.'" '.$applicable.'>&nbsp;'.$mc->question."<br>";
          }
        ?>
        </div>
    </div>    
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Modify</button>

               
      </div>
    </div>


    </div><!-- /.box-body -->





  </form>
  </div>