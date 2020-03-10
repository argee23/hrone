  
<?php foreach($details as $d) { ?>
  
  

  <div class="col-md-8">


        <input type="hidden" id="seminarid" value="<?php echo $id;?>">
        <div class="col-md-12">
                        <div class="col-md-4"><label>Title</label></div>
                          <div class="col-md-8">
                              <textarea class="form-control" rows="3" id="title" name="title"><?php echo $d->training_title;?></textarea>
                        </div>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
                        <div class="col-md-4"><label>Purpose</label></div>
                          <div class="col-md-8">
                            <textarea class="form-control" name="purpose" id="purpose" rows="3"><?php echo $d->purpose;?></textarea>
                        </div>
        </div>

        <div class="col-md-12" style="margin-top: 5px;">
                        <div class="col-md-4"><label>Conducted By Type</label></div>
                          <div class="col-md-8">
                            <select class="form-control" id="conducted_by_type" name="conducted_by_type" required onchange="view_conducted_by();">
                                <option disabled selected>Select Conducted By Type</option>
                                <option value="internal" <?php if($d->conducted_by_type=='internal'){ echo "selected"; }?> >Internal</option>
                                <option value="external" <?php if($d->conducted_by_type=='external'){ echo "selected"; }?> >External</option>
                            </select>
                        </div>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
                        <div class="col-md-4"><label>Conducted By</label></div>
                          <div class="col-md-8">
                          <?php if($d->conducted_by_type=='internal'){
                              $fullname= $this->employee_training_seminars_final_model->get_fullname($d->conducted_by);
                            ?>

                            <a data-toggle="modal" data-target="#add_conducted_by_type"> 
                              <input type="text" class="form-control" name="conducted_by" id="conducted_by" value="<?php echo $fullname;?>" required>
                            </a>
                            <input type="hidden" id="conducted_by_employee" name="conducted_by_employee" value="<?php echo $d->conducted_by;?>">

                          <?php } else { ?>

                            <input type="text" class="form-control" name="conducted_by" id="conducted_by" value="<?php echo $d->conducted_by;?>">
                            
                          <?php } ?>
                        </div>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
                        <div class="col-md-4"><label>Address Conducted</label></div>
                          <div class="col-md-8">
                            <input type="text" class="form-control"  id="address" name="address" value="<?php echo $d->training_address;?>">
                        </div>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
                        <div class="col-md-4"><label>Fee Type</label></div>
                          <div class="col-md-8">
                            <select class="form-control" id="fee_type" name="fee_type" required onchange="payment_file_maintenance(this.value);">
                                <option value="" disabled selected>Select</option>
                                <option value="company" <?php if($d->fee_type=='company'){ echo "selected"; }?> >Company Shoulder</option>
                                <option value="employee" <?php if($d->fee_type=='employee'){ echo "selected"; }?> >Employee Shoulder</option>
                                <option value="free" <?php if($d->fee_type=='free'){ echo "selected"; }?> >Free</option>
                            </select>
                        </div>
        </div>
        <?php if($d->fee_type=='free'){ $pp = 'disabled'; } else{ $pp = ''; } ?>
        <div class="col-md-12" style="margin-top: 10px;">
                        <div class="col-md-4"><label>Fee Amount</label></div>
                          <div class="col-md-8">
                            <input type="text" class="form-control" id="fee_amount" name="fee_amount" value="<?php echo $d->fee_amount;?>" onkeypress="return isNumberKey(this, event);" <?php echo $pp;?>>
                        </div>
        </div>

        <?php if($d->fee_type=='free'){ $ppp = 'disabled'; } else{ $ppp = ''; } ?>

        <div class="col-md-12" style="margin-top: 10px;">
                        <div class="col-md-4"><label>Payment Status</label></div>
                          <div class="col-md-8">
                            <select class="form-control" id="payment_status" name="payment_status" required  <?php echo $ppp;?>>
                                <option value="" disabled selected>Select Payment Status</option>
                                <option value="paid" <?php if($d->payment_status=='paid'){ echo "selected"; }?>>Paid</option>
                                <option value="unpaid" <?php if($d->payment_status=='unpaid'){ echo "selected"; }?>>Unpaid</option>
                                <option value="partial" <?php if($d->payment_status=='partial'){ echo "selected"; }?>>Partial pay</option>

                            </select>
                        </div>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
                        <div class="col-md-4"><label>File Attachment</label></div>
                          <div class="col-md-8">
                            <input type="file" class="form-control" name="file" id="file">
                        </div>
        </div>

        <?php if($d->payment_status=='company'){ $df=''; } else{ $df='disabled'; }?>
        <div class="col-md-12" style="margin-top: 10px;" id="requiredMonthscompany">
                        <div class="col-md-4"><label>Months required</label></div>
                          <div class="col-md-8"> 
                            <input type="text" class="form-control" id="requiredmonths" name="requiredmonths" onkeypress="return isNumberKey(this, event);" <?php echo $df;?>>
                            <n class="text-danger">Required Length of service</n>
                        </div>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
                        <div class="col-md-4"><label>Date From</label></div>
                          <div class="col-md-8">
                            <input type="date" class="form-control" value="<?php echo $d->datefrom;?>" id="date_from" name="date_from"  onchange="get_compan_file_maintenance(event);">
                        </div>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
                        <div class="col-md-4"><label>Date To</label></div>
                          <div class="col-md-8">
                            <input type="date" class="form-control"  value="<?php echo $d->dateto;?>" id="date_to" name="date_to"  onchange="get_compan_file_maintenance(event);"> 
                        </div>
        </div>

        <div class="col-md-12" style="margin-top: 20px;height: 200px;overflow-y: scroll" id="date_list">
          <table class="table table-bordered">
            <thead>
                <tr class="danger">
                    <th>Date</th>
                    <th>Time From</th>
                    <th>Time To</th>
                    <th>Hours</th>
                </tr>
            </thead>
            <tbody>
             <?php 
                $string="";
                $i=1; foreach($dates as $dd){
                $datee = $dd->date;
                $string .= $i."=";
            ?>
              <tr>
                  <td>
                      <input type="checkbox" onclick="checker_date_range('<?php echo $i;?>');" class="dateclass" checked> <?php echo $dd->date;?> 
                      <input type="hidden" name='date_<?php echo $i?>' id='date_<?php echo $i?>' value='<?php echo $dd->date;?>'>
                      <input type='hidden' id="checker<?php echo $i;?>" value='1'> 
                  </td>
                  <td>  
                      <input type="time" style="width: 90%;font-color:red;" name='time_from<?php echo $i?>' id='time_from<?php echo $i?>' class="classtimefrom" value="<?php echo $dd->time_from;?>"> 
                  </td>
                  <td>
                      <input type="time" style="width: 90%;" name='time_to<?php echo $i?>' id='time_to<?php echo $i?>' class="classtimeto" value="<?php echo $dd->time_to;?>"> </td>
                  <td>  
                     <input type="number" style="width: 50%;" name='hour<?php echo $i;?>' id='hour<?php echo $i?>' class="classhour" placeholder="Hours" value="<?php echo $dd->hours;?>">
                  </td> 
              </tr>
            <?php $i++; } ?>
            </tbody>
          </table>
          <input type="hidden" id="count_dates" value="<?php echo $i;?>">
          <input type="hidden" id="selected_dates"  name="selected_dates" value="<?php echo $string;?>" class="form-control" required>
        </div>

  </div>


  <div class="col-md-4">

     <div style="height:auto;" id="selected_employee_ts">
        <table id="selected_emp" class="col-md-12 table table-hover table-striped">
          <thead>
            <tr  class="success">
              <th width="30%;">Employee ID</th>
              <th width="60%;">Name</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
    </div>

  </div>






<?php } ?>

<div class="col-md-12" style="margin-top:20px;"><button type="submit" id="smbt_ind" class="col-md-12 btn btn-success">SAVE</button></div>
