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
<body>

<div class="col-md-12" id="printProfile" >

<div class="row table-responsive">
<div class="col-md-12">

<div class="box box-success ">
<div class="panel panel-success" >
  <div class="panel-heading table-responsive " >
        <strong>
       
        <?php 

           $company_id  = $this->uri->segment('4');
           $location_id = $this->uri->segment('5');
           $current_comp=$this->code_of_discipline_model->get_company($company_id);
           if(!empty($current_comp)){
              echo $company_name = $current_comp->company_name;
           }else{
              echo $company_name="classification not exist";
           }
        
         ?>
         <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>">
         <input type="hidden" name="location_id" id="location_id" value="<?php echo $location_id; ?>">



      </strong><strong>(CODE OF DISCIPLINE)<i class="fa fa-arrow-circle-left fa-2x text-danger pull-right" data-toggle='tooltip' data-placement='left' title='back' onclick="view_company_location('<?php echo $company_id; ?>')"></i>

       <a  id="btnAddcod" type="button" class="btn btn-default btn-xs pull-right" data-toggle="tooltip" data-placement="left" data- title="Add new Disobedience">
          <?php
          echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i> Add Code of Discipline';
          ?>
        </a>
          <a  id="btnView" type="button" class="btn btn-default btn-xs pull-right" data-toggle="tooltip" data-placement="left" data- title="View All Code of Discipline" onclick="view_page();">
          <?php
          echo '<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';" "></i>View All';
          ?>
        </a>
     
      </strong>

      

    
    
       </div>
 <div id="same_page">
  <div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">


      
          <div class="col-md-12" >
              <div class="form-group">
                  <div class="btn-group-vertical btn-block">
                      
                              <div class="panel panel">
                              <div class="panel-heading"><center><b><h2>COMPANY CODE OF DISCIPLINE</h2></b></center></div>
                                 <div class="alert" id="alertsuccess" style="color:black; display: none;"></div>
                                 <div class="container-fluid">
                                  <table  id="showdata" class="table table-bordered table-responsive">
                                   <!--      <thead style="display: none;">
                                        <tr style="display: none;">
                                              <th style="visibility: hidden;display: none;">numbering</th>
                                              <th style="visibility: hidden;display: none;">title</th>
                                               <th style="visibility: hidden;display: none;"></th>

                                        </tr>
                                        </thead>
                                          <tbody>
                                        <?php foreach ($result as $sac) { ?>
                                          <tr>
                                                                        <td style="text-align:left;"><?php echo $sac->numbering; ?></td>
                                                                        <td style="text-align:left;"><?php echo $sac->title; ?>
                                                                          
                                                                            <span colspan="2" class="col-xs-10" style="text-overflow: ellipsis;  white-space: nowrap; width: 655px; overflow: hidden; display: inline-block;"><?php echo $sac->description; ?>...<a onclick="view_disob(<?php echo $sac->cod_id; ?>);" data-toggle="tooltip" title="CLick to View this <?php echo $sac->numbering; ?> Code of Discipline"><strong>see more</strong></a>
                                                                        <span>
                                                                        </td>
                                                                      
                                                                         <td>   
                                                                            <a style="margin-left:2px; margin-top:2px;" href="javascript:;" class="item-delete pull-right" data="'+data[i].cod_id+'" data-toggle="tooltip" title="Delete <?php echo $sac->numbering; ?> Code of Discipline"><?php echo '<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';" "></i>';?></a>

                                                                             <a style="margin-left:2px; margin-top:2px;" href="javascript:;" class="item-edit pull-right" onclick="disremoveedit(<?php echo $sac->cod_id; ?>);" data="<?php echo $sac->cod_id; ?>" data-toggle="tooltip" title="Edit <?php echo $sac->numbering; ?> Code of Discipline"><?php echo '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" "></i>';?></a>
                                                                       </td>
                                                                     </tr>
                                                                 
                                       
                                                                       <?php }?>
                                                 </tbody> -->
                                      </table>
                                    </div>
<!-- ADD EDIT COD MODAL -->
                     <div id="myModal" class="modal modal-primary fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                                   <div class="modal-header">
                                        <button type="button" class="close" aria-label="Close" id="closecodq" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                        <span><h4 class="modal-title"></h4>
                                      </div>
                                      <div class="modal-body" >
                                          <form id="myForm" class="form-horizontal" method="post"  action="" style="color:black;">
                                            <input  type="hidden" class="form-control" name="company_id" id="company_id" value="<?php echo $company_id; ?>">  
                                            <input type="hidden" class="form-control" name="location_id" id="location_id" value="<?php echo $location_id; ?>"> 
                                             <input type="hidden" class="form-control" name="cod_id" id="cod_id" value="0"> 
                                             <input type="hidden" class="form-control" name="codnumberings" id="codnumberings"> 
                                            <br></br>  
                                          <div id="sample">
                                                  <div class="form-group"  >
                                                  <label for="Numbering" class="col-sm-3 control-label">Numbering</label>
                                                    <div class="col-sm-7" >
                                                   
                                                      <select  class="form-control" name="codnumbering"  id="codnumbering"  required>
                                                          <option selected="selected" value=""  required>~ Select ~</option>
                                                          <?php 
                                                          foreach($numberinglist as $num){

                                                               echo "<option value='".$num->num_id."' >".$num->numbering."</option>";
                                                         
                                                          }
                                                         
                                                          ?>
                                                       </select>
                                                    
                                                    </div>
                                                  </div> 
                                                   <div class="form-group"  >
                                                      <label for="forTitle" class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-7" >
                                                        
                                                          <span id="num_availability"></span>
                                                        
                                                        </div>
                                                    </div>  
                                                

                                                    <div class="form-group"  >
                                                      <label for="forTitle" class="col-sm-3 control-label">Title</label>
                                                        <div class="col-sm-7" >
                                                   
                                                          <textarea class="tinymce form-control" name="title" id="title" style="width:500px; height:100%; background: white;
                                                       color:black;" required></textarea>
                                                        </div>
                                                    </div>  

                                                    <div class="form-group"  id="location_hide">
                                                      <label for="forTitle" class="col-sm-3 control-label">Location</label>
                                                        <div class="col-sm-7" >
                                                            <?php
                                                                $comp_loc=$this->general_model->get_company_locations($company_id);
                                                                     if(!empty($comp_loc)){
                                                                          foreach($comp_loc as $loc){
                                                                             echo '<input type="checkbox" value="'.$loc->location_id.'" checked id="location" name="location[]">'.$loc->location_name.'<br>';  
                                                                              }
                                                                     }else{
                                                                            echo 'warning: no location setup yet.';     

                                                                       }
                                                            ?>
                                                        </div>
                                                    </div>  
                                                
                                                <div  class="form-group"  >
                                                   <label for="forDescription" class="col-sm-3 control-label">Description:</label>
                                                  <div class="col-sm-7" >
                                                        <textarea class="tinymce form-control" name="description" id="description" style="width:500px; height: 100px; background: white;
                                                       color:black;" required></textarea><br />
                                                   </div>
                                                </div>  

                                                  <input type="hidden" name="newtitle" id="newtitle" class="col-sm-7">
                                                  <br></br>
                                                  <input type="hidden" name="newdesc" id="newdesc" class="col-sm-7">
                                            </div>

                                        
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" id="closecod" data-dismiss="modal">Close</button>
                                        <button type="button" id="btnSavecod" name="submit" onclick="gototitle();"  class="btn btn-default" style="color:black;" data-dismiss="modal" disabled> &nbsp;Save&nbsp; </button>
                                      </div>
                                      </form>


                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->


<!-- DELETE MODAL -->

              
                     <div id="deleteModal" class="modal modal-danger fade" tabindex="-1" role="dialog" >
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                   <div class="modal-header">
                                        <button type="button" class="close" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                        <span><h4 class="modal-title"> Confirm Delete</h4>
                                      </div>
                                      <div class="modal-body" >
                                          Do you want to delete this Record?
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" id="btnDelete" name="submit" class="btn btn-danger" data-dismiss="modal" style="color:black;"> Delete </button>
                                      </div>
                                      </form>
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->





                           </div>  
                      </div>             
                  
                 </div>


              </div>
          </div>

  
     </div> 
  </div><!-- /.box-body --> 

</div>

</div>
</div>

</div>
</div>

</div>
</div>
<div class="col-md-4"  id="col_3">
    
  </div>


 
    </div><!-- same_page closing -->  

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

        $("#example1").DataTable();

      });

        tinymce.init({
                                selector: 'textarea',
                                                      height: 100,
                                                      theme: 'modern',
                                                      removed_menuitems: 'newdocument documentproperties',
                                                      menubar:false,
                                                      plugins: 'emoticons print preview fullpage searchreplace autolink directionality link charmap hr advlist lists textcolor wordcount link contextmenu colorpicker textpattern help',
                                                      toolbar1: 'formatselect | fontsizeselect | fontselect | bold italic strikethrough superscript subscript undo redo cut copy paste selectall find and replace hr forecolor backcolor | link | charmap | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat preview emoticons',
                                                      font_formats: 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats',
                                                       fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                                                      image_advtab: true,
                                                     
                                                     });                      

    </script>

  </body>
</html>
 


    <style>
    .nicEdit-main {
      background-color: white;
      margin: 0 !important;
      padding: 4px;
      color:black;
      }

  .modal-header .close {
    float: right !important;
    margin-right: -30px !important;
    margin-top: -30px !important;
    background-color: white !important;
    border-radius: 15px !important;
    width: 30px !important;
    height: 30px !important;
    opacity: 1 !important;
}

</style>