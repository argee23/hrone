
  <div class="col-md-12" id="actionn_update">
        <div class="col-md-3"></div>
          <div class="col-md-6">

           <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/quick_links/save_quick_links_file_maintenance_update/<?php echo $portal;?>/<?php echo $module;?>" >

              <?php foreach($details as $d){?>

              <input type="hidden" name="quick_link_id" id="quick_link_id" value="<?php echo $id;?>">
              <div class="col-md-12">
               <select class="form-control" name="topic_upd" required onchange="get_sub_topic_list(this.value,'subtopic_add');" disabled>
                  <option value="">Select Topic</option>
                  <?php foreach($topic as $t){ 
                    
                  ?>
                    <option value="<?php echo $t->topic_id;?>" <?php if($t->topic_id==$d->topic_id){ echo "selected"; }?>><?php echo $t->topic;?></option>
                  <?php } ?>
               </select>
              </div>

              

              <div class="col-md-12" style="margin-top: 10px;">
                 <input type="text" class="form-control" placeholder="Input Table Name" name="tablename_upd" value="<?php echo $d->table;?>" required>
              </div>

              <div class="col-md-12" style="margin-top: 10px;" >
                 <input type="text" class="form-control"  placeholder="Input Link" name="linnk_upd" value="<?php echo $d->link;?>" required>
              </div>


              <div class="col-md-12" style="margin-top: 10px">
                <button class="col-md-12 btn btn-success btn-sm">SAVE UPDATE</button>
              </div>

              <?php } ?>
          </form>

          </div>
        <div class="col-md-3"></div>  
  </div>
 