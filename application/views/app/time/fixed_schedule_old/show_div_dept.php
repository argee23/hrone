
<div class="form-group"  >
        <label for="department" class="col-sm-2 control-label">Division - Department</label>
    <div class="col-sm-10">
        <select name="department" class="form-control" id="department_id"  required onchange="fetch_section();"><!--  clear_fetched_sub_sec(); -->

      <?php 
      if(!empty($get_div_dept)){
        echo '<option value="All" selected>All</option>';
        foreach($get_div_dept as $dept){
            if($_POST['dept'] == $dept->department_id){
                $selected = "selected='selected'";
            }else{
                $selected = "";
            }
            echo '<option value="'.$dept->department_id.'"  '.$selected.'>'.$dept->dept_name.'</option>';
        }


      }else{
?>
        <option value="" selected disabled>warning: no department yet.</option>
<?php
      }

?>
        </select>
    </div>
</div>  