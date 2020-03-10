<div class="row">
<div class="col-md-8">
<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>Movement History</strong> (edit)</div>
  <div class="box-body">

  <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_201_profile/movement_history_save_edit/<?php echo $movement_history->movement_id;?>" >

    	 <div class="box-body">
          <div class="row">
            <div class="col-md-6">
                  <div class="form-group">
                    <label for="company">Type</label>
                     <select class="form-control" name="type" id="type" required> 
                     <option value=''>Select</option>
                     <?php
                        foreach ($movement_type as $me) {?>

                        <option value="<?php echo $me->id?>" <?php if($movement_history->movement_type_id==$me->id){ echo "selected";}?>><?php echo $me->title?></option>
                       <?php }?>
                    </select>
                  </div>
                   <?php 

                   $withdiv = $this->employee_201_profile_model->get_with($movement_history->company_to);
                   $withsub = $this->employee_201_profile_model->get_withsub($movement_history->section_to);
                   ?>
                    
                  <div class="form-group">
                    <label for="company">Company</label>
                    <select class="form-control" name="company" id="company" 
                    onchange = "getDivisionEdit(this.value);" required>
                      <option value=''>Select</option>
                      <?php foreach ($companyList as $company) {?>
                       <option value="<?php echo $company->company_id;?>" <?php if($movement_history->company_to==$company->company_id){ echo "selected";}?>>
                       <?php echo $company->company_name;?></option>
                    <?php }?>
                    </select>
                  </div>
                  
                   <div class="form-group">
                    <label for="company">Division</label>
                     <select class="form-control" name="division" id="division" 
                     <?php if($withdiv==0 || $withdiv==null) { echo "disabled";}?>
                     onchange = "getDepartmentEdit(this.value);" required> 
                      <?php 
                          $division = $this->employee_201_profile_model->get_company_division($movement_history->company_to); 
                          foreach($division as $div) { ?>
                            <option value="<?php echo $div->division_id?>" <?php if($movement_history->division_to==$div->division_id){ echo "selected";}?>><?php echo $div->division_name?></option>
                     <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Department</label>
                     <select class="form-control" name="department" id="department" onchange = "getSectiontEdit(this.value);" required> 
                      <?php 
                            $department = $this->employee_201_profile_model->get_company_department($movement_history->company_to,$movement_history->division_to,$withdiv); 
                            foreach($department as $dept) { ?>
                              <option value="<?php echo $dept->department_id?>" <?php if($movement_history->department_to==$dept->department_id){ echo "selected";}?>><?php echo $dept->dept_name?></option>
                       <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Section</label>
                     <select class="form-control" name="section" id="section" onchange = "getsubSectiontEdit(this.value);" required> 
                        <?php 
                          $section = $this->employee_201_profile_model->get_department_section($movement_history->department_to); 
                          foreach($section as $sec) { ?>
                            <option value="<?php echo $sec->section_id?>" <?php if($movement_history->section_to==$sec->section_id){ echo "selected";}?>><?php echo $sec->section_name?></option>
                     <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Subsection</label>
                     <select class="form-control" name="subsection" id="subsection" 
                       <?php if($withsub==0 || $withsub==null) { echo "disabled";}?> required> 
                      <?php 
                          $subsec = $this->employee_201_profile_model->get_section_subsection($movement_history->section_to); 
                          foreach($subsec as $sub) { ?>
                            <option value="<?php echo $sub->subsection_id?>" <?php if($movement_history->subsection_to==$sub->subsection_id){ echo "selected";}?>><?php echo $sub->subsection_name?></option>
                     <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Locations</label>
                    <select class="form-control" name="location" id="location" required> 
                     <?php   
                      $location = $this->employee_201_profile_model->get_company_location($movement_history->company_to); 
                      foreach ($location as $loc) {?>
                            <option value="<?php echo $loc->location_id?>" <?php if($loc->location_id==$movement_history->location_to){ echo "selected"; }?>><?php echo $loc->location_name?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Classifications</label>
                     <select class="form-control" name="classification" id="classification" required> 
                      <?php   
                        $classification = $this->employee_201_profile_model->get_company_classification($movement_history->company_to); 
                        foreach ($classification as $class) {?>
                              <option value="<?php echo $class->classification_id?>" <?php if($class->classification_id==$movement_history->classification_to){ echo "selected"; }?>><?php echo $class->classification?></option>
                        <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Tax Code</label>
                      <select class="form-control" name="taxcode" id="taxcode" required>
                       <option value=''>Select</option>
                         <?php 
                          foreach($taxcodeList as $taxcode) {?>
                          <option value="<?php echo $taxcode->taxcode_id;?>" <?php if($movement_history->taxcode_to==$taxcode->taxcode_id){ echo "selected"; }?>><?php echo $taxcode->taxcode;?></option>
                          <?php }?>
                      </select>
                  </div>

            </div>
            <div class="col-md-6">
               <div class="form-group">
                    <label for="company">Pay Type</label>
                      <select class="form-control" name="paytype" id="paytype" required>
                        <?php 
                          foreach($paytypeList as $paytype){
                         
                          ?>
                          <option value="<?php echo $paytype->pay_type_id;?>" <?php if($movement_history->pay_type_to==$paytype->pay_type_id){ echo "selected"; }?>><?php echo $paytype->pay_type_name;?>
                        
                          </option>
                          <?php }?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Positions</label>
                      <select class="form-control" name="position" id="position" required>
                        <option value=''>Select</option>
                         <?php 
                          foreach($positionList as $position){
                          ?>
                            <option value="<?php echo $position->position_id;?>" <?php if($movement_history->position_to==$position->position_id){ echo "selected"; }?> ><?php echo $position->position_name;?></option>
                        <?php }?>
                      </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Employment</label>
                      <select class="form-control" name="employment" id="employment" required>
                      <option value=''>Select</option>
                          <?php 
                            foreach($employmentList as $employment){
                          ?>
                            <option value="<?php echo $employment->employment_id;?>" <?php if($movement_history->employment_to==$employment->employment_id){ echo "selected"; }?>><?php echo $employment->employment_name;?></option>
                          <?php }?>
                    </select>
                  </div>
                  
                  <div class="form-group">
                    <label for="company">Report to</label>
                    <input type="hidden" id="report_id" name="report_id" value="<?php echo $movement_history->report_to_to?>">
                    <?php $name = $this->employee_201_profile_model->report_name($movement_history->report_to_to); ?>
                <a data-toggle="modal" data-target="#report_too"> <input type="text" id="report_name" name="report_to" class="form-control" value="<?php echo $name?>"></a>
                  </div>

                  <div class="form-group">
                    <label for="company">Date from</label>
                       <input type="date" class="form-control" name="date_from" id="date_from" value="<?php echo $movement_history->date_from?>"> 
                  </div>

                  <div class="form-group">
                    <label for="company">Date to</label>
                     <input type="date" class="form-control" name="date_to" id="date_to" value="<?php echo $movement_history->date_to?>"> 
                  </div>

                  <div class="form-group">
                    <label for="company">Namee</label>
                     <input type="text" class="form-control" name="namee" id="namee" value="<?php echo $movement_history->namee?>"> 
                    
                  </div>

                  <div class="form-group">
                    <label for="company">Comments</label><br>
                     <textarea class="form-control" name="comment" id="comment" rows="5" col="5"><?php echo $movement_history->comment?></textarea> 
                  </div>
                 
            </div>
            <div class="col-md-12">
             <div class="form-group">
                    <label for="company">Certificates</label>
                     <input type="file" name="file">
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
