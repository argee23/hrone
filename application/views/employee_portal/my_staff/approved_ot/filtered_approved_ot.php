
                     <table class="table table-hover" id="overtime">
                        <thead>
                            <tr class='danger'>
                                <th>ID</th>
                                <th>Group Name</th>
                                <th>Date</th>
                                <th>Reason</th>
                                <th>Date Plotted</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php $i=1; foreach ($plotted as $p) {?>
                            <tr>
                                <td><?php echo $p->id; ?></td>
                                <td><?php echo $p->group_name; ?></td>
                                <td><?php echo $p->date; ?></td>
                                <td><?php echo $p->reason; ?></td>
                                <td><?php echo $p->date_created; ?></td>
                                <td>

                                      <center>

                                          <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'   onclick='edit_group_approved_ot("<?php echo $p->id;?>","<?php echo $p->date;?>")' aria-hidden='true' data-toggle='tooltip' title='Click to Update Group Name'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>

                                          <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick='view_approved_ot("<?php echo $p->id;?>","<?php echo $p->date;?>")' aria-hidden='true' data-toggle='tooltip' title='Click to View Plotted OT Hour/s'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                                          <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick='delete_approved_ot("<?php echo $p->id;?>","<?php echo $p->date;?>")' aria-hidden='true' data-toggle='tooltip' title='Click to Delete Plotted OT Hour/s'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                         
                                           <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_add_color;?>' target="_blank" aria-hidden='true' data-toggle='tooltip' title='Click to Add Employee with approved ot hours'    href="<?php echo base_url().'employee_portal/overtime_management_section_mngr_approved_ot/add_member_approved_ot';?>/<?php echo $p->id;?>/<?php echo $p->date;?>"  style='display: none;'><i  class="fa fa-<?php  echo $system_defined_icons->icon_add;?> fa-lg  pull-left"></i></a>


                                           <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>'  onclick='upload_member_approved_ot("<?php echo $p->id;?>","<?php echo $p->date;?>","<?php echo $p->group_name;?>")' aria-hidden='true' data-toggle='tooltip' title='Click to Upload Employee with approved ot hours'  ><i  class="fa fa-upload fa-lg  pull-left"></i></a>


                                      </center>

                                </td>
                          </tr>
                          <?php $i++; } ?>
                          </tbody>
                      </table>