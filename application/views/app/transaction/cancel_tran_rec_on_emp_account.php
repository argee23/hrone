<div class="col-md-14">
      <div class="box box-info">
    <div class="box-header">
Cancel Transactions On Employee Account Settings <i class="fa fa-gear text-danger"></i>
    </div>
  <div class="box-body">
 <div class="table-responsive">   <!--  for table responsiveness -->  
  <form name="f1" method="post" action="<?php echo base_url()?>app/transaction_employees/save_cancel_opt_on_emp_acc" >

  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <td>Doc.No</td>
        <td>Transaction(s)</td>
        <td>Cancellation Option on Employee Account Setting
<button type="submit" class="btn btn-primary pull-right btn-xs" ><i class="fa fa-save"></i> Save</>
        </td>

      </tr>
    </thead>
    <tbody>
    <?php foreach($file as $file_doc){?>
      <tr <?php if($file_doc->IsActive==0){ echo "class='text-danger'";}else{echo "class='text-success'";} ?>>
        <td><?php echo $file_doc->identification; ?></td>
        <td><!-- //===============================viewing of transactions -->
          <?php
         echo $file_doc->form_name;
          ?>
        </td>
        <td><!-- //===============================cancellation option on employee account setting-->
        <?php //$file_doc->id;?>
            <select class="form-control" name="<?php echo $file_doc->id;?>">
            <option value="<?php echo $file_doc->cancellation_option;?>" selected>
            <?php 
            if($file_doc->cancellation_option=="0"){
              echo "disable cancellation";
            }else if($file_doc->cancellation_option=="1"){
              echo "cancellation wthin the day on pending status";
            }else if($file_doc->cancellation_option=="2"){
              echo "allow cancellation while pending status";
            }else{
              echo "no setting yet";
            }
           // $file_doc->cancellation_option;

            ?></option>
            <option value="" disabled></option>
            <option value="0">disable cancellation</option>
            <option value="1">cancellation wthin the day on pending status</option>
            <option value="2">allow cancellation while pending status</option>
            </select>                   
        </td>

      </tr>
            <?php } ?>  
              </tbody>
            </table>   
</form>

      </div>   <!--  for table responsiveness -->
  	
  </div>

      </div>
</div>