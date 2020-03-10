<?php include('header.php');?>
        
        <div id="col_2">
               <div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>Residence Map</strong></div>

    <div class="box-body">


            <div class="tab-pane" id="residence">
  <div class="panel panel-success"> 
    

    <div class="panel-body">
           <?php if($checker_inactive==0){?>
            <div class='col-md-6'>
            <br><br><br>
              <center> <h4>Update Residence Map</h4>
              <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_201_profile/residence_info_modify/<?php echo $this->uri->segment("4");?>" >
                <div class="form-group">
                  <label>Choose your new residence map: </label>
                    <div class="input-group">
                      <input type="file" name="file" id="file" required>
                      <div class="input-group-btn">
                      
                      </div>
                    </div>
                    <span>Maximum Allowed Size: 500KB</span><br><br>
<?php
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
?>


                      <button type="submit" class="btn btn-success btn-sm" style="margin-left:20px;">Upload</button>
<?php
}
?>


                  </div>
                </form>
            </div>
              <hr>
            
            <?php } ?>
             <div <?php if($checker_inactive==0){ echo'class="col-sm-6"'; } else { echo'class="col-sm-12"'; } ?>>
              <?php if($checker_inactive!=0){ echo "<center>";}?>
                 <img style="width: 250px;height:250px; " class="img img-responsive p"  src="<?php echo base_url(); ?>public/employee_files/residence/<?php echo $residence; ?>">
                   <div class="pull-right">
                   <a style='margin-right: 24px;' type="button" class="btn btn-success btn-xs" href="<?php echo base_url(); ?>app/employee_201_profile/download_residence/<?php echo $residence; ?>"><i class="fa fa-download"></i> Download</a>
                   </div>
              <?php if($checker_inactive!=0){ echo "</center>"; }?>
             </div>


    </div>
  </div>
  </div>
<!-- End Residence Information -->

     </div>
    </div><!-- /.box-body -->
</div>
</div>
             
        </div>  
</div>

<script>
  

</script>

        </div>

        </div>
 <?php include('footer.php');?>


