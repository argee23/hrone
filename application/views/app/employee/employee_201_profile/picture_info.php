<div class="box box-success">
<br>
<form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_201_profile/picture_save/<?php echo $this->uri->segment("4");?>" >


  <div class="row">
  <div class="col-md-12">
	  <div class="form-group">
	    <div class="btn btn-info">
	    <input type="file" name="file" id="file" required>
	    </div>
	     <span><small>Maximum Allowed Size: 2MB</small></span><br>
	  </div>
	  <div class="col-md-12">
	  <div class="btn-toolbar">

<?php
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

?>

	  	  <button type="submit" title="Upload picture" class="btn btn-success btn pull-right"><i class="fa fa-check"></i></button>
<?php
}
?>


	  </div>
	  </div>
  </div>
  </div>

</form>
