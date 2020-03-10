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
 $company_id=$this->uri->segment('4');
 $location=$this->input->post('location');
 $classification=$this->input->post('classification');
 $department=$this->input->post('department');
 $section=$this->input->post('section');

if(($location=="all")||($location=="All")||($location=="ALL")||($location=="aLl")||($location=="alL")){
			$final_loc="All";
		}else{
			$loc=$this->general_model->get_the_location($location);
			if(!empty($loc)){
				$final_loc=$loc->location_name;
			}else{
				$final_loc='notice: location id no longer exist.';
			}
		}
if(($classification=="all")||($classification=="All")||($classification=="ALL")||($classification=="aLl")||($classification=="alL")){
			$final_clas="All";
		}else{
			$clas=$this->general_model->get_the_classification($classification);
			if(!empty($clas)){
				$final_clas=$clas->classification;
			}else{
				$final_clas='notice: classification id no longer exist.';
			}
		}
if(($department=="all")||($department=="All")||($department=="ALL")||($department=="aLl")||($department=="alL")){
			$final_dept="All";
		}else{
			$dept=$this->general_model->get_the_department($department);
			if(!empty($dept)){
				$final_dept=$dept->dept_name;
			}else{
				$final_dept='notice: department id no longer exist.';
			}
		}
if(($section=="all")||($section=="All")||($section=="ALL")||($section=="aLl")||($section=="alL")){
			$final_sect="All";
		}else{
			$sect=$this->general_model->get_the_section($section);
			if(!empty($sect)){
				$final_sect=$sect->section_name;
			}else{
				$final_sect='notice: section id no longer exist.';
			}
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
      <?php echo $message;?>
        <?php echo validation_errors(); ?>

<form name="f" method="post" action="<?php echo base_url()?>app/time_fixed_schedule/save_add_group/<?php echo $company_id;?>/<?php echo $location;?>/<?php echo $classification;?>/<?php echo $department;?>/<?php echo $section;?>" > 

<table style="font-size: 11px;" class="table table-bordered table-striped">
<thead>
<tr>
	<td colspan="2"> 
<div class="col-md-12">
	<div class="panel panel-success">
			<div class="panel-heading"><strong> Location: <i class="fa fa-angle-double-right"></i> <?php echo $final_loc;?></strong></div>
			<div class="panel-heading"><strong> Classification: <i class="fa fa-angle-double-right"></i> <?php echo $final_clas;?></strong></div>
			<div class="panel-heading"><strong> Department: <i class="fa fa-angle-double-right"></i> <?php echo $final_dept;?></strong></div>
			<div class="panel-heading"><strong> Section: <i class="fa fa-angle-double-right"></i> <?php echo $final_sect;?></strong></div>
	</div>

<td>
<label class="col-md-12">
Enter Group Name :
</label>

<input type="text" name="group_name" placeholder="Enter Group Name" required class="form-control">

</td>
</tr>
	<tr>
		<th>Option</th>
		<th>Employee ID</th>
		<th>Name</th>
	</tr>
</thead>
<?php
//$employee_filter=$this->general_model->filter_employee($company_id,$location,$classification,$department,$section);
if(!empty($employee)){
	foreach($employee as $emp){
		echo '<tr>'.
		'<td> <input type="checkbox" name="selected_employee[]" value="'.$emp->employee_id.'"> </td>'.
		'<td>'.$emp->employee_id.'</td>'.
		'<td>'.$emp->name.'</td>'.
	'</tr>'		;
	}

}else{
echo '<tr>'.
		'<td colspan="3" class="text-danger text-center"> no employee found </td>'.
	'</tr>'		;	
}
?>

<tr>
	<td colspan="3">
        <button type="submit" class="btn btn-danger btn-md pull-right"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to Save Employee Group"><i class="fa fa-floppy-o"></i> Save</button>
	</td>
</tr>

</table>

</div>