
  <table class="col-md-12 table table-hover" id="req_report">
    <thead>
      <tr class="danger">
        <th>No.</th>
        <th>Company Name</th>
        <th>Position</th>
        <th>Slot</th>
        <th>Current Available</th>
       <?php foreach($status as $stat){?>
        <th><?php echo $stat->status_title;?></th>
       <?php } ?> 
      </tr>
    </thead>
    <tbody>
     <?php $i=1; foreach($results as $res){?>
      <tr>
        <td><?php echo $i;?></td>
        <td><?php echo $res->company_name;?></td>
        <td> <?php echo $res->job_title;?></td>
        <td><?php echo $res->job_vacancy;?></td>
        <td>
          <?php 
              $get_hired_by_job = $this->recruitments_model->get_hired_by_job($res->job_id,$res->company_id);
              echo $available = $res->job_vacancy - $get_hired_by_job;
          ?>
        </td>
         <?php foreach($status as $stat){?>
        <td>
            <?php $get_analytics = $this->recruitments_model->get_num_status($res->job_id,$res->company_id,$stat->id); ?>
             
            <a data-toggle='collapse' data-target='#<?php echo $res->job_id.$stat->id;?>' style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view applicant'><span class='badge' <?php if(count($get_analytics)>0){ ?>   style="background-color:#ff0000;"  <?php }?> ><?php echo count($get_analytics);?></span></a>
            <div class="collapse in" id="<?php echo $res->job_id.$stat->id;?>">
                 <?php 
                   foreach($get_analytics as $ga)
                      { echo '<a href="'.base_url().'app/recruitments/applicant_profile/'.$ga->employee_info_id.'/'.$ga->applicant_id.'/'.$ga->job_id."/".$ga->company_id."/".$employer_type.'" data-toggle="tooltip"  title="Click to view resume of '.$ga->fullname.' " role="button" class="btn btn-default btn-xs"><i class="fa fa-arrow-right text-danger  "></i> &nbsp;&nbsp;'.$ga->fullname.'</a>';
                       }
                   ?>
           </div>

        </td>
       <?php } ?> 
      </tr>
    <?php $i++; } ?>
    </tbody>
  </table>