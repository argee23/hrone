<?php $topic_location=$this->uri->segment('4');?>


<br> <ol class="breadcrumb">
<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>General Form | Update</h4>
  </ol><br>



<div class="col-md-12 text-center">
<?php $form_location   = base_url()."app/pms/update_appraisal_schedule";?>
<form role="form" class="form-horizontal" id="update_appraisal_schedule" method="post" action="<?php echo $form_location?>">
<div class="row">

  <?php foreach($res as $row){?>

  <div class="col-md-6">
    <label>Covered Year</label>

    <!-- <input type="text" class="form-control" required name="cover_year" value="<?php echo $row->cover_year?>"> -->
       <div class="input-group date" id="datePicker">
                <input type="text" class="form-control" onclick="date();" name="cover_year" required  value="<?php echo $row->cover_year ?>" />
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
              </div>
  </div>

  <div class="col-md-6">
    <label>Appraisal Period Type</label>

      <input type="hidden" name="id" value="<?php echo $row->mid?>">

  <select class="form-control appraisal_period_type_select" name="appraisal_period_type_id" required  >

                <option selected="" value="<?php echo $row->id?>"><?php echo $row->appraisal_period_type;?></option>
         <?php foreach($appraisal_period_type as $res){?>
                    <option value="<?php echo $res->id;?>"><?php echo $res->appraisal_period_type; ?></option>
                  <?php } ?>

                  </select>
  </div>

 

</div>
<div class="row">
  
    <div class="col-md-6">
    <label>Appraisal Type</label>


    <?php if(!empty($row->payroll_period_group_id)){ ?>
  <select class="form-control appraisal_type" name="payroll_period_group_id" required >
            <option  selected="" value="<?php echo $row->pay_type_id; ?>"><?php echo $row->pay_type_name;?></option>
         <?php foreach($payroll_period_group as $row){?><option value="<?php echo $row->pay_type_id;?>"><?php echo $row->pay_type_name; ?></option><?php }?>
    
<!--  -->
</select>
<?php echo $row->appraisal_group_name;?>
<?php  }elseif(!empty($row->appraisal_group_id)){?>
 <select class="form-control appraisal_type" name="appraisal_type_group_id" required >
            <option  selected="" value="<?php echo $row->appraisal_group_id; ?>"><?php echo $row->appraisal_group_name;?></option>
         <?php foreach($appraisal_group as $row){?><option value="<?php echo $row->appraisal_group_id;?>"><?php echo $row->appraisal_group_name; ?></option><?php }?>
    
<!--  -->
</select>

<?php }elseif(!empty($row->appraisal_company_id)){ ?>
  <select class="form-control appraisal_type" name="appraisal_company" required >
            <option  selected="" value="<?php echo $row->company_id; ?>"><?php echo $row->company_name;?></option>
         <?php foreach($company_ as $company){?><option value="<?php echo $company->company_id;?>"><?php echo $company->company_name; ?></option><?php }?>
    
<!--  -->
</select>
<?php } ?>

  </div> 
      <div class="col-md-6">
    <label>Number of Days</label>

        <input type="text" name="number_of_days" class="form-control" value="<?php echo $row->number_days;?>">

  </div> 
 
 
</div>

  </br>  <input type="hidden" name="hidden" value="<?php echo $topic_location?>">

<div class="row text-center">
  <div class="col-md-6 col-md-offset-6 text-center  "></div>

   <input type="submit" class=" btn btn-primary" value="Update" onclick="save_update_appraisal_schedule();" >
</div>
<?php } ?>
</form>
</div>
