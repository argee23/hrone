      <div class="box box-success">
        <div class="box-header">
          <h3>Employee Report List</h3>
          <div id="msg"></div>
          <?php
            if ($this->session->flashdata('success_msg')) {
          ?>
          <div class="alert alert-success alert-dismissable fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $this->session->flashdata('success_msg'); ?>
          </div>
          <?php
            }
          ?>

          <?php
            if ($this->session->flashdata('error_msg')) {   
          ?>
          <div class="alert alert-danger alert-dismissable fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $this->session->flashdata('error_msg'); ?>
          </div>
          <?php
            }
          ?>
          <a type="button" class="btn btn-success btn-sm" title="Add Report" onclick="add_report()"><i class="fa fa-plus-square"></i> Add New Report </a>
        </div> <!-- /.box-header -->

        <div class="box-body">
          <table id="reportList" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Report ID</th>
                <th>Report Name</th>
                <th>Description</th>
                <th>Option</th>
              </tr>
            </thead>
            <tbody>
            <?php
            if ($record) 
            {     
              foreach ($record as $data) 
              {      
            ?>
              <tr>
                <td><?php echo $data->report_id; ?></td>
                <td><?php echo $data->report_name; ?></td>
                <td><?php echo $data->report_description; ?></td>
                <td>
                  <a type="button" class="btn btn-info fa fa-edit" title="Edit Report" onclick="edit_report(<?php echo $data->report_id;?>)"></a>
                  <a type="button" class="btn btn-danger fa fa-remove" title="Delete Report" onclick="delete_report(<?php echo $data->report_id;?>)"></a>
                </td>
              </tr>
            <?php
               }
             }
             else
             {
            ?>
              <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error_message'); ?>
              </div>
            <?php
             }
            ?>
            </tbody>
          </table>
        </div>
      </div> <!-- /.box -->
    
