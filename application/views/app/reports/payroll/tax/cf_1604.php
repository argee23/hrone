<head>
<link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
rel="stylesheet">
<link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">


<style type="text/css">
	.form_image{
		display:block;
   		margin:auto;   		
	}
	.form_image_div{
		background-color: #fff;

	}
	.choose_company{
		background-color: #D2691E;
		display:block;
   		margin:auto;
   		width:50%;
   		color:#fff;
		font-weight: bold;
	}
	.choose_company_title{
		text-transform: uppercase;
		text-align: center;
	}
}
/*=============================*/

/*=============================*/

</style>


</head>




<div class="form_image_div">

	<div class="col-md-3 bg-danger">

			<div class="col-md-12 bg-info">
					
					<img src="<?php echo base_url().'public/img/cropped.png'?>" style="width:150px;" >	

					<div class="form-group col-md-12  bg-danger"  >

					<label for="next" class="col-sm-12 control-label">Generate 1604CF Step by Step Instructions</label>
					<label for="next" class="col-sm-12 control-label">&nbsp;</label>
					<label for="next" class="col-sm-12 control-label">1) Enter Remittance Date</label>
					<label for="next" class="col-sm-12 control-label">2) Enter Adjustment </label>
					<label for="next" class="col-sm-12 control-label">3) Enter Penalties </label>
					<label for="next" class="col-sm-12 control-label">4) Choose Covered Year </label>
					<label for="next" class="col-sm-12 control-label">5) Choose Company </label>
			
					</div>
					

					<div class="form-group col-md-12  bg-danger"  >
					<label for="next" class="col-sm-12 control-label">Choose Covered Year <i class="fa fa-arrow-down"></i></label>
					<div class="col-sm-12" >
					<select name="year" class="form-control" id="year">
					<?php
					if(!empty($year_choicesList)){
					foreach($year_choicesList as $y){
					echo '<option>'.$y->yy.'</option>';
					}
					}else{

					}
					?>

					</select>
					</div>
					</div>




					<div class="form-group col-md-12 bg-danger"  >
					<label for="next" class="col-sm-12 control-label">Choose Company  <i class="fa fa-arrow-down"></i></label>
					<div class="col-sm-12" >

					<select class="form-control" onchange="getCompanyDetails(this.value);" name="chosen_company_id" >
							<option value="" disabled selected>Select Company</option>
					<?php
					if(!empty($companyList)){
					foreach($companyList as $c){
					?>

						<option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
					<?php			
					}
					}else{
					}
					?>
					</select>

					</div>
					</div>
			</div>

<br>
		<div class="col-md-12 bg-warning">
	<img src="<?php echo base_url().'public/gov_reports_templates/bir.png'?>" style="width:100px;" >	

		BIR Form No. 1604CF<br><br>
				 Annual Information Return of Income Tax Withheld on Compensation and Final Withholding Taxes</label>
				 <label for="next" class="col-sm-12 control-label">
		<br>		 	
		Description<br><br>		 	
		This return is filed by every employer or withholding agent/payor who is either an individual, estate, trust, partnership, corporation, government agency and instrumentality, government-owned and controlled corporation, local government unit and other juridical entity required to deduct and withhold taxes on compensation paid to employees and on other income payments subject to Final Withholding Taxes.
		<br><br>
		Filing Date
		<br><br>
		On or before January 31 of the year following the calendar year in which the compensation payment and other income payments subject to final withholding taxes were paid or accrued.


		</div>
	</div>



	<div class="col-md-9">

		<div id="show_company_details">

					<div class="form-group col-md-4 bg-success"  >
						<label for="next" class="col-sm-12 control-label text-center">Remittance Date  <i class="fa fa-arrow-down"></i></label>
						<label for="next" class="col-sm-3 control-label">January</label>
						<div class="col-sm-9" ><input type="date" id="jan_remit_date" class="form-control" value=""></div>
						<label for="next" class="col-sm-3 control-label">February</label>
						<div class="col-sm-9" ><input type="date" id="feb_remit_date" class="form-control" value=""></div>
						<label for="next" class="col-sm-3 control-label">March</label>
						<div class="col-sm-9" ><input type="date" id="mar_remit_date" class="form-control" value=""></div>
						<label for="next" class="col-sm-3 control-label">April</label>
						<div class="col-sm-9" ><input type="date" id="apr_remit_date" class="form-control" value=""></div>
						<label for="next" class="col-sm-3 control-label">May</label>
						<div class="col-sm-9" ><input type="date" id="may_remit_date" class="form-control" value=""></div>
						<label for="next" class="col-sm-3 control-label">June</label>
						<div class="col-sm-9" ><input type="date" id="jun_remit_date" class="form-control" value=""></div>
						<label for="next" class="col-sm-3 control-label">July</label>
						<div class="col-sm-9" ><input type="date" id="jul_remit_date" class="form-control" value=""></div>
						<label for="next" class="col-sm-3 control-label">August</label>
						<div class="col-sm-9" ><input type="date" id="aug_remit_date" class="form-control" value=""></div>
						<label for="next" class="col-sm-3 control-label">September</label>
						<div class="col-sm-9" ><input type="date" id="sep_remit_date" class="form-control" value=""></div>
						<label for="next" class="col-sm-3 control-label">October</label>
						<div class="col-sm-9" ><input type="date" id="oct_remit_date" class="form-control" value=""></div>
						<label for="next" class="col-sm-3 control-label">November</label>
						<div class="col-sm-9" ><input type="date" id="nov_remit_date" class="form-control" value=""></div>
						<label for="next" class="col-sm-3 control-label">December</label>
						<div class="col-sm-9" ><input type="date" id="dec_remit_date" class="form-control" value=""></div>
					</div>

					<div class="form-group col-md-4 bg-success"  >
						<label for="next" class="col-sm-12 control-label text-center">Adjustment <i class="fa fa-arrow-down"></i></label>
						<label for="next" class="col-sm-3 control-label">January</label>
						<div class="col-sm-9" ><input type="number" id="jan_adj_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">February</label>
						<div class="col-sm-9" ><input type="number" id="feb_adj_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">March</label>
						<div class="col-sm-9" ><input type="number" id="mar_adj_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">April</label>
						<div class="col-sm-9" ><input type="number" id="apr_adj_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">May</label>
						<div class="col-sm-9" ><input type="number" id="may_adj_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">June</label>
						<div class="col-sm-9" ><input type="number" id="jun_adj_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">July</label>
						<div class="col-sm-9" ><input type="number" id="jul_adj_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">August</label>
						<div class="col-sm-9" ><input type="number" id="aug_adj_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">September</label>
						<div class="col-sm-9" ><input type="number" id="sep_adj_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">October</label>
						<div class="col-sm-9" ><input type="number" id="oct_adj_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">November</label>
						<div class="col-sm-9" ><input type="number" id="nov_adj_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">December</label>
						<div class="col-sm-9" ><input type="number" id="dec_adj_enrty" class="form-control" placeholder="0.00" value="0"></div>
					</div>
					<div class="form-group col-md-4 bg-success"  >
						<label for="next" class="col-sm-12 control-label text-center">Penalties  <i class="fa fa-arrow-down"></i></label>
						<label for="next" class="col-sm-3 control-label">January</label>
						<div class="col-sm-9" ><input type="number" id="jan_pen_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">February</label>
						<div class="col-sm-9" ><input type="number" id="feb_pen_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">March</label>
						<div class="col-sm-9" ><input type="number" id="mar_pen_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">April</label>
						<div class="col-sm-9" ><input type="number" id="apr_pen_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">May</label>
						<div class="col-sm-9" ><input type="number" id="may_pen_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">June</label>
						<div class="col-sm-9" ><input type="number" id="jun_pen_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">July</label>
						<div class="col-sm-9" ><input type="number" id="jul_pen_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">August</label>
						<div class="col-sm-9" ><input type="number" id="aug_pen_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">September</label>
						<div class="col-sm-9" ><input type="number" id="sep_pen_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">October</label>
						<div class="col-sm-9" ><input type="number" id="oct_pen_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">November</label>
						<div class="col-sm-9" ><input type="number" id="nov_pen_enrty" class="form-control" placeholder="0.00" value="0"></div>
						<label for="next" class="col-sm-3 control-label">December</label>
						<div class="col-sm-9" ><input type="number" id="dec_pen_enrty" class="form-control" placeholder="0.00" value="0"></div>
					</div>


			<img src="<?php echo base_url().'public/gov_reports_templates/1604CF.png'?>" class="form_image">
		</div>

	</div>
	


	
</div>

<div>

</div>



<script type="text/javascript">
  function getCompanyDetails(company_id)
        {  

 		var year = document.getElementById("year").value;

 		var jan_remit_date = document.getElementById("jan_remit_date").value;
 		var feb_remit_date = document.getElementById("feb_remit_date").value;
 		var mar_remit_date = document.getElementById("mar_remit_date").value;
 		var apr_remit_date = document.getElementById("apr_remit_date").value;
 		var may_remit_date = document.getElementById("may_remit_date").value;
 		var jun_remit_date = document.getElementById("jun_remit_date").value;
 		var jul_remit_date = document.getElementById("jul_remit_date").value;
 		var aug_remit_date = document.getElementById("aug_remit_date").value;
 		var sep_remit_date = document.getElementById("sep_remit_date").value;
 		var oct_remit_date = document.getElementById("oct_remit_date").value;
 		var nov_remit_date = document.getElementById("nov_remit_date").value;
 		var dec_remit_date = document.getElementById("dec_remit_date").value;

	      if(jan_remit_date==''){
	      	var jan_remit_date="0";
	      }else{        
	      }
	      if(feb_remit_date==''){
	      	var feb_remit_date="0";
	      }else{       
	      }

	      if(mar_remit_date==''){
	      	var mar_remit_date="0";
	      }else{       
	      }
	      if(apr_remit_date==''){
	      	var apr_remit_date="0";
	      }else{       
	      }
	      if(may_remit_date==''){
	      	var may_remit_date="0";
	      }else{       
	      }
	      if(jun_remit_date==''){
	      	var jun_remit_date="0";
	      }else{       
	      }
	      if(jul_remit_date==''){
	      	var jul_remit_date="0";
	      }else{       
	      }
	      if(aug_remit_date==''){
	      	var aug_remit_date="0";
	      }else{       
	      }
	      if(sep_remit_date==''){
	      	var sep_remit_date="0";
	      }else{       
	      }
	      if(oct_remit_date==''){
	      	var oct_remit_date="0";
	      }else{       
	      }
	      if(nov_remit_date==''){
	      	var nov_remit_date="0";
	      }else{       
	      }
	      if(dec_remit_date==''){
	      	var dec_remit_date="0";
	      }else{       
	      }



 		var jan_adj_enrty = document.getElementById("jan_adj_enrty").value;
 		var feb_adj_enrty = document.getElementById("feb_adj_enrty").value;
 		var mar_adj_enrty = document.getElementById("mar_adj_enrty").value;
 		var apr_adj_enrty = document.getElementById("apr_adj_enrty").value;
 		var may_adj_enrty = document.getElementById("may_adj_enrty").value;
 		var jun_adj_enrty = document.getElementById("jun_adj_enrty").value;
 		var jul_adj_enrty = document.getElementById("jul_adj_enrty").value;
 		var aug_adj_enrty = document.getElementById("aug_adj_enrty").value;
 		var sep_adj_enrty = document.getElementById("sep_adj_enrty").value;
 		var oct_adj_enrty = document.getElementById("oct_adj_enrty").value;
 		var nov_adj_enrty = document.getElementById("nov_adj_enrty").value;
 		var dec_adj_enrty = document.getElementById("dec_adj_enrty").value;

 		// // if(jan_adj_enrty=0){
 		// // 	var jan_adj_enrty=0;
 		// // }else{
 		// // }
 		// if(feb_adj_enrty=0){
 		// 	var feb_adj_enrty=0;
 		// }else{
 		// }
 		// if(mar_adj_enrty=0){
 		// 	var mar_adj_enrty=0;
 		// }else{
 		// }
 		// if(apr_adj_enrty=0){
 		// 	var apr_adj_enrty=0;
 		// }else{
 		// }
 		// if(may_adj_enrty=0){
 		// 	var may_adj_enrty=0;
 		// }else{
 		// }
 		// if(jun_adj_enrty=0){
 		// 	var jun_adj_enrty=0;
 		// }else{
 		// }
 		// if(jul_adj_enrty=0){
 		// 	var jul_adj_enrty=0;
 		// }else{
 		// }
 		// if(aug_adj_enrty=0){
 		// 	var aug_adj_enrty=0;
 		// }else{
 		// }
 		// if(sep_adj_enrty=0){
 		// 	var sep_adj_enrty=0;
 		// }else{
 		// }
 		// if(oct_adj_enrty=0){
 		// 	var oct_adj_enrty=0;
 		// }else{
 		// }
 		// if(nov_adj_enrty=0){
 		// 	var nov_adj_enrty=0;
 		// }else{
 		// }
 		// if(dec_adj_enrty=0){
 		// 	var dec_adj_enrty=0;
 		// }else{
 		// }



 		var jan_pen_enrty = document.getElementById("jan_pen_enrty").value;
 		var feb_pen_enrty = document.getElementById("feb_pen_enrty").value;
 		var mar_pen_enrty = document.getElementById("mar_pen_enrty").value;
 		var apr_pen_enrty = document.getElementById("apr_pen_enrty").value;
 		var may_pen_enrty = document.getElementById("may_pen_enrty").value;
 		var jun_pen_enrty = document.getElementById("jun_pen_enrty").value;
 		var jul_pen_enrty = document.getElementById("jul_pen_enrty").value;
 		var aug_pen_enrty = document.getElementById("aug_pen_enrty").value;
 		var sep_pen_enrty = document.getElementById("sep_pen_enrty").value;
 		var oct_pen_enrty = document.getElementById("oct_pen_enrty").value;
 		var nov_pen_enrty = document.getElementById("nov_pen_enrty").value;
 		var dec_pen_enrty = document.getElementById("dec_pen_enrty").value;


 		// if(jan_pen_enrty=0){
 		// 	var jan_pen_enrty=0;
 		// }else{
 		// }
 		// if(feb_pen_enrty=0){
 		// 	var feb_pen_enrty=0;
 		// }else{
 		// }
 		// if(mar_pen_enrty=0){
 		// 	var mar_pen_enrty=0;
 		// }else{
 		// }
 		// if(apr_pen_enrty=0){
 		// 	var apr_pen_enrty=0;
 		// }else{
 		// }
 		// if(may_pen_enrty=0){
 		// 	var may_pen_enrty=0;
 		// }else{
 		// }
 		// if(jun_pen_enrty=0){
 		// 	var jun_pen_enrty=0;
 		// }else{
 		// }
 		// if(jul_pen_enrty=0){
 		// 	var jul_pen_enrty=0;
 		// }else{
 		// }
 		// if(aug_pen_enrty=0){
 		// 	var aug_pen_enrty=0;
 		// }else{
 		// }
 		// if(sep_pen_enrty=0){
 		// 	var seo_pen_enrty=0;
 		// }else{
 		// }
 		// if(oct_pen_enrty=0){
 		// 	var oct_pen_enrty=0;
 		// }else{
 		// }
 		// if(nov_pen_enrty=0){
 		// 	var nov_pen_enrty=0;
 		// }else{
 		// }
 		// if(dec_pen_enrty=0){
 		// 	var dec_pen_enrty=0;
 		// }else{
 		// }


        if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
            
            document.getElementById("show_company_details").innerHTML=xmlhttp2.responseText;
            }
          }

        xmlhttp2.open("GET","<?php echo base_url();?>app/reports_payroll/getCompanyDetails/"+company_id+"/"+year
        	+"/"+jan_remit_date+"/"+feb_remit_date+"/"+mar_remit_date+"/"+apr_remit_date+"/"+may_remit_date+"/"+jun_remit_date
        	+"/"+jul_remit_date+"/"+aug_remit_date+"/"+sep_remit_date+"/"+oct_remit_date+"/"+nov_remit_date+"/"+dec_remit_date
        	+"/"+jan_adj_enrty+"/"+feb_adj_enrty+"/"+mar_adj_enrty+"/"+apr_adj_enrty+"/"+may_adj_enrty+"/"+jun_adj_enrty
        	+"/"+jul_adj_enrty+"/"+aug_adj_enrty+"/"+sep_adj_enrty+"/"+oct_adj_enrty+"/"+nov_adj_enrty+"/"+dec_adj_enrty
        	+"/"+jan_pen_enrty+"/"+feb_pen_enrty+"/"+mar_pen_enrty+"/"+apr_pen_enrty+"/"+may_pen_enrty+"/"+jun_pen_enrty
        	+"/"+jul_pen_enrty+"/"+aug_pen_enrty+"/"+sep_pen_enrty+"/"+oct_pen_enrty+"/"+nov_pen_enrty+"/"+dec_pen_enrty,false);

        xmlhttp2.send();
        }




</script>