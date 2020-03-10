<div class="row">
<div class="col-md-8">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>TRAINING AND SEMINAR ATTAINMENT</strong> (edit)</div>
  <div class="box-body">

    <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_201_profile/training_seminar_modify/<?php echo $this->uri->segment("4");?>" >

          <div class="row">
            <div class="col-md-12">
                             <input type="hidden" name="company" id="company" value="<?php echo $company_id;?>">
                            <div class="col-md-6" style="margin-top: 10px;">
                                <div class="col-md-4"><label>Training Type</label></div>
                                <div class="col-md-8">
                                  <select class="form-control" id="training_type" name="training_type" required>
                                    <option value="" disabled selected>Select</option>
                                    <option value="training" <?php if($training_seminar->training_type=='training'){ echo "selected"; }?>>Training</option>
                                    <option value="seminar" <?php if($training_seminar->training_type=='seminar'){ echo "selected"; }?>>Seminar</option>
                                  </select>
                                </div>
                            </div> 

                            <div class="col-md-6" style="margin-top: 10px;">  
                                <div class="col-md-4"><label>Sub Type</label></div>
                                <div class="col-md-8">
                                  <select class="form-control" id="sub_type" name="sub_type" required onchange="view_conducted_by();">
                                    <option value="" disabled selected>Select</option>
                                    <option value="internal" <?php if($training_seminar->sub_type=='internal'){ echo "selected"; }?>>Internal(conducted by the company)</option>
                                    <option value="external" <?php if($training_seminar->sub_type=='external'){ echo "selected"; }?>>External(conducted by other agency/company)</option>
                                  </select>
                                </div>
                            </div>
                           
                            <div class="col-md-6" style="margin-top: 10px;">
                                 <div class="col-md-4"><label>Title / Topic</label></div>
                                <div class="col-md-8">
                                  <input type="text" class="form-control" id="title" name="title"  value="<?php echo $training_seminar->training_title; ?>" required>
                                </div>
                            </div>
                            

                             <div class="col-md-6"  style="margin-top: 10px;">
                                <div class="col-md-4"><label>Conducted by type</label></div>
                                <div class="col-md-8">
                                  <select class="form-control" id="conducted_by_type" name="conducted_by_type" required>
                                    <option value="" disabled selected>Select</option>
                                    <option value="internal" <?php if($training_seminar->conducted_by_type=='internal'){ echo "selected"; }?>>Internal</option>
                                    <option value="external" <?php if($training_seminar->conducted_by_type=='external'){ echo "selected"; }?>>External</option>
                                  </select>
                                </div>
                            </div>


                             <div class="col-md-6"  style="margin-top: 10px;">
                              <div class="col-md-4"><label>Conducted by</label></div>
                                  <div class="col-md-8" id="div_conducted_by">
                                   <?php if($training_seminar->conducted_by_type=='internal'){?>

                                    <a data-toggle="modal" data-target="#add_conducted_by_type"> 
                                      <input type="text" class="form-control" name="conducted_by" id="conducted_by" value="<?php echo $training_seminar->conducted_by; ?>" required> 
                                   </a>
                                    <input type="hidden" id="conducted_by_employee" name="conducted_by_employee">

                                    <?php } else{ ?>
                                     <input type="text" class="form-control" name="conducted_by" id="conducted_by" required value="<?php echo $training_seminar->conducted_by; ?>">
                                   
                                    <?php } ?>
                              </div>
                            </div>



                            <div class="col-md-6" style="margin-top: 10px;">
                                <div class="col-md-4"><label>Purpose / Objective</label></div>
                                <div class="col-md-8">
                                  <input type="text" class="form-control" name="purpose" id="purpose" required value="<?php echo $training_seminar->purpose; ?>"> 
                                </div>
                            </div>
                           
                           
                            <div class="col-md-6"  style="margin-top: 10px;">
                                <div class="col-md-4"><label>Address </label></div>
                                <div class="col-md-8">
                                  <input type="text" class="form-control" id="address" name="address" required value="<?php echo $training_seminar->training_address; ?>">
                                </div>
                            </div>

                            
                            <div class="col-md-6"  style="margin-top: 10px;">
                                <div class="col-md-4"><label>Fee Type</label></div>
                                <div class="col-md-8">
                                  <select class="form-control" id="fee_type" name="fee_type" onchange="payment(this.value);" required>
                                    <option value="" disabled selected>Select</option>
                                    <option value="company" <?php if($training_seminar->fee_type=='company'){ echo "selected"; }?>>Company Shoulder</option>
                                    <option value="employee" <?php if($training_seminar->fee_type=='employee'){ echo "selected"; }?> >Employee Shoulder</option>
                                    <option value="free" <?php if($training_seminar->fee_type=='free'){ echo "selected"; }?>>Free</option>
                                  </select>
                                </div>
                            </div>

                            <?php if($training_seminar->fee_type=='free'){ $dd = 'disabled'; } else{ $dd = ''; }?>
                            <div class="col-md-6"  style="margin-top: 10px;">
                                <div class="col-md-4"><label>Fee Amount</label></div>
                                <div class="col-md-8">
                                  <input type="number" class="form-control" id="fee_amount" name="fee_amount" value="<?php echo $training_seminar->fee_amount;?>" onkeypress="return isNumberKey(this, event);" onkeyup ="check_payment_status();" value="<?php echo $training_seminar->fee_amount; ?>" <?php echo $dd;?>>
                                </div>
                            </div>
                             <?php if($training_seminar->fee_type=='free'){ $ddd = 'disabled'; } else{ $ddd = ''; }?>

                            <div class="col-md-6"  style="margin-top: 10px;">
                                <div class="col-md-4"><label>Payment Status</label></div>
                                <div class="col-md-8">
                                   <select class="form-control" id="payment_status" name="payment_status" <?php echo $ddd;?>>
                                      <option value="">Select</option>
                                      <option value="paid" <?php if($training_seminar->payment_status=='paid'){ echo "selected"; };?>>Paid</option>
                                       <option value="unpaid"  <?php if($training_seminar->payment_status=='unpaid'){ echo "selected"; };?>>Unpaid</option>
                                      <option value="partial"  <?php if($training_seminar->payment_status=='partial'){ echo "selected"; };?>>Partial</option>
                                  </select>  
                              </div>
                            </div>

                            <?php if($training_seminar->fee_type=='company'){ $f='required'; } else{ $f='disabled'; }?>
                             <div class="col-md-6"  style="margin-top: 10px;" id="requiredMonthscompany">
                                <div class="col-md-12"><label>Months Required</label></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-8">
                                   <input type="text" class="form-control" id="requiredmonths" name="requiredmonths" value="<?php echo $training_seminar->monthsRequired;?>" onkeypress="return isNumberKey(this, event);" <?php echo $f;?> >
                                   <n class="text-danger">Required length of service (months)</n>
                                </div>
                            </div>


                            
                            <div class="col-md-6"  style="margin-top: 10px;">
                                <div class="col-md-4"><label>Attached File </label></div>
                                <div class="col-md-8">
                                  <input type="file" name="file" class="form-control"  id="file" value="<?php echo $training_seminar->file_name; ?>">
                                </div>

                            </div>


                            <div class="col-md-6"  style="margin-top: 10px;">
                                <div class="col-md-4"><label>Date From</label></div>
                                <div class="col-md-8">
                                  <input type="date" class="form-control" id="date_from" name="date_from" required value="<?php echo $training_seminar->datefrom; ?>" onchange="get_compan(event);">
                                </div>
                            </div>
                           
                            <div class="col-md-6"  style="margin-top: 10px;">
                                <div class="col-md-4"><label>Date To</label></div>
                                <div class="col-md-8">
                                  <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo $training_seminar->dateto; ?>" required onchange="get_compan(event);">
                                </div>
                            </div>


                            <div class="col-md-12"  style="margin-top: 10px;">
                                    
                                    <div class="col-md-12">
                                        <input type="hidden" name="seminarid" id="seminarid" value="<?php echo $training_seminar->training_seminar_id;?>">
                                        <div class="text-danger" id="date_list">
                                            <center>
                                        <?php  $dates = $this->employee_201_profile_model->get_all_dates($training_seminar->training_seminar_id); ?>    
                                            <table class="table table-hover" id="bb<?php echo $training_seminar->training_seminar_id;?>">
                                            <thead>
                                                <tr class="danger">
                                                    <th>Date</th>
                                                    <th>Time From</th>
                                                    <th>Time In</th>
                                                    <th>Hours</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <?php 
                                                      $string="";
                                                      $i=1; foreach($dates as $d){
                                                      $datee = $d->date;
                                                      $string .= $i."=";
                                                  ?>
                                                    <tr>
                                                          <td>
                                                              <input type="checkbox" onclick="checker_date_range('<?php echo $i;?>');" class="dateclass" checked> <?php echo $d->date;?> 
                                                              <input type="hidden" name='date_<?php echo $i?>' id='date_<?php echo $i?>' value='<?php echo $d->date;?>'>
                                                              <input type='hidden' id="checker<?php echo $i;?>" value='1'> 
                                                          </td>
                                                          
                                                            
                                                          <td>  <input type="time" style="width: 90%;font-color:red;" name='time_from<?php echo $i?>' id='time_from<?php echo $i?>' class="classtimefrom" value="<?php echo $d->time_from;?>">  </td>
                                                          <td>  <input type="time" style="width: 90%;" name='time_to<?php echo $i?>' id='time_to<?php echo $i?>' class="classtimeto" value="<?php echo $d->time_to;?>"> </td>

                                                          <td>  
                                                              <input type="number" style="width: 50%;" name='hour<?php echo $i;?>' id='hour<?php echo $i?>' class="classhour" placeholder="Hours" value="<?php echo $d->hours;?>">
                                                          </td>
                                                            
                                                    </tr>
                                                <?php $i++; } ?>
                                            </tbody>
                                        </table>
                                        </center>
                                         <input type="hidden" id="count_dates" value="<?php echo $i;?>">
                                         <input type="hidden" id="selected_dates"  name="selected_dates" value="<?php echo $string;?>" class="form-control" required>

                                        </div>
                                    </div>
                            </div>





                            <input type="hidden" name="payment_status_final" id="payment_status_final" value="<?php echo $training_seminar->payment_status;?>">
                      </div>

                <div class="form-group">
                  <div class="col-md-12"  style="padding-top: 30px;"><button type="submit" class="form-control btn btn-danger" id="smbt_ind"><i class="fa fa-floppy-o"></i> SAVE CHANGES</button></div>
                </div>
            </form>
         </div> 
     </div>
    </div>
</div>
</div>  
</div>


