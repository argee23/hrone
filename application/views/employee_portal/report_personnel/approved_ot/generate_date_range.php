<form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>employee_portal/reports_personnel_approved_ot/generate_report_date_range/" target="_blank" >
   <div class="col-md-12">


    <div class="col-md-3"></div>
    <div class="col-md-6">
      
        <div class="col-md-12">
            <label>Date From</label>
            <input type="date" class="form-control" name="date_from" required value="<?php echo date('Y-m-d');?>">
        </div>

         <div class="col-md-12">
            <label>Date To</label>
            <input type="date" class="form-control" name="date_to" required value="<?php echo date('Y-m-d');?>">
        </div>


        <div class="col-md-12">
            <label>Crystal Report</label>
            <select class="form-control" id="crystal" name="crystal_report" required>
              <option disabled selected value="">Select Crystal Report</option>
              <option value="default">Default Report</option>
              <?php foreach($reports as $r){?>
                  <option value="<?php echo $r->p_id;?>"><?php echo $r->report_name;?></option>
              <?php } ?>
            </select>
        </div>

          <div class="col-md-12">
            <label>Crystal Option</label>
            <select class="form-control" name="option" id="option" required >
                      <option value="All">All</option>
                      <option value="plotted_only">Plotted/Filed Approved OT </option>
                       <option value="sm_plotted">Plotted/Filed By other managers</option>
                    </select><br>
        </div>

      

         <div class="col-md-12" style="margin-top: 20px;">
           <button type="submit" class="col-md-12 btn btn-success">GENERATE REPORT</button>
        </div>

    </div>
    <div class="col-md-3"></div>
<br><br><br>
</div>
</form>