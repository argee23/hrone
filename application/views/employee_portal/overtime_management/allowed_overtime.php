<br><br>
<div id="app">
  <div class="col-lg-12">
      <input type="hidden" id="atro_option" value="<?php echo $option;?>">
      <h2 class="page-header">Personnel Allowed Over Time Management</h2>
        <?php 
        if($policy_main==1)
            { require_once(APPPATH.'views/employee_portal/overtime_management/general_pre_approved_for_filing.php'); }  
        else{ require_once(APPPATH.'views/employee_portal/overtime_management/group_pre_approved_for_filing.php'); } ?>
</div>

<script type="text/javascript">

  // var today = new Date().toISOString().split('T')[0];
  // document.getElementsByName("date")[0].setAttribute('min', today);

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
   $(function () {
        $('#mngr_details').DataTable({
          "pageLength":1,
          "pagingType" : "simple",
          "paging": true,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
 function get_employees(group)
 {
   var atro_option = document.getElementById('atro_option').value;
    if(group=='') { alert('Select valid group'); }
    else
      {
        var a_date = document.getElementById('date').value;
        if(a_date==null || a_date=='')
        {
          alert('Please fill up the date to continue');
          document.getElementById('group').value='';
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
                    document.getElementById("group_members").innerHTML=xmlhttp2.responseText;
                     $("#overtime").DataTable({
                              lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                              });
                    }
                  }
                xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/overtime_management/group_members/"+group+"/"+a_date+"/"+atro_option,false);
                xmlhttp2.send();
          }
      }
 }
 function get_employees_for_general(val)
 {
    var date = val.target.value;
    var group = document.getElementById('group').value;
    var atro_option = document.getElementById('atro_option').value;
    
    if(group=='') { alert('Select valid group'); }
    else
      {
        var a_date = date;
        if(a_date==null || a_date=='')
        {
          alert('Please fill up the date to continue');
          document.getElementById('group').value='general';
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
                    document.getElementById("group_members").innerHTML=xmlhttp2.responseText;
                     $("#overtime").DataTable({
                              lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                              });
                    }
                  }
                xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/overtime_management/group_members_for_general/"+group+"/"+a_date+"/"+atro_option,false);
                xmlhttp2.send();
          }
      }
      
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
    var group = document.getElementById('group').value;
    var date = document.getElementById('date').value;
    var atro_option = document.getElementById('atro_option').value;
    

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
                if(group=='general'){}
                else{ document.getElementById('group').value=''; }
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
                          document.getElementById("group_members").innerHTML=xmlhttp2.responseText;
                           $("#overtime").DataTable({
                            // destroy: true,           
                          });
                        }
                      }
                    xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/overtime_management/save_pre_approved/"+employee_result+"/"+hours+"/"+reas+"/"+count+"/"+group+"/"+date+"/"+atro_option,false);
                    xmlhttp2.send();
                  }
              
            }
            else { alert('Hours should not be less or equal to 0. Please check all red bordered input type.');  }
    }
    }

    function save_pre_approved_general()
    {
    var employee_id=document.getElementById('selected_employee').value;
    var employee_result = employee_id.substring(0, employee_id.length - 1);
    var hrs_value=document.getElementById('employee_i').value;
    var error=document.getElementById('recheck_hrs').value;
    // var group = document.getElementById('group').value;
    // var date = document.getElementById('date').value;
    // if(document.getElementById('reason').value==''){ reason ='none'; }
    // else{ reason=document.getElementById('reason').value; }
    // function_escape("reason_",reason);
    // var reas= document.getElementById("reason_").value;

    alert(employee_id);
    alert(employee_result);
    alert(hrs_value);
    // alert(error);
    // alert(group);
    // alert(date);
    // alert(reas);
    // if(employee_id=='') { alert("Please select atleast one employee to continue"); }
    // else { 
    //         if(error=='')  
    //         { 
    //           var hrs = hrs_value.substring(0, hrs_value.length - 1);
    //           var res = hrs.split("-");
    //           var count = hrs.split('-').length;
    //           hours_result = "";
    //           for(i=0;i<count;i++)
    //           {
    //               var ii = res[i];
    //               var v =document.getElementById('hrs'+ii).value;
    //               hours_result +=v + "-";
    //           }

    //           if(hours_result==''){}
    //           else
    //           { 
    //             document.getElementById('date').value='';
    //             document.getElementById('group').value='';
    //               var hours = hours_result.substring(0, hours_result.length - 1);
    //               if (window.XMLHttpRequest)
    //               {
    //                   xmlhttp2=new XMLHttpRequest();
    //                   }
    //                 else
    //                   {// code for IE6, IE5
    //                   xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
    //                   }
    //                 xmlhttp2.onreadystatechange=function()
    //                   {
    //                   if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
    //                     {
    //                       document.getElementById("app").innerHTML=xmlhttp2.responseText;
    //                        $("#overtime").DataTable({
    //                         // destroy: true,           
    //                       });
    //                     }
    //                   }
    //                 xmlhttp2.open("GET","<?php //echo base_url();?>employee_portal/overtime_management/save_pre_approved_general/"+employee_result+"/"+hours+"/"+reas+"/"+count+"/"+group+"/"+date,false);
    //                 xmlhttp2.send();
    //               }
              
    //         }
    //         else { alert('Hours should not be less or equal to 0. Please check all red bordered input type.');  }
      //}
    }


    function save_pre_approved_update()
    {
      var date = document.getElementById('date_value').value;
      var group = document.getElementById('group_value').value;
      var count = document.getElementById('upt_count').value;
      var employee = document.getElementById('employee_value').value;
       var atro_option = document.getElementById('atro_option').value;
    

      hours_result = "";
      for(i=1;i<count;i++)
     {
        var v =document.getElementById('hrs_'+i).value;
        hours_result += v + "-";
        
     }
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
                       $("#overtimes").DataTable({
                            // destroy: true,           
                          });
                    }
                  }
                xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/overtime_management/save_pre_approved_update/"+date+"/"+group+"/"+count+"/"+hours_result+"/"+employee+"/"+atro_option,false);
                xmlhttp2.send();
      
    }
    function view_filter_pre_approved(option)
    {
      var atro_option = document.getElementById('atro_option').value;
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
                    document.getElementById("filtering_").innerHTML=xmlhttp2.responseText;
                     
                    }
                  }
                xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/overtime_management/filter_all_date_preapproved/"+option+"/"+atro_option,false);
                xmlhttp2.send();

    }

    function get_year(option,id,val1,val2,val3)
    {

      if(option=='Year') { var value1 = val1; } else{ var value1 = document.getElementById('group').value; }
      if(option=='Day') { var value2 = document.getElementById('year').value; } else{ var value2 = val2; }

      var atro_option = document.getElementById('atro_option').value;
      
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
                xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/overtime_management/get_dates/"+option+"/"+value1+"/"+value2+"/"+val3+"/"+atro_option,false);
                xmlhttp2.send();
     
    
    }
    function  get_employees_with_preapproved()
    {
        var group = document.getElementById('group').value;
        var year = document.getElementById('year').value;
        var month = document.getElementById('month').value;
        var day = document.getElementById('day').value;

        var atro_option = document.getElementById('atro_option').value;

        if(group=='' || year=='month' || month=='' || day=='')
        {
            alert('Please select valid option/s to continue');
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
                    document.getElementById('group_members').innerHTML=xmlhttp2.responseText;
                     $("#overtimes").DataTable({
                            
                      });
                    }
                  }
                xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/overtime_management/get_employees_with_preapproved/"+group+"/"+year+"/"+month+"/"+day+"/"+atro_option,false);
                xmlhttp2.send();
        }
    }

    function upd_hrs(val)
    {
      var count = document.getElementById('upt_count').value;
      for(i=1;i < count; i++)
      {
        document.getElementById('hrs_'+i).value=val;
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

    //for all general/pre approved
    function for_pre_approved_general()
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
                    document.getElementById("app").innerHTML=xmlhttp2.responseText;
                     $("#overtime").DataTable({
                            
                      });
                    }
                  }
                xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/overtime_management/for_pre_approved_general/",false);
                xmlhttp2.send();
    }

    // function plot_general_preapproved(val)
    // {
    //   var date = val.target.value;
    //     if (window.XMLHttpRequest)
    //               {
    //               xmlhttp2=new XMLHttpRequest();
    //               }
    //             else
    //               {// code for IE6, IE5
    //               xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
    //               }
    //             xmlhttp2.onreadystatechange=function()
    //               {
    //               if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
    //                 {
    //                 document.getElementById("group_members_general").innerHTML=xmlhttp2.responseText;
    //                  $("#overtime").DataTable({
                            
    //                   });
    //                 }
    //               }
    //             xmlhttp2.open("GET","<?php //echo base_url();?>employee_portal/overtime_management/plot_general_preapproved/"+date,false);
    //             xmlhttp2.send();
    // }
</script>
<!-- DataTables -->
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>


<?php require_once(APPPATH.'views/app/application_form/footer.php');?>