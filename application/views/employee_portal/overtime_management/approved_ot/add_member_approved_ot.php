   <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    
    <style>
       table    {
                  border-collapse: collapse;
                  width: 100%;
                }

                th, td {
                  text-align: left;
                  padding: 8px;
                }

                tr:nth-child(even){background-color: #f2f2f2}

                th {
                  background-color: #4CAF50;
                  color: white;
                }
    </style>
          
<br><br>
  
  <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>employee_portal/overtime_management_section_mngr_approved_ot/save_ot_approved_ot/<?php echo $id;?>/<?php echo $date;?>">
     

    <input type="hidden" id="check" value="<?php echo $check;?>">  
    <table style="width:96%;margin-left:2%;margin-top:20px;margin-bottom:20px;" border="1">
      <thead>
        <tr>  
            <th style="width: 3%;">No</th>
            <th><a name="check_uncheck" id="check_uncheck" class="form-control" onclick="check_uncheck();">
                    <input type="checkbox" class="form-control" id="check_uncheck" name="check_uncheck">
                    <input type="hidden" id="check_uncheck_value" name="check_uncheck_value" value="0">
                </a>
            </th>
            <th>Employee</th>
            <th style="width: 5%;">OT Hours</th></th>
            <th>Shift</th>
            <th>Attendance</th>
            <th>Remarks</th>
        </tr>
      </thead>
      <tbody>
       <?php $i=1; foreach ($group_members as $p) {
         $stat = $this->overtime_management_section_mngr_approved_ot_model->checker_member($p->section,$p->subsection,$p->location,$this->session->userdata('employee_id'));
         if($stat > 0) {

           $attendance = $this->overtime_management_section_mngr_approved_ot_model->get_employee_attendance($p->employee_id,$date);
           $check_selected = $this->overtime_management_section_mngr_approved_ot_model->check_selected($p->employee_id,$date);
           if(!empty($check_selected))
           {
              if($check_selected->id == $id)
              {
                 $checker = "exist_true";
              }
              else
              {
                 $checker = "exist_false";
              }

             
           }
           else
           {
              $checker = "";
           }

       ?>

        <tr <?php if(!empty($checker)) { if($checker == 'exist_false') { echo "style='color:#FF6347'; "; } else{ echo "style='color:red'; "; } } ?>>
            <td>
                  <?php echo $i;?>
                  <input type="hidden" id="employee_value" name="employee_value<?php echo $i;?>" value="<?php echo $p->employee_id;?>">
                  <input type="hidden" id="checker_true_false<?php echo $i;?>" name="checker_true_false" class="classSelected" value="<?php if(!empty($checker)) { if($checker == 'exist_false') { echo "0"; } else{ echo "1"; }  } else { echo "1"; } ?>">        
            </td>
            <td><input type="checkbox" name="employee_id<?php echo $i;?>" id="employee_id<?php echo $i;?>" class="form-control" <?php if(!empty($checker)) { if($checker == 'exist_false') { echo "disabled"; } else{ echo "checked"; } } ?> ></td>
            <td><center><?php echo $p->employee_id;?><br>[<?php echo $p->first_name.' '.$p->last_name;?>]</center></td>
            <td>
              <?php if(!empty($checker)) { if($checker == 'exist_false') { echo $check_selected->hours; } else{ echo '<input type="text" id="total_hour'.$i.'" name="total_hour'.$i.'" name="" class="form-control" value="'.$check_selected->hours.'" onkeypress="return isNumberKey(this, event, '.$i.');">'; } } else{ echo '<input type="text" id="total_hour'.$i.'" name="total_hour'.$i.'" class="form-control" value="0" onkeypress="return isNumberKey(this, event , '.$i.');">'; } ?>
               
            </td>
            <td>
                <?php
                        $datef = $date;
                        $m =  date("m", strtotime($datef));
                        $yy =  date("Y", strtotime($datef));
                        
                                    $individual_schedules = $this->overtime_management_section_mngr_approved_ot_model->get_individual_schedules($p->employee_id,$datef,$m,$yy);
                                    if(!empty($individual_schedules))
                                    {
                                      $schedule_result=$individual_schedules;
                                      $schedule_type="individual";
                                    }
                                    else
                                    {
                                      $fixed_schedules = $this->overtime_management_section_mngr_approved_ot_model->checker_if_fixed_sched($p->employee_id,$datef);
                                      if(!empty($fixed_schedules))
                                      {
                                        $schedule_result=$fixed_schedules;
                                         $schedule_type="fixed";
                                      }
                                      else
                                      {
                                          $group_schedules = $this->overtime_management_section_mngr_approved_ot_model->checker_if_group_sched($p->employee_id,$datef);
                                          if(!empty($group_schedules))
                                          {
                                            $schedule_result=$group_schedules;
                                             $schedule_type="group";
                                          }
                                          else
                                          {
                                            $schedule_result="";
                                             $schedule_type="no_schedule";
                                          }
                                      }
                                    }

                                    if(!empty($schedule_result))
                                            {
                                              $schedule="";
                                              foreach($schedule_result as $sched)
                                              {
                                               
                                                if($schedule_type=='fixed')
                                                {  
                                                  $day  =  date("D", strtotime($datef)); 
                                                  $day_ =  strtolower($day);
                                                  if($day_=='restday'){  $schedule = 'restday'; } else {  $schedule = $sched->$day_; }
                                                }
                                                else
                                                {   
                                                   if($sched->restday==1)
                                                    { $schedule = "restday"; } else{  $schedule=$sched->shift_in.' to '.$sched->shift_out; }
                                                }
                                              } 
                                            }
                                            else
                                            {
                                              $schedule =" No Plotted Schedule";
                                            }
                                    echo $schedule;

                   ?>   
            </td>
            <td>
              <?php if(!empty($attendance)){ foreach($attendance as $a){ if(!empty($a->time_in)){ echo "<b>&nbsp;IN &nbsp;&nbsp;&nbsp;&nbsp;: </b> ".$a->time_in; } echo "<br>"; if(!empty($a->time_out)){ echo "<b>&nbsp;OUT :</b> ".$a->time_out; } } } else { } ?>
            </td>
            <td>
              <?php if(!empty($checker)) { if($checker == 'exist_false') { echo "Plotted by ".$check_selected->plotted_by.' with '.$check_selected->hours.' approved OT<br>[Group Name:'.$check_selected->group_name.']'; } else{ echo "With plotted approved OT "; } } else{ echo "No Approved OT yet"; } ?>

            </td>
        </tr>

       <?php $i++; } else{ $i+0; } } echo "<input type='hidden' name='count' id='count' value='".$i."'> "  ?>
      </tbody>
    </table>
  
    <div style="position: fixed; bottom: 15px; right: 0px;border:0px solid #000;width: 100%">
   
   <center><button type="submit" style="background-color: #4CAF50;width: 200px;height: 40px;" data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to Save Schedule" id="savepp"><i class="fa fa-floppy-o"></i> Save</button></center>
</div>

</form>

<!-- DataTables -->


<script type="text/javascript">
  
  function check_uncheck()
  {
      var count= document.getElementById("count").value;
      var checks = document.getElementsByClassName("classSelected");
      
      var checker_value= document.getElementById('check_uncheck_value').value;
      if(checker_value == '0')
      {
          document.getElementById('check_uncheck_value').value=1;
          for (i=1;i <= count; i++)
              {
                  
                if(document.getElementById('checker_true_false'+i).value=='1') 
                {
                  document.getElementById('employee_id'+i).checked=true;
                }


              }
      } 
      else
      {
         document.getElementById('check_uncheck_value').value=0;
         for (i=1;i <= count; i++)
              {
                  
                if(document.getElementById('checker_true_false'+i).value=='1') 
                {
                  document.getElementById('employee_id'+i).checked=false;
                }


              } 

      }    
            
    

  }

  function isNumberKey(txt, evt ,i) {
        
        document.getElementById('employee_id'+i).checked=true;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
            //Check if the text already contains the . character
            if (txt.value.indexOf('.') === -1) {
                return true;

            } else {
                return false;

            }
        } else {

            if (charCode > 31
                 && (charCode < 48 || charCode > 57))
                return false;

        }
        return true;
    }


    function checker()
    {
      if(document.getElementById('check').value=='1')
      {
        alert('Employee Approved Overtime successfully added!');        
      }
    }

</script>
