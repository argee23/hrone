
 <?php $form_location   = base_url()."app/pms/save_position_department_section/";?>
<form class = "form-horizontal" id="creator_options" method="post" action="<?php echo $form_location;?>">
<input type="hidden" name="company_" value="<?php  echo $this->uri->segment('5');  ?>"><input type="hidden" name="val" value="<?php  echo $this->uri->segment('4');  ?>">

         <div class = "form-group">
            <label for = "firstname" class = "col-sm-2 control-label">Position</label>
            <div class = "col-sm-8">
            	        <select id="s" class="form-control"  name="position" required="">  

			
			<option selected="" value="<?php if(!empty($position_department->position_name)){echo $position_department->position_id; } ?>"><?php if(!empty($position_department->position_name)){ echo $position_department->position_name;  }?></option>
      <?php $s = $this->pms_model->position(); foreach($s as $e){?>

      <option value="<?php  echo $e->position_id; ?>"><?php echo $e->position_name ?></option>
      <?php } ?>
    </select>
        
            </div>
         </div>
         <div class = "form-group">
            <label for = "lastname" class = "col-sm-2 control-label">Department</label>
            <div class = "col-sm-8">
         	        <select id="department" class="form-control"  name="department" required="" onchange="sec(this.value);">

  	<option selected="" value="<?php if(!empty($position_department->section_name)){ echo $position_department->department_id; }?>"> <?php if(!empty($position_department->dept_name)){ echo $position_department->dept_name; } ?></option>
      <?php $s = $this->pms_model->get_department(); foreach($s as $e){?>
		
      <option value="<?php  echo $e->department_id; ?>"><?php echo $e->dept_name ?></option>
      <?php } ?>
    </select>
            </div>
         </div>
   
           <div class = "form-group">
            <label for = "firstname" class = "col-sm-2 control-label">Competency requirement</label>
            <div class = "col-sm-8">
    			<input class="form-control" type="text" name="criteria" required="" value="<?php if(!empty($position_department->compentency_requirement)){ echo $position_department->compentency_requirement; }?>">
        
            </div>
         </div>
         <div class = "form-group">
            <div class = "col-sm-offset-2 col-sm-10">
         
        <input type="submit" name="submit" class="btn btn-primary"  onclick="save_position_department()" id="submit"  value="submit">
            </div>
         </div>
      </form>


   



