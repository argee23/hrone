<div class="col-md-4">
      <label for="department">Select Department</label>
</div>
<div class="col-md-8">
        <select class="form-control select2" name="department" id="department" onchange="get_section(this.value)" required>
        <option value=""  selected="selected" disabled="">-Select Department-</option>                          
        
        <?php 
        foreach($departmentList as $dpt){
        echo "<option value='".$dpt->department_id."' >".$dpt->dept_name."</option>";
        }
        ?>
        </select>  
</div>
       
            