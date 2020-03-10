<?php require_once(APPPATH.'views/include/calendar.php');?>
<div class="col-md-12">
     <div class="col-md-4">
        <div class="panel panel-default" style="height: 450px;">
            <div class="col-md-12 panel-heading" style="height: auto;">
              <label>Group Name:</label><br>
              <n><u><?php echo "<a  href='".base_url('app/plot_schedules/sm_group_members')."/".$group->id."' aria-hidden='true' title='Click to view members'  data-toggle='modal' data-target='#modal'> 
                          ";?><?php echo $group->group_name?></a></u></n>
            </div>
           <br>
           <div id="ip_emp_profile">
            <div class="col-md-12" style="margin-top: 10px;overflow-y: scroll;height:230px;">
           <?php  foreach ($g_members as $gm) {?>
                   <a style="cursor: pointer;" onclick='get_emp_all_schedule("<?php echo $gm->employee_id?>","<?php echo $group->id?>");'><i class="fa fa-user margin-r-5"></i><n class="text-danger"><u> <?php echo $gm->first_name." ".$gm->last_name;?></u></n></a><br>
                    
            <?php } ?>
              </div>
           </div>
         <span class="badge"></span>
        </div>
     </div>
      <?php foreach($color_code as $cc){?>
    <input type="hidden" id="<?php echo $cc->color_code;?>" value="<?php echo $cc->identification;?>">
    <?php } ?>
    <div class="col-md-8" id="calendar_option">
      
      <div class="col-md-12" id="sm_calendar">
      </div>
      
    </div>

   
            
