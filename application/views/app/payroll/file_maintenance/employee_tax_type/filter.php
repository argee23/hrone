
<input type="hidden" id="company_id" value="<?php echo $company_id;?>">
<?php
$base_table=1;
$base_ann=2;
 echo "<a onclick='taxtypeFilter2(".$base_table.")' type='button' class='btn btn-success col-md-12 btn-flat'><p class='text-left'>
 <strong>View Base on Tax Table Employees</strong> </p></a>";

 echo "<a onclick='taxtypeFilter2(".$base_ann.")' type='button' class='btn btn-warning col-md-12 btn-flat'><p class='text-left'>
 <strong>View Annualize Tax Employees</strong> </p></a>";


?>