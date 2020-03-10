<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$biobrand_add=$this->session->userdata('biobrand_add');
$biobrand_edit=$this->session->userdata('biobrand_edit');
$biobrand_enable_disable=$this->session->userdata('biobrand_enable_disable');
$biobrand_del=$this->session->userdata('biobrand_del');
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
          Add Biometrics Brand
        </strong>
      </div>
        <div class="panel-body">
          <form name="" method="post" action="<?php echo base_url()?>app/time_biometrics_setup/add_brand" >
              <div class="form-group"   >
                <label for="next" class="col-sm-5 control-label">Brand Name<?php echo $system_defined_icons->required_marked;?></label>
                  <div class="col-sm-7" >
                    <input type="text" name="brand_name" placeholder="Brand Name" class="form-control" required>
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
      <strong>Biometrics Brand Management</strong>

        <a class="<?php echo $biobrand_add;?> btn btn-default btn-xs pull-right" data-toggle="collapse" href="#collapse_manage_pp" aria-expanded="false" aria-controls="collapseExample">
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
                <th>Date Added</th>
                <th>Date Last Modified</th>
                <th>Status</th>
                <th style="text-align:center;">Options</th>
              </tr>
            </thead>
            <?php
            if(!empty($brandmng)){
              foreach($brandmng as $brand){
                $delete_check=$this->time_biometrics_setup_model->checkbeforedelete($brand->bio_categ_id);
                if(!empty($delete_check)){
                  $allow_delete=0; // dont allow delete
                }else{
                  $allow_delete=1; // allow delete
                }

                $edit="<i class='".$biobrand_edit." fa fa-".$system_defined_icons->icon_edit." fa-".$system_defined_icons->icon_size."x'  
                style='color:".$system_defined_icons->icon_edit_color.";' data-toggle='tooltip' data-placement='left' title='Edit' onclick='edit_brand(".$brand->bio_categ_id.")'></i>" ;
                $confirm_mess='"Are you sure you want to delete?"';
                $delete='';

                if($brand->InActive=="1"){
                   $status="Deactivated";
                   $status_class='class="text-danger"';

                   $edit="<i class='".$biobrand_edit." fa fa-".$system_defined_icons->icon_edit." fa-".$system_defined_icons->icon_size."x  text-muted'  data-toggle='tooltip' data-placement='left' title='Edit not allowed' ></i>" ;

                   $delete="<i class='".$biobrand_del." fa fa-".$system_defined_icons->icon_delete." fa-".$system_defined_icons->icon_size."x  text-muted'  data-toggle='tooltip' data-placement='left' title='Delete not allowed' ></i>" ;
                    
                }else{
                   
                   $status="Active";
                   $status_class='';

                }



                echo '
                <tr '.$status_class.'>
                <td>'.$brand->brand_name.'</td>
                <td>'.$brand->date_added.'</td>
                <td>'.$brand->date_updated.'</td>
                <td>'.$status.'</td>
                <td>'.$edit.' '.$delete;
        
                if($brand->InActive=="0"){
                
                  if($allow_delete==1){
                ?>
                    <a  class='<?php echo $biobrand_del;?> fa fa-<?php echo $system_defined_icons->icon_delete.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_delete_color.';"';?> data-toggle="tooltip" data-placement="left" title="Delete" href="<?php echo site_url('app/time_biometrics_setup/delete_brand/'. $brand->bio_categ_id.''); ?>" onClick="return confirm('Are you sure you want to permanently delete?')"></a>
                    
                    <?php
                  }else{
                    
                  }
                    ?>
                    <a  class='<?php echo $biobrand_enable_disable;?> fa fa-<?php echo $system_defined_icons->icon_disable.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_disable_color.';"';?> data-toggle="tooltip" data-placement="left" title="Click to Deactivate/Disable" href="<?php echo site_url('app/time_biometrics_setup/brand_status_action/'. $brand->bio_categ_id.'/'.$brand->InActive); ?>" onClick="return confirm('Are you sure you want to Deactivate Machine Brand?')"></a>

                <?php
                }else{
                ?>

                    <a  class='<?php echo $biobrand_enable_disable;?> fa fa-<?php echo $system_defined_icons->icon_enable.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_enable_color.';"';?> data-toggle="tooltip" data-placement="left" title="Click to Activate/Enable" href="<?php echo site_url('app/time_biometrics_setup/brand_status_action/'. $brand->bio_categ_id.'/'.$brand->InActive); ?>" onClick="return confirm('Are you sure you want to Activate Machine Brand?')"></a>

                <?php
                }
                echo '</td>
                </tr>
                ';
              }

            }else{
              echo '
                <tr>
                <td colspan="4"> notice: there is no biometrics brand setup yet.</td>
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
