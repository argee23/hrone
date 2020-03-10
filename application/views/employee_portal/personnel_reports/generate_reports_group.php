<div class="panel-heading"><h4>Filter Report</h4></div>
<div class="col-md-12">
</div>
<div class="col-md-12">
<input type="hidden" id="type_option" value="<?php echo $type;?>">
    <div class="col-md-12">
            <div class="col-md-3">  
                  <label class="pull-right">Filtering</label> 
              </div>
              <div class="col-md-6"> 
            <select class="form-control" id="filter" onchange="pao_generate_filter(this.value);">
                <option value="single" selected >Single Date Filtering</option>
                <option value="date_range">Date Range Filtering</option>
            </select>
            </div>
    </div>



  <div class="col-md-12" style="margin-top: 10px;">
          <div class="col-md-3">  
              <label class="pull-right">Employees</label> 
          </div>
          <div class="col-md-6">
            <select class="form-control" id="res_employees" onchange="view_employees_action(this.value);">
              <option value="" selected disabled>Select</option>
              <option value="All">All</option>
              <option value="individual">Individual</option>
            </select>
          </div>
  </div>

     <div class="col-md-12" style="margin-top: 10px;">
         <div class="col-md-3">  
                  <label class="pull-right">Crystal Report</label> 
              </div>
              <div class="col-md-6">
            <select class="form-control" id="report" onchange="get_crystal_report_fields('view_crystal_fields',this.value,'<?php echo $type;?>');">
              <option value="" disabled selected>Select Crystal Report</option>
              <?php foreach ($crystal_report_list as $crll) {?>
                  <option value="<?php echo $crll->p_id?>"><?php echo $crll->report_name;?></option>
              <?php }?>
            </select>
            <br>
            <div id="show_reportdr" style="display: none;"><a style="cursor: pointer;">Click here to view report fields.</a></div>
          </div>
    </div>
    <div class="col-md-12">
           <div class="col-md-3">
            </div>
            <div class="col-md-6" id="view_crystal_fields">
            </div>
    </div>

         <div class="col-md-12" style="margin-top: 10px;display: none;" id="for_individual">
          <div class="col-md-3">  
              <input type="hidden" id="res_employeeid">
              <label class="pull-right">Individual Employee</label> 
          </div>
          <div class="col-md-6">
            <a data-toggle="modal" data-target="#search_employee_modal"><input type="text" class="form-control" placeholder="Select Employee" id="search_employee" required></a>
          </div>
        </div>

         <div class="col-md-12" style="margin-top: 10px;display: none;" id="for_all_sec">
           <div class="col-md-3">  
              <label class="pull-right">Section</label> 
          </div>
          <div class="col-md-6">
            <select class="form-control" id="res_section" onchange="get_subsection(this.value);">
             <?php if(empty($sections)){echo "<option value=''>No section/s found.</option>"; }
             else { if(count($sections)==1){ echo "<option value='' disabled selected>Select</option>"; } else { echo "<option value='All'>All</option>"; } foreach($sections as $sec) {?>
                  <option value="<?php echo $sec->section;?>"><?php echo $sec->section_name?></option>
             <?php }} ?>
            </select>
            </div>
        </div>

         <div class="col-md-12" style="margin-top: 10px;display: none;"  id="for_all_sub">
          <div class="col-md-3">  
              <label class="pull-right">Subsection</label> 
          </div>
          <div class="col-md-6">
            <select class="form-control" id="res_subsection">
              
            </select>
          </div>
        </div>

        <div class="col-md-12" style="margin-top: 10px;display: none;"  id="for_all_loc">
          <div class="col-md-3">  
              <label class="pull-right">Location</label> 
          </div>
          <div class="col-md-6">
            <?php if(empty($locations)){ echo "<n class='text-danger'>No location/s found.</n>";}
               else{ $i=0; foreach($locations as $loc) { ?>  
                 <div class="col-md-6"> <input type="checkbox" class="res_location" id="location_<?php echo $i;?>" value="<?php echo $loc->location;?>" checked> <?php echo $loc->location_name;?></div>
            <?php $i++; } echo "<input type='hidden' value='".$i."' id='count_location'>"; }?>
          </div>
        </div>

       <div class="col-md-12" style="margin-top: 10px;display: none;"  id="for_all_class">
          <div class="col-md-3">  
              <label class="pull-right">Classification</label> 
          </div>
          <div class="col-md-6">
             <?php if(empty($classifications)){ echo "<n class='text-danger'>No classification/s found.</n>";}
               else{ $ii=0; foreach($classifications as $class) { ?>  
                 <div class="col-md-6"> <input type="checkbox" class="res_classification" id="classification_<?php echo $ii;?>" value="<?php echo $class->classification_id;?>" checked> <?php echo $class->classification;?></div>
            <?php $ii++; } echo "<input type='hidden' value='".$ii."' id='count_classification'>"; }?>
          </div>
        </div>

         <div class="col-md-12" style="margin-top: 10px;display: none;"  id="for_all_emp">
          <div class="col-md-3">  
              <label class="pull-right">Employment</label> 
          </div>
          <div class="col-md-6">
             <?php if(empty($employmentList)){ echo "<n class='text-danger'>No employment/s found.</n>";}
               else{ $ii=0; foreach($employmentList as $emp) { ?>  
                 <div class="col-md-6"> <input type="checkbox" class="res_employment" id="emp_<?php echo $ii;?>" value="<?php echo $emp->employment_id;?>" checked> <?php echo $emp->employment_name;?></div>
            <?php $ii++; } echo "<input type='hidden' value='".$ii."' id='count_employment'>"; }?>
          </div>
        </div>
        
</div>

<div class="col-md-12" style="margin-top: 10px;" id="single">
         

            <div class="col-sm-12" style="margin-top: 10px;">

               <div class="col-md-3">  
                  <label class="pull-right">Group</label> 
              </div>
              <div class="col-md-6"> 
               <?php if(empty($group)){ ?>
               <select class="form-control" name="group" id="group" onchange="get_year('Year','year',this.value,'-','-');">
                <option value="" selected disabled>No group/s found.</option>
               </select>
               <?php } else{ ?>
                    <select class="form-control" name="group" id="group" onchange="get_year('Year','year',this.value,'-','-');">
                        <option value="">Select Group</option>
                        <option value="All">All</option>
                        <?php foreach ($group as $g) { ?>
                        <option value="<?php echo $g->id?>"><?php echo $g->group_name?></option>
                        <?php }  ?>
                    </select>
                <?php } ?>
              </div>
            </div>

             <div class="col-sm-12" style="margin-top: 10px;">
              <div class="col-md-3">  
                  <label class="pull-right">Date</label> 
              </div>
              <div class="col-sm-2" style="margin-top: 10px;">  
              <select class="form-control" id="year" onchange="get_year('Month','month','-',this.value,'-');">
                <option value="" selected disabled>Y</option>
                </select>
            </div>
            <div class="col-sm-2" style="margin-top: 10px;">  
              <select class="form-control" id="month" onchange="get_year('Day','day','-','-',this.value);">
                <option value="" selected disabled>M</option>
                </select>
            </div>
            <div class="col-sm-2" style="margin-top: 10px;">  
              <select class="form-control" id="day">
                <option value="" selected disabled>D</option>
                </select>
            </div>
            </div>


             <div class="col-sm-12" style="margin-top: 10px;">
              <div class="col-md-3">  
                  <label class="pull-right">Option</label> 
              </div>
              <div class="col-md-6">
              <select class="form-control" id="option">
                <option value="" disabled selected>Select Option</option>
                <option value="plotted_all">All Plotted Overtime</option>
                <option value="plotted_only">Plotted Overtime</option>
              </select>
              </div>
            </div>
         
       
       
        <div class="col-sm-12" style="margin-top: 10px;">
              <div class="col-md-3">  
                  <label class="pull-right"></label> 
              </div>
              <div class="col-md-6"><a  class="col-md-12 btn btn-success pull-right"  onclick="pao_view_generate_report_single_field();">GENERATE REPORT</a></div>
        </div>
  
 
</div>
</div>

<div class="col-md-12" style="margin-top: 10px;display:none" id="date_range">

        

            <div class="col-sm-12"  style="margin-top: 10px;">  
              <div class="col-md-3">  
                  <label class="pull-right">Group</label> 
              </div>
              <div class="col-md-6"> 
               <?php if(empty($group)){ ?>
               <select class="form-control" name="group" id="groupdr" onchange="get_year('Year','year',this.value,'-','-');">
                <option value="" selected disabled>No group/s found.</option>
               </select>
               <?php } else{ ?>
                    <select class="form-control" name="group" id="groupdr" onchange="get_year('Year','year',this.value,'-','-');">
                        <option value="">Select Group</option>
                        <option value="All">All</option>
                        <?php foreach ($group as $g) { ?>
                        <option value="<?php echo $g->id?>"><?php echo $g->group_name?></option>
                        <?php }  ?>
                    </select>
                <?php } ?>
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 10px;">
              <div class="col-md-3">  
                  <label class="pull-right">Date Range</label> 
              </div>
             
                 <div class="col-md-3">
                <input type="date" name="date_from" id="date_fromdr" class="form-control">
                </div>
                <div class="col-md-3">
                    <input type="date" name="date_to" id="date_todr" class="form-control">
                </div>
             
            </div>

           
            
             <div class="col-sm-12" style="margin-top: 10px;">
           <div class="col-md-3">  
                  <label class="pull-right">Option</label> 
              </div>
              <div class="col-md-6"> 
              <select class="form-control" id="optiondr">
                <option value="" disabled selected>Select Option</option>
                <option value="plotted_all">All Plotted Overtime</option>
                <option value="plotted_only">Plotted Overtime</option>
              </select>
              </div>
            </div>
         

        <div class="col-md-12" style="margin-top: 10px;">
          <div class="col-md-3">  
                    <label class="pull-right"></label> 
                </div>
          <div class="col-md-6"> <a  class="col-md-12 btn btn-success pull-right"  onclick="pao_view_generate_report_date_range();">GENERATE REPORT</a></div>
        </div>
    
   
    
</div>
</div>
</div>

<div class="col-md-12" id="overtime_forms_report_result">

</div>
