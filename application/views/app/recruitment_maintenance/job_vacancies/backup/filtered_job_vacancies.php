
<div class="col-md-12" style="margin-bottom: 30px;" id="printableArea">
  <div class="datagrid">

  <?php  foreach ($plantilla as $pp) {?>

      <table>
          <thead>
              <tr>
                <th colspan="5">Plantilla : <?php echo $pp->plantilla_no;?></th>
              </tr>
          </thead>
          <tbody>

            <?php foreach($department as $d){
            ?>
              <tr>
                <td colspan="5"><b>Department : <?php echo $d->dept_name;?></b></td>
              </tr>
              <?php foreach($location as $l){
                  $job_vacancies = $this->recruitment_plantilla_model->get_job_vacancies_dept_location($pp->id,$d->department_id,$l->location_id);
              ?>
                  <tr class="alt">
                    <td style="width: 10%;"></td>
                    <td colspan="4"><i>Location : <?php echo $l->location_name;?></i></td>
                  </tr>

                    <?php if(empty($job_vacancies)){ echo "<tr><td colspan='4'><n class='text-success' style='margin-left:200px;'>No Job Vacancies Found</n></td></tr>";}else{?>

                    <tr>
                        <td colspan="2" style="width: 40%;"></td>
                        <td style="width: 30%;"><n class='text-danger'><b>Position</b></n></td>
                        <td style="width: 30%;"><n class='text-danger'><b>Job Vacancy</b></n></td>
                        <td></td>
                    </tr>

                    <?php foreach($job_vacancies as $jv){
                    ?>
                        <td colspan="2"></td>
                        <td><?php echo $jv->job_title;?></td>
                        <td><?php echo $jv->job_vacancy;?></td>
                        <td><a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitment_plantilla/view_job_details')."/".$jv->company_id."/".$employer_type."/".$jv->job_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to View Job Details'><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a></td>
                    </tr>
                    <?php } } ?>

              <?php } ?>    
              <tr class="alt">
                  <td colspan="4"></td>
              </tr>
            <?php } ?>
          </tbody>
      </table>

    <?php } ?>
  </div>
</div>

