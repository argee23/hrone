<style type="text/css">



.board-container{padding:10px;box-sizing:border-box;color:black; }
.board{background-color:#efefef;height:100%;padding:14px; width: 60%; }
</style>
<br><br><Br><br>

<div class="content-body" style="background-color: #263a4e;">
<div class="col-lg-12">
  
   <div class="panel panel-success">
    
        <div class="panel-body" style="background-color: #263a4e; color:white;">
          
<div id="not" class="col-md-12" >



 <div class="col-lg-10 col-lg-offset-1"  align="center">


  <div id="c"></div>
<?php 
  $in = 1;
    foreach($pollingg as $pollingg){ ?>
      <input type="hidden" name="rtyrtye<?php echo $pollingg->id ?>" id="qas<?php echo $pollingg->id ?>" class="question" data-werw="<?php echo $pollingg->id ?>"  value="<?php echo $pollingg->try; ?>">
            <span class="pull-left"><h3><?php  echo $pollingg->question;?></h3></span><br><br><br>
              
     <?php   $poll = $this->poll_model->get_polling_opt($pollingg->poll,$pollingg->question);
            
            foreach($poll as $poll){ ?>
                            
              <?php $c = $this->poll_model->ans_res($poll->opts,$this->session->userdata('employee_id'),$pollingg->id);
                      
                if(!empty($c)){
                
                   echo '<div class="row board-container"><div class="board"  style="text-align:left">'.$poll->opts.'</div> </div>';
                }
                else{
                 
                  echo '<div class="row board-container"><div class="board"  style="text-align:left"><input 
                    data-a="'.$poll->multiple_choice.'"  class="'.$pollingg->id.'" data-c="'.$this->uri->segment(4).'" type="checkbox" value="'.$poll->opts.'" >'.$poll->opts.'</div> </div>'; 

                } 

             
            } echo '<hr>';
          
          
    $in++;   }

  

 ?>
    <button class="button btn btn-primary" style="width: 80px;">save</button>
</div>
    
 

</div>
</div>
</div>    
</div>
</div>

   <script src="<?php echo base_url('public/plugins/node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script>
<script type="text/javascript">


$(document).on('click','.board-container',function(e) {
    var q = $(this).closest('div').find('[type=checkbox]');
          
              if($('#qas'+q.attr('class')).val() != 0){
              // $('.'+q.attr('class')).prop('checked', false);
     
               q.prop('checked', true);
               var  c = $('#qas'+q.attr('class')).val() - parseInt(1) ;

               $('#qas'+q.attr('class')).val(c) ;
             }else{
              alert('You reach the maximum number of respond');
             }
      

});

     $(document).on('click','.button',function(){
      
      $( "#load" ).show();
        var val = [];
        var question = []
        var attem = [];
        var questionid =[];
    
        $('.question').each(function(i){
            attem[i] = $(this).val();
            questionid[i] = $(this).attr('data-werw');
        })
        $(':checkbox:checked').each(function(i){
            val[i] = $(this).val();
            question[i] = $(this).attr('data-a');
             poll = $(this).attr('data-c');
            
        });
                  poll_name = <?php echo $this->uri->segment(4); ?>;




       var dataString = { 
              val : val,
              question:question,
              poll_name:poll_name,
              poll:poll,
              attem:attem,
              questionid:questionid

       
            };

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('employee_portal/poll/saved_polling').'/'.$this->uri->segment(5);?>",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
 
        
              if(true){

                $('#c').html('<div class="alert alert-success">POll Succes!</div>');
                var socket = io.connect( 'http://'+window.location.hostname+':3000' );

            

          


$.each(data, function(k, v) {
    
    socket.emit('new_message', { 
                 count: v.count,
                id:v.id,
                opt:v.opt,
                wc:v.wc,
                questionid:v.questionid
               
                });


  });


              

              } 
          
            },error: function(xhr, status, error) {
              alert(error);
            },

      
        

    });
 });

</script>
