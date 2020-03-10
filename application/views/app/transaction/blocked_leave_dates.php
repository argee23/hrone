
<div id="coll_2">
<div class="col-md-12" style="padding-top: 20px;">
  <div class="col-md-4" style="padding-bottom: 50px;"  id="fetch_all_result">
      <div class="panel panel-info">
      <h4 class="text-danger" style="font-weight: bold;"><center>Add New Here</center></h4><hr>
            <div class="col-md-12">
               <label>Company: </label>
               <select class="form-control" id="company" onchange="getLocation(this.value);">
               <option value="" selected disabled>Select Company</option>
               <?php foreach($companyList as $company) { ?>
                 <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
                 <?php } ?>
               </select>
               <br>

               <div id="location">
               </div>

                <label>Date</label>
                <input type="date" name="date" id="date" class="form-control">
                <br> 

                <button class="col-md-12 btn btn-success" onclick="save_blocked_dates();">Save</button>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div> 
    </div>


  <div class="col-md-8" style="padding-bottom: 50px;"  id="fetch_all_result">
      <div class="panel panel-info">
            <div class="col-md-12"><br><br>
                  <table class="table table-bordered" id="blocked_leave"  style="margin-top:20px;">
                      <thead>
                        <tr class="success">
                          <th> No.</th>
                          <th>Company Name</th>
                          <th>Location </th>
                          <th>Blocked Leave Dates</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($leave_list as $l) { if(empty($leave_list)){ echo "<h3 class='text-danger'>No data found.</h3>";} ?>
                        <tr>
                          <td><?php echo $l->id?></td>
                          <td> <?php echo $l->company_name?> </td>
                          <td> <?php echo $l->location_name?> </td>
                          <td> <?php echo $l->date?> </td>
                          <td>
                              <a class='fa fa-<?php echo $system_defined_icons->icon_delete;?>' style='color:<?php echo $system_defined_icons->icon_delete_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='delete_date(<?php echo $l->id?>)'></a>
                          </td>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div> 
    </div>

</div>
</div>