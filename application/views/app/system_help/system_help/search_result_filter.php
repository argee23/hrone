
  <?php  if(empty($results)){ echo "<h3 class='text-danger'><center><i class='fa fa-exclamation'></i>No Results found.</center></h3>"; } else{?>

         <table id="results" class="table table-hover">
            <thead>
                <tr class="danger">
                    <th style="width:2px;"></th>
                    <th style="width: 48px;">Question</th>
                    <th style="width: 50px;">Answer</th>
                   
                </tr>
            </thead>
            <tbody>
            <?php $i=1; foreach($results as $r){
                $keywords =  $this->system_help_model->get_keywords($r->id);
              ?>
                <tr>
                    <td><?php echo $i.").";?></td>
                    <td>
                        <?php echo $r->question;?>
                        <n class='text-danger' style='font-size:12px;'><br>
                         <i><b>Others :</b> <?php echo $r->module;?>-><?php echo $r->topic;?>-><?php echo $r->subtopic;?></i>
                        </n>  
                        <n class='text-warning' style='font-size:12px;'><br>
                          <i><b><?php if(empty($keywords)){ echo "No keyword found."; } else{?>Keywords : <?php foreach($keywords as $k){ echo $k->keyword.","; } ?><?php } ?>
                         </b> </i>
                         <br>
                        </n> 
                    </td>
                    <td>
                      <?php echo $r->answer;?>
                      <n class='text-danger' style='font-size:12px;'><br>
                         <i><?php if(!empty($r->attachment)){ ?>
                            <a style='cursor:pointer;'  href="<?php echo base_url(); ?>app/system_help/download_system_help/<?php echo $r->attachment; ?>" aria-hidden='true' data-toggle='tooltip' title='Click to Dowload Attachment for question -  <?php echo $r->question;?>'>Download Attach File</a>
                         <?php }?></i>
                      </n>   
                    </td>
                    
                </tr>
              <?php $i++; } ?>
            </tbody> 
        </table>    


  <?php } ?>
   