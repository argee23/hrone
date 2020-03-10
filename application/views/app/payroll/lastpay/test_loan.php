<?php
$l_count=0;
if(!empty($MyLoanBalance)){
    foreach($MyLoanBalance as $l){
    	$l_count++;
    	echo '

    	<input type="checkbox" id="loabBalCheckbox'.$l_count.'" onclick="computeLB'.$l_count.'();">
    	<div id="loanBal'.$l_count.'">
'.$l->loan_amt.'
    	</div>
    	<div style="background-color:#ccc;" id="totalLoan'.$l_count.'">
0.00
    	</div>
    	';
?>
<script type="text/javascript">
		function computeLB<?php echo $l_count;?>(){ 

        var loanBal = document.getElementById("loanBal<?php echo $l_count;?>").innerHTML;
        var loanBal = Number(loanBal);  
        var loanBalcheckBox = document.getElementById("loabBalCheckbox<?php echo $l_count;?>");

        if(loanBalcheckBox.checked == true){
            document.getElementById("totalLoan<?php echo $l_count;?>").innerHTML=loanBal;
        }else{
            document.getElementById("totalLoan<?php echo $l_count;?>").innerHTML="0.00";
        }

		ttl_loan();

    	}

</script>

<?php
    }

}else{

	
}


?>

<script type="text/javascript">
	function ttl_loan(){   
		var z_loan=0;  
<?php 
$ab=$l_count;
while($ab>0){?>
        var tl = document.getElementById("totalLoan<?php echo $ab;?>").innerHTML;
       	var tl =Number(tl);

        var loabBalCheckbox = document.getElementById("loabBalCheckbox<?php echo $ab;?>");
        if(loabBalCheckbox.checked == true){
        	var z_loan=z_loan+tl;
        	document.getElementById("LoanFinalOverAll").innerHTML=z_loan;
        }else{
        	document.getElementById("LoanFinalOverAll").innerHTML=z_loan;
        }
<?php 
$ab=$ab-1;
}
?>
document.getElementById("LoanFinalOverAll").innerHTML=z_loan;
	}
</script>

<br><br><br><br>
<div id="LoanFinalOverAll">
	0.00 
</div>