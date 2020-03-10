<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_oa_type=$this->session->userdata('add_oa_type');
$edit_oa_type=$this->session->userdata('edit_oa_type');
$delete_oa_type=$this->session->userdata('delete_oa_type');
$enable_disable_oa_type=$this->session->userdata('enable_disable_oa_type');

/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/


?>
<div class="col-md-12" id="printProfile" >

<div class="row table-responsive">
<div class="col-md-12">

<div class="box box-success ">
<div class="panel panel-success" >
  <div class="panel-heading table-responsive " >
        <strong>
        <?php 
           $company_id =$this->uri->segment('4');
           $current_comp=$this->payroll_file_maintenance_additions_model->get_company($company_id);
           if(!empty($current_comp)){
              echo $company_name = $current_comp->company_name;
           }else{
              echo $company_name="company not exist";
           }
        
         ?>
      </strong><strong>(OTHER ADDITIONS)</strong>

      <a onclick="add_new_addition_list(<?php echo $company_id;?>)" type="button" class="<?php echo $add_oa_type;?> btn btn-xs btn-default pull-right" data-toggle="tooltip" data-placement="left" title="Add New Other Addition">        <?php
        echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
        ?>
           
      </a>
      </strong>
      
    
       </div>

<div id="add_edit_table"></div>


  <div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">



      
     <div class="col-md-12" >
     <div class="table-responsive">
      
   <table id="example1" class="table table-striped table-striped table-bordered table-condensed">
        <thead>
            <tr>
                    <th style="text-align:center;">ID</th>
                    <th style="text-align:center;">CODE</th>
                    <th style="text-align:center;">TYPE</th>
                    <th style="text-align:center;">RATE</th>
                    <th style="text-align:center;">AMOUNT</th>
                    <th style="text-align:center;">TAXABLE</th>
                    <th style="text-align:center;">ALPHA LIST NON-TAX(de minimis)</th>
                    <th style="text-align:center;">BONUS</th>
                    <th style="text-align:center;">13th MONTH PAY</th>
                    <th style="text-align:center;">BASIC</th>
                    <th style="text-align:center;">OT</th>
                    <th style="text-align:center;">LEAVE</th>
                    <th style="text-align:center;">EXCLUDE TO ALPHALIST</th>
                    <th style="text-align:center;">CATEGORY</th>
                  <!--   <th style="text-align:center;">DATETIME ADDED/UPDATED</th> -->
                    <th style="text-align:center;">STATUS</th>
                    <th style="text-align:center;">ACTION</th>
            </tr>
        </thead>
        <tbody border="1">
          <?php foreach($addition_list as $addlist){if($addlist->InActive_type == 0){ $inactive = 'Enabled';}else{ $inactive = 'Disabled';}?>

                  <tr <?php if($addlist->InActive_type == 1){echo 'style="color:#999;""';}else{echo 'class="text-success"';} ?>>
                    <input type="hidden" value="<?php echo $addlist->company_id;  ?>">
                   <td align="center" ><?php echo $addlist->id;  ?></td>
                   <td align="center" ><?php echo $addlist->other_addition_code;  ?></td>
                   <td align="center" ><?php echo $addlist->other_addition_type;  ?></td>
                   <td align="center" ><?php echo $addlist->rate;  ?></td>
                   <td align="center" ><?php echo $addlist->amount;  ?></td>
                  
                              <?php 
                                  $taxable = FALSE;
                                  $non_tax = FALSE;
                                  $bonus = FALSE;
                                  $th_month_pay = FALSE;
                                  $basic = FALSE;
                                  $ot = FALSE;
                                  $other_addition_leave = FALSE;
                                  $exclude = FALSE;
                                 
                                                   if ($addlist->taxable == 1) {
                                                        $taxable = TRUE;
                                                    } else {
                                                        $taxable = FALSE;
                                                    }
                                                   if ($addlist->non_tax == 1) {
                                                        $non_tax = TRUE;
                                                    } else {
                                                        $non_tax = FALSE;
                                                    }
                                                   if ($addlist->bonus == 1) {
                                                        $bonus = TRUE;
                                                    } else {
                                                        $bonus = FALSE;
                                                    }
                                                   if ($addlist->th_month_pay == 1) {
                                                        $th_month_pay = TRUE;
                                                    } else {
                                                        $th_month_pay = FALSE;
                                                    }     
                                                   if ($addlist->basic == 1) {
                                                        $basic = TRUE;
                                                    } else {
                                                        $basic = FALSE;
                                                    }     
                                                   if ($addlist->ot == 1) {
                                                        $ot = TRUE;
                                                    } else {
                                                        $ot = FALSE;
                                                    }     
                                                   if ($addlist->other_addition_leave == 1) {
                                                        $other_addition_leave = TRUE;
                                                    } else {
                                                        $other_addition_leave = FALSE;
                                                    }     
                                                   if ($addlist->exclude == 1) {
                                                        $exclude = TRUE;
                                                    } else {
                                                        $exclude = FALSE;
                                                    }     

                              ?>


                   <td align="center"> <input type="checkbox" id="checkbox" <?php echo ($taxable==TRUE)? 'checked':'';?> disabled/></td>
                   <td align="center"><input type="checkbox" id="checkbox" <?php echo ($non_tax==TRUE)? 'checked':'';?> disabled/></td>
                   <td align="center"><input type="checkbox" id="checkbox" <?php echo ($bonus==TRUE)? 'checked':'';?> disabled/></td>
                   <td align="center"><input type="checkbox" id="checkbox" <?php echo ($th_month_pay==TRUE)? 'checked':'';?> disabled/></td>
                   <td align="center"><input type="checkbox" id="checkbox" <?php echo ($basic==TRUE)? 'checked':'';?> disabled/></td>
                   <td align="center"><input type="checkbox" id="checkbox" <?php echo ($ot==TRUE)? 'checked':'';?> disabled/></td>
                   <td align="center" ><input type="checkbox" id="checkbox" <?php echo ($other_addition_leave==TRUE)? 'checked':'';?> disabled/></td>
                   <td align="center" ><input type="checkbox" id="checkbox" <?php echo ($exclude==TRUE)? 'checked':'';?> disabled/></td>
                       <?php 
                        $addcategory = $addlist->category;
                        $myCateg=$this->payroll_file_maintenance_additions_model->get_oa_category($addcategory);
                        if(!empty($myCateg)){
                          echo "<td align='center'>".$myCateg->category."</td>";
                        }else{

                        }
  
                      ?>
    
                    <td align="center"><?php echo $inactive?></td>
                    <td style="padding-right: 30px;" align="center">

                    <?php if($addlist->InActive_type == 0){

echo $edit="<i class='".$edit_oa_type." fa fa-".$system_defined_icons->icon_edit." fa-".$system_defined_icons->icon_size."x'  
                style='color:".$system_defined_icons->icon_edit_color.";' data-toggle='tooltip' data-placement='left' title='Edit' onclick='addition_list_table_edit(".$addlist->id.")'></i>" ;
                    ?>

<a  class='<?php echo $enable_disable_oa_type;?> fa fa-<?php echo $system_defined_icons->icon_disable.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_disable_color.';"';?> data-toggle="tooltip" data-placement="left" title="Click to Deactivate/Disable" href="<?php echo site_url('app/payroll_file_maintenance_additions/deactivate_other_addition_list/'. $addlist->id); ?>" onClick="return confirm('Are you sure you want to Disable?')"></a>

<a  class='<?php echo $delete_oa_type;?> fa fa-<?php echo $system_defined_icons->icon_delete.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_delete_color.';"';?> data-toggle="tooltip" data-placement="left" title="Delete" href="<?php echo site_url('app/payroll_file_maintenance_additions/delete_list/'. $addlist->id.''); ?>" onClick="return confirm('Are you sure you want to permanently delete?')"></a>



                    <?php 

                    }else{


echo "<i class='".$edit_oa_type." fa fa-".$system_defined_icons->icon_edit." fa-".$system_defined_icons->icon_size."x'  
                style='color:#ccc' data-toggle='tooltip' data-placement='left' title='Cannot Edit. Enable First' ></i>" ;

                      ?>
                            
<a  class='<?php echo $enable_disable_oa_type;?> fa fa-<?php echo $system_defined_icons->icon_enable.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_enable_color.';"';?> data-toggle="tooltip" data-placement="left" title="Click to Activate/Enable" href="<?php echo site_url('app/payroll_file_maintenance_additions/activate_other_addition_list/'. $addlist->id); ?>" onClick="return confirm('Are you sure you want to Enable?')"></a>

                    <?php 
echo "<i class='".$delete_oa_type." fa fa-".$system_defined_icons->icon_delete." fa-".$system_defined_icons->icon_size."x'  
                style='color:#ccc' data-toggle='tooltip' data-placement='left' title='Cannot Delete. Enable First' ></i>" ;


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
</div>

</div>
</div>

</div>
</div>
<div class="col-md-4"  id="col_3">  

</div>

