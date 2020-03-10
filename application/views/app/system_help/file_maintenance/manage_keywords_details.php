<div class="col-md-12" style="margin-top: 10px;">

  <?php if($this->session->flashdata('success_inserted') AND $action_=='add')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Keyword is Successfully Added.</center></n></div>';
            } 
        else if($this->session->flashdata('success_deleted') AND $action_=='delete')
        {
            echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Keyword ID - '.$flash_id.' is Successfully Deleted.</center></n></div>';
        }
        else if($this->session->flashdata('success_updated') AND $action_=='update')
        {
            echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Keyword ID - '.$flash_id.' is Successfully Updated.</center></n></div>';
        }
  else{}?>

</div>
 <table id="resultss" class="table table-hover">
            <thead>
                <tr class="danger">
                    <th>ID</th>
                    <th>Keyword</th>
                    <th>Date Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach($keywords as $k){?>
                <tr>
                    <td><?php echo $k->id;?></td>
                    <td>

                        <div id="keyword_orig<?php echo $k->id;?>"><?php echo $k->keyword;?></div>
                        <div id="keyword_upd<?php echo $k->id;?>" style="display: none;">
                            <input type="text" class="form-control" name="keywordd" id="keywordd<?php echo $k->id;?>" value="<?php echo $k->keyword;?>">
                            <input type="hidden" id="keywordd_final<?php echo $k->id;?>">
                        </div>
                    </td>
                    <td><?php echo $k->date_added;?></td>
                    <td>
                        <div id="kaction_orig<?php echo $k->id;?>">
                          <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Question <?php echo $k->keyword;?>' onclick="delete_keywords('<?php echo $portal;?>','<?php echo $module;?>','<?php echo $k->id;?>','<?php echo $id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                          <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update Question <?php echo $k->keyword;?>' onclick="edit_keywords('<?php echo $k->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                        </div>

                        <div id="kaction_upd<?php echo $k->id;?>" style="display: none;">
                            <a aria-hidden='true' data-toggle='tooltip' title='Click to Save Update <?php echo $k->keyword;?>' onclick="save_keyword_update('<?php echo $k->id;?>','<?php echo $portal;?>','<?php echo $module;?>','<?php echo $id;?>');"><i class="fa fa-check fa-lg  pull-left text-success"></i></a>
                           <a aria-hidden='true' data-toggle='tooltip' title='Click to Cancel Update <?php echo $k->keyword;?>' onclick="cancel_keyword_update('<?php echo $k->id;?>');"><i class="fa fa-times fa-lg  pull-left text-danger"></i></a>
                      
                        </div>
                    </td>
                </tr>
              <?php } ?>
            </tbody>
        </table>  