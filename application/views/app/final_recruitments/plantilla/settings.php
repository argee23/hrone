<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Company Recruitment Settings</h4></ol>
<div class="col-md-12"><br>
      
      <div class="col-md-12">
          <div class="col-md-3"></div>
          <div class="col-md-6">
              <select class="form-control">
                  <option value="" disabled selected>Select Recruitment Settings</option>
                  <?php foreach ($settings as $s) {?>
                      <option value="<?php echo $s->id;?>"><?php echo $s->title;?></option>
                  <?php } ?>
              </select>
          </div>
          <div class="col-md-3"></div>
      </div> 


      <div class="col-md-12">

      </div>



</div>  
<div class="btn-group-vertical btn-block"> </div>   
     