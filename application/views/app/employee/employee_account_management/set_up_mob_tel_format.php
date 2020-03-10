  
  <div class="col-md-2">Set up format:</div>
  <div class="col-md-10">
    <?php if($this->session->flashdata('success_inserted') AND $action_=='insert')
            { 
              echo '<div id="flashdata_result" style="padding-top:40px;"> <n class="text-danger" style="font-weight:bold;"> <center>Company ID - '.$flash_id.' Mobile and Telephone Format Setting is Successfully Added.</center></n></div>';
            } 
           else if($this->session->flashdata('success_updated') AND $action_=='update' )
            { 
              echo '<div id="flashdata_result" style="padding-top:40px;"> <n class="text-danger" style="font-weight:bold;"> <center>Company ID - '.$flash_id.' Mobile and Telephone Format Setting is Successfully Updated.</center></n></div>';
            } 
           else{}
    ?>
  <table class="table table-hover table-striped" id='table_tel_mob' style="margin-top:30px;">
       <thead class='text-success'>
            <tr class="danger">  
                <th>No.</th>
                <th>Location Name</th>
                <th>Telephone Format</th>
                <th>Mobile Format</th>
            </tr>
        </thead>
        <tbody >
        <?php if(empty($check_exist)){?>
        
        <?php if(empty($location)){ echo "<tr><td colspan='4' class='text-info'>No location added in this company. Please add to continue.</td></tr>"; } else{ 
          $i=1;
          $ii = 0;
          foreach ($location as $loc) { ?>
              <tr>
                  <td><?php echo $i."."?><input type="hidden" id="loc<?php echo $i;?>" value="<?php echo $loc->location_id?>"></td>
                  <td><?php echo $loc->location_name?></td>
                  <td><input type="text" name="tel" id="tel<?php echo $i?>" placeholder="sample format: xxx-xx" class="form-control" ></td>
                  <td><input type="text" name="mob" id="mob<?php echo $i?>" placeholder="sample format: xxx-xxxx" class="form-control"></td>
              </tr>
        <?php $i++;  $ii= $ii+1; } echo "<input type='hidden' value='".$ii."' id='number_fields'>"; } ?>
      
        <?php } else{
           $i=1;
          $ii = 0;
          foreach ($check_exist as $loc) { 

            ?>
              <tr>
                  <td><?php echo $i."."?><input type="hidden" id="loc<?php echo $i;?>" value="<?php echo $loc->location_id?>"></td>
                  <td><?php echo $loc->location_name?></td>
                  <td><input type="text" name="tel" id="tel<?php echo $i?>" value="<?php echo $loc->telephone_format?>" class="form-control" ></td>
                  <td><input type="text" name="mob" id="mob<?php echo $i?>" value="<?php echo $loc->mobile_format?>" class="form-control"></td>
              </tr>
        <?php $i++;  $ii= $ii+1; } echo "<input type='hidden' value='".$ii."' id='number_fields'>"; } ?>
          </tbody>
  </table>
  </div>

  <div class="col-md-12">
  <?php if(empty($check_exist)){

if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

    ?>
    <button class="btn btn-success pull-right" onclick="save_mob_tel('<?php echo $company_id?>','insert');" <?php if(empty($location)) { echo "disabled"; } ?>>Save </button>


    <?php
}

     } else{ 
if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

      ?>
      <button class="btn btn-success pull-right" onclick="save_mob_tel('<?php echo $company_id?>','update');">UPDATE CHANGES </button>
    <?php

}
     } ?>
  </div>


                           