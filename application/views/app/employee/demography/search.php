<!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">

    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Emp. ID</th>
                        <th>Employee Name</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Department</th>
                        <th>Section</th>
                        <th>Options</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($employee as $employee){ ?>

                      <tr>
                        <td><?php echo $employee->employee_id ?></td>
                        <td><?php echo $employee->name ?></td>
                        <td><?php echo $employee->company_name ?></td>
                        <td><?php echo $employee->location_name ?></td>
                        <td><?php echo $employee->dept_name ?></td>
                        <td><?php echo $employee->section_name ?></td>
                        <td>
                              <?php
                                $employee_id =  $employee->employee_id;

                              ?>

                            <a href="#myModal" data-toggle="modal" id="<?php echo $employee->employee_id; ?>" data-target="#inactive-employee"
                            <i  class="fa fa-power-off fa-lg" style="color:green;" class="hidden"  data-toggle="tooltip" data-placement="left" title="Inactive employee"></i></a>

                            <a href="<?php echo base_url(); ?>app/employee/employee_profile/<?php echo $employee_id; ?>"><i class="fa fa-file-text fa-lg pull-right" style="color:blue;" class="hidden"  data-toggle="tooltip" data-placement="left" title="View <?php echo $employee->name?>'s 201 Record" onclick='employee_profile($employee->employee_id)' ></i></a> 

                        </td>
                      </tr>
                      <?php }?>
                    </tbody>
                  </table>

                  <script>
                    $(function () {

        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
                  </script>