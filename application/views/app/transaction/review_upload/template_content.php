<?php
$chosen_template=$this->input->post('template');
if($chosen_template=="employee_atro_form_template"){

echo '
   <tr>
      <td>'.$emp_id.'</td>
      <td>'.$ot_date.'</td>
      <td>'.$ot_hrs.'</td>
      <td>'.$remarks.'</td>
   </tr>

';

}else{
?>
                  <tr>
                     <td><?php echo $col_0?></td>
                     <td><?php echo $col_1?></td>
                     <td><?php echo $col_2?></td>
                     <td><?php echo $col_3?></td>
                     <td><?php echo $col_4?></td>
                     <td><?php echo $col_5?></td>
                     <td><?php echo $col_6?></td>
                     <?php if($action=='review'){?>
                     <td>
                     <?php if($remarks=='Error'){?>
                     <n class='text-danger'><?php echo $errors?></n>
                     <?php } else{?>
                     <n class='text-success'>Ok</n>
                     <?php } ?>
                     </td>
                     <?php } else{}?>
                  </tr>
                  

<?php
}
?>