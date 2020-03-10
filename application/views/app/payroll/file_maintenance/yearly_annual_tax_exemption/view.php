<?php
$edit_yearly_tax_exemp=$this->session->userdata('edit_yearly_tax_exemp');
?>
<div id="editMe">

</div>


<table id="example1" class="table table">
<thead>
  <tr>
    <th colspan="5"><?php echo $compInfo->company_name;?></th>
  </tr>
  <tr>
    <th>Taxcode</th>
    <th>Total</th>
    <th>Description</th>
    <th>Covered Year</th>
    <th>Action</th>
  </tr>
</thead>
<tbody>
<input type="text" id="company_id" value="<?php echo $company_id;?>" style="display: none;">
<?php

if(!empty($taxcodeList)){
  foreach($taxcodeList as $t){
    $myExemp=$this->payroll_yearly_annual_tax_exemption_model->CheckExemption($t->taxcode_id,$company_id);
      if(!empty($myExemp)){
        $total=$myExemp->total;
        $covered_year=$myExemp->covered_year;
      }else{
        $total="<span class='text-danger'>0</span>";
        $covered_year="<span class='text-danger'>".date('Y')."</span>";
      }

        $edit = '<i class="'.$edit_yearly_tax_exemp.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editExemption('.$t->taxcode_id.')"></i>';

      if($edit_yearly_tax_exemp!=""){
              $edit = '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x text-mute"  data-toggle="tooltip" data-placement="left" title="Not Allowed Check Your User Rights" ></i>';
      }else{

      }

    echo '
     <tr>
    <td>'.$t->taxcode.'</td>
    <td>'.$total.'</td>
    <td>'.$t->description.'</td>
    <td>'.$covered_year.'</td>
    <td>'.$edit.'</td>
    </tr>
    ';
  }
}else{

}


?>
</tbody>
</table>


