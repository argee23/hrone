<head>
<link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
rel="stylesheet">
<link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">

</head>
<body>
  <div class="table table-responsive">
    
<?php
  $dateObj   = DateTime::createFromFormat('!m', $month);
  $monthName = $dateObj->format('F');
?>
  <table id="" class="table table">
    <thead>
      <tr>
        <th colspan="5">Tax Deduction Details for the Month of <span class="text-danger"><?php echo $monthName;?></span> </th>
      </tr>
      <tr>
        <th>Employee ID</th>
        <th>Employee Name</th>
        <th>Payroll Period</th>
        <th>Month</th>
        <th>Tax Deduction</th>
      </tr>
    </thead>
<?php



if(!empty($emp_wtax)){
  foreach($emp_wtax as $e){
    echo '
      <tr>
        <td>'.$e->employee_id.'</td>
        <td>'.$e->name.'</td>
        <td>'.$e->complete_from.' to '.$e->complete_to.'</td>
        <td>'.$monthName.'</td>
        <td>'.$e->wtax.'</td>
      </tr>
    ';
  }
}else{

}
?>

    </tbody>
  </table>


  </div>


</body>