
<div class="box box-primary">
	<div class="box-header">
	Edit Sending Email
	</div>
<div class="box-body">
	<form name="f1" method="post" action="<?php echo base_url()?>app/transaction_employees/save_edit_sending_email" >
<div class="col-md-12">
<div class="panel panel-danger">
<?php 

foreach($tse as $edit_tran){
	 $employee=$edit_tran->employee_id;
	 $email=$edit_tran->se_email;
	 $form_identification=$edit_tran->form_identification;
	 $date_created=$edit_tran->date_created;
	 $applied=$edit_tran->applied;
	 $approved=$edit_tran->approved;
	 $cancelled=$edit_tran->cancelled;
	 $rejected=$edit_tran->rejected;
?>
	<div class="panel-heading"><i class="fa fa-folder-open-o"></i> &nbsp;&nbsp;Edit Sending Email For <?php 
		 
      $value= $form_identification; 
      $the_form=$this->transaction_employees_model->get_form_form_name($value);
      echo "<u>".$the_form->form_name."</u>";
      ?> 
      </div>
<div class="panel-body">		

  	<div  class="form-group">
        <label for="employee" class="col-sm-12 control-label">
        <a type="button" class="btn btn-danger btn-xs pull-left"> <i class="fa fa-user"></i> &nbsp;&nbsp;<?php echo $edit_tran->name;?></a></label>
        <div class="col-sm-12">
        <input type="hidden" value="<?php echo $edit_tran->se_id;?>" name="tse" /> <!--tse: transaction sending email -->
        <input type="hidden" value="<?php echo $employee;?>" name="employee" />
        <input type="hidden" value="<?php echo $form_identification;?>" name="form" />        
        </div>
    </div>
  	<div class="form-group">
        <label for="email" class="col-sm-12 control-label">Email</label>
        <div class="col-sm-12">
          <input type="email" class="form-control" name="email" id="" placeholder="Email" required value="<?php echo $email;?>">
        </div>
    </div>
  	<div class="form-group">
        <label for="send_email_when" class="col-sm-12 control-label">Send Email When</label>
        <div class="col-sm-12">
          <input type="checkbox" name="during_applied" value="1" <?php if($applied=="1"){ echo "checked";}else{ echo "";} ?> >Applied<br>
          <input type="checkbox" name="during_approved" value="1" <?php if($approved=="1"){ echo "checked";}else{ echo "";} ?> >Approved<br>
          <input type="checkbox" name="during_rejected" value="1" <?php if($rejected=="1"){ echo "checked";}else{ echo "";} ?> >Rejected<br>
          <input type="checkbox" name="during_cancelled" value="1" <?php if($cancelled=="1"){ echo "checked";}else{ echo "";} ?> >Cancelled
        </div>
    </div>
  	<div class="form-group">
        <label for="location" class="col-sm-12 control-label">Location</label>
        <div class="col-sm-12">
        <?php
		foreach ($locationList as $l){			
			$cur_form= $form_identification;
			$getloc= $this->transaction_employees_model->tran_send_email_location($cur_form,$l->location_id);
			
			if (!empty($getloc)){
                  $applicable="checked";
                  }else{
                  $applicable="";
                  }
			echo '<input name="location[]"  value="'.$l->location_id.'" type="checkbox" '.$applicable.' >'. $l->location_name."<br>";
		}
		?>	
        </div>
    </div>
  <?php } ?>
		<button type="submit" class="btn btn-primary pull-right btn-md" ><i class="fa fa-save"></i> Save</></button>

</form>

</div></div>