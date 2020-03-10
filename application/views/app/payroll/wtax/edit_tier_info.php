<div class="modal-header bg-success">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel">Edit for <strong><?php echo $tax_tier_info->pay_type_name ?></strong> Pay Type Exemption <strong><?php echo $tax_tier_info->order_no ?></strong></h4>
</div>
<div class="modal-body">
  <input type="hidden" name="pay_type" id="pay_type" value="<?php echo $tax_tier_info->pay_type?>">
  <input type="hidden" name="order_no" id="order_no" value="<?php echo $tax_tier_info->order_no?>">
  <input type="hidden" name="tax_table_id" id="tax_table_id" value="<?php echo $tax_tier_info->tax_table_id?>">

  <table class="table table-hover">
    <tr>
      <td>EXEMPTION</td>
      <td>
        <input type="number" name="exempt_value" class="form-control input-sm" value="<?php echo number_format($tax_tier_info->exempt_value,2,".","") ?>" style="text-align: right; width: 110px">
        <div class="input-group" style="text-align: right; width: 177px">
          <input type="number" name="exempt_percentage" class="form-control input-sm" value="<?php echo number_format($tax_tier_info->exempt_percentage,0,".","") ?>" style="text-align: right;">
          <div class="input-group-addon bg-info">% over</div>
        </div>
      </td>
    </tr>
    <?php foreach ($taxcodeList as $tax_code): $tax_code_exempt ="tax_code_".$tax_code->taxcode_id?>
    <tr>
      <td title="<?php echo $tax_code->description ?>" width="20%"> 
        <?php echo strtoupper($tax_code->taxcode);?>
      </td>
      <td>
        <input type="number" name="tax_code_<?php echo $tax_code->taxcode_id ?>" class="form-control input-sm" value="<?php echo number_format($tax_tier_info->$tax_code_exempt,2,'.','') ?>" style="text-align: right; width: 110px">
      </td>
    </tr>
    <?php endforeach ?>
  </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <button type="button" class="btn btn-primary" id="saveBtn" onclick="saveChanges()">Save changes</button>
</div>