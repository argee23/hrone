<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">

<!-- 
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
  rel="stylesheet"> -->
  <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet ">
  <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
  <!--end of DataTables -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
  <link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
  <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">


  <link href="<?php echo base_url()?>public/plugins/editable/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>

  




  <style> 
    .activeclick{
      color:#f39c12;
    }
    
      

    .modal-body{
      font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif, Apple Color Emoji, segoe UI Emoji, Segoe UI Symbol !important;
      
    }
    .modal-small {
      width: 500px;
      margin: 30px auto;
    }
    label{
      font-weight: normal;
    }

    textarea{

      max-width: 100%; 
    }
    .Editble .fa-pencil {
      display: none;
      cursor:pointer;
      margin-left:5px;
    }
    
    .Editble:hover .fa-pencil {
      display: inline-block;
    }
    .Editble span:hover .fa-pencil {display: inline-block;}
    .Editble input:hover .fa-pencil {display: none;}
    .input-edit {width:94%;display:inline;}
    .panel-body {padding:0px;}
    .table {margin-bottom:0px;}
    
    #instruction_area {
      border: none;
      overflow: hidden;
      outline: none;
      width: 100%;
    } 

    .argee_prettyline {
      height: 5px;
      border-top: 0;
      background: #c4e17f;
      border-radius: 5px;
      background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
      background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
      background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
      background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
    }




    .slider {
      -webkit-appearance: none;

      height: 25px;
      background: #d3d3d3;
      outline: none;
      opacity: 0.7;
      -webkit-transition: .2s;
      transition: opacity .2s;
      width: 100%;


    }

    .slider:hover {
      opacity: 1;
    }
    table {
      empty-cells: show;
    }
.disabled {
    pointer-events:none; //This makes it not clickable
    opacity:0.6;         //This grays it out to look disabled
}
    
    .slider::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 25px;
      height: 25px;
      background: #4CAF50;
      cursor: pointer;
    }

    .slider::-moz-range-thumb {
      width: 25px;
      height: 25px;
      background: #4CAF50;
      cursor: pointer;
    }


    /* Make inline editables take the full width of their parents */
    .editable-container.editable-inline,
    .editable-container.editable-inline .control-group.form-group,
    .editable-container.editable-inline .control-group.form-group .editable-input,
    .editable-container.editable-inline .control-group.form-group .editable-input textarea,
    .editable-container.editable-inline .control-group.form-group .editable-input select,
    .editable-container.editable-inline .control-group.form-group .editable-input input:not([type=radio]):not([type=checkbox]):not([type=submit])
    {
      width: 98%;
    }

.tooltop1 {
  position: relative;
  display: inline-block;
}

.tooltop1 .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  bottom: 125%;
  left: 50%;
  margin-left: -60px;
  opacity: 0;
  transition: opacity 0.3s;
    font-size: 12px;
}

.tooltop1 .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;

}

.tooltop1:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}


.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid blue;
  border-right: 16px solid green;
  border-bottom: 16px solid red;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}


@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
  </style>

  <script>
    window.onload = function() { <?php echo $onload ?>; };
  </script>
  

</head>



<?php 

require_once(APPPATH.'views/include/header.php');

if($this->session->userdata('is_logged_in')){
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

<body style="background-color: #D7EFF7;">

  <table id="e">

  </table>	

  <div class="content-wrapper2">
    <section class="content-header">
      <h1>PMS Setting</h1>
      <?php
      if($current_account_logged_in!="employer_account"){

      }else{
        echo ' <small>Employer panel</small>';
      }
      ?>

        <ol class="breadcrumb">
    <li><a ><i class="fa fa-dashboard"></i> Home</a></li>
    <li>PMS</li>

      <li class="active">Settings</li>
  </ol>

    </section>


    <!--//============================================================= Start Main content -->    

    <div class="col-md-12">
      <?php echo $message;?>
      <p id="message"></p>
      <?php echo validation_errors(); ?>
    </div>



    <div class="col-sm-3" style="height:auto;padding-bottom: 30px;">
      <div class="box box-solid box-success" style="border-color: #f39c12;">
       <div class="box-header" style="background-color: #f39c12;">
        <select class="form-control" name="company" id="company">
         <!-- <option selected  value="<?php echo $qwe; ?>"><?php $res = $this->pms_model->qwee($qwe); echo $res->company_name;  ?></option> --><option value="" disabled selected>-Select Company-</option>
         <?php foreach ($companyList as $res){ ?>
           <option value="<?php echo $res->company_id ?>"><?php echo $res->company_name ?></option> 
         <?php } ?>
       </select>
       <br>
       <h5 class="box-title"><i class='fa fa-cogs'></i> <span>Appraisal Settings </span></h5>
     </div>   
     <div class="panel panel-danger">
      <ul class="nav nav-pills nav-stacked">
         <li><a style='cursor: pointer;' id="lock_un" class="hide_ul"><i  class="<?php if(!empty($lock) == 1){ echo 'fa fa-unlock'; }else{ echo 'fa fa-unlock-alt';} ?>" ></i>  <span>Lock/Unlock </i></span></a></li>
        <li ><a style="cursor: pointer;" id="general_instruction" ><i  class='fa fa-circle-o'></i> <span >General Instruction</span></a></li>
        <li><a style='cursor: pointer;'  id="manage_general_form"><i class='fa fa-circle-o'></i> <span>Manage General Form</span></a></li>
        <!--   <li><a style='cursor: pointer;' id="grading"><i class='fa fa-circle-o'></i> <span>Manage Grading Table</i></span></a></li> -->
<!--          <li><a style='cursor: pointer;' id="employee_development_plan" ><i class='fa fa-circle-o'></i> <span >Employees Development Plan
 </i></span></a></li> -->
        <li><a style='cursor: pointer;'id="manage_appraisal_schedule"><i class='fa fa-circle-o'></i> <span>Manage Appraisal Schedule</i></span></a></li>
        <li><a style='cursor: pointer;' id="manage_appraisal_group" class="hide_ul"><i class='fa fa-circle-o'></i> <span>Manage Appraisal Group</i></span></a> </li>
        <li><a style='cursor: pointer;' id="manage_scorecard_creators" class="hide_ul"><i class='fa fa-circle-o'></i> <span>Manage Scorecard creators</i></span></a> </li>
                <li><a style='cursor: pointer;' id="manage_form_evaluators" class="hide_ul"><i class='fa fa-circle-o'></i> <span>Manage Form Evaluators  </i></span></a> </li>
                      <li><a style='cursor: pointer;' id="manage_form_approver" class="hide_ul"><i class='fa fa-circle-o'></i> <span>Manage Form Approvers  </i></span></a> </li>
                       <li><a style='cursor: pointer;' id="settings" class="hide_ul"><i class='fa fa-circle-o'></i> <span>Settings </i></span></a> </li>
                                   <!--  <li><a style='cursor: pointer;' id="map" class="hide_ul"><i class='fa fa-circle-o'></i> <span>map </i></span></a> </li> -->
        <!--    <li><a style='cursor: pointer;' id="manage_appraisal_group_members"><i class='fa fa-circle-o'></i> <span>Manage Appraisal Group Members</i></span></a></li> -->
      </ul>
    </div>
  </div>
  <div class="btn-group-vertical btn-block"></div>  
</div>
</div>  



<div class="col-md-9" style="padding-bottom: 50px;">
  <div class="box box-success">
    <div class="box-header">
      <h4 id="company_name"></h4>
    </div>
    <div class="col-md-12" id="fetch_all_result"><br>
      <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>General Instruction</h4></ol>
      <div class="col-md-110 well">

        <h3 class="page-header text-center"><br /></h3><br>
        

        <textarea  id="instruction_area" rows="13"  data-type="wysihtml5" data-pk="" data-name="instruction"  data-url=""></textarea>
        <hr>  

        <div class="text-center">
          <a class="btn btn-success" id="update" ><i class="glyphicon glyphicon-eye-open"></i> Update </a>
        </div>
      </div> 
    </div>
    <div class="btn-group-vertical btn-block"> </div>   
  </div>
</div> 





<!--//============================================================= End Main content -->




<!-- /.content-wrapper -->






<?php require_once(APPPATH.'views/include/footer.php');?>


<!--END footer-->
<!--//==========Start Js/bootstrap==============================//-->


<script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
<script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
<script>vex.defaultOptions.className = 'vex-theme-os'</script>
<script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>public/app.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">

<script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="crossorigin="anonymous"></script>
<script src="<?php echo base_url()?>public/plugins/editable/bootstrap3-editable/js/bootstrap-editable.js"></script>  


<link href="<?php echo base_url()?>public/plugins/editable/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.css" rel="stylesheet">
<script src="<?php echo base_url()?>public/plugins/editable/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.js"></script>
<script src="<?php echo base_url()?>public/plugins/editable/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.2/wysihtml5-0.3.0.js"></script>



<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  


<!-- DataTables -->
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script> 
<link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
<script src="<?php echo base_url()?>public/plugins/datepicker/bootstrap-datepicker.js"></script>  
<!-- Time Picker -->
<script src="<?php echo base_url()?>public/plugins/timepicker/bootstrap-timepicker.js"></script>  


 <link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
      <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

<!--//==========End Js/bootstrap==============================//-->


<script type="text/javascript">


var myCar = (function () {
  var configs = {
    "colour" : "red",
    "cost" : 10000
  };

  function _applyPaint() {
   
        //this is private
  }

  function delete_all(id,url) {

     $('#'+id+' input[name=check]:checked').each(function() {
           $(this).closest('tr').addClass('removeRow');
       });

    var checkbox = $('.check:checked');
    if(checkbox.length > 0)
    {
     var checkbox_value = [];
     $(checkbox).each(function(){
      checkbox_value.push($(this).val());
  
    });
     $.ajax({
       url: "<?php echo base_url();?>app/pms/"+url+"",
       method:"POST",
       data:{checkbox_value:checkbox_value},
       success:function()
       {
         $('.removeRow').empty();
   
       }
     })
   }
   else
   {
     alert('Select atleast one records');
   }

  }

  function stop () {

  }

  function accelerate () {
  
  }

  return {
    delete_all : delete_all,
    stop : stop,
    accelerate : accelerate
  }

  

})();

// $(function () {
//   $("#example1").DataTable();
// });
$.fn.editable.defaults.mode = 'inline';







//----------------------------------------------------------------------------- saving data functions--------------------------------------------------------------------------------------
function show_period_type(val)
{          
 var company= document.getElementById("company_").value;     
       //var contact_type= document.getElementById("contact_type").value;        
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
              
              document.getElementById("show_period_type").innerHTML=xmlhttp.responseText;

            }
          }
          xmlhttp.open("GET","<?php echo base_url();?>app/pms/show_period_type/"+val+"/"+company,true);
          xmlhttp.send();

        }
function showcontactchoices(val)
{          
 var company= document.getElementById("company_").value;     
       //var contact_type= document.getElementById("contact_type").value;        
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
              
              document.getElementById("show").innerHTML=xmlhttp.responseText;

            }
          }
          xmlhttp.open("GET","<?php echo base_url();?>app/pms/show/"+val+"/"+company,true);
          xmlhttp.send();

        }
function save_eval_appro_score(id){
         if(document.getElementById("creator_optionsq").checkValidity()){
           $( "#creator_optionsq" ).submit(function( event ) {
            event.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
              url: "<?php echo base_url();?>app/pms/save_eval_appro_score/"+id+"",
              type: 'POST',
              data: $('#creator_optionsq').serialize(),
              success: function(e) {
                
               $('#message').show();
               $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
         

               
               
               
             }
           });
          });
         }
       }
        function save_grading_table(fid,company){
          if(document.getElementById("form").checkValidity()){
            $( "#form" ).submit(function( event ) {
             event.preventDefault();
             var form = $(this);
             var url = form.attr('action');
             
             $.ajax({ 
              url: url,
              type: 'POST',
              dataType:'json',
              data: $('#form').serialize(),
              success: function(e) {
                if(e == "true"){
                 $('#message').show();
                 $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
                 $('#myModal').modal('hide');
                 manage_criteria(fid,company);   
               }else{
                
                $('#message').show();
                $('#message').html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+e+"</div>").fadeOut(10000);
                $('#myModal').modal('hide');
                manage_criteria(fid,company);   

              }
              
            }
          });

           });
          }  
        }



        function save_general_form(){
          if(document.getElementById("form4").checkValidity()){
            $( "#form4" ).submit(function( event ) {
              
              event.preventDefault();
              var form = $(this);
              var url = form.attr('action');
              
              $.ajax({ 
                url: url,
                type: 'POST',
                dataType:'json',
                data: $('#form4').serialize(),
                
                success: function(e) {

                 if(e == 'true'){
                   $('#message').show();
                   $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully</div>").fadeOut(10000);
                   $('#myModal').modal('hide');
                   
                   manage_general_form();
                 }else{ 
                  $('#message').show();
                  $('#message').html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+e+"</div>").fadeOut(10000);
                  $('#myModal').modal('hide');
                  
                  manage_general_form();                
                }
                
                
                
              }
            });
            });
          }
        }



        function save_criteria_form(modal_id,fid,company){
         
          $( "#criteria_form" ).submit(function( event ) {
  $('#s').prop('disabled',true);
            event.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            
            $.ajax({ 
              url: url,
              type: 'POST',
          
              data: $('#criteria_form').serialize(),
              success: function(e) {
               
                 $('#message').show();
                 $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
                 $(modal_id).modal('hide');
                 manage_criteria(fid,company);
              
            }
          });
          });
        }

        function save_appraisal_schedule(){
         
          if(document.getElementById("appraisalschedule").checkValidity()){
            $( "#appraisalschedule" ).submit(function( event ) {
              event.preventDefault();
              var form = $(this);
              var url = form.attr('action');
              $.ajax({ 
                url: url,
                type: 'POST',
                dataType:'json',
                data: $('#appraisalschedule').serialize(),
                success: function(s) {

                  if(s == 'true'){
                   $('#message').show();
                   $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
                   $('#myModal').modal('hide');
                   manage_appraisal_schedule();
                 }else{
                  $('#message').show();
                  $('#message').html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+s+"</div>").fadeOut(10000);
                  $('#myModal').modal('hide');
                  manage_appraisal_schedule();
                }
              }
            });
            });
          }

        }
        function save_general(){
          if(document.getElementById("pms_ob").checkValidity()){
            $( "#pms_ob" ).submit(function( event ) {
              event.preventDefault();

              var form = $(this);
              var url = form.attr('action');
              $.ajax({ 
                url: url,
                type: 'POST',
                dataType:'json',
                data: $('#pms_ob').serialize(),
                success: function(e) {
                 if(e == 'true'){
                   $('#message').show();
                   $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
                   $('#genwral').modal('hide');
                   manage_appraisal_schedule();

                 }else{ 
                  $('#message').show();
                  $('#message').html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+e+"</div>").fadeOut(10000);
                  $('#genwral').modal('hide');
                  manage_appraisal_schedule();                
                }
              }
            });
            });
          }
        } function save_position_department(id){
         if(document.getElementById("creator_options").checkValidity()){
           $( "#creator_options" ).submit(function( event ) {
            event.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');
            $.ajax({ 
              url: "<?php echo base_url().'app/pms/save_position_department'?>",
              type: 'POST',
              data: $('#creator_options').serialize(),
              success: function(e) {
                
               $('#message').show();
               $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
               $('#mem').modal('hide');

               
               
               
             }
           });
          });
         }
       }

        function save_employee(){
          if(document.getElementById("pms_obemployee").checkValidity()){
            $( "#pms_obemployee" ).submit(function( event ) {
              event.preventDefault();

              var form = $(this);
              var url = form.attr('action');
              $.ajax({ 
                url: url,
                type: 'POST',
                data: $('#pms_obemployee').serialize(),
                dataType:'json',
                success: function(e) {
                  if(e =='true'){
                   $('#message').show();
                   $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
                   $('#empoyee').modal('hide');
                   $('.modal-backdrop').remove();
                   manage_appraisal_schedule();
                 }else{

                   $('#message').show();
                   $('#message').html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+e+"</div>").fadeOut(10000);
                   $('#empoyee').modal('hide');
                   $('.modal-backdrop').remove();
                   manage_appraisal_schedule();
                 }

               }  
             });
            });
          }
        }
              function save_position(id){
         if(document.getElementById("creator_options").checkValidity()){
           $( "#creator_options" ).submit(function( event ) {
            event.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');
            $.ajax({ 
              url: "<?php echo base_url().'app/pms/save_position'?>",
              type: 'POST',
              data: $('#creator_options').serialize(),
              success: function(e) {
                
               $('#message').show();
               $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
               $('#mem').modal('hide');

               
               
               
             }
           });
          });
         }
       }
        function save_group_pms(){
          if(document.getElementById("save_pms").checkValidity()){
            $( "#save_pms" ).submit(function( event ) {
              
              event.preventDefault();
              var form = $(this);
              var url = form.attr('action');
              $.ajax({ 
                url: url,
                type: 'POST',
                dataType:'json',
                data: $('#save_pms').serialize(),
                success: function(e) {
                  if(e == 'true'){
                   $('#message').show();
                   $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
                   $('#myModal').modal('hide');
                   manage_appraisal_group();
                 }
                 else{
                  $('#message').show();
                  $('#message').html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>'"+e+"'</div>").fadeOut(10000);
                  $('#myModal').modal('hide');
                  manage_appraisal_group();

                }
              }
            });
            });
          }
        }
         function save_evaluator_option2($employee){


         if(document.getElementById("evaluators").checkValidity()){
           $( "#evaluators" ).submit(function( event ) {
            event.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');
            $.ajax({  
              url: "<?php echo base_url()?>app/pms/save_evaluator_option2/"+$employee+"",
              type: 'POST',
    
              data: $('#evaluators').serialize(),
              success: function(e) {
              
               $('#message').show();
               $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
               $('#mem').modal('hide');
          
               get_selected_evaluators('2');
               
               
               
             }
           });
          });
         }
       }
      function save_position_department_section(val){
         if(document.getElementById("creator_options").checkValidity()){
           $( "#creator_options" ).submit(function( event ) {
            event.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');
            $.ajax({ 
              url: "<?php echo base_url().'app/pms/save_position_department_section'?>",
              type: 'POST',
              data: $('#creator_options').serialize(),
              success: function(e) {
                
               $('#message').show();
               $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
               $('#mem').modal('hide');
               
      
               
               
             }
           });
          });
         }
       }

        function save_score_option3(id){
         if(document.getElementById("creator_options").checkValidity()){
           $( "#creator_options" ).submit(function( event ) {
            event.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');
            $.ajax({ 
              url: "<?php echo base_url().'app/pms/save_score_option3'?>",
              type: 'POST',
              data: $('#creator_options').serialize(),
              success: function(e) {
                
               $('#message').show();
               $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
               $('#mem').modal('hide');
               
               manage_scorecard_creators();
               
               
               
             }
           });
          });
         }
       }

       $(document).on('click','.save_score_option2',function(){
              var employee =  $(this).attr('data-id');
              var company =   $(this).attr('data-value');
               $.ajax({  
              url: "<?php echo base_url()?>app/pms/save_score_option2/"+employee+"/"+company+"",
              type: 'POST',
              data: $('#creator_options').serialize(),
              success: function(e) {
                
               $('#message').show();
               $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
               $('#mem').modal('hide');
               
               get_selected_scorer('2');
               
               
               
             }
           });
       });
       // function save_score_option2($employee,$company){
       //   if(document.getElementById("creator_options").checkValidity()){
       //     $( "#creator_options" ).submit(function( event ) {
       //      event.preventDefault();
            
       //      var form = $(this);
       //      var url = form.attr('action'); 
       //      $.ajax({  
       //        url: "<?php echo base_url()?>app/pms/save_score_option2/"+$employee+","+$company+"",
       //        type: 'POST',
       //        data: $('#creator_options').serialize(),
       //        success: function(e) {
                
       //         $('#message').show();
       //         $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
       //         $('#mem').modal('hide');
               
       //         get_selected_scorer('2');
               
               
               
       //       }
       //     });
       //    });
       //   }
       // }



       function save_approvers($id){
         if(document.getElementById("approvers").checkValidity()){
           $( "#approvers" ).submit(function( event ) {
            event.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');
            $.ajax({ 
                 url: "<?php echo base_url()?>app/pms/save_approvers/"+$id+"",
              type: 'POST',
              data: $('#approvers').serialize(),
              success: function(e) {
                
               $('#message').show();
               $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
               $('#mem').modal('hide');
               
               get_selected_approvers('2');
               
               
               
             }
           });
          });
         }
       }

       function save_appraisal_member(id){
         if(document.getElementById("save_appraisal_member").checkValidity()){
           $( "#save_appraisal_member" ).submit(function( event ) {
            event.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');
            $.ajax({ 
              url: "<?php echo base_url().'app/pms/save_appraisal_member'?>",
              type: 'POST',
              data: $('#save_appraisal_member').serialize(),
              success: function(e) {
                
               $('#message').show();
               $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
               $('#mem').modal('hide');
               
               manage_member(id);
               
               
               
             }
           });
          });
         }
       }






//----------------------------------------------------------------------------- updating data functions--------------------------------------------------------------------------------------

function save_update_grading_table($fid,$company,$id){

 $( "#grading_table" ).submit(function( event ) {
  event.preventDefault();
  var form = $(this);
  var url = form.attr('action');
  $.ajax({ 
    url: url,
    type: 'POST',
    data: $('#grading_table').serialize(),
    success: function() {
     $('#message').show();
     $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
     
     manage_criteria($fid,$company,$id);
     
   }
 });
});
}
function save_update_criteria_form($fid , $company){

 $( "#save_update_criteria_form" ).submit(function( event ) {
  event.preventDefault();

  var form = $(this);
  var url = form.attr('action');
  $.ajax({ 
    url: url,
    type: 'POST',
    data: $('#save_update_criteria_form').serialize(),
    success: function() {
     $('#message').show();
     $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
      manage_criteria($fid,$company);
     
   }
 });
});
}
function save_update_general_form(){

 $( "#update_general_form" ).submit(function( event ) {
  event.preventDefault();
  var form = $(this);
  var url = form.attr('action');
  $.ajax({ 
    url: url,
    type: 'POST',
    data: $('#update_general_form').serialize(),
    success: function() {
     $('#message').show();
     $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully</div>").fadeOut(10000);
     
     manage_general_form();
     
   }
 });
});
}

// function save_update_criteria_form(){

//  $( "#update_criteria_form" ).submit(function( event ) {
//   event.preventDefault();
//   var form = $(this);
//   var url = form.attr('action');
//   $.ajax({ 
//     url: url,
//     type: 'POST',
//     data: $('#update_criteria_form').serialize(),
//     success: function() {
//      $('#message').show();
//      $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>form is Successfully Updated!</div>").fadeOut(10000);
     
//      manage_general_form();
     
//    }
//  });
// });
// }

function save_update_group(){


 $( "#appraisal" ).submit(function( event ) {
  event.preventDefault();
  var form = $(this);
  var url = form.attr('action');
  $.ajax({ 
    url: url,
    type: 'POST',
    data: $('#appraisal').serialize(),
    success: function(data) {
    if(data == "good"){

     $('#message').show();
     $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
     
     manage_appraisal_group();
     }else{
     $('#message').show();
     $('#message').html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+data+"Already exist!</div>").fadeOut(10000);
     }

   }
 });
});
}
function save_update_appraisal_schedule(){


 $( "#update_appraisal_schedule" ).submit(function( event ) {
  event.preventDefault();
  var form = $(this);
  var url = form.attr('action');
  $.ajax({ 
    url: url,
    type: 'POST',
    data: $('#update_appraisal_schedule').serialize(),
    success: function() {
     $('#message').show();
     $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
     
     manage_appraisal_schedule();
     
   }
 });
});
}
function save_update_employee_objectives($company){


 $( "#update_employee_objectives" ).submit(function( event ) {

  event.preventDefault();
  var form = $(this);
  var url = form.attr('action');
  $.ajax({ 
    url: url,
    type: 'POST',
    data: $('#update_employee_objectives').serialize(),
    success: function() {
     $('#message').show();
     $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
     
     manage_appraisal_schedule($company);
     
   }
 });
});
}
function save_update_general_objectives($company){


 $( "#update_general_objectives" ).submit(function( event ) {

  event.preventDefault();
  var form = $(this);
  var url = form.attr('action');
  $.ajax({ 
    url: url,
    type: 'POST',
    data: $('#update_general_objectives').serialize(),
    success: function() {
     $('#message').show();
     $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
     
     manage_appraisal_schedule($company);
     
   }
 });
});
}







//--------------------------- end of saving data function------------------------------------------

//--------------------------- view update function------------------------------------------

function view_update_general_form($id){
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
                xmlhttp2.open("GET","<?php echo base_url();?>app/pms/view_update_general_form/"+$id,false);
                xmlhttp2.send();
              }

  function view_update_appraisal_schedule($id,$company_){
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
                    $(document).ready(function(){
                     appraisal_period_type_select = $(".appraisal_period_type_select option:selected").val();

                     $(".appraisal_period_type_select option[value='"+appraisal_period_type_select+"']:not(:selected)").remove();
                     appraisal_type = $(".appraisal_type option:selected").val();

                     $(".appraisal_type option[value='"+appraisal_type+"']:not(:selected)").remove()
                   });
                    
                  }
                }
                xmlhttp2.open("GET","<?php echo base_url();?>app/pms/view_update_appraisal_schedule/"+$id+'/'+$company_,false);
                xmlhttp2.send();
              }

 function view_update_general_objectives($id,$company){
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
                   //  $(document).ready(function(){
                   //   appraisal_period_type_select = $(".appraisal_period_type_select option:selected").val();

                   //   $(".appraisal_period_type_select option[value='"+appraisal_period_type_select+"']:not(:selected)").remove();
                   //   appraisal_type = $(".appraisal_type option:selected").val();

                   //   $(".appraisal_type option[value='"+appraisal_type+"']:not(:selected)").remove()
                   // });
                    
                  }
                }
                xmlhttp2.open("GET","<?php echo base_url();?>app/pms/view_update_general_objectives/"+$id+'/'+$company,false);
                xmlhttp2.send();
              }

 function view_update_employee_objectives($id,$company){
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
                   //  $(document).ready(function(){
                   //   appraisal_period_type_select = $(".appraisal_period_type_select option:selected").val();

                   //   $(".appraisal_period_type_select option[value='"+appraisal_period_type_select+"']:not(:selected)").remove();
                   //   appraisal_type = $(".appraisal_type option:selected").val();

                   //   $(".appraisal_type option[value='"+appraisal_type+"']:not(:selected)").remove()
                   // });
                    
                  }
                }
                xmlhttp2.open("GET","<?php echo base_url();?>app/pms/view_update_employee_objectives/"+$id+'/'+$company,false);
                xmlhttp2.send();
              }




 function view_update_criteria_form($fid) {
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
                xmlhttp2.open("GET","<?php echo base_url();?>app/pms/view_update_criteria_form/"+$fid,false);
                xmlhttp2.send();
              }


                  function update_criteria_form($fid,$c,$company) {
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
                xmlhttp2.open("GET","<?php echo base_url();?>app/pms/updates_criteria_form/"+$fid+'/'+$c+'/'+$company,false);
                xmlhttp2.send();
              }


              function view_update_appraisal_group($id , $company) {
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
                  xmlhttp2.open("GET","<?php echo base_url();?>app/pms/view_update_appraisal_group/"+$id+'/'+$company,false);
                  xmlhttp2.send();
                }



                function view_update_grading_table($id ,$company , $fid) {
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
                xmlhttp2.open("GET","<?php echo base_url();?>app/pms/view_update_grading_table/"+$fid+'/'+$company+'/'+$id,false);
                xmlhttp2.send();
              }

//--------------------------- end of  view update function------------------------------------------


//--------------------------- functions------------------------------------------


function sec(val){
   document.getElementById('department').value;
   alert(department);

}
function get_selected_evaluators(val ,eval_id){

 if($('#company').val() ){
  co = $("#company").val();
show = document.getElementById("show");
  $(show).load('<?php echo base_url()?>app/pms/get_selected_evaluators/'+val+'/'+co+'/'+eval_id,function(){
 
  })

}else{
  swal("", "Please select a company first", "warning");
}
}
function get_selected_plan(val ,eval_id){

 if($('#company').val() ){
  co = $("#company").val();
    var sel = document.getElementById('section');
    var el = document.getElementById('department');
show = document.getElementById("show");
  $(show).load('<?php echo base_url()?>app/pms/get_selected_plan/'+val+'/'+co+'/'+eval_id,function(){
 
 
  })

}else{
  swal("", "Please select a company first", "warning");
}
}
function get_selected_scorer(val ,eval_id){
 if($('#company').val() ){
  co = $("#company").val();
show = document.getElementById("show");
  $(show).load('<?php echo base_url()?>app/pms/get_selected_score/'+val+'/'+co+'/'+eval_id,function(){

      
  })

}else{
  swal("", "Please select a company first", "warning");
}
}
function general_instruction(co){
 if($('#company').val() ){
  co = $("#company").val();
  $('#fetch_all_result').load('<?php echo base_url()?>app/pms/general_instruction/'+co,function(){
    $.fn.editable.defaults.mode = 'inline';
    $('.id').off('click');
    $('#update').on('click', function(e){ 

     e.preventDefault();
     e.stopPropagation();
     $('#instruction_area').editable({ rows:15,inputclass:'input-large'});
     $('#instruction_area').trigger('click');

   });
  })

}else{
  swal("", "Please select a company first", "warning");
}
}
function settings(){
 if($('#company').val() ){
  
  co = $("#company").val();
  $('#fetch_all_result').load('<?php echo base_url()?>app/pms/settings/'+co,function(){

  })

}else{
  swal("", "Please select a company first", "warning");
}
}
function manage_general_form(co){
 
  co = $("#company").val();
  if($('#company').val() ){
   $('#fetch_all_result').load('<?php echo base_url()?>app/pms/manage_general_form/'+co,function(){
    $('.s').select2({width: "100%"});
    $(document).on('click','.removed',function(e){
      $(this).parent().parent().remove();
    });
    $(".number").on("input", function() {
      var nonNumReg = /[^0-9]/g;
      $(this).val($(this).val().replace(nonNumReg, '')); 
    });


    $('.delete_form').click(function(e){

      swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {            
          var val1 = $(this).attr("data-id");
          var val2 = $("#company").val();
          var $button = $(this);
          $.ajax({ 
            url: "<?php echo site_url('app/pms/delete_form'); ?>",
            type: 'POST',
            data: { "text1": val1 ,"text": val2},
            success: function(data) {
             
              $('#message').show();
              $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Record has been inserted successfully</div>").fadeOut(10000);
              manage_general_form();


            }
          });
          
        } else {

        }

      });         

    });




    var columns = $("#table > tbody > tr:first > td").length;
    for (var i = 0; i < columns; i++) {
      if ($("#table > tbody > tr > td:nth-child(" + i + ")").filter(function() {
        return $(this).text() != '';
      }).length == 0) {
        $("#table > tbody > tr > td:nth-child(" + i + "), #table > thead > tr > th:nth-child(" + i + ")").hide();
      }
    } 
    $('.addrow').click(function(e){
     $(".modal-body #app").append('<div class="row"><div class="form-group"><div class="col-md-6"><label for="message-text">Description</label><textarea name="description[]" id="form_description" required class="form-control"></textarea></div><div class="col-md-3"><label for="message-text">weight:</label><div class="input-group"> <input required="" name="des_weight[]" type="number" class="form-control" id="recipient-name"><span class="input-group-addon">%</span></div></div><div class="col-md-3" style="margin-top:40px;"><a href="#" class="removed">Remove  </a></div></div></div></div>')});

    // ("#form4").DataTable();


    $(".input").focus(function() {
      $(this).parent().addClass("focus");
    });

    $(".input").focusout(function() {
      if($(this).val().length < 1 ){
        $(this).parent().removeClass("focus");
      }
    }); 
    
  });
 }else{
  swal("", "Please select a company first", "warning");
}

}
function lock_un(){
 if($('#company').val() ){
  co = $("#company").val();
    $.ajax({
              url: "<?php echo base_url();?>app/pms/lock_un/"+co+"",
              type: 'POST',
              success: function(q) {
              if(q == 0){
                w = 1;
              }else if(q==1){
                w= 0;
              }else{
                w=1;
              }
         
                
                $.ajax({
              url: "<?php echo base_url();?>app/pms/save_lock_un/"+co+"",
              type: 'POST',
              data:{w : w},
              success: function(wer) {
                if(q == 0){
                    alert('Successfully Locked ');
                } else if(q==1){
                    alert('Successfully Unlocked');
                }else{
                    alert('Successfully Locked ');
                }
                
                  location.reload();
               
               
               
             }
           });
         

               
               
               
             }
           });



}else{
  swal("", "Please select a company first", "warning");
}
}




function grading(){
 if($('#company').val() ){  
  co = $("#company").val();
  $('#fetch_all_result').load('<?php echo base_url()?>app/pms/manage_grading_table/'+co,function(){
    var tab= $("#grading_table").DataTable();
  });

}else{
 swal("", "Please select a company first", "warning"); 
}

}
function get_selected_approvers(val){
 if($('#company').val() ){
  co = $("#company").val();
show = document.getElementById("show");
  $(show).load('<?php echo base_url()?>app/pms/get_selected_approvers/'+val+'/'+co,function(){
 
  })

}else{
  swal("", "Please select a company first", "warning");
}
}










function manage_scorecard_creators(){
 if($('#company').val() ){
  co = $("#company").val();
  $('#fetch_all_result').load('<?php echo base_url()?>app/pms/manage_scorecard_creators/'+co,function(){


    $(document).on('change','.radio1',function(){
        val1 =  $(this).attr('data-value');
        val2 =  $(this).attr('data-id');
        $.ajax({
         url: "<?php echo base_url().'app/pms/radio1/'?>",
         method:"POST",
         data:{"text1": val1 , "text2": val2 },
         success:function()
         {
           $('.removeRow').fadeOut(1500);
         }
       })

      });

    $(document).on('click','#select',function(){
       var data = $("#creator_options").serialize();
       $.ajax({
         data: data,
         type: "post",
         url: "<?php echo base_url().'app/pms/get_opt3/'?>",
         success: function(e){
          $('#listing').html(e);
        }
      });
     });



$(document).on('click','#deleteall_set_seperate',function(){

         myCar.delete_all('delete_scorecard_option2','delete_all_option2');

});
$(document).on('click','#deleteall_choose_position',function(){
         myCar.delete_all('delete_scorecard_option3','delete_all_option3');

});                


$(document).on('change','.radio1',function(){
  val1 =  $(this).attr('data-value');
  val2 =  $(this).attr('data-id');
  $.ajax({
   url: "<?php echo base_url().'app/pms/radio1/'?>",
   method:"POST",
   data:{"text1": val1 , "text2": val2 },
   success:function()
   {
     $('.removeRow').fadeOut(1500);
   }
 })

});
$(document).on('click','#checkAll',function(){
  $('.checkall').not(this).prop('checked', this.checked);
});

$(document).on('click','#check',function(){
  $('.check').not(this).prop('checked', this.checked);
});


$(document).on('click','.delete_scorecard_option2', function(event){
  
 swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this data!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
 .then((willDelete) => {
  if (willDelete) {  

   var val1 = $(this).attr("data-id");

   var $button = $(this);
   $.ajax({ 
    url: "<?php echo site_url('app/pms/delete_scorecard_option2'); ?>",
    type: 'POST',
    data: { "text1": val1 },
    success: function() {
     $('#message').show();
     $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Data is Successfully Deleted!</div>").fadeOut(10000);
     manage_scorecard_creators();
   }
 });
 } else {
  
 }
});  });
  });


}else{
 swal("", "Please select a company first", "warning");
}

}


function manage_form_approver(){
 if($('#company').val() ){
  co = $("#company").val();
  $('#fetch_all_result').load('<?php echo base_url()?>app/pms/manage_form_approver/'+co,function(){


    $(document).on('click','#checkAll',function(){
  $('.checkall').not(this).prop('checked', this.checked);
});



$(document).on('click','#check',function(){
  $('.check').not(this).prop('checked', this.checked);
});

$(document).on('click','#deleteall',function(){
      myCar.delete_all('delete_approvers','delete_all_from_approvers');
});          


$(document).on('click','.delete_approvers', function(event){
  
 swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this data!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
 .then((willDelete) => {
  if (willDelete) {  

   var val1 = $(this).attr("data-id");


   var $button = $(this);
   $.ajax({ 
    url: "<?php echo site_url('app/pms/delete_form_approvers'); ?>",
    type: 'POST',
    data: { "text1": val1 },
    success: function() {
     $('#message').show();
     $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Data is Successfully Deleted!</div>").fadeOut(10000);
      get_selected_approvers('2');
   }
 });
 } else {
  
 }
});  });

  });


}else{
 swal("", "Please select a company first", "warning");
}

}
function manage_form_evaluators(){
  
 if($('#company').val() ){
  co = $("#company").val();
  $('#fetch_all_result').load('<?php echo base_url()?>app/pms/manage_form_evaluators/'+co,function(){


  });

$(document).on('click','#checkAll',function(){
  $('.checkall').not(this).prop('checked', this.checked);
});



$(document).on('click','#check',function(){
  $('.check').not(this).prop('checked', this.checked);
});

$(document).on('click','#deleteall',function(){
      myCar.delete_all('delete_evaluators','delete_all_form_evaluators');
});          


$(document).on('click','.delete_evaluators', function(event){
  
 swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this data!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
 .then((willDelete) => {
  if (willDelete) {  

   var val1 = $(this).attr("data-id");


   var $button = $(this);
   $.ajax({ 
    url: "<?php echo site_url('app/pms/delete_form_evaluators'); ?>",
    type: 'POST',
    data: { "text1": val1 },
    success: function() {
     $('#message').show();
     $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Data is Successfully Deleted!</div>").fadeOut(10000);
      manage_form_evaluators();
   }
 });
 } else {
  
 }
});  });

$(document).on('click','#filters',function(ew) {
  ew.preventDefault();
  var data = $("#evaluators").serialize();
  $.ajax({
   data: data,
   type: "post",
   url: "<?php echo base_url().'app/pms/get_evaluator/'?>",
   success: function(e){
    $('#lsit').html(e);
  }
});
});
}else{
 swal("", "Please select a company first", "warning");
}

}
function employee_development_plan(){
 if($('#company').val() ){
  co = $("#company").val();
  $('#fetch_all_result').load('<?php echo base_url()?>app/pms/employee_development_plan/'+co,function(){

      
  })

}else{
  swal("", "Please select a company first", "warning");
}
}
function manage_appraisal_group(){
 if($('#company').val() ){
  co = $("#company").val();
  $('#fetch_all_result').load('<?php echo base_url()?>app/pms/manage_appraisal_group/'+co,function(){
   var tab = $("#appraisal_group").DataTable();
   $("#appraisal_member").DataTable();
   
   

   $(document).ready(function() { 
    $('#myModal').modal('hide');
    $('.modal-backdrop').remove();

    $("#appraisal_group").on('click','.group', function(event){
      
     swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this data!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
     .then((willDelete) => {
      if (willDelete) {  

       var val1 = $(this).attr("data-id");
       var $button = $(this);
       $.ajax({ 
        url: "<?php echo site_url('app/pms/delete_group'); ?>",
        type: 'POST',
        data: { "text1": val1 },
        success: function() {
         $('#message').show();
         $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Data is Successfully Deleted!</div>").fadeOut(10000);
         manage_appraisal_group();
       }
     });
     } else {
      
     }
   });  });
  });

 });


}else{
 swal("", "Please select a company first", "warning");
}

}
function manage_appraisal_schedule($co){
  if($('#company').val() ){
    co = $("#company").val();
    $('#fetch_all_result').load('<?php echo base_url()?>app/pms/manage_appraisal_schedule/'+co,function(){

     if (location.hash) {
      $('a[href=\'' + location.hash + '\']').tab('show');
    }
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
      $('a[href="' + activeTab + '"]').tab('show');
    }

    $('body').on('click', 'a[data-toggle=\'tab\']', function (e) {
      e.preventDefault()
      var tab_name = this.getAttribute('href')
      if (history.pushState) {
        history.pushState(null, null, tab_name)
      }
      else {
        location.hash = tab_name
      }
      localStorage.setItem('activeTab', tab_name)

      $(this).tab('show');
      return false;
    });
    $(window).on('popstate', function () {
      var anchor = location.hash ||
      $('a[data-toggle=\'tab\']').first().attr('href');
      $('a[href=\'' + anchor + '\']').tab('show');
    });

    var appraisal_schedule = $("#appraisal_schedule").DataTable({searching: false, paging: false});
    var manage_general_objectives = $("#manage_general_objectives").DataTable({searching: false, paging: false});

    $('.s').select2({width: "100%",dropdownParent: $("#genwral")});
    $('.e').select2({width: "100%",dropdownParent: $("#empoyee")});
    $('#datePicker').datepicker({
     minViewMode: 2,
     format: 'yyyy',
     
     autoclose: true
   });
         $('#datePicker1').datepicker({
	format: 'mm-dd',
    inline: false,
    lang: 'en',
    multidate: 1,
	
    closeOnDateSelect: true
	     })
      $('#datePicker2').datepicker({
	format: 'yy-mm-dd',
    inline: false,
    lang: 'en',
    multidate: 2,
    closeOnDateSelect: true
	     })
		     $('#datePicker3').datepicker({
	format: 'yy-mm-dd',
    inline: false,
    lang: 'en',
    multidate: 3,

    closeOnDateSelect: true
	     })

		 	 	     $('#datePicker5').datepicker({
	format: 'yy-mm-dd',
    inline: false,
    lang: 'en',
    multidate: 5,
    closeOnDateSelect: true
	     })

    $("#appraisal_schedule").on('click','.delete_type_schedule', function(event){
     
     swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this data!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
     .then((willDelete) => {
      if (willDelete) {  

       var val1 = $(this).attr("data-id");
	     var val2 = $(this).attr("data-value");
       var $button = $(this);
       $.ajax({ 
        url: "<?php echo site_url('app/pms/delete_type_schedule'); ?>",
        type: 'POST',
        data: { "text1": val1, "text4": val2 },
        success: function() {
         $('#message').show();
         $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Data is Successfully Deleted!</div>").fadeOut(10000);
         appraisal_schedule.row( $button.parents('tr') ).remove().draw();
         
         
       }
     });
       
     } else {
      
     }
   });  });
    $("#manage_general_objectives").on('click','.delete_general_objectives', function(event){
     
     swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this data!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
     .then((willDelete) => {
      if (willDelete) {  

       var val1 = $(this).attr("data-id");
       var $button = $(this);

       $.ajax({ 
        url: "<?php echo site_url('app/pms/delete_general_objectives'); ?>",
        type: 'POST',
        data: { "text1": val1 },
        success: function() {
         $('#message').show();
         $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Data is Successfully Deleted!</div>").fadeOut(10000);
         manage_general_objectives.row( $button.parents('tr') ).remove().draw();
         
         
       }
     });
       
     } else {
      
     }
   });  });
    $("#manage_employee_objectives").on('click','.delete_employee_objectives', function(event){
     
     swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this data!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
     .then((willDelete) => {
      if (willDelete) {  

       var val1 = $(this).attr("data-id");
       var $button = $(this);
       $.ajax({ 
        url: "<?php echo site_url('app/pms/delete_employee_objectives'); ?>",
        type: 'POST',
        data: { "text1": val1 },
        success: function() {
         $('#message').show();
         $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Data is Successfully Deleted!</div>").fadeOut(10000);
         manage_appraisal_schedule()
         
         
       }
     });
       
     } else {
      
     }
   });  });

    
  });
}else{
 swal("", "Please select a company first", "warning");
}

}
// function manage_creator_option2(){
//   if($('#company').val() ){

//     co = $("#company").val();
//     $('#fetch_all_result').load('<?php echo base_url()?>app/pms/manage_creator_option2/'+co,function(){
      
      

// // $("#s").on('change', function(){
// //     var selected = $(this).val();

// //     if(selected != null)
// //     {
// //       if(selected.indexOf('all')>=0){

// //           $(this).val('all').select2({allowClear: true,
// //     placeholder: "Select an attribute"});
// //       }
// //     }
// // })


// $(document).on('click','#filtere',function(ew) {
//   ew.preventDefault();
//   var data = $("#creator_options").serialize();
//   $.ajax({
//    data: data,
//    type: "post",
//    url: "<?php echo base_url().'app/pms/opt2/'?>",
//    success: function(e){
//     $('#lsit').html(e);
//   }
// });
// });



// $(document).on('change','.radio1',function(){
//   val1 =  $(this).attr('data-value');
//   val2 =  $(this).attr('data-id');
//   $.ajax({
//    url: "<?php echo base_url().'app/pms/radio1/'?>",
//    method:"POST",
//    data:{"text1": val1 , "text2": val2 },
//    success:function()
//    {
//      $('.removeRow').fadeOut(1500);
//    }
//  })

// });
// $("#checkAll").click(function(){
//   $('.checkall').not(this).prop('checked', this.checked);
// });

// $("#check").click(function(){
//   $('.check').not(this).prop('checked', this.checked);
// });


// $('#deleteall').click(function(){
//     $('#delete_scorecard_option2 input[name=check]:checked').each(function() {

//     $(this).closest('tr').addClass('removeRow');
//   });
//   var checkbox = $('.check:checked');
//   if(checkbox.length > 0)
//   {
//    var checkbox_value = [];
//    $(checkbox).each(function(){
//     checkbox_value.push($(this).val());
//   });
//    $.ajax({
//      url: "<?php echo base_url().'app/pms/delete_all_option2/'?>",
//      method:"POST",
//      data:{checkbox_value:checkbox_value},
//      success:function()
//      {
//        $('.removeRow').fadeOut(1500);
//      }
//    })
//  }
//  else
//  {
//    alert('Select atleast one records');
//  }
// });          

// $("#delete_scorecard_option2").on('click','.delete_scorecard_option2', function(event){
  
//  swal({
//   title: "Are you sure?",
//   text: "Once deleted, you will not be able to recover this data!",
//   icon: "warning",
//   buttons: true,
//   dangerMode: true,
// })
//  .then((willDelete) => {
//   if (willDelete) {  

//    var val1 = $(this).attr("data-id");

//    var $button = $(this);
//    $.ajax({ 
//     url: "<?php echo site_url('app/pms/delete_scorecard_option2'); ?>",
//     type: 'POST',
//     data: { "text1": val1 },
//     success: function() {
//      $('#message').show();
//      $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Data is Successfully Deleted!</div>").fadeOut(10000);
//      manage_creator_option2();
//    }
//  });
//  } else {
  
//  }
// });  });
// });
//   }else{
//    swal("", "Please select a company first", "warning");
//  }
 
// }
function map(){
 if($('#company').val() ){
  
  co = $("#company").val();
  $('#fetch_all_result').load('<?php echo base_url()?>app/pms/map/'+co,function(){

  })

}else{
  swal("", "Please select a company first", "warning");
}
}
function manage_creator_option3(){
  if($('#company').val() ){

    co = $("#company").val();

    $('#fetch_all_result').load('<?php echo base_url()?>app/pms/manage_creator_option3/'+co,function(){
     
      $('#select').change(function(){
       var data = $("#creator_options").serialize();
       $.ajax({
         data: data,
         type: "post",
         url: "<?php echo base_url().'app/pms/get_opt3/'?>",
         success: function(e){
          $('#listing').html(e);
        }
      });
     });
      $(document).on('change','.radio1',function(){
        val1 =  $(this).attr('data-value');
        val2 =  $(this).attr('data-id');
        $.ajax({
         url: "<?php echo base_url().'app/pms/radio1/'?>",
         method:"POST",
         data:{"text1": val1 , "text2": val2 },
         success:function()
         {
           $('.removeRow').fadeOut(1500);
         }
       })

      });
      $("#checkAll").click(function(){
        $('.checkall').not(this).prop('checked', this.checked);
      });
      
      $("#check").click(function(){
        $('.check').not(this).prop('checked', this.checked);
      });
      
      $('#check').click(function(){
        $('#delete_scorecard_option3 input[name=check]:checked').each(function() {

          $(this).closest('tr').addClass('removeRow');
        });
      });
      $('#deleteall').click(function(){
        var checkbox = $('.check:checked');
        if(checkbox.length > 0)
        {
         var checkbox_value = [];
         $(checkbox).each(function(){
          checkbox_value.push($(this).val());
        });
         $.ajax({
           url: "<?php echo base_url().'app/pms/delete_all/'?>",
           method:"POST",
           data:{checkbox_value:checkbox_value},
           success:function()
           {
             $('.removeRow').fadeOut(1500);
           }
         })
       }
       else
       {
         alert('Select atleast one records');
       }
     });          

      $("#delete_scorecard_option3").on('click','.delete_scorecard_option3', function(event){
        
       swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
       .then((willDelete) => {
        if (willDelete) {  

         var val1 = $(this).attr("data-id");
         var $button = $(this);
         $.ajax({ 
          url: "<?php echo site_url('app/pms/delete_scorecard_option3'); ?>",
          type: 'POST',
          data: { "text1": val1 },
          success: function() {
           $('#message').show();
           $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Data is Successfully Deleted!</div>").fadeOut(10000);
           manage_creator_option3();
         }
       });
       } else {
        
       }
     });  });
    });
  }else{
   swal("", "Please select a company first", "warning");
 }
 
}
function manage_member(id , company){
  if($('#company').val() ){

    co = $("#company").val();
    $('#fetch_all_result').load('<?php echo base_url()?>app/pms/manage_member/'+id+'/'+company,function(){
     $(document).on('click','#filter',function(ew) {
      
      ew.preventDefault();
      var data = $("#save_appraisal_member").serialize();
      $.ajax({
       data: data,
       type: "post",
       url: "<?php echo base_url().'app/pms/e/'?>",
       success: function(e){
        $('#listing').html(e);
      }
    });
    });
     var tab = $("#get_member").DataTable();
     $("#members").DataTable();
     
     

// $("#s").on('change', function(){
//     var selected = $(this).val();

//     if(selected != null)
//     {
//       if(selected.indexOf('all')>=0){

//           $(this).val('all').select2({allowClear: true,
//     placeholder: "Select an attribute"});
//       }
//     }
// })

$("#checkAll").click(function(){
  $('.checkall').not(this).prop('checked', this.checked);
});

$("#check").click(function(){
  $('.check').not(this).prop('checked', this.checked);
});

$(document).on('click','.delete_member', function(event){
 
 swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this data!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
 .then((willDelete) => {
  if(willDelete) {  

   var val1 = $(this).attr("data-id");
   var $button = $(this);
   $.ajax({ 
    url: "<?php echo site_url('app/pms/delete_member'); ?>",
    type: 'POST',
    data: { "text1": val1 },
    success: function() {
     $('#message').show();
     $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Data is Successfully Deleted!</div>").fadeOut(10000);
     manage_member(id);
     
     
   }
 });
   
 } else {
  
 }
});  });


});
  }else{
   swal("", "Please select a company first", "warning");
 }
 
}
function manage_criteria(id,company,gid){
  if($('#company').val() ){

    co = $("#company").val();
    $('#fetch_all_result').load("<?php echo base_url()?>app/pms/manage_criteria/"+id+"/"+company+"/"+gid,function(){
     if (location.hash) {
      $('a[href=\'' + location.hash + '\']').tab('show');
    }
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
      $('a[href="' + activeTab + '"]').tab('show');
    }

    $('body').on('click', 'a[data-toggle=\'tab\']', function (e) {
      e.preventDefault()
      var tab_name = this.getAttribute('href')
      if (history.pushState) {
        history.pushState(null, null, tab_name)
      }
      else {
        location.hash = tab_name
      }
      localStorage.setItem('activeTab', tab_name)

      $(this).tab('show');
      return false;
    });
    $(window).on('popstate', function () {
      var anchor = location.hash ||
      $('a[data-toggle=\'tab\']').first().attr('href');
      $('a[href=\'' + anchor + '\']').tab('show');
    });
    var tab = $("#get_member").DataTable();
    var tab1 = $("#grading_table").DataTable({"paging":   false, "info":     false ,"searching": false});

    $("#members").DataTable();
                          // var tab1= $("#grading_table").DataTable({searching: false, paging: false});



                          $('.s').select2({width: "100%"});
                          var columns = $("#table > tbody > tr:first > td").length;
                          for (var i = 0; i < columns; i++) {
                            if ($("#table > tbody > tr > td:nth-child(" + i + ")").filter(function() {
                              return $(this).text() != '';
                            }).length == 0) {
                              $("#table > tbody > tr > td:nth-child(" + i + "), #table > thead > tr > th:nth-child(" + i + ")").hide();
                            }
                          }                  $('.addrow').click(function(e){
                           $(".modal-body #app").append('<div class="row"><div class="form-group"><div class="col-md-6"><label for="message-text">Description</label><textarea name="description[]" id="form_description" required class="form-control"></textarea></div><div class="col-md-3"><label for="message-text">weight:</label><div class="input-group"> <input required="" name="des_weight[]" type="number" class="form-control" id="recipient-name"><span class="input-group-addon">%</span></div></div><div class="col-md-3" style="margin-top:40px;"><a href="#" class="removed">Remove  </a></div></div></div></div>')});



                          $(document).on('click','.removed',function(e){


                            $(this).parent().parent().remove();
                          });
                          $(document).on('click','.delete_criteria',function(e){
                           var $tr = $(this).closest('tr'); 

                           swal({
                            title: "Are you sure?",
                            text: "Once deleted, you will not be able to recover this data!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                          })
                           .then((willDelete) => {
                            if (willDelete) {  

                             var val1 = $(this).attr("data-id");
                             var $button = $(this);
                             $.ajax({ 
                              url: "<?php echo site_url('app/pms/delete_criteria'); ?>",
                              type: 'POST',
                              data: { "text1": val1 },
                              success: function() {
                               $('#message').show();
                               $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Data is Successfully Deleted!</div>").fadeOut(10000);
                               $tr.find('td').fadeOut(1000,function(){ 
                                $tr.remove();                    
                              }); 
                             }
                           });
                           } else {
                            
                           }
                         });  });

     // gradingggggggggggggggggggggggggggggggg

    $('#copy').click(function(){
        

       if (confirm('clicking okay will overwrite existing grading scale')) {

         
        var listing = $('#listing');
        $('#listing').empty();

        var val1 = $(this).attr("data-id");
 
        var  company_ = $('input[name=company_]').val();
         var id = $('#fid').val();
    var  company_ = $('input[name=company_]').val();
        $.ajax({
         data: { "getfid": val1,'company':company_},
         
         type: "post",
         url: "<?php echo base_url().'app/pms/copy/'?>",
         success: function(data){
          listing.html(data);
                                    

                                      }
                                    });
      } else {
       
      }  
      
    });
     $('.get_existed_grading').click(function(){
      
       if (confirm('clicking okay will overwrite existing grading scale')) {

         
        var listing = $('#listing');
        $('#listing').empty();
        var score = $('input[name=gid]').val();
        var scoring_guide = $('input[name=scoring_guide]').val();
        var  equivalent = $('input[name=score_equivalent]').val();
        var  ranking = $('input[name=ranking]').val();
        var  fid = $('input[name=fid]').val();

        var  color = $('input[name=color]').val();
        var val1 = $(this).attr("data-id");

        var id = $('#fid').val();
        var  company_ = $('input[name=company_]').val();

        $.ajax({
         data: { "getfid": val1 , "id": id},
         
         type: "post",
         url: "<?php echo base_url().'app/pms/get_existed_grading/'?>",
         success: function(data){
          listing.html(data);
                                    

                                      }
                                    });
      } else {
       
      }     
      
    });
$("#grading_table").on('click','.delete', function(event){
 
var $tr = $(this).closest('tr'); 
  swal({
    title: "Are you sure?",
    text: "Once deleted, you will not be able to recover this data!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      var val2 = $("#company").val();
      var val1 = $(this).attr("data-id");
      var $button = $(this);


      $.ajax({ 
        url: "<?php echo site_url('app/pms/delete_grade'); ?>",
        type: 'POST',
        data: { "text1": val1,"text":val2},
        success: function(data) { 
          $('#message').show();
          $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Data is Successfully Deleted!</div>").fadeOut(5000);
          tab1.row( $button.parent('tr') ).remove().draw();

             $tr.find('td').fadeOut(1000,function(){ 
                                $tr.remove();                    
                              }); 

        }
      });

      
    } else {
     
    }
  });




});


});
}else{
 swal("", "Please select a company first", "warning");
}

}


//--------------------------- end of functions------------------------------------------

$(document).ready(function(){

$(':button').prop('disabled', true);

  $(function(){


    $('#company').change(function(){
      id = this.value;
      co_name = $("#company option:selected").text();
      $('#company_name').text(co_name);
      co = $("#company").val();

      $('#fetch_all_result').load('<?php echo base_url()?>app/pms/general_instruction/'+co,function(){
        $('#update').on('click', function(e){ 

         e.preventDefault();
         e.stopPropagation();
         $('#instruction_area').editable({

           rows:15,
           inputclass:'input-large'

         });
         $('#instruction_area').trigger('click');

       });
      })
    })





    $(document).on('click','#manage_scorecard_creators', function(){
      manage_scorecard_creators();
    })
    $(document).on('click','#general_instruction', function(){
      general_instruction();
    })
    $(document).on('click','#grading',function(){
      grading();
    });
    $(document).on('click','#lock_un',function(){
      lock_un();
    });
    $(document).on('click','#manage_general_form',function(){
      manage_general_form();
    });

   $(document).on('click','#employee_development_plan', function(){
      employee_development_plan();
    })
    $(document).on('click','#manage_appraisal_group',function(){
      manage_appraisal_group();
    });

    $(document).on('click','#manage_appraisal_schedule',function(){
      manage_appraisal_schedule();
    });
    $(document).on('click','#manage_appraisal_group_members',function(){
      manage_appraisal_group_members();
    });
       $(document).on('click','#manage_form_approver',function(){
      manage_form_approver();
    });
          $(document).on('click','#manage_form_evaluators',function(){
      manage_form_evaluators();
    });
     $(document).on('click','#settings',function(){
      settings();
    });
        $(document).on('click','#map',function(){
      map();
    });




  });

  co_name = $("#company option:selected").val();

  $("#company option[value='"+co_name+"']:not(:selected)").remove();


//para sa active element 
$(".nav a").on("click", function(){
   $(".nav").find(".activeclick").removeClass("activeclick");
   $(this).children('i').addClass("activeclick");
});




$('#wqweqweqwe').DataTable({
  "pageLength": -1,
  "pagingType" : "simple",
  "paging": true,
  "lengthChange": true,
  lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": true
});



});


</script>

</body>
</html>