<div class="row">
<div class="col-md-8">
<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>Movement History</strong> (add)</div>
  <div class="box-body">
  <?php 
  foreach($current_data as $cd)
  {
      $company_id     = $cd->company_id;
      $pay_type       = $cd->pay_type;
      $location       = $cd->location;
      $classification = $cd->classification;
      $taxcode        = $cd->taxcode;
      $position_id       = $cd->position;
      $employment_id     = $cd->employment;
      $report_id = $cd->report_to;

      $division_id = $cd->division_id;
      $department_id = $cd->department;
      $section_id = $cd->section;
      $subsection_id = $cd->subsection;

      $withdiv = $this->employee_201_profile_model->get_with($company_id);
      $withsub = $this->employee_201_profile_model->get_withsub($section_id);
  }

  ?>
  <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_201_profile/movement_history_save_add/<?php echo $this->uri->segment("4");?>" >

    	 <div class="box-body">

          <div class="row">
            <div class="col-md-6">
                  <div class="form-group">
                    <label for="company">Type</label>
                     <select class="form-control" name="type" id="type" required onchange="movement_history_add_option(this.value);"> 
                     <option value=''>Select</option>
                     <?php
                        foreach ($movement_type as $me) {
                          echo "<option value=".$me->id.">".$me->title."</option>";
                        }
                     ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Company</label>
                     <select class="form-control" name="company" id="company" onchange = "getDivisionEdit(this.value);" required disabled>
                      <option value=''>Select</option>
                      <?php foreach ($companyList as $company) {?>
                       <option value="<?php echo $company->company_id;?>" <?php if($company_id==$company->company_id){ echo "selected"; }?> >
                       <?php echo $company->company_name;?></option>
                    <?php }?>
                    </select>
                  </div>
                  
                   <div class="form-group">
                    <label for="company">Division</label>
                     <select class="form-control" name="division" id="division" onchange = "getDepartmentEdit(this.value);" required disabled> 
                     <?php 
                     if($division_id==0 || $division_id==''){ echo "<option value='0'>No division in this company.</option>";}
                     else{
                     $division = $this->employee_201_profile_model->get_company_division($company_id); 
                          foreach($division as $div) { ?>
                            <option value="<?php echo $div->division_id?>" <?php if($division_id==$div->division_id){ echo "selected";}?>><?php echo $div->division_name?></option>
                     <?php } } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Department</label>
                     <select class="form-control" name="department" id="department" onchange = "getSectiontEdit(this.value);" required disabled> 

                      <?php 
                            $department = $this->employee_201_profile_model->get_company_department($company_id,$division_id,$withdiv); 
                            foreach($department as $dept) { ?>
                              <option value="<?php echo $dept->department_id?>" <?php if($department_id==$dept->department_id){ echo "selected";}?>><?php echo $dept->dept_name?></option>
                       <?php } ?>

                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Section</label>
                     <select class="form-control" name="section" id="section" onchange = "getsubSectiontEdit(this.value);" required disabled> 
                      <?php 
                          $section = $this->employee_201_profile_model->get_department_section($department_id); 
                          foreach($section as $sec) { ?>
                            <option value="<?php echo $sec->section_id?>" <?php if($section_id==$sec->section_id){ echo "selected";}?>><?php echo $sec->section_name?></option>
                     <?php } ?>

                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Subsection</label>
                     <select class="form-control" name="subsection" id="subsection" required disabled> 
                      <?php if($withsub==0 || $withsub==null) { echo "<option value='0'>Subsection not required.</option>";}
                        else{
                          $subsec = $this->employee_201_profile_model->get_section_subsection($section_id); 
                          foreach($subsec as $sub) { ?>
                            <option value="<?php echo $sub->subsection_id?>" <?php if($subsection_id==$sub->subsection_id){ echo "selected";}?>><?php echo $sub->subsection_name?></option>
                     <?php } } ?>

                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Locations</label>
                    <select class="form-control" name="location" id="location" required disabled> 
                     <?php   
                      $location = $this->employee_201_profile_model->get_company_location($company_id); 
                      foreach ($location as $loc) {?>
                            <option value="<?php echo $loc->location_id?>" <?php if($loc->location_id==$location){ echo "selected"; }?>><?php echo $loc->location_name?></option>
                      <?php } ?>

                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Classifications</label>
                     <select class="form-control" name="classification" id="classification" required disabled> 
                         <?php   
                        $classification = $this->employee_201_profile_model->get_company_classification($company_id); 
                        foreach ($classification as $class) {?>
                              <option value="<?php echo $class->classification_id?>" <?php if($class->classification_id==$classification){ echo "selected"; }?>><?php echo $class->classification?></option>
                        <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Tax Code</label>
                      <select class="form-control" name="taxcode" id="taxcode" required disabled>
                       <option value=''>Select</option>
                         <?php 
                          foreach($taxcodeList as $taxcode1) {?>
                          <option value="<?php echo $taxcode1->taxcode_id;?>" <?php if($taxcode==$taxcode1->taxcode_id){ echo "selected"; }?> ><?php echo $taxcode1->taxcode;?></option>
                          <?php }?>
                      </select>
                  </div>

            </div>
            <div class="col-md-6">
               <div class="form-group">
                    <label for="company">Pay Type</label>
                      <select class="form-control" name="paytype" id="paytype" required disabled>
                       <option value=''>Select</option>
                        <?php 
                          foreach($paytypeList as $paytype){
                         
                          ?>
                        <option value="<?php echo $paytype->pay_type_id;?>" <?php if($pay_type==$paytype->pay_type_id){ echo "selected"; }?>><?php echo $paytype->pay_type_name;?></option>
                          <?php }?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Positions</label>
                      <select class="form-control" name="position" id="position" required disabled>
                        <option value=''>Select</option>
                         <?php 
                          foreach($positionList as $position){
                          ?>
                            <option value="<?php echo $position->position_id;?>" <?php if($position_id==$position->position_id){ echo "selected"; }?>><?php echo $position->position_name;?></option>
                        <?php }?>
                      </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Employment</label>
                      <select class="form-control" name="employment" id="employment" required disabled>
                      <option value=''>Select</option>
                          <?php 
                            foreach($employmentList as $employment){
                          ?>t
                            <option value="<?php echo $employment->employment_id;?>" <?php if($employment_id==$employment->employment_id){ echo "selected"; }?>><?php echo $employment->employment_name;?></option>
                          <?php }?>
                    </select>
                  </div>
                  
                  <div class="form-group">
                    <label for="company">Report to</label>
                    <?php $name = $this->employee_201_profile_model->report_name($report_id); ?>
                     <input type="hidden" id="report_id" name="report_id" value="<?php echo $report_id;?>">
                <a data-toggle="modal" data-target="#report_too"> <input type="text" id="report_name" name="report_to" class="form-control" value="<?php echo $name;?>" disabled></a> </div>

                  <div class="form-group">
                    <label for="company">Date from</label>
                       <input type="date" class="form-control" name="date_from" id="date_from"> 
                  </div>

                  <div class="form-group">
                    <label for="company">Date to</label>
                     <input type="date" class="form-control" name="date_to" id="date_to"> 
                  </div>

                  <div class="form-group" style="display: none;">
                    <label for="company">Namee</label>
                     <input type="text" class="form-control" name="namee" id="namee" > 
                    
                  </div>

                  <div class="form-group">
                    <label for="company">Comments</label><br>
                     <textarea class="form-control" name="comment" id="comment" rows="5" col="5" ></textarea> 
                  </div>
                 
            </div>
            <div class="col-md-12">
             <div class="form-group">
                    <label for="company">Certificates</label>
                     <input type="file" name="file" id="file" disabled>
                  </div>
            </div>
            </div>
            </div><!-- /.box-body -->   
  

     <div class="form-group">
     <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> Save Changes</button>
     </div>
     </form>
     </div> 
     </div>

</div>
</div>

</div>  
</div>

<div class="modal modal-primary fade" id="report_too" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="myModalLabel">Report to: </h4>
              </div>
               <div class="modal-body">
                  <input onKeyUp="report_to(this.value)" class="form-control input-sm" name="ccSearch" id="ccSearch" type="text" placeholder="Search here">
                    <span id="add_showSearchResultss"> </span>
              </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>                          
     </div>
  </div>
</div>
