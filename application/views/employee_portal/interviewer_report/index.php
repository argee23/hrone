
  <div class="col-md-12" style="padding-top: 50px;"> 

    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i>Applicants Interview Reports</b></n></a> </li>
               <li class="pull-right"> <a data-toggle="tab" style="cursor: pointer;" onclick="generate_report();"><b> <i></i>Generate Reports</b></a></li>
               <li class="active pull-right"><a data-toggle="tab" style="cursor: pointer;" onclick="window.location.reload()"> <b><i class="fa fa-adjust"></i>Manage Crystal Report</b></a> </li>
              
          </ul>
      </div>
      <div class="col-md-12" style="padding-top: 30px;" id="all_action">
            
            <div class="col-md-12" style="margin-bottom: 20px;">
            <button class="col-md-2 btn btn-success btn-sm pull-right" onclick="add_crystal_report();">ADD CRYSTAL REPORT</button>
            </div>

            <div class="col-md-12" id="crystal_report_action">

                <table class="col-md-12 table table-hover" id="crystal_report">
                  <thead>
                    <tr class="danger">
                      <th>No.</th>
                      <th>Report ID</th>
                      <th>Report Name</th>
                      <th>Report Description</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $i=1; foreach($crystal_report as $cd){?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $cd->id;?></td>
                      <td><?php echo $cd->title;?></td>
                      <td><?php echo $cd->description;?></td>
                      <td> 
                        <?php if($cd->InActive==1){} else{ ?><a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="edit_crystal_report('edit','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Update Crystal report details' ><i  class="fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-left"></i></a> <?php } ?>

                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="stat_crystal_report('delete','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Delete crystal report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                       <?php if($cd->InActive==1){?>

                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' onclick="stat_crystal_report('enable','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to disable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                        <?php }else{ ?>
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'onclick="stat_crystal_report('disable','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to enable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                        <?php } ?>
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="stat_crystal_report('view','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to View crystal report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                      </td>
                    </tr>
                  <?php $i++; } ?>
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

  
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">

    <script type="text/javascript">
      
        $(function () {
        $('#crystal_report').DataTable({
          "pageLength":-1,
          "pagingType" : "simple",
          "paging": true,
         lengthMenu: [[-1,5, 10, 15, 20, 25, 30, 35, 40, -1], ["All",5, 10, 15, 20, 25, 30, 35, 40]],
          "searching": true,
          "ordering":true,
          "info": true,
          "autoWidth": true
        });
      });

      function add_crystal_report()
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
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/applicant_interview_result_report/add_crystal_report/",true);
            xmlhttp.send();
      }

        function reset()
      {
       var checks = document.getElementsByClassName("option");
       var crystal_fields= document.getElementById("crystal_fields").value;
                for (i=0;i < crystal_fields; i++)
                {
                  checks[i].checked =false;
                }
       
      }
      function checkAll()
      {
       var checks = document.getElementsByClassName("option");
       var crystal_fields= document.getElementById("crystal_fields").value;
                for (i=0;i < crystal_fields; i++)
                {
                  checks[i].checked =true;
                }
      }


      function save_report()
       {
        
         var report_name= document.getElementById("report_name").value;
         var report_desc= document.getElementById("report_desc").value;         
         var crystal_fields= document.getElementById("crystal_fields").value;
         var checks = document.getElementsByClassName("option");
         var fields='';

       

                  for (i=0;i < crystal_fields; i++)
                  {
                    if (checks[i].checked === true)
                    {
                      fields +=checks[i].value + "-";
                    }
                  }

         if(report_name=='' || report_desc=='')
         { alert("Fill Up the Report Name and Report Desription to continue"); }
         else
         {
            if(fields=='' || fields==null)
            { alert("Check atleast one field to continue"); }
            else
            { 

                function_escape('rname',report_name);
                function_escape('rdesc',report_desc);

                var name = document.getElementById('rname').value;
                var desc =  document.getElementById('rdesc').value;


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
                      location.reload();
                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>employee_portal/applicant_interview_result_report/save_new_report/"+fields+"/"+name+"/"+desc,true);
                xmlhttp.send();
                 
            }
         }

       } 


        function stat_crystal_report(action,id)
      {
          if(action=='view')
          {
            var result = true;
          }
          else
          {
            msg = 'Are you sure you want to ' + action + ' id- ' + id;
            var result = confirm(msg);
          }
         

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
                            if(action=='view')
                              {
                                document.getElementById("all_action").innerHTML=xmlhttp.responseText;
                              }
                            else
                              {
                                location.reload();
                              }
                        }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>employee_portal/applicant_interview_result_report/stat_crystal_report/"+action+"/"+id,true);
                xmlhttp.send();
          }

      }

      function edit_crystal_report(action,id)
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
                      document.getElementById("all_action").innerHTML=xmlhttp.responseText;
                  }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/applicant_interview_result_report/edit_crystal_report/"+action+"/"+id,true);
          xmlhttp.send();
      }
       function reset1()
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

        function update_crystal_report(crystal_id)
        {
          var description = document.getElementById('description').value;
          var name = document.getElementById('name').value;

          function_escape('description_',description);
          function_escape('name_',name);

          var description_final = document.getElementById('description_').value;
          var name_final = document.getElementById('name_').value;

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


          if(description=='' || name=='')
          {
            alert('Fill up all fields to continue');
          }
          else if(data=='')
          {
            alert('Select atleast one field to continue');
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
                          location.reload();
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/applicant_interview_result_report/update_crystal_report/"+name_final+"/"+description_final+"/"+data+"/"+crystal_id,true);
              xmlhttp.send();
          }
       }

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
                          document.getElementById("all_action").innerHTML=xmlhttp.responseText;
                          $("#generate_report_table").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/applicant_interview_result_report/generate_report/",true);
              xmlhttp.send();
        }

        function daterange()
        {
           if(document.getElementById('daterangechecker').checked==true)
           {
              document.getElementById('daterange').value=1;
              document.getElementById('date_from').disabled=true;
              document.getElementById('date_to').disabled=true;
           }
           else
           {
              document.getElementById('daterange').value=0;
              document.getElementById('date_from').disabled=false;
              document.getElementById('date_to').disabled=false;
           } 
        }


        function filter_result()
        {
          var daterange = document.getElementById('daterange').value;
          if(daterange==1)
          {
            var from = 'All';
            var to = 'All';
          }
          else
          {
            var from = document.getElementById('date_from').value;
            var to = document.getElementById('date_to').value;
          }

          var position = document.getElementById('position').value;
          var proc= document.getElementById('process').value;
          var result = document.getElementById('result').value;
          var crystal_report = document.getElementById('crystal_report').value;

          if(from=='' || to=='' || position=='' || proc=='' || result=='' || crystal_report=='')
          {
            alert('Fill all fields to continue');
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
                          document.getElementById("generate_results").innerHTML=xmlhttp.responseText;
                          $("#generate_report_table").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/applicant_interview_result_report/filter_result/"+from+"/"+to+"/"+position+"/"+proc+"/"+result+"/"+crystal_report,true);
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
  <!--END ajaxX FUNCTIONS-->
