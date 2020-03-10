 <div class="modal-content">
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Manage Keywords for Question <br><b>"<?php if(!empty($question_details->question)){ echo $question_details->question; }?>"</b></center></h4>
      </div>
           
      <div class="col-md-12">

        <div class="panel panel-default">
        <div class="panel-heading">
        <strong>
            <h5><b>Question</b> : <n class="text-danger"><i> <?php if(!empty($question_details->question)){ echo $question_details->question; }?></i></n></h5>
            <h5><b>Answer </b>: <n class="text-danger"> <i> <?php if(!empty($question_details->answer)){ echo $question_details->answer; }?></i></n></h5>
        </strong>
        </div>
        <div class="panel-body">
          <div class="col-md-12">
            
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Keyword">
                        <input type="hidden" name="keyword_final" id="keyword_final">
                    </div>
                    <div class="col-md-12" style="margin-top: 10px;">
                        <button class="form-control btn btn-success btn-sm" onclick="save_keyword('<?php echo $id;?>','<?php echo $portal;?>','<?php echo $module;?>');">SAVE KEYWORD</button>
                    </div>
                </div>
                <div class="col-md-3"></div>
           
          </div>

          <div class="col-md-12" id="keyword_list">
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
        </div>  
      </div>
      </div>
      </div>


      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="function_reload_keyword('<?php echo $portal;?>','<?php echo $module;?>');">Close</button>
      </div>
      </div>
    </div>


<script>

  $(function () {
        $('#resultss').DataTable({
          "pageLength": 6,
           lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]] ,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

</script>