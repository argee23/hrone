
<div class="col-md-4" id="printProfile" >

<div class="row table-responsive">
<div class="col-md-12">

<div class="box box-success ">
<div class="panel panel-success" >
  <div class="panel-heading table-responsive " >
        <strong>
       
        <?php 

           $company_id = $this->uri->segment('4');
           $current_comp=$this->code_of_discipline_model->get_company($company_id);
           if(!empty($current_comp)){
              echo $company_name = $current_comp->company_name;
           }else{
              echo $company_name="classification not exist";
           }
        
         ?>
      </strong><strong>(CODE OF DISCIPLINE)</strong>

      

     <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>">
    
       </div>

  <div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body">
         <div class="row">





      
          <div class="col-md-12" >
              <div class="form-group">
                  <div class="btn-group-vertical btn-block">
                      
                              <div class="panel panel">
                              <div class="panel-heading"><strong class="pull-left">Select a Location</strong></div>
                              <div class="btn-group-vertical btn-block">

                                  <?php foreach($locationlist as $loc){?>
                                  <p class='form-control btn btn-block' style="padding:20px; font-size:18px;"><strong class="pull-left"><?php echo $loc->location_name; ?></strong><a onclick="view_comploc_discipline('<?php echo $loc->location_id; ?>')"><strong class='pull-right' data-toggle="tooltip" title="click to view">view</strong></a></h4> 
                                  <?php } ?>
                              
                              </div>  
                          <!--     <br></br>
                              <div class="container"><a class="btn btn-primary" onclick="gotochart()"> TRy CHART</a></div> -->
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
