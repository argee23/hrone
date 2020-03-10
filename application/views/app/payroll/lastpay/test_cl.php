
	

<?php
echo '
<div class="table-responsive">
<table class="table table">
<thead>
	<tr>
        <th>Convert?</th>
        <th>Leave Type</th>
        <th>Taxable Leave Beyond <a href="#" title="I am Configurable at Administrator>Leave Type"><i class="fa fa-info"></i>Help</a></th>
        <th>Remaining Leave <a href="#" title="I can be found at Administrator>Leave Management"><i class="fa fa-info"></i>Help</a></th>
        <th>Daily Rate</th>
        <th>Amount</th>
	</tr>
</thead>
<tbody>
';
$dailyrate=512;
if(!empty($MyRemLeave)){
	$i=0;
	foreach($MyRemLeave as $r){
		$i++;
		$c=$r->id;
		echo '
<tr>
<td><input type="checkbox" id="leaveTypeCheckbox'.$i.'" onclick="computeCL'.$i.'();"></td>
<td>'.$r->leave_type.'</td>
<td><input type="text" readonly id="leaveBeyondTax'.$i.'" value="2"></td>
<td><input type="text" id="leaveType'.$i.'" value="'.$r->available.'"></td>

<td><input type="text" readonly id="Rate'.$i.'" value="'.$dailyrate.'"></td>
<td>
total value<div style="background-color:#ccc;width:100px;" id="totalLeave'.$i.'" >0.00</div>
total non tax<div style="background-color:#AFD848;width:100px;" id="leavetotalNontax'.$i.'" >0.00</div>
total taxable<div style="background-color:#98F4ED;width:100px;" id="leavetotalTaxable'.$i.'" >0.00</div>
</td>

</tr>
	
		';
?>

<script type="text/javascript">

	function computeCL<?php echo $i;?>(){ 

        var leaveType = document.getElementById("leaveType<?php echo $i;?>").value;  
        var available = Number(leaveType);
        var Rate = document.getElementById("Rate<?php echo $i;?>").value;  
        var Rate = Number(Rate);

        var totalPerLeave = Number(available) * Number(Rate);

        var leaveBeyondTax = document.getElementById("leaveBeyondTax<?php echo $i;?>").value;
       	var leaveBeyondTax =Number(leaveBeyondTax);

       	if(available>leaveBeyondTax){
       		var nontax = leaveBeyondTax;
       		var taxable = Number(available) - Number(leaveBeyondTax);
       	}else{
       		var nontax = available;
       		var taxable = 0;
       	}

       	var finalNontax = Number(nontax) * Number(Rate);
       	var finalTaxable = Number(taxable) * Number(Rate);


        var checkBox = document.getElementById("leaveTypeCheckbox<?php echo $i;?>");
        

        if(checkBox.checked == true){
           // document.getElementById("final").innerHTML=available;
            document.getElementById("totalLeave<?php echo $i;?>").innerHTML=totalPerLeave;
            document.getElementById("leavetotalNontax<?php echo $i;?>").innerHTML=finalNontax;
            document.getElementById("leavetotalTaxable<?php echo $i;?>").innerHTML=finalTaxable;
        }else{
           // document.getElementById("final").innerHTML="0.00";
            document.getElementById("totalLeave<?php echo $i;?>").innerHTML="0.00";
            document.getElementById("leavetotalNontax<?php echo $i;?>").innerHTML="0.00";
            document.getElementById("leavetotalTaxable<?php echo $i;?>").innerHTML="0.00";
        }

		ttlc_lv();

	}

</script>
<?php
	}
}else{

}
?>

<script type="text/javascript">
	function ttlc_lv(){   
		var z=0;  
		var leavetotalNontax=0;
		var leavetotalTaxable=0;
<?php 
$a=$i;
while($a>0){?>
        var oa = document.getElementById("totalLeave<?php echo $a;?>").innerHTML;
       	var oa =Number(oa);

        var n = document.getElementById("leavetotalNontax<?php echo $a;?>").innerHTML;
       	var n =Number(n);

        var t = document.getElementById("leavetotalTaxable<?php echo $a;?>").innerHTML;
       	var t =Number(t);

        var checkBox = document.getElementById("leaveTypeCheckbox<?php echo $a;?>");
        if(checkBox.checked == true){
        	var z=z+oa;
        	var leavetotalNontax=leavetotalNontax+n;
        	var leavetotalTaxable=leavetotalTaxable+t;
        	document.getElementById("leaveFinal_over_all").innerHTML=z;
        	document.getElementById("leaveFinal_taxable").innerHTML=leavetotalTaxable;
        	document.getElementById("leaveFinal_nontaxable").innerHTML=leavetotalNontax;
        }else{
        	document.getElementById("leaveFinal_over_all").innerHTML=z;
        	document.getElementById("leaveFinal_taxable").innerHTML=leavetotalTaxable;
        	document.getElementById("leaveFinal_nontaxable").innerHTML=leavetotalNontax;
        }
<?php 
$a=$a-1;
}
?>
document.getElementById("leaveFinal_over_all").innerHTML=z;
	}
</script>

<?php
echo '
<tr>
<td>over all
<div id="leaveFinal_over_all">
	0.00 
</div></td>

<td>taxable
<div id="leaveFinal_taxable">
	0.00 
</div></td>

<td>nontaxable
<div id="leaveFinal_nontaxable">
	0.00 
</div></td>

</tr>
</tbody>
</table>
</div>



';

?>
