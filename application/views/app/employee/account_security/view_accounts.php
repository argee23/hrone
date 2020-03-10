        <div class="col-md-4" style="padding: 1% 0 ">
        <button type="button" class="btn btn-primary" onclick="exportToExcel()">
        <i class="fa fa-file-excel-o fa-fw text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Export To Excel"></i> Export to Excel
        </button>
        </div>
        <div class="col-md-12">
        <table id="users" class="table table-bordered table-striped">       
                    <thead>
                      <tr>
                        <th>EMP ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Location</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Status</th>
                        <th>Date Change Password</th>
                        <th>Option</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($users as $user){ ?>

                      <tr>
                        <td><?php echo $user->employee_id?></td>
                        <td><?php echo $user->last_name?></td>
                        <td><?php echo $user->first_name?></td>
                        <td><?php echo $user->location_name?></td>
                        <td><?php echo $user->username?></td>
                        <td><?php echo $user->password?></td>
                        <td><?php if($user->InActive == 0){
                                    echo "Active";
                                }
                                else{
                                    echo "InActive";
                                }
                        ?>  
                        </td>
                        <td><?php echo $user->passChangeDate?></td>
                        <td>

                            <i class="fa fa-pencil-square fa-fw fa-lg text-primary" aria-hidden="true"  data-toggle="tooltip" data-placement="left" title="Edit Password" onclick="changePassword('<?php echo $user->id ?>')"></i>
                             
                        </td>
                      </tr>
                      <?php }?>
                     
                    </tbody>
        </table>
        </div>