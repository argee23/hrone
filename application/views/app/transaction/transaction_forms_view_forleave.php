<br><br>
<h4 class="text-danger"><center><?php echo $form_details->form_name;?></center></h4>
<div class="col-md-12">
  <table class="table table-bordered" id="settings_action_table"  style="margin-top:20px;">
      <thead>
        <tr class="danger">
          <th>Leave Type</th>
          <?php if($datas[2]=='TS1')
          {?>
            <th>
              Previous Days Allowed to File
            </th>
          <?php } elseif($datas[2]=='TS2'){?>
          <th>Late Filing Type</th>
          <?php } 
          elseif($datas[2] == 'TS3')
          {
            echo "<th>With Attachment</th>";
          }
          elseif($datas[2] == 'TS4')
          {
             echo "<th>Required Attachment</th>";
          }
          elseif($datas[2] == 'TS5')
          {
             echo "<th>Employee Pay Option</th>";
          }
          elseif($datas[2] == 'TS6')
          {
             echo "<th>Employee Leave Cancellation</th>";
          }
          ?>
        </tr>
      </thead>
      <tbody>
     
        <?php $i=0;

            foreach($leavedetails as $l)
            {
               $data = $this->transaction_employees_model->get_settings_data($datas[1],$datas[0],$datas[2],$l->id);
                if(empty($data)){ $d = ''; }
                else{ $d= $data; }
        ?>

          <tr>
            <td><?php echo $l->leave_type;?></td>
            <td><?php echo $d;?></td>
          </tr>
      <?php $i++; }  echo "<input type='text' style='display:none;' value='".$i."' id='counts_data_forleave'>";?>
      </tbody>
   </table>       
  </div>
  <div class="col-md-12">
      <button class="btn btn-success pull-right" onclick="update_settings_leave('<?php echo $datas[3];?>');">UPDATE</button>
   </div> 
