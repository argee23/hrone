<table class="table table-hover" id="generate_report_results">
  <thead>
    <tr class="danger">
    <?php foreach($crystal_report as $cc){?>
      <th><?php echo $cc->label;?></th>
    <?php } ?>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($details as $d) {
  ?>
    <tr>
    <?php foreach($crystal_report as $cc){
    
        $cc_field = $cc->field;
      
          if($code_type=='S2' AND $cc_field=='numbering')
              {
                $get_numbering = $this->report_recruitments_model->get_numbering_application_status($d->company_id,$d->id,'numbering');
                if(empty($get_numbering)){ $data = "no setup yet"; } else{ $data = '11'; }
              } 
          else if($code_type=='S2' AND $cc_field=='include_comp')
              {
                $get_comp = $this->report_recruitments_model->get_numbering_application_status($d->company_id,$d->id,'include_in_computation_job_vacancy');
                if(empty($get_comp)){ $data = "no setup yet"; } else{ if($data==1){ $dd= 'yes'; } else{ $dd='no'; } $data = $dd; }
              }
          else
              {
                $data = $d->$cc_field;
              }
    ?>
      <td>
        <?php 
            if($code_type=='S1' AND $cc_field=='IsUploadable')
            {
             if($data==1){ echo "yes"; } else{ echo "no"; }
            }

            else if($code_type=='S2' AND $cc_field=='IsDefault')
            {
             if($data==1){ echo "yes"; } else{ echo "no"; }
            }
            

            else if($code_type=='S3' AND $cc_field=='color_code')
            {
              echo "<input type='color' value='".$data."'>"." ".$data;
            }
            
            else if($code_type=='S4' AND $cc_field=='correct_ans')
            {
             if($data==1){ echo "yes"; } else{ echo "no"; }
            }
            
            else if($cc_field=='InActive')
            {
             if($data==1){ echo "InActive"; } else{ echo "Active"; }
            }
            else
            {
             
                echo $data; 
              
            }
        ?>
      </td>
    <?php } ?>
    </tr>
  <?php } ?>
  </tbody>
</table>
   