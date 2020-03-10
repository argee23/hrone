
<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_faq=$this->session->userdata('add_faq');
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
			
		  <div class="form-group">
		    <label>Select Company</label><a onclick="addFaq()" type="button" class="<?php echo $add_faq;?> btn btn-default btn-xs pull-right" title="Add">
			<?php
			echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
			?>		
			</a>
		    <select class="form-control select2" name="company" style="width: 100%;" onchange="getFaq(this.value)">
		      <option selected="selected" disabled="disabled" value="">-Choose Company-</option>
		      <?php 
		        foreach($companyList as $company){
		        if($_POST['company'] == $company->company_id){
		            $selected = "selected='selected'";
		        }else{
		            $selected = "";
		        }
		        ?>
		        <option value="<?php echo $company->company_id;?>" <?php echo $selected;?>><?php echo $company->company_name;?></option>
		        <?php }?>
		    </select>
		  </div>		
		</div>

	<div id="section"></div>
		
	</div>
	</div>

	<div class="col-md-6" id="col_3">
		
	</div>
</div>