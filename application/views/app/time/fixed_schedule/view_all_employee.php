<div class="row">
<div class="col-md-12">
<div class="box box-success">
<div class="panel panel-success">

  <div class="panel-heading"><strong><?php echo $company_name->company_name; ?></strong>
    <a onclick="view_company_group('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="View Group list"><i class="fa fa-arrow-circle-left fa-2x text-danger pull-right"></i></a>
  </div>

  <div class="box-body">
  <div class="panel panel-success">
  <div class="box-body">
  <div class="row">

  <div class="col-md-4">
  <div class="form-group">
    <label for="reference_position">Status </label>
    <select class="form-control" name="search" id="search" onchange="get_search(this.value)">
        <option selected="selected" value="0" >All employee</option>
        <option value="1" >Employee with group</option>
        <option value="2" >Employee with no group</option>
    </select>
  </div>
  </div>


  <!-- table -->
    <div class="col-md-12">
    <div id="search_here">
    <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>EMPLOYEE ID</th>
        <th>EMPLOYEE NAME</th>
        <th>GROUP NAME</th>
        <th>GROUP TYPE</th>
        <th>STATUS</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($employee_flexi as $employee){ ?>
      <tr>
        <td><?php echo $employee->employee_id; ?></td>
        <td><?php echo $employee->first_name; ?> <?php echo $employee->middle_name; ?> 
          <?php echo $employee->last_name; ?> <?php echo $employee->name_extension; ?>
        </td>
        <td><?php echo $employee->group_name; ?></td>
        <td><?php echo 'Flexi Schedule Group'; ?></td>
        <?php if($employee->InActive === '1'){ ?>
        <td style="color:#ff0000;">InActive</td>
        <?php } ?>
        <?php if($employee->InActive === '0'){ ?>
        <td>Active</td>
        <?php } ?>
      </tr>
      <?php }
      foreach($employee_fixed as $employee){ ?>
      <tr>
        <td><?php echo $employee->employee_id; ?></td>
        <td><?php echo $employee->first_name; ?> <?php echo $employee->middle_name; ?> 
          <?php echo $employee->last_name; ?> <?php echo $employee->name_extension; ?>
        </td>
        <td><?php echo $employee->group_name; ?></td>
        <td><?php echo 'Fixed Schedule Group'; ?></td>
        <?php if($employee->InActive === '1'){ ?>
        <td style="color:#ff0000;">InActive</td>
        <?php } ?>
        <?php if($employee->InActive === '0'){ ?>
        <td>Active</td>
        <?php } ?>
      </tr>
      <?php }
      foreach($employee_section as $employee){ ?>
      <tr>
        <td><?php echo $employee->employee_id; ?></td>
        <td><?php echo $employee->first_name; ?> <?php echo $employee->middle_name; ?> 
          <?php echo $employee->last_name; ?> <?php echo $employee->name_extension; ?>
        </td>
        <td><?php echo $employee->group_name; ?></td>
        <td><?php echo 'Section Manager Scheduled Group'; ?></td>
        <?php if($employee->InActive === '1'){ ?>
        <td style="color:#ff0000;">InActive</td>
        <?php } ?>
        <?php if($employee->InActive === '0'){ ?>
        <td>Active</td>
        <?php } ?>
      </tr>
      <?php }
      foreach($employee_available as $employee){ ?>
      <tr>
        <td style="color:#ff0000;"><?php echo $employee->employee_id; ?></td>
        <td style="color:#ff0000;"><?php echo $employee->first_name; ?> <?php echo $employee->middle_name; ?> 
          <?php echo $employee->last_name; ?> <?php echo $employee->name_extension; ?>
        </td>
        <td><p style="color:#ff0000;">No group</p></td>
        <td></td>
        <td></td>
      </tr>
      <?php }
      /*foreach($employee_available_sec as $employee){ ?>
      <tr>
        <td style="color:#ff0000;"><?php echo $employee->employee_id; ?></td>
        <td style="color:#ff0000;"><?php echo $employee->first_name; ?> <?php echo $employee->middle_name; ?> 
          <?php echo $employee->last_name; ?> <?php echo $employee->name_extension; ?>
        </td>
        <td><p style="color:#ff0000;">No group</p></td>
        <td></td>
      </tr>
      <?php } */?>
    </tbody>
    </table>
    </div>
    </div>
  <!-- end of table -->


  </div> 
  </div><!-- /.box-body --> 
  </div>
  </div>

</div>
</div>  
</div>
</div>

