<div class="col-md-9">
  <div class="tab-content">
    <div class="tab-pane active" id="p_info">
      <div class="panel panel-success"> 
        <div class="panel-heading">
          <span class="pull-right"> 
            <?php if($setting=='allowed') { if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else{  ?>  <?php echo "<a type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#modal' href='".base_url('employee_portal/employee_201/add_training_modal')."/".$this->session->userdata('employee_id')."'>";?><i class="fa fa-plus"></i> Add training/work</a><?php } } else{?>
              <a href="#editable_topics">View editable topic</a>
            <?php } ?>
          </span>
          <h4 class="text-info"><?php if($setting=='allowed') { ?> Training and Seminar Attainment <?php } else{?> You're not allowed to edit,delete and add <b>Training and Seminar Attainment</b> <?php } ?></h4>
           <?php foreach ($info as $training_seminar) {
            $update = null;
            foreach($update_info as $obj) { 
                if ($training_seminar->training_seminar_id == $obj->training_seminar_id) {
                    $update = $obj;
                    break;
                }
            }
            ?>


            <div class="box box-solid" >
                <div class="box-header with-border  bg-gray">
                  <i class="fa fa-black-tie fa-border"></i>
                  <n class="box-title" style='font-size:15px;'><?php echo $training_seminar->training_title;?></n>
                 
                   <?php if($setting=='allowed') { if($pending > 0) { } else { ?>
                    <div class="box-tools pull-right">
                          
                          <?php echo "<a type='button' class='btn btn-primary btn-xs' data-toggle='modal' data-target='#modal' href='".base_url('employee_portal/employee_201/getTraining')."/".$training_seminar->training_seminar_id."'>";?><i class="fa fa-edit"></i>Edit</a>

                            <?php echo "<a type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#modall' href='".base_url('employee_portal/employee_201/delTraining')."/".$training_seminar->training_seminar_id."'>";?><i class="fa fa-times"></i>Delete</a>
                      </div>
                  <?php } } ?>

                </div>
               

                <div class="box-body">
                    <dl class="dl-horizontal text-info">
                        <div class="col-md-6">
                          <dt>Training Type</dt>
                          <dd>
                               <?php echo $training_seminar->training_type;
                                if (empty($update->training_type) || $update->training_type==$training_seminar->training_type) { } 
                                else { echo  '<dd class="text-danger">- > ' . $update->training_type. '</dd>'; } ?>
                          </dd>

                         

                          <dt>Purpose</dt>
                          <dd>
                               <?php echo $training_seminar->purpose;
                                if (empty($update->purpose) || $update->purpose==$training_seminar->purpose) { } 
                                else { echo  '<dd class="text-danger">- > ' . $update->purpose. '</dd>'; } ?>
                          </dd>

                          <dt>Conducted By</dt>
                          <dd>
                               <?php echo $training_seminar->conducted_by;
                                if (empty($update->conducted_by) || $update->conducted_by==$training_seminar->conducted_by) { } 
                              else { echo  '<dd class="text-danger">- > ' . $update->conducted_by. '</dd>'; } ?>
                          </dd>

                          
                          <dt>Attached File</dt>
                           <dd>
                              <a href="<?php echo base_url(); ?>app/employee_201_profile/download_training_certificate/<?php echo $training_seminar->file_name; ?>" style="cursor: pointer;"><?php echo $training_seminar->file_name;?></a>
                                <?php  if (empty($update->file_name) || $update->file_name==$training_seminar->file_name) { } 
                              else { echo  '<dd class="text-info">- > ';?><a href="<?php echo base_url(); ?>app/employee_201_profile/download_training_certificate/<?php echo $update->file_name; ?>" style='cursor:pointer;'> <?php echo $update->file_name;?></a></dd><?php } ?>

                           </dd>
                            <dt>Payment Status</dt>
                              <dd>
                                <?php echo $training_seminar->payment_status;
                                 if (empty($update->payment_status) || $update->payment_status==$training_seminar->payment_status) { } 
                                  else { echo  '<dd class="text-danger">- > ' . $update->payment_status. '</dd>'; } ?>
                              </dd>

                           
                        </div>
                        <div class="col-md-6">
                             <dt>Sub Type</dt>
                              <dd>
                                  <?php echo $training_seminar->sub_type; 
                                  if (empty($update->sub_type) || $update->sub_type==$training_seminar->sub_type) { } 
                                  else { echo  '<dd class="text-danger">- > ' . $update->sub_type. '</dd>'; } ?>
                              </dd>

                              <dt>Conducted BY Type</dt>
                              <dd>
                                   <?php echo $training_seminar->conducted_by_type;
                                   if (empty($update->conducted_by_type) || $update->conducted_by_type==$training_seminar->conducted_by_type) { } 
                                    else { echo  '<dd class="text-danger">- > ' . $update->conducted_by_type. '</dd>'; } ?>
                              </dd>
                              <dt>Address</dt>
                              <dd>
                                  <?php echo $training_seminar->training_address;
                                   if (empty($update->conducted_by) || $update->conducted_by==$training_seminar->conducted_by) { } 
                                  else { echo  '<dd class="text-danger">- > ' . $update->conducted_by. '</dd>'; } ?>
                              </dd>
                              <dt>Fee Type</dt>
                              <dd>
                                  <?php echo $training_seminar->fee_type;
                                  if (empty($update->fee_type) || $update->fee_type==$training_seminar->fee_type) { } 
                                  else { echo  '<dd class="text-danger">- > ' . $update->fee_type. '</dd>'; } ?>
                              </dd>

                              <dt>Fee Amount</dt>
                              <dd>
                                   <?php if(empty($training_seminar->fee_amount)) { echo "-"; } else{ echo number_format($training_seminar->fee_amount,2); }
                                   if (empty($update->fee_amount) || $update->fee_amount==$training_seminar->fee_amount) { } 
                                  else { echo  '<dd class="text-danger">- > ' . $update->fee_amount. '</dd>'; } ?>
                              </dd>

                        </div>
                        <div class="col-md-12">
                            <br>
                              <dd>
                            
                                 <?php if($training_seminar->fee_type=='company')
                                 {
                                    echo "Required length of service to be totally shouldered by the company : "."<b>".$training_seminar->monthsRequired." Month/s</b>";
                                    if(empty($update->monthsRequired)){}
                                    else if($training_seminar->monthsRequired==$update->monthsRequired){}
                                    else
                                    {
                                        echo  '<dd class="text-danger">Updated Number of Months : - > ' . $update->monthsRequired. ' Month/s</dd>';
                                    }
                                   
                                 }?>
                              </dd>
                        </div>



                        <div class="col-md-12" style="padding-top: 20px;">
                            <div class="col-md-12">
                             <div class="col-md-1"></div>
                             <div class="col-md-10">
                             <?php 
                                $dates = $this->employee_201_profile_model->get_all_dates($training_seminar->training_seminar_id);  
                                $dates_upd = $this->employee_201_model->get_date_upd($training_seminar->training_seminar_id);  
                            ?>
                                  
                                  <table class="table table-hover" id="bb<?php echo $training_seminar->training_seminar_id;?>"  style="background-color:white; ">
                                      <thead>
                                          <tr class="success" style="color:black;"> 
                                              <th  >Date</th>
                                              <th>Time From</th>
                                              <th>Time To</th>
                                              <th>Hours</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                       <tr>
                                              <td colspan="4"><u>Trainings and Seminar Original Date and Time</u></td>
                                        </tr>
                                      <?php foreach($dates as $d){
                                          
                                        ?>
                                          <tr>
                                              <td>
                                                  <?php 
                                                      $month=substr($d->date, 5,2);
                                                      $day=substr($d->date, 8,2);
                                                      $year=substr($d->date, 0,4);

                                                      echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;

                                                  ?>  

                                              </td>
                                              <td><?php echo $d->time_from; ?></td>
                                              <td><?php echo $d->time_to; ?></td>
                                              <td><?php echo $d->hours;  ?></td>
                                          </tr>
                                      <?php } ?>
                                        <tr>
                                              <td colspan="4"><n class="text-info pull-right">Total Hours : <b><?php echo $training_seminar->total_hours;?></b></n></td>
                                        </tr>
                                        <?php if(empty($dates_upd)){} else{?>
                                         <tr>
                                              <td colspan="4" class="text-danger"><u>Trainings and Seminar Updated Date and Time</u></td>
                                        </tr>
                                      <?php foreach($dates_upd as $d){
                                        
                                          
                                        ?>
                                          <tr class="text-danger">
                                              <td>
                                                  <?php 
                                                      $month=substr($d->date, 5,2);
                                                      $day=substr($d->date, 8,2);
                                                      $year=substr($d->date, 0,4);

                                                      echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;

                                                  ?>  

                                              </td>
                                              <td><?php echo $d->time_from; ?></td>
                                              <td><?php echo $d->time_to; ?></td>
                                              <td><?php echo $d->hours;  ?></td>
                                          </tr>
                                      <?php } } ?>
                                        <tr>
                                             
                                              <?php

                                                 $hr_total_upd= $this->employee_201_model->get_total_hours_update($training_seminar->training_seminar_id);
                                                 
                                               ?>
                                                 <td colspan="4"><n class="text-danger pull-right"><?php if(empty($hr_total_upd->hours)){}else{ ?> Total Hours : <?php echo $hr_total_upd->hours; }?> <b>

                                            </b></n></td>
                                        </tr>


                                      </tbody>
                                  </table>
                                  </div>
                              <div class="col-md-1"></div>
                            </div>
                        </div>
                </div>
                  <?php if ($training_seminar->request_status) { ?>
                   <div class="overlay">
                    <i class="fa fa-trash-o"></i>
                  </div>
                  <?php } ?> 
          </div>

         <?php  } ?>

          <?php foreach ($update_info as $training)
          { if (!($training->training_seminar_id)) { ?>
                <div class="box box-solid" >
                <div class="box-header with-border  bg-gray">
                  <i class="fa fa-black-tie fa-border"></i>
                  <n class="box-title" style='font-size:15px;'><?php echo $training->training_title;?></n>
                 
                  
                    <div class="box-tools pull-right">
                      <span class="label label-success"> 
                           <?php if($pending==0){ ?>Waiting for you to send the update request <?php 
                            } else {?>Waiting for HR Approval<?php } ?>&nbsp;<i class="fa fa-hourglass-start"></i>
                      </span>
                    </div>

                </div>
                <div class="box-body">
                    <dl class="dl-horizontal text-info">
                        <div class="col-md-6">
                          <dt>Training Type</dt>
                          <dd>
                               <?php echo $training->training_type;?>
                              
                          </dd>

                         

                          <dt>Purpose</dt>
                          <dd>
                              <?php echo $training->purpose;?>
                            
                          </dd>

                          <dt>Conducted By</dt>
                          <dd>
                               <?php echo $training->conducted_by;?>
                            
                          </dd>

                          
                          <dt>Attached File</dt>
                           <dd>
                                <a  style="cursor: pointer;"><?php echo $training->file_name;?></a><br>
                               
                           </dd>

                          
                              <dt>Payment Status</dt>
                              <dd>
                                  <?php echo $training->payment_status;?>
                                 
                              </dd>
                         
                        </div>
                        <div class="col-md-6">
                             <dt>Sub Type</dt>
                              <dd>
                                   <?php echo $training->sub_type;?>
                                  
                              </dd>

                              <dt>Conducted BY Type</dt>
                              <dd>
                                  <?php echo $training->conducted_by_type;?>
                                   
                              </dd>
                              <dt>Address</dt>
                              <dd>
                                   <?php echo $training->training_address;?>
                                   
                              </dd>
                              <dt>Fee Type</dt>
                              <dd>
                                  <?php echo $training->fee_type;?>
                                  
                              </dd>

                             
                                <dt>Fee Amount</dt>
                                <dd>
                                     <?php if(empty($training->fee_amount)){ echo "-"; } else { echo number_format($training->fee_amount,2); }?>
                                   
                                </dd>

                               
                              
                        </div>

                        <div class="col-md-12">
                            <br>
                              <dd>
                                 <?php 
                                 if(!empty($training->fee_type) && $training->fee_type=='company')
                                 {
                                  echo "Required length of service to be totally shouldered by the company : "."<b>".$training->monthsRequired." Month/s<b>";
                                 }
                                 ?>
                              </dd>
                        </div>

                        <div class="col-md-12" style="padding-top: 20px;">
                            <div class="col-md-12">
                             <div class="col-md-1"></div>
                             <div class="col-md-10">
                            <?php 
                                $dates = $this->employee_201_model->get_all_dates_updated($training->update_id);?>
                                  <table class="table table-hover" style="background-color: white;">
                                      <thead>
                                          <tr class="danger">
                                              <th>Date</th>
                                              <th>Time From</th>
                                              <th>Time To</th>
                                              <th>Hours</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                      <?php if(empty($dates)){?>

                                          <tr>
                                              <td colspan="3"><n class="text-danger"><center>No dates found.</center></n></td>
                                             
                                          </tr>

                                      <?php } else{ foreach($dates as $d){?>

                                          <tr>
                                              <td><?php echo $d->date;?></td>
                                              <td><?php echo $d->time_from;?></td>
                                              <td><?php echo $d->time_to;?></td>
                                              <td><?php echo $d->hours;?></td>
                                          </tr>
                                      <?php }}  ?>

                                        <tr>
                                            <td colspan="4"><n class="text-danger pull-right">Total Hours : <b><?php echo $training->total_hours;?></b></n></td>
                                        </tr>
                                      </tbody>
                                  </table>
                                  </div>
                              <div class="col-md-1"></div>
                            </div>
                        </div>
                    </dl>
                </div>
          </div>

        <?php  } } ?>
        </div>
      </div>
    </div>
  </div>
</div>
 <div id="modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
       <div class="modal-content modal-lg">
       </div>
    </div>
</div>

 <div id="modall" class="modal fade" role="dialog">
   <div class="modal-dialog">
       <div class="modal-content modal-md">
       </div>
    </div>
</div>
<!-- Modal -->

<style type="text/css">
  .modal {
}
.vertical-alignment-helper {
    display:table;
    height: 100%;
    width: 120%;

}
.vertical-align-center {
    /* To center vertically */
    display: table-cell;
    vertical-align: left;

}
.modal-content {
    /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
 /*   width:inherit;
    height:inherit;*/
    /* To center horizontally */
    margin: 0 auto;
    margin-left:-60px;
}
</style>
<!-- Edit Training Modal -->

<?php require_once(APPPATH.'views/app/application_form/footer.php');?>

<script>

$('#date_start').Zebra_DatePicker({
  pair: $('#end_date'),
  direction: -1 //Allow Past Days only
});

$('#date_end').Zebra_DatePicker({
});

$('#edit_date_start').Zebra_DatePicker({
  pair: $('#edit_end_date'),
  direction: -1 //Allow Past Days only
});

$('#edit_date_end').Zebra_DatePicker({
});

function checkStartDate(datestart, form_name) {
    var x = document.forms[form_name][datestart].value;
    if (x == "") {
        alert("Please specify the date start field.");
        return false;
    }
}

function dday()
{
  var val = document.getElementById("one_date_val").value;
  if(val==1){ 
    document.getElementById("one_date").disabled=true;
    alert("This field is not required for present work");
  }
  else{ document.getElementById("one_date").disabled=false; }
  
}

function Onedday()
{ 
    if(document.getElementById('One').checked==true)
      { 
        document.getElementById("one_date").disabled=true; 
       document.getElementById('one_date_val').value=1;
      }
    else
      { 
        document.getElementById("one_date").disabled=false;
        document.getElementById('one_date_val').value=0;
      }
}

 function del_image(id)
  {  
      var option= 'emp_trainings_seminars_for_update';
      var idd='file_name';
      var result = confirm("Are you sure you want to update the ststus?");
      if(result == true)
      {
        $("#del_img").load(location.href + " #del_img");
       {
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                 { 
                  document.getElementById("del_img").innerHTML=xmlhttp.responseText;

                 }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_201/del_per_image/"+id+"/"+option+"/"+idd,true);
            xmlhttp.send();
        } }
        else{}


  }

</script>