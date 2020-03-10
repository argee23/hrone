<?php 
if($option=='department')
{
  if(empty($details))
  {
      echo "<option value=''>No section/s found.Please add to continue.</option>";
  }
  else
  {
     echo "<option value=''>Select</option>";
     foreach($details as $d)
     {
         echo "<option value='".$d->department_id."'>".$d->dept_name."</option>";
     }
  }
}
else
{
          if(empty($details))
          {?>
          <div class="col-md-12">
              <di class="col-md-12"><n class="text-danger">No <?php echo $option;?> found.</n></di>
          </div>
          <?php }
          else
          {
            $i=0;
            foreach($details as $d){
              if($option=='location')
              {
                $id   =    $d->lid;
                $name =    $d->location_name;
              }
              else if($option=='classification')
              {
                $id   =    $d->classification_id;
                $name =    $d->classification;
              }
              else if($option=='employment')
              {
                $id   =    $d->employment_id;
                $name =    $d->employment_name;
              }

              ?>

            <div class="col-md-12">
              <di class="col-md-12"><n class="text-danger"><input type="checkbox" id="<?php echo $option.$i;?>" value="<?php echo $id;?>" class="class<?php echo $option;?>" checked><?php echo $name;?></n></di>
          </div>
          <?php $i++; } echo "<input type='hidden' value='".$i."' id='count".$option."'> "; } 
}?>