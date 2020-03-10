<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sert Technology Inc</title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
       Quick Links
       <small>File Maintenance</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Quick Links File Maintenance</a></li>
    </ol>
  </section>
  <br>
    <div class="col-md-12">
    <?php echo $message;?>
    </div>
    <?php echo validation_errors(); ?>
  <div class="col-md-3" style="padding-bottom: 50px;" id="add_filtering">
    <div class="box box-success">
      <div class="panel panel-danger">
        <?php $i=1; foreach($user_category as $u){
          $get_modules = $this->system_help_model->get_modules_by_usercategory($u->portal_id);
           if(empty($active))
          {
            if($i==1){ $iii= 'in'; } else{ $iii= '';  }
          }
          else
          {
            if($active==$u->portal_id)
              { $iii = 'in'; } else{ $iii=''; }
            
          }
        ?>

             <div class="panel-heading">
              <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse<?php echo $i;?>"><h4 class="box-title"><i class='fa fa-user'></i> <span><?php echo $u->portal;?></span></h4></a>
              </h4>
            </div>
            <div id="collapse<?php echo $i;?>" class="panel-collapse collapse <?php echo $iii;?>">
                <div class="panel-body" style="overflow: auto;">
                  <ul class="nav nav-pills nav-stacked">
                    <?php foreach($get_modules as $m){?>
                        <li><a style='cursor: pointer;' onclick="quick_links_file_maintenance_action('<?php echo $u->portal_id;?>','<?php echo $m->module_id;?>');"><i class='fa fa-circle-o'></i> <span><?php echo $m->module;?></span></a></li>
                    <?php } ?>
                  </ul>

                </div>
            </div>

        <?php  $i++; } ?>

              
      </div>             
    </div> 
  </div> 
  <div class="col-md-9" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info"  id="fetch_all_result">
       <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>File Maintenance</h4></ol>
            <div class="col-md-12"><br>
                
            </div>  
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
    

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
       <div class="modal-dialog">
           <div class="modal-content modal-lg">
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
    <script type="text/javascript">
      
      function quick_links_file_maintenance_action(portal_id,module_id)
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
                $("#results").DataTable({
                        lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]]             
                        });
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/quick_links/quick_links_file_maintenance_action/"+portal_id+"/"+module_id,false);
          xmlhttp2.send();
      }


      function show_hide_system_help(show,hide)
      {
        $('#'+show).show();
        $('#'+hide).hide();
        $('#actionn_update').hide();
      }


      function get_sub_topic_list(topic,id)
      {
        if(topic=='')
        {
          alert('Please select valid topic to continue');
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
                document.getElementById(id).innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/system_help/get_sub_topic_list/"+topic,false);
          xmlhttp2.send();
        }
      }

      function file_maintenance_action(portal,module,id,action)
      {
        var result = confirm("Are you sure you want to " + action + " this record?");
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
          xmlhttp2.open("GET","<?php echo base_url();?>app/quick_links/file_maintenance_action/"+portal+"/"+module+"/"+id+"/"+action,false);
          xmlhttp2.send();
        }
      }

     function file_maintenance_action_update_form(action,id,portal,module)
      {
          $('#actionn_update').show();
          $('#actionn_add').hide();
          $('#actionn_filter').hide();

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
                document.getElementById('actionn_update').innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/quick_links/file_maintenance_action_update_form/"+id+"/"+portal+"/"+module,false);
          xmlhttp2.send();
        
      }


      function filter_quick_links_file_maintenance(portal,module)
      {
        var topic = document.getElementById('topic_filter').value;

        if(topic=='' || subtopic=='')
        {
          alert('Fill up all fields  to continue');
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
                  document.getElementById('system_help_file_maintenance_view').innerHTML=xmlhttp2.responseText;
                  $("#results").DataTable({
                        lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]]             
                        });
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/quick_links/filter_system_help_file_maintenance/"+portal+"/"+module+"/"+topic,false);
          xmlhttp2.send();
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


    </script>