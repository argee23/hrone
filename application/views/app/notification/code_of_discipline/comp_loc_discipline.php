<div class="col-md-12" id="printProfile" >

<div class="row table-responsive">
<div class="col-md-12">

<div class="box box-success ">
<div class="panel panel-success" >
  <div class="panel-heading table-responsive " >
        <strong>
       
        <?php 

           $company_id  = $this->uri->segment('4');
          // $location_id = $this->uri->segment('5');
           $current_comp=$this->code_of_discipline_model->get_company($company_id);
           if(!empty($current_comp)){
              echo $company_name = $current_comp->company_name;
           }else{
              echo $company_name="classification not exist";
           }
        
         ?>
         <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>">
       <!--   <input type="hidden" name="location_id" id="location_id" value="<?php echo $location_id; ?>">
 -->


      </strong><strong>(CODE OF DISCIPLINE)

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

                                  <div id="showdata">
                                               
                                
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
                                         <!--    <input type="hidden" class="form-control" name="location_id" id="location_id" value="<?php echo $location_id; ?>">  -->
                                             <input type="hidden" class="form-control" name="cod_id" id="cod_id" value="0"> 
                                             <input type="hidden" class="form-control" name="codnumberings" id="codnumberings"> 
                                            <br></br>  
                                          <div id="sample">
                                                  <div class="form-group"  >
                                                  <label for="Numbering" class="col-sm-3 control-label">Numbering</label>
                                                    <div class="col-sm-7" >
                                                   
                                                      <select  class="form-control" name="codnumbering"  id="codnumbering" required>
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

                                                <!--     <div class="form-group"  id="location_hide">
                                                      <label for="forTitle" class="col-sm-3 control-label">Location</label>
                                                        <div class="col-sm-7" >
                                                            <?php
                                                                $comp_loc=$this->code_of_discipline_model->get_company_locations($company_id);

                                                                     if(!empty($comp_loc)){
                                                                          foreach($comp_loc as $loc){
                                                                             echo '<input type="checkbox" value="'.$loc->location_id.'" checked id="location" name="location[]">'.$loc->location_name.'<br>';  
                                                                              }
                                                                     }else{
                                                                            echo 'warning: no location setup yet.';     

                                                                       }
                                                            ?>
                                                        </div>
                                                    </div>   -->
                                                
                                                <div  class="form-group"  >
                                                   <label for="forDescription" class="col-sm-3 control-label">Description:</label>
                                                  <div class="col-sm-7" >
                                                        <textarea class="tinymce form-control" name="description" id="description" style="width:500px; height: 100px; background: white;
                                                       color:black;" required></textarea><br />
                                                   </div>
                                                </div>  

                                                  <input type="hidden" name="newtitle" id="newtitle" class="col-sm-7">
                                                   <input type="hidden" name="newdesc" id="newdesc" class="col-sm-7">
                                                  <br></br>
                                                 
                                                   <input type="hidden" name="check_title" id="check_title" class="col-sm-7">
                                                   <input type="hidden" name="check_desc" id="check_desc" class="col-sm-7">
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

              
                     <div id="deleteModal" class="modal modal-default fade" tabindex="-1" role="dialog" >
                      <div class="modal-dialog" role="document" style="width:450px;">
                        <div class="modal-content">
                                   <div class="modal-header">
                                       
                                        <span><h4 class="modal-title"></h4>
                                      </div>
                                      <div class="modal-body" >
                                          Do you want to delete this Record?
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button type="button" id="btnDelete" name="submit" class="btn btn-default" data-dismiss="modal" style="color:black;"> Ok </button>
                                      </div>
                                      </form>
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->




<!-- DISABLE MODAL -->

              
                     <div id="disableModal" class="modal modal-default fade" tabindex="-1" role="dialog" >
                      <div class="modal-dialog" role="document" style="width:450px;">
                        <div class="modal-content">
                                   <div class="modal-header">
                                       
                                        <span><h4 class="modal-title"></h4>
                                      </div>
                                      <div class="modal-body" >
                                          Do you want to disable this Record?
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button type="button" id="btnDisable" name="submit" class="btn btn-default" data-dismiss="modal" style="color:black;"> Ok </button>
                                      </div>
                                      </form>
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->




<!-- ENABLE MODAL -->

              
                     <div id="enableModal" class="modal modal-default fade" tabindex="-1" role="dialog" >
                      <div class="modal-dialog" role="document" style="width:450px;">
                        <div class="modal-content">
                                   <div class="modal-header">
                                       
                                        <span><h4 class="modal-title"></h4>
                                      </div>
                                      <div class="modal-body" >
                                          Do you want to enable this Record?
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button type="button" id="btnEnable" name="submit" class="btn btn-default" data-dismiss="modal" style="color:black;"> Ok </button>
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

 <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <!-- DataTables -->
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

