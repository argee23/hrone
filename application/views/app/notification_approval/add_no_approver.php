<?php
  /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $add_max_discactmem_app=$this->session->userdata('add_max_discactmem_app');
    $edit_max_discactmem_app=$this->session->userdata('edit_max_discactmem_app');
    $del_max_discactmem_app=$this->session->userdata('del_max_discactmem_app');
    //$system_defined_icons = $this->general_model->system_defined_icons();

    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>
<div id='refresh_main'></div>
<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Set up Number of Approvers</h4></ol>
  <div class="panel panel-danger">
    <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:50px;" id='add_edit'>
          <div class="col-md-12">
                 <div class='col-md-5'>
                  <div class="col-md-4"><label>Company:</label></div>
                    <div class="col-md-8">
                   <select class="form-control" id='setting_company'>
                             <option selected disabled value='0'>Select Company</option>
                            <?php foreach($companyList as $company){ 
                              $recheck_if_exist_no_approver =  $this->notification_approval_model->recheck_if_exist_no_approver($company->company_id);?>
                            <option value="<?php echo $company->company_id?>" <?php if($recheck_if_exist_no_approver==0){}else{ echo "disabled";}?>><?php echo $company->company_name?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                
                <div class='col-md-5' style="padding-top: 5px;">
                  <div class="col-md-6"><label>Number of Approver:</label></div>
                    <div class="col-md-6">
                      <input type='number' class='form-control'  id='setting_no_approvers'>
                  </div>
                </div>
                <div class='col-md-2' style="padding-top: 5px;">
                  <div class="col-md-4"></div>
                    <div class="col-md-8">
                     <button class='btn btn-success' onclick="save_no_approver_setting();" <?php  
     if($add_max_discactmem_app=="hidden "){
       echo 'disabled title="You Are Not Allowed.Check your access rights." ';
     }else{       
     }
     ?> 
     > <!-- close button -->
    <?php
    echo 'SAVE <i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
    ?>  

                     </button>
                  </div>
                </div>
        </div>
      </div>
        <div class="box box-danger" class='col-md-12'></div>
         <?php if($this->session->flashdata('success_inserted') AND $action_=='add')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Company ID - '.$flash_id.' Number of Approver Setting is Successfully Added.</center></n></div>';
            } 
           else if($this->session->flashdata('insert_error') AND $action_=='add' )
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>There is an error in adding Company ID - '.$flash_id.' Number of Approver Setting. PLease try again later.</center></n></div>';
            } 
            else if($this->session->flashdata('success_deleted') AND $action_=='delete')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>ID - '.$flash_id.' Number of Approver Setting is Successfully Deleted.</center></n></div>';
            }
            else if($this->session->flashdata('delete_error') AND $action_=='delete')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>There is an error in deleting ID - '.$flash_id.' Number of Approver Setting. PLease try again later.</center></n></div>';
            }
            else if($this->session->flashdata('success_updated') AND $action_=='update')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Company ID - '.$flash_id.' Number of Approver Setting is Successfully Updated.</center></n></div>';
            }
            else if($this->session->flashdata('update_error') AND $action_=='delete')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>There is an error in updating Company ID - '.$flash_id.' Number of Approver Setting. PLease try again later.</center></n></div>';
            }
            else{}?>
        <div class='col-md-12'>
          <table id="no_approver" class="col-md-12 table table-hover table-striped">
                <thead class=''>
                  <tr  class="success">
                    <th>ID</th>
                    <th>Company ID</th>
                    <th>Company Name</th>
                    <th>Number of Approver</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
              <?php foreach($setting_no_approver as $no)
              {?>
                    <tr>
                        <td><?php echo $no->no_approver_id?></td>
                      <td><?php echo $no->company_id?></td>
                      <td><?php echo $no->company_name?></td>
                      <td><?php echo $no->setting_value?></td>
                      <td>
                        <a class='<?php echo $edit_max_discactmem_app;?> fa fa-<?php echo $system_defined_icons->icon_edit;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to edit!' onclick='edit_setting_no_approver("<?php echo $no->no_approver_id;?>","<?php echo $no->company_id?>")'></a>
                         <a class='<?php echo $del_max_discactmem_app;?> fa fa-<?php echo $system_defined_icons->icon_delete;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='delete_setting_no_approver(<?php echo $no->no_approver_id;?>)'></a>
                      </td>
                    </tr>
              <?php } ?>
                </tbody>
       </table>
       </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>   
  </div>   

