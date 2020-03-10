
  <table class="table table-bordered" id="view_plotted_sm">
            <thead>
             <tr  class="success">
                <th style="width:15%;">Manager ID</th>
                <th style="width:25%;">Manager Name</th> 
                <th style="width:40%;">Group Name/s</th>
                <th style="width:10%;">Status</th>
                <th style="width:5%;">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($sec_mngrs as $sm) { 
              $group_list = $this->plot_schedules_model->get_section_managers_group($sm->manager);
              ?>
              <tr>
                <td><?php echo $sm->manager?></td>
                <td><?php echo $sm->first_name." ".$sm->last_name?></td>
                <td>
                    <?php if(empty($group_list)){} else{ echo "<a data-toggle='collapse' data-target='#demo".$sm->id."' style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view the list of group/s'> ".count($group_list)." Group/s</a>"; }?><br>
                    <div id="demo<?php echo $sm->id?>" class="collapse">
                    <?php if(empty($group_list)){ echo "No group found."; } else { $i = 1; foreach ($group_list as $gl) {
                        $count = $this->plot_schedules_model->get_group_members($gl->id,'count');
                      ?>
                          <?php echo "<a  href='".base_url('app/plot_schedules/sm_group_members')."/".$gl->id."' aria-hidden='true' title='Click to view members'  data-toggle='modal' data-target='#modal'><span class='badge'>".$count."</span></a> / <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='".$gl->group_name."' onclick='sm_view_group_schedule(".$gl->id.");'> ".substr($gl->group_name,0,50)."</a>
                          <br>";?>
                    <?php $i++; } } ?>
                    </div>
                </td>
                <td><?php if($sm->InActive==1){ echo "<n class='text-danger'>Not Active</n>"; } else{ echo "<n class='text-success'>Active</n>"; }?> </td>
                <td>
                   <a><?php if(empty($group_list)){ echo "---"; } else{ ?><i  class="btn btn fa fa-<?php echo $system_defined_icons->icon_view;?> fa-lg pull-left" style="color:<?php echo $system_defined_icons->icon_view_color;?>" onclick='view_group_list(<?php echo $sm->manager?>);'></i></a> <?php } ?>
                </td>
              </tr>
            <?php } ?>  
            </tbody>
  </table> 
          

 <div id="modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
       <div class="modal-content modal-md">
       </div>
    </div>
</div>