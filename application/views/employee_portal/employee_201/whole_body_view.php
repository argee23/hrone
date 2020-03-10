<div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><span class="pull-right"> 
            <?php if($setting=='allowed') { if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else{ } } else{?>
              <a href="#editable_topics">View editable topic</a>
            <?php } ?>
          </span>
          <h4 class="text-danger"><?php if($setting=='allowed') { ?> Employee Whole Body Picture <?php } else{?> You're not allowed to edit,delete and add <b>Employee Whole Body Picture</b> <?php } ?></h4>
              </div>

    <div class="box-body">
    <div class="panel panel-success">
    <br>
           <center>
                <div class="box box-success">
                            <br>
                            <form enctype="multipart/form-data" method="post" action="update_whole_body" >


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
                                        $whole_body = $whole_body_view->whole_body_pic;
                                    ?>
                                    <div class="col-md-6">
                                    <img  <?php if($whole_body == ""){ ?>
                                        src="<?php echo base_url()?>public/employee_files/whole_body_picture/no_image.png" 
                                        <?php } else{ ?> 
                                        src="<?php echo base_url()?>public/employee_files/whole_body_picture/<?php echo $whole_body;?>"
                                        <?php } ?>
                                        width="300px;"> 
                                        <br><n style="color: white;">Original Image</n>
                                    </div>
                                    <div class="col-md-6">
                                    <?php if(empty($whole_body_update) || $whole_body_update->whole_body_pic==$whole_body){} else{?> 
                                        <img  <?php if(empty($whole_body_update)){ ?>
                                        src="<?php echo base_url()?>public/employee_files/whole_body_picture/no_image.png" 
                                        <?php } else{ ?> 
                                        src="<?php echo base_url()?>public/employee_files/whole_body_picture/<?php echo $whole_body_update->whole_body_pic;?>"
                                        <?php } ?>
                                        width="300px;" style='padding-left: 5px;'>
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


