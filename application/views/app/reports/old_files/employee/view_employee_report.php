    <div class="box box-success">
      <div class="box-header">
        <h3> Employee Summary Report </h3>
      </div>
        <div class="box-body">
          <table id="generateReport" class="table table-bordered table-striped">
            <thead>
              <tr>
                <?php
                if ($report_fields) {
                   foreach ($report_fields as $head) {
                 ?>
                    <th><?php echo $head->header?></th>
                   <?php 
                 }
                }  
               else
               {
              ?>
                <div class="alert alert-danger">
                  <?php echo $this->session->flashdata('message'); ?>
                </div>
              <?php
               }
              ?>
              </tr>
            </thead>
            <tbody>
              <?php if ($filter) {
                foreach($filter as $data){
               ?>
              <tr>
                <?php if ($filter) { foreach ($report_fields as $val) { $name = $val->table; ?>
                    <td><?php echo $data->$name; ?></td>
                   <?php } 
                 }  
               else
               {
              ?>
                <div class="alert alert-danger">
                  <?php echo $this->session->flashdata('message'); ?>
                </div>
              <?php
               }
              ?>
              </tr>
              <?php }
            } else
               {
              ?>
                <div class="alert alert-danger">
                  <?php echo $this->session->flashdata('message'); ?>
                </div>
              <?php
               }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    