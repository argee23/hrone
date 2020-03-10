 <?php 
  /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $add_auto_form_approve=$this->session->userdata('add_auto_form_approve');
    $edit_auto_form_approve=$this->session->userdata('edit_auto_form_approve');
    $del_auto_form_approve=$this->session->userdata('del_auto_form_approve');
    $system_defined_icons = $this->general_model->system_defined_icons();

    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>
 <div id="setting_main_div" > 
 <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:50px;">
          <div class="col-md-12" id='setting_edit'>
           <div class='col-md-4' style="padding-top: 5px;">
                  <div class="col-md-3"><label>Company:</label></div>
                    <div class="col-md-9">
                       <select class="form-control" id='setting_company'>
                             <option selected disabled value='0'>Select Company</option>
                            <?php foreach($companyList as $company){ if($UserDefine==0){?>
                                    <option value="<?php echo $company->company_id?>" <?php foreach ($status_setting as $s) { if($s->company_id==$company->company_id){ echo "disabled"; } }?>><?php echo $company->company_name?></option> <?php } else{ if($UserDefine==$company->company_id){ ?>
                                    <option value="<?php echo $company->company_id?>" <?php foreach ($status_setting as $s) { if($s->company_id==$company->company_id){ echo "disabled"; } }?>><?php echo $company->company_name?></option>
                            <?php } else{} } } ?>
                        </select>
                  </div>
                </div>
              <div class='col-md-3' style="padding-top:5px;">
                  <div class="col-md-3"><label>Days:</label></div>
                    <div class="col-md-9">
                      <input type='number' class='form-control'  id='setting_days'>
                  </div>
                </div>
                 <div class='col-md-3' style="padding-top:5px;">
                  <div class="col-md-3"><label>Status:</label></div>
                    <div class="col-md-9">
                     <select class="form-control" name='setting_status' id='setting_status'>
                        <option value='0' selected disabled>Select</option>
                        <option value='approved'>approved</option>
                        <option value='cancelled'>cancelled</option>
                        <option value='rejected'>rejected</option>
                     </select>
                  </div>
                </div>
                <div class='col-md-2' style="padding-top: 5px;">
                  <div class="col-md-4"></div>
                    <div class="col-md-8">
                     <button class='btn btn-success' onclick="save_status_setting_add('<?php echo $transaction_id?>')"
    <?php  
     if($add_auto_form_approve=="hidden "){
       echo 'disabled title="You Are Not Allowed.Check your access rights." ';
     }else{       
     }
     ?> 
                      >

    <?php
    echo 'SAVE <i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
    ?> 
                    </button>
                  </div>
                </div>
        </div>
      </div>
        <div class="box box-danger" class='col-md-12'></div>
        <div class="col-md-12" id='status_settings'>
         <table id="status_setting" class="col-md-12 table table-hover table-striped">
                <thead>
                  <tr  class="success">
                    <th>ID</th>
                    <th>Company ID
                    <th>Company Name</th>
                    <th>Days</th>
                     <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($status_setting as $ss) { ?>
                  <tr>
                      <td><?php echo $ss->id?></td>
                      <td><?php echo $ss->company_id?></td>
                      <td><?php echo $ss->company_name?></td>
                      <td><?php echo $ss->days?></td>
                      <td><?php echo $ss->action?></td>
                      <td>
                         <a class='<?php echo $edit_auto_form_approve;?> fa fa-pencil-square-o' aria-hidden='true' data-toggle='tooltip' title='Click to edit!' onclick='edit_status_setting("<?php echo $ss->id;?>","<?php echo $ss->company_id?>","<?php echo $transaction_id?>")'></a>
                         <a class='<?php echo $del_auto_form_approve;?> fa fa-trash' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='delete_status_setting("<?php echo $ss->id;?>","<?php echo $transaction_id?>")'></a>
                      </td>
                  </tr>
                <?php } ?>
                </tbody>
       </table>  
       </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div>

</div>

     

