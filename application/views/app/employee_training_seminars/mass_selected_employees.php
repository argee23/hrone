<?php 
  $empl = substr_replace($employees, "", -1);
  $var = explode("-",$empl);
 

?>
<input type="hidden" name="finalemployee" id="finalemployee" value="<?php echo $empl ;?>">

<table id="selected_emp" class="col-md-12 table table-hover table-striped">
  <thead>
      <tr  class="success">
        <th width="30%;"><center>Employee ID</center></th>
        <th width="70%;"><center>Name</center></th>
      </tr>
  </thead>
  <tbody>
     <?php  foreach ($var as $emp) {
      $name = $this->employee_training_seminars_model->get_name_emp($emp);
      ?>
      <tr>
        <td><center><?php echo $emp;?></center></td>
        <td><center><?php echo $name;?></center></td>
      </tr>
     <?php } ?>
  </tbody>
 </table>
                           