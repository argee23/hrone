
  <div class="col-md-12" style="padding-top: 50px;"> 

    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i>Notification Reports</b></n></a> </li>
               <li class="pull-right"> <a data-toggle="tab" style="cursor: pointer;" onclick="generate_report();"><b> <i></i>Generate Reports</b></a></li>
               <li class="active pull-right"><a data-toggle="tab" style="cursor: pointer;" onclick="window.location.reload()"> <b><i class="fa fa-adjust"></i>Manage Crystal Report</b></a> </li>
              
          </ul>
      </div>
      <div class="col-md-12" style="padding-top: 30px;" id="all_action">
            <div class="col-md-3">

                
                   <div class="col-md-12" style="padding-top:10px;">
                          <div class="col-md-12"><label>Notifications:</label></div>
                            <div class="col-md-12">
                                  <select class="form-control" id='fnotification' onchange="get_crystal_reports('view',this.value);">
                                  <?php if(empty($notifications)){ echo "<option value=''>No Notification found.</option>";}
                                  else{ echo "<option value='' disabled selected>Select Notification</option>"; foreach($notifications as $notif){?>
                                  <option value="<?php echo $notif->id;?>"><?php echo $notif->form_name;?></option>
                                  <?php }} ?>
                                  </select>
                         </div>
                  </div>

            </div>

            <div class="col-md-9" id="crystal_report_action">


                <table class="col-md-12 table table-hover" id="crystal_report">
                  <thead>
                    <tr class="danger">
                      <th>No.</th>
                      <th>Report ID</th>
                      <th>Report Name</th>
                      <th>Report Description</th>
                      <th>Fields</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>

            </div>
    </div>

      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result" style="padding-bottom: 10px;"><br>
              <div class="col-md-12">
              </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div>             
    </div> 
  </div> 

   <div class="modal modal-primary fade" id="search_employee_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Select Employees</h4>
                  </div>
                 <div class="modal-body">                             
                    <input onKeyUp="employee_list(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                    <span id="Search_Employee_Result"></span>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>                          
            </div>
        </div>
    </div> 
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script>


       $(function () {
        $('#crystal_report').DataTable({
          "pageLength":1,
          "pagingType" : "simple",
          "paging": true,
         lengthMenu: [[1,5, 10, 15, 20, 25, 30, 35, 40, -1], [1,5, 10, 15, 20, 25, 30, 35, 40, "All"]],
          "searching": true,
          "ordering":true,
          "info": true,
          "autoWidth": true
        });
      });

      function manage_crystal_report()
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
                  document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                   $("#crystal_report").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                  }
                }
            xmlhttp.open("GET","<?php echo base_url();?>app/notifications_report/manage_crystal_report/",true);
            xmlhttp.send();
      }
      function get_notifications(company)
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
                  document.getElementById("fnotification").innerHTML=xmlhttp.responseText;
                  }
                }
            xmlhttp.open("GET","<?php echo base_url();?>app/notifications_report/get_notifications/"+company,true);
            xmlhttp.send();


      }

    
      function get_crystal_reports(action,notif)
      {

        var type = 'approver';
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
                  document.getElementById("crystal_report_action").innerHTML=xmlhttp.responseText;
                   $("#crystal_report").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                  }
                }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/notification_approver_reports/manage_crystal_report_notification/"+type+"/"+notif+"/"+action,true);
            xmlhttp.send();

      }
      function stat_crystal_report(notif,company,action,id)
      {

          msg = 'Are you sure you want to ' + action + ' id- ' + id;

          var result = confirm(msg);
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
                        document.getElementById("crystal_report_action").innerHTML=xmlhttp.responseText;
                       $("#crystal_report").DataTable({
                              lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                              });
                      }
                    }
                xmlhttp.open("GET","<?php echo base_url();?>employee_portal/notification_approver_reports/stat_crystal_report/"+notif+"/"+company+"/"+action+"/"+id,true);
                xmlhttp.send();
          }

      }

      function edit_crystal_report(notif,company,action,id)
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
                  document.getElementById("crystal_report_action").innerHTML=xmlhttp.responseText;
                
                  }
                }
            xmlhttp.open("GET","<?php echo base_url();?>app/notifications_report/stat_crystal_report/"+notif+"/"+company+"/"+action+"/"+id,true);
            xmlhttp.send();




      }
      function add_crystal_report(notif,company,action)
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
                  document.getElementById("crystal_report_action").innerHTML=xmlhttp.responseText;
                   $("#crystal_report").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                  }
                }
            xmlhttp.open("GET","<?php echo base_url();?>app/notifications_report/add_crystal_report/"+company+"/"+notif+"/"+action,true);
            xmlhttp.send();
      }

      function reset()
       {
          var count= document.getElementById("crystal_fields").value;
          var checks = document.getElementsByClassName("option_check");
          var data=document.getElementById('ccc').value;


          if(data==0){ res =true; document.getElementById('ccc').value='1'; } 
          else{ res =false;  document.getElementById('ccc').value='0'; }
          for (i=0;i < count; i++)
          {
            document.getElementById("r_" + i).checked=res;
          
          }     

         
       }

    function save_crystal_report(company,notif,action,action_id)
    {
      var report_name = document.getElementById('name').value;
      function_escape('name_',report_name);
      var name = document.getElementById('name').value;
      var report_desc = document.getElementById('description').value;
      function_escape('description_',report_desc);
      var desc = 'mimi'+document.getElementById('description_').value;

      var count= document.getElementById("crystal_fields").value;
      var checks = document.getElementsByClassName("option_check");
      var data ='';

      for (i=0;i < count; i++)
        {
          if (checks[i].checked === true)
            {
              data +=checks[i].value + "-";
                    
             }
        }
      if(name=='')
      {
        alert('Please fill up the report name to continue.');
      }
      else if(data=='')
      {
        alert('Please select atleast one field to continue.');
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
                    document.getElementById("crystal_report_action").innerHTML=xmlhttp.responseText;
                     $("#crystal_report").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                    }
                  }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/notification_approver_reports/save_crystal_report/"+company+"/"+notif+"/"+action+"/"+name+"/"+desc+"/"+data+"/"+action_id,true);
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



    //start of generate report
    function generate_report()
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
                    document.getElementById("all_action").innerHTML=xmlhttp.responseText;
                     $("#crystal_reports").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                    }
                  }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/notification_approver_reports/generate_report/",true);
              xmlhttp.send();
    }

    function get_generate_crystal_reports(value)
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
                    document.getElementById("generate_crystal_report").innerHTML=xmlhttp.responseText;
                    
                    }
                  }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/notification_approver_reports/get_generate_crystal_reports/"+value,true);
              xmlhttp.send();
    }
      function check_status_filter(val,idd)
    {
      if(val=='approved' || val=='all')
      {
        document.getElementById(idd).disabled=false;
      }
      else
      {
        document.getElementById(idd).disabled=true;
      }
    }

     function employee_list(val)
      {
        var vall = val+"-";
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
            document.getElementById("Search_Employee_Result").innerHTML=xmlhttp.responseText;
            }
          }
       xmlhttp.open("GET","<?php echo base_url();?>employee_portal/notification_approver_reports/employee_list/"+vall,true);
        xmlhttp.send();
        
    }
    function select_emp(id,name)
    {
      document.getElementById("employee_id").value = id; 
      document.getElementById("employee_name").value = name;
    }
    
    function disabled_date()
     {
      var val = document.getElementById('date_range').value;
      if(val==1)
      {
        document.getElementById('date_range').value=0;
        document.getElementById('date_from').disabled=false;
        document.getElementById('date_to').disabled=false;
      }
      else
      {
        document.getElementById('date_range').value=1;
        document.getElementById('date_from').disabled=true;
        document.getElementById('date_to').disabled=true;
      }
     }

    function check_employee_filter(val)
    {
      if(val=='one')
      {
           $("#one_employee").show();
           $("#ssection").hide();
           $("#ssubsection").hide();
           $("#sclassification").hide();
           $("#semployment").hide();
           $("#slocation").hide();
           $("#sdepartment").hide();
      }
      else
      {
           $("#one_employee").hide();
           $("#ssection").show();
           $("#ssubsection").show();
           $("#sclassification").show();
           $("#semployment").show();
           $("#slocation").show();
           $("#sdepartment").show();
      }
    }
    function get_section(dept)
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
            document.getElementById('section').innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/notification_approver_reports/get_section/"+dept,true);
        xmlhttp.send();
      }
      function get_subsection(section)
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
              document.getElementById('subsection').innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/notification_approver_reports/get_subsection/"+section,true);
          xmlhttp.send();
     }

     function filter_report()
     {

      var notification = document.getElementById('generate_notification').value;
      var crystal_report = document.getElementById('generate_crystal_report').value;
      var status = document.getElementById('status').value;
      var status_view = document.getElementById('status_view').value;

      var date_range = document.getElementById('date_range').value;
      if(date_range==1)
      {
        var date_from =  'all';
        var date_to =  'all';
      }
      else
      {
        var date_from =  document.getElementById('date_from').value;
        var date_to =  document.getElementById('date_to').value;
      }
      

      var employee = document.getElementById('employee').value;

      if(employee=='one')
      {
        var employee_id = document.getElementById('employee_id').value;

        get_filter_report_result(notification,crystal_report,status,status_view,date_to,date_from,employee,employee_id,employee,employee,employee,employee,employee,employee);
      }
      else
      {
          var department = document.getElementById('department').value;
          var section = document.getElementById('section').value;
          var subsection = document.getElementById('subsection').value;

          var location          =   document.getElementsByClassName('res_location');
          var location_count    =   document.getElementById('count_location').value;
         
          var loc='';
                    for (i=0;i < location_count; i++)
                    {
                      if (location[i].checked === true)
                      {
                        loc +=location[i].value + "-";
                        
                      }
                    }
          var classification    =   document.getElementsByClassName('res_classification');
          var classification_count    =   document.getElementById('count_classification').value;

          var classs='';
                    for (i=0;i<classification_count; i++)
                    {
                      if (classification[i].checked === true)
                      {
                        classs += classification[i].value + "-";
                        
                      }
                    }

          var employment    =   document.getElementsByClassName('res_employment');
          var employment_count    =   document.getElementById('count_employment').value;

          var empp='';
                    for (i=0;i<employment_count; i++)
                    {
                      if (employment[i].checked === true)
                      {
                        empp += employment[i].value + "-";
                        
                      }
                    }
          
          get_filter_report_result(notification,crystal_report,status,status_view,date_to,date_from,employee,employee_id,department,section,subsection,loc,classs,empp);
        }

     }

     function  get_filter_report_result(notification,crystal_report,status,status_view,date_to,date_from,employee,employee_id,department,section,subsection,loc,classs,empp)
     {
    if(notification=='' || crystal_report=='' || status=='' || status_view=='' || date_to=='' || date_from=='' || employee=='' || employee_id=='' || department=='' || section=='' || subsection=='' || loc=='' || classs=='' || empp=='')
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
                document.getElementById('crystal_report_action').innerHTML=xmlhttp.responseText;
                 $("#crystal_reports").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/notification_approver_reports/get_filter_report_result/"+notification+"/"+crystal_report+"/"+status+"/"+status_view+"/"+date_to+"/"+date_from+"/"+employee+"/"+employee_id+"/"+department+"/"+section+"/"+subsection+"/"+loc+"/"+classs+"/"+empp,true);
            xmlhttp.send();
      }
    }



    </script>
  <!--END ajaxX FUNCTIONS-->
