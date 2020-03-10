<?php
    /*
    -----------------------------------
    start : user role restriction access checking.
    get the below variable at table "pages" field page_name
    -----------------------------------
    */
    $edit_announcement_table=$this->session->userdata('edit_announcement_table');
    $delete_announcement_table=$this->session->userdata('delete_announcement_table');
    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>


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

        <table id="announcementList" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Details</th>
                    <th>File Name</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                if ($announcement) 
                {     ?>
                  <br><br><br>
                  <div class="callout callout-success">
                    <i class="fa fa-bullhorn"></i>&nbsp;&nbsp;&nbsp;<?php echo $this->session->flashdata('msg'); ?>
                  </div>

                  <?php
                  foreach ($announcement as $data) 
                  {      
                ?>
                  <tr>
                    <td><?php echo $data->date_from; ?> - <?php echo $data->date_to; ?></td>
                    <td><?php echo $data->announcement_title; ?></td>
                    <td><?php echo $data->announcement_details; ?></td>
                    <td><?php echo $data->file_name; ?></td>
                    <td>
                      <?php 
                         $edit = '<i class="'.$edit_announcement_table.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editAnnounce('.$data->announcement_id.')"></i>';

                        $delete = anchor('app/file_maintenance/delete_announcement/'.$data->announcement_id.'/'.$company->company_id ,'<i class="'.$delete_announcement_table.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this announcement?')"));

                        echo "$edit $delete";
                      ?>
                    </td>
                  </tr>
                <?php
                   }
                 }
                 else
                 {
                ?><br><br><br>
                  <div class="callout callout-danger">
                    <i class="fa fa-bullhorn"></i>&nbsp;&nbsp;&nbsp;<?php echo $this->session->flashdata('empty_msg'); ?>
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