<div class="row">
<?php
if(!empty($my_setting)){
?>

	<div class="col-md-12" id="col_3">
		
	</div>
	<div class="col-md-12">
		<div class="panel panel-success">
		  <!-- Default panel contents -->
		  <div class="panel-heading"><strong>Manage SMS Notification Settings <i class="fa fa-arrow-right"></i><?php echo $myCinFo->company_name;?></strong> </div>
<div class="panel-body">
<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/sms/save_sms_notif_setting/" >
<input type="hidden" name="company_id" value="<?php echo $this->uri->segment('4');?>">
<table class="table table-hover table-striped">
	<thead>
		<tr>
			<th>Topic</th>
			<th>Setting</th>
		</tr>
	</thead>
	<tbody>


<?php

	foreach($my_setting as $s){

		echo '
			<tr>
				<td>'.$s->setting_topic.'</td>
		';

		$mysetting=$this->sms_model->sms_notif_value($myCinFo->company_id,$s->id);
		$yes_sel="";
		$no_sel="";
		$no_setup_notice="";
		if(!empty($mysetting)){
			if($mysetting->setting=="on"){
				$yes_sel="selected";
			}else{
				$no_sel="selected";
			}
		}else{
			$no_setup_notice="<span class='text-danger'>no setup yet</span>";	
		}

		echo '
				<td>
					'.$no_setup_notice.'<select class="form-control" name="sms_notif_value_'.$s->id.'">
						<option value="" selecte ddisable style="color:#ff0000;">Select</option>
						<option disabled>&nbsp;</option>
						<option value="off" '.$no_sel.'>off</option>
						<option value="on" '.$yes_sel.'>on</option>						
					</select>
				</td>
			</tr>
		';


	}

?>
</tbody>

</table>


 <button type="submit" class="btn btn-danger pull-right"> Save </button>
</form>


</div>
</div>
</div>




<?php
}else{

}

?>


</div>