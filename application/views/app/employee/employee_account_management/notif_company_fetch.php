<div class="col-md-12" id='division'>
				          
				</div>
				      <hr>
				      <div class="col-md-12" id='department' style="padding-top: 15px;">
				         
				      </div>

				      <div class="col-md-12" id='section' style="padding-top: 15px;">
				          
				      </div>

				     <div class="col-md-12" id='subsection' style="padding-top: 15px;">
				         
				      </div>


				      
				      <div class="col-md-12" name="location" id="location" style="padding-top: 15px;">
				      <div class="col-md-3">Location :</div>
				          <div class="col-md-9">
				          <?php $i= 0; if(empty($location)){?>
				          			 <label>No Location Found</label></div>
				          <?php } else{?>
				           
				          <?php foreach($location as $row){ ?>
				         <div class='col-md-6'>  <input type='checkbox' class='location' id='div<?php echo $i?>' value='<?php echo $row->location_id?>' checked><?php echo $row->location_name?></div>

        					<?php $i = $i + 1; } }  echo "<input type='hidden' id='c_location' value='".$i."'></div>";?>
				          </div>
				         </div>
				         	
				      </div>

				       <div class="col-md-12" id='classification' style="padding-top: 15px;">
				        <div class="col-md-3">Classification :</div>
				          <div class="col-md-9">
				          <?php $i= 0; if(empty($classification)){?>
				          		 <label>No Classification Found</label></div>
				          <?php } else{?>
				         
				          <?php foreach($classification as $row){ ?>
				         <div class='col-md-6'>  <input type='checkbox' class='classification' id='div<?php echo $i?>' value='<?php echo $row->classification_id?>' checked><?php echo $row->classification?></div>

        					<?php $i = $i + 1; } }  echo "<input type='hidden' id='c_classification' value='".$i."'></div>";?>
				          </div>
				         </div>
				      </div>

				      </div>

				       <div class="col-md-12" id='employment' style="padding-top: 15px;">
				        <div class="col-md-3">Employement :</div>
				          <div class="col-md-9">
				          <?php $i= 0; if(empty($employment)){?>
				          		 <label>No Employment Found</label></div>
				          <?php } else{?>
				          
				          <?php foreach($employment as $row){ ?>
				         <div class='col-md-6'>  <input type='checkbox' class='employment' id='div<?php echo $i?>' value='<?php echo $row->employment_id?>' checked><?php echo $row->employment_name?></div>

        					<?php $i = $i + 1; } }  echo "<input type='hidden' id='c_employment' value='".$i."'></div>";?>
				          </div>
				         </div>
				      </div>

				      </div>



				      <div class="col-md-12" style="padding-top: 15px;">
				      
				          <div class="col-md-3">Employee Status :</div>
				          <div class="col-md-9">
				            <select class="form-control" id="status">
				              <option value='All'>All</option>
				              <option value="0" selected>Active</option>
				              <option value="1">InActive</option>
				            </select>
				           </div>
				          </div>
				      </div>
					<div class='col-md-12'>
						<button class='btn btn-success pull-right' id='save' onclick="save_notifdata_one_emp('One_emp','<?php echo $account_management_policy_id?>');" style='margin-left: 5px;'>Save</button>	
					</div>