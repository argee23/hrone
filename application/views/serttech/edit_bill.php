
<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>serttech/mypublic_recruitment/modify_bill/<?php echo $this->uri->segment("4");?>">
    <div class="box-body">

      <div class="form-group">
        <label for="customer_type" class="col-sm-2 control-label">Customer Type</label>
        <div class="col-sm-10">
          <select name="customer_type" class="form-control"  required >
          <?php if($bill->customer_type=="new"){
          		$select_new="selected";
          		$select_old="";
          }else{
          		$select_old="selected";
          		$select_new="";
          }
          ?>
          <option value="new"  <?php echo $select_new;?> >New Customer</option>
          <option value="old"  <?php echo $select_old;?> >Old Customer</option>

          </select>

        </div>
      </div>

            <div class="form-group" id="manual_select_month">
        <label for="no_of_months" class="col-sm-2 control-label">Validity</label>
        <div class="col-sm-10">
          <select name="no_of_months" class="form-control" required >
          <option value="<?php echo $bill->no_of_months;?>" ><?php echo $bill->no_of_months;?> Months</option>
          <option value="" disabled="">&nbsp;</option>
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
          <input type="number" class="form-control" name="no_of_jobs"  placeholder="No. of Jobs Can post" value="<?php echo $bill->no_of_jobs;?>">
        </div>
      </div>
      <div class="form-group">
        <label for="orig_price" class="col-sm-2 control-label">Price</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="orig_price" placeholder="Price" value="<?php echo $bill->orig_price;?>" onkeypress="return isNumberKey(event)">
        </div>
      </div>
      <div class="form-group">
        <label for="discount_percentage" class="col-sm-2 control-label">Discount Percentage</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="discount_percentage" placeholder="eg. 2" value="<?php echo $bill->discount_percentage;?>" onkeypress="return isNumberKey(event)">
        </div>
      </div>
      <div class="form-group">
        <label for="vat_percentage" class="col-sm-2 control-label">Vat Percentage</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="vat_percentage" placeholder="eg. 2" value="<?php echo $bill->vat_percentage;?>" onkeypress="return isNumberKey(event)">
        </div>
      </div>
      <div class="form-group">
        <label for="is_vat_included_at_last_price" class="col-sm-2 control-label">Is VAT Included already?</label>
        <div class="col-sm-10">
        <?php 
        if($bill->is_vat_included_at_last_price=="yes"){
        $check_yes="checked";
        $check_no="";
        }else{
        	$check_no="checked";
        	$check_yes="";
        }
        	?>
       <input type="radio" name="is_vat_included_at_last_price" <?php echo $check_yes;?>>Yes
       <input type="radio" name="is_vat_included_at_last_price"  <?php echo $check_no;?>>No
        </div>
      </div>
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>