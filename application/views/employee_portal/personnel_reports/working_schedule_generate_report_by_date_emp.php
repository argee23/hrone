
<div class="col-md-12 container" style="margin-top: 30px;">
  <div class="panel panel-body table-responsive">
        <h4><center><b>Personnel Working Schedules</b></center></h4>
  </div>
</div>
</div>
  <?php
  $dateslist = '';
  $ii=0; foreach($details as $dd){ 
    
      if(empty($details)){}
      else{

        if($type=='date')
        {
          $ed_value = $dd->date;
        }
        else
        {
          $ed_value = $dd->employee_id;
        }
       
        if(empty($dateslist))
        {   
           $dateslist.=$ed_value."/";
            $res = true;
        }
        else
        {
            $dd_date = $ed_value;
            $dateexplode =  explode('/',$dateslist);
           
            if (in_array($dd_date, $dateexplode)) {
                  $res = false;
            } else {
               
                $dateslist.=$ed_value."/";
                  $res = true;
                
            }
        }
        
        if($res==true)
        {

       

                if($type=='date')
                          {
                            $month=substr($dd->date, 5,2);
                            $day=substr($dd->date, 8,2);
                            $year=substr($dd->date, 0,4);

                            $details = $this->personnel_reports_model->ws_for_all_individual($forms_filter[0],$forms_filter[1],$dd->date,$dd->date,$forms_filter[4],$forms_filter[5],$forms_filter[6],$forms_filter[7],$forms_filter[8],$forms_filter[9],$this->session->userdata('company_id'),$forms_filter[10],$forms_filter[11]);
                            $title = 'Working Schedules dated: '.date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                          }
                else

                          {
                             $details = $this->personnel_reports_model->ws_for_all_individual('individual',$forms_filter[1],$forms_filter[2],$forms_filter[3],$forms_filter[4],$forms_filter[5],$forms_filter[6],$forms_filter[7],$forms_filter[8],$dd->employee_id,$this->session->userdata('company_id'),$forms_filter[10],$forms_filter[11]);

                             $title =  'Working Schedule of Employee id '.$dd->employee_id;
                          }

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
<div class="col-md-12 container" style="margin-top: 10px;">
  <div class="panel panel-body table-responsive">
    <h4 class="text-danger"><u> <?php echo $title; ?></u></h4>
          <div class="box-header with-border"></div>

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
                                       if($ff=='yy')
                                       {
                                        $year = date('', strtotime($ddd->date));
                                        $field = $year;
                                       }
                                       else if($ff=='mm')
                                       {
                                        $month = date('m', strtotime($ddd->date));
                                        $field = $month;
                                       }
                                       else if($ff=='dd')
                                       {
                                        $day = date('d', strtotime($ddd->date));
                                        $field = $day;
                                       }
                                       else if($ff=='date_plotted')
                                       {
                                          if($ddd->group_id==0 || empty($ddd->group_id)){ $field= $ddd->date_plotted; } else{ $field= $ddd->date_created; }
                                       }
                                       else
                                       {
                                        $field=$ddd->$ff;
                                       }
                                    ?>
                                        <td> <?php if($ff=='group_id'){ if($ddd->group_id==0 || empty($ddd->group_id)) { echo "individual plotting <br>(plotted by ".$ddd->plotter.")"; } else{ echo $field; } } else { echo $field; }?></td>
                                   <?php } ?>
                                </tr>
                              <?php } ?>                       
                         </tbody>
                      </table>
          </div>

        </div>
</div>
</div>

<?php $ii++; } } } ?>

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
    
