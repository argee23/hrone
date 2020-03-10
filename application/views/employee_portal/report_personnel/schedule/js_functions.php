<script>
    
    // calendar schedule

    function get_schedules_result(val,option,show_opt)
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
                document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                 $("#show_opt").show('hide');
                  $('#calendar_option_employee').fullCalendar({
                    header: {
                    left:   'prev,next today',
                    center: '',
                    right:  'title',
                    },
                    editable: false,
                    async : false,
                    fixedWeekCount: false,
                    events: '<?php echo base_url();?>employee_portal/reports_personnel_schedule/schedules_result_calendar/'+val+"/"+option+"/"+show_opt,
                    eventClick: function (calEvent, jsEvent, view) { 
	                    $("#myModal2").modal('show');
	                    var d = calEvent.start.format();
	                    document.getElementById("details_date").innerHTML = "Date: "+ d;
	                    get_detailed_schedule_modal(d,val,option,show_opt);
                  	},
                  });
                
                
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/schedules_result/"+val+"/"+option+"/"+show_opt,true);
          xmlhttp.send();

    }

    function get_detailed_schedule_modal(d,val,option,show_opt)
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
                document.getElementById("schedule_details_modal").innerHTML=xmlhttp.responseText;
                $("#calendar_modal").DataTable({
                        lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]]             
                        });""
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/schedule_calendar_modal/"+d+"/"+val+"/"+option+"/"+show_opt,true);
          xmlhttp.send();
    }

    function get_detailed_individual_modal(d,employee)
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
                document.getElementById("schedule_details_modal").innerHTML=xmlhttp.responseText;
                $("#calendar_modal").DataTable({
                        lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]]             
                        });""
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/schedule_individual_calendar_modal/"+d+"/"+employee,true);
          xmlhttp.send();
    }

   function show_hide(val) 
    {

        var x = document.getElementById(val);
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function get_schedules_filter(show_opt)
    {
      var val = document.getElementById('val').value;
      var option = document.getElementById('option').value;
      if(show_opt!='' && val!='' && show_opt!='')
        { get_schedules_result(val,option,show_opt); }
      else{  alert('Invalid details'); }
    }

    function show_calendar_employment_details()
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
                document.getElementById("main_action").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/show_calendar_employment_details/",true);
          xmlhttp.send();
    }

    function get_calendar_department(company)
    {

      if(company=='All')
      {
        document.getElementById('calendar_department').value='All';
        document.getElementById('calendar_department').disabled=true; 
      }
      else
      { 

            document.getElementById('calendar_department').disabled=false; 

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
                  document.getElementById("calendar_department").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/calendar_department/"+company,true);
            xmlhttp.send();
      }
    }

    function get_calendar_section(department)
    {
      var company = document.getElementById('calendar_company').value;
      if(department=='All')
      {
          var section = document.getElementById('calendar_section').value;
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
                  document.getElementById("calendar_section").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/calendar_section/"+company+"/"+department,true);
            xmlhttp.send();
      }
    }

    function calendar_individual_report(roption)
    {
        $("#myModal2").modal('show');
        document.getElementById("details_date").innerHTML = "<center>View Individual Schedule</center>";
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
                document.getElementById("schedule_details_modal").innerHTML=xmlhttp.responseText;
                $("#employee_list").DataTable({
                        lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/calendar_individual_employees/"+roption,true);
          xmlhttp.send();
    }

    function calendar_individual_sched(employee,name)
    {
      $("#schedule_details_modal").load(location.href + " #schedule_details_modal");
      document.getElementById('employee_name').value=name;
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
                document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                  $('#calendar_option_employee').fullCalendar({
                    header: {
                    left:   'prev,next today',
                    center: '',
                    right:  'title',
                    },
                    editable: false,
                    async : false,
                    fixedWeekCount: false,
                    events: '<?php echo base_url();?>employee_portal/reports_personnel_schedule/calendar_individual_sched/'+employee,
                    eventClick: function (calEvent, jsEvent, view) { 
                      var title = calEvent.title;
                      $("#myModal2").modal('show');
                      var d = calEvent.start.format();
                      document.getElementById("details_date").innerHTML = "<n class='text-danger'><center>Date: "+ d+ "<br> Name: "+ name + "["+employee+"]<br>Schedule: "+ title +" </center></n>";
                      get_detailed_individual_modal(d,employee);
                    },
                  });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/schedules_individual_result/"+employee,true);
          xmlhttp.send();
    }


    //excel report

    function excel_report_payroll_period()
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
              document.getElementById("main_action").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/excel_report_payroll_period/",true);
          xmlhttp.send();
    }
    function get_field(field,id)
    {
        var count= document.getElementById("count").value;
        var checks = document.getElementsByClassName("field_checker");
        var data ='';

        for (i=0;i < count; i++)
          {
            if (checks[i].checked === true)
              {
                data +=checks[i].value + "-";
                      
               }
          }

        document.getElementById('final_report').value=data;
    }
    function get_excel_manual_ws_get_group(paytype)
    { 

         var company = document.getElementById('company').value;
         
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
              document.getElementById("group").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/excel_group/"+paytype+"/"+company,true);
          xmlhttp.send();
    }


    function get_excel_payroll_period(group)
    {
          var company = document.getElementById('company').value;
          var paytype = document.getElementById('paytype').value;

         
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
              document.getElementById("payroll_period").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/excel_payroll_period/"+paytype+"/"+company+"/"+group,true);
          xmlhttp.send();
    }
    

    //start excel with crystal report

    function crystal_report_view()
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
                    document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                     $("#crystal_report").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/crystal_report_view/",true);
                xmlhttp.send();
     }

     function crystal_report_add()
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
                    document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                    }
                  }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/crystal_report_add/",true);
          xmlhttp.send();
     }

     function reset()
     {
        var count= document.getElementById("crystal_fields").value;
        var checks = document.getElementsByClassName("option_check");
        var data=document.getElementById('ccc').value;
        if(data == '0'){ res = true; document.getElementById('ccc').value='1'; } 
        else{ res = false;  document.getElementById('ccc').value='0'; }
        for (i=0;i < count; i++)
        {
           document.getElementById("r_" + i).checked=res;
        }     
     }

    function save_crystal_reports(action,id)
     {

        var report_name = document.getElementById('report_name').value;
        function_escape('name',report_name);
        var name = document.getElementById('name').value;
        var report_desc = document.getElementById('report_desc').value;
        function_escape('desc',report_desc);
        var desc = 'mimi'+document.getElementById('desc').value;

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
                    document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                     $("#crystal_report").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/crystal_reports_saveadd/"+name+"/"+desc+"/"+data+"/"+action+"/"+id,true);
                xmlhttp.send();
        }
     }

     function del_stat_crystal_report(option,id)
     {

      if(option=='delete'){ msg = 'Are you sure you want to delete ID -' + id; }
          else if(option=='enabled') { msg = 'Are you sure you want to enabled ID -' + id;}
          else if(option=='disabled'){ msg = 'Are you sure you want to disabled ID -' + id; }
          else{ msg =''; }
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
                  document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                   $("#crystal_report").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                  }
                }
                 xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/crystal_report_del_stat/"+option+"/"+id,true);
                xmlhttp.send();
          }
     }

     function editform_crystal_report(id,action)
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
                    document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/crystal_report_fields/"+id+"/"+action,true);
                xmlhttp.send();
      }


    function crystal_report_generate_reports()
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
                  document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                }
              }
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/crystal_report_generate_reports/",true);
        xmlhttp.send();
    } 


    function get_crystal_report_fields(id,value,option)
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
            document.getElementById(id).innerHTML=xmlhttp.responseText;
             
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/get_crystal_report_fields/"+value+"/"+option,true);
        xmlhttp.send();
    }

    function view_employees_action_ws(option)
    {
      if(option=='individual')
      {
        $("#for_individual").show();
        $("#for_all_sec").hide();
        $("#for_all_sub").hide();
        $("#for_all_loc").hide();
        $("#for_all_class").hide();
        $("#for_all_emp").hide();
        $("#for_group").hide();
      }
      else if(option=='All')
      {
        $("#for_individual").hide();
        $("#for_all_sec").show();
        $("#for_all_sub").show();
        $("#for_all_loc").show();
        $("#for_all_class").show();
        $("#for_all_emp").show();
        $("#for_group").hide();
      }
      else
      {
        $("#for_individual").hide();
        $("#for_all_sec").hide();
        $("#for_all_sub").hide();
        $("#for_all_loc").hide();
        $("#for_all_class").hide();
        $("#for_all_emp").hide();
        $("#for_group").show();
      }
    }

     function employee_list(val)
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
            document.getElementById("Search_Employee_Result").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/search_employee_list/"+val,true);
        xmlhttp.send();
    

    }

    function select_emp(id,name)
    {

      document.getElementById("res_employeeid").value = id;
      document.getElementById("search_employee").value = name; 

    }


    function get_subsection(section)
    {
      if(section=='')
        { alert("Please select valid section to continue."); }
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
            document.getElementById("res_subsection").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/get_subsection/"+section,true);
        xmlhttp.send();
      }
    }


     function crystal_report_generate_report()
    {

      var employees         =   document.getElementById('res_employees').value;
      var employees_id      =   document.getElementById('res_employeeid').value;
      var crystal_report    =   document.getElementById('res_report').value;
      
      var date_from         =   document.getElementById('res_datefrom').value;
      var date_to           =   document.getElementById('res_dateto').value;

      var group             =   document.getElementById('sm_group').value;
      var option            =   document.getElementById('sm_option').value;

      var section           =   document.getElementById('res_section').value;
      var subsection        =   document.getElementById('res_subsection').value;
     
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


      if(employees=='individual')
       {
            r_employeeid = employees_id;
            r_section =  'individual';
            r_subsection = 'individual';
            r_location =  'individual';
            r_classification =  'individual';
            r_employment =  'individual';
            r_group =  'individual';
            r_option =  'individual';
       } 

       else if(employees=='All')
       {
           
            r_employeeid = 'all';
            r_group =  'all';
            r_option =  'all';
            r_section =  section;
            r_subsection = subsection;
            r_location =  loc;
            r_classification =  classs;
            r_employment =  empp;
       }
       else
       {
            r_employeeid = 'group';
            r_section =  'group';
            r_subsection = 'group';
            r_location =  'group';
            r_classification =  'group';
            r_employment =  'group';
            r_group =  group;
            r_option =  option;
       }
      
      crystal_report_generate_report_result(employees,crystal_report,date_from,date_to,r_employeeid,r_section,r_subsection,r_location,r_classification,r_employment,r_group,r_option);
    }
    function crystal_report_generate_report_result(employees,crystal_report,date_from,date_to,employees_id,section,subsection,loc,classs,emppp,group,option)
    {
      
      if(employees=='' || crystal_report=='' || date_from=='' || date_to=='' || employees_id=='' || section=='' || subsection=='' || loc=='' || classs=='' || emppp=='' || group=='' || option=='')
      {
        alert('Please fill up all fields to continue.');
        
      }
      else
      {
        if(date_from > date_to)
        {
            alert("Date from must be greater than date to");
        }
        else{
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
                document.getElementById("forms_report_result").innerHTML=xmlhttp.responseText;
                 
                              $("#table_p_ot_all").DataTable({
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
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/crystal_report_generate_report_result/"+employees+"/"+crystal_report+"/"+date_from+"/"+date_to+"/"+section+"/"+subsection+"/"+loc+"/"+classs+"/"+emppp+"/"+employees_id+"/"+group+"/"+option,true);
            xmlhttp.send();
          }
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
    //end excel with crystal report



    //start of excel report section manager

    function excel_report_sectionmngr(section_mngr)
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
                  document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                }
              }
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/excel_report_sectionmngr/"+section_mngr,true);
        xmlhttp.send();
    }

    function excel_report_department(department)
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
                  document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                }
              }
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/excel_report_department/"+department,true);
        xmlhttp.send();
    }



    //crystal report

     function crystal_report_generate_date_range()
     {
               $("#show_opt").hide();
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
                            document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                          }
                        }
                xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/date_range_report/",true);
                xmlhttp.send();
     }

     function crystal_report_generate_payroll_period()
     {
               $("#show_opt").hide();
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
                            document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                          }
                        }
                xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/crystal_report_generate_payroll_period/",true);
                xmlhttp.send();
     }


    function pp_get_paytypegroup()
   {  
      var company  = document.getElementById('company').value;
      var pay_type = document.getElementById('paytype').value;

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
                          document.getElementById("paytypegroup").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/pp_get_paytype_group/"+company+"/"+pay_type,true);
              xmlhttp.send();

   }


   function pp_get_payroll_period(group)
   {
      var company  = document.getElementById('company').value;
      var pay_type = document.getElementById('paytype').value;

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
                          document.getElementById("payrollperiod").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/pp_get_payroll_period/"+company+"/"+pay_type+"/"+group,true);
              xmlhttp.send();

   }


   
   function crystal_report_generate_employment()
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
                          document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/employment_report/",true);
              xmlhttp.send();
   }

   function emp_get_department(value)
   {
    if(value=='All')
    {
        document.getElementById('company').value="All";
        document.getElementById('department').value="All";
        document.getElementById('section').value="All";
        document.getElementById('classification').value="All";
        document.getElementById('location').value="All";



        document.getElementById('department').disabled=true;
        document.getElementById('section').disabled=true;
        document.getElementById('classification').disabled=true;
        document.getElementById('location').disabled=true;
    }
    else
    {
        document.getElementById('department').disabled=false;
        document.getElementById('classification').disabled=false;
        document.getElementById('location').disabled=false;

        get_department(value);
        get_location(value);
        get_classification(value);
    }
   }


  function get_classification(company)
  {
    var xmlhttp;
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
                          document.getElementById("classification").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/get_classification/"+company,true);
              xmlhttp.send();
  }


  function get_location(company)
  {
    var xmlhttp;
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
                          document.getElementById("location").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/get_location/"+company,true);
              xmlhttp.send();
  }

  function get_department(company)
  {
     var xmlhttp;
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
                          document.getElementById("department").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/get_department/"+company,true);
              xmlhttp.send();
  }

  function emp_get_section(department)
  {
    if(department=='All')
    {
      document.getElementById('section').value='All';
      document.getElementById('section').disabled=true;
    }
    else {
      var company  = document.getElementById('company').value;
      document.getElementById('section').disabled=false;
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
                          document.getElementById("section").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_schedule/emp_get_section/"+company+"/"+department,true);
              xmlhttp.send();
    }
  }

     
    //end
    </script>
    