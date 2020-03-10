<script>
    $('#calendar').fullCalendar({
      editable: false,
      async : false,
      height: 550,
      fixedWeekCount: false,

    
    });

    //start of payroll period locking

    function lock_plotting()
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
               $("#table_lockplotting").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/lock_plotting/",true);
          xmlhttp.send();
      }
    function get_payroll_period(company,group)
    {
      if(group=='none')  
        {   var c = company;  var g = 'none';  }
      else
        {
          var c = document.getElementById('lock_company').value;
          var g = group;
        }

        if(company=='none')
        { 
          alert("Please select valid company to continue");
          document.getElementById('pp_group').disabled=true;
        } 
        else{
          document.getElementById('pp_group').disabled=false;
          if(group=='none') { get_group_list(company); var xmlhttp; } else{}
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
              document.getElementById("lock_pp").innerHTML=xmlhttp.responseText;
               $("#table_lockplotting").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/get_payroll_period/"+c+"/"+g,true);
          xmlhttp.send();
        }
    }

    function get_group_list(company)
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
              document.getElementById("pp_group").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/get_group_list/"+company,true);
          xmlhttp.send();
    }

    function IsLock(val,id,ppdate)
    {
      var company = document.getElementById('lock_company').value;
      var group = document.getElementById('pp_group').value;
      if(val==0){ var msg = 'Are you sure you want to unlock ' + ppdate + ' Payroll Period?'; }
      else{ var msg= 'Are you sure you want to lock ' + ppdate + ' Payroll Period?'; }
      
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
              document.getElementById("lock_pp").innerHTML=xmlhttp.responseText;
               $("#table_lockplotting").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
               setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/IsLock/"+val+"/"+id+"/"+company+"/"+group,true);
          xmlhttp.send();
        }
    }
    //end of payroll period locking


    //start of creating group by admin

    function group_by_admin()
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
              document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
               $("#table_grp_admin").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/group_by_admin/",true);
          xmlhttp.send();
    }

    function display_action(option)
    {
      if(option=='add')
      {
          $("#create_admin_action_add").show();
          $("#create_admin_action_filter").hide();
          $("#edit_admin_action_filter").hide();
          
      }
      else
      {
          $("#create_admin_action_add").hide();
          $("#create_admin_action_filter").show();
          $("#edit_admin_action_filter").hide();
          
      }
    }

    function save_admin_group()
    {
      var idd='add';
      var company = document.getElementById('grp_admin_company').value;
      var grp_name = document.getElementById('grp_admin_grpname').value;
      function_escape('grpname',grp_name);
      var grp_desc = document.getElementById('grp_admin_grpdesc').value;
      function_escape('grpdesc',grp_desc);

      var gname = document.getElementById('grpname').value;
      var gdesc = document.getElementById('grpdesc').value;

      document.getElementById('grp_admin_company').value="none";
      document.getElementById('grp_admin_grpname').value="";
      document.getElementById('grp_admin_grpdesc').value="";

      if(company=='none' || grp_name=='' || grp_desc==''){ alert("Please fill up all fields to continue"); }
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
              document.getElementById("view_grp_by_admin").innerHTML=xmlhttp.responseText;
               $("#table_grp_admin").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/save_admin_group/"+company+"/"+gname+"/"+gdesc+"/"+idd,true);
          xmlhttp.send();
        }
    }
    function update_admin_group(idd)
    {
      var company = document.getElementById('editt_grp_admin_company').value;
      var grp_name = document.getElementById('edit_grp_admin_grpname').value;
      function_escape('edit_grpname',grp_name);
      var grp_desc = document.getElementById('edit_grp_admin_grpdesc').value;
      function_escape('edit_grpdesc',grp_desc);

      var gname = document.getElementById('edit_grpname').value;
      var gdesc = document.getElementById('edit_grpdesc').value;

      $("#edit_admin_action_filter").hide();

      
      if(company=='' || grp_name=='' || grp_desc==''){ alert("Please fill up all fields to continue"); }
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
              document.getElementById("view_grp_by_admin").innerHTML=xmlhttp.responseText;
               $("#table_grp_admin").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/save_admin_group/"+company+"/"+gname+"/"+gdesc+"/"+idd,true);
          xmlhttp.send();
        }
    }
    function view_group_filter(company)
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
              document.getElementById("view_grp_by_admin").innerHTML=xmlhttp.responseText;
               $("#table_grp_admin").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/view_group_filter/"+company,true);
          xmlhttp.send();
    }

    function edit_grp_admin(option,id)
    {
       $("#create_admin_action_add").hide();
       $("#create_admin_action_filter").hide();
       $("#edit_admin_action_filter").show();
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
              document.getElementById(option).innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/edit_grp_admin/"+id,true);
          xmlhttp.send();

    }
    function edd_group(option,id)
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
              document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
               $("#table_grp_admin").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
            xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/edd_group/"+option+"/"+id,true);
            xmlhttp.send();
      }
    }
    //end of creating group by admin

    //individual plotting 
    function individual_plotting()
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
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/individual_plotting/",true);
          xmlhttp.send();
    }

    function get_ip_location(company)
    {
      document.getElementById('ip_name').value="";
      document.getElementById('ip_employee_id').value="";
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
              document.getElementById("ip_location").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/get_ip_location/"+company,true);
          xmlhttp.send();
    }
    function ip_employee_list(val)
    {
      var company = document.getElementById('ip_company').value;
      var location = document.getElementById('ip_location').value;
      var search = '-'+val;
      if(company=='none' || location=='none'){ alert("Please fill up all fields to continue"); }
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
              document.getElementById("Search_Employee_Result").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/ip_employee_list/"+company+"/"+location+"/"+search,true);
          xmlhttp.send();
      }
    }
    function ip_select_emp(employee_id,name)
    {
      document.getElementById('ip_name').value=name;
      document.getElementById('ip_employee_id').value=employee_id;
    }
    function ip_show_employee()
    {
     var company = document.getElementById('ip_company').value;
     var location = document.getElementById('ip_location').value;
     var employee_id = document.getElementById('ip_employee_id').value; 


     if(company=='none' || location=='none' || employee_id=='')
     { alert("Please fill up all fields to continue"); }
     else{
       check_with_payroll_period(employee_id,company);
       var res_a = document.getElementById('emp_pp_value').value;
        if(res_a==1)
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
                
                 $('#calendar').fullCalendar({
                
                 	header: {
  		    				left:   'prev,next today',
  		    				center: '',
  		    				right:  'title'
  						  },
                  editable: false,
                  async : false,
                  height: 400,
                  fixedWeekCount: false,
                  
                  events: '<?php echo base_url();?>app/plot_schedules/get_schedule/' + employee_id +"/"+'individual',

                  eventClick: function (calEvent, jsEvent, view) { 
                    var d = calEvent.start.format();
                    eventClick(calEvent,d,employee_id);
                    
                  },
                  dayClick: function(date, jsEvent, view) { 
                  	 datef = date.format();
                    dayClick(datef,employee_id);
                  },

                });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/ip_plot_selected_employee/"+company+"/"+location+"/"+employee_id,true);
            xmlhttp.send();
          } else{ alert("Please add payroll period group for the selected employee to continue"); }
    }
    }
    
    function check_with_payroll_period(employee_id,company)
    {
      var result = '';
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'url': '<?php echo base_url();?>app/plot_schedules/check_with_pp/',
            'data': { "employee": employee_id, "company" : company},
            'success': function (data) {
            result = data;
             
            }
        });
        document.getElementById('emp_pp_value').value=result;
    }
    function eventClick(calEvent,eventt,employee_id)
    {
        var result;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'url': '<?php echo base_url();?>app/plot_schedules/eventClick/',
            'data': { "date": eventt, "employee_id" : employee_id},
            'success': function (data) {
            	result = data;
              var final = result.replace(/\s/g, '');
              
              if(final=='"deleted"'){ 

                    $('#calendar').fullCalendar('refetchEvents','stick');
                     document.getElementById("result_act").innerHTML="<center><n class='text-danger'><b>Removed</b>!</n></center>"; 
                     setTimeout(function(){
                     document.getElementById("result_act").innerHTML="";
                     },2000);
               }
              else if(final=='"locked"')
              {
                alert('You are not allowed to remove plotted schedule if payroll period is locked.');
              }
              else{ 
                var msg = 'You are not allowed to remove the group plotted schedule .Do you want to add new working schedule?';
                 var result = confirm(msg);
                 if(result == true)
                  { 
                      dayClick(eventt,employee_id);
                  } 
                  else{}
               
                }
              
               
            }
        });

    }
    function dayClick(date,employee_id)
    { 

    	var w_sched =document.getElementById('working_sched').value;
      var company = document.getElementById('i_comp').value;
    	if(w_sched==''){ alert("Please choose working schedule to continue"); }
    	else{
       
        var restt;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'url': '<?php echo base_url();?>app/plot_schedules/dayClick/',
            'data': { "date": date, "employee_id" : employee_id ,"value" : w_sched ,"company" : company},
            'success': function (result) {
              restt = result;
              var final = result.replace(/\s/g, '');
              if(final=='"locked"'){ alert('You are not allowed to add/replot plotted schedule if payroll period is locked.'); }
              else{
            	     $('#calendar').fullCalendar('refetchEvents','stick');
            	     document.getElementById("result_act").innerHTML="<center><n class='text-danger'><b>Saved!</b>!</n></center>"; 
                     setTimeout(function(){
                     document.getElementById("result_act").innerHTML="";
                     },2000);
                }
          }
        });
      }
      
    }
     //start of viewing plotted schedules of section managers
     function view_section_mngr_group()
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
               $("#view_plotted_sm").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/view_section_mngr_group/",true);
          xmlhttp.send();
    }

    function get_section_manager(company)
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
              document.getElementById("section_mngr_grp").innerHTML=xmlhttp.responseText;
               $("#view_plotted_sm").DataTable({
                        lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/sm_section_managers/"+company,true);
          xmlhttp.send();
    }
    function view_group_list(mngr)
    {
      var company = document.getElementById('sm_company').value;
     
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
                $("#sm_mngr_group").DataTable({
                        lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/view_group_list/"+mngr+"/"+company,true);
          xmlhttp.send();
    }
    function sm_view_group_schedule(group)
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
                document.getElementById("sm_section_mngr_grp").innerHTML=xmlhttp.responseText;
                $('#sm_calendar').fullCalendar({
                    header: {
                    left:   'prev,next today',
                    center: '',
                    right:  'title'
                    },
                    editable: false,
                    async : false,
                    height: 400,
                    fixedWeekCount: false,
                    events: '<?php echo base_url();?>app/plot_schedules/get_schedule/' + group +"/"+'by_group',
                });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/sm_view_group_schedule/"+group,true);
          xmlhttp.send();
    }

    function get_emp_all_schedule(employee_id,group)
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
                document.getElementById("calendar_option").innerHTML=xmlhttp.responseText;
                
                 $('#calendar_option_employee').fullCalendar({
                
                  header: {
                  left:   'prev,next today',
                  center: '',
                  right:  'title'
                },
                  editable: false,
                  async : false,
                  height: 400,
                  fixedWeekCount: false,
                  
                  events: '<?php echo base_url();?>app/plot_schedules/get_schedule/' + employee_id +"/"+'individual',
                });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/get_emp_all_schedule/"+employee_id+"/"+group,true);
            xmlhttp.send();
   
    }
    //end of viewing plotted schedules of section managers

    //start of enrolling employees in admin created group
    function enrol_employees(group,company)
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
                $("#enroll_employee_grp").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/enrol_employees/"+group+"/"+company,true);
          xmlhttp.send();
    }

    function admin_update_members(company,group,manager)
    {
       $("#upd_members").hide();
        $("#loader").show();
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
              document.getElementById("admin_enroll_employee").innerHTML=xmlhttp.responseText;
                $("#enroll_employee_grp").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/admin_update_members/"+company+"/"+group+"/"+manager,true);
          xmlhttp.send();
    }

    function enrol_employee_action(val,emp,pp)
    {
          
          var checker_pp = document.getElementById('checker_pp').value;
          if(checker_pp=="")
          {
            document.getElementById('checker_pp').value=pp;
          }
          else if(pp==checker_pp)
          { }
          else{ 
              alert("Please add employees with the same payroll period group to continue");
              document.getElementById('c'+val).checked=false;
          }
          var i = 'c'+val;
          var ii = document.getElementById('c_'+val).value;


          if(ii=='1')
          { 
            
              var selected = document.getElementById('selected_load_emp').value;
              var res = selected.replace(emp+"-", "");
              document.getElementById('selected_load_emp').value=res;    
              document.getElementById('c_' + val).value='0';
          } 
          else
          { 
            if(pp==checker_pp || checker_pp=='')
            {
              var selected = document.getElementById('selected_load_emp').value;
              var res = selected +=emp + "-";
              document.getElementById('selected_load_emp').value=res;  
              document.getElementById('c_'+ val).value='1';
            } else{}
          }

       if(res==""){ document.getElementById('checker_pp').value=""; }
       else{}
          
    }
  
    function admin_update_members_group(group,company)
    {
      var employees =document.getElementById('selected_load_emp').value;
      if(employees==''){ alert("Please select atleast one employee to continue"); }
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
              document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                $("#enroll_employee_grp").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/admin_update_members_group/"+company+"/"+group+"/"+employees,true);
          xmlhttp.send();
      }
    }    
    function enrol_employee_ac(option,id,company,group)
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
              document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                $("#enroll_employee_grp").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/enrol_employee_ac/"+option+"/"+id+"/"+company+"/"+group,true);
          xmlhttp.send();
        }
    }
    function view_emp_selected()
    {   
         $("#t_show").show();
      var employees = document.getElementById('selected_load_emp').value;
       if(employees==''){ alert("No Employee Selected"); }
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
              document.getElementById("mmmmmm").innerHTML=xmlhttp.responseText;
                $("#selected_load_emp_table").DataTable({
                        lengthMenu: [[5,10, 25, 50, 100, -1], [5,10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/view_emp_selected_grp/"+employees,true);
          xmlhttp.send();
           $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
      }
    }
    function hide_s_emp()
    {
        $("#t_show").hide();
    }
    //end of enrolling employees in admin group

    //start of manual upload
    function manual_upload()
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
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/plot_schedules/manual_upload/",true);
          xmlhttp.send();
    }
     function myFunction() {
            alert("NOTE: If there's a downloaded file open/check it to correct the template!");
           if(document.getElementById("file").value =='' || document.getElementById("file").value ==null)
           {
            alert("Select File to continue");
           }
           if(document.getElementById("action").value =="")
           {
              alert("Select Action to continue");
           }
      }
    //end of manual upload
    //for all
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


    //calendar

   
    </script>
