 <table id="notif_approver" class="col-md-12 table table-hover table-striped">
                <thead>
                  <tr  class="success">
                    <th style="width:15%;">Name</th>
                    <th style="width:15%;">Classification</th>
                    <th style="width:15%;">Location</th>
                    <th style="width:15%;">Section</th>
                    <th style="width:15%;">Subsection</th>
                    <th style="width:10%;">Approval Level</th>
                    <th style="width:10%;">Action</th>
                  </tr>
                </thead>
                <?php foreach ($details as $d) {

                  if(!empty($d->date_deleted)){}else{?>
                  <tr>
                    <td><?php echo $d->first_name." ".$d->last_name;?></td>
                    <td><?php echo $d->cname;?></td>
                    <td><?php echo $d->location_name;?></td>
                    <td><?php echo $d->section_name;?></td>
                    <td><?php echo $d->subsection_name;?></td>
                    <td><?php echo $d->approval_level;?></td>
                    <td>

                     <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="approver_action('delete','<?php echo $d->iddd;?>','<?php echo $notif;?>','<?php echo $company;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Approver' ><i  class="fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>

                    <?php if($d->ia==1){ ?>
                          <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' onclick="approver_action('enable','<?php echo $d->iddd?>','<?php echo $notif;?>','<?php echo $company;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to disable approver'><i  class="fa fa-<?php echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                          <?php }else{  ?>
                          <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>' onclick="approver_action('disable','<?php echo $d->iddd?>','<?php echo $notif;?>','<?php echo $company;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to enable approver'><i  class="fa fa-<?php echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                    <?php }?>
                  </td>
                      </tr>
                    <?php } } ?>
                <tbody>
               
                </tbody>
 </table>  