<?php
  /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */


    $clear_all_from_approver=$this->session->userdata('clear_all_from_approver');
    $system_defined_icons = $this->general_model->system_defined_icons();

    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>
          <table id="approver_all" class="col-md-12 table table-hover table-striped">
                <thead>
                  <tr  class="success">
                    <th style="width:10%;">Approver ID</th>
                    <th style="width:35%;">Approver Name</th>
                    <th style="width:35%;">Company</th>
                    <th style="width:10%;">Approval Level</th>
                    <th style="width:10%;">Form Identification</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($approver as $row) {?>
                  <tr>
                      <td><?php echo $row->approver?></td>
                      <td><?php echo $row->fullname?></td>
                      <td><?php echo $row->company_name?></td>
                      <td><?php 
                      $x=$row->approval_level;
                       if($x=="1"){
                            $ext="st";
                          }else if($x=="3"){
                            $ext="rd";
                          }else if($x=="2"){
                            $ext="nd";
                          }else{
                            $ext="th";
                          }
                        echo $row->approval_level.$ext." Approval "?></td>
                      <td><?php echo $row->form_identification?></td>
                  </tr>
                <?php } ?>
                </tbody>
       </table>
       <?php if(empty($approver)){} else{?>
          <button class='btn btn-danger' onclick="Delete_allapprovers('<?php echo $companyy?>')"
    <?php  
     if($clear_all_from_approver=="hidden "){
       echo 'disabled title="You Are Not Allowed.Check your access rights." ';
     }else{       
     }
     ?> 
            >Delete All Approvers

    <?php
    echo ' <i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';" "></i>';
    ?> 
          </button>
       <?php }?>
        

