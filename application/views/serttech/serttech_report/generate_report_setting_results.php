<table class="table table-hover" id="generate_report_result">
  <thead>
    <tr class="danger">
        <?php 
          if($crystalreport=='default'){
              if($code=='SD1')
              {?>
                  <th>Customer Type</th>
                  <th>Validity</th>
                  <th>Jobs License</th>
                  <th>Orig Price</th>
                  <th>Discount %</th>
                  <th>Discounted Price</th>
                  <th>Vat Included already</th>
                  <th>Vat Percentage</th>
                  <th>Amount of Vat</th>
                  <th>Gross</th>
            <?php } else if($code=='SD2'){?>
                  <th>Free Trial Validity</th>
                  <th>Number of Jobs Can Post</th>
            <?php } 
            else if($code=='SD12' || $code=='SD3') {?>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Note</th>
                  <th>Status</th>
                  <th>IsUploadable?</th>
                  <th>Date Created</th>
            <?php }
            else if($code=='SD6'){?>
                  <th>Smtp Host</th>
                  <th>Smtp Port</th>
                  <th>Username</th>
                  <th>Password</th>
                  <th>Send Mail From</th>
                  <th>Security Type</th>
            <?php }
            else if($code=='single_field'){?>
                  <th>Setting</th>
                  <th>Data</th>
                  <th>Date Created</th>
            <?php }
            else if($code=='setting_list' || $code=='default_setting' || $code=='not_default_setting')
            {?>
                  <th>ID</th>
                  <th>Setting</th>
                  <th>Code</th>
                  <th>IsDefault</th>
                  <th>If Single Field</th>
                  <th>Note</th>
                  <th>Date Created</th>
            <?php }
            else {?>
                  <th>Data</th>
                  <th>Date Created</th>
            <?php }
            } 
            else { 
            foreach($crystal_report as $cc){?>
            <th><?php echo $cc->label;?></th>
          <?php }  } ?>


    </tr>
  </thead>
  <tbody>
      <?php if($code=='SD1'){
          foreach($details as $bill_offers){

            $customer=$bill_offers->customer_type;
            $num_months=$bill_offers->no_of_months;
            $num_jobs=$bill_offers->no_of_jobs;
            $orig_price=$bill_offers->orig_price;
            $disc_percent=$bill_offers->discount_percentage;
            $vat_per=$bill_offers->vat_percentage;
            $is_vat_included_at_last_price=$bill_offers->is_vat_included_at_last_price;
            $less_amount = ($disc_percent / 100) * $orig_price;
            $discounted_amount = $orig_price-$less_amount;
            $vat_amount= ($vat_per / 100) * $discounted_amount;

            if($is_vat_included_at_last_price=="no"){
            $gross=$discounted_amount+$vat_amount;
            }else{
              $gross=$discounted_amount-$vat_amount;
            }

      ?>
        <tr>
          <?php 
             if($crystalreport=='default')
              {
                echo '<td>'.$customer.' customers</td>
                      <td>'.$num_months.' months</td>
                      <td>'.$num_jobs.'</td>
                      <td>'.$orig_price.'</td>
                      <td>'.$disc_percent.'%  ('.number_format($less_amount,2).')</td>
                      <td>'.$discounted_amount.'</td>
                      <td>'.$is_vat_included_at_last_price.'</td>
                      <td>'.$vat_per.'%</td>
                      <td>'.number_format($vat_amount,2).'</td>
                      <td>'?><?php if($bill_offers->InActive==1){ echo "InActive"; } else{ echo "Active"; } echo '</td> ';
              } else { 
             foreach($crystal_report as $cc){
             $dataa = $cc->field;
             if($dataa=='amount_vat') {  $val = $vat_amount; }
             else if($dataa=='gross') {  $val = $gross; }
             else if($dataa=='InActive'){ if($bill_offers->InActive==1){ $val ='InActive'; } else{ $val = "Active"; } }
             else
              {  $val = $bill_offers->$dataa; }
            
           
          ?>
            <td><?php echo $val;?></td>
          <?php } } ?>
        </tr>

      <?php } } 
      else if($code=='SD2'){
        foreach($details as $d){
      ?>
        <tr>
             <?php 
             if($crystalreport=='default'){?>
                <td><?php echo $d->free_trial_months_can_post;?></td>
                <td><?php echo $d->free_trial_jobs_can_post;?></td>
             <?php } else { 
               foreach($crystal_report as $cc){
               $dataa = $cc->field;
               $val = $d->$dataa;
              ?>
                <td><?php echo $val;?></td>
             <?php } } ?>
        </tr>

      <?php }  } else if($code=='SD12' || $code=='SD3'){ 
        foreach($details as $d){
      ?>
         <tr>
             <?php 
             if($crystalreport=='default'){?>
                <td><?php echo $d->id;?></td>
                <td><?php echo $d->title;?></td>
                <td><?php echo $d->description;?></td>
                <td><?php echo $d->note;?></td>
                <td><?php if($d->InActive==1){ echo "InActive"; } else{ echo "Active"; }?></td>
                <td><?php if($d->uploadable==1){ echo "yes"; } else{ echo "no"; };?></td>
                <td><?php echo $d->date_created;?></td>
             <?php } else { 
               foreach($crystal_report as $cc){
               $dataa = $cc->field;
               if($dataa=='InActive'){ $vv = $d->$dataa; if($vv==1){ $val='InActive'; } else{ $val = 'Active'; } }
               else if($dataa=='uploadable'){ $vv = $d->$dataa; if($vv==1){ $val='yes'; } else{ $val = 'no'; }  }
               else{  $val = $d->$dataa; }
              ?>
                <td><?php echo $val;?></td>
             <?php } } ?>
        </tr>
      <?php } ?>

      <?php } else if($code=='SD6'){
        foreach($details as $d){
      ?>
         <tr>
             <?php 
             if($crystalreport=='default'){?>
                <td><?php echo $d->smtp_port;?></td>
                <td><?php echo $d->smtp_host;?></td>
                <td><?php echo $d->username;?></td>
                <td><?php echo $d->password;?></td>
                <td><?php echo $d->send_mail_from; ?></td>
                <td><?php echo $d->security_type;?></td>
             <?php } else { 
               foreach($crystal_report as $cc){
               $dataa = $cc->field;
               $val = $d->$dataa; 
              
              ?>
                <td><?php echo $val;?></td>
             <?php } } ?>
        </tr>
      <?php } } 
      else if($code=='single_field'){

           foreach($details as $d){
            ?>
               <tr>
                   <?php 
                   if($crystalreport=='default'){?>
                      <td><?php echo $d->policy_title;?></td>
                      <td><?php echo $d->data;?></td>
                      <td><?php echo $d->date_created;?></td>
                   <?php } else { 
                     foreach($crystal_report as $cc){
                     $dataa = $cc->field;
                     $val = $d->$dataa; 
                    ?>
                      <td><?php echo $val;?></td>
                   <?php } } ?>
              </tr>
        <?php }

       }
       else if($code=='setting_list' || $code=='default_setting' || $code=='not_default_setting') 
        {

          foreach($details as $d){
            ?>
               <tr>
                   <?php 
                   if($crystalreport=='default'){?>
                      <td><?php echo $d->id;?></td>
                      <td><?php echo $d->policy_title;?></td>
                      <td><?php echo $d->code;?></td>
                      <td><?php if($d->IsDefault==1){ echo "yes"; } else { echo "no"; } ;?></td>
                      <td><?php if($d->InActive==1){ echo "InActive"; } else{ echo "Active"; };?></td>
                      <td><?php echo $d->note;?></td>
                      <td><?php echo $d->date_created;?></td>
                   <?php } else { 
                     foreach($crystal_report as $cc){
                     $dataa = $cc->field;
                     $val = $d->$dataa; 
                    ?>
                      <td><?php if($dataa=='InActive'){ if($val==1){ echo "InActive"; } else{ echo "Active"; } } else if($dataa=='IsDefault'){ if($val==1){ echo "yes"; } else{ echo "no"; } } else if($dataa=='single_fields') { if($val==1){ echo "yes"; } else{ echo "no"; } } else { echo $val; } ?></td>
                   <?php } } ?>
              </tr>
      <?php }}
      //else 
      else{

            foreach($details as $d){
            ?>
               <tr>
                   <?php 
                   if($crystalreport=='default'){?>
                      <td><?php echo $d->data;?></td>
                      <td><?php echo $d->date_created;?></td>
                   <?php } else { 
                     foreach($crystal_report as $cc){
                     $dataa = $cc->field;
                     $val = $d->$dataa; 
                    ?>
                      <td><?php echo $val;?></td>
                   <?php } } ?>
              </tr>
      <?php }


        } ?>
  </tbody>
</table>
   