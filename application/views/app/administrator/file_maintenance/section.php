
<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_section=$this->session->userdata('add_section');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>
<div class="row">
	<div class="col-md-6">

	<div class="panel panel-danger">
		<div class="panel-heading">
			

		    <strong> Section </strong> <a onclick="addSection()" type="button" class="<?php echo $add_section;?>btn btn-default btn-xs pull-right" title="Add">
			<?php
			echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
			?>		
			</a>

		</div>
		<div class="panel-body">
			<div class="form-group">

		    <label> Select Company </label>
		    <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="getDepartment(this.value)">
		      <option selected="selected" disabled="disabled" value="">-Choose Company-</option>
		      <?php 
		        foreach($companyList as $company){ ?>
		        <option value="<?php echo $company->company_id;?>"> <?php echo $company->company_name;?> </option>
		        <?php }?>
		    </select>

		  </div>
		  <div id="fetch"></div>
		  <div id="departmentList"></div>
		</div>
		
	</div>
	</div>

	<div class="col-md-6" id="col_3">
		
	</div>
</div>
