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
                    <th>Correct Answer</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($questions as $questions){ ?>

                <tr>
                    <td><?php echo $questions->company_name?></td>
                    <td><?php echo $questions->question?></td>
                    <td><?php if($questions->correct_ans == 1){ echo "Yes"; } else { echo "No";}?></td>
                    <td><?php if($questions->InActive == 1){ echo "Inactive"; } else { echo "Active";}?></td>
                </tr>
                      <?php }?>
                     
             </tbody>
    </table>
    </div>