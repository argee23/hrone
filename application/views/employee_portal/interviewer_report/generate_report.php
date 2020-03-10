<div class="col-md-12">

    <div class="col-md-3">


        <div class="col-md-12" style="margin-top: 10px;">
            <label>Interview Date Range</label><br>
            &nbsp;&nbsp;<input type="checkbox" id="daterangechecker" onclick="daterange();">&nbsp;All
            <input type="date" name="date_from" id="date_from" class="form-control">
            <n class="text-danger">&nbsp;Date From</n>
            <input type="date" name="date_to" id="date_to" class="form-control" style="margin-top: 5px;">
            <n class="text-danger">&nbsp;Date To</n>

            <input type="hidden" id="daterange" value="0">
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
        <label>Position</label>
          <select class="form-control" id="position" name="position">
              <option value="All">All</option>
               <?php foreach($position as $p){?>
                  <option value="<?php echo $p->position_id;?>"><?php echo $p->position_name;?></option>
              <?php } ?>
          </select>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
        <label>Interview Process</label>
          <select class="form-control" id="process" name="process">
              <option value="All">All</option>
              <?php foreach($process as $p){?>
                  <option value="<?php echo $p->interview_id;?>"><?php echo $p->title;?></option>
              <?php } ?>
          </select>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
        <label>Interview Result</label>
          <select class="form-control" id="result" name="result">
              <option value="All">All</option>
              <option value="passed">Passed</option>
              <option value="failed">Failed</option>
              <option value="not_attended">x</option>
          </select>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
        <label>Crystal Report</label>
          <select class="form-control" id="crystal_report" name="crystal_report">
          <?php if(empty($crystal_report)) { echo "<option value=''>No Crystal report found.</option>"; } else { 
            foreach($crystal_report as $cc){
                echo "<option value='".$cc->id."'>".$cc->title."</option>";
            } }?>
          </select>
        </div>


        <div class="col-md-12" style="margin-top: 10px;">
            <button class="col-md-12 btn btn-success btn-sm" onclick="filter_result();">FILTER</button>
        </div>
    </div>


    <div class="col-md-9" id="generate_results">
        <table class="table table-hover" id="generate_report_table">
            <thead>
                <tr class="danger">
                    <th>Interview Date</th>
                    <th>Interview Time</th>
                    <th>Interview Result</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>  
                </tr>
            </tbody>
        </table>
    </div>

</div>