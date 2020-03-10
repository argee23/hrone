<ul class="nav nav-pills nav-stacked">
<?php
if($message == '1'){ foreach ($query as $row) {
$company= $row->company_id;
$loantype= $row->loan_type_id;
?>
 <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="empLoans(<?php echo $company.",".$loantype?>);"><i class='fa fa-<?php echo $system_defined_icons->icon_view;?>' ></i> <span><?php echo $row->loan_type?></span></a></li>
<?php } ?>
</ul>
<?php } else{ ?>
<h3 class="text-danger">No results found..</h3>
<?php }?>