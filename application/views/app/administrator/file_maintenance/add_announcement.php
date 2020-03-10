
<div class="row">
  <div class="col-md-10">
    <div class="panel panel-success">
      <div class="panel-heading"><strong>Add Announcement</strong></div>
        <div class="panel-body">
          <form enctype="multipart/form-data" id="announcement_form" method="post" action="<?php echo base_url()?>app/file_maintenance/save_announcement">
          <div class="form-horizontal">
            <div id="alert"></div>
            <h3 class="text-primary">Announcement Information</h3>
            <hr>
            
            <div class="form-group">
              <label for="title" class="col-sm-2 control-label">Title:</label>
              <div class="col-md-8">
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required>
              </div>
            </div>
            
            <div class="form-group">
              <label for="date_from" class="col-sm-2 control-label">Date From:</label>
              <div class="col-md-8">
                <input type="date" class="form-control" id="date_from" name="date_from" required>
              </div>
            </div>
            
            <div class="form-group">
              <label for="date_to" class="col-sm-2 control-label">Date To:</label>
              <div class="col-md-8">
                <input type="date" class="form-control" id="date_to" name="date_to" required>
              </div>
            </div>
            
            <div class="form-group" >
              <label for="details" class="col-sm-2 control-label">Details:</label>
              <div class="col-md-8">
                <textarea class="form-control" rows="3" id="details" name="details" placeholder="Enter Details" required></textarea>
              </div>
            </div>
            
            <div class="form-group" >
              <label for="attach_file" class="col-sm-2 control-label">Attach File:</label>
              <div class="col-md-2">
                <input type="file" id="attach_file" name="attach_file">
              </div>
            </div>
          </div>

          <hr>
          <h3 class="text-primary">Other Information</h3>
          <hr>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="company">Company</label>
                  <br>

                  <div class="col-md-9">All : </div>
                  
                   <div class="col-md-1"><input type="checkbox" onclick="all_company();" class="all_company"></div><br>
                  
                  <?php
                  foreach ($companyList as $row)
                  {
                  ?>
                    <div class="col-md-9"><?php echo $row->company_name?> : </div>
                    <div class="col-md-1"><input class="company" onclick="uncheck_company();" type="checkbox" name="company[]" value="<?php echo $row->company_id?>"></div><br>
                  <?php
                  }
                  ?>
              </div>
            </div>

            <div class="col-md-6" id="division">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6" id="department">
            </div>

            <div class="col-md-6" id="section">
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6" id="subsection">
            </div>
          </div>
         
            </div>
          </div>
            
          <div class="form-group">
            <hr>
            <button type="button" class="btn btn-danger pull-right" onclick="announcement_company()">Back</button>
            <button type="submit" onclick="add_announce()" class="btn btn-primary pull-right">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

    <div class="col-md-6" id="col_3"> 
    </div>
</div>