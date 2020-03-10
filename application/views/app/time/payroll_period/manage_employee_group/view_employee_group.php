

<div class="box box-primary">
  <div class="box-header">
  <div class="panel panel-info">
    <div class="panel-heading"><strong><?php echo $group_name->group_name; ?></strong> <?php if($group_name->InActive === '1'){ echo 'InActive'; } ?>

     <?php if($group_name->InActive === '0'){ ?>

    <a href="#myModal" data-toggle="modal" id="<?php echo $this->uri->segment("4"); ?>" data-target="#add_employee">

    <?php
echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x pull-right" style="color:'.$system_defined_icons->icon_add_color.';" "  data-toggle="tooltip" data-placement="left" title="Click To Enroll / Add Employee(s)To This Group"></i>';
    ?>


    </a>
    <?php } ?>
    
    </div>

    
    </div>

    <div id="search_here">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Employee ID</th>
          <th>Employee Name</th>
          <th>Pay type</th>
          <th>Member Status</th>
          <th>Location/Classification</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
       <?php if(count($employee_group_count) > 0){ ?>
       <?php foreach($employee_group as $employee){ 

              $company_id=$employee->company_id;
              $location=$employee->location; //location id
              $classification=$employee->classification; //classification id

        require(APPPATH.'views/include/loc_class_restriction.php');

        if($allowed>0){ // check this variable at loc_class_restriction
        ?>
        <tr>
          <td><?php echo $employee->employee_id;?></td>
          <td><?php echo $employee->first_name.' '.$employee->last_name.' '.$employee->middle_name.' '.$employee->name_extension?></td>
          <td><?php echo $employee->pay_type_name ?></td>
          <td>
          <?php 

          if($group_name->InActive == '0'){ 
            if($employee->InActive == '0'){ 
              echo 'Active';
            }else{
              echo 'InActive';
            }
          }else{
              echo 'InActive';
          } 

          ?>
          </td>
          <td><?php echo $employee->location_name." / ".$employee->class_name?></td>
          <td>
              <?php 
              if($group_name->InActive == '0'){ 
              if($employee->InActive == '0'){ 
              ?>
                <!-- // Click to inactive employee  -->
                <a href="<?php echo site_url('app/time_payroll_period/inactivate_employee/'. $employee->employee_id.''); ?>" onClick="return confirm('Are you sure you want to inactive employee as a member of this group?')">
                <i  class="fa fa-<?php echo $system_defined_icons->icon_disable." fa-".$system_defined_icons->icon_size."x "; ?>" style="color:<?php echo $system_defined_icons->icon_disable_color; ?>"  data-toggle="tooltip" data-placement="left" title="Click to inactive employee as a member of this group"></i></a>

              <?php }

              if($employee->InActive == '1'){ ?>
                <!-- // Click to activate employee  -->
                <a href="<?php echo site_url('app/time_payroll_period/activate_employee/'. $employee->employee_id.''); ?>" onClick="return confirm('Are you sure you want to activate employee as a member of this group?')">
                <i  class="fa fa-<?php echo $system_defined_icons->icon_enable." fa-".$system_defined_icons->icon_size."x "; ?>" style="color:<?php echo $system_defined_icons->icon_enable_color; ?>"  data-toggle="tooltip" data-placement="left" title="Click to activate employee as a member of this group "></i></a>

              <?php 
              }  } 
              if($group_name->InActive == '1'){
              echo 'InActive';
              } 
              ?>

            <a href="<?php echo site_url('app/time_payroll_period/remove_employee/'. $employee->employee_id.''); ?>" onClick="return confirm('Are you sure you want to remove employee from this group?')">
            <i  class="fa fa-<?php echo $system_defined_icons->icon_delete." fa-".$system_defined_icons->icon_size."x "; ?>" style="color:<?php echo $system_defined_icons->icon_delete_color; ?>"  data-toggle="tooltip" data-placement="left" title="Click to remove employee as a member of this group "></i></a>


          </td>

        </tr>
        <?php 
     }else{
      //echo "location not allowed.";
     }

      } 
        }?>
      </tbody>
    </table>
    </div>
  </div><!-- /.box-body -->
</div><!-- /.box -->

<!-- Modal for adding employee to the group -->
<div id="add_employee" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">


<!-- //======= start added-->
            <div class="box box-success">
              <div class="panel panel-success">
                <div class="panel-heading"><strong>ENROLL VIA SELECTING ALL EMPLOYEE OF A SELECTED LOCATION</strong>
     
                    </div>
            </div>

                  <div class="box-body">
                    <div class="col-md-12">
<form method="post" action="<?php echo base_url()?>app/time_payroll_period/master_save_group_mem/<?php echo $this->uri->segment("4");?>" >
<input type="hidden" name="c_company_id" value="<?php echo $c_company_id?>">
<input type="hidden" name="c_pay_type_id" value="<?php echo $c_pay_type_id?>">
                   <?php
                        if(!empty($comp_loc)){
                          foreach($comp_loc as $l){
                            echo '<input type="checkbox" value="'.$l->location_id.'" name="loc[]"><b>'.$l->location_name.'</b> Employees<br>';
                          }
                        }else{

                        }
                        ?>
<button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-user-plus"></i> SAVE</button>
          

</form>
                    </div>
                   

                    </div>

            </div>
<!-- //================= end added-->

            <div class="box box-success">
              <div class="panel panel-success">
                <div class="panel-heading"><strong>ENROLL VIA SELECTING A SPECIFIC EMPLOYEE</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                </button>
                </div>
            </div>

              <form method="post" action="<?php echo base_url()?>app/time_payroll_period/save_employee_group/<?php echo $this->uri->segment("4");?>" >

                  <div class="box-body">
                    <div class="modal-body">
                    <div class="col-md-12">

                        <table id="example2" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th style="text-align: center;"><!-- <input type="checkbox" class="chk_boxes" data="1" label="check all"  />check all --></th>
                              <th>Employee ID</th>
                              <th>Employee Name</th>
                              <th>Location</th>
                            </tr>
                          </thead>
                          <tbody>
                           <?php 
                           foreach($available_employee as $employee){ 
                            ?>

                            <tr>
                              <td>
                                <input type="checkbox" name="employeeselected[]" class="case" name="case" value="<?php echo $employee->employee_id?>"></td>
                              <td><?php echo $employee->employee_id?> </td>
                              <td><?php echo $employee->first_name.' '.$employee->last_name.' '.$employee->middle_name.' '.$employee->name_extension?></td>
                            <td><?php echo $employee->location_name?> </td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                    </div>
                    </div>
                    <br>
                        <button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-user-plus"></i> ADD</button>
                  </div><!-- /.box-body -->
            </form>
        </div>
    </div>

</div>
<!-- End  Modal for adding employee to the group -->