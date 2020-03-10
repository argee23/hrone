<?php $topic_location=$this->uri->segment('4');?>
<?php $company_=$this->uri->segment('5');?>



<br> <ol class="breadcrumb">
<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>General Form | Update</h4>
  </ol><br>



<div class="col-md-12 text-center">
<?php $form_location   = base_url()."app/pms/save_update_employee_objectives";?>
<form role="form" class="form-horizontal" id="update_employee_objectives" method="post" action="<?php echo $form_location?>">
<div class="row">

  <?php foreach($update_data as $row){?>

  <div class="col-md-6">
    <label>Name </label>

    <!-- <input type="text" class="form-control" required name="cover_year" value="<?php echo $row->cover_year?>"> -->

                <input type="text" class="form-control"  name="name" required  value="<?php echo $row->name ?>" />
              

  </div>
  <div class="col-md-6">
    <label>objectives  </label>

    <!-- <input type="text" class="form-control" required name="cover_year" value="<?php echo $row->cover_year?>"> -->

                <input type="text" class="form-control"  name="objectives" required  value="<?php echo $row->objectives ?>" />
              

  </div>
 

</div>


  </br>  <input type="hidden" name="company_" value="<?php echo $company_?>">
  <input type="hidden" name="id" value="<?php echo $row->id?>">

<div class="row text-center">
  <div class="col-md-6 col-md-offset-6 text-center  "></div>

   <input type="submit" class=" btn btn-primary" value="Update" onclick="save_update_employee_objectives(<?php echo $company_; ?>);" >
</div>
<?php } ?>
</form>
</div>
