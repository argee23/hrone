<title>Current Image</title>
<div class="box-header with-border">
  <h3 class="box-title">Image</h3>
    <div class="box-tools pull-right">
    </div>
</div><br>
<div class="col-lg-12">
  <div class="col-lg-4">
    <label>Current Image:</label>
    <div class="thumbnail">
      <img class="img-responsive" src="<?php echo base_url()?>public/applicant_files/employee_picture/<?php echo $this->session->userdata('picture'); ?>" alt="<?php echo $this->session->userdata('name_of_user'); ?>" width="250" height="250"> 
      </div>
  </div>
  <div class="col-lg-8">
  <form name="change_image" method="post" action="update_image" enctype="multipart/form-data">
  <div class="form-group">
    <label>Choose your new image: </label>
      <div class="input-group">
        <input type="file" class="btn btn-default input-sm" name="photo" id="photo">
        <div class="input-group-btn">
          <button type="submit" class="btn btn-success btn-sm">Upload</button>
        </div>
      </div>
      <span>Maximum Allowed Size: 2MB</span>
    </div>
    </form>
  </div>
</div>