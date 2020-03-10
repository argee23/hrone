<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_classification/<?php echo $this->uri->segment("4");?>">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-10"> <?php echo $company_name->company_name ?> </label>
        <input type="hidden" name="company_id" value="<?php echo $classification->company_id ?>">
      </div>
      <div class="form-group">
        <label for="classification" class="col-sm-2 control-label">Classification</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="classification" id="classification" placeholder="Classification" value="<?php echo $classification->classification;?>" required>
        </div>
      </div>
      <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="<?php echo $classification->description;?>">
        </div>
      </div>
      <div class="form-group">
        <label for="classification" class="col-sm-2 control-label">Ranking</label>
        <div class="col-sm-10">

        <select class="form-control" name="ranking" required>
          <option value="<?php echo $classification->ranking?>"><?php echo $classification->ranking?></option>
          <?php
          for ($x = 1; $x <= 20; $x++){
            echo '<option value="'.$x.'">'.$x.'</option>';
           // echo "The number is: $x <br>";
          } 
          ?>
        </select>

<!--           <input type="text" class="form-control" name="ranking" id="classification" placeholder="Classification" value="<?php //echo $classification->classification;?>" required> -->


        </div>
      </div>

          <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>