<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
       <?php require_once(APPPATH.'views/app/time/plot_schedules/calendar.php');?>
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
      <h1>Time<small>Plot Schedules</small></h1>
     <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="">Time</a></li>
        <li class="active">Plot Schedules</li>
      </ol>
    </section>
    <br>

    <div class="col-md-12">
     <?php echo $message;?>
    </div>
     <div class="col-sm-3" style="height:auto;padding-bottom: 30px;">
         <div class="box box-solid box-success">
         <div class="box-header">
          <h5 class="box-title"><i class='fa fa-clipboard'></i> <span>Late and Absences Settings</span></h5>
          </div>
          <div style="height: 420px;">
             <ul class="nav nav-pills nav-stacked">
                <li><a style='cursor: pointer;'  onclick="late_absence_setting('Late');"><i class='fa fa-circle-o text-success'></i> <span>Late Settings</span></a></li>
                <li><a style='cursor: pointer;'  onclick="late_absence_setting('Absence');"><i class='fa fa-circle-o text-success'></i> <span>Absences Settings</span></a></li>

                <?php
if($this->session->userdata('serttech_account')=="1"){//serttech lang pwede magmodify ng formula             
                ?>
                <li><a style='cursor: pointer;' onclick="setting();"><i class='fa fa-circle-o text-success'></i> <span>Late and Absences Basis Management</span></a></li>

<?php
}else{}
?>

                <li><a style='cursor: pointer;'  onclick="late_absence_basis();"><i class='fa fa-circle-o text-success'></i> <span>Late and Absencies Basis</span></a></li>
               

              </ul>
          </div>
          </div>
          <div class="btn-group-vertical btn-block"></div>  
          </div>
        </div>  
    <div class="col-md-9" style="padding-bottom: 50px;height: 100%;">
      <div class="box box-success">
        <div class="panel panel-info">
              <div class="col-md-12" id="fetch_all_result"><br>
                
              </div>
              <div class="btn-group-vertical btn-block"> </div>   
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
    
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
     <?php require_once(APPPATH.'views/app/time/plot_schedules/js_functions.php');?>  


    <script type="text/javascript">
      
      function late_absence_setting(val)
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/late_absences_occurence_settings/late_absence_setting/"+val,false);
        xmlhttp2.send();
      }


      function setting_action(val)
      {
        var company = document.getElementById('company').value;
        var option = document.getElementById('option').value;

        if(company=='' || option=='')
        {
          $('#msgg').show();
        }
        else
        {
          $('#msgg').hide();

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
                document.getElementById("setting_action").innerHTML=xmlhttp2.responseText;
                $("#setting").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/late_absences_occurence_settings/setting_action/"+company+"/"+val+"/"+option,false);
          xmlhttp2.send();

        }
      }




      function update_settings()
      {
        $('#update_').hide();
        $('#update_save').show();
        $('#action_view').hide();
        $('#action_update').show();
      }

      function setting()
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
                $("#setting").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/late_absences_occurence_settings/setting/",false);
        xmlhttp2.send();
      } 


      function save_setting()
      {
        var setting = document.getElementById('setting_name').value;
        function_escape('setting_name_final',setting);
        var setting_name  = document.getElementById('setting_name_final').value;

        if(setting_name=='')
        {
          alert('Fill up setting field to continue');
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
                  location.reload();
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/late_absences_occurence_settings/save_setting/"+setting_name,false);
            xmlhttp2.send();
        }
      }

      function action_setting(action,id)
      {

        if(action=='edit')
        {
          $('#orig_setting'+id).hide();
          $('#orig_action'+id).hide();
          
          $('#upd_setting'+id).show();
          $('#upd_action'+id).show();
        }
        else if(action=='cancel')
        {
          $('#orig_setting'+id).show();
          $('#orig_action'+id).show();
          
          $('#upd_setting'+id).hide();
          $('#upd_action'+id).hide();
        }
        else if(action=='save_update')
        {
          var setting = document.getElementById('setting'+id).value;
          function_escape('settingfinal'+id,setting);
          var setting_name = document.getElementById('settingfinal'+id).value;
          if(setting_name==''){ alert('Fill up setting field to continue'); }
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
                      location.reload();
                    }
                  }
                xmlhttp2.open("GET","<?php echo base_url();?>app/late_absences_occurence_settings/save_update_setting/"+setting_name+"/"+id,false);
                xmlhttp2.send();
            }
        }
        else
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
              xmlhttp2.open("GET","<?php echo base_url();?>app/late_absences_occurence_settings/action_setting/"+action+"/"+id,false);
              xmlhttp2.send();
          }
        }

      }


      function late_absence_basis()
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
                      $("#setting").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/late_absences_occurence_settings/late_absence_basis/",false);
              xmlhttp2.send();
      }

      function setting_action_basis(company)
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
              document.getElementById("setting_action").innerHTML=xmlhttp2.responseText;
              $("#setting").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/late_absences_occurence_settings/setting_action_basis/"+company,false);
        xmlhttp2.send();
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