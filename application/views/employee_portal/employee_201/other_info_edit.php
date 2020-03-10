<div class="row">
<div class="col-md-8">
<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>OTHER INFORMATION</strong> (edit)</div>
  <div class="box-body">
    <form method="post" action="<?php echo base_url()?>employee_portal/employee_201/other_info_modify/<?php echo $this->session->userdata('employee_id');?>" >
            
            <?php foreach ($employee_udf as $udf) { 
               $datass = $this->employee_201_profile_model->get_udf_data($udf->emp_udf_col_id,$this->session->userdata('employee_id'));
               $data_update = $this->employee_201_profile_model->get_udf_data_for_update($udf->emp_udf_col_id,$this->session->userdata('employee_id'));

               if(count($data_update)==0){ 
                  if(count($datass)>0)
                  {
                    $datas = $datass->data;
                  } else{ $datas ='';}
               } 
               else { $datas = $data_update->data; } 

              $udff=$udf->udf_type;
              if($udf->udf_not_null=='no'){ $d='';}
              else{ $d='required'; }
              ?>
                <div class="row">
                <div class="col-md-12">
                   <div class="form-group">
                   <input type="hidden" name="id<?php echo $udf->emp_udf_col_id?>" value="<?php echo $udf->emp_udf_col_id?>">
                    <input type="hidden" name="company<?php echo $udf->emp_udf_col_id?>" value="<?php echo $udf->company_id?>">
                      <label><?php echo $udf->udf_label?></label>
                    </div>
                </div>
                
                <div class="col-md-8">
                  <?php if($udff=='Textfield'){
                    if($udf->udf_accept_value=='Letters'){ 
                      $e ='type="text"  pattern="[A-Za-z].{0,}"'; }
                    elseif ($udf->udf_accept_value=='Numbers') {
                       $e ='type="number" min="1"';
                    }
                    else{ $e ='type="text"'; }
                    ?>
                      <input <?php echo $e;?> name="data<?php echo $udf->emp_udf_col_id?>" maxlength="<?php echo $udf->udf_max_length; ?>" class="form-control" value="<?php echo $datas?>" <?php echo $d?>>
                  <?php } elseif($udff=='Datepicker') {?>
                   <input type="date" name="data<?php echo $udf->emp_udf_col_id?>" value="<?php echo $datas?>">
                  <?php } elseif($udff=='Textarea') { ?>
                    <textarea name="data<?php echo $udf->emp_udf_col_id?>" class="form-control" rows="5" col="5" <?php echo $d?>><?php echo $datas?></textarea>
                  <?php } else{?> 
                    <select name="data<?php echo $udf->emp_udf_col_id?>" class="form-control" <?php echo $d?>>
                    <?php $dropdown = $this->employee_201_profile_model->get_udf_dropdowoption($udf->emp_udf_col_id);
                    echo "<option value=''>Select</option>";
                      foreach ($dropdown as $dr) {?>
                       <option <?php if($dr->optionLabel==$datas){ echo 'selected'; }?>><?php echo $dr->optionLabel?></option>
                      <?php }  ?>
                    </select>
                  <?php } ?>
                </div>
                </div><br>
            <?php } ?>

    <div class="form-group">
    <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> SAVE CHANGES</button>
    </div>
    </form>

</div>
</div>

</div>
</div>  
</div>
