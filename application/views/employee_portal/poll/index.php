




<style type="text/css">

.col-md-2, .col-md-10{
    padding:0;
}
.panel{
    margin-bottom: 0px;
}
.chat-window{
    bottom:0;
    position:fixed;
    float:right;
    margin-left:10px;
}
.chat-window > div > .panel{
    border-radius: 5px 5px 0 0;
}
.icon_minim{
    padding:2px 10px;
}
.msg_container_base{
  background: #e5e5e5;
  margin: 0;
  padding: 0 10px 10px;
  max-height:300px;
  overflow-x:hidden;
}
.top-bar {
  background: #666;
  color: white;
  padding: 10px;
  position: relative;
  overflow: hidden;
}
.msg_receive{
    padding-left:0;
    margin-left:0;
}
.msg_sent{
    padding-bottom:20px !important;
    margin-right:0;
}
.messages {
  background: white;
  padding: 10px;
  border-radius: 2px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
  max-width:100%;
}
.messages > p {
    font-size: 13px;
    margin: 0 0 0.2rem 0;
  }
.messages > time {
    font-size: 11px;
    color: #ccc;
}
.msg_container {
    padding: 10px;
    overflow: hidden;
    display: flex;
}

.avatar {
    position: relative;
}
.base_receive > .avatar:after {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    width: 0;
    height: 0;
    border: 5px solid #FFF;
    border-left-color: rgba(0, 0, 0, 0);
    border-bottom-color: rgba(0, 0, 0, 0);
}

.base_sent {
  justify-content: flex-end;
  align-items: flex-end;
}
.base_sent > .avatar:after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 0;
    border: 5px solid white;
    border-right-color: transparent;
    border-top-color: transparent;
    box-shadow: 1px 1px 2px rgba(black, 0.2); // not quite perfect but close
}

.msg_sent > time{
    float: right;
}



.msg_container_base::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

.msg_container_base::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
}

.msg_container_base::-webkit-scrollbar-thumb
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}

.btn-group.dropup{
    position:fixed;
    left:0px;
    bottom:0;
}   

/*---*CHAT*-----*/
#chat .panel-heading{
    background-image: url(http://www.caixa.gov.br/Style%20Library/images/bg_destaqueInternas.jpg);
    background-position: center 30%;
}
#chat .panel-heading, #chat .panel-heading a {
    color:#fff ;
}
#chat .messages{
    box-shadow:none;
    background: #f3f5f9;
    
}
#chat .base_sent .messages{
    background: #2DADB0;
    border-radius: 8px 8px 0px 8px;
    -webkit-border-radius: 8px 8px 0px 8px;
    color: #fff;
    border-bottom:1px solid #108BB4;
}
#chat .base_sent::after{
    top:0px;
    width: 0;
    height: 0;
    border-top:10px solid transparent;
    border-left: 10px solid #2DADB0;
    border-bottom: 0px solid transparent;
    
}
#chat .base_receive .messages{
    background: #f3f5f9;
    border-radius: 0 8px 8px 8px;
    border-bottom:1px solid #ccc;
    
}
#chat .base_receive::before{
    width: 0;
    height: 0;
    border-top: 0px solid transparent;
    border-right: 10px solid #f3f5f9;
    border-bottom: 10px solid transparent;
}

#chat .msg_container_base{
    background:#fff;
}
#chat time{ color:#fff; font-style: italic; }
    
















            .contact-form-page{
                height: 50px;
                width: 50px;
                display: block;
                border-radius: 50%;
                position: absolute;
                bottom: 42px;
                right: 42px;
                overflow: hidden;
                -webkit-transition: all 0.5s;
                -moz-transition: all 0.5s;
                -o-transition: all 0.5s;
                transition: all 0.5s;
                background: #7EC6E7;

            }

            .show-profile{
                background: #3aa8db;
                height: 50%;
                display: block;
                width: 336px;
                bottom: 0;
                right: 0;
                position: absolute;
                overflow-y: scroll;
                border-radius: 0;
                padding-bottom: 30px;
      

            }

            .form-profile-img{
                float: left;
            }
            .form-profile-img img{
                border-radius: 50%;
                margin: 20px 0 0 14px;
            }
            .contact-form-page h1{
                font-size: 18px;
                color: #fff;
                margin: 20px 26px;
                padding: 0px;
                line-height: 29px;
                padding-right: 30px;
            }
            .top-btn{
                position: absolute;
                top: 15px;
                right: 15px;
                background: #98D1EC;
                color: #fff;
                padding: 15px 0;
                text-align: center;
                width: 60px;
                height: 60px;
                border-radius: 50%;
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
                -webkit-transition: all 1s;
                -moz-transition: all 1s;
                -o-transition: all 1s;
                transition: all 1s;
                opacity: 0;
            }
            .top-btn:hover{
                 -webkit-transform: rotate(360deg);
                 -moz-transform: rotate(360deg);
                 -o-transform: rotate(360deg);
                 transform: rotate(360deg);
                 background: #7EC6E7;
                 color: #fff
            }

            .header-btn, .footer-btn a{
                font-size: 20px;
                color: #fff;
                background: #3aa8db;
                float: right;
            }
            .form-head{
                display: block;
            }
            .cancel-btn-img{
                position: relative;
            }
            .footer-btn{
                position: relative;
            }

            .buttom-btn{
                position: absolute;
                bottom: 30px;
                right: 30px;
                background: #3aa8db;
                color: #fff;
                padding: 21px;
                text-align: center;
                width: 75px;
                height: 75px;
                border-radius: 50%;
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
                -webkit-transition: all 0.5s;
                -moz-transition: all 0.5s;
                -o-transition: all 0.5s;
                transition: all 0.5s;
                opacity: 1;
            }
            .buttom-btn i{
                font-size: 30px;
            }

            .buttom-btn:hover{
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
                background:#71C0E5;
                color: #fff
            }
            input.form-control {
                height: 40px;
                border-radius: 0;
                outline: none;
            }
            textarea.form-control {
                height: 150px;
                border-radius: 0;
            }
            .contact-form-page form{
                padding: 0 26px;
            }

            .contact-form-page .submit-buttom{
                padding: 10px 40px;
                text-align: center;
                display: block;
                border-radius: 0;
                background: #007BB5;
                border: none;
                border-bottom: 5px solid #005B85;
                text-shadow: none;
                box-shadow: none;
                font-size: 16px;
                color: #ffffff;
                text-transform: uppercase;
                font-family: 'Roboto Condensed', sans-serif;
            }
            .form-group label{
                font-size: 14px;
                color: #fff;
            }

            /*
                BUTTON OPACITY STYLE
            */
            .top-btn-show{
                opacity: 1 !important;
                -webkit-transition: all 0.5s;
                -moz-transition: all 0.5s;
                -o-transition: all 0.5s;
                transition: all 0.5s;
            }
            .buttom-btn-hide{
                opacity: 0 !important;
                -webkit-transition: all 0.5s;
                -moz-transition: all 0.5s;
                -o-transition: all 0.5s;
                transition: all 0.5s;
            }
/* GITHUB SOURCE STYLE  */
.github-source{
  display:inline-block;
  color:#000;
  margin:20px;
  position: relative;
  z-index:999999;
}
.github-source i{
  font-size:50px;
  color:#fff
}






</style>

<br><br>

<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-md-6">
<h2 class="page-header">Creators Page </h2>
   


     
 

      <div class="panel panel-success">
        <div class="panel-header">
              <h4 style="margin:15px;">Created Poll

                <span class="pull-right" style="margin-top:-5px;"> <a href="<?php echo base_url(); ?>employee_portal/poll/create"><button type="button" class="btn btn-primary btn-sm">Create a Poll</button></a></span>
                  <br><br>
                  <div class="box box-danger"></div>
              </h4>
            
          
        </div>
        <div class="panel-body">

            <div class="col-md-12">
			
				
 			

<table class="table">
  <thead>
    <tr>
      <th scope="col">Poll</th>

    </tr>
  </thead>
  <tbody>
  	<?php foreach($poll as $poll) {?>
    <tr>
      
      <td><?php echo $poll->name; ?></td>
      <td>

                <a href="<?php echo base_url() .'/employee_portal/poll/participants/'.$poll->id ?>" class="btn btn-success btn-sm">
    <span class="glyphicon glyphicon-user"></span> Participants
</a>
</td>        
<?php if($poll->status == '0'){ ?>
      <td><button data-c="<?php echo $poll->id; ?>" type="button" id="activated" class="btn btn-success btn-sm button">Activate</button></td>

     <?php }else{ ?> 

<td><button data-c="<?php echo $poll->id; ?>" type="button" id="deactivated" class="btn btn-danger btn-sm button">Deactivate</button></td>
     <?php } ?>
      <td><a target="_blank" rel="noopener noreferrer" href="<?php echo base_url() .'/employee_portal/poll/polling_live/'.$poll->id.'/'.$poll->poll_type ?>"><span class="glyphicon glyphicon-eye-open"></span> View Live result</a></td>

  
    </tr>
<?php } ?>

  </tbody>
</table>


</div>
</div>  
</div>
</div>
<div class="col-md-6">
<h2 class="page-header">Creators Page </h2>
   


     
 

      <div class="panel panel-success">
         <div class="panel-header">
              <h4 style="margin:15px;">Pending Poll 

     
                  <br><br>
                  <div class="box box-danger"></div>
              </h4>
            
          
        </div>
        <div class="panel-body">

            <div class="col-md-12">
     
        

<table class="table">
  <thead>
    <tr>
      <th scope="col">Name</th>

    </tr>
  </thead>
  <tbody>

    <?php if(!empty($participant)){ foreach($participant as $participant) { if($participant->status == '1'){?>
    <tr>
      
      <td><?php echo $participant->name; ?></td>
            <td><a target="_blank" rel="noopener noreferrer" href="<?php echo base_url().'/employee_portal/poll/polling/'.$participant->id.'/'.$participant->poll_type?>">Start the Poll</a></td>
        <?php ?>
     
  
    </tr>
<?php }}}else{?>
          <center><strong>NO POLL FOUND</strong></center>

 <?php } ?>

  </tbody>
</table>


</div>
</div>  
</div>
</div>
</div>


<div class="container" id="chat">
    <div class="row chat-window col-xs-5 col-md-3" id="chat_window_1" style="margin-left:10%;">
        <div class="col-xs-12 col-md-12">
          <div class="panel panel-default">
                <div class="panel-heading top-bar">
                    <div class="col-md-8 col-xs-8">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat - <span data-group="" data-erte="" class="receiver"></span></h3>
                    </div>
                    <div class="col-md-4 col-xs-4" style="text-align: right;">
                        <a href="#"><span id="minim_chat_window" class="glyphicon glyphicon-minus icon_minim"></span></a>
                        <a href="#"><span class="glyphicon glyphicon-remove icon_close" data-id="chat_window_1"></span></a>
                    </div>
                </div>
                <div class="panel-body msg_container_base">
                 
             
          
          
                
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="textbox" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />
                        <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" id="btn-chat">Send</button>
                        </span>
                    </div>
                </div>
        </div>
        </div>
    </div>
  </div>
            <div class="contact-form-page">
            <div class="form-head">
                <div class="header-btn">
                    <a class="top-btn" href="#"><i class="fa fa-times"></i></a>
                </div>
            </div>
               
                        <ul class="l">
                            
                          </ul>
                
            </div>
            <a class="buttom-btn" href="#"><i class="fa fa-times"></i></a>
    



</body>
<script type="text/javascript">
  $('.button').click(function(){
     
          var data = $(this).attr('data-c');
            $.ajax({
               dataType: "json",
   data: {data:data},

   type: "post",

   url: "<?php echo base_url().'employee_portal/poll/activate_deactivate/'?>",
   success: function(emit){
        if(emit.success == true){
                alert('Succesfully Activated');
                 var socket = io.connect( 'http://'+window.location.hostname+':3000' );   
          $.each(emit, function(k, v) {
     
                socket.emit('new_count_message', { 
                     
                     notification_type:v.notification_type,
                     emp_id:v.emp_id,
                     new_count_message: v.new_count_message,
                     notification:v.notification

                });
                    });
        }  
  } 
});
  });

$(document).on('click', '.panel-heading span.icon_minim', function (e) {
    var $this = $(this);
    if (!$this.hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideUp();
        $this.addClass('panel-collapsed');
        $this.removeClass('glyphicon-minus').addClass('glyphicon-plus');
    } else {
        $this.parents('.panel').find('.panel-body').slideDown();
        $this.removeClass('panel-collapsed');
        $this.removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).on('focus', '.panel-footer input.chat_input', function (e) {
    var $this = $(this);
    if ($('#minim_chat_window').hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideDown();
        $('#minim_chat_window').removeClass('panel-collapsed');
        $('#minim_chat_window').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).on('click', '#new_chat', function (e) {
    var size = $( ".chat-window:last-child" ).css("margin-left");
     size_total = parseInt(size) + 400;
    alert(size_total);
    var clone = $( "#chat_window_1" ).clone().appendTo( ".container" );
    clone.css("margin-left", size_total);
});
$(document).on('click', '.icon_close', function (e) {
    //$(this).parent().parent().parent().parent().remove();
    $( "#chat_window_1" ).remove();
});






// //log user that just arrived - Page loaded
// $(document).ready(function() {
//          $.ajax({
//         type: 'POST',
//         url: 'log.php',
//         async:false,
//         data: {userlog:"userid arrived"}
//     });
// });

// //log user that is about to leave - window/tab will be closed.
// $(window).bind('beforeunload', function(){
//     $.ajax({
//         type: 'POST',
//         url: 'log.php',
//         async:false,
//         data: {userlog:"userid left"}
//     });
// });

$(document).on('click', '#btn-chat', function (e) {
        alert($('.receiver').text());
     var dataString = { 
              msg : $('#textbox').val(),
              sender_id:'<?php echo $this->session->userdata('employee_id'); ?>',
              receiver:$('.receiver').attr('data-erte')
       

       
            };
    $.ajax({
   data: dataString,
   type: "post",
   url: "<?php echo base_url().'employee_portal/poll/send/'?>",
   success: function(e){  
     
      $('#textbox').val(' ');
          
  }
});
});

 

  
  function ertrt(emp,el){
    wertwert = $(el).text();

    if(emp != $('.receiver').text()){
          $.ajax({
            type: "POST",
            url: "<?php echo base_url('employee_portal/poll/recieve/');?>",
        
            dataType: "json",
            data:{emps:emp},
            cache : false,
            success: function(data){

              $('.msg_container_base').html('');


            $('.receiver').attr('data-id',emp);
            $('.receiver').text(wertwert);
            $('.receiver').attr('data-erte',emp);
            






  $.each(data, function(k, v) {
        

                if(v.employee_id  != <?php echo $this->session->userdata('employee_id'); ?>){
    $('.msg_container_base').append('<div class="row msg_container base_receive"> <div class="col-xs-10 col-md-10"> <div class="messages msg_sent"> <p>'+v.msg+'</p><time datetime="2009-11-13T20:00" style="color:black;">'+v.receiver+' • 51 min</time> </div></div></div>');
                }else{
      $('.msg_container_base').append('<div class="row msg_container base_sent"> <div class="col-xs-10 col-md-10"> <div class="messages msg_sent"> <p>'+v.msg+'</p><time datetime="2009-11-13T20:00" >'+v.sender+' • 51 min</time> </div></div></div>');
                }
                
          
               
          


  });
       
          
            }

      
        

    });
        }
    }


function get_employee(){


                      $.ajax({
            type: "POST",
            url: "<?php echo base_url('employee_portal/poll/get_online_employee');?>",
            dataType: "json",
            cache : false,
            success: function(data){

                $.each(data, function(k, v) {

                   $('ul').append('<li>'+v.employee_id+'</li>');

                 });
                
           }

      
        

    });
}

get_employee();


    $( document ).ready(function() {
  $(".buttom-btn").click(function(){
    $(".top-btn").addClass('top-btn-show');
    $(".contact-form-page").addClass('show-profile');
    $(this).addClass('buttom-btn-hide')
  });

  $(".top-btn").click(function(){
    $(".buttom-btn").removeClass('buttom-btn-hide');
    $(".contact-form-page").removeClass('show-profile');
  });
})

</script>



