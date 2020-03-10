<div class="col-md-14">
      <div class="box box-info">
  <form name="f1" method="post" action="<?php echo base_url()?>app/transaction_employees/save_late_fil_tran_opt/" >    
    <div class="box-header">
Late Filing Options
 <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save?</button>
    </div>
  <div class="box-body">
  	 <div class="table-responsive">   <!--  for table responsiveness -->       

  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <td>Doc.No</td>
        <td>Transaction(s)</td>
        <td>Previous Days Allowed to File</td>
      </tr>
    </thead>
    <tbody>
    <?php foreach($file as $file_doc){?>
      <tr <?php if($file_doc->IsActive==0){ echo "class='text-danger'";}else{echo "class='text-success'";} ?>>
        <td><?php echo $file_doc->identification; ?></td>
        <td> <?php echo $file_doc->form_name; ?></td>
        <td>

        <input type="hidden" name="cur_form_controller" value="<?php echo $this->uri->segment('3');?>">
        <input type="hidden" name="form_name" value="<?php echo $file_doc->form_name; ?>"> 
       	<input type="hidden" name="identification" value="<?php echo $file_doc->identification; ?>"> 
       	<select name="late_filing_option" class="form-control">
       	<option value="<?php echo $file_doc->late_filing;?>"><?php echo $file_doc->late_filing;?></option>
       	<option value="none">None</option>
       		<?php 
       		$no=1;
       		while($no<=100){
       			echo '<option value="'.$no.'">'.$no.'</option>';
       			$no++;
       		}
       		$no=0;
       		?>
       	</select>
        </td>
      
      </tr>
            <?php } ?>  
              </tbody>
            </table>   

        
      </div>   <!--  for table responsiveness -->
  </div>
    </form>
      </div>
</div>