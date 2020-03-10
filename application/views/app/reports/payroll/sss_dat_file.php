


            <div class="col-md-12">
              <div class="panel panel-danger">
                <div class="panel-heading">
                  <strong>
                 Generate SSS Dat File
                  </strong>
                </div>

                <div class="panel-body">
<?php
              foreach($companyList as $c){
               $pp_group=$this->report_time_model->checkCompPayPer($c->company_id);
              foreach($pp_group as $g){
echo '
<form class="form-horizontal" method="post" action="'.base_url().'app/reports_payroll/generate_sssDatFile" target="_blank">
';
            echo '<input type="hidden" name="company_sss_number" value="'.$c->sss_number.'">';
            echo '<input type="hidden" name="company_id" value="'.$c->company_id.'">';
            echo '<input type="hidden" name="company_name" value="'.$c->company_name.'">';
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
            <div class="col-md-12">Year</div>
            <div class="col-md-12">    
             <select class="form-control" name="covered_year" required>';
             foreach ($year_choicesList as $y) {
            echo ' <option value="'.$y->yy.'">'.$y->yy.'</option>';
             }
            echo ' </select>
            </div>
            </div> 

            <div class="col-md-12">
            <div class="col-md-12">Month</div>
            <div class="col-md-12">    
             <select class="form-control" name="covered_month" required>';
            		 $mm=1;
             while ($mm<=12) {
					//$mm = sprintf("%02d", $mm);
					$monthName = date('F', mktime(0, 0, 0, $mm, 10)); // March
            		echo ' <option value="'.$mm.'">'.$monthName.'</option>';
            		$mm++;
             }
            echo ' </select>
            </div>
            </div> 

            <div class="col-md-12">
            <div class="col-md-12">Report Result Type</div>
            <div class="col-md-12">    
              <input type="radio" name="report_result_type" value="text" > Text File 
              <input type="radio" name="report_result_type" value="dat" checked>  Dat File
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


                </div>
                </div>
                </div>