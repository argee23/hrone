<td><?php echo $location->location_name ?></td>
<?php if ($minimum): ?>
<td>
  <form action="<?php echo base_url()?>app/payroll_wtax/modify_minimum" method="post" id="modify_minimum">
    <input type="hidden" name="company_id" id="company_id"  value="<?php echo $company_id ?>">
    <input type="hidden" name="location_id" id="location_id"  value="<?php echo $location_id ?>">
    <input type="text" class="form-control input-sm" name="minimum_amount" id="minimum_amount" value="<?php echo number_format($minimum->minimum_amount,2) ?>" style="text-align: center"> 

  <span class="text-danger">Effectivity Date</span>
   <input type="date" class="form-control input-sm" name="effectivity_date" id="effectivity_date" style="text-align: center" value="<?php echo $minimum->effectivity_date; ?>" required>  

   <span class="text-danger">Declaration Date</span>
   <input type="date" class="form-control input-sm" name="declaration_date" id="declaration_date" style="text-align: center" value="<?php echo $minimum->declaration_date; ?>" required>  


  </form>                   
</td>
<td>
  <span class="pull-right"><button class="btn btn-link" data-id="<?php echo $company_id?>" id="<?php echo $location_id?>" onclick="modifyMinimum(this.id,this.getAttribute('data-id'))"><i class="fa fa-floppy-o"></i> save</button></span>
</td>
<?php else: ?>
<td>
  <form action="<?php echo base_url()?>app/payroll_wtax/add_minimum" method="post" id="add_minimum">
    <input type="hidden" name="company_id" id="company_id"  value="<?php echo $company_id ?>">
    <input type="hidden" name="location_id" id="location_id"  value="<?php echo $location_id ?>">
   <input type="text" class="form-control input-sm" name="minimum_amount" id="minimum_amount" value="0.00" style="text-align: center">  

  <span class="text-danger">Effectivity Date</span>
   <input type="date" class="form-control input-sm" name="effectivity_date" id="effectivity_date"  style="text-align: center" required>  

   <span class="text-danger">Declaration Date</span>
   <input type="date" class="form-control input-sm" name="declaration_date" id="declaration_date" style="text-align: center" required>  

  </form>                 
</td>
<td>
  <span class="pull-right"><button class="btn btn-link" onclick="saveMinimum()"><i class="fa fa-floppy-o"></i> save</button></span>
</td>
<?php endif ?>