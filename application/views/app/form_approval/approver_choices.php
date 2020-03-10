<?php
  /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */


    $add_form_app_choice=$this->session->userdata('add_form_app_choice');
    $del_form_app_choice=$this->session->userdata('del_form_app_choice');
    $system_defined_icons = $this->general_model->system_defined_icons();

    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>
<div id='refresh_main'></div>
<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Set up Approvers Choices</h4></ol>
  <div class="panel panel-danger">
    <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:50px;" id='add_edit'>
          <div class="col-md-12">
              
                <div class='col-md-8'>
                         <div class="col-md-3"><label><u>Employee Name:</u></label></div>
                          <div class="col-md-9"  id='r_option'>
                             <a data-toggle="modal" data-target="#all_emp_show"><input type='hidden' id='employee_selected_id' value='0'> <input type='text' class='form-control' placeholder="Select Employee" id='employee_selected_name'></a>
                          </div>
                </div>
          <div class='col-md-2'><button class='btn btn-success' onclick="save_approver_choices();"
    <?php  
     if($add_form_app_choice=="hidden "){
       echo 'disabled title="You Are Not Allowed.Check your access rights." ';
     }else{       
     }
     ?> 
            >
    <?php
    echo 'SAVE <i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
    ?>  
          </button></div>
        </div>
      </div>
        <div class="box box-danger" class='col-md-12'></div>
         <?php if($this->session->flashdata('success_inserted') AND $action_=='add')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Employee ID - '.$flash_id.' is Successfully Added as an Approver Choices.</center></n></div>';
            } 
           else if($this->session->flashdata('insert_error') AND $action_=='add' )
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>There is an error in adding Employee ID - '.$flash_id.' as Approver Choices. PLease try again later.</center></n></div>';
            } 
            else if($this->session->flashdata('success_deleted') AND $action_=='delete')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>ID - '.$flash_id.' Number of Approver Setting is Successfully Deleted.</center></n></div>';
            }
            else if($this->session->flashdata('delete_error') AND $action_=='delete')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>There is an error in deleting ID - '.$flash_id.' Number of Approver Setting. PLease try again later.</center></n></div>';
            }
            else{}?>

        <div class='col-md-12'>
          <table id="approver_choices" class="col-md-12 table table-hover table-striped">
                <thead class=''>
                  <tr  class="success">
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Company Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($approver_list as $approver) { ?>
                 <tr>
                    <td><?php echo $approver->employee_id?></td>
                    <td><?php echo $approver->fullname?></td>
                    <td><?php echo $approver->company_name?></td>
                    <td><a class='<?php echo $del_form_app_choice;?> fa fa-<?php echo $system_defined_icons->icon_delete;?>' style='cursor:pointer;  color:<?php echo $system_defined_icons->icon_delete_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='deleteApprover(<?php echo $approver->employee_id?>)'></a></td>
                 </tr>
                <?php } ?>
                </tbody>
       </table>
       </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>      

