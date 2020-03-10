
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!DOCTYPE html>
<html>
  <head>

	<style type="text/css">
		.tbody {

  	background: #EEEEF0; 
}
.tbody td{
	border:4px solid #fff;
}
	</style>

   </head>

<body>

<!--  <input href="#myModal" data-toggle="modal" class="btn btn-danger btn-sm" type="button" value="Add Areas">
 <button id='update_form' class="btn btn-danger btn-block pull-right">Ready for Evaluation</button> -->

      	<div class="col-md-12" >
          	<div class="panel panel-default" style="border: 1px solid #00a65a;border-top: 7px solid #00a65a;">
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
		                          	<th scope="col">Score</th>
									<th scope="col" colspan="2"> Scoring Guide</th>  
								</tr>
		                  	</thead>
							<tbody class="tbody">
								<?php foreach($grading as $grading):?>
								<tr id="score_criteria_data">
									<td><?=$grading->score?></td>
									<td><?=$grading->score_equivalent?></td>
									<td><?=$grading->scoring_guide?></td>
                          <div class="tooltop1">
                   <td><div class="tooltop1"> <button class="delete btn btn-danger btn-xs" data-id ="<?php echo $grading->gid; ?>"><span class="glyphicon glyphicon-trash"></span></button></div></td>
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
	               <th scope="col">Area</th>
  <?php $q = $res1->row(); if(!empty($q->level))  { ?> <th scope="col">level</th> <?php }?>
								<th scope="col" colspan="2"> Description / weight</th>	
		                  	</thead>
		                  	<tbody class="tbody"> 
										
							<?php foreach($res1->result()  as $res1):?>
								<tr id='pos_area_data'>
									<td><?=$res1->area?></td>
                  <?php if(!empty($res1->level)){ ?> <td><?=$res1->level?></td> <?php  } ?>
									   <td><?php $res2= $this->pms_model->get_weight_and_description_admin($res1->cid,$res1->doc_no);
              foreach($res2 as $res2){?> 
                <table class="table table-bordered"  style="table-layout:fixed;"><tbody>
                  <tr>
                    <td style="width: 140px" ><?php echo $res2->description; ?></td><td style="width: 30px;" > <?php $criteria =  $this->pms_model->get_weight_job($res2->id);
                     foreach($criteria as $criteria){ echo '<b>'.ucfirst($criteria->job_level).':</b> '.$criteria->weight.'%<br>'; } ?></td>
                  </tr>
                </tbody>
                </table><?php } ?></td>

					  <td><div class="tooltop1"> <button class="delete_criteria btn btn-danger btn-xs" data-id ="<?php echo $res1->cid; ?>"><span class="glyphicon glyphicon-trash"></span></button></div></td>

								</tr>
							<?php endforeach?>
						

							</tbody>
		                </table>
                 		
                


				        <!-- Modal -->
					

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
        </div>       <?php $s = $doc_no; $form_location   = base_url()."employee_portal/pms/save_grading_table/";?>     
                                                      <form role="form"  id="form" method="post" action="javascript:void(0)"  onsubmit="save_grading_table_admin('<?php echo $employeeid ?>','<?php echo $form ?>','<?php echo $doc_no?>');">
        <div class="modal-body">

                                                      	<input type="hidden" name="fid" value="<?php  echo $doc_no;  ?>">
                                                      	 <div class="form-group">

                                                                  <label for="message-text">Score:</label>
                                                                      <?php $g =  $this->pms_model->getgradingtype_admin($form);
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
<form  action="javascript:void(0)" role="form"  id="criteria_form" method="post" onsubmit="save_criteria_form_admin('<?php echo $doc_no ?>','<?php echo $form ?>');"   >

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
          
           
       

                  <div class="row" >
                    
                    <div class="form-group">
                      <input type="hidden" name="idcriteria" value="<?php echo $doc_no ?>">
                      
                      
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
        </div>
</body></html>


	<!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
	
    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

	<script type="text/javascript">
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
                              url: "<?php echo site_url('employee_portal/pms/delete_criteria'); ?>",
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
                    $(document).on('click','.delete', function(event){
              
 
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
      var val2 = 1;
      var val1 = $(this).attr("data-id");
      var $button = $(this);


      $.ajax({ 
        url: "<?php echo site_url('employee_portal/pms/delete_grade'); ?>",
        type: 'POST',
        data: { "text1": val1,"text":val2},
        success: function(data) { 
          $('#message').show();
          $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Data is Successfully Deleted!</div>").fadeOut(5000);
       

             $tr.find('td').fadeOut(1000,function(){ 
                                $tr.remove();                    
                              }); 

        }
      });

      
    } else {
     
    }
  });




});

function save_criteria_form_admin(doc_no,fid,company){

       
            $.ajax({ 
              url: "<?php echo base_url('employee_portal/pms/save_criteria_form_admin') ?>",
              type: 'POST',
         
              data: $('#criteria_form').serialize()+ "&doc_no=" + doc_no+ "&fid=" + fid,
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

	     $('.addrow').click(function(e){
     $(".modal-body #app").append('<div class="row"><div class="form-group"><div class="col-md-6"><label for="message-text">Description</label><textarea name="description[]" id="form_description" required class="form-control"></textarea></div><div class="col-md-3"><label for="message-text">weight:</label><div class="input-group"> <input required="" name="des_weight[]" type="number" class="form-control" id="recipient-name"><span class="input-group-addon">%</span></div></div><div class="col-md-3" style="margin-top:40px;"><a href="#" class="removed">Remove  </a></div></div></div></div>')});
              $(document).on('click','.removed',function(e){


                            $(this).parent().parent().remove();
                          });



         function save_grading_table_admin(employeeid,fid,doc_no){
        
         
             $.ajax({ 
              url: "<?php echo base_url('employee_portal/pms/save_grading_table_admin') ?>",
              type: 'POST',
     		  dataType:'json',
              data: $('#form').serialize()+ "&employeeid=" + employeeid+ "&doc_no=" +doc_no+ "&fid=" + fid,
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



	</script>	