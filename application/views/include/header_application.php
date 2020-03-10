<script language="javascript">
  setTimeout(function timeru(){$('.alert').fadeOut(1000)}, 4000);
</script>

        
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
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      </ul>
      <ul class="nav navbar-nav navbar-right">

      <?php if ($this->session->userdata('is_applicant')) {
 $check1 = $this->general_model->check_if_allowed_to_view(3);?>
        ?>
        <li class="dropdown" style="margin-top: 15px;margin-right: 15px;">
          <img class="img-circle" src="<?php echo base_url()?>public/applicant_files/employee_picture/<?php echo $this->session->userdata('picture'); ?>" alt="" width="50px"><span>
          <button  class="btn btn-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><font class="text-success"> <?php echo $this->session->userdata('name_of_user'); ?></font></button>
          <ul class="dropdown-menu">
           <li><a href="<?php echo base_url()?>login/logout">Sign Out</a></li> 
           <li><a href="<?php echo base_url()?>app/application_form/change_password">Change Password</a></li> 
           <?php if(!empty($check1) AND $check1->allow_system_help==1)
            {?>
            <li> <a href="<?php echo base_url()?>app/system_help/system_help">System Help</a></li>
            <?php } if(!empty($check1) AND $check1->allow_quick_links==1){?>
            <li> <a href="<?php echo base_url()?>app/quick_links/quick_links">Quick Links</a></li>
           <?php } ?>
      <?php }
      else { ?>
        <li class="dropdown" style="margin-top: 20px;margin-right: 20px;">
          <span>
              <a href="<?php echo base_url()?>login" role="button" aria-haspopup="true" aria-expanded="false"><font class="text-success"> Back to Login Page </font> <i class="fa fa-sign-out"></i></a>

          </span>
            <ul class="dropdown-menu">
           <li><a href="<?php echo base_url()?>index">Change Company</a></li> 
           </ul>
        </li>
      <?php } ?>
      </ul>
    </div><!-- /.navbar-collapse -->
    </div>
    <?php if ($this->session->userdata('is_logged_in'))
    {
      require_once(APPPATH.'views/include/sidebar_applicant.php');
    }
    ;?>
</nav>