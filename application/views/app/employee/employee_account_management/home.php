<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
    <link href="<?php echo base_url()?>public/bootstrap/css/tables.css" rel="stylesheet">  
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
     <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
  </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>
<body>
<!-- Start Content Wrapper. Contains page content -->
<div class="content-wrapper2">
<!-- Start Content Header (Page header) -->
  <section class="content-header">
  <h1>
    201 Employee Files
    <small>Account Management</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>201 Employee Files</li>
    <li class="active">Account Management</li>
  </ol>
</section>
  <br>

  <div class="col-sm-4">
      <div class="box box-solid box-success">
        <div class="box-header">
        <h5 class="box-title"><i class='fa fa-user-md'></i> <span> Account Management Settings</span></h5>
<?php
        if($this->session->userdata('serttech_account')=="1"){
?>        
        <a class='fa fa-plus-square pull-right' aria-hidden='true' data-toggle='tooltip' title='Click to add new system policy!' onclick="add_system_policy()"></a>

<?php
}else{}
?>

        </div>
        <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark"">
          <div id="fetch_company_result" style="height: 352px;overflow-y: auto;" >
               <div id="policy">
                <ul class="nav nav-pills nav-stacked">
                 <?php if(empty($policy)) { echo "<h3 class='text-danger'>No Results Found!.</h3>";} else{ foreach($policy as $rows)
                  { ?>
                      <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to add the policy' onclick="add_policy_data(<?php echo $rows->account_management_policy_id?>)"><i class='fa fa-folder-open'></i> <span><?php echo $rows->title?> </span></a></li> 
                  <?php } }?>
                  </ul>
               </div>
             <input type="hidden" value="" name="result_company" id="result_company">
            </div>
        </div>
      </div>
</div>
 <div id="all_res">
  <div class="col-md-8" style="padding-bottom: 50px;"  id="fetch_all_result">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
            <div style="height:367px;"></div>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div> 
    </div>
  </div> 
  </div>
  
  <script>
     function add_system_policy()
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
                  document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                }
              }
                xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/add_system_policy/",true);
                xmlhttp.send();
      } 
    }

   
    //option selected
     function option(option_results)
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
                  document.getElementById("option_results").innerHTML=xmlhttp.responseText;
                }
              }
                xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/option_results/"+option_results,true);
                xmlhttp.send();
      }
      
    }

    //save new policy
    function save_policy()
    {
      $("#all_res").load(location.href + " #all_res");
     var option_results= document.getElementById("options").value;
     var title= document.getElementById("add_policy").value;
      if(option_results=='' || title =='')
      { alert("Fill Up required fields");}
      else
      {
        if(option_results=='account_sec')
        {
          var additional = document.getElementsByClassName("additional");
          if(document.getElementById("note").value==''){ var note = 'none'}
          else{ var note = document.getElementById("note").value; }
          var additional_data='';
          for (i=0;i<2; i++)
          {
            if (additional[i].checked === true)
            {
              additional_data +=additional[i].value + "-";
            }
          }
        }
        else if(option_results=='govt_fields')
        {
           var additional = document.getElementsByClassName("fields");
           var no_fields = document.getElementById("no_fields").value;
           var no = no_fields - 2;
          if(document.getElementById("note").value==''){ var note = 'none'}
          else{ var note = document.getElementById("note").value; }
          var additional_data='';
          for (i=0;i<no; i++)
          {
            if (additional[i].checked === true)
            {
              additional_data +=additional[i].value + "-";
            }
          }
        }
        else if(option_results=='dis_acct')
        {
          var additional = document.getElementsByClassName("acct");
          if(document.getElementById("note").value==''){ var note = 'none'}
          else{ var note = document.getElementById("note").value; }
          var additional_data='';
          for (i=0;i<9; i++)
          {
            if (additional[i].checked === true)
            {
              additional_data +=additional[i].value + "-";
            }
          }
        }
        else if(option_results=='notif')
        {
          var additional = document.getElementsByClassName("who_view");
          if(document.getElementById("note").value==''){ var note = 'none'}
          else{ var note = document.getElementById("note").value; }
          var additional_data='';
          for (i=0;i<2; i++)
          {
            if (additional[i].checked === true)
            {
              additional_data +=additional[i].value + "-";
            }
          }
        }
        else if(option_results=='mob_tel')
        {
           if(document.getElementById("note").value==''){ var note = 'none'}
          else{ var note = document.getElementById("note").value; }
        }
        else 
        {
              if(document.getElementById("note").value==''){ var note = 'none'}
              else{ var note = document.getElementById("note").value; }

              var tbl_values = new Array();
              var r_table = document.getElementById('table_others');
              var rowLength = r_table.rows.length;
              var loop = 1;
              var loopb = 1;
              for (i = 1; i < rowLength; i++){
                  var oCells = r_table.rows.item(i).cells;
                  var cellLength = oCells.length;
                  var cellVal = oCells.item(0).innerHTML;
                  var one = 1;
                  tbl_values.push($('#title' + loop).val());
                  tbl_values.push($('#input_type' + loop).val());
                  tbl_values.push($('#format_data' + loop).val());
                  loopb++;
                  loop++;
              } 

              var converted = tbl_values.toString();
              var converted1 = tbl_values.join("qq");
        }

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
                    document.getElementById("policy").innerHTML=xmlhttp.responseText;
                  }
                }
          if(option_results=='account_sec' || option_results=='govt_fields' || option_results=='dis_acct' || option_results=='notif')
            { xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/save/"+option_results+"/"+additional_data+"/"+note+"/"+title,true); }
          else if(option_results=='mob_tel')
          {
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/save_mo_tel_format/"+option_results+"/"+note+"/"+title,true);
          }
          else{ xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/save_others_setting/"+option_results+"/"+converted1+"/"+loop+"/"+note+"/"+title,true); }

        
          xmlhttp.send();
        }
      }
     
    }

    function add_policy_data(account_management_policy_id)
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
                  document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                }
              }
                xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/add_policy_data/"+account_management_policy_id,true);
                xmlhttp.send();
      }
    }

    function account_security(action,option_results,account_management_policy_id)
    {
      var default_password = document.getElementById("default_password").value;
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
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/save_account_security_data/"+default_password+"/"+account_management_policy_id+"/"+action,true);
                xmlhttp.send();
      }
    }

    function update()
    {
        document.getElementById("default_password").disabled = false;
         $("#update_save").show();
         $("#update_form").hide();
    }

    //input whole number/decimal
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

    //reset
    function reset()
    {
    }

    //save govt_fields
    function save_govt_fields(action,option_results,account_management_policy_id)
    {

      var number_fields = document.getElementById('number_fields').value;
      var additional_functions = document.getElementById('additional_functions').value;
      var tbl_values = new Array();
      var r_table = document.getElementById('table_home');
      var rowLength = r_table.rows.length;
      var loop = 1;
      var loopb = 1;
      for (i = 1; i < rowLength; i++){
      var oCells = r_table.rows.item(i).cells;
      var cellLength = oCells.length;
      var cellVal = oCells.item(0).innerHTML;
      var one = 1;
      tbl_values.push($('#field' + loop).val());

      for(ii = 1; ii < number_fields; ii++){
      tbl_values.push($('#' + ii + loop).val());

      }

      loopb++;
      loop++;
      }

      var converted = tbl_values.toString();
      var converted1 = tbl_values.join("qq");
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
                xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/save_govt_fields/"+account_management_policy_id+"/"+action+"/"+option_results+"/"+loop+"/"+converted1+"/"+number_fields+"/"+additional_functions,true);
                xmlhttp.send();

      }
    }
    function save_mob_tel(company_id,option)
    {

      var number_fields = document.getElementById('number_fields').value;
      var tbl_values = new Array();
      var r_table = document.getElementById('table_tel_mob');
      var rowLength = r_table.rows.length;
      var loop = 1;
      var loopb = 1;
      for (i = 1; i < rowLength; i++){
      var oCells = r_table.rows.item(i).cells;
      var cellLength = oCells.length;
      var cellVal = oCells.item(0).innerHTML;
      var one = 1;
      tbl_values.push($('#loc' + loop).val());
      tbl_values.push($('#tel' + loop).val());
      tbl_values.push($('#mob' + loop).val());

      for(ii = 1; ii < number_fields; ii++){
      }

      loopb++;
      loop++;

      }

      var converted = tbl_values.toString();
      var converted1 = tbl_values.join("mimi");
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
                  document.getElementById("mob_tel_action").innerHTML=xmlhttp.responseText;
                   setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
                xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/save_mob_tel/"+company_id+"/"+converted1+"/"+loop+"/"+number_fields+"/"+option,true);
                xmlhttp.send();
      }
      
    }
   

    function update_govt_fields_form()
    {
      $("#save_update").show();
      $("#update_form").hide();
      $("#table_home").show();
      $("#table_show").hide();
    }

    function disable_by(option)
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
        
        document.getElementById("option_view_result").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/disable_by_view/"+option,true);
    xmlhttp.send();
    }

    function onchange_val(by,onchange_val)
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
            
            document.getElementById(by).innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/onchange/"+by+"/"+onchange_val+"/"+company,true);
        xmlhttp.send();

      
    }
    function onchange_val2(by,onchange_val)
    {     var company = document.getElementById('company').value;      
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
            
            document.getElementById(by).innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/onchange2/"+by+"/"+onchange_val+"/"+company,true);
        xmlhttp.send();
    }

    function save_disable(account_management_policy_id)
    { 
      var disable = document.getElementById('disable').value;
      var count = document.getElementById('count_'+disable).value;
      var checks = document.getElementsByClassName(disable);
      if(disable=='Company')
      { 
        var company = 'none'; 
        var department = '0';
        var division ='0';
        var section ='0';
      }
      else if(disable=='Location')
      {
        var company = document.getElementById('company').value;
        var division = '0';
        var department = '0';
        var section ='0';
      }
      else if(disable=='Department')
      {
        var company = document.getElementById('company').value;
        var division = document.getElementById('f_division').value;
        var department = '0';
        var section ='0';
      }
      else if(disable=='Section')
      {
        var company = document.getElementById('company').value;
        var division = document.getElementById('f_division').value;
        var department = document.getElementById('f_dept').value;
        var section = '0';
       
      }
      else  if(disable=='SubSection')
      { 
        var company = document.getElementById('company').value;
        var division = document.getElementById('f_division').value;
        var department = document.getElementById('f_dept').value;
        var section = document.getElementById('f_section').value;
        
      }
       else if(disable=='Position' || disable=='Classification' || disable=='Employment')
      {
        var company = document.getElementById('company').value;
        var division = '0';
        var department = '0';
        var section ='0';
      }

      else{
        var company = '0';
        var division = '0';
        var department = '0';
        var section = '0';
      }
    
      var data_check=''; 
      var data_uncheck=''; 
       for (i=0; i < count; i++)
          { 
            if(checks[i].checked === true)
            { 
             data_check +=checks[i].value + "-";
            }
            else{
              data_uncheck +=checks[i].value + "-";
            }
          }
        if(data_uncheck=='')
          { data_uncheck1='none'; }
        else{ data_uncheck1=data_uncheck;}
        if(data_check=='')
          { data_check1='none'; }
        else{ data_check1=data_check;}
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
            
            document.getElementById('ss').innerHTML=xmlhttp.responseText;
            
            }
          }
        
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/save_disable/"+disable+"/"+data_check1+"/"+data_uncheck1+"/"+company+"/"+account_management_policy_id+"/"+division+"/"+department+"/"+section,true); 
        xmlhttp.send(); 
        alert("Disable Account is successfully updated");
      
    }

    //generate fields
    function other_add_fields(option_results,no_fields)
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
                  document.getElementById("fields_fillup").innerHTML=xmlhttp.responseText;
                }
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/generate_fields/"+option_results+"/"+no_fields,true);
                xmlhttp.send();
      }
    }

    function input_format(field_no,input_type)
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
                  document.getElementById("format"+field_no).innerHTML=xmlhttp.responseText;
                }
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/input_format/"+field_no+"/"+input_type,true);
                xmlhttp.send();
      }

    }
     //save govt_fields
    function save_others(action,option,account_management_policy_id)
    {
   
      var tbl_values = new Array();
      var r_table = document.getElementById('table_others');
      var field_no = document.getElementById('item_count');
      var rowLength = r_table.rows.length;
      var loop = 1;
      var loopb = 1;
      for (i = 1; i < rowLength; i++){
      tbl_values.push($('#data' + loop).val());
      tbl_values.push($('#fieldno' + loop).val());

      loopb++;
      loop++;
      }

      var converted = tbl_values.toString();
      var converted1 = tbl_values.join("qq");
      {
        $("#save_disable").hide();
        $("#loaderr").show();

        if($('#loaderr').is(':visible'))
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/save_others_data/"+loop+"/"+converted1+"/"+action+"/"+option+"/"+account_management_policy_id,true);
                    xmlhttp.send();

            setTimeout(function(){
               xmlhttp2.send();
            },2000); 

        }
      }

    }
    function disabled_other_form()
    {
      var field_no = document.getElementById('item_counts').value;
      $("#other_update_form").show();
      $("#other_form").hide();
      for (i=1; i < field_no; i++)
      { 
      var a = 'data' + i;
      document.getElementById(a).disabled=false;
      }
    }

    //save update others
    function save_update_others(action,option,account_management_policy_id)
    {
   
      var tbl_values = new Array();
      var r_table = document.getElementById('table_others_update');
      var field_no = document.getElementById('item_counts');
      var rowLength = r_table.rows.length;
      var loop = 1;
      var loopb = 1;
      for (i = 1; i < rowLength; i++){
      tbl_values.push($('#data' + loop).val());
      tbl_values.push($('#fieldno' + loop).val());

      loopb++;
      loop++;
      }

      var converted = tbl_values.toString();
      var converted1 = tbl_values.join("qq");
      {
        $("#other_update_form").hide();
        $("#loaderr").show();
      

        if($('#loaderr').is(':visible'))
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
                xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/save_others_data/"+loop+"/"+converted1+"/"+action+"/"+option+"/"+account_management_policy_id,true);
                  xmlhttp.send();
             setTimeout(function(){
               xmlhttp2.send();
            },2000); 
        }
      }
    }
    function designation(option)
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
                  document.getElementById("designation_actions").innerHTML=xmlhttp.responseText;
                }
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/designation_filter/"+option,true);
                xmlhttp.send();
       }
    
    }

      function result_onchange_val(option,val)
     { 
       
        var company_id= document.getElementById("company").value;
       
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
                  if(option=='division'){ document.getElementById("division").innerHTML=xmlhttp.responseText; }
                  else if(option=='department'){ document.getElementById("department").innerHTML=xmlhttp.responseText; }
                  else if(option=='section'){ document.getElementById("section").innerHTML=xmlhttp.responseText; }
                  else if(option=='subsection'){ document.getElementById("subsection").innerHTML=xmlhttp.responseText; }
                  else if(option=='classification'){ document.getElementById("classification").innerHTML=xmlhttp.responseText; }
                  else if(option=='location'){ document.getElementById("location").innerHTML=xmlhttp.responseText; }
                } 
              }
              if(option=='department' || option=='classification' || option=='location')
              { xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/result_onchange_val/"+option+"/"+company_id,true); }
            
            else{ xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/result_onchange_val/"+option+"/"+val,true); }
            xmlhttp.send();
            }
     }

     function save_designantion_value()
     {
          var company= document.getElementById("company").value;
          var division= document.getElementById("division").value;
          var department= document.getElementById("department").value;
          var section= document.getElementById("section").value;
          var subsection = document.getElementById("subsection").value;
          var location_check = document.getElementsByClassName("location");
          var status = document.getElementById("status").value;
          var l= document.getElementById("c_location").value;
          var c = document.getElementById("c_classification").value;
          var no_to_view = document.getElementById("no_to_view").value;
          var view_option = document.getElementById("view_option").value;
          var account_management_policy_id = document.getElementById("account_management_policy_id").value;

          var location='';

                    for (i=0;i<l; i++)
                    {
                      if (location_check[i].checked === true)
                      {
                        location +=location_check[i].value + "-";                }
                    }
          var classification_check = document.getElementsByClassName("classification");
          var classification='';

                    for (i=0;i<c; i++)
                    {
                      if (classification_check[i].checked === true)
                      {
                        classification +=classification_check[i].value + "-";                }
                    }

          var employment_check = document.getElementsByClassName("employment");
          var employment='';

                    for (i=0;i<4; i++)
                    {
                      if (employment_check[i].checked === true)
                      {
                        employment +=employment_check[i].value + "-";                }
                    }
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
                xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/save_designation_value/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+status+"/"+location+"/"+classification+"/"+employment+"/"+no_to_view+"/"+view_option+"/"+account_management_policy_id,true);
                xmlhttp.send();
      }

     }

     function save_all_value()
     {
        var no_to_view = document.getElementById("no_to_view").value;
        var view_option = document.getElementById("view_option").value;
        var account_management_policy_id = document.getElementById("account_management_policy_id").value;
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
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/notif_save_all/"+no_to_view+"/"+view_option+"/"+account_management_policy_id,true);
              xmlhttp.send();
            }
            
     }


     //notif all option
     function notif_action(action,account_management_policy_id,option)
     {
   		var company_id = document.getElementById("notif_company_id").value;

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
                  document.getElementById(action).innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/notif_action/"+action+"/"+account_management_policy_id+"/"+option+"/"+company_id,true);
              xmlhttp.send();
            }
     }
    
    //save notif all by company
    function save_notifdata_all(option,account_management_policy_id)
    {
    	var company_id = document.getElementById("notif_company_id").value;
    	var  comp_option = document.getElementById("notif_option_res").value;
    	var  notif_days_view = document.getElementById("notif_days_view").value;
      if(notif_days_view=='')
      { alert("Please fill up the Days to View notification to continue"); }
      else{
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
                  document.getElementById('fetch_all_result').innerHTML=xmlhttp.responseText;
                   $("#table_show_notif").DataTable({
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      }); 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/save_notifdata_all/"+company_id+"/"+comp_option+"/"+account_management_policy_id+"/"+notif_days_view,true);
              xmlhttp.send();
            }
      }
      
    }

    //update form
    function updateform_notif_all(option,company_id,account_management_policy_id)
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
                  document.getElementById('notification_main_div').innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/updateform_notif/"+option+"/"+company_id+"/"+account_management_policy_id,true);
              xmlhttp.send();
            }
    }
    //save notif multi
    function save_notifdata_multi(option,account_management_policy_id)
    {
    	var  company_id = document.getElementById("notif_company_id").value;
    	var  comp_option = document.getElementById("notif_option_res").value;
    	var  notif_days_view = document.getElementById("notif_days_view").value;
    	var  count = document.getElementById("count").value;
    	var checks = document.getElementsByClassName("n_company");
    	var data_check=''; 
        for (i=0; i < count; i++)
          { 
            if(checks[i].checked === true)
            { 
             data_check +=checks[i].value + "-";
            }
            else{
              
            }
          }
        if(notif_days_view=='')
          { alert("Please Fill Up Days to View Notification to continue"); }
        else if(data_check=='')
            { alert("Please Choose Alteast One comapany to continue"); }
        else{
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
                  document.getElementById('fetch_all_result').innerHTML=xmlhttp.responseText; 
                  $("#table_show_notif").DataTable({
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      }); 
                } 
              } 
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/save_notifdata_multi/"+company_id+"/"+comp_option+"/"+account_management_policy_id+"/"+notif_days_view+"/"+data_check,true);
              xmlhttp.send();
            }
          }
          
    }

    //get department based on division or company
    function get_data_department(options,value)
    { 
          $("#section").load(location.href + " #section");
          $("#subsection").load(location.href + " #subsection");
        var  company_id = document.getElementById("compp").value;
        var  count = document.getElementById("c_division").value;
        var  data_class = document.getElementsByClassName("division");

        if(value=='no_data')
        {
            var datas = value;
        }
       
        else{
            
            var datas='';
            for (i=0;i<count; i++)
            {
                if (data_class[i].checked === true)
                {
                  datas +=data_class[i].value + "-";
                }
              }
            }
        if(datas=='')
          { $("#department").load(location.href + " #department");
            alert('Please Check atleast one to continue'); }
        else {

          {
             document.getElementById("division_value").value = datas;
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
                  document.getElementById(options).innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/get_data_department/"+options+"/"+datas+"/"+company_id,true);
              xmlhttp.send();
            }
        }

    }

    //get section list

     //get department based on division or company
    function get_data_section(options,value)
    { 
         $("#subsection").load(location.href + " #subsection");
        var  company_id = document.getElementById("compp").value;
        var  count = document.getElementById("c_department").value;
        var  division = document.getElementById("division_value").value;
        var  data_class = document.getElementsByClassName("departments");

        if(value=='no_div')
        {
            var datas = value;
        }
        else if(value == 'All')
        {
           if(document.getElementById("All_d").checked)
           {
            var datas = 'All';
           }
           else{ 
              var datas = ''; 
               for (i=0;i<count; i++)
                {
                    if (data_class[i].checked === true)
                    {
                      datas +=data_class[i].value + "-";
                    }
                  }
              }
            
        }
        else{
            
            var datas='';
            for (i=0;i<count; i++)
            {
                if (data_class[i].checked === true)
                {
                  datas +=data_class[i].value + "-";
                }
              }
            }
        
        if(datas=='')
          { $("#section").load(location.href + " #section");
            alert('Please Check atleast one to continue'); }
        else { document.getElementById("department_value").value = datas;
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
                  document.getElementById(options).innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/get_data_section/"+options+"/"+datas+"/"+company_id+"/"+division,true);
              xmlhttp.send();
            }
        }
    }

  function get_data_subsection(options,value)
    { 

        var  company_id = document.getElementById("compp").value;
        var  count = document.getElementById("c_section").value;
        var  division = document.getElementById("division_value").value;
        var  department = document.getElementById("department_value").value;
        var  data_class = document.getElementsByClassName("sections");
        
        if(value=='no_div')
        {
            var datas = value;
        }
        else if(value == 'All')
        {
           if(document.getElementById("All_s").checked)
           {
            var datas = 'All';
           }
           else{ 
              var datas = ''; 
               for (i=0;i<count; i++)
                {
                    if (data_class[i].checked === true)
                    {
                      datas +=data_class[i].value + "-";
                    }
                  }
              }
            
        }
        else{
            
            var datas='';
            for (i=0;i<count; i++)
            {
                if (data_class[i].checked === true)
                {
                  datas +=data_class[i].value + "-";
                }
              }
            }
        
        if(datas=='')
          { $("#subsection").load(location.href + " #subsection");
            alert('Please Check atleast one to continue'); }
        else { document.getElementById("section_value").value = datas;
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
                  document.getElementById(options).innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/get_data_subsection/"+options+"/"+datas+"/"+company_id+"/"+division+"/"+department,true);
              xmlhttp.send();
            }
        }
    } 
     function get_data_sub_val(value)
     {

      var  count_subsection= document.getElementById("c_subsection").value;
      var  class_subsection = document.getElementsByClassName("subsections");
       if(value=='no_div')
        {
            var datas = 'All';
        }
        else if(value == 'All')
        {
           if(document.getElementById("All_ss").checked)
           {
            var datas = 'All';
           }
           else{ 
              var datas = ''; 
               for (i=0;i<count_subsection; i++)
                {
                    if (class_subsection[i].checked === true)
                    {
                      datas +=class_subsection[i].value + "-";
                    }
                  }
              }
        }
        else{
            
            var datas='';
            for (i=0;i<count_subsection; i++)
            {
                if (class_subsection[i].checked === true)
                {
                  datas +=class_subsection[i].value + "-";
                }
              }
            }
     document.getElementById("subsection_value").value = datas;
     }
    function save_notifdata_one_emp(action,option,account_management_policy_id)
    {

      var company = document.getElementById("notif_company_id").value;
      var company_view = document.getElementById("compp").value;
      var division = document.getElementById("division_value").value;
      var department = document.getElementById("department_value").value;
      var section = document.getElementById("section_value").value;
      var subsection = document.getElementById("subsection_value").value;
      var no_to_view = document.getElementById("oneemp_days_view").value;
      var view_option = document.getElementById("notif_option_res").value;

     
      var count_l = document.getElementById("c_location").value;
      var class_location = document.getElementsByClassName("location");
      var location ='';
      for (i=0;i<count_l; i++)
            {
                if (class_location[i].checked === true)
                {
                  location +=class_location[i].value + "-";
                }
              }
      var class_status = document.getElementsByClassName("emp_status");
      var status ='';
      for (i=0;i<2; i++)
            {
                if (class_status[i].checked === true)
                {
                  status +=class_status[i].value + "-";
                }
              }
      var count_e = document.getElementById("c_employment").value;
      var class_employment = document.getElementsByClassName("employment");
      var employment ='';
      for (i=0;i<count_e; i++)
            {
                if (class_employment[i].checked === true)
                {
                  employment +=class_employment[i].value + "-";
                }
              }
      var count_c = document.getElementById("c_classification").value;
      var class_classification = document.getElementsByClassName("classification");
      var classification ='';
      for (i=0;i<count_c; i++)
            {
                if (class_classification[i].checked === true)
                {
                  classification +=class_classification[i].value + "-";
                }
              }
      if(company=='' || division=='' || department=='' || section=='' || subsection=='' || classification=='' || employment=='' || location=='' || status=='' || no_to_view=='' || view_option=='' || company_view=='')
        { alert("Please Fill Up all Fields to continue"); }
      else
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
                  document.getElementById('fetch_all_result').innerHTML=xmlhttp.responseText; 
                   $("#table_show_notif").DataTable({
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      }); 
                } 
              }
            if(action=='insert')
               { 
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/save_notif_one_emp/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification+"/"+employment+"/"+status+"/"+location+"/"+account_management_policy_id+"/"+no_to_view+"/"+view_option+"/"+company_view,true);
               }
            else
               { 
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/saveupdate_notif_one_emp/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification+"/"+employment+"/"+status+"/"+location+"/"+account_management_policy_id+"/"+no_to_view+"/"+view_option+"/"+company_view,true);
               }
              xmlhttp.send();
       }        
     }
    }
    function fetch_company(options,company_id)
    {
      document.getElementById("company_id_fetch").value = company_id;
            $("#department").load(location.href + " #department");
            $("#section").load(location.href + " #section");
            $("#subsection").load(location.href + " #subsection");
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
                  document.getElementById('division').innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/get_division_list/"+options+"/"+company_id,true);
              xmlhttp.send();
       }   
    }
    function delete_notif(options,company_id,account_management_policy_id)
    { 
      var result = confirm("Are you sure you want add new viewing option. The latest viewing set up will be deleted when you choose to continue?");
      if(result == false)
      {
      }
      else{
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
                  document.getElementById('fetch_all_result').innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/delete_notif/"+options+"/"+company_id+"/"+account_management_policy_id,true);
              xmlhttp.send();
       }   
     }
    }

    function updatesave_notif_all(options,company_id,account_management_policy_id)
    {
      var notif_days_view_update =  document.getElementById("notif_days_view_update").value;
      if(options=='All')
      {
        var datas = 'none';
      }
      else if(options=='One_specs')
      {
        var datas = 'none';
      }
      else if(options=='Multi')
      {
        var  data_class = document.getElementsByClassName("n_company_update");
        var count =  document.getElementById("count_update").value;
        var datas='';
        for (i=0;i<count; i++)
            {
              if (data_class[i].checked === true)
                {
                   datas +=data_class[i].value + "-";
                }
            }
      }
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
                  document.getElementById('fetch_all_result').innerHTML=xmlhttp.responseText; 
                  $("#table_show_notif").DataTable({
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      }); 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/update_notif_all/"+options+"/"+datas+"/"+company_id+"/"+account_management_policy_id+"/"+notif_days_view_update,true);
              xmlhttp.send();
       }  

    }
     function view(option) {
       
         $("#" + option).show();
     }

     function mob_tel_action(val)
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
                  document.getElementById('mob_tel_action').innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_account_management/view_location_list/"+val,true);
              xmlhttp.send();
       
     }

   
  </script>

    <footer class="footer">
    <div class="container-fluid">
    <br>
    <strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.
    <span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
    </div>
    </footer>
    <!--END footer-->
    <!--//==========Start Js/bootstrap==============================//-->
   <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <!--//==========End Js/bootstrap==============================//-->
