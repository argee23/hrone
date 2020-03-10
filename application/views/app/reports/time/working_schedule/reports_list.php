
        <?php echo $message; //echo $this->uri->segment('4');?>
      <?php echo validation_errors(); ?>

            <br><ol class="breadcrumb">
                <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Time Summary Reports | Report List 
          <!-- <button class="btn btn-success pull-right" style="margin-top: -8px;" onclick="add_reports('<?php //echo $this->uri->segment('4');?>');">ADD REPORTS</button>-->


<!-- //===== System General Icons -->
  <a onclick="add_reports('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add REPORTS">
  <?php
  echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
  ?>
  </a>



                </h4>
            </ol><br>
             <table id="table_home" class="table table-hover table-striped">
                <thead>
                  <tr>
                     <th style="width:15%;">Report ID</th>
                    <th style="width:30%;">Report Name</th>
                    <th style="width:40%;">Report Description</th>
                    <th style="width:15%;">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($report as $row){ ?>
                  <tr>
                    <td><?php echo $row->report_id?></td>
                    <td><?php echo $row->report_name?></td>
                    <td><?php echo $row->report_desc?></td>
                    <td>
                        <!-- 
                       <a class='fa fa-trash' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!' onclick="deleteReport('<?php //echo $row->report_id?>')"></a> | -->

                       <!--  <a class='fa fa-pencil-square-o' aria-hidden='true' data-toggle='tooltip' title='Click to edit!' onclick="updateReport('<?php //echo $this->uri->segment('4').'/'.$row->report_id?>')"></a> |  

                      <a class='fa fa-arrow-circle-right' aria-hidden='true' data-toggle='tooltip' title='Click to view record!' onclick="viewReport('<?php //echo $this->uri->segment('4').'/'.$row->report_id?>')"></a>
                       -->

                   <a  class='fa fa-<?php echo $system_defined_icons->icon_delete.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_delete_color.';"';?> data-toggle="tooltip" data-placement="left" title="Delete Report" href="<?php echo site_url('app/reports_time/deleteReport/'. $row->report_id.'/'.$row->report_type.''); ?>" onClick="return confirm('Are you sure you want to permanently delete report type?')"></a> |

                   <i class='fa fa-<?php echo $system_defined_icons->icon_edit.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_edit_color.';"';?> data-toggle='tooltip' data-placement='left' title='Edit Report details' onclick="updateReport('<?php echo $this->uri->segment('4').'/'.$row->report_id?>')"></i> | 


                 <i class='fa fa-<?php echo $system_defined_icons->icon_view.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_view_color.';"';?> data-toggle='tooltip' data-placement='left' title='View Details' onclick="viewReport('<?php echo $this->uri->segment('4').'/'.$row->report_id?>')"></i>&nbsp; 






                    </td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>