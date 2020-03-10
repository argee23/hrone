<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Job Analytics</h4></ol>
<div class="box-body">
    <div id="MassUploading">
        <div class="well">
              <div class="MassUploading" style="height: 80px;">

                  <div class="col-md-12">
                          <div class="col-md-4">
                              <center><label>Department</label></center>
                              <select class="form-control" id="fdepartment">
                                <option value="" selected disabled>Select Department</option>
                                 <?php foreach($department as $d){?>
                                    <option value="<?php echo $d->department_id;?>"><?php echo $d->dept_name;?></option>
                                 <?php } ?>
                              </select>
                          </div>

                          <div class="col-md-3">
                              <center><label>Location</label></center>
                             <select class="form-control" id="flocation">
                                 <option value="" selected disabled>Select Location</option>
                                 <?php foreach($location as $l){?>
                                    <option value="<?php echo $l->location_id;?>"><?php echo $l->location_name;?></option>
                                 <?php } ?>
                              </select>
                          </div>

                          <div class="col-md-4">
                              <center><label>Plantilla</label></center>
                              <select class="form-control" id="fplantilla">
                                   <option value="" selected disabled>Select Plantilla</option>
                                 <?php foreach($plantilla as $p){?>
                                    <option value="<?php echo $p->id;?>"><?php echo $p->plantilla_no;?></option>
                                 <?php } ?>
                              </select>
                          </div>

                          <div class="col-md-1" style="margin-top: 24px;">
                              <button class="col-md-12 btn btn-success pull-right btn-sm" onclick="job_filtering_analytics('<?php echo $company_id;?>');"><i class="fa fa-arrow-right"></i>Filter</button>
                          </div>
                  </div>
        </div>
    </div>
</div>

 <div class="box box-default" class='col-md-12'></div>

<div class="col-md-12" id="job_analytics_filtering">
      <table class="table table-bordered" id="job_analytics">
                      <thead>
                         <tr class="danger">
                          <th>No</th>
                          <th>Company</th>
                          <th>Position</th>
                          <th>Slot</th>
                          <th>Current Available</th>
                           <?php foreach($status as $stat)
                          {?>
                          <th><?php echo $stat->status_title;?></th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                       
                      </tbody>
              </table>
</div>