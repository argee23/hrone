<style type="text/css">
	
.nav>li>a:hover, .nav>li>a:focus, .nav .open>a, .nav .open>a:hover, .nav .open>a:focus {
   box-shadow:5px 8px 8px 0 #ccc;

}
.dropdown {
    background:#fff;
    border:1px solid #efefef;
    border-radius:4px;
    width:20vw; 
}
.dropdown-menu>li>a {
    color:#428bca;
}
.dropdown ul.dropdown-menu {
    border-radius:4px;
    box-shadow:none;
    margin-top:20px;
    width:300px;

}

</style>

<div class="content-body">

<div class="col-lg-12">

<h2 class="page-header">Section Management </h2>
	
<div class="col-md-3" >

						
			<div class="panel panel-success" id="general_page" >
																<br>
							<center><strong style="color:#3c8dbc;"><?php echo $eval_c->fullname; ?></strong></center>	
					        <div class="panel-body" >
<form id="form5" method="post">
								<div class="box-header with-border" style="padding: 0px;" >
									     <input type="hidden" name="employid" class="form-control" value="<?php  echo $employee_id ?>"  >
									     				  	 <input type="hidden" name="refe" id="idko" value="<?php echo $doc_no ?>"  >
								                               <input type="hidden" id="max" name="max" value="<?php echo $max; ?>"  >
								                                 <input type="hidden" name="l" value="<?php echo $ref->eval_level ?>"  >

                                                 <input type="hidden" name="eval"  value="<?php if(!empty($eval->eval_level)){echo $eval->eval_level; }?>" >
                                                 	<div class="profile-userbuttons" style="padding-right: 15px;">
                                                 			<div id="e" style="width: 100%;">   </div>
				
					<button type="button" class="btn btn-danger btn-sm" style="width: 50%;" >Cancel</button>

					<br>
					<br>

						  <?php if($get_last_eval->evaluators == $this->session->userdata('employee_id')){ ?>
	<button type="button" class="btn btn-primary btn-sm" style="width: 100%;" onclick="recommendatin('qwe',<?php echo $employee_id; ?>,'<?php echo $doc_no; ?>')">Recommendation</button>
<?php } ?>
				</div>

				
                                       </form>
										
							   
															
									 <br>   	
			 <?php if($general_forms)
				 {
								$first = 1;			 
						 foreach($general_forms as $general_forms)
									 {
									 $f = $this->pms_model->form_saved($general_forms->doc_no,$general_forms->fid);
								
									 	if(($f != 'false') OR ($f =='true')){
									 	
									 		 ?>				
									 		  				  <ul class="nav navbar-nav">
																	<li class="dropdown"  id="4" onclick="criteria_form_admin(<?php echo $general_forms->fid ?>,'<?php  echo $this->uri->segment('4');  ?>','<?php echo $general_forms->doc_no ?>');",>
																	 <a  href="http://totoprayogo.com" class="dropdown-toggle" data-toggle="dropdown"><?php echo $general_forms->form_title; ?><i onclick="delete_me(<?php echo $general_forms->id; ?>,this);" class="glyphicon glyphicon-ok pull-right"></i> </a>
																	</li>
 															  </ul><br><br><br><br>
									 				
									 		 <?php 
										}else{	?>
											  
												
												<ul class="nav navbar-nav">
		
														<?php  if($first==1){?>
																	<li style="background-color: #e5e5e5" class="dropdown" id="4" onclick="criteria_form_admin(<?php echo $general_forms->fid ?>,'<?php  echo $this->uri->segment('4');  ?>','<?php echo $general_forms->doc_no ?>');",>
																			<a href="http://totoprayogo.com" class="dropdown-toggle" data-toggle="dropdown"><?php echo $general_forms->form_title; ?><i onclick="delete_me(<?php echo $general_forms->id; ?>,this);" class="fa fa-times-circle pull-right"></i> </a>
																   </li>
														<?php }else{?>
																	<li style="background-color: #e5e5e5" class="dropdown" id="4" onclick="alert('bawal pa');",>
																			<a href="http://totoprayogo.com" class="dropdown-toggle" data-toggle="dropdown"><?php echo $general_forms->form_title; ?><i onclick="delete_me(<?php echo $general_forms->id; ?>,this);" class="fa fa-times-circle pull-right"></i> </a>
																   </li>
														<?php } $first++;?>
											   </ul><br><br><br><br>

										
										
									   <?php }
						}
					}?>
											
											   		    					    
											  	<div id="c">	 <?php if($emple_forms)
				 {
								$first = 1;			 
						 foreach($emple_forms as $emple_forms)
									 {
									 $f = $this->pms_model->form_saved($emple_forms->doc_no,$emple_forms->fid);
									 	if(!empty($f->score)){
									 	
									 		 ?>				
									 		  				  <ul class="nav navbar-nav">
																	<li style=";background-color:#3cb371" class="dropdown" id="4" onclick="criteria_form_admin(<?php echo $emple_forms->fid ?>,'<?php  echo $this->uri->segment('4');  ?>','<?php echo $emple_forms->doc_no ?>');",>
																	 <a style="color:#fff !important" href="http://totoprayogo.com" class="dropdown-toggle" data-toggle="dropdown"><?php echo $emple_forms->form_title; ?><i onclick="delete_me(<?php echo $emple_forms->fid; ?>,this);" class="glyphicon glyphicon-ok pull-rui"></i> </a>
																	</li>
 															  </ul><br><br><br><br>
									 				
									 		 <?php 
										}else{	?>
											  
												
												<ul class="nav navbar-nav">
		
														<?php  if($first==1){?>
																	<li style="background-color: #e5e5e5" class="dropdown" id="4" onclick="criteria_form_employeeportal(<?php echo $emple_forms->fid ?>,'<?php  echo $this->uri->segment('4');  ?>','<?php echo $general_forms->doc_no ?>');",>
																			<a href="http://totoprayogo.com" class="dropdown-toggle" data-toggle="dropdown"><?php echo $emple_forms->form_title; ?><i onclick="delete_me(<?php echo $emple_forms->fid; ?>,this);" class="fa fa-times-circle pull-right"></i> </a>
																   </li>
														<?php }else{?>
																	<li style="background-color: #e5e5e5" class="dropdown" id="4" onclick="alert('qwe');",>
																			<a href="http://totoprayogo.com" class="dropdown-toggle" data-toggle="dropdown"><?php echo $emple_forms->form_title; ?><i onclick="delete_me(<?php echo $emple_forms->id; ?>,this);" class="fa fa-times-circle pull-right"></i> </a>
																   </li>
														<?php } $first++;?>
											   </ul><br><br><br><br>

										
										
									   <?php }
						}
					}?>
													
												 </div> 
										
										




								</div>
					      	</div>
			 </div>
    </div>
	<div class="col-md-9" id="main">

      </div>







     <script type="text/javascript">
 e = $('#max').val();

 if(e > 1){
 $('#e').html('<button onclick="next_eval()" type="button" class="btn btn-success btn-sm pull-right" style="width:50%">Recommend  evaluation</button>');
}else{
 $('#e').html('<button onclick="ready_for_approval()" type="button" st class="btn btn-success btn-sm pull-right" style="width:50%">Ready for approval</button>');
 }


     function qwe(id){
	     $.ajax({
            url: "<?php echo base_url();?>employee_portal/pms/is_form_ready/"+id,

            type: 'POST',
            success: function(data){
           		if(data >= 1){
           			alert('di pa pde');
           		}else{
           			alert('pde na');
           		}
            }
        }); 
	
	}
     	   function criteria_form_employeeportal(id,e,doc_no){
        $.ajax({
            url: "<?php echo base_url();?>employee_portal/pms/criteria_form_employeeportal/",
            data:{'id':id,'e':e,doc_no:doc_no},
            type: 'POST',
            success: function(data){
           
              $('#main').html(data);
            }
        });
      
	}
    function recommendatin(fid,e,doc_no){

        $.ajax({
            url: "<?php echo base_url();?>employee_portal/pms/for_recommend/",
            data:{'fid':fid,'e':e,'doc_no':doc_no},
            type: 'POST',
            success: function(data){
           
              $('#main').html(data);
            }
        });
      
	}
    function criteria_form_admin(fid,e,doc_no){
    
        $.ajax({
            url: "<?php echo base_url();?>employee_portal/pms/criteria_form_admin/",
            data:{'fid':fid,'e':e,'doc_no':doc_no},
            type: 'POST',
            success: function(data){
           
              $('#main').html(data);
            }
        });
      
	}
	    function next_eval(){
           id = $('#idko').val();

           $.ajax({
            url: "<?php echo base_url();?>employee_portal/pms/is_form_ready/"+id,

            type: 'POST',
            success: function(data){
              if(data >= 1){
                alert('Please complete the evaluation');
              }else{
                $.ajax({ 
                url: "<?php echo base_url();?>employee_portal/pms/next_eval/",
                type: 'POST',
                data: $('#form5').serialize(),
                
                success: function(data) {
    
                     window.location.replace("<?php echo base_url(); ?>employee_portal/pms/evaluation");

                    }
               });
              }
            }
        }); 
  
        
        
            
            }   
   function ready_for_approval() {



     $.ajax({
       url: "<?php echo base_url();?>employee_portal/pms/approver_for/",
       method:"POST",
       data:$('#form5').serialize(),
       
   
       success:function()
       {
        
      window.location.replace("<?php echo base_url(); ?>employee_portal/pms/evaluation");       }
     })
   


  }
     </script>