 
<div class="col-md-12 container" style="margin-top: 30px;">
  <div class="panel panel-body table-responsive">
        <h4><center>Generate Report/s | Filtered by transaction</center></h4>
     
  </div>
</div>
</div>

<?php foreach($transactions as $trans){ 

                        $details=$this->personnel_reports_model->generate_report_forms_details($forms_filter[0],$forms_filter[1],$trans->t_table_name,$forms_filter[3],$forms_filter[4],$forms_filter[5],$forms_filter[6],$forms_filter[7],$forms_filter[8],$forms_filter[9],$forms_filter[10],$forms_filter[11]);
                        if(empty($details)){}
                        else{
                      ?>
  <script type="text/javascript">
                      $(function () {
                        $('#table<?php echo $trans->id.$trans->t_table_name;?>').DataTable({
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
                                title: 'Forms Report'
                              },
                              {
                                extend: 'print',
                                title: 'Forms Report'
                              }
                            ]   
                        });
                      });
  </script>

 <div class="col-md-12 container" style="margin-top: 10px;">
    <div class="panel panel-body table-responsive">
        <h4><?php echo $trans->form_name;?></h4>
            <div class="box-header with-border">
                 <h3 class="box-title"></h3>
                   <div class="pull-right box-tools"></div>
            </div>
            <div class="box-body">    
                <table class="col-md-9 table table-hover" id="table<?php echo $trans->id.$trans->t_table_name;?>">
                        <thead>
                          <tr class="success">
                               <?php foreach ($report_fields as $rf){ ?>
                                <th><?php echo $rf->title?></th>
                              <?php } ?>
                          </tr>
                        </thead>
                        <tbody>
                          <?php  foreach ($details as $ddd) {?>
                          <tr>
                             
                              <?php foreach ($report_fields as $rf){
                                      $ff = $rf->field;
                                   if($rf->field=='form_name'){ $field = $trans->form_name; } elseif($rf->field=='identification'){ $field = $trans->identification; } else{   $field = $ddd->$ff;  }
                                ?>
                                
                                    <td><?php if($ff=='doc_no'){?>
                                  <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $field; ?>/<?php echo $trans->t_table_name; ?>/<?php echo $trans->form_name; ?>" target="_blank"><?php echo $field; ?></a>
                               <?php }else{ echo $field; } ?></td>
                                <?php  }?>
                          </tr>
                          <?php }?>
                         </tbody>
                      </table>      
            </div>
    </div>
</div>
<?php } } ?>



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
    
