<div class="col-md-12">	
      		<button class="btn btn-success btn-xs pull-right" style="margin-bottom: 10px;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitment_hris/setting_plantilla_add')."/".$company_id;?>"><i class="fa fa-plus"></i> ADD PLANTILLA </button>
      		<table class="table table-hover" id="settings">
      			<thead> 
      				<tr class="danger">
      					<th>No</th>
      					<th>Plantilla</th>
      					<th>Details</th>
      					<th>Date Range From</th>
      					<th>Date Range To</th>
      					<th>Action</th>
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
                      <input type='hidden' id='upd_no_final_<?php echo $p->id;?>'>
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
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Plantilla' onclick="delete_plantilla('<?php echo $company_id;?>','<?php echo $p->id;?>','<?php echo $code;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="cancel_updateplantilla('<?php echo $p->id;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Edit Plantilla'><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                    </div>
                    <div id="upd<?php echo $p->id;?>" style='display: none;'>
                        <a style='cursor:pointer;color:green;'  aria-hidden='true' data-toggle='tooltip' title='Click to Save Plantilla Update' onclick="saveupdate_plantilla('<?php echo $company_id;?>','<?php echo $p->id;?>','<?php echo $code;?>');"><i  class="fa fa-check fa-lg  pull-left"></i></a>
                        <a style='cursor:pointer;color:red;'  aria-hidden='true' data-toggle='tooltip' title='Click to Cancel Plantilla Update' onclick="cancel_plantilla('<?php echo $p->id;?>')"><i  class="fa fa-times fa-lg  pull-left"></i></a>
                    </div>

                  </td>
                </tr>

              <?php } ?>
      			</tbody>
      		</table>
      	</div>