
<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_division=$this->session->userdata('add_division');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>
<div class="row">
	<div class="col-md-7">
		<div class="panel panel-info">

		<div class="panel-heading"><strong>Division</strong> <a onclick="addDivision()" type="button" class="<?php echo $add_division;?> btn btn-default btn-xs pull-right" title="Add">
      <?php
      echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
      ?>    
      </a></div>
			<div class="panel-body">
				<div class="col-md-12">
          			<label>Filter by Company:</label>
          			<select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="fetchDivision(this.value)">
          			<option selected="selected" disabled="disabled" value="0">- Select Company -</option>
          				<?php 
            				foreach($companyList as $company){
            				if($_POST['company'] == $company->company_id){
                				$selected = "selected='selected'";
            				}
            				else{
               					$selected = "";
            				}
                    if($company->wDivision=="1"){


            			?>
            		<option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
            			<?php 
                }else{
                }

                  }?>
          			</select>
          			<div id="fetch"></div>
        		</div>
			</div>
		</div>
	</div>

	<div class="col-md-5" id="col_3">
		
	</div>
</div>
