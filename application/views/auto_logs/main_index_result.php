
<?php
//minute times seconds
$auto_timer=$real_time_timer*60;

?>

<meta http-equiv="refresh" content="<?php echo $auto_timer;?>; URL=<?php echo base_url()?>auto_sync_logs/auto_sync_logs/auto_sync_now/<?php echo $bio_id?>">

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/iCheck/all.css">

    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    <script>

// ========================
var sec = <?php echo $auto_timer;?>;
var sec2 = sec - 2;

var numdays = Math.floor(sec / 86400);
var numhours = Math.floor((sec % 86400) / 3600);
var numminutes = Math.floor(((sec % 86400) % 3600) / 60);
var numseconds = ((sec % 86400) % 3600) % 60;


//alert("timer start : "+numdays + " days " + numhours + " hours " + numminutes + " minutes " + numseconds + " seconds")
window.setInterval(function(){
showUser("time_to"); //========VIEW DATE
}, sec * 1000); 


var count=sec;
var counter=window.setInterval("timer()",1000); 

// ========================


function timer(){
  count=count-1;
  if (count <= 0)
  {
     count = sec;
     return;
  }
  var seconds = count;
  
  var numdays = Math.floor(seconds / 86400);
  var numhours = Math.floor((seconds % 86400) / 3600);
  var numminutes = Math.floor(((seconds % 86400) % 3600) / 60);
  var numseconds = ((seconds % 86400) % 3600) % 60;

  if(count==sec2){


  }
  document.getElementById('txtData').innerHTML=numdays + " days " + numhours + " hours " + numminutes + " minutes " + numseconds + " seconds";
}
    </script>
      
<style type="text/css">
	.upload_result_table{
		background-color: #ff0000;


	}
.notes{
	width: 800px;
  display: block;
  background-color: #eee;
  margin-left: auto;
  margin-right: auto;
  color: #ff0000;
  font-weight: bold;
  font-size: 2em;
}


</style>


  </head>

<font size="+2" id="txtData"></font>


<?php
//echo "$upload_bio_warning";





?>

<?php

// if(!empty($the_second_db)){
//   foreach($the_second_db as $a){
//     echo $a->message."<br>";
//   }
// }else{

// }

?>


</html>