

	<style type="text/css">
		.tbody {

  	background: #EEEEF0; 
}	
.tbody td{
	border:4px solid #fff;
}



	</style>





      	<div class="col-md-12" >
          	<div class="panel panel-default">
	            <div class="panel-body">
	            	
                    <div class="box-header with-border">
					    <h3 class="box-title"><strong style="color:#3c8dbc;"><?php  echo $elem; ?></strong></h3>
				    	<br><br>

		                <table id='score_criteria' class="table">
							<thead>
		                        <tr class='info'>
		                          	<th scope="col" colspan="4">Grading     <button type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>Add New</button> </th>
		                      	</tr>
		                      	<tr>
		                          	<th >Score</th>
									<th > Scoring Guide</th>
									<th >Score</th>
								</tr>
		                  	</thead>
							<tbody class="tbody">
								<?php foreach($grading as $grading):?>
								<tr id="score_criteria_data">
									<td><?=$grading->score?></td>
									<td><?=$grading->score_equivalent?></td>
									<td><?=$grading->scoring_guide?></td>

								</tr>
								<?php endforeach?>
							</tbody>
						</table>

						<div id='edit_pos_area'></div>
				
						<table id='pos_area' class="table">
							<thead>
		                      <tr class='info'>
		                          	<th scope="col" colspan="6">Criteria  <a href="#" type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal"  data-target='#mymodal4' ><i class="fa fa-plus"></i> Add Criteria</a></th>

		                      	</tr>
		                      	<tr>
		                      	<th >Area</th>
								<th > Scoring Guide</th>
								<th > level </th>
								<th> measurement </th>
								<th > target </th>
								</tr>
		                  	</thead>
		                  	<tbody class="tbody cr" >
					
							<?php foreach($res1 as $res1){?>
								<tr id='pos_area_data'>
									<td><?=$res1->area?></td>
									<td><?php $res2= $this->pms_model->get_weight_and_description_portal($res1->criteria_id);
											              foreach($res2 as $res2){?> 
											                <table class="table table-bordered"  style="table-layout:fixed;"><tbody>
											                  <tr>
											                    <td style="width: 140px" ><?php echo $res2->description; ?></td><td style="width: 30px;" > <?php echo $res2->weight; ?>%</td>

											                 
											                  </tr>
											                </tbody>
											                </table><?php } ?></td>

							<td  >  <?php if($res1->level){echo $res1->level; }?></td>
							<td  > <?php if($res1->measurement){ echo $res1->measurement; }?></td>
							<td > <?php if($res1->target){ echo $res1->target;}?></td>


								</tr>
							<?php }?>
						
							</tbody>
		                </table>
                 		
                


				        <!-- Modal -->
					

					</div>
              	</div>
	        </div>

        </div>


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>       <?php $s = $form; $form_location   = base_url()."employee_portal/pms/save_grading_table/";?>     
                                                      <form role="form"  id="form" method="post" action="javascript:void(0)"  onsubmit="save_grading_table('<?php echo $employeeid ?>','<?php echo $form?>' ,'<?php echo $this->session->userdata('company_id')?>');">
        <div class="modal-body">

                                                      	<input type="hidden" name="fid" value="<?php  echo $form;  ?>">
                                                      	 <div class="form-group">

                                                                  <label for="message-text">Score:</label>
                                                                      <?php $g =  $this->pms_model->getgradingtype($form);
                                                                      $grading_type = $g->grading_type;
                                                                  if($g->grading_type == '2'){?>
                                                                  <div class="input-group">
                                                                  <?php $name = 'score_name' ?>
                                                                  <input required="" name="<?php echo $name ?>" type="text" placeholder="ex 95% - 100%" class="form-control" id="recipient-name">
                                                                  <span class="input-group-addon">%</span>
                                                             
                                                                    </div>
                                                                       <?php }else{ ?>
                                                                      <input required="" name="score_name" type="number" class="form-control" placeholder="ex 1" id="recipient-name">
                                                         

                                                               <?php } ?>
                                                                </div><input type="hidden" name="company_" value="<?php echo $this->session->userdata('company_id');	 ?>">
                                                                 <div class="form-group">
                                                                  <label for="message-text">Ranking:</label>
                                                                  <input required name="ranking" type="number" class="form-control" id="recipient-name">
                                                                </div>
                                                                 <div class="form-group">
                                                                  <label for="message-text">Score equivalent:</label>
                                                                  <input required name="equivalent" type="text" class="form-control" id="recipient-name" placeholder="ex Outstanding
">
                                                                </div> 
                                                                <div class="form-group">
                                                                      <label for="message">Score guide</label>
                                                                  
                                                                      <textarea class="form-control" name="scoring_guide" id="scoring_guide" placeholder="ex Delivers beyond 95% - 100% of KPI.     
" required></textarea>
                                                            
                                                                  </div>
                                                               
                                                     
        </div>
        <div class="modal-footer">
        	   <input type="submit" class=" btn btn-primary" value="submit"  >
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> </form>
      </div>
      
    </div>
  </div>
   <div class="modal"  id="mymodal4" role="dialog">
    <div class="modal-dialog modal-lg">
     <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Critera Form</h4>
        <hr class="prettyline">
      </div>
              
             <?php $form_location   = base_url()."employee_portal/pms/save_criteria_form/";?>     
<form  action="javascript:void(0)" role="form"  id="criteria_form" method="post" onsubmit="save_criteria_form();"   >

    <input type="hidden" name="f" value="<?php  echo $this->uri->segment('4');  ?>">
       <div class="modal-body" id="largemodal" >
         <div class="row">
          <div class="col-sm-12">
<div style="width: 100%; height: 15px; border-bottom: 1px solid #4285f4; text-align: center">
  <span style="font-size: 15px; background-color: #fff; color:black; padding: 0 10px;">
     <i>Required Fields</i><!--Padding is optional-->
  </span>
</div>
<br>

            <!-- Tab panes -->
          
      
       <input type="hidden" name="doc_no" value="<?php echo $doc_no ?>">

                  <div class="row" >
                    
                    <div class="form-group">
                      <input type="hidden" name="idcriteria" value="<?php echo $form ?>">
                      
                      
                      <div class="col-md-6">
                        <label for="message-text">Area</label>
                        <input type="text" class="form-control" name="area_name" cid="form_title" placeholder="ex Communication


" required>
                      </div><input type="hidden" name="company_" value="<?php  echo  $this->session->userdata('company_id');	  ?>">
                      <div class="col-md-6">
                        <label for="message-text">Covered</label>
                     
                        <select  name="cover" class="form-control">
                                     <option value="all" >All</option> 
                          <?php $res = $this->pms_model->position(); foreach($res as $res){?>

                            <option value="<?php echo $res->position_name ?>"><?php  echo $res->position_name;?></option>
                            
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  
                  
                  <div class="row">
                    <div class="form-group">
                      <div class="col-md-6">
                        <label for="message-text">Description</label>
                        <textarea name="description[]" id="form_description" placeholder=" ex: Every communication is positive, clear and precise, open, honest and timely without offence


" required class="form-control"></textarea>
                      </div>
                      <div class="col-md-3">
                        <label for="message-text">weight:</label>                                      
                        <div class="input-group">

                          <input required="" name="des_weight[]" type="number" class="form-control" id="recipient-name">
                          <span class="input-group-addon">%</span></div>
                        </div>
                        <div class="col-md-3" style="margin-top:40px;">
                          <a href="#" class="addrow">Add new field</a>
                        </div>
                      </div>
                    </div>
                    <div id="app" ></div>
                    
  <br>

<div style="width: 100%; height: 15px; border-bottom: 1px solid #4285f4; text-align: center">
  <span style="font-size: 15px; background-color: #fff; color:black; padding: 0 10px;">
     <i>Optional Fields</i><!--Padding is optional-->
  </span>
</div> 
<br>
          
                    <div class="row" >
                      <div class="form-group">
                        
                       
                        <div class="col-md-6">
                          <label for="message-text">Measurement</label>
                          <input type="text" class="form-control" name="measurement"  >
                        </div>
                        <div class="col-md-6">
                          <label for="message-text">Level:</label>                                      


                          <input name="level" type="number" class="form-control" id="recipient-name">
                        </div>
                      </div>
                    </div>
                    
                    
                    <div class="row">
                      <div class="form-group">
                        <div class="col-md-6">
                          <label for="message-text">Target</label>
                          <textarea name="target" id="form_description"  class="form-control"></textarea>
                        </div>
                        
                      </div>
                    </div>
                    



        
                  <!--next vet div-->
               
                  <!-- next Shop div-->

                  <!-- next div pet trainer-->
                  
                
              </div>
            </div>       <div class="modal-footer">
              <input type="hidden" name="isEmpty" value="">
                          
            <input type="submit" class=" btn btn-primary" value="submit" >

			 <!-- onclick="save_criteria_form('#my<?php echo $form?>','<?php echo $form?>' , '<?php echo $this->session->userdata('company_id');	?>' );" -->

              <button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancel</button>
            </div>
            </form>
          </div>
       
     
      </div><!-- Modal content-->
    </div><!-- Modal dialog--> 


	<!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
	
    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

	<script type="text/javascript">

                 
  function save_criteria_form(){

       
            $.ajax({ 
              url: "<?php echo base_url('employee_portal/pms/save_criteria_form') ?>",
              type: 'POST',
         
              data: $('#criteria_form').serialize(),
              success: function(e) {
                // if(e == 'true'){
                	   location.reload();
                 $('#message').show();
                 $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
  
               
                	 // $('.cr').append('<tr><td>'+e.area+'</td><td>'+e.area+'</td><td>'+e.area+'</td></tr>');




              //  }else{
              //   $('#message').show();
              //   $('#message').html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+e+"</div>").fadeOut(10000);
              //   $(modal_id).modal('hide');
              //   manage_criteria(fid,company);
              // }                
            }
          });
         


        }


       
                       
       function save_grading_table(employeeid,fid){
          
          
           
        
             
             $.ajax({ 
              url: "<?php echo base_url('employee_portal/pms/save_grading_table') ?>",
              type: 'POST',
     		  dataType:'json',
              data: $('#form').serialize()+ "&employeeid=" + employeeid,
              success: function(e) {
                // if(e == "true"){
                   $('#message').show();
                   $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully</div>").fadeOut(10000);
                   $('#myModal').modal('hide');
                   	document.getElementById("form").reset();
 	
                     
      				 $('#score_criteria').append('<tr><td>'+e.score+'</td><td>'+e.score_equivalent+'</td><td>'+e.scoring_guide+'</td></tr>');

              //  }else{
                
              //   $('#message').show();
              //   $('#message').html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+e+"</div>").fadeOut(10000);
              //   $('#myModal').modal('hide');
              //   manage_criteria(fid,company);   

              // }
              
            }
          });

           
        }

       $('.addrow').click(function(e){
     $(".modal-body #app").append('<div class="row"><div class="form-group"><div class="col-md-6"><label for="message-text">Description</label><textarea name="description[]" id="form_description" required class="form-control"></textarea></div><div class="col-md-3"><label for="message-text">weight:</label><div class="input-group"> <input required="" name="des_weight[]" type="number" class="form-control" id="recipient-name"><span class="input-group-addon">%</span></div></div><div class="col-md-3" style="margin-top:40px;"><a href="#" class="removed">Remove  </a></div></div></div></div>')});
              $(document).on('click','.removed',function(e){


                            $(this).parent().parent().remove();
                          });

	</script>
