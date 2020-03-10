<?php 
  $empl = substr_replace($employees, "", -1);
  $var = explode("-",$empl);
 

?>
<input type="hidden" name="finalemployee" id="finalemployee" value="<?php echo $empl ;?>">
<input type="hidden" name="fcompany" id="fcompany" value="<?php echo $company;?>">

<table id="selected_emp" class="col-md-12 table table-hover table-striped">
  <thead>
      <tr class="danger">
                  <th style="width: 100%;"><center>LIST OF SELECTED EMPLOYEES</center></th>
      </tr>
  </thead>
  <tbody>
     <?php  foreach ($var as $emp) {
      $name = $this->employee_training_seminars_final_model->get_name_emp($emp);
      ?>
      <tr>
        <td><center><?php echo $name;?></center></td>
      </tr>
     <?php } ?>
  </tbody>
 </table>
                           