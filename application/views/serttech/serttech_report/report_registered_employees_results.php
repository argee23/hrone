<br><br>
<table id="generate_report_result" class="table table-bordered table-striped">
          <thead>
            <tr class="danger">
            <?php if($crystalreport=='default'){?>
              <th>Employer</th>
              <th>Account Type</th>
              <th>Account Status</th>
              <th>Registration Date</th>
              <th>End Date</th>
            <?php } else { foreach($crystal_report as $cc){?>
                <th><?php echo $cc->label;?></th>
            <?php } } ?>
            </tr>
          </thead>
          <tbody>
          <?php foreach($details as $d){ 
          ?>
            <tr>
              <?php if($crystalreport=='default'){?>
                <td><?php echo $d->company_name;?></td>
                <td><?php if($d->active_usage_type=='free_trial'){ echo "Free Trial"; } else{ echo $d->customer_type." customers ( ".$d->no_of_months." validity license with".$d->no_of_jobs." job/s )"; } ?></td>
                <td><?php if($d->is_usage_active==1){ echo "Active"; } else{ echo "Expired"; }?></td>
                <td><?php echo $d->date_registered;?></td>
                <td><?php echo $d->date_end;?></td>
              <?php } else { foreach($crystal_report as $cc){
                $dataa = $cc->field;
                if($dataa=='is_usage_active'){ $v = $d->$dataa; if($val==1){ $val='Active'; } else { $val='Expired'; } }
                else if($dataa=='industry')
                {
                  $val = $this->serttech_recruitment_reports_model->get_industry_data($d->$dataa);
                }
                else{ $val = $d->$dataa; }
               
              ?>
                  <td><?php echo $val;?></td> 
              <?php } }?>
            </tr>
          <?php } ?>
          </tbody>
</table>