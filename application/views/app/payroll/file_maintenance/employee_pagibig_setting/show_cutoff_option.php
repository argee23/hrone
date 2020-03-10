<?php
$selected_pay_type=$this->uri->segment('4');
echo '  <select class="form-control" name="cutoff" id="cutoff" required>';

if($selected_pay_type==1){
echo 
'<option value="1">1st cutoff</option>
<option value="2">2nd cutoff</option>
<option value="3">3rd cutoff</option>
<option value="4">4th cutoff</option>
<option value="5">5th cutoff</option>
<option value="per_payday">Every payday</option>';

}elseif($selected_pay_type==2 OR $selected_pay_type==3){
echo 
'<option value="1">1st cutoff</option>
<option value="2">2nd cutoff</option>
<option value="per_payday">Every payday</option>';
}elseif($selected_pay_type==4){
echo 
'<option value="1">1st cutoff</option>
<option value="per_payday">Every payday</option>';
}
echo '</select>';
?>