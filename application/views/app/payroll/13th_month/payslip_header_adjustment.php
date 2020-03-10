

<div class="datagrid">

<table >

    <tbody>
        <tr>
            <td align="right" width="20%"><?php echo $employee_id?></td>
            <td align="right" width="20%"><?php echo $name?></td>
            <td>

            <input type="text" name="adj_<?php echo $employee_id?>" class="form-control" placeholder="you may input positive or negative amount to adjust the automatic computation of the system." value="<?php echo $current_amount?>">

            <input type="hidden" name="employee_id[]" class="form-control" placeholder="you may input positive or negative amount to adjust the automatic computation of the system." value="<?php echo $employee_id?>">
            </td>
        </tr>
    </tbody>
</table>



</div>