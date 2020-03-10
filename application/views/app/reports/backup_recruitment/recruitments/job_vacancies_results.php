
  <table class="col-md-12 table table-hover" id="req_report">
    <thead>
      <tr class="danger">
        <th>No.</th>
        <th>Company Name</th>
        <th>Position</th>
        <th>Slot</th>
        <th>Salary</th>
        <th>Job Description</th>
        <th>Job Qualification</th>
        <th>Hiring Start</th>
        <th>Hiring End</th>
        <th>Location</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; foreach($results as $row){?>
    <tr>  
        <td><?php echo $i;?></td>
        <td><?php echo $row->company_name;?></td>
        <td><?php echo $row->job_title;?></td>
        <td><?php echo $row->job_vacancy;?></td> 
        <td><?php echo number_format($row->salary,2);?></td> 
        <td><?php echo $row->job_description;?></td> 
        <td><?php echo $row->job_qualification;?></td> 
        <td><?php echo $row->hiring_start;?></td> 
        <td><?php echo $row->hiring_end;?></td>
        <td>
           <?php 
                  $province = $this->recruitments_model->get_province_city('provinces','id','name',$row->loc_province);
                  $city = $this->recruitments_model->get_province_city('cities','id','city_name',$row->loc_city);

                  echo $province.",".$city;
              ?>
        </td>
        <td><?php echo $row->status;?></td>
    </tr>
    <?php $i++; } ?>
    </tbody>
  </table>