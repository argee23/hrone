 <div class="modal-content">
      <div class="modal-header" >
        <h4 class="modal-title text-success"><b><center>Other Information</center></b></h4>
      </div>
      <div class="modal-body">
        <?php if(empty($employee_udf)) { echo "<h2 class='text-danger'>No Other info/s added.</h2>"; } else{ foreach ($employee_udf as $udf) {?>
                   <div class="col-md-12">
                    <div class="form-group">
                      <div class="col-sm-3">
                      <p><?php echo $udf->udf_label?></p>
                      </div>
                      <div class="col-sm-5">
                         <?php 
                            $data = $this->employee_201_profile_model->get_udf_data($udf->emp_udf_col_id,$this->session->userdata('employee_id'));
                            $data_update = $this->employee_201_profile_model->get_udf_data_for_update($udf->emp_udf_col_id,$this->session->userdata('employee_id'));
                            if(count($data)==0){ $data_o=''; } else{ $data_o = $data->data; }
                            if(count($data_update)==0){ $data_u=''; } else{ $data_u = $data_update->data; }
                          ?>
                          <label><?php echo $data_o?></label>
                          <?php if(empty($data_u)){} else{?>
                          <br> <label class='text-danger'><?php echo $data_u?></label>
                          <?php } ?>
                      </div>
                    </div>
                    </div>
                  <?php } }?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>



<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});

</script>