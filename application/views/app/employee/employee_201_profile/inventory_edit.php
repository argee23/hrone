<div class="row">
<div class="col-md-8">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>INVENTORY</strong> (edit)</div>
  <div class="box-body">
      <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_201_profile/inventory_modify/<?php echo $this->uri->segment("4");?>" >


            <div class="row">
            <div class="col-md-12">

            <div class="form-group">
            <label >Inventory name</label>

             <input type="hidden" name="setting_id" value="<?php echo $inventory->setting_id;?>">
              <input type="text" name="inventory_name" class="form-control" plaecholder="Inventory name" value="<?php echo $inventory->inventory_name; ?>" required>
               <p style="color:#ff0000;">Inventory name is required</p>
            </div>

            <label><?php echo $inventory->file; ?></label>
            <div class="form-group">
            <div class="btn btn-info">
              <input type="file" name="file" id="file" value="<?php echo $inventory->file; ?>">
            </div>
            <p>Allowed file type jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc.</p>
            </div>
            
            <div class="form-group">
              <label for="comment">Description(s)</label>
              <textarea name="comment" rows="5" cols="50" class="form-control" placeholder="Remark(s)" ><?php echo $inventory->comment; ?></textarea>
            </div>

            </div>
            </div> 

     <div class="form-group">
     <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> Save Changes</button>
     </div>
     </form>

     </div> 
     </div>

</div>
</div>

</div>  
</div>


