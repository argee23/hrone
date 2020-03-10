
    <table class="col-md-12 table table-hover" id="crystal_reports">
      <thead>
           <tr class="danger">
            <?php foreach($crystal as $c){?>
              <th><?php echo $c->udf_label;?></th>
            <?php } ?>
            </tr>
       </thead>
        <tbody>
          <?php foreach($reports as $r){

              $date1 = $r->date_employed;;
              $date2 = date('Y-m-d');

              $ts1 = strtotime($date1);
              $ts2 = strtotime($date2);

              $year1 = date('Y', $ts1);
              $year2 = date('Y', $ts2);

              $month1 = date('m', $ts1);
              $month2 = date('m', $ts2);

              $months_employed = $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
            

              ?>

            <tr>
            <?php foreach($crystal as $c){
               $cc = $c->TextFieldName;
              ?>
              <td>
                  <?php if($cc=='hours')
                    {
                      echo $data = $r->total_hours;
                    }
                    else if($cc=='date_and_time' )
                    {
                      $date_details = $this->training_seminar_request_reports_model->get_date_details($r->training_seminar_id);
                       $i=1;
                       foreach($date_details as $ddd)
                       {
                        echo $ddd->date."(".$ddd->time_from." to ".$ddd->time_to.")"."<br>";
                         $i++;
                       }

                    }
                    elseif($cc=='date')
                    {
                      $i=1;
                       foreach($date_details as $ddd)
                       {
                        echo $ddd->date."<br>";
                         $i++;
                       }
                    } 
                    elseif($cc=='time_from')
                    {
                       $i=1;
                       foreach($date_details as $ddd)
                       {
                        echo $ddd->time_from."<br>";
                        $i++;
                       }
                    }
                    elseif($cc=='time_to')
                    {
                       $i=1;
                       foreach($date_details as $ddd)
                       {
                        echo $ddd->time_to."<br>";
                        $i++;
                       }
                    } 
                    elseif($cc=='time_from_to')
                    {
                      $i=1;
                       foreach($date_details as $ddd)
                       {
                        echo $ddd->time_from." to ".$ddd->time_to."<br>";
                        $i++;
                       }
                    }
                    else if($cc=='months_employed')
                    {
                      echo $months_employed;
                    }
                    else if($cc=='employee_reponse')
                    {
                        if($r->stat==1){ echo "Accept"; }
                        else if($r->stat==0 AND !empty($r->date_respond)){ echo "Declined"; } else {  echo "No Reponse"; }
                    }

                    else{ echo $data = $r->$cc; }
                  ?>

              </td>
            <?php }  ?>
            </tr>

          <?php } ?>
       </tbody>
    </table>

