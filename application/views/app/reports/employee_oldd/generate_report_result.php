<div class="col-md-12" style="margin-top: 40px;">

  <div class="col-md-12" style='overflow: scroll;'>

  <?php if($viewing_option=='detailed'){
   
  ?>
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
             
               if($code=='E11')
               {

                if($yearoption=='active')
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
                else
                {
                  if($from=='All')
                  {
                    $date_employment = $this->employee_reports_model->get_date_of_employment($r->employee_id);
                    $date_employed_count = "";
                      foreach($date_employment as $d)
                      {
                          $get_date_resigned = $this->employee_reports_model->get_date_resigned($d->date_employed,$d->employee_id);
                          $date1 = $d->date_employed;
                          if(empty($get_date_resigned))
                            {
                              $date2 = date('Y-m-d');
                            }
                          else
                            {
                              $date2 = $get_date_resigned;
                            }

                            $ts1 = strtotime($date1);
                            $ts2 = strtotime($date2);
                            $year1 = date('Y', $ts1);
                            $year2 = date('Y', $ts2);
                            $month1 = date('m', $ts1);
                            $month2 = date('m', $ts2);
                            $months = $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
                            $year = $months /12;

                            $date_employed_count+=$months;
                      }
                      $year_count= $date_employed_count /12;
                      $months_count = $date_employed_count + 0;
                      $value = number_format($year_count,1)." Year/s<br>"."(".$months_count." Month/s)";

                    
                        if($value <=$to AND $value >= $from)
                        {
                          $res=true;
                        }
                        else
                        {
                          $res=false;
                        }
                   
                  }   
                  else { $res= true; } 
                }
                 
              }
              else if($code=='E19')
              { 
                  //age
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

                                else if($dd=='year_of_employment_all')
                              {
                                  $date_employment = $this->employee_reports_model->get_date_of_employment($r->employee_id);
                                  $date_employed_count = "";
                                  foreach($date_employment as $d)
                                  {
                                      $get_date_resigned = $this->employee_reports_model->get_date_resigned($d->date_employed,$d->employee_id);
                                      $date1 = $d->date_employed;
                                      if(empty($get_date_resigned))
                                      {
                                        $date2 = date('Y-m-d');
                                      }
                                      else
                                      {
                                        $date2 = $get_date_resigned;
                                      }
                                      $ts1 = strtotime($date1);
                                      $ts2 = strtotime($date2);
                                      $year1 = date('Y', $ts1);
                                      $year2 = date('Y', $ts2);
                                      $month1 = date('m', $ts1);
                                      $month2 = date('m', $ts2);
                                      $months = $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
                                      $year = $months /12;

                                      $date_employed_count+=$months;
                                  }
                                      $year_count= $date_employed_count /12;
                                      $months_count = $date_employed_count + 0;


                                      $value = number_format($year_count,1)." Year/s<br>"."(".$months_count." Month/s)";

                                 
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
  <?php } else{

    if($code=='E19'){ ?>

           <table class="table table-hover" id="results">
          <thead>
              <tr class="danger">
              <?php if($viewing_type=='company'){?>
                <th>Company ID</th>
                <th>Company Name</th>
              <?php  } else if($viewing_type=='division'){?>
                <th>Division ID</th>
                <th>Division Name</th>
              <?php  } else if($viewing_type=='department'){?>
                <th>Department ID</th>
                <th>Department Name</th>
              <?php } else if($viewing_type=='section'){?>
                <th>Section ID</th>
                <th>Section Name</th>
              <?php } else if($viewing_type=='subsection'){?>
                <th>Subsection ID</th>
                <th>Subsection Name</th>
              <?php } else if($viewing_type=='location'){?>
                <th>Location ID</th>
                <th>Location Name</th>
              <?php } else if($viewing_type=='classification'){?>
                <th>Classification ID</th>
                <th>Classification Name</th>
              <?php } else if($viewing_type=='employment'){?>
                <th>Employment ID</th>
                <th>Employment Name</th>
              <?php } else if($viewing_type=='taxcode'){?>
                <th>Taxcode ID</th>
                <th>Taxcode Name</th>
              <?php } else if($viewing_type=='civil_status'){ ?>
                <th>Civil Status ID</th>
                <th>Civil Status</th>
              <?php } else if($viewing_type=='gender'){?>
                <th>Gender ID</th>
                <th>Gender Name</th>
              <?php } else if($viewing_type=='position'){ ?>
                <th>Position ID</th>
                <th>Position Name</th>
              <?php } else if($viewing_type=='paytype'){?>
                <th>PayType ID</th>
                <th>Paytype Name</th>
              <?php } else if($viewing_type=='religion'){?>
                <th>Religion ID</th>
                <th>Religion Name</th>
              <?php } ?>
              <th>Count</th>
              
              </tr>
          </thead>  
          <tbody>
            <?php foreach($result as $r){
            ?>
              <tr>

               <?php if($viewing_type=='company'){?>
                <td><?php echo $r->company_id;?></td>
                <td><?php echo $r->company_name;?></td>

              <?php } else if($viewing_type=='division'){?>
                <td><?php echo $r->division_id;?></td>
                <td><?php echo $r->division_name;?></td>

              <?php } else if($viewing_type=='department'){?>
                <td><?php echo $r->department_id;?></td>
                <td><?php echo $r->dept_name;?></td>

              <?php } else if($viewing_type=='section'){?>
                <td><?php echo $r->section_id;?></td>
                <td><?php echo $r->section_name;?></td>

              <?php } else if($viewing_type=='subsection'){ ?>
                <td><?php echo $r->subsection_id;?></td>
                <td><?php echo $r->subsection_name;?></td>

              <?php } else if($viewing_type=='location'){?>
                <td><?php echo $r->location_id;?></td>
                <td><?php echo $r->location_name;?></td>

              <?php  } elseif($viewing_type=='classification'){?>
                <td><?php echo $r->classification_id;?></td>
                <td><?php echo $r->classification_name;?></td>

              <?php } else if($viewing_type=='employment'){?>
                <td><?php echo $r->employment_id;?></td>
                <td><?php echo $r->employment_name;?></td>

              <?php } else if($viewing_type=='taxcode'){?>
                <td><?php echo $r->taxcode_id;?></td>
                <td><?php echo $r->taxcode;?></td>

              <?php } else if($viewing_type=='civil_status'){?>
                <td><?php echo $r->civil_status_id;?></td>
                <td><?php echo $r->civil_status;?></td>

              <?php } else if($viewing_type=='gender'){?>
                <td><?php echo $r->gender_id;?></td>
                <td><?php echo $r->gender_name;?></td>

              <?php } else if($viewing_type=='position'){?>
                <td><?php echo $r->position_id;?></td>
                <td><?php echo $r->position_name;?></td>

              <?php } else if($viewing_type=='paytype'){?>
                <td><?php echo $r->pay_type_id;?></td>
                <td><?php echo $r->pay_type_name;?></td>

              <?php } else if($viewing_type=='religion'){?>
                <td><?php echo $r->param_id;?></td>
                <td><?php echo $r->cValue;?></td>
              <?php } ?>
                <td><?php echo $r->count;?></td>

              </tr>

            <?php } ?>
          </tbody>
      </table>

    <?php }  else{ ?>

         <table class="table table-hover" id="results">
          <thead>
              <tr class="danger">
              <?php if($code=='E1'){?>
                <th>Company ID</th>
                <th>Company Name</th>
              <?php  } else if($code=='E2'){?>
                <th>Division ID</th>
                <th>Division Name</th>
              <?php  } else if($code=='E3'){?>
                <th>Department ID</th>
                <th>Department Name</th>
              <?php } else if($code=='E4'){?>
                <th>Section ID</th>
                <th>section_id Name</th>
              <?php } else if($code=='E5'){?>
                <th>Subsection ID</th>
                <th>Subsection Name</th>
              <?php } else if($code=='E6'){?>
                <th>Location ID</th>
                <th>Location Name</th>
              <?php } else if($code=='E7'){?>
                <th>Classification ID</th>
                <th>Classification Name</th>
              <?php } else if($code=='E8'){?>
                <th>Employment ID</th>
                <th>Employment Name</th>
              <?php } else if($code=='E9'){?>
                <th>Taxcode ID</th>
                <th>Taxcode Name</th>
              <?php } else if($code=='E13'){ ?>
                <th>Civil Status ID</th>
                <th>Civil Status</th>
              <?php } else if($code=='E14'){?>
                <th>Gender ID</th>
                <th>Gender Name</th>
              <?php } else if($code=='E15'){ ?>
                <th>Position ID</th>
                <th>Position Name</th>
              <?php } else if($code=='E17'){?>
                <th>PayType ID</th>
                <th>Paytype Name</th>
              <?php } else if($code=='E18'){?>
                <th>Religion ID</th>
                <th>Religion Name</th>
              <?php } ?>
               <th>Count</th>
              
              </tr>
          </thead>  
          <tbody>
            <?php foreach($result as $r){
            ?>
              <tr>
               <?php if($code=='E1'){?>
                <td><?php echo $r->company_id;?></td>
                <td><?php echo $r->company_name;?></td>
              <?php } else if($code=='E2'){?>
                <td><?php echo $r->division_id;?></td>
                <td><?php echo $r->division_name;?></td>
              <?php } else if($code=='E3'){?>
                <td><?php echo $r->department_id;?></td>
                <td><?php echo $r->dept_name;?></td>
              <?php } else if($code=='E4'){?>
                <td><?php echo $r->section_id;?></td>
                <td><?php echo $r->section_name;?></td>
              <?php } else if($code=='E5'){ ?>
                <td><?php echo $r->subsection_id;?></td>
                <td><?php echo $r->subsection_name;?></td>
              <?php } else if($code=='E6'){?>
                <td><?php echo $r->location_id;?></td>
                <td><?php echo $r->location_name;?></td>
              <?php  } elseif($code=='E7'){?>
                <td><?php echo $r->classification_id;?></td>
                <td><?php echo $r->classification_name;?></td>
              <?php } else if($code=='E8'){?>
                <td><?php echo $r->employment_id;?></td>
                <td><?php echo $r->employment_name;?></td>
              <?php } else if($code=='E9'){?>
                <td><?php echo $r->taxcode_id;?></td>
                <td><?php echo $r->taxcode;?></td>
              <?php } else if($code=='E13'){?>
                <td><?php echo $r->civil_status_id;?></td>
                <td><?php echo $r->civil_status;?></td>
              <?php } else if($code=='E14'){?>
                <td><?php echo $r->gender_id;?></td>
                <td><?php echo $r->gender_name;?></td>
              <?php } else if($code=='E15'){?>
                <td><?php echo $r->position_id;?></td>
                <td><?php echo $r->position_name;?></td>
              <?php } else if($code=='E17'){?>
                <td><?php echo $r->pay_type_id;?></td>
                <td><?php echo $r->pay_type_name;?></td>
              <?php } else if($code=='E18'){?>
                <td><?php echo $r->param_id;?></td>
                <td><?php echo $r->cValue;?></td>
              <?php } ?>
              <td><?php echo $r->count;?></td>
              </tr>

            <?php } ?>
          </tbody>
      </table>

    <?php } ?>
    

  <?php } ?>
  </div>


</div>