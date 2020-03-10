<div class="row">
<div class="col-md-8">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>EMPLOYMENT EXPERIENCE</strong> (edit)</div>
  <div class="box-body">
    <form method="post" action="<?php echo base_url()?>app/employee_201_profile/employment_exp_modify/<?php echo $this->uri->segment("4");?>" >

          <div class="row">
            <div class="col-md-12">

            <div class="form-group" >
              <label for="position">Position Name</label>
              <select class="form-control" name="position_id" id="position_id" required>
                  <option disabled selected value="">Select Position</option>
                  <?php foreach($positionList as $position){ if($position->isEmployer==1)
                    {} else { ?>
                       <option value="<?php echo $position->position_id;?>" <?php if($position->position_id==$employment_exp->position_id){ echo "selected"; }?>><?php echo $position->position_name;?></option>
                  <?php } }?>
              </select>

              <p style="color:#ff0000;">Position name is required</p>
            </div>


            <div class="form-group" >
              <label for="company_name">Company Name</label>
              <input type="text" name="company_name" class="form-control" placeholder="Company name" value="<?php echo $employment_exp->company_name; ?>" required>
              <p style="color:#ff0000;">Company name is required</p>
            </div>


            <div class="form-group">
              <label for="company_address">Company address</label>
              <input type="text" name="company_address" class="form-control" placeholder="Company address" value="<?php echo $employment_exp->company_address; ?>" required>
              <p style="color:#ff0000;">Company address is required</p>
            </div>
            </div>

            <div class="col-md-6">
            <div class="form-group" >
              <label for="company_contact">Company contact No.</label>
              <input type="number" name="company_contact" class="form-control" placeholder="Company contact No." value="<?php echo $employment_exp->company_contact; ?>" >
            </div>

            <div class="form-group">
              <label for="date_start">Date started</label>
              <input type="text" id="date_start" name="date_start" class="form-control" placeholder="date start" value="<?php  echo $employment_exp->date_start; ?>" required>
              <p style="color:#ff0000;">Date started is required</p>
            </div>
            </div>

            <div class="col-md-6">
            <div class="form-group">
              <label for="salary">Salary</label>
            <input type="number" name="salary" class="form-control" placeholder="Salary" value="<?php echo $employment_exp->salary; ?>">
            </div>
            </div>

            <div id="date_end_view">
            <div class="col-md-6">
            <div class="form-group" >
              <label for="date_end">Date Ended</label>
              <input type="text" id="date_end" name="date_end" class="form-control" placeholder="date end" value="<?php if($employment_exp->isPresentWork==1){} else{ echo $employment_exp->date_end; } ?>" <?php if($employment_exp->isPresentWork==1){ echo "disabled"; } else{} ?> required>
              <p style="color:#ff0000;">Date ended is required</p>
            </div>
            </div>

            <div class="col-md-6">
            <div class="form-group">
              <input type="hidden" value="<?php if($employment_exp->isPresentWork==1){ echo "no"; } else{ echo "yes";}?>"
              name="isPresent" id="isPresent">
              <input type="checkbox"   name="isPresent_" id="isPresent_" value="yes" onchange="date_end_experience(this.value);" <?php if($employment_exp->isPresentWork==1){ echo "checked"; } else{} ?>>
              <label> Present work</label>
            </div>
            </div>
            </div>

            <div class="col-md-12">

            <div class="form-group" >
              <label for="job_description">Job description</label>
              <textarea name="job_description" rows="4" cols="50" placeholder="Job description(s)" class="form-control"><?php echo $employment_exp->job_description; ?></textarea>
            </div>

            <div class="form-group">
              <label for="reason_for_leaving">Reason(s) for leaving</label>
            <textarea name="reason_for_leaving" rows="4" cols="50" placeholder="Reason(s) for leaving" class="form-control"><?php echo $employment_exp->reason_for_leaving; ?></textarea>
            </div>

            </div>

            </div>            

    <div class="form-group">
    <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> SAVE CHANGES</button>
    </div>
    </form>
     </div> 
     </div>

</div>
</div>

</div>  
</div>


