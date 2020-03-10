
<div class="row">
<div class="col-md-7">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong><?php echo $brand_name." &nbsp;".$bio_name." ".$bio_setup_status;

echo  $view_setup='<a class="fa fa-'.$system_defined_icons->icon_view.' pull-right text-primary" data-toggle="collapse" title="Click to view biometrics setup" href="#view_setup" aria-expanded="false" aria-controls="collapseExample"> Click To View Biometrics Setup</a>';

  ?></strong>

  </div>

  <div class="box-body">
  <div class="panel panel-success">
  <div class="box-body">

<?php 

$bio_id=$this->uri->segment("4");
echo form_open_multipart('app/time_manual_attendance/import_biometrics_db/'.$bio_id.'');?>

   <form action="<?php echo base_url(); ?>app/time_manual_attendance/import_biometrics_db/<?php echo $bio_id?>" method="post" name="upload_mdb"  enctype="multipart/form-data" target="_blank"> 
      <br>

    <div class="form-group">
    <label for="type" class="col-sm-12 control-label">Choose File</label>
    <div class="col-sm-12">
      <input type="file" name="file" class="form-control" id="file" accept=".mdb" required
      <?php
      if($bio_setup_status==""){
      }else{
        echo "disabled";
      }
      ?>
      >
    </div>
    </div>
<style type="text/css">
label input {
  display: none;/* <-- hide the default checkbox */
}
label span {/* <-- style the artificial checkbox */
  height: 10px;
  width: 10px;
  border: 1px solid grey;
  display: inline-block;
  position: relative;
}
[type=checkbox]:checked + span:before {/* <-- style its checked state..with a ticked icon */
  content: '\2714';
  position: absolute;
  top: -5px;
  left: 0;
}
</style>

    <div class="form-group">
      <label for="type" class="col-sm-12 control-label">Date From (Manual)</label>
        <div class="col-sm-12">
          <input type="date" name="date_from" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
      <label for="type" class="col-sm-12 control-label">Date To (Manual)</label>
        <div class="col-sm-12">
          <input type="date" name="date_to" class="form-control" required>
        </div>
    </div>
<div class="form-group col-sm-12"> </div><div class="form-group col-sm-12"> </div>
    <div class="form-group">
      <label for="type" class="col-sm-12 control-label">Group Uploading (Choose Company)</label>
        <div class="col-sm-12">
         <?php 
         foreach($companyList as $comp){

          $isemployee_exist=$this->time_manual_attendance_model->check_employees($comp->company_id);
          if(!empty($isemployee_exist)){
            $no_employee_notice="";
            $no_employee_notice_rmrks="";
          }else{
            $no_employee_notice="disabled";
            $no_employee_notice_rmrks='<i class="fa fa-ban text-danger"></i>';
            $no_employee_notice_notes='<span class="text-danger"><i>(no employee yet.)</i></span>';
            
          }

          if($no_employee_notice==""){
              echo 
              '<label>
              <input type="checkbox" name="chosen_company[]" value="'.$comp->company_id.'" '.$no_employee_notice.'>
              <span></span>
              '.$comp->company_name.' &nbsp;'.$no_employee_notice_rmrks.'
              </label>
              <br>
              ';
          }else{
              echo 
              '
              <span></span>
              '.$no_employee_notice_rmrks.' &nbsp;'.$comp->company_name.' &nbsp;
              '.$no_employee_notice_notes.'
              <br>
              ';            
          }

         }
         ?>
        </div>
    </div>

<div class="form-group col-sm-12"> </div><div class="form-group col-sm-12"> </div>
   <div class="form-group"  id="show_selected_emp">
      <label for="next" class="col-sm-12 control-label text-danger"><a type="button" class="" data-toggle="modal" data-target="#showEmployeeList"></a> &nbsp;&nbsp;Individual Uploading</label>
        <div class="col-sm-12 bg-danger" >
          <span id="hey" style="display: none;font-style: italic;color: #ff0000;">(Invidual employee processing is hidden as you have chosen to process via group) </span>
              <a data-toggle="modal" data-target="#showEmployeeList" id="ieh"><input type="text" id="ie" class="form-control col-sm-12" placeholder="For Individual Uploading : Click to Select Employee" onclick="disable_group_process()"></a>
        </div>
    </div>  
<div class="form-group col-sm-12"> </div><div class="form-group col-sm-12"> </div>
    <div class="form-group">
      <label for="type" class="col-sm-12 control-label">Action</label>
        <div class="col-sm-12">
          <select class="form-control" name="upload_action">
            <option value="upload_and_review">Review (system will not save it yet.)</option>
            <option value="upload_and_save">Save</option>
          </select>
        </div>
    </div>


	  <div class="form-group col-sm-12"> </div>



      <button 
      <?php
      if($bio_setup_status==""){
      }else{
        echo "disabled";
      }
      ?>

     type="submit" id="submit" name="save" class="btn btn-danger btn pull-right" onclick="$('form').attr('target', '_blank');"><i class="fa fa-upload"></i> Upload</button>


      
  	</form>

  </div>
  </div>
  </div>

</div>
</div>

</div>  


<?php

echo '
 <div class="collapse col-md-5" id="view_setup">
      
<button class="btn btn-primary col-md-12" >Auto Sync Logs Action  <i class="fa fa-arrow-down text-default"></i></button> 
<button class="btn btn-default col-md-12" > '.$sync_action_text.'</button> 

<button class="btn btn-default col-md-5" >Table Name:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-primary"></i> '.$file_table_name.'</button> 

<button class="btn btn-default col-md-5" >Employee ID Field Name:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-primary"></i> '.$employee_id_field_name.'</button> 
<button class="btn btn-default col-md-5" >Logs Field Name:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-primary"></i> '.$logs_field_name.'</button> 
<button class="btn btn-default col-md-5" >Logs Type Field Name:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-primary"></i> '.$logs_type_field_name.'</button> 

<button class="btn btn-danger col-md-5" >  IN Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-danger"></i> '.$code_in.'</button> 

<button class="btn btn-danger col-md-5" >  OUT Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-danger"></i> '.$code_out.'</button> 

<button class="btn btn-warning col-md-5" >  First Break OUT Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-warning"></i> '.$code_break_out1.'</button> 

<button class="btn btn-warning col-md-5" >  First Break IN Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-warning"></i> '.$code_break_in1.'</button> 

<button class="btn btn-info col-md-5" >  Lunch Break OUT Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-info"></i> '.$code_lunch_out.'</button> 

<button class="btn btn-info col-md-5" >  Lunch Break IN Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-info"></i> '.$code_lunch_in.'</button> 

<button class="btn btn-success col-md-5" >  Second Break OUT Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-success"></i> '.$code_break_out2.'</button> 

<button class="btn btn-success col-md-5" >  Second Break IN Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-success"></i> '.$code_break_out1.'</button> 
      
      </div>';

?>
</div>
