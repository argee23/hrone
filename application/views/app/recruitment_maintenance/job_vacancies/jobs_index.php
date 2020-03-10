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
      <small>Job Vacancy</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#""><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Recruitment</a></li>
      <li class="active">Job Vacancy</li>
    </ol>
  </section>


  <?php if($employer_type=='public'){?>

 

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
                        <li class="my_hover"><a style='cursor: pointer;' onclick="get_company_job_vacancy('<?php echo $company->company_id;?>','<?php echo $employer_type;?>');"><i class='fa fa-circle-o'></i> <span>  <?php echo $company->company_name?> </span></a></li>
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
               <?php require_once(APPPATH.'views/app/recruitment_maintenance/job_vacancies/job_vacancy_hris.php'); ?>
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
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/tinymce.min.js"></script>
    <script type="text/javascript">
      
       $(function () {
        $('#job_vacancy').DataTable({
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

       function get_company_job_vacancy(company_id,employer_type)
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
                 $("#job_vacancy").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                }
              }
            xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_plantilla/get_company_job_vacancy/"+company_id+"/"+employer_type,true);
            xmlhttpDep.send();
       }

       function check_plantilla_position(company_id,employer_type)
       {
          var dept = document.getElementById('adepartment').value;
          var plantilla = document.getElementById('aplantilla').value;
          var location = document.getElementById('alocation').value;
          var position = document.getElementById('apositionn').value;
          
          if(dept=='' || plantilla=='' || location=='' || position=='')
          {
            document.getElementById('submit').disabled=true;
          }
          else
          {
            document.getElementById('submit').disabled=false;
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
                    document.getElementById("positiondetails").innerHTML=xmlhttpDep.responseText;
                    }
                  }
              xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_plantilla/check_plantilla_position/"+company_id+"/"+employer_type+"/"+dept+"/"+plantilla+"/"+location+"/"+position,true);
              xmlhttpDep.send();
          }
          
       }

      function get_city(province)
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
              document.getElementById("city").innerHTML=xmlhttpDep.responseText;
              }
            }
          xmlhttpDep.open("GET","<?php echo base_url();?>app/final_recruitments/get_city/"+province,true);
          xmlhttpDep.send();
      }

      function job_details_action(action,company_id,employer_type,id)
      {
        var result = confirm("Are you sure you want to " +  action + " Job ID - " + id );
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/recruitment_plantilla/job_details_action/"+action+"/"+company_id+"/"+employer_type+"/"+id,true);
                  xmlhttp.send();
            } 
      }

      function get_department_location_plantilla(company_id)
      {
          var xmlhttp;

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
                  document.getElementById("fdepartment").innerHTML=xmlhttpDep.responseText;
                  get_location(company_id);

                }
              }
            xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_plantilla/get_department/"+company_id,true);
            xmlhttpDep.send();
      }


      function get_location(company_id)
      {
           var xmlhttp;
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
                  document.getElementById("flocation").innerHTML=xmlhttpDep.responseText;
                  get_plantilla(company_id);
                }
              }
            xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_plantilla/get_location/"+company_id,true);
            xmlhttpDep.send();
      }

       function get_plantilla(company_id)
      {
            var xmlhttp;
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
                document.getElementById("fplantilla").innerHTML=xmlhttpDep.responseText;
                }
              }
            xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_plantilla/get_plantilla/"+company_id,true);
            xmlhttpDep.send();
      } 


      function filter_plantilla_job(company_id)
      {
        var company = document.getElementById('fcompany').value;
        var department = document.getElementById('fdepartment').value;
        var location = document.getElementById('flocation').value;
        var plantilla = document.getElementById('fplantilla').value;
        var position = document.getElementById('fposition').value;

        if(company=='' || department=='' || location=='' || plantilla=='' || position=='')
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
                  document.getElementById("filtering_result").innerHTML=xmlhttpDep.responseText;
                  }
                }
              xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_plantilla/filter_plantilla_job/"+company+"/"+department+"/"+location+"/"+plantilla+"/"+position,true);
              xmlhttpDep.send();
        }
      }


      function filtering_by_company(employer_type)
      {
        alert(employer_type);
          var company = document.getElementById('company').value;
          var department = document.getElementById('department').value;
          var location = document.getElementById('location').value;
          var plantilla = document.getElementById('plantilla').value;
          var position = document.getElementById('position').value;

          if(document.getElementById('postedall').checked==true)
          {
              var date_from ='All';
              var date_to = 'All';
          }
          else
          {
              var date_from = document.getElementById('posted_from').value;
              var date_to = document.getElementById('posted_to').value;
          }

          if(company=='' || department=='' || location=='' || plantilla=='' || position=='' || date_from=='' || date_to=='')
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
                  document.getElementById("filtering_result").innerHTML=xmlhttpDep.responseText;
                  $("#job_vacancy").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                  }
                }
              xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_plantilla/filtering_by_company/"+company+"/"+department+"/"+location+"/"+plantilla+"/"+position+"/"+date_from+"/"+date_to+"/"+employer_type,true);
              xmlhttpDep.send();
          }
      } 

      function datepostedall(id,from,to)
      {
        if(document.getElementById(id).checked==true)
        {
          document.getElementById(from).disabled=true;
          document.getElementById(to).disabled=true;
        }
        else
        {
          document.getElementById(from).disabled=false;
          document.getElementById(to).disabled=false;
        }
      }

      function get_plantilla_dates(id)
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
                  document.getElementById("pantilla_dates").innerHTML=xmlhttpDep.responseText;
                  }
                }
              xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_plantilla/get_plantilla_dates/"+id,true);
              xmlhttpDep.send();
      }


      function check_hiring()
      {
        var hiring_start = document.getElementById('hiring_start').value;
        var hiring_end = document.getElementById('hiring_end').value;

        var checker_from = document.getElementById('pfrom').value;
        var checker_to = document.getElementById('pto').value;

       
        if(hiring_start!='' && hiring_end!='')
        {
            if(hiring_start <= hiring_end)
            {
               if(checker_to >=hiring_end && checker_from <= hiring_start)
               {
                  document.getElementById('submit').disabled=false;
               }
               else {
                   document.getElementById('submit').disabled=true;
                   alert('Hiring Start and Hiring End must based on plantilla dates');
                }
            }
            else
            {
              document.getElementById('submit').disabled=true;
              alert('Hiring End must greater than the hiring start');
            }
        }
        

      }

    </script>
  </body>
</html>
