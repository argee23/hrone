<script type="text/javascript">
 $(function () {
        $('#package_tables').DataTable({
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

//START OF SETTINGS
// start of requirement management
function get_report(type)
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
                  $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                  
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_reports/get_report/"+type,true);
            xmlhttp.send();
}
function get_settings_filter(val,type)
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
                document.getElementById("setting_filter").innerHTML=xmlhttp.responseText;
                  $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                  
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_reports/get_settings_filter/"+val+"/"+type,true);
            xmlhttp.send();
}

function re_get_subscription_type(val,divv)
{
  if(val=='free_trial')
  {
    document.getElementById(divv).disabled=true;
  }
  else
  {
    document.getElementById(divv).disabled=false;
  }
}
function re_get_dates(val,from,to)
{
  var value =  document.getElementById(val).value;
  if(value==0)
  {
      document.getElementById(from).disabled=true;
      document.getElementById(to).disabled=true;
      document.getElementById(val).value=1;
  }
  else
  {
      document.getElementById(from).disabled=false;
      document.getElementById(to).disabled=false;
      document.getElementById(val).value=0;
  }
}

function get_employers_registered(type)
{
  var employer         =  document.getElementById('re_employer').value;
  var account          =  document.getElementById('re_accounttype').value;
  var status           =  document.getElementById('re_accountstatus').value;

  var registered_      =  document.getElementById('registered_').value;
  var end_             =  document.getElementById('end_').value;

  if(account=='free_trial') { var accounttype    = 'free_trial'; }
  else { var accounttype   =  document.getElementById('re_subscriptiontype').value; }

  if(registered_==0)
  {
    var r_from =  document.getElementById('re_registeredfrom').value;
    var r_to =  document.getElementById('re_registeredto').value;
  }  
  else
  {
    var r_from = 'all';
    var r_to = 'all';
  }
  if(end_==0)
  {
    var e_from = document.getElementById('re_endfrom').value;
    var e_to = document.getElementById('re_endto').value;
  }  
  else
  {
    var e_from = 'all';
    var e_to = 'all';
  }


  if(employer=='' || accounttype=='' || status=='' || r_from=='' || r_to=='' || e_to=='' || e_from=='')
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
                document.getElementById("registered_employees_table").innerHTML=xmlhttp.responseText;
                  $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                  
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_reports/get_employers_registered_results/"+type+"/"+employer+"/"+accounttype+"/"+status+"/"+r_from+"/"+r_to+"/"+e_to+"/"+e_from,true);
            xmlhttp.send();
  }
}

function get_job_management(type)
{
  var employer         =  document.getElementById('j_employer').value;
  var status           =  document.getElementById('j_accountstatus').value;

  var receiveddate_    =  document.getElementById('registered_').value;
  var updatedate_      =  document.getElementById('end_').value;

  if(receiveddate_==0)
  {
    var r_from =  document.getElementById('re_registeredfrom').value;
    var r_to =  document.getElementById('re_registeredto').value;
  }  
  else
  {
    var r_from = 'all';
    var r_to = 'all';
  }
  if(updatedate_==0)
  {
    var u_from = document.getElementById('re_endfrom').value;
    var u_to = document.getElementById('re_endto').value;
  }  
  else
  {
    var u_from = 'all';
    var u_to = 'all';
  }

  if(employer=='' || status=='' || r_from=='' || r_to=='' || u_from=='' || u_to=='')
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
                document.getElementById("registered_employees_table").innerHTML=xmlhttp.responseText;
                  $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                  
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_reports/get_job_management_results/"+type+"/"+employer+"/"+status+"/"+r_from+"/"+r_to+"/"+u_to+"/"+u_from,true);
            xmlhttp.send();
  
  }

}
function get_req_status(option)
{
  document.getElementById('s_employer').disabled=false;
  if(option=='view_not_viewed')
  {
   
    $("#view_new_uploaded").hide();
    $("#view_requirements").hide();

  }
  else if(option=='view_new_uploaded')
  {
    $("#view_not_viewed").hide();
    $("#view_requirements").hide();
  }
  else if(option=='view_requirements')
  {
    $("#view_new_uploaded").hide();
    $("#view_not_viewed").hide();
  } 
  else if(option=='view_payment')
  {
    $("#view_new_uploaded").hide();
    $("#view_not_viewed").hide();
    $("#view_requirements").hide();
  }
  else{}
   $("#"+option).show();
}

function get_requirement_status(type)
{
  var employer    =     document.getElementById('s_employer').value;
  var option      =     document.getElementById('s_type').value;

  if(option=='view_not_viewed')
  {
      var datefinal = document.getElementById('view_not_viewed_').value;
      if(datefinal==1)
      {
          var datefrom  = 'all';
          var dateto    = 'all';
      }
      else
      {
          var datefrom  =  document.getElementById('view_not_viewed_from').value;;
          var dateto    =  document.getElementById('view_not_viewed_to').value;;
      }
      var account=option;
      var accounttype=option;
      var status=option;
      var activate=option;
      var payment=option;
    
  }
  else if(option=='view_new_uploaded')
  {
      var datefinal = document.getElementById('view_new_uploaded_').value;
      if(datefinal==1)
      {
          var datefrom  = 'all';
          var dateto    = 'all';
      }
      else
      {
          var datefrom  =  document.getElementById('view_new_uploaded_from').value;;
          var dateto    =  document.getElementById('view_new_uploaded_to').value;;
      }
      var account=option;
      var accounttype=option;
      var status=option;
       var activate=option;
      var payment=option;
  }
  else if(option=='view_requirements')
  {
      var activate=option;
      var payment=option;
      var account = document.getElementById('s_accounttype').value;
      if(account=='free_trial') { var accounttype    = 'free_trial'; }
      else if(account=='all'){ var accounttype='all'; }
      else { var accounttype   =  document.getElementById('s_subscriptiontype').value; }

      var status = document.getElementById('s_status').value;
      var datefinal = document.getElementById('view_requirements_to_').value;
      if(datefinal==1)
      {
          var datefrom  = 'all';
          var dateto    = 'all';
      }
      else
      {
          var datefrom  =  document.getElementById('view_requirements_from').value;;
          var dateto    =  document.getElementById('view_requirements_to').value;;
      }
  }
  else if(option=='view_payment')
  {
    var activate = document.getElementById('s_license').value;
    var payment = document.getElementById('s_payment').value; 
    var account   = document.getElementById('ss_accounttype').value; 
    var status=option;
     if(account=='free_trial') { var accounttype    = 'free_trial'; }
     else if(account=='all'){ var accounttype='all'; }
      else { var accounttype   =  document.getElementById('ss_subscriptiontype').value; }

    var datefinal = document.getElementById('view_payment_').value; 
     var s_payment = document.getElementById('s_payment').value; 
      if(datefinal==1)
      {
          var datefrom  = 'all';
          var dateto    = 'all';

      }
      else
      {
          var datefrom  =  document.getElementById('_view_not_viewed_from').value;;
          var dateto    =  document.getElementById('_view_not_viewed_to').value;;
      }
     
  }
  
  if(employer=='' || option=='' || datefinal=='' || datefrom=='' || dateto=='' || account=='' || accounttype=='' || status=='' || activate=='' || payment=='' )
  {
    alert("Please fill up all fields");
    alert(datefinal);
    
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
                document.getElementById("req_status_table").innerHTML=xmlhttp.responseText;
                  $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                  
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_reports/get_requirement_status_results/"+type+"/"+employer+"/"+option+"/"+datefinal+"/"+datefrom+"/"+dateto+"/"+account+"/"+accounttype+"/"+status+"/"+activate+"/"+payment,true);
            xmlhttp.send();
  }
}
</script>