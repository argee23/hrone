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

    <link href="<?php echo base_url()?>public/bootstrap/css/tables.css" rel="stylesheet">  
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

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
      <small>Job Application</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#""><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Recruitment</a></li>
      <li class="active">Job Application</li>
    </ol>
  </section>


  <?php if($employer_type=='public'){?>

  <div class="col-md-12" style="margin-bottom: 50px;">
     <div class="box">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
            <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark" id="company_job_application">
                  <?php require_once(APPPATH.'views/app/final_recruitments/job_application/job_application_public.php'); ?>   
            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div>

  <?php } else{ ?>

  <!---by company id-->
  <div class="col-md-3" style="padding-bottom: 50px;" id="add_filtering">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
            <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">
                <ul class="nav nav-pills nav-stacked">
                    <?php
                   foreach ($companyList as $company)
                    {?>
                        <li class="my_hover"><a style='cursor: pointer;' onclick="get_company_job_application('<?php echo $company->company_id;?>','<?php echo $employer_type;?>');"><i class='fa fa-circle-o'></i> <span>  <?php echo $company->company_name?> </span></a></li>
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
  <!---job vacancy list-->
  <div class="col-md-9" style="margin-bottom: 50px;">
     <div class="box">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
            <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark" id="company_job_vacancy">
               <?php require_once(APPPATH.'views/app/final_recruitments/job_application/job_application_hris.php'); ?>
            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div>

  <?php   } ?>

  <!---modal-->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
         <div class="modal-content modal-lg">
         </div>
      </div>
  </div>

  <div class="modal fade" id="modall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog">
       <div class="modal-content modal-md">
       </div>
    </div>
  </div>

  <style type="text/css">
    .modal {
    }
    .vertical-alignment-helper {
        display:table;
        height: 100%;
        width: 120%;
    }
    .vertical-align-center {
        display: table-cell;
        vertical-align: left;
    }
    .modal-content {
        margin: 0 auto;
        margin-left:-60px;
    }
  </style>
  <div class="overlay" hidden="hidden" id="loading">
  <i class="fa fa-spinner fa-spin"></i>
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
    <script type="text/javascript">
        $(function () {
        $('#job_application').DataTable({
          "pageLength": -1,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
        });

        function job_filtering_application(employer_type,company_id)
        {
          var company = document.getElementById('company').value;
          var from = document.getElementById('from').value;
          var to =  document.getElementById('to').value;
          var position = document.getElementById('position').value;

          if(company=='' || from=='' || to=='' || position=='')
          {
            alert("Please fill up all fields to continue");
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
              document.getElementById("filtering_result").innerHTML=xmlhttpDep.responseText;
               $("#job_application").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttpDep.open("GET","<?php echo base_url();?>app/final_recruitments/job_filtering_application_hris/"+company+"/"+employer_type+"/"+from+"/"+to+"/"+position,true);
          xmlhttpDep.send();
          }
        }

        function get_company_job_application(company_id,employer_type)
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
                document.getElementById("company_job_vacancy").innerHTML=xmlhttpDep.responseText;
                 $("#job_application").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                }
              }
            xmlhttpDep.open("GET","<?php echo base_url();?>app/final_recruitments/get_company_job_application/"+company_id+"/"+employer_type,true);
            xmlhttpDep.send();
        }

        function job_filtering_application_public(employer_type,company_id)
        {

           var from = document.getElementById('from').value;
           var to =  document.getElementById('to').value;
           var position = document.getElementById('position').value;

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
              document.getElementById("filtering_result").innerHTML=xmlhttpDep.responseText;
               $("#job_application").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttpDep.open("GET","<?php echo base_url();?>app/final_recruitments/job_filtering_application_public/"+company_id+"/"+employer_type+"/"+from+"/"+to+"/"+position,true);
          xmlhttpDep.send();
        }


        function update_application_status(title,company_id,employer_type,status,app_id,stat_id)
        {
              var result = confirm("Are you sure you want to update the applicant status to '" + title + "'?");
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
                    xmlhttp.open("GET","<?php echo base_url();?>app/final_recruitments/update_application_status_all/"+company_id+"/"+employer_type+"/"+status+"/"+app_id+"/"+stat_id,true);
                    xmlhttp.send();
              }
        }


        function update_interview_details(id)
        {
            $('#origation'+id).hide();
            $('#origdate'+id).hide();
            $('#origtime'+id).hide();
            $('#originterviewer'+id).hide();

            $('#updation'+id).show();
            $('#upddate'+id).show();
            $('#updtime'+id).show();
            $('#updinterviewer'+id).show();
        }

        function cancel_interview_details(id)
        {
            $('#origation'+id).show();
            $('#origdate'+id).show();
            $('#origtime'+id).show();
            $('#originterviewer'+id).show();

            $('#updation'+id).hide();
            $('#upddate'+id).hide();
            $('#updtime'+id).hide();
            $('#updinterviewer'+id).hide();
        }

        function save_updated_details(id,company_id,app_id,employer_type,numbering)
        {

          var date = document.getElementById('date'+id).value;
          var time = document.getElementById('time'+id).value;
          var interviewer = document.getElementById('interviewer'+id).value;

          function_escape('interviewerfinal'+id,interviewer);
          var interviewer_final = document.getElementById('interviewerfinal'+id).value;

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
              document.getElementById("datagridd").innerHTML=xmlhttpDep.responseText;
                setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
              }
            }
            xmlhttpDep.open("GET","<?php echo base_url();?>app/final_recruitments/save_updated_details/"+date+"/"+time+"/"+interviewer_final+"/"+id+"/"+company_id+"/"+app_id+"/"+employer_type+"/"+numbering,true);
            xmlhttpDep.send();
        
        }

        function cancel_interview_request(id,company_id,app_id,employer_type,numbering)
        {
          
            var result = confirm("Are you sure you want to cancel the interview request?");
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
                  xmlhttpDep.open("GET","<?php echo base_url();?>app/final_recruitments/cancel_interview_request/"+id+"/"+company_id+"/"+app_id+"/"+employer_type+"/"+numbering,true);
                  xmlhttpDep.send();
              }
        }

        function manually_update(cc)
        {
            var x = document.getElementById(cc);
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            } 
        }


        function save_manually_update(interview_id,app_id)
        {
           var response =  document.getElementById('manual_response').value;
           var reason = document.getElementById('manual_reason').value;

           function_escape('manual_reason_final',reason);
           var reason_final = document.getElementById('manual_reason_final').value;

           if(response=='' || reason_final=='')
           {
            alert('Fill up all fields to continue');
           }
           else
           {
              var result = confirm("Are you sure you want to manually update the interview request status?");
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
                  xmlhttpDep.open("GET","<?php echo base_url();?>app/final_recruitments/save_manually_update/"+interview_id+"/"+app_id+"/"+response+"/"+reason_final,true);
                  xmlhttpDep.send();
              }
           }

        }

        function save_manually_update_finalreponse(interview_id,app_id)
        {

            var response =  document.getElementById('fmanualresponse').value;
            var reason = document.getElementById('fmanualreason').value;

            
             function_escape('fmanualreason_final',reason);
             var reason_final = document.getElementById('fmanualreason_final').value;

             if(response=='' || reason_final=='')
             {
              alert('Fill up all fields to continue');
             }
             else
             {
                var result = confirm("Are you sure you want to manually update the applicant interview request status?");
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
                    xmlhttpDep.open("GET","<?php echo base_url();?>app/final_recruitments/save_manually_update_finalreponse/"+interview_id+"/"+app_id+"/"+response+"/"+reason_final,true);
                    xmlhttpDep.send();
                }
             }

        }

        function cancel_referral(id,applicant_id,job_id,app_id)
        {
           var result = confirm("Are you sure you want to cancel employee referral id" + id + "?");
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
                       document.getElementById("referral_action").innerHTML=xmlhttpDep.responseText;
                      }
                    }
                    xmlhttpDep.open("GET","<?php echo base_url();?>app/final_recruitments/cancel_referral/"+id+"/"+applicant_id+"/"+job_id+"/"+app_id,true);
                    xmlhttpDep.send();
                }
        }



        //
        function update_referral_status(id)
        {
          $('#upd'+id).show();
          $('#orig'+id).hide();

          $('#actionupd'+id).show();
          $('#actionorig'+id).hide();
        }

        function cancel_referral_status(id)
        {
          $('#upd'+id).hide();
          $('#orig'+id).show();

          $('#actionupd'+id).hide();
          $('#actionorig'+id).show();
        }

        function referral_status(val,id)
        {
          if(val=='rejected')
          {
             $('#company'+id).hide(); 
             $('#employee'+id).hide();   
          }
          else
          {
            $('#company'+id).show(); 
            $('#employee'+id).show(); 
          }
        }

        function saveupdate_referral_status(id,idd,job_id,applicant_id)
        {
            var status = document.getElementById('status'+id).value;

            if(status=='approved')
            {
                var employee = document.getElementById('employee'+id).value;
                var commentt = document.getElementById('comment'+id).value;

                function_escape('commentfinal'+id,commentt);
                var comment = document.getElementById('commentfinal'+id).value;

            }
            else
            {
                var comment = document.getElementById('comment'+id).value;
                var employee='not_included';
            }

            if(status=='' || employee=='' || comment=='')
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
                       document.getElementById("referral_action").innerHTML=xmlhttpDep.responseText;
                      }
                    }
                xmlhttpDep.open("GET","<?php echo base_url();?>app/final_recruitments/saveupdate_referral_status/"+id+"/"+idd+"/"+job_id+"/"+applicant_id+"/"+comment+"/"+status+"/"+employee,true);
                xmlhttpDep.send();
            }


        }

        function get_employees(company,id)
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
                       document.getElementById("employee"+id).innerHTML=xmlhttpDep.responseText;
                      }
                    }
            xmlhttpDep.open("GET","<?php echo base_url();?>app/final_recruitments/get_employees/"+company,true);
            xmlhttpDep.send();
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
  </body>
</html>
