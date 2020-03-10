  
<style type="text/css">
    .tbody {

    background: #EEEEF0; 
}
.tbody td{
  border:4px solid #fff;
}
* {
  border-radius: 0 !important;
}
</style>

    <script type="text/javascript">
    function printDiv(divName) {

      $('input[type="checkbox"]').each(function() {
          var $this = $('input[type="checkbox"]');
          if($this.is(':checked')) {
              $('textarea#asd').prop('disabled', true);
             $this.attr('checked', true);
          } else {
              $this.removeAttr('checked');
          }
      });

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
<?php $form_location   = base_url()."employee_portal/pms/submit_agree/";?>
<form id="form5" method="post" action="<?php echo $form_location;?>">
           <?php 
  if(!empty($this->session->flashdata('result'))){
    echo '<p>'.$this->session->flashdata('result').'</p>';
  }
 ?> 
<div  id="printableArea" style="background-color: #fff;"> <!-- this is important -->

  <div  class="col-md-2" ></div>
  <div class="col-md-8" class="well" style="margin-top:10px;margin-left: auto;margin-right: auto; " >
    <br>
    <table class="table" border="0" width="100%" cellpadding="0" cellspacing="0">
      <thead>
          <tr class="info" >
            <td colspan="2" >
              <center><h3><strong>PERFORMANCE APPRAISAL FORM</strong></h3></center>

            </td>
          </tr>
      </thead>
    </table><br>

  <?php $grading_type = $grading_type->grading_type; ?>
<div class="box box-primary">
            
         <div class="box-body">
          <div style="background-color: #d9edf7;color:black; padding:10px;"><b>Employee info</b></div>
          
          <hr>
    <span class="col-sm-10">
      <dt>Employee Name</dt>
      <dd><?=$emp_info->first_name;?> <?=$emp_info->middle_name;?> <?=$emp_info->last_name;?></dd>
      <dt>Division</dt>
      <dd><?=$emp_info->division_name;?></dd>
      <dt>Department</dt>
      <dd><?php if($emp_info->dept_name == '' || $emp_info->dept_name == null){ echo 'N/A'; } else { echo $emp_info->dept_name; }?></dd>
      <dt>Classification</dt>
      <dd><?=$emp_info->classification_name;?></dd>
      <div class="pull-right" style="margin-top: -140px;">
      <dt>Position</dt>
      <dd><?=$emp_info->position_name;?></dd>
      <dt>Current Status</dt>
      <dd><?=$emp_info->employment_name;?></dd>
      <dt>Date Hired</dt>
      <dd><?=date("F d, Y", strtotime($emp_info2->date_employed));?></dd>
      <dt>Performance Appraisal Period</dt>
      <dd><?php echo $get_current_appraisal_schedule_of_employee->coverage; ?><br><br><br></dd>
    </div>
    </span>
  </div></div>


  <br>



  
<div class="box box-primary">

         <div class="box-body">
          
            <div style="background-color: #d9edf7;color:black; padding:10px;"><b>General Instructions </b></div>
  <hr>
          <?php  if(!empty($gIns->instruction)){ echo nl2br($gIns->instruction);}?>
           
            

    <?php foreach ($summary as $s):?>
     <table> 

    <tbody>
        <tr>
          <td><?php if(!empty($s->form_instruction)){ echo nl2br($s->form_instruction);}?></td>
        </tr>
      <?php endforeach?>
    </tbody>
     </table>
  </div>
</div>
  
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

  ?>    
  <br><br><br>
  
<div class="box box-primary">

         <div class="box-body">

    <table class="table">
      <thead>
        <tr class="info">
          <th scope="col" colspan="4">Part  <?php 
            echo $file_doc->form_part .':'.$file_doc->form_title;
          ?></th>
          </tr>
        <tr>
          <th scope="col">Score</th>
           <th scope="col">score equivalent</th>
          <th scope="col" colspan="2"> <?php 
            echo 'KRA';
          ?> Scoring Guide</th>
        </tr>
      </thead>
      <tbody class="tbody">
      <?php $score = $this->pms_model->get_form_criteria($file_doc->fid,$file_doc->doc_no);
            foreach($score as $sc){
          ?>
        <tr>
          <td><?=$sc->score?></td>
          <td><?=$sc->score_equivalent?></td>
          <td><?=$sc->scoring_guide?></td>   
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <hr>
  <br>
    <table id="edit_general" class="table">
          <thead> 
          <tr>
              <th scope="col"> 
          <?php $form = $this->pms_model->get_form_details($file_doc->doc_no);
           echo $form->form_title;
              ?> 
              </th>

              <th scope="col">Description</th>
              <th scope="col">Weight</th>
              <th scope="col">Score</th>
              <th scope="col">Rating</th>
            </tr>
          </thead>

          <tbody>
            <?php 
          $score = $this->pms_model->get_form_score($e_id,$file_doc->fid,$file_doc->doc_no);
          $w = '';
          $q = '';
          foreach($score as $sc):?>
            <tr id='sec'>
          
              <?php       $ws = $this->pms_model->criteira_s($sc->cid,$sc->doc_no,$grading_type);
              foreach($ws as $ws){
 ?>           <td><?=$sc->area?></td>
              <td><?=$ws->description?></td>
              <td><?=$ws->weight?></td>
              <td style="background-color:  <?php echo $ws->color; ?>"><?php if($grading_type == 1){ echo $ws->score; }elseif($grading_type ==2){ echo $ws->ranking; }?></td>
              <td><?=$ws->rating?></td>
            </tr>
          <?php $w += $ws->weight;
          $q += $ws->rating; } endforeach ?>
          </tbody>
            <tr>  
              <td scope="col"></td>
              <td scope="col" colspan="1"><strong>Totals and Rating for Part <?php 
                echo $file_doc->form_part; ?></strong>
              </td>
              <td scope="col" colspan="2">
                <?php 
               
                echo  '<b>'.$w.'</b>';?>%
              </td>
        
              <td scope="col" colspan="1" ><?php echo '<b>'.round($q).'</b>'; ?></td>
            </tr>
                </table>
  

        </tr>  
      </div>
 </div>

  <?php
  }
  ?>

  <!-------------------------------------------------------------------- FINAL RATING ----------------------------------------------------->

  <br><br><br>
  <div class="box box-primary">
            


         <div class="box-body">
 <b>Final Rating of Employee or Ratee</b>

         

          <hr>
  <table class="table table-striped" >
    <thead>
      
      <tr>
        <th>Part</th>
             <th>Form title</th>
        <th>Weight</th>
        <th>Part rating</th>
        <th> Rating</th>
      </tr>
    </thead>
    <tbody >
  <?php $sw= '';$c= ''; $finalrating = '';


   foreach ($summary as $s){;?>
        <tr>
          <td><?=$s->form_part?></td>
          <td><?=$s->form_title?></td>
          <td><?=$s->weight?></td>
          <td><?=$s->part_rating?></td>
          <td><?=$s->total_rating?></td>
        </tr>
      <?php $sw += $s->weight; $c += $s->total_rating; $finalrating += $s->part_rating;  } ?>
      <tr>
        <td scope="col" colspan="2"><strong>Final Rating</strong></td>
        <td><strong><?php echo $sw; ?> %</strong></td>
        <td >
          <strong> <?php  echo $finalrating;?> </strong>
       </td>
       <td style="color: <?php $qs =  $this->pms_model->get_score_equival($c,$grading_type); echo $qs->color; ?>">
        <?php if(round($c) == 0){ echo 1; }else{ echo round($c).' ('.$qs->score_equivalent.')'; } ?>
          
        </td>
      </tr>
    </tbody>
  </table>


</div></div>
  <!-------------------------------------------------------- RECOMMENDATION -------------------------------------------------------------->

  <br><br><br>
    <div class="box box-primary">

         <div class="box-body">
  <table class="table">
    <thead>
      <tr class="info"><th colspan="3">Recommendations by Immediate Superior or Rater</th></tr>
      <tr>
        <th>Recommendations</th>
        <th>Effectivity Date</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      if(!empty($recom->doc_no)){
    ?>
      <?php if($recom->promotion){   ?>
        <tr>
          <td><?php  echo '<b>Promotion:</b> '.$recom->pro_pos;   ?></td>
          <td>
            <?php if(true){
              echo '<b>Date from:</b>';
            }else {
              echo '<b>date from'.' - '.'date to</b>';
            }?> 
          </td>
        </tr>
      <?php } ?>
        <?php   if($recom->demotion){ ?>
          <tr>
          <td><?php echo '<b>Demotion : </b>'.$recom->demo_pos;  ?></td>
          <td>
            <?php if(true){
              echo 'date from';
            }else {
              echo 'date from'.' - '.'date to';
            }?> 
          </td>
        </tr>
      <?php } ?>
        <?php   if($recom->regularization){  ?>
          <tr>
          <td><?php echo '<b>Regularization</b>' ?></td>
          <td>
            <?php if(true){
              echo $recom->reg_date;
            }else {
              echo 'date from'.' - '.'date to';
            }?> 
          </td>
        </tr>
      <?php } ?>
            <?php   if($recom->retain_in_existing_position){  ?>
          <tr>
          <td><?php echo '<b>Retain in existing position</b>' ?></td>
          <td>
            <?php if(true){
              echo 'date from';
            }else {
              echo 'date from'.' - '.'date to';
            }?> 
          </td>
        </tr>
      <?php } ?>
             <?php   if($recom->extend_probationary_period){  ?>
          <tr>
          <td><?php echo '<b>Extend Probationary Period :</b>'.$recom->no_months; ?></td>
          <td>
            <?php if(true){
              echo 'date from';
            }else {
              echo 'date from'.' - '.'date to';
            }?> 
          </td>
        </tr>
      <?php } ?>
                 <?php   if($recom->contract_renewal){  ?>
          <tr>
          <td><?php echo '<b>Contract renewal : </b>'; ?></td>
          <td>
            <?php if(false){
              echo 'date from';
            }else {
              echo $recom->c_from.' - '.$recom->c_to;
            }?> 
          </td>
        </tr>
      <?php } ?>
              <?php   if($recom->end_of_contract){  ?>
          <tr>
          <td><?php echo '<b>End of contract</b>'; ?></td>
          <td>
            <?php if(true){
              echo 'date from';
            }else {
              echo 'date from'.' - '.'date to';
            }?> 
          </td>
        </tr>
      <?php } ?>
            <?php   if($recom->for_lateral_transfer){  ?>
          <tr>
          <td><?php echo '<b>For lateral Transfer :</b>Department: '.$recom->f_department.'Position:'. $recom->f_position; ?></td>
          <td>
            <?php if(true){
              echo 'date from';
            }else {
              echo 'date from'.' - '.'date to';
            }?> 
          </td>
        </tr>
      <?php } ?>
            <?php   if($recom->salary_increase){  ?>
          <tr>
          <td><?php echo '<b>Salary Increase :</b>'.$recom->salary; ?></td>
          <td>
            <?php if(true){
              echo 'date from';
            }else {
              echo 'date from'.' - '.'date to';
            }?> 
          </td>
        </tr>
      <?php } ?>


      <?php } else {?>
        <tr>
          <td colspan="3"><center><strong>NO IMMEDIATE RECOMMENDATIONS</strong></center></td>
        </tr>
      <?php }?>
      <tr>
        <td colspan="3"><strong>comments :</strong>  <?php if(!empty($recom->comments)){echo $recom->comments; }?></td>
      </tr>
    </tbody>
  </table>
</div>
</div>
<div class="box box-primary">

         <div class="box-body">
          <strong>Signatures</strong>
  <table class="table">
    <thead>
      <tr class="info"><th  colspan="3">Signatures</th></tr>
      <tr class="info" >
        <th colspan="3">A. Immediate Superior or Rater</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="3">I certify that prior to the appraisal period, I have personally discussed all the parts of this PAF with the employee/ratee as basis for appraisal. The results of this PAF were discussed with the employee/ratee on the date indicated below. </td>
      </tr>
<!--        <?php foreach($evals as $e){
         if ($e->evaluator_level=="1"){
          $ext="st";
        }else if($e->evaluator_level=="2"){
          $ext="nd";
        }else if($e->evaluator_level=="3"){
          $ext="rd";
        }else{
          $ext="th";
        }}?>  -->
      <tr>
        <td width="50%"><br><br>
            <font style="text-decoration:underline; "><?php foreach($eval as $evals){ echo '['.$evals->employee_id.']'.$evals->first_name.$evals->middle_name.$evals->last_name.' '.'( level '.$evals->eval_level.')</br>';}?></font><br>Immediate Superior/Rater<br>
        <td width="50%"><br><br><font style="text-decoration:underline; ">date</font><br>Date of Discussion</td>
      </tr>
    
    </tbody>
    <thead>
      <tr class="info" >
        <th colspan="3">B. Employee or Ratee</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td colspan="3">I certify that my Immediate Superior/Rater has discussed with me all the items in this PAF prior to the appraisal period. Likewise, the results of my appraisal were also personally discussed with me by my Immendiate Superior/Rater on the date indicated below. </td>
      </tr>
      <tr>
        <td width="50%"><br>
            <input type="radio" name="agreed" value="agreed"> I agree with all results.
            <br><br><br><br>
            <font style="text-decoration:underline; ">[<?php echo $emp_info->employee_id ?>] <?=$emp_info->first_name;?> <?=$emp_info->middle_name;?> <?=$emp_info->last_name;?></font><br> Employee/Ratee
        </td>
        <td width="50%"><br>
            <input type="radio" value="disagreed" name="agreed"> 
            <input name="doc_no" type="hidden" value="<?php echo $doc_no; ?>">
         I do not agree with some/all results and I have attached a supporting letter to show details.
            <br><br><font style="text-decoration:underline; ">date</font><br>Date of Discussion</td>
      </tr>
    </tbody>
    <thead>
      <tr class="info" >
        <th colspan="3">C. Approvers</th>
      </tr>
    </thead>

    <tbody>
      

  <?php 



if(true){
  
  $cars = array("Volvo");
foreach($cars as $cars){
$name='argee'. " ".'bantang'. " ".'nabor'. " ";





  if(true){
    $cars = array("Volvo");
    foreach($cars as $cars){
   
       // $type  = $t_stat->approval_type;
          $type='';
       if (true){
        $type=='System By-Passed';
       }
       else{
        $type  = 'werwer';
       }
    }
  }else{
       $stat="pending";
  }
  //
  if(true){
    $bgstyle='#000';
  }else{
    $bgstyle='#ff0000';
  }

  $add='';
  if (false)
  { 
     $add = $dt . "<br>". $type ." <br> ";
  }?>

     
        <td width="50%"><br><br>
            <font style="text-decoration:underline; "><?php foreach($qwse as $s){ echo '['.$s->employee_id.']'.$s->fullname.' '.'( level '.$s->appro_level.')</br>';}?></font><br>Approver<br>
        <td width="50%"><br><br><font style="text-decoration:underline; ">date</font><br>Date of Discussion</td>
      
<?php }
}
?>
      </tr>
    </tbody>

  </table>

  </tbody>
</table>

</div>
</div></div>
  <div  class="col-md-2" ></div>
</div>
<div  class="col-md-10" ><br>
  <button type="submit" style="margin-left: 15px;" class="btn btn-success pull-right btn-md" >  Submit</button> 
  <button type="submit" class="btn btn-danger pull-right btn-md" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button><br><br><br>
</div>
</form>