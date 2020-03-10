<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Viewing of Working Schedules Plotted by Section Managers</h4></ol>
<div class="col-md-12">
    <div class="col-md-2"><center><label><u>Company</u></label></center></div>
  
    <div class="col-md-5">
      <select class="form-control" id="sm_company" onchange="get_section_manager(this.value)">
       <option value="none" disabled selected>Select</option>
         <?php foreach ($companyList as $company) {?>
            <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
        <?php } ?>
      </select>
    </div>
   <br><br>
    <div class="box box-default" class='col-md-12'></div>
</div>
  
<div class="col-md-12" style="padding-top:10px;" id='section_mngr_grp'>
  <table class="table table-bordered" id="view_plotted_sm">
            <thead>
             <tr  class="success">
                <th style="width:20%;">Manager ID</th>
                <th style="width:25%;">Manager Name</th> 
                <th style="width:40%;">Group Name/s</th>
                <th style="width:10%;">Status</th>
                <th style="width:5%;">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </tbody>
  </table> 
</div>              
 <div id="modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
       <div class="modal-content modal-md">
       </div>
    </div>
</div>