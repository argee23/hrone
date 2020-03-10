<style>
	body{
		background-image: url("<?php echo base_url()?>public/img/fromsirjeic.jpg");
		background-size:cover;
		background-position:center;
	}

	.container-2{
		padding-left:30px;
		padding-right:30px;
	}

	.login-text{
		font-weight:900;
		color: #171717;
		font-size: 32px;
	}
	input {
	  border: 0;
	  outline: 0;
	  background: transparent;
	  border-bottom: 1px solid black;
	}
	.input{

	  width: 100%: 
	}
	.btn-login{
		font-size: 10px;
	}
	.btn-1{

		background-image: linear-gradient(to right, #07a43e,#184572,#f2b20c,#e2332f);
		color: #ffffff;
		width: 80%;
		height: 40px;
		border: 0;
		border-radius: 8px;
	}
</style>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HRWeb.ph</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
  
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<!--     <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet"> -->
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">

<div class="container-2">
	<div class="row">
		<div class="col-sm-3 bg-info" style="height:720px">
			<img src="<?php echo base_url()?>public/img/cropped.png" width="200px" alt="">
			<br><br><br>
			<div class="text-center login-text">Log in</div>
			<p class="text-center help-block">Welcome to HRweb.ph!<br>Enter your access credentials to enter the system.</p>
			<br>
			<br>
	  <?php echo $message;?>
      <?php echo validation_errors(); ?> 

<form name="loginForm" action="<?php echo base_url()?>login/validate_login" method="post" >
<input type="hidden" name="nbd" value="<?php echo $nbd;?>">		
		<center>
		<input class="input" type="text" name="username" id="username" placeholder="Username"></center>
		<br>
		<br>
		<center><input class="input" type="password" name="password" id="password" placeholder="Password"></center>
		<br>
		<br>
		<center>
<?php
$des=3;
require_once(APPPATH.'views/trial_expiration_prompt.php');
?>
		<button type="submit" class="bt-login btn-1" <?php echo $disble_submit_button;?> ><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Continue</button></center>
</form>
			<center><img class="img-responsive" src="<?php echo base_url()?>public/company_logo/foodpanda-3.png" alt=""></center>
		</div>

		<div class="col-sm-9" style="height: 100%">
			<div class="container">
				<h2>Find Job Opportunities | <span class="text-info">
  <a class="joblink" href="<?php echo base_url()?>login/login">Apply Now! </a>	
				</span></h2>
				<div class="table-responsive">

				<table class="table">
<?php
if(!empty($posts)) { 
	foreach($posts as $job) { 
?>
                  <tr>
                    <td>
                      <div class="job">
                          <form name="view_job" action="<?php echo base_url()?>app/application_form/signup" method="post">
                          <input type="hidden" name="id" id="id" value="<?php echo $job['id']; ?>">
                          <input type="hidden" name="company_id" id="company_id" value="<?php echo $job['company_id']; ?>">

                          <h4 class="text-info">
                           <img src="<?php echo base_url()?>/public/company_logo/<?php echo $job['logo']; ?>" class="pull-right media-object" style="width:50px">
                          <div class="job_title ellipses"><button type="submit" class="btn btn-default"><strong><?php echo $job['job_title']; ?></strong></button></div>
                           </h4>
                         
                            <p><i class="fa fa-building"></i> <?php echo $job['company_name']; ?></p>

                            <p><span class="fa fa-map-marker"></span>
                            <?php echo $location = $this->login_model->get_job_location($job['job_id']); ?> 
                            </p>
                            <p><span class="fa fa-fa fa-usd"></span>
                             <?php echo number_format($job['salary'],2); ?>
                            </p>
  
                           <div class="job_content ellipses">

                            <?php 

                              $count_string = strlen($job['job_description']);

                              if($count_string > 280  )
                              {
                                 echo nl2br(substr($job['job_description'], 0, 280))." ...";
                              }
                              else
                              {
                                 echo $job['job_description'];
                              }
                            ?>
                            <br>
                            <a style="color:gray;font-size: 11px;text-decoration: none;" class='pull-left'><?php echo $job['cValue'];?></a>
                            <a style="color:gray;font-size: 11px;text-decoration: none;" class='pull-right'>
                            <i>
                               <?php 
                                  $month=substr($job['hiring_start'], 5,2);
                                  $day=substr($job['hiring_start'], 8,2);
                                  $year=substr($job['hiring_start'], 0,4);

                                
                                  $emonth=substr($job['hiring_end'], 5,2);
                                  $eday=substr($job['hiring_end'], 8,2);
                                  $eyear=substr($job['hiring_end'], 0,4);
                                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year." to ".date("F", mktime(0, 0, 0, $emonth, 10))." ". $eday.", ". $eyear;

                               ?>

                              </i>
                            </a>
                            </div>
                            </form>
                          </div>
                          <br>

                      </div>

                    </td>
                  </tr>
<!-- echo '
<tr>
						<td>
							<button class="btn btn-default"><strong>'.$job['job_title'].'</strong></button><br><br>
							<p><i class="fa fa-building-o" aria-hidden="true"></i> <strong>'.$job['company_name'].'</strong></p>
							<p><i class="fa fa-map-marker" aria-hidden="true"></i> ';
							echo $location = $this->login_model->get_job_location($job['job_id']);
							echo '</p>
							<p><i class="fa fa-usd" aria-hidden="true"></i> '.number_format($job['salary'],2).'</p>

';

                              $count_string = strlen($job['job_description']);
                              if($count_string > 280  )
                              {
                                 echo nl2br(substr($job['job_description'], 0, 280))." ...";
                              }
                              else
                              {
                                 echo nl2br($job['job_description']);
                              }
echo '
							<div class="bg-danger"><small>Accounting/Finance <span class="pull-right">
';
                                  $month=substr($job['hiring_start'], 5,2);
                                  $day=substr($job['hiring_start'], 8,2);
                                  $year=substr($job['hiring_start'], 0,4);

                                
                                  $emonth=substr($job['hiring_end'], 5,2);
                                  $eday=substr($job['hiring_end'], 8,2);
                                  $eyear=substr($job['hiring_end'], 0,4);
                                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year." to ".date("F", mktime(0, 0, 0, $emonth, 10))." ". $eday.", ". $eyear;
echo '

							</span></small></div>
						</td>
					</tr> 
';
 -->

<?php
	}
}else{

}
?>


					
				</table>
				</div>
			</div>
		</div>
	</div>
</div>
    
<script src="<?php echo base_url()?>public/login/js/jquery-1.11.3.js"></script>
</head>
<body>
	
</body>
<script src="<?php echo base_url()?>public/login/js/bootstrap.min.js"></script>
</html>