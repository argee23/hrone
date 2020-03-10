<?php if($this->session->userdata('recruitment_employer_is_logged_in')){
    $employer_type = 'public';
  }else{
  $employer_type = 'hris';
  }

?>
      <div class="col-md-12">

          <?php if($code=='A1')
          {?>

              <form action="<?php echo base_url()?>app/report_recruitments/get_analytics_results/<?php echo $code;?>" method="post" id="get_employee_count" target="_blank">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <div class="col-md-12">

                  <div class="col-md-12">
                    <div class="col-md-12"><label>Company: </label></div>
                    <div class="col-md-12">
                      <select name="company" id="company" class="form-control" onchange="get_company_code1(this.value);" required>
                      <?php if($employer_type=='hris'){?>
                            <option value="All" style="color:red;">All Companies</option>
                            <option value="Multiple" style="color:red;">Multiple Selection</option>
                      <?php } else{}?>
                            <?php foreach ($companyList as $company){
                            ?>
                              <option value="<?php echo $company->company_id ?>"><?php echo $company->company_name ?></option>
                            <?php } ?>
                      </select>
                    </div>
                  </div>

                 <div class="col-md-12" id="multiplecompany" style="display: none;">
                    <div class="col-md-12"><label>Select Multiple Company: </label></div>
                     <div class="col-md-12">
                      <div class="col-md-12">
                        <?php $compm = ''; foreach($companyList as $c){
                          $dd = $c->company_id."-";
                          $compm .= $dd;
                        ?>
                          <input type="checkbox" class="multiple_company" value='<?php echo $c->company_id;?>' checked onclick='multiple_company_checker();'><?php echo $c->company_name."<br>";?>
                        <?php } echo "<input type='hidden' value='".$compm."' id='companymultiple_list' name='companymultiple_list'> <input type='hidden' id='companymultiple_count' value='".count($companyList)."'> "; ?>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Crystal Report</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="crystal_report" id="crystal_report">
                          <option value="" disabled selected>Select Crystal Report</option>
                          <option value="default">Default Crystal Report</option>
                          <?php foreach($crystal_report as $c){?>
                            <option value="<?php echo $c->id;?>"><?php echo $c->title;?></option>
                          <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Date Range Option</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="date_range_option" id="date_range_option">
                          <option value="date_posted">Date Posted</option>
                          <option value="hiring_start">Hiring Start</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Date Range From</label></div>
                      <div class="col-md-12">
                          <input type="date" class="form-control" name="date_from" id="date_from">
                      </div>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Date Range To</label></div>
                      <div class="col-md-12">
                          <input type="date" class="form-control" name="date_to" id="date_to">
                      </div>
                  </div>
                 
                  </div>
                   <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-12"><div class="col-md-12"><button type="submit" class="col-md-12 btn btn-success btn-sm" id='sbmt'>Save</button></div></div>
                  </div>

                </div>

                <div class="col-md-2"></div>
              <div class="col-md-4"></div>
              <div class="col-md-4"></div>

          <?php }

          else if($code=='A2' || $code=='A7' || $code=='A5'){?>

            <form action="<?php echo base_url()?>app/report_recruitments/get_analytics_results/<?php echo $code;?>" method="post" id="get_employee_count" target="_blank">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <div class="col-md-12">

                  <div class="col-md-12">
                    <label>Company: </label>
                    <select name="company" id="company" class="form-control" required>
                          <option value="" selected disabled>Select Company</option>                          
                          <?php foreach ($companyList as $company){
                          ?>
                            <option value="<?php echo $company->company_id ?>"><?php echo $company->company_name ?></option>
                          <?php } ?>
                    </select>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                      <label>Crystal Report</label>
                      <select class="form-control" name="crystal_report" id="crystal_report">
                          <option value="" disabled selected>Select Crystal Report</option>
                          <option value="default">Default Crystal Report</option>
                          <?php foreach($crystal_report as $c){?>
                            <option value="<?php echo $c->id;?>"><?php echo $c->title;?></option>
                          <?php } ?>
                      </select>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Date Range Option</label>
                    <select class="form-control" name="date_range_option" id="date_range_option" onchange="get_job_position_by_date();">
                          <option value="date_posted">Date Posted</option>
                          <option value="hiring_start">Hiring Start</option>
                    </select>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Date Range From</label>
                    <input type="date" class="form-control" name="date_from" id="date_from" onchange="get_job_position_by_date();">
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Date Range To</label>
                    <input type="date" class="form-control" name="date_to" id="date_to" onchange="get_job_position_by_date();">
                  </div>
                  

                  <div class="col-md-12" style="margin-top: 10px;">
                    <label>Company Job Position: </label>
                    <select name="position" id="position" class="form-control" required onchange="get_multiple_positions(this.value);">
                          <option value="" selected disabled>Select Position</option>                          
                    </select>
                  </div>

                   <div class="col-md-12" style="margin-top: 10px;" id="for_multiple_positions">
                   </div>

                   <div class="col-md-12" id="multipleposition" style="display: none;" >
                    <label>Select Multiple Position: </label><br>
                     <div class="col-md-12">
                    </div>
                  </div>

                 

                  </div>
                   <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-12"><button type="submit" class="col-md-12 btn btn-success btn-sm" id='sbmt'>Save</button></div>
                  </div>

                </div>

                <div class="col-md-2"></div>
                
              </form>

              <div class="col-md-4">
              </div>

              <div class="col-md-4">
              </div>


          <?php } else if($code=='A3'){  ?>


             <form action="<?php echo base_url()?>app/report_recruitments/get_analytics_results/<?php echo $code;?>" method="post" id="get_employee_count" target="_blank">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <div class="col-md-12">

                  <div class="col-md-12">
                    <label>Company: </label>
                    <select name="company" id="company" class="form-control" onchange="get_company_code1(this.value);" required>
                         
                          <?php foreach ($companyList as $company){

                          ?>
                            <option value="<?php echo $company->company_id ?>"><?php echo $company->company_name ?></option>
                          <?php } ?>
                    </select>
                  </div>

                   <div class="col-md-12" id="multiplecompany" style="display: none;">
                    <label>Select Multiple Company: </label><br>
                     <div class="col-md-12">
                    <?php $compm = ''; foreach($companyList as $c){
                      $dd = $c->company_id."-";
                      $compm .= $dd;
                    ?>
                      <input type="checkbox" class="multiple_company" value='<?php echo $c->company_id;?>' checked onclick='multiple_company_checker();'><?php echo $c->company_name."<br>";?>
                    <?php } echo "<input type='hidden' value='".$compm."' id='companymultiple_list' name='companymultiple_list'> <input type='hidden' id='companymultiple_count' value='".count($companyList)."'> "; ?>
                    </div>
                  </div>

                   <div class="col-md-12"  style="margin-top: 10px;">
                      <label>Crystal Report</label>
                      <select class="form-control" name="crystal_report" id="crystal_report">
                          <option value="" disabled selected>Select Crystal Report</option>
                          <option value="default">Default Crystal Report</option>
                          <?php foreach($crystal_report as $c){?>
                            <option value="<?php echo $c->id;?>"><?php echo $c->title;?></option>
                          <?php } ?>
                      </select>
                  </div>


                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Month From:</label>
                    <select class="form-control" name="month_from" id="month_from">
                      <option value="1">January</option>
                      <option value="2">February</option>
                      <option value="3">March</option>
                      <option value="4">April</option>
                      <option value="5">May</option>
                      <option value="6">June</option>
                      <option value="7">July</option>
                      <option value="8">August</option>
                      <option value="9">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                    </select>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Month To:</label>
                    <select class="form-control" name="month_to" id="month_to">
                      <option value="1">January</option>
                      <option value="2">February</option>
                      <option value="3">March</option>
                      <option value="4">April</option>
                      <option value="5">May</option>
                      <option value="6">June</option>
                      <option value="7">July</option>
                      <option value="8">August</option>
                      <option value="9">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                    </select>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Year:</label>
                    <select class="form-control" name="year" id="year">
                    <?php $year = date('Y'); for($i=2017;$i <= $year;$i++){?>
                      <option value="<?php echo $i;?>"><?php echo $i;?></option>
                    <?php } ?>
                    </select>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Based on Application Status</label>
                    <select class="form-control" name="application_status" id="application_status">
                      <option value="hired_status">Hired Status</option>
                      <option value="application_status">Based on Applciation Status Settings</option>
                    </select>
                  </div>

                 
                  </div>
                   <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-12"><button type="submit" class="col-md-12 btn btn-success btn-sm" id='sbmt'>Save</button></div>
                  </div>

                </div>

                <div class="col-md-2"></div>
                
              </form>

              <div class="col-md-4">
              </div>

              <div class="col-md-4">
              </div>


          <?php  } else if($code=='A4'){?>

             <form action="<?php echo base_url()?>app/report_recruitments/get_analytics_results/<?php echo $code;?>" method="post" id="get_employee_count" target="_blank">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <div class="col-md-12">

                  <div class="col-md-12">
                    <label>Company: </label>
                    <select name="company" id="company" class="form-control" onchange="get_company_code1(this.value);" required>
                    <?php if($employer_type=='hris'){?>
                          <option value="All" style="color:red;">All Companies</option>
                          <option value="Multiple" style="color:red;">Multiple Selection</option>
                    <?php } else{}?>
                          <?php foreach ($companyList as $company){

                          ?>
                            <option value="<?php echo $company->company_id ?>"><?php echo $company->company_name ?></option>
                          <?php } ?>
                    </select>
                  </div>

                   <div class="col-md-12" id="multiplecompany" style="display: none;">
                    <label>Select Multiple Company: </label><br>
                     <div class="col-md-12">
                    <?php $compm = ''; foreach($companyList as $c){
                      $dd = $c->company_id."-";
                      $compm .= $dd;
                    ?>
                      <input type="checkbox" class="multiple_company" value='<?php echo $c->company_id;?>' checked onclick='multiple_company_checker();'><?php echo $c->company_name."<br>";?>
                    <?php } echo "<input type='hidden' value='".$compm."' id='companymultiple_list' name='companymultiple_list'> <input type='hidden' id='companymultiple_count' value='".count($companyList)."'> "; ?>
                    </div>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                      <label>Crystal Report</label>
                      <select class="form-control" name="crystal_report" id="crystal_report">
                          <option value="" disabled selected>Select Crystal Report</option>
                          <option value="default">Default Crystal Report</option>
                          <?php foreach($crystal_report as $c){?>
                            <option value="<?php echo $c->id;?>"><?php echo $c->title;?></option>
                          <?php } ?>
                      </select>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Date:</label>
                    <input type="date" name="date" id="date" class="form-control" required> 
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Time:</label>
                    <input type="time" name="time" id="time" class="form-control" required> 
                  </div>

                 

                  </div>
                   <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-12"><button type="submit" class="col-md-12 btn btn-success btn-sm" id='sbmt'>Save</button></div>
                  </div>

                </div>

                <div class="col-md-2"></div>
                
              </form>

              <div class="col-md-4">
              </div>

              <div class="col-md-4">
              </div>


          <?php } else if($code=='A6' || $code=='A9'){?>

               <form action="<?php echo base_url()?>app/report_recruitments/get_analytics_results/<?php echo $code;?>" method="post" id="get_employee_count" target="_blank">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <div class="col-md-12">

                  <div class="col-md-12">
                    <label>Company: </label>
                    <select name="company" id="company" class="form-control" onchange="get_company_code1(this.value);" required>
                    <?php if($employer_type=='hris'){?>
                          <option value="All" style="color:red;">All Companies</option>
                          <option value="Multiple" style="color:red;">Multiple Selection</option>
                    <?php } else{}?>
                          <?php foreach ($companyList as $company){

                          ?>
                            <option value="<?php echo $company->company_id ?>"><?php echo $company->company_name ?></option>
                          <?php } ?>
                    </select>
                  </div>

                   <div class="col-md-12" id="multiplecompany" style="display: none;">
                    <label>Select Multiple Company: </label><br>
                     <div class="col-md-12">
                    <?php $compm = ''; foreach($companyList as $c){
                      $dd = $c->company_id."-";
                      $compm .= $dd;
                    ?>
                      <input type="checkbox" class="multiple_company" value='<?php echo $c->company_id;?>' checked onclick='multiple_company_checker();'><?php echo $c->company_name."<br>";?>
                    <?php } echo "<input type='hidden' value='".$compm."' id='companymultiple_list' name='companymultiple_list'> <input type='hidden' id='companymultiple_count' value='".count($companyList)."'> "; ?>
                    </div>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                      <label>Crystal Report</label>
                      <select class="form-control" name="crystal_report" id="crystal_report">
                          <option value="" disabled selected>Select Crystal Report</option>
                          <option value="default">Default Crystal Report</option>
                          <?php foreach($crystal_report as $c){?>
                            <option value="<?php echo $c->id;?>"><?php echo $c->title;?></option>
                          <?php } ?>
                      </select>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Date From<?php if($code=='A6'){ echo " (Date Applied)"; } else{ echo "(Date Posted)"; }?>:</label>
                    <input type="date" name="datefrom" id="datefrom" class="form-control" required> 
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Date To<?php if($code=='A6'){ echo " (Date Applied)"; } else{ echo "(Date Posted)"; }?>:</label>
                    <input type="date" name="dateto" id="dateto" class="form-control" required> 
                  </div>

                
                  </div>
                   <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-12"><button type="submit" class="col-md-12 btn btn-success btn-sm" id='sbmt'>Save</button></div>
                  </div>

                </div>

                <div class="col-md-2"></div>
                
              </form>

              <div class="col-md-4">
              </div>

              <div class="col-md-4">
              </div>


          <?php } else if($code=='A8'){ ?>

              <form action="<?php echo base_url()?>app/report_recruitments/get_analytics_results/<?php echo $code;?>" method="post" id="get_employee_count" target="_blank">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <div class="col-md-12">

                  <div class="col-md-12">
                    <label>Company: </label>
                    <select name="company" id="company" class="form-control" required onclick="get_company_employee_id(this.value);" required>
                          <option value="" selected disabled>Select Company</option>                          
                          <?php foreach ($companyList as $company){
                          ?>
                            <option value="<?php echo $company->company_id ?>"><?php echo $company->company_name ?></option>
                          <?php } ?>
                    </select>
                  </div>
                    
                    <div class="col-md-12"  style="margin-top: 10px;">
                      <label>Crystal Report</label>
                      <select class="form-control" name="crystal_report" id="crystal_report">
                          <option value="" disabled selected>Select Crystal Report</option>
                          <option value="default">Default Crystal Report</option>
                          <?php foreach($crystal_report as $c){?>
                            <option value="<?php echo $c->id;?>"><?php echo $c->title;?></option>
                          <?php } ?>
                      </select>
                  </div>

                   <div class="col-md-12" style="margin-top: 10px;">
                    <label>Employee id:</label>
                    <select class="form-control"  id="employee_id" name="employee_id">
                      <option value="" disabled selected>Select Employee</option>
                    </select>
                   </div>


                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Date From (date added):</label>
                    <input type="date" name="datefrom" id="datefrom" class="form-control" required> 
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Date To (date added):</label>
                    <input type="date" name="dateto" id="dateto" class="form-control" required> 
                  </div>


                  </div>
                   <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-12"><button type="submit" class="col-md-12 btn btn-success btn-sm" id='sbmt'>Save</button></div>
                  </div>

                </div>

                <div class="col-md-2"></div>
                
              </form>

              <div class="col-md-4">
              </div>

              <div class="col-md-4">
              </div>


          <?php } else if($code=='A9'){ ?>

             <form action="<?php echo base_url()?>app/report_analytics_recruitment/get_analytics_results/<?php echo $code;?>" method="post" id="get_employee_count" target="_blank">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <div class="col-md-12">

                  <div class="col-md-12">
                    <label>Company: </label>
                    <select name="company" id="company" class="form-control" onchange="get_company_code1(this.value);" required>
                    <?php if($employer_type=='hris'){?>
                          <option value="All" style="color:red;">All Companies</option>
                          <option value="Multiple" style="color:red;">Multiple Selection</option>
                    <?php } else{}?>
                          <?php foreach ($companyList as $company){

                          ?>
                            <option value="<?php echo $company->company_id ?>"><?php echo $company->company_name ?></option>
                          <?php } ?>
                    </select>
                  </div>

                   <div class="col-md-12" id="multiplecompany" style="display: none;">
                    <label>Select Multiple Company: </label><br>
                     <div class="col-md-12">
                    <?php $compm = ''; foreach($companyList as $c){
                      $dd = $c->company_id."-";
                      $compm .= $dd;
                    ?>
                      <input type="checkbox" class="multiple_company" value='<?php echo $c->company_id;?>' checked onclick='multiple_company_checker();'><?php echo $c->company_name."<br>";?>
                    <?php } echo "<input type='hidden' value='".$compm."' id='companymultiple_list' name='companymultiple_list'> <input type='hidden' id='companymultiple_count' value='".count($companyList)."'> "; ?>
                    </div>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Graph Type:</label>
                    <select class="form-control" name="graph" id="graph">
                        <option value="Bar">Bar Graph</option>
                        <option value="Line">Line Graph</option>
                        <option value="Area">Area Graph</option>
                    </select>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Color Code:</label>
                    <input type="color" name="color" id="color" class="form-control" required> 
                  </div>

                   <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Analytics Title:</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                  </div>


                  </div>
                   <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-12"><button type="submit" class="col-md-12 btn btn-success btn-sm" id='sbmt'>Save</button></div>
                  </div>

                </div>

                <div class="col-md-2"></div>
                
              </form>

              <div class="col-md-4">
              </div>

              <div class="col-md-4">
              </div>

          <?php  } else if($code=='A10'){?>

              <form action="<?php echo base_url()?>app/report_analytics_recruitment/get_analytics_results/<?php echo $code;?>" method="post" id="get_employee_count" target="_blank">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <div class="col-md-12">

                  <div class="col-md-12">
                    <label>Company: </label>
                    <select name="company" id="company" class="form-control" onchange="get_company_code1(this.value);" required>
                          <?php foreach ($companyList as $company){

                          ?>
                            <option value="<?php echo $company->company_id ?>"><?php echo $company->company_name ?></option>
                          <?php } ?>
                    </select>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Graph Type:</label>
                    <select class="form-control" name="graph" id="graph">
                        <option value="Bar">Bar Graph</option>
                        <option value="Line">Line Graph</option>
                        <option value="Area">Area Graph</option>
                    </select>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Color Code:</label>
                    <input type="color" name="color" id="color" class="form-control" required> 
                  </div>

                   <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Analytics Title:</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                  </div>


                  </div>
                   <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-12"><button type="submit" class="col-md-12 btn btn-success btn-sm" id='sbmt'>Save</button></div>
                  </div>

                </div>

                <div class="col-md-2"></div>
                
              </form>

              <div class="col-md-4">
              </div>

              <div class="col-md-4">
              </div>

          <?php } else if($code=='A11' || $code=='A13'){?>

           
            <form action="<?php echo base_url()?>app/report_analytics_recruitment/get_analytics_results/<?php echo $code;?>" method="post" id="get_employee_count" target="_blank">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <div class="col-md-12">

                  <div class="col-md-12">
                    <label>Company: </label>
                    <select name="company" id="company" class="form-control" required onclick="get_company_job_positions_a11(this.value);" required>
                          <option value="" selected disabled>Select Company</option>                          
                          <?php foreach ($companyList as $company){
                          ?>
                            <option value="<?php echo $company->company_id ?>"><?php echo $company->company_name ?></option>
                          <?php } ?>
                    </select>
                  </div>

                  <?php if($code=='A13'){?>
                     <div class="col-md-12"  style="margin-top: 10px;">
                      <input type="checkbox" name="interview_process" id="interview_process" value="1">
                      <label>Include Company Interview Process</label>
                    </div>

                  <?php } ?>
                  <div class="col-md-12" style="margin-top: 10px;">
                    <label>Position: </label>
                    <select name="position" id="position" class="form-control" required>
                          <option value="" selected disabled>Select Position</option>                          
                    </select>
                  </div>

                   <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Graph Type:</label>
                    <select class="form-control" name="graph" id="graph">
                        <option value="Bar">Bar Graph</option>
                        <option value="Line">Line Graph</option>
                        <option value="Area">Area Graph</option>
                    </select>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Color Code:</label>
                    <input type="color" name="color" id="color" class="form-control" required>
                  </div>

                   <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Analytics Title:</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                  </div>


                  </div>
                   <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-12"><button type="submit" class="col-md-12 btn btn-success btn-sm" id='sbmt'>Save</button></div>
                  </div>

                </div>

                <div class="col-md-2"></div>
                
              </form>

              <div class="col-md-4">
              </div>

              <div class="col-md-4">
              </div>

          <?php } else if($code=='A12'){ ?>


              <form action="<?php echo base_url()?>app/report_analytics_recruitment/get_analytics_results/<?php echo $code;?>" method="post" id="get_employee_count" target="_blank">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <div class="col-md-12">

                  <div class="col-md-12">
                    <label>Company: </label>
                    <select name="company" id="company" class="form-control" required onclick="get_company_job_positions_a11(this.value);" required>
                          <option value="" selected disabled>Select Company</option>                          
                          <?php foreach ($companyList as $company){
                          ?>
                            <option value="<?php echo $company->company_id ?>"><?php echo $company->company_name ?></option>
                          <?php } ?>
                    </select>
                  </div>

                   <div class="col-md-12"  style="margin-top: 10px;">
                    <input type="checkbox" name="interview_process" id="interview_process" value="1">
                    <label>Include Company Interview Process</label>
                  </div>


                   <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Graph Type:</label>
                    <select class="form-control" name="graph" id="graph">
                        <option value="Bar">Bar Graph</option>
                        <option value="Line">Line Graph</option>
                        <option value="Area">Area Graph</option>
                    </select>
                  </div>

                  <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Color Code:</label>
                    <input type="color" name="color" id="color" class="form-control" required>
                  </div>

                   <div class="col-md-12"  style="margin-top: 10px;">
                    <label>Analytics Title:</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                  </div>


                  </div>
                   <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-12"><button type="submit" class="col-md-12 btn btn-success btn-sm" id='sbmt'>Save</button></div>
                  </div>

                </div>

                <div class="col-md-2"></div>
                
              </form>

              <div class="col-md-4">
              </div>

              <div class="col-md-4">
              </div>


          <?php } ?>

      </div>
