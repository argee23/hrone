
<?php $cid = $this->uri->segment("4");
$company_id=$cid;
$cinfo=$this->general_model->get_company_info($company_id);
$cname=$cinfo->company_name;
?>
  <div class="col-md-12">
  <div class="box box-default">
  <div class="box-header">
  <strong>
                        <a class="btn btn-default btn-xs" data-toggle="collapse" href="#collapse_add" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa fa-plus fa-sm text-danger"></i> Add Position
                        </a>
    </strong>

  </div>
  <div class="box-body">

<!-- Add Position (s) -->

  <div class="col-md-12 collapse" id="collapse_add">
    <div class="panel panel-info">
  <div class="panel-heading"><strong>Add Position- <?php echo $cname;?></strong> </div> 
      <div class="panel-body">

  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/save_position/<?php echo $this->uri->segment("4");?>">
      <div class="form-group">
        <label for="position" class="col-sm-2 control-label">Position</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="position" id="position" placeholder="Position" required>
        </div>
      </div>
                      <div class="form-group">
                  <label for="industry" class="col-sm-2 control-label">Industry / Nature of Business</label>
                 <div class="col-sm-10">
                              
                  <select name="industry" class="form-control" >
                  <?php
                    foreach ($job_specList as $job_specs){
                    echo "<option value='".$job_specs->param_id."'>".$job_specs->cValue."</option>";
                    }
                  ?>
                  </select> 
                </div>
                </div>
            <div class="form-group">
        <label for="job_description" class="col-sm-2 control-label">Job Description</label>
        <div class="col-sm-10">
          <textarea type="text" class="form-control" name="job_description" id="job_description" placeholder="Job Description"></textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="job_qualification" class="col-sm-2 control-label">Qualification</label>
        <div class="col-sm-10">
          <textarea type="text" class="form-control" name="job_qualification" id="job_qualification" placeholder="Qualification"></textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="salary" class="col-sm-2 control-label">Salary</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="salary" id="salary" placeholder="Salary">
        </div>
      </div>
      <div class="form-group">
        <label for="job_vacancy" class="col-sm-2 control-label">Vacancy (slot)</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="job_vacancy" id="job_vacancy" placeholder="Vacancy (slot)" required>
        </div>
      </div>
      <div class="form-group">
        <label for="hiring_start" class="col-sm-2 control-label">Hiring Start</label>
        <div class="col-sm-10">
          <input type="date" class="form-control" name="hiring_start" id="hiring_start"  required>
        </div>
      </div>
      <div class="form-group">
        <label for="hiring_end" class="col-sm-2 control-label">Hiring Closed</label>
        <div class="col-sm-10">
          <input type="date" class="form-control" name="hiring_end" id="hiring_end" required>
        </div>
      </div>      
<!--           <div class="form-group"   >
      <label for="pay_date" class="col-sm-2 control-label ">Company</label>
        <div class="col-sm-10" >
    <?php 
      //     foreach($companyList as $select_comp){
      //       $company_id=$select_comp->company_id;

      // if($company_id==$cid){
      //   $checked="checked";
      // }else{
      //   $checked="";
      // }

      //       echo '<input type="checkbox" name="company_id[]" value="'.$company_id.'" '.$checked.'>&nbsp;'.$select_comp->company_name."<br>";
      //     }
        ?>
        </div>
    </div> -->
          <div class="form-group"   >
      <label for="pay_date" class="col-sm-2 control-label ">Requirements</label>
        <div class="col-sm-10" >
    <?php 
          foreach($act_req_List as $act_req){
            $req_id=$act_req->req_id;
            echo '<input type="checkbox" name="req_id[]" value="'.$req_id.'" checked>&nbsp;'.$act_req->item_name."<br>";
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
            echo '<input type="checkbox" name="ques_id[]" value="'.$ques_id.'" checked>&nbsp;'.$qq->question."<br>";
          }
        ?>
        </div>
    </div>   
   <div class="form-group">
      <label for="hypoQues_id" class="col-sm-2 control-label ">Hypothetical Question(s)</label>
        <div class="col-sm-10">
    <?php 
          foreach($act_hypothetical_preQueList as $hq){
            $hypoQues_id=$hq->id;
            echo '<input type="checkbox" name="hypoQues_id[]" value="'.$hypoQues_id.'" checked>&nbsp;'.$hq->question."<br>";
          }
        ?>
        </div>
    </div>
    <div class="form-group">
      <label for="hypoQues_id" class="col-sm-2 control-label ">Multiple Choice Question(s)</label>
        <div class="col-sm-10">
    <?php 
          foreach($act_mc_preQueList as $mc){
            $mcQues_id=$mc->id;
            echo '<input type="checkbox" name="mcQues_id[]" value="'.$mcQues_id.'" checked>&nbsp;'.$mc->question."<br>";
          }
        ?>
        </div>
    </div>   
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
  </form>
               
      </div>
    </div>
  </div>

<!-- Position (s) -->

  <div class="col-md-12">
  <div class="panel panel-info">
  <div class="panel-heading">
  <strong>Job Vacancy

  </strong> 
  </div>
  <div class="panel-body">
  
    <table id="" class="table table-bordered table-striped">
      <thead>
      <tr>
      <th width="83%">Position</th>
      <th width="10%">Status</th>
      <th width="7%">Option</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach($jobsList as $jobs){?>
      <tr>
      <td><b><?php echo $jobs->job_title; ?></b>
<button data-toggle="collapse" data-target="#seemore_<?php echo $jobs->job_id."_".$cid;?>" class="btn-info pull-right">see more</button>

<div id="seemore_<?php echo $jobs->job_id."_".$cid;?>" class="collapse">
Slot: <button class="btn-default"><?php echo $jobs->job_vacancy; ?></button><br>
Salary: <button class="btn-danger"><?php echo $jobs->salary; ?></button><br>
Job Description: <button class="btn-default"><?php echo nl2br($jobs->job_description); ?></button><br>
Job Qualification: <button class="btn-default"><?php echo nl2br($jobs->job_qualification); ?></button><br>
<span class="label label-primary">Hiring Start : <?php echo $jobs->hiring_start; ?></span><br>
<span class="label label-warning">Closed On : <?php echo $jobs->hiring_end; ?></span>
</div>
      </td>
      <td><?php
 $cd=date('Y-m-d');
$company_id=$cid;

if($jobs->hiring_end<=$cd){
  $automatic_close_job=$this->recruitment_model->closed($jobs->job_id,$company_id);
}else{
  $automatic_open_job=$this->recruitment_model->open($jobs->job_id,$company_id);
}


       if($jobs->status_per_company=="1"){ 
    echo $op = anchor('app/recruitment/to_close_job/'.$jobs->job_id.'/'.$cid,'<i class="fa fa-power-off fa-lg text-success"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Click to closed?' ))." open";

        }else {

    echo $cl = anchor('app/recruitment/to_open_job/'.$jobs->job_id.'/'.$cid,'<i class="fa fa-power-off fa-lg text-danger"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Click to open?' ))." closed";

           } ?></td>
  
      <td>
      <?php
      //delete
  echo $delete = anchor('app/recruitment/delete_position/'.$jobs->job_id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-right"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Permanently Delete?','onclick'=>"return confirm('Are you sure you want to permanently delete ".$jobs->job_title."?')"));
    echo $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="Edit" onclick="editPosition('.$jobs->company_id.','.$jobs->job_id.')"></i>';
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