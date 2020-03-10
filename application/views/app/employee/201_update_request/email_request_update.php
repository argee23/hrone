
<div class="col-md-12">
<div class="col-md-2"></div>
<div class="col-md-8" style="margin-top:10px;margin-left: auto;margin-right: auto;">
<h3>System Links : <?php echo base_url();?></h3>
<?php if($stat_all=='Done'){}else{ ?><h3>Status : <a style="color:#1e90ff;"><?php echo $stat_all?></a></h3><?php } ?>


  <table border="0" width="100%" cellpadding="0" cellspacing="0">
  <thead>
  <tr>
    <th colspan="4" style="text-align: center">
   <br>
   <strong>
  <br><h4>Status of Requested 201 Update</h4></strong>
    </th>
  </tr>
  <tr>
    <th colspan="4"></th>
  </tr>
  <tr>
    <th colspan="4" style="text-align: center"><h2></h2></th>
  </tr>
  <tr>
    <th colspan="4"></th>
  </tr>
  </thead>
  <tbody style="font-size: 10px;">
   <tr>
    <td width="20%"><p style="color: #1e90ff;">EMPLOYEE ID:</p></td><td width="40%"><?php echo $me->employee_id?></td>    
    <td ><p style="color: #1e90ff;">DATE UPDATED:</p></td>  
    <td>
      <?php 
        $month=substr($date_created, 5,2);
        $day=substr($date_created, 8,2);
        $year=substr($date_created, 0,4);
        echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
      ?>
    </td>   
  </tr>
  <tr>
    <td>
    <p style="color: #1e90ff;">EMPLOYEE NAME:</p></td><td><?php echo $me->first_name." ".$me->last_name?></td>    
    <td>
    <p style="color: #1e90ff;">LOCATION:</p></td><?php echo $me->location_name?><td>
    </td>
  </tr> 
  <tr>
    <td><p style="color: #1e90ff;">POSITION:</p></td>  
    <td><?php echo $me->position_name?></td>    
    <td><p style="color: #1e90ff;">DEPARTMENT:</p></td>  
    <td><?php echo $me->dept_name?></td>   
  </tr> 
 <tr>
    <td width="20%"><p style="color: #1e90ff;">CLASSIFICATION:</p></td>  
    <td width=""><?php echo $me->classification?></td>    
    <td width="20%"><p style="color: #1e90ff;">SECTION:</p></td>  
    <td width=""><?php echo $me->section_name?> </td>    
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  <tr>
        <td colspan="1"><center><b>Topic Title</b></center></td>  
        <td><center><b>Action</b></center></td> 
        <td><center><b>Status</b></center></td>    
        <td><center><b>Date Updated</b></center></td>   
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  
     <?php $statt = $this->employee_201_model->topics_status($request_id); 
        foreach($statt as $s) { ?>
    <tr cellpadding="1" cellspacing="1">
        <td align='center'><p class="text-primary" ><?php echo $s->topic_title?></p></td>
        <td align='center'>
            <?php $statt_action = $this->employee_201_model->topics_status_action($s->request_topic_id);             
                  foreach($statt_action as $stat){ echo "<n>".$stat->action."</n><br>";}?>
        </td>
        <td align='center'>
            <?php $statt_action = $this->employee_201_model->topics_status_action($s->request_topic_id); 
                  foreach($statt_action as $stat){ echo " <n class='text-success'>".$stat->status."</n><br>";} ?>
        </td>
        <td align='center'>
            <?php $statt_action = $this->employee_201_model->topics_status_action($s->request_topic_id); 
                  foreach($statt_action as $stat){ if(empty($stat->date_updated) || $stat->status=='Pending'){ echo "Not yet Updated"."<br>"; }else{ echo " <n class='text-success'>".$stat->date_updated."</n>"."<br>"; } } ?>
        </td>
    </tr>
  <?php } ?>

  </tbody>
</table>

</div>
  <div  class="col-md-2" ></div>
</div>
<div class="col-md-2"></div>
</div>
