 <div style="height:80px;">

          <div class="col-md-12">
	          <div class="col-md-6">
	          	<div class="col-md-4">Division</div>
	          	<div class="col-md-8">
	          		<select class="form-control" id="fdivision" onchange="get_department(this.value,'<?php echo $company;?>');">
	          	
	          		<?php if($with_division==0)
	          		{
	          			echo "<option value='not_included'>No division required in this company. You can proceed to next field.</option>";
	          		}
	          		else
	          		{
	          			echo "<option value='all'>All</option>";
	          			foreach($division as $div)
	          			{
	          				echo "<option value='".$div->division_id."'>".$div->division_name."</option>";
	          			}
	          		}?>
	          		</select>
	          	</div>
	          </div>
	           <div class="col-md-6">
	           <div class="col-md-4">Department</div>
	          	<div class="col-md-8">
	          		<input type="hidden" id="fcompany" value="<?php echo $company;?>">
	          		<select class="form-control" id="fdepartment" onchange="get_section(this.value,'<?php echo $company;?>');"> 
	          			<option value='not_included' disabled selected>Select</option>
	          			<?php if($with_division==0){
	          			foreach($department as $d)
	          			{
	          				echo "<option value='".$d->department_id."'>".$d->dept_name."</option>";
	          			

	          			} } ?>
	          		</select>
	          	</div>
	          </div>
	           
	            <div class="col-md-6" style="margin-top: 5px;">
	          	<div class="col-md-4">Section</div>
	          	<div class="col-md-8">
	          			<select class="form-control" id="fsection" onchange="get_subsection(this.value,'<?php echo $company;?>');">
	          					<option value='not_included' disabled selected>Select</option>
	          			</select>
	          	</div>
	          </div>
	           <div class="col-md-6"  style="margin-top: 5px;">
	           <div class="col-md-4">Subsection</div>
	          	<div class="col-md-8">
	          		<select class="form-control" id="fsubsection" onchange="get_filtering_result();">
	          			<option value='not_included' disabled selected>Select</option>
	          		</select>
	          	</div>
	          </div>

	           <div class="col-md-6"  style="margin-top: 5px;">
	          	<div class="col-md-4">Location</div>
	          	<div class="col-md-8">
	          		<select class="form-control" id="flocation" onchange="get_filtering_result();">
	          			<option value='not_included' disabled selected>Select</option>
	          			<?php if(empty($location))
	          			{
	          				echo "<option value='not_included'>No location/s found.</option>";
	          			}
	          			else
	          			{
	          				echo "<option value='all'>All</option>";
	          				foreach($location as $loc)
	          				{
	          					echo "<option value='".$loc->location_id."'>".$loc->location_name."</option>";
	          				}
	          			}?>
	          		</select>
	          	</div>
	          </div>
	           <div class="col-md-6"  style="margin-top: 5px;">
	           <div class="col-md-4">Classification</div>
	          	<div class="col-md-8">
	          		<select class="form-control" id="fclassification" onchange="get_filtering_result();">
	          			<option value='not_included' disabled selected>Select</option>
	          			<?php if(empty($classification))
	          			{
	          				echo "<option value='not_included'>No location/s found.</option>";
	          			}
	          			else
	          			{
	          				echo "<option value='all'>All</option>";
	          				foreach($classification as $cc)
	          				{
	          					echo "<option value='".$cc->classification_id."'>".$cc->classification."</option>";
	          				}
	          			}?>
	          		</select>
	          	</div>
	          </div>

          </div><br><br><br><br><br><br>
           <div class="box box-danger" class='col-md-12'></div>
            <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
	        
          <div class="col-md-12"  style="overflow: scroll;" id="filter_result">
            <table id="salary_approvers" class="col-md-12 table table-hover table-striped">
                <thead>
                  <tr  class="success">
                    <th style="width:5%;">ID</th>
                    <th style="width:15%;">Name</th>
                    <th style="width:15%;">Company ID</th>
                    <th style="width:15%;">Classification</th>
                    <th style="width:15%;">Location</th>
                    <th style="width:15%;">Department</th>
                    <th style="width:15%;">Section</th>
                    <th style="width:15%;">Subsection</th>
                    <th style="width:5%;">Approval Level</th>
                    <th style="width:5%;">Action</th>
                  </tr>
                </thead>
                <tbody> 
                <?php foreach($approver_details as $ad)
                {?>
                  <tr>
                    <td><?php echo $ad->id;?></td>
                    <td><?php echo $ad->fullname;?></td>
                    <td><?php echo $ad->company_name;?></td>
                    <td><?php echo $ad->classification;?></td>
                    <td><?php echo $ad->location_name;?></td>
                    <td><?php echo $ad->dept_name;?></td>
                    <td><?php echo $ad->section_name;?></td>
                    <td><?php echo $ad->subsection_name;?></td>
                    <td><?php 
                      $x=$ad->approval_level;
                       if($x=="1"){
                            $ext="st";
                          }else if($x=="3"){
                            $ext="rd";
                          }else if($x=="2"){
                            $ext="nd";
                          }else{
                            $ext="th";
                          }
                        echo $ad->approval_level.$ext." Approver "?></td>
                     <td>
                     	  <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  onclick="delete_one_approver('<?php echo $company;?>','<?php echo $ad->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Approver'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                     </td>
                  </tr>
                <?php } ?>
                </tbody>
       </table>  
        </div>
      </div>