<?php if(!empty($posts)): foreach($posts as $job): ?>
 <div class="col-md-12">
      <div class="jobstyle">
        <div class="job">
            <form name="view_job" action="<?php echo base_url()?>app/application_form/signup" method="post">
            <input type="hidden" name="id" id="id" value="<?php echo $job['id']; ?>">
            <input type="hidden" name="company_id" id="company_id" value="<?php echo $job['company_id']; ?>">
            <h4 class="text-info">
            <img src="<?php echo base_url()?>/public/company_logo/<?php echo $job['logo']; ?>" class="pull-right media-object" style="width:50px">
            <div class="job_title ellipses"><button type="submit" class="btn btn-default"><?php echo $job['job_title']; ?></button></div></h4>
            </form>
            <p><i class="fa fa-building"></i> <?php echo $job['company_name']; ?></p>
            <div class="job_content ellipses">

              <?php echo nl2br( $job['job_description'] ); ?>
              
            </div>

            <br>
        </div>
        </div>
      </div>

<?php endforeach; else: ?>
<p>Post(s) not available.</p>
<?php endif; ?>
<?php echo $this->ajax_pagination->create_links(); ?>