
<?php $check_sub_sec=$this->uri->segment('4');?>
<div class="form-group">
<label for="subsection" class="col-sm-5 control-label">Sub- Section</label>
<div class="col-sm-7">
    <select class="form-control select2" name="sub_section"  id="sub_section" ng-model="section">

      <?php
      if(!empty($get_sub_section)){
        echo '<option selected="selected" value="All">-All-</option>';
        foreach($get_sub_section as $sub_sec){

            echo '<option value="'.$sub_sec->subsection_id.'">'.$sub_sec->subsection_name.'</option>';          
        }
       
      }else{
        if($check_sub_sec=="All"){
echo '<option value="All" selected >All</option>';
        }else{

if($check_section->wSubsection=="1"){
echo '<option value="" selected disabled>warning: no sub-section setu up yet.</option>';
}else{
echo '<option value="not_applicable" selected>not applicable to above selected section : you may ignore me</option>';	
}
        }
      }

        ?>

   
    </select>   
    </div>    
</div>

