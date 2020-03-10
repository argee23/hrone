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

          <label for="next" class="col-sm-12 control-label">Generate 1601-C Step by Step Instructions</label>
          <label for="next" class="col-sm-12 control-label">&nbsp;</label>
          <label for="next" class="col-sm-12 control-label">4) Choose Covered Year </label>
          <label for="next" class="col-sm-12 control-label">4) Choose Covered Month </label>
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


          <div class="form-group col-md-12  bg-danger"  >
          <label for="next" class="col-sm-12 control-label">Choose Covered Month <i class="fa fa-arrow-down"></i></label>
          <div class="col-sm-12" >
          <select name="year" class="form-control" id="month">
           <!--  <option disabled value="" selected>Select</option> -->
            <?php
              for($iM =1;$iM<=12;$iM++){
                echo '<option value="'.$iM.'">'.date("M", strtotime("$iM/12/10")).'</option>';
             
              }
            ?>
          </select>
          </div>
          </div>

          <div class="form-group col-md-12 bg-danger"  >
	          <label for="next" class="col-sm-6 control-label">Surcharge  <i class="fa fa-arrow-right"></i></label>
	          <div class="col-sm-6" >
	          	<input type="number" class="form-control" name="surcharge" id="surcharge" value="0">
	          </div>
	          <label for="next" class="col-sm-6 control-label">Interest  <i class="fa fa-arrow-right"></i></label>
	          <div class="col-sm-6" >
	          	<input type="number" class="form-control" name="interest" id="interest" value="0">
	          </div>
	          <label for="next" class="col-sm-6 control-label">Compromise  <i class="fa fa-arrow-right"></i></label>
	          <div class="col-sm-6" >
	          	<input type="number" class="form-control" name="compromise" id="compromise" value="0">
	          </div>
      	  </div>

          <div class="form-group col-md-12 bg-danger"  >
          <label for="next" class="col-sm-12 control-label">Choose Company  <i class="fa fa-arrow-down"></i></label>
          <div class="col-sm-12" >

          <select class="form-control" onchange="show_1601c(this.value);" name="chosen_company_id" >
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

    BIR Form No. 1601-C<br><br>
         Monthly Remittance Return of Income Taxes Withheld on Compensation</label>
         <label for="next" class="col-sm-12 control-label">
    <br>      
      Description<br><br>     
      This return shall be filed in triplicate by every Withholding Agent (WA)/payor required to deduct and withhold taxes on compensation paid to employees.
      <br><br>
      Filing Date
      <br><br>

      <span class="text-danger"> For the months of January to November</span><br>
      A) Large and Non-large Taxpayer<br>
      <span class="text-danger"> To (Manual)</span><br>
      On or before the tenth (10th) day of the following month in which withholding was made<br>
      <span class="text-danger">To (EFPS)</span><br>
      In accordance with the schedule set forth in RR No. 26-2002 as follows:<br><br>
      Group A : Fifteen (15) days following end of the month<br>
      Group B : Fourteen (14) days following end of the month<br>
      Group C : Thirteen (13) days following end of the month<br>
      Group D : Twelve (12) days following end of the month<br>
      Group E : Eleven (11) days following end of the month<br>

      <span class="text-danger"> For the month of December</span><br><br>
      A) Large and Non-large Taxpayer<br>
      <span class="text-danger"> To (Manual)</span><br>
      On or before January 15 of the following year<br>
      <span class="text-danger">To (EFPS)</span><br>
      In accordance with the schedule set forth in RR No. 26-2002 as follows:<br><br>
      Group A : Fifteen (15) days following end of the month<br>
      Group B : Fourteen (14) days following end of the month<br>
      Group C : Thirteen (13) days following end of the month<br>
      Group D : Twelve (12) days following end of the month<br>
      Group E : Eleven (11) days following end of the month




    </div>
  </div>


  <div class="col-md-9">
    <div id="show_company_details">
      <img src="<?php echo base_url().'public/gov_reports_templates/1601c.png'?>" class="form_image">
    </div>
  </div>
  


  
</div>

<div>

</div>



<script type="text/javascript">
  function show_1601c(company_id)
        {  

    var year = document.getElementById("year").value;
    var month = document.getElementById("month").value;
    var surcharge = document.getElementById("surcharge").value;
    var interest = document.getElementById("interest").value;
    var compromise = document.getElementById("compromise").value;

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

        xmlhttp2.open("GET","<?php echo base_url();?>app/reports_payroll/show_1601c/"+company_id+"/"+year
          +"/"+month+"/"+surcharge+"/"+interest+"/"+compromise,false);

        xmlhttp2.send();
        }




</script>