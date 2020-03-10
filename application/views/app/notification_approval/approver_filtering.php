 
   <div class="col-md-12"><br> 
   <div style="height:80px;">

          <div class="col-md-12">

            <div class="col-md-12">

             <div class="col-md-12">
              <div class="col-md-2"></div>
              <div class="col-md-8">
                <input type="hidden" id="Company_result" value="<?php echo $company;?>">
                <select class="form-control" id='Notification_result' onchange="get_filtering_result_company();">
                   
                    <?php if($notificationList==0)
                    {
                      echo "<option value='not_included'>No Notification Found.</option>";
                    }
                    else
                    {
                      echo "<option value='all'>All Notification</option>";
                      foreach($notificationList as $n)
                      {
                        echo "<option value='".$n->id."'>".$n->form_name."</option>";
                      }
                    }?>
                </select>
              </div>
               <div class="col-md-2"></div>
             </div>


              <div class="col-md-4" style="padding-top: 5px;">
                <select class="form-control" id="Division_result" onchange="load_department(this.value,'<?php echo $company;?>');">
                <?php if($with_division == 0)
                {

                  echo "<option value='not_included'>No division required in this company. You can proceed now to next field.</option>";
                }
                else
                {
                  if(empty($get_division))
                  {
                    echo "<option value='not_included'>No division found. Please add to continue filtering.</option>";
                  }
                  else
                  {
                     echo "<option value='not_included'>Select Division</option>";
                    foreach($get_division as $div)
                    {
                        echo "<option value='".$div->division_id."'>".$div->division_name."</option>";
                    }
                  }
                }
                ?>
                </select>
              </div>

              <div class="col-md-4" style="padding-top: 5px;">
                <select class="form-control" id="Department_result" onchange="load_section(this.value,'<?php echo $company;?>');">
                <?php if($with_division==0)
                {
                  if(empty($get_department))
                  {
                     echo "<option value='not_included'>No department found.Please add to continue filtering.</option>";
                  }
                  else
                  {
                    echo "<option value='not_included'>Select Department</option>";
                    foreach($get_department as $de)
                    {
                        echo "<option value='".$de->department_id."'>".$de->dept_name."</option>";
                    }
                  }
                ?>

                  
               <?php }
                else
                {
                  echo '<option disabled selected value="not_included">Select Department</option>';
                }
                ?>
                </select>
              </div>


               <div class="col-md-4" style="padding-top: 5px;">
                <select class="form-control" id="Section_result" onchange="load_subsection(this.value);">
                  <option disabled selected value="not_included">Select Section</option>
                </select>
              </div>

              <div class="col-md-4" style="padding-top: 5px;">
                <select class="form-control" id="Subsection_result" onchange="get_filtering_result_company();">
                  <option disabled selected value="not_included">Select Subsection</option>
                </select>
              </div>


              <div class="col-md-4" style="padding-top: 5px;">
                <select class="form-control" id="Location_result" onchange="get_filtering_result_company();">
                    <?php if(empty($locationList)){
                      echo '<option value="not_included">No location found.</option>';
                    }
                    else
                    {
                       echo '<option value="not_included">Select Location</option>';
                      foreach($locationList as $loc)
                      {
                        echo '<option value="'.$loc->location_id.'">'.$loc->location_name.'</option>';
                      }
                    }
                    ?>
                </select>
              </div>

              <div class="col-md-4" style="padding-top: 5px;">
                <select class="form-control" id="Classification_result" onchange="get_filtering_result_company();">
                  <?php if(empty($classificationList)){
                  echo '<option value="not_included">No Classification found.</option>';
                  }
                  else
                  {
                    echo '<option value="not_included">Select Classification</option>';
                    foreach($classificationList as $c)
                    {
                      echo '<option value="'.$c->classification_id.'">'.$c->classification.'</option>';
                    }
                  }?>
                </select>
              </div>



            </div>


          </div><br><br><br><br><br><br>

           <div class="box box-danger" class='col-md-12'></div>
            <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
          
          <div class="col-md-12"  style="overflow: scroll;" id="filter_result">
            <table id="salary_approvers" class="col-md-12 table table-hover table-striped">
                <thead>
                  <tr  class="success">
                    <th style="width:5%;">ID</th>
                    <th style="width:15%;">Name</th>
                    <th style="width:10%;">Notification</th>
                    <th style="width:15%;">Company ID</th>
                    <th style="width:10%;">Section</th>
                    <th style="width:10%;">Subsection</th>
                    <th style="width:5%;">Approval Level</th>
                    <th style="width:15%;">Classification</th>
                    <th style="width:15%;">Location</th>
                    <th style="width:5%;">Action</th>
                  </tr>
                </thead>
                <tbody> 
                  <?php foreach($details as $d){?>
                    <tr>
                        <td><?php echo $d->idd;?></td>
                        <td><?php echo $d->fullname;?></td>
                        <td><?php echo $d->form_name;?></td>
                        <td><?php echo $d->company_name;?></td>
                        <td><?php echo $d->section_name;?></td>
                        <td><?php echo $d->subsection_name;?></td>
                        <td>
                          <?php 
                              $x=$d->approval_level;
                               if($x=="1"){
                                    $ext="st";
                                  }else if($x=="3"){
                                    $ext="rd";
                                  }else if($x=="2"){
                                    $ext="nd";
                                  }else{
                                    $ext="th";
                                  }
                              echo $d->approval_level.$ext." Approver "?>
                        </td>
                        <td><?php echo $d->classification_name;?></td>
                        <td><?php echo $d->location_name;?></td>
                        <td>
                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  onclick="delete_notif_oneapprover('<?php echo $company;?>','<?php echo $d->idd;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Approver'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                        </td>
                    </tr>
                  <?php } ?>
                </tbody>
       </table>  
        </div>
      </div>
      </div>
