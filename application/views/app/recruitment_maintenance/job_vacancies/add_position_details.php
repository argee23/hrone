<?php if($checker > 0){ echo "<h4 class='text-danger'><center>Plantilla Job Position already exist<i class='fa fa-exclamation'></i></center></h4>"; } else{?>

<div class="col-md-6">

  <dt>Industry</dt>
  <dd>
    <select class="form-control" name="industry">
      <?php
        foreach ($job_specList as $job_specs){
                    echo "<option value='".$job_specs->param_id."'>".$job_specs->cValue."</option>";
         }
      ?>
    </select>
  </dd>
  <br>

  <dt>Job Description</dt>
  <dd>
    <textarea rows="4" class="form-control" name="job_description" id="job_description" placeholder="Job Description" ></textarea>
  </dd>
  <br>

  <dt>Salary</dt>
  <dd><input type="text" class="form-control" name="salary" id="salary" placeholder="Salary" ></dd>
  <br>

  <dt>Hiring Start</dt>
  <dd><input type="date" class="form-control" name="hiring_start" id="hiring_start" onchange="check_hiring();"></dd>
  <br>

  <dt>Location (Province)</dt>
  <dd>
    <select class="form-control" id="province" name="province"  onchange="get_city(this.value);">
      <option>Select Province</option>
                    <?php foreach($provinceList as $province){?>
                      <option value="<?php echo $province->id;?>"><?php echo $province->name;?></option>
                    <?php } ?>
      </select> 
               
  </dd>
  <br>

  <dt></dt>
  <dd>
    With target number of hired applicant on a specific date <br><input type="radio" name="a_d" id="targetyes" onclick="with_target(1);"> Yes &nbsp;&nbsp;&nbsp; <input type="radio" name="a_d" onclick="with_target(0);" id="targetno" checked> No 
  <input type="hidden" id="target_val" value="0">
  </dd>
  <br>

</div>


<div class="col-md-6">

  <dt>Years of Experience</dt>
  <dd>
    <input class="form-control" name="yrs_experience" id="yrs_experience" placeholder=" Years of Experience" >
  </dd>
  <br>

  <dt>Qualification</dt>
  <dd>
      <textarea rows="4" class="form-control" name="job_qualification" id="job_qualification" placeholder="Qualification" ></textarea>
  </dd>
  <br>

  <dt>Vacancy Slot</dt>
  <dd><input type="number" class="form-control" name="job_vacancy" id="job_vacancy" placeholder="Vacancy (slot)" ></dd>
  <br>

  <dt>Hiring Closed</dt>
  <dd><input type="date" class="form-control" name="hiring_end" id="hiring_end" onchange="check_hiring();"></dd>
  <br>

 
  <dt>Location (City)</dt>
  <dd>
  <select class="form-control" style="margin-top: 5px;" id="city" name="city" >
    <option>Select City</option>>
  </select>
  </dd>

  <br>

  <dt>Target Applicants</dt>
  <dd>
      <input type="text" class="form-control" name="target_applicant" id="target_applicant" placeholder="With target number of hired applicants" disabled>
  </dd>
  <br>
            
  <dt>Target Date</dt>
  <dd>
      <input type="date" class="form-control" name="target_date" id="target_date" disabled>
  </dd>
  <br>

</div>

<div class="col-md-12"><center><n id="with" style="display:none;" class="text-danger">Make sure to fill up the target applicants and target date <br><br></n></center></div>

<?php } ?>