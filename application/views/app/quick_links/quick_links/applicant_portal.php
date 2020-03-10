 <?php require_once(APPPATH.'views/app/application_form/header.php');?>

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
                  </section>
                  <br>
                    <div class="col-md-12">
                    <?php echo $message;?>
                    </div>
                    <?php echo validation_errors(); ?>
                   <div class="col-md-3" style="padding-bottom: 50px;" id="add_filtering">
    <div class="box box-success">
      <div class="panel panel-danger">
        <?php $i=1; foreach($user_category as $u){
          $get_modules = $this->system_help_model->get_modules_by_usercategory($u->portal_id);
          
        ?>
        
             <div class="panel-heading">
              <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse<?php echo $i;?>"><h4 class="box-title"><i class='fa fa-user'></i> <span><?php echo $u->portal;?></span></h4></a>
              </h4>
            </div>
            <div id="collapse<?php echo $i;?>" class="panel-collapse collapse in">
                <div class="panel-body" style="overflow: auto;">
                  <ul class="nav nav-pills nav-stacked">
                      <?php if(empty($get_modules)) { echo "<li><n class='text-danger'>No Module Found.</n></li>"; } else { foreach($get_modules as $m){?>
                        <li><a style='cursor: pointer;' onclick="quick_links_action('<?php echo $u->portal_id;?>','<?php echo $m->module_id;?>');"><i class='fa fa-circle-o'></i> <span><?php echo $m->module;?></span></a></li>
                    <?php } } ?>
                  </ul>

                </div>
            </div>

        <?php  $i++; } ?>

              
      </div>             
    </div> 
  </div> 
  <div class="col-md-9" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info"  id="fetch_all_result">
       <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>File Maintenance</h4></ol>
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
