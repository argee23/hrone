  <?php
  $form_part_id=$form_score_det->form_part_id;

  ?>

  <div id='part' class="col-md-12">
    <div class="panel panel-info">
      <div class="panel-heading">   
        
          Edit Score Criteria for Form Part   
      <strong><?php echo $form_score_det->part_name;?></strong>
      <button id='close' class="pull-right close"> x </button>
      </div>
        <div class="panel-body">
          <form name="" method="post" action="<?php echo base_url()?>employee_portal/pms/save_edit_form_score/<?php echo $this->uri->segment("4")?>" >
          
            <input type="hidden" name="id" value="<?php echo $this->uri->segment("4");?>">
            <input type="hidden" name="form_part_id" value="<?php echo $form_part_id;?>">

              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Score Number</label>
                  <div class="col-sm-12" >
                  <input type="hidden" name="form_part_id" value="<?php echo $form_part_id;?>">
                  <select name="score" class="form-control" required>
                  <option value="<?php echo $form_score_det->score?>" selected><?php echo $form_score_det->score?></option>
                    <?php 
                    for ($x = 1; $x <= 20; $x++) {
                    $csn=$this->pms_model->check_score_number($x,$form_part_id);
                    if(!empty($csn)){
                      $part_num_exist=$csn->score;
                    }else{
                      $part_num_exist="";
                    }
                        if($part_num_exist==$x){
                           echo '<option value="'.$x.'" disabled>'.$x.'</option>';
                        }else{
                           echo '<option value="'.$x.'">'.$x.'</option>';
                        }
                    } 
                    ?>
                  </select>
                  </div>
              </div><br><br><br><br>
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Score Equivalent</label>
                  <div class="col-sm-12" >
                   <input type="text" name="score_equivalent" class="form-control"  required placeholder="e.g. Outstanding" value="<?php echo $form_score_det->score_equivalent?>" required>
                  </div>
              </div><br><br><br>
             
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Scoring Guide</label>
                  <div class="col-sm-12" >
                   <textarea placeholder="e.g. Delivers beyond 95% - 100%" name="score_guide" class="form-control" required><?php echo $form_score_det->score_guide?></textarea>
                  </div>
              </div><br><br><br><br>
           
              <div class="form-group"   >
                <label for="next" class="col-sm-5 control-label">&nbsp;&nbsp;&nbsp;</label>
                  <div class="col-sm-7" >
                  
                    <button type='submit' class="btn btn-primary pull-right"> Save </button>

                    </button>
                  </div>
              </div>

            </form>

        </div>
    </div>
  </div>
  