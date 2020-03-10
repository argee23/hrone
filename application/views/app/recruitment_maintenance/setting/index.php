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
    if(empty($code)){ $codes ='ED9'; } else{ $codes=$code; }
    
    ?>
<body>
<div class="content-wrapper2">
  <section class="content-header">
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
    <h1><?php echo $question_type;?>
      Recruitment
      <small>Plantilla</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#""><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Recruitment</a></li>
      <li class="active">Settings</li>
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
                          <li class="my_hover"><a style='cursor: pointer;' onclick="set_setting('<?php echo $comp->company_id;?>','<?php echo $codes;?>')"><i class='fa fa-circle-o'></i> <span>  <?php echo $comp->company_name?> </span></a></li>
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
       <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Recruitment Settings</h4></ol>
            <div class="col-md-12"><br>
               
            </div>  
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
  
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
         <div class="modal-content modal-md">
         </div>
      </div>
  </div>

   <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
  
  function set_setting(company_id,code)
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
                    $("#settings").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                  }
              }
      xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_hris/setting_company/"+company_id+"/"+code,true);
      xmlhttpDep.send();
  }

  function delete_plantilla(company_id,id,code)
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
      xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_hris/delete_plantilla/"+company_id+"/"+id+"/"+code,true);
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

   function saveupdate_plantilla(company_id,id,code)
   {

       var no = document.getElementById('upd_no_'+id).value;
       var details = document.getElementById('upd_desc_'+id).value;
       var from = document.getElementById('upd_from_'+id).value;
       var to = document.getElementById('upd_to_'+id).value;

       function_escape('upd_desc_final_'+id,details);
       var details_final = document.getElementById('upd_desc_final_'+id).value;

       function_escape('upd_no_final_'+id,no);
       var no_final = document.getElementById('upd_no_final_'+id).value;

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
              xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_hris/saveupdate_plantilla/"+company_id+"/"+id+"/"+no_final+"/"+details_final+"/"+from+"/"+to+"/"+code,true);
              xmlhttpDep.send();
        }
   }

  function get_company_settings(company_id,val)
  {
    if(val=='ED5')
    {
        $("#settingsaction").load(location.href + " #settingsaction");
        $('#questions').show();
    }
    else
    {
        $('#questions').hide();
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
                    document.getElementById("settingsaction").innerHTML=xmlhttpDep.responseText;
                    $("#settings").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                  }
              }
        xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_hris/get_company_settings/"+company_id+"/"+val,true);
        xmlhttpDep.send();
    }
      
  }

  function get_company_questions(company_id,val)
  {
       var setting = document.getElementById('setting').value;
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
                    document.getElementById("settingsaction").innerHTML=xmlhttpDep.responseText;
                    $("#settings").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                  }
              }
        xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_hris/get_company_settings_questions/"+company_id+"/"+val+"/"+setting,true);
        xmlhttpDep.send();
  }


  //for status option settings
  function employer_settings_status(action,id,company_id)
  {
    
    if(action=='delete' || action=='disable' || action=='enable')
    {
       var result = confirm("Are you sure you want to " + action + " id-" + id);
          if(result == true)
          {
            var title_ = action;
            var color_ = action;
            var description_ =action;
            employer_status_action(action,id,title_,description_,color_,company_id)
          } else {}
    }
    else if(action=='update')
    {
          $("#o_title"+id).hide();
          $("#o_description"+id).hide();
          $("#o_color"+id).hide();
          $("#original"+id).hide();

          $("#u_title"+id).show();
          $("#u_description"+id).show();
          $("#u_color"+id).show();
          $("#update"+id).show();
    }
    else if(action=='cancel')
    {
          $("#o_title"+id).show();
          $("#o_description"+id).show();
          $("#o_color"+id).show();
          $("#original"+id).show();

          $("#u_title"+id).hide();
          $("#u_description"+id).hide();
          $("#u_color"+id).hide();
          $("#update"+id).hide();
    }
    else if(action=='save_update')
    {
      var title = document.getElementById('title'+id).value;
      var description = document.getElementById('description'+id).value;
      var color = document.getElementById('color'+id).value;

      function_escape('title_'+id,title);
      function_escape('description_'+id,description);
      function_escape('color_'+id,color);

      var title_ = document.getElementById('title_'+id).value;
      var description_ = document.getElementById('description_'+id).value;
      var color_ = document.getElementById('color_'+id).value;

      employer_status_action(action,id,title_,description_,color_,company_id)
    }
  } 


  function employer_status_action(action,id,title,description,color,company_id)
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
              xmlhttp.open("GET","<?php echo base_url();?>app/recruitment_hris/ED2_employer_status_action/"+action+"/"+id+"/"+title+"/"+description+"/"+color+"/"+company_id,true);
              xmlhttp.send();
    
  }

  function view_updating_numbering(val)
  {
    document.getElementById('update_checking').value=val;
    var count = document.getElementById('numbering_count').value;
    var cinput =   document.getElementsByClassName('numbering_value');


    for (i=0;i < count; i++)
          {
            $('#numbering_update'+i).show();
            $('#numbering_viewing'+i).hide();
          } 
    
    $('#action_viewing').hide(); 
    $('#action_updating').show();  
  }


  function cancel_numbering()
  {
    var count = document.getElementById('numbering_count').value;
    var cinput =   document.getElementsByClassName('numbering_value');


    for (i=1;i < count; i++)
          {
            $('#numbering_update'+i).hide();
            $('#numbering_viewing'+i).show();
          } 
    
    $('#action_viewing').show(); 
    $('#action_updating').hide(); 
  }

  function savechanges_numbering(company_id)
  {
      var checking_type = document.getElementById('update_checking').value;
      if(checking_type=='comp')
      {
          checkingtype_value = 'computation';
      }
      else
      {
         checkingtype_value = 'numbering';
      }

      var result = confirm("Are you sure you want to update the status numbering of company id " + company_id + "?.");
         if(result == true)
         {
            var count = document.getElementById('numbering_count').value;
            var cinput =   document.getElementsByClassName(checkingtype_value + '_value');

            var value_numbering='';
            var value_id='';
            for (i=1;i < count; i++)
                  {
                    document.getElementById(checkingtype_value + "value"+i).style.borderColor = "white";
                    document.getElementById('checking_empty').value=0;
                  }
                              
            for (i=1;i < count; i++)
                  {
                      var val = document.getElementById(checkingtype_value + 'value'+i).value;
                      value_numbering += val + "-";

                      var id = document.getElementById(checkingtype_value + 'id'+i).value;
                      value_id += id + "-";

                      if(checking_type=='num')
                      {
                          for (ii=1;ii < count; ii++)
                          {
                            if(ii==i){}
                            else
                            {
                              var a = document.getElementById(checkingtype_value + 'value'+ii).value;
                              if(a==val)
                              {
                                document.getElementById(checkingtype_value + "value"+i).style.borderColor = "red";
                                document.getElementById(checkingtype_value + "value"+ii).style.borderColor = "red";
                                document.getElementById('checking_empty').value=1;
                              }
                              else
                              {}
                            }
                          }
                      }
                      else
                      {
                        
                      }
                        
                  }

            var checker = document.getElementById('checking_empty').value;
            if(checker==1)
            {
               alert("Duplicate Values are not allowed.");
               
            }
            else
            {
              save_updated_numbering(company_id,value_numbering,value_id,count,checking_type);
            }
         }

  }

  function save_updated_numbering(company_id,value_numbering,value_id,count,checking_type)
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
              xmlhttp.open("GET","<?php echo base_url();?>app/recruitment_hris/ED2_employer_status_numbering/"+company_id+"/"+value_numbering+"/"+value_id+"/"+count+"/"+checking_type,true);
              xmlhttp.send();
  }

  function view_updating_comp(val)
  {
    document.getElementById('update_checking').value=val;
    var count = document.getElementById('numbering_count').value;
    var cinput =   document.getElementsByClassName('numbering_value');


    for (i=0;i < count; i++)
          {
            $('#computation_update'+i).show();
            $('#computation_viewing'+i).hide();
          } 
    
    $('#action_viewing').hide(); 
    $('#action_updating').show();  
  }


  function job_requirements(company,action,id)
  {
    if(action=='save')
    {
      var uploadable = document.getElementById('uploadable').value;
      var title = document.getElementById('requirements').value;
      function_escape('requirements_',title);
      var title_ = document.getElementById('requirements_').value;

      save_job_requirements(company,action,id,uploadable,title_)
     
    }
    else if(action=='enable' || action=='disable' || action=='delete')
    {
      var result = confirm("Are you sure you want to delete id-" + id);
      if(result == true)
        {
          var title_ = action;
          var uploadable = action;
          save_job_requirements(company,action,id,uploadable,title_)
        } else {}
    }
    else if(action=='update')
    {

        $("#o_isupload"+id).hide();
        $("#u_isupload"+id).show();

        $("#o_title"+id).hide();
        $("#u_title"+id).show();

        $("#original"+id).hide();
        $("#update"+id).show();
    }
    else if(action=='cancel')
    {
        $("#o_title"+id).show();
        $("#u_title"+id).hide();

        $("#o_isupload"+id).show();
        $("#u_isupload"+id).hide();

        $("#original"+id).show();
        $("#update"+id).hide();
    }
    else if(action=='save_update')
    {

          var uploadable = document.getElementById('uploadable'+id).value;
          var title = document.getElementById('title'+id).value;
          function_escape('title_'+id,title);
          var title_ = document.getElementById('title_'+id).value;

          
          save_job_requirements(company,action,id,uploadable,title_)

    }
  }

  function save_job_requirements(company,action,id,uploadable,title)
  {
   
    if(company=='' || action=='' || id=='' || uploadable=='' || title=='')
    {
        alert("Please fill up all fields to continue");
    }
    else{

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
              xmlhttp.open("GET","<?php echo base_url();?>app/recruitment_hris/ED6_save_job_requirements/"+company+"/"+action+"/"+id+"/"+uploadable+"/"+title,true);
              xmlhttp.send();
    }
  }

  function action_appprover_choices(action,company_id,code,id)
  {
      var result = confirm("Are you sure you want to" + action + " approver choices id -" + id);
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
              xmlhttp.open("GET","<?php echo base_url();?>app/recruitment_hris/ED13_action_appprover_choices/"+company_id+"/"+code+"/"+id+"/"+action,true);
              xmlhttp.send();
      }
  }

  function action_setting10_action(action,id,company)
  {
    var result = confirm("Are you sure you want to" + action + " approver id -" + id);
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
          xmlhttp.open("GET","<?php echo base_url();?>app/recruitment_hris/action_setting10_action/"+action+"/"+id+"/"+company,true);
          xmlhttp.send();
    }
  }

  function check_dates_plantilla()
  {
    var from = document.getElementById('plantilla_datefrom').value;
    var to = document.getElementById('plantilla_dateto').value;
    var checker = document.getElementById('datechecker').value;

    if(from!='' && to!='')
    {
        if(to > from)
        {
            if(checker==''){  document.getElementById('submit').disabled=false; }
            else 
            { 
                if(checker < to && checker < from){ document.getElementById('submit').disabled=false; }
                else{ 
                        alert('Please check the date range plantilla.'); 
                        document.getElementById('submit').disabled=true;
                    }
            }
        }
        else
        {
          alert('Date to must be greater than date from');
          document.getElementById('submit').disabled=true;
        }
    }
  }


  //qualifying questions
function qualifying_questions(company,action,id)
{
   if(action=='delete' || action=='enable' || action=='disable')
  {
      var result = confirm("Are you sure you want to disable id-" + id);
      if(result == true)
      {
        var question_=action;
        var ans = action;

        save_qualifying_questions(company,action,id,question_,ans,'qualifying');
      } else {}  
  }
  else if(action=='update')
  {
    $("#u_qquestions"+id).show();
    $("#u_qans"+id).show();

    $("#o_qquestions"+id).hide();
    $("#o_qans"+id).hide();

    $("#o_qualifying"+id).hide();
    $("#u_qualifying"+id).show();
  }
  else if(action=='cancel')
  {
     $("#u_qquestions"+id).hide();
    $("#u_qans"+id).hide();

    $("#o_qquestions"+id).show();
    $("#o_qans"+id).show();

    $("#o_qualifying"+id).show();
    $("#u_qualifying"+id).hide();
  }
  else if(action=='save_update')
  {
      var question = document.getElementById('uqquestions'+id).value;
      var ans = document.getElementById('uqqanswer'+id).value;

      function_escape('uqquestions_'+id,question);
      var question_ = document.getElementById('uqquestions_'+id).value;

      save_qualifying_questions(company,action,id,question_,ans,'qualifying');
  }
  else
  {
    
      save_qualifying_questions(company,action,id,'view','view','qualifying');
   
  }
}

  
  function save_qualifying_questions(company,action,id,question,answer,question_type)
  {

    if(answer=='' || question_type=='' || question=='')
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
                    location.reload();
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/recruitment_hris/save_qualifying_questions/"+company+"/"+action+"/"+id+"/"+question+"/"+answer+"/"+question_type,true);
            xmlhttp.send();
      }
  }
  function allow_upload(val,id,idd)
  {
    if(idd=='uploadable' || idd=='qquestion' || idd=='uqqanswer')
    {
        document.getElementById(id).value=val;
    }
    else
    {
      document.getElementById(id+''+idd).value=val;
    }
  }


  //start of hypothetical

function hypothetical_questions(company,action,id)
{

  if(action=='save')
  {
    var question = document.getElementById('hquestion').value;
    function_escape('hquestion_',question);

    var question_ = document.getElementById('hquestion_').value;
    
    save_hypothetical(company,action,id,question_,'hypothetical');
   
  }
  else if(action=='delete' || action=='enable' || action=='disable')
  {
      var result = confirm("Are you sure you want to "+action+ " id-" + id);
      if(result == true)
      {
        save_hypothetical(company,action,id,action,'hypothetical');
      } else {}  
  }
  else if(action=='update')
  {
      $("#o_hypothetical"+id).hide();
      $("#u_hypothetical"+id).show();

      $("#o_hquestions"+id).hide();
      $("#u_hquestions"+id).show();
  }
  else if(action=='cancel')
  {
      $("#o_hypothetical"+id).show();
      $("#u_hypothetical"+id).hide();

      $("#o_hquestions"+id).show();
      $("#u_hquestions"+id).hide();
  }
  else if(action=='save_update')
  {
      var question = document.getElementById('uhquestions'+id).value;
      function_escape('uhquestions_'+id,question);

      var question_ = document.getElementById('uhquestions_'+id).value;
      
      save_hypothetical(company,action,id,question_,'hypothetical');
   
  }
  else
  {
    save_hypothetical(company,action,id,'view','hypothetical');
  }
}

function save_hypothetical(company,action,id,question,question_type)
{
   alert('ok');
    if(question=='')
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
                    location.reload();
                }
              }
              
              xmlhttp.open("GET","<?php echo base_url();?>app/recruitment_hris/save_hypothetical_questions_company/"+company+"/"+action+"/"+id+"/"+question+"/"+question_type,true);
              xmlhttp.send();
              
      }
}
//end of hypothetical


//start of multiple choice


function multiplechoice_questions(company,action,id)
{

  if(action=='delete' || action=='enable' || action=='disable')
  {
      var result = confirm("Are you sure you want to disable id-" + id);
      if(result == true)
      {
        save_multiplechoice_questions(company,action,id,action,'multiple_choice');
      } else {}  
  }
  else if(action=='update')
  {
      $("#o_hypothetical"+id).hide();
      $("#u_hypothetical"+id).show();

      $("#o_hquestions"+id).hide();
      $("#u_hquestions"+id).show();
  }
  else if(action=='cancel')
  {
      $("#o_hypothetical"+id).show();
      $("#u_hypothetical"+id).hide();

      $("#o_hquestions"+id).show();
      $("#u_hquestions"+id).hide();
  }
  else if(action=='save_update')
  {
      var question = document.getElementById('uhquestions'+id).value;
      function_escape('uhquestions_'+id,question);

      var question_ = document.getElementById('uhquestions_'+id).value;
      
      save_multiplechoice_questions(company,action,id,question_,'multiple_choice');
   
  }
  
}

function save_multiplechoice_questions(company,action,id,question,question_type)
{
  
    if(question=='')
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
                    location.reload();
                }
              }
          
          xmlhttp.open("GET","<?php echo base_url();?>app/recruitment_hris/save_hypothetical_questions_company/"+company+"/"+action+"/"+id+"/"+question+"/"+question_type,true);
          xmlhttp.send();
          
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