
            <table id="salary_approvers" class="col-md-12 table table-hover table-striped">
                <thead>
                  <tr  class="success">
                    <th style="width:5%;">ID</th>
                    <th style="width:15%;">Name</th>
                    <th style="width:15%;">Company ID</th>
                    <th style="width:15%;">Classification</th>
                    <th style="width:15%;">Location</th>
                      <th style="width:15%;">Department</th>
                    <th style="width:15%;">Section</th>
                    <th style="width:15%;">Subsection</th>
                    <th style="width:5%;">Approval Level</th>
                  </tr>
                </thead>
                <tbody> 
                <?php foreach($approver_details as $ad)
                {?>
                  <tr>
                    <td><?php echo $ad->id;?></td>
                    <td><?php echo $ad->fullname;?></td>
                    <td><?php echo $ad->company_name;?></td>
                    <td><?php echo $ad->classification;?></td>
                    <td><?php echo $ad->location_name;?></td>
                    <td><?php echo $ad->dept_name;?></td>
                    <td><?php echo $ad->section_name;?></td>
                    <td><?php echo $ad->subsection_name;?></td>
                    <td><?php 
                      $x=$ad->approval_level;
                       if($x=="1"){
                            $ext="st";
                          }else if($x=="3"){
                            $ext="rd";
                          }else if($x=="2"){
                            $ext="nd";
                          }else{
                            $ext="th";
                          }
                        echo $ad->approval_level.$ext." Approver "?></td>
                  </tr>
                <?php } ?>
                </tbody>
       </table>  