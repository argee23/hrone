<?php
    $company_id             = $this->uri->segment("4");
   
?>

<div class="col-md-12">
<div id="add_edit"></div>

<input type="button" class="btn btn-success" value="Click Me to Checked All Checkboxes" onclick="checked_all_loc_gov(<?php echo $company_id;?>)">

<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
</tr>
  <tr>
    <th style="text-align:center;">Location ID</th>
    <th style="text-align:center;">Location</th>
      <th style="text-align:center;">Gov Id</th>
    <th style="text-align:center;">WithHolding Tax</th>
    <th style="text-align:center;">Pag-Ibig</th>
    <th style="text-align:center;">SSS</th>
    <th style="text-align:center;">Philhealth


    </th>
  </tr>
</thead>
<tbody>
<?php foreach($company_location as $com_location){ ?>
  <tr>
    <td align="center"><?php echo $com_location->location_id; ?></td>
    <td align="center"> <?php echo $com_location->location_name; ?></td>
 

   
  <?php 
         $location_id = $com_location->location_id;
         

                                    $gov_id = NULL;
                                    $wtax = NULL;
                                    $pagibig = NULL;
                                    $sss = NULL;
                                    $ph = NULL;
                                   

                          foreach($gov_default_value as $gov_value)
                          {
                              $gov_company =  $gov_value->company_id;
                              $gov_location =  $gov_value->location_id;
                       
                   

                     if($company_id == $gov_value->company_id && $location_id == $gov_value->location_id){

                            
                                  $gov_id      =  $gov_value->gov_id;
                                  $wtax        =  $gov_value->withholding_tax;
                                  $pagibig     =  $gov_value->pagibig;
                                  $sss         =  $gov_value->sss;
                                  $ph          =  $gov_value->philhealth;
                 
                    }  

                           if(empty($gov_value)){
                                   $gov_id = "";
                                    $wtax = "";
                                    $pagibig = "";
                                    $sss = "";
                                    $ph = "";
                                   
                                   
                                }else{
                                    $gov_id = $gov_id;
                                    $wtax    = $wtax;
                                    $pagibig = $pagibig;
                                    $sss     = $sss;
                                    $ph      = $ph;
                                
                                   
                                }
  }
                            
                            if($wtax == 1){

                              $wtax = "checked";
                             }else{
                              $wtax = "";
                             }
                             
                             if($pagibig == 1){

                              $pagibig = "checked";
                             }else{
                              $pagibig = "";
                             }
                             
                             if($sss == 1){

                              $sss = "checked";
                             }else{
                              $sss = "";
                             }
                             
                             if($ph == 1){

                              $ph = "checked";
                             }else{
                              $ph = "";
                             }

            
            
?>
                          <td align='center'><input type='hidden'  value='<?php echo $gov_id; ?>' disabled/></td>
                          <td align='center'><input type="checkbox"  <?php echo $wtax; ?> disabled/></td>
                          <td align='center'><input type="checkbox"  <?php echo $pagibig; ?> disabled/></td>
                          <td align='center'><input type="checkbox"  <?php echo $sss; ?> disabled/></td>
                          <td align='center'><input type="checkbox"  <?php echo $ph; ?> disabled/></td>




    <td>  
      <?php
          $location_id = $com_location->location_id;

                      $already_exist   = $this->payroll_compensation_model->check_gov_def_value($company_id,$location_id);
                  
                        echo $already_exist;

                          if($already_exist == 1){
                            ?>
                                 <a><i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="Click to Edit <?php //echo $lpb->pay_code?>'" onclick="gov_default_edit('<?php echo $gov_id; ?>')"></i></a>
                               <!--    $to_edit_enabled= $this->session->userdata('check_leave_type_edit_enabled_icon');  
                                 echo $edit = '<i '.$to_edit_enabled.' class="hidden" data-toggle="tooltip" data-placement="left" title="Click to Edit" onclick="gov_default_edit('.$gov_id.')"></i>'; 
                                -->
                               
                                <br>
                                 <?php }else{ ?>

                                 <a><i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="Click to Add <?php //echo $lpb->pay_code?>'" onclick="gov_default_add('<?php echo $company_id; ?>','<?php echo $com_location->location_id; ?>')"></i></a>

                               <?php } ?>
    </td>
  </tr>
<?php }?>
</tbody>
</table>
</div>


