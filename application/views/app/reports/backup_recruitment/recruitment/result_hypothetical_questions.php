    <div class="col-md-12" id="fill" style="padding: 0 0 1% 0">
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
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($questions as $questions){ ?>

                <tr>
                    <td><?php echo $questions->company_name?></td>
                    <td><?php echo $questions->question?></td>
                    <td><?php if($questions->InActive == 1){ echo "Inactive"; } else { echo "Active";}?></td>
                </tr>
                      <?php }?>
                     
             </tbody>
    </table>
    </div>