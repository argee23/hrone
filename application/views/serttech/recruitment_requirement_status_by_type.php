<?php if($type=='active'){?>

  <div class="col-md-8" style="padding-top:30px;">
    
      <div class="col-md-12">
                  <div class="col-md-12">
                        <div class="col-md-3"><label class="pull-right">Filter:</label></div>
                        <div class="col-md-4">
                          <select class="form-control" onchange="recruitment_requirement_stat_by_company('All',this.value);">
                            <?php
                               $companyList=$this->serttech_recruitment_setting_model->employers_job();
                            ?>
                              <option value="" disabled selected>Select Company</option>
                            <?php if(empty($companyList)){ echo "<option value=''>No company found.</option>"; } else{
                              foreach($companyList as $comp){?>
                              <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                            <?php } }?>
                          </select>
                        </div>
                          <div class="col-md-2">
                          <select class="form-control" onchange="recruitment_requirement_stat_by_company('All',this.value);">
                              <option value="" disabled selected>Select</option>
                              <option>All</option>
                              <option>Subscription</option>
                              <option>Free Trial</option>
                          </select>
                        </div>
                        <div class="col-md-3"></div>
                  </div>
                   <div class="col-md-12">
                      <div class="col-md-12"><br>
                          <div class="box box-default" class='col-md-12'></div>
                      </div>  
                    </div>
              </div>
     <div class="col-md-12" id="by_company_requirements">
           <table class="col-md-12 table table-hover" id="table_requirement">
                            <thead>
                                <tr class="danger">
                                    <th>No.</th>
                                    <th>Employer</th>
                                    <th>Type</th>
                                    <th>Registration Date</th>
                                    <th>Date Approved</th>
                                    <th>Payment Status</th>
                                    <th>Activation Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                  <?php $i=1; 
                                       foreach ($details as $row) {
                                        $pending_req= $this->serttech_recruitment_setting_model->total_pending_requirements($row->id);
                                        ?>
                                          <tr>
                                                <td><?php echo $i;?></span></td>
                                                <td><a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Employers details' onclick="view_details_employer_requirements('view_employer_details','view_employer','<?php echo $row->employer_id;?>','All');"><?php echo $row->company_name;?></a></td>
                                                <td><?php if($row->type=='free_trial'){ echo "Free Trial"; } else{ echo "Package"; }?></td>
                                                <td><?php echo $row->date_registered;?></td>
                                                <td><?php echo $row->date_approved;?></td>
                                                 <td><?php if($row->type=='free_trial'){ echo "Free"; } else { if($row->payment_status=='paid'){ echo 'Paid'; } else{ echo 'Not yet paid'; } };?></td> 
                                                 <td><?php echo $row->setting_activation;?></td> 
                                                <td><?php echo $row->status;?></td>
                                                <td>
                                                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to View Requirement Status' onclick="view_details_employer_requirements('view_employer_req','view_req','<?php echo $row->id;?>','All');"><i  class="fa fa-files-o fa-lg  pull-left"></i></a>

                                                      
                                                </td>
                                          </tr>

                                  <?php $i++;  } ?>
                            </tbody>
                </table>
        </div>     
  </div>              
<div class="col-md-4" id="sidebar_req" style="padding-top: 40px;" >
</div>
<?php  
}
elseif($type=='payment')
{ ?>

  <div class="col-md-8" style="padding-top:30px;">
    
    <div class="col-md-12">
                  <div class="col-md-12">
                        <div class="col-md-3"><label class="pull-right">Filter:</label></div>
                        <div class="col-md-4">
                          <select class="form-control" onchange="recruitment_requirement_stat_by_company('All',this.value);">
                            <?php
                               $companyList=$this->serttech_recruitment_setting_model->employers_job();
                            ?>
                              <option value="" disabled selected>Select Company</option>
                            <?php if(empty($companyList)){ echo "<option value=''>No company found.</option>"; } else{
                              foreach($companyList as $comp){?>
                              <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                            <?php } }?>
                          </select>
                        </div>
                          <div class="col-md-2">
                          <select class="form-control" onchange="recruitment_requirement_stat_by_company('All',this.value);">
                              <option value="" disabled selected>Select</option>
                              <option>All</option>
                              <option>Subscription</option>
                              <option>Free Trial</option>
                          </select>
                        </div>
                        <div class="col-md-3"></div>
                  </div>
                   <div class="col-md-12">
                      <div class="col-md-12"><br>
                          <div class="box box-default" class='col-md-12'></div>
                      </div>  
                    </div>
                </div>

     <div class="col-md-12" id="by_company_requirements">
        <table class="col-md-12 table table-hover" id="table_requirement" style="overflow: scroll;">
          <thead>
            <tr class="danger">
              <th>No.</th>
              <th>Employer</th>
              <th>Type</th>
              <th>Registration Date</th>
              <th>Date Approved</th>
              <th>Payment Status</th>
              <th>Activation Type</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; 
              foreach ($details as $row) {
                  $pending_req= $this->serttech_recruitment_setting_model->total_pending_requirements($row->id);
            ?>
                <tr>                          
                    <td><?php echo $i;?></span></td>                             
                    <td><a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Employers details' onclick="view_details_employer_requirements('view_employer_details','view_employer','<?php echo $row->employer_id;?>','All');"><?php echo $row->company_name;?></a></td>                           
                    <td><?php if($row->type=='free_trial'){ echo "Free Trial"; } else{ echo "Package"; }?></td>                           
                    <td><?php echo $row->date_registered;?></td>                            
                    <td><?php if($row->date_approved=='0000-00-00 00:00:00'){ echo "still pending"; } else{  echo $row->date_approved; }?></td>                            
                    <td><?php if($row->type=='free_trial'){ echo "Free"; } else { if($row->payment_status=='paid'){ echo 'Paid'; } else{ echo 'Not yet paid'; } };?></td>                              
                    <td><?php echo $row->setting_activation;?></td>                              
                    <td><?php echo $row->status;?></td>                            
                    <td>
                                           
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to View Requirement Status' onclick="view_details_employer_requirements('view_employer_req','view_req','<?php echo $row->id;?>','All');"><i  class="fa fa-files-o fa-lg  pull-left"></i></a>
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Mark as Paid' onclick="mark_as_active_paid('view_employer_req','<?php echo $row->setting_activation;?>','<?php echo $row->id;?>','payment');"><i  class="fa fa-paypal fa-lg  pull-left"></i></a>
                    </td>
               </tr>
            <?php $i++;  } ?>
            </tbody>
           </table>
        </div>     
  </div>              
<div class="col-md-4" id="sidebar_req" style="padding-top: 40px;" >
</div>
<?php }
else if($type=='manual_activation')
{?>
   <div class="col-md-8" style="padding-top:30px;">
    
     <div class="col-md-12">
                  <div class="col-md-12">
                        <div class="col-md-3"><label class="pull-right">Filter:</label></div>
                        <div class="col-md-4">
                          <select class="form-control" onchange="recruitment_requirement_stat_by_company('All',this.value);">
                            <?php
                               $companyList=$this->serttech_recruitment_setting_model->employers_job();
                            ?>
                              <option value="" disabled selected>Select Company</option>
                            <?php if(empty($companyList)){ echo "<option value=''>No company found.</option>"; } else{
                              foreach($companyList as $comp){?>
                              <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                            <?php } }?>
                          </select>
                        </div>
                          <div class="col-md-2">
                          <select class="form-control" onchange="recruitment_requirement_stat_by_company('All',this.value);">
                              <option value="" disabled selected>Select</option>
                              <option>All</option>
                              <option>Subscription</option>
                              <option>Free Trial</option>
                          </select>
                        </div>
                        <div class="col-md-3"></div>
                  </div>
                   <div class="col-md-12">
                      <div class="col-md-12"><br>
                          <div class="box box-default" class='col-md-12'></div>
                      </div>  
                    </div>
                </div>

     <div class="col-md-12" id="by_company_requirements">
        <table class="col-md-12 table table-hover" id="table_requirement" style="overflow: scroll;">
          <thead>
            <tr class="danger">
              <th>No.</th>
              <th>Employer</th>
              <th>Type</th>
              <th>Registration Date</th>
              <th>Date Approved</th>
              <th>Payment Status</th>
              <th>Activation Type</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; 
              foreach ($details as $row) {
                  $pending_req= $this->serttech_recruitment_setting_model->total_pending_requirements($row->id);
            ?>
                <tr>                          
                    <td><?php echo $i;?></span></td>                             
                    <td><a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Employers details' onclick="view_details_employer_requirements('view_employer_details','view_employer','<?php echo $row->employer_id;?>','All');"><?php echo $row->company_name;?></a></td>                           
                    <td><?php if($row->type=='free_trial'){ echo "Free Trial"; } else{ echo "Package"; }?></td>                           
                    <td><?php echo $row->date_registered;?></td>                            
                    <td><?php if($row->date_approved=='0000-00-00 00:00:00'){ echo "still pending"; } else{  echo $row->date_approved; }?></td>                            
                    <td><?php if($row->type=='free_trial'){ echo "Free"; } else { if($row->payment_status=='paid'){ echo 'Paid'; } else{ echo 'Not yet paid'; } };?></td>                              
                    <td><?php echo $row->setting_activation;?></td>                              
                    <td><?php echo $row->status;?></td>                            
                    <td> 
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to View Requirement Status' onclick="view_details_employer_requirements('view_employer_req','view_req','<?php echo $row->id;?>','All');"><i  class="fa fa-files-o fa-lg  pull-left"></i></a>
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Activate Account' onclick="mark_as_active_paid('view_employer_req','<?php echo $row->setting_activation;?>','<?php echo $row->id;?>','manual_activation');"><i  class="fa fa-check-square-o fa-lg  pull-left"></i></a>
                    </td>
               </tr>
            <?php $i++;  } ?>
            </tbody>
           </table>
        </div>     
  </div>              
<div class="col-md-4" id="sidebar_req" style="padding-top: 40px;" >
</div>
<?php }
else{?>
            <div class="col-md-12" style="padding-top: 40px;">
              <div class="col-md-8">
               
               <div class="col-md-12">
                  <div class="col-md-12">
                        <div class="col-md-3"><label class="pull-right">Filter:</label></div>
                        <div class="col-md-4">
                          <select class="form-control" onchange="recruitment_requirement_stat_by_company('All',this.value);">
                            <?php
                               $companyList=$this->serttech_recruitment_setting_model->employers_job();
                            ?>
                              <option value="" disabled selected>Select Company</option>
                            <?php if(empty($companyList)){ echo "<option value=''>No company found.</option>"; } else{
                              foreach($companyList as $comp){?>
                              <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                            <?php } }?>
                          </select>
                        </div>
                          <div class="col-md-2">
                          <select class="form-control" onchange="recruitment_requirement_stat_by_company('All',this.value);">
                              <option value="" disabled selected>Select</option>
                              <option>All</option>
                              <option>Subscription</option>
                              <option>Free Trial</option>
                          </select>
                        </div>
                        <div class="col-md-3"></div>
                  </div>
                   <div class="col-md-12">
                      <div class="col-md-12"><br>
                          <div class="box box-default" class='col-md-12'></div>
                      </div>  
                    </div>
            </div>

              <div class="col-md-12" id="by_company_requirements">

                 <table class="col-md-12 table table-hover" id="table_requirement">
                      <thead>
                          <tr class="danger">
                              <th>No.</th>
                              <th>Employer</th>
                              <th>Details</th>
                              <th>Type</th>
                              <th>Registration Date</th>
                              <th>Payment Status</th>
                              <th>Activation Type</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                            <?php $i=1; 
                                 foreach ($details as $row) {
                                  $pending_req= $this->serttech_recruitment_setting_model->total_pending_requirements($row->id);
                                  ?>
                                    <tr>
                                          <td><span class="badge"><?php echo $pending_req;?></span></td>
                                          <td><a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Employers details' onclick="view_details_employer_requirements('view_employer_details','view_employer','<?php echo $row->employer_id;?>','All');"><?php echo $row->company_name;?></a></td>
                                          <td><?php echo $row->company_name;?></td>
                                          <td><?php if($row->type=='free_trial'){ echo "Free Trial"; } else{ echo "Package"; }?></td>
                                          <td><?php echo $row->date_registered;?></td>
                                          <td><?php if($row->type=='free_trial'){ echo "Free"; } else { if($row->payment_status=='paid'){ echo 'Paid'; } else{ echo 'Not yet paid'; } };?></td> 
                                          <td><?php echo $row->setting_activation;?></td> 
                                          <td><?php echo $row->status;?></td>
                                          <td>
                                              
                                                  <?php if($row->status!='pending')
                                                  {?>
                                                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to View Requirement Status' onclick="view_details_employer_requirements('view_employer_req','view_req','<?php echo $row->id;?>','All');"><i  class="fa fa-files-o fa-lg  pull-left"></i></a>

                                                  <?php } else{?>
                                                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update Requirement Status' onclick="view_details_employer_requirements('view_employer_req','Update_req','<?php echo $row->id;?>','All');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                                  <?php }?>
                                          </td>
                                    </tr>

                            <?php $i++;  } ?>
                      </tbody>
                  </table>
              </div>
              </div>

              <div class="col-md-4" id="sidebar_req">

                  <div class="col-md-12">
                  <?php if($type=='All' || $type=='free_trial'){?>
                                    <div class="box box-default">
                                       <div class="box-header with-border">
                                            <h3 class="box-title">Free Trial Requirements</h3>
                                        </div>
                                        <div class="box-body">
                                          <table class="table table-user-information" id="free_trial">
                                            <thead>
                                               <tr style="display: none;">
                                                  <th></th>
                                                  <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i=1; foreach ($free_trial as $row) {?>
                                              <tr>
                                                <td class="pull-right"><?php echo $i.")";?></td>
                                                <td class="text-info"><strong><?php echo $row->title;?></strong></td>
                                              </tr>
                                            <?php $i++; } ?>
                                            </tbody>
                                          </table>
                                        </div>
                                      </div>
                                  </div>
                <?php } if($type=='subscription' || $type=='All'){?>
                                   <div class="col-md-12">
                                    <div class="box box-default">
                                       <div class="box-header with-border">
                                            <h3 class="box-title">Subscription Requirements</h3>
                                        </div>
                                        <div class="box-body">
                                          <table class="table table-user-information" id="subscription">
                                             <thead>
                                               <tr style="display: none;">
                                                  <th></th>
                                                  <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php $i=1; foreach ($package as $row) {?>
                                              <tr>
                                                <td class="pull-right"><?php echo $i.")";?></td>
                                                <td class="text-info"><strong><?php echo $row->title;?></strong></td>
                                              </tr>
                                            <?php $i++; } ?>
                                            </tbody>
                                          </table>
                                        </div>
                                      </div>
                                  </div>
                <?php } ?>
              </div>

            </div>  
<?php } ?>
