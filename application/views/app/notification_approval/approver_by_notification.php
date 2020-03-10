 <?php if($this->session->flashdata('success_deleted') AND $action_=='deleted')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Company ID - '.$flash_id.' New Form Approver is Successfully Deleted.</center></n></div>';
            } 
            else{}?>
 <table id="salary_approvers" class="col-md-12 table table-hover table-striped">
                <thead>
                  <tr  class="success">
                    <th style="width:5%;">ID</th>
                    <th style="width:15%;">Name</th>
                    <th style="width:10%;">Notification</th>
                    <th style="width:15%;">Company ID</th>
                    <th style="width:10%;">Section</th>
                    <th style="width:10%;">Subsection</th>
                    <th style="width:5%;">Approval Level</th>
                    <th style="width:15%;">Classification</th>
                    <th style="width:15%;">Location</th>
                    <th style="width:5%;">Action</th>
                  </tr>
                </thead>
                <tbody> 
                  <?php foreach($details as $d){?>
                    <tr>
                        <td><?php echo $d->idd;?></td>
                        <td><?php echo $d->fullname;?></td>
                        <td><?php echo $d->form_name;?></td>
                        <td><?php echo $d->company_name;?></td>
                        <td><?php echo $d->section_name;?></td>
                        <td><?php echo $d->subsection_name;?></td>
                        <td>
                          <?php 
                              $x=$d->approval_level;
                               if($x=="1"){
                                    $ext="st";
                                  }else if($x=="3"){
                                    $ext="rd";
                                  }else if($x=="2"){
                                    $ext="nd";
                                  }else{
                                    $ext="th";
                                  }
                              echo $d->approval_level.$ext." Approver "?>
                        </td>
                        <td><?php echo $d->classification_name;?></td>
                        <td><?php echo $d->location_name;?></td>
                        <td>
                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  onclick="delete_notif_oneapprover('<?php echo $company;?>','<?php echo $d->idd;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Approver'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                        </td>
                    </tr>
                  <?php } ?>
                </tbody>
       </table>  