
<label for="section" class="col-sm-12">Section<?php $check_dept=$this->uri->segment('4');?></label>
        <div class="col-sm-12" >
    <select class="form-control select2" name="section"  id="section" required onchange="fetch_sub_section()">

      <?php
      if(!empty($get_section)){
        echo '<option selected="selected" value="All">-All-</option>';
        foreach($get_section as $section){
            $check_ss=$section->wSubsection;
            if($check_ss=="0"){
              $subsection="no subsection";
              $sub_sec_color='style="color:#488C0D;"';
            }else if($check_ss=="1"){
              $subsection="with subsection";
              $sub_sec_color='style="color:#ff0000;"';  
            }else{
              $subsection="warning: no subsection setup yet.";
              $sub_sec_color='';  
            }
          if($_POST['section'] == $section->section_id){
              $selected = "selected='selected'";
          }else{
              $selected = "";
          }
            echo '<option value="'.$section->section_id.'"  '.$selected.''.$sub_sec_color.'>'.$section->section_name.'</option>';          
        }
       
      }else{
        if($check_dept=="All"){
echo '<option value="All" selected >All</option>';
        }else{
echo '<option value="" selected disabled>warning: no section yet.</option>';
        }

      }

        ?>  
    </select>      
    </div> 


