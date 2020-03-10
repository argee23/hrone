<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Company 201 Update Settings</h4></ol>
       <?php 
          if($this->session->flashdata('success_inserted'))
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Company ID - '.$flash_id.' 201 Setting is Successfully Added.</center></n></div>';
            }
           else if($this->session->flashdata('insert_error'))
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>There is an error in adding Company ID - '.$flash_id.' 201 Setting. PLease try again later.</center></n></div>';
            }
           else if($this->session->flashdata('success_updated'))
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Company ID - '.$flash_id.' 201 Setting is Successfully Updated.</center></n></div>';
            }
            else if($this->session->flashdata('nochanges_updated'))
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>No changes made in Company ID - '.$flash_id.' 201 Setting.</center></n></div>';
            }
              else if($this->session->flashdata('success_deleted'))
              { 
                echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center> Company ID - '.$flash_id.' 201 Setting is Successfully Deleted.</center></n></div>';
              }
              else if($this->session->flashdata('delete_error'))
              { 
                echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>There is an error in deleting Company ID - '.$flash_id.' 201 Setting. PLease try again later.</center></n></div>';
              }
            else{}
      ?>
    <div class="col-md-12"><br>
     <div style="height:80px;" id='filtering' >
        <div style="height:295px;">
          <div class="col-md-12" id='viewing_filtering'>
                <table id="view_section_manager" class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th style="width:10%;">Company ID</th>
                    <th style="width:20%;">Company Name</th>
                    <th style="width:55%;">Edited 201 Topics</th>
                    <th style="width:15%;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($topicCompany as $t) { ?>
                    <tr>
                      <td><?php echo $t->company_id?></td>
                      <td><?php echo $t->company_name?></td>
                      <td>
                          <?php 
                            $topic_sel = explode("-",$t->topics);
                              foreach ($topic_sel as $val) {
                                  $topics = $this->employee_emp_prof_update_request_model->topics_company($t->company_id,$val);
                                  foreach ($topics as $title) {
                                    echo $title->topic_title.",";
                                  }
                               } 
                          ?> 
                      </td>
                      <td>
                          <a class='fa fa-pencil-square-o' aria-hidden='true' data-toggle='tooltip' title='Click to edit!'  onclick='editSetting("<?php echo $t->update_setting_id;?>","<?php echo $t->company_id;?>")'></a>
                          <a class='fa fa-trash' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='deleteSetting("<?php echo $t->update_setting_id;?>","<?php echo $t->company_id;?>")'></a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
       </table>
     

          </div>
      </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
            

