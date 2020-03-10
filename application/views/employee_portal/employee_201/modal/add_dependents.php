  <div class="modal-dialog">
 <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center></center></h4>
        
        <h4> <n class="text-danger"><i class="glyphicon glyphicon-certificate"></i><b>Add Dependents</b></n></h4>
      </div>
      <div class="modal-body" style="height:480px;">
            <form class="form-horizontal" name="info_form" action="add_dependent" method="post" onsubmit="return  checkStartDate('add_birthday', 'info_form')">
          <div class="form-group has-feedback">
            <label class="control-label col-sm-3" for="email">First Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
            </div>
          </div>
          <div class="form-group has-feedback" >
            <label class="control-label col-sm-3" for="email">Middle Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name" >
            </div>
          </div>
          <div class="form-group has-feedback" >
            <label class="control-label col-sm-3" for="email">Last Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="email">Name Extension</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="name_ext" name="name_ext" placeholder="Name Extension (II, III, Jr. etc.)">
            </div>
          </div>
          <div class="form-group has-feedback" >
            <label class="control-label col-sm-3" for="email">Relationship</label>
            <div class="col-sm-9">
              <select class="form-control" name="relationship" id="relation"  onchange="genderr();" required>
                <?php
                echo "<option value='' selected disabled>Select</option>";
                 foreach ($relationshipList as $rel)
                { 
                  $check =  $this->employee_201_model->check_rel_exist($this->session->userdata('employee_id'),$rel->param_id);
                  if($check=='true'){ $d= ''; } else{ $d='disabled'; }
                  ?>
                      <option value="<?php echo $rel->param_id; ?>" <?php echo $d?>><?php echo $rel->cValue; ?></option>
                  <?php
                }?>
              </select>
            </div>
          </div>
          <div class="form-group has-feedback">
            <label class="control-label col-sm-3" for="email">Civil Status</label>
             <div class="col-sm-9">
              <select class="form-control" name="civil_status" id="civil_status"  required>
             
                <?php 

                foreach ($civilStatusList as $rel)
                {  $check =  $this->employee_201_model->check_rel_exist($this->session->userdata('employee_id'),$rel->param_id);
                  if($check=='true'){ $d= ''; } else{ $d='disabled'; }
                  ?>
                      <option value="<?php echo $rel->civil_status_id; ?>" <?php echo $d;?> ><?php echo $rel->civil_status; ?></option>
                  <?php
                }?>
              </select>
              </div>
          </div>

          <div class="form-group has-feedback">
            <label class="control-label col-sm-3" for="email">Gender</label>
             <div class="col-sm-9">
              <select class="form-control" name="gender" id="gender" required>
              <option value="">Select</option>
                <?php foreach ($genderList as $rel)
                { ?>
                      <option value="<?php echo $rel->gender_id; ?>"  ><?php echo $rel->gender_name; ?></option>
                  <?php
                }?>
              </select>
              </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="email">Birthday</label>
            <div class="col-sm-9">
              <input type="date" id="add_birthday" name="add_birthday" >
            </div>
          </div>

        <div class="form-group">        
          <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-success" ><i class="fa fa-plus-circle"></i> Add Dependent</button>
             <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          </div>
        </div>

        </form>
         </div>
      </div>
    </div>
</div>
    
<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});

 function genderr()
      {
        var val = document.getElementById('relation').value;
        if(val==71 || val==74 || val==75 || val==79)
        { 
            document.getElementById('gender').value=2;
            document.getElementById('gender').disabled=true;
        }
        else if(val==70 || val==73 || val==76 || val==78)
        {  document.getElementById('gender').value=1;
            document.getElementById('gender').disabled=true;
         }
        else{
          document.getElementById('gender').value="";
          document.getElementById('gender').disabled=false;

        }
      }

     
</script>