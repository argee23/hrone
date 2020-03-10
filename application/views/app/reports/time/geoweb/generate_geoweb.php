<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#time_quick_gen" data-toggle="tab"><i class="fa fa-file text-info"></i> Generate Report<span class="text-danger">(Without Filtering)</span></a></li>
        <li><a href="#time_w_filtering" data-toggle="tab"><i class="fa fa-folder text-warning"></i> Generate Report<span class="text-info">(With Filtering)</span></a></li>
    </ul>

    <div class="tab-content">
      <div class="active tab-pane" id="time_quick_gen">
        <div class="box box-default">
          <div class="box-body">
                      <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/reports_time_geoweb/quick_generate_geoweb/" target="_blank">
                            <div class="col-md-12">
                                <div class="col-md-3 bg-danger">Report Type<small><i> ( Note: You must create a report fields contents at 'Attendance Geoweb Crystal Report'. Those report types you created will be the choices in this area <i class="fa fa-arrow-right"></i> )</i> </small></div>
                                <div class="col-md-6"> 
                                  <select class="form-control" name="report" required>
                                    <option value="default">Default Crystal Report</option>
                                    <?php foreach ($crystal_report as $row) {?>
                                     <option value="<?php echo $row->report_id?>"><?php echo $row->report_name?></option>
                                    <?php } ?>
                                  </select><br>
                                </div>
                            </div> 

                            <div class="col-md-12" style="margin-top: 10px;">
                            <div class="col-md-3">Company</div>
                            <div class="col-md-6">
                              <select class="form-control" name="company" required >
                                  <?php foreach ($companyList as $row) {?>
                                    <option value="<?php echo $row->company_id?>"><?php echo $row->company_name?></option>
                                  <?php } ?>
                              </select><br>
                            </div>
                            </div>

                          <div class="col-md-12">
                            <div class="col-md-3">Date From and To</div>
                            <div class="col-md-6">
                              <input type="date" name="date_from" class="form-control" value="<?php echo date('Y-m-d')?>"><br>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                              <input type="date" name="date_to" class="form-control" value="<?php echo date('Y-m-d')?>"><br>
                            </div>
                          </div>

                            <div class="col-md-12">
                            <div class="col-md-3">Viewing Option</div>
                            <div class="col-md-6">
                              <select class="form-control" name="option" required >
                                  <option value="punch_type">By Punch type</option>
                                  <option value="covered_date">By Covered Date</option>
                              </select><br>
                            </div>
                            </div>



                            <div class="col-md-12">
                                <div class="col-md-3">Report Result Type</div>
                                <div class="col-md-6">    
                                  <input type="radio" name="report_result_type" value="excel" checked> Excel 
                                  <input type="radio" name="report_result_type" value="browser_view"> Browser View    
                                </div>
                            </div> 
                           <div class="col-md-12">
                              <div class="col-md-3"></div>
                              <div class="col-md-6"><button class="btn btn-success col-md-3"  target="_blank">GENERATE</button>
                              </div>
                          </div>
                  </form>
            </div>
          </div>
        </div>
      </div>
</div>
           