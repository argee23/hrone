   <div class="form-group">
    <label class="control-label col-sm-4" > Select a Group</label>
      <div class="col-sm-8">
        <?php if(empty($group)){ echo "<n class='text-danger'>No group/s found.</n>"; } else{ ?>
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
   <br><br>
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">Year</label>
      <div class="col-sm-8">
       <select class="form-control" id="year" onchange="get_year('Month','month','-',this.value,'-');">
         
       </select>
      </div>
  </div>
   <br><br>
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">Month</label>
      <div class="col-sm-8">
       <select class="form-control" id="month" onchange="get_year('Day','day','-','-',this.value);">
         
       </select>
      </div>
  </div>
   <br><br>
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">Day</label>
      <div class="col-sm-8">
       <select class="form-control" id="day" onchange="get_employees_with_preapproved();">
         
       </select>
      </div>

 
  
 
             