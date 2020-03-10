<title><?php echo $this->session->userdata('sys_name');?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
rel="stylesheet">
<link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">



<?php
$company_id =$this->uri->segment('5'); //company id
$group_id =$this->uri->segment('4');

$group_detail=$this->time_fixed_schedule_model->delete($group_id); 
if(!empty($group_detail)){
    $group_name= $group_detail->group_name;

}else{
    $group_name='group not found';
}

  $company=$this->general_model->get_company_info($company_id);
  if(!empty($company)){
    $company_name =$company->company_name;
    $company_logo =$company->logo;
    $company_address =$company->company_address;
    $company_contact_no =$company->company_contact_no;
    $company_tin =$company->TIN;
  }else{
    $company_name ='company not found';
    $company_logo ='company not found';
    $company_address ='company not found';
    $company_contact_no ='company not found';
    $company_tin ='company not found';
  }

?>
<input type="hidden" value="<?php echo $company_id; ?>" id="company_id">
<input type="hidden" value="<?php echo $group_id; ?>" id="group_id">

<form name="f" method="post" action="<?php echo base_url()?>app/plot_schedule/save_admin_group_plot_sched/<?php echo $group_id;?>/<?php echo $company_id;?>" > 

<div class="table-responsive">
<table style="margin-left: auto;margin-right: auto;">
<tr>
    <th  style="text-align: center"><img src="<?php echo base_url();?>public/company_logo/<?php echo $company_logo ;?>" class="img-rounded" id="company_logo" width="120" height="120"><br>
    <strong>
    <?php 
    echo $company_name."<br>". $company_address."<br>Tel:". $company_contact_no;
    ?><br><small><?php echo date("F j, Y");?></small></strong>
    </th>
</tr>
</table>

    <div id="tableWrap" style="margin-left: 10px;margin-right: 10px;">

<table style="font-size: 11px;" class="table table-bordered table-striped">
<thead>
    <tr style="border-top:2px solid #000;">
        <th>Fixed Schedule</th>
        <th colspan="9">Group Name: <?php echo $group_name; ?></th>
    </tr>
    </thead>
    <tr>
        <th > Employee ID</th>
        <th > Employee Name</th>
        <th>Monday</th>
        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Thursday</th>
        <th>Friday</th>
        <th>Saturday</th>
        <th>Sunday</th>
         <th > Date Registered </th>
    </tr>

<?php 
$members=$this->time_fixed_schedule_model->get_members_of_group($company_id,$group_id);  
if(!empty($members)){
    foreach($members as $member){
        echo
         '<tr>'.
            '<td>'.$member->employee_id. '</td>'.
            '<td>'.$member->member_name. '</td>'.
            '<td>'.$member->mon. '</td>'.
            '<td>'.$member->tue. '</td>'.
            '<td>'.$member->wed. '</td>'.
            '<td>'.$member->thu. '</td>'.
            '<td>'.$member->fri. '</td>'.
            '<td>'.$member->sat. '</td>'.
            '<td>'.$member->sun. '</td>'.
            '<td>'.$member->date_added. '</td>'.
        '</tr>';
    }
}else{
        echo '<tr><td colspan="10" class="text-center text-danger"> -- no employee/group members yet -- </td></tr>';
}



?>

</table>

    </div>
</div>


</form>
