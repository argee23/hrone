
<?php if($val=='SD12' || $val=='SD3')
{?>
   <table class="table table-hover" id="<?php echo $type;?>">
          <thead>
            <tr class="danger">
              <th>No</th>
              <th>ID</th>
              <th>Title</th>
              <th>Description</th>
              <th>Notes</th>
              <th>Uploadable?</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; foreach($details as $row){?>
            <tr>
              <td><?php echo $i;?></td>
              <td><?php echo $row->id;?></td>
              <td>
                <div id="o_title<?php echo $row->id;?>"><?php echo $row->title;?></div>
                <div id="u_title<?php echo $row->id;?>" style="display: none;">
                    <input type="text" class="form-control" id="upd_title<?php echo $row->id;?>" value="<?php echo $row->title;?>">
                    <input type="hidden" id="upd_title_<?php echo $row->id;?>">
                </div>
              </td>
              <td>
                <div id="o_desc<?php echo $row->id;?>"><?php echo $row->description;?></div>
                <div id="u_desc<?php echo $row->id;?>" style="display: none;">
                    <input type="text" class="form-control" id="upd_desc<?php echo $row->id;?>" value="<?php echo $row->description;?>">
                    <input type="hidden" id="upd_desc_<?php echo $row->id;?>">
                </div>
              </td>
              <td>
                <div id="o_note<?php echo $row->id;?>"><?php echo $row->note;?></div>
                <div id="u_note<?php echo $row->id;?>" style="display: none;">
                    <input type="text" class="form-control" id="upd_note<?php echo $row->id;?>" value="<?php echo $row->note;?>">
                    <input type="hidden" id="upd_note_<?php echo $row->id;?>">
                </div>
              </td>
              <td>
                <div id="o_uploadable<?php echo $row->id;?>"><?php if($row->uploadable==1){ echo "Yes"; } else{ echo "No"; } ?></div>
                <div id="u_uploadable<?php echo $row->id;?>" style="display: none;">
                    <input type="radio" name="updfile_uploadable<?php echo $row->id;?>" onclick="action_file_uploaded('upd_final_file_uploaded','1');" <?php if($row->uploadable==1){ echo "checked"; }?>> Yes
                    <input type="radio" name="updfile_uploadable<?php echo $row->id;?>" onclick="action_file_uploaded('upd_final_file_uploaded','0');"  <?php if($row->uploadable==0){ echo "checked"; }?>> No
                    <input type="hidden" id="upd_final_file_uploaded" value='<?php echo $row->uploadable;?>'>
                </div>

                

              </td>
           
            </tr>
          <?php $i++; } ?>
          </tbody>
        </table>
<?php } 
else if($val=='SD1')
{?>
 <table id="<?php echo $type;?>" class="table table-bordered table-striped">
          <thead>

            <tr class="danger">
              <th>No</th>
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
            </tr>
          </thead>
          <tbody>
          <?php
          $i=1;
          foreach($rec_employer_bill_setting_mng as $bill_offers){

          if ($bill_offers->InActive=="0"){
            $color="";
            $todo="disable_bill";
            $bg="";

          }elseif($bill_offers->InActive=="1"){
            $color="";
            $todo="enable_bill";
          $bg="";
          }else{

          }

          $enable_disable= '<a href="'.base_url().'serttech/mypublic_recruitment/'.$todo.'/'.$bill_offers->id.'"  " ><i class="fa fa-power-off '.$color.' pull-right"></i></a>'.'<br>';
          $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right"   data-toggle="tooltip" data-placement="left" title="Edit" onclick="editbill('.$bill_offers->id.')"></i>';
          $delete = anchor('serttech/mypublic/delete_bill/'.$bill_offers->id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-right"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ?')"));


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

          echo '<tr '.$bg.'>';
          echo '<td>'.$i.'</td>';
          echo '<td>'.$customer.' customers</td>';
          echo '<td>'.$num_months.' months</td>';
          echo '<td>'.$num_jobs.'</td>';
          echo '<td>'.$orig_price.'</td>';
          echo '<td>'.$disc_percent.'%  ('.number_format($less_amount,2).')</td>';
          echo '<td>'.$discounted_amount.'</td>';
          echo '<td>'.$is_vat_included_at_last_price.'</td>';
          echo '<td>'.$vat_per.'%</td>';
          echo '<td>'.number_format($vat_amount,2).'</td>';
          echo '<td>'.number_format($gross,2).'</td>';

          echo '</tr>';
        $i++; }
          ?>
          </tbody>
    </table>
<?php }  elseif($val=='SD6'){?>

  <table class="table table-hover" id="<?php echo $type;?>">
          <thead>
            <tr class="danger">
              <th>SMTP Host</th>
              <th>SMPT Port</th>
              <th>Username</th>
              <th>Password</th>
              <th>Send Email From</th>
              <th>Security Type</th>
            </tr>
          </thead>
          <tbody>
          <?php  foreach($details as $row){?>
            <tr>
              <td><?php echo $row->smtp_host;?></td>
              <td><?php echo $row->smtp_port;?></td>
              <td><?php echo $row->username;?></td>
              <td><?php echo $row->password;?></td>
              <td><?php echo $row->send_mail_from;?></td>
              <td><?php echo $row->security_type;?></td>
            </tr>
          <?php  } ?>
          </tbody>
        </table>

<?php } else{?>

  <table class="table table-hover" id="<?php echo $type;?>">
          <thead>
            <tr class="danger">
              <th>No</th>
              <th>Setting Title</th>
              <th>Note</th>
              <th>Status</th>
              <th>Is Default</th>
              <th>Data</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; foreach($details as $row){?>
            <tr>
              <td><?php echo $i;?></td>
              <td><?php echo $row->policy_title;?></td>
              <td><?php echo $row->note;?></td>
              <td><?php if($row->InActive==0){ echo "Active"; } else{ echo "InActive"; };?></td>
              <td><?php if($row->IsDefault==0){ echo "no"; } else{ echo "yes"; };?></td>
              <td><?php echo $row->data;?></td>
            </tr>
          <?php $i++; } ?>
          </tbody>
        </table>

<?php } ?>