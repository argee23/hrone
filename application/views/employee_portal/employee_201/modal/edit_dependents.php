  <div class="modal-dialog">
 <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center></center></h4>
        
        <h4> <n class="text-danger"><i class="glyphicon glyphicon-certificate"></i><b>Update Dependents</b></n></h4>
      </div>
      <div class="modal-body" style="height:480px;">
             <form class="form-horizontal" name="pinfo_form" action="edit_dependent" method="post">
         <input type="hidden" name="id" id="id" value="<?php echo $dependent_id?>">
          <div class="form-group has-feedback">
            <label class="control-label col-sm-3" for="email">First Name</label>
            <div class="col-sm-9">
             
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php if(empty($data1)){ echo $data->first_name; } else{ echo $data1->first_name; }?> " required>
              
             
            </div>
          </div>
          <div class="form-group has-feedback" >
            <label class="control-label col-sm-3" for="email">Middle Name</label>
            <div class="col-sm-9">
           
            
              <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php if(empty($data1)){ echo $data->middle_name; } else{ echo $data1->middle_name; }?>">
             
            </div>
          </div>
          <div class="form-group has-feedback" >
            <label class="control-label col-sm-3" for="email">Last Name</label>
            <div class="col-sm-9">
              
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php if(empty($data1)){ echo $data->last_name; } else{ echo $data1->last_name; }?>" required>
              
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="email">Name Extension</label>
            <div class="col-sm-9">
            
                <input type="text" class="form-control" id="name_ext" name="name_ext" value="<?php if(empty($data1)){ echo $data->name_ext; } else{ echo $data1->name_ext; }?>" >
              
              
            </div>
          </div>
          <div class="form-group has-feedback" >
            <label class="control-label col-sm-3" for="email">Relationship</label>
            <div class="col-sm-9">
              <select class="form-control" name="relationship" id="relation"  onchange="genderr();" required>
                <?php 
                
                foreach ($relationshipList as $rel)
                { 
                  $check =  $this->employee_201_model->check_rel_exist($this->session->userdata('employee_id'),$rel->param_id);
                  if($check=='true'){ $d= ''; } else{ $d='disabled'; }
                  ?>
                      <option value="<?php echo $rel->param_id; ?>" <?php echo $d; if(empty($data1->relationship)){ if($data->relationship==$rel->param_id) { echo "selected"; } } else{ if($data1->relationship==$rel->param_id) { echo "selected"; } } ?> ><?php echo $rel->cValue; ?></option>
                  <?php
                }?>
              </select>
           
           
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="email">Civil Status</label>
             <div class="col-sm-9">
            
               
                <select class="form-control" name="civil_status" id="civil_status"  required>
                <?php foreach ($civilStatusList as $rel)
                { ?>
                      <option value="<?php echo $rel->civil_status_id; ?>"  ><?php echo $rel->civil_status; ?></option>
                  <?php
                }?>
              </select>
             
              </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3" for="email">Gender</label>
             <div class="col-sm-9">
              
             
              <select class="form-control" name="gender" id="gender"  required>
             
                <?php foreach ($genderList as $rel)
                { ?>
                      <option value="<?php echo $rel->gender_id; ?>" <?php if(empty($data1->gender)){ if($data->gender==$rel->gender_id) { echo "selected"; } } else{ if($data1->gender==$rel->gender_id) { echo "selected"; }}?>><?php echo $rel->gender_name; ?></option>
                  <?php
                }?>
              </select>
              
              </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="email">Birthday</label>
            <div class="col-sm-9">
            
               
              <input type="date"  name="birthday" value="<?php if(empty($data1)){ echo $data->birthday; } else{ echo $data1->birthday; }?>" >
              
            </div>
          </div>

        <div class="form-group">        
          <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-success" ng-disabled="pinfo_form.$invalid"> Save Changes</button>
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