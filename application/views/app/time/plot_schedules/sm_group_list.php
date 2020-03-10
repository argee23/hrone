<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Group List</h4></ol>
<div class="col-md-12">
    <div class="col-md-2"><center><label>Company :</label></center></div>
    <div class="col-md-4">
     <u> <n class="text-danger"><?php echo $manager_details->company_name?></n></u>
    </div>

    <div class="col-md-2"><center><label>Section Manager :</label></center></div>
    <div class="col-md-4">
      <u><n class="text-danger"><?php echo $manager_details->first_name." ".$manager_details->last_name;?></n></u>
    </div>

     
   <br><br>
    <div class="box box-default" class='col-md-12'></div>
</div>
  
<div class="col-md-12" style="padding-top:10px;" id='sm_section_mngr_grp'>
      <table class="table table-bordered" id="sm_mngr_group">
            <thead>
             <tr  class="success">
                <th style="width:10%;">Group ID</th>
                <th style="width:50%;">Group Name</th> 
                <th style="width:15%;">Date Created</th>
                <th style="width:5%;">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php $i=1; foreach ($sm_grp as $gp) {
               $count = $this->plot_schedules_model->get_group_members($gp->id,'count');?>
              <tr>
                <td><?php echo $gp->id?></td>
                <td> <?php echo "<a  href='".base_url('app/plot_schedules/sm_group_members')."/".$gp
                  ->id."' aria-hidden='true' title='Click to view members'  data-toggle='modal' data-target='#modal'><span class='badge'>".$count."</span></a> 
                          ";?> / <?php echo $gp->group_name?></td>
                <td><?php echo $gp->date_created?></td>
                <td><center><i class="fa fa-calendar text-info" style="cursor: pointer;" onclick="sm_view_group_schedule(<?php echo $gp->id?>)"></i></center></td>
              </tr>
            <?php $i++; } ?>
            </tbody>
  </table> 
      <!-- <button class="btn btn-success pull-right" onclick="get_section_manager(<?php //echo $manager_details->company_id; ?>)">BACK</button>   -->
</div>              
<div id="modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
       <div class="modal-content modal-md">
       </div>
    </div>
</div>