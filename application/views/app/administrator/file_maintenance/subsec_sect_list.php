		<div class="form-group">
			<label>Select Section</label>
		    <select class="form-control select2" name="section_add" id="section_add" style="width: 100%;" required="required" <?php if(isset($type)){ echo 'onchange="examineSectSubView(this.value)"'; } 
                else { echo 'onchange="examineSectSub(this.value)"'; } ?> >
		      <option selected="selected" disabled="disabled" value="">-Choose Section-</option>
		      <?php 
		        foreach($sectionList as $section){
		        ?>
		        <option value="<?php echo $section->section_id;?>"><?php echo $section->section_name;?></option>
		        <?php }?>
		    </select> 
		 </div>
		 <?php if(isset($type)){ echo '<div id="SubsectionView"></div>'; } 
         else { echo '<div id="addSubsection"></div>'; } ?>
		 