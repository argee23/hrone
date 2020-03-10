
<div class="panel panel-default" ng-cloak>
  <div class="panel-body">
  <h4 class="panel-header">TRIP TICKET FORM</h4>
  <hr>
   <?php count($approvers); if (count($approvers) == 0)
  { ?>
      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>
                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>
  <?php } else { ?>
    <form class="form-horizontal" name="add_trip_ticket" enctype="multipart/form-data" method="post" action="add_trip_ticket" onsubmit="document.getElementById('smbt').disabled=true;">
    
     <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
        <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Car Model</center></label>
          <div class="col-sm-8">
           <select class="form-control" id="model" name="model" required onchange="get_platenumber(this.value);">
             <?php if(empty($car_model)) { echo "<option value=''>No car details found.</option>"; } else { ?>
             <option value="">Select</option>
             <?php foreach ($car_model as $model) {?>
                <option value=<?php echo $model->id?>><?php echo $model->car_model?></option>
             <?php } } ?>
           </select>
          </div>
        </div>
    </div>
    </div>

    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
        <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Plate Number</center></label>
          <div class="col-sm-8">
           <select class="form-control" id="plate_no" name="plate_no" required>
            
           </select>
          </div>
        </div>
    </div>
    </div>

    
   

    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Trip Time Out</center></label>
          <div class="col-sm-8">
               <input type="text" class="form-control" id="trip_time_out" name="trip_time_out"  placeholder="24 hour format ex. 13:00 for 1PM" data-inputmask="'mask': '99:99'" required>
          </div>
        </div>
    </div>
    </div>

    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Trip Date</center></label>
          <div class="col-sm-8">
              <input type="text" class="form-control" id="trip_date" name="trip_date" ng-model="ddate" required>
          </div>
        </div>
    </div>
    </div>

    <div class="col-md-12"  ng-if="date_infos.result==false && ddate">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Warning</center></label>
          <div class="col-sm-8" class="bg-danger panel-body">  
           <div class="bg-danger panel-body"><n class="text-danger" >Please Check Late Filing Policy <br> ({{date_infos.late_filing_type}} / {{date_infos.late_filing}} day/s)</n></div>
          </div>
        </div>
    </div>
    </div>

    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>To be returned on date </center></label>
          <div class="col-sm-8">
          <input type="text" class="form-control" id="return_date" name="return_date"  placeholder="YYYY-MM-DD ex. 2017-12-13 for December 13, 2017" data-inputmask="'alias': 'yyyy-mm-dd'" required>
          </div>
        </div>
    </div>
    </div>

    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>To be returned on time </center></label>
          <div class="col-sm-8">
          <input type="text" class="form-control" id="return_time" name="return_time"  placeholder="24 hour format ex. 13:00 for 1PM" data-inputmask="'mask': '99:99'" required>
          </div>
        </div>
    </div>
    </div>


   

    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Actual Time Out</center></label>
          <div class="col-sm-8">
               <input type="text" class="form-control" id="actual_time_out" name="actual_time_out"  placeholder="24 hour format ex. 13:00 for 1PM / no need to fill up" data-inputmask="'mask': '99:99'" readonly>
          </div>
        </div>
    </div>
    </div>

    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Actual Time In</center></label>
          <div class="col-sm-8">
              <input type="text" class="form-control" id="actual_time_in" name="actual_time_in"  placeholder="24 hour format ex. 13:00 for 1PM / no need to fill up" data-inputmask="'mask': '99:99'" readonly>
          </div>
        </div>
    </div>
    </div>

    

    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Destination From</center></label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="destination_from" name="destination_from" required>
          </div>
        </div>
    </div>
    </div>

     <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Destination To</center></label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="destination_to" name="destination_to" required>
          </div>
        </div>
    </div>
    </div>

     <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Purpose</center></label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="purpose" name="purpose" required>
          </div>
        </div>
    </div>
    </div>

   

    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Kilometer Out</center></label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="km_out" name="km_out" required>
          </div>
        </div>
    </div>
    </div>

     <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Kilometer In</center></label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="km_in" name="km_in" placeholder="no need to fill up"  readonly>
          </div>
        </div>
    </div>
    </div>

    

    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Fuel Before</center></label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="fuel_before" name="fuel_before" required>
          </div>
        </div>
    </div>
    </div>

     <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Fuel After</center></label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="fuel_after" name="fuel_after" placeholder="no need to fill up" readonly>
          </div>
        </div>
    </div>
    </div>


  <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">
  <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">
  <input type="hidden" id="form_id" value="<?php echo $form_id?>">


 
    <?php
      $required = '';
      $req = 0;
      if ($setting_attachment == 1) { 

        if ($setting_required == 1)
        {
            $required = 'required';
            $req = 1;
        }
    ?> 
    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>File Attachment</center></label>
          <div class="col-sm-8">
              <input type="file"  id="file_attached" name="file_attached" <?php echo $required;?>>
              <div class="help-block with-errors"><span class="text-danger"> <small><i>Accepted Files: PNG, JPG, GIF, PDF | File size must not exceed 500 KB</i></small></span>
          </div>
        </div>
    </div>
    </div>
 <?php } ?>

  <input type="hidden" name="required" value="<?php echo $setting_required;?> ">
  <input type="hidden" name="attach_file" value="<?php echo $setting_attachment;?>">
 
     
 <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Other Details</center></label>
          <div class="col-sm-8">
              <textarea rows="4" class="form-control" name='other_details' id='other_details'></textarea>
          </div>
        </div>
    </div>
    </div>


   
   <div class="form-group">
    <label class="control-label col-sm-6" for="email"></label>
    <div class="col-sm-6">
    <button type="submit" class="btn btn-success btn-md" ng-disabled="!add_trip_ticket.$valid || date_infos.result==false" id="smbt">Submit</button>
    </div>
  </div>

  </span>
  </form>
  <?php } ?>
  </div>
</div>


<?php require_once(APPPATH.'views/app/application_form/footer.php');?>
<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>

<script>
  function get_platenumber(val)
  {
    if(val=="")
    {
      alert('Please select valid car model to continue.');
    }
    else
    {
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
              //output results
            document.getElementById("plate_no").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_transactions/get_platenumber/"+val,true);
        xmlhttp.send();
        } 
    }
  }

</script>

<script type="text/javascript">
 
    var starting = null;
    var end_date = null;
    $(document).ready(function()
    {
      
      $('#trip_date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false }).on('change', function(e, date)
      {

        end_date = moment(date);
        var id = document.getElementById('form_id').value;
      
        if (starting != null)
        {
          angular.element('#app').scope().get_late_filing(starting.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'),id); 
          //Function get_schedules description is in index.php of transactions folder. :)
        }
      });

      $('#trip_date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false  }).on('change', function(e, date)
      {
        starting = date;
        var id = document.getElementById('form_id').value;
       
        if (end_date != null)
        {
          angular.element('#app').scope().get_late_filing(starting.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'),id); 
          //Function get_schedules description is in index.php of transactions folder. :)
        }
      }); 
     

      $.material.init()
    });


</script>


