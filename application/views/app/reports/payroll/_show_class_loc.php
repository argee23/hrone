<?php
echo "
<div class='col-md-12'>
<div class='col-md-3'>Classification :</div>
          <div class='col-md-6' style='padding-bottom:10px;'>";
          $ii=0;
      foreach ($comp_class as $row) { ?>
        <input type='checkbox' checked class='classification' value='<?php echo "cc".$row->classification_id?>' ><?php echo $row->classification."<br>"?>
        <?php $ii = $ii + 1; } echo "<input type='hidden' id='c_classification' value='".$ii."'></div></div>";


echo "<div class='col-md-12'><div class='col-md-3'>Location :</div>
          <div class='col-md-6' style='padding-bottom:10px;'>";
         $i=0;
      foreach ($comp_loc as $row) { ?>
        <input type='checkbox' checked class='location' value='<?php echo "ll".$row->location_id?>' onchange="result_onchange('classification',this.value)" ><?php echo $row->location_name?><br>
        <?php $i = $i + 1; }  echo "<input type='hidden' id='c_location' value='".$i."'></div></div>";
?>