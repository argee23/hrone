<div id='refresh_main'></div>
<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Set up Plotting Schedule By Classification/Level</h4></ol>
  <div class="panel panel-danger">
    <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:50px;" id='add_edit'>
          <div class="col-md-12">
                <div class='col-md-5'>
                       <div class="col-md-4"><label><u>Company:</u></label></div>
                        <div class="col-md-8" id='r_company'>
                          <select class="form-control" id='company_classlevel' onchange = "enabled_class_level_option();"> 
                                <option value='' selected disabled>Select Company</option>
                                 <?php 
                                foreach($companyList as $company){
                                  $check = $this->section_manager_model->checker_exist_setting_class($company->company_id,'general');?>
                                  <option value="<?php echo $company->company_id?>" <?php if($check>0){ echo "disabled";}?>><?php echo $company->company_name?></option>
                                <?php } ?>
                          </select>
                        </div>
                </div>
                <div class='col-md-5'>
                         <div class="col-md-5"><label><u>Setting Option:</u></label></div>
                          <div class="col-md-7"  id='r_option'>
                              <select class="form-control" id='class_level_option' > 
                                  <option selected disabled value=''>Select Option</option>
                                  <option value="classification">By Classification</option>
                                  <option value="level">By Level</option>
                              </select>
                          </div>
                </div>
                
                <div class='col-md-2'><button class='btn btn-success' onclick="save_level_classification_setting('insert');">SAVE</button></div>
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
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Company ID - '.$flash_id.' Setting is Successfully Updated.</center></n></div>';
            }
            else if($this->session->flashdata('update_error') AND $action_=='update')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>There is an error in updating Company ID - '.$flash_id.' Setting. PLease try again later.</center></n></div>';
            }
             else if($this->session->flashdata('updated_nochanges') AND $action_=='update')
            {
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>No changes made in Company ID - '.$flash_id.'.</center></n></div>';
            }
            else{}?>
        <div class='col-md-12'>
          <table id="classlevel" class="col-md-12 table table-hover table-striped">
                <thead class=''>
                  <tr  class="success">
                    <th>ID</th>
                    <th>Company ID</th>
                    <th>Company Name</th>
                    <th>Setting</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php  foreach ($classlevelList as $row) {?>
                    <tr>
                      <td><?php echo $row->id?></td>
                      <td><?php echo $row->company_id?></td>
                      <td><?php echo $row->company_name?></td>
                      <td><?php echo $row->classification_level_access?></td>
                      <td>
                        <a class='fa fa-pencil-square-o' aria-hidden='true' data-toggle='tooltip' title='Click to edit!'  onclick='editDetails("<?php echo $row->id;?>","<?php echo $row->company_id?>")'></a>
                        <a class='fa fa-trash' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='deleteDetails(<?php echo $row->id;?>)'></a>
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

