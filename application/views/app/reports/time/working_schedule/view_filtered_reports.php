    <style type="text/css">
      .print{
          page-break-after: always;

      }
    </style>
    <ol class="breadcrumb">
                <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Time Summary Reports | Working Schedule
            </ol><br>
             <table id="print_table" class="table table-hover table-striped">
                <thead>
                  <tr>
                   <?php 
                   if(!empty($report_fields)){
                    foreach ($report_fields as $row){
                      echo '<th>'.$row->title.'</th>';
                    }
                   }else{
                    echo 'no result';
                   }
                   ?>
                  </tr>
                </thead>
                <tbody>
                
                <?php 

// ===== For time summary total declare var:

if($report_fs_type=="by_month" OR $report_fs_type=="by_year" OR $report_area=="time_summary" OR $report_area=="late" OR $report_area=="undertime" OR $report_area=="overbreak" OR $report_area=="regular_nd" OR $report_area=="overtime"){
foreach ($report_fields as $row){ 
  $name = $row->field_name;
  if($row->sum_me=="1"){
    $sum_var=$name."_sum";
    $sum_var_fin="$sum_var";
    $$sum_var_fin=0;
  }else{

  }
}
}else{}



                foreach($ws_data as $row1){?>
                  <tr>
                    <?php foreach ($report_fields as $row) { $name = $row->field_name; ?>
                    <td><?php if($name=='InActive'){ if($row1->$name=='0'){ echo 'Active';} else{ echo "InActive"; }} else { 

if($report_area=="working_schedules"){

      if($report_fs_type=="single_pp"){
        require(APPPATH.'views/app/reports/time/view_from_dtr_data.php');
      }else{
        echo $row1->$name; 
      }

}elseif($report_area=="attendances" OR $report_area=="late" OR $report_area=="undertime" OR $report_area=="overbreak" OR $report_area=="absent" OR $report_area=="regular_nd" OR $report_area=="overtime" OR $report_area=="time_summary"){ 

      if($report_fs_type=="single_pp"){
        require(APPPATH.'views/app/reports/time/view_from_dtr_data.php');

      }elseif($report_fs_type=="double"){


//======================  Sum Values 

if($report_area=="late" OR $report_area=="undertime" OR $report_area=="overbreak" OR $report_area=="regular_nd" OR $report_area=="overtime"){
//======================  Sum Values 
                        if($row->sum_me=="1"){
                          $add_me_var=$name."_sum";
                          $add_me_var_fin="$add_me_var";
                          $$add_me_var_fin+=$row1->$name;
                        }else{

                        }
//======================  Sum Values 
}else{
  
}


              if($report_area=="late" OR $report_area=="undertime" OR $report_area=="overbreak" OR $report_area=="absent" OR $report_area=="regular_nd" OR $report_area=="overtime"){
                  $date="logs_whole_date";
              }else{
                  $date="covered_date";
              }

            if($name=="date"){
              echo $row1->$date; 
            }elseif($name=="mm" OR $name=="dd" OR $name=="yy"){
                                  $m=substr($row1->$date, 5,2);
                                  $d=substr($row1->$date, 8,2);
                                  $y=substr($row1->$date, 0,4);

                                    if($name=="mm"){
                                      echo $m;
                                    }elseif($name=="dd"){
                                      echo $d;
                                    }else{
                                      echo $y;
                                    }

            }elseif($name=="classification"){
              echo $row1->classification_name; 
            }else{
                echo $row1->$name; 
            }
        
      }elseif($report_fs_type=="by_month" OR $report_fs_type=="by_year"){
          if($name=="payroll_period_id"){
            echo $row1->complete_from." to ".$row1->complete_to;
          }elseif($name=="classification"){
              echo $row1->classification_name; 
          }else{
            echo $row1->$name; 
          } 

//======================  Sum Values 
                        if($row->sum_me=="1"){
                          $add_me_var=$name."_sum";
                          $add_me_var_fin="$add_me_var";
                          $$add_me_var_fin+=$row1->$name;
                        }else{

                        }
//======================  Sum Values 

      }else{//single


//======================  Sum Values 

if($report_area=="late"){
//======================  Sum Values 
                        if($row->sum_me=="1"){
                          $add_me_var=$name."_sum";
                          $add_me_var_fin="$add_me_var";
                          $$add_me_var_fin+=$row1->$name;
                        }else{

                        }
//======================  Sum Values 
}else{
  
}

          if($name=="date"){
            echo $single_date_ymd;
          }elseif($name=="mm" OR $name=="dd" OR $name=="yy"){
                                $m=substr($single_date_ymd, 5,2);
                                $d=substr($single_date_ymd, 8,2);
                                $y=substr($single_date_ymd, 0,4);

                                  if($name=="mm"){
                                    echo $m;
                                  }elseif($name=="dd"){
                                    echo $d;
                                  }else{
                                    echo $y;
                                  }
          }elseif($name=="classification"){
            echo $row1->classification_name; 
          }else{
              echo $row1->$name; 
          }
      }

}elseif($report_area=="by_group_time_summary"){

      if($name=="coverage"){         
            echo $group_duration;          
      }else{
        if($groupings_type=="g_company"){
          if($name=="location_name" OR $name=="division_name" OR $name=="dept_name" OR $name="section" OR $name="subsection_name" OR $name="employment" OR $name="classification"){ 
            echo "Not Applicable";
          }else{
            echo $row1->$name;
          }         
        }elseif($groupings_type=="g_location"){
          if($name=="division_name" OR $name=="dept_name" OR $name=="section" OR $name=="subsection_name" OR $name=="employment" OR $name=="classification"){ 
            echo "Not Applicable";
          }else{
            echo $row1->$name;
          }         
        }elseif($groupings_type=="g_div"){
          if($name=="dept_name" OR $name=="section" OR $name=="subsection_name" OR $name=="employment" OR $name=="classification"){ 
            echo "Not Applicable";
          }else{
            echo $row1->$name;
          }         
        }elseif($groupings_type=="g_dept"){
          if($name=="location_name" OR $name=="section" OR $name=="subsection_name" OR $name=="employment" OR $name=="classification"){ 
            echo "Not Applicable";
          }else{
            echo $row1->$name;
          }         
        }elseif($groupings_type=="g_sect"){
          if($name=="subsection_name" OR $name=="employment" OR $name=="classification"){ 
            echo "Not Applicable";
          }else{
            echo $row1->$name;
          }         
        }elseif($groupings_type=="g_subsect"){
          if($name=="employment" OR $name=="classification"){ 
            echo "Not Applicable";
          }else{
            echo $row1->$name;
          }         
        }elseif($groupings_type=="g_employ" OR $groupings_type=="g_class"){
          if($name=="location_name" OR $name=="division_name" OR $name=="dept_name" OR $name=="section" OR $name=="subsection_name"){ 
            echo "Not Applicable";
          }else{
            echo $row1->$name;
          }         
        }else{
           echo $row1->$name;    
        }
      }
      
}else{

}

                      }?></td>
                   <?php } ?>
                  </tr>
                <?php } 




// FOr the SUM TOTAL
if($report_fs_type=="by_month" OR $report_fs_type=="by_year" OR $report_area=="time_summary" OR $report_area=="late" OR $report_area=="undertime" OR $report_area=="overbreak" OR $report_area=="regular_nd" OR $report_area=="overtime"){

                    echo '
                    <tr>';
                    foreach ($report_fields as $row){ 
                      $name = $row->field_name;
                      echo '<th>';
                        if($row->sum_me=="1"){
                              $c=$name."_sum";
                              echo $$c;
                        }else{
                          echo "n/a";
                        }                  
                    echo '</th>';
                    }
                   echo '</tr>'; 
}else{}                  

                ?>

<!-- //============== Fixed Schedule -->
                <?php 
if($report_area=="working_schedules"){

if($report_fs_type=="single"){

                foreach($fs_data as $row1){?>
                  <tr>
                    <?php foreach ($general_fields as $row) { 
                      $name = $row->field_name; 

                     ?>
                    <td>
                    <?php 
                    if($name=='InActive'){
                      echo "Active";
                    }elseif($name=="date_plotted"){
                      if(!empty($row1->last_update)){
                        echo $row1->last_update;
                      }else{
                        echo $row1->date_added;
                      }
                    }elseif($name=="shift_category"){
                        echo "Fixed Schedule";
                    }elseif($name=="plotter"){
                        echo "system user: ".$row1->system_user;

                    }elseif($name=="shift_in" OR $name=="shift_out"){

                      $shift_in=substr($row1->the_day, 0,5);
                      $shift_out=substr($row1->the_day, 8,6);

                        if($name=="shift_in"){
                           echo $shift_in;
                        }else{
                           echo $shift_out;
                        }
                    }elseif($name=="mm" OR $name=="dd" OR $name=="yy" OR $name=="date"){
                        $m=substr($single_date, 0,2);
                        $d=substr($single_date, 3,2);
                        $y=substr($single_date, 6,4);
                          if($name=="mm"){
                            echo $m;
                          }elseif($name=="dd"){
                            echo $d;
                          }elseif($name=="date"){
                            echo $single_date;
                          }else{
                            echo $y;
                          }

                    }else{
                      echo $row1->$name; 
                    }
                       ?></td>
                   <?php } ?>
                  </tr>
                <?php } ?>

<?php
}elseif($report_fs_type=="double"){
?>

                <?php 
  while (strtotime($date_from) <= strtotime($date_to)) {

                foreach($fs_data as $row1){?>
                  <tr>
                    <?php foreach ($general_fields as $row) { $name = $row->field_name; ?>
                    <td>
                    <?php 
                    if($name=='InActive'){
                      echo "Active";
                    }elseif($name=="date_plotted"){
                      if(!empty($row1->last_update)){
                        echo $row1->last_update;
                      }else{
                        echo $row1->date_added;
                      }
                    }elseif($name=="shift_category"){
                        echo "Fixed Schedule";
                    }elseif($name=="plotter"){
                        echo "system user: ".$row1->system_user;;

                    }elseif($name=="shift_in" OR $name=="shift_out"){

                      $dayOfWeek = date("l", strtotime($date_from));

                      if($dayOfWeek=="Monday"){
                        $shift_in=substr($row1->mon, 0,5);
                        $shift_out=substr($row1->mon, 8,6);
                      }elseif($dayOfWeek=="Tuesday"){
                        $shift_in=substr($row1->tue, 0,5);
                        $shift_out=substr($row1->tue, 8,6);
                      }elseif($dayOfWeek=="Wednesday"){
                        $shift_in=substr($row1->wed, 0,5);
                        $shift_out=substr($row1->wed, 8,6);
                      }elseif($dayOfWeek=="Thursday"){
                        $shift_in=substr($row1->thu, 0,5);
                        $shift_out=substr($row1->thu, 8,6);
                      }elseif($dayOfWeek=="Friday"){
                        $shift_in=substr($row1->fri, 0,5);
                        $shift_out=substr($row1->fri, 8,6);
                      }elseif($dayOfWeek=="Saturday"){
                        $shift_in=substr($row1->sat, 0,5);
                        $shift_out=substr($row1->sat, 8,6);
                      }elseif($dayOfWeek=="Sunday"){
                        $shift_in=substr($row1->sun, 0,5);
                        $shift_out=substr($row1->sun, 8,6);
                      }else{

                      }
                        if($name=="shift_in"){
                          if($shift_in=="restd"){ 
                            echo "restday";
                          }else{
                             echo $shift_in;
                          }
                        }else{
                          if($shift_in=="restd"){ 
                            echo "restday";
                          }else{
                             echo $shift_out;
                          }
                        }
                    }elseif($name=="mm" OR $name=="dd" OR $name=="yy" OR $name=="date"){

                      //  y m d
                        $m=substr($date_from, 5,2);
                        $d=substr($date_from, 8,2);
                        $y=substr($date_from, 0,4);
                          if($name=="mm"){
                            echo $m;
                          }elseif($name=="date"){
                            echo $date_from;
                          }elseif($name=="dd"){
                            echo $d;
                          }else{
                            echo $y;
                          }
                    }else{
                      echo $row1->$name; 
                    }
                       ?></td>
                   <?php } ?>
                  </tr>
                <?php } 

     $date_from = date ("Y-m-d", strtotime("+1 day", strtotime($date_from)));
}

                ?>

<?php
}else{
  //echo 'pang payroll period ';
}


}else{

}
?>


                </tbody>
              </table>