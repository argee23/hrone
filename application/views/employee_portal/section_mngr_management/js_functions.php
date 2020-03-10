<script type="text/javascript">
function add_group_form()
  {
  	 var department = document.getElementById('department_list').value;
  	 var division = document.getElementById('division_list').value;
     var has_division = document.getElementById('has_division').value;
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
              document.getElementById("main_body_groups").innerHTML=xmlhttp2.responseText;
              $("#grp").DataTable({
                        lengthMenu: [[-1, 10, 25, 50, 100], ['All', 10, 25, 50, 100]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/section_mngr_management/add_group_form/"+has_division+"/"+division+"/"+department,false);
        xmlhttp2.send();
  }

  function get_subsection(section)
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
              document.getElementById("subsection_list").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/section_mngr_management/get_subsection/"+section,false);
        xmlhttp2.send();

  }

  function view_employees()
  {
    var section = document.getElementById('section_value').value;
    var subsection = document.getElementById('subsection_value').value;
 
    var department = document.getElementById('department').value;
    var division = document.getElementById('division').value;
    var has_division = document.getElementById('has_division').value;

    var loc          =   document.getElementsByClassName('location_value');
    var location_count    =   document.getElementById('location_count').value;
     
      var location='';
                for (i=0;i < location_count; i++)
                {
                  if (loc[i].checked === true)
                  {
                    location +=loc[i].value + "-";
                    
                  }
                }

    if(section=='' || subsection=='' )
    {
      alert("Please fill up all fields to continue");
    }
    else if(location=='')
    {
      alert("Please select atleast one location to continue");
    }
    else{
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
                document.getElementById("employee_list").innerHTML=xmlhttp2.responseText;
                 $("#grp").DataTable({
                        lengthMenu: [[-1, 10, 25, 50, 100], ['All', 10, 25, 50, 100]]             
                        });
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/section_mngr_management/view_employees_add/"+section+"/"+subsection+"/"+location+"/"+department+"/"+division+"/"+has_division,false);
          xmlhttp2.send();
      }
  }

  function add_emp_selected(i,employee_id)
  {
    var ii = document.getElementById('e_'+employee_id).value;
    var emp = employee_id;

    if(ii=='1')
          { 
            
              var selected = document.getElementById('selected_employee').value;
              var res = selected.replace(emp+"-", "");
              document.getElementById('selected_employee').value=res;    
              document.getElementById('e_' + employee_id).value='0';
            
          } 
    else
          { 
           
              var selected = document.getElementById('selected_employee').value;
              var res = selected +=emp + "-";
              document.getElementById('selected_employee').value=res;  
              document.getElementById('e_'+ employee_id).value='1';
           
            
          }

  }

  function save_group()
  {
     $("#updmembers").hide();
      $("#loader").show();
    var emp = document.getElementById('selected_employee').value;
    var group_ = document.getElementById('group').value;
    function_escape('group_final',group_);
    var group = document.getElementById('group_final').value;
    var section = document.getElementById('section').value;
    var subsection = document.getElementById('subsection').value;
    var department = document.getElementById('department').value;
    var division = document.getElementById('division').value;
    var has_division = document.getElementById('has_division').value;
  
    if(emp=='')
    {
      alert("Please select atleast one employee to continue");
    }
    else if(group=='')
    {
      alert("Please fill up group field to continue");
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
                location.reload();
            }
          xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/section_mngr_management/save_group/"+emp+"/"+group+"/"+section+"/"+subsection+"/"+department+"/"+division+"/"+has_division,false);
          xmlhttp2.send();
    }
  }
  function delete_group(group_id)
  {
    var has_division = document.getElementById('has_division').value;
    var department = document.getElementById('department_list').value;
    var division = document.getElementById('division_list').value;
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
   xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/section_mngr_management/delete_group_one/"+has_division+"/"+division+"/"+department+"/"+group_id,false);
   xmlhttp2.send();
  }
  else{}
    
  }
  
  function review_selected_emp(i)
  {
    var emp = document.getElementById('selected_employee').value;
    if(emp==''){ alert("No employee/s selected yet"); }
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
                  document.getElementById(i).innerHTML=xmlhttp2.responseText;
                }
              }
    
         xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/section_mngr_management/review_selected_emp/"+emp,false);
         xmlhttp2.send();
    }
  }

  function edit_group(group_id,$section,$subsection)
  {
    var has_division = document.getElementById('has_division').value;
    var department = document.getElementById('department_list').value;
    var division = document.getElementById('division_list').value;
    
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
                document.getElementById("main_body_groups").innerHTML=xmlhttp2.responseText;
                $("#grp").DataTable({
                        lengthMenu: [[-1, 10, 25, 50, 100], ['All', 10, 25, 50, 100]]             
                        });
              }
            }
   xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/section_mngr_management/edit_group_one/"+has_division+"/"+division+"/"+department+"/"+group_id,false);
   xmlhttp2.send();
  }

  function save_updated_group()
  {
    var emp = document.getElementById('selected_employee').value;
    var group_ = document.getElementById('group').value;
    function_escape('group_final',group_);
    var group = document.getElementById('group_final').value;
    var section = document.getElementById('section').value;
    var subsection = document.getElementById('subsection').value;
    var department = document.getElementById('department').value;
    var division = document.getElementById('division').value;
    var has_division = document.getElementById('has_division').value;
    var group_id = document.getElementById('group_id').value;
    
     if(emp=='')
    {
      alert("Please select atleast one employee to continue");
    }
    else if(group=='')
    {
      alert("Please fill up group field to continue");
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
               location.reload();
            }
          xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/section_mngr_management/save_updated_group/"+emp+"/"+group+"/"+section+"/"+subsection+"/"+department+"/"+division+"/"+has_division+"/"+group_id,false);
          xmlhttp2.send();
    }
  }



  function check_uncheck()
  {
    var count_class = document.getElementById('count_class').value;
    var cinput =   document.getElementsByClassName('class_input');
    var option = document.getElementById('check_uncheck').value;

    if(option==0)
    {
      document.getElementById('check_uncheck').value=1;
      document.getElementById('selected_employee').value="";
      for (i=0;i < count_class; i++)
        {
         
            cinput[i].checked = true;
            emp = cinput[i].value;

            var selected = document.getElementById('selected_employee').value;
            var res = selected +=emp + "-";
            document.getElementById('selected_employee').value=res;  
            document.getElementById('e_'+ emp).value='1';

        }
        
    }
    else
    {  
      document.getElementById('check_uncheck').value=0;
      document.getElementById('selected_employee').value="";
      for (i=0;i < count_class; i++)
        {
            cinput[i].checked = false;

        }
      document.getElementById('check_uncheck').value='0';
    }

  }


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


</script>