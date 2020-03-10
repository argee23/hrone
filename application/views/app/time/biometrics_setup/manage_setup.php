<!-- //=========== add brand -->
  <div class="col-md-12">
    <div class="panel panel-danger">
      <div class="panel-heading">   
        <strong>
          Manage Biometrics Setup
        </strong>
      </div>
        <div class="panel-body">
          <form name="" method="post" action="<?php echo base_url()?>app/time_biometrics_setup/save_manage_setup/<?php echo $this->uri->segment("4")?>" >

          	<input type="hidden" name="id" value="<?php echo $this->uri->segment("4");?>">
<?php
if($real_time_status=="1"){

?>
    <div class="form-group"   >
      <label for="next" class="col-sm-12 control-label">File Location <br><span style="color:#ccc;">e.g <i class="fa fa-arrow-right"></i> c:/Anviz/DB/CrossChex.mdb</span></label>
        <div class="col-sm-12" >
          <input type="text" name="file_loc_name" placeholder="see example above" class="form-control" value="<?php echo $m_file_loc_name;?>">
        </div>
    </div>

    <div class="form-group">
      <label for="type" class="col-sm-12 control-label text-danger">Interval of Auto Sync (Minutes)</label>
        <div class="col-sm-12">
          <input type="number" name="real_time_timer" class="form-control"  maxlength="3" placeholder="example: 30  <-- it means 30 minutes" value="<?php echo $real_time_timer;?>">
        </div>
    </div>
    <div class="form-group"   >
      <label for="next" class="col-sm-12 control-label">IP Address</label>
        <div class="col-sm-12" >
          <input type="text" name="ip_address" placeholder="IP Address of file location" class="form-control" value="<?php echo $m_ip_address;?>">
        </div>
    </div>
<?php
}else{
?>
<input type="hidden" name="file_loc_name" value="">
<input type="hidden" name="real_time_timer" value="">
<input type="hidden" name="ip_address" value="">
<?php
}
?>



              <div class="form-group"   >
                <label for="next" class="text-danger col-sm-12 control-label">Database Date & Time Column Setup<?php echo $system_defined_icons->required_marked;?> </label>
                  <div class="col-sm-12" >
                    <select name="bio_container_type" class="form-control" required>
                      <?php
                      if(!empty($bio_container_type)){

                      }else{
                        echo '<option disabled selected>Select</option>';  
                      }
                      ?>
                      <option value="one_column_date_time" <?php if($bio_container_type=="one_column_date_time"){echo "selected";}else{}?> >Date & Time is in one column</option>
                      <option value="separate_column_date_time" <?php if($bio_container_type=="separate_column_date_time"){echo "selected";}else{}?>>Date is separate from time column</option>
                    </select>
                  </div>
              </div>
              <div class="form-group"   >
                <label for="next" class="text-danger col-sm-12 control-label">If Date is separate from time column(whats the column title of Date)</label>
                  <div class="col-sm-12" >
                    <input type="text" name="date_container" class="form-control" value="<?php echo $date_container;?>">
                  </div>
              </div>
              <div class="form-group"   >
                <label for="next" class="text-danger col-sm-12 control-label">If Date is separate from time column(whats the column title of Time)</label>
                  <div class="col-sm-12" >
                    <input type="text" name="time_container" class="form-control" value="<?php echo $time_container;?>">
                  </div>
              </div>



              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">MS Access DSN Driver<?php echo $system_defined_icons->required_marked;?> </label>
                  <div class="col-sm-12" >
                    <input type="text" name="data_source_name_driver" placeholder="example: (*.mdb, *.accdb)" class="form-control" value="<?php echo $m_data_source_name_driver;?>">
                  </div>
              </div>
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Database Table Name<?php echo $system_defined_icons->required_marked;?> </label>
                  <div class="col-sm-12" >
                    <input type="text" name="file_table_name" placeholder="Database Table Name" class="form-control" required value="<?php echo $m_file_table_name;?>">
                  </div>
              </div>

              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Database Field Name of Employee ID<?php echo $system_defined_icons->required_marked;?> </label>
                  <div class="col-sm-12" >
                    <input type="text" name="employee_id_field_name" placeholder="Field Name of Employee ID Container" class="form-control" required value="<?php echo $m_employee_id_field_name;?>">
                  </div>
              </div>

              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Logs Database Field Name<?php echo $system_defined_icons->required_marked;?> </label>
                  <div class="col-sm-12" >
                    <input type="text" name="logs_field_name" placeholder="Logs Field Name" class="form-control" required value="<?php echo $m_logs_field_name;?>">
                  </div>
              </div>

              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Logs Type Database Field Name<?php echo $system_defined_icons->required_marked;?> </label>
                  <div class="col-sm-12" >
                    <input type="text" name="logs_type_field_name" placeholder="Logs Type Field Name" class="form-control" required value="<?php echo $m_logs_type_field_name;?>">
                  </div>
              </div>

    
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Logs Action <?php echo $system_defined_icons->required_marked;?></label>
                  <div class="col-sm-12" >
                   <select name="sync_action" class="form-control" required>
                   <option value="<?php echo $sync_action;?>" selected=selected><?php echo $sync_action_text;?></option>
                   <?php
                   if(!empty($logs_sync_actionList)){
                      $no_sync_action=0;
                      echo '<option disabled >&nbsp;<option>';
                        foreach($logs_sync_actionList as $sync_action){
                          echo '<option value="'.$sync_action->param_id.'">'.$sync_action->cValue.'</option>';                       
                        }
                   }else{
                      $no_sync_action=1;
                      echo '<option option disabled selected=selected>notice: no auto sync system default action found.</option>';
                   }
                   ?>                    
                   </select>
                  </div>
              </div>


              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">IN Code<?php echo $system_defined_icons->required_marked;?> </label>
                  <div class="col-sm-12" >
                    <input type="text" name="code_in" placeholder="IN Code" class="form-control" required value="<?php echo $code_in;?>">
                  </div>
              </div>
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">OUT Code<?php echo $system_defined_icons->required_marked;?> </label>
                  <div class="col-sm-12" >
                    <input type="text" name="code_out" placeholder="OUT Code" class="form-control" required value="<?php echo $code_out;?>">
                  </div>
              </div>
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">First Break OUT Code</label>
                  <div class="col-sm-12" >
                    <input type="text" name="code_break_out1" placeholder="Lunch Break OUT" class="form-control"  value="<?php echo $code_break_out1;?>">
                  </div>
              </div>              
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">First Break IN Code</label>
                  <div class="col-sm-12" >
                    <input type="text" name="code_break_in1" placeholder="First Break IN" class="form-control"  value="<?php echo $code_break_in1;?>">
                  </div>
              </div>

              <!-- //=================== -->
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Lunch Break OUT Code</label>
                  <div class="col-sm-12" >
                    <input type="text" name="code_lunch_out" placeholder="Lunch Break OUT" class="form-control"  value="<?php echo $code_lunch_out;?>">
                  </div>
              </div>              
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Lunch Break IN Code</label>
                  <div class="col-sm-12" >
                    <input type="text" name="code_lunch_in" placeholder="Lunch Break IN" class="form-control"  value="<?php echo $code_lunch_in;?>">
                  </div>
              </div>

               <!-- //=================== -->
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Second Break OUT Code</label>
                  <div class="col-sm-12" >
                    <input type="text" name="code_break_out2" placeholder="Second Break OUT" class="form-control"  value="<?php echo $code_break_out2;?>">
                  </div>
              </div>               
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Second Break IN Code</label>
                  <div class="col-sm-12" >
                    <input type="text" name="code_break_in2" placeholder="Second Break IN" class="form-control"  value="<?php echo $code_break_in2;?>">
                  </div>
              </div>
<?php
if($real_time_status=="1"){
?>

              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Choose Company You'd like to realtime logs.</label>
                  <div class="col-sm-12" >                 
 <?php
    if(!empty($companyList)){
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
 $isrealtime=$this->auto_sync_logs_model->companyRealtimeLogs($comp->company_id);
 if(!empty($isrealtime)){
  $realTime="1";
  $realTime_marked="checked";
  $dont_allow_select="";
 }else{
  $realTime="";
  $realTime_marked="";
  $dont_allow_select="";
 }

          if($no_employee_notice==""){
              echo 
              '<label>
              <input type="checkbox" '.$dont_allow_select.' name="chosen_company[]" value="'.$comp->company_id.'" '.$no_employee_notice.' value='.$realTime.' '.$realTime_marked.'>
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
    }else{
      //echo "none";
    }
    ?>
                  </div>
              </div>
<?php
}else{

}
?>





              <div class="form-group"   >
                <label for="next" class="col-sm-5 control-label">&nbsp;&nbsp;&nbsp;</label>
                  <div class="col-sm-7" >
                  
                    <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
                    <?php
                      echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Save';
                    ?>

                    </button>
                  </div>
              </div>
            </form>

        </div>
    </div>
  </div>