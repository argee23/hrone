<!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">

    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

                  <table id="user_table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>User ID</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>User Role</th>
                    <th>Department</th>
                    <th>Section</th>
                    <th>Status</th>
                    <th>Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($user as $user){if($user->InActive == 0){ $inactive = 'Active';}else{ $inactive = 'Inactive';}?>

                  <tr>
                    <td><?php echo $user->employee_id?></td>
                    <td><?php echo $user->employee_id?></td>
                    <td><?php echo $user->name?></td>
                    <td><?php echo $user->role_name?></td>
                    <td><?php echo $user->dept_name?></td>
                    <td><?php echo $user->section_name?></td>
                    <td><?php echo $inactive?></td>
                    <td>
                        <a href="<?php echo base_url()?>app/user/edit_user"><i class="fa fa-pencil-square-o fa-lg text-primary pull-right" data-toggle="tooltip" data-placement="left" title="Modify <?php echo $user->name?>'s User Account"></i></a>
                        <a href="<?php echo base_url()?>app/user/delete_user"><i class="fa fa-times-circle fa-lg text-danger pull-right" data-toggle="tooltip" data-placement="left" title="Delete <?php echo $user->name?>'s User Account"></i></a>
                    </td>
                  </tr>
                  <?php }?>
                </tbody>
              </table>
                  <script>
                    $(function () {

                      $("#user_table").DataTable();
                    });
                  </script>