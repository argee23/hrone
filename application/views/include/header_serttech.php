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
      <img src="<?php echo base_url()?>public/img/cropped.png" alt="Brand">
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <img class="img-circle" src="<?php echo base_url()?>public/img/<?php echo $serttech_account->picture; ?>" alt="" width="50px"><span>
 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><font class="text-success"> <?php echo $serttech_account->myname; ?></font></a>
          <ul class="dropdown-menu">
           <!-- <li><a href="<?php //echo base_url()?>login/logout">Sign Out</a></li>  -->
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li>
              <div class="pull-right">
                  <a href="<?php echo base_url()?>serttech/serttech_login/logout" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
          </span>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>