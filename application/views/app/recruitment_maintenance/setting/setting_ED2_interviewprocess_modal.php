 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>INTERVIEW PROCESS OF <?php echo strtoupper($company_name);?></center></h4>
      </div>
     
      <div class="modal-body">

          <div class="col-md-10">
              
              <div class="col-md-12">
                <div class="col-md-4"><n class="pull-right"><strong>Interview Process</strong></n></n></div>
                <div class="col-md-7">
                  <input type="text" class="form-control" name="title" id="processtitle">
                  <input type="hidden" id="processtitle_final">
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><n class="pull-right"><strong>Process Description</strong></n></div>
                <div class="col-md-7">
                  <input type="text" class="form-control" name="description" id="processdescription">
                  <input type="hidden" id="processdescription_final">
                </div>
              </div>

               <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-4"><n class="pull-right"><strong>Color Code</strong></n></div>
                <div class="col-md-7">
                  <input type="color" class="form-control" name="processcolor" id="processcolor">
                  <input type="hidden" id="processcolor_final">
                </div>
              </div>

              <div class="col-md-12" style="margin-top: 20px;">
                <div class="col-md-4"></div>
                <div class="col-md-7"><button class="col-md-12 btn btn-success" onclick="ED2_save_interview_process('<?php echo $company_id;?>');">SAVE</button></div>
              </div>

          </div>

        <br><br><br><br><br><br><br><br><br>
        <div class="box box-default" class='col-md-12'></div>

        <div class="col-md-12" style="margin-top: 20px;" id="action_interview_process">
          <table class="col-md-12 table table-hover" id="inproc">
              <thead>
                <tr class="danger">
                  <th>ID</th>
                  <th>Numbering</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Color Code</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=1; foreach($details as $d){
                  $ddd=$d->interview_id;
                  ?>
                  <tr>
                    <td><?php echo $d->interview_id;?></div>   
                    </td>
                    <td>
                      <div id="ip_viewing<?php echo $i;?>"> 
                        <?php echo $d->numbering;?>
                        <input type="hidden" id="ipid<?php echo $i;?>" value="<?php echo $d->interview_id;?>">
                      </div>
                      <div id="ip_update<?php echo $i;?>" style="display: none;">
                        <select class="form-control ip_value" id="numberingvaluee<?php echo $i;?>"> 
                          <?php $co_o = count($details);  
                             
                              for ($x = 1; $x <= $co_o; $x++) {?>
                              <option <?php if($d->numbering==$x){ echo "selected"; }?>><?php echo $x;?></option>";
                              <?php }?>
                              </select>
                      </div>

                    </td>
                    <td>
                        <div id="title_orig<?php echo $ddd;?>"> <?php echo $d->title;?></div>
                        <div id="title_upd<?php echo $ddd;?>" style="display: none;"><input type="text" class="form-control" id="titleupdate<?php echo $ddd;?>" value="<?php echo $d->title;?>"></div> 
                        <input type='hidden' id='t<?php echo $ddd;?>'>
                    </td>
                    <td>
                        <div id="desc_orig<?php echo $ddd;?>"><?php echo $d->description;?></div>
                        <div id="desc_upd<?php echo $ddd;?>" style="display: none;"><input type="text" class="form-control" id="descupdate<?php echo $ddd;?>" value="<?php echo $d->description;?>"></div> 
                        <input type='hidden' id='d<?php echo $ddd;?>'>  
                    </td>
                    <td>
                        <div id="color_orig<?php echo $ddd;?>"><input type="color" value="<?php echo $d->color_code;?>" disabled></div>
                        <div id="color_upd<?php echo $ddd;?>" style="display: none;"> <input type="color" value="<?php echo $d->color_code;?>" id="colorupdate<?php echo $ddd;?>"></div>
                        <input type='hidden' id='c<?php echo $ddd;?>'>
                    </td>
                    <td>
                      <?php if($d->InActive==1)
                      {?>

                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable interview process' onclick="interview_process_action('<?php echo $company_id;?>','<?php echo $d->interview_id;?>','enable');">
                        <i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                           
                      <?php } 
                      else
                      { ?>

                      <div id="update<?php echo $d->interview_id;?>" style="display: none;">
                            <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="interview_process_updatesave('<?php echo $company_id;?>','<?php echo $d->interview_id;?>');"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>
                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update' onclick="interview_process_update_form_cancel('<?php echo $d->interview_id;?>');" ><i  class="fa fa-times fa-lg  pull-left"></i></a>
                      </div>
                      <div id="original<?php echo $d->interview_id;?>">
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to update interview process' onclick="interview_process_update_form('<?php echo $d->interview_id;?>');">
                        <i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                        

                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hid<?php echo $d->interview_id;?>den='true' data-toggle='tooltip' title='Click to delete interview process' onclick="interview_process_action('<?php echo $company_id;?>','<?php echo $d->interview_id;?>','delete');">
                        <i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                        
                         <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable interview process' onclick="interview_process_action('<?php echo $company_id;?>','<?php echo $d->interview_id;?>','disable';">
                        <i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                      </div> 

                      <?php }
                      ?>
                    </td>
                  </tr>
                <?php $i++; } echo "<input type='text' id='ip_count' value='".$i."'' style='display:none;'>";  ?>

              </tbody>
          </table>
        </div>
          
          <input type="hidden" id="checking_ipempty" value="0">
          <div class="modal-footer" >
            <div class="col-md-12" id="main_btn">
               <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" style="margin-top: 20px;">Close</button>
               <button type="button" class="btn btn-success btn-sm" style="margin-top: 20px;margin-left: 10px;" onclick="update_numbering_inproc('<?php echo count($details);?>');">Update Numbering</button>
            </div>

            <div class="col-md-12 pull-right" id="num_btn" style="display: none;">
              <button type="button" class="btn btn-success btn-sm" style="margin-top: 20px;margin-left: 10px;"  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick='saveupdate_numbering_inproc("<?php echo $company_id;?>");'>Save Changes</button>
              <button type="button" class="btn btn-danger btn-sm" style="margin-top: 20px;margin-left: 10px;" onclick='update_numbering_inproc_cancel();' aria-hidden='true' data-toggle='tooltip' title='Click to cancel numbering update'>Cancel</button>
           
            </div>
          </div>

      </div>


</div>

<script>

  $(function () {
        $('#inproc').DataTable({
          "pageLength": 6,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
  });

  $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
  });

  function ED2_save_interview_process(company)
  { 
      var title = document.getElementById('processtitle').value;
      var description = document.getElementById('processdescription').value;
      var color = document.getElementById('processcolor').value;

      function_escape('processtitle_final',title);
      function_escape('processdescription_final',description);
      function_escape('processcolor_final',color);

      var ftitle = document.getElementById('processtitle_final').value;
      var fdescription = document.getElementById('processdescription_final').value;
      var fcolor = document.getElementById('processcolor_final').value;

      if(ftitle=='' || fdescription=='' || fcolor=='')
      {
        alert("Please fill up all fields to continue");
      }
      else
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
                    document.getElementById("action_interview_process").innerHTML=xmlhttp.responseText;
                     $("#inproc").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                    setTimeout(function() {
                        $('#flashdata_result').fadeOut('fast');
                        }, 3000);

                    document.getElementById('processtitle').value="";
                    document.getElementById('processdescription').value="";
                    document.getElementById('processcolor').value="";

                  }
                }
      xmlhttp.open("GET","<?php echo base_url();?>app/recruitment_hris/ED2_save_interview_process/"+ftitle+"/"+fdescription+"/"+fcolor+"/"+company,true);
      xmlhttp.send();

    }

  }

  function interview_process_action(company_id,id,action)
  {
    var result = confirm("Are you sure you want to "+action + " interview process id - "+id);
      if(result == true)
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
                    document.getElementById("action_interview_process").innerHTML=xmlhttp.responseText;
                     $("#inproc").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                    setTimeout(function() {
                        $('#flashdata_result').fadeOut('fast');
                        }, 3000);
                  }
                }
      xmlhttp.open("GET","<?php echo base_url();?>app/recruitment_hris/ED2_interview_process_action/"+company_id+"/"+id+"/"+action,true);
      xmlhttp.send();
    }
  }

  function interview_process_update_form(id)
  {
    $('#update'+id).show();
    $('#original'+id).hide();

    $('#title_orig'+id).hide();
    $('#desc_orig'+id).hide();
    $('#color_orig'+id).hide();

    $('#title_upd'+id).show();
    $('#desc_upd'+id).show();
    $('#color_upd'+id).show();
  }

  function interview_process_update_form_cancel(id)
  {
    $('#update'+id).hide();
    $('#original'+id).show();

    $('#title_orig'+id).show();
    $('#desc_orig'+id).show();
    $('#color_orig'+id).show();

    $('#title_upd'+id).hide();
    $('#desc_upd'+id).hide();
    $('#color_upd'+id).hide();
  }

  function interview_process_updatesave(company,id)
  { 
  
      var title = document.getElementById('titleupdate'+id).value;
      var desc = document.getElementById('descupdate'+id).value;
      var color = document.getElementById('colorupdate'+id).value;

      function_escape('t'+id,title);
      function_escape('d'+id,desc);
      function_escape('c'+id,color);

      var ft = document.getElementById('t'+id).value;
      var fd = document.getElementById('d'+id).value;
      var fc = document.getElementById('c'+id).value;

      if(ft=='' || fd=='' || fc=='')
      {
        alert("Please fill up all fields to continue");
      }
      else
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
                    document.getElementById("action_interview_process").innerHTML=xmlhttp.responseText;
                     $("#inproc").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                    setTimeout(function() {
                        $('#flashdata_result').fadeOut('fast');
                        }, 3000);
                  }
                }
      xmlhttp.open("GET","<?php echo base_url();?>app/recruitment_hris/interview_process_updatesave/"+company+"/"+id+"/"+ft+"/"+fd+"/"+fc,true);
      xmlhttp.send();
      
     }
  }


  function update_numbering_inproc(countt)
  { 
    var count = document.getElementById('ip_count').value;
    var cinput =   document.getElementsByClassName('ip_value');
    for (i=1;i < count; i++)
        {
          $('#ip_update'+i).show();
          $('#ip_viewing'+i).hide();
         
        } 

        $('#main_btn').hide();
        $('#num_btn').show();
  }

  function update_numbering_inproc_cancel()
  {
    $('#main_btn').show();
    $('#num_btn').hide();


    var count = document.getElementById('ip_count').value;
    var cinput =   document.getElementsByClassName('ip_value');
  
    for (i=1;i < count; i++)
        {
          $('#ip_update'+i).hide();
          $('#ip_viewing'+i).show();
         
        } 
  }

  function saveupdate_numbering_inproc(company_id)
  {
    
    var result = confirm("Are you sure you want to update the interview process numbering of company id " + company_id + "?.");
       if(result == true)
       {
          var count = document.getElementById('ip_count').value;
          var cinput =   document.getElementsByClassName('ip_value');

          var value_numbering='';
          var value_id='';
          for (i=1;i < count; i++)
                {
                  document.getElementById("numberingvaluee"+i).style.borderColor = "white";
                  document.getElementById('checking_ipempty').value=0;
                }
                            
          for (i=1;i < count; i++)
                {
                    var val = document.getElementById('numberingvaluee'+i).value;
                    value_numbering += val + "-";

                    var id = document.getElementById('ipid'+i).value;
                    value_id += id + "-";

                      for (ii=1;ii < count; ii++)
                      {
                        if(ii==i){}
                        else
                        {
                          var a = document.getElementById('numberingvaluee'+ii).value;
                          if(a==val)
                          {
                            document.getElementById("numberingvaluee"+i).style.borderColor = "red";
                            document.getElementById("numberingvaluee"+ii).style.borderColor = "red";
                            document.getElementById('checking_ipempty').value=1;
                          }
                          else
                          {}
                        }
                      }
                }

          var checker = document.getElementById('checking_ipempty').value;
          if(checker==1)
          {
             alert("Duplicate Values are not allowed.");
             
          }
          else
          {
            save_update_interview_process(count,company_id,value_numbering,value_id);
          }
       }
  }

  function save_update_interview_process(count,company_id,value_numbering,value_id)
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
                    document.getElementById("action_interview_process").innerHTML=xmlhttp.responseText;
                     $("#inproc").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                    setTimeout(function() {
                        $('#flashdata_result').fadeOut('fast');
                        }, 3000);
                    
                      $('#main_btn').show();
                      $('#num_btn').hide();


                      var count = document.getElementById('ip_count').value;
                      var cinput =   document.getElementsByClassName('ip_value');
                    
                      for (i=1;i < count; i++)
                          {
                            $('#ip_update'+i).hide();
                            $('#ip_viewing'+i).show();
                           
                        } 
                  }
                }
      xmlhttp.open("GET","<?php echo base_url();?>app/recruitment_hris/ED2_save_update_interview_process/"+count+"/"+company_id+"/"+value_numbering+"/"+value_id,true);
      xmlhttp.send();
  }
  function function_escape(ids,titles)
      {
         var a = titles.replace(/\?/g, '-a-');
         var b = a.replace(/\!/g, "-b-");
         var c = b.replace(/\//g, "-c-");
         var d = c.replace(/\|/g, "-d-");
         var e = d.replace(/\[/g, "-e-");
         var f = e.replace(/\]/g, "-f-");
         var g = f.replace(/\(/g, "-g-");
         var h = g.replace(/\)/g, "-h-");
         var i = h.replace(/\{/g, "-i-");
         var j = i.replace(/\}/g, "-j-");
         var k = j.replace(/\'/g, "-k-");
         var l = k.replace(/\,/g, "-l-");
         var m = l.replace(/\'/g, "-m-");
         var n = m.replace(/\_/g, "-n-");
         var o = n.replace(/\@/g, "-o-");
         var p = o.replace(/\#/g, "-p-");
         var q = p.replace(/\%/g, "-q-");
         var r = q.replace(/\$/g, "-r-");
         var s = r.replace(/\^/g, "-s-");
         var t = s.replace(/\&/g, "-t-");
         var u = t.replace(/\*/g, "-u-");
         var v = u.replace(/\+/g, "-v-");
         var w = v.replace(/\=/g, "-w-");
         var x = w.replace(/\:/g, "-x-");
         var y = x.replace(/\;/g, "-y-");
         var z = y.replace(/\%20/g, "-z-");
         var aa = y.replace(/\./g, "-zz-");
         var bb = aa.replace(/\</g, "-aa-");
         var cc = bb.replace(/\>/g, "-bb-");
         document.getElementById(ids).value=cc;
      }


</script>
