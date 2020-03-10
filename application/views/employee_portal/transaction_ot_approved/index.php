<br><br><br>
<div id="app" ng-app="myApp" ng-controller="appCtrl" ng-init='getTransactionList()' ngcloak>
<div class="col-sm-12">
      <div class="box box-solid box-default">
        <div class="box-header">
        <h4 class="box-title">Approved OT Filed by section managers</h4>
       </div>
        <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark"">
            
            <table class="table table-hover" id="approved_ot">
                <thead>
                    <tr class="danger">
                        <th>No</th>
                        <th>Date</th>
                        <th>Day</th>
                        <th>No of Hours</th>
                        <th>Reason</th>
                        <th>Date Filed</th>
                        <th>Filed By</th>
                    </tr> 
                </thead>

                <tbody>
                    <?php $i=1; foreach($approved_ot as $ot){?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td>
                            <?php 
                                $month=substr($ot->ot_date, 5,2);
                                $day=substr($ot->ot_date, 8,2);
                                $year=substr($ot->ot_date, 0,4);
                                $dayy =  date("D", strtotime($ot->ot_date));
                                echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year; 
                            ?>
                            
                        </td>
                        <td><?php echo $dayy;?></td>
                        <td><?php echo $ot->hours;?> hr/s</td>
                        <td><?php echo $ot->reason;?></td>
                        <td>
                            <?php 
                                $m=substr($ot->date_created, 5,2);
                                $d=substr($ot->date_created, 8,2);
                                $y=substr($ot->date_created, 0,4);
                                echo date("F", mktime(0, 0, 0, $m, 10))." ". $d.", ". $y; 
                            ?>
                              
                        </td>
                        <td><?php echo $ot->fullname;?></td>
                    </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>

        </div>
      </div>
</div>  
 <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>

    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
    <!--//==========End Js/bootstrap==============================//-->
<script type="text/javascript">
  
      $(function () {
        $('#approved_ot').DataTable({
          "pageLength": 50,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          lengthMenu: [[20, 25, 30, 35, 40, -1], [20, 25, 30, 35, 40, "All"]],
          dom: 'Blfrtip',
          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                  buttons: [
                      {
                        extend: 'excel',
                        title: 'timekeeping report'
                      },
                      {
                        extend: 'print',
                        title: 'timekeeping Report'
                      }
          ],
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

</script>