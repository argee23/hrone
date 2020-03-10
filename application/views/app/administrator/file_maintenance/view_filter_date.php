
<div class="row">
  <div class="col-md-10">
    <div class="panel panel-success">
      
      <div class="panel-heading"><strong><?php echo $company->company_name; ?></strong><a type="button" id="button" class="btn btn-sm btn-danger pull-right" title="Back" onclick="announcement_company()"><i class="fa fa-reply-all"></i></a><a onclick="filter_announcement()" type="button" class="btn btn-sm btn-success pull-right" title="Filter Announcement"><i class="fa fa-filter"></i></a></div>
      <input type="hidden" name="hidden_company" id="hidden_company" value="<?php echo $company->company_id; ?>">
      <div class="panel-body">
        <div class="form-group pull-left">
          <label for="date_to" class="col-sm-2 control-label">Date To:</label>
          <div class="col-sm-8">
            <input type="date" class="form-control" id="filter_date_to">
          </div>
        </div>

        <div class="form-group pull-left">
          <label for="date_from" class="col-sm-2 control-label">Date From:</label>
          <div class="col-sm-8">
            <input type="date" class="form-control" id="filter_date_from">
          </div>
        </div>

        <div class="form-group pull-left">
          <a type="button" id="button" class="btn btn-success" title="Filter By Date" onclick="view_filter_date()"><i class="fa fa-calendar"></i> Filter By Date </a>
        </div>

        <br><br><br><br>
          <table id="announcementFilterList" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Date</th>
                <th>Title</th>
                <th>Details</th>
                <th>Option</th>
              </tr>
            </thead>
            <tbody>
            <?php
            if ($filter_date) 
            {     
              foreach ($filter_date as $data) 
              {      
            ?>
              <tr>
                <td><?php echo $data->date_from; ?> - <?php echo $data->date_to; ?></td>
                <td><?php echo $data->announcement_title; ?></td>
                <td><?php echo $data->announcement_details; ?></td>
                <td>
                  <a type="button" class="btn btn-info fa fa-edit" title="Edit Announcement" onclick="editAnnounce(<?php $data->announcement_id; ?>)"></a>
                  <a type="button" href="<?php echo base_url();?>app/file_maintenance/delete_announcement/<?php echo $data->announcement_id;?>" title="Delete Announcement" class="btn btn-danger fa fa-remove" onclick="return confirm('Are you you want to delete record?')"></a>
                </td>
              </tr>
            <?php
               }
             }
             else
             {
            ?>
              <div class="alert alert-danger">
                <?php echo $this->session->flashdata('no_data'); ?>
              </div>
            <?php
             }
            ?>
            </tbody>
          </table>
      </div>
      
    </div>
  </div>

  <div class="col-md-6" id="col_3">
    
  </div>
</div>