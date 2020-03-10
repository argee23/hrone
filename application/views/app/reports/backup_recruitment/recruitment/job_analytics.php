<!-- <div class="well"> -->
  <div class="box box-success">
    <div class="box-header">
      <!-- <h1>Coachella</h1> -->
    </div>
    <div class="box-body">
      <h3> Job Analytics Reports</h3>
      <h4> Filter Report by: </h4>
      <div class="row">
      <div class="col-md-3">
          <label>Company :</label>
          <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="reportsAnalytics()">
<?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
 }else{
  echo '<option selected="selected" value="0"> All Companies </option>';
 } 
?>  


          <?php 
            foreach($companyList as $company){
            if($_POST['company'] == $company->company_id){
                $selected = "selected='selected'";
            }else{
                $selected = "";
            }
            ?>
            <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
            <?php }?>
          </select>
      </div>
      <div class="col-md-3">
        <label>Position :</label>
        <select class="form-control select2" name="position" id="position" style="width: 100%;" onchange="reportsAnalytics()">
        <option selected="selected" value="0"> All Position </option>
        <?php 
          foreach($alljobsList as $job){ //alljobsList2
          ?>
          <option value="<?php echo $job->job_title;?>"><?php echo $job->job_title;?></option>
          <?php }?>
        </select>
       </div>
       <div class="col-md-3">
        <label>Slot :</label>
        <input type="text" name="slot" class="form-control" id="slot" onKeyUp="reportsAnalytics()"/>
      </div>
    </div>
    <div class="row">
    </div>
    <!-- <div class="row"> -->
    <div class="col-md-12" id="fill" style="padding: 0 0 1% 0">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <hr>
      </div>
    </div>
    <table id="jobAnalytics" class="table table-bordered table-striped">
            <thead>
            	<tr>
                    <th>Company Name</th>
                    <th>Position</th>
                    <th>Slot</th>
                    <th>Current Available</th>
                        <?php
              				if(!empty($app_active_optionList)){
                  			foreach($app_active_optionList as $stat_opts){
						?>
					<th><?php echo $stat_opts->status_title; ?></th>
						<?php
                 		} }
                 			else{
                  			}
						?>
                </tr>
            </thead>
            <tbody>
                      <?php foreach($alljobsList as $jobs){?>
      			<tr>
      				<td><?php echo $jobs->company_name; ?></td>
      				<td><b><?php echo $jobs->job_title; ?></b> </td>
     				<td><?php echo $jobs->job_vacancy; ?></td>
     				<td><?php

						$jobs->company_id; 
							$hired_app=$this->general_model->hired_applicantList($jobs->company_id,$jobs->job_id);
							$array_items = count($hired_app);
							echo $jobs->job_vacancy-$array_items;

      					?></td>
						<?php

              				if(!empty($app_active_optionList)){
                  			foreach($app_active_optionList as $stat_opts){
						?>
					<td>

						<?php 

							$app_stat=$this->general_model->appStatus_List($jobs->company_id,$jobs->job_id,$stat_opts->app_stat_id);
							$array_items2 = count($app_stat);

 							// if($array_items2=="0"){
  						// 		$change_bg="";
 							// }
 							// else{
  						// 		$change_bg='style="background-color:#ff0000;"';
 							// }
							echo $array_items2.'</br>';
							$no = 1;
							foreach($app_stat as $app){
   							echo '<div>('.$no.') '.$app->fullname.'</div>';
   							$no++;
							}


							echo '</div>';
						?>
							
					</td>
						<?php
              				} }else{
                  		}
						?>
      			</tr>
      					<?php } ?>  
        </tbody>
    </table>
    </div>
    </div>
    </div>
<!-- </div> -->


