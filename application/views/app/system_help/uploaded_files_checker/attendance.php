<div class="col-md-12" id="main_result" style="margin-top: 50px;overflow: scroll;">

<div class="col-md-12">
  <div class="col-md-3">
  </div>
  <div class="col-md-6">
    <div class="col-md-3">
    <label>Date From</label></div>
     <div class="col-md-9">
     <input type="date" name="from" id="from" class="form-control">
    </div>
    <div class="col-md-3">
    <label>Date To</label></div>
    <div class="col-md-9" style="margin-top: 5px;">
     <input type="date" name="to" id="to" class="form-control">
    </div>
    <div class="col-md-12" style="margin-top: 10px;">
      <button class="col-md-12 btn btn-success btn-sm" onclick="attendance_filter();">FILTER (based on date of time in)</button>
    </div>


  </div>
  <div class="col-md-3">
  </div>

</div>
<div class="col-md-12" id="res">
<table class="table table-hover" id="report" >
  <thead>
    <tr class="danger">
      <th>Employee ID</th>
      <th>Employee Name</th>
      <th>Date In</th>
      <th>Time In</th>
      <th>Time Out</th>
      <th>Date Out</th>    
    </tr>
  </thead>
  <tbody>
 
  </tbody>
</table>
</div>
   



</div>
      