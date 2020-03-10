<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>View New Section Manager</h4></ol>
        
  <div class="panel panel-danger">
    <div class="col-md-12"><br>
     <div style="height:80px;" id='filtering' >
          <div class="col-md-4">
                <div class="col-md-4"><label>Company</label></div>
                <div class='col-md-8'>  
                    <select class="form-control" id='company' onchange="load_list(),filter_division();" > 
                              <option selected disabled value="0">Select</option>
                               <?php 
                              foreach($companyList as $company){
                                echo "<option value='".$company->company_id."' >".$company->company_name."</option>";
                              }
                              ?>
                        </select>
                </div>
          </div>
           <div class="col-md-4">
                <div class="col-md-4"><label>Division</label></div>
                <div class='col-md-8' >
                    <select class="form-control" id='division' onchange="load_withdivision(),filter_dept();">
                        <option value="0">Select</option>
                    </select>
                </div>
          </div>
           <div class="col-md-4"> 
                <div class="col-md-4"><label>Department</label></div>
                <div class='col-md-8'>
                    <select class="form-control" id='department'  onchange="load_withdepartment(),filter_section();">
                        <option>Select</option>
                    </select>
                </div>
          </div>

           <div class="col-md-4" style='padding-top: 5px;'>
                <div class="col-md-4"><label>Section</label></div>
                <div class='col-md-8'>
                    <select class="form-control" id='section' onchange="load_withsection(),filter_subsection();">
                        <option>Select</option>
                    </select>
                </div>
          </div>
           <div class="col-md-4" style='padding-top: 5px;'>
                <div class="col-md-4"><label>Subsection</label></div>
                <div class='col-md-8'>
                    <select class="form-control" id='subsection' onchange="load_withsubsection(),filter_location();">
                        <option>Select</option>
                    </select>
                </div>
          </div>
           <div class="col-md-4" style='padding-top: 5px;'>
                <div class="col-md-4"><label>Location</label></div>
                <div class='col-md-8'>
                    <select class="form-control" id='location' onchange="load_withlocation();">
                        <option>Select</option>
                    </select>
                </div>
          </div>

      </div>
        <div class="box box-danger" class='col-md-12'></div>
        <div style="height:295px;">
          <div class="col-md-12" id='viewing_filtering'>
                <table id="view_section_manager" class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th>Company ID</th>
                    <th>Manager</th>
                    <th>Division</th>
                    <th>Department</th>
                    <th>Section</th>
                    <th>Subsection</th>
                    <th>Location</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($sectionmgrsList as $row) {?>
                  <tr>
                    <td><?php echo $row->company_id."=".$row->division_name?></td>
                    <td><?php echo $row->first_name." ".$row->last_name?></td>
                    <td><?php echo $row->division_name?></td>
                    <td><?php echo $row->dept_name?></td>
                    <td><?php echo $row->section_name?></td>
                    <td><?php echo $row->subsection_name?></td>
                    <td><?php  if($row->loc=='All'){ echo"All"; } else{ echo  $row->location_name; } ?></td>
                    <td>
                        <a onclick="delete_manager_one('<?php echo $row->id?>','<?php echo $row->company_id?>')"><i  class="fa fa-remove fa-lg text-danger pull-left"></i></a>
                        <?php if($row->InActive==0)
                        {?>
                        <a onclick="status_manager_one('<?php echo $row->company_id?>','<?php echo $row->id?>','1');"><i  class="fa fa-power-off fa-lg text-success pull-left"></i></a>
                        <?php } else{ ?>
                          <a onclick="status_manager_one('<?php echo $row->company_id?>','<?php echo $row->id?>','0');"><i  class="fa fa-power-off fa-lg text-danger pull-left"></i></a>
                        <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
                </tbody>
       </table>
     

          </div>
      </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>             

