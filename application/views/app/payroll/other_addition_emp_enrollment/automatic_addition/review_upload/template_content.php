
                  <tr>
                     <td><?php echo $col_0?></td>
                     <td><?php echo $col_1?></td>
                     <td><?php echo $col_2?></td>
                    
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
                  