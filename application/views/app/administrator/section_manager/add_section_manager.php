 <?php 
  /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $add_sect_mngr=$this->session->userdata('add_sect_mngr');
    $system_defined_icons = $this->general_model->system_defined_icons();

    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>
<br><ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Add New Section Manager</h4></ol>
        
  <div class="panel panel-danger">
     <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:280px;">
          <div class="col-md-12">
                <div class='col-md-6'>
                    <div class="col-md-4"><label>Company:</label></div>
                    <div class="col-md-8">
                    
                        <select class="form-control" id='Company_result' onchange="loadDivision(this.value)">
                             <option selected disabled value='0'>Select Company</option>
                            <?php foreach($companyList as $company){ ?>
                            <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
                           <?php } ?>
                        </select>
                    </div>
                </div>
               
                
                <div class='col-md-6'  style="padding-top: 2px;">
                  <div class="col-md-4"><label>Location:</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="Location_result">
                        <option value='0'>Select Location</option>
                      </select>
                  </div>
                </div>

                <div class='col-md-6'  style="padding-top: 3px;">
                  <div class="col-md-4"><label>Division:</label></div>
                    <div class="col-md-8">
                    <select class="form-control" id="Division_result"  onchange="loadDept(this.value)">
                        <option value='0'>Select Division</option>
                        <option value='All'>All</option>
                    </select>
                    </div>
                </div>

                <div class='col-md-6' style="padding-top: 5px;">
                  <div class="col-md-4"><label>Department:</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="Department_result"  onchange="get_section(this.value)">
                        <option value='0'>Select Department</option>
                        <option value='All'>All</option>
                      </select>
                  </div>
                </div>

                <div class='col-md-6' style="padding-top: 5px;">
                  <div class="col-md-4"><label>Section:</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="Section_result" onchange="get_subsection(this.value)">
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
                  <div class="col-md-4"><label>Manager</label></div>
                    <div class="col-md-8">
                      <a data-toggle="modal" data-target="#search_employee_modal">
                      <input type='hidden' id='result_employee' value="0"> 
                      <input type='text' class='form-control' placeholder="Select Employee" id='search_employee'></a>
                  </div>
                </div>

                <div class='col-md-12' style="padding-top: 30px;">
                  <div class="col-md-4"></div>
                    <div class="col-md-8">
                      <button class="col-md-5 btn btn-success pull-right" onclick="save_section_mngr();" 
    <?php  
     if($add_sect_mngr=="hidden "){
       echo 'disabled title="You Are Not Allowed.Check your access rights." ';
     }else{       
     }
     ?> 
     > <!-- close button -->
    <?php
    echo 'SAVE <i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
    ?>  
</button>
                  </div>
                </div>
        </div>
      </div>
        <div class="box box-danger" class='col-md-12'></div>
        <div class='col-md-12' style="height:230px;overflow: auto;">
       </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div>
  </div>             

