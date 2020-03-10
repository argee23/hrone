<label>Transaction List :</label>
 <ul class="nav nav-pills nav-stacked">
                <?php foreach ($transaction as $row) { ?>
                  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;"  onclick="transaction_data(<?php echo $row->id ?>);"><i class='fa fa-folder-open'></i> <span><n <?php if($row->IsActive=='0' || $row->IsActive==''){ echo "class='text-danger'"; } else{}?> ><?php echo $row->form_name?></n></span></a></li>
                  <?php } ?>
            </ul>