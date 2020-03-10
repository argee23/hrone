        <?php   if($this->session->flashdata('success_deleted') AND $action_=='deleted')
              { 
                echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>ID - '.$id.' is Successfully Deleted.</center></n></div>';
              } 
              else{}?>

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
                    <th>Action</th>
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
                    <td>
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  onclick="delete_one_approver('<?php echo $company;?>','<?php echo $ad->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Approver'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                    </td>
                  </tr>
                <?php } ?>
                </tbody>
       </table>  