 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Question: <?php echo $question;?></center></h4>
      </div>
     
      <div class="modal-body">
        <span class="dl-horizontal col-sm-12">
                  <div class="col-md-2">
                     <label class="pull-right">Choices</label>
                  </div>
                  <div class="col-md-8">
                    <input style="width:100%;" type="text" id="choicess" class="form-control" placeholder="Add New Choices">
                    <input type="hidden" id="choicess_">
                  </div>
                  <button class="col-md-2 btn btn-success btn-sm" onclick="multiplechoices_manage('<?php echo $company_id;?>','save','<?php echo $id;?>','save');">SAVE</button>

                  <br><br><br>
                  <div class="box box-default" class='col-md-12'></div>
                  <div class="col-md-12" style="margin-top: 30px;" id="choices_list">
                    <table id="multiplechoices" class="table table-bordered table-striped">
                      <thead>
                        <tr class="danger">
                          <th>No.</th>
                          <th>Choices</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $i=1;
                            foreach($choices as $row){?>
                              <tr>
                                <td><?php echo $i;?></td>
                                <td>
                                    <div id="o_choices<?php echo $row->mc_id;?>"><?php echo $row->mc_choice;?></div>
                                    <div id="u_choices<?php echo $row->mc_id;?>" style='display: none;'>
                                      <input type="text" class="form-control" id="uuchoices<?php echo $row->mc_id;?>" value="<?php echo $row->mc_choice;?>" style='width:100%;'>
                                      <input type="hidden" id="uuchoices_<?php echo $row->mc_id;?>">
                                    </div>
                                </td>
                                <td><?php if($row->mc_InActive==1) { echo "InActive"; } else{ echo "Active"; }?></td>
                                <td>
                                  <div id="o_qchoices<?php echo $row->mc_id;?>">
                                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Edit Question'  onclick="multiplechoices_manage('<?php echo $company_id;?>','update','<?php echo $id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Question' onclick="multiplechoices_manage('<?php echo $company_id;?>','delete','<?php echo $id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                               
                                      <?php 
                                        if($row->mc_InActive==1){?> 
                                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable Question'  onclick="multiplechoices_manage('<?php echo $company_id;?>','enable','<?php echo $id;?>','<?php echo $row->mc_id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                                        <?php } else { ?>
                                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Question'  onclick="multiplechoices_manage('<?php echo $company_id;?>','disable','<?php echo $id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                                                  <?php } ?>
                                            </div>

                                            <div id="u_qchoices<?php echo $row->mc_id;?>" style='display: none;'>
                                              <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="multiplechoices_manage('<?php echo $company_id;?>','save_update','<?php echo $id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>

                                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update'  onclick="multiplechoices_manage('<?php echo $company_id;?>','cancel','<?php echo $id;?>','<?php echo $row->mc_id;?>');"><i  class="fa fa-times fa-lg  pull-left"></i></a>
                                          
                                            </div>
                                        </td>
                                      </tr>
                                    <?php $i++;  }?>
                                    </tbody>
                          </table>
                  </div>
        </span>

          <div class="modal-footer" >
            <div class="col-md-12"> 
               <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 20px;">Close</button>
            </div>
          </div>
      </div>


</div>

<script>

  $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
  });

  $(function () {
        $('#multiplechoices').DataTable({
          "pageLength": -1,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
  });
  });
  
function multiplechoices_manage(company,action,question_id,id)
{
  if(action=='save')
  {

    var question = document.getElementById('choicess').value;
    function_escape('choicess_',question);
    var question_ = document.getElementById('choicess_').value;
    save_multiplechoices_manage(company,action,question_id,id,question_,'multiple_choice');

    
  }
  else if(action=='delete' || action=='enable' || action=='disable')
  {
      var result = confirm("Are you sure you want to disable id-" + id);
      if(result == true)
      {
        var question_=action;

        save_multiplechoices_manage(company,action,question_id,id,question_,'multiple_choice');
      } else {}  
  }
  else if(action=='update')
  {
    $("#u_choices"+id).show();

    $("#o_choices"+id).hide();
    

    $("#o_qchoices"+id).hide();
    $("#u_qchoices"+id).show();

  }
  else if(action=='cancel')
  {
    $("#u_choices"+id).hide();
    $("#o_choices"+id).show();
    

    $("#o_qchoices"+id).show();
    $("#u_qchoices"+id).hide();
  }
  else if(action=='save_update')
  {
      var question = document.getElementById('uuchoices'+id).value;

      function_escape('uuchoices_'+id,question);
      var question_ = document.getElementById('uuchoices_'+id).value;

      save_multiplechoices_manage(company,action,question_id,id,question_,'multiple_choice');
  }
  else
  {
     save_multiplechoices_manage(company,action,question_id,id,'view','multiple_choice');
  }
}

function save_multiplechoices_manage(company,action,question_id,id,choices,question_type)
{

     if (window.XMLHttpRequest)
        {
          xmlhttp=new XMLHttpRequest();
        }
      else
        {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
          xmlhttp.onreadystatechange=function()
            {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("choices_list").innerHTML=xmlhttp.responseText;
                 $("#multiplechoices").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/recruitment_hris/save_manage_questions_choices/"+company+"/"+action+"/"+question_id+"/"+id+"/"+choices+"/"+question_type,true);
            xmlhttp.send();
}

</script>
