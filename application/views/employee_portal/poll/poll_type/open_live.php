<style type="text/css">
.board-container{padding:10px;box-sizing:border-box;color:black; }
.board{background-color:#efefef;height:100%;padding:14px; width: 60%; }
</style>
	<br><br><Br><br>
<div class="content-body" style="background-color: #263a4e;">

<div class="col-lg-12">
<div class="panel panel-success">
<div class="panel-body" style="background-color: #263a4e;height:100%;color:white; min-height: 100vh;">
<div id="not" class="col-md-12" >



			 <div class="col-lg-10 col-lg-offset-1" >


			  <?php $qsw =  $this->db->select('*')->from('poll_name')->where('id',$this->uri->segment('4'))->get()->row(); echo '<center><h1>'.$qsw->name.'</h1></center>';  ?>

							
								<hr>
										<?php foreach($get_result as $get_result){ ?>
								<div class="row">
									<div class="col-md-8">
							
																	<?php echo '<h4>'.$get_result->poll_answer.'</h4><small>-'.$get_result->fullname.'</small>'; ?>
																		
									
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
												<div class="col-md-1">
							
																	           <span  class="up<?php echo $get_result->id ?>">
                      <?php  

                            $this->db->select_sum('upvote');
                                                                                                                                          
                            $this->db->from('poll_up_down_vote');
                            $this->db->where('open_id',$get_result->id);
                           	
                            echo 'upvote<br>'.'<h4>'.$this->db->get()->row()->upvote.'</h4>';   ?>
                        
                      </span>
									
									</div>
						
								</div><br><br>
								<?php } ?>
	

			 					
			 </div>


							





</div>
</div>
</div>
</div></div>










 <script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script>

<script type="text/javascript">
	
	




    var socket = io.connect( 'http://'+window.location.hostname+':3000' );

      socket.on( 'poll', function( data ) {

   
      console.log(data.id);
         $('.up'+data.id).html('Upvote<br>'+'<h4>'+data.up+'</h4>');
         $('.down'+data.id).html('Downvote<br>'+'<h4>'+data.down+'</h4>');

 
      

  });

</script>