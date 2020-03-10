<div class="box box-success">
  <div class="panel panel-info">
    <div class="col-md-12"><br>
      <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Payroll System Default Policy</h4></ol>
        <div style="height:295px;">
          <div class="col-md-12">
            <div class="panel panel-success">
              <div class="panel-heading"><strong><center>System Default Policy List</strong></center>
               </div>
               <div class="panel-body" id="main_result">
                <table id="table_home" class="table table-hover table-striped">
                <thead>
                  <tr>
                     <th>Policy Title</th>
                    <th>Single Field</th>
                    <th>W/ Emp and Class</th>
                    <th>With Payroll Period</th>
                    <th>Input Type</th>
                    <th>Input Format</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($policy_list as $row){ ?>
                  <tr>
                    <td><?php echo $row->title?></td>
                    <td><?php if($row->single_field == '1'){ echo "yes"; } else{ echo "no"; }?></td>
                    <td><?php if($row->employment_classification =='1'){ echo "yes"; } else{ echo "no"; } ?></td>
                    <td><?php if($row->payroll_period =='1'){ echo "yes"; } else{ echo "no"; } ?></td>
                    <td><?php echo $row->input_type?></td>
                    <td><?php echo $row->input_format?></td>
                    <td> <a class='fa fa-<?php echo $system_defined_icons->icon_delete;?> pull-right' style='color:<?php echo $system_defined_icons->icon_delete_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to Delete Details' onclick='delete_policy(<?php echo $row->payroll_main_id?>)'></a>
                    </td>
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