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
<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Clear All Approvers</h4></ol>
  <div class="panel panel-danger">
    <div class="col-md-12"><br>
     <div style="height:50px;" id='add_edit'>
          <div class="col-md-12">
               
                 <div class='col-md-5'>
                  <div class="col-md-4"><label>Company:</label></div>
                    <div class="col-md-8">
                   <select class="form-control" onchange="deleteapprover_by_company(this.value)">
                             <option selected disabled value='0'>Select Company</option>
                             <option selected disabled value='0'>All</option>
                            <?php foreach($companyList as $company){ ?>
                            <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

        </div>
      </div>
      <div class="box box-danger" class='col-md-12'></div>
        <div class='col-md-12' id="delete_by_companyy">
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
          <button class='btn btn-danger' onclick="Delete_allapprovers('All');"
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
       </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>      

