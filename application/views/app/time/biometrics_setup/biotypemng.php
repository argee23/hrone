<?php 
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$biotype_add=$this->session->userdata('biotype_add');
$biotype_edit=$this->session->userdata('biotype_edit');
$biotype_enable_disable=$this->session->userdata('biotype_enable_disable');
$biotype_del=$this->session->userdata('biotype_del');

$biotype_ms=$this->session->userdata('biotype_ms');
$biotype_rtaction=$this->session->userdata('biotype_rtaction');
$biotype_vs=$this->session->userdata('biotype_vs');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>


<div class="row">
<!-- //=========== add brand -->
  <div class="col-md-12 collapse" id="collapse_manage_pp">
    <div class="panel panel-danger">
      <div class="panel-heading">   
        <strong>
          Add Biometrics Type/Name
        </strong>
      </div>
        <div class="panel-body">
          <form name="" method="post" action="<?php echo base_url()?>app/time_biometrics_setup/add_biotype" >
              <div class="form-group"   >
                <label for="next" class="col-sm-5 control-label">Brand Name<?php echo $system_defined_icons->required_marked;?></label>
                  <div class="col-sm-7" >
                   <select name="brand_name" class="form-control" required>
                   <?php
                   if(!empty($active_brand)){
                      $no_brand_yet=0;
                      echo '<option disabled selected=selected>Select<option>';
                        foreach($active_brand as $brand){
                         $brandstatus=$brand->InActive;
                          echo '<option value="'.$brand->bio_categ_id.'">'.$brand->brand_name.'</option>';                       
                        }
                   }else{
                      $no_brand_yet=1;
                      echo '<option option disabled selected=selected>notice: create/add a brand name first.</option>';
                   }

                   ?>                    
                   </select>
                  </div>
              </div>
              <div class="form-group"   >
                <label for="next" class="col-sm-5 control-label">Biometrics Type / Name<?php echo $system_defined_icons->required_marked;?></label>
                  <div class="col-sm-7" >
                   <input type="text" name="bio_type" class="form-control" <?php 
                   if($no_brand_yet=="1"){
                    echo 'disabled placeholder="notice: create/add a brand name first."' ;
                   }else{

                   }
                   ?> required>
                  </div>
              </div>
              <div class="form-group"   >
                <label for="next" class="col-sm-5 control-label">Database Type<?php echo $system_defined_icons->required_marked;?></label>
                  <div class="col-sm-7" >
                   <select name="bio_db_type" class="form-control" required>
                   <?php
                   if(!empty($db_typeList)){
                      $no_dbtype_yet=0;
                      echo '<option disabled selected=selected>Select<option>';
                        foreach($db_typeList as $db_type){
                         $db_typestatus=$db_type->InActive;
                          echo '<option value="'.$db_type->param_id.'">'.$db_type->cValue.'</option>';                       
                        }
                   }else{
                      $no_dbtype_yet=1;
                      echo '<option option disabled selected=selected>notice: create/add a database type first.</option>';
                   }

                   ?>                    
                   </select>
                  </div>
              </div>              



<!--               <div class="form-group"   >
                <label for="next" class="col-sm-5 control-label">Biometrics Photo</label>
                  <div class="col-sm-7" >
                   <input type="file" name="bio_photo" class="form-control" <?php 
                   // if($no_brand_yet=="1"){
                   //  echo 'disabled placeholder="notice: create/add a brand name first."' ;
                   // }else{

                   // }
                   ?>>
                  </div>
              </div> -->
              <div class="form-group"   >
                <label for="next" class="col-sm-5 control-label">Biometrics Details</label>
                  <div class="col-sm-7" >
                  <?php
$bd="Users Capacity : 
Finger Print capacity:";
                  ?>
                   <textarea name="bio_details" class="form-control"><?php echo $bd;?>
                   </textarea>
                  </div>
              </div>
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

<!-- //=========== manage brand -->

  <div class="col-md-12">
    <div class="panel panel-danger">
      <div class="panel-heading">   
      <strong>Biometrics Type Management</strong>

        <a class="<?php echo $biotype_add;?> btn btn-default btn-xs pull-right" data-toggle="collapse" href="#collapse_manage_pp" aria-expanded="false" aria-controls="collapseExample">
        <?php
        echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
        ?>
                               
        </a>
      </div>

        <div class="panel-body">

          <div class="col-md-12">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Brand Name</th>
                <th>Bio Type / Name</th>
                <th>Database Type</th>
                <th>Status</th>
                <th style="text-align:center;">Options</th>
              </tr>
            </thead>
            <?php
            if(!empty($check_real_time_bio)){
              $real_time_bio=1;
            }else{
              $real_time_bio=0;
            }

            if(!empty($biotypemng)){
              foreach($biotypemng as $brandtyp){
               $real_time_status= $brandtyp->real_time_status;
               if($real_time_status=="1"){
                $real_time_status_text="(You are using this biometric/s in realtime logs synching).";
                $bgcolor='style="background-color:#ccfff2;font-weight:bold;"';
               }else{
                $real_time_status_text="";
                $bgcolor='';
               }
                $setup=$this->time_biometrics_setup_model->selected_bio_type($brandtyp->id);
                if(!empty($setup)){
                  $mysetup_sync_action_text=$setup->sync_action_text;
                  $mysetup_code_in=$setup->code_in;

                  $mysetup_code_in=$setup->code_in;
                  $mysetup_code_out=$setup->code_out;
                  $mysetup_code_break_in1=$setup->code_break_in1;
                  $mysetup_code_break_out1=$setup->code_break_out1;
                  $mysetup_code_lunch_in=$setup->code_lunch_in;
                  $mysetup_code_lunch_out=$setup->code_lunch_out;
                  $mysetup_code_break_in2=$setup->code_break_in2;
                  $mysetup_code_break_out2=$setup->code_break_out2;
                }else{
                  $mysetup_sync_action_text="";
                  $mysetup_code_in="";
                  $mysetup_code_out="";
                  $mysetup_code_break_in1="";
                  $mysetup_code_break_out1="";
                  $mysetup_code_lunch_in="";
                  $mysetup_code_lunch_out="";
                  $mysetup_code_break_in2="";
                  $mysetup_code_break_out2="";
                }
                $edit="<i class='".$biotype_edit." fa fa-".$system_defined_icons->icon_edit." fa-".$system_defined_icons->icon_size."x'  
                style='color:".$system_defined_icons->icon_edit_color.";' data-toggle='tooltip' data-placement='left' title='Edit' onclick='edit_biotype(".$brandtyp->id.")'></i>" ;

                $manage="<i class='".$biotype_ms." fa fa-".$system_defined_icons->icon_manage." fa-".$system_defined_icons->icon_size."x'  
                style='color:".$system_defined_icons->icon_manage_color.";' data-toggle='tooltip' data-placement='left' title='Manage Biometrics Setup' onclick='manage_setup(".$brandtyp->id.")'></i>" ;

                $confirm_mess='"Are you sure you want to delete?"';

                $view_setup='<a class="'.$biotype_vs.' fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';" data-toggle="collapse" title="Click to view biometrics setup" href="#view_setup_'.$brandtyp->id.'" aria-expanded="false" aria-controls="collapseExample"> </a>';

                $delete='';
    

                if($brandtyp->InActive=="1"){

                   $status="Deactivated $real_time_status_text";
                   $status_class='class="text-danger"';

                   $edit="<i class='".$biotype_edit." fa fa-".$system_defined_icons->icon_edit." fa-".$system_defined_icons->icon_size."x  text-muted'  data-toggle='tooltip' data-placement='left' title='Edit not allowed' ></i>" ;


                   $delete="<i class='".$biotype_del." fa fa-".$system_defined_icons->icon_delete." fa-".$system_defined_icons->icon_size."x  text-muted'  data-toggle='tooltip' data-placement='left' title='Delete not allowed' ></i>" ;
          

                  
                   $manage="<i class='".$biotype_ms." fa fa-".$system_defined_icons->icon_manage." fa-".$system_defined_icons->icon_size."x  text-muted'  data-toggle='tooltip' data-placement='left' title='Manage not allowed' ></i>" ;
                  


                }else{
                   
                   $status="Active $real_time_status_text";
                   $status_class='';

                }


               echo ' <tr '.$bgcolor. $status_class.'>
                <td>'.$brandtyp->brand_name.'</td>
                <td>'.$brandtyp->bio_name.'</td>
                <td>'.$brandtyp->cValue.'</td>
                <td>'.$status.'</td>
                <td>'.$view_setup. $manage. $edit.' '.$delete;
        
                if($brandtyp->InActive=="0"){
                ?>



                    <?php
                    if($real_time_status=="1"){

                            echo "<i class='".$biotype_del." fa fa-".$system_defined_icons->icon_delete." fa-".$system_defined_icons->icon_size."x  text-muted'  data-toggle='tooltip' data-placement='left' title='Delete not allowed as this is currently being used in real time synching.' ></i>" ;
                            echo "<i class='".$biotype_enable_disable." fa fa-".$system_defined_icons->icon_disable." fa-".$system_defined_icons->icon_size."x  text-muted'  data-toggle='tooltip' data-placement='left' title='Disable not allowed as this is currently being used in real time synching.' ></i>" ;
                    ?>
                            <a  class='<?php echo $biotype_rtaction;?> fa fa-lock<?php echo ' fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_disable_color.';"';?> data-toggle="tooltip" data-placement="left" title="Click to Turn Off Usage of this biometrics in Auto Synching of logs" href="<?php echo site_url('app/time_biometrics_setup/biotype_realtime_used_action/'. $brandtyp->id.'/'.$brandtyp->real_time_status); ?>" onClick="return confirm('Are you sure you want to Turn Off Usage of this biometrics in Auto Synching of logs?')"></a>
                    <?php
                    }else{

                    ?>

                            <a  class='<?php echo $biotype_del;?> fa fa-<?php echo $system_defined_icons->icon_delete.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_delete_color.';"';?> data-toggle="tooltip" data-placement="left" title="Delete" href="<?php echo site_url('app/time_biometrics_setup/delete_bio_type/'. $brandtyp->id.''); ?>" onClick="return confirm('Are you sure you want to permanently delete?')"></a>

                            <a  class='<?php echo $biotype_enable_disable;?> fa fa-<?php echo $system_defined_icons->icon_disable.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_disable_color.';"';?> data-toggle="tooltip" data-placement="left" title="Click to Deactivate/Disable" href="<?php echo site_url('app/time_biometrics_setup/biotype_status_action/'. $brandtyp->id.'/'.$brandtyp->InActive); ?>" onClick="return confirm('Are you sure you want to Deactivate Biometrics Type?')"></a>

                    <?php
                      if($real_time_bio=="0"){// wala pang naka active as used in real time logs synching : allow to set / choose biometrics.
                    ?>
                            <a  class='fa fa-unlock<?php echo ' fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_enable_color.';"';?> data-toggle="tooltip" data-placement="left" title="Click to Turn ON Usage of this biometrics in Auto Synching of logs" href="<?php echo site_url('app/time_biometrics_setup/biotype_realtime_used_action/'. $brandtyp->id.'/'.$brandtyp->real_time_status); ?>" onClick="return confirm('Are you sure you want to Turn ON Usage of this biometrics in Auto Synching of logs?')"></a>                    

                    <?php
                      }else{

                      }

                    }
                    ?>




                <?php
                }else{
                ?>

                    <a  class='<?php echo $biotype_enable_disable;?> fa fa-<?php echo $system_defined_icons->icon_enable.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_enable_color.';"';?> data-toggle="tooltip" data-placement="left" title="Click to Activate/Enable" href="<?php echo site_url('app/time_biometrics_setup/biotype_status_action/'. $brandtyp->id.'/'.$brandtyp->InActive); ?>" onClick="return confirm('Are you sure you want to Activate Biometrics Type?')"></a>

                <?php
                }
                echo '</td></tr>';

if($brandtyp->bio_container_type=="separate_column_date_time"){//case: fexco
  $logs_setup_mean='
          <button class="btn btn-default col-md-4" >Date Container:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-primary"></i> '.$brandtyp->date_container.'</button> 
          <button class="btn btn-default col-md-4" >Time Container:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-primary"></i> '.$brandtyp->time_container.'</button> 
          ';
}else{
  $logs_setup_mean='<button class="btn btn-default col-md-4" >Logs Date/Time Container:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-primary"></i> '.$brandtyp->logs_field_name.'</button> 
          ';
}
                echo '
           <tr class="collapse" id="view_setup_'.$brandtyp->id.'"><td colspan="5">
                
          <button class="btn btn-primary col-md-4" >Auto Sync Logs Action:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-primary"></i> '.$mysetup_sync_action_text.'</button> 

          <button class="btn btn-default col-md-4" >MS Access DSN Driver:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-primary"></i> '.$brandtyp->data_source_name_driver.'</button> 

          <button class="btn btn-default col-md-4" >Table Name:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-primary"></i> '.$brandtyp->file_table_name.'</button> 
          <button class="btn btn-default col-md-4" >Employee ID Field Name:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-primary"></i> '.$brandtyp->employee_id_field_name.'</button> 


          <button class="btn btn-default col-md-4" >MS Access DSN Driver:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-primary"></i> '.$brandtyp->data_source_name_driver.'</button> 

          '.$logs_setup_mean.'

          <button class="btn btn-default col-md-4" >Logs Code Type Field Name:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-primary"></i> '.$brandtyp->logs_type_field_name.'</button> 

          <button class="btn btn-danger col-md-4" >  IN Code:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-danger"></i> '.$mysetup_code_in.'</button> 

          <button class="btn btn-danger col-md-4" >  OUT Code:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-danger"></i> '.$mysetup_code_out.'</button> 

          <button class="btn btn-warning col-md-4" >  First Break OUT Code:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-warning"></i> '.$mysetup_code_break_out1.'</button> 

          <button class="btn btn-warning col-md-4" >  First Break IN Code:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-warning"></i> '.$mysetup_code_break_in1.'</button> 

          <button class="btn btn-info col-md-4" >  Lunch Break OUT Code:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-info"></i> '.$mysetup_code_lunch_out.'</button> 

          <button class="btn btn-info col-md-4" >  Lunch Break IN Code:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-info"></i> '.$mysetup_code_lunch_in.'</button> 

          <button class="btn btn-success col-md-4" >  Second Break OUT Code:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-success"></i> '.$mysetup_code_break_out2.'</button> 

          <button class="btn btn-success col-md-4" >  Second Break IN Code:</button> 
          <button class="btn btn-default col-md-8" > <i class="fa fa-arrow-right text-success"></i> '.$mysetup_code_break_in2.'</button> 
          ';

echo '<div class="col-md-12 btn btn-primary">Bio Details <i class="fa fa-arrow-down"></i></div>
          <div class="col-md-12  btn btn-default">
'.nl2br($brandtyp->bio_details).'
          </div>
      </div>
          ';



if($real_time_status=="1"){

echo '<div class="col-md-12 btn btn-primary">Real Time action will get logs from the below checked companies</div>
          <div class="col-md-12">';

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
  $dont_allow_select="disabled";
 }else{
  $realTime="";
  $realTime_marked="";
  $dont_allow_select="disabled";
 }

          if($no_employee_notice==""){
              echo 
              '<label>
              <input type="checkbox" '.$dont_allow_select.' name="cc_view[]" value="'.$comp->company_id.'" '.$no_employee_notice.' value='.$realTime.' '.$realTime_marked.'>
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
         
}else{

}
            echo '</div>    </td></tr>';



              }// end foreach

            }else{
              echo '
                <tr>
                <td colspan="4"> notice: there is no biometrics type/name setup yet.</td>
                </tr>
              ';
            }
            ?>
            <tbody>

            </tbody>
          </table>
          </div>





        </div>



    </div>
  </div>
</div>
