
 <?php if(empty($postt)){ ?>

   <div class="job">
                          <h4 class="text-info"><center><br><br><div class="job_title ellipses">Post(s) not available.</div></center></h4>
                        
                          <br>
                      </div>

 <?php }else{?>
 <table id="searching_data">
    <thead>
        <tr>
          <th style="width:100%;"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($postt as $p) {?>
      <tr>
        <td>
            
            <div class="job">
                          <form name="view_job" action="<?php echo base_url()?>app/application_form/signup" method="post">
                          <input type="hidden" name="id" id="id" value="<?php echo $p->id;?>">
                          <input type="hidden" name="company_id" id="company_id" value="<?php echo $p->company_id; ?>">
                         <h4 class="text-info">
                         
                           <img src="<?php echo base_url()?>/public/company_logo/<?php echo $p->logo; ?>" class="pull-right media-object" style="width:50px">
                          <div class="job_title ellipses"><button type="submit" class="btn btn-default"><?php echo $p->job_title; ?></button></div>
                           </h4>
                         
                            <p><i class="fa fa-building"></i> <?php echo $p->company_name; ?></p>
                            <p><span class="fa fa-map-marker"></span>
                            <?php echo $location = $this->login_model->get_job_location($p->job_id); ?> 
                            </p>
                            <p><span class="fa fa-fa fa-usd"></span>
                             <?php echo number_format($p->salary,2); ?>
                            </p>

                          <div class="job_content ellipses">

                            <?php 

                              $count_string = strlen($p->job_description);

                              if($count_string > 280  )
                              {
                                 echo nl2br(substr($p->job_description, 0, 280))." ...";
                              }
                              else
                              {
                                 echo $p->job_description;
                              }
                            ?>
                            <br>
                             <a style="color:gray;font-size: 11px;text-decoration: none;" class='pull-left'><?php echo $p->cValue;?></a>
                            <a style="color:gray;font-size: 11px;text-decoration: none;" class='pull-right'>
                              <i>
                               <?php 
                                  $month=substr($p->hiring_start, 5,2);
                                  $day=substr($p->hiring_start, 8,2);
                                  $year=substr($p->hiring_start, 0,4);

                                  $emonth=substr($p->hiring_end, 5,2);
                                  $eday=substr($p->hiring_end, 8,2);
                                  $eyear=substr($p->hiring_end, 0,4);
                                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year." to ".date("F", mktime(0, 0, 0, $emonth, 10))." ". $eday.", ". $eyear;
                               ?>
                              </i>
                            </a>

                            </div>
                            </form>
                          </div>
                          <br>
                      </div>
              </div>
        </td>
      </tr>
    <?php } ?>
    </tbody>
</table>

<?php } ?>