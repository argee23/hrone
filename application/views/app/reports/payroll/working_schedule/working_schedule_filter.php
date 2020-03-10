<?php $topic_location=$this->uri->segment('4');

if($topic_location=="payroll_register"){

  $note_guide="Payroll Register";
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
<!-- //======== -->
<?php
              foreach($companyList as $c){
              //  echo "<span class='text-danger'>".$c->company_name."</span><br>";
               $pp_group=$this->report_time_model->checkCompPayPer($c->company_id);

              foreach($pp_group as $g){
                //echo $g->group_name."<br>";

echo '
<form class="form-horizontal" method="post" action="'.base_url().'app/reports_payroll/quick_click_generate/'.$topic_location.'" target="_blank">
';

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
              <input type="radio" name="report_result_type" value="excel" > Excel 
              <input type="radio" name="report_result_type" value="browser_view" checked>  Browser View    
            </div>
            </div> 

            <div class="col-md-12">
            <div class="col-md-12">Choose Payrol Period</div>
            <div class="col-md-12">    
            <select name="pay_period" class="form-control" required>
            ';
            if(!empty($pp)){
            foreach($pp as $pay_period){
              $df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
              $dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
              echo '<option value="'.$pay_period->id.'*'.$pay_period->month_cover.'">'.$df.' to '.$dt.'</option>';    
            }
            }else{
              echo '<option value="" disabled>warning : no payroll period created yet.</option>';  
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


echo '</form>';

                        }






              }// company list

?>
<!-- //======== -->

                        </div>
                      </div>
                </div>

                        <div class="tab-pane" id="time_w_filtering">
                             Updated Feature Soon to be released...
                         </div>

              </div>

        </div>

<?php
}else{// with filtering

?>
<input type="hidden" id="topic_location" value="<?php echo $topic_location?>">
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
              <?php 
                if($topic_location=="pagibig_group_rep"){
                  echo '<option value="1" class="text-danger">Pagibig Group Report</option>';
                }elseif($topic_location=="sss_group_rep"){
                  echo '<option value="1" class="text-danger">SSS Group Report</option>';
                }elseif($topic_location=="ph_group_rep"){
                  echo '<option value="1" class="text-danger">Philhealth Group Report</option>';
                }elseif($topic_location=="tax_deduction"){
                  echo '<option value="1" class="text-danger">Tax Group Report</option>';
                }elseif($topic_location=="pagibig_certificate"){
                  echo '<option value="1" class="text-danger">Pagibig Certificate</option>';
                }elseif($topic_location=="sss_certificate"){
                  echo '<option value="1" class="text-danger">SSS Certificate</option>';
                }elseif($topic_location=="ph_certificate"){
                  echo '<option value="1" class="text-danger">Philhealth Certificate</option>';
                }elseif($topic_location=="sss_transmittal"){
                  echo '<option value="1" class="text-danger">SSS Transmittal Report</option>';
                }elseif($topic_location=="sss_r3"){
                  echo '<option value="1" class="text-danger">R-3 (Contribution collection list)</option>';
                }elseif($topic_location=="pagibig_mcrf"){
                  echo '<option value="1" class="text-danger">Members Contribution Remittance Form (MCRF)</option>';
                }elseif($topic_location=="pagibig_mrrf"){
                  echo '<option value="1" class="text-danger">Membership Registration/Remittance Form</option>';
                }elseif($topic_location=="sss_r1"){
                  echo '<option value="1" class="text-danger">R-1A</option>';
                }elseif($topic_location=="bank_file_metrobank1" OR $topic_location=="bank_file_metrobank2" OR $topic_location=="bank_file_metrobank3"){
                  echo '<option value="metrobank_text" class="text-danger">Metrobank Text File</option>';
                  echo '<option value="metrobank_dat" class="text-danger">Metrobank Dat File</option>';
                }elseif($topic_location=="loan_report"){
                  echo '<option value="loan_report" class="text-danger">Loan Report</option>';
                }elseif($topic_location=="payslip_viewed"){
                  echo '<option value="payslip_viewed" class="text-danger">Payslip View/Acknowledge Report</option>';
                }else{

                }

                foreach ($report as $row) {?>
               <option value="<?php echo $row->report_id?>"><?php echo $row->report_name?></option>
              <?php } ?>
            </select><br>
          </div>
      </div> 
<?php
if($topic_location=="sss_r1"){
?>  
<div class="col-md-12">
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


       <div class="col-md-12" style="padding-top: 20px;" id="for_group_viewing">
          <div class="col-md-7 pull-right">
          <button class="btn btn-success col-md-3"  target="_blank" onclick="generate_sss_r1('<?php echo $this->uri->segment('4');?>');">VIEW</button>

          </div>
      </div>

<?php
}else{

?>
       <div class="col-md-12">
          <div class="col-md-3"> Type:</div>
          <div class="col-md-6">        
            <select class="form-control" name="type" id="type" required onchange="basis('type',this.value)">
              <option selected disabled value=""> Select</option>
              <?php 
              if($topic_location=="other_addition" OR $topic_location=="other_deduction" OR $topic_location=="late" OR $topic_location=="undertime" OR $topic_location=="overbreak" OR $topic_location=="absent" OR $topic_location=="overtime" OR $topic_location=="regular_nd" OR $topic_location=="pagibig" OR $topic_location=="sss" OR $topic_location=="philhealth" OR $topic_location=="payroll_register"){ //

                echo '<option value="by_month" class="text-danger">By Month</option>';
                echo '<option value="by_year" class="text-danger">By Year</option>';
                echo '<option value="single_pp" class="text-danger">Processed Payroll Period</option>';

              }elseif($topic_location=="pagibig_group_rep" OR $topic_location=="sss_group_rep" OR $topic_location=="ph_group_rep" OR $topic_location=="tax_deduction"){
                echo '<option value="group_by_month">Grouping Report By Month</option>';
                echo '<option value="group_by_year">Group Report By Year</option>';
              }elseif($topic_location=="pagibig_certificate" OR $topic_location=="sss_certificate" OR $topic_location=="ph_certificate" OR $topic_location=="sss_r3"){
                echo '<option value="by_year" class="text-danger">By Year</option>';
              }elseif($topic_location=="pagibig_mcrf" OR $topic_location=="pagibig_mrrf" OR $topic_location=="sss_transmittal"){
                echo '<option value="by_month" class="text-danger">By Month/Year</option>';
              }elseif($topic_location=="bank_file_metrobank1" OR $topic_location=="bank_file_metrobank2" OR $topic_location=="bank_file_metrobank3"){
                echo '<option value="single_pp" class="text-danger">Processed Payroll Period</option>';
              }elseif($topic_location=="loan_report"){
                echo '<option value="by_month" class="text-danger">By Month</option>';
                echo '<option value="by_year" class="text-danger">By Year</option>';
              }elseif($topic_location=="payslip_viewed"){
                echo '<option value="by_month" class="text-danger">By Month</option>';
                echo '<option value="single_pp" class="text-danger">Processed Payroll Period</option>';
              }else{

              }

              ?>

            </select><br>
          </div>
      </div>

      <div class="col-md-12" id="date_filter" style="display: none;">
          <div class="col-md-3"> Date:</div>
          <div class="col-md-2">        
            <select class="form-control" name="yy" id="yy" required onchange="year('type',this.value)">
              <option selected disabled value="">YY</option>
             <option>All</option>
             <?php foreach ($year as $row1) {?>
              <option><?php echo $row1->yy; ?></option>
            <?php }?>
            </select><br>
          </div>
          <div class="col-md-2">        
            <select class="form-control" name="mm" id="mm" required onchange="month('type',this.value)">
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
            <select class="form-control" name="dd" id="dd" required onchange="year('type',this.value)">
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
if($topic_location=="pagibig_group_rep" OR $topic_location=="sss_group_rep" OR $topic_location=="ph_group_rep" OR $topic_location=="tax_deduction"){
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
          

                    </select><br>                  
                </div>
          </div>
<?php



    echo ' <div style="display:none;" id="group_by_month_choices">
    <div class="col-md-12" id="group_by_month_choices" >
    <div class="col-md-3">Covered Month From</div>
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
    <div class="col-md-3">Covered Month To</div>
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
    <div class="col-md-3">Covered Year</div>
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

<?php
if($topic_location=="pagibig_mcrf" OR $topic_location=="pagibig_mrrf" OR $topic_location=="sss_transmittal" OR $topic_location=="philhealth" OR $topic_location=="sss" OR $topic_location=="pagibig"){

}elseif($topic_location=="bank_file_metrobank1" OR $topic_location=="bank_file_metrobank2" OR $topic_location=="bank_file_metrobank3"){
  if($topic_location=="bank_file_metrobank3"){
    $first_cc="(3020)";
    $second_cc='<div class="col-md-12">    
                <div class="col-md-3">Company Code Provided by Bank (3168)</div>
                <div class="col-md-6">              
                    <input type="text" class="form-control" required name="company_code2" id="bank_company_code_two">             
                </div>
      </div>';
  }else{
    $first_cc="";
    $second_cc="";
  }
echo '<div class="col-md-12">    
                <div class="col-md-3">Company Code Provided by Bank '.$first_cc.'</div>
                <div class="col-md-6">              
                    <input type="text" class="form-control" required name="company_code" id="bank_company_code">             
                </div>
      </div>
      '.$second_cc.'
      <div class="col-md-12">    
                <div class="col-md-3">Company(s) Depository Branch Code</div>
                <div class="col-md-6">              
                    <input type="text" class="form-control" required name="company_depository_code" id="bank_company_depository_code">             
                </div>
      </div>
      <div class="col-md-12">    
                <div class="col-md-3">Effectivity Date</div>
                <div class="col-md-6">              
                    <input type="date" class="form-control" required name="effectivity_date" id="bank_effectivity_date">             
                </div>
      </div>';


}elseif($topic_location=="sss_r3"){
echo '

      <div class="col-md-12">
          <div class="col-md-3">Quarter</div>
          <div class="col-md-6">        
            <select class="form-control" name="quarter" id="quarter" required>
              <option selected disabled value=""> Select Quarter</option>

              <option value="1">1st Quarter</option>
              <option value="2">2nd Quarter</option>
              <option value="3">3rd Quarter</option>
              <option value="4">4th Quarter</option>
              
            </select>
          </div>
      </div>
      <div class="col-md-12">
          <div class="col-md-3">Row Per Page</div>
          <div class="col-md-6">        
            <select class="form-control" name="page_row" id="page_row" required>
              <option selected disabled value=""> Select # of row(s) per page</option>
';

for ($i=5; $i<105; $i+=5) {
  echo '<option value="'.$i.'">'.$i.'</option>';
}

echo '
            </select>
          </div>
      </div>
';



}else{






?>
    <div class="col-md-12"  id="show_selected_emp">
      <label for="next" class="col-sm-3 control-label"><a type="button" class="" data-toggle="modal" data-target="#showEmployeeList"></a>Invidual Employee</label>
        <div class="col-sm-6" >
          <span id="hey" style="display: none;font-style: italic;color: #ff0000;">(Invidual employee processing is hidden as you have chosen to process via group) </span>
              <a data-toggle="modal" data-target="#showEmployeeList" id="ieh"><input type="text" id="selected_individual_employee_id" class="form-control col-sm-12" placeholder="For Individual Report Only : Click to Select Employee" onclick="disable_group_process()"></a>
        </div>
    </div>  

<?php


}

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
      <div class="col-md-12" id="def_employment">
          <div class="col-md-3">Employment :</div>
          <div class="col-md-6">
              <?php foreach ($employment as $row) {
                echo "<input type='checkbox' class='employment' checked value='"."ee".$row->employment_id."' onchange='employment();'> ".$row->employment_name."<br>";
              }?>
              <br>
          </div>
      </div>

<?php } ?>




      <div class="col-md-12" id="def_emp_status">
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

       <div class="col-md-12" style="padding-top: 20px;" id="for_group_viewing">
          <div class="col-md-7 pull-right">
          <button class="btn btn-success col-md-3"  onclick="view_filter('<?php echo $this->uri->segment('4');?>');">VIEW</button>

          </div>
      </div>
     

<?php
}
?>





    </div>
    </div>


    <?php

  }
    ?>