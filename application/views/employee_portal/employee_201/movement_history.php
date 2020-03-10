<div class="row">
<div class="col-md-8">
<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>MOVEMENT HISTORY</strong></div>
  <div class="box-body" style="height: 560px;">
       <div class="scrollbar_all" id="style-1" style="height: 470px;">
         <div class="force-overflow">
          <div class="row">
            <div class="col-md-12">
            <div class="form-group">

                <?php foreach($movement_history_view as $movement_history){
                 $movement = $this->employee_201_profile_model->get_movement($movement_history->movement_type_id);?>

                <div class="panel panel-danger">
                  <div class="panel-heading"><strong><?php echo $movement." | ".date('d M Y', strtotime($movement_history->date_time)); ?></strong>
                <?php if(empty($movement_history->attached_file)){} else{?>
                  <a href="<?php echo base_url(); ?>app/employee_201_profile/download_movement_history/<?php echo $movement_history->attached_file; ?>" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Download attached file <?php echo $movement_history->attached_file?>"><i class="fa fa-download fa-2x text-success pull-right"></i></a> 
                  <?php } ?>
                  

                </strong></a></div>
                  <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th>From</th>
                        <th>To</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Company</td>
                        <td><?php echo $movement_history->company_name_from; ?></td>
                        <td><?php echo $movement_history->company_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Location</td>
                        <td><?php echo $movement_history->location_name_from; ?></td>
                        <td><?php echo $movement_history->location_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Division</td>
                        <td><?php echo $movement_history->division_name_from; ?></td>
                        <td><?php echo $movement_history->division_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Department</td>
                        <td><?php echo $movement_history->department_name_from; ?></td>
                        <td><?php echo $movement_history->department_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Section</td>
                        <td><?php echo $movement_history->section_name_from; ?></td>
                        <td><?php echo $movement_history->section_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Subsection</td>
                        <td><?php echo $movement_history->subsection_name_from; ?></td>
                        <td><?php echo $movement_history->subsection_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Employment</td>
                        <td><?php echo $movement_history->employment_name_from; ?></td>
                        <td><?php echo $movement_history->employment_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Classification</td>
                        <td><?php echo $movement_history->classification_name_from; ?></td>
                        <td><?php echo $movement_history->classification_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Taxcode</td>
                        <td><?php echo $movement_history->taxcode_name_from; ?></td>
                        <td><?php echo $movement_history->taxcode_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Pay type</td>
                        <td><?php echo $movement_history->pay_type_name_from; ?></td>
                        <td><?php echo $movement_history->pay_type_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Report to</td>
                        <td><?php echo $name = $this->employee_201_profile_model->report_name($movement_history->report_to_from); ?></td>
                        <td><?php echo $movement_history->report_to_name; ?></td>
                      </tr>
                       <tr class='success'>
                        <td colspan="3">Comment : <n class='text-success'><?php echo $movement_history->comment; ?></n></td>
                       
                      </tr>
                      

                    </tbody>
                  </table>
                  </div>
                  </div>
                <?php } ?>

                <?php if(count($movement_history_view)<=0){?>
                <tr>
                  <td>
                  <p class='text-center'><strong>No Movement history(ies) yet.</strong></p>
                  </td>
                </tr>
                <?php } ?>

            </div>
            </div>

             </div>
             </div>
     </div> 
     </div>

</div>
</div>

</div>  
</div>

</div>  
</div>
</div>


