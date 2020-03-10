

<div id='refresh_main'></div>
<br>
    <ol class="breadcrumb">
      <h4 class="text-danger"> 
        <i class="fa fa-list">Approver List Filtering</i>
      </h4>
    </ol>
  <div class="panel panel-danger"  id='action_trans'>
    <div class="col-md-12"><br> 
      <div id="refresh_flashdata" style="padding-bottom: 10px;"></div>
      
        <div style="height:80px;">

          <div class="col-md-12">
           

              <div class="col-md-2"> </div>
              <div class="col-md-8">
                    <div class="col-md-12">
                      <select class="form-control" id="company_viewing" onchange="get_all_filtering_viewing(this.value);">
                          <option value="">Select Company</option>
                          <?php foreach($companyList as $company){?>
                                 <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
                          <?php } ?>
                      </select>
                    </div>
                    
                    <div class="col-md-12" style="padding-top: 2px;">
                    <select class="form-control" id="transaction_viewing" onchange="get_approver_viewing();">
                    <option value="All" selected>All Transaction</option>
                         <?php
                           foreach ($file_t as $transactions)
                            { ?>
                              <option value="<?php echo $transactions->id?>"><?php echo $transactions->form_name?> </option>
                           <?php }  ?>
                    </select>
                    </div>

                    <div class="col-md-12" style="padding-top: 2px;">
                    <select class="form-control" id="department_viewing">
                        <option value="" selected disabled> Select Department</option>
                    </select>
                    </div>

                    
                   <div class="col-md-12" style="padding-top: 2px;">
                    <select class="form-control" id="classification_viewing">
                        <option value="" selected disabled> Select Classification</option>
                    </select>
                  </div>


                  <div class="col-md-12" style="padding-top: 2px;">
                    <select class="form-control" id="location_viewing">
                        <option value="" selected disabled> Select Location</option>
                    </select>
                  </div>

                  <div class="col-md-12" style="padding-top: 2px;">
                    <select class="form-control" id="approver_viewing">
                        <option value="" selected disabled>All Approvers</option>
                    </select>
                  </div>
                 

                  <div class="col-md-12" style="padding-top: 5px;padding-bottom: 2px;">
                    <button class="col-md-12 btn btn-info" onclick="get_allfiltering_viewing()"><i class="fa fa-arrow-right"></i>Filter</button>
                  </div>

              </div>
              <div class="col-md-2"> </div>
          </div>
          <br><br><br><br><br><br><br><br><br><br><br><br><br><br>

          <div class="box box-default" class='col-md-12'></div>



          <div class="col-md-12"  id="viewing_main_page_here">


          </div>


      </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>      

