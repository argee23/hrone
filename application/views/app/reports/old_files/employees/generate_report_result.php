<div class="col-md-12" style="margin-top: 40px;">

  <div class="col-md-12" style='overflow: scroll;'>

      <table class="table table-hover" id="results">
          <thead>
              <tr class="danger">
              <?php foreach($crystal_report as $c){?>
                  <th><?php echo $c->udf_label;?></th>
              <?php } ?>
              </tr>
          </thead>  
          <tbody>
            <?php foreach($result as $r){

              $age = $r->age;
              $date1 = $r->date_employed;;
              $date2 = date('Y-m-d');
              $ts1 = strtotime($date1);
              $ts2 = strtotime($date2);
              $year1 = date('Y', $ts1);
              $year2 = date('Y', $ts2);
              $month1 = date('m', $ts1);
              $month2 = date('m', $ts2);
              $months_employed = $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
              $value1 = $months_employed /12;

              $res=false;
              if($code=='E16')
              {
                if($from!='All')
                {
                    if($age <=$to AND $age >= $from)
                    {
                      $res=true;
                    }
                    else
                    {
                      $res=false;
                    }
                }
                else{ $res=true; }
              }
              else if($code=='E11')
              {
                  if($from!='All')
                  {
                    if($value1 <=$to AND $value1 >= $from)
                    {
                      $res=true;
                    }
                    else
                    {
                      $res=false;
                    }
                  }
                  else{  $res=true; }
              }
              else if($code=='E19')
              {
                  if($age_from!='All')
                  {
                      if($age <=$age_to AND $age >= $age_from)
                      {
                        $ageres=true;
                      }
                      else
                      {
                        $ageres=false;
                      }
                  }
                  else{ $ageres=true; }

                  if($yremp_from!='All')
                  {
                    if($value1 <=$yremp_to AND $value1 >= $yremp_from)
                    {
                      $yrres=true;
                    }
                    else
                    {
                      $yrres=false;
                    }
                  }
                  else {  $yrres=true; }

                  if($ageres==true AND $yrres==true)
                  {
                    $res = true;
                  } else { $res = false; }
                 
              }
              else
              {
                $res = true;
              }
              if($res==true){
            ?>

              <tr>
                <?php foreach($crystal_report as $c){?>

                  <td>
                      <?php 

                              $dd = $c->TextFieldName;

                              if($dd=='civil_status')
                              {
                                $value = $this->employee_reports_model->get_datas($r->civil_status);
                              }
                              else if($dd=='blood_type')
                              {
                                $value = $this->employee_reports_model->get_datas($r->blood_type);
                              }
                              else if($dd=='citizenship')
                              {
                                $value = $this->employee_reports_model->get_datas($r->citizenship);
                              }
                              else if($dd=='religion')
                              {
                                $value = $this->employee_reports_model->get_datas($r->religion);
                              }
                              else if($dd=='year_of_employment')
                              {
                                
                               
                                $value = number_format($value1,1)." Year/s <br>(".$months_employed.' Month/s'.")";


                              }
                              else if($dd=='permanent_province')
                              {
                                $value = $this->employee_reports_model->address('provinces',$r->permanent_province,'name');
                               
                              }
                              else if($dd=='permanent_city')
                              {
                                $value = $this->employee_reports_model->address('cities',$r->permanent_city,'city_name');
                                
                              }
                              else if($dd=='present_city')
                              {
                                $value = $this->employee_reports_model->address('cities',$r->present_city,'city_name');
                               
                              }
                              else if($dd=='present_province')
                              {
                                $value = $this->employee_reports_model->address('provinces',$r->present_province,'name');
                               
                              }
                              else 
                              {
                                $value =$r->$dd;
                              }

                              echo $value;

                            
                      ?>
                  </td>

                <?php } ?>
              </tr>

            <?php } } ?>
          </tbody>
      </table>

  </div>


</div>