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
      Administrator
       <small>Section Managers</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Administrator</a></li>
      <li class="active">Section Manager</li>
    </ol>
  </section>
  <br>
  
   <div class="col-sm-3" style="height:auto;padding-bottom: 30px;">
       <div class="box box-solid box-success">
       <div class="box-header">
        <h5 class="box-title"><i class='fa fa-cogs'></i> <span>Section Managers</span></h5>
        </div>
        
        <div class="panel panel-danger">
            <div class="panel-heading">
              <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse"><h4 class="box-title"><i class='fa fa-user'></i> <span>Manage Section Manager</span></h4></a>
              </h4>
            </div>
            <div id="collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                  <ul>
                    <li class="set_text"><a style='cursor: pointer;' onclick="add_section_manager('Section','Add');">Add New Section Manager</a></li>
                    <li class="set_text"><a style='cursor: pointer;' onclick="view_section_manager('Section','View');">View Section Manager</a></li>
                    <li><a style='cursor: pointer;' onclick="delete_section_manager('Section','Delete');">Delete Section Managers</a></li>
                  </ul>
                </div>
            </div><br>
            <div class="panel-heading">
              <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse2"><h4 class="box-title"><i class='glyphicon glyphicon-cog '></i> <span>Section Manager Setting</span></h4></a>
              </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse in">
                <div class="panel-body">
                  <ul>
                    <li class="set_text"><a style='cursor: pointer;' onclick="setup_setting_class_level('Setting','Add');">By Classification/Level</a></li>
                    <li class="set_text"><a style='cursor: pointer;' onclick="setup_allow_access('Setting','Add');">Allow to access personnel working schedule?</a></li>
                </ul>
                </div>
            </div><br>
        </div>
        </div>
        <div class="btn-group-vertical btn-block"></div>  
        </div>
      </div>  
  <div class="col-md-9" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result"><br>
            <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Section Manager Settings</h4></ol>
            <div style="height: 305 px";></div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
  	 <div class="modal modal-primary fade" id="search_employee_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Select Employee</h4>
                  </div>
                 <div class="modal-body">                             
                    <input onKeyUp="employee_list(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                    <span id="Search_Employee_Results"></span>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>                          
            </div>
        </div>
    </div>
    <!--Start footer-->
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

<script>

  function add_section_manager(option,action)
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
            	document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/add_section_manager/"+option+"/"+action,false);
        xmlhttp2.send();

  }
  
   function get_section(val)
        {  
          var div = document.getElementById('division').value;
          var dept = document.getElementById('department').value;
          var company = document.getElementById('company').value;

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
             document.getElementById("Section_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/load_section/"+val+"/"+div+"/"+dept,false);
        xmlhttp2.send();

        }

   function get_subsection(val)
    {
        var div = document.getElementById('division').value;
        var dept = document.getElementById('department').value;
        var company = document.getElementById('company').value;

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
            document.getElementById("Subsection_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/load_subsection/"+val+"/"+div+"/"+dept+"/"+company,false);
        xmlhttp2.send();
      
  }
  function view_section_manager(option,action)
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
            document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
               $("#view_section_manager").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/view_section_manager/"+option+"/"+action,false);
        xmlhttp2.send();

  }

  function setup_setting_class_level(option,action)
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
            document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
             $("#classlevel").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/setup_setting_class_level/"+option+"/"+action,false);
        xmlhttp2.send();
  }


  function save_level_classification_setting(action)
  {
  	var company = document.getElementById('company_classlevel').value;
  	var option = document.getElementById('class_level_option').value;
  
  	if(company=='' || option=='')
  		{ alert("Please fill up all fields to continue"); }
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
            document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
             $("#classlevel").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
             setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/save_level_classification_setting/"+action+"/"+company+"/"+option,false);
        xmlhttp2.send();
    }
  }

  function deleteDetails(id)
  {
  	
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
            document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
             $("#classlevel").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
                            setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/delete_level_classification_setting/"+id,false);
        xmlhttp2.send();
       } 
  }
   function editDetails(id,company)
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
            document.getElementById("add_edit").innerHTML=xmlhttp2.responseText;

            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/editform_level_classification_setting/"+id+"/"+company,false);
        xmlhttp2.send();
      
  }

  function setup_allow_access(option,action) 
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
            document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
             $("#settingaccess").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/setup_allow_access/"+option+"/"+action,false);
        xmlhttp2.send();  	
  }
   function save_allow_access_setting(action)
  {
  	var company = document.getElementById('company_allow').value;
  	var option = document.getElementById('option_allow').value;
  	if(company=='' || option=='')
  		{ alert('Please fill up all fields to continue'); }
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
            document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
             $("#settingaccess").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
             setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/save_allowaccess_setting/"+action+"/"+company+"/"+option,false);
        xmlhttp2.send();
    }
  }
   function deleteDetails_allowaccess(id)
  {
  	
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
            document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
             $("#settingaccess").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
             setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/delete_allow_access_setting/"+id,false);
        xmlhttp2.send();
       } 
  }
   function editDetails_allowaccess(id)
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
            document.getElementById("add_edit").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/editform_allow_access_setting/"+id,false);
        xmlhttp2.send();
  }

  function delete_section_manager(option,action)
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
            document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
             $("#section_mgrs").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/delete_section_manager/"+option+"/"+action,false);
        xmlhttp2.send();
  }
   //list of search employees
   function employee_list(val)
      {

      var company_id= document.getElementById("Company_result").value;

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
            document.getElementById("Search_Employee_Results").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/search_employee_list/"+val+"/"+company_id,true);
        xmlhttp.send();
        }
    }
    function select_emp(id,name)
    { 
      document.getElementById("result_employee").value = id;  
      document.getElementById("search_employee").value = name;
      document.getElementById("cSearch").value =''; 
    }

  

  function delete_section_mngrs(val)
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
            document.getElementById("delete_section_mangers_list").innerHTML=xmlhttp.responseText;
             $("#delete_list").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/delete_section_mngrs/"+val,true);
        xmlhttp.send();
        } 
       
  }

  function delete_selected_company(id)
  {
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
              document.getElementById("delete_section_mangers_list").innerHTML=xmlhttp.responseText;
               $("#delete_list").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/delete_selected_company/"+id,true);
          xmlhttp.send();
          } 
        }
    else{}
  }

function delete_manager_one(id,company)
{     
    

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
                document.getElementById("viewing_filtering").innerHTML=xmlhttp.responseText;
                 $("#section_managers").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/delete_one_sectionmanagers/"+id+"/"+company,true);
            xmlhttp.send();
            } 
          }
      else{}
}

function status_manager_one(company_id,id,value)
{
   
 if(value==1)
 { var result = confirm("Are you sure you want to disable the section manager?"); }
else { var result = confirm("Are you sure you want to enable the section manager?"); }
   
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
                document.getElementById("viewing_filtering").innerHTML=xmlhttp.responseText;
                 $("#section_managers").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/status_one_sectionmanagers/"+company_id+"/"+id+"/"+value,true);
            xmlhttp.send();
            } 
          }
      else{}
}

function load_list()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
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
            document.getElementById("viewing_filtering").innerHTML=xmlhttp.responseText;
             $("#section_managers").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/section_managers/"+company,true);
        xmlhttp.send();
    } 
}

function filter_division()
{ 
  var xmlhttp;
  var company = document.getElementById('company').value;
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
                document.getElementById("division").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/division_filtering/"+company,true);
            xmlhttp.send();
            } 
}

function load_withdivision()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
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
            document.getElementById("viewing_filtering").innerHTML=xmlhttp.responseText;
             $("#section_managers").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/section_managers_withdivision/"+company+"/"+division,true);
        xmlhttp.send();
    } 
}
function load_withdepartment()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
  var department = document.getElementById('department').value;
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
            document.getElementById("viewing_filtering").innerHTML=xmlhttp.responseText;
             $("#section_managers").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/section_managers_withdepartment/"+company+"/"+division+"/"+department,true);
        xmlhttp.send();
    } 
}
function filter_dept()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
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
                document.getElementById("department").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/departments_filtering/"+company+"/"+division,true);
            xmlhttp.send();
     } 
}
function filter_section()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
  var department = document.getElementById('department').value;
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
                document.getElementById("section").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/sections_filtering/"+company+"/"+division+"/"+department,true);
            xmlhttp.send();
     } 
}
function load_withsection()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
  var department = document.getElementById('department').value;
  var section = document.getElementById('section').value;
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
            document.getElementById("viewing_filtering").innerHTML=xmlhttp.responseText;
             $("#section_managers").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/section_managers_withsection/"+company+"/"+division+"/"+department+"/"+section,true);
        xmlhttp.send();
    } 
}

function filter_subsection()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
  var department = document.getElementById('department').value;
  var section = document.getElementById('section').value;
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
                document.getElementById("subsection").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/subsections_filtering/"+company+"/"+division+"/"+department+"/"+section,true);
            xmlhttp.send();
     } 
}
function load_withsubsection()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
  var department = document.getElementById('department').value;
  var section = document.getElementById('section').value;
  var subsection = document.getElementById('subsection').value;
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
            document.getElementById("viewing_filtering").innerHTML=xmlhttp.responseText;
             $("#section_managers").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/section_managers_withsubsection/"+company+"/"+division+"/"+department+"/"+section
          +"/"+subsection,true);
        xmlhttp.send();
    } 
}

function filter_location()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
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
                document.getElementById("location").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/locations_filtering/"+company,true);
            xmlhttp.send();
     } 
}
function load_withlocation()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
  var department = document.getElementById('department').value;
  var section = document.getElementById('section').value;
  var subsection = document.getElementById('subsection').value;
  var location = document.getElementById('location').value;
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
            document.getElementById("viewing_filtering").innerHTML=xmlhttp.responseText;
             $("#section_managers").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/section_manager/section_managers_withlocation/"+company+"/"+division+"/"+department+"/"+section
          +"/"+subsection+"/"+location,true);
        xmlhttp.send();
    } 
}


function enabled_class_level_option()
{
  document.getElementById('class_level_option').disabled=false;
}

//for adding new section manager
function loadDivision(val)
        {  
       
          loadLocation(val);
          
          var xmlhttp;
        
          document.getElementById('Department_result').disabled=false;
          document.getElementById('Section_result').disabled=false;
          document.getElementById('Subsection_result').disabled=false;

          document.getElementById('Department_result').value='0';
          document.getElementById('Section_result').value='0';
          document.getElementById('Subsection_result').value='0';

          document.getElementById("result_employee").value = '';  
          document.getElementById("search_employee").value = '';
          document.getElementById("cSearch").value =''; 
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
               document.getElementById("Division_result").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/load_division/"+val,false);
          xmlhttp2.send();

        }
function loadLocation(val)
{
  var xmlhttp;
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
             document.getElementById("Location_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/loadLocation/"+val,false);
        xmlhttp2.send();
}
function loadDept(val)
        {  
          var division = document.getElementById('Division_result').value;
          var company = document.getElementById('Company_result').value;
          if(val=='All')
          {
            document.getElementById('Department_result').value='All';
            document.getElementById('Department_result').disabled=true;

            document.getElementById('Section_result').value='All';
            document.getElementById('Section_result').disabled=true;

            document.getElementById('Subsection_result').value='All';
            document.getElementById('Subsection_result').disabled=true;
          }
        else{
          document.getElementById('Department_result').disabled=false;
          document.getElementById('Section_result').disabled=false;
          document.getElementById('Subsection_result').disabled=false;

          document.getElementById('Department_result').value='0';
          document.getElementById('Section_result').value='0';
          document.getElementById('Subsection_result').value='0';

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
             document.getElementById("Department_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/load_dept/"+val+"/"+company,false);
        xmlhttp2.send();
        }
        }
   function get_section(val)
        {  
          var div = document.getElementById('Division_result').value;
          var dept = document.getElementById('Department_result').value;
          var company = document.getElementById('Company_result').value;

        if(dept=='All'){

          document.getElementById('Section_result').disabled=true;
          document.getElementById('Subsection_result').disabled=true;

          document.getElementById('Section_result').value='All';
          document.getElementById('Subsection_result').value='All';

        }
          else{
          document.getElementById('Section_result').disabled=false;
          document.getElementById('Subsection_result').disabled=false;

          document.getElementById('Section_result').value='0';
          document.getElementById('Subsection_result').value='0';
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
             document.getElementById("Section_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/load_section/"+val+"/"+div+"/"+dept,false);
        xmlhttp2.send();
          }
        }
         function get_subsection(val)
    {
          var div = document.getElementById('Division_result').value;
          var dept = document.getElementById('Department_result').value;
          var company = document.getElementById('Company_result').value;
       if(val=='All'){

          document.getElementById('Subsection_result').disabled=true;

          document.getElementById('Subsection_result').value='All';

        }
          else{
          document.getElementById('Subsection_result').disabled=false;

          document.getElementById('Subsection_result').value='0';

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
            document.getElementById("Subsection_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/load_subsection/"+val+"/"+div+"/"+dept+"/"+company,false);
        xmlhttp2.send();
      }
  }

   function save_section_mngr()
  {
    var company = document.getElementById('Company_result').value;
    var division = document.getElementById('Division_result').value;
    var department = document.getElementById('Department_result').value;
    var section = document.getElementById('Section_result').value;
    var subsection = document.getElementById('Subsection_result').value;
    var employee_id = document.getElementById('result_employee').value;
    var location = document.getElementById('Location_result').value;
   
   if(company==0 || division==0 ||department==0 ||section==0 ||subsection==0 ||employee_id==0 || location==0)
    { 
      alert("Please fill up all fields to continue saving");
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
             document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
               $("#view_section_manager").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/section_manager/save_section_mngr/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+employee_id+"/"+location,false);
        xmlhttp2.send();
    }
  }


</script>