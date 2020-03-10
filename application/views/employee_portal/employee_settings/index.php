<br><br><br>
<div>
    <!-- Start of Side View -->
    <div class="col-md-3">
      <div class="panel box box-success" style="height:500px;">
        <div class="panel-heading"><h4>Employee Settings  <span class="pull-right"><i class="fa fa-gear"></i></span></h4></div>
        <div class="panel-body  fixed-panel-side mCustomScrollbar" data-mcs-theme="dark"">
          <ul class="nav nav-pills nav-stacked">
              <li><a href="#editable_topics" onclick="change_password();"><i class='fa fa-circle-o'></i> <span>Change Password</span></a></li>
              
              <li><a style="cursor:pointer;" onclick="account_settings();"><i class='fa fa-circle-o'></i> <span>Account Settings</span></a></li>
             
          </ul>
        </div>
      </div>
    </div>

  <div class="col-md-9" style="height:500px;" id="main_res">
    <div class="panel box box-success" >

    </div>
  </div>
</div>

<script type="text/javascript">
  function account_settings()
  {
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
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_settings/account_settings/",true);
            xmlhttp.send();
    } 
  }
  function account_settings_updateform()
  {
    document.getElementById('email').disabled=false; 
    document.getElementById('account_display').disabled=false; 
    document.getElementById('trans_status').disabled=false; 
    document.getElementById('notif_status').disabled=false; 
    document.getElementById('req_approval').disabled=false; 
    document.getElementById('req_update').disabled=false; 
    document.getElementById('as_save').disabled=false;
  }

  function save_account_settings()
  {
    var eemail = document.getElementById('email').value;
    if(eemail==""){ email='none'; } else{  email = eemail;  }
    
    function_escape("l_email",email);
    var l_email = document.getElementById('l_email').value;
    var account_display = document.getElementById('account_display').value; 
    var trans_status = document.getElementById('trans_status').value; 
    var notif_status= document.getElementById('notif_status').value; 
    var req_approval = document.getElementById('req_approval').value; 
    var req_update = document.getElementById('req_update').value;

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
                setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_settings/save_account_settings/"+l_email+"/"+account_display
              +"/"+trans_status+"/"+notif_status+"/"+req_approval+"/"+req_update,true);
            xmlhttp.send();
    } 
  }
  function change_password()
  {
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
                setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_settings/change_password/",true);
            xmlhttp.send();
    } 
  }
  
  function correct_password(val,option)
  {
  	var password = document.getElementById('old_password').value;
  	var current_password = document.getElementById('current_password').value;
  	var new_password = document.getElementById('new_password').value;
  	var confirm_pass = document.getElementById('retype_password').value;
  	var l =  val.length;

  	if(option=='check_oldpass')
  	{
	  	if(val==password) { document.getElementById("old_password_checker").innerHTML=""; }
	  	else{ document.getElementById("old_password_checker").innerHTML="<i style='color:red;font-size:13px;'>Incorrect Password</i>"; }
  	}
  	else if(option=='new_pass')
  	{
  		
  		if(password==val){ document.getElementById('new_password_needed').innerHTML="<i style='color:red;font-size:13px;'>Please provide new password</i>"; }
  		else if(l < 8) { document.getElementById('new_password_needed').innerHTML="<i style='color:red;font-size:13px;'>A valid password contains atleast 8 characters.</i>"; }
  		else { document.getElementById('new_password_needed').innerHTML=''; }
  	}
  	else if(option=='confirm_pass')
  	{
  		if(new_password==confirm_pass) { document.getElementById('confirmpass').innerHTML="";   }
  		else{ document.getElementById('confirmpass').innerHTML="<i style='color:red;font-size:13px;'>Password Mismatch.</i>"; }
  	}
  	if(password==current_password && new_password==confirm_pass && new_password!=password && l > 8)
  	{
  		document.getElementById('save_button').disabled=false;
  	}
  	else{ document.getElementById('save_button').disabled=true; }
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
