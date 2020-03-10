
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
             <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;text-align: center;">Filter Notification/s</h4></ol>
            <div style="height: 433px";>
              
                  <div class="col-md-12"><label>Company</label></div>
                  <div class="col-md-12">
                       <select class="form-control" id="filter_company" onchange="get_notifications_filter(this.value);">
                          <option value="" disabled selected>Select</option>
                          <?php foreach($companyList as $company){?>
                            <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
                          <?php } ?>
                        </select>
                  </div>


                  <div class="col-md-12"><label>Forms</label></div>
                  <div class="col-md-12">
                         <select class="form-control" id="filter_forms">
                          
                        </select>
                  </div>


                  <div class="col-md-12"><label>Viewing Status</label></div>
                  <div class="col-md-12">
                      <select class="form-control" id="filter_status">
                          <option value="" disabled selected>Select</option>
                          <option value="all">All</option>
                          <option value="a">Acknoledge</option>
                          <option value="v">Viewed</option>
                          <option value="nv">Not yet viewed</option>
                          <option value="na">Not yet acknowledge</option>
                      </select>
                  </div>
                    
                  <div class="col-md-12"><label>Date From</label></div>
                  <div class="col-md-12">
                     <input type="date" class="col-md-6 form-control" id="filter_from">
                  </div>
                  <div class="col-md-12"><label>Date To</label></div>
                  <div class="col-md-12">
                     <input type="date" class="col-md-6 form-control" id="filter_to">
                  </div>

                  <div class="col-md-12" style="margin-top: 10px;">
                    <button class="btn btn pull-right btn-default" style="margin-left: 5px;" onclick="window.location.reload()">ADD</button>
                    <button class="btn btn pull-right btn-default" onclick="show_filter();" >FILTER</button>
                  </div>
            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  