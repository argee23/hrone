 <div class="col-md-12"  style="margin-top: 10px;">
            <table class="table table-bordered">
              <thead>
                <tr>
                   <th colspan="3"><center><h3 class="text-success">Waiting for HR Approval</h3></center></th>
                </tr>
              </thead>
             <tbody>  
                <tr>
                    <td align='center'><b>Topic</b></td>
                    <td  align='center'><b>Action</b></td>
                    <td  align='center'><b>Status</b></td>
                </tr>
                <?php  foreach ($topicss as $k) {?>
                  <tr>
                    <td width='40%'><center><n class="text-danger"><?php echo $k->topic_title?></n></center></td>
                    <td width='30%'>
                      <?php $checkers = $this->employee_201_model->checker_req($k->request_id,$k->request_topic_id); foreach($checkers as $c) {?>
                         <n style='padding-left: 30px;'><?php echo $c->action?> </n><br>
                        <?php } ?>  
                    </td> 
                    <td>
                    <?php $checkers = $this->employee_201_model->checker_req($k->request_id,$k->request_topic_id); foreach($checkers as $c) {?>
                         <n style='padding-left: 30px;' class="<?php if($c->status=='Pending'){ echo "text-success"; } elseif($c->status=='Approved'){ echo "text-danger"; } else{ echo "text-info"; } ?>"><?php echo $c->status?> </n><br>
                        <?php } ?>
                    </td>
                   
                  </tr>
                  <?php } ?>
              </tbody>
            </table>
        </div>