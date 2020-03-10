<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
	  <?php $form_location   = base_url()."app/pms/update_/";?>
<form id="form-search" method="post" action="<?php echo $form_location;?>">
    <span><span class="style2">Enter you email here</span>:</span>
    <select name="email">

    	<?php $s = $this->pms_model->get_employee(); foreach($s as $e){?>
    	<option value="<?php  echo $e->fullname; ?>"><?php echo $e->fullname ?></option>
			<?php } ?>
    </select>
 

 <input type="submit" value="subscribe" class="submit" id="save" />
 <table ><thead><th>qwes</th><th>qwes</th></thead><tbody  ></tbody></table>
 <p id="listing"></p>
</form>
</body>
</html>
<script type="text/javascript">
	  $(document).on('click','#filter',function(ew) {
ew.preventDefault();
  var data = $("#form-search").serialize();
  $.ajax({
         data: data,
         type: "post",
         url: "<?php echo base_url().'app/pms/e/'?>",
         success: function(e){
              $('#listing').append(e);
         }
});
 });
</script>