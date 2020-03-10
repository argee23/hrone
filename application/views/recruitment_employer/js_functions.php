<script type="text/javascript">

function get_setting(type,company_id,account)
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
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/employer_get_setting/"+type+"/"+company_id+"/"+account,true);
            xmlhttp.send();
}



//for status option settings
function employer_settings_status(type,account,action,id,company_id)
{
	if(action=='delete' || action=='disable' || action=='enable')
	{
		 var result = confirm("Are you sure you want to " + action + " id-" + id);
	      if(result == true)
	      {
	      	var title_ = action;
	      	var color_ = action;
	      	var description_ =action;
	        employer_status_action(type,account,action,id,title_,description_,color_,company_id)
	      } else {}
	}
	else if(action=='update')
	{
		$("#o_title"+id).hide();
      	$("#o_description"+id).hide();
      	$("#o_color"+id).hide();
      	$("#original"+id).hide();

      	$("#u_title"+id).show();
      	$("#u_description"+id).show();
      	$("#u_color"+id).show();
      	$("#update"+id).show();
	}
	else if(action=='cancel')
	{
		$("#o_title"+id).show();
      	$("#o_description"+id).show();
      	$("#o_color"+id).show();
      	$("#original"+id).show();

      	$("#u_title"+id).hide();
      	$("#u_description"+id).hide();
      	$("#u_color"+id).hide();
      	$("#update"+id).hide();
	}
	else if(action=='save_update')
	{
		var title = document.getElementById('title'+id).value;
		var description = document.getElementById('description'+id).value;
		var color = document.getElementById('color'+id).value;

		function_escape('title_'+id,title);
		function_escape('description_'+id,description);
		function_escape('color_'+id,color);

		var title_ = document.getElementById('title_'+id).value;
		var description_ = document.getElementById('description_'+id).value;
		var color_ = document.getElementById('color_'+id).value;

		employer_status_action(type,account,action,id,title_,description_,color_,company_id)
	}
}	


function employer_status_action(type,account,action,id,title,description,color,company_id)
{
  if(account=='public'){ var divid = 'main_res'; } else{ var divid='by_company_result'+type; }
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
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/employer_status_action/"+type+"/"+account+"/"+action+"/"+id+"/"+title+"/"+description+"/"+color+"/"+company_id,true);
            xmlhttp.send();
  
}

//save email settings

//start of email settings

function ValidateEmail() {

        var email=document.getElementById('username').value;
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
  }

function email_settings(type,id,action,typp,account,company_id)
{

  if(action=='update')
  {
        $("#o_host").hide();
        $("#o_port").hide();
        $("#o_username").hide();
        $("#o_password").hide();
        $("#o_mail_from").hide();
        $("#o_security_type").hide();

        $("#u_host").show();
        $("#u_port").show();
        $("#u_username").show();
        $("#u_password").show();
        $("#u_mail_from").show();
        $("#u_security_type").show();

        $("#email_update").hide();
        $("#email_save").show();
        $("#email_cancel").show();

  }
  else if(action=='cancel')
  { 
        $("#o_host").show();
        $("#o_port").show();
        $("#o_username").show();
        $("#o_password").show();
        $("#o_mail_from").show();
        $("#o_security_type").show();

        $("#u_host").hide();
        $("#u_port").hide();
        $("#u_username").hide();
        $("#u_password").hide();
        $("#u_mail_from").hide();
        $("#u_security_type").hide();

        $("#email_update").show();
        $("#email_save").hide();
        $("#email_cancel").hide();
  }
  else if(action=='save_update' || action=='save')
  {

        var host = document.getElementById('smtp_host').value; 
        var port = document.getElementById('smtp_port').value;
        var username = document.getElementById('usernamehost').value;
        var password = document.getElementById('password').value;
        var send_mail_from = document.getElementById('send_mail_from').value;
        var security_type = document.getElementById('security_type').value;

      
        function_escape('smtp_host_',host);
        function_escape('smtp_port_',port);
        function_escape('usernamehost_',username);
        function_escape('password_',password);
        function_escape('send_mail_from_',send_mail_from);  
        function_escape('security_type_',security_type);

        var host_ = document.getElementById('smtp_host_').value; 
        var port_ = document.getElementById('smtp_port_').value;
        var username_ = document.getElementById('usernamehost_').value;
        var password_ = document.getElementById('password_').value;
        var send_mail_from_ = document.getElementById('send_mail_from_').value;
        var security_type_ = document.getElementById('security_type_').value;


       if (!ValidateEmailHost()) {
            alert("Invalid email address.");
        }
        else {
         
            save_email_settings(type,action,id,host_,port_,username_,password_,send_mail_from_,typp,security_type_,account,company_id);
        }


  }


}
function save_email_settings(type,action,id,host_,port_,username_,password_,send_mail_from_,typp,security_type_,account,company_id)
{
  if(account=='public'){ var divid= 'main_res'; } else{ var divid='by_company_result'+type; }

  if(host_=='' || port_=='' || username_=='' || password_=='' || send_mail_from_=='' || account=='' || company_id=='' )
  {
    alert("Please fill up all fields tpo continue");
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
                document.getElementById(divid).innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/save_email_setting/"+type+"/"+action+"/"+id+"/"+host_+"/"+port_+"/"+username_+"/"+password_+"/"+send_mail_from_+"/"+typp+"/"+security_type_+"/"+account+"/"+company_id,true);
            xmlhttp.send();
  }
}
//end of email settings

function ValidateEmail() {

        var email=document.getElementById('text').value;
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
  }

  function ValidateEmailHost() {

        var email=document.getElementById('usernamehost').value;
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
  }

//single data 
function single_field_data_checker(type,format,account,company_id,action,id)
{
  var data = document.getElementById(format).value;
  if(type=='ED4')
  {
        if (!ValidateEmail()) {
            alert("Invalid email address.");
        }
        else 
        {
            function_escape('for_email',data);
            var datas = document.getElementById('for_email').value;
            single_field_data(type,format,account,company_id,action,id,datas);
        }
  }
  else
  {
     single_field_data(type,format,account,company_id,action,id,data);
  }
}
function single_field_data(type,format,account,company_id,action,id,data)
{
 
  if(account=='public'){ var divid='main_res'; } else{ var divid='by_company_result'+type; }
  if(data==''){ alert("Please fill up fields to continue"); }
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
                document.getElementById(divid).innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/save_single_field_data/"+type+"/"+format+"/"+account+"/"+company_id+"/"+data+"/"+action+"/"+id,true);
            xmlhttp.send();
    }
  }

//end single data

//job requirements


function allow_upload(val,id,idd)
{
  if(idd=='uploadable' || idd=='qquestion' || idd=='uqqanswer')
  {
      document.getElementById(id).value=val;
  }
  else
  {
    document.getElementById(id+''+idd).value=val;
  }
}

function job_requirements(type,account,company,action,id)
{
  if(action=='save')
  {
    var uploadable = document.getElementById('uploadable').value;
    var title = document.getElementById('requirements').value;
    function_escape('requirements_',title);
    var title_ = document.getElementById('requirements_').value;

    save_job_requirements(type,account,company,action,id,uploadable,title_)
   
  }
  else if(action=='enable' || action=='disable' || action=='delete')
  {
    var result = confirm("Are you sure you want to delete id-" + id);
    if(result == true)
      {
        var title_ = action;
        var uploadable = action;
        save_job_requirements(type,account,company,action,id,uploadable,title_)
      } else {}
  }
  else if(action=='update')
  {

      $("#o_isupload"+id).hide();
      $("#u_isupload"+id).show();

      $("#o_title"+id).hide();
      $("#u_title"+id).show();

      $("#original"+id).hide();
      $("#update"+id).show();
  }
  else if(action=='cancel')
  {
      $("#o_title"+id).show();
      $("#u_title"+id).hide();

      $("#o_isupload"+id).show();
      $("#u_isupload"+id).hide();

      $("#original"+id).show();
      $("#update"+id).hide();
  }
  else if(action=='save_update')
  {

        var uploadable = document.getElementById('uploadable'+id).value;
        var title = document.getElementById('title'+id).value;
        function_escape('title_'+id,title);
        var title_ = document.getElementById('title_'+id).value;

        
        save_job_requirements(type,account,company,action,id,uploadable,title_)

  }
}

function save_job_requirements(type,account,company,action,id,uploadable,title)
{
 

   if(account=='public'){ var divid = 'main_res'; } else{ var divid='by_company_result'+type; }

  if(type=='' || account=='' || company=='' || action=='' || id=='' || uploadable=='' || title=='')
  {
      alert("Please fill up all fields to continue");
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
                document.getElementById(divid).innerHTML=xmlhttp.responseText;
                 $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/save_job_requirements/"+type+"/"+account+"/"+company+"/"+action+"/"+id+"/"+uploadable+"/"+title,true);
            xmlhttp.send();
  }
}

//end of job requirements


//qualifying questions

function qualifying_questions(type,account,company,action,id)
{
  if(action=='save')
  {
    var question = document.getElementById('qquestion').value;
    var ans = document.getElementById('qquestion_ans').value;

    function_escape('qquestion_',question);
    var question_ = document.getElementById('qquestion_').value;

    save_qualifying_questions(type,account,company,action,id,question_,ans,'qualifying');
  }
  else if(action=='delete' || action=='enable' || action=='disable')
  {
      var result = confirm("Are you sure you want to disable id-" + id);
      if(result == true)
      {
        var question_=action;
        var ans = action;

        save_qualifying_questions(type,account,company,action,id,question_,ans,'qualifying');
      } else {}  
  }
  else if(action=='update')
  {
    $("#u_qquestions"+id).show();
    $("#u_qans"+id).show();

    $("#o_qquestions"+id).hide();
    $("#o_qans"+id).hide();

    $("#o_qualifying"+id).hide();
    $("#u_qualifying"+id).show();
  }
  else if(action=='cancel')
  {
     $("#u_qquestions"+id).hide();
    $("#u_qans"+id).hide();

    $("#o_qquestions"+id).show();
    $("#o_qans"+id).show();

    $("#o_qualifying"+id).show();
    $("#u_qualifying"+id).hide();
  }
  else if(action=='save_update')
  {
      var question = document.getElementById('uqquestions'+id).value;
      var ans = document.getElementById('uqqanswer'+id).value;

      function_escape('uqquestions_'+id,question);
      var question_ = document.getElementById('uqquestions_'+id).value;

      save_qualifying_questions(type,account,company,action,id,question_,ans,'qualifying');
  }
  else
  {
    
      save_qualifying_questions(type,account,company,action,id,'view','view','qualifying');
   
  }
}


  function save_qualifying_questions(type,account,company,action,id,question,answer,question_type)
  {
    if(account=='public'){ var divid = 'questions_body';  } else{ var divid='by_company_result'+type; }
    if(answer=='' || question_type=='' || question=='')
    {
      alert('Please fill up all fields to continue');
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
                document.getElementById(divid).innerHTML=xmlhttp.responseText;
                 $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/save_qualifying_questions/"+type+"/"+account+"/"+company+"/"+action+"/"+id+"/"+question+"/"+answer+"/"+question_type,true);
            xmlhttp.send();
      }
  }

//end of qualifying questions

//start of hypothetical

function hypothetical_questions(type,account,company,action,id)
{

  if(action=='save')
  {
    var question = document.getElementById('hquestion').value;
    function_escape('hquestion_',question);

    var question_ = document.getElementById('hquestion_').value;
    
    save_hypothetical(type,account,company,action,id,question_,'hypothetical');
   
  }
  else if(action=='delete' || action=='enable' || action=='disable')
  {
      var result = confirm("Are you sure you want to disable id-" + id);
      if(result == true)
      {
        save_hypothetical(type,account,company,action,id,action,'hypothetical');
      } else {}  
  }
  else if(action=='update')
  {
      $("#o_hypothetical"+id).hide();
      $("#u_hypothetical"+id).show();

      $("#o_hquestions"+id).hide();
      $("#u_hquestions"+id).show();
  }
  else if(action=='cancel')
  {
      $("#o_hypothetical"+id).show();
      $("#u_hypothetical"+id).hide();

      $("#o_hquestions"+id).show();
      $("#u_hquestions"+id).hide();
  }
  else if(action=='save_update')
  {
      var question = document.getElementById('uhquestions'+id).value;
      function_escape('uhquestions_'+id,question);

      var question_ = document.getElementById('uhquestions_'+id).value;
      
      save_hypothetical(type,account,company,action,id,question_,'hypothetical');
   
  }
  else
  {
    save_hypothetical(type,account,company,action,id,'view','hypothetical');
  }
}

function save_hypothetical(type,account,company,action,id,question,question_type)
{
  if(account=='public' || action=='view'){ var divid='questions_body'; } else{  var divid='by_company_result'+type; }
    if(question=='')
    {
      alert('Please fill up all fields to continue');
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
                document.getElementById(divid).innerHTML=xmlhttp.responseText;
                 $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
              if(account=='public' || action=='view')
              {
               xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/save_hypothetical_questions/"+type+"/"+account+"/"+company+"/"+action+"/"+id+"/"+question+"/"+question_type,true);
                xmlhttp.send();
              }
              else
              {
                xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/save_hypothetical_questions_company/"+type+"/"+account+"/"+company+"/"+action+"/"+id+"/"+question+"/"+question_type,true);
                xmlhttp.send();
              }
      }
}
//end of hypothetical


//start of multiple choice


function multiplechoice_questions(type,account,company,action,id)
{

  if(action=='save')
  {
    var question = document.getElementById('hquestion').value;
    function_escape('hquestion_',question);

    var question_ = document.getElementById('hquestion_').value;
    
    save_multiplechoice_questions(type,account,company,action,id,question_,'multiple_choice');
   
  }
  else if(action=='delete' || action=='enable' || action=='disable')
  {
      var result = confirm("Are you sure you want to disable id-" + id);
      if(result == true)
      {
        save_multiplechoice_questions(type,account,company,action,id,action,'multiple_choice');
      } else {}  
  }
  else if(action=='update')
  {
      $("#o_hypothetical"+id).hide();
      $("#u_hypothetical"+id).show();

      $("#o_hquestions"+id).hide();
      $("#u_hquestions"+id).show();
  }
  else if(action=='cancel')
  {
      $("#o_hypothetical"+id).show();
      $("#u_hypothetical"+id).hide();

      $("#o_hquestions"+id).show();
      $("#u_hquestions"+id).hide();
  }
  else if(action=='save_update')
  {
      var question = document.getElementById('uhquestions'+id).value;
      function_escape('uhquestions_'+id,question);

      var question_ = document.getElementById('uhquestions_'+id).value;
      
      save_multiplechoice_questions(type,account,company,action,id,question_,'multiple_choice');
   
  }
  else if(action=='manage_choices')
  {
    manage_questions_choices(type,account,company,action,id);
  }
  else
  {
    save_multiplechoice_questions(type,account,company,action,id,'view','multiple_choice');
  }
}


function save_multiplechoice_questions(type,account,company,action,id,question,question_type)
{
  if(account=='public' || action=='view'){ var divid='questions_body'; } else{  var divid='by_company_result'+type; }
    if(question=='')
    {
      alert('Please fill up all fields to continue');
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
                document.getElementById(divid).innerHTML=xmlhttp.responseText;
                 $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
          if(account=='public' || action=='view'){
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/save_hypothetical_questions/"+type+"/"+account+"/"+company+"/"+action+"/"+id+"/"+question+"/"+question_type,true);
            xmlhttp.send();
          }
          else
          {
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/save_hypothetical_questions_company/"+type+"/"+account+"/"+company+"/"+action+"/"+id+"/"+question+"/"+question_type,true);
            xmlhttp.send();
          }
      }
}

function manage_questions_choices(type,account,company,action,id)
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
                document.getElementById("questions_body").innerHTML=xmlhttp.responseText;
                 $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/manage_questions_choices/"+type+"/"+account+"/"+company+"/"+action+"/"+id,true);
            xmlhttp.send();
      
}

function multiplechoices_manage(type,account,company,action,question_id,id)
{
  if(action=='save')
  {

    var question = document.getElementById('choicess').value;
    function_escape('choicess_',question);
    var question_ = document.getElementById('choicess_').value;
    save_multiplechoices_manage(type,account,company,action,question_id,id,question_,'multiple_choice');

    
  }
  else if(action=='delete' || action=='enable' || action=='disable')
  {
      var result = confirm("Are you sure you want to disable id-" + id);
      if(result == true)
      {
        var question_=action;

        save_multiplechoices_manage(type,account,company,action,question_id,id,question_,'multiple_choice');
      } else {}  
  }
  else if(action=='update')
  {
    $("#u_choices"+id).show();

    $("#o_choices"+id).hide();
    

    $("#o_qchoices"+id).hide();
    $("#u_qchoices"+id).show();

  }
  else if(action=='cancel')
  {
    $("#u_choices"+id).hide();
    $("#o_choices"+id).show();
    

    $("#o_qchoices"+id).show();
    $("#u_qchoices"+id).hide();
  }
  else if(action=='save_update')
  {
      var question = document.getElementById('uuchoices'+id).value;

      function_escape('uuchoices_'+id,question);
      var question_ = document.getElementById('uuchoices_'+id).value;

      save_multiplechoices_manage(type,account,company,action,question_id,id,question_,'multiple_choice');
  }
  else
  {
     save_multiplechoices_manage(type,account,company,action,question_id,id,'view','multiple_choice');
  }
}

function save_multiplechoices_manage(type,account,company,action,question_id,id,choices,question_type)
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
                document.getElementById("questions_body").innerHTML=xmlhttp.responseText;
                 $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/save_manage_questions_choices/"+type+"/"+account+"/"+company+"/"+action+"/"+question_id+"/"+id+"/"+choices+"/"+question_type,true);
            xmlhttp.send();
}

//end of multiple choice

//manage position
    

function company_position(type,account,company_id,action,id,req_id,preq_id)
{

  if(action=='save')
  {
      var position = document.getElementById('position').value;
      function_escape('position_',position);
      var position_ = document.getElementById('position_').value;

      save_company_position(type,account,company_id,action,id,position_,req_id,preq_id);
  }
  else if(action=='delete' || action=='enable' || action=='disable')
  {
     var result = confirm("Are you sure you want to " + action + "id-" + id);
      if(result == true)
      {
       
        save_company_position(type,account,company_id,action,id,action,req_id,preq_id);
      } else {}  
  }
  else if(action=='update')
  {

     $("#o_position"+id).hide();
     $("#u_position"+id).show();

     $("#oposition"+id).hide();
     $("#uposition"+id).show();
     
  }
  else if(action=='cancel')
  {
      $("#o_position"+id).show();
      $("#u_position"+id).hide();

      $("#oposition"+id).show();
      $("#uposition"+id).hide();
  }
  else if(action=='save_update')
  {
      var position = document.getElementById('position'+id).value;
      function_escape('position_'+id,position);
      var position_ = document.getElementById('position_'+id).value;

      save_company_position(type,account,company_id,action,id,position_,req_id,preq_id);
  }
  else if(action=='delete_req' || action=='add_req')
  {
    if(action=='add_req'){ msg ='Add Requirement '; }
    else { msg ='Remove Requirement ';  }
      var result = confirm("Are you sure you want to " +  msg + " id-" + req_id);
      if(result == true)
      {
       
        save_company_position(type,account,company_id,action,id,action,req_id,preq_id);
      } {}  
  }
  else{}

}

function save_company_position(type,account,company_id,action,id,position_,req_id,preq_id)
{
   if(account=='public'){ var divid = 'main_res';  } else{ var divid='by_company_result'+type;  } 
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
                document.getElementById(divid).innerHTML=xmlhttp.responseText;
                 $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/save_company_position/"+type+"/"+account+"/"+company_id+"/"+action+"/"+id+"/"+position_+"/"+req_id+"/"+preq_id,true);
            xmlhttp.send();
}
//end of manage  position


//get free trial

  function get_free_trial(company_id)
  {

      var account='public';
      var result = confirm("Are you sure");
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
                  location.reload();
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer/get_free_trial/"+company_id+"/"+account,true);
            xmlhttp.send();

      } 
      {}  
  }

//end of free trial


//for dashboard pending requirements

function get_requirement_status(company_id,employer_id,req_id,type)
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
                   document.getElementById("main_body_result").innerHTML=xmlhttp.responseText;
                    $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/get_requirement_status/"+company_id+"/"+employer_id+"/"+req_id+"/"+type,true);
            xmlhttp.send();
  
}

function get_package_details(company_id,employer_id)
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
                   document.getElementById("main_body_result").innerHTML=xmlhttp.responseText;
                    $("#package").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/get_package_details/"+company_id+"/"+employer_id,true);
            xmlhttp.send();
}


function employer_upload_file(employer_id,id,action)
{
  if(action =='update')
  {
        $("#orig"+id).hide();
        $("#o_action"+id).hide();

         $("#upd"+id).show();
        $("#u_action"+id).show();
  }
  else if(action=='cancel')
  {
        $("#orig"+id).show();
        $("#o_action"+id).show();

        $("#upd"+id).hide();
        $("#u_action"+id).hide();
  }
  else if(action=='save_update')
  {
    
  }
}


//avail package subscription
function avail_package(company_id,employer_id,id,account)
{
     
      var result = confirm("Are you sure you want to avail package");
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
                  location.reload();
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/get_package_subscription/"+company_id+"/"+employer_id+"/"+id+"/"+account,true);
            xmlhttp.send();

      } 
      {}  

}

//for history

function get_employer_history(action, company)
{
  if(action=='request_history')
  {
    $("#licenserequesthistory_nav_tab_div").show();    
    $("#activelicensehistory_nav_tab_div").hide();
  }
  else
  {
    $("#licenserequesthistory_nav_tab_div").hide();    
    $("#activelicensehistory_nav_tab_div").show();
  }
  $("#activelicensedetails_nav_tab_div").hide();
  $("#main_nav_tab_div").hide();
  

  
 
  if(action=='request_history')
  {
    var di = 'div_history_request';
  }
  else
  {
    var di = 'div_history_active';
  }

  div_history_active
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
                   document.getElementById(di).innerHTML=xmlhttp.responseText;
                     $("#"+action).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/get_employer_history/"+action+"/"+company,true);
            xmlhttp.send();
}

//end of history

//active license details

function get_active_license(type,company,id)
{
   $("#activelicensedetails_nav_tab_div").show();
  $("#main_nav_tab_div").hide();
  $("#activelicensehistory_nav_tab_div").hide();
  $("#licenserequesthistory_nav_tab_div").hide();

  
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
                   document.getElementById("main_body_result").innerHTML=xmlhttp.responseText;
                     $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/get_active_license/"+type+"/"+company+"/"+id,true);
            xmlhttp.send();
}
//end of active license details











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





//start by company settings
function by_company_status(company,type,account)
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
                   document.getElementById("by_company_result"+type).innerHTML=xmlhttp.responseText;
                    $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 

                    if(type=='ED8')
                    {
                        tinymce.remove();
                        tinymce.init({
                            selector: 'textarea',
                            height: 500,
                            theme: 'modern',
                            menubar:false,
                            plugins: 'emoticons print preview fullpage searchreplace autolink directionality link charmap hr advlist lists textcolor wordcount link contextmenu colorpicker textpattern help',
                            toolbar1: 'formatselect | fontsizeselect | fontselect | bold italic underline strikethrough superscript subscript undo redo cut copy paste find and replace hr forecolor backcolor | link | charmap | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat preview emoticons',
                            font_formats: 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats',
                            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                            image_advtab: true
                    });
                    }
                }
              }
            if(type=='ED8')
            {
                xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/by_company_status_ED8/"+company+"/"+type+"/"+account,true);
          
            }
            else
            {
                xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/by_company_status/"+company+"/"+type+"/"+account,true);
          
            }
            xmlhttp.send();
}

function by_company_questions(company,type,account,question_type)
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
                   document.getElementById("by_company_result"+type).innerHTML=xmlhttp.responseText;
                    $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/by_company_questions/"+company+"/"+type+"/"+account+"/"+question_type,true);
            xmlhttp.send();

}


//numbering of status option by company 

function view_updating_numbering(val)
{
  document.getElementById('update_checking').value=val;
  var count = document.getElementById('numbering_count').value;
  var cinput =   document.getElementsByClassName('numbering_value');


  for (i=0;i < count; i++)
        {
          $('#numbering_update'+i).show();
          $('#numbering_viewing'+i).hide();
        } 
  
  $('#action_viewing').hide(); 
  $('#action_updating').show();  
}

function view_updating_comp(val)
{
  document.getElementById('update_checking').value=val;
  var count = document.getElementById('numbering_count').value;
  var cinput =   document.getElementsByClassName('numbering_value');


  for (i=0;i < count; i++)
        {
          $('#computation_update'+i).show();
          $('#computation_viewing'+i).hide();
        } 
  
  $('#action_viewing').hide(); 
  $('#action_updating').show();  
}



function cancel_numbering()
{
  var count = document.getElementById('numbering_count').value;
  var cinput =   document.getElementsByClassName('numbering_value');


  for (i=1;i < count; i++)
        {
          $('#numbering_update'+i).hide();
          $('#numbering_viewing'+i).show();
        } 
  
  $('#action_viewing').show(); 
  $('#action_updating').hide(); 
}

function savechanges_numbering(type,account,company_id)
{
    var checking_type = document.getElementById('update_checking').value;
    if(checking_type=='comp')
    {
        checkingtype_value = 'computation';
    }
    else
    {
       checkingtype_value = 'numbering';
    }

    var result = confirm("Are you sure you want to update the status numbering of company id " + company_id + "?.");
       if(result == true)
       {
          var count = document.getElementById('numbering_count').value;
          var cinput =   document.getElementsByClassName(checkingtype_value + '_value');

          var value_numbering='';
          var value_id='';
          for (i=1;i < count; i++)
                {
                  document.getElementById(checkingtype_value + "value"+i).style.borderColor = "white";
                  document.getElementById('checking_empty').value=0;
                }
                            
          for (i=1;i < count; i++)
                {
                    var val = document.getElementById(checkingtype_value + 'value'+i).value;
                    value_numbering += val + "-";

                    var id = document.getElementById(checkingtype_value + 'id'+i).value;
                    value_id += id + "-";

                    if(checking_type=='num')
                    {
                        for (ii=1;ii < count; ii++)
                        {
                          if(ii==i){}
                          else
                          {
                            var a = document.getElementById(checkingtype_value + 'value'+ii).value;
                            if(a==val)
                            {
                              document.getElementById(checkingtype_value + "value"+i).style.borderColor = "red";
                              document.getElementById(checkingtype_value + "value"+ii).style.borderColor = "red";
                              document.getElementById('checking_empty').value=1;
                            }
                            else
                            {}
                          }
                        }
                    }
                    else
                    {
                      
                    }
                      
                }

          var checker = document.getElementById('checking_empty').value;
          if(checker==1)
          {
             alert("Duplicate Values are not allowed.");
             
          }
          else
          {
            save_updated_numbering(type,account,company_id,value_numbering,value_id,count,checking_type);
          }
       }

}


function save_updated_numbering(type,account,company_id,value_numbering,value_id,count,checking_type)
{
  if(account=='public'){ var divid = 'main_res'; } else{ var divid='by_company_result'+type; }
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
            xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer_management/employer_status_numbering/"+type+"/"+account+"/"+company_id+"/"+value_numbering+"/"+value_id+"/"+count+"/"+checking_type,true);
            xmlhttp.send();
}

function cancel_pending_request(company_id)
{
  var result = confirm("Are you sure you want to cancel pending request?");
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
                  location.reload();
                }
              }
      xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer/cancel_pending_request/"+company_id,true);
      xmlhttp.send();
  }
}
//end of by company requirements
</script>