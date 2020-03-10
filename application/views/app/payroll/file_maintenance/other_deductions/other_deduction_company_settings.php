
<div class="col-md-4" id="printProfile" >

<div class="row table-responsive">
<div class="col-md-12">

<div class="box box-success ">
<div class="panel panel-success" >
  <div class="panel-heading table-responsive " >
        <strong>
        
            </strong><strong>OTHER DEDUCTIONS</strong>

      

     
    
       </div>

  <div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">




      
         	<div class="col-md-12">
			<div class="form-group">
			<label for="company">Select a Company</label>
			 <div class="btn-group-vertical btn-block">
              <?php 
              //$cl->classification_id.
                  foreach($companyList as $loc){
                      echo "<a onclick='other_deduction_select_option(".$loc->company_id.")' type='button' onchange='getSSTableSearch(this.value); applyFilter();' class='btn btn-default btn-flat'><p class='text-left'><strong>".$loc->company_code."</strong></p></a>";
                  }
              ?>
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

