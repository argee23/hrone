<?php
    /*
    -----------------------------------
    start : user role restriction access checking.
    get the below variable at table "pages" field page_name
    -----------------------------------
    */

    $add_pr_hold_emp_reason=$this->session->userdata('add_pr_hold_emp_reason');
    $edit_pr_hold_emp_reason=$this->session->userdata('edit_pr_hold_emp_reason');
    $del_pr_hold_emp_reason=$this->session->userdata('del_pr_hold_emp_reason');
    $en_dis_pr_hold_emp_reason=$this->session->userdata('en_dis_pr_hold_emp_reason');

    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>

<div class="col-md-12" id="add_holdReason">

</div>


<table class="table table">
<thead>
	<tr>
		<th>Reason</th>
		<th>Status</th>
		<th>Option

<?php

echo "<a onclick='add_holdReason(".$company_id.")' type='button' class='".$add_pr_hold_emp_reason." pull-right'>";
echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i></a>';

?>
		</th>
	</tr>
</thead>
<tbody>
<?php
if(!empty($holdReasonList)){
	foreach($holdReasonList as $h){


        $edit = '<i class="'.$edit_pr_hold_emp_reason.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editReason('.$h->id.')"></i>';

        $disable = anchor('app/payroll_hold_employee/deactivate_reason/'.$h->id.'/'.$h->company_id,'<i class="'.$en_dis_pr_hold_emp_reason.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Deactivate?','onclick'=>"return confirm('Are you sure you want to Deactivate Reason?')"));

        $enable = anchor('app/payroll_hold_employee/activate_reason/'.$h->id.'/'.$h->company_id,'<i class="'.$en_dis_pr_hold_emp_reason.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Activate?','onclick'=>"return confirm('Are you sure you want to Activate Reason?')"));

        $delete = anchor('app/payroll_hold_employee/deleteReason/'.$h->id.'/'.$h->company_id,'<i class="'.$del_pr_hold_emp_reason.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete Reason?')"));

if($h->InActive=="1"){
	$enable_disable="$enable";
	$data_row_class="bg-danger";
	$data_row_status="InActive";

}else{
	$enable_disable="$disable";
	$data_row_class="";
		$data_row_status="Active";
}


		echo '
	<tr class="'.$data_row_class.'">
		<td>'.$h->reason.'</td>
		<td>'.$data_row_status.'</td>
		<td>'.$edit.' '.$delete.' '.$enable_disable.'</td>
	</tr>
		';
	}
}else{
		echo '
	<tr>
		<td colspan="2" class="text-danger">No added reason yet.</td>
	</tr>
		';
}

?>


</tbody>
	


</table>