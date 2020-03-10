
<input type="hidden" id="vacancy_code" value="<?php echo $vacancy_code;?>">

<?php if($vacancy_code=='VR1'){ ?>

  
  <div id="job_vacancies_main_filtering">
    <div class="col-md-6">
          <div>
              <div class="col-md-12"><label>Company</label></div>
              <div class="col-md-12">
                <select class="form-control" name="company" id="company">
                    <option value="" selected disabled>Select Company</option>
                    <?php foreach($companyList as $comp){?>
                      <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                    <?php } ?>
                </select>
              </div>
          </div>

          <div class="col-md-12" style="margin-top:20px;"></div>
          <div>
              <div class="col-md-12"><label>Date Posted From</label></div>
              <div class="col-md-12">
                <input type="date" name="date_posted_from" id="date_posted_from" class="form-control" onchange="get_positions_by_date_range();">
              </div>
          </div>

          <div class="col-md-12" style="margin-top:20px;"></div>
          <div>
              <div class="col-md-12"><label>Positions</label></div>
              <div class="col-md-12">
                <select class="form-control" name="position" id="position">
                  
                </select>
              </div>
          </div>

          <div class="col-md-12" style="margin-top:20px;"></div>
          <div>
              <div class="col-md-12"><label>Slot Range</label></div>
              <div class="col-md-2"><center><input type="checkbox" id='slotrange' onclick='checker_range("slotrange","slot_range_from","slot_range_to");'>&nbsp;All</center></div>
              <div class="col-md-5"><input type="text" class="form-control" placeholder="Range From" id="slotrange_from"></div>
              <div class="col-md-5"><input type="text" class="form-control" placeholder="Range To" id="slotrange_to"></div>
          </div>

          <div class="col-md-12" style="margin-top:20px;"></div>
          <div>
              <div class="col-md-12"><label>Salary Range</label></div>
              <div class="col-md-2"><center><input type="checkbox" id='salaryrange' onclick='checker_range("salaryrange","salary_range_from","salary_range_to");'>&nbsp;All</center></div>
              <div class="col-md-5"><input type="text" class="form-control" placeholder="Range From" id="salary_range_from"></div>
              <div class="col-md-5"><input type="text" class="form-control" placeholder="Range To" id="salary_range_to"></div>
          </div>

          <div class="col-md-12" style="margin-top:20px;"></div>
          <div>
              <div class="col-md-12"><label>Location<i>(Province)</i></label></div>
              <div class="col-md-2"><center><input type="checkbox" id='locationn' onclick='checker_range("locationn","province","city");'>&nbsp;All</center></div>
              <div class="col-md-5">
                <select class="form-control" id="province" name="province" onchange="get_cities(this.value);">
                    <option value="" disabled selected>Select Province</option>
                    <?php foreach($provinceList as $p){?>
                        <option value="<?php echo $p->id;?>"><?php echo $p->name;?></option>
                    <?php } ?>
                </select>
              </div>
              <div class="col-md-5">
                <select class="form-control" id="city" name="city">
                    <option value="" selected disabled>Select City</option>
                </select>
              </div>
          </div>
    </div>

    <div class="col-md-6">
          
          <div>
              <div class="col-md-12"><label>Crystal Report</label></div>
              <div class="col-md-12">
                <select class="form-control" id="crystal_report" name="crystal_report">
                    <option value="" disabled selected>Select Crystal Report</option>
                    <?php if(empty($crystal_report))
                    {
                      echo "<option value='' disabled selected>No Crystal Report found.</option>";
                    }
                    else
                    {
                      foreach($crystal_report as $c)
                      {
                         echo "<option value='".$c->id."'>".$c->title."</option>";
                      }
                    }?>
                </select>
              </div>
          </div>

          <div class="col-md-12" style="margin-top:20px;"></div>
          <div>
              <div class="col-md-12"><label>Date Posted To</label></div>
              <div class="col-md-12">
                <input type="date" name="date_posted_to" id="date_posted_to" class="form-control" onchange="get_positions_by_date_range();">
              </div>
          </div>

          <div class="col-md-12" style="margin-top:20px;"></div>
          <div>
              <div class="col-md-12"><label>Status</label></div>
              <div class="col-md-12">
                <select class="form-control" id="status" name="status">
                    <option value="" disabled selected>Select Status</option>
                    <option value="all">All</option>
                    <option value="0">Close</option>
                    <option value="1">Open</option>
                </select>
              </div>
          </div>

          
          <div class="col-md-12" style="margin-top:20px;"></div>
          <div>
              <div class="col-md-12"><label>Hiring Start Range</label></div>
              <div class="col-md-2"><center><input type="checkbox" id='hiringstart' onclick='checker_range("hiringstart","hiring_start_from","hiring_start_to");'>&nbsp;All</center></div>
              <div class="col-md-5"><input type="date" class="form-control" placeholder="Date From" id="hiring_start_from"></div>
              <div class="col-md-5"><input type="date" class="form-control" placeholder="Date To" id="hiring_start_to"></div>
          </div>

          <div class="col-md-12" style="margin-top:20px;"></div>
          <div>
              <div class="col-md-12"><label>Hiring End Range</label></div>
              <div class="col-md-2"><center><input type="checkbox" id='hiringend' onclick='checker_range("hiringend","hiring_end_from","hiring_end_to");'>&nbsp;All</center></div>
              <div class="col-md-5"><input type="date" class="form-control" placeholder="Date From" id="hiring_end_from"></div>
              <div class="col-md-5"><input type="date" class="form-control" placeholder="Date To" id="hiring_end_to"></div>
          </div>

        
    </div>
    <div class="col-md-12" style="margin-bottom: 30px;margin-top: 30px;">
        <div class="col-md-12"><button class="col-md-12 btn-success" onclick="get_results_filtering_VR1('<?php echo $employer_type;?>','<?php echo $vacancy_code;?>');"> GENERATE REPORT</button></div>
    </div>
  </div>

  <div class="col-md-12" id="vr1_results">


  </div>

  
<?php } else if($vacancy_code=='VR2' || $vacancy_code=='VR5' || $vacancy_code=='VR6'){?>

  <div id="job_vacancies_applicants_filtering">
    <div class="col-md-12">
      <div class="col-md-2"></div>
      <div class="col-md-8">
              <div>
                  <div class="col-md-12"><label>Company</label></div>
                  <div class="col-md-12">
                    <select class="form-control" id="company" name="company">
                        <option value="" disabled selected>Select Company</option>
                        <?php foreach($companyList as $c)
                        {
                          echo "<option value='".$c->company_id."'>".$c->company_name."</option>";
                        }?>
                    </select>
                  </div>
              </div>  

              <div>
                  <div class="col-md-12"><label>Date Posted From</label></div>
                  <div class="col-md-12">
                    <input type="date" name="date_posted_from" id="date_posted_from" class="form-control" onchange="get_positions_by_date_range();">
                  </div>
              </div>

              <div>
                  <div class="col-md-12"><label>Date Posted To</label></div>
                  <div class="col-md-12">
                    <input type="date" name="date_posted_to" id="date_posted_to" class="form-control" onchange="get_positions_by_date_range();">
                  </div>
              </div>

              <div>
              <div class="col-md-12"><label>Crystal Report</label></div>
              <div class="col-md-12">
                <select class="form-control" id="crystal_report" name="crystal_report">
                    <option value="" disabled selected>Select Crystal Report</option>
                    <?php if(empty($crystal_report))
                    {
                      echo "<option value='' disabled selected>No Crystal Report found.</option>";
                    }
                    else
                    {
                      foreach($crystal_report as $c)
                      {
                         echo "<option value='".$c->id."'>".$c->title."</option>";
                      }
                    }?>
                </select>
              </div>
          </div>

              <div>
                  <div class="col-md-12"><label>Position</label></div>
                  <div class="col-md-12">
                    <select class="form-control" id="position" name="position">
                       
                    </select>
                  </div>
              </div>
              <div class="col-md-12" style="margin-bottom: 30px;margin-top: 30px;">
                  <button class="col-md-12 btn-success" onclick="get_results_filtering_VR2('<?php echo $employer_type;?>','<?php echo $vacancy_code;?>');"> GENERATE REPORT</button>
              </div>

      </div>
      <div class="col-md-2"></div>
    </div>

    <div class="col-md-12" id="vr2_results">


    </div>

  </div>

<?php } else if($vacancy_code=='VR3'){ ?>

  <div id="job_vacancies_date_posted_filtering">
    <div class="col-md-12">
      <div class="col-md-2"></div>
      <div class="col-md-8">
              <div>
                  <div class="col-md-12"><label>Company</label></div>
                  <div class="col-md-12">
                    <select class="form-control" id="company" name="company">
                        <option value="" disabled selected>Select Company</option>
                        <?php foreach($companyList as $c)
                        {
                          echo "<option value='".$c->company_id."'>".$c->company_name."</option>";
                        }?>
                    </select>
                  </div>
              </div>
              
              <div>
              <div class="col-md-12"><label>Crystal Report</label></div>
              <div class="col-md-12">
                <select class="form-control" id="crystal_report" name="crystal_report">
                    <option value="" disabled selected>Select Crystal Report</option>
                    <?php if(empty($crystal_report))
                    {
                      echo "<option value='' disabled selected>No Crystal Report found.</option>";
                    }
                    else
                    {
                      foreach($crystal_report as $c)
                      {
                         echo "<option value='".$c->id."'>".$c->title."</option>";
                      }
                    }?>
                </select>
              </div>
              </div>

               <div>
                  <div class="col-md-12"><label>Date Posted From</label></div>
                  <div class="col-md-12">
                    <input type="date" name="date_posted_from" id="date_posted_from" class="form-control" onchange="get_positions_by_date_range();">
                  </div>
              </div>

              <div>
                  <div class="col-md-12"><label>Date Posted To</label></div>
                  <div class="col-md-12">
                    <input type="date" name="date_posted_to" id="date_posted_to" class="form-control" onchange="get_positions_by_date_range();">
                  </div>
              </div>

              <div>
                  <div class="col-md-12"><label>Position</label></div>
                  <div class="col-md-12">
                    <select class="form-control" id="position" name="position">
                       
                    </select>
                  </div>
              </div>

              <div>
                  <div class="col-md-12"><label>Status</label></div>
                  <div class="col-md-12">
                    <select class="form-control" id="status" name="status">
                        <option selected disabled value="">Select Status</option>
                        <option value="all">All</option>
                        <option value="1">Open</option>
                        <option value="0">Close</option>
                    </select>
                  </div>
              </div>


              <div>
                    <div class="col-md-12" style="margin-bottom: 30px;margin-top: 30px;">
                  <button class="col-md-12 btn-success" onclick="get_results_filtering_VR3('<?php echo $employer_type;?>','<?php echo $vacancy_code;?>');"> GENERATE REPORT</button>
              </div>

      </div>
      <div class="col-md-2"></div>
    </div>

     <div class="col-md-12" id="vr3_results">


    </div>

  </div>

  <?php } else if($vacancy_code=='VR4'){?>

  <div id="job_vacancies_date_posted_filtering">
    <div class="col-md-12">
      <div class="col-md-2"></div>
      <div class="col-md-8">
              <div>
                  <div class="col-md-12"><label>Company</label></div>
                  <div class="col-md-12">
                    <select class="form-control" id="company" name="company">
                        <option value="" disabled selected>Select Company</option>
                        <?php foreach($companyList as $c)
                        {
                          echo "<option value='".$c->company_id."'>".$c->company_name."</option>";
                        }?>
                    </select>
                  </div>
              </div>
              
              <div>
              <div class="col-md-12"><label>Crystal Report</label></div>
              <div class="col-md-12">
                <select class="form-control" id="crystal_report" name="crystal_report">
                    <option value="" disabled selected>Select Crystal Report</option>
                    <?php if(empty($crystal_report))
                    {
                      echo "<option value='' disabled selected>No Crystal Report found.</option>";
                    }
                    else
                    {
                      foreach($crystal_report as $c)
                      {
                         echo "<option value='".$c->id."'>".$c->title."</option>";
                      }
                    }?>
                </select>
              </div>
              </div>

               <div>
                  <div class="col-md-12"><label>Date Posted From</label></div>
                  <div class="col-md-12">
                    <input type="date" name="date_posted_from" id="date_posted_from" class="form-control" onchange="get_positions_by_date_range();">
                  </div>
              </div>

              <div>
                  <div class="col-md-12"><label>Date Posted To</label></div>
                  <div class="col-md-12">
                    <input type="date" name="date_posted_to" id="date_posted_to" class="form-control" onchange="get_positions_by_date_range();">
                  </div>
              </div>

              <div>
                  <div class="col-md-12"><label>Position</label></div>
                  <div class="col-md-12">
                    <select class="form-control" id="position" name="position">
                       
                    </select>
                  </div>
              </div>

              <div>
                    <div class="col-md-12" style="margin-bottom: 30px;margin-top: 30px;">
                  <button class="col-md-12 btn-success" onclick="get_results_filtering_VR4('<?php echo $employer_type;?>','<?php echo $vacancy_code;?>');"> GENERATE REPORT</button>
              </div>

      </div>
      <div class="col-md-2"></div>
    </div>

     <div class="col-md-12" id="vr4_results">


    </div>

  </div>


  <?php } else if($vacancy_code=='VR7'){?>


    <div id="job_vacancies_date_posted_filtering">
    <div class="col-md-12">
      <div class="col-md-2"></div>
      <div class="col-md-8">
              <div>
                  <div class="col-md-12"><label>Company</label></div>
                  <div class="col-md-12">
                    <select class="form-control" id="company" name="company">
                        <option value="" disabled selected>Select Company</option>
                        <?php foreach($companyList as $c)
                        {
                          echo "<option value='".$c->company_id."'>".$c->company_name."</option>";
                        }?>
                    </select>
                  </div>
              </div>
              
              <div>
              <div class="col-md-12"><label>Crystal Report</label></div>
              <div class="col-md-12">
                <select class="form-control" id="crystal_report" name="crystal_report">
                    <option value="" disabled selected>Select Crystal Report</option>
                    <?php if(empty($crystal_report))
                    {
                      echo "<option value='' disabled selected>No Crystal Report found.</option>";
                    }
                    else
                    {
                      foreach($crystal_report as $c)
                      {
                         echo "<option value='".$c->id."'>".$c->title."</option>";
                      }
                    }?>
                </select>
              </div>
              </div>

               <div>
                  <div class="col-md-12"><label>Date Posted From</label></div>
                  <div class="col-md-12">
                    <input type="date" name="date_posted_from" id="date_posted_from" class="form-control" onchange="get_positions_by_date_range();">
                  </div>
              </div>

              <div>
                  <div class="col-md-12"><label>Date Posted To</label></div>
                  <div class="col-md-12">
                    <input type="date" name="date_posted_to" id="date_posted_to" class="form-control" onchange="get_positions_by_date_range();">
                  </div>
              </div>

              <div>
                  <div class="col-md-12"><label>Position</label></div>
                  <div class="col-md-12">
                    <select class="form-control" id="position" name="position">
                       
                    </select>
                  </div>
              </div>

              <div>
                  <div class="col-md-12"><label>Option</label></div>
                  <div class="col-md-12">
                    <select class="form-control" id="option" name="option">
                        <option selected disabled value="">Select Option</option>
                        <option value="not_meet">Not meet the target applicants</option>
                        <option value="meet">Meet the target applicant</option>
                        <option value="ongoing">Ongoing</option>
                    </select>
                  </div>
              </div>


              <div>
                    <div class="col-md-12" style="margin-bottom: 30px;margin-top: 30px;">
                  <button class="col-md-12 btn-success" onclick="get_results_filtering_VR7('<?php echo $employer_type;?>','<?php echo $vacancy_code;?>');"> GENERATE REPORT</button>
              </div>

      </div>
      <div class="col-md-2"></div>
    </div>

     <div class="col-md-12" id="vr7_results">


    </div>

  </div>




  <?php } else { ?>

  <div id="job_vacancies_adminverified_filtering" >
    <div class="col-md-12">
      <div class="col-md-2"></div>
      <div class="col-md-8">
              <div>
                  <div class="col-md-12"><label>Company</label></div>
                  <div class="col-md-12">
                     <select class="form-control" name="company" id="company">
                        <option value="" disabled selected>Select Company</option>
                        <?php foreach($companyList as $c)
                        {
                          echo "<option value='".$c->company_id."'>".$c->company_name."</option>";
                        }?>
                    </select>
                  </div>
              </div>
              
               <div>
                  <div class="col-md-12"><label>Date Created From</label></div>
                  <div class="col-md-12">
                    <input type="date" name="date_created_from" id="date_created_from" class="form-control" onchange="get_positions_by_date_range();">
                  </div>
              </div>

              <div>
                  <div class="col-md-12"><label>Date Created To</label></div>
                  <div class="col-md-12">
                    <input type="date" name="date_created_to" id="date_created_to" class="form-control" onchange="get_positions_by_date_range();">
                  </div>
              </div>

              <div>
              <div class="col-md-12"><label>Crystal Report</label></div>
              <div class="col-md-12">
                <select class="form-control" id="crystal_report" name="crystal_report">
                    <option value="" disabled selected>Select Crystal Report</option>
                    <?php if(empty($crystal_report))
                    {
                      echo "<option value='' disabled selected>No Crystal Report found.</option>";
                    }
                    else
                    {
                      foreach($crystal_report as $c)
                      {
                         echo "<option value='".$c->id."'>".$c->title."</option>";
                      }
                    }?>
                </select>
              </div>
              </div>

              <div>
              <div class="col-md-12"><label>Status</label></div>
              <div class="col-md-12">
                <select class="form-control" id="status" name="status">
                    <option value="" disabled selected>Select Status</option>
                    <option value="all">All</option>
                    <option value="1">Approved</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="rejected">Rejected</option>

                </select>
              </div>
              </div>

              
              <div class="col-md-12" style="margin-bottom: 30px;margin-top: 30px;">
                  <button class="col-md-12 btn-success" onclick="get_results_filtering_VR8('<?php echo $employer_type;?>','<?php echo $vacancy_code;?>');"> GENERATE REPORT</button>
              </div>
      </div>
      <div class="col-md-2"></div>
    </div>

     <div class="col-md-12" id="vr8_results">


    </div>

  </div>

<?php  } ?>