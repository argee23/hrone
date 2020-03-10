 <div class="col-md-12" style="margin-top: 20px;">
            <button class="btn btn-danger btn-xs pull-right" onclick="filter_notifications();">Click to filter</button><br>
             <h4 class="text-danger" style="font-weight: bold;text-align: center;">Filtered Reports Result</h4>
              
              <div class="col-md-12" style="margin-top: 10px;">
                
                 <table class="table table-bordered" id="filter">
                    <thead>
                     <tr  class="danger">
                        <th>Doc No</th>
                        <th>Doc Type</th>
                        <th>Employee ID</th>
                        <th>Company ID</th>
                        <th>Date Viewed</th>
                        <th>Date Send</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($details as $d)
                        {?>
                        <tr>
                          <td><a href="<?php echo base_url();?>app/issue_notifications/view_notif_form/<?php echo $d->doc_no."/".$d->company_id."/".$d->employee_id; ?>" target="_blank" style="cursor:pointer;"><?php echo $d->doc_no;?></a></td></td>
                          <td><?php echo $form_details->form_name;?></td>
                          <td><?php echo $d->employee_id;?></td>
                          <td><?php echo $d->company_id;?></td>
                          <td><?php  echo $d->time_viewed;?></td>
                          <td><?php echo $d->time_acknowledge;?></td>
                        </tr>
                       <?php }?>
                    </tbody>
                </table>    

              </div>

            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
 </div>         