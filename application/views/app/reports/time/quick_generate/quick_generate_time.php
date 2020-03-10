<?php
if($report_result_type=="excel"){
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$report_area.xls");
    header("Pragma: no-cache");   
    header("Expires: 0");
}else{

}

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
<link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
rel="stylesheet">
<link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">

</head>
<body>



<div class="table-responsive">

<table id="print_table" class="table table-hover table-striped">
  <thead>
    <tr>
      <th colspan="5"><?php echo $report_title;?></th>
    </tr>
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
foreach($ws_data as $row1){?>
<tr>
<?php foreach ($report_fields as $row) { $name = $row->field_name; ?>
<td><?php if($name=='InActive'){ if($row1->$name=='0'){ echo 'Active';} else{ echo "InActive"; }} else { 

if($report_area=="attendances"){ 
                $date="covered_date";

                if($report_fs_type=="double"){
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
                  }elseif($name=="actual_in"){
                    echo $row1->time_in; 
                  }elseif($name=="actual_out"){
                    echo $row1->time_out; 
                  }else{

                            //============start udf
                            if($name>0){
                                  $udf_data=$this->report_time_model->check_udf_content($row1->employee_id,$name);
                                  if(!empty($udf_data)){
                                    echo $udf_data->data;
                                  }else{
                                    echo ""; 
                                  }
                                 
                            }else{
                              echo $row1->$name; 
                            }
                            //============end udf
                              
                                                        
                    
                  }
                }else{
                }

}elseif($report_area=="late" OR $report_area=="undertime" OR $report_area=="overbreak" OR $report_area=="absent" OR $report_area=="regular_nd" OR $report_area=="overtime"){
                $date="logs_whole_date";

                if($report_fs_type=="double"){
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
                            //============start udf
                            if($name>0){
                                  $udf_data=$this->report_time_model->check_udf_content($row1->employee_id,$name);
                                  if(!empty($udf_data)){
                                    echo $udf_data->data;
                                  }else{
                                    echo ""; 
                                  }
                                 
                            }else{
                              echo $row1->$name; 
                            }
                            //============end udf
                  }
                }else{
                }


}elseif($report_area=="time_summary"){
                $date="logs_whole_date";

                if($report_fs_type=="double"){
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
                  }elseif($name=="payroll_period_id"){
                    echo $row1->complete_from." TO ".$row1->complete_to; 
                  }else{
                            //============start udf
                            if($name>0){
                                  $udf_data=$this->report_time_model->check_udf_content($row1->employee_id,$name);
                                  if(!empty($udf_data)){
                                    echo $udf_data->data;
                                  }else{
                                    echo ""; 
                                  }
                                 
                            }else{
                              echo $row1->$name; 
                            }
                            //============end udf
                  }
                }else{
                }
}else{

}

}?></td>
<?php } ?>
</tr>
<?php } ?>

</tbody>
</table>


</div>
</body>


</html>
