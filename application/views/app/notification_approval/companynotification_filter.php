
              <?php
                  if($with_division > 0){
                    if(empty($get_division)){ echo "<h2><center>No Division Found.</center></h2>"; }
                      foreach($get_division as $div){?>

                        <div class="datagrid">
                          <table>
                            <thead>
                              <tr>
                                <th colspan="9">Division : <?php echo $div->division_name;?></th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php 

                                  $get_all_department = $this->form_approval_model->load_dept_filter($div->division_id,$div->company_id);
                                  if(empty($get_all_department))
                                  {?>
                                        <tr class="alt">
                                           <td colspan="9"> No department found. </td>
                                        </tr>
                                  <?php }
                                  else
                                  {

                                    foreach($get_all_department as $dept){ 
                                    $get_all_section = $this->form_approval_model->load_section($dept->company_id,$div->division_id,$dept->department_id);

                                  ?>
                                      <tr class="alt">
                                        <td colspan="9"> Department : <?php echo $dept->dept_name;?> </td>
                                      </tr> 

                                      <?php  foreach($get_all_section as $sec){
                                        $check_if_with_subsection = $this->form_approval_model->with_subsection($sec->section_id);
                                        if($check_if_with_subsection==0)
                                        {
                                          //get all approvers
                                        }
                                        else
                                        {
                                            $get_all_subsection_list = $this->form_approval_model->load_subsections($sec->section_id);

                                        }
                                ?>

                              <tr class="alt">
                                <td colspan="9" style="padding-left: 5%;"> Section : <?php echo $sec->section_name;?> </td>
                              </tr>

                              <?php  if($check_if_with_subsection==0)
                              {
                                   $get_all_approvers = $this->notification_approval_model->get_all_notification_approver_list($dept->company_id,$div->division_id,$dept->department_id,$sec->section_id,'not_included',$classification,$location,$notification);
                              ?>
                                
                             <tr class="alt">
                                <td style="width: 5%;"></td>
                                <td colspan="8" style="padding-left:6%;"><n class="text-danger"><strong> Subsection: No subsection in this section.</strong></n></td>
                              </tr>
                              <?php if(empty($get_all_approvers))
                              {?>

                                    <tr>
                                      <td>
                                      <td style="width: 5%;"></td>
                                      <td colspan="8"><center><n class="text-info"><strong>NO APPROVERS FOUND.</strong></n></center></td>
                                    </tr>

                              <?php } else {?>

                              <tr>
                                        <td colspan="3" style="width:20%;"></td> 
                                        <td>Employee ID</td>
                                        <td>Name</td>
                                        <td>Approver Level</td>
                                        <td>Location</td>
                                        <td>Classification</td></td>
                                        <td>Notification</td></td>
                                      </tr>

                                 <?php  } foreach($get_all_approvers as $app) {?>

                                   <tr>
                                        <td colspan="3" style="width:20%;"></td> 
                                        <td><?php echo $app->employee_id;?></td>
                                        <td><?php echo $app->fullname;?></td>
                                        <td>
                                       
                                            <?php
                                                 if ($app->approval_level=="1"){
                                                  $ext="st";
                                                }else if($app->approval_level=="2"){
                                                  $ext="nd";
                                                }else if($app->approval_level=="3"){
                                                  $ext="rd";
                                                }else{
                                                  $ext="th";
                                                }

                                                   echo $app->approval_level.$ext;
                                            ?>
                                          
                                        </td>
                                        <td><?php echo $app->location_name;?></td>
                                        <td><?php echo $app->classification_name;?></td>
                                         <td><?php echo $app->form_name;?></td>
                                      </tr>

                              <?php } ?>

                              <?php }
                              else
                              {
                                  
                                if(empty($get_all_subsection_list)){?>
                                  <tr>
                                    <td style="width: 5%;"></td>
                                    <td colspan="8"><n class="text-danger"><strong><center>  No subsection Found</center></strong></n></td>
                                  </tr>
                                <?php 
                                }
                                else
                                {
                                  foreach($get_all_subsection_list as $subsec){
                                    if($check_if_with_subsection==0)
                                    {
                                      $subsection = 'not_included';
                                    }
                                    else
                                    {
                                      $subsection = $subsec->subsection_id;
                                    }

                                    $get_all_approvers = $this->notification_approval_model->get_all_notification_approver_list($dept->company_id,$div->division_id,$dept->department_id,$sec->section_id,$subsection,$classification,$location,$notification);


                                ?>

                                <tr class="alt">
                                  <td>
                                  <td style="width:5%;"></td>
                                  <td colspan="8"><n class="text-danger"><strong>Subsection: <?php echo $subsec->subsection_name;?></strong></n></td>
                                </tr>


                                 <?php if(count($get_all_approvers)==0)
                                 {?> 
                                   <tr>
                                    <td>
                                    <td style="width: 5%;"></td>
                                    <td colspan="8"><center><n class="text-info"><strong>NO APPROVERS FOUND.</strong></n></center></td>
                                  </tr>
                                  <?php } else{?>

                                    <tr>
                                      <td colspan="3" style="width:20%;"></td> 
                                      <td>Employee ID</td>
                                      <td>Name</td>
                                      <td>Approver Level</td>
                                      <td>Location</td>
                                      <td>Classification</td>
                                      <td>Notification</td>
                                    </tr>

                                  <?php   foreach($get_all_approvers as $app){?>

                                    <tr>
                                      <td colspan="3" style="width:20%;"></td> 
                                      <td><?php echo $app->employee_id;?></td>
                                      <td><?php echo $app->fullname;?></td>
                                      <td>
                                     
                                          <?php
                                               if ($app->approval_level=="1"){
                                                $ext="st";
                                              }else if($app->approval_level=="2"){
                                                $ext="nd";
                                              }else if($app->approval_level=="3"){
                                                $ext="rd";
                                              }else{
                                                $ext="th";
                                              }

                                                 echo $app->approval_level.$ext;
                                          ?>
                                        
                                      </td>
                                      <td><?php echo $app->location_name;?></td>
                                      <td><?php echo $app->classification_name;?></td>
                                      <td><?php echo $app->form_name;?></td>
                                    </tr>

                                   <?php  }  } ?>

                            <?php  } } }  }  } } ?>
                      </tbody>
                    </table>
                  </div>

                  <?php }  } else{ 

                    if(empty($get_department)){ echo "<h2><center>No Department Found.</center></h2>"; }
                      foreach($get_department as $dept){
                  ?>

                    <div class="datagrid">
                        <table>
                          <thead>
                            <tr>
                              <th colspan="9">Department : <?php echo $dept->dept_name;?></th>
                            </tr>
                          </thead>
                          <tbody> 
                          <?php 
                           $get_all_section = $this->form_approval_model->load_section($dept->company_id,'not_included',$dept->department_id); 
                           if(empty($get_all_section)){?>

                            <tr>
                              <td colspan="9"> <n class="tetx-info"><center><strong>NO SECTION FOUND</strong></center></n></td>
                            </tr>

                           <?php }
                          else
                          {
                            foreach($get_all_section as $sec){
                              $check_if_with_subsection = $this->form_approval_model->with_subsection($sec->section_id);
                                  if($check_if_with_subsection==0)
                                  {
                                    //get all approvers
                                  }
                                  else
                                  {
                                      $get_all_subsection_list = $this->form_approval_model->load_subsections($sec->section_id);

                                  }
                          ?>
                  <tr class="alt">
                    <td colspan="9"> Section : <?php echo $sec->section_name;?></td>
                  </tr> 

                    <?php  if($check_if_with_subsection==0)
                          {

                             $get_all_approvers = $this->notification_approval_model->get_all_notification_approver_list($dept->company_id,'not_included',$dept->department_id,$sec->section_id,'not_included',$classification,$location,$notification);
                            

                            ?>
                            <tr class="alt">
                              <td style="width: 5%;"></td>
                              <td colspan="8"><n class="text-danger"> Subsection: No subsection in this section.</n></td>
                            </tr>
                            <?php if(empty($get_all_approvers))
                            {?>
                                 <tr>
                                    <td colspan="9"><center><n class="text-info"><strong>NO APPROVERS FOUND.</strong></n></center></td>
                                </tr>
                           <?php }
                            else
                            {?>
                                <tr>
                                    <td colspan="3" style="width:20%;"></td> 
                                    <td>Employee ID</td>
                                    <td>Name</td>
                                    <td>Approver Level</td>
                                    <td>Location</td>
                                    <td>Classification</td> 
                                    <td>Notification</td>

                                </tr>
                            <?php foreach($get_all_approvers as $app){?>    
                                <tr>
                                    <td colspan="3" style="width:20%;"></td> 
                                    <td><?php echo $app->employee_id;?></td>
                                    <td><?php echo $app->fullname;?></td>
                                    <td>
                                               
                                                    <?php
                                                         if ($app->approval_level=="1"){
                                                          $ext="st";
                                                        }else if($app->approval_level=="2"){
                                                          $ext="nd";
                                                        }else if($app->approval_level=="3"){
                                                          $ext="rd";
                                                        }else{
                                                          $ext="th";
                                                        }

                                                           echo $app->approval_level.$ext;
                                                    ?>
                                                  
                                  </td>
                                  <td><?php echo $app->location_name;?></td>
                                  <td><?php echo $app->classification_name;?></td>
                                  <td><?php echo $app->form_name;?></td>
                                </tr>

                            <?php } }


                        }
                          else
                          {
                              $get_all_subsection_list = $this->form_approval_model->load_subsections($sec->section_id);
                              if(empty($get_all_subsection_list))
                              {?>
                                  <tr>
                                    <td colspan="9"><center><n class="text-info"><strong>NO SUBSECTION FOUND.</strong></n></center></td>
                                  </tr>
                             <?php  }
                              else
                              {
                                  foreach ($get_all_subsection_list as $subsec) {

                                     if($check_if_with_subsection==0)
                                      {
                                        $subsection = 'not_included';
                                      }
                                      else
                                      {
                                        $subsection = $subsec->subsection_id;
                                      }

                                      $get_all_approvers = $this->notification_approval_model->get_all_notification_approver_list($dept->company_id,'not_included',$dept->department_id,
                                      $sec->section_id,$subsection,$classification,$location,$notification);


                                    ?>

                                      <tr class="alt">
                                       <td style="width: 5%;"></td>
                                        <td colspan="8"> <n class="text-danger">Subsection : <?php echo $subsec->subsection_name;?></n></td>
                                      </tr> 
                                      <?php 

                                      if($check_if_with_subsection==0)
                                      {}
                                      else
                                      {

                                            if(empty($get_all_approvers)) { ?>
                                              <tr>
                                              <td colspan="9"><center><n class="text-info"><strong>NO APPROVERS FOUND.</strong></n></center></td>
                                            </tr>
                                            <?php }
                                            else
                                            {?>
                                                <tr>
                                                  <td colspan="3" style="width:20%;"></td> 
                                                  <td>Employee ID</td>
                                                  <td>Name</td>
                                                  <td>Approver Level</td>
                                                  <td>Location</td>
                                                  <td>Classification</td>
                                                  <td>Notification</td>
                                                </tr>
                                            <?php 
                                              foreach($get_all_approvers as $app){
                                            ?>
                                              <tr>
                                                <td colspan="3" style="width:20%;"></td> 
                                                <td><?php echo $app->employee_id;?></td>
                                                <td><?php echo $app->fullname;?></td>
                                                <td>
                                               
                                                    <?php
                                                         if ($app->approval_level=="1"){
                                                          $ext="st";
                                                        }else if($app->approval_level=="2"){
                                                          $ext="nd";
                                                        }else if($app->approval_level=="3"){
                                                          $ext="rd";
                                                        }else{
                                                          $ext="th";
                                                        }

                                                           echo $app->approval_level.$ext;
                                                    ?>
                                                  
                                                </td>
                                                <td><?php echo $app->location_name;?></td>
                                                <td><?php echo $app->classification_name;?></td>
                                                <td><?php echo $app->form_name;?></td>
                                              </tr>


                                      <?php   }} }?> 

                                  <?php }
                              }
                          }
                    ?>

                <?php } } ?>
                </tbody>
              </table>
            </div>
         <?php } } ?>