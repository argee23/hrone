<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/stamp.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- printing -->
    <script type="text/javascript">
    function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    }
    </script>
    <style type="text/css" media="print">
    @page 
    {
    size: auto;   /* auto is the initial value */
    margin: 0mm;  /* this affects the margin in the printer settings */
    }
    </style>
    <!-- end printing -->
</head>
<body> 
<div  id="printableArea"> <!-- this is important -->
  <div  class="col-md-2" ></div>
  <div class="col-md-8" style="margin-top:10px;margin-left: auto;margin-right: auto;border:4px solid #F1F3F9;">
  <?php 
  /*$length = 10;
  $randomString = substr(str_shuffle("123456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ"), 0, $length);
  echo $randomString;*/
 $cur_form= $this->uri->segment('6');
  foreach($file as $file_doc){
    $dept=$file_doc->department;
    $sect=$file_doc->section;
    $clas=$file_doc->classification;
    $e_id=$file_doc->employee_id;

  $cID=$file_doc->company_id; 
  $company=$this->pms_model->get_emp_company($cID);
  foreach($company as $comp_det){
    $company_name =$comp_det->company_name;
    $company_logo =$comp_det->logo;
    $company_address =$comp_det->company_address;
    $company_contact_no =$comp_det->company_contact_no;
    $company_tin =$comp_det->TIN;
  }

  ?>     

  <table border="0" width="100%" cellpadding="0" cellspacing="0">
  
  <br><br>
  <tbody style="font-size: 10px;">



    <table class="table">
      <thead>
        <tr class="info">
          <th scope="col" colspan="4">Part 
            <?php $form = $this->pms_model->get_form_details($file_doc->form_part_id);
            echo $form->part_number.':'.$form->part_name;
          ?></th>
          </tr>
        <tr>
          <th scope="col">Score</th>
          <th scope="col" colspan="2"> <?php $form = $this->pms_model->get_form_details($file_doc->form_part_id);
            echo $form->part_name;
          ?> Scoring Guide</th>
        </tr>
      </thead>
      <tbody>
        <?php $score = $this->pms_model->get_form_criteria($file_doc->form_part_id);
            foreach($score as $sc){
          ?>
        <tr>
          <td><?=$sc->score?></td>
          <td><?=$sc->score_equivalent?></td>
          <td><?=$sc->score_guide?></td>   
        </tr>
        <?php } ?>
      </tbody>
    </table>

    <table id="edit_general" class="table">
          <thead>
          <tr>
              <th scope="col"> 
                <?php $form = $this->pms_model->get_form_details($file_doc->form_part_id);
                echo $form->part_name; ?>
              </th>
              <th scope="col">Description</th>
              <th scope="col">Weight</th>
              <th scope="col">Score</th>
              <th scope="col">Rating</th>
            </tr>
          </thead>

          <tbody>
          <?php 
          $score = $this->pms_model->get_form_score($file_doc->form_part_id);
          foreach($score as $sc):?>
            <tr id='sec'>
              <td><?=$sc->pos_area?></td>
              <td><?=$sc->area_desc?></td>
              <td><?=$sc->area_weight?></td>
              <td><?=$sc->score?></td>
              <td><?=$sc->rating?></td>
            </tr>
          <?php endforeach?>
          </tbody>
            <tr>
              <td scope="col"></td>
              <td scope="col" colspan="1"><strong>Totals and Rating for Part <?php $form = $this->pms_model->get_form_details($file_doc->form_part_id);
                echo $form->part_number; ?></strong>
              </td>
              <td scope="col" colspan="2">
                <?php 
                $sum_weight = $this->pms_model->get_total_weight_score($file_doc->form_part_id);
                echo $sum_weight->total; ?>%
              </td>
              <td scope="col" colspan="1"><?=$file_doc->total_rating?></td>
            </tr>
                </table>
  

        </tr>  
      </table>
    </td>
  </tr>
  <?php
  }
  ?>

  <?php 
$dept=$file_doc->department;
$sect=$file_doc->section;
$clas=$file_doc->classification;

$loc=$file_doc->location;
$sub=$file_doc->subsection;

$get_all_app=$this->pms_model->get_all_app($file_doc->doc_no,$dept,$sect,$clas,$loc,$sub);


if(!empty($get_all_app)){
foreach($get_all_app as $doc_app){
$name=$doc_app->first_name. " ".$doc_app->middle_name. " ".$doc_app->last_name. " ";
$app_position=$doc_app->position_name;

  if ($doc_app->approval_level=="1"){
    $ext="st";
  }else if($doc_app->approval_level=="2"){
    $ext="nd";
  }else if($doc_app->approval_level=="3"){
    $ext="rd";
  }else{
    $ext="th";
  }

  $dt = "";
  $type="";
$trans_stat=$this->pms_model->get_form_status($doc_app->employee_id,$file_doc->doc_no);

  if(!empty($trans_stat)){
    foreach($trans_stat as $t_stat){
       $stat=$t_stat->status;   
       $dt = $t_stat->date_time;  
       // $type  = $t_stat->approval_type;

       if ($t_stat->approval_type=='sys_bp'){
        $type=='System By-Passed';
       }
       else{
        $type  = $t_stat->approval_type;
       }
    }
  }else{
       $stat="pending";
  }
  //
  if($stat=="approved"){
    $bgstyle='#000';
  }else{
    $bgstyle='#ff0000';
  }

  $add='';
  if ($stat !='pending')
  {
     $add = $dt . "<br>". $type ." <br> ";
  }

      echo '
      <br><br>
         <td width="220px" style="color:'.$bgstyle.';">
           <label style="text-transform:uppercase;text-decoration:none;">'.$stat.'</label><br> ' . $add . '
            <font style="text-decoration:underline; ">'.'['.$doc_app->employee_id.'] '.$name.'</font><br>'.$doc_app->approval_level.$ext. ' Level'.'<br>'.$app_position.'
          </td><br><br>
          ';
}
}else{
  echo "<td class='text-danger'>--- no assigned approvers --- </td><br><br><br>";
}
?>
  </tbody>
</table>
</div>
  <div  class="col-md-2" ></div>
</div>
<div  class="col-md-10" ><br>
  <button type="submit" class="btn btn-danger pull-right" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button><br><br><br>
</div>



</body>
</html>