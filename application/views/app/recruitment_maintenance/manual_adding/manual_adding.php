<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Manual Adding | Job Vacancy Request</h4></ol>
<div class="col-md-12"><br>
        
        <div class="col-md-12">

            <div class="col-md-3">
                <label>Plantilla</label>
                <select class="form-control" id="plantilla" name="plantilla">
                    <?php if(empty($plantilla)){ echo "<option value=''> No Plantilla Found.</option>"; } else{ echo "<option>All</option>"; foreach($plantilla as $p){?>
                          <option value="<?php echo $p->id;?>"><?php echo $p->plantilla_no;?></option>
                    <?php } } ?>
                </select>
            </div>

            <div class="col-md-3">
                <label>Department</label>
                <select class="form-control" id="department" name="department">
                     <?php if(empty($department)){ echo "<option value=''> No Department Found.</option>"; } else{ echo "<option>All</option>"; foreach($department as $d){?>
                          <option value="<?php echo $d->department_id;?>"><?php echo $d->dept_name;?></option>
                    <?php } } ?>
                </select>
            </div>

            <div class="col-md-3">
                <label>Location</label>
                <select class="form-control" id="location" name="location">
                     <?php if(empty($location)){ echo "<option value=''> No Department Found.</option>"; } else{ echo "<option>All</option>"; 
                     foreach($location as $l){?>
                          <option value="<?php echo $l->location_id;?>"><?php echo $l->location_name;?></option>
                    <?php } } ?>
                </select>
            </div>

            <div class="col-md-3">
                <label>Type</label>
                <select class="form-control" id="type" name="type">
                    <option>All</option>
                    <option value="new">New Job Vacancy</option>
                    <option value="additional">Additional Job Vacancy</option>
                </select>
            </div>  

            <div class="col-md-3">
                <label>Status</label>
                <select class="form-control" id="status" name="status">
                    <option>All</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Approver Type</label>
                <select class="form-control" id="approver_type" name="approver_type">
                    <option>All</option>
                    <option value="approvers">Approvers</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="col-md-3" style='margin-top:25px;'>
                <button class='col-md-12 btn btn-success btn-sm' onclick="filter_job_vacancy('<?php echo $company_id;?>');"><i class="fa fa-arrow-right"></i>&nbsp;FILTER</button>  
            </div>

        </div>

        <div class="col-md-12">
        <br><div class="col-md-12"><div class="col-md-12 box box-danger" class='col-md-12'></div></div>

            <div class="col-md-12" style="margin-top: 30px;" id="filterresult">
              <table id="request_list" class="table table-bordered table-striped">
                <thead>
                  <tr class="danger">
                    <th>Doc No</th>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Job Position</th>
                    <th>Job Vacancy</th>
                    <th>Approver Type</th>
                    <th>Date Appproved</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($request as $r){?>
                  <tr>
                    <td><?php echo $r->id;?></td>
                    <td> 
                         <a style="cursor: pointer;" href="<?php echo base_url();?>employee_portal/recruitment_job_vacancy_request_list/view/<?php echo $r->idd; ?>"  target="_blank"><?php echo $r->doc_no;?></a>
                    </td>
                    <td><?php echo $r->type;?></td>
                    <td><?php echo $r->job_title;?></td>
                    <td><?php echo $r->job_vacancy;?></td>
                    <td><?php echo $r->approver_type;?></td>
                    <td><?php echo $r->status_update_date;?></td>
                    <td>
                       <a style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/manual_adding_approved_request/manual_adding_request')."/".$r->doc_no;?>">
                            <i class="fa fa-folder"></i>
                        </a> 
                    </td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>

        </div>
</div>  
<div class="btn-group-vertical btn-block"> </div>   
     
