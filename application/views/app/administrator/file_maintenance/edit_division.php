  <div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_division/<?php echo $this->uri->segment("4");?>">
    <div class="box-body">
      <div class="form-group">
        <label control-label"> Company : <?php echo $company_name->company_name ?> </label>
        <input type="hidden" name="company_name" value="<?php echo $company_name->company_name ?>">
        <input type="hidden" name="company_id"  value="<?php echo $company_name->company_id ?>">
      </div>
<!--       <div class="form-group">
        <label control-label">Location : </label>
        <select class="form-control select2" name="location" id="location" style="width: 100%;" required="required" >
            <?php 
                foreach($locationList as $location){
                
            ?>
          <option value="<?php echo $location->location_id; ?>" <?php if($division->location_id == $location->location_id){ echo ' selected="selected"'; } ?> ><?php echo $location->location_name;?></option>
            <?php }?>
        </select>        
      </div> -->
      <div class="form-group">
        <label for="division" control-label"> Division Name:  </label> 
          <input type="text" class="form-control" name="division" id="division" placeholder="Division Name" value="<?php echo $division->division_name;?>">
      </div>
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>