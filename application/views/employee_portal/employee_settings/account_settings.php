<div class="col-md-12" >
  <div class="tab-content">
    <div class="tab-pane active" id="p_info">
      <div class="panel panel-success">
        <div class="panel-heading">
          <h4 class="text-danger">Account Settings</h4>
        </div>
    <div class="panel-body" style="height:440px;">
      <table class="table table-responsive">
            <thead>
              <th style="width:20%;"></th>
              <th style="width:30%;"></th>
              <th style="width:20%;"></th>
              <th style="width:30%;">
                  <button class="btn btn-info pull-right" style="margin-right:5px;" onclick="account_settings_updateform();">Edit</button>
                  <button class="btn btn-success pull-right" style="margin-right:5px;" onclick="save_account_settings();" id="as_save" disabled>Save Changes</button>
              </th>
            </thead>
            <tbody> 
              <tr>
                <td colspan="4">
                   <?php if($this->session->flashdata('updated'))
                    { 
                      echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Account Settings is Successfully Updated.</center></n></div>';
                    }else{}?>
                </td>
              </tr>
                
              <tr class="info">
                <td colspan="2" class="text-danger"><center><b><u>Email Option</u></b></center></td>
                <td colspan="2" class="text-danger"><center><b><u>Account Display</u></b></center></td>
              </tr>
              
              <tr>
                <td>Email Address</td>
                <td><input type="text" class="form-control" value="<?php if(empty($emp_settings) || $emp_settings->email=='none') { echo $emp_details->email;} else { echo $emp_settings->email; }?>" id="email" disabled>
                <input type="hidden" class="form-control"  id="l_email"></td>
                <td>Account Display</td>
                <td>
                  <select class="form-control" id="account_display" disabled>
                      <option value="0" <?php if(empty($emp_settings) || $emp_settings->account_display==0){ echo "selected"; } else{}?>>No setting</option>
                      <option value="picture_and_info" <?php if( !empty($emp_settings) && $emp_settings->account_display=='picture_and_info'){ echo "selected"; } else{}?>>Picture and Employee Information</option>
                      <option value="empid_and_name" <?php if(!empty($emp_settings) && $emp_settings->account_display=='empid_and_name'){ echo "selected"; } else{}?>>Employee ID and Name Only</option>
                      <option value="empid" <?php if(!empty($emp_settings) && $emp_settings->account_display=='empid'){ echo "selected"; } else{}?>>Employee ID only</option>
                  </select>
                </td>
              </tr>
              <tr class="info"><td colspan="4" class="text-danger"><center><b><u>Send Email Option</u></b></center></td></tr>
               <tr>
                  <td>Transaction Status</td>
                  <td>
                      <select class="form-control" id="trans_status" disabled>
                         <option <?php if(empty($emp_settings) || $emp_settings->transaction_status=='No'){ echo "selected"; } else{}?>>No</option>
                        <option <?php if(!empty($emp_settings) && $emp_settings->transaction_status=='Yes'){ echo "selected"; } else{}?>>Yes</option>
                      </select>
                  </td>
                   <td>Notification Status</td>
                  <td>
                      <select class="form-control" id="notif_status" disabled>
                        <option <?php if(empty($emp_settings) || $emp_settings->notification_status=='No'){ echo "selected"; } else{}?>>No</option>
                        <option <?php if(!empty($emp_settings) && $emp_settings->notification_status=='Yes'){ echo "selected"; } else{}?>>Yes</option>
                      </select></td>
              </tr>
              
              <tr>
                  <td>Request For Approval</td>
                  <td>
                      <select class="form-control" id="req_approval" disabled>
                        <option <?php if(empty($emp_settings) || $emp_settings->request_approval=='No'){ echo "selected"; } else{}?>> No</option>
                        <option <?php if(!empty($emp_settings) && $emp_settings->request_approval=='Yes'){ echo "selected"; } else{}?>>Yes</option>
                      </select>
                  </td>
                  <td><?php if($if_approver==1){ echo "Request Update"; } else{ echo ""; }?> </td>
                  <td>
                      <select class="form-control" id="req_update" disabled <?php if($if_approver==1){} else{ echo "style='display:none;'"; }?>>
                          <option <?php if(empty($emp_settings) || $emp_settings->request_update=='No'){ echo "selected"; } else{}?> >No</option>
                          <option <?php if(!empty($emp_settings) && $emp_settings->request_update=='Yes'){ echo "selected"; } else{}?>>Yes</option>
                      </select>
                  </td>
              </tr>
            </tbody>
          </table>
         
          <div class="box box-danger"></div>
    </div>
  </div>
</div>
