<?php
    $system_defined_icons = $this->general_model->system_defined_icons();
    $company_List = $this->general_model->companyList(); 
?>
<div id='refresh_main'></div>
<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Allow disabled section manager to access personnel working schedule </h4></ol>
  <div class="panel panel-danger">
    <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:50px;" id='add_edit'>
          <div class="col-md-12">
                <div class='col-md-5'>
                       <div class="col-md-4"><label><u>Company :</u></label></div>
                        <div class="col-md-8" id='r_company'>
                          <select class="form-control" id='company_allow' > 
                                <option value='' selected disabled>Select Company</option>
                                 <?php 
                                foreach($company_List as $company){
                                  $check = $this->section_manager_model->checker_exist_setting_class($company->company_id,'section_manager_setting_access')?>
                                 <option value="<?php echo $company->company_id?>" <?php if($check>0){ echo "disabled";}?>><?php echo $company->company_name?></option>
                                <?php } ?>
                          </select>
                        </div>
                </div>
                <div class='col-md-5'>
                         <div class="col-md-5"><label><u>Allow to access :</u></label></div>
                          <div class="col-md-7"  id='r_option'>
                              <select class="form-control" id='option_allow'  > 
                                  <option selected disabled value=''>Select Option</option>
                                  <option value="can_view">can access plotted schedule</option>
                                  <option value="cannot_view">can't access plotted schedule</option>
                                  <option value="no_access">no accees in entire personnel working schedule</option>
                              </select>
                          </div>
                </div>
                <div class='col-md-2'><button class='btn btn-success' onclick="save_allow_access_setting('insert');">SAVE</button></div>
        </div>


      </div>
        <div class="box box-danger" class='col-md-12'></div>
         <?php if($this->session->flashdata('success_inserted') AND $action_=='insert')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Company ID - '.$flash_id.'  Setting is Successfully Added.</center></n></div>';
            } 
           else if($this->session->flashdata('insert_error') AND $action_=='insert' )
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>There is an error in adding Company ID - '.$flash_id.'  Setting. PLease try again later.</center></n></div>';
            } 
            else if($this->session->flashdata('success_deleted') AND $action_=='delete')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>ID - '.$flash_id.'  Setting is Successfully Deleted.</center></n></div>';
            }
            else if($this->session->flashdata('delete_error') AND $action_=='delete')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>There is an error in deleting ID - '.$flash_id.'  Setting. PLease try again later.</center></n></div>';
            }
            else if($this->session->flashdata('success_updated') AND $action_=='update')
            {  echo "la";
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Company ID - '.$flash_id.' Setting is Successfully Updated.</center></n></div>';
            }
            else if($this->session->flashdata('update_error') AND $action_=='update')
            {  
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>There is an error in updating Company ID - '.$flash_id.' Setting. PLease try again later.</center></n></div>';
            }
             else if($this->session->flashdata('updated_nochanges') AND $action_=='update')
            { echo "mi";
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>No changes made in Company ID - '.$flash_id.'.</center></n></div>';
            }
            else{}?>
        <div class='col-md-12'>
          <table id="settingaccess" class="col-md-12 table table-hover table-striped">
                <thead class=''>  
                  <tr  class="success">
                    <th>ID</th>
                    <th>Company ID</th>
                    <th>Company Name</th>
                    <th>Allow Access?</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php  foreach ($accessList as $row) {?>
                    <tr>
                      <td><?php echo $row->section_manager_access_id?></td>
                      <td><?php echo $row->company_id?></td>
                      <td><?php echo $row->company_name?></td>
                      <td><?php if($row->allow_access=='can_view'){ echo "Can access the of viewing personnel working schedule."; } elseif($row->allow_access=='cannot_view'){ echo "Can't access the viewing of personnel working schedule.";} else{ echo "No access in entire personnel working schedule."; }?></td>
                      <td>
                        <a class='fa fa-<?php echo $system_defined_icons->icon_edit;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to edit!'  onclick='editDetails_allowaccess(<?php echo $row->section_manager_access_id;?>)'></a>
                        <a class='fa fa-<?php echo $system_defined_icons->icon_delete;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='deleteDetails_allowaccess(<?php echo $row->section_manager_access_id;?>)'></a>
                      </td>
                    </tr>
                <?php } ?>

                    </tbody>
                </tbody>
       </table>
       </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>      

