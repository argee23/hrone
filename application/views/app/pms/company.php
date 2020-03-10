
  <select class="form-control" name="appraisal_company">
                          
           <option  disabled="" selected="" value="">Select company</option><?php foreach($res as $res){?><option value="<?php echo $res->company_id;?>"><?php echo $res->company_name; ?></option><?php } ?>
               
                  </select>