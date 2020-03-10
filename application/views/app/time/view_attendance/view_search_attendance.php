  <div class="col-md-12">
    <div class="form-group">
    <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th scope="col" colspan="1" class="bg-primary">COVERED DATE</th>
        <th scope="col" colspan="1" style="background-color:#FBB917" >DATE</th>
        <th scope="col" colspan="1" style="background-color:#4CC552" >TIME</th>
        <th scope="col" colspan="2"  >BREAK</th>
        <th scope="col" colspan="2" >LUNCH</th>
        <th scope="col" colspan="2" >BREAK</th>
        <th scope="col" colspan="1" style="background-color:#4CC552" >TIME</th>
        <th scope="col" colspan="1" style="background-color:#FBB917" >DATE</th>
      </tr>
      <tr>
        <th scope="col" class="bg-primary">&nbsp;</th>
        <th scope="col"  style="background-color:#FDD017" > IN</th>
        <th scope="col" style="background-color:#54C571" > IN</th>
        <th scope="col" > OUT</th>
        <th scope="col" > IN</th>
        <th scope="col" > OUT</th>
        <th scope="col" > IN</th>
        <th scope="col" > OUT</th>
        <th scope="col" > IN</th>
        <th scope="col" style="background-color:#54C571" > OUT</th>
        <th scope="col" style="background-color:#FDD017" > OUT</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $check = false; 
      foreach($search_attendance as $attendance){ ?>
      <tr>
      <td class="bg-primary" ><?php echo $attendance->covered_date; ?></td>
      <td  style="background-color:#FDD017" ><?php echo $attendance->time_in_date; ?></td>
      <td style="background-color:#7FE817" ><?php echo $attendance->time_in; ?></td>
      <td ><?php echo $attendance->break_1_out; ?></td>
      <td ><?php echo $attendance->break_1_in; ?></td>
      <td ><?php echo $attendance->lunch_break_out; ?></td>
      <td ><?php echo $attendance->lunch_break_in; ?></td>
      <td ><?php echo $attendance->break_2_out; ?></td>
      <td ><?php echo $attendance->break_2_in; ?></td>
      <td style="background-color:#7FE817" ><?php echo $attendance->time_out; ?></td>
      <td style="background-color:#FFDB58" ><?php echo $attendance->time_out_date; ?></td>
      </tr>
      <?php $check = true;
      }
      if($check == false){?>
      <tr>
      <td>
        <p class='text-center'><strong>No Log(s) yet.</strong></p>
        </td>
      </tr>
       <?php }?>
    </tbody>
  </table>
  </div>
  </div>