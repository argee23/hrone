                    <thead>
                      <tr>
                        <th>Company Name</th>
                        <th>Event Title</th>
                        <th>Event Start </th>
                        <th>Event End</th>
                        <th>Status</th>
                        <th>Options</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($nae as $nae){ ?>

                      <tr>
                        <td><?php echo $nae->company_name?></td>
                        <!-- <td><a tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="focus" title="Event Description" data-content="<?php echo nl2br($nae->event_description) ?>"><?php echo $nae->event_title?></a></td> -->
                        <td>
                          <a role="button" data-html="true" data-toggle="collapse" data-target="#info_<?php echo $nae->id?>"><?php echo $nae->event_title?></a>
                          <div id="info_<?php echo $nae->id?>" class="collapse">
                          <p class="text-success">
                          <?php echo nl2br($nae->event_description) ?>
                          </p>
                          </div>
                        </td>
                        <td><?php echo $nae->event_start?></td>
                        <td><?php echo $nae->event_end?></td>
                        <!-- <td><?php if($nae->status == 1){ echo "Active";} else { echo "Inactive"; } ?></td>   -->
                        
                        <td>
                        <?php 
                        if($nae->event_start && $nae->event_end < date('Y-m-d H:i:s')) { 
                          echo "<strong class='text-danger'>Completed</strong>";
                        } 
                        else if ($nae->event_start < date('Y-m-d H:i:s') && $nae->event_end > date('Y-m-d H:i:s')){
                          echo "<strong class='text-success'>Ongoing</strong>";
                        }
                        else{
                          echo "<strong class='text-info'>Upcoming</strong>";
                        } 
                        ?>
                        </td>

                        <td>

                            <i <?php echo $this->session->userdata('check_edit_pay_type_icon'); ?> class="hidden"  data-toggle="tooltip" data-placement="left" title="Edit" onclick="editNewsAndEvents('<?php echo $nae->id?>')"></i>
                            <a href="<?php echo base_url()?>app/file_maintenance/delete_news_and_events/<?php echo $nae->id ?>"><i  <?php echo $this->session->userdata('check_del_pay_type_icon');?> class="hidden"  data-toggle="tooltip" data-placement="left" title="Delete <?php echo $nae->company_name?>'s <?php echo $nae->event_title ?>?" onclick="return confirm('Are you sure to delete <?php echo addslashes($nae->company_name)."\'s"." ".addslashes($nae->event_title) ?> event?')"></i></a>
                             
                        </td>
                      </tr>
                      <?php }?>
                     
                    </tbody>