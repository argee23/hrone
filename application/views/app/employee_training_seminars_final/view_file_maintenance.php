<ol class="breadcrumb">
  <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>File Maintenance Training and Seminar Details 
<button class="btn btn-danger btn-xs pull-right" style="cursor: pointer;" onclick="file_maintenance();"><i class="fa fa-arrow-left"></i>&nbsp;BACK</button>
  </h4>
</ol>

                              
 <?php foreach($details as $d){?>
    <div>
     <div class="col-md-8">   
     <div class="panel panel-success panel-heading"  id='action_trans' style="height: 600px;overflow-y: scroll;">
        <div class="panel-heading">
            <h4><i class="fa fa-clipboard"></i><?php echo strtoupper($d->training_title);?></h4>   
         </div>
              <div class="col-md-12" style="padding-top:20px;">
                <div class="col-md-4"><label>Training Type</label></div>
                <div class="col-md-8">
                   <n class="text-danger"><?php echo $d->training_type;?></n>
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Sub Type</label></div>
                <div class="col-md-8">
                   <n class="text-danger"><?php echo $d->sub_type;?></n>
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Title/Topic</label></div>
                <div class="col-md-8">
                  <n class="text-danger"><?php echo $d->training_title;?></n>
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Conducted By Type</label></div>
                <div class="col-md-8">
                    <n class="text-danger"><?php echo $d->conducted_by_type;?></n>
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Conducted By</label></div>
                <div class="col-md-8" id="div_conducted_by">
                   <n class="text-danger"><?php echo $d->conducted_by;?></n>
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Purpose / Objective</label></div>
                <div class="col-md-8">
                   <n class="text-danger"><?php echo $d->purpose;?></n>
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Address Conducted</label></div>
                <div class="col-md-8">
                   <n class="text-danger"><?php echo $d->training_address;?></n>
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Fee Type</label></div>
                <div class="col-md-8">
                  <n class="text-danger"><?php echo $d->fee_type;?></n>
                </div>
              </div>

              <?php if($d->fee_type=='company'){?>
              <div class="col-md-12"  style="margin-top: 10px;" id="requiredMonthscompany">
                  <div class="col-md-4"><label>Required Months</label></div>
                    <div class="col-md-8">
                      <n class="text-danger"><?php if($d->monthsRequired==0 || empty($d->monthsRequired)){ echo "No required length of service to be totally shouldered by the company"; } else{ echo $d->monthsRequired." Month/s. "; } ?></n>
                    </div>
              </div>

              <?php } ?>

             

              <?php if($d->fee_type=='free'){}else{?>
               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><label>Fee Amount</label></div>
                <div class="col-md-8">
                   <n class="text-danger"><?php if(empty($d->fee_amount)){} else{ echo number_format($d->fee_amount,2); }?></n>
                </div>
              </div>

              <?php } ?>

              <div class="col-md-12"  style="margin-top: 10px;">
                <div class="col-md-4"><label>Date From</label></div>
                  <div class="col-md-8">
                     <n class="text-danger">
                          <?php 
                            $month=substr($d->datefrom, 5,2);
                            $day=substr($d->datefrom, 8,2);
                            $year=substr($d->datefrom, 0,4);

                            echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                          ?>
                     </n>
                  </div>
              </div>

              <div class="col-md-12"  style="margin-top: 10px;">
                <div class="col-md-4"><label>Date To</label></div>
                  <div class="col-md-8">
                    <n class="text-danger">
                       <?php 
                            $month=substr($d->dateto, 5,2);
                            $day=substr($d->dateto, 8,2);
                            $year=substr($d->dateto, 0,4);

                            echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                          ?>
                    </n>
                  </div>
              </div>
              
          </div>
        </div>

           <div class="col-md-4" id="selected_employee_ts" style="overflow-y:scroll;">
            <table class="table table-hover" id="table_emp1">
                    <thead>
                        <tr class="success">
                          <th>Date</th>
                          <th>Time</th>
                          <th>Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach($dates as $dd){?>
                        <tr>
                          <td>
                            <?php 
                              $month=substr($dd->date, 5,2);
                              $day=substr($dd->date, 8,2);
                              $year=substr($dd->date, 0,4);

                              echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                            ?>
                          </td>
                          <td><?php echo $dd->time_from." to ".$dd->time_to;?></td>
                          <td><?php echo $dd->hours;?></td>
                        </tr>
                    <?php } ?>
                        <tr>
                          <td></td>
                          <td>Total</td>
                          <td><?php echo $d->total_hours;?></td>
                        </tr>   
                    </tbody>
                  </table>
           </div>


      </div>
  <?php } ?>

