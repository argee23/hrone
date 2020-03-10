 <div class="modal-content">
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Add New Setting</center></h4>
      </div>
    <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/inventory_storage_settings/saveupdate_settings/<?php echo $company."/".$id;?>" >
    <?php foreach($details as $d){?>
    <div class="col-md-12">
       <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger"><i>All Fields are required</i></a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-11">
            <dt>Settings</dt>
            <dd>
              <select class="form-control" name="settings" id="settings" onchange="get_details(this.value);">
                  <option value="">Select</option>
                  <option value="default" <?php if($d->setting=='default'){ echo "selected"; }?>>Default</option>
                  <option value="hard_drive" <?php if($d->setting=='hard_drive'){ echo "selected"; }?>>Hard Drives</option>
                  <option value="dropbox" <?php if($d->setting=='dropbox'){ echo "selected"; }?> >Dropbox</option>
                  <option value="google_drives" <?php if($d->setting=='google_drives'){ echo "selected"; }?>>Google Drives</option>
              </select>
            </dd><br>
            <dt>Description</dt>
            <dd>
              <textarea class="form-control" rows="3" required name="description"><?php echo $d->description;?></textarea>
            </dd><br>
            <dt>Date Effective From</dt>
            <dd>
              <input type="date" class="form-control" name="datefrom" value="<?php echo $d->date_from;?>">
            </dd><br>
           <dt>Date Effective To</dt>
            <dd>
              <input type="date" class="form-control" name="dateto" value="<?php echo $d->date_to;?>">
            </dd><br>
          </span>
          

          <span class="dl-horizontal col-sm-11"  id="hard_drive">
            <dt>Directory</dt>
            <dd><input type="text" class="form-control" name="hard_drive" placeholder="example: F:/" value="<?php echo $d->if_hard_drives;?>"></dd><br>
            <dd><n class="text-danger"><i>Note: Directory field is for hard drive setting only. </i></n></dd>

           
          </span>
        
        </div>
        </div>    
    </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-default" onclick="location.reload();">Close</button>
      </div>
      </form>

    <?php } ?>
      </div>

    </div>


<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
  });
   function get_details(val)
   {
    if(val=='hard_drive')
    {
      $("#"+val).show();
    }
    else
    {
       $("#hard_drive").hide();
    }
   }
</script>