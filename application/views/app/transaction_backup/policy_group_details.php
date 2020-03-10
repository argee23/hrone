 
<div class="col-md-12">
    <div class="col-md-5">
        <div class="col-md-12"><n class='text-danger'><center>Company :</center> </n></div>
        <div class="col-md-12"><u><center><?php echo $details->company_name?></center></u></div>
    </div>
    <div class="col-md-4">
        <div class="col-md-12"><n class='text-danger'><center>Group Name :</center> </n></div>
        <div class="col-md-12"><u><center><?php echo $details->group_name?></center></u></div>
    </div>
    <div class="col-md-3">
        <div class="col-md-12"><n class='text-danger'><center>Policy Type : </center></n></div>
        <div class="col-md-12"><u><center><?php echo $details->cValue?></center></u></div>
    </div>
</div><br><br><br>
 <div class="box box-danger" class='col-md-12'></div>
 <br>
 <table class="table table-bordered" id="blocked_leave"  style="margin-top:20px;">
    <thead>
        <tr class="success">
            <th>Employee ID</th>
            <th>Name</th>
            <th>Company </th>
            <th>Department</th>
            <th>Section</th>
           <!--  <th>Action</th> -->
        </tr>
    </thead>
    <tbody>
    <?php foreach ($group_details as $gd) {?>
        <tr>
          <td><?php echo $gd->employee_id?></td>
          <td><?php echo $gd->name?></td>
          <td><?php echo $gd->company_name?></td> 
          <td><?php echo $gd->dept_name?></td>
          <td><?php echo $gd->section_name?></td>
          <!-- <td><a class='fa fa-trash' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='delete_group_member(<?php //echo $gd->member_id?>,<?php //echo $group?>)'></a></td> -->
        </tr>
    <?php } ?>

   </tbody>
 </table>

<button class="btn btn-danger pull-right" onclick="del_group_policy(<?php echo $group?>);">DELETE GROUP</button>
<button class="btn btn-success pull-right" onclick="update_group_policy(<?php echo $group?>,<?php echo $details->company_id?>);" style='margin-right:10px;'>UPDATE GROUP</button>