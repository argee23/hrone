<?php 
$check = false;
?>
<?php if (count($payroll_pagibig) > 0){ ?>
    <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="width:15%" >EMPLOYEE ID</th>
            <th style="width:35%" > EMPLOYEE NAME</th>
            <th> AMOUNT</th>
            <th style="width:15%" >DEDUCTION PER</th>
            <th style="width:15%" >TYPE</th>
            <th></th>
          </tr>
        </thead>
      <tbody>
      <?php 
      $check = false;
      foreach($payroll_pagibig as $pagibig){ ?>
      <tr>
        <td><?php echo $pagibig->employee_id; ?></td>
        <td><?php echo $pagibig->last_name.', '.$pagibig->first_name.' '.$pagibig->middle_name.' '.$pagibig->name_extension; ?></td>
        <td><?php echo $pagibig->amount; ?></td>
        <td><?php echo $pagibig->cut_off_id; ?></td>
        <td><?php echo $pagibig->pagibig_type_name; ?></td>
        <td>

        <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="pagibig_table_edit('<?php echo $pagibig->pagibig_table_id; ?>')"></i></div>
        </td>
      </tr>
      <?php $check = true;
      } ?>
    </tbody>
    </table>

    <?php if($check === false){ ?>
        <tr>
          <p class='text-center' style='color:#ff0000;'><strong>No pagibig Data yet.</strong></p>
        </tr>
    <?php } ?>
<?php }





