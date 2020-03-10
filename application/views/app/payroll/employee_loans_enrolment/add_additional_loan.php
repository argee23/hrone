  
  <input type="hidden" id="loan_type" value="<?php echo $loan_type;?>">
  <input type="hidden" id="company_id" value="<?php echo $company;?>">
    <input type="hidden" id="loan_id" value="<?php echo $loan_id;?>">
  <div class="datagrid">
    <table>
        <thead>
        </thead>
        <tbody> 
          <tr class="alt">
            <td colspan="4"><center><h5><strong>Add Additional Loan</strong></h5></center></td>
          </tr>

          <tr>
              <td>Option</td>
              <td>
                  <select class="form-control" onchange="get_all_approved_forms(this.value);" id="addditonal_option">
                    <option value="" disabled selected>Select</option>
                    <option value="manual">Manual Input</option>
                    <option value="forms">Approved Forms</option>
                  </select>
              </td>
              <td><n>Approved Forms</n></td>
              <td>
                 <select class="form-control" disabled id="additional_approved" onchange="get_docno_details(this.value);">
                    <option value="" disabled selected>Select</option>
                  </select>
              </td>

              <tr>
                  <td>Additional Loan Amount</td>
                  <td>
                    <input type="text" name="addditonal_amount" class="form-control" id="addditonal_amount" placeholder="Loan Amount" onkeypress="return isNumberKey(this, event);">
                  </td>
                  <td>Description</td>
                  <td>
                  <input type="text" name="addditonal_description" class="form-control" id="addditonal_description" placeholder="Description">
                  <input type="hidden" name="addditonal_description_final" class="form-control" id="addditonal_description_final">
                  </td>
              </tr>

               <tr>
                  <td>Loan Application</td>
                  <td>
                    <input type="text" name="loan_app" class="form-control" id="loan_app" placeholder="Loan Application" >
                  </td>
                  <td>Reference Number</td>
                  <td>
                  <input type="text" name="addditonal_amount" class="form-control" id="addditonal_reference" placeholder="Reference Number">
                  </td>
              </tr>
              <tr>
                  <td>Date Effective(Deduction Effectivity)</td>
                  <td>
                  <input type="date" name="date_effective" class="form-control" id="date_effective" placeholder="e.g.2018-01-01" required>
                  </td>              
              </tr>

          <tr class="alt">
            <td colspan="4">
                <n id="doc_no_details"></n>
                <button class="btn btn-default btn-xs pull-right" onclick="collapse();"><b>VIEW ACTIVE LOAN</b></button>
                <button class="btn btn-default btn-xs pull-right" style="margin-right:5px;" id="smbt" onclick="save_additional_loan('<?php echo $loan_id;?>','<?php echo $loan_type;?>','<?php echo $company;?>');"><b>SAVE ADDITIONAL LOAN</b></button>
            </td>
          </tr>
        </tbody>
    </table>
  </div>

  <div class="datagrid" style="display: none;margin-top: 20px" id="datagridd">
      <table>
       <?php foreach($loandetails as $l){?>
        <thead>
          <tr>
            <th colspan="6">
               Employee Loan of Mila Somera Jove
               <n class="pull-right"><?php echo $l->status;?></n>
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

          <?php } ?>
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
              <td colspan="6"><strong><?php echo $i;?>).  With Loan amount of <?php echo number_format($addd->loan_amount,2);?></strong></td>
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


      </table>
    </div>

