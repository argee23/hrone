<div class="panel-heading"><h4>Generate Forms Transactions Report</h4></div>
<div class="col-md-12">

</div>

      <input type="hidden" id="type_option" value="<?php echo $type;?>">
<div class="col-md-12" id="filtering_rf_">
       <div class="col-md-12" style="margin-top: 10px;">
           <div class="col-md-3">  
              <label class="pull-right">Crystal Report</label> 
          </div>
          <div class="col-md-6">
            <select class="form-control" id="res_report" onchange="get_crystal_report_fields('view_crystal_fields',this.value,'forms_report');">
              <option value="" disabled selected>Select Crystal Report</option>
              <?php foreach ($crystal_report_list as $crll) {?>
                  <option value="<?php echo $crll->p_id?>"><?php echo $crll->report_name;?></option>
              <?php }?>
            </select>
           </div>
        </div>
         <div class="col-md-12">
           <div class="col-md-3">
            </div>
            <div class="col-md-6" id="view_crystal_fields">
            </div>
         </div>
        <div class="col-md-12" style="margin-top: 15px;">
        <div class="col-md-3">  
              <label class="pull-right">Transactions</label> 
          </div>
          <div class="col-md-6">
            <select class="form-control" id="res_transactions">
            <?php if (empty($transactions)){ echo "<option value=''>No transaction/s found.</option>"; } else{ ?>
               <option value="" disabled selected>Select Transactions</option>
               <option value="All">All</option>
            <?php foreach($transactions as $tr) { ?>
                <option value="<?php echo $tr->t_table_name;?>"><?php echo $tr->form_name;?></option>
            <?php } }?>
            </select>
          </div>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
          <div class="col-md-3">  
              <label class="pull-right">Status</label> 
          </div>
          <div class="col-md-6">
            <select class="form-control" id="res_status">
                <option value="All">All</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="cancelled">Cancelled</option>
                <option value="rejected">Rejected</option>
            </select>
          </div>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
          <div class="col-md-3">  
              <label class="pull-right">Date Range</label> 
          </div>
          <div class="col-md-3">
            <input type="date" class="form-control" id="res_datefrom" >
          </div>
          <div class="col-md-3">
            <input type="date" class="form-control" id="res_dateto">
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

        <div class="col-md-12" style="margin-top: 10px;">
          <div class="col-md-3"></div>
          <div class="col-md-6"><button class="col-md-12 btn btn-success" onclick="fr_generate_report();">GENERATE REPORT</button></div>
        </div>
<div class="col-md-12">
<br><br>
  <div class="box box-danger" class='col-md-12'></div>
</div>
</div>

<div class="col-md-12" id="forms_report_result">

</div>



