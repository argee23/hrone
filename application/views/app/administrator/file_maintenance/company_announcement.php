<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_announcement=$this->session->userdata('add_announcement');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-success">
		  <!-- Default panel contents -->
		  <div class="panel-heading"><strong>Announcement</strong> <a onclick="addAnnounce()" type="button" class="<?php echo $add_announcement;?> btn btn-default btn-xs pull-right" title="Add">
			<?php
			echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
			?>		
		  </a></div>

		  	<div class="panel-body">
				<div class="col-md-12">
          			<label>Filter by Company:</label>
          			<select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="announcement(this.value)">
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
            		<option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
            			<?php }?>
          			</select>
          			
        		</div>
        		<div id="fetch"></div>
			</div>
		</div>
	</div>

	<div class="col-md-6" id="col_3">
		
	</div>
</div>
