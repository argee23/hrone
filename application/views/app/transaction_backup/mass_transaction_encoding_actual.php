<title><?php echo $this->session->userdata('sys_name');?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
rel="stylesheet">
<link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
<!-- //=======================export to excel -->
<script type="text/javascript" src="<?php echo base_url()?>/public/jquery-1.9.0.js"></script>
<script type="text/javascript">
$(function(){
$('#export').click(function(){
     //getting values of current time for generating the file name
        var dt = new Date();
        var day = dt.getDate();
        var month = dt.getMonth() + 1;
        var year = dt.getFullYear();
        var hour = dt.getHours();
        var mins = dt.getMinutes();
        var postfix = year + "-" + month + "-" + day ;
        //creating a temporary HTML link element (they support setting file names)
        var a = document.createElement('a');
        //getting data from our div that contains the HTML table
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById('tableWrap');
        var table_html = table_div.outerHTML.replace(/ /g, '%20');
        a.href = data_type + ', ' + table_html;
        //setting the file name
        a.download = postfix + '_Mass_Transaction_Encoding' + '.xls';
        //triggering the function
        a.click();
        //just in case, prevent default behaviour
        e.preventDefault();
   
})
})
</script>
<?php 
		$value =$this->input->post('form');
		$the_form=$this->transaction_employees_model->get_form_form_name($value);
		if(!empty($the_form)){
			$the_form_name 		= $the_form->form_name;
			$the_form_tablename	=	$the_form->t_table_name;
			}else{
			$the_form_name ="";
			$the_form_tablename	="";
		}

$location = $this->input->post('location');//	echo "<br>";
$clas = $this->input->post('classification');	//echo "<br>";
$dept = $this->input->post('department');	//echo "<br>";
$sect = $this->input->post('section');	//echo "<br>";
$date_from = $this->input->post('date_from');	//echo "<br>";
$date_to = $this->input->post('date_to');	//echo "<br>";
$mass_encode_option = $this->input->post('mass_encode_option');	//echo "<br><br>";

$f_month=substr($date_from, 5,2);
$f_day=substr($date_from, 8,2);
$f_year=substr($date_from, 0,4);

$t_month=substr($date_to, 5,2);
$t_day=substr($date_to, 8,2);
$t_year=substr($date_to, 0,4);

 $cID=$this->session->userdata('company_id');
  $company=$this->transaction_employees_model->get_emp_company($cID);
  foreach($company as $comp_det){
    $company_name =$comp_det->company_name;
    $company_logo =$comp_det->logo;
    $company_address =$comp_det->company_address;
    $company_contact_no =$comp_det->company_contact_no;
    $company_tin =$comp_det->TIN;
  }
?>
<div class="table-responsive">

<form name="f" method="post" action="<?php echo base_url()?>app/transaction_employees/save_mass_encode/<?php echo $the_form_tablename;?>/<?php echo $the_form_name;?>/<?php echo $value;?>/<?php echo $location;?>/<?php echo $clas;?>/<?php echo $dept;?>/<?php echo $sect;?>/<?php echo $date_from;?>/<?php echo $date_to;?>/" > 

<?php
$datefrom = new DateTime($date_from);
			$dateto = new DateTime($date_to);
			$diff = $dateto->diff($datefrom)->format("%a");
			$colspan=$diff+1;
?>
<table style="margin-left: auto;margin-right: auto;">

	  <tr >
    <th  style="text-align: center"><img src="<?php echo base_url();?>public/company_logo/<?php echo $company_logo ;?>" class="img-rounded" id="company_logo" width="120" height="120"><br>
    <strong>
    <?php 
    echo $company_name."<br>". $company_address."<br>Tel:". $company_contact_no;
    ?><br><?php// echo date("F j, Y");?></strong>
    </th>
  </tr>
</table>

  <div id="tableWrap" style="margin-left: 10px;margin-right: 10px;">
	<table style="font-size: 11px;" class="table table-bordered table-striped">
	<thead>
	<tr style="text-align: center;display: none;">
		<td colspan="<?php echo $colspan+3;?>" >
		<table style="font-size: 11px;width: 20%;text-align:center;" class="table table-bordered table-striped">
			<tr >
		<td style="background-color: #75E77D;width: 25%;"><strong>Rest day</strong></td>
		<td style="background-color: #FFF633;width: 25%;"><strong>Holiday</strong></td>
		<td style="background-color: #65CCB8;width: 25%;"><strong>Holiday - Rest day</strong></td>
		<td style="background-color: #E78275;width: 25%;"><strong>Sunday</strong></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr style="border-top:2px solid #000;">
		<th colspan="2" style="text-align: center;">Mass Transaction Encoding <br>
		[ <u>
		<?php echo $the_form_name;?> 
		</u>
		]
		</th>
		<th ><?php echo "Date: ". date("F", mktime(0, 0, 0, $f_month, 10))." ". $f_day.", ". $f_year. " To ". date("F", mktime(0, 0, 0, $t_month, 10))." ". $t_day.", ". $t_year; ?></th>
		<th colspan="<?php echo $colspan-1;?>"></th>
	</tr>
	<tr>
		<th>Employee ID</th>
		<th>Employee</th>
	<?php 
			$from = $this->input->post('date_from');
			$to = $this->input->post('date_to');
			// 

			// 
			$to = date("Y-m-d",strtotime(date("Y-m-d", strtotime($to)) . " +1 days"));

			while($from!=$to){
			$mon = date('M', strtotime($from));
			$day_style = date('D', strtotime($from)); 

			if($day_style == "Sun"){  $fcol = "background-color:#E78275"; $color="#E78275";}else{ $fcol="";$color="#E78275";}

			list($year, $month, $day) = explode("-", $from);

			$holiday=$this->transaction_employees_model->validate_date($month,$day);
			if(!empty($holiday)){
				$ifholiday= 'background-color: #FFF633;';
			}else{
				$ifholiday='';				
			}
			?>
			<th style="text-align:center;<?php 
			if(($ifholiday!="") AND ($fcol!="")){
				echo $ifholiday.'-webkit-box-shadow:inset 50px 0px 0px 0px '.$color.';
    -moz-box-shadow:inset 50px 0px 0px 0px '.$color.';
    box-shadow:inset 50px 0px 0px 0px '.$color;
			}else{
				echo $ifholiday." ".$fcol;
			}

			?>"><?php echo $mon." - ".$day."<br>". $day_style."<br>";
			$holiday=$this->transaction_employees_model->validate_date($month,$day);
			foreach($holiday as $getholiday){
					echo $the_holiday=$getholiday->holiday." <br>--<br>";
					echo $holiday_type= $getholiday->cValue;
				}
			
			$atro_date= $year.$month.$day; //IMPORTANT
			?></th>
			<?php 
			$from=strtotime(date("Y-m-d", strtotime($from)) . " +1 days");
			$from = date("Y-m-d",$from);
			}
	?>
	</tr>
	</thead>
	<tbody>
	<?php
		if(!empty($employee)){
		foreach($employee as $emp){
	?>
	<tr>
		<td><?php echo $emp->employee_id;?></td>
		<td><?php echo $emp->name;?></td>
			<?php 
			$from = $this->input->post('date_from');
			$to = $this->input->post('date_to');
			$to = date("Y-m-d",strtotime(date("Y-m-d", strtotime($to)) . " +1 days"));

			while($from!=$to){
			$mon = date('M', strtotime($from));
			$day_style = date('D', strtotime($from)); 
			//fcol: font color
			if($day_style == "Sun"){  $fcol = "color:#E78275;background-color:#E78275;";}else{ $fcol="";}

			list($year, $month, $day) = explode("-", $from);

			$holiday=$this->transaction_employees_model->validate_date($month,$day);
			if(!empty($holiday)){
				$ifholiday= 'background-color: #FFF633;';
			}else{
				$ifholiday='';
			}
			?>
			<td style="width:5%;text-align:center;<?php

if(($ifholiday!="") AND ($fcol!="")){
				echo $ifholiday.'-webkit-box-shadow:inset 50px 0px 0px 0px '.$color.';
    -moz-box-shadow:inset 50px 0px 0px 0px '.$color.';
    box-shadow:inset 50px 0px 0px 0px '.$color;
			}else{
				echo $ifholiday." ".$fcol;
			}
			 ?>">		
				<?php
				$the_form=$this->transaction_employees_model->get_form_form_name($value);
				if(!empty($the_form)){
				//current_me: current mass encoding 
				 $current_me=$the_form->t_table_name;
				}else{
				 $current_me="";
				}
				if($current_me=="emp_atro"){
				?>
				<!-- render overtime -->				
				<input type="text" name="<?php echo $emp->employee_id."_".$year."-".$month."-".$day;?>" style="width: 100px" value="">
				<?php 
					}else if(($current_me=="emp_change_rest_day")||($current_me=="emp_change_sched")){
					//get_wsc: get working schedule complete
					$get_wsc=$this->transaction_employees_model->get_working_sched_complete($emp->classification);
						if(!empty($get_wsc)){
								echo '<select name="'.$emp->employee_id."_".$year."-".$month."-".$day.'" >
									<option style="color:#35B2AE" value="Rest day">Rest day</option>
									<option disabled>-- whole day schedule --</option>';
							foreach($get_wsc as $sched){
								echo '<option style="color:#ff0000" value="'.$sched->time_in.$sched->time_out.'">'.$sched->time_in.' to '.$sched->time_out.'</option>';
							}						
								echo '</select>';	
						}else{
								echo "
							<input type='text' style='display:none;' required>
							no shift schedule reference.<br>please create shift schedule first.";
						}
	
					}else{ //check table

					}
				?>
			</td>
			<?php 
			$from=strtotime(date("Y-m-d", strtotime($from)) . " +1 days");
			$from = date("Y-m-d",$from);
			}
	?>
	</tr>
		<?php	
		}
		?>
	</tbody>
	</table>
	</div>
	<div style="  position: fixed;
    bottom: 15px;
    right: 0px;border:0px solid #000;width: 100%">

		 <button type="button" style="background-color: #75E77D;" class="btn btn btn-md" >Rest day</button>
		 <button type="button" style="background-color: #FFF633;"  class="btn btn btn-md" >Holiday</button>
		 <button type="button" style="background-color: #65CCB8;"  class="btn btn btn-md" >Holiday -Rest day</button>
		 <button type="button" style="background-color: #E78275;"  class="btn btn btn-md" >Sunday</button>

    <button type="button"  class="btn btn-success btn-md pull-right"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Encode via excel " id="export" name="export"><i class="fa fa-file-excel-o"></i> Encode Via Excel</button>


		<button type="submit" class="btn btn-danger btn-md pull-right"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to "><i class="fa fa-floppy-o"></i> Save</button>
		</div>


	</form>		

	<?php 
} // if not empty employee records query
else{


	?>

	<tr>
	<td style="text-align: center;text-transform: uppercase;" colspan="<?php echo $colspan+3;?>" >
		-----    <i class="fa fa-exclamation text-danger" ></i> No employee found under selected settings. -----    
	</td>
	</tr>
	<?php
}
?>

</div>