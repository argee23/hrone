 <?php
            $begin = new DateTime( $from );
            $end = new DateTime( $to );
            $end = $end->modify( '+1 day' );

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval ,$end);
            $eendd = new DateTime( $to);
            $diff = $eendd->diff($begin)->format("%a");
            $count_days = $diff + 1;
            $final = substr($fields, 0, -1);
            $final_fields =  explode('-', $final);

?>


<div class="col-md-12" style="padding-top: 40px;">
    <div class="box box-default">
      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result"><br>
                      <div class="col-md-12">
                        <!-- <button class="btn btn-success btn-sm pull-right" onclick="showFiltering();">CLICK TO FILTER</button> -->
                      </div>
                      <div class="col-md-12" id="myDIVFilter" style="display: none;margin-top: 10px;">
                        <div class="panel panel-default">
                          <div class="panel-heading" style="height: 120px;">
                             
                             <div class="col-md-4" style="margin-top: 10px;">
                                 <select class="form-control" id="fdepartment" onclick="get_department(this.value);">
                                  <option value="" selected disabled>Select Department</option>
                                  <!-- <option value="All">All</option> -->
                                  <?php foreach ($departmentList as $dept) {?>
                                      <option value="<?php echo $dept->department_id;?>"><?php echo $dept->dept_name;?></option>
                                  <?php } ?>
                                </select> 
                                <select class="form-control" style="margin-top: 5px;" id="flocation">
                                  <option value="" selected disabled>Select Location</option>
                                    <option value="All">All</option>
                                   <?php foreach ($locationList as $l) {?>
                                      <option value="<?php echo $l->location_id;?>"><?php echo $l->location_name;?></option>
                                  <?php } ?>
                              </select>  
                            </div>

                            <div class="col-md-4" style="margin-top: 10px;">
                              <select class="form-control" style="margin-top: 5px;" id="fsection"  onchange="get_subsection(this.value);">
                                    <option value="" selected disabled>Select Section</option>
                              </select>
                              <select class="form-control" style="margin-top: 5px;" id="fclassification">
                                  <option value="" selected disabled>Select Classification</option>
                                   <option value="All">All</option>
                                  <?php foreach ($classificationList as $cl) {?>
                                      <option value="<?php echo $cl->classification_id;?>"><?php echo $cl->classification;?></option>
                                  <?php } ?>
                              </select>

                                
                            </div>

                           <div class="col-md-4" style="margin-top: 10px;">
                              
                              <select class="form-control" style="margin-top: 5px;" id="fsubsection">
                                    <option value="" selected disabled>Select Subsection</option>
                              </select>
                              <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 5px;" onclick="get_filter_payroll_period_result('<?php echo $fields;?>','<?php echo $from;?>','<?php echo $to;?>','<?php echo $payroll_period;?>','<?php echo $group;?>');">FILTER</button>
                          </div>

                          </div>
                          <div class="col-md-12" style="margin-top: 5px;">
                           
                            <input type='hidden' name='final_report' id='final_report' value="1/" value="">
                            <input type='hidden' name='count' id='count' value="<?php echo count($fields);?>">
                          </div>
                        </div>
                    </div>
                
              <div class="col-md-12">
               <h3 class="text-danger">
                  <center>Working Schedules for Payroll Period
                    <?php 
                            $fmonth=substr($from, 5,2);
                            $fday=substr($from, 8,2);
                            $fyear=substr($from, 0,4);
                            $from_date = date("F", mktime(0, 0, 0, $fmonth, 10))." ". $fday.", ". $fyear;  

                            $tmonth=substr($to, 5,2);
                            $tday=substr($to, 8,2);
                            $tyear=substr($to, 0,4);
                            $to_date = date("F", mktime(0, 0, 0, $tmonth, 10))." ". $tday.", ". $tyear;
                            echo $from_date." to ".$to_date;

                            echo "<input type='hidden' id='title_report' value='".$from_date." to ".$to_date."'>";
                    ?>
                  </center>
                </h3>
              </div>
              <div class="col-md-12" style="margin-top:2px;overflow: scroll;width: 100%;" id="filter_div">
               
                <table class="table table-bordered" id="result">
                    <thead>
                       <tr style="background-color:#0080ff;color:white;">
                            <th rowspan="2">ID</th>
                            <?php foreach($final_fields as $ff){
                             $t = $this->reports_personnel_schedule_model->get_report_field($ff);
                            ?>
                               <th  rowspan="2" style="width: 10%;"><?php echo $t->title;?></th>
                            <?php
                            }
                              foreach($daterange as $date)
                              {
                                $datef = $date->format('Y-m-d');
                                $day =  date("D", strtotime($datef)); 
                                $tmonth= substr($datef, 5,2);
                                $tday=substr($datef, 8,2);
                                $m =  date("m", strtotime($datef));
                                echo "<th style='font-size:11px;width:100px;'><b><center>".$day."</center>";
                              }
                            ?>
                        </tr>

                       <tr style="background-color:#0080ff;color:white;">
                            <?php
                              foreach($daterange as $date)
                              {
                                $datef = $date->format('Y-m-d');
                                $day =  date("D", strtotime($datef)); 
                                $tmonth= substr($datef, 5,2);
                                $tday=substr($datef, 8,2);
                                $m =  date("m", strtotime($datef));
                                echo "<th style='font-size:11px;width:100px;font-size:15px;'><b><center>".$tday."</center></b></th>";
                              }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $i=1; foreach($employee_info as $emp)
                      {?>
                      <tr>
                        <td><?php echo $i;?></td>
                        <?php foreach($final_fields as $ff){
                             $t = $this->reports_personnel_schedule_model->get_report_field($ff);
                              $field_name= $t->field;
                        ?>
                               <td style="width: 10%;"><?php echo $emp->$field_name;?></td>
                        <?php
                        } 
                          foreach($daterange as $date)
                              {
                                $datef = $date->format('Y-m-d');
                                $day =  date("D", strtotime($datef)); 
                                $tmonth= substr($datef, 5,2);
                                $tday=substr($datef, 8,2);
                                $m =  date("m", strtotime($datef));
                                $mm = $date->format('m');
                                $yy = $date->format('Y');

                                $individual_schedules = $this->reports_personnel_schedule_model->get_individual_schedules($emp->employee_id,$datef,$mm,$yy);
                                if(!empty($individual_schedules))
                                {
                                  $schedule_result=$individual_schedules;
                                  $schedule_type="individual";
                                }
                                else
                                {
                                  $fixed_schedules = $this->reports_personnel_schedule_model->checker_if_fixed_sched($emp->employee_id,$datef);
                                  if(!empty($fixed_schedules))
                                  {
                                    $schedule_result=$fixed_schedules;
                                     $schedule_type="fixed";
                                  }
                                  else
                                  {
                                      $group_schedules = $this->reports_personnel_schedule_model->checker_if_group_sched($emp->employee_id,$datef);
                                      if(!empty($group_schedules))
                                      {
                                        $schedule_result=$group_schedules;
                                         $schedule_type="group";
                                      }
                                      else
                                      {
                                        $schedule_result="";
                                         $schedule_type="no_schedule";
                                      }
                                  }
                                }

                                if($option=='attendance' || $option=='all')  { $attendance = $this->reports_personnel_schedule_model->get_employee_attendance($emp->employee_id,$datef); }
                                else { $attendance ="";   }


                          ?>
                                
                              
                                   
                                        <?php if(!empty($schedule_result))
                                        {
                                          $schedule="";
                                          foreach($schedule_result as $sched)
                                          {
                                            if($schedule_type=='fixed')
                                            {
                                              $day  =  date("D", strtotime($datef)); 
                                              $day_ =  strtolower($day);
                                              if($day_=='restday'){  $schedule = 'restday'; } else {  $schedule = $sched->$day_; }
                                            }
                                            else
                                            {
                                               if($sched->restday==1)
                                                { $schedule = "restday"; } else{  $schedule=$sched->shift_in.' to '.$sched->shift_out; }
                                            }
                                           
                                          } 
                                        }
                                        else
                                        {
                                          $schedule ="";
                                        }

                                        if(empty($schedule)){ $color= "style='font-size:13px;background-color:#d8f0f3;'"; } else if($schedule=='restday'){ $color= "style='font-size:13px;background-color:#DAA520;'";  }else{ $color= "style='font-size:13px;'"; }
                                         echo "<td ".$color.">";

                                                if($option=='schedule' || $option=='all')  
                                                {
                                                  echo $schedule.'&nbsp;<br>';
                                                }   
                                                if($option=='attendance' || $option=='all')        
                                                  if(!empty($attendance)){ foreach($attendance as $a){ if(!empty($a->time_in)){ echo "<b>IN &nbsp;: </b> ".$a->time_in; } echo "<br>"; if(!empty($a->time_out)){ echo "<b>OUT :</b> ".$a->time_out; } } } else { }
                              
                                            ?>
                                                     
                                              </td
                                        ?>
                                        



                         <?php } ?>
                          </tr>
                      <?php $i++;   }  ?>

                    </tbody>
                </table>

              </div>

            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
<script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  

  <script type="text/javascript">
      $(function () {
        var title = document.getElementById('title_report').value;
        $("#result").DataTable({
          "dom": '<"top">Bfrt<"bottom"li><"clear">',
          "pageLength":-1,
          lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
          buttons:
            [
              {
                  extend: 'excel',
                  title: title
              },
              {
                  extend: 'print',
                  title: title
              }
            ]              
        });
      });

      function showFiltering() {
        var x = document.getElementById("myDIVFilter");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }


    function get_department(department)
    {
         if (window.XMLHttpRequest)
            {
            xmlhttp=new XMLHttpRequest();
            }
          else
            {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
          xmlhttp.onreadystatechange=function()
            {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
              { 
              document.getElementById("fsection").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/filter_department/"+department,true);
          xmlhttp.send();
    }


    function get_subsection(section)
    { 

         var department = document.getElementById('fdepartment').value;
          if (window.XMLHttpRequest)
            {
            xmlhttp=new XMLHttpRequest();
            }
          else
            {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
          xmlhttp.onreadystatechange=function()
            {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
              { 
              document.getElementById("fsubsection").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/filter_subsection/"+section+"/"+department,true);
          xmlhttp.send();
    }

    function get_filter_payroll_period_result(fields,from,to,payroll_period,group)
    {

          var department = document.getElementById('fdepartment').value;
          var section = document.getElementById('fsection').value;
          var subsection = document.getElementById('fsubsection').value;
          var location = document.getElementById('flocation').value;
          var classification = document.getElementById('fclassification').value;
         
          if(department=='' || section=='' || subsection=='' || classification=='' || location=='')
          {
            alert('Fill up all fields to continue');
          }
          else
          {
            alert(fields);
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                  document.getElementById("filter_div").innerHTML=xmlhttp.responseText;
                  $("#result").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/get_filter_payroll_period_result/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+fields+"/"+from+"/"+to+"/"+payroll_period+"/"+group,true);
            xmlhttp.send();
        }
    }
  </script>

