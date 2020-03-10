
<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_user=$this->session->userdata('add_user');
$edit_user=$this->session->userdata('edit_user');
$view_user=$this->session->userdata('view_user');
$enable_disable_user=$this->session->userdata('enable_disable_user');
    //$system_defined_icons = $this->general_model->system_defined_icons();
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>



<body onLoad="autoload();">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Administrator
    <small>User Directory</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Administrator</li>
    <li class="active">User Directory</li>
  </ol>
</section>

      <section class="content"> 

        <div class="box box-primary">        
        <?php echo $message;?>
        <?php echo validation_errors(); ?>
        <br>

          <div class="box-header">
                <a href="#filter" role="button" data-toggle="collapse" class="btn btn-warning btn-xs"><i class="fa fa-arrow-down"></i> More Filter Options</a>

<a  type="button" class="<?php echo $add_user;?> btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#showEmployeeList">
      <?php
      echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
      ?>  

 Add System User</a>
          </div><!-- /.box-header -->

                <div class="box-body">
                  <div class="collapse" id="filter">
                    <!-- <form class="" name="myForm"> -->
                    <div class="well">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="department">Department</label>
                          <select class="form-control select2" name="department" id="department" style="width: 100%;" onchange="applyFilter2()">
                            <option selected="selected" value="0">-All Departments-</option>
                            <?php 
                              foreach($departmentList as $department){
                              if($_POST['department'] == $department->department_id){
                                  $selected = "selected='selected'";
                              }else{
                                  $selected = "";
                              }
                              ?>
                              <option value="<?php echo $department->department_id;?>" <?php echo $selected;?>><?php echo $department->dept_name;?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>
<script>                      
    function getSection()
        {          
             
          $("#secMsg").attr('class','text-danger');
          $("#section").attr('disabled','disabled');       
      }

    function applyFilter()
        {  

        var department = document.getElementById("department").value;
        var section = document.getElementById("section").value;
        var user_role = document.getElementById("user_role").value;
        var status = document.getElementById("status").value;
            
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
            
            document.getElementById("search_here").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/user/search/"+department+"/"+section+"/"+user_role+"/"+status,false);
        xmlhttp.send();


        $("#user_table").DataTable();

        }

    function applyFilter2()
        {  

        var department = document.getElementById("department").value;
        var section = document.getElementById("section").value;
        var user_role = document.getElementById("user_role").value;
        var status = document.getElementById("status").value;
            
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
            
            document.getElementById("search_here").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/user/search/"+department+"/"+section+"/"+user_role+"/"+status,false);
        xmlhttp.send();

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
            
            document.getElementById("here").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/user/get_section/"+department,false);
        xmlhttp2.send();


        $("#user_table").DataTable();

        }
    </script>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="section">Section</label>
                          <div id="here">
                            <input type="text" class="form-control" placeholder="-All Sections-" onclick="getSection()">
                            <input type="hidden" class="form-control" id="section" placeholder="Section" onclick="getSection()" value="0">

                            <span id="secMsg" class="hidden">Select a department first.</span>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control select2" name="user_role" id="user_role" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="0">-All Employments-</option>
                            <?php 
                              foreach($userRoleList as $user_role){
                              if($_POST['user_role'] == $user_role->role_id){
                                  $selected = "selected='selected'";
                              }else{
                                  $selected = "";
                              }
                              ?>
                              <option value="<?php echo $user_role->role_id;?>" <?php echo $selected;?>><?php echo $user_role->role_name;?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">                        
                        <div class="form-group">
                          <label>Status</label>
                          <select class="form-control select2" id="status" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="2">-All Status-</option>
                            <option value="0">Active</option>
                            <option value="1">Inactive</option>
                          </select>
                        </div><!-- /.form-group -->
                      </div>

                    </div>
                    <div class="row">

                      <div class="col-md-3"></div>

                      <div class="col-md-3"></div>

                      <div class="col-md-3"></div>

                      <div class="col-md-3"></div>

                    </div>
                    </div> <!-- end well -->

                    <!-- </form> -->

                    </div>

                  </div>

          <div class="box-body">
              <div id="search_here">
              <table id="user_table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Employee ID</th>
                    <th>Username</th>
                    <th>Employee Name</th>
                    <th>User Role</th>
                    <th>Department</th>
                    <th>Section</th>
                    <th>Status</th>
                    <th>Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($user as $user){if($user->InActive == 0){ $inactive = 'Active';}else{ $inactive = 'Inactive';}
if($user->serttech_account=='1'){

}else{


                  ?>

                  <tr <?php if($user->InActive == 1){echo 'class="text-danger"';}else{echo 'class="text-success"';} ?>>
                    <td><?php echo $user->employee_id?></td>
                    <td><?php echo $user->username?></td>
                    <td><?php echo $user->name?></td>
                    <td><?php echo $user->role_name?></td>
                    <td><?php echo $user->dept_name?></td>
                    <td><?php echo $user->section_name?></td>
                    <td><?php echo $inactive?></td>
                    <td>

                    <?php if($user->InActive == 0){ 

        $enable = anchor('app/user/deactivate_user/'.$user->internal_id,'<i class="'.$enable_disable_user.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Deactivate','onclick'=>"return confirm('Are you sure you want to deactivate ".$user->name."?')"));

        $edit = anchor('app/user/user_profile/'.$user->internal_id.'/edit','<i class="'.$edit_user.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Edit'));

        $view = anchor('app/user/user_profile/'.$user->internal_id.'/view','<i class="'.$view_user.' fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'View'));

        echo $enable.' '.$edit.' '.$view;

             }else{
              
        echo $disable = anchor('app/user/activate_user/'.$user->internal_id,'<i class="'.$enable_disable_user.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Activate','onclick'=>"return confirm('Are you sure you want to activate ".$user->name."?')"));

                      ?>


                    <?php }?>
                    </td>
                  </tr>
                  <?php 
}
                  }?>
                </tbody>
              </table>
              </div>
            </div><!-- box-body -->
          </div>
          
          </section>
          </div>
              
            <!-- Loading (remove the following to stop the loading)-->   
            <div class="overlay" hidden="hidden" id="loading">
            <i class="fa fa-spinner fa-spin"></i>
            </div>

 <?php require_once(APPPATH.'views/include/footer.php');?>

    <!--//======================  Employee List Modal Container //--> 

<div class="modal modal-primary fade" id="showEmployeeList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Select Employees</h4>
                </div>
          <div class="modal-body">
                                                                                           
<script language="javascript">

function autoload()
{
  getEmployeeList(''); 
}

function getEmployeeList(val)
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
    document.getElementById("showSearchResult").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","<?php echo base_url();?>app/user/showSearchEmployee/"+val,true);
xmlhttp.send();
}
</script>   
                    <input onKeyUp="getEmployeeList(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                        <span id="showSearchResult">

                        </span>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>                          
                  </div>
                </div>
            </div><!-- /.box-body -->

<!--//====================================== End Employee List Modal Container ==============================//-->


    <!-- REQUIRED JS SCRIPTS -->

       <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }


      $(function () {

        //Initialize Select2 Elements
        $(".select2").select2();

        $("#user_table").DataTable();


      });

    </script>

  </body>
</html>