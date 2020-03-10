
<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Add Editable 201 Topics Setting</h4></ol>
        
  <div class="panel panel-danger">
    <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:295px;">
          <div class="col-md-12">
     
            <div class="col-md-2"><label>Select Company :</label></div>
            <div class="col-md-6">
              <select class="form-control" onchange="topic_list(this.value);" id="company">
                <option readonly selected value="<?php echo $company_id?>"><?php echo $company_title?></option>
              </select>
            </div><br><br>
            <div class="col-md-12" id='topic_list'>
                  <br>
                  <div class="box box-danger" class='col-md-12'></div>
                  <h4 class="text-danger"><center><?php echo $company_title?> 201 Update Setting</center></h4><br>
                  <div class="col-md-12"><input type="checkbox" name="topics" class="checkbox_stat" id="check_uncheck" onclick="checkbox_stat();">Check | Uncheck All</div>
                  <?php $i=0; foreach($topicList as $topic) { ?>
                      <div class="col-md-4">
                        <input type="checkbox" name="topics" class="topics" value="<?php echo $topic->topic_id?>" 
                         <?php foreach ($companySetting as $cc){ $da =  explode("-",$cc->topics); foreach ($da as $d) { if($d == $topic->topic_id){ echo "checked"; } } }?> ><?php echo $topic->topic_title?>
                      </div>
                  <?php $i = $i + 1; } echo "<input type='hidden' id='topic_count' value='".$i."'>";?>
                  <div class="col-md-12">
                    <button class="btn btn-danger pull-right" style="margin-left: 5px;"  onclick='deleteSetting("<?php echo $update_setting_id;?>","<?php echo $company_id;?>")'>DELETE</button>
                    <button class="btn btn-success pull-right" onclick="save_updatedsetting();">SAVE CHANGES</button>
                  </div>
            </div>
          </div>
        </div>
      </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>             



