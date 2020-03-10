<!-- //=========== add brand -->
  <div class="col-md-12">
    <div class="panel panel-danger">
      <div class="panel-heading">   
        <strong>
          Edit Biometrics Brand
        </strong>
      </div>
        <div class="panel-body">
          <form name="" method="post" action="<?php echo base_url()?>app/time_biometrics_setup/save_brand/<?php echo $this->uri->segment("4")?>" >
          	<input type="hidden" name="bio_categ_id" value="<?php echo $this->uri->segment("4");?>">
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Brand Name<?php echo $system_defined_icons->required_marked;?></label>
                  <div class="col-sm-12" >
                    <input type="text" name="brand_name" placeholder="Brand Name" class="form-control" required value="<?php echo $s_brand_name;?>">
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