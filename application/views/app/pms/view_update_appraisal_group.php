<?php $topic_location=$this->uri->segment('4');?>

<br> <ol class="breadcrumb">
<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>General Form | Update</h4>
  </ol><br>



<div class="col-md-12 text-center">
<?php $form_location   = base_url()."app/pms/update_pms_group_appraisal";?>
<form role="form" class="form-horizontal" id="appraisal" method="post" action="<?php echo $form_location?>">
<div class="row">

  <?php foreach($pms_appraisal as $pms_appraisal){?>

  <div class="col-md-6">
    <label>Appraisal Group Name</label>

    <!-- <input type="text" class="form-control" required name="cover_year" value="<?php echo $row->cover_year?>"> -->

                <input type="text" class="form-control" name="group_name" required  value="<?php echo $pms_appraisal->appraisal_group_name ?>" />
            
             
  </div>

  <div class="col-md-6">
    <label>Group Details  </label>

      <input type="hidden" name="id" value="<?php echo $pms_appraisal->appraisal_group_id?>">
<input type="text" class="form-control"  name="group_details" required  value="<?php echo $pms_appraisal->appraisal_group_details ?>" />
  </div>

 

</div>

<input type="hidden" name="company_" value="<?php echo $this->uri->segment('5'); ?>">
  <br>  <input type="hidden" name="hidden" value="<?php echo $topic_location?>">

<div class="row text-center">
  <div class="col-md-6 col-md-offset-6 text-center  "></div>

   <input type="submit" class=" btn btn-primary" value="Update" onclick="save_update_group();" >
</div>
<?php } ?>
</form>
</div>
