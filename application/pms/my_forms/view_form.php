
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

<div  id="printableArea" style="background-color: red;"> <!-- this is important -->
  <div  class="col-md-2" ></div>
  <div class="col-md-8" style="margin-top:10px;margin-left: auto;margin-right: auto;border:4px solid #F1F3F9; background-color: white " >
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
    <span class="col-sm-10">
      <dt>Employee Name</dt>
      <dd><?=$emp_info->first_name;?> <?=$emp_info->middle_name;?> <?=$emp_info->last_name;?></dd>
      <dt>Division</dt>
      <dd><?=$emp_info->division_name;?></dd>
      <dt>Department</dt>
      <dd><?php if($emp_info->dept_name == '' || $emp_info->dept_name == null){ echo 'N/A'; } else { echo $emp_info->dept_name; }?></dd>
      <dt>Classification</dt>
      <dd><?=$emp_info->classification_name;?></dd>
      <div class="pull-right" style="margin-top: -160px;">
      <dt>Position</dt>
      <dd><?=$emp_info->position_name;?></dd>
      <dt>Current Status</dt>
      <dd><?=$emp_info->employment_name;?></dd>
      <dt>Date Hired</dt>
      <dd><?=date("F d, Y", strtotime($emp_info2->date_employed));?></dd>
      <dt>Performance Appraisal Period</dt>
      <dd>July 14 2019<br><br><br></dd>
    </div>
    </span>



  <br>
  <table class="table">
    <thead>
      <tr class="info">
        <th>General Instructions</th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <td><?php echo nl2br($gIns->instruction);?><br><br></td>
        </tr>
    </tbody>
    <?php foreach ($summary as $s):?>
    <thead>
      <tr>
        <th>Part <?=$s->form_part?>: <?=$s->form_title?></th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <td><?php echo nl2br($s->form_instruction);?></td>
        </tr>
      <?php endforeach?>
    </tbody>
  </table>

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
  <table border="0" width="100%" cellpadding="0" cellspacing="0">
    
  <tbody style="font-size: 10px;">

    <table class="table">
      <thead>
        <tr class="info">
          <th scope="col" colspan="4">Part  <?php 
            echo '1 : KRA';
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
      <tbody>
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
          $score = $this->pms_model->get_form_score($e_id,$file_doc->fid);
          $w = '';
          $q = '';
          foreach($score as $sc):?>
            <tr id='sec'>
              
              <?php       $ws = $this->pms_model->criteira_s($sc->cid);
              foreach($ws as $ws){
 ?>           <td><?=$sc->area?></td>
              <td><?=$ws->description?></td>
              <td><?=$ws->weight?></td>
              <td><?=$ws->score?></td>
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
              <td scope="col" colspan="1"><?php echo '<b>'.$q.'</b>'; ?></td>
            </tr>
                </table>
  

        </tr>  
      </table>
    </td>
  </tr>
  <?php
  }
  ?>

  <!-------------------------------------------------------------------- FINAL RATING ----------------------------------------------------->

  <br><br><br>
  <table class="table">
    <thead>
      <tr class="info"><th colspan="5">Final Rating of Employee or Ratee</th></tr>
      <tr>
        <th colspan="2">Final Rating</th>
        <th>Weight</th>
        <th>Part rating</th>
        <th> Rating</th>
      </tr>
    </thead>
    <tbody>
  <?php $sw= '';$c= ''; foreach ($summary as $s):?>
        <tr>
          <td><?=$s->form_part?></td>
          <td><?=$s->form_title?></td>
          <td><?=$s->weight?></td>
          <td><?=$s->part_rating?></td>
          <td><?=$s->total_rating?></td>
        </tr>
      <?php $sw += $s->weight; $c += $s->total_rating; endforeach ?>
      <tr>
        <td scope="col" colspan="2"><strong>Final Rating</strong></td>
        <td><strong><?php echo $sw; ?> %</strong></td>
        <td></td>
        <td><strong><?php echo $c; ?></strong></td>
      </tr>
    </tbody>
  </table>


  <!-------------------------------------------------------- RECOMMENDATION -------------------------------------------------------------->

  <br><br><br>
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
      if(true){
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
        <td colspan="3"><strong>comments :</strong>  <?php echo $recom->comments; ?></td>
      </tr>
    </tbody>
  </table>

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
            <font style="text-decoration:underline; ">[112312]argee bqeqwe qw</font><br>Immediate Superior/Rater<br>1st Level
        </td>
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
            <input type="checkbox"> I agree with all results.
            <br><br><br><br>
            <font style="text-decoration:underline; ">[<?php echo $emp_info->employee_id ?>] <?=$emp_info->first_name;?> <?=$emp_info->middle_name;?> <?=$emp_info->last_name;?></font><br> Employee/Ratee
        </td>
        <td width="50%">
            <textarea row='2' class="form-control" id='asd'></textarea> I do not agree with some/all results and I have attached a supporting letter to show details.
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
  }

      echo '
      <tr>
          <td width="50%">
          <br><br>
            <font style="text-decoration:underline; ">'.'[tyery] '.'argee'.'</font><br>'.'1st Level'.'<br>'.'position'.'
          </td><br><br>
          <td width="50%"><br><br><font style="text-decoration:underline; ">'.'date'.'</font><br>Date of Approval</td>';
}
}
?>
      </tr>
    </tbody>

  </table>

  </tbody>
</table>

</div>
  <div  class="col-md-2" ></div>
</div>
<div  class="col-md-10" ><br>
  <button type="submit" class="btn btn-danger pull-right btn-md" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button><br><br><br>
</div>
