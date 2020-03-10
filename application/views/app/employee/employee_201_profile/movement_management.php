
  <div class="col-md-8">
    <div class="box box-danger">
      <div class="panel panel-danger">
        <div class="panel-heading"><strong>Movement Type Management</strong></div>  
        <div class="col-md-12" style="margin-top: 20px;">
            <div class="col-md-2"><label>Movement Type:</label></div>
            <div class="col-md-7">
                  <input type="text" id="title_add" class="form-control">
                  <input type="hidden" id="title_add_final">
            </div>
            <div class="col-md-1"><button class="btn btn-success" onclick="movement_type_action('save','save','save')">SAVE</button></div>
           <br><br> <div class="box box-default" class='col-md-12'></div>
        </div>

          <div class="box-body">
            <div class="col-md-12">
            <br>
                <table class="table table-border" id="movement_type_">
                  <thead>
                    <tr class="success">  
                        <th>No.</th>
                        <th>Movement ID</th>
                        <th>Movement Type</th>
                        <th>Date Created</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $i=1; foreach ($movement_type as $mt) {?>
                      <tr>
                        <td><?php echo $i.".)";?></td>
                        <td><?php echo $mt->id;?></td>   
                        <td>
                            <div style="display: none;" id="u_title<?php echo $mt->id;?>">
                              <input type="text" style="width:100%;border:1px solid red;" class="form-control" id="updatetitle<?php echo $mt->id;?>" value="<?php echo $mt->title?>" >
                              <input type="hidden" id="updatetitle_final<?php echo $mt->id;?>">
                            </div>
                            <div id="o_title<?php echo $mt->id;?>"><?php echo $mt->title;?></div>
                        </td>
                        <td><?php echo $mt->date_created;?></td>
                        <td>

                        <div id="o<?php echo $mt->id;?>">
                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update details'  onclick="movement_type_action('edit','delete','<?php echo $mt->id;?>')" ><i  class="fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-left"></i></a> 

                           <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete movement type' onclick="movement_type_action('delete','delete','<?php echo $mt->id;?>')"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>

                        </div>

                        <div id="u<?php echo $mt->id;?>" style="display: none;">

                        <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="movement_type_action('save_update','save_update','<?php echo $mt->id;?>')"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>

                           <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update' onclick="movement_type_action('cancel_update','cancel_update','<?php echo $mt->id;?>')"><i  class="fa fa-times fa-lg  pull-left"></i></a>
                           
                        </div>

                        </td>
                      </tr>
                  <?php $i++;  } ?>
                  </tbody>
                </table>
                </div>
                <div class="col-md-12"><button class="btn btn-default pull-right" onclick="window.location.reload()">BACK</button></div>
        </div>  
      </div>
    </div>
  </div>
 