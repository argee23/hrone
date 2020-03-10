<div class="row">
<div class="col-md-8">

<div class="box box-warning">
<div class="panel panel-warning">
  <div class="panel-heading"><strong>INVENTORY</strong> (add)</div>
  <div class="box-body">

    <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_201_profile/inventory_save/<?php echo $this->uri->segment("4");?>" >
            

            <div class="row">
            <div class="col-md-12">

            <div class="form-group">
            <label >Inventory name</label>
              <input type="text" name="inventory_name" class="form-control" placeholder="Inventory name" required>
              <p style="color:#ff0000;">Inventory name is required</p>
            </div>
            
            <label>Upload file</label>
            <div class="form-group">
            <div class="btn btn-info">
              <input type="file" name="file" id="file" required>
            </div>
            <p>Allowed file type jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc.</p>
            <p style="color:#ff0000;">Inventory file is required</p>
            </div>
            
            <div class="form-group">
              <label for="comment">Description(s)</label>
              <textarea name="comment" rows="5" cols="50" class="form-control" placeholder="Remark(s)" ></textarea>
            </div>
            </div>
            </div>

     <div class="form-group">
       <button type="submit" class="form-control btn btn-warning"><i class="fa fa-floppy-o"></i> SAVE </button>
      </div>
      </form>

     </div> 
     </div>

</div>
</div>

</div>  
</div>


