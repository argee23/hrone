<div class="col-md-12">
    <?php echo $message;?>
    <p id="message"></p>
    <?php echo validation_errors(); ?>
  </div>



       <div class="col-md-12" >
        <!-- <div class="box box-success">
                <div class="col-md-12" id="fetch_all_result"><br>
                  <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>General Instruction</h4></ol>
                     <div class="col-md-110 well">
             <?php foreach($general_instruction as $res){?>
          <h3 class="page-header text-center"><?php  echo $res->company_name; ?><br /></h3><br>


          <textarea  id="instruction_area" rows="13"  data-type="wysihtml5" data-pk="<?php echo $res->id ;?>" data-name="instruction"  data-url="<?php echo base_url();?>app/pms/general_instruction_update" ><?php echo $res->instruction; ?></textarea>
            <hr>  
          <?php }?>
            <div class="text-center">
                <a class="btn btn-success" id="update" ><i class="glyphicon glyphicon-eye-open"></i> Update </a>
            </div>
          </div> 
        </div>
                <div class="btn-group-vertical btn-block"> </div>   
        </div> -->

        <div class="box box-success">
        	<div class="box-header bg-success">
        		<h4 class="box-title">General Instructions</h4>
        	</div>
        	<div class="box-body">
        		
    			<h3 class="text-center"><?php  echo $res->company_name; ?></h3>

				<div class="well">
					<textarea  id="instruction_area" rows="13"  data-type="wysihtml5" data-pk="<?php echo $res->id ;?>" data-name="instruction"  data-url="<?php echo base_url();?>app/pms/general_instruction_update" ><?php echo $res->instruction; ?></textarea>
				</div>
        		
        		<!-- end $general_instruction -->
        		<div class="text-center">
        			<a class="btn btn-success" id="update" ><i class="glyphicon glyphicon-eye-open"></i> Update </a>
        		</div>
        	</div>
        </div>
     </div> 

