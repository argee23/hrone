 <?php 
  /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $add_auto_salary_approve=$this->session->userdata('add_auto_salary_approve');
    $edit_auto_salary_approve=$this->session->userdata('edit_auto_salary_approve');
    $del_auto_salary_approve=$this->session->userdata('del_auto_salary_approve');
    $ena_dis_auto_salary_approve=$this->session->userdata('ena_dis_auto_salary_approve');
    $system_defined_icons = $this->general_model->system_defined_icons();

    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>

<div id='refresh_main'></div>
<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Automatic Update of Approval Status</h4></ol>
  <div class="panel panel-danger">
    <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:50px;" id='add_edit'>
          <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-8" id="update_action">
                <div class='col-md-12'>
                         <div class="col-md-3"><label><u>Company:</u></label></div>
                          <div class="col-md-9"  id='r_option'>
                             <select class="form-control" id="acompany">
                             <option value="" disabled selected>Select</option>
                             <?php foreach($companyList as $comp){?>
                                <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                             <?php } ?>
                             </select>
                          </div>
                </div>
                 <div class='col-md-12' style="margin-top: 5px;">
                         <div class="col-md-3"><label><u>No. of Days:</u></label></div>
                          <div class="col-md-9"  id='r_option'>
                             <input type="number" class="form-control" placeholder="Input number of days" id="adays">
                          </div>
                </div>
                 <div class='col-md-12' style="margin-top: 5px;">
                         <div class="col-md-3"><label><u>Status:</u></label></div>
                          <div class="col-md-9"  id='r_option'>
                            <select class="form-control" id="astatus">
                              <option value="" disabled selected>Select</option>
                              <option value='approved'>Approved</option>
                              <option value='cancelled'>Cancelled</option>\
                              <option value='rejected'>Rejected</option>
                            </select>
                          </div>
                </div>
                 <div class='col-md-12' style="margin-top: 5px;">
                         <div class="col-md-3"></div>
                          <div class="col-md-9"  id='r_option'>
                           <button class='col-md-12 btn btn-success' onclick="save_automatic_update_status();"
<?php  
     if($add_auto_salary_approve=="hidden "){
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
          <div class="col-md-2"></div>
                
        </div>
      </div><br><br><br><br><br><br>
        <div class="box box-danger" class='col-md-12'></div>
         <?php if($this->session->flashdata('success_inserted') AND $action_=='add')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Automatic Update of Approval Status for company id - '.$flash_id.' is successfully added.</center></n></div>';
            } 
          
            else if($this->session->flashdata('success_deleted') AND $action_=='delete')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Automatic Update of Approval Status for company id - '.$flash_id.' is successfully deleted.</center></n></div>';
            }
            else if($this->session->flashdata('success_disabled') AND $action_=='disable')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Automatic Update of Approval Status for company id - '.$flash_id.' is successfully disabled.</center></n></div>';
            }
            else if($this->session->flashdata('success_enabled') AND $action_=='enable')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Automatic Update of Approval Status for company id - '.$flash_id.' is successfully enabled.</center></n></div>';
            }
            else if($this->session->flashdata('success_updated') AND $action_=='update')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Automatic Update of Approval Status for company id - '.$flash_id.' is successfully updated.</center></n></div>';
            }
            else{ }?>

        <div class='col-md-12'>
          <table id="automatic_approver" class="col-md-12 table table-hover table-striped">
                <thead class=''>
                  <tr  class="success">
                    <th>ID</th>
                    <th>Company</th>
                    <th>Number of days</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($details as $d){?>
                  <tr>
                    <td><?php echo $d->id;?></td>
                    <td><?php echo $d->company_name;?></td>
                    <td><?php echo $d->days;?></td>
                    <td><?php echo $d->status;?></td>
                    <td>
                        <a class='<?php echo $edit_auto_salary_approve;?> fa fa-<?php echo $system_defined_icons->icon_edit;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to edit!' 
                          onclick='settings_update_automatic_update_status("<?php echo $d->company_id;?>");'></a>
                         <a class='<?php echo $del_auto_salary_approve;?> fa fa-<?php echo $system_defined_icons->icon_delete;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  
                         onclick='settings_automatic_update_status("delete","<?php echo $d->company_id;?>");'></a>

                         <?php if($d->InActive==1)
                         { ?>
                            <a class='<?php echo $ena_dis_auto_salary_approve;?> fa fa-<?php echo $system_defined_icons->icon_disable;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to enable record!'  onclick='settings_automatic_update_status("enable","<?php echo $d->company_id;?>");'></a>
                         <?php }
                         else
                         { ?> 
                            <a class='<?php echo $ena_dis_auto_salary_approve;?> fa fa-<?php echo $system_defined_icons->icon_enable;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to disable record!'  onclick='settings_automatic_update_status("disable","<?php echo $d->company_id;?>");'></a>
                         <?php } ?>
                    </td>
                  </tr>
                <?php }?>
                </tbody>
       </table>
       </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>      

