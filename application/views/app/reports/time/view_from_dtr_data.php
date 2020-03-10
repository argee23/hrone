<?php

//======================  Sum Values 

if($report_area=="time_summary" OR $report_area=="late" OR $report_area=="undertime" OR $report_area=="overbreak" OR $report_area=="regular_nd" OR $report_area=="overtime"){
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
                        if($row->sum_me=="1"){
                          $add_me_var=$name."_sum";
                          $add_me_var_fin="$add_me_var";
                          $$add_me_var_fin+=$row1->$name;
                        }else{

                        }

//======================  Sum Values 


        if($name=="date"){
          echo $row1->logs_whole_date;
        }elseif($name=="mm" OR $name=="dd" OR $name=="yy"){
                              $m=substr($row1->logs_whole_date, 5,2);
                              $d=substr($row1->logs_whole_date, 8,2);
                              $y=substr($row1->logs_whole_date, 0,4);

                                if($name=="mm"){
                                  echo $m;
                                }elseif($name=="dd"){
                                  echo $d;
                                }else{
                                  echo $y;
                                }

        }elseif($name=="shift_category"){
          
          echo "this is a processed/saved data on dtr.";
        }elseif($name=="plotter"){
          echo "process by system user: ".$row1->system_user_id;
        }elseif($name=="date_plotted"){
          echo "process on: ".$row1->date_process;
        }elseif($name=="classification"){
          echo $row1->classification_name; 
        }elseif($name=="payroll_period_id"){
          echo $payroll_period_from_and_to; 
        }else{
            echo $row1->$name; 
        }

?>