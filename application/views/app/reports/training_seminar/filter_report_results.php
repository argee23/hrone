<table class="col-md-12 table table-hover" id="crystal_reports">
      <thead>
           <tr class="danger">
              <?php foreach($fields as $f){?>

                  <th><?php echo $f->udf_label;?></th>

              <?php } ?>
            </tr>
       </thead>
        <tbody>
        <?php 
            foreach($results as $r){
             if($others=='during')
             {
                $date_employed= $r->date_employed;
                if($date_employed <=$r->datefrom AND $date_employed <= $r->dateto)
                {
                  $res='true';
                } else{ $res='false'; }
             }
             else if($others=='before')
             {
                $date_employed= $r->date_employed;
                 if($r->datefrom < $date_employed AND $r->dateto < $date_employed)
                {
                  $res='true';
                } else{ $res='false'; }
             }
             else
             {
              $res='true';
             }
            if($res=='false'){}else{

              $date1 = $r->date_employed;;
              $date2 = date('Y-m-d');

              $ts1 = strtotime($date1);
              $ts2 = strtotime($date2);

              $year1 = date('Y', $ts1);
              $year2 = date('Y', $ts2);

              $month1 = date('m', $ts1);
              $month2 = date('m', $ts2);

              $months_employed = $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
              $date_employed = $r->date_employed;
              $monthsRequired = $r->monthsRequired;

             if($with_required_service_length=='ymeet')
             {
                if($months_employed >= $monthsRequired)
                {
                    $s ='true';
                }
                else
                {
                    $s ='false';
                }
             }    
             else if($with_required_service_length=='nmeet')
             {
                if($months_employed < $monthsRequired)
                {
                    $s ='true';
                }
                else
                {
                    $s ='false';
                }
             }
             else{ $s='true'; }
             if($s=='false') { } else{

          ?>
          <tr>
               <?php  foreach($fields as $u){ $ff= $u->TextFieldName; ?>

                <td> 
                  <?php 
                    $date_details = $this->training_seminar_reports_model->get_date_details($r->training_seminar_id);
                    if($ff=='hours')
                    {
                        $i=1;
                       foreach($date_details as $ddd)
                       {
                        echo $ddd->hours."<br>";
                         $i++;
                       }
                      
                     
                    }
                    else if($ff=='months_employed')
                    {
                       
                       echo $months_employed;

                    }
                    else if($ff=='date_and_time')
                    {
                       $i=1;
                       foreach($date_details as $ddd)
                       {
                        echo $ddd->date."(".$ddd->time_from." to ".$ddd->time_to.")"."<br>";
                         $i++;
                       }
                      
                    }
                    else if($ff=='date')
                    {
                       $i=1;
                       foreach($date_details as $ddd)
                       {
                        echo $ddd->date."<br>";
                        $i++;
                       }
                       
                    }
                    else if($ff=='time_from')
                    {
                       $i=1;
                       foreach($date_details as $ddd)
                       {
                        echo $ddd->time_from."<br>";
                        $i++;
                       }
                    }
                    else if($ff=='time_to')
                    {
                        $i=1;
                       foreach($date_details as $ddd)
                       {
                        echo $ddd->time_to."<br>";
                        $i++;
                       }
                    }
                    else if($ff=='time_from_to')
                    {
                        $i=1;
                       foreach($date_details as $ddd)
                       {
                        echo $ddd->time_from." to ".$ddd->time_to."<br>";
                        $i++;
                       }
                    }
                    else
                    {
                          echo $r->$ff;
                    }

                  ?>
                    
                </td> 


               <?php } ?>
          </tr>
        <?php } }  } ?>
       </tbody>
</table>