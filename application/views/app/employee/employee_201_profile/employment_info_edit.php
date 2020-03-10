<div class="row">
<div class="col-md-8">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>EMPLOYMENT INFORMATION</strong> (edit)</div>

  <form method="post" action="<?php echo base_url()?>app/employee_201_profile/employment_info_modify/<?php echo $this->uri->segment("4");?>" >

    <div class="box-body">

        
          <div class="row">
            <div class="col-md-6">

            <div class="form-group">
            <input type="hidden" name="type" id="type" value="1">
              <label for="company">Company</label>
               <select class="form-control" name="company" id="company" onchange = "getDivisionEdit(this.value);" required>
                <?php foreach ($companyList as $company) {?>
                 <option value="<?php echo $company->company_id;?>" <?php if($employment_info_view->company_id==$company->company_id){ echo "selected";}?>>
                 <?php echo $company->company_name;?></option>
              <?php }?>
              </select>
              <p style="color:#ff0000;">Company is required</p>
            </div>

            
            <div id="div">
              <div class="form-group">
                <label>Division</label>
                   <select class="form-control" name="division" id="division" <?php if($employment_info_view->wDivision==0 || $employment_info_view->wDivision==null) { echo "disabled";}?> onchange = "getDepartmentEdit(this.value);">
                      <?php 
                          $division = $this->employee_201_profile_model->get_company_division($employment_info_view->company_id); 
                          foreach($division as $div) { ?>
                            <option value="<?php echo $div->division_id?>" <?php if($employment_info_view->division_id==$div->division_id){ echo "selected";}?>><?php echo $div->division_name?></option>
                     <?php } ?>
                  </select>
                <p style="color:#ff0000;">Division is required</p>           
              </div>
            </div>

              <div id="dept">
              <div class="form-group">
                <label>Department</label>
                 <select class="form-control" name="department" id="department" onchange = "getSectiontEdit(this.value);" required>
                      <?php 
                          $department = $this->employee_201_profile_model->get_company_department($employment_info_view->company_id,$employment_info_view->division_id,$employment_info_view->wDivision); 
                          foreach($department as $dept) { ?>
                            <option value="<?php echo $dept->department_id?>" <?php if($employment_info_view->department==$dept->department_id){ echo "selected";}?>><?php echo $dept->dept_name?></option>
                     <?php } ?>
                  </select>
                <p style="color:#ff0000;">Department is required</p>           
              </div>
            </div>

             <div id="dept">
              <div class="form-group">
                <label>Section</label>
                 <select class="form-control" name="section" id="section" onchange = "getsubSectiontEdit(this.value);" required>
                       <?php 
                          $section = $this->employee_201_profile_model->get_department_section($employment_info_view->department); 
                          foreach($section as $sec) { ?>
                            <option value="<?php echo $sec->section_id?>" <?php if($employment_info_view->section==$sec->section_id){ echo "selected";}?>><?php echo $sec->section_name?></option>
                     <?php } ?>
                  </select>
                <p style="color:#ff0000;">Section is required</p>           
              </div>
            </div>   

            <div id="dept">
              <div class="form-group">
                <label>Subsection</label>
                <select class="form-control" name="subsection" id="subsection" <?php if($employment_info_view->wSubsection==0 || $employment_info_view->wSubsection==null) { echo "disabled";}?>required>
                      <?php 
                          $subsec = $this->employee_201_profile_model->get_section_subsection($employment_info_view->section); 
                          foreach($subsec as $sub) { ?>
                            <option value="<?php echo $sub->subsection_id?>" <?php if($employment_info_view->subsection==$sub->subsection_id){ echo "selected";}?>><?php echo $sub->subsection_name?></option>
                     <?php } ?>
                  </select>
                <p style="color:#ff0000;">Subsection is required</p>           
              </div>
            </div>   

             <div class="form-group">
                <label>Taxcode</label>
                  <select class="form-control" name="taxcode" id="taxcode" required>
                         <?php 
                          foreach($taxcodeList as $taxcode) {?>
                          <option value="<?php echo $taxcode->taxcode_id;?>" <?php if($taxcode->taxcode==$taxcode->taxcode_id){ echo "selected"; }?>><?php echo $taxcode->taxcode;?></option>
                          <?php }?>
                  </select>
                  <p style="color:#ff0000;">Taxcode is required</p>
              </div><!-- /.form-group -->

              <div id="reportTo">
              <div class="form-group">
                <label>Report to</label>
                <input type="hidden" id="report_id" name="report_id" value="<?php echo $employment_info_view->report_to?>">
                <a data-toggle="modal" data-target="#report_too"> <input type="text" id="report_name" name="report_to" class="form-control" value="<?php echo $employment_info_view->report_to_name; ?>"></a>
              </div><!-- /.form-group -->
              </div>

            </div>
            
            <div class="col-md-6">
            <div id="loc">
              <div class="form-group">
                <label>Location</label>
                 <select class="form-control" name="location" id="location" required>
                <?php   
                $location = $this->employee_201_profile_model->get_company_location($employment_info_view->company_id); 
                foreach ($location as $loc) {?>
                      <option value="<?php echo $loc->location_id?>" <?php if($loc->location_id==$employment_info_view->location){ echo "selected"; }?>><?php echo $loc->location_name?></option>
                <?php } ?>
                  </select>
                <p style="color:#ff0000;">Location is required</p>           
              </div><!-- /.form-group -->
              </div>

              <div id="class">
              <div class="form-group">
                <label>Classification</label>
                <select class="form-control" name="classification" id="classification" required>
                     <?php   
                        $classification = $this->employee_201_profile_model->get_company_classification($employment_info_view->company_id); 
                        foreach ($classification as $class) {?>
                              <option value="<?php echo $class->classification_id?>" <?php if($class->classification_id==$employment_info_view->classification){ echo "selected"; }?>><?php echo $class->classification?></option>
                        <?php } ?>
                  </select>
                <p style="color:#ff0000;">Classification is required</p>           
              </div><!-- /.form-group -->
              </div>

              <div class="form-group">
                <label>Pay type</label>
                <select class="form-control" name="paytype" id="paytype" required>
                  <?php 
                    foreach($paytypeList as $paytype){
                   
                    ?>
                    <option value="<?php echo $paytype->pay_type_id;?>" <?php if($employment_info_view->pay_type==$paytype->pay_type_id){ echo "selected"; }?>><?php echo $paytype->pay_type_name;?></option>
                    <?php }?>
                </select>
                <p style="color:#ff0000;">Pay type is required</p>
              </div><!-- /.form-group -->

              <div class="form-group" >
              <label for="employment_type">Employment type</label>
                <select class="form-control" name="employment" id="employment"  required>
                  <?php 
                        $today = date('Y-m-d');
                        $end_date = $contract->end_date;
                        $empl = $contract->employment_id;
                        if($end_date >=$today)
                        {
                         foreach($employmentList as $employment){ ?>
                            <option value="<?php echo $employment->employment_id;?>" <?php if($empl==$employment->employment_id){ echo "selected"; } else{ echo "disabled"; } ?>><?php echo $employment->employment_name; if($empl==$employment->employment_id){echo "(current contract)"; }?></option>
                          <?php }
                        }
                        else
                        {
                           foreach($employmentList as $employment){ ?>
                            <option value="<?php echo $employment->employment_id;?>" <?php if($employment_info_view->employment==$employment->employment_id){ echo "selected"; } ?>><?php echo $employment->employment_name;?></option>
                          <?php }
                        }
                   
                  ?>
                </select>
            <p style="color:#ff0000;" id="err_emp">Employment type is required</p>
            </div>

            <div class="form-group">
            <label for="position">Position</label>
              <select class="form-control" name="position" id="position" required>
                     <?php 
                      foreach($positionList as $position){
                      ?>
                   <option value="<?php echo $position->position_id;?>" <?php if($employment_info_view->position==$position->position_id) { echo "selected"; } ?>><?php echo $position->position_name;?></option>
                <?php }?>
            </select>
            <p style="color:#ff0000;">Position is required</p>
          </div><!-- /.form group -->
             
              <div class="form-group">
                <label>Date employed</label>
                <input type="date" name="date_employed" id="date_employed" class="form-control" placeholder="yyyy/mm/dd" value="<?php echo $employment_info_view->date_employed; ?>">
              </div><!-- /.form-group -->
            </div>
            </div>

     <div class="form-group">
     <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> SAVE CHANGES</button>
     </div>
    </div><!-- /.box-body -->
    </form>
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

</div>  
</div>


