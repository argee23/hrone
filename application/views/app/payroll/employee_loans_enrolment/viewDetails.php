
  <input type="hidden" id="loan_type" value="<?php echo $loan_type;?>">
  <input type="hidden" id="company_id" value="<?php echo $company;?>">
  <input type="hidden" id="loan_id" value="<?php echo $loan_id;?>">
  

  
  <div id="update_loan_details" style="padding-top: 10px;">
    
  </div>

 

  <div class="datagrid" style="margin-top: 20px" id="datagridd">
      <table>
       <?php foreach($loandetails as $l){?>
        
        <thead>
          <tr>
            <th colspan="6">
               Employee Loan of <?php echo $l->fullname;?> <i>(<?php echo $l->status;?>)</i>
               <?php if($l->status=='Active' || $l->status=='Pause'){
                  if($l->status=='Pause')
                  {
                ?>
                  
                  <a class='fa fa-pause-circle-o fa-lg pull-right' style='cursor:pointer;color:#FF4500;'  onclick="enable_disable('<?php echo $l->emp_loan_id;?>','<?php echo $l->loan_type_id;?>','<?php echo $l->company_id;?>','Active','Main','<?php echo $l->emp_loan_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Activate Loan'></a>
                <?php } else{ ?>
                  <a class='fa fa-pause-circle-o fa-lg pull-right' style='cursor:pointer;color:#7CFC00;'  onclick="enable_disable('<?php echo $l->emp_loan_id;?>','<?php echo $l->loan_type_id;?>','<?php echo $l->company_id;?>','Pause','Main','<?php echo $l->emp_loan_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Pause Loan'></a>

                  <a class='fa fa-paypal fa-lg pull-right' style='cursor:pointer;color:#D2691E;'  onclick="enable_disable('<?php echo $l->emp_loan_id;?>','<?php echo $l->loan_type_id;?>','<?php echo $l->company_id;?>','Paid','Main','<?php echo $l->emp_loan_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Mark as Paid'></a>


                <?php } ?>

                  <a class='fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg pull-right' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to Delete All Loan' onclick="deleteDetails('<?php echo $l->emp_loan_id;?>','<?php echo $l->loan_type_id;?>','<?php echo $l->company_id;?>');"></a>
                  <a class='fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-right' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="editDetails('main','<?php echo $l->emp_loan_id;?>','<?php echo $l->loan_type_id;?>','<?php echo $l->company_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Update Loan'></a>

                
               <?php } ?>
            </th>
          </tr>
         
        </thead>
        <tbody> 
        
          <tr class="alt">
            <td style="width:15%;"><n class='text-danger'><strong>Date Effective</strong></n></td>
            <td style="width:15%;">  
              <u>
                <?php 
                if(!empty($l->date_effective)){
                  $month=substr($l->date_effective, 5,2);
                  $day=substr($l->date_effective, 8,2);
                  $year=substr($l->date_effective, 0,4);

                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year; }
                ?>
              </u>
            </td>
            <td style="width:15%;"><n class='text-danger'><strong>Date Granted</strong></n></td>
            <td style="width:15%;">
              <u>
              <?php 
                 if(!empty($l->date_granted)){
                  $month=substr($l->date_granted, 5,2);
                  $day=substr($l->date_granted, 8,2);
                  $year=substr($l->date_granted, 0,4);

                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year; }
                ?>
              </u>
            </td>
            <td style="width:15%;"><n class='text-danger'><strong>Loan Type</strong></n></td>
            <td style="width:15%;"><u><?php echo $l->loan_type;?></u></td>
          </tr>

          <tr class="alt">
            <td><n class='text-danger'><strong>Department</strong></n></td>
            <td><u><?php echo $l->section_name?></u></td>
            <td><n class='text-danger'><strong>Section</strong></n></td>
            <td><u><?php echo $l->section_name?></u></td>
            <td><n class='text-danger'><strong>Classification</strong></n></td>
            <td><u><?php echo $l->classification?></u></td>
          </tr>
          <tr class="alt">
            <td><n class='text-danger'><strong>Loan Amount</strong></n></td>
            <td><u><?php if(!empty($l->loan_amt)){ echo number_format($l->loan_amt,2); } ?></u></th>
            <td><n class='text-danger'><strong>Amortization</strong></n></td>
            <td><u><?php if(!empty($l->amortization)){ echo number_format($l->amortization,2); } ?></u></td>
             <td><n class='text-danger'><strong>Pay Type</strong></n></td>
            <td><u><?php echo $l->pay_type_name?></u></td>

          </tr>
           <tr class="alt">
             <td><n class='text-danger'><strong>Option</strong></n></td>
            <td><u><?php foreach($pay_type_option as $p){ if($p->cDesc==$l->option){ echo $p->cValue; }}?></u></td>
            <td><n class='text-danger'><strong>Principal Amount</strong></n></td>
            <td><u><?php if(!empty($l->principal_amt)){ echo number_format($l->principal_amt,2); } ?></u></td>
            <td><n class='text-danger'><strong>Reference Number</strong></n></td>
            <td><u><?php echo $l->ref_no;?></u></td>
          </tr>
          
                  
        </tbody>

        <thead>
        <?php if(count($additionalloan)==0){} else{?>
        <tr>
            <th colspan="6">
               Employee Additional Loans  

            </th>
          </tr>
        <?php } ?>
        </thead>

        <tbody>
            <?php if(count($additionalloan)==0){} else{
             $i=1; foreach($additionalloan as $addd){
            ?>
            <tr class="alt">
              <td colspan="6">
                <strong><?php echo $i;?>).  With Loan amount of <?php echo number_format($addd->loan_amount,2);?></strong>
                <?php if($l->status=='Active'){

                ?>
                <a class='fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg pull-right' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="deleteDetails_additional('<?php echo $l->emp_loan_id;?>','<?php echo $l->loan_type_id;?>','<?php echo $l->company_id;?>','<?php echo $addd->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete All Loan'></a>
                  <a class='fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-right' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="editDetails('<?php echo $addd->id;?>','<?php echo $l->emp_loan_id;?>','<?php echo $l->loan_type_id;?>','<?php echo $l->company_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Update Loan'></a>
                <?php } ?>
                 
              </td>
            </tr>

            <tr>
              <td>Date Effective</td>
              <td><?php echo $addd->date_effective;?></td>
            </tr>

             <tr>
              <td>Loan Amount : </td>
              <td><u><?php echo number_format($addd->loan_amount,2);?><u></td>
              <td>Date Added :</td>
              <td><u>
                <?php 
                 if(!empty($addd->date_added)){
                  $month=substr($addd->date_added, 5,2);
                  $day=substr($addd->date_added, 8,2);
                  $year=substr($addd->date_added, 0,4);

                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year; }
                ?>
                <u></td>
              <td>Description :</td>
              <td><u><?php echo $addd->description;?><u></td>
            </tr>


             <tr>
              <td>Reference Number :</td>
              <td><u><?php if(empty($addd->reference_no)){ echo "no reference number"; } else{ echo $addd->reference_no; };?><u></td>
              <td>Loan Application Number :</td>
              <td><u><?php echo $addd->app_num;?><u></td>
              <?php if($addd->added_doc_no=='not_included' || empty($addd->added_doc_no)){} else{?>
              <td>Doc Number :</td>
              <td><u><a style="cursor:pointer;" target="_blank" href='<?php echo base_url();?>/app/transaction_employees/form_view/<?php echo $addd->added_doc_no;?>/emp_loans/HR005'><?php echo $addd->added_doc_no;?></a><u></td>
              <?php  } ?>
            </tr>


            <?php $i++; } } ?>
            <tr class="alt">
              <td colspan="6"><strong><n class="pull-right text-danger" style="font-size: 15px;">Total Loan:<?php echo number_format($total_loan,2);?></n></strong></td>
            </tr>

            
        </tbody>

          <?php } ?>





      </table>
    </div>

