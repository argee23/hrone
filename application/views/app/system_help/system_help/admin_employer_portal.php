<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Sert Technology Inc</title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
      <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
      <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
      <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
      <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
      <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
      <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">

      <script>
        window.onload = function() { <?php echo $onload ?>; };
      </script>

                     
      <!-- header logo: style can be found in header.less -->
      <?php require_once(APPPATH.'views/include/header.php');?>
      <!-- SIDEBAR -->

      <?php require_once(APPPATH.'views/include/header.php');?>
        <?php if($this->session->userdata('is_logged_in')){
        $current_account_logged_in="admin or employee account";
        }else{
        $current_account_logged_in="employer_account";
        }    
        if($current_account_logged_in!="employer_account"){
           require_once(APPPATH.'views/include/sidebar.php');
          }else{
         require_once(APPPATH.'views/include/sidebar_recruitment_employer.php');
          }
        ?>

    
      
    </head>

    <body>
        <!-- Start Content Wrapper. Contains page content -->
        <div class="content-wrapper2">
        <!-- Start Content Header (Page header) -->
        <section class="content-header">
          <h1>
              System Help
              <small>File Maintenance</small>
          </h1>
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
              <li><a href="">System Help File Maintenance</a></li>
          </ol>
        </section><br>
        <div class="col-md-12">
          <?php echo $message;?>
        </div>
        <?php echo validation_errors(); ?>
                  <div class="col-md-3" style="padding-bottom: 50px;" id="add_filtering">
                    <div class="box box-success">
                      <div class="panel panel-warning">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                              <a data-toggle="collapse" href="#collapse"><h5 class="box-title"><i class='fa fa-search'></i> <span>Searching (word by word searching) </span></h5></a>
                          </h4>
                        </div>
                        <div>
                        <div class="panel-body" style="overflow: auto;">
                            <div class="col-md-12" style="margin-top: 10px;">
                               <input type="text" class="form-control" placeholder="Enter Search Criteria" name="search" id="search" required>
                               <input type="hidden" id="search_final">
                            </div>
                            <div class="col-md-12" style="margin-top: 10px;">
                                <button class="col-md-12 btn btn-success btn-sm" onclick="search_now('word_by_word');"><i class="fa fa-search"></i>SEARCH NOW </button>
                            </div>
                            </div>
                          </div>

                           <div class="panel-heading">
                          <h4 class="panel-title">
                              <a data-toggle="collapse" href="#collapse"><h5 class="box-title"><i class='fa fa-search'></i> <span>Search (search value searching)</span></h5></a>
                          </h4>
                        </div>
                        <div>
                        <div class="panel-body" style="overflow: auto;">
                            <div class="col-md-12" style="margin-top: 10px;">
                               <input type="text" class="form-control" placeholder="Enter Search Criteria" name="searchh" id="searchh" required>
                               <input type="hidden" id="searchh_final">
                            </div>
                            <div class="col-md-12" style="margin-top: 10px;">
                                <button class="col-md-12 btn btn-success btn-sm" onclick="search_now('word');"><i class="fa fa-search"></i>SEARCH NOW</button>
                            </div>
                            </div>
                          </div>


                          <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#collapse"><h5 class="box-title"><i class='fa fa-step-forward'></i> <span>Filtering</span></h5></a>
                            </h4>
                          </div>
                        <div>
                        <div class="panel-body" style="overflow: auto;">
                         
                            <div class="col-md-12">
                             <select class="form-control" name="portalindex" id="portalindex" required onchange="get_module_list(this.value,'moduleindex');">
                                <?php if(empty($portal_list))
                                {
                                  echo "<option value=''>No portal found.</option>";
                                }
                                else
                                {?>
                                    <option value="">Select Portal</option>
                                    <?php if($role=='admin'){?><option value="All">All</option><?php } ?>
                                    <?php foreach($portal_list as $p){?>
                                      <option value="<?php echo $p->portal_id;?>"><?php echo $p->portal;?></option>
                                <?php }  }  ?>
                               
                             </select>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                             <select class="form-control" name="moduleindex" id="moduleindex" required onchange="get_topic_list(this.value,'topic','index');">
                                <option value="">Select Module</option>
                             </select>
                            </div>


                            <div class="col-md-12" style="margin-top: 10px;">
                             <select class="form-control" name="topic" id="topic" required onchange="get_subtopic_list(this.value,'subtopic','index');">
                                <option value="">Select Topic</option>
                                <?php foreach($topic as $t){?>
                                  <option value="<?php echo $t->topic_id;?>"><?php echo $t->topic;?></option>
                                <?php } ?>
                             </select>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                              <select class="form-control" name="subtopic" id="subtopic" required>
                                  <option value="">Select Sub Topic</option> 
                              </select>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                                <button class="col-md-12 btn btn-success btn-sm" onclick="filter_results('portalindex','moduleindex','topic','subtopic','fetch_all_result');"><i class="fa fa-arrow-right"></i>FILTER NOW</button>
                            </div>

                              </div>
                          </div>

                        </div>
                    </div>
                  </div>             
          </div> 
        </div> 
        <div class="col-md-9" style="padding-bottom: 50px;">
          <div class="box box-success">
            <div class="panel panel-info"  id="fetch_all_result">
             <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>System Help</h4></ol>
                  <div class="col-md-12"><br>
                      
                  </div>  
                  <div class="btn-group-vertical btn-block"> </div>   
            </div>             
          </div> 
        </div> 
        
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog">
            <div class="modal-content modal-lg">
            </div>
          </div>
        </div>

                    <!--Start footer-->
        <footer class="footer">
        <div class="container-fluid"><br>
        <strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.
        <span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
        </div>
        </footer>
        <!--END footer-->
        <!--//==========Start Js/bootstrap==============================//-->
        <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
        <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
        <script>vex.defaultOptions.className = 'vex-theme-os'</script>
        <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
        <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url()?>public/app.min.js"></script>
        <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
        <script src="<?php echo base_url()?>public/angular.min.js"></script>
        <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
        <!--//==========End Js/bootstrap==============================//-->
  </body>
</html>