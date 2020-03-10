<div class="col-md-4">
      <label for="department">Select Section</label>
</div>

<div class="col-md-8">
        <select class="form-control select2" name="section" id="section" onchange="get_subsection(this.value)" required>
        <option value=""  selected="selected" disabled="">-Select Section-</option>                          
        
        <?php 
        foreach($sectionList as $sec){
        echo "<option value='".$sec->section_id."' >".$sec->section_name."</option>";
        }
        ?>
        </select>  
</div>
       
            