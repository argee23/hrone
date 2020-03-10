
<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Assign Admin and Email for Request Update Email Notification</h4></ol>
        
  <div class="panel panel-danger">
    <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:295px;">
          <div class="col-md-12">
            <div class="col-md-2"><label>Select Company :</label></div>
            <div class="col-md-6">
              <select class="form-control" onchange="email_details(this.value);">
                <option selected disabled value="0" <?php if($option=='none'){ echo "selected"; } ?>>Select Company</option>
                <?php foreach($companyList as $company){ ?>
                    <option value="<?php echo $company->company_id?>" <?php if($option==$company->company_id){ echo "selected"; }?>><?php echo $company->company_name?></option>
                <?php } ?>
              </select>
            </div><br><br><br>
             <div class="box box-danger"></div>
            <div class="col-md-12" id='action_email'>
              <?php if($option=='none' || empty($option)){?>
                <table class="table table-hover table-striped" id="email">
                  <thead class='text-success'>
                    <tr class="danger">
                      <th style="width:15%;">Location</th>
                      <th style="width:15%;">Admin ID</th>
                      <th style="width:25%;">Admin Name</th>
                      <th style="width:30%;">Email</th>
                      <th style="width:15%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>  
              <?php }  else{?>

                 <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_emp_prof_update_request/save_201_email/<?php echo $option;?>">
                   <table class="table table-hover table-striped">
                      <thead class='text-success'>
                        <tr class="danger">
                          <th style="width:5%;">No.</th>
                          <th style="width:20%;">Location</th>
                          <th style="width:35%;">Admin Name</th>
                          <th style="width:40%;">Email</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php  $i=1;
                              $ii = 0;
                              $location=$this->employee_emp_prof_update_request_model->load_locations($option);
                              $admin_list=$this->employee_emp_prof_update_request_model->admin_list($option); 
                              foreach($location as $loc){ 
                              $email_admin = $this->employee_emp_prof_update_request_model->email($loc->location_id,$option);

                              if(!empty($email_admin->email)) { $email_ = $email_admin->email;  } else{ $email_ = ""; }
                              if(!empty($email_admin->admin)) { $admin_ = $email_admin->admin;  } else{ $admin_ = ""; }

                              ?>
                        <tr>
                        <td><?php echo $i."."?></td>
                        <td><?php echo $loc->location_name?><input type='hidden' id='location<?php echo $i;?>' name="location<?php echo $loc->location_id;?>" value='<?php echo $loc->location_id?>'></td>
                        <td> 
                            <select class="form-control" style="width: 100%;" onchange="get_email(this.value,'<?php echo $i?>','<?php echo $loc->location_id;?>');" id='employee<?php echo $i?>' name='employee<?php echo $loc->location_id?>'>
                            <?php if(empty($admin_list)){ echo "<option value='0'>No admin found. Please add to continue. .</option>"; } else {?>
                            <option value="0">Select</option>
                            <?php foreach($admin_list as $admin){?>
                                <option value="<?php echo $admin->employee_id?>" <?php if(!empty($admin_) AND $admin_==$admin->employee_id){ echo "selected"; }else{}?>><?php echo $admin->fullname?></option>
                            <?php } }?>
                            </select>
                        </td>
                        <td> <div id="email<?php echo $i?>"><input type="email" class="form-control" style="width:100%;" id='emailss<?php echo $i?>' name='email<?php echo $loc->location_id;?>' value="<?php echo $email_?>"></div></td>
                      </tr>
                      <?php $i++; $ii=$ii+1; } echo "<input type='hidden' value='".$ii."' id='number_fields'>"; ?>
                    </tbody>
                 </table>
                 <div class="col-md-12">  
                    <button type="submit" class="btn btn-success pull-right">SAVE CHANGES</button>
                 </div> 

               </form>



              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>             



