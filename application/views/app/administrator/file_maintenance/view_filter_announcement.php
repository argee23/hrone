
<div class="row">
  <div class="col-md-10">
    <div class="panel panel-success">
      
      <div class="panel-heading"><strong>Announcement</strong></div>
        <div class="panel-body">
          <a type="button" id="button" class="btn btn-default" title="Back" onclick="announcement_company()"><i class="fa fa-reply-all"></i> Back </a>
          <br><br>
            <table id="filterList" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Details</th>
                  <th>Date From</th>
                  <th>Date To</th>
                  <th>File Name</th>
                  <th>Description</th>
                  <th>Name</th>
                </tr>
              </thead>
              <tbody>
              <?php
              if ($filter) 
              {     
                foreach ($filter as $data) 
                {      
              ?>
                <tr>
                  <td><?php echo $data->announcement_title; ?></td>
                  <td><?php echo $data->announcement_details; ?></td>
                  <td><?php echo $data->date_from; ?></td>
                  <td><?php echo $data->date_to; ?></td>
                  <td><?php echo $data->file_name; ?></td>
                  <td><?php echo $data->table_name; ?></td>
                  <td>
                  <?php
                  if ($data->table_name == 'company') 
                  {
                    echo $data->company_name;
                  }
                  elseif ($data->table_name == 'section') {
                    echo $data->section_name;
                  }
                  elseif ($data->table_name == 'division') {
                    echo $data->division_name;
                  }
                  elseif ($data->table_name == 'department') {
                    echo $data->dept_name;
                  }
                  elseif ($data->table_name == 'subsection') {
                    echo $data->subsection_name;
                  }
                  ?>
                  </td>
                </tr>
              <?php
                 }
               }
               else
               {
              ?>
                <div class="alert alert-danger">
                  <?php echo $this->session->flashdata('filter_data'); ?>
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