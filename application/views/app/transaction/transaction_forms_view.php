<br><br>
<h4 class="text-danger"><center><?php echo $form_details->form_name;?></center></h4>
<div class="col-md-12">
  <table class="table table-bordered" id="settings_action_table"  style="margin-top:20px;">
      <thead>
        <tr class="danger">
          <th>Company Name</th>
          <?php if($datas[2]=='TS1')
          {?>
            <th>
              Previous Days Allowed to File <i class="pull-right"><a style="cursor: pointer;">mass input</a></i>
              <div class="col-md-12" style="display: none;"><input type="number" class="form-control"></div>
            </th>
          <?php } elseif($datas[2]=='TS2'){?>
          <th>Late Filing Type</th>
          <?php } else if($datas[2]=='TS3') {?>
           <th>With Attachment</th>
          <?php } else if($datas[2]=='TS4'){?>
           <th>Attachment Required</th>
          <?php } else if($datas[2]=='TS5'){?>
          <th>Leave Options</th>
          <?php } else if($datas[2]=='TS6'){?>
          <th>Cancellation Option</th>
          <?php } else if($datas[2]=='TS7'){?>
          <th>Maximum allowed undertime hrs to be filed</th>
          <?php } else if($datas[2]=='TS8'){?>
           <th>Update raw in and out in TK ?</th>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
      <?php
        $i=0;
        foreach($company_list as $comp)
        {
          $data = $this->transaction_employees_model->get_settings_data($comp->company_id,$datas[0],$datas[2],'none');
          if(empty($data)){ $d = 'no settings'; }
          else{ $d= $data;}
          ?>
          <tr>
            <td><?php echo $comp->company_name;?></td>
            <td><?php if($datas[2]=='TS3'){ if($data==1){ echo "yes"; } else if($data==0){ echo "no"; } else{ echo "no_settings"; }  } 
                      else if($datas[2]=='TS4'){ if($data==1){ echo "required"; } else if($data==0){ echo "not required"; } else{ echo "no_settings"; } } 
                      else{ echo $data; }?>
                
            </td>
          </tr>
      <?php $i++;  } echo "<input type='text' style='display:none;' value='".$i."' id='counts_data'>";?>
      </tbody>
   </table>
    <input type="hidden" id="company_data">  
    <input type="hidden" id="settings_value"> 
    <input type="hidden" id="settings_checked">          
  </div>
<div class="col-md-12">
      <button class="btn btn-success pull-right" onclick="update_settings('<?php echo $datas[0];?>');">UPDATE</button>
   </div> 
