<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
     <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
    </head>
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
  </head>
    <?php require_once(APPPATH.'views/include/header.php');?>
    <?php if($this->session->userdata('is_logged_in')){
    $current_account_logged_in="admin or employee account";
    }else{
    $current_account_logged_in="employer_account";
    }    
    if($current_account_logged_in!="employer_account"){
       require_once(APPPATH.'views/include/sidebar.php');
      }else{
     require_once(APPPATH.'views/include/sidebar_recruitment_employer.php');
      }
    ?>
<body>
<div class="content-wrapper2">
  <section class="content-header">
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
    <h1>
      Recruitment
      <small>Plantilla</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#""><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Recruitment</a></li>
      <li class="active">Plantilla</li>
    </ol>
  </section>

  <div class="col-md-3" style="padding-bottom: 50px;" id="add_filtering">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
            <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">
                <ul class="nav nav-pills nav-stacked">
                    <?php
                     foreach ($companyList as $comp)
                      { ?>
                          <li class="my_hover"><a style='cursor: pointer;' onclick="set_plantilla('<?php echo $employer;?>','<?php echo $comp->company_id;?>')"><i class='fa fa-circle-o'></i> <span>  <?php echo $comp->company_name?> </span></a></li>
                        <?php
                      }
                     ?>
                </ul>
                 
            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
  <div class="col-md-9" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info"  id="fetch_all_result">
       <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Manage Company Plantilla</h4></ol>
            <div class="col-md-12"><br>
               
            </div>  
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
    

  <?php require_once(APPPATH.'views/include/footer.php');?>
    <script src="<?php echo base_url()?>public/validation.js"></script>
    <?php require_once(APPPATH.'views/include/footer.php');?>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/tinymce.min.js"></script>
  </body>
</html>

<script type="text/javascript">
  
  function set_plantilla(employer,company_id)
  {
    
    if (window.XMLHttpRequest)
      {
        xmlhttpDep=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
        xmlhttpDep=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttpDep.onreadystatechange=function()
      {
        if (xmlhttpDep.readyState==4 && xmlhttpDep.status==200)
          {
            document.getElementById("fetch_all_result").innerHTML=xmlhttpDep.responseText;
             $("#plantilla").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
          }
      }
    xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_plantilla/set_plantilla/"+employer+"/"+company_id,true);
    xmlhttpDep.send();
  }


  function delete_plantilla(company_id,employer,id)
  {
    var result = confirm("Are you sure you want to delete plantilla id '" + id);
    if(result == true)
    {
       if (window.XMLHttpRequest)
        {
          xmlhttpDep=new XMLHttpRequest();
        }
      else
        {// code for IE6, IE5
          xmlhttpDep=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttpDep.onreadystatechange=function()
        {
          if (xmlhttpDep.readyState==4 && xmlhttpDep.status==200)
            {
             location.reload();
            }
        }
      xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_plantilla/delete_plantilla/"+company_id+"/"+employer+"/"+id,true);
      xmlhttpDep.send();
    }
 } 

 function cancel_updateplantilla(id)
 {
    $('#no_upd_'+id).show();
    $('#desc_upd_'+id).show();
    $('#from_upd_'+id).show();
    $('#to_upd_'+id).show();
    $('#upd'+id).show();


    $('#no_orig_'+id).hide();
    $('#desc_orig_'+id).hide();
    $('#from_orig_'+id).hide();
    $('#to_orig_'+id).hide();
     $('#orig'+id).hide();

 }
 function cancel_plantilla(id)
 {
    $('#no_upd_'+id).hide();
    $('#desc_upd_'+id).hide();
    $('#from_upd_'+id).hide();
    $('#to_upd_'+id).hide();
    $('#upd'+id).hide();


    $('#no_orig_'+id).show();
    $('#desc_orig_'+id).show();
    $('#from_orig_'+id).show();
    $('#to_orig_'+id).show();
     $('#orig'+id).show();
 }

 function saveupdate_plantilla(company_id,employer,id)
 {
     var no = document.getElementById('upd_no_'+id).value;
     var details = document.getElementById('upd_desc_'+id).value;
     var from = document.getElementById('upd_from_'+id).value;
     var to = document.getElementById('upd_to_'+id).value;

     function_escape('upd_desc_final_'+id,details);
     var details_final = document.getElementById('upd_desc_final_'+id).value;

      if(no=='' || details=='' || from=='' || to=='')
      {
        alert('Fill up all fields to continue');
      }
      else
      {
           if (window.XMLHttpRequest)
              {
                xmlhttpDep=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
                xmlhttpDep=new ActiveXObject("Microsoft.XMLHTTP");
              }
              xmlhttpDep.onreadystatechange=function()
              {
                if (xmlhttpDep.readyState==4 && xmlhttpDep.status==200)
                  {
                   location.reload();
                  }
              }
            xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_plantilla/saveupdate_plantilla/"+company_id+"/"+employer+"/"+id+"/"+no+"/"+details_final+"/"+from+"/"+to,true);
            xmlhttpDep.send();
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