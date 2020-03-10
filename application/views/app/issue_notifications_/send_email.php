<?php 
  $doc_details->doc_no;
?>
<div class="col-md-12">
<div class="col-md-2"></div>
<div class="col-md-8" style="margin-top:10px;margin-left: auto;margin-right: auto;">
        
  <table border="0" width="100%" cellpadding="0" cellspacing="0">
  <thead>
  <tr>
    <th colspan="4"></th>
  </tr>
  <tr>
    <th colspan="4" style="text-align: center"><h2><?php echo $form_details->form_name?></h2></th>
  </tr>
  <tr>
    <th colspan="4"></th>
  </tr>
  
  </thead>

  <tbody style="font-size: 10px;">
  <tr>
    <td width="20%"><p style="color: #1e90ff;">EMPLOYEE ID:</p></td><td width="40%"><?php echo $file->employee_id;?></td>    
    <td><p style="color: #1e90ff;">DATE FILED:</p></td>  
    <td>
        <?php 
        // $month=substr($doc_details->date_created, 5,2);
        // $day=substr($doc_details->date_created, 8,2);
        // $year=substr($doc_details->date_created, 0,4);

        // echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
        ?>
    </td>   
  </tr>
  <tr>
    <td>
    <p style="color: #1e90ff;">EMPLOYEE NAME:</p></td> <td><?php echo $file->first_name." ".$file->middle_name." ".$file->last_name;?> </td>    
    <td>
    <p style="color: #1e90ff;">DOCUMENT NO:</p></td>  <td><?php echo $doc_no;?> </td>   
  </tr> 
  <tr>
    <td><p style="color: #1e90ff;">POSITION:</p></td>  
    <td><?php 
    $pos=$file->position;
    $pos=$this->transaction_employees_model->get_emp_pos($pos);
    foreach($pos as $position){
      echo $position->position_name;
    }
    ?></td>    
    <td><p style="color: #1e90ff;">DEPARTMENT:</p></td>  
    <td> <?php 
    $dept=$this->transaction_employees_model->get_emp_dept($file->department);
    foreach($dept as $dpt){
      echo $dpt->dept_name;
    }
    ?>
    </td>   
  </tr> 
 <tr>
    <td width="20%"><p style="color: #1e90ff;">CLASSIFICATION:</p></td>  
    <td width="">
      <?php 
    $clas=$this->transaction_employees_model->get_emp_clas($file->classification);
    foreach($clas as $class){
      echo $class->classification;
    }
    ?>
    </td>    
    <td width="20%"><p style="color: #1e90ff;">SECTION:</p></td>  
    <td width="">
     <?php 
    $sec=$this->transaction_employees_model->get_emp_sect($file->section);
    foreach($sec as $sect){
      echo $sect->section_name;
    }
    ?>
    </td>    
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
 
  <tr>
    <td colspan="4"></td>
  </tr>
  
  <?php if(!empty($doc_details->code_of_discipline))
  {
  ?>

    <tr>
      <td colspan="4"><hr></td>
    </tr>

   <tr>
    <td>
    <p class="text-primary">CODE OF DISCIPLINE:</p></td>  
    <td>
      <?php 
          $code_ = $this->issue_notifications_model->get_data_cc('title','company_code_of_discipline','cod_id',$doc_details->code_of_discipline);
          echo strip_tags($code_);
      ?>
    </td>    
    <td>
    <p class="text-primary">DISOBEDIENCE SECTION:</p></td>  
    <td>
         <?php 
          $disob_ = $this->issue_notifications_model->get_data_cc('disob_title','cod_disobedience','cod_disob_id',$doc_details->disobedience_section);
          echo strip_tags($disob_);

      ?>
    </td>   
  </tr> 
  
  <tr>
    <td>
    <p class="text-primary">DISOBEDIENCE NO.:</p></td>  
    <td> 
      <?php 
          $disob_no = $this->issue_notifications_model->get_data_cc('num_days','cod_disob_punish','pun_id',$doc_details->disobedience_no);
          $disob_title = $this->issue_notifications_model->get_data_cc('disob','cod_disob_punish','pun_id',$doc_details->disobedience_no);
          echo strip_tags($disob_title);

      ?>
    </td>    
    <td>
    <p class="text-primary">PUNISHMENT:</p></td>  
    <td>
       <?php 
          $punish = $this->issue_notifications_model->get_data_cc('punish','cod_disob_punish','pun_id',$doc_details->disobedience_no);
          echo strip_tags($punish);

      ?>
    </td>   
  </tr> 

  <?php } ?>

    <tr>
      <td colspan="4"><hr></td>
    </tr>
   

  
  <tr>
    <td></td>
    <td colspan="2" align="center"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2" align="center"></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  <tr>
    <td colspan="4"  style="text-align: center;">
      <table border="0px solid #F4F6F7" style="margin-left:auto;margin-right:auto;">

  <tr>

        </tr>          
      </table>
    </td>
  </tr>
  </tbody>
</table>
</div>
  <div  class="col-md-2" ></div>
</div>
<div class="col-md-2"></div>
</div>
