
<div class="col-md-12" id="printProfile" >

<div class="row table-responsive">
<div class="col-md-12">

<div class="box box-success ">
<div class="panel panel-success" >
  <div class="panel-heading table-responsive " >
        <strong>
       
        <?php 

           $company_id  = $this->uri->segment('4');
           //$location_id = $this->uri->segment('5');
           $current_comp=$this->code_of_discipline_model->get_company($company_id);
           if(!empty($current_comp)){
              echo $company_name = $current_comp->company_name;
           }else{
              echo $company_name="classification not exist";
           }
        
         ?>
         <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>">
        <!--  <input type="hidden" name="location_id" id="location_id" value="<?php echo $location_id; ?>">
 -->


      </strong><strong>(CODE OF DISCIPLINE)<i class="fa fa-arrow-circle-left fa-2x text-danger pull-right" data-toggle='tooltip' data-placement='left' title='back' onclick="view_comploc_discipline('<?php echo $company_id; ?>')"></i>
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
                            
                                 <div class="alert" id="alertsuccessa" style="display: none;"></div>

                             
                                          <div class="form-group" id="showdata"> 
                            
                               
                                          </div>

                                               <div class="form-group" > 
                                                    <table class="table table-bordered" style="margin-top:20px;">
                                                                  <thead>
                                                                      <tr>
                                                                          <th style="text-align:left;">ID</th>    
                                                                          <th style="text-align:left;">Disobedience Title</th>            
                                                                          <th style="text-align:center;">Action</th>    
                                                                      </tr>
                                                                  </thead>
                                                                  <tbody id="showdatadis">

                                                                    

                                                                  </tbody>
                                                    </table>
                                                    </div>

                                                  

<!-- ADD Disobedience -->

              
                     <div id="disobedienceModal" class="modal modal-primary fade" tabindex="-1" role="dialog" >
                     <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                                   <div class="modal-header">
                                        <button type="button" class="close" style="background-color: red;" aria-label="Close" id="closemopa" data-dismiss="modal"><span aria-hidden="false">&times;</span></button>
                                        <span><h4 class="modal-title"></h4>
                                      </div>
                                      <div class="modal-body" >
                                          <form id="myFormdisob" class="form-horizontal" method="post"  action="" style="color:black;">
                                            <input  type="hidden" class="form-control" name="company_id" id="company_id" value="<?php echo $company_id; ?>">  
                                           <!--  <input type="hidden" class="form-control" name="location_id" id="location_id" value="<?php echo $location_id; ?>">  -->
                                             <input type="hidden" class="form-control" name="cod_id" id="cod_id" value="0"> 


                                               <div class="form-group"  >
                                                      <label for="forTitle" class="col-sm-3 control-label">Disobedience Title</label>
                                                        <div class="col-sm-7" >
                                                        
                                                          <textarea class="tinymce form-control" name="distitle" id="distitle" style="width:500px; height:100%; background: white;
                                                       color:black;" required ></textarea>
                                                        </div>
                                                    </div>  

                                               <input type="hidden" class="form-control" name="newdistitle"  id="newdistitle" class="col-sm-7">
                                               <input type="hidden" class="form-control" name="newdischktitle"  id="newdischktitle" class="col-sm-7">

                                           

                                            <div class="form-group">
                                             <label for="no_of_fields" class="col-sm-3 control-label">No of fields</label>
                                                  <div class="col-sm-7" >
                                                    <select name="no_of_field" id="no_of_field" class="form-control" required >
                                                    <option value="0" selected="" required>Select</option>
                                                    <?php
                                                    for($nemz_no =1;$nemz_no<=10;$nemz_no++){
                                                    echo "<option value='".$nemz_no."'>". $nemz_no."</option>";
                                                    }
                                                    ?>
                                                    </select> 
                                                  </div>
                                              </div>
                                              <div class="form-group">
                                                <label for="next" class="col-sm-3 control-label">&nbsp;</label>
                                                  <div class="col-sm-7" >

                                                  <a onclick="next_newa();"  type="button"  class="btn btn-danger btn-md pull-left"><i class="fa fa-arrow-down"></i> Next</a>
                                                  </div>
                                              </div>

                                             

                                              <div class="ditoka form-group" id="dito_ka">
                                                


                                              </div>
                                                    <div class="modal-footer">
                                                    <button type="button"  class="btn btn-danger fordiv" id="closemo" data-dismiss="modal">Close</button>
                                                    <button type="button" id="btnSaveob" name="submit" onclick="gototitledis();" class="btn btn-default" style="color:black;" data-dismiss="modal" disabled> &nbsp;Save&nbsp; </button>
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

<!-- EDIT Disobedience -->
  
                   <div id="editdisobModal" class="modal modal-primary fade" tabindex="-1" role="dialog" >
                     <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                                   <div class="modal-header">
                                        <button type="button" class="close" style="background-color: red;" aria-label="Close" id="closemopa" data-dismiss="modal"><span aria-hidden="false">&times;</span></button>
                                        <span><h4 class="modal-title"></h4>
                                      </div>
                                      <div class="modal-body" >
                                          <form id="myFormeditdisob" class="form-horizontal" method="post"  action="" style="color:black;">
                                            <input  type="hidden" class="form-control" name="company_id" id="company_id" value="<?php echo $company_id; ?>">  
                                           <!--  <input type="hidden" class="form-control" name="location_id" id="location_id" value="<?php echo $location_id; ?>"> -->
                                            <input type="hidden" class="form-control" name="cod_id" id="cod_id" value="0"> 
                                            <input type="hidden" class="form-control" name="cod_disob_id" id="cod_disob_id" value="0"> 
                                          
                                               <div class="form-group"  >
                                                      <label for="forTitle" class="col-sm-3 control-label">Disobedience Title</label>
                                                        <div class="col-sm-7" >
                                                        
                                                          <textarea class="tinymce form-control" name="distitles" id="distitles" style="width:500px; height:100%; background: white;
                                                       color:black;" required ></textarea>
                                                        </div>
                                                    </div>  

                                               <input type="hidden" class="form-control" name="newdistitles"  id="newdistitles" class="col-sm-7">
                                                <input type="hidden" class="form-control" name="newdischktitles"  id="newdischktitles" class="col-sm-7">

                                      
                                                


                                              </div>
                                                    <div class="modal-footer">
                                                    <button type="button"  class="btn btn-danger fordiv" id="closemo" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="gototitledised();" id="btnSaveobedit" name="submit"  class="btn btn-default" style="color:black;" data-dismiss="modal"> &nbsp;Save&nbsp; </button>
                                                  </div>
                                              
                                         
                                          </form>
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->     
              
                   






<!-- DELETE MODAL -->

              
                     <div id="deletedisModal" class="modal modal-default fade" tabindex="-1" role="dialog" >
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
                                        <button type="button" id="btnDeletedis" name="submit" class="btn btn-default" data-dismiss="modal" style="color:black;"> Ok </button>
                                      </div>
                                      </form>
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->




<!--ADD PUNISHMENT -->

       <div id="punishModal" class="modal modal-primary fade" tabindex="-1" role="dialog" >
                     <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                                   <div class="modal-header">
                                        <button type="button" class="close" style="background-color: red;" aria-label="Close" id="closemopanga" data-dismiss="modal"><span aria-hidden="false">&times;</span></button>
                                        <span><h4 class="modal-title"></h4>
                                      </div>
                                      <div class="modal-body" >
                                          <form id="myFormpunish" class="form-horizontal" method="post"  action="" style="color:black;">
                                            <input  type="hidden" class="form-control" name="company_id" id="company_id" value="<?php echo $company_id; ?>">  
                                           <!--  <input type="hidden" class="form-control" name="location_id" id="location_id" value="<?php echo $location_id; ?>"> -->
                                             <input type="hidden" class="form-control" name="cod_id" id="cod_id" value="0"> 
                                             <input type="hidden" class="form-control" name="cod_disob_id" id="cod_disob_id" value="0"> 

                                              <div class="form-group">
                                                  <label for="for-disobedience" id="fordisobedience" class="col-sm-3 control-label">Disobedience</label>
                                                      <div class="col-sm-7">
                                                                <input type="text" class="form-control" name="disobedience" id="disobedience"  onchange="return trim(this)" placeholder="Disobedience" value="" required>
                                                          <span id="disob_availability"></span>
                                                        
                                                        </div>
                                                    </div>  

                                              <div class="form-group">
                                                  <label for="for-numday" id="fornumdays" class="col-sm-3 control-label">No. of Days</label>
                                                      <div class="col-sm-7">
                                                            
                                                                 <select name="numdays" id="numdays" class="form-control" placeholder="No. of Days"  required="">
                                                                    <option value="0" selected="">Select</option>
                                                                    <?php
                                                                    for($nemz_no =0;$nemz_no<=31;$nemz_no++){
                                                                    echo "<option value='".$nemz_no."'>". $nemz_no."</option>";
                                                                    }
                                                                    ?>
                                                                 </select> 
                                                            
                                                      </div>
                                              </div>

                                              <div class="form-group">
                                                  <label for="for-numdis" id="fornumdis"  class="col-sm-3 control-label">No. of Disobedience</label>
                                                      <div class="col-sm-7">
                                                              
                                                                 <select name="numdis" id="numdis" class="form-control" placeholder="No. of Disobedience"  required="">
                                                                    <option value="0" selected="">Select</option>
                                                                    <?php
                                                                    for($nemz_no =1;$nemz_no<=31;$nemz_no++){
                                                                    echo "<option value='".$nemz_no."'>". $nemz_no."</option>";
                                                                    }
                                                                    ?>
                                                                 </select> 
                                                          <span id="numdis_availability"></span>
                                                        
                                                        </div>
                                                    </div>  

                                              <div class="form-group">
                                                  <label for="for-suspun" id="forsuspun"  class="col-sm-3 control-label">Suspension/Punishment</label>
                                                      <div class="col-sm-7">
                                                              <select name="suspun" id="suspun" class="form-control" placeholder="No. of Disobedience" onchange="kapag_others(this.value);"  required="required">
                                                                <option value="1" selected="">Suspension/supensyon</option>
                                                                <option value="2" selected="">Dismissal/Pagkakatanggal</option>
                                                                <option value="3" selected="">Others</option>
                                                                 <option selected="selected" value="" disabled>Select Option</option>                                          
                                                              </select> 
                                                               <label>for others:</label>
                                                                <textarea class="form-control" name="suspun" id="suspuntextadd"  onchange="return trim(this)" placeholder="Suspension/Punishment" required="required" disabled></textarea>

                                                              
                                                      </div>
                                              </div>

                                      
                                        
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button"  class="btn btn-danger" id="closemonga" data-dismiss="modal">Close</button>
                                        <button type="button" id="btnSavepunish" name="submit" class="btn btn-default" style="color:black;" data-dismiss="modal" disabled> &nbsp;Save&nbsp; </button>
                                      </div>
                                      </form>
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->


<!--EDIT PUNISHMENT -->

       <div id="punisheditModal" class="modal modal-primary fade" tabindex="-1" role="dialog" >
                     <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                                   <div class="modal-header">
                                        <button type="button" class="close" style="background-color: red;" aria-label="Close" id="closemopanga" data-dismiss="modal"><span aria-hidden="false">&times;</span></button>
                                        <span><h4 class="modal-title"></h4>
                                      </div>
                                      <div class="modal-body" >
                                          <form id="myFormpunishedit" class="form-horizontal" method="post"  action="" style="color:black;">
                                            <input  type="hidden" class="form-control" name="company_id" id="company_id" value="<?php echo $company_id; ?>">  
                                           <!--  <input type="hidden" class="form-control" name="location_id" id="location_id" value="<?php echo $location_id; ?>"> -->
                                             <input type="hidden" class="form-control" name="cod_id" id="cod_id" value="0"> 
                                             <input type="hidden" class="form-control" name="cod_disob_id" id="cod_disob_id" value="0"> 
                                              <input type="hidden" class="form-control" name="pun_id" id="pun_id" value="0"> 

                                              <div class="form-group">
                                                  <label for="for-disobedience" id="fordisobedience" class="col-sm-3 control-label">Disobedience</label>
                                                      <div class="col-sm-7">
                                                                <input type="text" class="form-control" name="disobedience" id="disobedience"  onchange="return trim(this)" placeholder="Disobedience" value="" required>   
                                                      </div>
                                              </div>


                                              <div class="form-group">
                                                  <label for="for-numday" id="fornumdays" class="col-sm-3 control-label">No. of Days</label>
                                                      <div class="col-sm-7">
                                                            
                                                                 <select name="numdays" id="numdays" class="form-control" placeholder="No. of Days"  required="">
                                                                    <?php
                                                                    for($nemz_no =0;$nemz_no<=31;$nemz_no++){
                                                                    echo "<option value='".$nemz_no."'>". $nemz_no."</option>";
                                                                    }
                                                                    ?>
                                                                 </select> 
                                                            
                                                      </div>
                                              </div>

                                              <div class="form-group">
                                                  <label for="for-numdis" id="fornumdis"  class="col-sm-3 control-label">No. of Disobedience</label>
                                                      <div class="col-sm-7">
                                                                 <input type="text" class="form-control"  name="numdis" id="numdis" onchange="return trim(this)"  placeholder="No. of Disobedience" value="" readonly>
                                                                
                                                                 </select> 
                                                        
                                                      </div>
                                              </div>

                                              <div class="form-group">
                                                  <label for="for-suspun" id="forsuspun"  class="col-sm-3 control-label">Suspension/Punishment</label>
                                                      <div class="col-sm-7">
                                                                <select name="suspun" id="suspunedit" class="form-control" placeholder="No. of Disobedience" onchange="kapag_othersedit(this.value);"  required="required">
                                                                <option value="1" selected="">Suspension/supensyon</option>
                                                                <option value="2" selected="">Dismissal/Pagkakatanggal</option>
                                                                <option value="3" selected="">Others</option>
                                                                 <option selected="selected" value="" disabled>Select Option</option>                                          
                                                              </select> 
                                                               <label>for others:</label>
                                                                <textarea class="form-control" name="suspun" id="suspuntextedit"  onchange="return trim(this)" placeholder="Suspension/Punishment" required="required" disabled></textarea>
                                                        
                                                      </div>
                                              </div>
                                               
                                            
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button"  class="btn btn-danger" id="closemonga" data-dismiss="modal">Close</button>
                                        <button type="button" id="btnSavepunishedit" name="submit" class="btn btn-default" style="color:black;" data-dismiss="modal"> &nbsp;Save&nbsp; </button>
                                      </div>
                                      </form>
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

    <!-- DELETE PUNISHMENT-->

              
                     <div id="deletedispunModal" class="modal modal-default fade" tabindex="-1" role="dialog" >
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
                                        <button type="button" id="btnDeletedispun" name="submit" class="btn btn-default" data-dismiss="modal" style="color:black;"> Ok </button>
                                      </div>
                                      </form>
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

    <!-- DELETE PUNISHMENT-->

              
                     <div id="viewdispunModal" class="modal modal-default fade" tabindex="-1" role="dialog" >
                      <div class="modal-dialog  modal-lg" role="document">
                        <div class="modal-content">
                                   <div class="modal-header">
                                        <button type="button" class="close" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                        <span><h4 class="modal-title"></h4>
                                      </div>
                                      <div class="modal-body" >
                                                    <table class="table table-bordered table-responsive" border="2" style="margin-top:20px;">
                                                                  <thead>
                                                                      <tr>
                                                                          <th style="text-align:center;">ID</th>
                                                                          <th style="text-align:center;">DISOBEDIENCE</th> 
                                                                          <th style="text-align:center;">NO. OF DAYS</th>
                                                                          <th style="text-align:center;">NO. OF DISOBEDIENCE</th> 
                                                                          <th style="text-align:center;">SUSPENSION/PUNISHMENT</th>
                                                                          <th style="text-align:center;">ACTION</th>   
                                                                      </tr>
                                                                  </thead>
                                                                  <tbody id="show_punishment">

                                                                    

                                                                  </tbody>
                                                  </table>
                                          
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" id="btnDeletedispun" name="submit" class="btn btn-danger" data-dismiss="modal" style="color:black;"> Delete </button>
                                      </div>
                                      </form>
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->


<div class="col-md-4"  id="col_3">
    
  </div>


 
    </div><!-- same_page closing -->  

 <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
   
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz_niceditor/js/nicEdit.js"></script>
    <!--  <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/jquery-3.1.1.min.js"></script>  -->
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/tinymce.min.js"></script>
   

    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
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

