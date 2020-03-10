<script type="text/javascript">

//START OF SETTINGS
// start of requirement management
function get_setting(type)
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
                if(type=='SD3' || type=='SD1' || type=='SD12' || type=='view_all_settings') 
                  { 
                      $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                  }
                else if(type=='SD18' || type=='SD19')
                {
                  tinymce.remove();
                        tinymce.init({
                            selector: 'textarea',
                            height: 400,
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
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/get_setting/"+type,true);
            xmlhttp.send();
}
function requirements_action(type,action,id)
{
  if(action=='add')
  {
        var title = document.getElementById('title').value; 
        var desc = document.getElementById('desc').value;
        var note = document.getElementById('note').value;
        function_escape('title_',title);
        function_escape('desc_',desc);
        function_escape('note_',note);
        var title_ = document.getElementById('title_').value; 
        var desc_ = document.getElementById('desc_').value;
        var note_ = document.getElementById('note_').value;
        var uploadable = document.getElementById('final_file_uploaded').value;
        save_requirements(title_,desc_,note_,type,action,id,uploadable);

  }
  else if(action=='delete')
  {
      var title_='delete';
      var desc_ = 'delete';
      var note_ = 'delete';
      var result = confirm("Are you sure you want to delete id-" + id);
      if(result == true)
      {
        save_requirements(title_,desc_,note_,type,action,id,action);
      } else {}
  }
  else if(action=='enable')
  { 
      var title_='enable';
      var desc_ = 'enable';
      var note_ = 'enable';
      var result = confirm("Are you sure you want to enable id-" + id);
      if(result == true)
      {
        save_requirements(title_,desc_,note_,type,action,id,action);
      } else {}    
  } 
  else if(action=='disable')
  { 
      var title_='enable';
      var desc_ = 'enable';
      var note_ = 'enable';
      var result = confirm("Are you sure you want to disable " + id);
      if(result == true)
      {
        save_requirements(title_,desc_,note_,type,action,id,action);
      } else {}    
  } 
  else if(action=='edit')
  {
      $("#o_title"+id).hide();
      $("#o_desc"+id).hide();
      $("#o_note"+id).hide();

      $("#u_title"+id).show();
      $("#u_desc"+id).show();
      $("#u_note"+id).show();

      $("#o"+id).hide();
      $("#u"+id).show();

      $("#o_uploadable"+id).hide();
      $("#u_uploadable"+id).show();
  }
  else if(action=='cancel')
  {
     $("#o_title"+id).show();
      $("#o_desc"+id).show();
      $("#o_note"+id).show();

      $("#u_title"+id).hide();
      $("#u_desc"+id).hide();
      $("#u_note"+id).hide();

      $("#o"+id).show();
      $("#u"+id).hide();

       $("#o_uploadable"+id).show();
      $("#u_uploadable"+id).hide();
  }
  else if(action=='save_update')
  {
      var title = document.getElementById('upd_title'+id).value; 
      var desc = document.getElementById('upd_desc'+id).value;
      var note = document.getElementById('upd_note'+id).value;
      function_escape('upd_title_'+id,title);
      function_escape('upd_desc_'+id,desc);
      function_escape('upd_note_'+id,note);
      var title_ = document.getElementById('upd_title_'+id).value; 
      var desc_ = document.getElementById('upd_desc_'+id).value;
      var note_ = document.getElementById('upd_note_'+id).value;
      var uploadable = document.getElementById('upd_final_file_uploaded').value;
      save_requirements(title_,desc_,note_,type,action,id,uploadable);
  }
}
function save_requirements(title_,desc_,note_,type,action,id,uploadable)
{
  if(title_=='' || desc_=='' || note_=='' || uploadable==''){ alert("Please fill up all fields to continue"); }
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
                 setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                if(type=='list_req' || type=='packages_settings' || type=='SD3' || type=='SD12') 
                  { 
                      $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                  }
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/save_requirements/"+type+"/"+title_+"/"+desc_+"/"+note_+"/"+action+"/"+id+"/"+uploadable,true);
            xmlhttp.send();
    }
}
//end of requirement management
function save_free_trial(type,id)
{
  var months = document.getElementById('months_trial').value;
  var post = document.getElementById('post_trial').value;

  if(months=='' || post=='')
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
                document.getElementById("main_res").innerHTML=xmlhttp.responseText;
                 setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                if(type=='list_req' || type=='packages_settings') 
                  { 
                      $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                  }
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/save_free_trial/"+type+"/"+months+"/"+post+"/"+id,true);
            xmlhttp.send();
  }
}
//start for package settings

function action_package_settings(type,action,id)
{

  if(action=='add')
  {
      var customertype=document.getElementById('p_customer_type').value;
      var validity = document.getElementById('p_months_validity').value;
      var license = document.getElementById('p_job_license').value;
      var price = document.getElementById('p_price').value;
      var discount = document.getElementById('p_discount').value;
      var vat = document.getElementById('p_vat').value;
      var vat_included = document.getElementById('p_vat_included').value;
      var applicant = document.getElementById('settings_applicannt').value;
      save_package_settings(type,action,id,customertype,validity,license,price,discount,vat,vat_included,applicant);
  }

  else if(action=='enable' || action=='disable' || action=='delete')
  {
      var customertype=action;
      var validity = action;
      var license = action;
      var price = action;
      var discount = action;
      var vat = action;
      var vat_included = action;

      var result = confirm("Are you sure you want to " + action + " id - " + id);
      if(result == true)
      {
        save_package_settings(type,action,id,customertype,validity,license,price,discount,vat,vat_included,action);
      } else {}

  }

  else if(action=='edit')
  {
      $("#add_new_package").hide();
      $("#package_view").hide();
      $("#update_new_package").show();

      update_package_settings(id,type);
  }
  else if(action=='save_update')
  {
      var customertype=document.getElementById('upd_p_customer_type').value;
      var validity = document.getElementById('upd_p_months_validity').value;
      var license = document.getElementById('upd_p_job_license').value;
      var price = document.getElementById('upd_p_price').value;
      var discount = document.getElementById('upd_p_discount').value;
      var vat = document.getElementById('upd_p_vat').value;
      var vat_included = document.getElementById('upd_p_vat_included').value;
      var applicant = document.getElementById('upd_settings_applicannt').value;

      if(customertype=='' || validity=='' || license=='' || price=='' || discount=='' || vat=='' || vat_included=='' || applicant=='')
      {
        alert('Fill up all fields to continue');
      }
      else
      {
          save_package_settings(type,action,id,customertype,validity,license,price,discount,vat,vat_included,applicant);
      }
      

  }
}
function update_package_settings(id,type)
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
                document.getElementById("update_new_package").innerHTML=xmlhttp.responseText;
                
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/update_package_settings/"+id+"/"+type,true);
            xmlhttp.send();
}
function save_package_settings(type,action,id,customertype,validity,license,price,discount,vat,vat_included,applicant)
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
                if(type=='list_req' || type=='packages_settings') 
                  { 
                      $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 

                  }
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/save_package_settings/"+type+"/"+action+"/"+id+"/"+customertype+"/"+validity+"/"+license+"/"+price+"/"+discount+"/"+vat+"/"+vat_included+"/"+applicant,true);
            xmlhttp.send();
}
//end for package settings

//settings list

function action_settings(type,action,id)
{
  if(action=='enable' || action=='disable' || action=='delete')
  {
      var title = action;
      var note = action;
      var result = confirm("Are you sure you want to " + action + " id-" + id);
      if(result == true)
      {
          save_action_settings(type,action,id,title,note);
      }
  }

  else if(action=='update')
  { 
      $("#usettings"+id).show();
      $("#u_title"+id).show();
      $("#u_note"+id).show();

      $("#osettings"+id).hide();
      $("#o_title"+id).hide();
      $("#o_note"+id).hide();
     
  }
  else if(action=='save_update')
  {
        var title = document.getElementById('s_upd_title'+id).value; 
        var note = document.getElementById('s_upd_note'+id).value;
        function_escape('s_upd_title_'+id,title);
        function_escape('s_upd_note_'+id,note);
        var title_ = document.getElementById('s_upd_title_'+id).value; 
        var note_ = document.getElementById('s_upd_note_'+id).value;

        save_action_settings(type,action,id,title_,note_);
  }
  else if(action=='cancel')
  {
      $("#usettings"+id).hide();
      $("#u_title"+id).hide();
      $("#u_note"+id).hide();

      $("#osettings"+id).show();
      $("#o_title"+id).show();
      $("#o_note"+id).show();
  }
  else
  {

  }
}

function save_action_settings(type,action,id,title,note)
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
                if(type=='view_all_settings') 
                  { 
                      $("#"+type).DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                  }
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/save_action_settings/"+type+"/"+action+"/"+id+"/"+title+"/"+note,true);
            xmlhttp.send();
     var xmlhttp;
     refresh_main();
    
}
//end settings list


//add new setting

function add_new_settings(type,option ,val)
{
  var choices = document.getElementById('s_choices').value;

  if(option=='choices' && val!='')
  {
      if(val=='single_field')
        { 
           $("#for_single_data").show();
        }
      else
        {
          $("#for_single_data").hide();
        }
  }
  else if(option=='format1' && choices!='')
  { 
      if(val=='text')
      {
        $("#s_format2").hide();
        $("#s_format2dropdown").hide();
        $("#s_format2datepicker").hide();
        $("#s_format2text").show();
      }
      else if(val=='dropdown')
      {
        $("#s_format2").hide();
        $("#s_format2dropdown").show();
        $("#s_format2datepicker").hide();
        $("#s_format2text").hide();
      }
      else if(val=='datepicker')
      {
        $("#s_format2").hide();
        $("#s_format2dropdown").hide();
        $("#s_format2datepicker").show();
        $("#s_format2text").hide();
      }
      else{
        $("#s_format2").show();
        $("#s_format2dropdown").hide();
        $("#s_format2datepicker").hide();
        $("#s_format2text").hide();
      }
  }
  else if(option=='text')  { document.getElementById('s_format2_final').value=val;  }
  else if(option=='dropdown')
  { 
      var d = document.getElementById('s_format2dropdown').value; 
      document.getElementById('s_format2_final').value=d; 
  }
  else if(option=='datepicker') { document.getElementById('s_format2_final').value=val; }
  else if(option=='save')
  {
    var choices   = document.getElementById('s_choices').value;
    var title   = document.getElementById('s_title').value;
    var note    = document.getElementById('s_note').value;
    var code    = document.getElementById('s_code').value;
  
    function_escape('s_title_',title);
    function_escape('s_note_',note);
    function_escape('s_code_',code);
   
    var title_   = document.getElementById('s_title_').value;
    var note_    = document.getElementById('s_note_').value;
    var code_    = document.getElementById('s_code_').value;
    
    if(choices=='single_field')
    {
        var format1 = document.getElementById('s_format1').value;
        var format2 = document.getElementById('s_format2_final').value;
        var field    = document.getElementById('s_field_name').value;
        function_escape('s_field_name_',field);
        function_escape('s_format2_final_',format2);
        var field_    = document.getElementById('s_field_name_').value;
        var format2_    = document.getElementById('s_format2_final_').value;
    }
    else
    {
        var format1 = option;
        var format2_ = option;
        var field_=option;
    }
     if(title_=='' || note_=='' || code_=='' || format1=='' || format2_=='')
        {
          alert("Please fill up all fields to continue");
        }
        else
        {
          save_new_rec_settings(choices,title_,note_,code_,field_,format1,format2_);
        }
  }
  else{}
  
}

function save_new_rec_settings(choices,title_,note_,code_,field_,format1,format2)
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
               
                      $("#view_all_settings").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/save_new_rec_settings/"+choices+"/"+title_+"/"+note_+"/"+code_+"/"+field_+"/"+format1+"/"+format2,true);
            xmlhttp.send();
  var xmlhttp;
  refresh_main();
}

      
//end of adding of new setting

//add new data in single data
function single_field_data(type,format,idd,action)
{
  var id = format+'_'+idd;
  var data = document.getElementById(id).value;
   function_escape('final_data_single',data);
  var datas = document.getElementById('final_data_single').value;
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
                document.getElementById("main_res").innerHTML=xmlhttp.responseText;
                setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/single_field_data/"+type+"/"+format+"/"+idd+"/"+action+"/"+datas,true);
            xmlhttp.send();
  }
}
//end new data in single data


//sd5 and sd6

function save_months_setting(type,id,option,table)
{
  var data = document.getElementById(option).value;
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
                document.getElementById("main_res").innerHTML=xmlhttp.responseText;
                setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/save_months_setting/"+type+"/"+id+"/"+option+"/"+data+"/"+table,true);
            xmlhttp.send();
  }
}

//end of sd5 q 

function ValidateEmail() {

        var email=document.getElementById('username').value;
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
  }


//start of email settings

function email_settings(type,id,action,typp)
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
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var send_mail_from = document.getElementById('send_mail_from').value;
        var security_type = document.getElementById('security_type').value;

      
        function_escape('smtp_host_',host);
        function_escape('smtp_port_',port);
        function_escape('username_',username);
        function_escape('password_',password);
        function_escape('send_mail_from_',send_mail_from);  
        function_escape('security_type_',security_type);

        var host_ = document.getElementById('smtp_host_').value; 
        var port_ = document.getElementById('smtp_port_').value;
        var username_ = document.getElementById('username_').value;
        var password_ = document.getElementById('password_').value;
        var send_mail_from_ = document.getElementById('send_mail_from_').value;
        var security_type_ = document.getElementById('security_type_').value;

       if (!ValidateEmail()) {
            alert("Invalid email address.");
        }
        else {
            save_email_settings(type,action,id,host_,port_,username_,password_,send_mail_from_,typp,security_type_);
        }


  }


}
function save_email_settings(type,action,id,host_,port_,username_,password_,send_mail_from_,typp,security_type_)
{
  if(host_=='' || port_=='' || username_=='' || password_=='' || send_mail_from_=='')
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
                document.getElementById("main_res").innerHTML=xmlhttp.responseText;
                setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/save_email_setting/"+type+"/"+action+"/"+id+"/"+host_+"/"+port_+"/"+username_+"/"+password_+"/"+send_mail_from_+"/"+typp+"/"+security_type_,true);
            xmlhttp.send();
  }
}
//end of email settings

//search settings

function search_settings(value)
{
  var val =value+'-';
  function_escape('search_val',val);
  var search = document.getElementById('search_val').value;
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
                document.getElementById("rec_main").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/search_settings/"+search,true);
            xmlhttp.send();
}

//end search settings

//refresh main
function refresh_main()
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
                document.getElementById("rec_main").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/refresh_main/",true);
            xmlhttp.send();
}

//for all

function action(option)
{
  if(option=='add_new_package')
  {
    $("#add_new_package").show();
    $("#package_view").hide();
    $("#update_new_package").hide();
  }
  else if(option=='vat_already_included')
  {
    document.getElementById('p_vat_included').value='yes';
  }
  else if(option=='vat_not_included')
  {
    document.getElementById('p_vat_included').value='no';
  }
  else if(option=='upd_vat_already_included')
  {
    document.getElementById('upd_p_vat_included').value='yes';
  }
  else if(option=='upd_vat_not_included')
  {
    document.getElementById('upd_p_vat_included').value='no';
  }
}

//END OF SETTINGS



//START OF REQUIREMENTS STATUS


function recruitment_requirement_stat(type)
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
                 $("#table_requirement").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                 $("#req_active").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
                    $(function () {
                    $('#'+type).DataTable({
                      "pageLength": 3,
                      "pagingType" : "simple",
                      "paging": true,
                      "lengthChange": false,
                      "searching": false,
                      "ordering": false,
                      "info": true,
                      "autoWidth": false
                    });
                  });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/get_requirement_list_by_type/"+type,true);
            xmlhttp.send();
}

function recruitment_requirement_stat_by_company(type,company)
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
                document.getElementById("by_company_requirements").innerHTML=xmlhttp.responseText;
                 $("#table_requirement").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/recruitment_requirement_stat_by_company/"+type+"/"+company,true);
            xmlhttp.send();
}

function view_details_employer_requirements(option,action,id,type)
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
                document.getElementById("sidebar_req").innerHTML=xmlhttp.responseText;
                 $(function () {
                    $('#'+action).DataTable({
                       lengthMenu: [[-1, 25, 50, 100], ['All', 25, 50, 100]],  
                      "pageLength": -1,
                      "pagingType" : "simple",
                      "paging": true,
                      "lengthChange": true,
                      "searching": false,
                      "ordering": false,
                      "info": true,
                      "autoWidth": false
                    });
                  });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/view_details_employer_requirements/"+option+"/"+action+"/"+id+"/"+type,true);
            xmlhttp.send();
}



//END OF REQUIREMENT STATUS

//approve requirements request

function requirement_request_action(option,action,employer_id,req_id,type)
{
  if(action=='comment')
  {
      $("#update"+req_id).show();
      $("#original"+req_id).hide();
  }
  else if(action=='cancel_comment')
  {
      $("#update"+req_id).hide();
      $("#original"+req_id).show();
  }
  else if(action=='update_comment')
  {
    var comment = document.getElementById('update_comment'+req_id).value;
    function_escape('update_comment_'+req_id,comment);
    var comment_ = document.getElementById('update_comment_'+req_id).value;
    save_requirement_request_action(option,action,employer_id,req_id,comment_,type);
  }
  else if(action=='approve' || action=='approve_all')
  {
    save_requirement_request_action(option,action,employer_id,req_id,action,type);
  }

}
function save_requirement_request_action(option,action,employer_id,req_id,comment_,type)
{

  if(action=='update_comment')
  {
    var t = "Are you sure you?";
  }
  else
  {
    var t = "Are you sure you want to approve the requirement?";
  }
  var result = confirm(t);
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
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/save_requirement_request_action/"+option+"/"+action+"/"+employer_id+"/"+req_id+"/"+comment_+"/"+type,true);
            xmlhttp.send();
    }
}
//end


//serttech job management

function job_management_action(action,status,job_id,status_res,company)
{
 if(action=='update')
 {
      $("#ucomment"+job_id).show();
      $("#ocomment"+job_id).hide();

      $("#update"+job_id).show();
      $("#original"+job_id).hide();
 }
 else if(action=='cancel')
 {

      $("#ucomment"+job_id).hide();
      $("#ocomment"+job_id).show();

      $("#update"+job_id).hide();
      $("#original"+job_id).show();
 }
 else if(action=='status_update')
 {
      var result = confirm("Are you sure you want to " + status_res + " id-" + job_id);
      if(result == true)
      {
          save_job_management_action(action,status,job_id,status_res,action,company);
      } else {}
 }
 else if(action=='status_update_by_company')
 {
    var result = confirm("Are you sure you want to  " + status_res + " all pending job under company " + job_id);
      if(result == true)
      {
          save_job_management_action(action,status,job_id,status_res,action,company);
      } else {}
 }
 else if(action=='view')
 {
     save_job_management_action(action,status,job_id,status_res,action,company);
 }
 else if(action=='save_comment')
 {
  var comment = document.getElementById('updatecomment'+job_id).value;
  function_escape('updatecomment_'+job_id,comment);
  var comment_ = document.getElementById('updatecomment_'+job_id).value;

  if(comment_==''){ alert("Comment field is empty"); }
  else{
       save_job_management_action(action,status,job_id,status_res,comment_,company);
  }
 }
}


function save_job_management_action(action,status,job_id,status_res,comment_,company)
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
                document.getElementById("job_management_result").innerHTML=xmlhttp.responseText;
                  $("#table_requirements").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
                   setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/save_job_management_action/"+action
              +"/"+status+"/"+job_id+"/"+status_res+"/"+comment_+"/"+company,true);
            xmlhttp.send();
}

function get_company_job_manage(company,status)
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
                document.getElementById("by_company_result").innerHTML=xmlhttp.responseText;
                  $("#table_requirements").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/get_company_job_manage/"+company+"/"+status,true);
            xmlhttp.send();
}
//end of serttech job management


//viewing of by company registerded bv company

function registered_employers_by_company(company)
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
                document.getElementById("registered_main_body").innerHTML=xmlhttp.responseText;
                  $("#by_company").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/registered_employers_by_company/"+company,true);
            xmlhttp.send();
}

//end of viewing by company





















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
      $(function () {
        $('#table_requirements').DataTable({
          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],  
          "pageLength": 10,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
     

       $(function () {
        $('#active').DataTable({
          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],  
          "pageLength": 10,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
        $(function () {
        $('#free_trial').DataTable({
          "pageLength": 3,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": true,
          "autoWidth": false
        });
      });

        $(function () {
        $('#subscription').DataTable({
          "pageLength": 3,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": true,
          "autoWidth": false
        });
      });
      //added by august 13
      function action_file_uploaded(div,val)
      {
        if(val=='')
        {
              document.getElementById(div).value=0;
        }
        else{
               document.getElementById(div).value=val;
        }
     
      }

    function mark_as_active_paid(option,action,id,type)
    {
      if(type=='manual_activation')
      {
         var result = confirm("Are you sure you want to activate the license?");
      }
      else
      {
        var result = confirm("Are you sure you want to mark the license paid?");
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
                        location.reload();
                      }
                    }
                  xmlhttp.open("GET","<?php echo base_url();?>serttech/recruitment_setting/mark_as_active/"+option+"/"+action+"/"+id+"/"+type,true);
                  xmlhttp.send();
        }
      
    }


    </script>

</script>