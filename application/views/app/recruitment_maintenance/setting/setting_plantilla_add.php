 <div class="modal-content">
     
    <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center><b>Add New Plantilla</b> <br>(<?php echo $company_name;?>)</center></h4>
    </div>
    
    <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment_hris/save_plantilla/<?php echo $company_id;?>">
       
      <div class="modal-body">
         <div class="panel panel-default">
            <div class="panel-heading">
              <strong><a class="text-danger">Plantilla Details <i>(All fields are )</i></a></strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-12">

                    <div class="col-md-12" id="action">
                        <input type="text" class="form-control" placeholder="Plantilla Number" name="plantilla_no" required>
                        <input type="text" class="form-control" style="margin-top: 5px;" placeholder="Plantilla Description" name="plantilla_desc"  required>
                        <input type="date" class="form-control" style="margin-top: 5px;" name="plantilla_datefrom" id="plantilla_datefrom" required onchange="check_dates_plantilla();">
                        <n class='text-danger'><i>&nbsp;&nbsp;Plantilla Date From</i></n>
                        <input type="date" class="form-control" style="margin-top: 5px;" name="plantilla_dateto" id="plantilla_dateto" required onchange="check_dates_plantilla();">
                        <n class='text-danger'><i>&nbsp;&nbsp;Plantilla Date To</i></n>
                    </div>
                    <input type='hidden' name='datechecker' id='datechecker' value="<?php echo $lastplantilla;?>">
              </span>
            </div>
          </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="submit">Submit</button>
            <button type="button" class="btn btn-default" onclick="window.location.reload()">Close</button>
        </div>

      </div>

    </form>

     
</div>

