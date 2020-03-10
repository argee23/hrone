
 <?php  if($this->session->flashdata('success_updated'))
            { 
              echo '<div id="flashdata_result" style="padding-top:40px;"> <n class="text-danger" style="font-weight:bold;"> <center>Company ID - '.$company.' Email Settings is Successfully Updated.</center></n></div>';
            } 
           else{}



    ?>
<br>
<form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_emp_prof_update_request/save_201_email/<?php echo $company;?>">
   <table class="table table-hover table-striped" id="email_for_update">
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
             foreach($location as $loc){ 
              $email_admin = $this->employee_emp_prof_update_request_model->email($loc->location_id,$company);

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
