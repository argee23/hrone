<div class="col-md-4">
      <label for="department">Select Subsection</label>
</div>

<div class="col-md-8">
        <select class="form-control select2" name="subsection" id="subsection"  required>
        <option value=""  selected="selected" disabled="">-Select Subsection-</option>                          
       
         <?php if($with_division==1){ } else{ echo "<option value='no_div'>Subsection is not required</option>";}?>
        <?php 
        foreach($subsectionList as $sub){
        echo "<option value='".$sub->subsection_id."' >".$sub->subsection_name."</option>";
        }
        ?>
        </select>  
</div>
 <div class="col-md-4" style="padding-top: 15px;" ><label>Location :</label></div>
 <div class="col-md-8" style="padding-top: 15px;">
    <?php $i= 0; if(empty($locationList)){?>
        <label>No Location Found</label></div>
    <?php } else{?>
        <select class="form-control select2" name="location" id="location"  required>
        <option value=""  selected="selected" disabled="">-Select Location-</option>                          
        <option value="All" >All</option>                          
      
        <?php 
        foreach($locationList as $loc){
        echo "<option value='".$loc->location_id."' >".$loc->location_name."</option>";
        }
        ?>
        </select>  
        <?php }?>
</div>
       
            