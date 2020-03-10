
<ol class="breadcrumb">
  <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Training and Seminar Details 
    <button class="btn btn-info btn-xs pull-right" style="cursor: pointer;"  data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/employee_training_seminars/add_mass_employees');?>"><i class="fa fa-pencil"></i>&nbsp;Update Employees</button>
    <button class="btn btn-danger btn-xs pull-right" style="cursor: pointer;margin-right: 5px;" onclick="viewing_of_incoming_trainings_seminar();"><i class="fa fa-arrow-left"></i>&nbsp;BACK</button>
  </h4>
</ol>

<form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_training_seminars/incoming_training_seminar_modify">

 <?php foreach($details as $training_seminar){?>
  <input type="hidden" name="training_seminar_id" value="<?php echo $training_seminar->training_seminar_id;?>">
    <div>
     <div class="col-md-8">   
     <div class="panel panel-success panel-heading"  id='action_trans' style="height: 800px;overflow-y: scroll;">
        <div class="panel-heading">
            <h4><i class="fa fa-clipboard"></i><?php echo strtoupper($training_seminar->training_title);?></h4>   
         </div>
              <div class="col-md-12" style="padding-top:20px;">
                <div class="col-md-4"><label>Training Type</label></div>
                <div class="col-md-8">
                    <select class="form-control" id="training_type" name="training_type" required>
                        <option value="" disabled selected>Select</option>
                        <option value="training" <?php if($training_seminar->training_type=='training'){ echo "selected"; }?>>Training</option>
                        <option value="seminar" <?php if($training_seminar->training_type=='seminar'){ echo "selected"; }?>>Seminar</option>
                    </select>
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Sub Type</label></div>
                <div class="col-md-8">
                    <select class="form-control" id="sub_type" name="sub_type" required onchange="view_conducted_by();">
                        <option value="" disabled selected>Select</option>
                        <option value="internal" <?php if($training_seminar->sub_type=='internal'){ echo "selected"; }?>>Internal(conducted by the company)</option>
                        <option value="external" <?php if($training_seminar->sub_type=='external'){ echo "selected"; }?>>External(conducted by other agency/company)</option>
                    </select>
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Title/Topic</label></div>
                <div class="col-md-8">
                  <input type="text" class="form-control" id="title" name="title"  value="<?php echo $training_seminar->training_title; ?>" required>
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Conducted By Type</label></div>
                <div class="col-md-8">
                    <select class="form-control" id="conducted_by_type" name="conducted_by_type" required>
                      <option value="" disabled selected>Select</option>
                      <option value="internal" <?php if($training_seminar->conducted_by_type=='internal'){ echo "selected"; }?>>Internal</option>
                      <option value="external" <?php if($training_seminar->conducted_by_type=='external'){ echo "selected"; }?>>External</option>
                    </select>
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Conducted By</label></div>
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

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Purpose / Objective</label></div>
                <div class="col-md-8">
                   <input type="text" class="form-control" name="purpose" id="purpose" required value="<?php echo $training_seminar->purpose; ?>">
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Address Conducted</label></div>
                <div class="col-md-8">
                   <input type="text" class="form-control" id="address" name="address" required value="<?php echo $training_seminar->training_address; ?>">
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
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

                <?php if($training_seminar->fee_type=='company'){ $f=''; } else{ $f='display:none;'; }?>
               <div class="col-md-12"  style="margin-top: 10px;<?php echo $f;?>" id="requiredMonthscompany">
                  <div class="col-md-4"><label>Required Month/s</label></div>
                  <div class="col-md-8">
                      <input type="text" class="form-control" id="requiredmonths" name="requiredmonths" value="<?php echo $training_seminar->monthsRequired;?>" onkeypress="return isNumberKey(this, event);" required>
                      <n class="text-danger">Required length of service to be totally shouldered<br> by the company</n>
                  </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Attachment</label></div>
                <div class="col-md-8">
                  <input type="file" name="file" class="form-control"  id="file" value="<?php echo $training_seminar->file_name; ?>">
                </div>
              </div>

             
               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Fee Amount</label></div>
                <div class="col-md-8">
                   <input type="number" class="form-control" id="fee_amount" name="fee_amount" value="<?php echo $training_seminar->fee_amount;?>" onkeypress="return isNumberKey(this, event);" onkeyup ="check_payment_status();" value="<?php echo $training_seminar->fee_amount; ?>" >
                </div>
              </div>

             
              <div class="col-md-12"  style="margin-top: 10px;">
                <div class="col-md-4"><label>Date From</label></div>
                  <div class="col-md-8">
                      <input type="date" class="form-control" id="date_from" name="date_from" required value="<?php echo $training_seminar->date_from; ?>" onchange="get_compan(event);">
                  </div>
              </div>

              <div class="col-md-12"  style="margin-top: 10px;">
                <div class="col-md-4"><label>Date To</label></div>
                  <div class="col-md-8">
                   <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo $training_seminar->date_to; ?>" required onchange="get_compan(event);">
                  </div>
              </div>

              <div class="col-md-12"  style="margin-top: 10px;">
               <div class="col-md-12">
                  <input type="hidden" name="seminarid" id="seminarid" value="<?php echo $training_seminar->training_seminar_id;?>">
                    <div class="text-danger" id="date_list" style="padding-left: 30px;">
                      <center>
                        <?php  $dates = $this->employee_training_seminars_model->get_incoming_trainingseminars_date($training_seminar->training_seminar_id); ?>    
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
                                    <td>  
                                      <input type="time" style="width: 90%;font-color:red;" name='time_from<?php echo $i?>' id='time_from<?php echo $i?>' class="classtimefrom" value="<?php echo $d->time_from;?>">  
                                    </td>
                                    <td>  
                                      <input type="time" style="width: 90%;" name='time_to<?php echo $i?>' id='time_to<?php echo $i?>' class="classtimeto" value="<?php echo $d->time_to;?>"> 
                                    </td>
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
          </div>
        </div>

        <div class="col-md-4" id="selected_employee_ts" style="height:800px;overflow-y:scroll;padding-top: 30px;">
          <input type="hidden" name="company" value="<?php echo $training_seminar->company_id;?>">

             <table class="table table-bordered" id="table_emp">
                <thead>
                    <tr class="danger">
                        <th style="width: 100%;"><center>LIST OF SELECTED EMPLOYEES</center></th>
                    </tr>
                </thead>
                <tbody>
                <?php $string=""; $i=1; foreach($employees as $e){
                    $dd = $e->employee_id;
                    $string .= $dd."-";
                  ?>
                    <tr>
                        <td><?php echo $i."). ";?><?php echo $e->fullname;?></td>
                    </tr>
                <?php $i++; } echo '<input type="text" name="finalemployee" id="finalemployee" value='.$string.' style="display:none;">'; ?>
                </tbody>
             </table>

        </div>
      </div>
  <?php } ?>


  <div class="col-md-12">
    <button class="col-md-12 btn btn-success" id="smbt_ind">SAVE CHANGES</button>
  </div>

</form>