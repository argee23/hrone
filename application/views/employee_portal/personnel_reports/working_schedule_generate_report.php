<div class="col-md-12" style="width: 100%;overflow: scroll;">


  <br>
 <h4 class="text-danger"><center>Personnel Schedule Report </center>
  </h4>
  <br><br>


  <table class="col-md-12 table table-bordered" id="table_p_ot_all">
      <thead>
        <tr class="success">
           <?php foreach ($report_fields as $rf){ ?>
                <th><?php echo $rf->title?></th>
           <?php } ?>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($details as $ddd) {?>
        <tr>
          <?php foreach ($report_fields as $rf){ 
               $ff = $rf->field;
               if($ff=='yy')
               {
                $year = date('', strtotime($ddd->date));
                $field = $year;
               }
               else if($ff=='mm')
               {
                $month = date('m', strtotime($ddd->date));
                $field = $month;
               }
               else if($ff=='dd')
               {
                $day = date('d', strtotime($ddd->date));
                $field = $day;
               }
               else if($ff=='date_plotted')
               {
                  if($ddd->group_id==0 || empty($ddd->group_id)){ $field= $ddd->date_plotted; } else{ $field= $ddd->date_created; }
               }
               else
               {
                $field=$ddd->$ff;
               }
              
            ?>
                <td>
                  <?php 
                      if($ff=='group_id')
                      {
                          if($field==0 || empty($field)){ echo "individual plotting"; } else{ echo $field; }
                      }
                      else
                      {
                         echo $field;
                      }
                  ?>
                </td>
           <?php } ?>
        </tr>
      <?php } ?>
      </tbody>
      </table>
 <?php if($employees=='All' || $employees=='individual')
{
  ?>
<div class="pull-right">
  <h5 class="text-info"><i><b><a style="cursor: pointer;" data-toggle="collapse" data-target="#d1">Click here for more report options:</a></b></i></h5>
    <div id="d1" class="collapse">
        <a href="<?php echo base_url()?>/employee_portal/personnel_reports/working_schedule_filter_view_others/<?php echo $forms_filter[0].'/'.$forms_filter[1].'/'.$forms_filter[2].'/'.$forms_filter[3].'/'.$forms_filter[4].'/'.$forms_filter[5].'/'.$forms_filter[6].'/'.$forms_filter[7].'/'.$forms_filter[8].'/'.$forms_filter[9].'/'.$forms_filter[10].'/'.$forms_filter[11]."/".'by_date';?>" target="_blank" class='btn btn'><n class='text-danger'><u><b>view working schedules by date.</b></u></a>
        <br>
        <?php if($employees=='individual'){}
        else{?>
        <a href="<?php echo base_url()?>/employee_portal/personnel_reports/working_schedule_filter_view_others/<?php echo $forms_filter[0].'/'.$forms_filter[1].'/'.$forms_filter[2].'/'.$forms_filter[3].'/'.$forms_filter[4].'/'.$forms_filter[5].'/'.$forms_filter[6].'/'.$forms_filter[7].'/'.$forms_filter[8].'/'.$forms_filter[9].'/'.$forms_filter[10].'/'.$forms_filter[11]."/".'by_emp';?>" target="_blank" class='btn btn'><n class='text-danger'><u><b> view working schedules by employee id.</b></u></a>
        <?php } ?>
    </div>
</div>
<?php } else{ if($forms_filter[11]=='plotted_sm'){ ?>

<div class="pull-right">
  <h5 class="text-info"><i><b><a style="cursor: pointer;" data-toggle="collapse" data-target="#d1">Click here for more report options:</a></b></i></h5>
    <div id="d1" class="collapse">

<a href="<?php echo base_url()?>/employee_portal/personnel_reports/working_schedule_filter_view_others/<?php echo $forms_filter[0].'/'.$forms_filter[1].'/'.$forms_filter[2].'/'.$forms_filter[3].'/'.$forms_filter[4].'/'.$forms_filter[5].'/'.$forms_filter[6].'/'.$forms_filter[7].'/'.$forms_filter[8].'/'.$forms_filter[9].'/'.$forms_filter[10].'/'.$forms_filter[11]."/".'by_group';?>" target="_blank" class='btn btn'><n class='text-danger'><u><b>view the plotted working schedule by group.</b></u></a>

</div>
</div>

<?php } else{ ?>
<div class="pull-right">
  <h5 class="text-info"><i><b><a style="cursor: pointer;" data-toggle="collapse" data-target="#d1">Click here for more report options:</a></b></i></h5>
    <div id="d1" class="collapse">

<a href="<?php echo base_url()?>/employee_portal/personnel_reports/working_schedule_filter_view_others/<?php echo $forms_filter[0].'/'.$forms_filter[1].'/'.$forms_filter[2].'/'.$forms_filter[3].'/'.$forms_filter[4].'/'.$forms_filter[5].'/'.$forms_filter[6].'/'.$forms_filter[7].'/'.$forms_filter[8].'/'.$forms_filter[9].'/'.$forms_filter[10].'/'.$forms_filter[11]."/".'by_group_emp';?>" target="_blank" class='btn btn'><n class='text-danger'><u><b> view working schedules by employee id.</b></u></a>
</div>
</div>
<?php } } ?>




 
</div>