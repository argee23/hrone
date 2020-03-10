<div class="col-md-12" style="overflow: scroll;"> 
<table class="table table-hover" id="generate_report_table">
            <thead>
                <tr class="danger">
                    <?php foreach($crystal_report as $cc){?>
                        <th><?php echo $cc->label;?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach($details as $d){?>
                <tr>
                    <?php foreach($crystal_report as $cc){
                      $val = $cc->field;
                      if($val=='fullname')
                      {
                        $data = $this->applicant_interview_result_report_model->get_applicant_details('fullname',$d->employee_info_id);
                      } 
                      else if($val=='first_name')
                      {
                        $data = $this->applicant_interview_result_report_model->get_applicant_details('first_name',$d->employee_info_id);
                      }
                      else if($val=='middle_name')
                      {
                        $data = $this->applicant_interview_result_report_model->get_applicant_details('middle_name',$d->employee_info_id);
                      }
                      else if($val=='last_name')
                      {
                        $data = $this->applicant_interview_result_report_model->get_applicant_details('last_name',$d->employee_info_id);
                      }
                      else
                      {
                         $data = $d->$val;
                      } 
                     
                    ?>
                        <td><?php echo $data;?></td>

                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
</table>
</div>
   