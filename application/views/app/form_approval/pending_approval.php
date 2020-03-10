<table id="transfer_approver" class="col-md-12 table table-hover table-striped">
  <thead>
    <tr  class="success">
      <th style="width:10%;">Date Filed</th>
      <th style="width:30%;">Doc No.</th>
      <th style="width:10%;">Employee ID</th>
      <th style="width:10%;">Employee Name</th>
       <th style="width:30%;">Approver</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($pending_approval as $pending) { 
     $data = $this->form_approval_model->doc_no_checker($pending->doc_no,$company,$identification);
      if(!empty($data)){
        $name = $this->form_approval_model->name($data->employee_id);
  ?>
     <tr>
        <td><?php echo $data->date_created?> </td>
        <td><a target="_blank" href="<?php echo base_url();?>app/transaction_employees/form_view/<?php echo $data->doc_no;?>/<?php echo $table_name;?>/<?php echo $identification;?>"><?php echo $data->doc_no?></a></td>
        <td><?php echo $data->employee_id?></td>
        <td><?php echo $name?></td>
        <td>
            <?php  
            $idd = $this->form_approval_model->approver_list_id($pending->doc_no,$identification);
            foreach($idd as $iddd)
            {
              $names = $this->form_approval_model->name($iddd->approver_id);
              if($iddd->status=='pending'){ 
              echo "<n class='text-success'>".$iddd->approver_id."[".$names."]"."</n><br>"; } 
              else{ 
              echo "<n class='text-danger'>".$iddd->approver_id."[".$names."]"."</n><br>";  }
            }
            ?>
        </td>
    </tr>
  <?php }  else{} } ?>
  </tbody>
</table>  
       