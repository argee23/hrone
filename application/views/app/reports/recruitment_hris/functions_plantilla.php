<script type="text/javascript">
  
     function crystal_report_settings(code)
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
                document.getElementById("main_result").innerHTML=xmlhttp2.responseText;
                $("#crystal_report_table").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/crystal_report_settings/"+code,false);
          xmlhttp2.send();
      }

      function add_crystal_report(code)
      {
          var code_type = document.getElementById('code_type').value;
          if(code_type==''){ alert("Fill jup all fields to continue"); }
          else
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
                  document.getElementById("action_here_div").innerHTML=xmlhttp2.responseText;
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/add_crystal_report/"+code+"/"+code_type,false);
            xmlhttp2.send();
          }
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


      function save_crystal_report(code,code_type)
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
              xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitments_hris/save_crystal_report/"+code+"/"+code_type+"/"+name_final+"/"+description_final+"/"+data,true);
              xmlhttp.send();
          }
       }

       function stat_crystal_report(action,id,type,code)
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
                                document.getElementById("action_here_div").innerHTML=xmlhttp.responseText;
                              }
                            else
                              {
                                location.reload();
                              }
                        }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitments_hris/stat_crystal_report/"+action+"/"+id+"/"+type+"/"+code,true);
                xmlhttp.send();
          }

          }

        function edit_crystal_report(action,id,type,code)
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
                        document.getElementById("action_here_div").innerHTML=xmlhttp.responseText;
                    }
            xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitments_hris/edit_crystal_report/"+action+"/"+id+"/"+type+"/"+code,true);
            xmlhttp.send();
        }


        function update_crystal_report(code,code_type,crystal_id)
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
              xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitments_hris/update_crystal_report/"+code+"/"+code_type+"/"+name_final+"/"+description_final+"/"+data+"/"+crystal_id,true);
              xmlhttp.send();
          }
        }


        function generate_report_filtering(code)
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
                  document.getElementById("main_result").innerHTML=xmlhttp2.responseText;
                  $("#generate_report_table").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/generate_report_settings/"+code,false);
            xmlhttp2.send();
        }

        function get_crystal_report(val)
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
                  document.getElementById("crystal_report").innerHTML=xmlhttp2.responseText;
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/get_crystal_report/"+val,false);
            xmlhttp2.send();
        }

        function generate_report_settings_results(code)
        {
          var crystal_report = document.getElementById('crystal_report').value;
          var code_type = document.getElementById('setting_code_type').value; 
          var company_id = document.getElementById('company_id').value; 

          if(crystal_report=='' || code_type=='' || company_id=='')
          {
            alert("Fill up all fields to continue");
          }
          else
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
                  document.getElementById("generate_reports").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
                                "dom": '<"top">Bfrt<"bottom"li><"clear">',
                                "pageLength":-1,
                                lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                                buttons:
                                [
                                  {
                                    extend: 'excel',
                                    title: 'Settings Report'
                                  },
                                  {
                                    extend: 'print',
                                    title: 'Settings Report'
                                  }
                                ]              
                              });
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/generate_report_settings_results/"+code+"/"+crystal_report+"/"+code_type+"/"+company_id,false);
            xmlhttp2.send();

          }
      }

      //job vacancies

      function job_vacancies_filtering(val)
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
                document.getElementById("filteringjobvacancies").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/job_vacancies_filtering/"+val,false);
          xmlhttp2.send();

      }



      //job vacancies

      function checker_range(id,from,to)
      {

        if(document.getElementById(id).checked==true)
        {
           document.getElementById(from).disabled=true;
           document.getElementById(to).disabled=true;
        }
        else
        {
           document.getElementById(from).disabled=false;
           document.getElementById(to).disabled=false;
        }
      }

      function vr1_get_department(company_id)
      {
          if(company_id=='All')
          {
              document.getElementById('department').value='All';
              document.getElementById('location').value='All';
              document.getElementById('plantilla').value='All';
              document.getElementById('position').value='All';

              document.getElementById('department').disabled=true;
              document.getElementById('location').disabled=true;
              document.getElementById('plantilla').disabled=true;
              document.getElementById('position').disabled=true;
          }
          else
          {
              document.getElementById('department').disabled=false;
              document.getElementById('location').disabled=false;
              document.getElementById('plantilla').disabled=false;
              document.getElementById('position').disabled=true;
              
              document.getElementById('department').value='';
              document.getElementById('location').value='';
              document.getElementById('plantilla').value='';
              document.getElementById('position').value='';

              get_department_vr1(company_id);
              get_location_vr1(company_id);
              get_plantilla_vr1(company_id);
          }
      }

      function get_plantilla_vr1(company_id)
      {
            var xmlhttp;
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
                  document.getElementById("plantilla").innerHTML=xmlhttp2.responseText;
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/get_plantilla/"+company_id,false);
            xmlhttp2.send();
      }

      function get_department_vr1(company_id)
      {
        var xmlhttp;
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
                  document.getElementById("department").innerHTML=xmlhttp2.responseText;
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/get_department/"+company_id,false);
            xmlhttp2.send();
      }

      function get_location_vr1(company_id)
      {
        var xmlhttp;  
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
                  document.getElementById("location").innerHTML=xmlhttp2.responseText;
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/get_location/"+company_id,false);
            xmlhttp2.send();
      }

      function vr1_department_location_plantilla()
      {
        var company_id = document.getElementById('company').value;
        var location = document.getElementById('location').value;
        var department = document.getElementById('department').value;
        var plantilla = document.getElementById('plantilla').value;

        if(location!='' && department!='' && plantilla!='')
        {
            if(location!='All' && department!='All' && plantilla!='All')
            {
                document.getElementById('position').disabled=false;
                vr1_positions(company_id,location,department,plantilla);
            }
            else
            {
                document.getElementById('position').disabled=true;
            }
        }
        else
        {
            document.getElementById('position').disabled=true;
        }
      }


      function vr1_positions(company_id,location,department,plantilla)
      {
            var xmlhttp;
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
                      document.getElementById("position").innerHTML=xmlhttp2.responseText;
                    }
                  }
                xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/get_vr1_positions/"+company_id+"/"+location+"/"+department+"/"+plantilla,false);
                xmlhttp2.send(); 
      }

      function get_cities(province)
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
                document.getElementById("city").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/get_cities/"+province,false);
          xmlhttp2.send();
      } 


      function get_results_filtering_VR1(code)
      {
        var company = document.getElementById('company').value;
        var crystal_report = document.getElementById('crystal_report').value;
        var department = document.getElementById('department').value;
        var location = document.getElementById('location').value;
        var plantilla = document.getElementById('plantilla').value;
        var status = document.getElementById('status').value;

        if(plantilla!='All' && location!='All' && department!='All')
        {
            var job_id = document.getElementById('position').value;
        }
        else
        {
          var job_id = 'All';
        }
        

        if(document.getElementById('slotrange').checked)
        {
            var slotfrom = 'All';
            var slotto = 'All';
        }
        else
        {
            var slotfrom = document.getElementById('slotrange_from').value;
            var slotto = document.getElementById('slotrange_to').value;
        }

        if(document.getElementById('salaryrange').checked)
        {
            var salaryfrom = 'All';
            var salaryto = 'All';
        }
        else
        {

            var salaryfrom = document.getElementById('salary_range_from').value;
            var salaryto = document.getElementById('salary_range_to').value;
        }

        if(document.getElementById('hiringstart').checked)
        {
            var startfrom = 'All';
            var startto = 'All';
        }
        else
        {
            var startfrom = document.getElementById('hiring_start_from').value;
            var startto = document.getElementById('hiring_start_to').value;
        }

        if(document.getElementById('hiringend').checked)
        {
            var endfrom = 'All';
            var endto = 'All';
        }
        else
        {
           var endfrom = document.getElementById('hiring_end_from').value;
           var endto = document.getElementById('hiring_end_to').value;
        }

        if(document.getElementById('locationn').checked)
        {
            var loccity = 'All';
            var locprovince = 'All';
        }
        else
        {
            var loccity = document.getElementById('city').value;
            var locprovince = document.getElementById('province').value;
        }

        if(slotfrom=='' || slotto=='' || salaryfrom=='' || salaryto=='' || startfrom=='' || startto=='' || endfrom=='' || endto=='' || loccity=='' || locprovince=='' || company=='' || status=='' || job_id=='' || department=='' || location=='' || plantilla=='' || crystal_report=='')
        {
          alert("fill up all fields");
        }
        else
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
                    document.getElementById("vr1_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Settings Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Settings Report'
                                }
                              ]              
                            });
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/get_results_filtering_VR1/"+slotfrom+"/"+slotto+"/"+salaryfrom+"/"+salaryto+"/"+startfrom+"/"+startto+"/"+endfrom+"/"+endto+"/"+loccity+"/"+locprovince+"/"+company+"/"+status+"/"+job_id+"/"+department+"/"+location+"/"+plantilla+"/"+crystal_report+"/"+code,false);
              xmlhttp2.send();
        }


      } 


      //vacancy v2

      function get_results_filtering_VR2(code)
      {
          var company = document.getElementById('company').value;
          var crystal_report = document.getElementById('crystal_report').value;
          var department = document.getElementById('department').value;
          var location = document.getElementById('location').value;
          var plantilla = document.getElementById('plantilla').value;

          if(plantilla!='All' && location!='All' && department!='All')
          {
              var job_id = document.getElementById('position').value;
          }
          else
          {
            var job_id = 'All';
          }

          if(company=='' ||  job_id=='' || department=='' || location=='' || plantilla=='' || crystal_report=='')
          {
            alert("fill up all fields");
          }
          else
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
                    document.getElementById("vr2_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Settings Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Settings Report'
                                }
                              ]              
                            });
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/get_results_filtering_VR2/"+company+"/"+job_id+"/"+department+"/"+location+"/"+plantilla+"/"+crystal_report+"/"+code,false);
              xmlhttp2.send();
        }
      }


      function get_results_filtering_VR7(code)
      {
          var company = document.getElementById('company').value;
          var crystal_report = document.getElementById('crystal_report').value;
          var department = document.getElementById('department').value;
          var location = document.getElementById('location').value;
          var plantilla = document.getElementById('plantilla').value;
          var option = document.getElementById('option').value;
          if(plantilla!='All' && location!='All' && department!='All')
          {
              var job_id = document.getElementById('position').value;
          }
          else
          {
            var job_id = 'All';
          }

          if(company=='' ||  job_id=='' || department=='' || location=='' || plantilla=='' || crystal_report=='' || option=='')
          {
            alert("fill up all fields");
          }
          else
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
                    document.getElementById("vr2_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Settings Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Settings Report'
                                }
                              ]              
                            });
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/get_results_filtering_VR7/"+company+"/"+job_id+"/"+department+"/"+location+"/"+plantilla+"/"+crystal_report+"/"+option+"/"+code,false);
              xmlhttp2.send();
        }
      }




      function get_results_filtering_VR8(code)
      {
          var company = document.getElementById('company').value;
          var crystal_report = document.getElementById('crystal_report').value;
          var department = document.getElementById('department').value;
          var location = document.getElementById('location').value;
          var plantilla = document.getElementById('plantilla').value;
          var option = document.getElementById('option').value;
          if(plantilla!='All' && location!='All' && department!='All')
          {
              var job_id = document.getElementById('position').value;
          }
          else
          {
            var job_id = 'All';
          }
          

          if(company=='' ||  job_id=='' || department=='' || location=='' || plantilla=='' || crystal_report=='' || option=='')
          {
            alert("fill up all fields");
          }
          else
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
                    document.getElementById("vr2_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Settings Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Settings Report'
                                }
                              ]              
                            });
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments_hris/get_results_filtering_VR8/"+company+"/"+job_id+"/"+department+"/"+location+"/"+plantilla+"/"+crystal_report+"/"+option+"/"+code,false);
              xmlhttp2.send();
        }

      }


      //job application

   



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