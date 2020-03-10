<?php

$edit_yearly_tax_rates=$this->session->userdata('edit_yearly_tax_rates');
$del_yearly_tax_rates=$this->session->userdata('del_yearly_tax_rates');
$add_yearly_tax_rates=$this->session->userdata('add_yearly_tax_rates');

?>
<div id="editMe">

</div>


<table id="example1" class="table table">
<thead>
  <tr>
    <th colspan="6"><?php echo $compInfo->company_name;?>
      
     <a onclick="addTaxRates(<?php echo $company_id;?>)" class="<?php echo $add_yearly_tax_rates;?> btn btn-default btn-xs pull-right" type="button"  title="Add">
            <?php
          echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
          ?>  
     </a>


    </th>
  </tr>
  <tr>
    <th>(+ additional)</th>
    <th>Percentage</th>
    <th>Of Excess Over</th>
    <th>But Not Over</th>
    <th>Covered Year</th>
    <th>Action</th>
  </tr>
</thead>
<tbody>
<input type="text" id="company_id" value="<?php echo $company_id;?>" style="display: none;">
<?php

if(!empty($taxRates)){
  foreach($taxRates as $t){

        $edit = '<i class="'.$edit_yearly_tax_rates.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editTaxRates('.$t->id.')"></i>';

        $delete = anchor('app/payroll_file_maintenance/deleteTaxRates/'.$t->id,'<i class="'.$del_yearly_tax_rates.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete?')"));

        if($edit_yearly_tax_rates!=""){
                $edit = '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x text-mute"  data-toggle="tooltip" data-placement="left" title="Not Allowed Check Your User Rights" ></i>';
                $delete = '<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x text-mute"  data-toggle="tooltip" data-placement="left" title="Not Allowed Check Your User Rights" ></i>';
        }else{

        }

    echo '
    <tr>
      <td>'.$t->additional_rate.'</td>
      <td>'.$t->percentage.'</td>
      <td>'.$t->excess_over.'</td>
      <td>'.$t->not_over.'</td>
      <td>'.$t->annual_year.'</td>
      <td>'.$edit.$delete.'</td>
    </tr>
    ';
  }
}else{

}


?>
</tbody>
</table>


