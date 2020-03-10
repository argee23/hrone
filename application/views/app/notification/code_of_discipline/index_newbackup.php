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
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">

   <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]--> <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script src="<?php echo base_url()?>public/chartjs/Chart.min.js"></script>
    <script src="<?php echo base_url()?>public/chartjs/moment.js"></script>
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    <script>
    function printProfile(divID) {

      var printContents = document.getElementById(divID).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;

    }
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
    Notification
    <small>Code Of Discipline</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Notification</li>
    <li class="active">Code of Discipline</li>
  </ol>
</section>

      <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

      <div class="row">
       <div class="col-md-3">
          <div class="box box-primary">
            <div class="panel panel-info">
            <div class="panel-heading"><strong>Select a Company</strong></div>
            <div class="btn-group-vertical btn-block">

                <?php foreach($companyList as $company){?>
                  <a onclick="view_company_location('<?php echo $company->company_id; ?>')" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong><?php echo $company->company_name; ?></strong></p></a>
                <?php } ?>

            </div>  
           </div>             
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     




<style>

      .scrollbar_all {

        height: 450px;
        overflow-x: hidden;
        overflow-y: scroll;
      }


      .force-overflow {
          min-height: 250px;
      }

      #style-1::-webkit-scrollbar {
          width: 5px;
          background-color: #d9edf7;
      } 

      #style-1::-webkit-scrollbar-thumb {
          background-color: #3c8dbc;
      }

      #style-1::-webkit-scrollbar-track {
          -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.3);
          background-color: #d9edf7;
      }
      
</style>



<!-- SCRIPT -->
<script>
    function view_company_location(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/code_of_discipline/view_company_location/"+val,true);
        xmlhttp.send();
    }

      function view_page()
    {      
      var company_id = document.getElementById('company_id').value;
      //alert(company_id);
      var location_id = document.getElementById('location_id').value;
      //alert(location_id); 
      window.open("<?php echo base_url();?>app/code_of_discipline/view_all_cod/"+company_id+"/"+location_id,true);
      window.send();
     
    }

       function view_page_disob(val)
    {   
      alert(val);   
      var company_id = document.getElementById('company_id').value;
      var location_id = document.getElementById('location_id').value;
  
      window.open("<?php echo base_url();?>app/code_of_discipline/view_all_cod_disob/"+val+"/"+company_id+"/"+location_id,true);
      window.send();
     
    }


    /* function gotochart()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/code_of_discipline/chart");
        xmlhttp.send();
    }*/


    function view_comploc_discipline(location)
    {      

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
                 
                    $(function(){

                      showallcod();
                      
                     
                     //Add New Modal
                            $('#btnAddcod').click(function(){
                                 tinymce.remove();
                                 tinymce.init({
                                                      selector: 'textarea',
                                                      height: 100,
                                                      theme: 'modern',
                                                      menubar:false,
                                                      plugins: 'emoticons print preview fullpage searchreplace autolink directionality link charmap hr advlist lists textcolor wordcount link contextmenu colorpicker textpattern help',
                                                      toolbar1: 'formatselect | fontsizeselect | fontselect | bold  italic underline strikethrough superscript subscript undo redo cut copy paste find and replace hr forecolor backcolor | link | charmap | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat preview emoticons',
                                                      font_formats: 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats',
                                                       fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                                                      image_advtab: true,
                                                     
                                                     });
                                $('#myModal').modal('show');
                                $('#myModal').find('.modal-title').text('Add New Code of Discipline');
                                $('#myForm').attr('action','<?php echo base_url()?>app/code_of_discipline/save_add_cod/<?php echo $this->uri->segment("4"); ?>');

                                     $('input[name=cod_id]').val('');
                                     $('input[name=codnumberings]').val('');
                                     $('select[name=codnumbering]').val('');
                                     tinymce.get('title').setContent('');
                                     tinymce.get('description').setContent('');
                                     $('input[name=newtitle]').val('');
                                     $('input[name=newdesc]').val('');
                                     $("#num_availability").empty();
                                     $("#location_hide").show();
                                                     

                            });

                            $('#btnSavecod').unbind().click(function(){
                                var url = $('#myForm').attr('action');
                                var data = $('#myForm').serialize();

                                //validate form
                                var companyid = $('input[name=company_id]');
                                var locationid = $('input[name=location_id]');
                                var numbering = $('select[name=codnumbering]');
                                var title = $('input[name=newtitle]');
                                var description = $('input[name=newdesc]');
                                var result = '';
                            
                                  if(numbering.val()==''){
                                      numbering.parent().addClass('has-error');
                                    }else{
                                    
                                      numbering.parent().removeClass('has-error');
                                      result += '1';
                                     }
                                  

                         
                                  if(result=='1'){


                                      $.ajax({
                                          type: 'ajax',
                                          method: 'post',
                                          url: url,
                                          data: data,
                                          async: false,
                                          dataType: 'json',
                                          success: function(response){

                                              showallcod();
                                              if(response.success){

                                              if(response.type == 'exist'){
                                                 $('#alertsuccess').removeClass('alert-success');
                                                 $('#alertsuccess').addClass('alert-warning');
                                                 $('#alertsuccess').html('Code of Discipline Already Exist!').fadeIn().delay(4000).fadeOut('slow');
                                                 
                                            
                                              }else if(response.type == 'update'){
                                                   var type = 'Updated';
                                                   $('#alertsuccess').removeClass('alert-warning');
                                                   $('#alertsuccess').addClass('alert-success');
                                                   $('#alertsuccess').html('Code of Discipline '+type+' Successfully').fadeIn().delay(4000).fadeOut('slow');
                                                   
                                                
                                              }else if(response.type == 'add'){
                                                    var type = 'Added';
                                                   $('#alertsuccess').removeClass('alert-warning');
                                                   $('#alertsuccess').addClass('alert-success');
                                                   $('#alertsuccess').html('Code of Discipline '+type+' Successfully').fadeIn().delay(4000).fadeOut('slow');
                                                   
                                            
                                              }
                                          
                                              
                                              }else{
                                                alert('Error');
                                              }
                                              
                                          },
                                          error: function(){
                                            alert('Could not Add this Code of Discipline');
                                          }
                                      }); 
                                  }
                                 

                            });

                        //EDIT 
                          $('#showdata').on('click','.item-edit', function(){
                              var id = $(this).attr('data');
                               $('#myModal').modal('show');
                               $('#myModal').find('.modal-title').text('Edit Code of Discipline');
                               $('#myForm').attr('action', '<?php echo base_url() ?>app/code_of_discipline/save_update_cod');
                               $("#num_availability").empty();
                               $("#location_hide").hide();

                               tinymce.remove();
                               tinymce.init({
                                                      selector: 'textarea',
                                                      height: 100,
                                                      theme: 'modern',
                                                      menubar:false,
                                                      plugins: 'emoticons print preview fullpage searchreplace autolink directionality link charmap hr advlist lists textcolor wordcount link contextmenu colorpicker textpattern help',
                                                      toolbar1: 'formatselect | fontsizeselect | fontselect | bold italic underline strikethrough superscript subscript undo redo cut copy paste find and replace hr forecolor backcolor | link | charmap | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat preview emoticons',
                                                      font_formats: 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats',
                                                       fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                                                      image_advtab: true,
                                                     
                                                     });
                               $.ajax({
                                  type: 'ajax',
                                  method: 'get',
                                  url: '<?php echo base_url()?>app/code_of_discipline/edit_code_discipline',
                                  data: {id: id},
                                  async: false,
                                  dataType: 'json',
                                  success: function(data){
                                     $('input[name=cod_id]').val(data.cod_id);
                                     $('input[name=codnumberings]').val(data.numbering);
                                     $('select[name=codnumbering]').val(data.numbering);
                                     $('textarea[name=title]').val(data.title);
                                     $('textarea[name=description]').val(data.description);
                                     $('input[name=newtitle]').val(data.title);
                                     $('input[name=newdesc]').val(data.description);

                                     var titles = document.getElementById('newtitle').value;
                                     var descriptions = document.getElementById('newdesc').value;
                                     tinymce.get('title').setContent(titles);
                                     tinymce.get('description').setContent(descriptions);
                                      },
                                  error: function(){
                                    alert('Could not Edit Data');
                                  }

                               });
                               
                          });

                        //DELETE 
                           $('#showdata').on('click','.item-delete', function(){
                                  var id = $(this).attr('data');
                                  $('#deleteModal').modal('show');

                                  $('#btnDelete').unbind().click(function(){

                                      $.ajax({
                                          type: 'ajax',
                                          method: 'get',
                                          async: false,
                                          url: '<?php echo base_url()?>app/code_of_discipline/delete_cod',
                                          data: {id: id},
                                          dataType: 'json',
                                          success: function(response){
                                              showallcod();
                                              if(response.success){
                                             $('#alertsuccess').removeClass('alert-success');
                                             $('#alertsuccess').addClass('alert-warning');
                                             $('#alertsuccess').html('Code of Discipline Delete Successfully').fadeIn().delay(4000).fadeOut('slow');
                                              
                                              }else{
                                                alert('Error');
                                              }
                                              },
                                          error: function(){
                                            alert('Error Deleting');
                                          }



                                      });

                                  });
                                  

                           });

                           //numbering already exist
                              $('#codnumbering').change(function(){
                                  var cod_num = $('select[name=codnumbering]').val();
                                  //alert(cod_num);
                                  var company_id = $('#company_id').val();
                                  // alert(company_id);
                                  var location_id = $('#location_id').val();
                                   //alert(location_id);
                                  
                                  if(cod_num != '' || cod_num != 0){
                                      $.ajax({
                                          type: 'ajax',
                                          url: '<?php echo base_url()?>app/code_of_discipline/check_numbering',
                                          method: 'POST',
                                          data: {cod_num: cod_num, company_id: company_id, location_id: location_id},
                                         // dataType: 'json',
                                          success:function(data){

                                            $('#disremov').val(data);
                                                    if(data == '<label class="text-danger" style="background-color:white;"><span class="glyphicon glyphicon-remove"></span> Numbering is Already Exist </label>'){
                                                      
                                                      $('#btnSavecod').attr("disabled", true);

                                                    }
                                                    else{
                                                        $('#btnSavecod').removeAttr('disabled');
                                                      }
                                            $('#num_availability').html(data);
                                          }


                                      });

                                  }

                              });

                          $('#closecod').unbind().click(function(){
                          $('#btnSavecod').attr("disabled", true);
                        
                          });
                          $('#closecodq').unbind().click(function(){
                          $('#btnSavecod').attr("disabled", true);
                         
                          });

                        //function 
                                function showallcod(){
                                    var company_id = $('#company_id').val();
                                    var location_id = location;
                                
                                    $.ajax({

                                            type: 'ajax',
                                            method: 'get',
                                            url: '<?php echo base_url()?>app/code_of_discipline/showallcod',
                                            data: {company_id: company_id, location_id: location_id},
                                            async: false,
                                            dataType: 'json',
                                            success: function(data){
                                                // html = '';
                                          
                                                
                                               

                                                        
                                                 var  html =   '<table id="example1" class="table table-bordered table-responsive">'+
                                                                    '<thead tyle="display: none;">'+
                                                                     '<tr style="display: none;">'+
                                                                           
                                                                            '<th style="visibility: hidden;display: none;">numbering</th>'+
                                                                            '<th style="visibility: hidden;display: none;">title</th>'+
                                                                            '<th style="visibility: hidden;display: none;"></th>'+

                                                                      '</tr>'+
                                                                    '</thead>'+
                                                                    '<tbody>';
                                                       var i;

                                                   for (i = 0; i < data.length; i++) {

                                                               html += '<tr>'+
                                                                         '<input type="hidden" class="form-control" name="comp_id" id="comp_id" value="'+data[i].company_id+'">'+
                                                                     '<input type="hidden" class="form-control" name="loc_id" id="loc_id" value="'+data[i].location_id+'">'+

                                                                        '<td style="text-align:left;">'+data[i].numbering+'</td>'+
                                                                        '<td style="text-align:left;">'+data[i].title+'<span colspan="2" class="col-xs-10" style="text-overflow: ellipsis;  white-space: nowrap; width: 655px; overflow: hidden; display: inline-block;">'+data[i].description+'...<a onclick="view_disob('+data[i].cod_id+');" data-toggle="tooltip" data-placement="right" title="CLick to View this '+data[i].numbering+' Code of Discipline"><strong>see more</strong>'+'</a>'+
                                                                        '</span>'+
                                                                        '</td>'+
                                                                        '<td>'+
                                                                            
                                                                            '<a style="margin-left:2px; margin-top:2px;" href="javascript:;" class="item-delete pull-right" data="'+data[i].cod_id+'" data-toggle="tooltip" title="Delete '+data[i].numbering+' Code of Discipline"><?php echo '<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';" "></i>';?></a>'+

                                                                             '<a style="margin-left:2px; margin-top:2px;" href="javascript:;" class="item-edit pull-right" onclick="disremoveedit('+data[i].cod_id+');" data="'+data[i].cod_id+'" data-toggle="tooltip" title="Edit '+data[i].numbering+' Code of Discipline"><?php echo '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" "></i>';?></a>'+
                                                                        '</td>'+
                                                                    '</tr>';
                                                                                                                            
} 
                                                
                                                                html += '</tbody>' + '</table>';

   

                                                $('#showdata').html(html);
                                                $("#example1").DataTable(); 
                                               
                                                
                                            },
                                            error: function(){
                                                alert('Could not get data');
                                            }

                                    });
                                      
                                         
                                                                   
                                }
                     
                    });

/* $('#showdata').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
             url: '<?php echo base_url()?>app/code_of_discipline/showallcod',
            "type": "GET"
        },
        "columns": [
            { "data": "numbering" },
            { "data": "title" },
            { "data": "description" }
        ]
    } );*/
              
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/code_of_discipline/view_comploc_discipline/"+company_id+"/"+location,true);
        xmlhttp.send();
    }



function view_disob(val)
    {     
        var cod_id = val;
        var company = $('#comp_id').val();
        var location = $('#loc_id').val();
      
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
                    $(function(){
                      showallcoddis();
                     // showallcoddislist();
                    
                        
                        //ADD DISOBEDIENCE

                        $('#showdata').on('click','.item-add-disob', function(){
                                  var id = $(this).attr('data');   
                                  tinymce.remove();
                                  tinymce.init({
                                                        selector: 'textarea',
                                                        height: 100,
                                                        theme: 'modern',
                                                        menubar:false,
                                                        plugins: 'emoticons print preview fullpage searchreplace autolink directionality link charmap hr advlist lists textcolor wordcount link contextmenu colorpicker textpattern help',
                                                        toolbar1: 'formatselect | fontsizeselect | fontselect | bold italic underline strikethrough superscript subscript undo redo cut copy paste find and replace hr forecolor backcolor | link | charmap | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat preview emoticons',
                                                        font_formats: 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats',
                                                         fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                                                        image_advtab: true,
                                                       
                                                       });
                                $('#disobedienceModal').modal('show');
                                $('#disobedienceModal').find('.modal-title').text('Add New Disobedience with Equilvalent Punishment');
                                $('#myFormdisob').attr('action','<?php echo base_url()?>app/code_of_discipline/save_add_disob/<?php echo $this->uri->segment("4"); ?>');

                                     $('input[name=cod_id]').val(id);
                                     tinymce.get('distitle').setContent('');
                                     $('select[name=no_of_field]').val('');
                                     $("#dito_ka").empty();
                                    
                                   
 

                               $('#btnSaveob').unbind().click(function(){
                                var url = $('#myFormdisob').attr('action');
                                var data = $('#myFormdisob').serialize();

                                //validate form
                                var disobedience = $('#disobedience');
                                var companyid = $('input[name=company_id]');
                                var locationid = $('input[name=location_id]');
                                var cod_id = $('select[name=cod_id]');
                                var no_of_field = $('select[name=no_of_field]');
                             
                                var result = '';
                            
                                  if(cod_id.val()=='' || cod_id.val()==0){
                                      cod_id.parent().addClass('has-error');
                                    }else{
                                    
                                      cod_id.parent().removeClass('has-error');
                                      result += '1';
                                     }
                                         
                         
                                  if(result=='1'){
                                      $.ajax({
                                          type: 'ajax',
                                          method: 'post',
                                          url: url,
                                          data: data,
                                          async: false,
                                          dataType: 'json',
                                          success: function(response){

                                              showallcoddis();
                                            //  showallcoddislist();
                                              if(response.success){

                                                if(response.type == 'exist'){
                                                 $('#alertsuccessa').removeClass('alert-success');
                                                 $('#alertsuccessa').addClass('alert-warning');
                                                 $('#alertsuccessa').html('Disobediece with Equivalent Punishment Already Exist!').fadeIn().delay(4000).fadeOut('slow');
                                                 
                                            
                                              }else if(response.type == 'update'){
                                                   var type = 'Updated';
                                                   $('#alertsuccessa').removeClass('alert-warning');
                                                   $('#alertsuccessa').addClass('alert-success');
                                                   $('#alertsuccessa').html('Disobediece with Equivalent Punishment '+type+' Successfully').fadeIn().delay(4000).fadeOut('slow');
                                                   
                                                
                                              }else if(response.type == 'add'){
                                                    var type = 'Added';
                                                   $('#alertsuccessa').removeClass('alert-warning');
                                                   $('#alertsuccessa').addClass('alert-success');
                                                   $('#alertsuccessa').html('Disobediece with Equivalent Punishment '+type+' Successfully').fadeIn().delay(4000).fadeOut('slow');
                                                   
                                            
                                              }


                                             /* if(response.type == 'add'){
                                                var type = 'Added';
                                              }else if(response.type == 'update'){
                                                var type = 'Updated';
                                              }
                                               
                                               $('.alert-success').html('Disobediece with Equivalent Punishment '+type+' Successfully').fadeIn().delay(2000).fadeOut('slow');*/
                                              
                                              }else{
                                                alert('Error');
                                              }
                                              
                                          },
                                          error: function(){
                                            alert('Could not Add this Code of Discipline');
                                          }
                                      }); 
                                  }
                          

                            });
                                  

                           });

                          $('#closemo').unbind().click(function(){
                          $("#dito_ka").empty();
                          $('#btnSaveob').attr("disabled", true);
                        
                          });
                          $('#closemopa').unbind().click(function(){
                          $( "#dito_ka" ).empty();
                          $('#btnSaveob').attr("disabled", true);
                         
                          });

                           //EDIT DISOBEDIENCE
                          $('#showdatadis').unbind().on('click','.item-editdisob', function(){
                              var id = $(this).attr('data');
                              //alert(id);
                               $('#editdisobModal').modal('show');
                               $('#editdisobModal').find('.modal-title').text('Edit Disobedience Title');
                               $('#myFormeditdisob').attr('action', '<?php echo base_url() ?>app/code_of_discipline/save_update_disobedience');
                              
                               tinymce.remove();
                               tinymce.init({
                                                      selector: 'textarea',
                                                      height: 100,
                                                      theme: 'modern',
                                                      menubar:false,
                                                      plugins: 'emoticons print preview fullpage searchreplace autolink directionality link charmap hr advlist lists textcolor wordcount link contextmenu colorpicker textpattern help',
                                                      toolbar1: 'formatselect | fontsizeselect | fontselect | bold italic underline strikethrough superscript subscript undo redo cut copy paste find and replace hr forecolor backcolor | link | charmap | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat preview emoticons',
                                                      font_formats: 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats',
                                                       fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                                                      image_advtab: true,
                                                     
                                                     });
                               $.ajax({
                                  type: 'ajax',
                                  method: 'get',
                                  url: '<?php echo base_url()?>app/code_of_discipline/edit_disobedience',
                                  data: {id: id},
                                  async: false,
                                  dataType: 'json',
                                  success: function(data){

                                     $('input[name=cod_id]').val(data.cod_id);
                                     $('input[name=cod_disob_id]').val(data.cod_disob_id);
                                     $('textarea[name=distitles]').val(data.disob_title);
                                     $('input[name=newdistitles]').val(data.disob_title);
                                     var titles = document.getElementById('newdistitles').value;
                                     tinymce.get('distitles').setContent(titles);
                                     
                                      },
                                  error: function(){
                                    alert('Could not Edit Data');
                                  }

                               });
                               
                          });
                        

                          $('#btnSaveobedit').unbind().click(function(){
                                var url = $('#myFormeditdisob').attr('action');
                                var data = $('#myFormeditdisob').serialize();

                                //validate form
                               
                                var companyid = $('input[name=company_id]');
                                var locationid = $('input[name=location_id]');
                                var cod_id = $('input[name=cod_id]');
                                 var cod_disob_id = $('input[name=cod_disob_id]');
                             
                                var result = '';
                            
                                  if(cod_disob_id.val()=='' || cod_disob_id.val()==0){
                                      cod_disob_id.parent().addClass('has-error');
                                    }else{
                                    
                                      cod_disob_id.parent().removeClass('has-error');
                                      result += '1';
                                     }
                                         
                         
                                  if(result=='1'){
                                      $.ajax({
                                          type: 'ajax',
                                          method: 'post',
                                          url: url,
                                          data: data,
                                          async: false,
                                          dataType: 'json',
                                          success: function(response){

                                              showallcoddis();
                                             // showallcoddislist();
                                              if(response.success){

                                                if(response.type == 'exist'){
                                                 $('#alertsuccessa').removeClass('alert-success');
                                                 $('#alertsuccessa').addClass('alert-warning');
                                                 $('#alertsuccessa').html('Disobediece with Equivalent Punishment Already Exist!').fadeIn().delay(4000).fadeOut('slow');
                                                 
                                            
                                              }else if(response.type == 'update'){
                                                   var type = 'Updated';
                                                   $('#alertsuccessa').removeClass('alert-warning');
                                                   $('#alertsuccessa').addClass('alert-success');
                                                   $('#alertsuccessa').html('Disobediece with Equivalent Punishment '+type+' Successfully').fadeIn().delay(4000).fadeOut('slow');
                                                   
                                                
                                              }else if(response.type == 'add'){
                                                    var type = 'Added';
                                                   $('#alertsuccessa').removeClass('alert-warning');
                                                   $('#alertsuccessa').addClass('alert-success');
                                                   $('#alertsuccessa').html('Disobediece with Equivalent Punishment '+type+' Successfully').fadeIn().delay(4000).fadeOut('slow');
                                                   
                                            
                                              }


                                            /*  if(response.type == 'add'){
                                                var type = 'Added';
                                              }else if(response.type == 'update'){
                                                var type = 'Updated';
                                              }
                                                 
                                               $('.alert-success').html('Disobediece with Equivalent Punishment '+type+' Successfully').fadeIn().delay(2000).fadeOut('slow');*/
                                              
                                              }else{
                                                alert('Error');
                                              }
                                              
                                          },
                                          error: function(){
                                            alert('Could not Add this Disobediece');
                                          }
                                      }); 
                                  }
                          

                            });



                                //DELETE 
                           $('#showdatadis').on('click','.item-deletedisob', function(){
                                  var cod_disob_id = $(this).attr('data');
                                 // alert(cod_disob_id);

                                  $('#deletedisModal').modal('show');

                                  $('#btnDeletedis').unbind().click(function(){

                                      $.ajax({
                                          type: 'ajax',
                                          method: 'get',
                                          async: false,
                                          url: '<?php echo base_url()?>app/code_of_discipline/delete_disobedience',
                                          data: {id: cod_disob_id},
                                          dataType: 'json',
                                          success: function(response){
                                              showallcoddis();
                                             // showallcoddislist();
                                              if(response.success){
                                              $('#alertsuccessa').removeClass('alert-success');
                                              $('#alertsuccessa').addClass('alert-warning');
                                            
                                               $('#alertsuccessa').html('Disobedience Delete Successfully').fadeIn().delay(4000).fadeOut('slow');
                                              
                                              }else{
                                                alert('Error');
                                              }
                                              },
                                          error: function(){
                                            alert('Error Deleting');
                                          }



                                      });

                                  });
                                  

                           });
                         
                           //ADD PUNISHMENT

                             $('#showdatadis').on('click','.item-add-punish', function(){
                                  var disob_id = $(this).attr('data');   
                                  //alert(disob_id);

                               $('#punishModal').modal('show');
                               $('#punishModal').find('.modal-title').text('Add Suspension/Punishment');
                               $('#myFormpunish').attr('action', '<?php echo base_url() ?>app/code_of_discipline/save_add_punishment');
                              
                                $('input[name=disobedience]').val('');
                                $('textarea[name=suspun]').val('');
                                $('select[name=numdays]').val('');
                                $('select[name=numdis]').val('');
                                $('#disob_availability').empty();
                                $('#numdis_availability').empty();
                                $.ajax({
                                  type: 'ajax',
                                  method: 'get',
                                  url: '<?php echo base_url()?>app/code_of_discipline/edit_disobedience',
                                  data: {id: disob_id},
                                  async: false,
                                  dataType: 'json',
                                  success: function(data){

                                     $('input[name=cod_id]').val(data.cod_id);
                                     $('input[name=cod_disob_id]').val(data.cod_disob_id);
                                     $('input[name=company_id]').val(data.company_id);
                                     $('input[name=location_id]').val(data.location_id);
                                     
                                      },
                                  error: function(){
                                    alert('Could not Edit Data');
                                  }

                               });
                               
                          });

                          $('#closemonga').unbind().click(function(){
                          $("#dito_kana").empty();
                          $('#btnSavepunish').attr("disabled", true);
                        
                          });
                          $('#closemopanga').unbind().click(function(){
                          $( "#dito_kana" ).empty();
                          $('#btnSavepunish').attr("disabled", true);
                       
                          });   


                            //disobedience punsihment already exist
                              $('#disobedience').change(function(){
                                  var disobedience = $('input[name=disobedience]').val();
                                  var company_id = $('#company_id').val();
                                  var location_id = $('#location_id').val();
                                  var cod_id = $('#cod_id').val();
                                  var cod_disob_id = $('#cod_disob_id').val();
                                  
                                  if(disobedience != '' || disobedience != 0){
                                      $.ajax({
                                          type: 'ajax',
                                          url: '<?php echo base_url()?>app/code_of_discipline/check_disob_punish',
                                          method: 'POST',
                                          data: {disobedience: disobedience, company_id: company_id, location_id: location_id, cod_id: cod_id, cod_disob_id: cod_disob_id},
                                         // dataType: 'json',
                                          success:function(data){

                                          //  $('#disremov').val(data);
                                                    if(data == '<label class="text-danger" style="background-color:white;"><span class="glyphicon glyphicon-remove"></span> Disobedience Punishment is Already Exist </label>'){
                                                      $('#btnSavepunish').attr("disabled", true);
                                                    }
                                                    else{
                                                        $('#btnSavepunish').removeAttr('disabled');
                                                      }
                                            $('#disob_availability').html(data);
                                          }


                                      });

                                  }

                              });

                                 //disobedience punsihment already exist
                              $('#numdis').change(function(){
                                  var numdis = $('select[name=numdis]').val();
                                  alert(numdis);
                                  var company_id = $('#company_id').val();
                                  var location_id = $('#location_id').val();
                                  var cod_id = $('#cod_id').val();
                                  var cod_disob_id = $('#cod_disob_id').val();
                                  
                                  if(disobedience != '' || disobedience != 0){
                                      $.ajax({
                                          type: 'ajax',
                                          url: '<?php echo base_url()?>app/code_of_discipline/check_disob_punish_number',
                                          method: 'POST',
                                          data: {numdis: numdis, company_id: company_id, location_id: location_id, cod_id: cod_id, cod_disob_id: cod_disob_id},
                                         // dataType: 'json',
                                          success:function(data){

                                          //  $('#disremov').val(data);
                                                    if(data == '<label class="text-danger" style="background-color:white;"><span class="glyphicon glyphicon-remove"></span> Disobedience No. is Already Exist </label>'){
                                                      $('#btnSavepunish').attr("disabled", true);
                                                    }
                                                    else{
                                                        $('#btnSavepunish').removeAttr('disabled');
                                                      }
                                            $('#numdis_availability').html(data);
                                          }


                                      });

                                  }

                              });


                            $('#btnSavepunish').unbind().click(function(){
                                var url = $('#myFormpunish').attr('action');
                                var data = $('#myFormpunish').serialize();

                                //validate form
                               
                                var companyid = $('input[name=company_id]');
                                var locationid = $('input[name=location_id]');
                                var cod_id = $('input[name=cod_id]');
                                var cod_disob_id = $('input[name=cod_disob_id]');
                             
                                var result = '';
                            
                                  if(cod_disob_id.val()=='' || cod_disob_id.val()==0){
                                      cod_disob_id.parent().addClass('has-error');
                                    }else{
                                    
                                      cod_disob_id.parent().removeClass('has-error');
                                      result += '1';
                                     }
                                         
                         
                                  if(result=='1'){
                                      $.ajax({
                                          type: 'ajax',
                                          method: 'post',
                                          url: url,
                                          data: data,
                                          async: false,
                                          dataType: 'json',
                                          success: function(response){

                                              showallcoddis();
                                              //showallcoddislist();
                                              if(response.success){
                                                 if(response.type == 'exist'){
                                                 $('#alertsuccessa').removeClass('alert-success');
                                                 $('#alertsuccessa').addClass('alert-warning');
                                                 $('#alertsuccessa').html('Punishment Already Exist!').fadeIn().delay(4000).fadeOut('slow');
                                                 
                                            
                                              }else if(response.type == 'update'){
                                                   var type = 'Updated';
                                                   $('#alertsuccessa').removeClass('alert-warning');
                                                   $('#alertsuccessa').addClass('alert-success');
                                                   $('#alertsuccessa').html('Punishment '+type+' Successfully').fadeIn().delay(4000).fadeOut('slow');
                                                   
                                                
                                              }else if(response.type == 'add'){
                                                    var type = 'Added';
                                                   $('#alertsuccessa').removeClass('alert-warning');
                                                   $('#alertsuccessa').addClass('alert-success');
                                                   $('#alertsuccessa').html('Punishment '+type+' Successfully').fadeIn().delay(4000).fadeOut('slow');
                                                   
                                            
                                              }

                                             /* if(response.type == 'add'){
                                                var type = 'Added';
                                              }else if(response.type == 'update'){
                                                var type = 'Updated';
                                              }
                                               $('#alertsuccessa').removeClass('alert-warning');
                                               $('#alertsuccessa').addClass('alert-success');
                                               $('#alertsuccessa').html('Punishment '+type+' Successfully').fadeIn().delay(2000).fadeOut('slow');
                                              */
                                              }else{
                                                alert('Error');
                                              }
                                              
                                          },
                                          error: function(){
                                            alert('Could not Add this Punishment');
                                          }
                                      }); 
                                  }
                          

                            });


                   //EDIT PUNISHMENT
                          $('#show_punishment').on('click','.item-edit-punish', function(){
                              var punish_id = $(this).attr('data');
                                tinymce.remove();
                               
                              //alert(punish_id);
                              $('#viewdispunModal').modal('hide');
                              $('#punisheditModal').modal('show');
                               $('#punisheditModal').find('.modal-title').text('Edit Suspension/Punishment');
                               $('#myFormpunishedit').attr('action', '<?php echo base_url() ?>app/code_of_discipline/save_update_punishment');
                               tinymce.remove();

                              $.ajax({
                                  type: 'ajax',
                                  method: 'get',
                                  url: '<?php echo base_url()?>app/code_of_discipline/edit_punishment',
                                  data: {id: punish_id},
                                  async: false,
                                  dataType: 'json',
                                  success: function(data){

                                     $('input[name=cod_id]').val(data.cod_id);
                                     $('input[name=cod_disob_id]').val(data.cod_disob_id);
                                     $('input[name=company_id]').val(data.company_id);
                                     $('input[name=location_id]').val(data.location_id);
                                     $('input[name=pun_id]').val(data.pun_id);
                                     $('input[name=disobedience]').val(data.disob);
                                     if(data.punish == 1 || data.punish == 2){
                                     $('select[name=suspun]').val(data.punish);
                                    }else{
                                     $('textarea[name=suspun]').val(data.punish);
                                     }
                                     $('select[name=numdays]').val(data.num_days);
                                     $('input[name=numdis]').val(data.offense);
                                     
                                     
                                      },
                                  error: function(){
                                    alert('Could not Edit Data');
                                  }

                               });
                               
                          });
                        

                            $('#btnSavepunishedit').unbind().click(function(){
                                var url = $('#myFormpunishedit').attr('action');
                                var data = $('#myFormpunishedit').serialize();

                                //validate form
                               
                                var companyid = $('input[name=company_id]');
                                var locationid = $('input[name=location_id]');
                                var cod_id = $('input[name=cod_id]');
                                var cod_disob_id = $('input[name=cod_disob_id]');
                                var pun_id = $('input[name=pun_id]');
                                var disobedience = $('#disobedience');
                                var suspun = $('textarea#suspun');
                                var num_days = $('#numdays');
                                var numdis = $('#numdis');
                             

                                var result = '';
                            
                                  if(pun_id.val()=='' || pun_id.val()==0){
                                    
                                      pun_id.parent().addClass('has-error');
                                    }else{
                                      
                                      pun_id.parent().removeClass('has-error');
                                      result += '1';
                                     }
                                     if(disobedience.val()=='' || disobedience.val()==0){
                                     
                                      disobedience.parent().addClass('has-error');
                                    }else{
                                      
                                      disobedience.parent().removeClass('has-error');
                                      result += '2';
                                     }
                                  
                                         
                         
                                  if(result=='12'){
                                      $.ajax({
                                          type: 'ajax',
                                          method: 'post',
                                          url: url,
                                          data: data,
                                          async: false,
                                          dataType: 'json',
                                          success: function(response){

                                              showallcoddis();
                                              //showallcoddislist();
                                              if(response.success){
                                                 if(response.type == 'exist'){
                                                 $('#alertsuccessa').removeClass('alert-success');
                                                 $('#alertsuccessa').addClass('alert-warning');
                                                 $('#alertsuccessa').html('Punishment Already Exist!').fadeIn().delay(4000).fadeOut('slow');
                                                 
                                            
                                              }else if(response.type == 'update'){
                                                   var type = 'Updated';
                                                   $('#alertsuccessa').removeClass('alert-warning');
                                                   $('#alertsuccessa').addClass('alert-success');
                                                   $('#alertsuccessa').html('Punishment '+type+' Successfully').fadeIn().delay(4000).fadeOut('slow');
                                                   
                                                
                                              }else if(response.type == 'add'){
                                                    var type = 'Added';
                                                   $('#alertsuccessa').removeClass('alert-warning');
                                                   $('#alertsuccessa').addClass('alert-success');
                                                   $('#alertsuccessa').html('Punishment '+type+' Successfully').fadeIn().delay(4000).fadeOut('slow');
                                                   
                                            
                                              }


                                             /* if(response.type == 'add'){
                                                var type = 'Added';
                                              }else if(response.type == 'update'){
                                                var type = 'Updated';
                                              }
                                            
                                               $('#alertsuccessa').html('Punishment '+type+' Successfully').fadeIn().delay(2000).fadeOut('slow');
                                              */
                                              }else{
                                                alert('Error');
                                              }
                                              
                                          },
                                          error: function(){
                                            alert('Could not Update this Punishment');
                                          }
                                      }); 
                                  }
                          

                            });

                         


                            //DELETE PUNISHMENT

                                 $('#show_punishment').on('click','.item-delete-punish', function(){
                                        var pun_id = $(this).attr('data');
                                        //alert(pun_id);
                                         $('#viewdispunModal').modal('hide');
                                        $('#deletedispunModal').modal('show');

                                        $('#btnDeletedispun').unbind().click(function(){

                                            $.ajax({
                                                type: 'ajax',
                                                method: 'get',
                                                async: false,
                                                url: '<?php echo base_url()?>app/code_of_discipline/delete_punishment',
                                                data: {id: pun_id},
                                                dataType: 'json',
                                                success: function(response){
                                                    showallcoddis();
                                                    //showallcoddislist();
                                                    if(response.success){
                                                     $('#alertsuccessa').removeClass('alert-success');
                                                     $('#alertsuccessa').addClass('alert-warning');
                                                     $('#alertsuccessa').html('Punsihment Delete Successfully').fadeIn().delay(4000).fadeOut('slow');
                                                    
                                                    }else{
                                                      alert('Error');
                                                    }
                                                    },
                                                error: function(){
                                                  alert('Error Deleting');
                                                }



                                            });

                                        });
                                        

                                 });


                        //View Punishment
                          $('#showdatadis').on('click','.item-view-punish', function(){
                              var view_id = $(this).attr('data');
                             //alert(view_id);
                             
                              $('#viewdispunModal').modal('show');
                              $('#viewdispunModal').find('.modal-title').text('View of Disobedience with Equivalent Punishment');
                            
                               $.ajax({
                                  type: 'ajax',
                                  method: 'get',
                                  url: '<?php echo base_url()?>app/code_of_discipline/showallcodpunishlist',
                                  data: {id: view_id},
                                  async: false,
                                  dataType: 'json',
                                  success: function(data){

                                      var html = '';
                                                var i;

                                              
                                                for(i=0; i<data.length; i++){

                                                        if(data[i].punish == 1){
                                                          datas = "Suspension/Suspensyon";
                                                        }else if(data[i].punish == 2){
                                                          datas = "Dismissal/Pagkakatangal";
                                                        }else{
                                                          datas = data[i].punish;
                                                        }

                                                       html +='<tr>'+
                                                                          '<td style="text-align:center;">'+data[i].pun_id+'</td>'+
                                                                          '<td style="text-align:center;">'+data[i].disob+'</td>'+
                                                                          '<td style="text-align:center;">'+data[i].num_days+'</td>'+ 
                                                                          '<td style="text-align:center;">'+data[i].offense+'</td>'+
                                                                          '<td style="text-align:center;">'+datas+'</td>'+
                                                                          '<td style="text-align:center;">'+
                                                                           '<a href="javascript:;" class="item-edit-punish" data="'+data[i].pun_id+'"  data-toggle="tooltip" title="Edit '+data[i].pun_id+'&nbsp;'+data[i].disob+' Punishment"><?php
                                                                                   echo '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" "></i>';?></a>'+
                                                                           '<a href="javascript:;" class="item-delete-punish" data="'+data[i].pun_id+'"  data-toggle="tooltip" title="Delete '+data[i].pun_id+'&nbsp;'+data[i].disob+' Punishment"><?php
                                                                                   echo '<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';" "></i>';?></a>'+

                                                                          '</td>'+
                                                                  '</tr>';
                                              }

                                               $('#show_punishment').html(html);

                                     
                                      },
                                  error: function(){
                                    alert('Could not Get Data');
                                  }

                               });
                               
                          });

                        

                        //function 
                                function showallcoddis(){
                                       var id = cod_id;
                                        var company_id = company;
                                        var location_id = location;
                                        
                                        $.ajax({
                                            type: 'ajax',
                                            method: 'get',
                                            url: '<?php echo base_url()?>app/code_of_discipline/showallcoddis',
                                            data: {id: id, company_id: company_id, location_id: location_id},
                                            async: false,
                                            dataType: 'json',
                                            success: function(data){
                                                var html = '';
                                                var i;

                                              
                                                for(i=0; i<data.length; i++){
                                                       html +=          
                                                                      '<a  href="javascript:;" class="btn btn-default  pull-right item-add-disob" data="'+data[i].cod_id+'"  data-toggle="tooltip" data-placement="bottom" data- title="Add new Disobedience and Suspension with Equivalent Punishment"><?php
                                                                      echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>Add';?></a>'+
                                                                        '<a  id="btnView" type="button" class="btn btn-default pull-right" data-toggle="tooltip" data-placement="left" data- title="View All Code of Discipline" onclick="view_page_disob('+data[i].cod_id+');"><?php
                                                                          echo '<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';" "></i>View';
                                                                          ?></a>'+

                                                                        '<br></br>'+    
                                                                        '<div class="panel-headingr"><center><b><h2>COMPANY CODE OF DISCIPLINE</h2></b></center></div>'+
                                                                        '<br>'+
                                                                     
                                                                      '<div style="text-align:center;">'+data[i].numbering+'</div>'+
                                                                      '<div style="text-align:center;">'+data[i].title+'</div>'+
                                                                      
                                                                      '<div style="text-align:center; margin-left:50px; margin-right:50px;">'+data[i].description+'</div>';
                                                             
                                                }

                                                $('#showdata').html(html);



                                           
                                            },
                                            error: function(){
                                                alert('Could not get data');
                                            }
                                    });

                                      $.ajax({
                                            type: 'ajax',
                                            method: 'get',
                                            url: '<?php echo base_url()?>app/code_of_discipline/showallcoddislist',
                                            data: {id: id, company_id: company_id, location_id: location_id},
                                            async: false,
                                            dataType: 'json',
                                            success: function(data){
                                                var html = '';
                                                var i;
                                                var trr;

                                              
                                                for(i=0; i<data.length; i++){

                                                     



                                                       html +='<tr>'+
                                                                          '<td>'+data[i].cod_disob_id+'</td>'+
                                                                          '<td style="text-align:center;">'+data[i].disob_title+'</td>'+
                                                                          '<td align="center">'+
                                                                                '<a href="javascript:;" class="pull-center item-view-punish" data="'+data[i].cod_disob_id+'"  data-toggle="tooltip" title="View Suspension/Punishment of Disobedience ID '+data[i].cod_disob_id+'"><?php
                                                                                   echo '<i  class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';" "></i>';?></a>'+
                                                                                 
                                                                                 '<a href="javascript:;" class="pull-center item-add-punish" data="'+data[i].cod_disob_id+'"  data-toggle="tooltip" title="Add new Suspension with Equivalent Punishment"><?php
                                                                                  echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';?></a>'+
                                                                                  
                                                                                '<a href="javascript:;" class="pull-center item-editdisob" data="'+data[i].cod_disob_id+'"  data-toggle="tooltip" title="Edit Disobedience ID '+data[i].cod_disob_id+'"><?php
                                                                                   echo '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" "></i>';?></a>'+

                                                                                 '<input type="hidden" class="form-control" name="cod_id" id="cod_id" value="'+data[i].cod_id+'">'+
                                                                                 '<a href="javascript:;" class="pull-center item-deletedisob" data="'+data[i].cod_disob_id+'" data-toggle="tooltip" title="Delete Disobedience ID '+data[i].cod_disob_id+'"><?php
                                                                                   echo '<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';" "></i>';?></a>'+

                                                                          '</td>'+

                                                              
                                                                '</tr>';
                                                              
                                                    $('#showdatadis').html(html);
                                                          }

                                           

                                           
                                            },
                                            error: function(){
                                                alert('Could not get data');
                                            }
                                    });


                                
                                }
                                              
                     
                    });

            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/code_of_discipline/view_disobedience/"+company+"/"+location+"/"+cod_id,true);
        xmlhttp.send();
    }

function kapag_others(val){
  alert(val);
  var data = val;
  if(data == 3){
   $('#suspun').attr("readonly",true);
   $('#suspuntextadd').attr("disabled", false);
  }else{
   $('#suspun').attr("readonly",false);
   $('#suspuntextadd').attr("disabled", true);
  }

}

function kapag_othersedit(val){
  alert(val);
  var data = val;
  if(data == 3){
   $('#suspunedit').attr("readonly",true);
   $('#suspuntextedit').attr("disabled", false);
  }else{
   $('#suspunedit').attr("readonly",false);
   $('#suspuntextedit').attr("disabled", true);
  }

}

function trim(el) {
    el.value = el.value.
    replace(/(^\s*)|(\s*$)/gi, ""). // removes leading and trailing spaces
    replace(/[ ]{2,}/gi, " "). // replaces multiple spaces with one space 
    replace(/\n +/, "\n"); // Removes spaces after newlines
    return;
}  

/*function disremove(val){
 
    if(val=='' || val == 0){
      $('#btnSaveob').attr("disabled", true);
    }else{
      $('#btnSaveob').removeAttr('disabled');
    }

}*/

function disremoveedit(val){
 
    if(val=='' || val == 0){
      $('#btnSavecod').attr("disabled", true);
    }else{
      $('#btnSavecod').removeAttr('disabled');
    }

 /* */
}

function gototitle(){

   var titles = window.parent.tinymce.get('title').getContent();
  
  var descriptions = window.parent.tinymce.get('description').getContent();
    
     document.getElementById("newtitle").value = titles;
     document.getElementById("newdesc").value = descriptions;

}  

function gototitledis(){

   var titles = window.parent.tinymce.get('distitle').getContent();
  // alert(titles);
     document.getElementById("newdistitle").value = titles;
   
}  

function gototitledised(){

   var titles = window.parent.tinymce.get('distitles').getContent();
   //alert(titles);
     document.getElementById("newdistitles").value = titles;
   
}  

 function next_newa()
        {  

        var company_id = document.getElementById('company_id').value;  
        //alert(company_id);    
        var no_of_field = document.getElementById('no_of_field').value;
        //alert(no_of_field);
          if(no_of_field=='' || no_of_field == 0){
              $('#btnSaveob').attr("disabled", true);
            }else{
              $('#btnSaveob').removeAttr('disabled');
            }
      
      

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
            
                document.getElementById("dito_ka").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/code_of_discipline/next_create_new/"+no_of_field+"/"+company_id,false);
        xmlhttp.send();
        }

function next_newb()
        {          
      
        var company_id = document.getElementById('company_id').value;  
        //alert(company_id); 
        var no_of_fields = document.getElementById('no_of_fields').value;
        //alert(no_of_fields);
      

         if(no_of_field=='' || no_of_field == 0){
              $('#btnSavepunish').attr("disabled", true);
            }else{
              $('#btnSavepunish').removeAttr('disabled');
            }
      
        

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
            
                document.getElementById("dito_kana").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/code_of_discipline/next_create_newb/"+no_of_fields+"/"+company_id,false);
        xmlhttp.send();
        } 
</script>
<!-- SCRIPT -->



<!-- TIME FLEXI SCHEDULE ================================================================================================= -->
        <div class="col-md-8" id="col_2"></div>
        </div>
      </div><!-- /.box-body -->
       

<!-- Loading (remove the following to stop the loading) -->   
<div class="overlay" hidden="hidden" id="loading">
<i class="fa fa-spinner fa-spin"></i>
</div>
<!-- ./ end loading -->
             



 <?php require_once(APPPATH.'views/include/footer.php');?>
    <!-- REQUIRED JS SCRIPTS -->
   
    
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
  


<!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
   
     <script src="<?php echo base_url()?>public/app.min.js"></script> 
   
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz_niceditor/js/nicEdit.js"></script>
    <!--  <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/jquery-3.1.1.min.js"></script>  -->
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/tinymce.min.js"></script>
  <!--  <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/bootstrap.min.js"></script> -->

   <!--  <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
   
    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }


      $(function () {

        //Initialize Select2 Elements
        $(".select2").select2();

        $("#example1").DataTable();

      });


    </script>

  </body>
</html>

<style>

/*#appadd {

    white-space: nowrap;
    overflow: hidden;
    width: 180px;
    height: 30px;
    text-overflow: ellipsis; 
}*/

#buttona {
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    border: 2px solid #4CAF50;
}



#buttona:hover {

    background-color: #4CAF50; /* Green */
    color: black;
}
#alertsuccess{

   color: #31708F;
}
</style>
