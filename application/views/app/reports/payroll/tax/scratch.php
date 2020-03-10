<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.container {
  position: relative;
  text-align: center;
  color: #ff0000;
  font-weight: bold;
  text-transform: uppercase;

/*  background-color:#000;*/

}
.c_1601{
	width: 95%;
	float: left;
}

.month{
		position: absolute;
		top: 206px;
		left: 85px;
/*		background-color: #000;*/
		width: 48px;
		height:  32px;		
		letter-spacing: 14px;
}
.year{
		position: absolute;
		top: 206px;
		left: 145px;
/*		background-color: #000;*/
		width: 90px;
		height:  32px;		
		letter-spacing: 14px;
}

.tin_1{
		position: absolute;
		top: 270px;
		left: 423px;
/*		background-color: #000;*/
		width: 77px;
		height:  32px;		
		letter-spacing: 14px;
}

.tin_2{
		position: absolute;
		top: 270px;
		left: 535px;
/*		background-color: #000;*/
		width: 77px;
		height:  32px;		
		letter-spacing: 14px;
}

.tin_3{
		position: absolute;
		top: 270px;
		left: 640px;
/*		background-color: #000;*/
		width: 77px;
		height:  32px;		
		letter-spacing: 14px;
}

.tin_4{
		position: absolute;
		top: 270px;
		left: 745px;
/*		background-color: #000;*/
		width: 77px;
		height:  32px;		
		letter-spacing: 14px;
}


</style>
</head>
</html>

<div class="container">
<?php


if(!empty($comp_info)){
	$tin_length = strlen((string)$comp_info->TIN);
	$tin_1=substr($comp_info->TIN, 0,3);
	$tin_2=substr($comp_info->TIN, 3,3);
	$tin_3=substr($comp_info->TIN, 6,3);
	$tin_4=substr($comp_info->TIN, 9,5);
}else{
	$tin_1=0;$tin_2=0;$tin_3=0;$tin_4=0;
	$tin_length=0;
}





		
?>
		<div class="month"><?php $month = sprintf("%02d", $month); echo $month;?></div>
		<div class="year"><?php echo $year;?></div>

<?php
if($tin_length>=12){
		echo '<div class="tin_1">'.$tin_1.'</div>';
		echo '<div class="tin_2">'.$tin_2.'</div>';
		echo '<div class="tin_3">'.$tin_3.'</div>';
		echo '<div class="tin_4">'.$tin_4.'</div>';
}else{
	
}

?>

  <img src="<?php echo base_url().'public/gov_reports_templates/1601c.png'?>" class="c_1601">  

</div>