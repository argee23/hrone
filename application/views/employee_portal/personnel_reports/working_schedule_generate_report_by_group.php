 <?php if($type=='plotted_sm'){?>

<div class="col-md-12" style="margin-top: 30px;">

      <div class="col-md-3 container">
        <div class="panel panel-body table-responsive">
              <h4><center>Group Member</center> </h4>
              <div class="box box-primary">
              
              <div class="box-header with-border">
              <h3 class="box-title"></h3>
              </div>
                <?php $i=1; foreach($groups_details as $gd){?>
                      <n><center><?php echo $i.".) ".$gd->fullname."(".$gd->employee_id.")";?></center></n><br>
                   <?php $i++;  }?>
               
                </div>
        </div>
      </div>

       <div class="col-md-9 container">
        <div class="panel panel-body table-responsive">
          <div class="box-header with-border">
                <h3 class="box-title"><center>Personnel Working Schedule</center></h3>
          </div>
          
          <div class="box-body">
            <table class="col-md-12 table table-bordered" id="table">
              <thead>
                <tr class="success">
                  <th>Date</th>
                  <th>Shift Category</th>
                  <th>Shift In</th>
                  <th>Shift Out</th>
                  <th>Date Plotted</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($details as $ddd) {?>
                  <tr>
                      <td><?php echo $ddd->date;?></td>
                      <td><?php echo $ddd->shift_category;?></td>
                      <td><?php if($ddd->shift_category=='rest day'){ echo "rest day"; } elseif($ddd->shift_category=='half day') { echo "half day"; }  else{  echo $ddd->shift_in; }?></td>
                      <td><?php if($ddd->shift_category=='rest day'){ echo "rest day"; } elseif($ddd->shift_category=='half day') { echo "half day"; }  else{  echo $ddd->shift_out; }?></td>
                      <td><?php echo $ddd->date_plotted;?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

</div>

 <?php } else{?>
<div class="col-md-12 container" style="margin-top: 30px;">
  <div class="panel panel-body table-responsive"><h4><center><b>Personnel Working Schedule</b></center></h4></div>
</div>
<?php $ii=0;  foreach($groups_details as $dd) {
     $details = $this->personnel_reports_model->ws_for_all_individual('individual',$forms_filter[1],$forms_filter[2],$forms_filter[3],$forms_filter[4],$forms_filter[5],$forms_filter[6],$forms_filter[7],$forms_filter[8],$dd->employee_id,$this->session->userdata('company_id'),$forms_filter[10],$forms_filter[11]);
     ?>
  <script type="text/javascript">
    $(function () {
         $('#table<?php echo $ii;?>').DataTable({
            "pageLength": -1,
            "pagingType" : "simple",
            "paging": true,
            lengthMenu: [[1,5, 10, 15, -1], [1,5, 10, 15, "All"]],
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "dom": '<"top">Bfrt<"bottom"li><"clear">',
            buttons:
              [
                {
                  extend: 'excel',
                  title: 'Personnel Working Schedule Report'
                },
                {
                  extend: 'print',
                  title: 'Personnel Working Schedule Report'
                }
              ]   
            });
          });
  </script>
     
<div class="col-md-12 container">
  <div class="panel panel-body table-responsive">
        <h4 class="text-danger"><u>Plotted Working Schedule for  <?php echo $dd->employee_id; ?></u></h4>
        <div class="box-header with-border">
              <div class="pull-right box-tools"> </div>
        </div>
        <div class="box-body">
          <table class="col-md-9 table table-hover" id="table<?php echo $ii;?>">
            <thead>
              <tr class="success">
                <?php foreach ($report_fields as $rf){ ?>
                  <th><?php echo $rf->title?></th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($details as $ddd) {?>
              <tr>
                  <?php foreach ($report_fields as $rf){ 
                      $ff = $rf->field;
                      $field=$ddd->$ff;
                  ?>
                  <td <?php if($ddd->group_id=='' || $ddd->group_id==0){ echo "class='text-info'"; } ?>><?php if($ff=='group_id') { if($ddd->group_id=='' || $ddd->group_id==0){ echo "individual plotting <br> (plotted by ".$ddd->plotter.")"; } 
                  else { echo $field; } } else{ echo $field; }  ?></td>
                  <?php } ?>
              </tr>
               <?php } ?>  
            </tbody>
          </table>
     </div>
  </div>
</div>


<?php $ii++; } }  ?>

<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
<script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script> 
    
  <script type="text/javascript">
                      $(function () {
                        $('#table').DataTable({
                          "pageLength": -1,
                          "pagingType" : "simple",
                          "paging": true,
                           lengthMenu: [[1,5, 10, 15, -1], [1,5, 10, 15, "All"]],
                          "lengthChange": true,
                          "searching": true,
                          "ordering": true,
                          "info": true,
                          "autoWidth": false,
                           "dom": '<"top">Bfrt<"bottom"li><"clear">',
                           buttons:
                            [
                              {
                                extend: 'excel',
                                title: 'Personnel Working Schedule'
                              },
                              {
                                extend: 'print',
                                title: 'Personnel Working Schedule'
                              }
                            ]   
                        });
                      });
                    </script>