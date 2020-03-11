<style type="text/css">
.board-container{padding:10px;box-sizing:border-box;color:black; }
.board{background-color:#efefef;height:100%;padding:14px; width: 60%; }
</style>
	<br><br><Br><br>
<div class="content-body" style="background-color: #263a4e;">
    <div id="c"></div>
<div class="col-lg-12">
<div class="panel panel-success">
<div class="panel-body" style="background-color: #263a4e;height:100%;color:white; min-height: 100vh;">
<div id="not" class="col-md-12" >



			 <div class="col-lg-10 col-lg-offset-1" >
                        
              <?php $qsw =  $this->db->select('*')->from('poll_name')->where('id',$this->uri->segment('4'))->get()->row(); echo '<center><h1>'.$qsw->name.'</h1></center>';  ?>
               
							<?php foreach($pollingg as $pollingg){ echo '<h3>'.$pollingg->poll_question.'</h3>'; } ?>	

								<div class="row">
									<div class="col-md-8">
									<input class="form-control" type="text" name="open">
									</div>
									<div class="col-md-4">
									<button class="button btn btn-primary" style="width: 80px;">save</button>
									</div>
								</div>
								<hr>
										<?php foreach($get_result as $get_result){ ?>
								<div class="row">
									<div class="col-md-8">
							         
											<?php echo '<h4>'.$get_result->poll_answer.'</h4>'; ?>
									
									</div>
                  <div class="col-md-1">
                       
                     <span class="up<?php echo $get_result->id ?>"> <?php  

                            $this->db->select_sum('upvote');

                            $this->db->from('poll_up_down_vote');
                            $this->db->where('open_id',$get_result->id);
                           
                                        echo 'Upvote<br>'.'<h4>'.$this->db->get()->row()->upvote.'</h4>';   ?></span>
                  
                  </div>
                    <div class="col-md-1">
                       
                            <span  class="down<?php echo $get_result->id ?>">
                      <?php  

                            $this->db->select_sum('downvote');
                                                                                                                                          
                            $this->db->from('poll_up_down_vote');
                            $this->db->where('open_id',$get_result->id);
                           
                            echo 'Downvote<br>'.'<h4>'.$this->db->get()->row()->downvote.'</h4>';   ?>
                        
                      </span>
                  
                  </div>
									<div class="col-md-2">
										<p ><span style=" font-size: 25px;" class="glyphicon glyphicon-triangle-top" id="sup<?php echo $get_result->id ?>" onclick="vote(<?php echo $get_result->id ?>,<?php echo $this->session->userdata('employee_id') ?>, 'up')"></span>
                     </p>
                      <span  class="downvote" ><span style=" font-size: 25px;" class="glyphicon glyphicon-triangle-bottom" onclick="vote(<?php echo $get_result->id ?>,<?php echo $this->session->userdata('employee_id') ?>, 'down')"></span>
                </p>
									
									</div>
								</div>
								<?php } ?>
	

			 					
			 </div>



</div>
</div>
</div>
</div>
</div>

	








 <script src="<?php echo base_url('public/plugins/node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script>
<script type="text/javascript">
	 var socket = io.connect( 'http://'+window.location.hostname+':3000' );

      socket.on( 'poll', function( data ) {

   

      console.log(data.up);
      $('.up'+data.id).html('Upvote<br>'+'<h4>'+data.up+'</h4>');
      $('.down'+data.id).html('Downvote<br>'+'<h4>'+data.down+'</h4>');


              
 
      

  });
	
     $(document).on('click','.button',function(){
      
      $( "#load" ).show();
     
    
   
                  poll_name = <?php echo $this->uri->segment(4); ?>;
                  ans = $("input[name=open]").val();




       var dataString = { 
              ans:ans,
              poll_name:poll_name,
        

       
            };

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('employee_portal/poll/saved_polling').'/'.$this->uri->segment(5);?>",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
        
        
              if(data.success == true){
              
                $('#c').html('<div class="alert alert-success">POll Succes!</div>');
                var socket = io.connect( 'http://'+window.location.hostname+':3000' );

         

              }else{
                $('#c').html('<div class="alert alert-danger">You already answered the poll !</div>');
              } 
          
            }

      
        

    });
 });



    function vote(id,emp,qwe){

    	     $.ajax({
            type: "POST",
            url: "<?php echo base_url('employee_portal/poll/save_upvote');?>",
            data: {id:id,emp:emp,qwe:qwe},
            dataType: "json",
            cache : false,
            success: function(data){
 				

 				console.log(data);
          		 if(data.success == 'true'){

                $('.sup'+id).css('background-color','black');
               		
                var socket = io.connect( 'http://'+window.location.hostname+':3000' );

                
            			
                	
    		
    socket.emit('poll', { 
                id:data.id,
                emp:data.emp,
                up:data.up,
                down:data.down,
                qwe:data.qwe
               
                });





              

              } 			
          
            }

    	  })
        
    }


</script>