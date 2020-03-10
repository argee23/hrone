<?php
$comp_id=$this->uri->segment('4');
?>

<input type="hidden" name="comp_id" id="company_id" value="<?php echo $comp_id;?>">
            <div class="box box-primary">
        
                <div class="box-header">

                <div class="btn-toolbar">
                  <a href="#filter" role="button" data-toggle="collapse" class="col-md-12 btn btn-primary btn-sm "><i class="fa fa-arrow-down"></i> Filter Location</a>
                </div>
<div class="collapse" id="filter">

<div class="col-md-12">

                        <div class="form-group">
                          <select class="form-control" name="location" id="location" style="width: 100%;" onchange="applyFilterlocation();">
                            <option value="" disabled selected>-Select-</option>
                            <option value="" >-All Location-</option>
                            <?php 
                            $myloc=$this->general_model->get_company_locations($comp_id);
                              foreach($myloc as $loc){
                              ?>
                              <option value="<?php echo $loc->location_id;?>" ><?php echo $loc->location_name;?></option>
                              <?php }?>
                          </select>
                        </div>
          
</div>

</div>




                  <div id="search_here">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <!-- <th>Company</th> -->
                        <th>Location/Classification</th>
    <!--                     <th>Department</th>
                        <th>Section</th> -->
                        <th>Option</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      foreach($comp_employees as $employee){ 
                       $company_id=$employee->company_id;
                       $location=$employee->location;
                       $classification=$employee->classification;
                        ?>
                      <tr>
                        <td><?php echo $employee->employee_id?></td>
                        <td><?php echo $employee->name?></td>
                        <!-- <td><?php //echo $employee->company_name ?></td> -->
                        <td><?php echo $employee->location_name."/".$employee->classification_name; ?></td>
         <!--           <td><?php //echo $employee->dept_name?></td>
                        <td><?php //echo $employee->section_name?></td> -->
                        <td>


                         <a onclick="view_attendance('<?php echo $employee->employee_id?>')" type="button" data-toggle="tooltip" data-placement="left" title="View <?php echo $employee->name?>'s Attendance" ><i class="fa fa-<?php echo $system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x'?> style='color:<?php echo $system_defined_icons->icon_view_color;?>' "></i></a>

                        </td>
                      </tr>
                      <?php 
          

                      }?>
                    </tbody>
                  </table>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->