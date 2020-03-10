<?php include('header.php');?>
        
        <div id="col_2">
                
                <div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>EMPLOYEE ELECTRONIC </strong></div>

    <div class="box-body">
    <div class="panel panel-success">
    <br>
           <center>
                <div class="box box-success">
                            <br>

                            <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_201_profile/electronic_signature_save/<?php echo $this->uri->segment("4");?>" >


                             <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                    <?php if($checker_inactive==0){?>
                                    <div class="btn btn-info">
                                     <input type="file" name="file" id="file" required>
                                    </div>
                                     <?php } ?>
                                  </div>

                             <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                    <div class="btn btn-info">
                                    <?php
                                       // echo  $signature_info_view->electronic_signature;
                                        $signature = $signature_info_view->electronic_signature;
                                    ?>
                                    <img  <?php if($signature == ""){ ?>

                                        src="<?php echo base_url()?>public/employee_files/electronic_signature/no_image.png" 
                                        <?php } else{ ?> 
                                        src="<?php echo base_url()?>public/employee_files/electronic_signature/<?php echo $signature;?>"
                                        <?php } ?>
                                        width="300px;" height="150px;">
                                    </div>
                                  </div>

                                  <div class="col-md-12">
                                  <div class="btn-toolbar">
                                     <?php if($checker_inactive==0){
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

  ?> <button type="submit" title="Upload picture" class="btn btn-success btn pull-right"><i class="fa fa-check"></i></button><?php } }?>
                                  </div>
                                  </div>
                              </div>
                              </div>

                            </form>
                </div>
            </center>
     <br>
     </div>
    </div><!-- /.box-body -->
</div>
</div>

</div>  
</div>




        </div>  
</div>

<script>
  

</script>

        </div>

        </div>
 <?php include('footer.php');?>


