
<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_city/">
    <div class="box-body">

      <div class="form-group">
        <label for="position" class="col-sm-2 control-label">Province</label>
        <div class="col-sm-10">
          <select class="form-control" name="province" id="province" required>
              <option>Select Province</option>
              <?php foreach($province as $p){?>
                  <option value="<?php echo $p->id;?>"><?php echo $p->name;?></option>
              <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="position" class="col-sm-2 control-label">City</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="city" id="city" placeholder="City"  required>
        </div>
      </div>
     
      <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-pencil"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>