  <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Employee Aknowledgement Setting | <?php echo $company_name;?>
  
  </h4></ol>
  <div class="col-md-12"><br>
         
    <div class="col-md-12" id="actions">

    <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_acknowledgment_settings/save_settings/<?php echo $company;?>" >

      <div class="col-md-12">
          <textarea id="value" name="value"><?php echo $settings;?></textarea>
          <div style="margin-top:20px;">
            <button class="col-md-2 btn btn-sm btn-success pull-right"
<?php
if($update_acknow_setting=="hidden "){
  echo "disabled title='Not Allowed. Check Your User Rights.' ";
}else{
  echo '';
}
?>

            > SAVE CHANGES</button>
          </div>
      </div>

    </form>

    </div>

  </div>  
  <div class="btn-group-vertical btn-block"> </div>   
