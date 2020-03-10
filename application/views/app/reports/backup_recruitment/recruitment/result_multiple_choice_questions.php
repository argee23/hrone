<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <hr>
  </div>
</div>
    <table id="questions" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Question</th>
                    <th>Choices</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($questions as $questions){ ?>

                <tr>
                    <td><?php echo $questions->company_name?></td>
                    <td><?php echo $questions->question?></td>
                    <td>
                        <?php 
                          $choices = $this->reports_model->get_choices($questions->id);
                          $no = 1; 
                          foreach($choices as $mc){
                            echo "<div>".$no.") ".$mc->mc_choice."</div>";
                            $no++;
                          }
                        ?>  
                    </td>
                    <td><?php if($questions->InActive == 1){ echo "Inactive"; } else { echo "Active";}?></td>
                </tr>
                      <?php }?>
                     
             </tbody>
    </table>