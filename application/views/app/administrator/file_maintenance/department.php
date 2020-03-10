
<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_department=$this->session->userdata('add_department');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>
<div class="row">
  <div class="col-md-7">
    <div class="panel panel-danger">

      <!-- Default panel contents -->
      <!-- <div class="panel-heading"><strong>Departments</strong> <a onclick="addDepartment()" type="button" <?php echo $this->session->userdata('check_add_department_icon'); ?> class="hidden"  title="Add"><i class="fa fa-plus"></i></a></div> -->

    <!-- <?php echo $table_department;?> -->
    <div class="panel-heading"><strong>Departments</strong> <a onclick="addDepartment()" type="button" 
    class="<?php echo $add_department;?> btn btn-default btn-xs pull-right" title="Add">
      <?php
      echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
      ?>    
      </a></div>
      <div class="panel-body">
        <div class="col-md-12">
                <div class="form-group" >
                <label>Filter by Company:</label>
                <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="fetchDepartments(this.value)">
                <option selected="selected" disabled="disabled" value="0">- Select Company -</option>
                  <?php 
                    foreach($companyList as $company){
                    if($_POST['company'] == $company->company_id){
                        $selected = "selected='selected'";
                    }
                    else{
                        $selected = "";
                    }
                  ?>
                <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name; if($company->wDivision == 1){echo ' - with Division';} else { echo ' - without Division';}?></option>
                  <?php }?>
                </select>
                </div>
                <div id="fetch"></div>
          </div>
      </div>
    </div>
  </div>

  <div class="col-md-5" id="col_3">
    
  </div>
</div>

