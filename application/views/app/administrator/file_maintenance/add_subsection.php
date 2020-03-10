<div class="well">
<!-- form start -->
  <h4 class="text-success">Add Subsection</h4>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_subsection/" >
    <div class="box-body">



      <div class="form-group">
        <label>Select Company:</label>
          <select class="form-control select2" name="company_add" id="company_add" required onchange="examineCompSub(this.value)">
            <option selected="selected" disabled="disabled" value=""> - Choose Company - </option>
<?php

 $check_comp=$this->file_maintenance_model->comp_w_subsection();
                if(!empty($check_comp)){

                  foreach($check_comp as $wSubsec){
                    $a=$wSubsec->company_id;

                    if(!empty($companyList)){
                     foreach($companyList as $company){
                      $b=$company->company_id;

                      if($a==$b){
                        echo '<option value="'.$company->company_id.'">'.$company->company_name.'</option>';
                      }else{

                      }

                     }
                    }else{
                      echo '<option>no company access</option>';
                    }


                  }

                }
?>
          </select>
      </div>
      <div id="sectionOrLoc"></div>
      
    </div><!-- /.box-body -->
  </form>
  </div>