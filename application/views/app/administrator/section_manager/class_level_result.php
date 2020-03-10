<div class="col-md-2">
          <select class="form-control" id='class_result'> 
              <option selected disabled value=''>Select Classification</option>
              <?php foreach($classificationList as $row) { ?>
                <option value="<?php echo $row->classification_id?>"><?php echo $row->classification?></option>
              <?php } ?>
          </select>
</div>