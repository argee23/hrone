<?php if($type=='active'){?>

  
     <table class="col-md-12 table table-hover" id="table_requirement">
                      <thead>
                          <tr class="danger">
                              <th>No.</th>
                              <th>Employer</th>
                              <th>Details</th>
                              <th>Type</th>
                              <th>Registration Date</th>
                              <th>Date Approved</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                            <?php $i=1; 
                                 foreach ($details as $row) {
                                  $pending_req= $this->serttech_recruitment_setting_model->total_pending_requirements($row->id);
                                  ?>
                                    <tr>
                                          <td><?php echo $i;?></span></td>
                                          <td><?php echo $row->company_name;?></td>
                                          <td><?php echo $row->company_name;?></td>
                                          <td><?php if($row->type=='free_trial'){ echo "Free Trial"; } else{ echo "Package"; }?></td>
                                          <td><?php echo $row->date_registered;?></td>
                                          <td><?php echo $row->date_approved;?></td>
                                          <td><?php echo $row->status;?></td>
                                          <td>
                                                  <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to View Employers details' onclick="view_details_employer_requirements('view_employer_details','view_employer','<?php echo $row->employer_id;?>','All');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                                                 
                                                  <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to View Requirement Status' onclick="view_details_employer_requirements('view_employer_req','view_req','<?php echo $row->id;?>','All');"><i  class="fa fa-files-o fa-lg  pull-left"></i></a>

                                                
                                          </td>
                                    </tr>

                            <?php $i++;  } ?>
                      </tbody>
                  </table>                   

<?php }
else{?>
           
                 <table class="col-md-12 table table-hover" id="table_requirement">
                      <thead>
                          <tr class="danger">
                              <th>No.</th>
                              <th>Employer</th>
                              <th>Details</th>
                              <th>Type</th>
                              <th>Registration Date</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                            <?php $i=1; 
                                 foreach ($details as $row) {
                                  $pending_req= $this->serttech_recruitment_setting_model->total_pending_requirements($row->id);
                                  ?>
                                    <tr>
                                          <td><span class="badge"><?php echo $pending_req;?></span></td>
                                          <td><?php echo $row->company_name;?></td>
                                          <td><?php echo $row->company_name;?></td>
                                          <td><?php if($row->type=='free_trial'){ echo "Free Trial"; } else{ echo "Package"; }?></td>
                                          <td><?php echo $row->date_registered;?></td>
                                          <td><?php echo $row->status;?></td>
                                          <td>
                                                  <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to View Employers details' onclick="view_details_employer_requirements('view_employer_details','view_employer','<?php echo $row->employer_id;?>','All');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                                                  <?php if($row->status!='pending')
                                                  {?>
                                                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to View Requirement Status' onclick="view_details_employer_requirements('view_employer_req','view_req','<?php echo $row->id;?>','All');"><i  class="fa fa-files-o fa-lg  pull-left"></i></a>

                                                  <?php } else{?>
                                                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update Requirement Status' onclick="view_details_employer_requirements('view_employer_req','Update_req','<?php echo $row->id;?>','All');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                                  <?php }?>
                                          </td>
                                    </tr>

                            <?php $i++;  } ?>
                      </tbody>
                  </table>
            
<?php } ?>
