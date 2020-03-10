<?php if($application_code=='AR1')
{?>


<div id="job_vacancies_adminverified_filtering" >
    <div class="col-md-12">
      <div class="col-md-2"></div>
      <div class="col-md-8">
              <div>
                  <div class="col-md-12"><label>Company</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="company" name="company" onchange="get_application_status_details(this.value);">
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
                  <div class="col-md-12"><label>Position</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="position" name="position">
                       
                    </select>
                  </div>
              </div>

               <div>
                  <div class="col-md-12"><label>Application Status</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="application_status" name="application_status" onclick="view_interview_process(this.value);">
                       
                    </select>
                  </div>
              </div>

               <div style="display: none;" id="interview_id">
                  <div class="col-md-12"><label>Interview Process</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="application_interview_status" name="application_interview_status">
                       
                    </select>
                  </div>
              </div>

              <div style="margin-top: 20px;">
                  <div class="col-md-12"><label>Date Applied (Date Range)</label></div>
                  <div class="col-md-2"><center><input type="checkbox" id='hiringstart' onclick='checker_range("hiringstart","hiring_start_from","hiring_start_to");'>&nbsp;All</center></div>
                  <div class="col-md-5"><input type="date" class="form-control" placeholder="Date From" id="hiring_start_from"></div>
                  <div class="col-md-5"><input type="date" class="form-control" placeholder="Date To" id="hiring_start_to"></div>
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

              <div class="col-md-12" style="margin-bottom: 30px;margin-top: 30px;">
                  <button class="col-md-12 btn-success" onclick="get_application_filtering_results_VR1('<?php echo $application_code;?>','<?php echo $employer_type;?>')"> GENERATE REPORT</button>
              </div>
      </div>
      <div class="col-md-2"></div>
    </div>

    <div class="col-md-12" id="ar1_results">


    </div>
  </div>


<?php } else if($application_code=='AR2'){?>


  <div id="job_vacancies_adminverified_filtering" >
      <div class="col-md-12">
        <div class="col-md-2"></div>
        <div class="col-md-8">
                <div>
                  <div class="col-md-12"><label>Company</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="company" name="company" onchange="get_application_status_details(this.value);">
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
                  <div class="col-md-12"><label>Position</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="position" name="position">
                       
                    </select>
                  </div>
              </div>

              <div>
                  <div class="col-md-12"><label>Option</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="hiring_option" name="hiring_option">
                        <option value="setting">Based on setting (if include in counting hired applicants)</option>
                        <option value="hired">Hired Status</option>
                    </select>
                  </div>
              </div>

              <div style="margin-top: 20px;">
                    <div class="col-md-12"><label>Date Hired (Date Range)</label></div>
                    <div class="col-md-2"><center><input type="checkbox" id='hiringstart' onclick='checker_range("hiringstart","hiring_start_from","hiring_start_to");'>&nbsp;All</center></div>
                    <div class="col-md-5"><input type="date" class="form-control" placeholder="Date From" id="hiring_start_from"></div>
                    <div class="col-md-5"><input type="date" class="form-control" placeholder="Date To" id="hiring_start_to"></div>
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

                <div class="col-md-12" style="margin-bottom: 30px;margin-top: 30px;">
                    <button class="col-md-12 btn-success" onclick="get_application_filtering_results_VR2('<?php echo $application_code;?>','<?php echo $employer_type;?>')"> GENERATE REPORT</button>
                </div>
        </div>
        <div class="col-md-2"></div>
      </div>
       <div class="col-md-12" id="ar2_results">


    </div>
    </div>

<?php }  else if($application_code=='AR3'){?>
    
    <div id="job_vacancies_adminverified_filtering" >
      <div class="col-md-12">
        <div class="col-md-2"></div>
        <div class="col-md-8">
                 <div>
                  <div class="col-md-12"><label>Company</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="company" name="company" onchange="interview_status(this.value);">
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
                  <div class="col-md-12"><label>Position</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="position" name="position">
                       
                    </select>
                  </div>
              </div>

             <div  id="interview_id">
                  <div class="col-md-12"><label>Interview Process</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="application_interview_status" name="application_interview_status">
                       
                    </select>
                  </div>
              </div>

                <div style="margin-top: 20px;">
                    <div class="col-md-12"><label>Interview Date (Date Range)</label></div>
                    <div class="col-md-2"><center><input type="checkbox" id='hiringstart' onclick='checker_range("hiringstart","hiring_start_from","hiring_start_to");'>&nbsp;All</center></div>
                    <div class="col-md-5"><input type="date" class="form-control" placeholder="Date From" id="hiring_start_from"></div>
                    <div class="col-md-5"><input type="date" class="form-control" placeholder="Date To" id="hiring_start_to"></div>
                </div>

                <div style="margin-top: 20px;">
                    <div class="col-md-12"><label>Interview Time (Time Range)</label></div>
                    <div class="col-md-2"><center><input type="checkbox" id='timestart' onclick='checker_range("timestart","time_start_from","time_start_to");'>&nbsp;All</center></div>
                    <div class="col-md-5"><input type="time" class="form-control" placeholder="Time From" id="time_start_from"></div>
                    <div class="col-md-5"><input type="time" class="form-control" placeholder="Time To" id="time_start_to"></div>
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

                <div class="col-md-12" style="margin-bottom: 30px;margin-top: 30px;">
                    <button class="col-md-12 btn-success" onclick="get_application_filtering_results_VR3('<?php echo $application_code;?>','<?php echo $employer_type;?>')"> GENERATE REPORT</button>
                </div>
        </div>
        <div class="col-md-2"></div>
      </div>

      <div class="col-md-12" id="ar3_results">


      </div>
    </div>
    

  

<?php } else if($application_code=='AR4'){?>

   <div id="job_vacancies_adminverified_filtering" >
      <div class="col-md-12">
        <div class="col-md-2"></div>
        <div class="col-md-8">
                 <div>
                  <div class="col-md-12"><label>Company</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="company" name="company" onchange="get_employee_name_list(this.value);">
                        <option value="" disabled selected>Select Company</option>
                       
                        <?php foreach($companyList as $c)
                        {
                          echo "<option value='".$c->company_id."'>".$c->company_name."</option>";
                        }?>
                    </select>
                  </div>
              </div>
              
             <div  id="interview_id">
                  <div class="col-md-12"><label>Interview Process</label></div>
                  <div class="col-md-12">
                    <select class="form-control" id="application_interview_status" name="application_interview_status">
                    </select>
                  </div>
              </div>

             <div style="margin-top: 20px;">
                    <div class="col-md-12"><label>Interview Date (Date Range)</label></div>
                    <div class="col-md-2"><center><input type="checkbox" id='hiringstart' onclick='checker_range("hiringstart","hiring_start_from","hiring_start_to");'>&nbsp;All</center></div>
                    <div class="col-md-5"><input type="date" class="form-control" placeholder="Date From" id="hiring_start_from"></div>
                    <div class="col-md-5"><input type="date" class="form-control" placeholder="Date To" id="hiring_start_to"></div>
              </div>

                <div>
                <div class="col-md-12"><label>Employee Name</label></div>
                <div class="col-md-12">
                  <select class="form-control" id="employee_list" name="employee_list">
                      
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

                <div class="col-md-12" style="margin-bottom: 30px;margin-top: 30px;">
                    <button class="col-md-12 btn-success" onclick="get_application_filtering_results_VR4('<?php echo $application_code;?>','<?php echo $employer_type;?>')"> GENERATE REPORT</button>
                </div>
        </div>
        <div class="col-md-2"></div>
      </div>

      <div class="col-md-12" id="ar3_results">


      </div>
    </div>

<?php } else if($application_code=='AR5'){?>

   <div id="job_vacancies_adminverified_filtering" >
      <div class="col-md-12">
        <div class="col-md-2"></div>
        <div class="col-md-8">
                 <div>
                  <div class="col-md-12"><label>Company</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="company" name="company" onchange="get_employee_name_list(this.value);">
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
                  <div class="col-md-12"><label>Position</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="position" name="position">
                       
                    </select>
                  </div>
              </div>

               <div style="margin-top: 20px;">
                    <div class="col-md-12"><label>Date Applied</label></div>
                    <div class="col-md-2"><center><input type="checkbox" id='appliedstart' onclick='checker_range("appliedstart","applied_start_from","applied_start_to");'>&nbsp;All</center></div>
                    <div class="col-md-5"><input type="date" class="form-control" placeholder="Date From" id="applied_start_from"></div>
                    <div class="col-md-5"><input type="date" class="form-control" placeholder="Date To" id="applied_start_to"></div>
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

                <div class="col-md-12" style="margin-bottom: 30px;margin-top: 30px;">
                    <button class="col-md-12 btn-success" onclick="get_application_filtering_results_VR5('<?php echo $application_code;?>','<?php echo $employer_type;?>')"> GENERATE REPORT</button>
                </div>
        </div>
        <div class="col-md-2"></div>
      </div>

      <div class="col-md-12" id="ar5_results">


      </div>
    </div>

<?php } else if($application_code=='AR6'){?>

  <div id="job_vacancies_adminverified_filtering" >
      <div class="col-md-12">
        <div class="col-md-2"></div>
        <div class="col-md-8">
                 <div>
                  <div class="col-md-12"><label>Company</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="company" name="company" onchange="get_employee_name_list(this.value);">
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
                  <div class="col-md-12"><label>Position</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="position" name="position">
                       
                    </select>
                  </div>
              </div>

               <div style="margin-top: 20px;">
                    <div class="col-md-12"><label>Date Blocked</label></div>
                    <div class="col-md-2"><center><input type="checkbox" id='blockedstart' onclick='checker_range("blockedstart","blocked_start_from","blocked_start_to");'>&nbsp;All</center></div>
                    <div class="col-md-5"><input type="date" class="form-control" placeholder="Date From" id="blocked_start_from"></div>
                    <div class="col-md-5"><input type="date" class="form-control" placeholder="Date To" id="blocked_start_to"></div>
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

                <div class="col-md-12" style="margin-bottom: 30px;margin-top: 30px;">
                    <button class="col-md-12 btn-success" onclick="get_application_filtering_results_VR6('<?php echo $application_code;?>','<?php echo $employer_type;?>')"> GENERATE REPORT</button>
                </div>
        </div>
        <div class="col-md-2"></div>
      </div>

      <div class="col-md-12" id="ar6_results">


      </div>
    </div>

<?php } else if($application_code=='AR7'){?>

  <div id="job_vacancies_adminverified_filtering" >
      <div class="col-md-12">
        <div class="col-md-2"></div>
        <div class="col-md-8">
                 <div>
                  <div class="col-md-12"><label>Company</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="company" name="company" onchange="get_employee_name_list(this.value);">
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
                  <div class="col-md-12"><label>Position</label></div>
                  <div class="col-md-12">
                     <select class="form-control" id="position" name="position">
                       
                    </select>
                  </div>
              </div>

               <div style="margin-top: 20px;">
                    <div class="col-md-12"><label>Date Hired</label></div>
                    <div class="col-md-2"><center><input type="checkbox" id='hiredstart' onclick='checker_range("hiredstart","hired_start_from","hired_start_to");'>&nbsp;All</center></div>
                    <div class="col-md-5"><input type="date" class="form-control" placeholder="Date From" id="hired_start_from"></div>
                    <div class="col-md-5"><input type="date" class="form-control" placeholder="Date To" id="hired_start_to"></div>
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

                <div class="col-md-12" style="margin-bottom: 30px;margin-top: 30px;">
                    <button class="col-md-12 btn-success" onclick="get_application_filtering_results_VR7('<?php echo $application_code;?>','<?php echo $employer_type;?>')"> GENERATE REPORT</button>
                </div>
        </div>
        <div class="col-md-2"></div>
      </div>

      <div class="col-md-12" id="ar7_results">


      </div>
    </div>


<?php } else if($application_code=='AR8'){?>



<?php } else if($application_code=='AR9'){?>



<?php } else if($application_code=='AR10'){?>


<?php } ?>
