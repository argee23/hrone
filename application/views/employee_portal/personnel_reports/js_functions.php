<script type="text/javascript">
 

function view_crystal_report(type,option)
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
                document.getElementById("main_res").innerHTML=xmlhttp.responseText;
                 $("#p_crystal_report").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/view_crystal_report/"+type+"/"+option,true);
            xmlhttp.send();
 }

 function addform_crystal_report(type)
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
                document.getElementById("main_res").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/addform_crystal_report/"+type,true);
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

 function save_crystal_reports(action,type,id)
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
                document.getElementById("main_res").innerHTML=xmlhttp.responseText;
                 $("#p_crystal_report").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/save_crystal_reports/"+type+"/"+name+"/"+desc+"/"+data+"/"+action+"/"+id,true);
            xmlhttp.send();
    }
 }

 function del_stat_crystal_report(option,id,type)
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
              document.getElementById("main_res").innerHTML=xmlhttp.responseText;
               $("#p_crystal_report").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
             xmlhttp.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/del_stat_crystal_report/"+option+"/"+id+"/"+type,true);
            xmlhttp.send();
      }
 }
 function editform_crystal_report(id,type,action)
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
                document.getElementById("main_res").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/editform_crystal_report/"+id+"/"+type+"/"+action,true);
            xmlhttp.send();
  }
  function view_pao_generate_reports(type)
  {
    var overtime_filing_type = document.getElementById('overtime_filing_type').value;
    $("#filter_report").show();
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
                  document.getElementById("main_res").innerHTML=xmlhttp.responseText;
                }
              }
        if(overtime_filing_type==1){ xmlhttp.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/view_generate_reports_general/"+type,true);
         }
        else{ xmlhttp.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/view_generate_reports_group/"+type,true);
         }
        xmlhttp.send();
  }

  function pao_generate_filter(type)
  {
    if(type=='single')
    {
     
      $("#date_range").hide();
      $("#"+type).show();
    }
    else if(type=='date_range')
    {
     
      $("#single").hide();
      $("#"+type).show();
    }
    else{}
  }

  function get_year(option,id,val1,val2,val3)
    {

      if(option=='Year') { var value1 = val1; } else{ var value1 = document.getElementById('group').value; }
      if(option=='Day') { var value2 = document.getElementById('year').value; } else{ var value2 = val2; }
      var overtime_filing_type = document.getElementById('overtime_filing_type').value;

      var type_option = document.getElementById('type_option').value;

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
                    document.getElementById(id).innerHTML=xmlhttp2.responseText;
                     
                    }
                  }
                xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/get_dates/"+option+"/"+value1+"/"+value2+"/"+val3+"/"+type_option,false);
                xmlhttp2.send();
    }

    function view_generate_report_single_field()
    {
      var filter = document.getElementById('filter').value;
      var group = document.getElementById('group').value;
      var year = document.getElementById('year').value;
      var month = document.getElementById('month').value;
      var day = document.getElementById('day').value;
      var report = document.getElementById('report').value;
      var option = document.getElementById('option').value;
      var overtime_filing_type = document.getElementById('overtime_filing_type').value;

      var employees         =   document.getElementById('res_employees').value;
      var employees_id      =   document.getElementById('res_employeeid').value;
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
       } 

       else
       {
           
            r_employeeid = 'all';
            r_section =  section;
            r_subsection = subsection;
            r_location =  loc;
            r_classification =  classs;
            r_employment =  empp;
       }

      if(filter=='' || year=='' || month=='' || day=='' || report=='' || group=='' || option=='' ||  r_employeeid=='' || r_section=='' || r_subsection=='' || r_location=='' || r_classification=='' || r_employment=='')
      {
        alert('Please fill up all fields to continue.');
        
      }
      else
      {
        var type =document.getElementById('type_option').value;
         if(type=='approved_ot'){ var title = "Approved Overtime"; } else{  var title = "Pre-Approved Overtime"; }
                
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
                    document.getElementById('overtime_forms_report_result').innerHTML=xmlhttp2.responseText;
                    $("#table_p_ot").DataTable({
                        "dom": '<"top">Bfrt<"bottom"li><"clear">',
                       "pageLength":-1,
                        lengthMenu: [[10, 25, 50, 100,-1], [10, 25, 50, 100, "All"]],
                        buttons:
                        [
                          {
                            extend: 'excel',
                            title: title
                          },
                          {
                            extend: 'print',
                            title: title
                          }
                        ]          
                                       
                        });
                    }
                  }
                xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/view_generate_report_single_field/"+type+"/"+filter+"/"+year+"/"+month+"/"+day+"/"+report+"/"+group+"/"+option+"/"+overtime_filing_type+"/"+employees+"/"+r_employeeid+"/"+r_section+"/"+r_subsection+"/"+r_location+"/"+r_classification +"/"+r_employment,false);
                xmlhttp2.send();
                
      }
    } 

    function view_generate_report_date_range()
    {
      var filter = document.getElementById('filter').value;
      var group = document.getElementById('groupdr').value;
      var from = document.getElementById('date_fromdr').value;
      var to = document.getElementById('date_todr').value;
      var report = document.getElementById('report').value;
      var option = document.getElementById('optiondr').value;
      var overtime_filing_type = document.getElementById('overtime_filing_type').value;

      var employees         =   document.getElementById('res_employees').value;
      var employees_id      =   document.getElementById('res_employeeid').value;
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
       } 

       else
       {
           
            r_employeeid = 'all';
            r_section =  section;
            r_subsection = subsection;
            r_location =  loc;
            r_classification =  classs;
            r_employment =  empp;
       }


            
      if(filter=='' || from=='' || to==''  || report=='' || group=='' || option=='' || r_employeeid=='' || r_section=='' || r_subsection=='' || r_location=='' || r_classification=='' || r_employment=='')
      {
        alert('Please fill up all fields to continue.');
        
      }
      else
      {
          
            if(from > to){ alert('Date to must greater than from to.'); }
            else{
                  var type =document.getElementById('type_option').value;
                  if(type=='approved_ot'){ var title = "Approved Overtime"; } else{  var title = "Pre-Approved Overtime"; }
                
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
                                  document.getElementById('overtime_forms_report_result').innerHTML=xmlhttp2.responseText;
                                   $("#table_p_ot").DataTable({
                                      "dom": '<"top">Bfrt<"bottom"li><"clear">',
                                           "pageLength":-1,
                                            lengthMenu: [[10, 25, 50, 100,-1], [10, 25, 50, 100, "All"]],
                                            buttons:
                                            [
                                              {
                                                extend: 'excel',
                                                title: title
                                              },
                                              {
                                                extend: 'print',
                                                title: title
                                              }
                                            ]                   
                                      });
                                  }
                                }
                     xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/view_generate_report_date_range/"+type+"/"+filter+"/"+from+"/"+to+"/"+report+"/"+group+"/"+option+"/"+overtime_filing_type+"/"+employees+"/"+r_employeeid+"/"+r_section+"/"+r_subsection+"/"+r_location+"/"+r_classification+"/"+r_employment,false);
                     xmlhttp2.send();
                
            }
      }
    } 


    function close_filtering(id)
    {
       $("#" + id).hide();
    }

    
    function show_report_field(val,id)
    {
       $("#"+id).show();
    }

    function show_crystalreport_details(id,type,action)
    {
      var idd = document.getElementById(id).value;
      editform_crystal_report(idd,type,action);
    }

    //for forms reports

    function view_fr_generate_reports(type)
    {
          $("#filter_report").show();
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
                        document.getElementById("main_res").innerHTML=xmlhttp.responseText;
                      }
                    }
             xmlhttp.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/view_fr_generate_reports/"+type,true);
              xmlhttp.send();
    }

    function fr_generate_filter(val)
    {
      if(val=='')
      {
        alert("Please select valid filtering type to continue");
      }
      else if(val=='single')
      {
         $("#filtering_r").show();
      }
    }

    function view_employees_action(option)
    {
      if(option=='individual')
      {
        $("#for_individual").show();
        $("#for_all_sec").hide();
        $("#for_all_sub").hide();
        $("#for_all_loc").hide();
        $("#for_all_class").hide();
        $("#for_all_emp").hide();
      }
      else
      {
        $("#for_individual").hide();
        $("#for_all_sec").show();
        $("#for_all_sub").show();
        $("#for_all_loc").show();
        $("#for_all_class").show();
         $("#for_all_emp").show();
      }
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


    //list of search employees
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
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/search_employee_list/"+val,true);
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
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/get_subsection/"+section,true);
        xmlhttp.send();
      }
    }

    function fr_generate_report()
    { 

      var employees         =   document.getElementById('res_employees').value;
      var employees_id      =   document.getElementById('res_employeeid').value;
      var crystal_report    =   document.getElementById('res_report').value;
      var transactions      =   document.getElementById('res_transactions').value;
      var status            =   document.getElementById('res_status').value;
      var date_from         =   document.getElementById('res_datefrom').value;
      var date_to           =   document.getElementById('res_dateto').value;
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
                

       
      if(employees=='All')
      {
          if(crystal_report=='' || transactions=='' || status=='' || date_from=='' || date_to=='' || section=='' || subsection=='' || loc=='' || classs=='')
          {
            alert("Please fill up all fields to continue");
            
          }
          else
          {
                generate_report_forms(employees,crystal_report,transactions,status,date_from,date_to,section,subsection,loc,classs,empp,'All');
          }
      }
      else if(employees=='individual')
      {
          if(crystal_report=='' || transactions=='' || status=='' || date_from=='' || date_to=='' || employees_id=='')
          {
            alert("Please fill up all fields to continue");
          }
          else
          {
              generate_report_forms(employees,crystal_report,transactions,status,date_from,date_to,'individual','individual','individual','individual','individual',employees_id);
          }
      }
      else
      {
          alert("Please fill up all fields to continue");
      }


    }

    function generate_report_forms(employees,crystal_report,transactions,status,date_from,date_to,section,subsection,loc,classs,empp,employees_id)
    {   
          $("#filtering_rf_").hide();
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
              $("#table_p_ot").DataTable({
                       "dom": '<"top">Bfrt<"bottom"li><"clear">',
                       "pageLength":-1,
                        lengthMenu: [[10, 25, 50, 100,-1], [10, 25, 50, 100, "All"]],
                        buttons:
                        [
                          {
                            extend: 'excel',
                            title: 'Forms Report'
                          },
                          {
                            extend: 'print',
                            title: 'Forms Report'
                          }
                        ]          
                        });
              $("#table_p_ot_all").DataTable({
                          "dom": '<"top">Bfrt<"bottom"li><"clear">',
                          "pageLength":-1,
                          lengthMenu: [[10, 25, 50, 100,-1], [10, 25, 50, 100, "All"]],
                          buttons:
                          [
                            {
                              extend: 'excel',
                              title: 'Forms Report'
                            },
                            {
                              extend: 'print',
                              title: 'Forms Report'
                            }
                          ]              
                        });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/generate_report_forms/"+employees+"/"+crystal_report+"/"+transactions+"/"+status+"/"+date_from+"/"+date_to+"/"+section+"/"+subsection+"/"+loc+"/"+classs+"/"+empp+"/"+employees_id,true);
        xmlhttp.send();
      
    }

    function view_filtering_fr()
    {
       $("#filtering_rf_").show();
        $("html, body").animate({ scrollTop: 0 }, "slow");
                return false;
    }


    //for working schedule reports

    function view_schedule_generate_reports(type)
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
                  document.getElementById("main_res").innerHTML=xmlhttp.responseText;
                }
              }
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/view_schedule_generate_reports/"+type,true);
        xmlhttp.send();

    }

    function ws_generate_report()
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
      
      working_schedule_generate_report(employees,crystal_report,date_from,date_to,r_employeeid,r_section,r_subsection,r_location,r_classification,r_employment,r_group,r_option);
    }
    function working_schedule_generate_report(employees,crystal_report,date_from,date_to,employees_id,section,subsection,loc,classs,emppp,group,option)
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
                              lengthMenu: [[10, 25, 50, 100,-1], [10, 25, 50, 100, "All"]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Forms Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Forms Report'
                                }
                              ]              
                            });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/working_schedule_generate_report/"+employees+"/"+crystal_report+"/"+date_from+"/"+date_to+"/"+section+"/"+subsection+"/"+loc+"/"+classs+"/"+emppp+"/"+employees_id+"/"+group+"/"+option,true);
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
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/personnel_reports/get_crystal_report_fields/"+value+"/"+option,true);
        xmlhttp.send();
    }
</script>