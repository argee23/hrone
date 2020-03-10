  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/sms/send_message/" target="_blank">

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-danger">
		  <!-- Default panel contents -->
		  <div class="panel-heading"><strong>Create Message</strong></div>
	
	<div class="panel panel-body">

      <div class="form-group">
        <div class="col-md-12">
          <label class="col-md-12">Choose Company</label>
<?php
if(!empty($companyList)){
	//<option value="" selected disabled>Select Company</option>
	echo '
<select class="form-control" name="company_id" id="company_id">

	';
	foreach($companyList as $c){
echo '

<option value="'.$c->company_id.'" >'.$c->company_name.'</option>

';
	}

echo '</select>';
}else{

}
 
?>
        </div>
       </div>

  <div class="form-group">
    <div class="col-md-12">
      <label class="col-md-12">Contacts Type</label>
      <select class="form-control" name="contact_type" onchange="showcontactchoices(this.value)">
      	<option  value="" selected disabled>Select</option>
      	<option value="masterlist">Select From Masterlist</option>
      	<option value="group">Select From Masterlist Grouped Contact</option>
      	<option value="applicants">Select From Applicants</option>
      </select>
    </div>
   </div>
<div class="form-group" id="show_contact">

</div>


    <div class="form-group" id="GetMessageTemplate">
      <div class="col-md-12">
        <label class="col-md-12">Compose
        <input type="checkbox" id="message_template" onclick="GetMessageTemplate()"> Look From Messages Templates?
        </label>
        <textarea class="form-control" rows="5" name="compose_message"></textarea>
      </div>
    </div>





          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Send</button>
         <!--  <button type="submit" class="btn btn-danger pull-right" ><i class="fa fa-pencil"></i> Draft</button> -->



	</div>
		</div>
</div>




</form>