<br>
<ol class="breadcrumb">
  <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>
  Generate "<?php if($val=='Deduction' || $val=='Addition') { echo "Other ".$val;}  else if($val=='Salary'){ echo "Salary Information"; } else{ echo $val; };?>" Report
  </h4>
</ol>
<div class="col-md-12" id="main_result">
<div class="col-md-12">
<?php if($val=='Salary'){?>
    <div class="col-md-12">
          
          <div class="col-md-3"></div>
          <div class="col-md-6">

            <div class="col-md-12">
            <select class="form-control" name="company" id="company" required>
              <option value="" disabled selected >Select Company</option>
                  <?php foreach($companyList as $c){?>
                        <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                  <?php } ?>
            </select>
            </div>
            <div class="col-md-12" style="margin-top: 5px;">
              <select class="form-control" name="option" id="option" required onchange="option_status(this.value);">
                <option value="" disabled selected >Select Option</option>
                <option value="All" style="color:red;">All</option>
                <option value="Upload">Manual Upload</option>
              </select>
            </div>
            <div class="col-md-12" style="margin-top: 5px;">
              <button class="col-md-12 btn btn-success" onclick="generate_report_salary('<?php echo $val;?>');">FILTER</button> 
            </div>

          </div>
          <div class="col-md-3"></div>
         
    </div>

<?php }
  else{?>
    <div class="col-md-6">
          <div class="col-md-12">
            <select class="form-control" name="company" id="company" required>
              <option value="" disabled selected >Select Company</option>
                  <?php foreach($companyList as $c){?>
                        <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                  <?php } ?>
            </select>
          </div>
          <div class="col-md-12" style="margin-top: 5px;">
              <select class="form-control" name="group" id="group" onchange="get_payroll_period(this.value);" required>
                <option value="" disabled selected >Select Group</option>
              </select>
          </div>
          <div class="col-md-12" style="margin-top: 5px;">
            <select class="form-control" name="option" id="option" required onchange="option_status(this.value);">
              <option value="" disabled selected >Select Option</option>
              <option value="All" style="color:red;">All</option>
              <option value="Upload">Manual Upload</option>
            </select>
          </div>
    </div>

    <div class="col-md-6">
          <div class="col-md-12">
            <select class="form-control" name="paytype" id="paytype" onchange="manual_ws_get_group(this.value);" required>
                <option value="" disabled selected >Select PayType</option>
                <?php foreach($paytypeList as $p){?>
                <option value="<?php echo $p->pay_type_id;?>"><?php echo $p->pay_type_name;?></option>
                  <?php } ?>
            </select>
          </div>
          <div class="col-md-12" style="margin-top: 5px;">
            <select class="form-control" name="payroll_period" id="payroll_period" required>
                <option value="" disabled selected >Select Payroll  Period</option>
            </select>
          </div>
          <div class="col-md-12" style="margin-top: 5px;">
            <button class="col-md-12 btn btn-success" onclick="generate_report_results('<?php echo $val;?>');">FILTER</button> 
          </div>
    <?php } ?>
    </div>
    <br><br><br><br><br><br><br><br>
    <div class="box box-danger" class='col-md-12'></div>

    <div class="col-md-12" id="results" style="overflow: scroll;">


    </div>

</div>
</div>
      