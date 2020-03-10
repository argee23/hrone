
		<div class="form-group">
			<label>Select Department</label>
		    <select class="form-control select2" name="department_add" id="department_add" style="width: 100%;" required="required" <?php if(isset($type)){ echo 'onchange="examineDeptSubView(this.value)"'; } 
                else { echo 'onchange="examineDeptSub(this.value)"'; } ?> >
		      <option selected="selected" disabled="disabled" value="">-Choose Department-</option>
		      <option disabled>Note: Departments of which section is w/subsection as a setup will appear below.</option>
		      <option disabled>&nbsp;</option>
<?php
$check_dept=$this->file_maintenance_model->dept_w_subsection();
                if(!empty($check_dept)){

                  foreach($check_dept as $wSubsec){
                    $a=$wSubsec->department_id;
                    $d_name=$wSubsec->dept_name;

                    if(!empty($departmentList)){
                     foreach($departmentList as $dept){
                      $b=$dept->department_id;
                      if($a==$b){
                      	echo '<option value="'.$b.'"> '.$d_name.'</option>';
                      }
                     }
                    }else{
                      echo '<option disabled> No department setup for this company yet.</option>';
                    }


  					}
  				}else{
  					echo '<option disabled> No department of which section is w/subsetion as a setup.<option>';
  				}
?>
		    </select> 
		 </div>
		 <?php if(isset($type)){ echo '<div id="SectionView"></div>'; } 
                else { echo '<div id="Section"></div>'; } ?>