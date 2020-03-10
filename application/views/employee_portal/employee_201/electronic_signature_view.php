<div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><span class="pull-right"> 
            <?php if($setting=='allowed') { if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else{ } } else{?>
              <a href="#editable_topics">View editable topic</a>
            <?php } ?>
          </span>
          <h4 class="text-danger"><?php if($setting=='allowed') { ?> Employee Signature <?php } else{?> You're not allowed to edit,delete and add <b>Electronic Signature</b> <?php } ?></h4>
              </div>

    <div class="box-body">
    <div class="panel panel-success">
    <br>
           <center>
                <div class="box box-success">
                            <br>
                            <form enctype="multipart/form-data" method="post" action="update_signature" >


                             <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                    <div class="btn btn-info">
                                    <input type="file" name="file" id="file" required>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <div class="btn btn-info">
                                    <?php
                                       // echo  $signature_info_view->electronic_signature;
                                        $signature = $signature_info_view->electronic_signature;
                                    ?>
                                    <div class="col-md-6">
                                    <img  <?php if($signature == ""){ ?>
                                        src="<?php echo base_url()?>public/employee_files/electronic_signature/no_image.png" 
                                        <?php } else{ ?> 
                                        src="<?php echo base_url()?>public/employee_files/electronic_signature/<?php echo $signature;?>"
                                        <?php } ?>
                                        width="300px;" height="150px;"> 
                                        <br><n style="color: white;">Original Image</n>
                                    </div>
                                    <div class="col-md-6">
                                    <?php if(empty($signature_info_update) || $signature_info_update->electronic_signature==$signature){} else{?> 
                                        <img  <?php if(empty($signature_info_update)){ ?>
                                        src="<?php echo base_url()?>public/employee_files/electronic_signature/no_image.png" 
                                        <?php } else{ ?> 
                                        src="<?php echo base_url()?>public/employee_files/electronic_signature/<?php echo $signature_info_update->electronic_signature;?>"
                                        <?php } ?>
                                        width="300px;" height="150px;" style='padding-left: 5px;'>
                                        <br><n style="color: white;">Requested Image</n>
                                        <?php } ?>
                                    </div>
                                    </div>
                                  </div>

                                  <div class="col-md-11">
                                  <div class="btn-toolbar">
                                   <?php if($setting=='allowed') { if($pending > 0) {?> <br><?php } else{  ?> <button type="submit" title="Upload picture" class="btn btn-success btn pull-right"><i class="fa fa-check"></i></button><?php } } else{?>
                                    <?php } ?>

                                     
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


