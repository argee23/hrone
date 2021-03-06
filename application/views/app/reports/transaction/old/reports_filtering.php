
<br><ol class="breadcrumb">
                <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i><?php echo $transaction_name; ?> Summary Reports
            </ol><br> 
    <div class="col-md-12">
    <div class="col-md-1"></div>
    <div class="col-md-11">
      <input type="hidden" name="transaction_id" id="transaction_id" value='<?php echo $transaction_id?>'>
      <div class="col-md-12">
          <div class="col-md-3">Report :</div>
          <div class="col-md-6">        
            <select class="form-control" name="report_trans" id="report_trans" required>
              <option selected disabled value=""> Select Reports</option>
              <?php foreach ($report as $row) {?>
               <option value="<?php echo $row->report_transaction_id?>"><?php echo $row->report_name?></option>
              <?php } ?>
            </select><br>
          </div>
      </div> 

       <div class="col-md-12">
          <div class="col-md-3"> Type:</div>
          <div class="col-md-6">        
            <select class="form-control" name="type" id="type" required onchange="basis('type',this.value)">
              <option selected disabled value=""> Select Date Filed</option>
              <option value="single">Single Date</option>
              <option value="double">Date Range</option>
            </select><br>
          </div>
      </div>

      <div class="col-md-12" id="date_filter" style="display: none;">
          <div class="col-md-3"> Date:</div>
          <div class="col-md-2">        
            <select class="form-control" name="yy" id="yy" required onchange="year('type',this.value)">
              <option selected disabled value="">YY</option>
             <option>All</option>
             <option>2017</option>
             <option>2018</option>
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
      <div class="col-md-12">
          <div class="col-md-3">Company :</div>
          <div class="col-md-6">
            <select class="form-control" name="company" id="company" required onchange="result_onchange('division',this.value),refresh();">
              <option selected disabled value=""> Select Company</option>
               <?php foreach ($company as $row) {?>
               <option value="<?php echo $row->company_id?>"><?php echo $row->company_name?></option>
              <?php } ?>
            </select><br>
          </div>
      </div>
     
       <div class="col-md-12">
          <div class="col-md-3">Division :</div>
          <div class="col-md-6">
            <select class="form-control" name="division" id="division" required onchange="result_onchange('department',this.value)">
            <option selected value=""> Select Division</option>
            </select><br>
          </div>
      </div>

      <div class="col-md-12">
          <div class="col-md-3">Department :</div>
          <div class="col-md-6">
            <select class="form-control" name="department" id="department" required onchange="result_onchange('section',this.value)">
              <option selected value=""> Select Department</option>
            </select><br>
          </div>
      </div>

      <div class="col-md-12">
          <div class="col-md-3">Section :</div>
          <div class="col-md-6"> 
            <select class="form-control" name="section" id="section" required onchange="result_onchange('subsection',this.value)">
              <option selected value=""> Select Section</option>
            </select><br></div>
      </div>

       <div class="col-md-12">
          <div class="col-md-3">Sub Section :</div>
          <div class="col-md-6">
            <select class="form-control" name="sub_section" id="subsection" required onchange="result_onchange('location',this.value)">
              <option selected disabled value=""> Select Sub Section</option>
            </select><br></div>
      </div>

       <div class="col-md-12" id="location">
      </div>
      <div class="col-md-12" name="classification" id="classification">
      </div>
      <div class="col-md-12">
          <div class="col-md-3">Employment :</div>
          <div class="col-md-6">
              <?php foreach ($employment as $row) {
                echo "<input type='checkbox' class='employment' value='"."ee".$row->employment_id."' onchange='employment();'> ".$row->employment_name."<br>";
              }?>
              <br>
          </div>
      </div>

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
          <div class="col-md-7 pull-right"><button class="btn btn-success col-md-3" onclick="view_filter();">VIEW</button></div>
      </div>
     
    </div>
    </div>