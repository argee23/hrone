
                                <table class="table table-hover" id="file_maintenance">
                                    <thead>
                                      <tr class="danger">
                                        <th>ID</th>
                                        <th>Company Name</th>
                                        <th>Type</th>
                                        <th>Tiltle / Topic</th>
                                         <th>Type</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php  foreach($file_maintenance as $f){?>
                                        <tr>
                                          <td><?php echo $f->id;?></td>
                                          <td><?php echo $f->company_name;?></td>
                                          <td><?php echo $f->training_type;?></td>
                                          <td><?php echo $f->training_title;?></td>
                                          <td><?php echo $f->type;?></td>
                                          <td><?php echo $f->date_created;?></td>
                                          <td>
                                                  <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="edit_fincoming_trainingsseminars(<?php echo $f->id;?>);"  aria-hidden='true' data-toggle='tooltip' title='Update Settings'><i class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>

                                                 <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="view_fincoming_trainingsseminars(<?php echo $f->id;?>);" aria-hidden='true' data-toggle='tooltip' title='View Settings'><i class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>

                                                 <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="delete_fincoming_trainings(<?php echo $f->id;?>);" aria-hidden='true' data-toggle='tooltip' title='Delete Incoming Trainings and Semianr'><i class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>

                                          </td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>