
<!-- Automatic element centering -->
<div style="background:#d2d6de;">

  <!-- User name -->
  <div class="lockscreen-name">John Doe</div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
     <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png"  alt="avatar"  >
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
     <?php $form_location   = base_url()."app/pms/save_lock_un/";?>
<form class="lockscreen-credentials" id="creator_options" method="post" action="<?php echo $form_location;?>">
      <div class="input-group">


   
		
  
          <button  type="button" class="btn" onclick='unlck(<?php echo $this->uri->segment('4');  ?>);'><i class="fa fa-arrow-right text-muted"></i></button>
         lock <input type="radio" name="qwe" value="1">
			unlock<input type="radio" name="qwe" value="0">

   
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Enter your password to retrieve your session
  </div>


		
	




<script type="text/javascript">
	 function unlck(id){
	 	          $.ajax({
              url: "<?php echo base_url();?>app/pms/save_lock_un/"+id+"",
              type: 'POST',
              data: $('#creator_options').serialize(),
              success: function(e) {
                
               $('#message').show();
               $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
         

               
               
               
             }
           });
	 }
</script>