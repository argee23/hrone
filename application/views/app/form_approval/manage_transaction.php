<?php
  /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $add_form_approver=$this->session->userdata('add_form_approver');
    $transfer_form_approver=$this->session->userdata('transfer_form_approver');
    $system_defined_icons = $this->general_model->system_defined_icons();

    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>

<div id='refresh_main'></div>
<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i><?php echo $trans_name?>
    <?php if($trans_id==1){ ?>
     <a class='btn btn-default btn-xs pull-right' onclick="request_form(<?php echo $trans_id?>);" style="margin-right: 5px;" >Add Request Form</a> 
    <?php } else{}?>
    <a class='btn btn-warning btn-xs pull-right' onclick="status_setting(<?php echo $trans_id?>);" style="margin-right: 5px;" >Auto Approve/Cancel/Reject Form Settings</a>
    <a class='<?php echo $transfer_form_approver;?> btn btn-danger btn-xs pull-right'  style="margin-right: 5px;" onclick="transfer_approver('<?php echo $identification?>');">Transfer of Approver</a> 
     
    <a class='<?php echo $add_form_approver;?> btn btn-primary btn-xs pull-right' style="margin-right: 5px;" onclick="add_approver(<?php echo $trans_id?>);">Add Approver</a></h4></ol>
  <div class="panel panel-danger"  id='action_trans'>
    <div class="col-md-12"><br> 
      <div id="refresh_flashdata" style="padding-bottom: 10px;"></div>
        <?php if($this->session->flashdata('success_inserted') AND $action_=='add')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Company ID - '.$flash_id.' New Form Approver is Successfully Added.</center></n></div>';
            } 
            else{}?>
        <div style="height:80px;">

          <div class="col-md-12">
                
              <div class="col-md-2"> </div>
              <div class="col-md-8">
                    <div class="col-md-12">
                      <select class="form-control" id="company_viewing" onchange="get_classification_viewing(this.value,'<?php echo $trans_id;?>');">
                          <option value="" selected disabled> Select Company</option>
                          <?php foreach($companyList as $company){?>
                                 <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
                          <?php } ?>
                      </select>
                    </div>
                    
                    <div class="col-md-12" style="padding-top: 2px;">
                    <select class="form-control" id="department_viewing">
                        <option value="" selected disabled> Select Department</option>
                    </select>
                    </div>

                    <?php if($trans_id==2){?>
                    <div class="col-md-12" style="padding-top: 2px;">
                    <select class="form-control" id="leavetype_viewing">
                        <option value="" selected disabled> Employee Leave</option>
                       
                    </select>
                  </div>
                  <?php } else{ echo "<input type='hidden' value='not_included' name='leavetype_viewing' id='leavetype_viewing'>"; } ?>
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
                  <div class="col-md-12" style="padding-top: 5px;padding-bottom: 2px;">
                    <button class="col-md-12 btn btn-info" onclick="get_company_viewing('<?php echo $trans_id;?>')"><i class="fa fa-arrow-right"></i>Filter</button>
                  </div>

              </div>
              <div class="col-md-2"> </div>
          </div>
          <br><br><br><br><br><br><br><br><br><br><br><br>

          <div class="box box-default" class='col-md-12'></div>



          <div class="col-md-12"  id="viewing_main_page_here">


          </div>


      </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>      

