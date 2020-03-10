
<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment_hris/ED16_email_save/<?php echo $company_id."/".$code;?>">
<div class="col-md-12">
  <div class="col-md-12" style="margin-bottom: 50px;">
  <u><h4 class="text-danger"><center>Assign Employee and Email for Email Notification (by company location)</center></h4></u>
  <div class="col-md-12" style="margin-top: 40px;">
      <table class="table table-hover" id="settings">
        <thead>
          <tr class="danger">
              <th style='width: 10px;'>ID</th>
              <th style='width: 30px;'>Location</th>
              <th style='width: 30px;'>Employee</th>
              <th style='width: 30px;'>Email</th>
          </tr>
        </thead>
        <tbody>
        <?php $i=1; foreach($location as $l){
          $data = $this->recruitment_hris_model->get_email_ED16($l->location_id,$company_id);
        ?>
          <tr>
              <td><?php echo $i;?></td>
              <td><?php echo $l->location_name;?></td>
              <td>
                  <select class="form-control" name="admin<?php echo $l->location_id;?>" style='width:100%;' required>
                    <option value="" disabled selected>Select Employee</option>
                    <?php foreach($admin as $a){?>
                        <option value="<?php echo $a->employee_id;?>" <?php if(!empty($data->employee_id)){ if($data->employee_id==$a->employee_id){ echo "selected";}}?>><?php echo $a->fullname;?></option>
                    <?php } ?>
                  </select>
              </td>
              <td>
                  <input type="email" style='width:100%;' class="form-control" name="email<?php echo $l->location_id;?>" id="email<?php echo $l->location_id;?>" required value="<?php if(!empty($data->email)){ echo $data->email; }?>" >
              </td>
          </tr>
        <?php $i++; } ?>
        </tbody>
      </table>
      <div class="col-md-8">
        <button class="col-md-6 btn btn-success pull-right">SAVE</button>
      </div>
  </div>
  </div>
</div>

</form>