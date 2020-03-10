<div class="box box-success">
  <div class="panel panel-info">
    <div class="col-md-12"><br>
      <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Account Management Settings| Add New Policy</h4></ol>
        <div style="height:295px;">
          <div class="col-md-12">
            <div class="panel panel-success">
               <div class="panel-body" id="main_result">
                <div class="col-md-12">
                    <div class='col-md-12' style="padding-bottom: 10px;">
                      <div class="col-md-2">
                        <label>Policy Option:</label>
                      </div>
                      <div class="col-md-10">
                        <select class="form-control" onchange="option(this.value);" id='options'>
                          <option selected disabled value=''>Select Option</option>
                          <option value='account_sec'>Account Security</option>
                          <option value="govt_fields">Government Fields</option>
                          <option value='dis_acct'>Disable Account</option>
                          <option value='notif'>Newly hired welcome notification on employees portal</option>
                          <option value='mob_tel'>Set up mobile and telephone number format</option>
                          <option value='others'>Others</option>
                        </select>
                      </div>
                    </div>
                    <div class='col-md-12' style="padding-bottom: 10px;" id="option_results">
                    </div>
                    
                    <div class='col-md-12'>
                      <div class='col-md-12'>
                      <button class='btn btn-success pull-right' onclick="save_policy();">Save</button>
                      </div>
                    </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>             
</div>
