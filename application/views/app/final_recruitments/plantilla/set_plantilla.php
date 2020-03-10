<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Plantilla | <?php echo $company_name;?></h4></ol>
<div class="col-md-12"><br>
        
    <div class="col-md-3"></div>
    <div class="col-md-6" id="action">

     <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/recruitment_plantilla/save_plantilla/<?php echo $company_id."/".$employer;?>" >
        <input type="text" class="form-control" placeholder="Plantilla Number" name="plantilla_no" required>
        <input type="text" class="form-control" style="margin-top: 5px;" placeholder="Plantilla Description" name="plantilla_desc"  required>
        <input type="date" class="form-control" style="margin-top: 5px;" name="plantilla_datefrom" required>
        <n class='text-danger'><i>&nbsp;&nbsp;Plantilla Date From</i></n>
        <input type="date" class="form-control" style="margin-top: 5px;" name="plantilla_dateto" required>
        <n class='text-danger'><i>&nbsp;&nbsp;Plantilla Date To</i></n>
        <button type="submit" class="col-md-12 btn btn-success btn-xs" style="margin-top: 5px;">SAVE</button>
      </form>

    </div>
    <div class="col-md-3"></div>

    <div class="col-md-12">
    <br>
      <div class="box box-danger" class='col-md-12'></div>
    </div>

    <div class="col-md-12">
        <table id="plantilla" class="table table-hover">
            <thead>
                <tr class="danger">
                  <th>ID</th>
                  <th>Plantilla Number</th>
                  <th>Details</th>
                  <th>Date From</th>
                  <th>Date To</th>
                  <th>Status</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($plantilla as $p) {?>
               
                <tr>
                  <td><?php echo $p->id;?></td>
                  <td>
                    <div id="no_orig_<?php echo $p->id;?>">
                      <?php echo $p->plantilla_no;?>
                    </div>
                    <div id="no_upd_<?php echo $p->id;?>"  style='display: none;'>
                      <input type="text" class="form-control" id="upd_no_<?php echo $p->id;?>" value="<?php echo $p->plantilla_no;?>">
                    </div>
                  </td>
                  <td>
                    <div id="desc_orig_<?php echo $p->id;?>">
                      <?php echo $p->plantilla_desc;?>
                    </div>
                    <div id="desc_upd_<?php echo $p->id;?>"  style='display: none;'>
                      <input type="text" class="form-control" id="upd_desc_<?php echo $p->id;?>" value="<?php echo $p->plantilla_desc;?>">
                      <input type='hidden' id='upd_desc_final_<?php echo $p->id;?>'>
                    </div>
                  </td>
                  <td>
                     <div id="from_orig_<?php echo $p->id;?>">
                      <?php echo $p->plantilla_from;?>
                    </div>
                    <div id="from_upd_<?php echo $p->id;?>"  style='display: none;'>
                      <input type="text" class="form-control" id="upd_from_<?php echo $p->id;?>" value="<?php echo $p->plantilla_from;?>">
                    </div>
                  </td>
                  <td>
                    <div id="to_orig_<?php echo $p->id;?>">
                      <?php echo $p->plantilla_to;?>
                    </div>
                    <div id="to_upd_<?php echo $p->id;?>"  style='display: none;'>
                      <input type="text" class="form-control" id="upd_to_<?php echo $p->id;?>" value="<?php echo $p->plantilla_to;?>">
                    </div>
                  </td>
                  <td>
                    <div id="orig<?php echo $p->id;?>">
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Plantilla' onclick="delete_plantilla('<?php echo $company_id;?>','<?php echo $employer;?>','<?php echo $p->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="cancel_updateplantilla('<?php echo $p->id;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Edit Plantilla'><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                    </div>
                    <div id="upd<?php echo $p->id;?>" style='display: none;'>
                        <a style='cursor:pointer;color:green;'  aria-hidden='true' data-toggle='tooltip' title='Click to Save Plantilla Update' onclick="saveupdate_plantilla('<?php echo $company_id;?>','<?php echo $employer;?>','<?php echo $p->id;?>');"><i  class="fa fa-check fa-lg  pull-left"></i></a>
                        <a style='cursor:pointer;color:red;'  aria-hidden='true' data-toggle='tooltip' title='Click to Cancel Plantilla Update' onclick="cancel_plantilla('<?php echo $p->id;?>')"><i  class="fa fa-times fa-lg  pull-left"></i></a>
                    </div>

                  </td>
                </tr>

              <?php } ?>
            </tbody>
        </table>
    </div>

</div>  
<div class="btn-group-vertical btn-block"> </div>   
      