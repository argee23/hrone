<table id="generate_report_result" class="table table-bordered table-striped">
          <thead>
            <tr class="danger">
            <?php if($crystalreport=='default'){?>
              <th>Employer</th>
              <th>Position</th>
              <th>Comment</th>
              <th>Status</th>
              <th>Date Send</th>
              <th>Date Update Status</th>
            <?php } else { foreach($crystal_report as $cc){?>
              <th><?php echo $cc->label;?></th>
            <?php } }  ?>
            </tr>
          </thead>
          <?php foreach($details as $d){
          ?>
            <tr>
            <?php if($crystalreport=='default'){?>
              <td><?php echo $d->company_name;?></td>
              <td><?php echo $d->job_title;?></td>
              <td><?php echo $d->comment;?></td>
              <td><?php if($d->admin_verified==1){ echo "approved"; } else{ echo $d->admin_verified; }?></td>
              <td><?php echo $d->date_posted;?></td>
              <td><?php echo $d->date_approved;?></td>
            <?php } else { foreach($crystal_report as $cc){ 
              $dataa = $cc->field; 
              if($dataa=='industry')
              {
                  $val = $this->serttech_recruitment_reports_model->get_industry_data($d->$dataa);
              }
              else if($dataa=='job_specialization')
              {
                 $val = $this->serttech_recruitment_reports_model->get_industry_data($d->$dataa);
              }
              else if($dataa=='admin_verified')
              {
                $val = $d->$dataa; 
                if($val==1){ $val = 'approved'; } else if($val=='waiting'){ $val='pending'; } else{  $val = $d->$dataa;  }
              }
              else
              {
                  $val = $d->$dataa; 
              }
            ?>
              <td><?php echo $val;?></td>
            <?php } } ?>
            </tr>
          <?php } ?>
          <tbody>
          </tbody>
</table>
