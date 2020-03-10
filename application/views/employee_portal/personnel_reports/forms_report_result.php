<div class="col-md-12" style="width: 100%;overflow: scroll;">
<br>
 <h4 class="text-danger"><center>Forms Transaction Report <?php if($transaction=='All'){} else{  echo 'for '.$trans_title->form_name."(".$trans_title->identification.")"; } ?></center>
  <button class="btn btn-default pull-right" onclick="view_filtering_fr();"><i class="fa fa-arrow-up"></i></button>
  </h4>
  <br><br>
<?php if($transaction=='All'){?>
  <table class="col-md-12 table table-bordered" id="table_p_ot_all">
      <thead>
        <tr class="success">
        <?php foreach ($report_fields as $rf){ ?>
          <th><?php echo $rf->title?></th>
        <?php } ?>
        </tr>
      </thead>
      <tbody>
      
      <?php foreach($transactions as $trans){ 

        $details=$this->personnel_reports_model->generate_report_forms_details($forms_filter[0],$forms_filter[1],$trans->t_table_name,$forms_filter[3],$forms_filter[4],$forms_filter[5],$forms_filter[6],$forms_filter[7],$forms_filter[8],$forms_filter[9],$forms_filter[10],$forms_filter[11]);
          foreach ($details as $ddd) {
           
      ?>
       
        <tr>
           
            <?php foreach ($report_fields as $rf){
              
                  $ff = $rf->field;
                   if($rf->field=='form_name'){ $field = $trans->form_name; } elseif($rf->field=='identification'){ $field = $trans->identification; } else{   $field = $ddd->$ff;  }
                 
              ?>
              
                <td><?php if($ff=='doc_no'){?>
                <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $field; ?>/<?php echo $trans->t_table_name; ?>/<?php echo $trans->form_name; ?>" target="_blank"><?php echo $field; ?></a>
             <?php }else{ echo $field; } ?></td>
              <?php  }?>
        </tr>
        <?php }   } ?>
      </tbody>
    </table>
<br>
<div class="col-md-12"><a href="<?php echo base_url()?>/employee_portal/personnel_reports/fr_filter_view_by_transaction/<?php echo $forms_filter[0].'/'.$forms_filter[1].'/'.$forms_filter[2].'/'.$forms_filter[3].'/'.$forms_filter[4].'/'.$forms_filter[5].'/'.$forms_filter[6].'/'.$forms_filter[7].'/'.$forms_filter[8].'/'.$forms_filter[9].'/'.$forms_filter[10].'/'.$forms_filter[11];?>" target="_blank" class='btn btn'><n class='text-danger'><u><b>Click here to view by transaction.</b></u></a>
<?php } else{?>
  <table class="col-md-12 table table-bordered" id="table_p_ot">
      <thead>
        <tr class="success">
        <th>No</th>
        <?php foreach ($report_fields as $rf){ ?>
          <th><?php echo $rf->title?></th>
        <?php } ?>
        </tr>
      </thead>
      <tbody>
      <?php $i=1; foreach ($details as $dd) {
        ?>
        <tr>
            <td><?php echo $i.'.';?></td>
           <?php foreach ($report_fields as $rrf) {

              $ff = $rrf->field;
              if($ff=='form_name')
              {
                  $field=$transs->form_name;
              }
              else if($ff=='identification')
              {
                $field=$transs->identification;
              }
              else
              {
                $field = $dd->$ff;
              }
             
            ?>
            <td><?php if($ff=='doc_no'){?>
                <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $field; ?>/<?php echo $transaction; ?>/<?php echo $trans_title->form_name; ?>" target="_blank"><?php echo $field; ?></a>
             <?php }else{ echo $field; } ?>
            </td>
            <?php } ?>
        </tr>
      <?php $i++; } ?>
      </tbody>
    </table>

<?php } ?>
</div>





