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
