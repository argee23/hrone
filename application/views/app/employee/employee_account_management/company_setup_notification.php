 <div class="box box-success">
  <div class="panel panel-info">
    <div class="col-md-12"><br>
      <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Account Management | <?php echo $title?></h4></ol>
            <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:295px;">
          <div class="col-md-12">
            <div class="panel panel-success">
               <div class="panel-body">
                    <table class="table table-hover table-striped" id='table_show_notif'>
                                <thead>
                                  <tr>
                                        <th>Company ID</th>
                                        <th>Company Name</th>
                                        <th>Company Settings</th>
                                        <th>Days to View Notifiaction</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php  foreach ($notif_setup as $row) {?>
                                    <tr>
                                         <td><?php echo $row->company_id?></td>
                                         <td><?php echo $row->company_name?></td>
                                         <td><?php if($row->action_option=='All'){ echo "View All New Hired Employees"; } elseif($row->action_option=='Multi'){ echo "View New hired employees in multiple companies"; } elseif($row->action_option=='One_emp'){ echo "View New Hired Employees based on chosen employment details";} else{ echo "View New Hired Employees based on employment details of the Logged in employee"; } ?></td>
                                         <td><?php echo $row->days_to_view?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                              </table>
                </div>
          </div>
        </div>
      </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>             
</div>               