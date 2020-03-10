       
<div class="col-md-12">
<table style="width: 100%;">
  <thead>
    <tr>
      <th><h4>Applicant Interview Details</h4></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width: 20%;"><p style="color: #1e90ff;">Interview Process</p></td>
      <td style="width: 80%;"><?php echo $process;?></td>
    </tr>
    <tr>
      <td style="width: 20%;"><p style="color: #1e90ff;">Applicant</p></td>
      <td tyle="width: 80%;"><?php echo $applicant;?></td>
    </tr>
    <tr>
      <td style="width: 20%;"><p style="color: #1e90ff;">Date Applied</p></td>
      <td tyle="width: 80%;">
         <?php 
          $month=substr($date_applied, 5,2);
          $day=substr($date_applied, 8,2);
          $year=substr($date_applied, 0,4);

          echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
          ?>
      </td>
    </tr>
     <tr>
      <td style="width: 20%;"><p style="color: #1e90ff;">Job Position</p></td>
      <td tyle="width: 80%;"><?php echo $position;?></td>
    </tr>
    
    <tr>
      <td style="width: 20%;"><p style="color: #1e90ff;">Interview Date</p></td>
      <td tyle="width: 80%;"> 
      <?php 
            $month=substr($interview_date, 5,2);
            $day=substr($interview_date, 8,2);
            $year=substr($interview_date, 0,4);

            echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
      ?>
      </td>
    </tr>
     <tr>
      <td style="width: 20%;"><p style="color: #1e90ff;">Interview Time</p></td>
      <td style="width: 80%;"><?php echo $interview_time;?></td>
    </tr>
    
   
  </tbody>
</table>

</div>