  <script language="javascript">
  setTimeout(function timeru(){$('.alert').fadeOut(1000)}, 4000);
</script>
<style type="text/css">

.list-notificacao{
  min-width: 400px;
  background: #ffffff;
}

.list-notificacao li{
   border-bottom : 1px #d8d8d8 solid;
   text-align    : justify;
   padding       : 5px 10px 5px 10px;
   cursor: pointer;
   font-size: 12px;
}

.list-notificacao li:hover{
background: #f1eeee;
}

.list-notificacao li:hover .exclusaoNotificacao{
display: block;
}

.list-notificacao li  p{
 color: black;
 width: 305px;
}

.list-notificacao li .exclusaoNotificacao{
    width: 25px;
    min-height: 40px;
    position: absolute;
    right: 0;
    display: none;
}

.list-notificacao .media img{ 
    width: 40px;
    height: 40px;
    float:left;
    margin-right: 10px;
}

.badgeAlertstyle {
    display: inline-block;
    min-width: 10px;
    padding: 3px 7px;
    font-size: 12px;
    font-weight: 700;
    color: #fff;
    line-height: 1;
    vertical-align: baseline;
    white-space: nowrap;
    text-align: center;
    background-color: #d9534f;
    border-radius: 10px;
    position: absolute;
    margin-top: -10px;
    margin-left: -10px
}</style>

<body class="hold-transition skin-blue fixed sidebar-mini">
  <div class="wrapper">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand-custom" href="#"><p class="text-primary"><br>
      <img  height="60" class="img img-responsive" src="<?php echo base_url()?>public/img/cropped.png" alt="Brand">
      </p>
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      </ul>
      <ul class="nav navbar-nav navbar-right">

      <?php if ($this->session->userdata('is_employee')) {
           $picture =  $this->general_model->picture($this->session->userdata('employee_id'));
           $check = $this->general_model->check_if_allowed_to_view(2);

           ?>
       
        <li class="dropdown" style="margin-top: 15px;margin-right: 15px;">
          <img class="img-circle" src="<?php echo $general_url; ?>employee_picture/<?php echo $picture; ?>" alt="" width="50px">
        
      
       
          <button class="btn btn-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><font class="text-success"> <?php echo $this->session->userdata('name_of_user'); ?></font></button>
            

          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url()?>login/logout">Sign Out</a></li> 
<!--             <li><a href="<?php echo base_url()?>employee_portal/employee_dashboard/change_password_view">Change Password</a></li>  -->
            <!-- allow to view system help -->
            <?php if(!empty($check) AND $check->allow_system_help==1)
            {?>
            <li> <a href="<?php echo base_url()?>app/system_help/system_help">System Help</a></li>
            <?php } if(!empty($check) AND $check->allow_quick_links==1){?>
            <li> <a href="<?php echo base_url()?>app/quick_links/quick_links">Quick Links</a></li>
           <?php } ?>
            <?php }
            else { 
                  redirect(base_url() . "login/index");
             } ?>
           </ul>  
      </li>
           <li class="dropdown" style="margin-top: 15px;margin-right: 15px;">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="s" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-bell alertNotificacao"></span>
                    <span id='badgeAlert' data-notification="1"></span>
                    <span class="caret"></span></a>
                    <ul class="list-notificacao dropdown-menu">
                 
                            <?php $get_notification =  $this->general_model->get_notification(); foreach($get_notification as $get_notification){ ?>
                          <li id='item_notification_2'><div class='media'><div class='media-left'><a href="<?php echo base_url('employee_portal/poll') ?>"> 
                              <img alt="64x64" class="media-object" data-src="holder.js/64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNWZhMWJmZmI3MCB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1ZmExYmZmYjcwIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxMy40Njg3NSIgeT0iMzYuNSI+NjR4NjQ8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true"> </a> </div><div class='media-body'><div class='exclusaoNotificacao'><button class='btn btn-danger btn-xs' id='2' onclick='excluirItemNotificacao(this)'>x</button></div><h4 class='media-heading'><?php echo $get_notification->notification_type ?></h4><p><?php echo $get_notification->notification_message ?></p></div></div></li>
                        <?php } ?>
                    </ul>
     
               </li>
      
      </ul>
    </div><!-- /.navbar-collapse -->
    </div>
        <?php require_once(APPPATH.'views/include/sidebar_employee.php');?>
</nav>

<script type="text/javascript">
      function unread_notification(){
               $.ajax({
            type: "POST",
            url: "<?php echo base_url('general/get_unread_notification');?>",
       
            dataType: "json",
            cache : false,
            success: function(data){
      
            if(data.count != '0'){
             $('#badgeAlert').text(data.count);
             $('#badgeAlert').addClass('badgeAlertstyle');

             
            }else{
             $('#badgeAlert').text('');
             $('#badgeAlert').removeClass('badgeAlertstyle'); 
            }
            

      
        

           }

      })
    }

    unread_notification();

      var socket = io.connect( 'http://'+window.location.hostname+':3000' );
        socket.on( 'new_count_message', function( data ) {
          var  emp_id = '<?php echo $this->session->userdata('employee_id'); ?>';
        if(data.emp_id == emp_id){
          $('#badgeAlert').text(data.new_count_message);
           $('#badgeAlert').addClass('badgeAlertstyle');
           $('#badgeAlert').attr('data-notification','1');
           $('.list-notificacao').append("<li id='item_notification_2'><div class='media'><div class='media-left'><a href='http://localhost/hrone/employee_portal/poll/'><img alt='64x64' class='media-object' data-src='holder.js/64x64' src='data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNWZhMWJmZmI3MCB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1ZmExYmZmYjcwIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxMy40Njg3NSIgeT0iMzYuNSI+NjR4NjQ8L3RleHQ+PC9nPjwvZz48L3N2Zz4='' data-holder-rendered='true'> </a></div><div class='media-body'><div class='exclusaoNotificacao'><button class='btn btn-danger btn-xs' id='2' onclick='excluirItemNotificacao(this)'>x</button></div><h4 class='media-heading'>"+data.notification_type+"</h4><p>"+data.notification+"</p></div></div></li>");


        }
  
        

    
 
      

  });
     $('#s').click(function(){

            if($('#badgeAlert').attr('data-notification') == '1'){

         
            $.ajax({
              type: "POST",
              url: "<?php echo base_url('general/seen_notification');?>",
              dataType: "json",
              cache : true,
              success: function(data){
                  
                  if(data.success == 'true'){
                  $('#badgeAlert').text('');
                  $('#badgeAlert').removeClass('badgeAlertstyle');
                  $('#badgeAlert').attr('data-notification','0');
                  }

             }

      })

           
             }
        });


function timeDifference(current, previous) {
    
    var msPerMinute = 60 * 1000;
    var msPerHour = msPerMinute * 60;
    var msPerDay = msPerHour * 24;
    var msPerMonth = msPerDay * 30;
    var msPerYear = msPerDay * 365;
    
    var elapsed = current - previous;
    
    if (elapsed < msPerMinute) {
         return Math.round(elapsed/1000) + ' seconds ago';   
    }
    
    else if (elapsed < msPerHour) {
         return Math.round(elapsed/msPerMinute) + ' minutes ago';   
    }
    
    else if (elapsed < msPerDay ) {
         return Math.round(elapsed/msPerHour ) + ' hours ago';   
    }

    else if (elapsed < msPerMonth) {
         return 'approximately ' + Math.round(elapsed/msPerDay) + ' days ago';   
    }
    
    else if (elapsed < msPerYear) {
         return 'approximately ' + Math.round(elapsed/msPerMonth) + ' months ago';   
    }
    
    else {
         return 'approximately ' + Math.round(elapsed/msPerYear ) + ' years ago';   
    }
}


// TESTS
// var wertwert= a.getFullYear()+'-'+(a.getMonth()+parseInt(1))+'-'+a.getDate()+ ' ' +a.getHours()+':'+a.getMinutes()+':'+a.getSeconds();
var current= new Date(2011, 4, 24, 12, 30, 30, 30);
// alert(timeDifference(current, new Date(2011, 04, 24, 12, 30, 00, 00)));
// alert(timeDifference(current, new Date(2011, 04, 24, 12, 00, 00, 00)));
// alert(timeDifference(current, new Date(2011, 04, 24, 11, 00, 00, 00)));
// alert(timeDifference(current, new Date(2011, 04, 23, 12, 00, 00, 00)));
// alert(timeDifference(current, new Date(2011, 03, 24, 12, 00, 00, 00)));
// alert(timeDifference(current, new Date(2010, 03, 24, 12, 00, 00, 00)));


</script>
