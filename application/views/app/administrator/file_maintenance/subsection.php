<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_subsection=$this->session->userdata('add_subsection');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>
<div class="row">
	<div class="col-md-6">

	<div class="panel panel-success">
		<div class="panel-heading">
			<strong> Subsection </strong> 
			<a onclick="addSubsection()" type="button" class="<?php echo $add_subsection;?> btn btn-default btn-xs pull-right" title="Add">
			<?php
			echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
			?>		
			</a>
		</div>
		<div class="panel-body">
			<div class="form-group">
		    <label> Select Company </label>
		    <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="examineCompSubView(this.value)">
		      <option selected="selected" disabled="disabled" value="">-Choose Company-</option>
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
		  <input type="hidden" name="type" id="type" value="view">
		  <div id="sectionOrLocView"></div>
		</div>
		
	</div>
	</div>

	<div class="col-md-6" id="col_3">
		
	</div>
</div>
