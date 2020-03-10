<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.container {
  position: relative;
  text-align: center;
  color: #000;
  font-weight: bold;
  text-transform: uppercase;
}
a{
	color:#000;
}
/*.bottom-left {
  position: absolute;
  bottom: 8px;
  left: 16px;
}

.top-left {
  position: absolute;
  top: 118px;
  left: 416px;
}

.top-right {
  position: absolute;
  top: 8px;
  right: 16px;
}

.bottom-right {
  position: absolute;
  bottom: 8px;
  right: 16px;
}

.centered {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}*/


/**/
.year_class{/*YEAR*/
		position: absolute;
		top: 192px;
		left: 260px;
		background-color: #fff;
		width: 81px;
		height:  24px;		
		letter-spacing: 13px;
}
/*if tin number is not equal to 12 digits*/
.tin_not_12{
		position: absolute;
		top: 245px;
		left: 130px;
		background-color: #fff;
		width: 50px;
		height:  24px;		
		letter-spacing: 22px;
}
/*start if tin number is equal to 12 digits*/
.number_4_1{
		position: absolute;
		top: 245px;
		left: 130px;
		background-color: #fff;
		width: 50px;
		height:  24px;		
		letter-spacing: 13px;
}

.number_4_2{
		position: absolute;
		top: 245px;
		left: 220px;
		background-color: #fff;
		width: 50px;
		height:  24px;		
		letter-spacing: 13px;
}

.number_4_3{
		position: absolute;
		top: 245px;
		left: 310px;
		background-color: #fff;
		width: 50px;
		height:  24px;		
		letter-spacing: 13px;
}
.number_4_4{
		position: absolute;
		top: 245px;
		left: 400px;
		background-color: #fff;
		width: 50px;
		height:  24px;		
		letter-spacing: 13px;
}
/*end if tin number is equal to 12 digits*/

.jan_remit_date{
		position: absolute;
		top: 509px;
		left: 150px;
		/*background-color: #fff;*/
		width: 100px;
		height:  10px;				
}
.jan_tax{
		position: absolute;
		top: 505px;
		left: 415px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.jan_adj{
		position: absolute;
		top: 505px;
		left: 585px;
/*		background-color: #000;*/
		width: 170px;
		height:  10px;				
}
.jan_penalty{
		position: absolute;
		top: 505px;
		left: 755px;
/*		background-color: #000;*/
		width: 165px;
		height:  10px;				
}
.jan_total_remitted{
		position: absolute;
		top: 505px;
		left: 920px;
/*		background-color: #000;*/
		width: 170px;
		height:  10px;				
}

.feb_remit_date{
		position: absolute;
		top: 525px;
		left: 150px;
		/*background-color: #fff;*/
		width: 100px;
		height:  10px;				
}

.feb_tax{
		position: absolute;
		top: 525px;
		left: 415px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;			
			
}
.feb_adj{
		position: absolute;
		top: 525px;
		left: 585px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;			
			
}
.feb_penalty{
		position: absolute;
		top: 525px;
		left: 755px;
/*		background-color: #fff;*/
		width: 165px;
		height:  10px;			
			
}
.feb_total_remitted{
		position: absolute;
		top: 525px;
		left: 920px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;			
			
}
.mar_remit_date{
		position: absolute;
		top: 543px;
		left: 150px;
/*		background-color: #fff;*/
		width: 100px;
		height:  10px;					
}
.mar_tax{
		position: absolute;
		top: 543px;
		left: 415px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;					
}
.mar_adj{
		position: absolute;
		top: 543px;
		left: 585px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;					
}
.mar_penalty{
		position: absolute;
		top: 543px;
		left: 755px;
/*		background-color: #fff;*/
		width: 165px;
		height:  10px;					
}

.mar_total_remitted{
		position: absolute;
		top: 543px;
		left: 920px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;					
}
.apr_remit_date{
		position: absolute;
		top: 560px;
		left: 150px;
/*		background-color: #fff;*/
		width: 100px;
		height:  10px;				
}
.apr_tax{
		position: absolute;
		top: 560px;
		left: 415px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.apr_adj{
		position: absolute;
		top: 560px;
		left: 585px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.apr_penalty{
		position: absolute;
		top: 560px;
		left: 755px;
/*		background-color: #fff;*/
		width: 165px;
		height:  10px;				
}
.apr_total_remitted{
		position: absolute;
		top: 560px;
		left: 920px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.may_remit_date{
		position: absolute;
		top: 575px;
		left: 150px;
/*		background-color: #fff;*/
		width: 100px;
		height:  10px;						
}
.may_tax{
		position: absolute;
		top: 575px;
		left: 415px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;						
}
.may_adj{
		position: absolute;
		top: 575px;
		left: 585px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;						
}
.may_penalty{
		position: absolute;
		top: 575px;
		left: 755px;
/*		background-color: #fff;*/
		width: 165px;
		height:  10px;						
}
.may_total_remitted{
		position: absolute;
		top: 575px;
		left: 920px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;						
}
.jun_remit_date{
		position: absolute;
		top: 595px;
		left: 150px;
/*		background-color: #fff;*/
		width: 100px;
		height:  10px;					
}
.jun_tax{
		position: absolute;
		top: 595px;
		left: 415px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;					
}
.jun_adj{
		position: absolute;
		top: 595px;
		left: 585px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;					
}
.jun_penalty{
		position: absolute;
		top: 595px;
		left: 755px;
/*		background-color: #fff;*/
		width: 165px;
		height:  10px;					
}
.jun_total_remitted{
		position: absolute;
		top: 595px;
		left: 920px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;					
}
.jul_remit_date{
		position: absolute;
		top: 610px;
		left: 150px;
/*		background-color: #fff;*/
		width: 100px;
		height:  10px;				
}
.jul_tax{
		position: absolute;
		top: 610px;
		left: 415px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.jul_adj{
		position: absolute;
		top: 610px;
		left: 585px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.jul_penalty{
		position: absolute;
		top: 610px;
		left: 755px;
/*		background-color: #fff;*/
		width: 165px;
		height:  10px;				
}
.jul_total_remitted{
		position: absolute;
		top: 610px;
		left: 920px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.aug_remit_date{
		position: absolute;
		top: 625px;
		left: 150px;
/*		background-color: #fff;*/
		width: 100px;
		height:  10px;					
}
.aug_tax{
		position: absolute;
		top: 625px;
		left: 415px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;					
}
.aug_adj{
		position: absolute;
		top: 625px;
		left: 585px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;					
}
.aug_penalty{
		position: absolute;
		top: 625px;
		left: 755px;
/*		background-color: #fff;*/
		width: 165px;
		height:  10px;					
}
.aug_total_remitted{
		position: absolute;
		top: 625px;
		left: 920px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;					
}
.sep_remit_date{
		position: absolute;
		top: 643px;
		left: 150px;
/*		background-color: #fff;*/
		width: 100px;
		height:  10px;				
}
.sep_tax{
		position: absolute;
		top: 643px;
		left: 415px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.sep_adj{
		position: absolute;
		top: 643px;
		left: 585px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.sep_penalty{
		position: absolute;
		top: 643px;
		left: 755px;
/*		background-color: #fff;*/
		width: 165px;
		height:  10px;				
}
.sep_total_remitted{
		position: absolute;
		top: 643px;
		left: 920px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.oct_remit_date{
		position: absolute;
		top: 657px;
		left: 150px;
/*		background-color: #fff;*/
		width: 100px;
		height:  10px;					
}
.oct_tax{
		position: absolute;
		top: 657px;
		left: 415px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;					
}
.oct_adj{
		position: absolute;
		top: 657px;
		left: 585px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;					
}
.oct_penalty{
		position: absolute;
		top: 657px;
		left: 755px;
/*		background-color: #fff;*/
		width: 165px;
		height:  10px;					
}
.oct_total_remitted{
		position: absolute;
		top: 657px;
		left: 920px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;					
}
.nov_remit_date{
		position: absolute;
		top: 675px;
		left: 150px;
/*		background-color: #fff;*/
		width: 100px;
		height:  10px;				
}
.nov_tax{
		position: absolute;
		top: 675px;
		left: 415px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.nov_adj{
		position: absolute;
		top: 675px;
		left: 585px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.nov_penalty{
		position: absolute;
		top: 675px;
		left: 755px;
/*		background-color: #fff;*/
		width: 165px;
		height:  10px;				
}
.nov_total_remitted{
		position: absolute;
		top: 675px;
		left: 920px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;					
}
.dec_remit_date{
		position: absolute;
		top: 690px;
		left: 150px;
/*		background-color: #fff;*/
		width: 100px;
		height:  10px;				
}
.dec_tax{
		position: absolute;
		top: 690px;
		left: 415px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.dec_adj{
		position: absolute;
		top: 690px;
		left: 585px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.dec_penalty{
		position: absolute;
		top: 690px;
		left: 755px;
/*		background-color: #fff;*/
		width: 165px;
		height:  10px;				
}
.dec_total_remitted{
		position: absolute;
		top: 690px;
		left: 920px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}

.total_withheld_tax{
		position: absolute;
		top: 707px;
		left: 415px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.total_adjustment{
		position: absolute;
		top: 707px;
		left: 585px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}
.total_penalty{
		position: absolute;
		top: 707px;
		left: 755px;
/*		background-color: #fff;*/
		width: 165px;
		height:  10px;				
}
.total_remitted{
		position: absolute;
		top: 707px;
		left: 920px;
/*		background-color: #fff;*/
		width: 170px;
		height:  10px;				
}

/**/




/**/
</style>
</head>
<body>


<div class="container">

	<img src="<?php echo base_url().'public/gov_reports_templates/1604CF.png'?>" class="form_image" style="width:100%;">	

<?php
if(!empty($jan_tax)){
	$total_jan_tax=$jan_tax->total_monthly_tax;
}else{
	$total_jan_tax=0;
}

if(!empty($feb_tax)){
	$total_feb_tax=$feb_tax->total_monthly_tax;
}else{
	$total_feb_tax=0;
}

if(!empty($mar_tax)){
	$total_mar_tax=$mar_tax->total_monthly_tax;
}else{
	$total_mar_tax=0;
}

if(!empty($apr_tax)){
	$total_apr_tax=$apr_tax->total_monthly_tax;
}else{
	$total_apr_tax=0;
}

if(!empty($may_tax)){
	$total_may_tax=$may_tax->total_monthly_tax;
}else{
	$total_may_tax=0;
}
if(!empty($jun_tax)){
	$total_jun_tax=$jun_tax->total_monthly_tax;
}else{
	$total_jun_tax=0;
}
if(!empty($jul_tax)){
	$total_jul_tax=$jul_tax->total_monthly_tax;
}else{
	$total_jul_tax=0;
}
if(!empty($aug_tax)){
	$total_aug_tax=$aug_tax->total_monthly_tax;
}else{
	$total_aug_tax=0;
}
if(!empty($sep_tax)){
	$total_sep_tax=$sep_tax->total_monthly_tax;
}else{
	$total_sep_tax=0;
}
if(!empty($oct_tax)){
	$total_oct_tax=$oct_tax->total_monthly_tax;
}else{
	$total_oct_tax=0;
}
if(!empty($nov_tax)){
	$total_nov_tax=$nov_tax->total_monthly_tax;
}else{
	$total_nov_tax=0;
}
if(!empty($dec_tax)){
	$total_dec_tax=$dec_tax->total_monthly_tax;
}else{
	$total_dec_tax=0;
}

// ============ start pang test lang
// $total_jan_tax=1123123123;
// $total_feb_tax=2;
// $total_mar_tax=3;
// $total_apr_tax=4;
// $total_may_tax=5;
// $total_jun_tax=6;
// $total_jul_tax=7;
// $total_aug_tax=8;

// $total_sep_tax=9;
// $total_oct_tax=10;
// $total_nov_tax=11;
// $total_dec_tax=12;
// ============ end pang test lang

$total_withheld_tax=$total_jan_tax+$total_feb_tax+$total_mar_tax+$total_apr_tax+$total_may_tax+$total_jun_tax+$total_jul_tax+$total_aug_tax+$total_sep_tax+$total_oct_tax+$total_nov_tax+$total_dec_tax;




$total_adjustment=$jan_adj+$feb_adj+$mar_adj+$apr_adj+$may_adj+$jun_adj+$jul_adj+$aug_adj+$sep_adj+$oct_adj+$nov_adj+$dec_adj;
$total_penalty=$jan_penalty+$feb_penalty+$mar_penalty+$apr_penalty+$may_penalty+$jun_penalty+$jul_penalty+$aug_penalty+$sep_penalty+$oct_penalty+$nov_penalty+$dec_penalty;

$total_jan_remit=$total_jan_tax+$jan_adj+$jan_penalty;
$total_feb_remit=$total_feb_tax+$feb_adj+$feb_penalty;
$total_mar_remit=$total_mar_tax+$mar_adj+$mar_penalty;
$total_apr_remit=$total_apr_tax+$apr_adj+$apr_penalty;
$total_may_remit=$total_may_tax+$may_adj+$may_penalty;
$total_jun_remit=$total_jun_tax+$jun_adj+$jun_penalty;
$total_jul_remit=$total_jul_tax+$jul_adj+$jul_penalty;
$total_aug_remit=$total_aug_tax+$aug_adj+$aug_penalty;
$total_sep_remit=$total_sep_tax+$sep_adj+$sep_penalty;
$total_oct_remit=$total_oct_tax+$oct_adj+$oct_penalty;
$total_nov_remit=$total_nov_tax+$nov_adj+$nov_penalty;
$total_dec_remit=$total_dec_tax+$dec_adj+$dec_penalty;


$total_remitted=$total_jan_remit+$total_feb_remit+$total_mar_remit+$total_apr_remit+$total_may_remit+$total_jun_remit+$total_jul_remit
+$total_aug_remit+$total_sep_remit+$total_oct_remit+$total_nov_remit+$total_dec_remit;

	$total_jan_tax=number_format($total_jan_tax,2);
	$total_feb_tax=number_format($total_feb_tax,2);
	$total_mar_tax=number_format($total_mar_tax,2);
	$total_apr_tax=number_format($total_apr_tax,2);
	$total_may_tax=number_format($total_may_tax,2);
	$total_jun_tax=number_format($total_jun_tax,2);
	$total_jul_tax=number_format($total_jul_tax,2);
	$total_aug_tax=number_format($total_aug_tax,2);
	$total_sep_tax=number_format($total_sep_tax,2);
	$total_oct_tax=number_format($total_oct_tax,2);
	$total_nov_tax=number_format($total_nov_tax,2);
	$total_dec_tax=number_format($total_dec_tax,2);
	$total_withheld_tax=number_format($total_withheld_tax,2);

	$jan_adj=number_format($jan_adj,2);
	$feb_adj=number_format($feb_adj,2);
	$mar_adj=number_format($mar_adj,2);
	$apr_adj=number_format($apr_adj,2);
	$may_adj=number_format($may_adj,2);
	$jun_adj=number_format($jun_adj,2);
	$jul_adj=number_format($jul_adj,2);
	$aug_adj=number_format($aug_adj,2);
	$sep_adj=number_format($sep_adj,2);
	$oct_adj=number_format($oct_adj,2);
	$nov_adj=number_format($nov_adj,2);
	$dec_adj=number_format($dec_adj,2);



	$total_adjustment=number_format($total_adjustment,2);

	$jan_penalty=number_format($jan_penalty,2);
	$feb_penalty=number_format($feb_penalty,2);
	$mar_penalty=number_format($mar_penalty,2);
	$apr_penalty=number_format($apr_penalty,2);
	$may_penalty=number_format($may_penalty,2);
	$jun_penalty=number_format($jun_penalty,2);
	$jul_penalty=number_format($jul_penalty,2);
	$aug_penalty=number_format($aug_penalty,2);
	$sep_penalty=number_format($sep_penalty,2);
	$oct_penalty=number_format($oct_penalty,2);
	$nov_penalty=number_format($nov_penalty,2);
	$dec_penalty=number_format($dec_penalty,2);

	$total_penalty=number_format($total_penalty,2);

	
	$total_jan_remit=number_format($total_jan_remit,2);
	$total_feb_remit=number_format($total_feb_remit,2);
	$total_mar_remit=number_format($total_mar_remit,2);
	$total_apr_remit=number_format($total_apr_remit,2);
	$total_may_remit=number_format($total_may_remit,2);
	$total_jun_remit=number_format($total_jun_remit,2);
	$total_jul_remit=number_format($total_jul_remit,2);
	$total_aug_remit=number_format($total_aug_remit,2);
	$total_sep_remit=number_format($total_sep_remit,2);
	$total_oct_remit=number_format($total_oct_remit,2);
	$total_nov_remit=number_format($total_nov_remit,2);
	$total_dec_remit=number_format($total_dec_remit,2);

	$total_remitted=number_format($total_remitted,2);



?>



<div class="general_style">
		<?php
		$tin_length = strlen((string)$cinfo->TIN);
		?>
		<div class="year_class">
			<?php echo date('Y');?>
		</div>
		<?php
		
		if($tin_length=="12"){// 12 digit tin number
		?>
		<div class="number_4_1">
			<?php 
				
					$tin_1=substr($cinfo->TIN, 0,3);
					$tin_2=substr($cinfo->TIN, 3,3);
					$tin_3=substr($cinfo->TIN, 6,3);
					$tin_4=substr($cinfo->TIN, 9,3);
					echo $tin_1;
			?>
		</div>
		<div class="number_4_2">
			<?php 
					$tin_1=substr($cinfo->TIN, 0,3);
					$tin_2=substr($cinfo->TIN, 3,3);
					$tin_3=substr($cinfo->TIN, 6,3);
					$tin_4=substr($cinfo->TIN, 9,3);
					echo $tin_2;
			?>
		</div>
		<div class="number_4_3">
			<?php 
					$tin_1=substr($cinfo->TIN, 0,3);
					$tin_2=substr($cinfo->TIN, 3,3);
					$tin_3=substr($cinfo->TIN, 6,3);
					$tin_4=substr($cinfo->TIN, 9,3);
					echo $tin_3;
			?>
		</div>
		<div class="number_4_4">
			<?php 
					$tin_1=substr($cinfo->TIN, 0,3);
					$tin_2=substr($cinfo->TIN, 3,3);
					$tin_3=substr($cinfo->TIN, 6,3);
					$tin_4=substr($cinfo->TIN, 9,3);
					echo $tin_4;
			?>
		</div>
		<?php
		}else{
				echo '
						<div class="tin_not_12">
						'.$cinfo->TIN.'
						</div>
				';
		}
		?>


		<div class="jan_remit_date">
			<?php echo $jan_remit_date;?>
		</div>
		<div class="feb_remit_date">
			<?php echo $feb_remit_date;?>
		</div>
		<div class="mar_remit_date">
			<?php echo $mar_remit_date;?>
		</div>
		<div class="apr_remit_date">
			<?php echo $apr_remit_date;?>
		</div>
		<div class="may_remit_date">
			<?php echo $may_remit_date;?>
		</div>
		<div class="jun_remit_date">
			<?php echo $jun_remit_date;?>
		</div>
		<div class="jul_remit_date">
			<?php echo $jul_remit_date;?>
		</div>
		<div class="aug_remit_date">
			<?php echo $aug_remit_date;?>
		</div>
		<div class="sep_remit_date">
			<?php echo $sep_remit_date;?>
		</div>
		<div class="oct_remit_date">
			<?php echo $oct_remit_date;?>
		</div>
		<div class="nov_remit_date">
			<?php echo $nov_remit_date;?>
		</div>
		<div class="dec_remit_date">
			<?php echo $dec_remit_date;?>
		</div>



		<div class="jan_tax">
			<?php echo '<a href="'.base_url().'app/reports_payroll/verify_tax_value/1/'.$company_id.'/'.$year.'" target="_blank" title="Click Me to View How the system Arrive to this value">'.$total_jan_tax.'</a>';?>
		</div>
		<div class="feb_tax">
			<?php echo '<a href="'.base_url().'app/reports_payroll/verify_tax_value/2/'.$company_id.'/'.$year.'" target="_blank" title="Click Me to View How the system Arrive to this value">'.$total_feb_tax.'</a>';?>
		</div>
		<div class="mar_tax">
			<?php echo '<a href="'.base_url().'app/reports_payroll/verify_tax_value/3/'.$company_id.'/'.$year.'" target="_blank" title="Click Me to View How the system Arrive to this value">'.$total_mar_tax.'</a>';?>
		</div>
		<div class="apr_tax">
			<?php echo '<a href="'.base_url().'app/reports_payroll/verify_tax_value/4/'.$company_id.'/'.$year.'" target="_blank" title="Click Me to View How the system Arrive to this value">'.$total_apr_tax.'</a>';?>
		</div>
		<div class="may_tax">
			<?php echo '<a href="'.base_url().'app/reports_payroll/verify_tax_value/5/'.$company_id.'/'.$year.'" target="_blank" title="Click Me to View How the system Arrive to this value">'.$total_may_tax.'</a>';?>
		</div>
		<div class="jun_tax">
			<?php echo '<a href="'.base_url().'app/reports_payroll/verify_tax_value/6/'.$company_id.'/'.$year.'" target="_blank" title="Click Me to View How the system Arrive to this value">'.$total_jun_tax.'</a>';?>
		</div>
		<div class="jul_tax">
			<?php echo '<a href="'.base_url().'app/reports_payroll/verify_tax_value/7/'.$company_id.'/'.$year.'" target="_blank" title="Click Me to View How the system Arrive to this value">'.$total_jul_tax.'</a>';?>
		</div>
		<div class="aug_tax">
			<?php echo '<a href="'.base_url().'app/reports_payroll/verify_tax_value/8/'.$company_id.'/'.$year.'" target="_blank" title="Click Me to View How the system Arrive to this value">'.$total_aug_tax.'</a>';?>
		</div>
		<div class="sep_tax">
			<?php echo '<a href="'.base_url().'app/reports_payroll/verify_tax_value/9/'.$company_id.'/'.$year.'" target="_blank" title="Click Me to View How the system Arrive to this value">'.$total_sep_tax.'</a>';?>
		</div>
		<div class="oct_tax">
			<?php echo '<a href="'.base_url().'app/reports_payroll/verify_tax_value/10/'.$company_id.'/'.$year.'" target="_blank" title="Click Me to View How the system Arrive to this value">'.$total_oct_tax.'</a>';?>
		</div>
		<div class="nov_tax">
			<?php echo '<a href="'.base_url().'app/reports_payroll/verify_tax_value/11/'.$company_id.'/'.$year.'" target="_blank" title="Click Me to View How the system Arrive to this value">'.$total_nov_tax.'</a>';?>
		</div>
		<div class="dec_tax">
			<?php echo '<a href="'.base_url().'app/reports_payroll/verify_tax_value/12/'.$company_id.'/'.$year.'" target="_blank" title="Click Me to View How the system Arrive to this value">'.$total_dec_tax.'</a>';?>
		</div>

		<div class="total_withheld_tax">
			<?php echo $total_withheld_tax;?>
		</div>

<!-- Start Adjustment -->
		<div class="jan_adj">
			<?php echo $jan_adj;?>
		</div>
		<div class="feb_adj">
			<?php echo $feb_adj;?>
		</div>
		<div class="mar_adj">
			<?php echo $mar_adj;?>
		</div>
		<div class="apr_adj">
			<?php echo $apr_adj;?>
		</div>
		<div class="may_adj">
			<?php echo $may_adj;?>
		</div>
		<div class="jun_adj">
			<?php echo $jun_adj;?>
		</div>
		<div class="jul_adj">
			<?php echo $jul_adj;?>
		</div>
		<div class="aug_adj">
			<?php echo $aug_adj;?>
		</div>
		<div class="sep_adj">
			<?php echo $sep_adj;?>
		</div>
		<div class="oct_adj">
			<?php echo $oct_adj;?>
		</div>
		<div class="nov_adj">
			<?php echo $nov_adj;?>
		</div>
		<div class="dec_adj">
			<?php echo $dec_adj;?>
		</div>

		<div class="total_adjustment">
			<?php echo $total_adjustment;?>
		</div>


<!--  End Adjustment-->

<!-- Start Penalty -->
		<div class="jan_penalty">
			<?php echo $jan_penalty;?>
		</div>
		<div class="feb_penalty">
			<?php echo $feb_penalty;?>
		</div>
		<div class="mar_penalty">
			<?php echo $mar_penalty;?>
		</div>
		<div class="apr_penalty">
			<?php echo $apr_penalty;?>
		</div>
		<div class="may_penalty">
			<?php echo $may_penalty;?>
		</div>
		<div class="jun_penalty">
			<?php echo $jun_penalty;?>
		</div>
		<div class="jul_penalty">
			<?php echo $jul_penalty;?>
		</div>
		<div class="aug_penalty">
			<?php echo $aug_penalty;?>
		</div>
		<div class="sep_penalty">
			<?php echo $sep_penalty;?>
		</div>
		<div class="oct_penalty">
			<?php echo $oct_penalty;?>
		</div>
		<div class="nov_penalty">
			<?php echo $nov_penalty;?>
		</div>
		<div class="dec_penalty">
			<?php echo $dec_penalty;?>
		</div>
		<div class="total_penalty">
			<?php echo $total_penalty;?>
		</div>		

<!-- End Penalty -->


<!-- Start Total Remitted -->
		<div class="jan_total_remitted">
			<?php echo $total_jan_remit;?>
		</div>
		<div class="feb_total_remitted">
			<?php echo $total_feb_remit;?>
		</div>
		<div class="mar_total_remitted">
			<?php echo $total_mar_remit;?>
		</div>
		<div class="apr_total_remitted">
			<?php echo $total_apr_remit;?>
		</div>
		<div class="may_total_remitted">
			<?php echo $total_may_remit;?>
		</div>
		<div class="jun_total_remitted">
			<?php echo $total_jun_remit;?>
		</div>
		<div class="jul_total_remitted">
			<?php echo $total_jul_remit;?>
		</div>
		<div class="aug_total_remitted">
			<?php echo $total_aug_remit;?>
		</div>
		<div class="sep_total_remitted">
			<?php echo $total_sep_remit;?>
		</div>
		<div class="oct_total_remitted">
			<?php echo $total_oct_remit;?>
		</div>
		<div class="nov_total_remitted">
			<?php echo $total_nov_remit;?>
		</div>
		<div class="dec_total_remitted">
			<?php echo $total_dec_remit;?>
		</div>
		<div class="total_remitted">
			<?php echo $total_remitted;?>
		</div>

<!-- End Total Remitted -->


</div>


</div>

</body>
</html> 
