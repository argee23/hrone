<script language="javascript">
  setTimeout(function timeru(){$('.alert').fadeOut(1000)}, 4000);
</script>

<?php
  if($this->session->userdata('serttech_account')=="1"){
  }else{

?>

  <SCRIPT TYPE="text/javascript">
  var message="Sorry, right-click has been disabled";
  function clickIE() {if (document.all) {(message);return false;}}
  function clickNS(e) {if
  (document.layers||(document.getElementById&&!document.all)) {
  if (e.which==2||e.which==3) {(message);return false;}}}
  if (document.layers)
  {document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
  else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
  document.oncontextmenu=new Function("return false")
  </SCRIPT> 

<?php

  }
?>
        
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

      <a  class="navbar-brand-custom" href="#"><p class="text-primary"><br>
      <img src="<?php echo base_url()?>public/img/cropped.png" alt="Brand">
      </a>


    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
<?php 

if($this->session->userdata('session_company_logo')){
  $clogo=$this->session->userdata('session_company_logo');
  $cheight=$this->session->userdata('session_company_logo_height');
  $cwidth=$this->session->userdata('session_company_logo_width');

  if($clogo==""){
    $clogo='default_logo';
  }else{

  }
  
  if($cheight=="" OR $cwidth==""){
    $cheight='60';
    $cwidth='90';
  }else{

  }
}else{
  $clogo='default_logo';
  $cheight='60';
  $cwidth='90';
}

?>

      <img src="<?php echo base_url()?>public/company_logo/<?php echo $clogo;?>" height="<?php echo $cheight;?>px" width=<?php echo $cwidth;?>px">

          <img class="img-circle" src="<?php
            if($this->session->userdata('serttech_account')=="1"){
               echo  base_url().'public/company_logo/serttech_admin_logo_default.png';

            }elseif($this->session->userdata('recruitment_employer_is_logged_in')){
             
                  $rec_company_id=$this->general_model->logged_employer_company();
                echo  base_url().'public/company_logo/'.$rec_company_id->logo;

            }else{ 
               $picture =  $this->general_model->picture($this->session->userdata('employee_id')); 
                echo  base_url()."public/employee_files/employee_picture/".$picture; 
            ?>
             <?php
            }
?>

          ?>" alt="" width="50px" ><span>
 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">



 <font class="text-success"> <?php 
if($this->session->userdata('serttech_account')=="1"){
   echo 'Serttech Account';
}else{
   echo $this->session->userdata('name_of_user'); 
}
?>
   

 </font></a>




<ul class="dropdown-menu">
            
<?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
    $check1 = $this->general_model->check_if_allowed_to_view(4);
?>
            <li> <a href="<?php echo base_url()?>app/system_settings" class="btn btn-default btn-flat">System Settings</a></li>
            <!-- <li> <a href="<?php echo base_url()?>app/system_settings" class="btn btn-default btn-flat">System Help</a></li> -->
            <li> <a href="<?php echo base_url()?>login/logout">Sign out</a></li>
            <li><a href="<?php echo base_url()?>recruitment_employer/recruitment_employer/change_password">Change Password</a></li>
             <!-- allow to view system help -->
            <?php if(!empty($check1) AND $check1->allow_system_help==1)
            {?>
            <li> <a href="<?php echo base_url()?>app/system_help/system_help">System Help</a></li>
            <?php } if(!empty($check1) AND $check1->allow_quick_links==1){
              $rec_employer_setting = $this->general_model->rec_employer_current_setting();
             if(!empty($rec_employer_setting)){
            ?>
            <li> <a href="<?php echo base_url()?>app/quick_links/quick_links">Quick Links</a></li>
           <?php } else{ } } ?>
<?php
}else{
$check = $this->general_model->check_if_allowed_to_view(1);


?>
 <li> <a href="<?php echo base_url()?>login/logout" class="btn btn-default btn-flat">Sign out</a></li> 
 <li> <a href="<?php echo base_url()?>admin_change_password/index" class="btn btn-default btn-flat">Change Password</a>

<?php

if($this->session->userdata('serttech_account')=="1"){
?>
<li> <a href="<?php echo base_url()?>app/system_settings" class="btn btn-default btn-flat">System Settings</a></li>
<li> <a href="<?php echo base_url()?>app/system_help_link_settings/index" class="btn btn-default btn-flat">Serttech System Help Content Settings</a>

<li> <a href="<?php echo base_url()?>app/system_help/file_maintenance" class="btn btn-default btn-flat">System Help File Maintenance</a>

<li> <a href="<?php echo base_url()?>app/quick_links/file_maintenance" class="btn btn-default btn-flat">Quick Links</a></li>

<?php
}else{
?>
        


              <!-- allow to view system help -->
            <?php if(!empty($check) AND $check->allow_system_help==1)
            {?>
            <li> <a href="<?php echo base_url()?>app/system_help/system_help" class="btn btn-default btn-flat">System Help</a></li>
            <?php } ?> 

            <!-- allow to view quick links -->
            <?php if(!empty($check) AND $check->allow_quick_links==1)
            {?>
            <li> <a href="<?php echo base_url()?>app/quick_links/quick_links" class="btn btn-default btn-flat">Access Quick Links</a></li>
           <?php } ?>

             <li> <a href="<?php echo base_url()?>app/quick_links/file_maintenance" class="btn btn-default btn-flat">Quick Links Maintenance</a></li>



            <li> <a href="<?php echo base_url()?>app/system_help_link_settings/allow_settting" class="btn btn-default btn-flat">System Help & Quick Links Settings</a></li>
<?php
}

?>




           
            
 




<?php } ?>
          </ul>



          </span>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>