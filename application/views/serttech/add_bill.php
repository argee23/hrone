
<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>serttech/mypublic_recruitment/save_bill">
    <div class="box-body">

      <div class="form-group">
        <label for="customer_type" class="col-sm-2 control-label">Customer Type</label>
        <div class="col-sm-10">
          <select name="customer_type" class="form-control"  required >
        
          <option value="new" >New Customer</option>
          <option value="old"   >Old Customer</option>

          </select>

        </div>
      </div>

            <div class="form-group" id="manual_select_month">
        <label for="no_of_months" class="col-sm-2 control-label">Validity</label>
        <div class="col-sm-10">
          <select name="no_of_months" class="form-control" required >
          <option value="" disabled="" selected>Select </option>
          <?php
              for($M =1;$M<=60;$M++){

              	if($M=="1"){
              		$months="month";
              	}else{
					$months="months";
              	}


                  echo "<option value='".$M."'>". $M ." ". $months."</option>";
                }
          ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="no_of_jobs" class="col-sm-2 control-label">No. of Jobs Can post</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="no_of_jobs"  placeholder="No. of Jobs Can post" value="">
        </div>
      </div>
      <div class="form-group">
        <label for="orig_price" class="col-sm-2 control-label">Price</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="orig_price" placeholder="Price" value="" onkeypress="return isNumberKey(event)">
        </div>
      </div>
      <div class="form-group">
        <label for="discount_percentage" class="col-sm-2 control-label">Discount Percentage</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="discount_percentage" placeholder="eg. 2" value="" onkeypress="return isNumberKey(event)">
        </div>
      </div>
      <div class="form-group">
        <label for="vat_percentage" class="col-sm-2 control-label">Vat Percentage</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="vat_percentage" placeholder="eg. 2" value="" onkeypress="return isNumberKey(event)">
        </div>
      </div>
      <div class="form-group">
        <label for="is_vat_included_at_last_price" class="col-sm-2 control-label">Is VAT Included already?</label>
        <div class="col-sm-10">
       
       <input type="radio" name="is_vat_included_at_last_price" >Yes
       <input type="radio" name="is_vat_included_at_last_price"  >No
        </div>
      </div>
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-pencil"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>