<div class="row">
        <div class="col-md-8 col-md-offset-2">
          <hr>
      </div>
    </div>
    <table id="jobAnalytics" class="table table-bordered table-striped">
            <thead>
              <tr>
                    <th>Company Name</th>
                    <th>Position</th>
                    <th>Slot</th>
                    <th>Current Available</th>
                        <?php
                      if(!empty($app_active_optionList)){
                        foreach($app_active_optionList as $stat_opts){
            ?>
          <th><?php echo $stat_opts->status_title; ?></th>
            <?php
                    } }
                      else{
                        }
            ?>
                </tr>
            </thead>
            <tbody>
                      <?php foreach($alljobsList as $jobs){?>
            <tr>
              <td><?php echo $jobs->company_name; ?></td>
              <td><b><?php echo $jobs->job_title; ?></b> </td>
            <td><?php echo $jobs->job_vacancy; ?></td>
            <td><?php

              $hired_app=$this->general_model->hired_applicantList($jobs->company_id,$jobs->job_id);
              $array_items = count($hired_app);
              echo $jobs->job_vacancy-$array_items;

                ?></td>
            <?php

                      if(!empty($app_active_optionList)){
                        foreach($app_active_optionList as $stat_opts){
            ?>
          <td>

            <?php 

              $app_stat=$this->general_model->appStatus_List($jobs->company_id,$jobs->job_id,$stat_opts->app_stat_id);
              $array_items2 = count($app_stat);

              // if($array_items2=="0"){
              //    $change_bg="";
              // }
              // else{
              //    $change_bg='style="background-color:#ff0000;"';
              // }
              echo $array_items2.'</br>';
              $no = 1;
              foreach($app_stat as $app){
                echo '<div>('.$no.') '.$app->fullname.'</div>';
                $no++;
              }


              echo '</div>';
            ?>
              
          </td>
            <?php
                      } }else{
                      }
            ?>
            </tr>
                <?php } ?>  
        </tbody>
    </table>