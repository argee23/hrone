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

/*=============================*/
.container {
  position: relative;
  text-align: center;
  color: #000;
  font-weight: bold;
  text-transform: uppercase;
}


.covered_year{
    position: absolute;
    top: 145px;
    left: 275px;
/*    background-color: #ff0000;*/
    width: 90px;
    height:  25px;    
    letter-spacing: 14px;
}
.tin_1{
    position: absolute;
    top: 200px;
    left: 275px;
/*    background-color: #000;*/
    width: 77px;
    height:  25px;    
    letter-spacing: 14px;
}

.tin_2{
    position: absolute;
    top: 200px;
    left: 347px;
/*    background-color: #000;*/
    width: 77px;
    height:  25px;    
    letter-spacing: 14px;
}

.tin_3{
    position: absolute;
    top: 200px;
    left: 425px;
/*    background-color: #000;*/
    width: 77px;
    height:  25px;    
    letter-spacing: 14px;
}

.tin_4{
    position: absolute;
    top: 200px;
    left: 500px;
/*    background-color: #000;*/
    width: 77px;
    height:  25px;    
    letter-spacing: 14px;
}

.last_name{
  position: absolute;
  top: 245px;
  left: 135px;
/*  background-color: #ff0000;*/
  width: 150px;
  height:  24px;   
}
.first_name{
  position: absolute;
  top: 245px;
  left: 235px;
/*  background-color: #ccc;*/
  width: 150px;
  height:  24px; 
}
.middle_name{
  position: absolute;
  top: 245px;
  left: 335px;
/*  background-color: #fff;*/
  width: 150px;
  height:  24px;  

}

/*======values rightmost*/
.tester{
    position: absolute;
    top: 100px;
    left: 275px;
    background-color: #ff0000;
    width: 220px;
    height:  25px;    
}

.non_taxable_13thmonth{
    position: absolute;
    top: 440px;
    left: 790px;
/*    background-color: #ff0000;*/
    width: 210px;
    height:  25px;    
}
.oa_deminimis{
    position: absolute;
    top: 485px;
    left: 790px;
/*    background-color: #ff0000;*/
    width: 210px;
    height:  25px;    
}
.gov_contribution{
    position: absolute;
    top: 535px;
    left: 790px;
/*    background-color: #ff0000;*/
    width: 210px;
    height:  25px;    
}

.oa_sal_and_otherf{
    position: absolute;
    top: 598px;
    left: 790px;
/*    background-color: #ff0000;*/
    width: 210px;
    height:  25px;    
}
.total_non_taxable{
    position: absolute;
    top: 645px;
    left: 790px;
/*    background-color: #ff0000;*/
    width: 210px;
    height:  25px;    
}
.total_basic{
    position: absolute;
    top: 732px;
    left: 790px;
/*    background-color: #ff0000;*/
    width: 210px;
    height:  25px;    
}
.oa_sal_and_otherf_taxable{
    position: absolute;
    top: 915px;
    left: 790px;
/*    background-color: #ff0000;*/
    width: 210px;
    height:  25px;    
}
.taxable_13thmonth{
    position: absolute;
    top: 1097px;
    left: 790px;
/*    background-color: #ff0000;*/
    width: 210px;
    height:  25px;    
}
.total_taxable{
    position: absolute;
    top: 1292px;
    left: 790px;
/*    background-color: #ff0000;*/
    width: 210px;
    height:  25px;    
}

/*==========leftmost=*/


.company_name{
    position: absolute;
    top: 765px;
    left: 135px;
/*    background-color: #ff0000;*/
    width: 400px;
    height:  25px;    
}
.company_address{
    position: absolute;
    top: 810px;
    left: 135px;
/*    background-color: #ff0000;*/
    width: 400px;
    height:  25px;    
}

.comp_tin_1{
    position: absolute;
    top: 720px;
    left: 273px;
/*    background-color: #ff0000;*/
    width: 70px;
    height:  25px;  
    letter-spacing: 14px;
}
.comp_tin_2{
    position: absolute;
    top: 720px;
    left: 350px;
/*    background-color: #ff0000;*/
    width: 70px;
    height:  25px;  
    letter-spacing: 14px;
}
.comp_tin_3{
    position: absolute;
    top: 720px;
    left: 425px;
/*    background-color: #ff0000;*/
    width: 70px;
    height:  25px;  
    letter-spacing: 14px;
}
.comp_tin_4{
    position: absolute;
    top: 720px;
    left: 498px;
/*    background-color: #ff0000;*/
    width: 70px;
    height:  25px;  
    letter-spacing: 14px;
}

.gross_compen_income{
    position: absolute;
    top: 994px;
    left: 360px;
/*    background-color: #ff0000;*/
    width: 200px;
    height:  25px;      
}
.left_22_total_non_taxable{
    position: absolute;
    top: 1019px;
    left: 360px;
/*    background-color: #ff0000;*/
    width: 200px;
    height:  25px;      
}
.left_23_total_non_taxable{
    position: absolute;
    top: 1047px;
    left: 360px;
/*    background-color: #ff0000;*/
    width: 200px;
    height:  25px;      
}

.left_24prev_total_taxable{
    position: absolute;
    top: 1073px;
    left: 360px;
/*    background-color: #ff0000;*/
    width: 200px;
    height:  25px;      
}
.left_25total_taxable_prev_pres{
    position: absolute;
    top: 1099px;
    left: 360px;
/*    background-color: #ff0000;*/
    width: 200px;
    height:  25px;      
}
.yearly_exemption{
    position: absolute;
    top: 1125px;
    left: 360px;
/*    background-color: #ff0000;*/
    width: 200px;
    height:  25px;      
}
.net_taxable_compen_income_how{
    position: absolute;
    top: 1180px;
    left: 360px;
/*    background-color: #ff0000;*/
    width: 200px;
    height:  25px;      
}
.witheld_tax_nf{
    position: absolute;
    top: 1206px;
    left: 360px;
/*    background-color: #ff0000;*/
    width: 200px;
    height:  25px;      
}
.present_employer_wtax{
    position: absolute;
    top: 1240px;
    left: 360px;
/*    background-color: #ff0000;*/
    width: 200px;
    height:  25px;      
}
.prev_tax_withheld{
    position: absolute;
    top: 1268px;
    left: 360px;
/*    background-color: #ff0000;*/
    width: 200px;
    height:  25px;      
}
.amt_of_tax_withheld_as_adj_nf{
    position: absolute;
    top: 1294px;
    left: 360px;
/*    background-color: #ff0000;*/
    width: 200px;
    height:  25px;      
}


/*=============================*/



</style>


</head>




<div class="form_image_div">

  <div class="col-md-3 bg-danger">

      <div class="col-md-12 bg-info">
          
          <img src="<?php echo base_url().'public/img/cropped.png'?>" style="width:150px;" >  


      </div>

<br>
    <div class="col-md-12 bg-warning">
      <img src="<?php echo base_url().'public/gov_reports_templates/bir.png'?>" style="width:100px;" >  
      BIR Form No. 2316<br><br>
      Certificate of Compensation Payment / Tax Withheld For Compensation Payment With or Without Tax Withheld</label>
      <label for="next" class="col-sm-12 control-label">
      <br>      
      Description<br><br>     
      A Certificate to be accomplished and issued to each employee receiving salaries, wages and other forms or remuneration by each employer indicating therein the total amount paid and the taxes withheld therefrom during the calendar year.This Certificate in turn should be attached to the Annual Income Tax Return (BIR Form 1700 - for individuals receiving purely compensation income, or BIR Form 1701 for individuals with mixed income).
      <br><br>
      Filing Date
      <br><br>
      To be issued to payee on or before January 31 of the succeeding year in which the compensation was paid, or in cases where there is termination of employment, it is issued on the same day the last payment of wages is made.
    </div>
  </div>


  <div class="col-md-9">
    <div id="container" style="font-size: 0.9em;font-weight: bold;">
      <?php
        if(!empty($e)){//employee data.
   
          require(APPPATH.'views/app/reports/payroll/tax/emp_2316_var.php');

          if($company_tin_no!=""){
            $comp_tin_length = strlen((string)$company_tin_no);
            $comp_tin_1=substr($company_tin_no, 0,3);
            $comp_tin_2=substr($company_tin_no, 3,3);
            $comp_tin_3=substr($company_tin_no, 6,3);
            $comp_tin_4=substr($company_tin_no, 9,5);
          }else{
            $comp_tin_1=0;$tin_2=0;$tin_3=0;$tin_4=0;
            $comp_tin_length=0;        
          }

          if($tin!=""){
            $tin_length = strlen((string)$tin);
            $tin_1=substr($tin, 0,3);
            $tin_2=substr($tin, 3,3);
            $tin_3=substr($tin, 6,3);
            $tin_4=substr($tin, 9,5);
          }else{
            $tin_1=0;$tin_2=0;$tin_3=0;$tin_4=0;
            $tin_length=0;        
          }

           echo '<div class="covered_year">'.$covered_year.'</div>';

          if($tin_length>=9){
                    echo '<div class="tin_1">'.$tin_1.'</div>';
                    echo '<div class="tin_2">'.$tin_2.'</div>';
                    echo '<div class="tin_3">'.$tin_3.'</div>';
                    echo '<div class="tin_4">'.$tin_4.'</div>';
          }else{
                    echo '<div class="tin_1">'.$tin.'</div>';
          }
         
          echo '<div class="last_name">'.$last_name.'</div>';
          echo '<div class="first_name">'.$first_name.'</div>';
          echo '<div class="middle_name">'.$middle_name.'</div>';
          
          //===NON TAXABLE COMPENSATION INCOME
          echo '<div class="non_taxable_13thmonth" title="'.$nontaxable_13thmonth_how.'">'.$non_taxable_13thmonth.'</div>';
          echo '<div class="oa_deminimis" title="'.$oa_deminimis_how.'">'.$oa_deminimis.'</div>';
          echo '<div class="gov_contribution" title="'.$gov_contribution_how.'">'.$gov_contribution.'</div>';
          echo '<div class="oa_sal_and_otherf" title="'.$oa_sal_and_otherf_how.'">'.$oa_sal_and_otherf.'</div>';
          echo '<div class="total_non_taxable" title="'.$total_non_taxable_how.'">'.$total_non_taxable.'</div>';
          //===TAXABLE COMPENSATION INCOME
          echo '<div class="total_basic" title="'.$basic_how.'">'.$total_basic.'</div>';
          echo '<div class="oa_sal_and_otherf_taxable" title="'.$oa_sal_and_otherf_how_taxable.'">'.$oa_sal_and_otherf_taxable.'</div>';
          echo '<div class="taxable_13thmonth" title="'.$taxable_13thmonth_how.'">'.$taxable_13thmonth.'</div>';
          echo '<div class="total_taxable" title="'.$total_taxable_how.'">'.$total_taxable.'</div>';

          if($comp_tin_length>=9){
                    echo '<div class="comp_tin_1">'.$comp_tin_1.'</div>';
                    echo '<div class="comp_tin_2">'.$comp_tin_2.'</div>';
                    echo '<div class="comp_tin_3">'.$comp_tin_3.'</div>';
                    echo '<div class="comp_tin_4">'.$comp_tin_4.'</div>';
          }else{
                    echo '<div class="comp_tin_1">'.$company_tin_no.'</div>';
          }

          echo '<div class="company_name">'.$company_name.'</div>';
          echo '<div class="company_address">'.$company_address.'</div>';

          echo '<div class="gross_compen_income" title="'.$gross_compen_incom_how.'">'.$gross_compen_income.'</div>';
          echo '<div class="left_22_total_non_taxable" title="'.$total_non_taxable_how.'">'.$total_non_taxable.'</div>';
          echo '<div class="left_23_total_non_taxable" title="'.$total_taxable_how.'">'.$total_taxable.'</div>';

          echo '<div class="left_24prev_total_taxable" title="'.$prev_total_taxable_how.'">'.$prev_total_taxable.'</div>';
          echo '<div class="left_25total_taxable_prev_pres" title="'.$total_taxable_prev_pres_how.'">'.$total_taxable_prev_pres.'</div>';
          echo '<div class="yearly_exemption" >'.$yearly_exemption.'</div>';
          
          echo '<div class="net_taxable_compen_income_how" title="'.$net_taxable_compen_income_how.'">'.$net_taxable_compen_income_nf.'</div>';
          echo '<div class="witheld_tax_nf" title="'.$wtax_formula_text.'">'.$witheld_tax_nf.'</div>';
          echo '<div class="present_employer_wtax" title="'.$present_employer_wtax_how.'">'.$present_employer_wtax_nf.'</div>';
          echo '<div class="prev_tax_withheld" >'.$prev_tax_withheld.'</div>';


          echo '<div class="amt_of_tax_withheld_as_adj_nf" title="'.$amt_of_tax_withheld_as_adj_how.'">'.$amt_of_tax_withheld_as_adj_nf.'</div>';

          if($sched=="7_1"){
             //echo '<div class="tester">'.$middle_name.'</div>';
             
          }elseif($sched=="7_2"){
           
          }elseif($sched=="7_3"){
           
          }elseif($sched=="7_4"){
           
          }elseif($sched=="7_5"){
            // show minimum wage earners details
           
          }else{

          }



      ?>
          <img src="<?php echo base_url().'public/gov_reports_templates/2316.png'?>" class="form_image"> <br>
      <?php
          
        }else{
          echo "no posted alphalist yet.";
        } 
      ?>

      
    </div>
  </div>
  


  
</div>

