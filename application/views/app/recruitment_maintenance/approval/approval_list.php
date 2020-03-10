<div class="col-md-12">

  <div class="col-md-12">
    
    
    <div class="col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-3">

        <div class="col-md-12">
          <select class="form-control" id="department">
              <option disabled selected value="">Select Department</option>
              <option value="All">All</option>
              <?php foreach($department as $d){?>
                  <option value="<?php echo $d->department_id;?>"><?php echo $d->dept_name;?></option>
              <?php } ?>
          </select>
        </div>

        <div class="col-md-12" style="margin-top: 5px;">
          <select class="form-control" id="location">
              <option disabled selected value="">Select Location</option>
              <option value="All">All</option>
              <?php foreach($location as $l){?>
                  <option value="<?php echo $l->location_id;?>"><?php echo $l->location_name;?></option>
              <?php } ?>
          </select>
        </div>

        <div class="col-md-12" style="margin-top: 5px;"><button class="col-md-12 btn btn-success btn-xs" onclick="filter_approvals('<?php echo $company_id;?>');">FILTER</button></div>

    </div>
    <br><br><br><br><br><br>
    <div class="box box-danger" class='col-md-12'></div>

  </div>

</div>

<div class="col-md-12" id="list"><br>
         <?php if(count($request) > 1){?>
                        <div class="col-md-12" style="margin-bottom: 10px;">
                            <a class="btn btn-primary btn-xs pull-right" href="<?php echo base_url();?>/app/recruitment_job_request_approval/mass_approval/<?php echo $company_id;?>" data-toggle="tooltip" title="Mass Approval">Mass Approval</a>
                        </div>
                      <?php } ?>
  <div class="col-md-12">
    <table id="request_list" class="table table-bordered table-striped">
      <thead>
            <tr class="danger">
              <th>Doc Number</th>
              <th>Employee</th>
              <th>Date Filed</th>
              <th>Department</th>
              <th>Location</th>
              <th>Details</th>
            </tr>        
      </thead>
      <tbody>
        <?php foreach($request as $r){?>
            <tr>
              <td>
                 <a style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/recruitment_job_request_approval/approve_request')."/".$r->doc_no."/".$r->section_manager;?>"><?php echo $r->doc_no;?></a>
              </td>
              <td><?php echo $r->fullname;?></td>
              <td>
                  <?php 
                    $month=substr($r->date_added, 5,2);
                    $day=substr($r->date_added, 8,2);
                    $year=substr($r->date_added, 0,4);
                    echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                  ?>
              </td>
              <td><?php echo $r->dept_name;?></td>
              <td><?php echo $r->location_name;?></td>
              <td> 
                  <a style="cursor: pointer;" href="<?php echo base_url();?>employee_portal/recruitment_job_vacancy_request_list/view/<?php echo $r->id; ?>"  target="_blank"><span class="badge bg-green">View Details</span></a>
              </td>
            </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

</div>  