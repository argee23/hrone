<table class="table">
  <tbody>
    <tr>
    <div class="btn-group-vertical btn-block">
    <br>
    <?php 
        $company_id = $this->uri->segment('4');
         $company_id;
    ?>

    <?php
    if($company_id != 0){ 

if($tran_udf_add=="hidden "){
  echo '<i  style="color:#ccc;" class="pull-right fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" title="Not Allowed.Check Access Rights"></i>';
}else{
      ?>
    <a onclick="addNewUDFCol_new(<?php echo $company_id; ?>)" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="Add"><?php echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
}
          ?></a>

    <?php }?>
    <?php $check=0; ?>
    <?php foreach($udfLists as $udfList) : if($udfList->IsActive == 1){ $inactive = 'Active';}else{ $inactive = 'InActive';} ?>
      <tr <?php if($udfList->IsActive == 0){echo 'style="color:#999;""';}else{echo 'class="text-success"';} ?>>
         <?php if($udfList->IsActive == 1){ ?>
        <td>
          <?php echo "<a data-toggle='tooltip' data-placement='right' class='btn btn-flat btn-link'><p class='text-left'><strong>".$udfList->form_name."</strong></p></a>"; ?>
        </td>
        <td>

<?php
if($tran_udf_mng_form_fields=="hidden "){
  echo '<i style="color:#ccc;" class="pull-right fa fa-'.$system_defined_icons->icon_manage.' fa-'.$system_defined_icons->icon_size.'x" title="Not Allowed.Check Access Rights"></i>';
}else{
?>
          <a type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="Manage Fields" onclick='viewUDFCol(<?php echo $udfList->id; ?>)'><?php echo '<i class="fa fa-'.$system_defined_icons->icon_manage.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_manage_color.';" "></i>&nbsp;';?></a>
<?php
}


if($tran_udf_del=="hidden "){
  echo '<i style="color:#ccc;" class="pull-right fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" title="Not Allowed.Check Access Rights"></i>';
}else{

?>

          <a class="pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/transaction_user_define_fields/del_udf_col_new/'. $udfList->id.''); ?>" onClick="return confirm('Are you sure you want to delete?')"><?php echo '<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';" "></i>';?></a>

<?php
}

if($tran_udf_edit=="hidden "){
  echo '<i  style="color:#ccc;" class="pull-right fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" title="Not Allowed.Check Access Rights"></i>';
}else{
?>
          <a type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="Edit" onclick='editUDFCol1(<?php echo $udfList->id; ?>)'><?php echo '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" "></i>&nbsp;';?></a>

<?php
}

if($tran_udf_enable_disable=="hidden "){
  echo '<i  style="color:#ccc;" class="pull-right fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" title="Not Allowed.Check Access Rights"></i>';
}else{
?>
           <a class="pull-right" data-toggle="tooltip" data-placement="right" title="Disable" href="<?php echo base_url()?>app/transaction_user_define_fields/deactivate_trans_form/<?php echo $udfList->id;?>"><?php echo '<i class="fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';" "></i>';?></a>
<?php
}

?>


          

        </td>

           <?php }else{ ?>

            <td>

               <?php echo "<a  data-toggle='tooltip' data-placement='right' title='view fields' class='btn btn-flat btn-link'><p class='text-left' disabled><strong>".$udfList->form_name."</strong></p></a>"; ?>
        </td>
        <td>


          <a class="pull-right" data-toggle="tooltip" data-placement="right" title="Click Enable to Delete" disabled><?php echo '<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" text-muted"></i>';?></a>

          <a type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="Click Enable to Edit" disabled><?php echo '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" text-muted"></i>&nbsp;';?></a> 

<?php
if($tran_udf_enable_disable=="hidden "){
  echo '<i  style="color:#ccc;" class="pull-right fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" title="Not Allowed.Check Access Rights"></i>';
}else{
?>
          <a class="pull-right" data-toggle="tooltip" data-placement="right" title="Enable" href="<?php echo base_url()?>app/transaction_user_define_fields/activate_trans_form/<?php echo $udfList->id;?>"><?php echo '<i class="fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';" "></i>';?></a>
<?php
}
?>


         <!--  <?php 
              if($udnList->form_type == 'Selectbox'){
                 echo "<i class='fa fa-list fa-lg text-primary pull-right' data-toggle='tooltip' data-placement='left' title=' View option' onclick='viewUDFOPT($udnList->id)'>aaaa</i>";  
              }
           ?> -->
          
        </td>

          <?php } ?>
      </tr>
    <?php 
    $check++;
    endforeach; ?>
        <?php if($check==0){?>
        <tr>
          <td>
          <p class='text-left'><strong>No result(s) found.</strong></p>
          </td>
        </tr>
        <?php } ?>
    </tr>




    
  </tbody>
</table>