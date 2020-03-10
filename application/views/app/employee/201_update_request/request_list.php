<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Change of Information Request</h4></ol>
<div id="action_main">
  <div class="panel panel-danger">
    <div class="col-md-12"><br>
     <div style="height:100px;" id='filtering' >

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
                <table id="request_table" class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th style="width:15%;">Employee ID</th>
                    <th style="width:20%;">Name</th>
                    <th style="width:55%;">201 Request</th>
                    <th style="width:5%;">Status</th>
                    <th style="width:5%;">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($request as $row){?>
                  <tr>
                    <td><?php  echo $row->employee_id;?></td>
                    <td><?php echo $row->fullname?></td>
                  
                    <td><?php echo $row->company_name?> </td>
                    </td>
                    <td><?php echo $row->status?></td>
                    <td><a class='fa fa-arrow-circle-right' aria-hidden='true' data-toggle='tooltip' title='Click to view details!' onclick="view_update_request(<?php echo $row->employee_id?>);"></a></td>
                  </tr>
                <?php }?>
                </tbody>
            </table>
          </div>
      </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
     </div>
  </div>  
  </div>           

