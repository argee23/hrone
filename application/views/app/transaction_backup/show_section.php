    <label>Section</label>
    <select class="form-control select2" name="section" id="section_add" style="width: 100%;" required onchange="active_transaction()">
      <option  value="" selected="selected" disabled="disabled" >-- Select Section --</option>
        <?php 
            $dept_id=$this->uri->segment('4');
            $get_section = $this->transaction_employees_model->getSec($dept_id);
            if(!empty($get_section)){
            foreach($get_section as $section){
            if($_POST['section'] == $section->section_id){
                $selected = "selected='selected'";
            }else{
                $selected = "";
            }
        ?>
        <option value="<?php echo $section->section_id;?>" <?php echo $selected;?>><?php echo $section->section_name;?></option>
        <?php 
            }
            }else{
            echo '<option value="all" >All</option>';

            }
        ?>
    </select>
