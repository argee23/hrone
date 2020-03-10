<!-- //=========== add  -->
  <div id='part' class="col-md-12">
    <div class="panel panel-warning">
      <div class="panel-heading">   
        <strong>
          Edit Form Part
          <button id='close' class="pull-right close"> x </button>
        </strong>
      </div>
        <div class="panel-body">
          <form method="post" action="<?php echo base_url()?>employee_portal/pms/save_edit_form_details/<?php echo $this->uri->segment("4")?>" >
          	<input type="hidden" name="id" value="<?php echo $this->uri->segment("4");?>">

              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Form Part Number</label>
                  <div class="col-sm-12" >

                  <select name="part_number" class="form-control" required>
                  <option value="<?php echo $form_details->part_number;?>" selected>Part <?php echo $form_details->part_number;?></option>
                    <?php 
                    for ($x = 1; $x <= 100; $x++) {
                    $cpn=$this->pms_model->check_part_number($x);
                    if(!empty($cpn)){
                      $part_num_exist=$cpn->part_number;
                    }else{
                      $part_num_exist="";
                    }
                        if($part_num_exist==$x){
                           echo '<option value="'.$x.'" disabled>Part '.$x.'</option>';
                        }else{
                           echo '<option value="'.$x.'">Part '.$x.'</option>';
                        }
                    } 
                    ?>
                  </select>
                  </div>
              </div>
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Form Part Name/Title</label>
                  <div class="col-sm-12" >
                   <input type="text" name="part_name" class="form-control" placeholder="ex: Leadership" value="<?php echo $form_details->part_name;?>">
                  </div>
              </div>
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Weight</label>
                  <div class="col-sm-12" >

                  <select name="form_weight" class="form-control" required>

                    <?php 

                    $fw=$form_details->form_weight;
                    $fw=substr($fw, 0,-1);

                    for ($x = 1; $x <= 200; $x++) {
                      if($fw==$x){
                        $sel="selected";
                      }else{
                        $sel="";
                      }

                           echo '<option value="'.$x.'" '.$sel.'>'.$x.'%</option>';
                        
                    } 
                    ?>
                  </select>
                  </div>
              </div>
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Form Instruction(s)</label>
                  <div class="col-sm-12" >
                   <textarea name="instructions" class="form-control" rows="10"><?php echo $form_details->instructions?></textarea>
                  </div>
              </div>


              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Form Part Description</label>
                  <div class="col-sm-12" >
                   <textarea name="part_desc" class="form-control" rows="5"><?php echo $form_details->part_desc;?></textarea>
                  </div>
              </div>

              <div class="col-sm-12">

              </div>



              <div class="form-group" >
                <label for="next" class="col-sm-5 control-label">&nbsp;&nbsp;&nbsp;</label>
                  <div class="col-sm-7" ><br>
                    
                    
                    <button type='submit' class="btn btn-primary pull-right"> Save </button>
                  </div>
              </div>
            </form>
        </div>
    </div>
  </div>

