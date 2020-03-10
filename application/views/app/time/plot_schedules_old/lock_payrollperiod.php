 <?php if(!empty($msg))
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>'.$msg.'</center></n></div>';
            } 
            else{}?>

<table class="table table-bordered" id="table_lockplotting">
          <thead>
           <tr  class="success">
              <th style="width:5%;">ID</th>
              <th style="width:20%;">Group Name</th>
              <th style="width:15%;">Paycode</th>
              <th style="width:10%;">Cutoff</th>
              <th style="width:15%;">From</th>
              <th style="width:15%;">To</th>
              <th style="width:10%;">No. of Days</th>
              <th style="width:10%;">Locked</th>
              <th style="width:5%;">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($company_payroll_period as $pp) {
            $df= date("F", mktime(0, 0, 0, $pp->month_from, 10))." ".$pp->day_from." ".$pp->year_from;
            $dt= date("F", mktime(0, 0, 0, $pp->month_to, 10))." ".$pp->day_to." ".$pp->year_to;
            $pp_date = $df." to ".$dt;
            if ($pp->cut_off=="1"){
              $ext="st";
            }else if($pp->cut_off=="2"){
              $ext="nd";
            }else if($pp->cut_off=="3"){
              $ext="rd";
            }else{
              $ext="th";
            }
            ?>
            <tr>
              <td><?php echo $pp->id?></td>
              <td><?php echo $pp->group_name?></td>
              <td><?php echo $pp->pay_code?></td>
              <td><?php echo $pp->cut_off.$ext." Cut off";?></td>
              <td><?php echo $df;?></td>
              <td><?php echo $dt;?></td>
              <td><?php echo $pp->no_of_days?></td>
              <td><?php if($pp->lock_plotting_of_sched==1){ echo "<n class='text-success'>yes</n>"; } else{ echo "<n class='text-danger'>no</n"; }?></td>
              <td>
                 <?php 
                    if($pp->lock_plotting_of_sched=="1"){ ?> <i class="btn btn fa fa-lock fa-lg" style="color:<?php echo $system_defined_icons->icon_disable_color;?>" onclick="IsLock('0','<?php echo $pp->id?>','<?php echo $pp_date?>');" aria-hidden='true' data-toggle='tooltip' title='Click to unlock the payroll period'></i> <?php } 
                    else{?> <i class="btn btn fa fa-unlock fa-lg"  style="color:<?php echo $system_defined_icons->icon_enable_color;?>" onclick="IsLock('1','<?php echo $pp->id?>','<?php echo $pp_date?>');" aria-hidden='true' data-toggle='tooltip' title='Click to lock the payroll period'></i> <?php } 
                     ?>
              </td>
            </tr>
          <?php } ?>
          </tbody>
</table>
          