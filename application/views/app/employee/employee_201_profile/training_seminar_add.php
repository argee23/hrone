<div class="row">
  <div class="col-md-8">
    <div class="box box-warning">
      <div class="panel panel-warning">
        <div class="panel-heading"><strong>TRAINING AND SEMINAR ATTAINMENTt</strong> (add)</div>
          <div class="box-body">

              <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_training_seminars_final/save_individual_adding/employee_adding" >

                      <div class="col-md-12" style="margin-top: 5px;">

                        <div class="col-md-6">
                            <div class="col-md-4"><label>Employee ID</div>
                            <div class="col-md-8">
                              <input type="text" class="form-control" name="employee_id" id="employee_id" value="<?php echo $employee_id;?>" readonly >
                              <input type="hidden" class="form-control" name="company" id="company" required value="<?php echo $company_id;?>">
                            </div>
                            
                        </div>

                        <div class="col-md-6">
                            <div class="col-md-4"><label>Training Type</label></div>
                              <div class="col-md-8">
                                <select class="form-control" id="training_type" name="training_type" onchange="get_all_trainings_individual(this.value,'employee');" required>
                                  <option value="" disabled selected>Select</option>
                                  <option value="training">Training</option>
                                  <option value="seminar">Seminar</option>
                                </select>
                            </div>
                        </div>
                      </div>

                      <div class="col-md-12" style="margin-top: 5px;">
                        <div class="col-md-6">
                            <div class="col-md-4"><label>Sub Type</label></div>
                              <div class="col-md-8">
                                <select class="form-control" id="sub_type" name="sub_type" required onchange="get_all_trainings_individual(this.value,'employee');">
                                    <option disabled selected value="">Select Sub Type</option>
                                    <option value="internal">Internal(conducted by the company)</option>
                                    <option value="external">External(conducted by other agency/company)</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="col-md-4"><label>Training Title</label></div>
                              <div class="col-md-8">
                                <select class="form-control" id="title" name="title" required onchange="get_all_trainings_details(this.value);">
                                    <option disabled selected>Select Training and Seminar</option>
                                </select>
                            </div>
                        </div>

                    

                      </div>

                      <div class="col-md-12"><hr class="c"></div>

                      <div class="col-md-12" style="margin-top: 5px;" id="for_training_details">

                      </div>


              </form>
            </div>
          </div>
      </div>
    </div>
  </div>

  <style type="text/css">
      hr.c {
          border: 1px solid yellowgreen;
        }
  </style>