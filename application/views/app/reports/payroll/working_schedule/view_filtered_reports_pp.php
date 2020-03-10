    <style type="text/css">
      .print{
          page-break-after: always;

      }
    </style>
   
    <ol class="breadcrumb">
                <h4 class="text-success" style="font-weight: bold;"><i class="fa fa-bars"></i>Time Summary Reports | Working Schedule
            </ol><br>
            <center><h5><n class="text-danger" style="font-weight:bold;"><?php echo "Payroll Period:".$from_date." to ".$to_date?></n></h5></center>
             <table id="print_table" class="table table-hover table-striped">
                <thead>
                  <tr>
                   <?php foreach ($report_fields as $row) { $name= $row->field_name;  
                    if($name == 'employee_id' || $name == 'first_name' || $name == 'middle_name' || $name == 'last_name' || $name == 'InActive' 
                          || $name == 'company_name' || $name == 'division_name' || $name == 'dept_name' || $name == 'section_name' || $name == 'subsection_name' || $name == 'location_name' 
                          || $name == 'classification' || $name == 'employment_name') { ?>
                    <th><?php echo $row->title?></th>
                   <?php } else{} } 
                     $from = $from_date;
                    $to = $to_date;
                    $to = date("m/d/Y",strtotime(date("m/d/Y", strtotime($to)) . " +1 days"));

                    while($from!=$to){
                    list($month, $day, $year) = explode("/", $from);
                    $mon = date('M', strtotime($from));
                    ?>
                    <th style="width:20px;"><?php echo $day."<br>".date('D', strtotime($from));?></th>
                    <?php 
                    $from=strtotime(date("m/d/Y", strtotime($from)) . " +1 days");
                    $from = date("m/d/Y",$from);
                    }?>
                  </tr>
                </thead>
                <tbody>
                <?php 
                    $payroll_emp = $this->report_time->emp_list_payroll($payroll_period_group);
                    foreach($payroll_emp as $row1){?>
                  <tr>
                    <?php foreach ($report_fields as $row) { $name = $row->field_name; 
                      if($name == 'employee_id' || $name == 'first_name' || $name == 'middle_name' || $name == 'last_name' || $name == 'InActive' 
                          || $name == 'company_name' || $name == 'division_name' || $name == 'dept_name' || $name == 'section_name' || $name == 'subsection_name' || $name == 'location_name' 
                          || $name == 'classification' || $name == 'employment_name') { ?>
                    <td>
                        <?php if($name=='InActive'){ if($row1->$name=='0'){ echo 'Active';} else{ echo "InActive"; }} else { echo $row1->$name; }?>
                    </td>

                    <?php
                    } else {} }
                    $from = $from_date;
                    $to = $to_date;
                    
                    $to = date("m/d/Y",strtotime(date("m/d/Y", strtotime($to)) . " +1 days"));
                    while($from!=$to){
                    list($month, $day, $year) = explode("/", $from);
                    $mon = date('M', strtotime($from));
                    $emp=$row1->employee_id;
                    $to1 = $year."-".$month."-".$day;
                    $shift_data = $this->report_time->shift_data($emp,$to1);
                  
                    if($shift_data == $to1)
                    { 
                      $shift_data1 = $this->report_time->shift_data1($emp,$to1);
                      foreach ($shift_data1 as $rowss) {
                        $data = $rowss->shift_in."-".$rowss->shift_out;
                      }
                    }
                  else{ $data=""; }
                    ?>
                    <td style="width:20px;"><?php echo $data;?></td>
                   <?php
                    $from=strtotime(date("m/d/Y", strtotime($from)) . " +1 days");
                    $from = date("m/d/Y",$from);
                    }?>
                  </tr>
                <?php } ?>
                </tbody>
              </table>