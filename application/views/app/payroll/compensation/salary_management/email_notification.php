<?php 

  $salary_details   = $this->salary_approver_model->get_salary_details($salary_id,$employee_id);
 
?>
<div class="col-md-12">
<div class="col-md-2"></div>
<div class="col-md-8" style="margin-top:10px;margin-left: auto;margin-right: auto;">
  
  <table border="0" width="100%" cellpadding="0" cellspacing="0">
  <thead>
  <tr>
    <th colspan="4"></th>
  </tr>
  <tr>
    <th colspan="4" style="text-align: center"><h2>Salary Information Approval</h2></th>
  </tr>
  <tr>
    <th colspan="4"></th>
  </tr>
  
  </thead>
  <?php foreach($salary_details as $sd){
     $employee_details = $this->salary_approver_model->get_employee_details($sd->employee_id);
    ?>

        <tbody style="font-size: 10px;">
        <tr>
          <td width="20%"><p style="color: #1e90ff;">EMPLOYEE ID:</p></td>
          <td width="40%"><?php echo $employee_details->employee_id;?></td>    
          <td><p style="color: #1e90ff;">DATE FILED:</p></td>  
          <td>
              <?php 
                $month=substr($sd->date_added, 5,2);
                $day=substr($sd->date_added, 8,2);
                $year=substr($sd->date_added, 0,4);
                echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
              ?>
          </td>   
        </tr>
        <tr>
          <td><p style="color: #1e90ff;">EMPLOYEE NAME:</p></td>  
          <td><?php echo $employee_details->fullname;?></td>    
          <td> <p style="color: #1e90ff;">LOCATION:</p></td>  
          <td>
            <?php 
                  $loc=$employee_details->location;
                  $location=$this->payroll_compensation_model->get_location_name($loc);
                  if(empty($location)){} else{ echo $location; }
                ?>
          </td>   
        </tr> 
        <tr>
          <td><p style="color: #1e90ff;">POSITION:</p></td>  
          <td>
                <?php 
                  $pos=$employee_details->position;
                  $pos=$this->transaction_employees_model->get_emp_pos($pos);
                  foreach($pos as $position){
                    echo $position->position_name;
                  }
                ?>
          </td>    
          <td><p style="color: #1e90ff;">DEPARTMENT:</p></td>  
          <td>
                 <?php 
                    $dept=$this->transaction_employees_model->get_emp_dept($employee_details->department);
                    foreach($dept as $dpt){
                      echo $dpt->dept_name;
                    }
                  ?>
          </td>   
        </tr> 
       <tr>
          <td width="20%"><p style="color: #1e90ff;">CLASSIFICATION:</p></td>  
          <td width="">
                 <?php 
                    $clas=$this->transaction_employees_model->get_emp_clas($employee_details->classification);
                    foreach($clas as $class){
                      echo $class->classification;
                    }
                  ?>
          </td>    
          <td width="20%"><p style="color: #1e90ff;">SECTION:</p></td>  
          <td width="">
                  <?php 
                    $sec=$this->transaction_employees_model->get_emp_sect($employee_details->section);
                    foreach($sec as $sect){
                      echo $sect->section_name;
                    }
                  ?>
          </td>    
        </tr>

        <tr>
          <td colspan="4"><hr></td>
        </tr>

        <tr>
          <td width="20%"><p style="color: #1e90ff;">EFFECTIVED DATE:</p></td>  
          <td width="">
                <?php  $month=substr($sd->date_effective, 5,2);
                  $day=substr($sd->date_effective, 8,2);
                  $year=substr($sd->date_effective, 0,4);

                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                ?>
          </td>    
          <td width="20%"><p style="color: #1e90ff;">SALARY RATE:</p></td>  
          <td width="">
                <?php 
                  $salary_rate = $this->salary_approver_model->get_salary_rate($sd->salary_rate);
                  if(empty($salary_rate)){} else{ echo $salary_rate; }
                ?>
          </td>    
        </tr>

         <tr>
          <td width="20%"><p style="color: #1e90ff;">SALARY AMOUNT:</p></td>  
          <td width="">
               <?php echo $sd->salary_amount;?>
          </td>    
          <td width="20%"><p style="color: #1e90ff;">NO. OF HOURS:</p></td>  
          <td width="">
                <?php echo $sd->no_of_hours;?> hour/s
          </td>    
        </tr>

        <tr>
          <td width="20%"><p style="color: #1e90ff;">NO. OF DAYS MONTHLY:</p></td>  
          <td width="">
               <?php echo $sd->no_of_days_monthly;?> days
          </td>    
          <td width="20%"><p style="color: #1e90ff;">WITHHOLDING TAX</p></td>  
          <td width="">
               <?php if($sd->withholding_tax==1){ echo "yes"; } else{ echo "no"; }?>
          </td>    
        </tr>

         <tr>
          <td width="20%"><p style="color: #1e90ff;">REASON:</p></td>  
          <td width="">
               <?php echo $sd->reason;?>
          </td>    
          <td width="20%"><p style="color: #1e90ff;">PAGIBIG</p></td>  
          <td width="">
               <?php if($sd->pagibig==1){ echo "yes"; } else{ echo "no"; }?>
          </td>    
        </tr>

         <tr>
          <td width="20%"><p style="color: #1e90ff;">NO. OF DAYS YEARLY:</p></td>  
          <td width="">
              <?php if($sd->is_salary_fixed==1){ echo "yes"; } else{ echo "no"; }?>
          </td>    
          <td width="20%"><p style="color: #1e90ff;">PHILHEALTH</p></td>  
          <td width="">
              <?php if($sd->philhealth==1){ echo "yes"; } else{ echo "no"; }?>
          </td>    
        </tr> 


        <tr>
          <td colspan="4"><hr></td>
        </tr>
        <tr>
          <td colspan="4"  style="text-align: center;">
            <table border="0px solid #F4F6F7" style="margin-left:auto;margin-right:auto;">

        <tr>
        <?php 

              $get_all_app=$this->salary_approver_model->get_salary_approvers($sd->salary_id,$sd->employee_id);

              if(!empty($get_all_app)){
              foreach($get_all_app as $doc_app){

              $name=$doc_app->first_name. " ".$doc_app->middle_name. " ".$doc_app->last_name. " ";
              $app_position=$doc_app->position_name;

                if ($doc_app->approval_level=="1"){
                  $ext="st";
                }else if($doc_app->approval_level=="2"){
                  $ext="nd";
                }else if($doc_app->approval_level=="3"){
                  $ext="rd";
                }else{
                  $ext="th";
                }

               
                //
                if($doc_app->status=="approved"){
                  $bgstyle='#000';
                }else{
                  $bgstyle='#ff0000';
                }

               

                    echo '
                       <td width="220px" style="color:'.$bgstyle.';">
                         <label style="text-transform:uppercase;text-decoration:none;">'.$doc_app->status.'</label><br>
                          <font style="text-decoration:underline; ">'.'['.$doc_app->approver_id.'] '.$name.'</font><br>'.$doc_app->approval_level.$ext. ' Level'.'<br>'.$app_position.'
                        </td>
                        ';
              }
              }else{
                echo "<td class='text-danger'>--- no assigned approvers --- </td>";
              }
              ?>
          </tr>
            </table>
          </td>
        </tr>
       
        </tbody>
<?php } ?>
</table>

<h3><i>Note: This is auto generated email do not reply.</i></h3>
</div>
  <div  class="col-md-2" ></div>
</div>
<div class="col-md-2"></div>
</div>
