<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/email_settings/save_company_email_settings" enctype="multipart/form-data">

            <div class="box box-success">
              <div class="panel panel-info">
                    <div class="col-md-12" id="fetch_all_result"><br>
                        <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Email Settings | <?php echo $company_name;?></h4></ol>

                        <div class="col-md-12" id="main_action" style="padding-top: 30px;">

                            <div class="col-md-1"></div>
                            <div class="col-md-9">
                              
                              <div class="col-md-12">  
                                  <div class="col-md-4">
                                      <label class="pull-right">SMTP Host</label>
                                  </div>
                                  <div class="col-md-8">
                                  <input type="hidden" name="company" id="company" value="<?php echo $company;?>"> 
                                      <input type="text" id="smtp_host" name="smtp_host" class="form-control" placeholder="SMTP Host" value="<?php if(empty($company_email_setting->smtp_host)){}else{ echo $company_email_setting->smtp_host; }?>">
                                  </div>
                              </div>

                               <div class="col-md-12" style="padding-top: 5px;">  
                                  <div class="col-md-4">
                                      <label class="pull-right">SMTP Port</label>
                                  </div>
                                  <div class="col-md-8">
                                      <input type="text" id="smtp_port" name="smtp_port" class="form-control" placeholder="SMTP Port"  value="<?php if(empty($company_email_setting->smtp_port)){}else{ echo $company_email_setting->smtp_port; }?>">
                                  </div>
                              </div>

                               <div class="col-md-12" style="padding-top: 5px;">  
                                  <div class="col-md-4">
                                      <label class="pull-right">Username</label>
                                  </div>
                                  <div class="col-md-8">
                                    
                                      <input type="email" id="send_mail_from" name="send_mail_from" class="form-control" placeholder="ex: sample@gmail.com" value="<?php if(empty($company_email_setting->send_mail_from)){}else{ echo $company_email_setting->send_mail_from; }?>">
                                  </div>
                              </div>

                               <div class="col-md-12" style="padding-top: 5px;">  
                                  <div class="col-md-4">
                                      <label class="pull-right">Password</label>
                                  </div>
                                  <div class="col-md-8">
                                      <input type="text" id="password" name="password" class="form-control" placeholder="Password" value="<?php if(empty($company_email_setting->password)){}else{ echo $company_email_setting->password; }?>">
                                  </div>
                              </div>

                               <div class="col-md-12" style="padding-top: 5px;">  
                                  <div class="col-md-4">
                                      <label class="pull-right">Send Mail From</label>
                                  </div>
                                  <div class="col-md-8">
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Send Email From" value="<?php if(empty($company_email_setting->username)){}else{ echo $company_email_setting->username; }?>">

                                  </div>
                              </div>

                               <div class="col-md-12" style="padding-top: 5px;">  
                                  <div class="col-md-4">
                                      <label class="pull-right">Security Type</label>
                                  </div>
                                  <div class="col-md-8">
                                      <select class="form-control" id="security_type" name="security_type">
                                          <option value="tls" <?php if(empty($company_email_setting->security_type)){} else{ if($company_email_setting->security_type=='tls'){ echo "selected"; } };?>>tls</option>
                                          <option value="ssl" <?php if(empty($company_email_setting->security_type)){} else{ if($company_email_setting->security_type=='ssl'){ echo "selected"; } };?>>ssl</option>
                                      </select>
                                  </div>
                              </div>

                              <div class="col-md-12" style="padding-top: 5px;">  
                                  <div class="col-md-4">
                                      <label class="pull-right">Status</label>
                                  </div>
                                  <div class="col-md-8">
                                      <select class="form-control" id="status" name="status">
                                          <option value="Active" <?php if(empty($company_email_setting->status)){} else{ if($company_email_setting->status=='Active'){ echo "selected"; } };?> >Active </option>
                                          <option value="Inactive" <?php if(empty($company_email_setting->status)){} else{ if($company_email_setting->status=='Inactive'){ echo "selected"; } };?> >InActive </option>
                                      </select>
                                  </div>
                              </div>

                              
                              <div class="col-md-12" style="padding-top: 10px;">  
                                  <div class="col-md-4">
                                  </div>
                                  <div class="col-md-8">
                                     <button type="submit" class="col-md-12 btn btn-success">SAVE CHANGES</button>
                                  </div>
                              </div>

                            </div>
                            <div class="col-md-2"></div>
                            
                        </div>


                    </div>
                    <div class="btn-group-vertical btn-block"> </div>   
              </div>             
            </div> 
</form>