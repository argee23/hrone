<div class="row">
        <div class="col-md-8 col-md-offset-2">
          <hr>
      </div>
    </div>
    <table id="jobApplication" class="table table-bordered table-striped">
            <thead>
                      <tr>
                        <th>Company Name</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Date Applied</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($applicantListAll as $reports){ ?>

                      <tr>
                        <td><?php echo $reports->company_name?></td>
                        <td><?php echo $reports->fullname?></td>
                        <td><?php echo $reports->job_title?></td>
                        <td><?php echo $reports->date_applied?></td>
                        <td><?php if(isset($reports->status_title)){echo $reports->status_title;} else { echo "No Status Set Yet";}?></td>
                        
                      </tr>
                      <?php }?>
                     
                    </tbody>
    </table>