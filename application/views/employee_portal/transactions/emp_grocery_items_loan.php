
<div class="panel panel-default">
  <div class="panel-body">
  <h4 class="panel-header">AUTHORIZATION FORM FOR GROCERY ITEM LOAN</h4>
  <hr>
  <?php if (count($approvers) == 0)
  { ?>



      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>

                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>

  <?php } else { ?>
  <form class="form-horizontal" name="add_med_re" method="post" enctype="multipart/form-data" action="add_grocery" onsubmit="document.getElementById('smbt').disabled=true;"
>

  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Grocery Items Total Worth</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="grocery_items_worth" name="grocery_items_worth" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': false" required>
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Net Pay</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="net_pay" name="net_pay" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': false" required>
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Coop Balance</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="coop_balance" name="coop_balance" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': false" required>
    </div>
  </div>


  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Last Payroll Period</label>
    <div class="col-sm-8">
    <select class="form-control" name="last_payroll_period" id="last_payroll_period" required>
     <?php
            $checker_pp =''; 
            foreach($payrollPeriods as $per)
            {
                $ppid = $per->id;
                $from = $per->year_from .'-'. $per->month_from.'-'.$per->day_from;
                $to = $per->year_to .'-'. $per->month_to.'-'.$per->day_to;
                $formatted =  date("F d, Y", strtotime($from)) . " to " .  date("F d, Y", strtotime($to));
                if(empty($checker_pp))
                {   
                    $checker_pp.=$ppid."/";
                    $res = true;
                }
                else
                {
                    $explode =  explode('/',$checker_pp);
                    if (in_array($ppid, $explode)) {
                          $res = false;
                    } else {
                          $checker_pp.=$ppid."/";
                          $res = true;
                       }
                    }
                    if($res==true){
                ?>
                  <option value="<?php echo $per->id; ?>"><?php echo $formatted; ?></option>
                <?php  } } ?>
    </select>
    </div>
  </div>

  <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">

      <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">


  
  <?php
  $required = '';
  $req = 0;
  if ($setting_attachment == 1) { 

    if ($setting_required == 1)
    {
        $required = 'required';
        $req = 1;
    }
  ?> 
    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>File Attachment</center></label>
          <div class="col-sm-8">
              <input type="file"  id="file_attached" name="file_attached" <?php echo $required;?>>
              <div class="help-block with-errors"><span class="text-danger"> <small><i>Accepted Files: PNG, JPG, GIF, PDF | File size must not exceed 500 KB</i></small></span>
          </div>
        </div>
    </div>
    </div>
 <?php } ?>

  <input type="hidden" name="required" value="<?php echo $setting_required;?> ">
  <input type="hidden" name="attach_file" value="<?php echo $setting_attachment;?>">
  



    
  <div class="form-group">
  <label class="control-label col-sm-4" for="email">Reason</label>
  <div class="col-sm-8">
  <textarea class="form-control" rows="3" id="reason" name="reason"></textarea>
  </div>
  </div>

   <div class="form-group">
    <label class="control-label col-sm-4" for="email"></label>
    <div class="col-sm-8">
    <button type="submit" class="btn btn-success btn-md" id="smbt">Submit</button>
    </div>
  </div>
</form>


  <?php } ?>
  </div>
</div>


<?php require_once(APPPATH.'views/app/application_form/footer.php');?>