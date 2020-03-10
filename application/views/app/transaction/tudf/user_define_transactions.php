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
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/iCheck/all.css">

    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
      
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Create New Transaction
    <small>User Define Transaction (Transaction Form)</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Transaction Form</li>
    <li class="active">User Define Transactions</li>
  </ol>
</section>

      <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

      <div class="row">



   



        <div class="col-md-4">
          <div class="box box-primary">

                <!-- <div class="panel panel-info"> -->
                <div class="panel-heading"><strong>Select a company</strong> <!-- <a onclick="addNewUDFCol()" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="Add"><i class="fa fa-plus-square fa-2x text-primary delete pull-right"></i></a> -->
  </div>

                     <!-- SEARCH HANAP DITO HOY /////////////////////////////////////////////////////////////////////////////////////
                  <a onclick="create_new_transaction()" type="button"  class="btn btn-danger btn-xs pull-right"><i class="fa fa-plus"></i> Create New transaction</a>
                   SEARCH HANAP DITO HOY -->

                <div class="box-body">
                <!-- <div class="col-sm-10"> -->
                  <select class="form-control" name="company" id="company" onclick="view_company_udt(this.value)" required>
                    <option selected="selected" value="none">~ Select Company UDF Forms ~</option>
                    <option value="0">~ ALL ~</option>
                      <?php 
                        foreach($companyList as $company){
                          echo "<option value='".$company->company_id."' >".$company->company_name."</option>";
                        }
                      ?>
                  </select>    
                <!-- </div> -->

                <div id="view_company_udf">
                                
                </div>

                </div> <!-- box body -->
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     
     <!-- </div>  row -->




<script >
   function create_new_transaction(val)
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/transaction_file_maintenance/create/"+val,true);
        xmlhttp.send();

        }
   function next()
        {          
        var no_of_field = document.getElementById('no_of_field').value;     
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/transaction_file_maintenance/next/"+no_of_field,false);
        xmlhttp.send();

        }
</script>



                          
<script>

<!--//=====================//-->


function trim(el) {
    el.value = el.value.
    replace(/(^\s*)|(\s*$)/gi, ""). // removes leading and trailing spaces
    replace(/[ ]{2,}/gi, " "). // replaces multiple spaces with one space 
    replace(/\n +/, "\n"); // Removes spaces after newlines
    return;
}

function pagdatepicker(val){
  var nof = document.getElementById('type'+val).value;
  
 // alert(nof);
  var data  = nof;
 
  if(data =='Textarea')
  {
      $('#max_length'+val).show('show');
      $('#accept_value'+val).show('show');
      $('#for_av'+val).show('show');
      $('#for_ml'+val).show('show');
      $('#max_length'+val).attr('disabled', false);
      $('#for_ml'+val).attr('disabled', false); 
      $('#accept_value'+val).attr('disabled', false);
      $('#for_av'+val).attr('disabled', false);
      $('.a_v'+val).attr('disabled', true);
      $('.m_l'+val).attr('disabled', true);
      document.getElementById('for_ml'+val).innerHTML = 'Max Length';
       $('#for_ml'+val).css("color", "black");
      $("#max_length"+val).attr("placeholder", "Max Length").blur();
  }else if(data =='Selectbox'){
      $('#max_length'+val).show('show');
      $('#accept_value'+val).show('show');
      $('#for_av'+val).show('show');
      $('#for_ml'+val).show('show');
      $('#max_length'+val).attr('disabled', false);
      $('#for_ml'+val).attr('disabled', false); 
      $('#accept_value'+val).attr('disabled', false);
      $('#for_av'+val).attr('disabled', false);
       $('.a_v'+val).attr('disabled', true);
      $('.m_l'+val).attr('disabled', true);
      document.getElementById('for_ml'+val).innerHTML = 'No. of Option';
      $('#for_ml'+val).css("color", "red");
      $("#max_length"+val).attr("placeholder", "How Many Options").blur();
  }else if(data =='Textfield'){
      $('#max_length'+val).show('show');
      $('#accept_value'+val).show('show');
      $('#for_av'+val).show('show');
      $('#for_ml'+val).show('show');
      $('#max_length'+val).attr('disabled', false);
      $('#for_ml'+val).attr('disabled', false); 
      $('#accept_value'+val).attr('disabled', false);
      $('#for_av'+val).attr('disabled', false);
      $('.a_v'+val).attr('disabled', true);
      $('.m_l'+val).attr('disabled', true);
      document.getElementById('for_ml'+val).innerHTML = 'Max Length';
       $('#for_ml'+val).css("color", "black");
       $("#max_length"+val).attr("placeholder", "Max Length").blur();
  }else if(data =='Datepicker'){
     $('#max_length'+val).hide('hide');
      $('#accept_value'+val).hide('hide');
      $('#for_av'+val).hide('hide');
      $('#for_ml'+val).hide('hide');
      $('#max_length'+val).attr("disabled", true);
      $('#for_ml'+val).attr("disabled", true);
      $('#accept_value'+val).attr("disabled", true);
      $('#for_av'+val).attr("disabled", true); 
      $('.a_v'+val).attr('disabled', false);
      $('.m_l'+val).attr('disabled', false);
     document.getElementById('for_ml'+val).innerHTML = 'Max Length';
      $("#max_length"+val).attr("placeholder", "Max Length").blur();
  }

  
}

function for_maxlength(val){
  var sel = document.getElementById('type'+val).value;
   var av = document.getElementById('accept_value'+val).value;
  
  
  var data  = av;
 // alert(data);
 if(sel != 'Selectbox'){
   if(data =='varchar')
  {   
      $('#max_length'+val).show('show');
      $('#for_ml'+val).show('show');
       $('#max_length'+val).attr("disabled", false);
      $('#for_ml'+val).attr("disabled", false); 
      $('#max_length'+val).removeAttr('max',99);
      $('#max_length'+val).attr('max',255); 
      $('.m_l'+val).attr('disabled', true);

  }else if(data =='int'){
      $('#max_length'+val).show('show');
      $('#for_ml'+val).show('show');
       $('#max_length'+val).attr("disabled", false);
      $('#for_ml'+val).attr("disabled", false);
      $('#max_length'+val).removeAttr('max',255);
      $('#max_length'+val).attr('max',99);
       $('.m_l'+val).attr('disabled', true);

  }else if(data =='text'){
      $('#max_length'+val).hide('hide');
      $('#for_ml'+val).hide('hide'); 
      $('#max_length'+val).attr("disabled", true);
      $('#for_ml'+val).attr("disabled", true);
      $('.m_l'+val).attr('disabled', false);
  }
}else{
   if(data =='varchar')
  {   
      $('#max_length'+val).show('show');
      $('#for_ml'+val).show('show');
       $('#max_length'+val).attr("disabled", false);
      $('#for_ml'+val).attr("disabled", false); 
      $('#max_length'+val).removeAttr('max',99);
      $('#max_length'+val).attr('max',255); 
      $('.m_l'+val).attr('disabled', true);

  }else if(data =='int'){
      $('#max_length'+val).show('show');
      $('#for_ml'+val).show('show');
       $('#max_length'+val).attr("disabled", false);
      $('#for_ml'+val).attr("disabled", false);
      $('#max_length'+val).removeAttr('max',255);
      $('#max_length'+val).attr('max',99);
      $('.m_l'+val).attr('disabled', true);

  }else if(data =='text'){
      $('#max_length'+val).show('show');
      $('#for_ml'+val).show('show'); 
      $('#max_length'+val).attr("disabled", false);
      $('#for_ml'+val).attr("disabled", false);
      $('.m_l'+val).attr('disabled', true);
  }
}

}

function for_single_maxlength(){
  var sel = document.getElementById('type').value;
   var av = document.getElementById('accept_value').value;
  
  
  var data  = av;
 // alert(data);
 if(sel != 'Selectbox'){
   if(data =='varchar')
  {   
      $('#max_length').show('show');
      $('#for_ml').show('show');
       $('#max_length').attr("disabled", false);
      $('#for_ml').attr("disabled", false); 
      $('#max_length').removeAttr('max',99);
      $('#max_length').attr('max',255); 
      $('.m_l').attr('disabled', true);

  }else if(data =='int'){
      $('#max_length').show('show');
      $('#for_ml').show('show');
       $('#max_length').attr("disabled", false);
      $('#for_ml').attr("disabled", false);
      $('#max_length').removeAttr('max',255);
      $('#max_length').attr('max',99);
       $('.m_l').attr('disabled', true);

  }else if(data =='text'){
      $('#max_length').hide('hide');
      $('#for_ml').hide('hide'); 
      $('#max_length').attr("disabled", true);
      $('#for_ml').attr("disabled", true);
      $('.m_l').attr('disabled', false);
  }
}else{
   if(data =='varchar')
  {   
      $('#max_length').show('show');
      $('#for_ml').show('show');
       $('#max_length').attr("disabled", false);
      $('#for_ml').attr("disabled", false); 
      $('#max_length').removeAttr('max',99);
      $('#max_length').attr('max',255); 
      $('.m_l').attr('disabled', true);

  }else if(data =='int'){
      $('#max_length').show('show');
      $('#for_ml').show('show');
       $('#max_length').attr("disabled", false);
      $('#for_ml').attr("disabled", false);
      $('#max_length').removeAttr('max',255);
      $('#max_length').attr('max',99);
      $('.m_l').attr('disabled', true);

  }else if(data =='text'){
      $('#max_length').show('show');
      $('#for_ml').show('show'); 
      $('#max_length').attr("disabled", false);
      $('#for_ml').attr("disabled", false);
      $('.m_l').attr('disabled', true);
  }
}

}


////////////////////////////////////////////////////////////////////////////////
  function addNewUDFCol_new(val)
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/transaction_user_define_fields/create_new/"+val,true);
        xmlhttp.send();

        }
   function next_new()
        {          
        var no_of_field = document.getElementById('no_of_field').value;
        var company_id = document.getElementById('company_id').value;     
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/transaction_user_define_fields/next_create_new/"+no_of_field+"/"+company_id,false);
        xmlhttp.send();

        }
        /////////////////////////////////////////////////////////////////////////////////////////////////////


 function addNewUDFCol1(val)
 {          
    
         var t_table_name = document.getElementById('t_table_name').value; 
        var company_id = document.getElementById('company_id').value;  
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/transaction_user_define_fields/add_new_emp_udf1/"+val+"/"+t_table_name+"/"+company_id,true);
        xmlhttp.send();

        }



    function addUDFOption(val)
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
              
              document.getElementById("col_3").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_user_define_fields/add_opt_emp_udf/"+val,true);
          xmlhttp.send();

    }

    function editUDFCol(val)
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
                
                document.getElementById("col_2").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/transaction_user_define_fields/edit_emp_udf_col_new/"+val,true);
            xmlhttp.send();
    }


       function editUDFCol1(val)
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
                
                document.getElementById("col_2").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/transaction_user_define_fields/edit_emp_udf1_new/"+val,true);
            xmlhttp.send();
    }


    function editUDFOpt(val)
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
                
                document.getElementById("col_3").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/transaction_user_define_fields/edit_emp_udf_opt/"+val,true);
          xmlhttp.send();
    }
  
    function viewUDFCol(val)
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
                
                document.getElementById("col_2").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/transaction_user_define_fields/view_emp_udf/"+val,true);
            xmlhttp.send();
    }

    function viewUDFOPT(val)
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
                
                document.getElementById("col_2").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/transaction_user_define_fields/view_emp_udf_opt/"+val,true);
            xmlhttp.send();
    }



        function viewUDFOPT1(val)
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
                
                document.getElementById("col_2").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/transaction_user_define_fields/view_emp_udf_opt1/"+val,true);
            xmlhttp.send();
    }

    function add_forTextfield(val)
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
            
            document.getElementById("addforTextfield").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/transaction_user_define_fields/view_add_forTextfield/"+val,true);
        xmlhttp.send();
    }


     function add_forTextfield1(val)
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
            
            document.getElementById("addforTextfield").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/transaction_user_define_fields/view_add_forTextfield1/"+val,true);
        xmlhttp.send();
    }

    function edit_forTextfield(val)
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
            
            document.getElementById("editforTextfield").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/transaction_user_define_fields/view_edit_forTextfield/"+val,true);
        xmlhttp.send();
    }  

    function view_company_udt(val)
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
            
            document.getElementById("view_company_udf").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/transaction_user_define_fields/view_company_udt/"+val,true);
        xmlhttp.send();
    }       


</script>

<!-- FILE MAINTENANCE LIST ================================================================================================= -->
                                    <div class="col-md-8" id="col_2">  
                    </div>
                </div>
            </div><!-- /.box-body -->
             
            <!-- Loading (remove the following to stop the loading)-->   
            <div class="overlay" hidden="hidden" id="loading">
            <i class="fa fa-spinner fa-spin"></i>
            </div>
            <!-- ./ end loading -->

             


  <?php require_once(APPPATH.'views/include/footer.php');?></div>
    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>
   

 <script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#company_logo')
                    .attr('src', e.target.result)
                    .width(240)
                    .height(240);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

$("#userfile").change(function(){
    readURL(this);
});
</script>




  </body>
</html>

