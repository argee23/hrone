<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Company Recruitment Settings</h4></ol>
<div class="col-md-12"><br>
      <?php echo $this->session->flashdata('question_type')."mila";?>
      <div class="col-md-12">
          <div class="col-md-3"></div>
          <div class="col-md-6">
          	 <n><center><b>SELECT RECRUITMENT SETTINGS</b></center></n>
              <select class="form-control" style="margin-top: 5px;" onchange="get_company_settings('<?php echo $company_id;?>',this.value)" id="setting">
              	<option value="" disabled selected>Select recruitment setting</option>
                  <?php foreach ($settings as $s) {?>
                      <option value="<?php echo $s->code;?>" <?php if($code==$s->code){ echo "selected"; }?>><?php echo $s->title;?></option>
                  <?php } ?>
              </select>

              <?php if($code=='ED5'){ $ff='block'; } else{ $ff='none'; }?>
              <select class="form-control" id="questions" style="margin-top: 5px;display: <?php echo $ff;?>" onchange="get_company_questions('<?php echo $company_id;?>',this.value);">
              	<option value="" disabled selected>Select Question Type</option>
                 <option value="qualifying">Qualifying Questions</option>
                 <option value="hypothetical">Hypothetical Questions</option>
                 <option value="multiple_choice">Multiple Choice</option>
              </select>

          </div>
          <div class="col-md-3"></div>
      </div> 

      <div class="col-md-12"><br>
      	<div class="box box-default" class='col-md-12'></div>
      </div>

     

      <div class="col-md-12" id="settingsaction" style="margin-top: 10px;">

        <?php if(empty($code)){ require_once(APPPATH.'views/app/recruitment_maintenance/setting/setting_ED9_main.php'); } 
              else{ require_once(APPPATH.'views/app/recruitment_maintenance/setting/setting_'.$code.'_main.php'); }  ?>
	       
      </div>



</div>  
<div class="btn-group-vertical btn-block"> </div>   
     