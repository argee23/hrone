   <div class="form-group">
      <input type="hidden" id="group" value="general">
   </div> 
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">Year</label>
      <div class="col-sm-8">
       <select class="form-control" id="year" onchange="get_year('Month','month','-',this.value,'-');">
            <?php echo "<option>Select Year</option>";
        foreach ($date as $y)
        {
          echo "<option value='".date("Y", strtotime($y->date))."'>".date("Y", strtotime($y->date))."</option>";
        } ?>
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

 
  
 
             