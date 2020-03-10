    	  <label for="message">Appraisal Group</label>
  <select class="form-control" name="appraisal_type_group_id" required onchange="if(this.value == 'group'){manage_appraisal_group()}">

		        <option  disabled="" selected="" value="">select appraisal gorup</option><option value="group">create a group</option><?php foreach($res as $res){?><<option value="<?php echo $res->appraisal_group_id;?>"><?php echo $res->appraisal_group_name; ?></option><?php }?>

                  </select>