<title>Uploaded Resume</title>
<div ng-init="getResume()" ng-cloak>
<div class="box-header with-border">
  <h3 class="box-title">Resume</h3>
    <div class="box-tools pull-right">
    </div>
</div><br>
   <div class="splash col-lg-12" ng-cloak="">
    <div class="spinner">
      <div class="double-bounce1"></div>
      <div class="double-bounce2"></div>
    </div>
    <center><h3 class="text-primary">Please wait while data loads..</h3></center>
  </div>
   <div ng-cloak>
   <div class="col-lg-12">
     <div class="col-lg-6">
      <center>
      <span ng-if="resumee.resume_file == null || resumee.resume_file.length == 0" ng-cloak>
      <h4>You have not upload a resume yet.</h4>
      </span>
      <a href="<?php echo base_url()?>public/applicant_files/resume/{{resumee.resume_file}}" target="_blank" class="btn btn-primary btn-lg" ng-class="{'disabled': resumee.resume_file == null || resumee.resume_file.length == 0}" ><i class="fa fa-eye" ng-cloak> View Resume</i>
      </a>

      </center>
     </div>
     <div class="col-lg-6">
      <form name="resume_upload" action="update_resume" method="post" enctype="multipart/form-data">
      <label>Update your Resume: </label>
      <input type="file" name="resume" id="resume" placeholder="Maximum Allowed Size: 500KB">
      <input type="hidden" name="resume_file" id="resume_file" value="{{resumee.resume_file}}"
      <small>Accepted File Type: <strong>PDF</strong> | File Size must <strong>not exceed 500KB.</strong></small><br><br>
      <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Upload Resume</button>
      </form>
     </div>
   </div>
   </div>
</div>