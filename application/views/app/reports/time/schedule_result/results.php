    <style type="text/css">
      .print{
          page-break-after: always;

      }
    </style>
    <ol class="breadcrumb">
                <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Time Summary Reports | Working Schedules
            </ol><br>
             <table id="print_table" class="table table-hover table-striped">
                <thead>
                  <tr>
                   <?php 
                   if(!empty($report_fields)){
                    foreach ($report_fields as $row){
                      echo '<th>'.$row->title.'</th>';
                    }
                   }else{
                    echo 'no result';
                   }
                   ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($details as $d){?>
                    <tr>
                        <?php 
                         if(!empty($report_fields)){
                          foreach ($report_fields as $row){

                             $field=$row->field_name;
                            
                             if($field=='shift_in')
                             {
                                if($d->restday==1){ $ddata= 'restday'; } else{ $ddata=$d->shift_in; }
                             }
                             else if($field=='shift_out')
                             {
                                if($d->restday==1){ $ddata= 'restday'; } else{ $ddata=$d->shift_out; }
                             }
                             else
                             {
                                $ddata= $d->$field;
                             }

                             echo "<td>".$ddata."</td>";
                          }
                         }else{
                          echo 'no result';
                         }
                        ?>
                    </tr>
                  <?php } ?>

                </tbody>
              </table>