<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>LIST OF TRAINING AND SEMINAR REQUESTS
              </h4></ol>
              <div style="height: 505px";>
                
                <?php if(empty($details)) {?>

                     
                       <center> <h4 class="text-success" style="margin-top: 70px;"><i class="icon fa fa-warning"></i><b>NO TRAINING AND SEMINAR FOUND</b></h4></center>
                    

                <?php } else{ foreach($details as $d){
                  $get_dates = $this->training_request_model->get_incoming_dates($d->training_seminar_id);
                ?>
               
                 <div class="col-md-12">
                    <div class="panel panel-default">
                      <div class="panel-heading"><n class="text-success"><strong><?php echo $d->training_title;?></strong></n>  
                       <span class="blink text-danger pull-right">
                             <a  style="cursor: pointer;color: red;" onclick="update_reponse('<?php echo $d->training_seminar_id;?>','<?php echo $val;?>');" class="pull-right"  >Click to <?php if($val==1){ echo "Cancel the approved"; } else{ echo "Join the rejected"; } ?> training Request.</a>
                      </span>
                      </div>
                      <div class="panel-body">

                        <span class="dl-horizontal col-sm-6">
                            <dt>Training Type</dt>
                            <dd><?php echo $d->training_type;?></dd>

                            <dt>Sub Type</dt>
                            <dd><?php echo $d->sub_type;?></dd>

                            <dt>Conducted By Type</dt>
                            <dd><?php echo $d->conducted_by_type;?></dd>

                            <dt>Conducted By</dt>
                            <dd><?php echo $d->conducted_by;?></dd>

                            <dt>Purpose / Objective</dt>
                            <dd><?php echo $d->purpose;?></dd>


                            <dt>Address Conducted</dt>
                            <dd><?php echo $d->training_address;?></dd>
                            
                        </span>

                        <span class="dl-horizontal col-sm-6">


                            <dt>Date From</dt>
                            <dd>
                                <?php 
                                  $month=substr($d->datefrom, 5,2);
                                  $day=substr($d->datefrom, 8,2);
                                  $year=substr($d->datefrom, 0,4);

                                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                ?>

                            </dd>

                            <dt>Date To</dt>
                            <dd>
                                <?php 
                                  $month=substr($d->dateto, 5,2);
                                  $day=substr($d->dateto, 8,2);
                                  $year=substr($d->dateto, 0,4);

                                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                ?>
                            </dd>

                            <dt>Fee Type</dt>
                            <dd><?php echo $d->fee_type;?></dd>

                            <dt>Attachment</dt>
                            <dd><?php echo substr($d->file_name,0,32);?>...</dd>

                            <dt>Fee Amount</dt>
                            <dd><?php echo $d->fee_amount;?></dd>

                            
                        </span>

                        <div class="col-md-12" style="padding-top: 10px;">
                          <div class="col-md-1"></div>
                          <div class="col-md-11">
                            <div class="datagrid">
                              <table>
                                <thead>
                                </thead>
                                <tbody>
                                  <tr class="alt">
                                    <td><b>Date</b></td>
                                    <td><b>Time</b></td>
                                    <td><b>Hours</b></td>
                                  </tr>
                                  <?php foreach($get_dates as $g)
                                  {?>
                                    <tr>
                                      <td>
                                           <?php 
                                            $month=substr($g->date, 5,2);
                                            $day=substr($g->date, 8,2);
                                            $year=substr($g->date, 0,4);

                                            echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                            ?>
                                      </td>
                                      <td><?php echo $g->time_from." to ".$g->time_to;?></td>
                                      <td><?php echo $g->hours;?></td>
                                    </tr>
                                  <?php } ?>
                                   <tr class="alt">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                <?php } }?>
              </div>