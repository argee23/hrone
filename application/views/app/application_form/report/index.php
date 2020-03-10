
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">

    <link href="<?php echo base_url()?>public/bootstrap/css/tables.css" rel="stylesheet">  
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


<br>
<title>Job Applications</title>
<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>
<body>
<!-- STATUS FILTERS -->
  <div class="col-md-12">
  </div>   
    <div class="col-md-3" style="padding-top: 30px;">

     <div class="box box-solid">
       
    <?php foreach($company as $c){?>      

        <div class="panel panel-danger">
            <div class="panel-heading">
              <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse<?php echo $c->company_id;?>"><h4 class="box-title"> <span><?php echo $c->company_name;?></span></h4></a>
              </h4>
            </div>
            <div id="collapse<?php echo $c->company_id;?>" class="panel-collapse collapse in">
                <div class="panel-body" style="height:auto;overflow: auto;">

                         <ul class="nav nav-pills nav-stacked">
                           <?php
                                $get_application = $this->applicant_reports_model->get_application($c->company_id);
                                foreach($get_application as $ga){?>

                                     <li><a style='cursor: pointer;' onclick="view_all_details('<?php echo $ga->job_id;?>','<?php echo $ga->id;?>','<?php echo $c->company_id;?>');"><i class='fa fa-circle-o'></i> <span>  <?php echo $ga->job_title."<br><n class='text-danger' style='margin-left:20px;'>(date applied: ".$ga->date_applied.")</n>";?> </span></a></li>

                           <?php } ?>
                        </ul>

                </div>
            </div>
        </div>
    
    <?php } ?>
    </div>

    </div> 

    <div class="col-md-9" style="padding-top: 30px;">
        <div class="box box-default">
            <div class="panel panel-info">
                <div class="col-md-12" id="fetch_all_result_action" style="height:auto;">
                </div>  
                <div class="btn-group-vertical btn-block"> </div> 
            </div>
        </div> 
   </div> 
        
  
   

    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">

    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    
    <script type="text/javascript">
      function view_all_details(job_id,app_id,company_id)
      {
         if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
              document.getElementById("fetch_all_result_action").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/applicant_reports/view_all_details/"+job_id+"/"+app_id+"/"+company_id,false);
        xmlhttp2.send();
      }
    </script>