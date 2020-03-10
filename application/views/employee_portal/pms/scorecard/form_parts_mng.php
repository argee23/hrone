
          <div id='add' class="col-md-12">

            <div class="panel panel-info">
              <div class="panel-heading">   
                <strong>
                  Forms Part Management
                  <a id='add_form_part' href=''><i class="fa fa-<?=$system_defined_icons->icon_add?> fa-<?=$system_defined_icons->icon_size?>x pull-right" data-toggle="tooltip" data-placement="left" title="Add" style="color:<?=$system_defined_icons->icon_add_color?>;"></i></a>
                </strong>
              </div>
                <div class="panel-body">
                  <?php if($check){?>
                  <table class="table">
                    <thead>
                      <th>Scoring</th>
                      <th>Equivalent</th>
                      <th>Scoring Guide</th>
                      <th>Options</th>
                    </thead>
                    <tbody>
                      <?php foreach($form_part_mng as $part):?>
                      <tr>
                        <td><?=$part->score?></td>
                        <td><?=$part->score_equivalent?></td>
                        <td><?=$part->score_guide?></td> 
                        </td>
                        <td>
                          <a href="javascript:void(0)"><i  onclick='edit_form_score_criteria("<?=$part->id?>");' class="fa fa-<?=$system_defined_icons->icon_edit?> fa-<?=$system_defined_icons->icon_size?>x" style="color:<?=$system_defined_icons->icon_edit_color?>;" data-toggle="tooltip" data-placement="left" title="Edit"></i></a>
                          <a href="<?php echo site_url('employee_portal/pms/delete_form_score/'. $part->id.'/'.$part->form_part_id); ?>"><i class="fa fa-<?=$system_defined_icons->icon_delete?> fa-<?=$system_defined_icons->icon_size?>x" data-toggle="tooltip" data-placement="left" title="Delete" style="color:<?=$system_defined_icons->icon_delete_color?>;"  onClick="return confirm('Are you sure you want to permanently delete?')"></i></a>
                          <!-- <a  class='fa fa-<?php echo $system_defined_icons->icon_enable.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_disable_color.';"';?> data-toggle="tooltip" data-placement="left" title="Disable" href="<?php echo site_url('employee_portal/pms/disable_form_sc/'.$part->id); ?>" onClick="return confirm('Are you sure you want to Deactivate Score Criteria?')"></a>
                          <a  class='fa fa-<?php echo $system_defined_icons->icon_enable.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_enable_color.';"';?> data-toggle="tooltip" data-placement="left" title="Enable" href="<?php echo site_url('employee_portal/pms/enable_form_sc/'. $part->id); ?>" onClick="return confirm('Are you sure you want to Activate Score Criteria?')"></a> -->
                        </td>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                <?php } else { echo '<center><h4><strong>NO FORM PARTS</strong></h4></center>'; }?>
                </div>
            </div>
          </div>

          <div id='add_form' class="col-md-12" style="display: none;">

            <div class="panel panel-info">
              <div class="panel-heading">   
                <strong>
                  Add Score Criteria
                  <button id='close' class="pull-right close"> x </button>
                </strong>
              </div>
                <div class="panel-body">
                  <form name="" method="post" action="<?php echo base_url()?>employee_portal/pms/add_form_score" >

              <div class="form-group"   >
                <label for="next" class="col-sm-5 control-label">Score Number</label>
                  <div class="col-sm-7" >
                  <input type="hidden" name="form_part_id" value="<?php echo $form_id;?>">
                  <select name="score" class="form-control" required>
                    <?php 
                    for ($x = 1; $x <= 20; $x++) {
                    $csn=$this->pms_model->check_score_number($x,$form_id);
                    if(!empty($csn)){
                      $part_num_exist = $csn->score;
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
              </div><br><br><br>
              <div class="form-group"   >
                <label for="next" class="col-sm-5 control-label">Score Equivalent</label>
                  <div class="col-sm-7" >
                   <input type="text" name="score_equivalent" class="form-control"  required placeholder="e.g. Outstanding" required>
                  </div>
              </div><br><br>
             
              <div class="form-group"   >
                <label for="next" class="col-sm-5 control-label">Scoring Guide</label>
                  <div class="col-sm-7" >
                   <textarea placeholder="e.g. Delivers beyond 95% - 100%" name="score_guide" class="form-control" required></textarea>
                  </div>
              </div><br><br>

              <div class="form-group" >
                <label for="next" class="col-sm-5 control-label">&nbsp;&nbsp;&nbsp;</label>
                  <div class="col-sm-7" >
                    <br>
                    <button type='submit' class="btn btn-primary pull-right"> Save </button>
                  </div>
              </div>

            </form>
                </div>
            </div>
          </div>