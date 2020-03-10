    
    <div id="noti"></div>
    <?php  $form_location   = base_url()."app/pms/save_general_instruction/";?>
<form id="form4" action="<?php echo $form_location; ?>" method="post" >

   <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>General Instruction</h4></ol>
      <div class="col-md-110 well">
          <input type="hidden" name="c" value="<?php echo $w ?>">
        <h3 class="page-header text-center"><?php if(!empty($general_instruction->company_name)){  echo $general_instruction->company_name;} ?><br /></h3><br>
          
          <?php $s =  $this->uri->segment('4'); ?>
     
        <textarea  name="instruction" required  id="instruction_area" data-c="<?php echo $s ;?>" rows="13"  data-type="wysihtml5" data-pk="<?php if(!empty($general_instruction->company_name)){ echo $general_instruction->id ;}?>" data-name="instruction"   data-url="<?php echo base_url();?>app/pms/general_instruction_update" ><?php if(!empty($general_instruction->company_name)){ echo $general_instruction->instruction; }?></textarea>
      
        <hr>  
        
        <div class="text-center">
          <?php if(!empty($general_instruction->instruction)){ ?>
          <a class="btn btn-success" id="update" ><i class="glyphicon glyphicon-eye-open"></i> Update </a>
        <?php }else{ ?>
          
          <a class="btn btn-success" id="save" onclick="save()" ><i class="glyphicon glyphicon-eye-open"></i> Add instruction </a>
          <?php } ?>
        </div>
      </div> 
   
    <div class="btn-group-vertical btn-block"> </div>  


</form>
</div>
<script type="text/javascript">
  function save(){

        $.ajax({
            url: "<?php echo base_url();?>app/pms/save_general_instruction/",
            data: $('#form4').serialize(),
            type: 'POST',
            success: function(data){
                  $('#message').show();
            $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  <strong>Company instruction</strong>, is Successfully Added!</div>").fadeOut(25000);             
            
                window.scrollTo({ top: 0, behavior: 'smooth' });
              general_instruction();
        
  
            }
        });
      
  }
</script>    