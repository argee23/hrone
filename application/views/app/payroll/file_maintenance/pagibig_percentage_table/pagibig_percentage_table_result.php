    <div class="col-md-12" >
      <div class="table-responsive">
        <div id="add_edit_exem"></div>
          <div id="search_here">

  <table id="example1" class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                    <th style="text-align:center;" rowspan="2">MONTHLY COMPENSATION</th>
                    <th style="text-align:center;" colspan="2">PERCENTAGE OF MONTH COMPENSATION</th>
                    <th style="text-align:center;" rowspan="2">STATUS</th>
                    <th style="text-align:center;" rowspan="2">YEAR</th>
                    <th style="text-align:center;" rowspan="2">OPTION</th>
                  
            </tr>
            <tr align="center" class="neg_two">
            <td  style="text-align:center;">Employee Share </td>
            <td  style="text-align:center;">Employer Share </td>
          </tr>
        </thead>
        <tbody border="1">
          <?php foreach($pagibiglist_result as $pi_per_list){if($pi_per_list->InActive == 0){ $inactive = 'Enabled';}else{ $inactive = 'Disabled';}?>

                  <tr <?php if($pi_per_list->InActive == 1){echo 'style="color:#999;""';}else{echo 'class="text-success"';} ?>>
                    <input type="hidden" name="company_id" id="company_id" value="<?php echo $pi_per_list->company_id;  ?>">
                    <input type="hidden" name="pi_percentage_id" id="pi_percentage_id" value="<?php echo $pi_per_list->pi_percentage_id;  ?>">
                     <input type="hidden" name="covered_year" id="covered_year" value="<?php echo $pi_per_list->covered_year;  ?>">
                   
                   <td align="center" ><?php echo $pi_per_list->amount_from; ?> to <?php echo $pi_per_list->amount_to; ?></td>
                   <td align="center" ><?php echo $pi_per_list->employee_share;  ?>%</td>
                   <td align="center" ><?php echo $pi_per_list->employer_share;  ?>%</td>
                  
                        
                
                    <td align="center"><?php echo $inactive?></td>
                    <td align="center"><?php echo $pi_per_list->covered_year?></td>
                    <td style="padding-right: 30px;" align="center">

                    <?php if($pi_per_list->InActive == 0){ ?>
                                
                         
                          <a href="<?php echo base_url()?>app/payroll_pagibig_percentage_table/delete_list/<?php echo $pi_per_list->pi_percentage_id;?>/<?php echo $pi_per_list->company_id;?>"><i class="fa fa-remove fa-lg text-success pull-right"  data-toggle="tooltip" data-placement="left" title="Click to Delete <?php echo $pi_per_list->pi_percentage_id;?>'" onclick="return confirm('Are you sure you want to delete <?php echo $pi_per_list->company_id.' : '.$pi_per_list->pi_percentage_id?> Pagibig Percentage?')"></i></a>


                          <a href="<?php echo base_url()?>app/payroll_pagibig_percentage_table/deactivate_pagibig_list/<?php echo $pi_per_list->pi_percentage_id;?>"><i <?php echo $this->session->userdata('check_leave_type_todisable_icon'); ?> class="hidden"  data-toggle="tooltip" data-placement="left" title="Click to Disable <?php echo $pi_per_list->pi_percentage_id;?>'" onclick="return confirm('Are you sure you want to disable <?php echo $pi_per_list->pi_percentage_id;?> Pagibig Percentage?')"></i></a>

                          <a><i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="Click to Edit <?php echo $pi_per_list->pi_percentage_id?>'" onclick="pagibig_percentage_edit('<?php echo $pi_per_list->company_id; ?>','<?php echo $pi_per_list->pi_percentage_id; ?>','<?php echo $pi_per_list->amount_from; ?>','<?php echo $pi_per_list->amount_to; ?>','<?php echo $pi_per_list->employee_share; ?>','<?php echo $pi_per_list->employer_share; ?>','<?php echo $pi_per_list->covered_year; ?>')"></i></a>
                    <?php 



                    }else{?>

                      

                        <i class="fa fa-remove fa-lg text-muted pull-right"  data-toggle="tooltip" data-placement="left" title="cannot delete : enable first "></i>
                   
                        <a href="<?php echo base_url()?>app/payroll_pagibig_percentage_table/activate_pagibig_list/<?php echo $pi_per_list->pi_percentage_id;?>"><i <?php echo $this->session->userdata('check_leave_type_toenable_icon'); ?> class="hidden" data-toggle="tooltip" data-placement="left" title="Click to Enable <?php echo $pi_per_list->pi_percentage_id;?>'" onclick="return confirm('Are you sure you want to enable <?php echo $pi_per_list->pi_percentage_id;?> Pagibig Percentage?')"></i></a>
               
                        <i class="fa fa-pencil-square-o fa-lg text-muted pull-right"  data-toggle="tooltip" data-placement="left" title="Click to Edit <?php echo $pi_per_list->pi_percentage_id?>"></i>
                    <?php 

                    }?>
                    </td>
                  </tr>
                  <?php }?>
          
              </tbody>
            </table>
            </div>
      </div>
      </div>

  
     </div> 
  </div><!-- /.box-body -->