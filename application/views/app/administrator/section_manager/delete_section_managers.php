<div id='refresh_main'></div>
<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Delete Section Managers</h4></ol>
  <div class="panel panel-danger">
    <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:50px;" id='add_edit'>
          <div class="col-md-12">
                <div class='col-md-8'>
                       <div class="col-md-5"><label><u>Delete Section Managers By :</u></label></div>
                        <div class="col-md-7" id='r_company'>
                          <select class="form-control" id='company_allow' onchange="delete_section_mngrs(this.value);" > 
                                <option value='' selected disabled>Select Company</option>
                                 <option value='All' >All</option>
                                 <?php 
                                foreach($companyList as $company){
                                  echo "<option value='".$company->company_id."' >".$company->company_name."</option>";
                                }
                                ?>
                          </select>
                        </div>
                </div>
        </div>

      </div>
        <div class="box box-danger" class='col-md-12'></div>
        <div class='col-md-12' id='delete_section_mangers_list'>
          <table id="section_mgrs" class="col-md-12 table table-hover table-striped">
                 <thead>
                  <tr>
                    <th>Company ID</th>
                    <th>Division</th>
                    <th>Department</th>
                    <th>Section</th>
                    <th>Subsection</th>
                    <th>Location</th>
                    <th>Manager</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
       </table>
       </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>      

