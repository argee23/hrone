
<!-- //=========================================================================== -->
<div class="col-md-8">
<div class="box box-primary">
	<div class="box-header">
	Add Sending Email Records <button type="button" data-toggle="collapse" data-target="#demo" class="btn btn-danger btn-xs pull-right" ><i class="fa fa-plus"></i> add </button>
	</div>
<div class="box-body">
	<form name="f1" method="post" action="<?php echo base_url()?>app/transaction_employees/save_sending_email" >

<div id="demo" class="collapse col-md-12">
<div class="panel panel-info">
	<div class="panel-heading"><strong>Add Sending Email For Transactions</strong></div>
<div class="panel-body">		
  	<div class="form-group" id="show_selected_emp">
        <label for="select_assigned_filing" class="col-sm-2 control-label">
        <a type="button" class="btn btn-success btn-xs pull-left" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user-plus"></i> &nbsp;&nbsp;[Select Employee]</a></label>
        <div class="col-sm-10">
        <a data-toggle="modal" data-target="#showEmployeeList">
        <input type="text" name="employee" class="form-control" placeholder="Select Employee" >
		</a>

        </div>
    </div>
  	<div class="form-group">
        <label for="CompanyName" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" name="email" id="" placeholder="Email" required>
        </div>
    </div>
  	<div class="form-group">
        <label for="CompanyName" class="col-sm-2 control-label">Send Email When</label>
        <div class="col-sm-10">
          <input type="checkbox" name="during_applied" value="1">Applied<br>
          <input type="checkbox" name="during_approved" value="1">Approved<br>
          <input type="checkbox" name="during_rejected" value="1">Rejected<br>
          <input type="checkbox" name="during_cancelled" value="1">Cancelled
        </div>
    </div>
  	<div class="form-group">
        <label for="CompanyName" class="col-sm-2 control-label">Transaction</label>
        <div class="col-sm-10">
          <select class="form-control select2" name="form" required>
          <option value="" disabled selected> -- Select Transaction -- </option>
          <option value="all">All</option>
			<?php 
			$transaction = $this->transaction_employees_model->getAll();
			foreach($transaction as $t){
				echo '<option value="'.$t->identification.'">'.$t->form_name.'</option>';
			}
			?>
		  </select>
        </div>
    </div>
  	<div class="form-group">
        <label for="location" class="col-sm-2 control-label">Location</label>
        <div class="col-sm-10">
        <?php
		foreach($locationList as $loc){
			echo '<input type="checkbox" name="location[]" value="'.$loc->location_id.'">'.$loc->location_name.'<br>';
		}
		?>	
        </div>
    </div>
		<button type="submit" class="btn btn-primary pull-right btn-md" ><i class="fa fa-save"></i> Save</></button>

</form>

</div></div></div>

<!--//===========================================================================view  -->

<div class="col-md-12">
<div class="panel panel-info">
	<div class="panel-heading"><strong>Sending Email Records</strong><!-- <button type="button" data-toggle="collapse" data-target="#demo" class="btn btn-danger btn-xs pull-right" ><i class="fa fa-plus"></i> add </button> --></div>
<div class="panel-body">
<div class="table-responsive">   <!--  for table responsiveness -->   	
<table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <td>Transaction</td>
        <td>Employee</td>
        <td>Email</td>
      <td>Location</td>
      <td style="text-align: center;">Send Email When
      </td>
      <td>Action</td>
      </tr>
    </thead>
    <tbody>
    <?php 
    //tse = transaction sending email
    foreach($tse as $send_email){?>
      <tr>
      <td><?php 
      $value= $send_email->form_identification; 
      $the_form=$this->transaction_employees_model->get_form_form_name($value);
      echo $the_form->form_name;
      ?></td>
        <td><?php echo $send_email->name; ?></td>
        <td><?php echo $send_email->email; ?></td>
        <td><?php 
		foreach ($locationList as $l){
			
			$cur_form= $send_email->form_identification;
			$getloc= $this->transaction_employees_model->tran_send_email_location($cur_form,$l->location_id);
			if (!empty($getloc)){
                  $applicable="checked";
                  }else{
                  $applicable="";
                  }
			echo '<input type="checkbox" '.$applicable.' >'. $l->location_name."<br>";
		}
         ?></td>
        <td ><!-- applied -->
				<?php if($send_email->applied=="1"){echo '<input type="checkbox" checked>Applied';}else{echo  '<input type="checkbox" >Applied';} ?><br>
			<!-- approved -->
				<?php if($send_email->approved=="1"){echo '<input type="checkbox" checked>Approved';}else{echo  '<input type="checkbox" >Approved';} ?><br>
			<!-- rejected -->
				<?php if($send_email->rejected=="1"){echo '<input type="checkbox" checked>Rejected';}else{echo  '<input type="checkbox" >Rejected';} ?><br>
			<!-- cancelled -->
				<?php if($send_email->cancelled=="1"){echo '<input type="checkbox" checked>Cancelled';}else{echo  '<input type="checkbox" >Cancelled';} ?>
			</td>
        <td>
			<?php
			echo $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary"  data-toggle="tooltip" data-placement="left" title="Edit" onclick="editSendingEmail('.$send_email->trans_id.')"></i>'; 
			?>
			<a href="<?php echo base_url()?>app/transaction_employees/delete_sending_email/<?php echo $send_email->trans_id;?>/<?php echo $send_email->form_identification;?>"><i class="fa fa-times-circle fa-lg text-danger delete" data-toggle="tooltip" data-placement="left" title="Click to Delete '" onclick="return confirm('Are you sure you want to delete ?')"></i></a>

           <!--  <a href="" data-toggle="tooltip" data-placement="left" title="" onclick="return confirm('Are you sure you want to delete?')" data-original-title="Delete"><i class="fa fa-times-circle fa-lg text-danger delete"></i></a>  -->
                       
        </td>
		</tr>
		<?php } ?>
		</tbody>
		</table></div>

</div></div></div>
  		</div>  



  		    
  

  	</div>  
  </div>







  <!--//======================================Employee List Modal Container ==============================//-->
<div class="modal modal-primary fade" id="showEmployeeList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Select Employee</h4>
                </div>
          <div class="modal-body">
                                           
  <input onKeyUp="getEmployeeList(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                        <span id="showSearchResult">                        </span>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>                          
                  </div>
                </div>
            </div><!-- /.box-body -->
<!--//====================================== End Employee List Modal Container ==============================//-->

<div class="col-md-4" id="editSendingEmail"></div>

