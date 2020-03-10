
  <div class="col-md-12" id="actionn_update">
        <div class="col-md-3"></div>
          <div class="col-md-6">

           <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/system_help/save_system_help_file_maintenance_update/<?php echo $portal;?>/<?php echo $module;?>" >

              <?php foreach($details as $d){?>

              <input type="hidden" name="system_help_id" id="system_help_id" value="<?php echo $id;?>">
              <div class="col-md-12">
               <select class="form-control" name="topic_upd" required onchange="get_sub_topic_list(this.value,'subtopic_add');" disabled>
                  <option value="">Select Topic</option>
                  <?php foreach($topic as $t){ ?>
                    <option value="<?php echo $t->topic_id;?>" <?php if($t->topic_id==$d->topic_id){ echo "selected"; }?>><?php echo $t->topic;?></option>
                  <?php } ?>
               </select>
              </div>

              <div class="col-md-12" style="margin-top: 10px;">
                <select class="form-control" name="subtopic_add_upd" id="subtopic_add_upd" required disabled>
                    <option value="">Select Sub Topic</option> 
                    <?php foreach($subtopic as $ss){?>
                       <option value="<?php echo $ss->subtopic_id;?>" <?php if($ss->subtopic_id==$d->subtopic_id){ echo "selected"; }?>><?php echo $ss->subtopic;?></option>
                    <?php }  ?>
                </select>
              </div>

              <div class="col-md-12" style="margin-top: 10px;">
                 <input type="text" class="form-control" placeholder="Input Question" name="question_upd" value="<?php echo $d->question;?>" required>
              </div>

              <div class="col-md-12" style="margin-top: 10px;" >
                 <input type="text" class="form-control"  placeholder="Input Answer" name="answer_upd" value="<?php echo $d->answer;?>" required>
              </div>


              <div class="col-md-12" style="margin-top: 10px;">
                  <input type="file" name="file" id="file">
                  <n class='text-danger'>Allowed files: 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx'</n> 
              </div>

              <div class="col-md-12" style="margin-top: 10px">
                <button class="col-md-12 btn btn-success btn-sm">SAVE UPDATE</button>
              </div>

              <?php } ?>
          </form>

          </div>
        <div class="col-md-3"></div>  
  </div>
 