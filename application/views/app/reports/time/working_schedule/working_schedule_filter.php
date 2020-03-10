<?php $topic_location=$this->uri->segment('4');

if($topic_location=="attendances" OR $topic_location=="late" OR $topic_location=="undertime" OR $topic_location=="overbreak" OR $topic_location=="absent" OR $topic_location=="regular_nd" OR $topic_location=="overtime" OR $topic_location=="time_summary"){

  if($topic_location=="attendances"){
    $note_guide="Attendance";
  }elseif($topic_location=="late"){
    $note_guide="Late";
  }elseif($topic_location=="undertime"){
    $note_guide="Undertime";
  }elseif($topic_location=="overbreak"){
    $note_guide="Overbreak";
  }elseif($topic_location=="absent"){
    $note_guide="Overbreak";
  }elseif($topic_location=="regular_nd"){
    $note_guide="Regular Night Differential";
  }elseif($topic_location=="overtime"){
    $note_guide="Overtime";
  }elseif($topic_location=="time_summary"){
    $note_guide="";
  }else{

  }
?>

         <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#time_quick_gen" data-toggle="tab"><i class="fa fa-file text-info"></i> Generate <?php echo $topic_location;?> <span class="text-danger">(Without Filtering)</span></a></li>
                      <li><a href="#time_w_filtering" data-toggle="tab"><i class="fa fa-folder text-warning"></i> Generate <?php echo $topic_location;?> <span class="text-info">(With Filtering)</span></a></li>
             
                    </ul>

              <div class="tab-content">
                <div class="active tab-pane" id="time_quick_gen">
                      <div class="box box-default">
                        <div class="box-body">
<?php
if($topic_location=="time_summary"){

            if($total_comp=="1"){
            ?>
<?php
            foreach($pp_group as $g){
?>
<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/reports_time/quick_generate_timesummary_report/<?php echo $topic_location;?>" target="_blank">

<?php
            $pay_type=$g->pay_type;
            $payroll_period_group_id=$g->payroll_period_group_id;

            echo '<input type="hidden" name="pay_type" value="'.$pay_type.'">';
            echo '<input type="hidden" name="payroll_period_group_id" value="'.$payroll_period_group_id.'">';

            $pp=$this->time_dtr_model->payroll_per_per_company_pay_type($t_company_id,$pay_type,$payroll_period_group_id);
            echo '



            <div class="col-md-6">
              <div class="panel panel-danger">
                <div class="panel-heading">
                  <strong>
                  '. $g->group_name.'
                  </strong>
                </div>

                <div class="panel-body">

            <div class="col-md-12">
            <div class="col-md-12">Report Type<small><i> ( Note: You must create a report fields contents at '.$note_guide.' Crystal Report. Those report types you created will be the choices in this area <i class="fa fa-arrow-right"></i> )</i> </small></div>
            <div class="col-md-12">    
             <select class="form-control" name="report" required>';
             foreach ($report as $row) {
            echo ' <option value="'.$row->report_id.'">'.$row->report_name.'</option>';
             }
            echo ' </select>
            </div>
            </div> 

            <div class="col-md-12">
            <div class="col-md-12">Report Result Type</div>
            <div class="col-md-12">    
            <input type="radio" name="report_result_type" value="excel" checked> Excel 
            <input type="radio" name="report_result_type" value="browser_view"> Browser View    
            </div>
            </div> 

            <div class="col-md-12">
            <div class="col-md-12">Choose Payrol Period</div>
            <div class="col-md-12">    
            <select name="pay_period" class="form-control" id="pay_period"  required >
            ';
            if(!empty($pp)){
            foreach($pp as $pay_period){
            $df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
            $dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
            echo '<option value="'.$pay_period->id.'">'.$df.' to '.$dt.'</option>';    
            }
            }else{
            echo '<option value="" disabled selected>warning : no payroll period created yet.</option>';  
            }
            echo '</select>
            </div>
            </div> 

            <div class="col-md-12">
            <div class="col-md-12">&nbsp;</div>
            <div class="col-md-12">
            <button type="submit" class="btn btn-danger"><i class="fa fa-arrow-right"></i> Generate </button>
            </div>
            </div>


                </div>
              </div>
            </div>



                      ';
?>
</form>
<?php
            }// end foreach group



            }else{


              foreach($companyList as $c){
               // echo "<span class='text-danger'>".$c->company_name."</span><br>";
              $pp_group=$this->report_time_model->checkCompPayPer($c->company_id);

echo '
<form class="form-horizontal" method="post" action="'.base_url().'app/reports_time/quick_generate_timesummary_report/'.$topic_location.'" target="_blank">
';

              foreach($pp_group as $g){
                //echo $g->group_name."<br>";

            echo '<input type="hidden" name="pay_type" value="'.$g->pay_type.'">';
            echo '<input type="hidden" name="payroll_period_group_id" value="'.$g->payroll_period_group_id.'">';

            $pp=$this->time_dtr_model->payroll_per_per_company_pay_type($c->company_id,$g->pay_type,$g->payroll_period_group_id);
            echo '



            <div class="col-md-6">
              <div class="panel panel-danger">
                <div class="panel-heading">
                  <strong>
                  '. $g->group_name.'
                  </strong>
                </div>

                <div class="panel-body">

            <div class="col-md-12">
            <div class="col-md-12">Report Type<small><i> ( Note: You must create a report fields contents at '.$note_guide.' Crystal Report. Those report types you created will be the choices in this area <i class="fa fa-arrow-right"></i> )</i> </small></div>
            <div class="col-md-12">    
             <select class="form-control" name="report" required>';
             foreach ($report as $row) {
            echo ' <option value="'.$row->report_id.'">'.$row->report_name.'</option>';
             }
            echo ' </select>
            </div>
            </div> 

            <div class="col-md-12">
            <div class="col-md-12">Report Result Type</div>
            <div class="col-md-12">    
            <input type="radio" name="report_result_type" value="excel" checked> Excel 
            <input type="radio" name="report_result_type" value="browser_view"> Browser View    
            </div>
            </div> 

            <div class="col-md-12">
            <div class="col-md-12">Choose Payrol Period</div>
            <div class="col-md-12">    
            <select name="pay_period" class="form-control" id="pay_period"  required >
            ';
            if(!empty($pp)){
            foreach($pp as $pay_period){
            $df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
            $dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
            echo '<option value="'.$pay_period->id.'">'.$df.' to '.$dt.'</option>';    
            }
            }else{
            echo '<option value="" disabled selected>warning : no payroll period created yet.</option>';  
            }
            echo '</select>
            </div>
            </div> 

            <div class="col-md-12">
            <div class="col-md-12">&nbsp;</div>
            <div class="col-md-12">
            <button type="submit" class="btn btn-danger"><i class="fa fa-arrow-right"></i> Generate </button>
            </div>
            </div>


                </div>
              </div>
            </div>



                      ';


                        }

echo '


            </form>
';




              }// company list
            }// multiple company


}else{
?>


  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/reports_time/quick_generate_time_report/<?php echo $topic_location;?>" target="_blank">
          <div class="col-md-12">
              <div class="col-md-3 bg-danger">Report Type<small><i> ( Note: You must create a report fields contents at '<?php echo $note_guide;?> Crystal Report'. Those report types you created will be the choices in this area <i class="fa fa-arrow-right"></i> )</i> </small></div>
              <div class="col-md-6">        
                <select class="form-control" name="report" required>
                  <?php foreach ($report as $row) {?>
                   <option value="<?php echo $row->report_id?>"><?php echo $row->report_name?></option>
                  <?php } ?>
                </select><br>
              </div>
          </div> 
          <div class="col-md-12">
          <div class="col-md-3">Company</div>
          <div class="col-md-6">
            <select class="form-control" name="company" required >
               <?php foreach ($companyList as $row) {?>
               <option value="<?php echo $row->company_id?>"><?php echo $row->company_name?></option>
              <?php } ?>
            </select><br>
          </div>
          </div>

        <div class="col-md-12">
          <div class="col-md-3">Date From and To</div>
          <div class="col-md-6">
            <input type="date" name="date_from" class="form-control" value="<?php echo date('Y-m-d')?>"><br>
          </div>
        </div>
        <div class="col-md-12">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <input type="date" name="date_to" class="form-control" value="<?php echo date('Y-m-d')?>"><br>
          </div>
        </div>



          <div class="col-md-12">
              <div class="col-md-3">Report Result Type</div>
              <div class="col-md-6">    
                <input type="radio" name="report_result_type" value="excel" checked> Excel 
                <input type="radio" name="report_result_type" value="browser_view"> Browser View    
              </div>
          </div> 
         <div class="col-md-12">
            <div class="col-md-3"></div>
            <div class="col-md-6"><button class="btn btn-success col-md-3"  target="_blank">GENERATE</button>
            </div>
        </div>

</form>
<?php  
}
?>


                        </div>

                      </div>
                </div>
                <div class="tab-pane" id="time_w_filtering">
                  Updated Feature Soon to be released...

                </div>



              </div>
          </div>

      </div>

      



<?php
}else{


?>

<br> <ol class="breadcrumb">
<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Time Summary Reports | <?php echo $topic_location;?></h4>
  </ol><br>
    <div class="col-md-12">
    <div class="col-md-1"></div>
    <div class="col-md-11">

      <div class="col-md-12">
          <div class="col-md-3">Report :</div>
          <div class="col-md-6">        
            <select class="form-control" name="report" id="report" required>
              <option selected disabled value=""> Select Reports</option>
              <?php foreach ($report as $row) {?>
               <option value="<?php echo $row->report_id?>"><?php echo $row->report_name?></option>
              <?php } ?>
            </select><br>
          </div>
      </div> 

       <div class="col-md-12">
          <div class="col-md-3"> Type:</div>
          <div class="col-md-6">        
            <select class="form-control" name="type" id="type" required onchange="basis('type',this.value)">
              <option selected disabled value=""> Select</option>
              <?php 
              if($topic_location=="time_summary"){
                
                echo '<option value="by_month">By Month</option>';
                echo '<option value="by_year">By Year</option>';
              echo '<option value="single_pp" class="text-danger">Processed Payroll Period</option>';
              }elseif($topic_location=="by_group_time_summary"){
                
                echo '<option value="group_by_month">Grouping Report By Month</option>';
                echo '<option value="group_by_year">Group Report By Year</option>';
                //echo '<option value="group_by_pp">Group Report By Payroll Period</option>';

              }else{

              ?>
                            <option value="single"
              <?php 
              if($topic_location=="late" OR $topic_location=="undertime"){ echo 'class="text-danger"';}else{ }
                  ?> >Single Date</option>
                            <option value="double"
              <?php 
              if($topic_location=="late" OR $topic_location=="undertime"){ echo 'class="text-danger"';}else{ }
                  ?> >Date Range</option>
              <option value="single_pp" class="text-danger">Processed Payroll Period</option>
              <?php
              }
              ?>
            </select><br>
          </div>
      </div>

      <div class="col-md-12" id="date_filter" style="display: none;">
          <div class="col-md-3"> Date:</div>
          <div class="col-md-2">        
            <select class="form-control" name="yy" id="yy" required> <!-- onchange="year('type',this.value)" -->
              <option selected disabled value="">YY</option>
             <option>All</option>
             <?php foreach ($year as $row1) {?>
              <option value="<?php echo $row1->yy;?>"><?php echo $row1->yy; ?></option>
            <?php }?>
            </select><br>
          </div>
          <div class="col-md-2">        
            <select class="form-control" name="mm" id="mm" required ><!-- onchange="month('type',this.value)" -->
             <option selected disabled value=""> MM</option>
             <option>All</option>
             <option value="01">January</option>
             <option value="02">February</option>
             <option value="03">March</option>
             <option value="04">April</option>
             <option value="05">May</option>
             <option value="06">June</option>
             <option value="07">July</option>
             <option value="08">August</option>
             <option value="09">September</option>
             <option value="10">October</option>
             <option value="11">November</option>
             <option value="12">December</option>
            </select><br>
          </div>
          <div class="col-md-2">        
            <select class="form-control" name="dd" id="dd" required ><!-- onchange="day('type',this.value)" -->
              <option selected disabled value=""> DD</option>
             <option>All</option>
             <?php   
            for ($x = 1; $x <= 31; $x++) {
              if($x==1 || $x==2|| $x==3 || $x==4 || $x==5 || $x==6 || $x==7 || $x==8 || $x==9)
              {
                echo "<option value='"."0".$x."'>".$x."</option>";
              } else{  echo "<option value='".$x."'>".$x."</option>"; }
              
            }
            ?>
            </select><br>
          </div>
      </div> 
<div id="filtered_double" style="display:none;">
            <div class="col-md-12">
                <div class="col-md-3">Date:</div>
                <div class="col-md-6">
                  <input type="date" id="date_from" class="form-control"><br>
                </div>
            </div>
              <div class="col-md-12">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                  <input type="date" id="date_to" class="form-control"><br>
                </div>
            </div>
</div>

<?php 
if($topic_location=="by_group_time_summary"){
?>
          <div class="col-md-12">    
                <div class="col-md-3">Groupings Type::</div>
                <div class="col-md-6">              
                    <select class="form-control" name="groupings_type" id="groupings_type" required >
                     <option selected disabled value=""> Select Groupings Type</option>
                     <option value="g_company">By Company</option>
                     <option value="g_location">By Location/Branch</option>
                     <option value="g_div">By Division</option>
                     <option value="g_dept">By Department</option>
                     <option value="g_sect">By Section</option>
                     <option value="g_subsect">By Sub Section</option>
                     <option value="g_employ">By Employment Status</option>
                     <option value="g_class">By Classification</option>

                    </select><br>                  
                </div>
          </div>
<?php



    echo ' <div style="display:none;" id="group_by_month_choices">
    <div class="col-md-12" id="group_by_month_choices" >
    <div class="col-md-3">DTR Covered Month From</div>
    <div class="col-md-6">
    <select class="form-control" name="covered_month_from" id="covered_month_from" required>
    <option selected disabled value=""> Select Month From</option>';
    for($m=1; $m<=12; ++$m){
    echo '<option value="'.sprintf("%02d", $m).'">'.date('F', mktime(0, 0, 0, $m, 1)).'</option>';
    }
    echo '</select><br>
    </div>
    </div>';

    echo '
    <div class="col-md-12">
    <div class="col-md-3">DTR Covered Month To</div>
    <div class="col-md-6">
    <select class="form-control" name="covered_month_to" id="covered_month_to" required>
    <option selected disabled value=""> Select Month To</option>';
    for($m=1; $m<=12; ++$m){
    echo '<option value="'.sprintf("%02d", $m).'">'.date('F', mktime(0, 0, 0, $m, 1)).'</option>';
    }
    echo '</select><br>
    </div>
    </div></div>';

    echo '<div style="display:none;" id="group_by_year_choices">
    <div class="col-md-12">
    <div class="col-md-3">DTR Covered Year</div>
    <div class="col-md-6">
    <select class="form-control" name="covered_year" id="covered_year" required>
    <option selected disabled value=""> Select Year</option>';  

    if(!empty($payroll_period_year)){
    foreach($payroll_period_year as $pp){    
    echo '<option value="'.$pp->year_cover.'">'.$pp->year_cover.'</option>';
    }
  }else{}
echo '</select><br>
</div>
</div> </div>';


}else{

?>
<div class="col-md-12" id="comp_default" >
          <div class="col-md-3">Company</div>
          <div class="col-md-6">
          <!-- onchange="result_onchange('division',this.value),refresh();" -->
            <select class="form-control" name="company" id="company" required onchange="result_onchange('division',this.value);" >
              <option selected disabled value=""> Select Company :</option>
               <?php foreach ($companyList as $row) {?>
               <option value="<?php echo $row->company_id?>"><?php echo $row->company_name?></option>
              <?php } ?>
            </select><br>
          </div>
 </div>

      <div class="col-md-12" id="class_loc">

      </div>


<div id="divi_2"> <!-- // -->
        
      
       <div class="col-md-12" >
          <div class="col-md-3">Division <i class="text-danger">(disregard if you do not have)</i>:</div>
          <div class="col-md-6" >
            <select class="form-control" name="division" id="division" required onchange="result_onchange('department',this.value),hide_sec_and_sub()";>
            <option selected value="All"> All</option>
            </select><br>
          </div>
      </div>


      <div class="col-md-12" >
          <div class="col-md-3">Department :</div>
          <div class="col-md-6">
            <select class="form-control" name="department" id="department" required onchange="result_onchange('section',this.value),hide_sub()"; >
              <option selected value="All"> All ORIG</option>
            </select><br>
          </div>
      </div>

<div id="hide_sec_on_div_change"> <!-- // -->
      <div class="col-md-12">
          <div class="col-md-3">Section :</div>
          <div class="col-md-6"> 
            <select class="form-control" name="section" id="section" required onchange="result_onchange('subsection',this.value),show_sub()">
              <option selected value="All"> All</option>
            </select><br></div>
      </div>

       <div class="col-md-12" id="hide_sub_on_dept_change">
          <div class="col-md-3">Sub-Section <i class="text-danger">(disregard if you do not have)</i>:</div>
          <div class="col-md-6">
            <select class="form-control" name="sub_section" id="subsection" required onchange="result_onchange('location',this.value)">
              <option selected disabled value="All"> All.</option>
            </select><br></div>
      </div>

</div>

</div>  <!-- // -->


       <div class="col-md-12" id="location">
      </div>
      <div class="col-md-12" name="classification" id="classification">
      </div>
      <div class="col-md-12">
          <div class="col-md-3">Employment :</div>
          <div class="col-md-6">
              <?php  foreach ($employment as $row) {
                echo "<input type='checkbox' class='employment' checked value='"."ee".$row->employment_id."' onchange='employment();'> ".$row->employment_name."<br>";
              } echo "<input type='hidden' value='".count($employment)."' id='total_employment'>"; ?>
              <br>
          </div>
      </div>

<?php } ?>

      <div class="col-md-12">
          <div class="col-md-3">Employee Status :</div>
          <div class="col-md-6">
            <select class="form-control" id="status">
              <option value='All'>All</option>
              <option value="0" selected>Active</option>
              <option value="1">InActive</option>
            </select>
           </div>
          </div>
      </div>








       <div class="col-md-12" style="padding-top: 20px;">
          <div class="col-md-7 pull-right"><button class="btn btn-success col-md-3"  target="_blank" onclick="view_filter('<?php echo $this->uri->segment('4');?>');">VIEW</button></div>
      </div>
     
    </div>
    </div>


    <?php
}

    ?>