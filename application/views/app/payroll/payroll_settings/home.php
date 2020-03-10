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
      payroll
       <small>Payroll Settings</small><br>
</head>
<body>

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Payroll</a></li>
      <li class="active">Payroll Settings</li>
    </ol>
  </section>
  <br>
  <div class="col-sm-4" >
      <div class="box box-solid box-success">
        <div class="box-header">
        <h5 class="box-title"><i class='fa fa-cog fa-spin'></i> <span> Payroll Settings</span></h5>
         <a class='fa fa-caret-square-o-right pull-right' aria-hidden='true' data-toggle='tooltip' title='Click to view system policy!' onclick="view_policy_list()"></a>
        <a class='fa fa-plus-square pull-right' aria-hidden='true' data-toggle='tooltip' title='Click to add new system policy!' onclick="add_system_policy()"></a>
       </div>
        <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark"">
        <input type="hidden" id="converted_char_title">
        <input type="hidden" id="converted_char_dropdown">
        <input type="hidden" id="converted_char_single_data">
          <div id="fetch_company_result" style="height: 355px;overflow-y: auto;"> <!-- style="height: 652px;overflow-y: auto;"  -->
          <strong>Choose Company :</strong>
          <select  class="form-control" name="fetch_company" id="fetch_company" onchange="chooseCompany(this.value)">
            <option selected disabled>Select Company</option>
            <?php foreach ($companyList as $row) {
               echo "<option value='".$row->company_id."'>".$row->company_name."</option>";
            }?>
            </select>
            <br>
            <div class="box box-danger"></div>
               <div id="policy">
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
   
      function chooseCompany(company_id)
            {  
              $("#all_res").load(location.href + " #all_res");
              document.getElementById("result_company").value = company_id;
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
                xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/payroll_settings_list/"+company_id,true);
                xmlhttp.send();
                } 
                
            }
      function settings(val,payroll_main_id)
      {
          var company_id= document.getElementById("result_company").value;
          if(company_id=="")
          {  alert("Select company to continue"); }
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
                    document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/payroll_topic/"+val+"/"+company_id+"/"+payroll_main_id,true);
                xmlhttp.send();
                } 
           }
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

    function save_add(payroll_main_id)
    {
      var company_id= document.getElementById("result_company").value;
      var policy_id= document.getElementById("policy_id").value;
      var data= document.getElementById("data").value;
      function_escape("converted_char_single_data",data);
      var policy_company_id= document.getElementById("policy_company_id").value;
      var datas= document.getElementById("converted_char_single_data").value;
      if(data=='' || data=='no setting')
      { alert("Fill Up the field to continue"); }
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
                    document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                    $("#results_data").DataTable({
                            // destroy: true,           
                          });
                   setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                    }
                  }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/save_new_data/"+company_id+"/"+payroll_main_id+"/"+policy_id+"/"+datas+"/"+policy_company_id,true);
                xmlhttp.send();
          } 
        }

     
    }

    function update_form(payroll_main_id)
    {
      var company_id= document.getElementById("result_company").value;
      var policy_id= document.getElementById("policy_id").value;
      var policy_company_id= document.getElementById("policy_company_id").value;
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
             $("#results_data").DataTable({
                            // destroy: true,           
                          });
                   setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
          }
      }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/update_form/"+company_id+"/"+payroll_main_id+"/"+policy_id+"/"+policy_company_id,true);
          xmlhttp.send();
      } 
    }

    function save_update(payroll_setting_id,payroll_main_id)
    {
      var company_id= document.getElementById("result_company").value;
      var policy_id= document.getElementById("policy_id").value;
      var data= document.getElementById("data").value;
      function_escape("converted_char_single_data",data);
      var policy_company_id= document.getElementById("policy_company_id").value;
      var datas= document.getElementById("converted_char_single_data").value;
      if(data=='' || data=='no setting')
      { alert("Fill Up the field to continue"); }
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
                    document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                     $("#results_data").DataTable({
                            // destroy: true,           
                          });
                   setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/save_update_data/"+company_id+"/"+payroll_main_id+"/"+policy_id+"/"+datas+"/"+policy_company_id+"/"+payroll_setting_id,true);
                xmlhttp.send();
          } 
        }
    }

    //add policy

     function add_policy(add_policy_id)
    { 
       $("#all_res").load(location.href + " #all_res");
       var company_id= document.getElementById("result_company").value;
       var result = confirm("Are you sure you want to add this policy?");
      if(result == true)
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
                    document.getElementById("policy").innerHTML=xmlhttp.responseText;
                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/add_new_policy/"+company_id+"/"+add_policy_id,true);
                xmlhttp.send();
          } 
      }
      else{}
    }

    //save payroll period setting
     function save_setting_payroll_period(payroll_main_id) {
       
        var value1= document.getElementById("select1").value;
        var value2= document.getElementById("select2").value;
        var value3= document.getElementById("select3").value;
        var value4= document.getElementById("select4").value;
        var value5= document.getElementById("select5").value;
        var company_id= document.getElementById("result_company").value;
        var policy_id= document.getElementById("policy_id").value;
        var policy_company_id= document.getElementById("policy_company_id").value;

        if(value2!='All' &&  value5=='not_included' && value1=='Yes')
          {
          alert("Select Payroll Period to continue");
          }
        else if(value1=='No' &&  value5!='not_included')
          {
          alert("For not viewing payroll period select the (not included) in payroll period.");
          }
        else if(value5!='not_included' && value1=='Yes' && value2=='All')
        {
          alert("For viewing all payroll period select the (not included) in payroll period.");
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
                  document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                   $("#results_datas").DataTable({
                            // destroy: true,           
                          });
                   setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                  }
                }
              xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/save_with_payroll_period/"+company_id+"/"+payroll_main_id+"/"+policy_id+"/"+policy_company_id+"/"+value1+"/"+value2+"/"+value3+"/"+value4+"/"+value5,true);
              xmlhttp.send();
            }
        }
      }


  //add for employment classification
   function save_emp_class(payroll_setting_id,action,payroll_main_id)
    {
      var company_id= document.getElementById("result_company").value;
       var policy_id= document.getElementById("policy_id").value;
      var policy_company_id= document.getElementById("policy_company_id").value;

      var tbl_values = new Array();
      var r_table = document.getElementById('table_home');
      var rowLength = r_table.rows.length;
      var loop = 1;
      var loopb = 1;
      for (i = 1; i < rowLength; i++){
      var oCells = r_table.rows.item(i).cells;
      var cellLength = oCells.length;
      var cellVal = oCells.item(0).innerHTML;
          
      tbl_values.push($('#class' + loop).val());
      tbl_values.push($('#1' + loop).val());
      tbl_values.push($('#2' + loop).val());
      tbl_values.push($('#3' + loop).val());
      tbl_values.push($('#4' + loop).val());
      loopb++;
      loop++;
      }

      var converted = tbl_values.toString();
      var converted1 = tbl_values.join("-");

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
                  xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/save_employment_classification/"+company_id+"/"+payroll_main_id+"/"+policy_id+"/"+policy_company_id+"/"+converted1+"/"+loop+"/"+payroll_setting_id+"/"+action,true);
                  xmlhttp.send();
        } 
       
    }
    
    //get group paytype
     function select_3(pay_type)
      {
         var company_id= document.getElementById("result_company").value;
        $("#select5").load(location.href + " #select5");
       
        if(pay_type=='no_val')
        {
          document.getElementById("select4").disabled = true;
        }
        else
        {
           document.getElementById("select4").disabled = false;
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
                  document.getElementById("select4").innerHTML=xmlhttp.responseText;
                  }
                }
              xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/paytype_result/"+company_id+"/"+pay_type,true);
              xmlhttp.send();
            }
        }
      }

      function select_4(group)
      {
        var company_id= document.getElementById("result_company").value;
        var pay_type= document.getElementById("select3").value;
        if(group=='no_val')
        {
          document.getElementById("select5").disabled = true;
        }
        else
        {
           document.getElementById("select5").disabled = false;
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
                  document.getElementById("select5").innerHTML=xmlhttp.responseText;
                  }
                }
              xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/group_result/"+company_id+"/"+group+"/"+pay_type,true);
              xmlhttp.send();
            }
        }
      }
      //checking the chosen payroll period 
     
      function check_all(payroll)
      {
        if(payroll=='no_val')
        {
          document.getElementById("select1").disabled = true;
        }
        else
        {  
          document.getElementById("select1").disabled = false;
        }
      }

      function select_1(val)
      {
        var s5= document.getElementById("select5").value;
        if(val=='Yes' && s5!='not_included')
        {
          document.getElementById("select2").disabled = false;
         
        }
        else if(s5=='not_included' && val=='Yes')
        {
          
          document.getElementById("select2").disabled = false;
        }
        
        else
        {
           document.getElementById("select2").disabled = true;
          $("#save_button").show();
        }
      } 

        function select_2(val)
        {
          if(val=='no_val')
          {
            
            $("#save_button").hide();
          }
          else if(val=='not_included')
          {
            document.getElementById("select1").disabled = false;
          }
          else
          {
             
             $("#save_button").show();
          }
          
        }

        //delete payroll period data
    function delete_setting_payroll_period(payroll_setting_id,pay_type,group)
       {
        var company_id= document.getElementById("result_company").value;
        var payroll_main_id= document.getElementById("payroll_main_id").value;
        var policy_id= document.getElementById("policy_id").value;
        var policy_company_id= document.getElementById("policy_company_id").value;

         var result = confirm("Are you sure you want to delete this record?");
      if(result == true)
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
                 $("#results_datas").DataTable({
                            // destroy: true,           
                          });
                  setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/delete_setting_payroll_period/"+payroll_setting_id+"/"+pay_type+"/"+group+"/"+company_id+"/"+payroll_main_id+"/"+policy_id+"/"+policy_company_id,true);
            xmlhttp.send();
          }
      }
      else{}
    }


      //delete payroll period data
    function edit_setting_payroll_period(payroll_setting4_id,pay_type,group)
       {
        var company_id= document.getElementById("result_company").value;
        var payroll_main_id= document.getElementById("payroll_main_id").value;
        var policy_id= document.getElementById("policy_id").value;
        var policy_company_id= document.getElementById("policy_company_id").value;

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
                document.getElementById("setting_action").innerHTML=xmlhttp.responseText;
                
                  setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/editform_setting_payroll_period/"+payroll_setting4_id+"/"+pay_type+"/"+group+"/"+company_id+"/"+payroll_main_id+"/"+policy_id+"/"+policy_company_id,true);
            xmlhttp.send();
          }
    }
    function edit_allow(val)
    {
      var payroll= document.getElementById("edit_s4_val").value;
      if(val=='Yes'){ document.getElementById("edit_payroll_option").disabled = false; } 
      else if(val=='No' && payroll!='not_included'){ alert("For not viewing payroll period select the (not included) in payroll period.");
       document.getElementById("edit_payroll_option").disabled = true; }
    }

       //delete payroll period data
    function save_editsetting_payrollperiod (payroll_setting4_id,payroll_main_id)
       {
        var company_id= document.getElementById("result_company").value;
        var policy_id= document.getElementById("policy_id").value;
        var policy_company_id= document.getElementById("policy_company_id").value;
        var payroll= document.getElementById("edit_s4_val").value;
        var allow= document.getElementById("edit_allow_payroll").value;
        var option= document.getElementById("edit_payroll_option").value;
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
                 $("#results_datas").DataTable({
                            // destroy: true,           
                          });
                  setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/editsave_setting_payroll_period/"+payroll_setting4_id+"/"+payroll+"/"+allow+"/"+option+"/"+company_id+"/"+payroll_main_id+"/"+policy_id+"/"+policy_company_id,true);
            xmlhttp.send();
          }
    }

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
                xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/add_system_policy/",true);
                xmlhttp.send();
      } 
    }
    function input_type(input_type)
    {
       document.getElementById("field_datas").value = input_type;
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
                  document.getElementById("input_type").innerHTML=xmlhttp.responseText;
                }
              }
                xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/input_type/"+input_type,true);
                xmlhttp.send();
      } 
    }
    function input_format(input_format)
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
                  document.getElementById("input_format").innerHTML=xmlhttp.responseText;
                }
              }
                xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/input_format/"+input_format,true);
                xmlhttp.send();
      } 
      
    }
   
     function  save_system_policy()
    {  

       var titles = document.getElementById("add_policy").value;
       function_escape("converted_char_title",titles);
       var title= document.getElementById("converted_char_title").value;
       var field= document.getElementById("field_datas").value;
       var input_type= document.getElementById("input_type").value;
       var input_format_data= document.getElementById("input_format_data").value;
       function_escape("converted_char_dropdown",input_format_data);
       var input_format_datas= document.getElementById("converted_char_dropdown").value;

       if(title=='' || field=='' || input_type=='' || input_format_data=='')
       {
        alert('Please fill up all fields to continue');
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
                  document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                  $("#table_home").DataTable({
                            // destroy: true,           
                          });
                  setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
                xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/save_system_policy/"+title+"/"+field+"/"+input_type+"/"+input_format_datas,true);
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

    function  view_policy_list()
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
                  $("#table_home").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]                     
                          });
                  setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
                xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/system_policy_list/",true);
                xmlhttp.send();
      }  
    }
   
    function   delete_policy(payroll_main_id)
    {
        var result = confirm("Are you sure you want to delete this record?");
      if(result == true)
      { $("#policy").load(location.href + " #policy");
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
                  $("#table_home").DataTable({
                            // destroy: true,           
                          });
                  setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
                xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/delete_policy/"+payroll_main_id,true);
                xmlhttp.send();
      }  
    }
    else{}
    }
   function   edit_policy(payroll_main_id)
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
                  $("#table_home").DataTable({
                            // destroy: true,           
                          });
                  setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
                xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/edit_policy/"+payroll_main_id,true);
                xmlhttp.send();
      }  
   
    }

    function saveupdate_system_policy(payroll_main_id)
    {
       var title = document.getElementById("add_policy").value;
       var field= document.getElementById("field_datas").value;
       var input_type= document.getElementById("input_type").value;
       var input_format_data= document.getElementById("input_format_data").value;
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
                  $("#table_home").DataTable({
                            // destroy: true,           
                          });
                  setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
                xmlhttp.open("GET","<?php echo base_url();?>app/payroll_settings_controller/saveupdate_system_policy/"+payroll_main_id+"/"+field+"/"+input_type+"/"+input_format_data+"/"+title,true);
                xmlhttp.send();
      } 
    }
  </script>

    <footer class="footer">
    <div class="container-fluid">
    <br>
    <strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.
    <span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
    </div>
    </footer>
    <!--END footer
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
