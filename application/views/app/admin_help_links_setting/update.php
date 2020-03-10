<?php if($option=='portal'){?>

          <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/system_help_link_settings/save_update_portal/<?php echo $option;?>" >
          <?php foreach($details as $d){?>
              <div class="col-md-12">
              	<input type="hidden" name="portal_id" value="<?php echo $d->portal_id;?>">
                <input type="text" name="portal" id="portal" class="form-control" value="<?php echo $d->portal;?>" required>
              </div>
              <div class="col-md-12" style="margin-top: 10px" required>
                <button class="col-md-12 btn btn-success btn-sm">SAVE UPDATE</button>
              </div>
           <?php } ?>
          </form>

<?php } else if($option=='category'){ ?>

		 <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/system_help_link_settings/save_update_modules/<?php echo $option;?>" >
          <?php foreach($details as $d){?>
          <input type="hidden" name="module_id" value="<?php echo $d->module_id;?>">
              <div class="col-md-12">
                <select class="form-control" name="portal" id="portal" required>
                    <option value=""  selected>Select Portal</option>
                    <?php foreach($portal_details as $p){?>
                       <option value="<?php echo $p->portal_id;?>" <?php  if($d->portal_id==$p->portal_id){ echo "selected"; }?>><?php echo $p->portal;?></option>
                    <?php } ?>
                </select>
              </div>
              <div class="col-md-12" style="margin-top: 10px;">
                <input type="text" name="category" name="category" class="form-control" required value="<?php echo $d->module;?>">
              </div>


              <div class="col-md-12" style="margin-top: 10px" required>
                <button class="col-md-12 btn btn-success btn-sm">SAVE UPDATE</button>
              </div>
           <?php } ?>
          </form>


<?php } else if($option=='module'){  ?>

			   <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/system_help_link_settings/save_update_topic/<?php echo $option;?>" >
	          <?php foreach($details as $d){?>
	          <input type="hidden" name="topic_id" value="<?php echo $d->topic_id;?>">
	              <div class="col-md-12">
	                <select class="form-control" name="portal" id="portal" required onchange="get_category(this.value);">
	                    <option value=""  selected>Select Portal</option>
	                    <?php foreach($portal_details as $p){?>
	                       <option value="<?php echo $p->portal_id;?>" <?php  if($d->portal_id==$p->portal_id){ echo "selected"; }?>><?php echo $p->portal;?></option>
	                    <?php } ?>
	                </select>
	              </div>

	              <div class="col-md-12" style="margin-top: 10px;">
	                <select class="form-control" name="module" id="module" required>
	                    <option value=""  selected>Select Module</option>
	                    <?php foreach($category_details as $c){?>
	                       <option value="<?php echo $c->module_id;?>" <?php  if($d->module_id==$c->module_id){ echo "selected"; }?>><?php echo $c->module;?></option>
	                    <?php } ?>
	                </select>
	              </div>

	              <div class="col-md-12" style="margin-top: 10px;">
	                <input type="text" name="topic" name="topic" class="form-control" required value="<?php echo $d->topic;?>">
	              </div>

	              <div class="col-md-12" style="margin-top: 10px" required>
	                <button class="col-md-12 btn btn-success btn-sm">SAVE UPDAdsaTE</button>
	              </div>
	           <?php } ?>
	          </form>

<?php } else if($option=='topic'){ ?>

        <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/system_help_link_settings/save_update_subtopic/<?php echo $option;?>" >
            <?php foreach($details as $d){?>
            <input type="hidden" name="subtopic_id" value="<?php echo $d->subtopic_id;?>">
                <div class="col-md-12">
                  <select class="form-control" name="portal" id="portal" required onchange="get_category(this.value);">
                      <option value=""  selected>Select Portal</option>
                      <?php foreach($portal_details as $p){?>
                         <option value="<?php echo $p->portal_id;?>" <?php  if($d->portal_id==$p->portal_id){ echo "selected"; }?>><?php echo $p->portal;?></option>
                      <?php } ?>
                  </select>
                </div>

                <div class="col-md-12" style="margin-top: 10px;">
                  <select class="form-control" name="module" id="module" required onchange="get_module(this.value);">
                      <option value=""  selected>Select Module</option>
                      <?php foreach($module_details as $c){?>
                         <option value="<?php echo $c->module_id;?>" <?php  if($d->module_id==$c->module_id){ echo "selected"; }?>><?php echo $c->module;?></option>
                      <?php } ?>
                  </select>
                </div>

                <div class="col-md-12" style="margin-top: 10px;">
                  <select class="form-control" name="topic" id="topic" required>
                      <option value=""  selected>Select Topic</option>
                      <?php foreach($topic_details as $c){?>
                         <option value="<?php echo $c->topic_id;?>" <?php  if($d->topic_id==$c->topic_id){ echo "selected"; }?>><?php echo $c->topic;?></option>
                      <?php } ?>
                  </select>
                </div>

                <div class="col-md-12" style="margin-top: 10px;">
                  <input type="text" name="subtopic" name="subtopic" class="form-control" required value="<?php echo $d->subtopic;?>">
                </div>

                <div class="col-md-12" style="margin-top: 10px" required>
                  <button class="col-md-12 btn btn-success btn-sm">SAVE UPDATE</button>
                </div>
             <?php } ?>
            </form>

<?php  } ?>