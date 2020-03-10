<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Add Editable 201 Topics Setting</h4></ol>
        
  <div class="panel panel-danger">
    <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:295px;">
          <div class="col-md-12">
     
            <div class="col-md-2"><label>Select Company :</label></div>
            <div class="col-md-6">
              <select class="form-control" onchange="topic_list(this.value);" id="company">
              <option selected disabled> Select Company first to continue adding.</option>
                <?php foreach($companyList as $company) {?>
                <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
                <?php } ?>
              </select>
            </div><br><br>
            <div class="col-md-12" id='topic_list'>
                <br>
                  <div class="box box-danger" class='col-md-12'></div>
                  <h4 class="text-danger"><center>Select atleast one topic to continue.</center></h4><br>
                  <?php foreach($topicList as $topic) { ?>
                      <div class="col-md-4">
                        <input type="checkbox" disabled><?php echo $topic->topic_title?>
                      </div>
                  <?php  } ?>

            </div>
          </div>
        </div>
      </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>             

