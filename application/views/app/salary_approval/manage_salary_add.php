 <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:280px;">
          <div class="col-md-12">
                <input type="hidden" id="Company_result" value="<?php echo $company;?>">
                <div class='col-md-6' >
                  <div class="col-md-4"><label>Classification:</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="Classification_result">
                        <option value='0'>Select Classification</option>
                        <?php if(empty($classification))
                        { echo "<option value='0'>No Classification Found.Please add first to continue.</option>"; }
                        else
                          {  echo "<option value='All'>All</option>"; foreach($classification as $cc){ ?>
                          <option value="<?php echo $cc->classification_id;?>"><?php echo $cc->classification;?></option>
                        <?php } } ?>
                      </select>
                  </div>
                </div>

                <div class='col-md-6'  style="padding-top: 2px;">
                  <div class="col-md-4"><label>Location:</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="Location_result">
                        <option value='0'>Select Location</option>
                        <?php if(empty($location))
                        { echo "<option value='0'>No Location Found.Please add first to continue.</option>";}
                        else
                        {
                          echo "<option value='All'>All</option>";
                          foreach($location as $ll){?>
                          <option value='<?php echo $ll->location_id;?>'><?php echo $ll->location_name;?></option>
                        <?php } } ?>
                      </select>
                  </div>
                </div>

                <div class='col-md-6'  style="padding-top: 3px;">
                  <div class="col-md-4"><label>Division:</label></div>
                    <div class="col-md-8">
                    <select class="form-control" id="Division_result"  onchange="loadDept(this.value)">
                        <option value='0'>Select Division</option>
                        <?php if($with_division==0)
                        {
                          echo "<option value='not_included'>Division is not required in this company.You can now proceed to next field.</option>";
                        }
                        else
                        {
                          if(empty($division))
                          {
                            echo "<option value='0'>o division found. Please add first to continue.</option>";
                          }
                          else
                          {
                            echo "<option value='All'>All</option>";
                            foreach($division as $dd){
                              echo "<option value='".$dd->division_id."'>".$dd->division_name."</option>";
                            }
                          }
                        }?>
                    </select>
                    </div>
                </div>

                <div class='col-md-6' style="padding-top: 5px;">
                  <div class="col-md-4"><label>Department:</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="Department_result"  onchange="get_sections(this.value)">
                        <option value='0'>Select Department</option>
                        <option value='All'>All</option>
                      </select>
                  </div>
                </div>
                <div class='col-md-6' style="padding-top: 5px;">
                  <div class="col-md-4"><label>Section:</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="Section_result" onchange="get_subsections(this.value)">
                        <option value='0'>Select Section</option>
                        <option value='All'>All</option>
                      </select>
                  </div>
                </div>

                <div class='col-md-6' style="padding-top: 5px;">
                  <div class="col-md-4"><label>Subsection:</label></div>
                    <div class="col-md-8">
                        <select class="form-control" id="Subsection_result">
                          <option value='0'>Select Subsection</option>
                        <option value='All'>All</option>
                        </select>
                    </div>
                </div>

                <div class='col-md-6' style="padding-top: 5px;">
                  <div class="col-md-4"><label>Select Approver:</label></div>
                    <div class="col-md-8">
                      <a data-toggle="modal" data-target="#add_approver_trans">
                      <input type='hidden' id='addnew_approver_id' value="0"> 
                      <input type='hidden' id='addnew_approver_position' value="0"> 
                      <input type='text' class='form-control' placeholder="Select Employee" id='addnew_approver_name'></a>
                  </div>
                </div>


                <div class='col-md-6' style="padding-top: 5px;">
                  <div class="col-md-4"><label>Approval Level:</label></div>
                    <div class="col-md-3">
                    <select class="form-control" id="Approval_result">
                         <option value="set">Set As</option>
                        <option value="align">Align On</option>
                    </select>
                  </div>
                  <div class="col-md-5">
                     <select class="form-control" id="Approvernum_result"> 
                        <option value="0">Select</option>
                       <?php if(empty($approver_setting)){ echo "<option value='0'>No setup for Number of Approver in this company. Please add first to continue.</option>"; }
                        else
                        {
                           $x = 1; 
                              while($x <= $approver_setting) {
                                if($x=="1"){
                                  $ext="st";
                                }else if($x=="3"){
                                  $ext="rd";
                                }else if($x=="2"){
                                  $ext="nd";
                                }else{
                                  $ext="th";
                                }
                                  echo '<option value="'.$x.'" >'.$x.$ext.' Approval</option>';
                                  $x++;
                              } 
                        }?>
                      </select>
                  </div>
                </div>

                

                <div class='col-md-12' style="padding-top: 15px;">
                  <div class="col-md-8"></div>
                    <div class="col-md-4" id='loaderr' style="display: none;"> <h4 class="text-info pull-right"><label><div class="loader"></div>S A V I N G . .</label></h4></div>

                    <div class="col-md-4" id="savv"> 
                      <button class="col-md-5 btn btn-success" style="margin-right:15px;" id="sbmt_f" onclick="save_new_approver();">SAVE</button>
                      <button class="col-md-6 btn btn-danger" onclick="get_salary_approvers('<?php echo $company;?>');" >BACK</button>
                  </div>
                </div>
        </div>
      </div>
        <div class="box box-danger" class='col-md-12'></div>
        <div class='col-md-12' style="height:230px;overflow: auto;">
       </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div>

<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 40px;
  height: 40px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
     

