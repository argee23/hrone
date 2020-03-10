  <div class="col-md-12">
    <label class="col-md-12">Choose Message From Templates
    </label>

<?php
if(!empty($myMessTemp)){
	foreach($myMessTemp as $m){
		echo '
<input type="radio" name="compose_message" value="'.$m->id.'"> '.nl2br($m->message_template).'<br><br>
		';
	}
}else{

}

?>



  </div>