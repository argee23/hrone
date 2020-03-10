 
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
        <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>

<br><br>
<div id="app">
  <div class="col-lg-12">
      <h2 class="page-header">Personnel Allowed Over Time Management</h2>
       
     
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading"><n class='text-success'> <b>FILTER APPROVED OVERTIME</b></n> </div>
            <div class="panel-body" id="filtering_">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">FROM</label>
                    <div class="col-sm-9">
                      <input type="date" name="datefrom" id="datefrom" class="form-control">
                    </div>

                    <label class="control-label col-sm-3" for="email" style="margin-top: 5px;">TO</label>
                    <div class="col-sm-9" style="margin-top: 5px;">
                      <input type="date" name="dateto" id="dateto" class="form-control">
                    </div>


                    <div class="col-sm-12" style="margin-top: 5px;">
                      <button class="col-md-12 btn btn-default" onclick="get_filtered_approved_ot();"><b>FILTER APPROVED OT <i class="fa fa-arrow-right"></i></b></button>
                    </div>

                  </div>
                  <br><br>
              </div>

              <div class="panel-heading"><n class='text-success'> <b>CHECK EMPLOYEE APPROVED OT</b></n> </div>
            <div class="panel-body" id="filtering_">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">EMPLOYEE</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="empchecker" >
                        <option value="" disabled selected>Select Employee</option>
                        <?php foreach($group_members as $m){ if($m->checker=='true'){?>
                            <option value="<?php echo $m->employee_id;?>"><?php echo $m->employee_id.'('.$m->fullname.')';?></option>
                        <?php } } ?>
                      </select>
                    </div>

                    <label class="control-label col-sm-3" for="email" style="margin-top: 5px;">DATE</label>
                    <div class="col-sm-9" style="margin-top: 5px;">
                      <input type="date" name="emp_date_from" id="emp_date_from" class="form-control">
                    </div>

                    <label class="control-label col-sm-3" for="email" style="margin-top: 5px;"></label>
                    <div class="col-sm-9" style="margin-top: 5px;">
                      <input type="checkbox" name="dateall" id="dateall" onclick="checker_employee_ot();">&nbsp;ALL DATES
                    </div>

                    <div class="col-sm-12" style="margin-top: 5px;">
                      <button class="col-md-12 btn btn-default" onclick="employee_approved_ot();"><b>CHECK APPROVED OT <i class="fa fa-arrow-right"></i></b></button>
                    </div>

                  </div>
                  <br><br>
              </div>
          </div>


        </div>


        <div class="col-md-9">
          <div class="panel panel-success">
            <div class="panel-heading"> Personnel List <a class="btn btn-success btn-xs pull-right" onclick="add_new_group();"><i class="fa fa-add">ADD NEW GROUP</i></a> </div>  
              <div class="panel-body" id="group_members">
                     <table class="table table-hover" id="overtime">
                        <thead>
                            <tr class='danger'>
                                <th>ID</th>
                                <th>Group Name</th>
                                <th>Date</th>
                                <th>Reason</th>
                                <th>Date Plotted</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php $i=1; foreach ($plotted as $p) {?>
                            <tr>
                                <td><?php echo $p->id; ?></td>
                                <td><?php echo $p->group_name; ?></td>
                                <td><?php echo $p->date; ?></td>
                                <td><?php echo $p->reason; ?></td>
                                <td><?php echo $p->date_created; ?></td>
                                <td>

                                      <center>

                                          <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'   onclick='edit_group_approved_ot("<?php echo $p->id;?>","<?php echo $p->date;?>")' aria-hidden='true' data-toggle='tooltip' title='Click to Update Group Name'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>

                                          <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick='view_approved_ot("<?php echo $p->id;?>","<?php echo $p->date;?>")' aria-hidden='true' data-toggle='tooltip' title='Click to View Plotted OT Hour/s'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                                          <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick='delete_approved_ot("<?php echo $p->id;?>","<?php echo $p->date;?>")' aria-hidden='true' data-toggle='tooltip' title='Click to Delete Plotted OT Hour/s'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                         
                                           <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_add_color;?>' target="_blank" aria-hidden='true' data-toggle='tooltip' title='Click to Add Employee with approved ot hours'    href="<?php echo base_url().'employee_portal/overtime_management_section_mngr_approved_ot/add_member_approved_ot';?>/<?php echo $p->id;?>/<?php echo $p->date;?>"  style='display: none;'><i  class="fa fa-<?php  echo $system_defined_icons->icon_add;?> fa-lg  pull-left"></i></a>


                                           <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>'  onclick='upload_member_approved_ot("<?php echo $p->id;?>","<?php echo $p->date;?>","<?php echo $p->group_name;?>")' aria-hidden='true' data-toggle='tooltip' title='Click to Upload Employee with approved ot hours'  ><i  class="fa fa-upload fa-lg  pull-left"></i></a>


                                      </center>

                                </td>
                          </tr>
                          <?php $i++; } ?>
                          </tbody>
                      </table>
              </div>
          </div>
        </div>

</div>
  

  <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content modal-md">
        <div class="modal-header bg-success">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><n id="details_date"></n></h4>
          <span><h5 id="status_datetime"></h5></span>
          <span id="status_icon"></span>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12" id="details_modal">  

            </div>
          </div>
        </div>

        <div id="status_buttons" class="modal-footer bg-success">
        <a class="btn btn-default" style="display: none;" href="<?php echo base_url().'employee_portal/overtime_management_section_mngr_approved_ot/download_ot_approved';?>" id="downloaded_template_file"><b><n class="text-danger">DOWNLOAD TEMPLATE</n></b></a>
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">CLOSE</button>
        </div>
      </div>
    </div>
  </div>



<!-- DataTables -->
 <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  


<?php require_once(APPPATH.'views/app/application_form/footer.php');?>

<script type="text/javascript">

    $(function () {
        $('#overtime').DataTable({
          "pageLength":30,
          "pagingType" : "simple",
          "paging": true,
         lengthMenu: [[30, 35, 40, -1], [30, 35, 40, "All"]],

          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

    function delete_approved_ot(id,date)
    {
      var result = confirm("Are you sure you want to delete this record?");
      if(result == true)
      {
          if (window.XMLHttpRequest)
                    {
                    xmlhttp2=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp2.onreadystatechange=function()
                    {
                    if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
                      {
                        location.reload();
                      }
                    }
          xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/overtime_management_section_mngr_approved_ot/delete_approved_ot/"+id+"/"+date,false);
          xmlhttp2.send();        
      }
    }


    function view_approved_ot(id,date)
    {
        $('#downloaded_template_file').hide();
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
                 document.getElementById("details_modal").innerHTML=xmlhttp.responseText;
                 $("#myModal2").modal('show');
                  document.getElementById("details_date").innerHTML = "Approved OT Hours for " + date;
                  $("#details").DataTable({
                        lengthMenu: [[-1,20, 25, 30, 35, 40], ["All",20, 25, 30, 35, 40]],
                          dom: 'Blfrtip',
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                          buttons: [
                          {
                            extend: 'excel',
                            title: 'Approved Overtime Hours'
                          },
                          {
                            extend: 'print',
                            title: 'Approved Overtime Hours'
                          }
                          ]            
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/overtime_management_section_mngr_approved_ot/view_approved_ot/"+id+"/"+date,true);
          xmlhttp.send();
       
    }

    
    function get_employees_for_general(val)
     {
          var date = val.target.value;
          var a_date = date;
          if (window.XMLHttpRequest)
          {
            xmlhttp2=new XMLHttpRequest();
          }
          else
          {// code for IE6, IE5
               xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp2.onreadystatechange=function()
          {
            if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
              {
                document.getElementById("group_members").innerHTML=xmlhttp2.responseText;
                $("#overtime").DataTable({
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]     
                });
              }
          }
          xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/overtime_management_section_mngr_approved_ot/get_employees/"+date,false);
          xmlhttp2.send();

     }

     function checkall_emp(val,emp)
     {
        if(val=='All')
        {
             var count = document.getElementById('count_emp').value;  
             if(document.getElementById('All').checked==true)
             {
                var all_value = document.getElementById('employee_all').value;
                document.getElementById('selected_employee').value=all_value;

                for(i=1;i<count;i++)
                  {
                    document.getElementById('id'+i).checked=true;
                      if(document.getElementById('hrs'+ i).value==0 || document.getElementById('hrs'+i).value=='')
                      {
                        document.getElementById("hrs"+i).style.borderColor="#FF4500";

                       var recheck = document.getElementById('recheck_hrs').value;
                       recheck +=i + "-";
                       document.getElementById('recheck_hrs').value=recheck; 

                       var emp_i = document.getElementById('employee_i').value;
                       emp_i +=i + "-";
                       document.getElementById('employee_i').value=emp_i;

                      }
                      else
                      {
                        document.getElementById("hrs"+i).style.borderColor="";
                        var recheck = document.getElementById('recheck_hrs').value;
                        var res =recheck.replace(new RegExp(i+'-','g'), '');
                        document.getElementById('recheck_hrs').value=res;

                        var emp_i = document.getElementById('employee_i').value;
                        emp_i +=i + "-";
                        document.getElementById('employee_i').value=emp_i;

                      }
                  }
             }
             else
             {
                document.getElementById('selected_employee').value="";
                document.getElementById('recheck_hrs').value="";

                document.getElementById('employee_i').value="";
                for(i=1;i<count;i++)
                  {
                    document.getElementById('id'+i).checked=false;
                    document.getElementById("hrs"+i).style.borderColor="";
                  }
             }
        }
        else
        {
          if(document.getElementById('id'+val).checked==true)
             {
                  var selected = document.getElementById('selected_employee').value;
                  selected +=emp + "-";
                  document.getElementById('selected_employee').value=selected;  
                  var emp_i = document.getElementById('employee_i').value;
                  emp_i +=val + "-";
                  document.getElementById('employee_i').value=emp_i;

                  if(document.getElementById('hrs'+ val).value==0 || document.getElementById('hrs'+val).value=='')
                      {
                        document.getElementById("hrs"+val).style.borderColor="#FF4500";
                        var recheck = document.getElementById('recheck_hrs').value;
                        recheck +=val + "-";
                        document.getElementById('recheck_hrs').value=recheck;
                      }
                  else
                      { 
                        document.getElementById("hrs"+val).style.borderColor="";
                        var recheck = document.getElementById('recheck_hrs').value;
                        var res =recheck.replace(new RegExp(val+'-','g'), '');
                        document.getElementById('recheck_hrs').value=res;
                      }
             }
          else
            {
                var selected = document.getElementById('All').checked=false;

                  var selected = document.getElementById('selected_employee').value;
                  var res = selected.replace(emp+"-", "");
                  document.getElementById('selected_employee').value=res;

                  var employee_i = document.getElementById('employee_i').value;
                  var emp_i = employee_i.replace(val+"-", "");
                  document.getElementById('employee_i').value=emp_i;

                  var recheck = document.getElementById('recheck_hrs').value;
                 var res =recheck.replace(new RegExp(val+'-','g'), '');
                  document.getElementById('recheck_hrs').value=res;
                 document.getElementById("hrs"+ val).style.borderColor="";
            }
        }
     }

     function hours_all(val,option)
     {
        if(option=='All')
        {
            var count = document.getElementById('count_emp').value;
            for(i=1;i<count;i++)
              {
                document.getElementById('hrs'+i).value=val;
                if(document.getElementById('id'+ i).checked==true)
                      {
                         if(val==0 || val=='' || val==null)
                         {
                            document.getElementById("hrs"+i).style.borderColor="#FF4500";
                            var recheck = document.getElementById('recheck_hrs').value;
                            recheck +=i + "-";
                            document.getElementById('recheck_hrs').value=recheck;
                         }
                         else
                          {  
                                document.getElementById("hrs"+i).style.borderColor=""; 
                                var recheck = document.getElementById('recheck_hrs').value;
                                var res =recheck.replace(new RegExp(i+'-','g'), '');
                                document.getElementById('recheck_hrs').value=res;
                          }
                      }
                else
                      {
                        document.getElementById("hrs"+i).style.borderColor="";
                        var recheck = document.getElementById('recheck_hrs').value;
                       var res =recheck.replace(new RegExp(i+'-','g'), '');
                        document.getElementById('recheck_hrs').value=res;
                      }
              }
        }
        else
        {
              if(document.getElementById('id'+ option).checked==true)
                      {
                         if(val==0 || val=='' || val < 0)
                         {
                            document.getElementById("hrs"+option).style.borderColor="#FF4500";
                            var recheck = document.getElementById('recheck_hrs').value;
                            recheck +=option + "-";
                            document.getElementById('recheck_hrs').value=recheck;
                         }
                         else
                          {  
                          
                            document.getElementById("hrs"+option).style.borderColor=""; 
                            var recheck = document.getElementById('recheck_hrs').value;
                           
                             var res =recheck.replace(new RegExp(option+'-','g'), '');
                            document.getElementById('recheck_hrs').value=res;

                          }
                      }
                else
                      {
                        document.getElementById("hrs"+option).style.borderColor="";
                        var recheck = document.getElementById('recheck_hrs').value;
                        var res =recheck.replace(new RegExp(option+'-','g'), '');
                        document.getElementById('recheck_hrs').value=res;
                      }
        }
     }

      function isNumberKey(txt, evt) {
          
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 46) {
                //Check if the text already contains the . character
                if (txt.value.indexOf('.') === -1) {
                    return true;

                } else {
                    return false;

                }
            } else {

                if (charCode > 31
                     && (charCode < 48 || charCode > 57))
                    return false;

            }
            return true;
        }
    function save_pre_approved()
    {
      var employee_id=document.getElementById('selected_employee').value;
      var employee_result = employee_id.substring(0, employee_id.length - 1);
      var hrs_value=document.getElementById('employee_i').value;
      var error=document.getElementById('recheck_hrs').value;
      var date = document.getElementById('date').value;
      

      if(document.getElementById('reason').value==''){ reason ='none'; }
      else{ reason=document.getElementById('reason').value; }
      function_escape("reason_",reason);
      var reas= document.getElementById("reason_").value;

      
      
      if(employee_id=='') { alert("Please select atleast one employee to continue"); }
      else { 
              if(error=='')  
              { 
                var hrs = hrs_value.substring(0, hrs_value.length - 1);
                var res = hrs.split("-");
                var count = hrs.split('-').length;
                hours_result = "";
                for(i=0;i<count;i++)
                {
                    var ii = res[i];
                    var v =document.getElementById('hrs'+ii).value;
                    hours_result +=v + "-";
                }

                if(hours_result==''){}
                else
                { 
                 
                    document.getElementById('date').value='';
                    var hours = hours_result.substring(0, hours_result.length - 1);
                    if (window.XMLHttpRequest)
                    {
                        xmlhttp2=new XMLHttpRequest();
                        }
                      else
                        {// code for IE6, IE5
                        xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
                        }
                      xmlhttp2.onreadystatechange=function()
                        {
                        if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
                          {
                           document.getElementById("details_modal").innerHTML=xmlhttp2.responseText;
                          }
                        }
                      xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/Overtime_management_section_mngr_approved_ot/save_approved_ot/"+employee_result+"/"+hours+"/"+reas+"/"+count+"/"+date,false);
                      xmlhttp2.send();
                    }
                
              }
              else { alert('Hours should not be less or equal to 0. Please check all red bordered input type.');  }
      }
      }

      function add_member_approved_ot(id,date)
      {
          $('#downloaded_template_file').hide();
          if (window.XMLHttpRequest)
          {
            xmlhttp2=new XMLHttpRequest();
          }
          else
          {// code for IE6, IE5
               xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp2.onreadystatechange=function()
          {
            if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
              {
                document.getElementById("group_members").innerHTML=xmlhttp2.responseText;
                $("#overtime").DataTable({
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]     
                });
              }
          }
          xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/overtime_management_section_mngr_approved_ot/add_member_approved_ot/"+date+"/"+id,false);
          xmlhttp2.send();

      }

      function add_member_save_pre_approved(id,date)
      {
        
            var count= document.getElementById("count_emp").value -1;
            var checks = document.getElementsByClassName("selected");
            var selected_employee ='';
            var selected_hrs ='';
            var error ='';

            if(document.getElementById('reason').value==''){ reason ='none'; }
            else{ reason=document.getElementById('reason').value; }
            function_escape("reason_",reason);
            var reas= document.getElementById("reason_").value;


     

            for (i=0;i < count; i++)
              {
                if (checks[i].checked === true)
                  {
                    var ii = i + 1;
                    selected_employee +=checks[i].value + "-";
                    var value = document.getElementById('hrs'+ii).value;

                    if(value=='0' || value=="")
                    {
                      error +="error";
                      break;
                    }
                    else
                    {
                      selected_hrs +=value + "-";
                      error += "";
                    }

                  }
              }

           if(selected_employee=="" || selected_hrs=="")
           {
            alert("Please select atleast one employee to continue");
           }
           else
           {
                if(error=="")
                {
                  if (window.XMLHttpRequest)
                    {
                    xmlhttp2=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp2.onreadystatechange=function()
                    {
                    if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
                      {
                       location.reload();
                      }
                    }
                  xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/overtime_management_section_mngr_approved_ot/add_member_save_pre_approved/"+id+"/"+date+"/"+selected_hrs+"/"+selected_employee+"/"+count+"/"+reas,false);
                  xmlhttp2.send();  
                }
                else
                {
                   alert('Hours should not be less or equal to 0. Please check all red bordered input type.');
                }
           }
      }


      function delete_approved_ot_member(id,idd,date)
      {
        var result = confirm("Are you sure you want to delete this record?");
        if(result == true)
        {
            if (window.XMLHttpRequest)
                      {
                      xmlhttp2=new XMLHttpRequest();
                      }
                    else
                      {// code for IE6, IE5
                      xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
                      }
                    xmlhttp2.onreadystatechange=function()
                      {
                      if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
                        {
                          location.reload();
                        }
                      }
            xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/overtime_management_section_mngr_approved_ot/delete_approved_ot_member/"+id+"/"+idd+"/"+date,false);
            xmlhttp2.send();  
          }
      }


      function delete_approved_ot_member(id,idd,date)
      {
        var result = confirm("Are you sure you want to delete this record?");
        if(result == true)
        {
            if (window.XMLHttpRequest)
                      {
                      xmlhttp2=new XMLHttpRequest();
                      }
                    else
                      {// code for IE6, IE5
                      xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
                      }
                    xmlhttp2.onreadystatechange=function()
                      {
                      if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
                        {
                          location.reload();
                        }
                      }
            xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/overtime_management_section_mngr_approved_ot/delete_approved_ot_member/"+id+"/"+idd+"/"+date,false);
            xmlhttp2.send();  
          }
      }

      function edit_group_approved_ot(id,date)
      {
        $('#downloaded_template_file').hide();
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
                 document.getElementById("details_modal").innerHTML=xmlhttp.responseText;
                 $("#myModal2").modal('show');
                  document.getElementById("details_date").innerHTML = "Update Group Details";
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/overtime_management_section_mngr_approved_ot/edit_group_approved_ot/"+id+"/"+date,true);
          xmlhttp.send();
      }

     function add_new_group()
      {
        $('#downloaded_template_file').hide();
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
                 document.getElementById("details_modal").innerHTML=xmlhttp.responseText;
                 $("#myModal2").modal('show');
                  document.getElementById("details_date").innerHTML = "Add New Group";
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/overtime_management_section_mngr_approved_ot/add_new_group/",true);
          xmlhttp.send();
      }


      function upload_member_approved_ot(id,date,group_name)
      {
          
          $('#downloaded_template_file').show();
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
                 document.getElementById("details_modal").innerHTML=xmlhttp.responseText;
                 $("#myModal2").modal('show');
                  document.getElementById("details_date").innerHTML = "Upload Approved OT [ " + group_name + " ]";
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/overtime_management_section_mngr_approved_ot/upload_approved_ot_group/"+id+"/"+date,true);
          xmlhttp.send();
      }

      
      function get_filtered_approved_ot()
      {
        var from = document.getElementById('datefrom').value;
        var to = document.getElementById('dateto').value;

        if(from =='' || to=='')
        {
          alert('Fill up date field to continue');
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
                   document.getElementById("group_members").innerHTML=xmlhttp.responseText;
                   $("#overtime").DataTable({
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]     
                });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/overtime_management_section_mngr_approved_ot/get_filtered_approved_ot/"+from+"/"+to,true);
            xmlhttp.send();
        }
      }
      
      function checker_employee_ot()
      {
        if(document.getElementById('dateall').checked==true)
        {
            document.getElementById('emp_date_from').disabled=true;
        }
        else
        {
            document.getElementById('emp_date_from').disabled=false;
        }
      }


      function employee_approved_ot()
      {
        var employee_id = document.getElementById('empchecker').value;
       
        if(document.getElementById('dateall').checked==true)
        {
          date = 'all';
        }
        else
        {
           var date = document.getElementById('emp_date_from').value;
        }

        if(date=='' || employee_id==''){ alert('Fill up all field to contine'); }
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
                   document.getElementById("group_members").innerHTML=xmlhttp.responseText;
                   $("#overtime").DataTable({
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]     
                });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/overtime_management_section_mngr_approved_ot/employee_approved_ot/"+employee_id+"/"+date,true);
            xmlhttp.send();


        }
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